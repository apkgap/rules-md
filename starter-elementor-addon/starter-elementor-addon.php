<?php
/**
 * Plugin Name:  Starter Elementor Addon
 * Plugin URI:   https://starter.local
 * Description:  Custom Elementor widgets for Starter — 3-file widget architecture (no card.php).
 * Version:      1.0.0
 * Requires PHP: 7.4
 * Author:       starter-theme
 * Text Domain:  starter-elementor-addon
 *
 * @package starter-elementor-addon
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'STARTER_PATH',    plugin_dir_path( __FILE__ ) );
define( 'STARTER_URL',     plugin_dir_url( __FILE__ ) );
define( 'STARTER_VERSION', '1.0.0' );

final class Starter_Elementor_Addon {

	private static $instance = null;

	/**
	 * Registered widget slugs (each in widgets/{slug}/{slug}.php, .css, .js — no card.php).
	 *
	 * @var string[]
	 */
	private $widgets = [
		'starter-hero',
		'starter-services',
		'starter-why-us',
		'starter-feature-cards',
		'starter-promo',
		'starter-reviews',
		'starter-cta-banner',
		'starter-posts',
		'starter-posts-tabs',
		'starter-accordion',
		'starter-info-cards',
		'starter-post-grid',
		'starter-steps',
		'starter-gallery',
		'starter-dual-heading',
		'starter-stats',
		'starter-dentists',
		'starter-location-tabs',
		'starter-directions',
		'starter-directions-social',
	];

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );
		add_action( 'elementor/widgets/register',               [ $this, 'register_widgets' ] );
		add_action( 'wp_enqueue_scripts',                       [ $this, 'register_widget_assets' ] );
		add_action( 'elementor/frontend/after_enqueue_styles',  [ $this, 'register_widget_styles' ] );
	}

	/**
	 * Register all widget CSS & JS handles for get_style_depends() / get_script_depends().
	 */
	public function register_widget_assets() {
		// Third-party PhotoSwipe assets used by starter-gallery
		$pswp_css = STARTER_PATH . 'assets/css/photoswipe.css';
		if ( file_exists( $pswp_css ) ) {
			wp_register_style( 'photoswipe-css', STARTER_URL . 'assets/css/photoswipe.css', [], (string) filemtime( $pswp_css ) );
		}
		$pswp_core = STARTER_PATH . 'assets/js/photoswipe.umd.min.js';
		if ( file_exists( $pswp_core ) ) {
			wp_register_script( 'photoswipe-core', STARTER_URL . 'assets/js/photoswipe.umd.min.js', [], (string) filemtime( $pswp_core ), true );
		}
		$pswp_lb = STARTER_PATH . 'assets/js/photoswipe-lightbox.umd.min.js';
		if ( file_exists( $pswp_lb ) ) {
			wp_register_script( 'photoswipe-lightbox', STARTER_URL . 'assets/js/photoswipe-lightbox.umd.min.js', [ 'photoswipe-core' ], (string) filemtime( $pswp_lb ), true );
		}

		foreach ( $this->widgets as $slug ) {
			$css_file = STARTER_PATH . "widgets/{$slug}/{$slug}.css";
			if ( file_exists( $css_file ) ) {
				$css_ver = (string) filemtime( $css_file );
				$css_url = STARTER_URL . "widgets/{$slug}/{$slug}.css";
				wp_register_style( $slug, $css_url, [], $css_ver );
				wp_register_style( "starter-{$slug}", $css_url, [], $css_ver );
			}

			$js_file = STARTER_PATH . "widgets/{$slug}/{$slug}.js";
			if ( file_exists( $js_file ) ) {
				$js_ver = (string) filemtime( $js_file );
				$js_url = STARTER_URL . "widgets/{$slug}/{$slug}.js";
				wp_register_script( $slug, $js_url, [ 'jquery' ], $js_ver, true );
				wp_register_script( "starter-{$slug}", $js_url, [ 'jquery' ], $js_ver, true );
			}
		}
	}

	public function register_widget_styles() {
		$this->register_widget_assets();

		$css_path = STARTER_PATH . 'assets/css/starter-hero.css';
		if ( file_exists( $css_path ) ) {
			$css_ver = (string) filemtime( $css_path );
			wp_enqueue_style(
				'starter-starter-hero',
				STARTER_URL . 'assets/css/starter-hero.css',
				[],
				$css_ver
			);
		}
	}

	public function register_categories( $elements_manager ) {
		$elements_manager->add_category(
			'starter-elementor-addon',
			[
				'title' => esc_html__( 'Starter', 'starter-elementor-addon' ),
				'icon'  => 'fa fa-star',
			]
		);
	}

	public function register_widgets( $widgets_manager ) {
		foreach ( $this->widgets as $slug ) {
			$file = STARTER_PATH . "widgets/{$slug}/{$slug}.php";
			if ( ! file_exists( $file ) ) {
				continue;
			}
			require_once $file;
			$class = 'STARTER_Widget_' . str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $slug ) ) );
			if ( class_exists( $class ) ) {
				$widgets_manager->register( new $class() );
			}
		}
	}
}

function starter_elementor_addon_init() {
	if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
		add_action(
			'admin_notices',
			function () {
				echo '<div class="notice notice-warning is-dismissible"><p>' .
					esc_html__( 'Starter Elementor Addon requires Elementor to be installed and activated.', 'starter-elementor-addon' ) .
					'</p></div>';
			}
		);
		return;
	}
	Starter_Elementor_Addon::instance();
}
add_action( 'plugins_loaded', 'starter_elementor_addon_init' );
