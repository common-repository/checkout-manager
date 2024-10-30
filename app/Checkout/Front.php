<?php
/**
 * All admin facing functions
 */
namespace WPPlugines\Checkout_Manager\App\Checkout;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Front
 * @author Al Imran Akash <alimranakash.bd@gmail.com>
 */
class Front {

    /**
     * Constructor function
     */
    public function __construct() {
        $this->hooks();
    }

    private function hooks() {
        $display_position   = get_option( 'imcm-display-position' );
        $hook_name          = isset( $display_position['thankyou_hooks'] ) ? $display_position['thankyou_hooks'] : '';

        add_filter( 'woocommerce_checkout_fields', [ $this, 'checkout_fields' ] );
        add_action( $hook_name, [ $this, 'render_custom_fields' ], 20 );
    }

    public function checkout_fields( $wc_fields ) {
        wp_enqueue_style( 'front-style' );

        $_woocm_fields = get_option( 'imcm-checkout-fields' ) ? : [];

        if ( isset( $_woocm_fields['woocm_fields'] ) ) {
            $types = $_woocm_fields['woocm_fields'];
        }

        if ( empty( $types ) ) return $wc_fields;

        $_fields = [];

        foreach ( $types as $type => $fields ) {
            $priority = 10;
            foreach ( $fields as $name => $field ) {
            // imcm_pri($field);
                if ( isset( $field['enabled'] ) ) {
                    
                    if( isset(  $wc_fields[ $type ][ $name ]['type'] ) ) {
                        $_fields[ $type ][ $name ]['type']      = $wc_fields[ $type ][ $name ]['type'];
                    }

                    if ( ! imcm_is_default_field( $name ) ) {
                        $_fields[ $type ][ $name ]['type']      = $field['type'];
                    }

                    if ( isset( $field['type'] ) && in_array( $field['type'], [ 'select', 'radio' ] ) ) {

                        $_options = explode( PHP_EOL, $field['options'] );

                        $options = [];
                        foreach ( $_options as $_option ) {
                            $options[ $_option ] = $_option;
                        }

                        $_fields[ $type ][ $name ]['options']   = $options;
                    }

                    $_fields[ $type ][ $name ]['label']         = $field['label'];
                    $_fields[ $type ][ $name ]['required']      = isset( $field['required'] );

                    $_fields[ $type ][ $name ]['priority']      = 0;
                    $_fields[ $type ][ $name ]['validate']      = '';
                    $_fields[ $type ][ $name ]['placeholder']   = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
                    $_fields[ $type ][ $name ]['class'][]       = $field['class'];
                }
                $priority++;
            }
        }

        return $_fields;
    }

    public function render_custom_fields( $order ) {
        do_action( 'imcm_custom_fields', $order );
    }
}