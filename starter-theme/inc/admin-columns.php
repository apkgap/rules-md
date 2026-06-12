<?php
/**
 * Add Featured Image column to admin posts list
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Add the thumbnail column
add_filter('manage_posts_columns', 'starter_theme_add_thumbnail_column', 5);
function starter_theme_add_thumbnail_column($columns) {
    // Add thumbnail before title
    $new_columns = [];
    foreach ($columns as $key => $title) {
        if ($key === 'title') {
            $new_columns['starter_theme_thumbnail'] = __('Feature Image', 'starter-theme');
        }
        $new_columns[$key] = $title;
    }
    return $new_columns;
}

// Output the thumbnail content
add_action('manage_posts_custom_column', 'starter_theme_display_thumbnail_column', 5, 2);
function starter_theme_display_thumbnail_column($column_name, $post_id) {
    if ($column_name === 'starter_theme_thumbnail') {
        if (has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail($post_id, array(50, 50), array('style' => 'width:50px;height:50px;object-fit:cover;border-radius:4px;box-shadow:0 0 0 1px #dcdcde;'));
        } else {
            echo '<div style="width:50px;height:50px;background:#f0f0f1;border-radius:4px;display:flex;align-items:center;justify-content:center;color:#a7aaad;box-shadow:0 0 0 1px #dcdcde;"><span class="dashicons dashicons-format-image"></span></div>';
        }
    }
}

// Adjust column width
add_action('admin_head', 'starter_theme_thumbnail_column_css');
function starter_theme_thumbnail_column_css() {
    echo '<style>
        .column-starter_theme_thumbnail { width: 75px; text-align: center; }
        td.column-starter_theme_thumbnail { padding-top: 5px !important; padding-bottom: 5px !important; }
    </style>';
}
