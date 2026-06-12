<?php
/**
 * Plugin Name: Starter Elementor Addon
 * Description: A starter Elementor addon showing custom queries, responsive grids, and dual-rendering configurations.
 * Version:     1.0.0
 * Author:      Starter Team
 * Text Domain: starter-elementor-addon
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class Starter_Elementor_Addon
 *
 * Main bootstrap class for the Elementor Addon plugin.
 */
final class Starter_Elementor_Addon {

    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
    const MINIMUM_PHP_VERSION = '7.4';

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }

    /**
     * Initialize the plugin hooks.
     */
    public function init() {
        // Check if Elementor is installed and active
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );
            return;
        }

        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return;
        }

        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        // Register Widget Assets Enqueue
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_assets' ] );

        // Register Widgets Hook
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
    }

    /**
     * Enqueue CSS/JS assets for our custom widgets.
     */
    public function enqueue_frontend_assets() {
        $css_file = plugin_dir_path( __FILE__ ) . 'widgets/post-custom-query/post-custom-query.css';
        $css_url  = plugin_dir_url( __FILE__ ) . 'widgets/post-custom-query/post-custom-query.css';
        
        // Cache busting using filemtime
        $css_ver = file_exists( $css_file ) ? filemtime( $css_file ) : self::VERSION;
        wp_register_style(
            'exat-post-custom-query',
            $css_url,
            [],
            $css_ver
        );

        $js_file = plugin_dir_path( __FILE__ ) . 'widgets/post-custom-query/post-custom-query.js';
        $js_url  = plugin_dir_url( __FILE__ ) . 'widgets/post-custom-query/post-custom-query.js';
        
        $js_ver = file_exists( $js_file ) ? filemtime( $js_file ) : self::VERSION;
        wp_register_script(
            'exat-post-custom-query',
            $js_url,
            [ 'jquery' ],
            $js_ver,
            true // Load in footer
        );
    }

    /**
     * Require and register our custom Elementor widgets.
     */
    public function register_widgets( $widgets_manager ) {
        $widget_path = plugin_dir_path( __FILE__ ) . 'widgets/post-custom-query/post-custom-query.php';
        
        if ( file_exists( $widget_path ) ) {
            require_once $widget_path;
            $widgets_manager->register( new \EXAT_Post_Custom_Query_Widget() );
        }
    }

    /**
     * Admin Notice for missing Elementor
     */
    public function admin_notice_missing_elementor() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'starter-elementor-addon' ),
            '<strong>' . esc_html__( 'Starter Elementor Addon', 'starter-elementor-addon' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'starter-elementor-addon' ) . '</strong>'
        );

        echo '<div class="error"><p>' . wp_kses_post( $message ) . '</p></div>';
    }

    /**
     * Admin Notice for outdated Elementor Version
     */
    public function admin_notice_minimum_elementor_version() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'starter-elementor-addon' ),
            '<strong>' . esc_html__( 'Starter Elementor Addon', 'starter-elementor-addon' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'starter-elementor-addon' ) . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        echo '<div class="error"><p>' . wp_kses_post( $message ) . '</p></div>';
    }

    /**
     * Admin Notice for outdated PHP Version
     */
    public function admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'starter-elementor-addon' ),
            '<strong>' . esc_html__( 'Starter Elementor Addon', 'starter-elementor-addon' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'starter-elementor-addon' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        echo '<div class="error"><p>' . wp_kses_post( $message ) . '</p></div>';
    }
}

// Instantiate the Main Class
Starter_Elementor_Addon::instance();
