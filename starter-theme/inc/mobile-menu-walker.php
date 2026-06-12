<?php

/**
 * Mobile Menu Walker (Drilldown / Step Style)
 *
 * Each sub-menu panel uses a hardcoded x-show condition based on
 * the SPECIFIC parent item ID, not a shared dynamic variable.
 * This prevents all sub-menus from opening at once.
 *
 * @package starter_theme
 */

class Mobile_Menu_Walker extends Walker_Nav_Menu
{
    /**
     * Tracks the ID of the last parent item rendered,
     * so start_lvl() knows which sub-menu it belongs to.
     */
    private int $current_parent_id = 0;

    /**
     * Start Level (ul.sub-menu)
     * Uses hardcoded parent ID in x-show to avoid shared-variable bug.
     */
    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $pid = $this->current_parent_id;

        // Each panel checks its OWN specific ID - not the shared parentId variable
        $output .= '<div x-show="view === \'menu-' . $pid . '\'"
                         x-cloak
                         class="absolute inset-0 bg-bg-base border border-border-base rounded-2xl p-2 z-20 transition-colors duration-500">';

        // Back Button
        $output .= '<button @click="view = \'main\'" class="flex items-center gap-2 text-muted mb-3 px-3 py-1.5 text-base hover:text-base transition-colors bg-transparent border-0 cursor-pointer w-full text-left">
						<span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-left-s-line"></i></span>
                        <span class="text-xs uppercase tracking-widest font-display font-normal transition-colors duration-500">ย้อนกลับ</span>
                    </button>';

        $output .= '<ul class="space-y-0.5 p-0 m-0 list-none">';
    }


    function end_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '</ul></div>';
    }

    /**
     * Start Element (li / a)
     */
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $classes       = empty($item->classes) ? [] : (array) $item->classes;
        $has_children  = in_array('menu-item-has-children', $classes);
        $is_active     = (bool) array_intersect(
            array(
                'current-menu-item',
                'current-menu-parent',
                'current-menu-ancestor',
                'current_page_item',
                'current_page_parent',
                'current_page_ancestor',
            ),
            $classes
        );

        // Store this item's ID so start_lvl() can reference it
        if ($has_children) {
            $this->current_parent_id = $item->ID;
        }

        $output .= '<li class="list-none m-0 p-0">';

        $atts = [
            'title'  => $item->attr_title ?? '',
            'target' => $item->target     ?? '',
            'rel'    => $item->xfn        ?? '',
            'href'   => $item->url        ?? '',
        ];

        // White theme link style
        $link_class = 'flex items-center justify-between w-full rounded-full px-[20px] py-[10px] text-base font-display font-normal text-starter-text-black no-underline transition-all duration-200 group hover:bg-starter-surface-primary-subdued hover:text-starter-text-primary';
        if ($has_children) {
            $link_class .= ' flex-1';
        }
        if ($is_active) {
            $link_class .= ' bg-starter-surface-primary-subdued text-starter-text-primary';
        }
        $atts['class'] = $link_class;

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if ($value !== '') {
                $value       = ($attr === 'href') ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);

        if ($has_children) {
            $output .= '<div class="flex w-full items-center justify-between gap-3">';
            $output .= '<a' . $attributes . '>';
            $output .= '<span class="font-display text-base font-normal leading-tight tracking-tight ">' . $title . '</span>';
            $output .= '</a>';
            $output .= '<button type="button" @click.stop.prevent="view = \'menu-' . esc_attr($item->ID) . '\'" class="w-8 h-8 flex items-center justify-center rounded-full text-starter-text-primary transition-all duration-200 hover:bg-starter-surface-primary-subdued hover:translate-x-0.5" aria-label="' . esc_attr($title) . '">';
            $output .= '<span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-s-line"></i></span>';
            $output .= '</button>';
            $output .= '</div>';
        } else {
            $output .= '<a' . $attributes . '>';
            $output .= '<span class="font-display text-base font-normal leading-tight tracking-tight ">' . $title . '</span>';
            $output .= '</a>';
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= '</li>';
    }
}
