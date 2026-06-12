<?php
/**
 * Register Custom Post Types and Custom Taxonomies
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Register Custom Post Types and Taxonomies
 */
function starter_theme_register_post_types() {
    // Add custom post types and taxonomies registrations here.
}
add_action( 'init', 'starter_theme_register_post_types' );
