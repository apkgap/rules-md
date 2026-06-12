<?php
/**
 * Custom Menu Walker for the Header Navigation.
 * Uses Alpine.js hover state instead of CSS group-hover
 * to reliably show/hide sub-menus.
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Header_Menu_Walker extends Walker_Nav_Menu
{
    private array $submenu_context = [];
    private ?string $active_mega_variant = null;
    private int $current_mega_parent_id = 0;

    /**
     * Starts the sub-menu list.
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $context = $this->submenu_context[$depth] ?? null;
        $variant = is_array($context) ? ($context['variant'] ?? null) : null;

        if ($depth === 0 && ($variant === 'mega-1' || $variant === 'mega-2' || $variant === 'mega-3')) {
            $this->active_mega_variant = $variant;

            // Full width panel classes
            $panel_classes = 'absolute top-full left-0 right-0 w-full bg-surface-base backdrop-blur-md shadow-xl z-50 border-t border-border-base transition-colors duration-500';

            if ($variant === 'mega-3') {
                $panel_classes .= ' starter-theme-mega starter-theme-mega--3';
            } else {
                $panel_classes .= $variant === 'mega-2' ? ' starter-theme-mega starter-theme-mega--2' : ' starter-theme-mega starter-theme-mega--1';
            }

            $output .= "\n<div class=\"" . esc_attr($panel_classes) . "\""
                . " x-show=\"open\" x-cloak"
                . " x-transition:enter=\"transition ease-out duration-200\""
                . " x-transition:enter-start=\"opacity-0 translate-y-2\""
                . " x-transition:enter-end=\"opacity-100 translate-y-0\""
                . " x-transition:leave=\"transition ease-in duration-150\""
                . " x-transition:leave-start=\"opacity-100 translate-y-0\""
                . " x-transition:leave-end=\"opacity-0 translate-y-2\""
                . " style=\"display:none;\""
                . ">\n";

            // Inner container to align with content
            $inner_classes = 'starter-theme-mega__inner container mx-auto grid grid-cols-12 gap-6 p-6';
            $output .= "<div class=\"" . esc_attr($inner_classes) . "\">\n";

            if ($variant === 'mega-1') {
                $image_url = is_array($context) ? ($context['image'] ?? '') : '';
                $image_url = is_string($image_url) ? trim($image_url) : '';
                $image_url = filter_var($image_url, FILTER_VALIDATE_URL) ? $image_url : '';
                $title = is_array($context) && isset($context['title']) && is_string($context['title']) ? $context['title'] : '';

                $output .= "<div class=\"col-span-12 lg:col-span-4 xl:col-span-4\">\n";
                if ($title !== '') {
                    $output .= "<div class=\"text-xs uppercase tracking-wider font-bold text-base mb-4 px-2\">" . esc_html($title) . "</div>\n";
                }

                if ($image_url) {
                    $output .= "<div class=\"w-full aspect-[4/3] rounded-xl bg-bg-base bg-cover bg-center\" style=\"background-image:url(" . esc_url($image_url) . ");\"></div>\n";
                } else {
                    $output .= "<div class=\"w-full aspect-[4/3] rounded-xl bg-gradient-to-br from-primary/10 to-secondary/10\"></div>\n";
                }
                $output .= "</div>\n";

                $output .= "<div class=\"col-span-12 lg:col-span-8 xl:col-span-8 relative min-h-[300px]\">\n";
                $output .= "<ul class=\"sub-menu starter-theme-mega__list flex flex-col items-start gap-1 w-full lg:w-[42%] pr-4 border-r border-border-base\" x-data=\"{ active: null }\" @click.away=\"active = null\" @keydown.escape.window=\"active = null\">\n";
                return;
            }

            if ($variant === 'mega-3') {
                $title = is_array($context) && isset($context['title']) && is_string($context['title']) ? $context['title'] : '';

                $output .= "<div class=\"col-span-12 py-2\">\n";
                if ($title !== '') {
                    $output .= "<div class=\"text-[15px] font-bold text-base uppercase tracking-wider mb-4\">" . esc_html($title) . "</div>\n";
                }
                $output .= "<ul class=\"sub-menu starter-theme-mega__grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 list-none p-0 m-0 w-full\">\n";
                return;
            }

            // mega-2
            $output .= "<div class=\"col-span-12 relative min-h-[400px]\">\n";
            $output .= "<ul class=\"sub-menu starter-theme-mega__list flex flex-col items-start gap-2 w-full lg:w-1/3 pr-8 border-r border-border-base\" x-data=\"{ active: null }\" @click.away=\"active = null\" @keydown.escape.window=\"active = null\">\n";
            return;
        }

        // Mega flyout submenu (submenu of depth-1 items)
        if ($depth === 1 && ($this->active_mega_variant === 'mega-1' || $this->active_mega_variant === 'mega-2')) {
            $parent_id = $this->current_mega_parent_id;
            $left_pos = ($this->active_mega_variant === 'mega-2') ? 'lg:left-1/3 lg:w-2/3' : 'lg:left-[42%] lg:w-[58%]';

            $output .= "\n<ul class=\"sub-menu starter-theme-mega__submenu absolute top-0 $left_pos pl-6 h-full z-[60]\""
                . " x-show=\"active === $parent_id\" x-cloak"
                . " x-transition:enter=\"transition ease-out duration-200\""
                . " x-transition:enter-start=\"opacity-0 translate-x-2\""
                . " x-transition:enter-end=\"opacity-100 translate-x-0\""
                . " x-transition:leave=\"transition ease-in duration-150\""
                . " x-transition:leave-start=\"opacity-100 translate-x-0\""
                . " x-transition:leave-end=\"opacity-0 translate-x-2\""
                . " style=\"display:none;\""
                . ">\n";
            return;
        }

        if ($depth >= 2 && ($this->active_mega_variant === 'mega-1' || $this->active_mega_variant === 'mega-2')) {
            $output .= "\n<ul class=\"sub-menu ml-4 mt-1 space-y-1 border-l border-border-base pl-4 w-full\""
                . " x-show=\"open_sub\" x-cloak"
                . " x-transition:enter=\"transition ease-out duration-200\""
                . " x-transition:enter-start=\"opacity-0 -translate-y-1\""
                . " x-transition:enter-end=\"opacity-100 translate-y-0\""
                . " style=\"display:none;\""
                . ">\n";
            return;
        }

        $output .= "\n<ul class=\"sub-menu absolute top-full left-0 mt-0 p-2 m-0 list-none flex flex-col gap-0.5 bg-surface-base backdrop-blur-md shadow-2xl rounded-xl min-w-[220px] z-50 border border-border-base transition-colors duration-500\""
            . " x-show=\"open\" x-cloak"
            . " x-transition:enter=\"transition ease-out duration-200\""
            . " x-transition:enter-start=\"opacity-0 translate-y-2\""
            . " x-transition:enter-end=\"opacity-100 translate-y-0\""
            . " x-transition:leave=\"transition ease-in duration-150\""
            . " x-transition:leave-start=\"opacity-100 translate-y-0\""
            . " x-transition:leave-end=\"opacity-0 translate-y-2\""
            . " style=\"display:none;\""
            . ">\n";
    }

    /**
     * Ends the sub-menu list.
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $context = $this->submenu_context[$depth] ?? null;
        $variant = is_array($context) ? ($context['variant'] ?? null) : null;

        if ($depth === 0 && ($variant === 'mega-1' || $variant === 'mega-2' || $variant === 'mega-3')) {
            $output .= "</ul>\n";
            if ($variant === 'mega-3') {
                $output .= "</div>\n"; // close col-12
            } else {
                // close content col
                $output .= "</div>\n";
                // close inner grid
                $output .= "</div>\n";
            }
            // close panel
            $output .= "</div>\n";
            unset($this->submenu_context[$depth]);
            $this->active_mega_variant = null;
            return;
        }

        $output .= "</ul>\n";
    }

    /**
     * Starts each menu item element.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $classes      = empty($item->classes) ? [] : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        $is_active    = in_array('current-menu-item', $classes);

        $classes[] = 'menu-item-' . $item->ID;

        // Pre-determine mega variant to know if we need static positioning
        $variant = null;
        if ($has_children && $depth === 0) {
            $meta_variant = isset($item->starter_theme_mega_type) && is_string($item->starter_theme_mega_type) ? $item->starter_theme_mega_type : '';
            if ($meta_variant === 'mega-1' || $meta_variant === 'mega-2' || $meta_variant === 'mega-3') {
                $variant = $meta_variant;
            } elseif (in_array('mega-1', $classes, true)) {
                $variant = 'mega-1';
            } elseif (in_array('mega-2', $classes, true)) {
                $variant = 'mega-2';
            } elseif (in_array('mega-3', $classes, true)) {
                $variant = 'mega-3';
            }
        }

        // Wrap items that have children with Alpine hover scope
        $is_mega_depth1 = $depth === 1 && ($this->active_mega_variant === 'mega-1' || $this->active_mega_variant === 'mega-2');
        $is_mega_top = ($depth === 0 && $variant !== null);
        $classes[] = 'list-none m-0 w-full ' . (($is_mega_depth1 || $is_mega_top) ? 'static' : 'relative');

        if ($has_children && $depth === 0) {
            $classes[] = 'h-full flex items-center';
            $li_extra   = ' x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false"';

            if ($variant) {
                $meta_image_id = isset($item->starter_theme_mega_image_id) ? $item->starter_theme_mega_image_id : 0;
                $meta_image_id = is_numeric($meta_image_id) ? (int) $meta_image_id : 0;

                $meta_image = '';
                if ($meta_image_id > 0) {
                    $resolved = wp_get_attachment_image_url($meta_image_id, 'large');
                    if (is_string($resolved)) {
                        $meta_image = $resolved;
                    }
                }

                if ($meta_image === '') {
                    $meta_image = isset($item->starter_theme_mega_image) && is_string($item->starter_theme_mega_image) ? $item->starter_theme_mega_image : '';
                }

                $fallback_image = is_string($item->description ?? null) ? $item->description : '';

                $this->submenu_context[$depth] = [
                    'variant' => $variant,
                    'image' => $meta_image !== '' ? $meta_image : $fallback_image,
                    'title' => is_string($item->title ?? null) ? $item->title : '',
                ];
            }
        } elseif ($has_children && $depth === 1 && ($this->active_mega_variant === 'mega-1' || $this->active_mega_variant === 'mega-2')) {
            // Mega vertical items: click row to open flyout submenu (shared state on list)
            $this->current_mega_parent_id = (int) $item->ID;
            $classes[] = 'starter-theme-mega__item';
            $classes[] = 'starter-theme-mega__item--has-children';
            $li_extra = '';
        } elseif ($has_children && $depth >= 2 && ($this->active_mega_variant === 'mega-1' || $this->active_mega_variant === 'mega-2')) {
            // Nested items within the flyout: accordion style
            $classes[] = 'menu-item-has-submenu-nested';
            $li_extra = ' x-data="{ open_sub: false }"';
        } else {
            $li_extra = '';
        }

        // Control li spacing: Mega menu items should be tight (p-0), 
        // while normal dropdown items need padding for better layout.
        $is_in_mega = ($this->active_mega_variant !== null);

        if ($depth === 0) {
            // Top level items: always need a little horizontal gap
            $classes[] = 'h-full flex items-center px-2';
            $classes[] = 'p-0 h-auto'; // Reset vertical padding for flex centering
        } else {
            if ($is_in_mega) {
                $classes[] = 'p-0 px-0 h-auto';
            } else {
                $classes[] = 'p-0 h-auto'; // Normal dropdowns shouldn't have padding on <li> (the <a> handles it)
            }
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names . $li_extra . '>';

        // Build link attributes
        $atts = [
            'title'  => $item->attr_title ?? '',
            'target' => $item->target     ?? '',
            'rel'    => $item->xfn        ?? '',
            'href'   => $item->url        ?? '',
        ];

        $is_home = is_front_page();

        if ($depth === 0) {
            $atts['class'] = 'header-nav-link flex items-center gap-1 transition-all duration-300 font-display font-medium text-sm whitespace-nowrap h-full py-4 text-base hover:opacity-70';
        } else {
            // Submenu item
            if ($depth === 1 && ($this->active_mega_variant === 'mega-1' || $this->active_mega_variant === 'mega-2')) {
                $atts['class'] = 'starter-theme-mega__link group flex items-center justify-between gap-3 py-2.5 px-4 text-xs font-display font-medium text-base w-full hover:bg-text-base/5 rounded-xl transition-all';
                $atts[':class'] = "active === " . (int)$item->ID . " ? 'bg-text-base/10' : ''";
            } elseif ($depth === 1 && $this->active_mega_variant === 'mega-3') {
                $atts['class'] = 'starter-theme-mega__grid-link block group transition-all duration-300 transform hover:-translate-y-1';
            } elseif ($depth >= 2 && ($this->active_mega_variant === 'mega-1' || $this->active_mega_variant === 'mega-2')) {
                $atts['class'] = 'flex items-center justify-between py-2 px-4 text-xs font-display text-base hover:bg-text-base/5 rounded-lg transition-all duration-200 font-medium w-full';
            } else {
                $atts['class'] = 'block py-2.5 px-4 text-xs font-display text-base hover:bg-text-base/5 rounded-lg transition-all duration-200 font-medium whitespace-nowrap w-full';
            }
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if ($value !== '') {
                $value       = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);

        $item_output  = $args->before;

        if ($is_mega_depth1 && $has_children && $this->active_mega_variant !== 'mega-3') {
            $toggle = 'active = active === ' . (int) $item->ID . ' ? null : ' . (int) $item->ID;
            $item_output .= '<a' . $attributes . ' @click.prevent.stop="' . $toggle . '">';
            $item_output .= '<span>' . $args->link_before . $title . $args->link_after . '</span>';
            $item_output .= '<span class="w-3 h-3 transition-transform duration-300 flex items-center justify-center" :class="(active === ' . (int) $item->ID . ') ? \'rotate-90\' : \'\'"><i class="ri-arrow-right-s-line"></i></span>';
            $item_output .= '</a>';
        } elseif ($depth >= 2 && $has_children && ($this->active_mega_variant === 'mega-1' || $this->active_mega_variant === 'mega-2')) {
            $item_output .= '<a' . $attributes . ' @click.prevent.stop="open_sub = !open_sub">';
            $item_output .= '<span>' . $args->link_before . $title . $args->link_after . '</span>';
            $item_output .= '<span class="w-3 h-3 opacity-50 transition-transform flex items-center justify-center" :class="open_sub ? \'rotate-180\' : \'\'"><i class="ri-arrow-down-s-line"></i></span>';
            $item_output .= '</a>';
        } elseif ($depth === 1 && $this->active_mega_variant === 'mega-3') {
            // Get subitem image
            $image_id = get_post_meta($item->ID, '_starter_theme_mega_image_id', true);
            $image_url = '';
            if (is_numeric($image_id) && (int)$image_id > 0) {
                $image_url = wp_get_attachment_image_url((int)$image_id, 'large');
            }
            if (!$image_url) {
                $image_url = get_post_meta($item->ID, '_starter_theme_mega_image', true);
            }

            $item_output .= '<a' . $attributes . '>';
            $item_output .= '<div class="space-y-3">';

            // Image area
            if ($image_url) {
                $item_output .= '<div class="w-full aspect-4/3 rounded-xl bg-cover bg-center shadow-sm border border-border-base group-hover:shadow-md transition-shadow" style="background-image:url(' . esc_url($image_url) . ');"></div>';
            } else {
                $item_output .= '<div class="w-full aspect-4/3 rounded-xl bg-surface-base flex items-center justify-center border border-border-base"><span class="w-6 h-6 text-base/20 flex items-center justify-center"><i class="ri-image-line"></i></span></div>';
            }

            // Text area
            $item_output .= '<div class="flex items-start justify-between group-hover:opacity-70 transition-colors gap-2">';
            $item_output .= '<span class="text-[15px] font-bold text-base transition-colors leading-snug line-clamp-2">' . $args->link_before . $title . $args->link_after . '</span>';
            $item_output .= '<span class="w-5 h-5 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all shrink-0 mt-0.5 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>';
            $item_output .= '</div>';

            $item_output .= '</div>';
            $item_output .= '</a>';
        } else {
            $item_output .= '<a' . $attributes . '>';
            $item_output .= '<span>' . $args->link_before . $title . $args->link_after . '</span>';
            if ($is_mega_depth1) {
                $item_output .= '<span class="w-3 h-3 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 text-base flex items-center justify-center"><i class="ri-arrow-right-s-line"></i></span>';
            }
            $item_output .= '</a>';
        }

        if ($has_children && $depth === 0) {
            $item_output .= '<span class="w-3 h-3 transition-transform duration-300 text-base pl-1 flex items-center justify-center" :class="open ? \'rotate-180\' : \'\'"><i class="ri-arrow-down-s-line"></i></span>';
        }

        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= "</li>\n";
    }
}
