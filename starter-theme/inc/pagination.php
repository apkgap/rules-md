<?php

/**
 * Custom Full Pagination
 *
 * @package starter_theme
 */

if (!function_exists('starter_theme_get_pagination_query')) {
    function starter_theme_get_pagination_query($query = null)
    {
        if ($query instanceof WP_Query) {
            return $query;
        }

        global $wp_query;

        return $wp_query;
    }
}

if (!function_exists('starter_theme_get_pagination_data')) {
    function starter_theme_get_pagination_data($custom_args = [], $query = null)
    {
        $query_obj = starter_theme_get_pagination_query($query);

        if (!$query_obj instanceof WP_Query) {
            return null;
        }

        $total_pages = (int) $query_obj->max_num_pages;

        if ($total_pages <= 1) {
            return null;
        }

        $paged = max(1, get_query_var('paged') ? (int) get_query_var('paged') : (isset($_GET['paged']) ? (int) $_GET['paged'] : 1));

        $default_args = [
            'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format'    => '?paged=%#%',
            'current'   => $paged,
            'total'     => $total_pages,
            'type'      => 'array',
            'end_size'  => 1,
            'mid_size'  => 1,
            'prev_next' => false,
        ];

        $args  = wp_parse_args($custom_args, $default_args);
        $links = paginate_links($args);

        if (empty($links) || !is_array($links)) {
            return null;
        }

        $items = [];

        foreach ($links as $link) {
            if (strpos($link, 'dots') !== false) {
                $items[] = [
                    'type'    => 'dots',
                    'label'   => '...',
                    'url'     => '',
                    'current' => false,
                ];
                continue;
            }

            $is_current = strpos($link, 'current') !== false;
            preg_match('/href=["\']([^"\']+)["\']/', $link, $matches);
            $url = isset($matches[1]) ? $matches[1] : '';
            $label = trim(wp_strip_all_tags($link));

            $items[] = [
                'type'    => 'page',
                'label'   => $label,
                'url'     => $url,
                'current' => $is_current,
            ];
        }

        $total_posts    = (int) $query_obj->found_posts;
        $posts_per_page = (int) $query_obj->get('posts_per_page');

        if (!$posts_per_page) {
            $posts_per_page = (int) get_option('posts_per_page');
        }

        $start_item = $total_posts > 0 ? (($paged - 1) * $posts_per_page) + 1 : 0;
        $end_item   = $total_posts > 0 ? min($start_item + $posts_per_page - 1, $total_posts) : 0;

        return [
            'current'       => $paged,
            'total'         => $total_pages,
            'items'         => $items,
            'prev_url'      => $paged > 1 ? get_pagenum_link($paged - 1) : '',
            'next_url'      => $paged < $total_pages ? get_pagenum_link($paged + 1) : '',
            'first_url'     => $paged > 1 ? get_pagenum_link(1) : '',
            'last_url'      => $paged < $total_pages ? get_pagenum_link($total_pages) : '',
            'jump_base'     => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'total_posts'   => $total_posts,
            'posts_per_page' => $posts_per_page,
            'start_item'    => $start_item,
            'end_item'      => $end_item,
        ];
    }
}

if (!function_exists('starter_theme_pagination_primary')) {
    function starter_theme_pagination_primary($custom_args = [], $query = null)
    {
        $pagination = starter_theme_get_pagination_data($custom_args, $query);

        if (empty($pagination)) {
            return;
        }

        set_query_var('pagination', $pagination);
        get_template_part('template-parts/pagination', 'primary');
        set_query_var('pagination', null);
    }
}

if (!function_exists('starter_theme_pagination_compact')) {
    function starter_theme_pagination_compact($custom_args = [], $query = null)
    {
        $pagination = starter_theme_get_pagination_data($custom_args, $query);

        if (empty($pagination)) {
            return;
        }

        set_query_var('pagination', $pagination);
        get_template_part('template-parts/pagination', 'compact');
        set_query_var('pagination', null);
    }
}

/**
 * Render pagination based on theme settings for the current post type
 */
if (!function_exists('starter_theme_render_pagination')) {
    function starter_theme_render_pagination($query = null, $custom_args = [])
    {
        $query_obj = starter_theme_get_pagination_query($query);
        if (!$query_obj instanceof WP_Query) {
            return;
        }

        $post_type = $query_obj->get('post_type');
        if (is_array($post_type)) {
            $post_type = reset($post_type);
        }

        // Handle case for default 'post' type which might be empty string in some queries
        if (empty($post_type)) {
            $post_type = 'post';
        }

        // Get setting from theme options
        $style = function_exists('starter_theme_get_option') ? starter_theme_get_option('pagination_style_' . $post_type, 'full') : 'full';

        if ('compact' === $style && function_exists('starter_theme_pagination_compact')) {
            starter_theme_pagination_compact($custom_args, $query_obj);
        } elseif (function_exists('starter_theme_full_pagination')) {
            starter_theme_full_pagination($custom_args, $query_obj);
        }
    }
}

if (!function_exists('starter_theme_full_pagination')) {
    function starter_theme_full_pagination($custom_args = [], $query = null)
    {
        $query_obj = starter_theme_get_pagination_query($query);

        if (!$query_obj instanceof WP_Query) {
            return;
        }

        $total_pages = $query_obj->max_num_pages;

        if ($total_pages <= 1) {
            return;
        }

        $paged = max(1, get_query_var('paged') ? (int) get_query_var('paged') : (isset($_GET['paged']) ? (int) $_GET['paged'] : 1));

        $default_args = [
            'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format'    => '?paged=%#%',
            'current'   => $paged,
            'total'     => $total_pages,
            'prev_text' => '<span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-left-s-line"></i></span> ' . esc_html__('ก่อนหน้า', 'starter-theme'),
            'next_text' => esc_html__('ถัดไป', 'starter-theme') . ' <span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-s-line"></i></span>',
            'type'      => 'array',
            'end_size'  => 1,
            'mid_size'  => 1,
        ];


        $args = wp_parse_args($custom_args, $default_args);
        $pages = paginate_links($args);

        if ($pages) {
            echo '<nav class="my-8 flex items-center justify-center gap-2 flex-wrap" aria-label="Pagination">';
            foreach ($pages as $page) {
                $is_current = strpos($page, 'current') !== false;
                $is_dots    = strpos($page, 'dots') !== false;

                if ($is_dots) {
                    echo '<span class="w-10 h-10 flex items-center justify-center text-[#8892a4] border border-transparent">...</span>';
                    continue;
                }

                // If it is the previous or next link, give it padding instead of fixed width
                if (strpos($page, 'prev') !== false || strpos($page, 'next') !== false) {
                    $page = str_replace("page-numbers", "px-4 h-10 rounded-xl bg-white border border-[#e2e6ee] text-[#8892a4] flex items-center justify-center text-xs font-semibold hover:border-primary hover:text-primary transition-all", $page);
                    echo $page;
                    continue;
                }

                if ($is_current) {
                    echo '<span class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center text-xs font-bold shadow-md">' . strip_tags($page) . '</span>';
                } else {
                    $page = str_replace('page-numbers', 'w-10 h-10 rounded-xl bg-white border border-[#e2e6ee] text-[#8892a4] flex items-center justify-center text-xs font-semibold hover:border-primary hover:text-primary transition-all', $page);
                    echo $page;
                }
            }
            echo '</nav>';

            $total_posts = $query_obj->found_posts;
            $posts_per_page = $query_obj->query_vars['posts_per_page'];
            if (!$posts_per_page) {
                $posts_per_page = get_option('posts_per_page');
            }
            $start_item = (($paged - 1) * $posts_per_page) + 1;
            $end_item = min($start_item + $posts_per_page - 1, $total_posts);

            echo '<div class="text-center mt-4 text-sm text-gray-600">';
            echo sprintf(
                esc_html__('แสดง %1$d - %2$d จากทั้งหมด %3$d รายการ', 'starter-theme'),
                $start_item,
                $end_item,
                $total_posts
            );
            echo '</div>';
        }
    }
}
