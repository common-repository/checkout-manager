<?php 
extract( $args );

if ( is_int( $order ) || is_numeric( $order ) ) {
    $order = wc_get_order( $order );
}

$_woocm_fields = get_option( 'imcm-checkout-fields' ) ? : '';

if ( isset( $_woocm_fields['woocm_fields'] ) ) {
    $types = $_woocm_fields['woocm_fields'];
}
else {
    $types = imcm_wc_fields();
}

$additional_fields = [];
foreach ( $types as $type => $fields ) {
    foreach ( $fields as $name => $field ) {
        if ( ! imcm_is_default_field( $name ) ) {
            $additional_fields[ $name ] = isset( $field['in_order'] ) ? sanitize_text_field( $field['in_order'] ) : '';
        }
    }
}

$custom_fields 	= imcm_custom_checkout_fields( $order );

if ( empty( $custom_fields['billing'] ) ) return;

$billing_fields	= $custom_fields['billing'];
echo '<h3>'. __( 'Custom Billing Fields', 'checkout-manager' ) .'</h3>';
echo '<div class="address">';

foreach ( $billing_fields as $key => $single_fields ) {
	if ( array_key_exists( $key, $additional_fields ) && 'on' == $additional_fields[ $key ] ) {
        foreach ( $single_fields as $key => $value ) {
            echo "<p><strong>". esc_attr( $key ) .":</strong> ". esc_html( $value ) ."</p>";
        }
    }
}

echo '</div>';