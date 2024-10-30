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
        add_action( 'wp_head', [ $this, 'head' ] );
        add_filter( 'body_class', [ $this, 'body_class' ] );
    }

    public function head() {
        // pri(IMCM_DEBUG_MODE);
    }

    public function body_class( $classes ) {
        return array_merge( $classes, array( 'imcm' ) );
    }
}