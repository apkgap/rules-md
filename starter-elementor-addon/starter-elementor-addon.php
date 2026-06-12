<?php
/**
 * Plugin Name:  Starter Elementor Addon
 * Plugin URI:   https://starter.local
 * Description:  Custom Elementor widgets for Starter — Hero, Services, Why Us, Promo, Reviews, CTA Banner.
 * Version:      1.0.0
 * Requires PHP: 7.4
 * Author:       starter-theme
 * Text Domain:  starter-elementor-addon
 *
 * @package starter-elementor-addon
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'STARTER_PATH',    plugin_dir_path( __FILE__ ) );
define( 'STARTER_URL',     plugin_dir_url( __FILE__ ) );
define( 'STARTER_VERSION', '1.0.0' );

final class starter_elementor_addon {

	private static $instance = null;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );
		add_action( 'elementor/widgets/register',               [ $this, 'register_widgets' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'register_widget_styles' ] );
	}

	public function register_widget_styles() {
		wp_enqueue_style(
			'starter-starter-hero',
			STARTER_URL . 'assets/css/starter-hero.css',
			[],
			STARTER_VERSION
		);
	}

	public function register_categories( $elements_manager ) {
		$elements_manager->add_category( 'starter-elementor-addon', [
			'title' => __( 'Starter', 'starter-elementor-addon' ),
			'icon'  => 'fa fa-star',
		] );
	}

	public function register_widgets( $widgets_manager ) {
		$widgets = [
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

		foreach ( $widgets as $slug ) {
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
		add_action( 'admin_notices', function() {
			echo '<div class="notice notice-warning is-dismissible"><p>' .
				esc_html__( 'Starter Elementor Addon requires Elementor to be installed and activated.', 'starter-elementor-addon' ) .
				'</p></div>';
		} );
		return;
	}
	starter_elementor_addon::instance();
}
add_action( 'plugins_loaded', 'starter_elementor_addon_init' );
