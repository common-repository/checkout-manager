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
 * @subpackage Ajax
 * @author Al Imran Akash <alimranakash.bd@gmail.com>
 */
class Ajax {

	/**
	 * Constructor function
	 */
	public function __construct() {
        $this->hooks();
	}

    private function hooks() {
        add_action( 'wp_ajax_imcm-setting', [ $this, 'imcm_setting' ] );
    }

    public function imcm_setting() {
        $response = [];

        if( !wp_verify_nonce( $_POST['_wpnonce'], 'checkout-manager' ) ) {
            $response['status']     = 0;
            $response['message']    = __( 'Unauthorized!', 'checkout-manager' );
            wp_send_json( $response );
        }

        $option_name    = isset( $_POST['option_name'] ) ? sanitize_text_field( $_POST['option_name'] ) : '';
        $page_load      = isset( $_POST['page_load'] ) ? sanitize_text_field( $_POST['page_load'] ) : '';

        unset( $_POST['action'] );
        unset( $_POST['option_name'] );
        unset( $_POST['page_load'] );
        unset( $_POST['_wpnonce'] );
        unset( $_POST['_wp_http_referer'] );

        $fields = [];
        if ( ! empty( $_POST ) && is_array( $_POST ) ) {
            foreach ( $_POST as $key => $field ) {
                $fields[ $key ] = imcm_sanitize_field( $field );
            }
        }

        update_option( $option_name, $fields );
        do_action( 'imcm-settings-saved', $option_name, $fields );
        
        $response['status']     = 1;
        $response['page_load']  = $page_load;
        $response['message']    = __( 'Settings Saved!', 'checkout-manager' );
        wp_send_json( $response );
    }
}