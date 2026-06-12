<?php

/**
 * Theme Options Page
 * 
 * @package starter_theme
 */

if (!defined('ABSPATH')) {
    exit;
}

function starter_theme_migrate_legacy_theme_options()
{
    $new_options = get_option('starter_theme_theme_options', null);
    $old_options = get_option('theme' . '_starter_theme_options', null);

    if ((null === $new_options || false === $new_options || array() === $new_options) && is_array($old_options) && !empty($old_options)) {
        update_option('starter_theme_theme_options', $old_options);
    }

    $new_theme_mods = get_option('theme_mods_starter-theme', null);
    $old_theme_mods = get_option('theme_mods_' . 'tae' . '-starter', null);

    if ((null === $new_theme_mods || false === $new_theme_mods || array() === $new_theme_mods) && is_array($old_theme_mods) && !empty($old_theme_mods)) {
        update_option('theme_mods_starter-theme', $old_theme_mods);
    }
}
add_action('after_setup_theme', 'starter_theme_migrate_legacy_theme_options', 1);

class starter_theme_theme_options
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_options_page'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('rest_api_init', array($this, 'register_rest_routes'));
    }

    public function add_options_page()
    {
        // Add Parent Menu
        add_menu_page(
            __('Theme Options', 'starter-theme'),
            __('Theme Options', 'starter-theme'),
            'manage_options',
            'starter-theme-theme-options',
            array($this, 'render_theme_options_page'),
            'dashicons-admin-generic',
            60
        );

        // Add Submenu "Page Title"
        add_submenu_page(
            'starter-theme-theme-options',
            __('Page Title Settings', 'starter-theme'),
            __('Page Title', 'starter-theme'),
            'manage_options',
            'starter-theme-page-title-settings',
            array($this, 'render_page_title_react_page')
        );

        // Add Submenu "Header Settings" (PHP form — no React build required)
        add_submenu_page(
            'starter-theme-theme-options',
            __('Header Settings', 'starter-theme'),
            __('Header', 'starter-theme'),
            'manage_options',
            'starter-theme-header-settings',
            array($this, 'render_header_settings_page')
        );

        // Add Submenu "Starter Footer Settings" (React)
        add_submenu_page(
            'starter-theme-theme-options',
            __('Starter Footer Settings', 'starter-theme'),
            __('Starter Footer', 'starter-theme'),
            'manage_options',
            'starter-theme-starter-footer-settings',
            array($this, 'render_starter_footer_page')
        );

        // Add Submenu "Archive & Pagination"
        add_submenu_page(
            'starter-theme-theme-options',
            __('Archive & Pagination Settings', 'starter-theme'),
            __('Pagination', 'starter-theme'),
            'manage_options',
            'starter-theme-archive-settings',
            array($this, 'render_archive_settings_page')
        );

        // Remove the duplicate first submenu
        remove_submenu_page('starter-theme-theme-options', 'starter-theme-theme-options');
    }

    public function enqueue_admin_scripts($hook)
    {
        // Allow scripts on our theme options pages
        if (strpos($hook, 'starter-theme') === false) {
            return;
        }

        wp_enqueue_media();

        $asset_file = get_template_directory() . '/dist/admin/admin-theme-options.asset.php';

        if (file_exists($asset_file)) {
            $assets = require $asset_file;

            wp_enqueue_style(
                'starter-theme-tailwind-admin',
                get_template_directory_uri() . '/dist/tailwind.css',
                array(),
                filemtime(get_template_directory() . '/dist/tailwind.css')
            );

            wp_enqueue_style('wp-components');
            wp_enqueue_editor();

            wp_enqueue_script(
                'starter-theme-admin-theme-options',
                get_template_directory_uri() . '/dist/admin/admin-theme-options.js',
                $assets['dependencies'],
                $assets['version'],
                true
            );

            wp_localize_script('starter-theme-admin-theme-options', 'StarterThemeOptions', array(
                'apiUrl'   => esc_url_raw(rest_url('starter_theme/v1/options')),
                'restRoot' => esc_url_raw(rest_url()),
                'nonce'    => wp_create_nonce('wp_rest')
            ));
        }
    }

    public function register_rest_routes()
    {
        register_rest_route('starter_theme/v1', '/options', array(
            'methods'  => 'GET',
            'callback' => array($this, 'get_options_api'),
            'permission_callback' => function () {
                return current_user_can('manage_options');
            }
        ));

        register_rest_route('starter_theme/v1', '/options', array(
            'methods'  => 'POST',
            'callback' => array($this, 'update_options_api'),
            'permission_callback' => function () {
                return current_user_can('manage_options');
            }
        ));

        register_rest_route('starter_theme/v1', '/menus', array(
            'methods'  => 'GET',
            'callback' => array($this, 'get_menus_api'),
            'permission_callback' => function () {
                return current_user_can('manage_options');
            }
        ));
    }

    /**
     * Return all registered WordPress nav menus as [{value, label}] for SelectControl.
     */
    public function get_menus_api()
    {
        $menus  = wp_get_nav_menus();
        $result = [['value' => '', 'label' => '— ไม่เลือก (ไม่แสดง) —']];

        foreach ($menus as $menu) {
            $result[] = [
                'value' => (string) $menu->term_id,
                'label' => $menu->name,
            ];
        }

        return rest_ensure_response($result);
    }

    public function get_options_api()
    {
        $options = get_option('starter_theme_theme_options', []);
        return rest_ensure_response((object) $options);
    }

    public function update_options_api($request)
    {
        $params = $request->get_json_params();
        if ( ! is_array( $params ) ) {
            return new WP_Error( 'invalid_data', 'Invalid parameters', [ 'status' => 400 ] );
        }

        $sanitized_params = $this->sanitize_options_recursively( $params );
        update_option('starter_theme_theme_options', $sanitized_params);
        return rest_ensure_response($sanitized_params);
    }

    private function sanitize_options_recursively( $value, $key = '' )
    {
        if ( is_array( $value ) ) {
            $sanitized = [];
            foreach ( $value as $k => $v ) {
                $sanitized[ sanitize_key( $k ) ] = $this->sanitize_options_recursively( $v, $k );
            }
            return $sanitized;
        }

        $key = strtolower( (string) $key );
        if ( strpos( $key, 'lines' ) !== false || strpos( $key, 'description' ) !== false || $key === 'starter_footer_fax' ) {
            return sanitize_textarea_field( $value );
        }
        if ( strpos( $key, 'url' ) !== false ) {
            return esc_url_raw( $value );
        }

        return sanitize_text_field( $value );
    }

    public function render_starter_footer_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have sufficient permissions.', 'starter-theme'));
        }
        echo '<div id="starter-footer-settings-root"></div>';
    }

    public function render_theme_options_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have sufficient permissions.', 'starter-theme'));
        }

        echo '<div class="wrap"><h1>' . esc_html__('Theme Options', 'starter-theme') . '</h1><p>' . esc_html__('Use the submenu items to edit each settings section.', 'starter-theme') . '</p></div>';
    }

    public function render_page_title_react_page()
    {
        echo '<div id="starter-theme-page-title-settings-root"></div>';
    }

    /**
     * Render the Header Settings page (PHP form — no React build required).
     */
    public function render_header_settings_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have sufficient permissions.', 'starter-theme'));
        }
        echo '<div id="starter-theme-header-settings-root"></div>';
    }

    public function render_archive_settings_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have sufficient permissions.', 'starter-theme'));
        }
        echo '<div id="starter-theme-archive-settings-root"></div>';
    }
}

new starter_theme_theme_options();

/**
 * Helper function to get theme option
 */
function starter_theme_get_option($key, $default = '')
{
    $options = get_option('starter_theme_theme_options');

    // Check for Polylang current language
    $lang = function_exists('pll_current_language') ? pll_current_language() : 'th';

    // Default to 'th' if empty (e.g. in admin ajax sometimes)
    if (empty($lang)) $lang = 'th';

    // 1. Try specific language key (e.g. field_en)
    $key_lang = $key . '_' . $lang;
    if (isset($options[$key_lang]) && !empty($options[$key_lang])) {
        return $options[$key_lang];
    }

    // 2. Fallback to generic key (for backward compatibility or shared fields)
    if (isset($options[$key]) && !empty($options[$key])) {
        return $options[$key];
    }

    return $default;
}

/**
 * Build responsive header position classes.
 */
function starter_theme_get_header_position_class($header_position, $sticky_disable_on = 'none', $sticky_z_class = 'z-40')
{
    $header_position = sanitize_key((string) $header_position);
    $sticky_disable_on = sanitize_key((string) $sticky_disable_on);

    if ($header_position === 'fixed') {
        return trim('fixed top-0 left-0 right-0 ' . $sticky_z_class);
    }

    if ($header_position !== 'sticky') {
        return trim('relative ' . $sticky_z_class);
    }

    switch ($sticky_disable_on) {
        case 'none':
            return trim('sticky top-0 ' . $sticky_z_class);

        case 'mobile':
            return trim('sticky top-0 max-[767px]:static min-[768px]:sticky min-[768px]:top-0 ' . $sticky_z_class);

        case 'tablet':
            return trim('sticky top-0 max-[767px]:sticky max-[767px]:top-0 min-[768px]:static min-[1025px]:sticky min-[1025px]:top-0 ' . $sticky_z_class);

        case 'mobile_tablet':
        default:
            return trim('sticky top-0 max-[1024px]:static min-[1025px]:sticky min-[1025px]:top-0 ' . $sticky_z_class);
    }
}


/**
 * Register strings for Polylang translation.
 * Call this in functions.php after theme setup.
 */
function starter_theme_register_polylang_strings()
{
    if (!function_exists('pll_register_string')) {
        return;
    }

    // Header strings
    pll_register_string('starter-theme', 'Search Articles', 'Header', false);
    pll_register_string('starter-theme', 'Type what you are looking for...', 'Header', false);
    pll_register_string('starter-theme', 'Press Enter to search or ESC to close', 'Header', false);

    // Common strings
    pll_register_string('starter-theme', 'Read More', 'Common', false);
    pll_register_string('starter-theme', 'View All', 'Common', false);
    pll_register_string('starter-theme', 'No results found', 'Common', false);
}
add_action('after_setup_theme', 'starter_theme_register_polylang_strings');
