<?php
/**
 * All admin facing functions
 */
namespace WPPlugines\Checkout_Manager\App;

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
class Checkout {

    /**
     * The single instance of the class.
     *
     * @var Plugin
     * @since 2.1
     */
    protected static $_instance = null;

    /**
     * Main Plugin Instance.
     *
     * Ensures only one instance of Plugin is loaded or can be loaded.
     *
     * @since 2.1
     * @static
     * @return Plugin - Main instance.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

	/**
	 * Constructor function
	 */
	public function __construct() {
        $this->hooks();
	}

    private function hooks() {
        new Checkout\Admin;
        new Checkout\Common;
        new Checkout\Ajax;
        new Checkout\Front();
    }
}