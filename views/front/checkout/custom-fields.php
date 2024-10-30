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
            $additional_fields[ $name ] = isset( $field['in_thakyou'] ) ? sanitize_text_field( $field['in_thakyou'] ) : '';
        }
    }
}

$custom_fields = imcm_custom_checkout_fields( $order );

if ( empty( $custom_fields['billing'] ) && empty( $custom_fields['shipping'] ) ) return;

wp_enqueue_style( 'front-style' );

echo '<section class="imcm-additional-fields-details woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">';
echo '<h2 class="woocommerce-column__title">'. __( 'Custom Fields', 'checkout-manager' ) .'</h2>';

$count = 1;
foreach ( $custom_fields as $key => $custom_field ) {
    if ( !empty( $custom_field ) ) {
        echo "<div class='woocommerce-column woocommerce-column--". esc_attr( $count ) ." woocommerce-column--". esc_attr( $key ) ."-address col-". esc_attr( $count ) ."'>";
        echo '<h4 class="imcm-custom-fields-title woocommerce-">'. esc_html( ucwords( $key ) ) .'</h4>';
            echo '<address>';
                foreach ( $custom_field as $key => $single_fields ) {
                    if ( array_key_exists( $key, $additional_fields ) && 'on' == $additional_fields[ $key ] ) {
                        foreach ( $single_fields as $key => $value ) {
                            echo "<p><strong>". esc_attr( $key ) .":</strong> ". esc_html( $value ) ."</p>";
                        }
                    }
                    
                }
            echo '</address>';
        echo '</div>';
        $count++;
    }   
}
echo '</section>';