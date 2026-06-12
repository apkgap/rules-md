<?php
/**
 * Enqueue scripts and styles.
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function starter_theme_scripts()
{
    // Roboto (Local)
    $roboto_css_path = get_template_directory() . '/assets/fonts/roboto/font.css';
    if (file_exists($roboto_css_path)) {
        wp_enqueue_style(
            'roboto-local',
            get_template_directory_uri() . '/assets/fonts/roboto/font.css',
            array(),
            filemtime($roboto_css_path)
        );
    }

    // Noto Sans Thai (Local)
    $noto_css_path = get_template_directory() . '/assets/fonts/noto-sans-thai/font.css';
    if (file_exists($noto_css_path)) {
        wp_enqueue_style(
            'noto-sans-thai',
            get_template_directory_uri() . '/assets/fonts/noto-sans-thai/font.css',
            array(),
            filemtime($noto_css_path)
        );
    }

    // Enqueue Tailwind CSS (Load First)
    $tailwind_css_path = get_template_directory() . '/dist/tailwind.css';
    $tailwind_css_ver = file_exists($tailwind_css_path) ? filemtime($tailwind_css_path) : _S_VERSION;
    wp_enqueue_style(
        'starter-theme-tailwind',
        get_template_directory_uri() . '/dist/tailwind.css',
        array('roboto-local', 'noto-sans-thai'),
        $tailwind_css_ver
    );

    // Remix Icon (Local)
    $remix_css_path = get_template_directory() . '/assets/remixicon/fonts/remixicon.css';
    if (file_exists($remix_css_path)) {
        wp_enqueue_style(
            'starter-theme-remixicon',
            get_template_directory_uri() . '/assets/remixicon/fonts/remixicon.css',
            array(),
            filemtime($remix_css_path)
        );
    }


    // Enqueue Switchery CSS (Local)
    $switchery_css_path = get_template_directory() . '/assets/css/switchery/switchery.css';
    if (file_exists($switchery_css_path)) {
        wp_enqueue_style(
            'switchery',
            get_template_directory_uri() . '/assets/css/switchery/switchery.css',
            array(),
            filemtime($switchery_css_path)
        );
    }

    // Enqueue Switchery JS (Local)
    $switchery_js_path = get_template_directory() . '/assets/js/switchery/switchery.js';
    if (file_exists($switchery_js_path)) {
        wp_enqueue_script(
            'switchery',
            get_template_directory_uri() . '/assets/js/switchery/switchery.js',
            array(),
            filemtime($switchery_js_path),
            true
        );
    }

    // Enqueue Main JS Bundle (Alpine.js, etc.)
    $app_js_path = get_template_directory() . '/dist/app.js';
    $app_js_ver = file_exists($app_js_path) ? filemtime($app_js_path) : _S_VERSION;

    wp_enqueue_script(
        'starter-theme-app-js',
        get_template_directory_uri() . '/dist/app.js',
        array( 'jquery-ui-datepicker' ),
        $app_js_ver,
        true
    );

    wp_style_add_data('starter-theme-style', 'rtl', 'replace');

    $nav_js_path = get_template_directory() . '/js/navigation.js';
    $nav_js_ver = file_exists($nav_js_path) ? filemtime($nav_js_path) : _S_VERSION;
    wp_enqueue_script(
        'starter-theme-navigation',
        get_template_directory_uri() . '/js/navigation.js',
        array(),
        $nav_js_ver,
        true
    );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'starter_theme_scripts');

function starter_theme_admin_scripts($hook) {
    // Noto Sans Thai for admin
    $noto_css_path = get_template_directory() . '/assets/fonts/noto-sans-thai/font.css';
    if (file_exists($noto_css_path)) {
        wp_enqueue_style(
            'noto-sans-thai-admin',
            get_template_directory_uri() . '/assets/fonts/noto-sans-thai/font.css',
            array(),
            filemtime($noto_css_path)
        );
    }

    // Remix Icon (Local) for admin screens
    $remix_css_path = get_template_directory() . '/assets/remixicon/fonts/remixicon.css';
    if (file_exists($remix_css_path)) {
        wp_enqueue_style(
            'starter-theme-remixicon-admin',
            get_template_directory_uri() . '/assets/remixicon/fonts/remixicon.css',
            array(),
            filemtime($remix_css_path)
        );
    }
}
add_action('admin_enqueue_scripts', 'starter_theme_admin_scripts');
