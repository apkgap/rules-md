<?php
/**
 * Footer Bottom Toggle Walker
 *
 * A custom Walker class for a toggle-style footer menu using Alpine.js.
 * This walker allows menu items to have dropdowns/accordions controlled by Alpine.js.
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if (!class_exists('Footer_Bottom_Toggle_Walker')) {
    class Footer_Bottom_Toggle_Walker extends Walker_Nav_Menu
    {

        // Start Level (ul.sub-menu)
        function start_lvl(&$output, $depth = 0, $args = null)
        {
            $classes = array('sub-menu', 'pl-4', 'mt-2', 'flex', 'flex-col', 'gap-[5px]', 'list-none');

            // Alpine.js control for submenu visibility
            // Matches parent's 'open' state
            $alpine_attrs = 'x-show="open" x-collapse x-cloak';

            $class_names = join(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));
            $output .= "\n<ul class=\"$class_names\" $alpine_attrs style=\"display: none;\">\n";
        }

        // Start Element (li)
        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
        {
            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;
            $classes[] = 'm-0';
            $classes[] = 'list-none';
            $classes[] = 'flex';
            $classes[] = 'flex-col';

            $has_children = in_array('menu-item-has-children', $classes);

            // Filter classes
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            // Alpine.js data attribute for parent items
            $alpine_data = $has_children ? 'x-data="{ open: false }"' : '';

            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= "<li$id$class_names $alpine_data>";

            $atts = array();
            $atts['title']  = ! empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = ! empty($item->target)     ? $item->target     : '';
            $atts['rel']    = ! empty($item->xfn)        ? $item->xfn        : '';
            $atts['href']   = ! empty($item->url)        ? $item->url        : '';

            // Base link style matching the other walker
            $atts['class']  = 'text-sm lg:text-base font-normal hover:opacity-70 transition-all duration-200 py-1 flex items-center gap-2 group';

            // Toggle behavior for parent items
            if ($has_children) {
                $atts['@click.prevent'] = 'open = !open';
                $atts['class'] .= ' justify-between w-full cursor-pointer';
            }

            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (! empty($value)) {
                    $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $title = apply_filters('the_title', $item->title, $item->ID);
            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . $title . $args->link_after;

            // Add toggle icon if has children
            if ($has_children) {
                $item_output .= '<i class="ri-arrow-down-s-line transition-transform duration-300 ease-out text-md" :class="open ? \'rotate-180\' : \'\'"></i>';
            }

            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= $item_output;
        }
    }
}
