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
 * @subpackage Common
 * @author Al Imran Akash <alimranakash.bd@gmail.com>
 */
class Common {

    /**
     * Constructor function
     */
    public function __construct() {
        $this->hooks();
    }

    private function hooks() {
        $display_position   = get_option( 'imcm-display-position' );

        $email_hook         = isset( $display_position['email_hooks'] ) ? $display_position['email_hooks'] : '';

        add_action( $email_hook, [ $this, 'custom_email_fields' ] );
    }

    public function custom_email_fields( $order ) {
        do_action( 'imcm_custom_email_fields', $order );
    }
}