<?php
/**
 * All admin facing functions
 */
namespace WPPlugines\Checkout_Manager;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Template
 * @author Al Imran Akash <alimranakash.bd@gmail.com>
 */
class Template {

	/**
	 * Constructor function
	 */
	public function __construct() {
        $this->hooks();
	}

    private function hooks() {
        add_action( 'imcm_settings', [ $this, 'settings' ] );
        add_action( 'imcm_checkout_fields', [ $this, 'checkout_fields' ] );
        add_action( 'imcm_custom_billing_fields', [ $this, 'billing_fields' ] );
        add_action( 'imcm_custom_shipping_fields', [ $this, 'shipping_fields' ] );
        add_action( 'imcm_custom_fields', [ $this, 'custom_fields' ] );
        add_action( 'imcm_custom_email_fields', [ $this, 'email_fields' ] );
    }

    public function settings() {
        echo Helper::get_template( 'settings', 'views/admin' );
    }

    public function checkout_fields() {
        echo Helper::get_template( 'checkout-fields', 'views/admin/checkout' );
    }

    public function billing_fields( $order ) {
        echo Helper::get_template( 'billing-fields', 'views/admin/checkout', [ 'order' => $order ] );
    }

    public function shipping_fields( $order ) {
        echo Helper::get_template( 'shipping-fields', 'views/admin/checkout', [ 'order' => $order ] );
    }

    public function custom_fields( $order ) {
        echo Helper::get_template( 'custom-fields', 'views/front/checkout', [ 'order' => $order ] );
    }

    public function email_fields( $order ) {
        echo Helper::get_template( 'email-fields', 'views/email', [ 'order' => $order ] );
    }
}