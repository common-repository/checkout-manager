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
 * @subpackage Assets
 * @author Al Imran Akash <alimranakash.bd@gmail.com>
 */
class Assets {

	/**
	 * Constructor function
	 */
	public function __construct() {
        $this->hooks();
	}

    private function hooks() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ] );
    }

    /**
     * Styles get function
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    public function get_styles() {
        $min = defined( 'IMCM_DEBUG_MODE' ) && IMCM_DEBUG_MODE ? '' : '.min';

        return [
            'minicolors-style' => [
                'src'     => IMCM_ASSETS . "/css/jquery.minicolors.css",
                'version' => filemtime( IMCM_PATH . "/assets/css/jquery.minicolors.css" ),
            ],
            'front-style' => [
                'src'     => IMCM_ASSETS . "/css/front{$min}.css",
                'version' => filemtime( IMCM_PATH . "/assets/css/front{$min}.css" ),
            ],
            'admin-style' => [
                'src'     => IMCM_ASSETS . "/css/admin{$min}.css",
                'version' => filemtime( IMCM_PATH . "/assets/css/admin{$min}.css" ),
            ],
            'jquery-ui' => [
                'src'     => IMCM_ASSETS . "/css/jquery-ui.css",
                'version' => time(),
            ]
        ];
    }

    /**
     * Scripts get function
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    public function get_scripts() {
        $min = defined( 'IMCM_DEBUG_MODE' ) && IMCM_DEBUG_MODE ? '' : '.min';

        return [
            'minicolors-script' => [
                'src'     => IMCM_ASSETS . "/js/jquery.minicolors{$min}.js",
                'version' => filemtime( IMCM_PATH . "/assets/js/jquery.minicolors{$min}.js" ),
                'deps'    => [ 'jquery' ],
            ],
            'front-script' => [
                'src'     => IMCM_ASSETS . "/js/front{$min}.js",
                'version' => filemtime( IMCM_PATH . "/assets/js/front{$min}.js" ),
                'deps'    => [ 'jquery' ],
            ],
            'admin-script' => [
                'src'     => IMCM_ASSETS . "/js/admin{$min}.js",
                'version' => filemtime( IMCM_PATH . "/assets/js/admin{$min}.js" ),
                'deps'    => [ 'jquery' ],
            ]
        ];
    }
    
    /**
     * Assets enqueue function
     * 
     * @since 1.0.0
     * 
     * @return mixed
     */
    public function enqueue_assets() {

        //Styles register 
        $styles = $this->get_styles();
        foreach ( $styles as $handale => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;
            wp_register_style( $handale, $style['src'], $deps, $style['version'] );
        }

        $style_enable   = imcm_get_style( 'style-enable', '' );
        $height         = imcm_get_style( 'height', '40' );
        $border         = imcm_get_style( 'border', '#d1d1d1' );
        $border_focus   = imcm_get_style( 'border-focus', '#d1d1d1' );
        $border_correct = imcm_get_style( 'border-correct-info', '#69bf29' );
        $border_wrong   = imcm_get_style( 'border-wrong-info', '#a00a00' );
        $error_message  = imcm_get_style( 'error-message-color', '#a00a00' );

        $custom_css     = "
            .imcm .woocommerce .select2-container .select2-selection--single, 
            .imcm .woocommerce select, 
            .imcm .woocommerce-page .select2-container .select2-selection--single, 
            .imcm .woocommerce-page select,
            .imcm .woocommerce form .form-row input.input-text, 
            .imcm .woocommerce form .form-row .select2-container .select2-choice, 
            .imcm .woocommerce form .form-row select {
                height: {$height}px;
                border-color: {$border};
            }
            .imcm .woocommerce form .form-row.woocommerce-invalid .select2-container .select2-choice, 
            .imcm .woocommerce form .form-row.woocommerce-invalid input.input-text, 
            .imcm .woocommerce form .form-row.woocommerce-invalid select, 
            .imcm .woocommerce form .form-row.woocommerce-invalid textarea {
                border-color: {$border_wrong};
            }
            .imcm .woocommerce form .form-row.woocommerce-invalid label, 
            .imcm .woocommerce form .form-row.woocommerce-invalid .ywccp_error {
                color: {$error_message};
            }
            .imcm .woocommerce form .form-row textarea:focus, 
            .imcm .woocommerce form input[type='email']:focus, 
            .imcm .woocommerce form input[type='number']:focus, 
            .imcm .woocommerce form input[type='password']:focus, 
            .imcm .woocommerce form input[type='reset']:focus, 
            .imcm .woocommerce form input[type='search']:focus, 
            .imcm .woocommerce form input[type='tel']:focus, 
            .imcm .woocommerce form input[type='text']:focus, 
            .imcm .woocommerce form input[type='url']:focus, 
            .imcm .woocommerce form textarea:focus {
                border-color: {$border_focus}
            }
        ";

        if ( 'on' == $style_enable ) {
            wp_add_inline_style( 'front-style', $custom_css );
        }
        
        //Scripts register
        $scripts = $this->get_scripts();
        foreach ( $scripts as $handale => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;
            wp_register_script( $handale, $script['src'], $deps, $script['version'], true );
        }

        //scripts localize function
        wp_localize_script( 'front-script', 'IMCM', [
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'checkout-manager' ),
        ] );

        //scripts localize function
        wp_localize_script( 'admin-script', 'IMCM', [
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'checkout-manager' ),
        ] );
    }
}