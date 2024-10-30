<?php
/**
 * Plugin Name:       Checkout Manager for Woocommerce
 * Plugin URI:        https://wpplugines.com/
 * Description:       Checkout Manager - The most advanced and powerful customization for your checkout page.
 * Version:           1.0.5
 * Author:            Al Imran Akash
 * Author URI:        https://profiles.wordpress.org/al-imran-akash/
 * Text Domain:       checkout-manager
 * Domain Path:       /languages
 */

namespace WPPlugines\Checkout_Manager;

/**
 * Exit if accessed directly
 * 
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main Plugin Class.
 *
 * @class Plugin
 */
final class Plugin {

    /**
     * Plugin version.
     *
     * @var string
     */
    public $version = '0.9';

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
     * Cloning is forbidden.
     *
     * @since 2.1
     */
    public function __clone() {}

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 2.1
     */
    public function __wakeup() {}

    /**
     * Plugin Constructor.
     */
    public function __construct() {
        $this->define_constants();
        $this->includes();
        $this->define_tables();
        $this->init_hooks();
    }

    /**
     * Define IM Constants.
     */
    private function define_constants() {
        $this->define( 'IMCM_FILE', __FILE__ );
        $this->define( 'IMCM_PATH', __DIR__ );
        $this->define( 'IMCM_URL', plugins_url( '', IMCM_FILE ) );
        $this->define( 'IMCM_ASSETS', IMCM_URL . '/assets' );
        $this->define( 'IMCM_ABSPATH', dirname( IMCM_FILE ) . '/' );
        $this->define( 'IMCM_BASENAME', plugin_basename( IMCM_FILE ) );
        $this->define( 'IMCM_VERSION', $this->version );
        $this->define( 'IMCM_DEBUG_MODE', apply_filters( 'imcm-debug', isset( get_option( 'imcm-setting-troubleshoot', false )['enable-debug'] ) == 'on' ) );
        $this->define( 'IMCM_MIN_PHP_VERSION', '5.6' );
        $this->define( 'IMCM_MIN_WP_VERSION', '4.0' );
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes() {
        /**
         * composer loaded
         * 
         * @since 1.0.0
         */
        require_once  IMCM_PATH . '/vendor/autoload.php';
    }

    /**
     * Register custom tables within $wpdb object.
     */
    private function define_tables() {
    }

    /**
     * Hook into actions and filters.
     *
     * @since 2.3
     */
    private function init_hooks() {
        new Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Ajax();
        }
        
        new App();
        new Front();
        new Admin();
        new Template();
    }

    /**
     * Define constant if not already set.
     *
     * @param string      $name  Constant name.
     * @param string|bool $value Constant value.
     */
    private function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }
}

Plugin::instance();