<?php
/**
 * Simple Footer Menu Walker
 *
 * Basic menu walker without dropdown/accordion toggle functionality.
 * Use this for simple flat menus (no submenus).
 *
 * @package starter_theme
 */

if (!class_exists('Footer_Simple_Walker')) {
    class Footer_Simple_Walker extends Walker_Nav_Menu
    {
        /**
         * Start the element output.
         */
        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
        {
            $classes     = empty($item->classes) ? array() : (array) $item->classes;
            $classes[]   = 'menu-item-' . $item->ID;
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $output .= '<li' . $class_names . '>';

            $atts           = array();
            $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = !empty($item->target)     ? $item->target     : '';
            $atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';
            $atts['href']   = !empty($item->url)        ? $item->url        : '';

            // Simple link style
            $atts['class'] = 'text-[13px] text-white hover:opacity-70 transition-all duration-200 py-1 font-normal no-underline';

            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value       = ('href' === $attr) ? esc_url($value)       : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $item_output  = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

        /**
         * Ends the element output.
         */
        function end_el(&$output, $item, $depth = 0, $args = null)
        {
            $output .= "</li>\n";
        }
    }
}
