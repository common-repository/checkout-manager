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
class Helper {

	/**
	 * Constructor function
	 */
	public function __construct() {
        $this->hooks();
	}

    private function hooks() {
    }

    public static function pri( $data ) {
        echo '<pre>';
        if( is_object( $data ) || is_array( $data ) ) {
            print_r( $data );
        }
        else {
            var_dump( $data );
        }
        echo '</pre>';
    }

    /**
     * @param bool $show_cached either to use a cached list of posts or not. If enabled, make sure to wp_cache_delete() with the `save_post` hook
     */
    public static function get_posts( $args = [], $show_heading = false, $show_cached = false ) {

        $defaults = [
            'post_type'         => 'post',
            'posts_per_page'    => -1,
            'post_status'       => 'publish'
        ];

        $_args = wp_parse_args( $args, $defaults );

        // use cache
        if( true === $show_cached && ( $cached_posts = wp_cache_get( "imcm_plugin_{$_args['post_type']}", 'imcm_plugin' ) ) ) {
            $posts = $cached_posts;
        }

        // don't use cache
        else {
            $queried = new \WP_Query( $_args );

            $posts = [];
            foreach( $queried->posts as $post ) :
                $posts[ $post->ID ] = $post->post_title;
            endforeach;
            
            wp_cache_add( "imcm_plugin_{$_args['post_type']}", $posts, 'imcm_plugin', 3600 );
        }

        $posts = $show_heading ? [ '' => sprintf( __( '- Choose a %s -', 'imcm_plugin' ), $_args['post_type'] ) ] + $posts : $posts;

        return apply_filters( 'imcm_plugin_get_posts', $posts, $_args );
    }

    public static function get_option( $key, $section, $default = '' ) {

        $options = get_option( $key );

        if ( isset( $options[ $section ] ) ) {
            return $options[ $section ];
        }

        return $default;
    }

    /**
     * Includes a template file resides in /views diretory
     *
     * It'll look into /cx-plugin directory of your active theme
     * first. if not found, default template will be used.
     * can be overwriten with cx-plugin_template_overwrite_dir hook
     *
     * @param string $slug slug of template. Ex: template-slug.php
     * @param string $sub_dir sub-directory under base directory
     * @param array $fields fields of the form
     */
    public static function get_template( $slug, $base = 'views', $args = null ) {

        // templates can be placed in this directory
        $overwrite_template_dir = apply_filters( 'imcm_plugin_template_overwrite_dir', get_stylesheet_directory() . '/checkout-manager/', $slug, $base, $args );
        // default template directory
        $plugin_template_dir = dirname( IMCM_FILE ) . "/{$base}/";

        // full path of a template file in plugin directory
        $plugin_template_path =  $plugin_template_dir . $slug . '.php';
        
        // full path of a template file in overwrite directory
        $overwrite_template_path =  $overwrite_template_dir . $slug . '.php';

        // if template is found in overwrite directory
        if( file_exists( $overwrite_template_path ) ) {
            ob_start();
            include $overwrite_template_path;
            return ob_get_clean();
        }
        // otherwise use default one
        elseif ( file_exists( $plugin_template_path ) ) {
            ob_start();
            include $plugin_template_path;
            return ob_get_clean();
        }
        else {
            return __( 'Template not found!', 'checkout-manager' );
        }
    }
}