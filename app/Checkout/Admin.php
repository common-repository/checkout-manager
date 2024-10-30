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
 * @subpackage Admin
 * @author Al Imran Akash <alimranakash.bd@gmail.com>
 */
class Admin {

    /**
     * Constructor function
     */
    public function __construct() {
        $this->hooks();
    }

    private function hooks() {

        $display_position   = get_option( 'imcm-display-position' );
        $billing_hooks      = isset( $display_position['order_billing_hooks'] ) ? $display_position['order_billing_hooks'] : '';
        $shipping_hooks     = isset( $display_position['order_shipping_hooks'] ) ? $display_position['order_shipping_hooks'] : '';

        $display_position   = get_option( 'display_position' );
        $billing_hooks      = isset( $display_position['order_billing_hooks'] ) ? $display_position['order_billing_hooks'] : '';
        $shipping_hooks     = isset( $display_position['order_shipping_hooks'] ) ? $display_position['order_shipping_hooks'] : '';

        add_action( 'admin_menu', [ $this, 'submenu' ] );
        add_action( $billing_hooks, [ $this, 'custom_billing_fields' ] );
        add_action( $shipping_hooks, [ $this, 'custom_shipping_fields' ] );
    }

    public function submenu() {
        add_submenu_page(
            'checkout-manager',
            __( 'Checkout Fields', 'checkout-manager' ),
            __( 'Checkout Fields', 'checkout-manager' ),
            'manage_options',
            'checkout-fields',
            [ $this, 'checkout_fields_callback' ] 
        );
    }

    public function checkout_fields_callback() {
        do_action( 'imcm_checkout_fields' );
    }

    public function custom_billing_fields( $order ) {
        do_action( 'imcm_custom_billing_fields', $order );
    }

    public function custom_shipping_fields( $order ) {
        do_action( 'imcm_custom_shipping_fields', $order );
    }
}