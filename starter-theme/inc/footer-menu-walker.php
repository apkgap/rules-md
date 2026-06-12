<?php
/**
 * Custom Walker for Footer Menu with Accordion/Dropdown Support
 * 
 * This walker adds accordion functionality to WordPress menus
 * with parent items that can expand/collapse to show child items
 * 
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Footer_Accordion_Walker extends Walker_Nav_Menu
{

    /**
     * Start the element output (opening <li> tag)
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $classes[] = 'm-0';
        $classes[] = 'list-none';
        $classes[] = 'flex';
        $classes[] = 'flex-col';
        $classes[] = 'gap-[10px]';

        // Check if this item has children
        $has_children = in_array('menu-item-has-children', $classes);

        if ($has_children) {
            $classes[] = 'has-dropdown';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        // Add Alpine.js x-data to parent items with children
        $alpine_attr = '';
        if ($has_children && $depth === 0) {
            $alpine_attr = ' x-data="{ open: false }"';
        }

        $output .= $indent . '<li' . $id . $class_names . $alpine_attr . '>';

        // Build the link/button
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        // If has children, create accordion button + link wrapper
        if ($has_children && $depth === 0) {
            // Parent item with accordion - NO x-data here, it's on the <li>
            $output .= '<div class="flex items-center justify-between group">';

            // The link itself - clickable parent
            $output .= '<a' . $attributes . ' class="text-xs text-base hover:opacity-70 transition-all duration-200 flex-1 py-0 font-normal flex items-center gap-2">';
            // Remixicon Marker
            // $output .= '<i class="fas fa-chevron-right text-xs text-white group-hover:text-white/70 transition-colors"></i>';
            $output .= apply_filters('the_title', $item->title, $item->ID);
            $output .= '</a>';

            // Toggle button for accordion with Remixicon
            $output .= '<button @click="open = !open" type="button" class="ml-3 p-0 min-h-0 min-w-0 h-3 w-3 text-base hover:opacity-70 rounded-md bg-transparent border-none outline-none focus:outline-none transition-all duration-200 flex items-center justify-center shadow-none focus:ring-0 focus:ring-offset-0" :aria-expanded="open" aria-label="Toggle submenu">';
            $output .= '<i class="ri-arrow-down-s-line w-3 h-3 transition-transform duration-300 ease-out text-md"></i>';
            $output .= '</button>';

            $output .= '</div>';
        } else {
            // Regular link without accordion (child items or items without children)
            // Use flex to align icon and text
            $base_class = 'text-xs text-base hover:opacity-70 transition-all duration-200 py-1 font-normal flex items-center gap-2 group';

            $link_class = $depth === 0
                ? $base_class . ' hover:translate-x-1'
                : $base_class . ' pl-3 border-l-2 border-transparent hover:border-text-base/30 hover:pl-4 font-light';

            $output .= '<a' . $attributes . ' class="' . $link_class . '">';
            // Remixicon Marker
            // $output .= '<i class="fas fa-chevron-right text-xs text-white group-hover:text-white/70 transition-colors"></i>';
            $output .= apply_filters('the_title', $item->title, $item->ID);
            $output .= '</a>';
        }
    }

    /**
     * Start the submenu (opening <ul> tag for children)
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);

        // Wrap submenu in Alpine.js x-show for accordion effect with enhanced animation
        $output .= "\n$indent<ul class=\"mt-0 ml-0 space-y-1 overflow-hidden list-none pl-0\" 
            x-show=\"open\" 
            x-collapse 
            x-cloak
            style=\"display: none;\">\n";
    }

    /**
     * End the submenu (closing </ul> tag)
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
}

/**
 * Helper function to render footer menu with accordion support
 * 
 * @param string $location  Menu theme_location (used as fallback)
 * @param string $menu_id   Optional HTML id for the <ul> element
 * @param int    $wp_menu_id Optional WP menu ID (overrides theme_location)
 * @return void
 */
function render_footer_accordion_menu($location, $menu_id = '', $wp_menu_id = 0)
{
    if (empty($menu_id)) {
        $menu_id = 'footer-menu-' . $location;
    }

    $args = array(
        'container'   => false,
        'menu_class'  => 'space-y-0 footer-accordion-menu list-none pl-0 flex flex-col gap-[10px]',
        'menu_id'     => $menu_id,
        'fallback_cb'    => false,
        'walker'         => new Footer_Accordion_Walker(),
        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    );

    if ( ! empty( $wp_menu_id ) ) {
        // Use specific menu by WP menu ID (selected from admin)
        $args['menu'] = intval( $wp_menu_id );
        wp_nav_menu( $args );
    } elseif ( has_nav_menu( $location ) ) {
        // Fallback: use menu assigned to theme location
        $args['theme_location'] = $location;
        wp_nav_menu( $args );
    }
}
