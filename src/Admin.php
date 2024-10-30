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
        register_activation_hook( IMCM_FILE, [ new Install(), 'install' ] );

        add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ], -1 );
        add_action( 'admin_notices', [ $this, 'build_dependencies_notice' ] );
        add_action( 'after_setup_theme', [ $this, 'setup_environment' ] );
        add_action( 'init', [ $this, 'init' ], 0 );
        // add_action( 'init', [ 'WC_Shortcodes', 'init' ] );
        add_action( 'activated_plugin', [ $this, 'activated_plugin' ] );
        add_action( 'deactivated_plugin', [ $this, 'deactivated_plugin' ] );
        add_action( 'admin_head', [ $this, 'head' ] );
        add_action( 'admin_menu', [ $this, 'menu' ] );
        add_filter( 'admin_body_class', [ $this, 'admin_body_class' ] );
        add_filter( "plugin_action_links_" . IMCM_BASENAME, [ $this, 'action_links' ] );   
    }

    public function head() {
        // wp_enqueue_style( 'admin-style' );
        // wp_enqueue_script( 'front-script' );
    }

    /**
     * When WP has loaded all plugins, trigger the `woocommerce_loaded` hook.
     *
     * This ensures `woocommerce_loaded` is called only after all other plugins
     * are loaded, to avoid issues caused by plugin directory naming changing
     * the load order. See #21524 for details.
     *
     * @since 3.6.0
     */
    public function on_plugins_loaded() {
        do_action( 'im_loaded' );
    }

    /**
     * Ran when any plugin is activated.
     *
     * @since 3.6.0
     * @param string $filename The filename of the activated plugin.
     */
    public function activated_plugin( $filename ) {}

    /**
     * Ran when any plugin is deactivated.
     *
     * @since 3.6.0
     * @param string $filename The filename of the deactivated plugin.
     */
    public function deactivated_plugin( $filename ) {}

    /**
     * Init WooCommerce when WordPress Initialises.
     */
    public function init() {
        // Before init action.
        do_action( 'before_im_plugin_init' );

        // Set up localisation.
        $this->load_plugin_textdomain();

        // Init action.
        do_action( 'im_plugin_init' );
    }

    /**
     * Load Localisation files.
     *
     * Note: the first-loaded translation file overrides any following ones if the same translation is present.
     */
    public function load_plugin_textdomain() {
        load_plugin_textdomain( 'cx-plugin', false, plugin_basename( dirname( IMCM_FILE ) ) . '/i18n/languages' );
    }

    /**
     * Output a admin notice when build dependencies not met.
     *
     * @return void
     */
    public function build_dependencies_notice() {}

    /**
     * Ensure theme and server variable compatibility and setup image sizes.
     */
    public function setup_environment() {
        $this->add_thumbnail_support();
    }

    /**
     * Ensure post thumbnail support is turned on.
     */
    private function add_thumbnail_support() {
        if ( ! current_theme_supports( 'post-thumbnails' ) ) {
            add_theme_support( 'post-thumbnails' );
        }
        add_post_type_support( 'product', 'thumbnail' );
    }

    /**
     * Register a custom menu page.
     */
    public function menu() {
        add_menu_page( __( 'Checkout Manager', 'checkout-manager' ), __( 'Checkout Manager', 'checkout-manager' ), 'manage_options', 'checkout-manager', [ $this, 'checkout_manager_callback' ], IMCM_ASSETS .'/img/logo.png', 15 );
    }

    public function checkout_manager_callback() {
        do_action( 'imcm_settings' );
    }

    public function admin_body_class( $classes ) {
        return $classes .= 'imcm';
    }

    public function action_links( $links ) {

        $new_links = [
            'settings'  => sprintf( '<a href="%1$s">' . __( 'Settings', 'woolementor' ) . '</a>', add_query_arg( 'page', 'checkout-manager', admin_url( 'admin.php' ) ) )
        ];
        
        return array_merge( $new_links, $links );
    }
}