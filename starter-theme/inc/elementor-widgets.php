<?php

/**
 * Register Custom Elementor Widgets
 *
 * @package starter_theme
 */

if (!defined('ABSPATH')) exit;

function starter_theme_register_elementor_widgets()
{
    if (!did_action('elementor/loaded')) return;

    // Register custom category
    \Elementor\Plugin::$instance->elements_manager->add_category(
        'starter-theme-elements',
        ['title' => __('Starter Theme Elements', 'starter-theme'), 'icon' => 'ri-plug-line']
    );

    // CSS styles are now registered in the starter-theme-elements plugin.
}
add_action('elementor/widgets/register', 'starter_theme_register_elementor_widgets');

