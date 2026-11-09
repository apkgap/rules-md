# Elementor Widgets Guidelines

This document details the standards and rules for creating, customizing, and maintaining Elementor widgets in the `[project-slug]-elementor-addon` plugin.

> [!IMPORTANT]
> **No `card.php` in widgets.** All widget markup lives inside the widget class file — in `render()` (PHP, frontend) and `content_template()` (Underscore.js, editor preview). Do not split widget markup into `card.php`, do not use `set_query_var()` / `get_query_var()` / `include` to pass data into a widget template, and do not call `get_template_part()` from a widget.

## 1. Widget File Structure
Every widget must reside in `widgets/[widget-name]/` and contain **exactly 3 files**:

```
widgets/[widget-name]/
├── [widget-name].php   — Widget class (controls, query builder, render(), content_template())
├── [widget-name].css   — BEM styles + CSS variables (no hardcoded user-controllable layout)
└── [widget-name].js    — Frontend handler (elementor/frontend/init hook, dependency guarded)
```

- `[widget-name].js` is optional **only** if the widget has zero interactivity; if omitted, remove it from `get_script_depends()`.
- **Forbidden inside `widgets/[widget-name]/`**: `card.php`, `template.php`, `partials/`, or any other PHP file included at render time.
- Shared reusable logic (query helpers, term helpers, date formatting) belongs in a plugin `inc/` helper file or a base class/trait — **never** in a template partial.

## 2. Widget Naming Conventions
- **PHP class**: `[PROJECT-PREFIX]_Widget_[Pascal_Case_Slug]` (must match the dynamic resolver in §3, e.g. `starter-post-grid` → `STARTER_Widget_Starter_Post_Grid`).
- **`get_name()`**: identical to the folder slug (`[project-slug]-[widget-name]`).
- **CSS/JS handles**: `[project-slug]-[widget-name]`.
- **BEM Naming**: `.[project-slug]-[widget-name]__[element]--[modifier]`.
- **CSS variables**: `--[project-slug]-[widget-name]-[property]` (e.g. `--starter-post-grid-cols`).
- **Text domain**: always the plugin text domain (`[project-slug]-elementor-addon`) — never the theme's.

## 3. Widget Registration
All widget classes are registered dynamically in the plugin bootstrap file (`[project-slug]-elementor-addon.php`):

```php
public function register_widgets( $widgets_manager ) {
    $widgets = [
        'starter-hero',
        'starter-services',
        // Add more widget slugs here...
    ];

    foreach ( $widgets as $slug ) {
        $file = STARTER_PATH . "widgets/{$slug}/{$slug}.php";
        if ( ! file_exists( $file ) ) {
            continue;
        }
        require_once $file;

        // Dynamic class name resolving (e.g., STARTER_Widget_Starter_Hero)
        $class = '[PROJECT-PREFIX]_Widget_' . str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $slug ) ) );
        if ( class_exists( $class ) ) {
            $widgets_manager->register( new $class() );
        }
    }
}
```

## 4. Asset Registration (Per Widget)
- Register (not enqueue) assets on `wp_enqueue_scripts` and enqueue the CSS in the editor via `elementor/editor/after_enqueue_styles`.
- Declare assets **only** through `get_style_depends()` / `get_script_depends()` — never call `wp_enqueue_*()` inside `render()`.
- Version with `filemtime()` + fallback constant.

```php
add_action( 'wp_enqueue_scripts', function () {
    $base = 'widgets/[widget-name]/[widget-name]';
    $css  = STARTER_PATH . $base . '.css';
    $js   = STARTER_PATH . $base . '.js';

    wp_register_style( '[project-slug]-[widget-name]', STARTER_URL . $base . '.css', [], file_exists( $css ) ? filemtime( $css ) : STARTER_VERSION );
    wp_register_script( '[project-slug]-[widget-name]', STARTER_URL . $base . '.js', [ 'elementor-frontend' ], file_exists( $js ) ? filemtime( $js ) : STARTER_VERSION, true );
} );
```

## 5. Widget Class Anatomy
Every widget class must follow this order:

1. `ABSPATH` guard at the top of the file.
2. Meta methods: `get_name()`, `get_title()`, `get_icon()`, `get_categories()`, `get_keywords()`, `get_style_depends()`, `get_script_depends()`.
3. `protected function register_controls()` — Content tab sections first, then Style tab sections.
4. Private/protected helpers (`build_widget_query()`, `get_active_post_types()`, `get_card_data()` …).
5. `protected function render()` — PHP markup output (frontend).
6. `protected function content_template()` — Underscore.js markup (editor live preview).

## 6. Rendering Rules (Inline Card Markup)
- Card/item markup is written **inline** inside the loop in `render()` and mirrored in `content_template()`.
- If the card markup is large, extract it into a **private method of the same class** (e.g. `protected function render_card( array $card, array $settings ): void`) — never into a separate file.
- Prepare all data at the top of the loop (variables), then output pure markup below. No queries inside the markup block (use the pre-fetched values).
- Every repeated element gets a unique `id` built from the widget ID + item index/post ID, with `id` before `class`:
  ```php
  $widget_id = $this->get_id();
  // <article id="<?php echo esc_attr( "[project-slug]-[widget-name]-{$widget_id}-{$post_id}" ); ?>" class="...">
  ```
- Escape every output (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`). Icons rendered via `\Elementor\Icons_Manager::render_icon()`.
- Use `wp_get_attachment_image()` for images whenever an attachment ID is available.
- Whitelist dynamic tag names (e.g. `title_tag`) with `\Elementor\Utils::validate_html_tag()` before printing.
- Empty state: return early (nothing printed) on frontend; show a short notice only in edit mode (`\Elementor\Plugin::$instance->editor->is_edit_mode()`).

## 7. Dual-Rendering Synchronization Rule
Any change to tag hierarchy, class names, `id` patterns, `data-*` attributes, or conditional display inside `render()` **must** be applied identically in `content_template()`.

- Query widgets: `content_template()` renders 3 placeholder items with the exact same structure (or omit `content_template()` entirely so Elementor falls back to server-side `render()` — preferred for complex query widgets).
- Keep Underscore.js logic simple to avoid Elementor Safe Mode; use `{{ }}` (escaped) for text and `{{{ }}}` only for trusted HTML (icons, WYSIWYG).
- Use `elementor.helpers.renderIcon( view, icon, { 'aria-hidden': true }, 'i', 'object' )` for icons in the editor template.

## 8. CSS Rules & Editor Preview Compatibility
- **No Direct Layout Overwrites**: Do not hardcode `display`, `width`, `height`, `padding`, `gap` in the widget `.css` when an Elementor control exists for it — read a CSS variable with a fallback instead.
- **Scope**: every selector starts with the widget block class; all control selectors use `{{WRAPPER}}`.
- **Editor Preview Compatibility**: styles must work identically in the frontend and inside the Elementor editor iframe.
- **No grid+flex on the same class**; grid widgets default to `display: grid;` driven by `--[project-slug]-[widget-name]-cols`.
- **Dividers**: omit the last item border with `:not(:last-child)`.

## 9. Spacing Controls CSS Variable Pattern
- **Control Selector Pattern:** `'{{WRAPPER}} .[block]' => '--[project-slug]-[widget-name]-gap: {{SIZE}}{{UNIT}};'`
- **Stylesheet:** `gap: var(--[project-slug]-[widget-name]-gap, 1.5rem);`
- Do **not** duplicate control values into inline `style=""` attributes in `render()`; let the control selector write the variable.

## 10. Frontend JavaScript Pattern
```js
( function () {
    'use strict';

    const init = ( $scope ) => {
        const root = $scope[0].querySelector( '.[project-slug]-[widget-name]' );
        if ( ! root || root.dataset.initialized ) return;
        root.dataset.initialized = 'true';

        // Library guards
        // if ( ! window.Swiper ) return;

        let config;
        try { config = JSON.parse( root.dataset.config || '{}' ); } catch ( e ) { config = {}; }
        // ... interaction code
    };

    window.addEventListener( 'elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/[project-slug]-[widget-name].default', init );
    } );
} )();
```
- Scope all DOM queries to `$scope` (multiple instances per page).
- Guard against double init (editor re-renders).
- No inline `<script>` in widget markup; pass config via `data-config="<?php echo esc_attr( wp_json_encode( $config ) ); ?>"`.

## 11. Avoid Duplicate Widgets
Before creating a widget, review the catalog in §17 and the existing `widgets/` folder. Extend an existing widget with new controls (keeping old control IDs) instead of creating overlapping widgets.

## 12. Widget Creation Workflow (`create-elementor-widget.md`)
1. **Search Existing Widgets** — confirm no duplicate.
2. **Create 3 files** in `widgets/[widget-name]/` (`.php`, `.css`, `.js`) — **no `card.php`**.
3. **Register** the slug in the bootstrap `$widgets` array.
4. **Register assets** (§4) and declare them in `get_style_depends()` / `get_script_depends()`.
5. **Implement `render()`** with inline card markup, then mirror it in `content_template()`.
6. **Verify** frontend + Elementor editor (multiple instances, responsive controls, empty state).

## 13. Control Configuration Safety (Example: `ku-hero`)
* Repeater for stats: `stats_repeater_list`; responsive columns: `stats_columns`; item padding: `stat_item_padding`.
* Dividers: `show_stat_dividers`, `stat_divider_color`, `stat_divider_width`, `stat_divider_style`.
* Widths: `content_section_width`, `image_section_width`.
* **Never rename existing control IDs** — Elementor stores settings as JSON in post meta. Add a fallback when migration is unavoidable.

## 14. Migrating Legacy Widgets That Use `card.php`
1. Copy the `card.php` markup into the loop in `render()` (or a private `render_*()` method).
2. Replace `get_query_var( 'x' )` with the local loop variables; delete all `set_query_var()` calls.
3. Replace `get_template_part( 'template-parts/...' )` with inline markup owned by the widget (the plugin must not depend on theme partials).
4. Make sure `content_template()` matches the new markup.
5. Delete `card.php` and verify frontend + editor.

## 15. Widget Post & Taxonomy Query Pattern
When creating a widget that queries database records dynamically (e.g., custom post types, taxonomies, terms), follow these practices and helper methods to fetch settings and build secure queries.

### 15.1 Control Options Helpers
Use these helper methods inside the Widget class to populate Elementor Control options dynamically:

```php
/**
 * Get registered post types for Elementor select controls (excluding attachments).
 */
protected function get_active_post_types(): array {
    $post_types = get_post_types( [ 'public' => true ], 'objects' );
    $options    = [];
    foreach ( $post_types as $post_type ) {
        if ( 'attachment' === $post_type->name ) {
            continue;
        }
        $options[ $post_type->name ] = $post_type->label;
    }
    return $options;
}

/**
 * Get taxonomies of a specific post type.
 */
protected function get_taxonomies_by_post_type( string $post_type ): array {
    $taxonomies = get_object_taxonomies( $post_type, 'objects' );
    $options    = [];
    foreach ( $taxonomies as $taxonomy ) {
        $options[ $taxonomy->name ] = $taxonomy->label;
    }
    return $options;
}

/**
 * Get terms of a specific taxonomy.
 */
protected function get_taxonomy_terms( string $taxonomy ): array {
    if ( empty( $taxonomy ) ) {
        return [];
    }
    $terms   = get_terms( [
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
    ] );
    $options = [];
    if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
        foreach ( $terms as $term ) {
            $options[ $term->slug ] = $term->name;
        }
    }
    return $options;
}
```

### 15.2 Constructing and Executing Queries Safely
Construct `WP_Query` arguments strictly within the controller layer (never inside presentation partials). To support fully dynamic category/taxonomy filtering on custom widgets, loop over all public taxonomies to register Elementor control fields, then parse the settings into a dynamic `tax_query`:

```php
// Inside register_controls():
$taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );
if ( ! is_wp_error( $taxonomies ) && is_array( $taxonomies ) ) {
    foreach ( $taxonomies as $taxonomy ) {
        $terms = get_terms( [
            'taxonomy'   => $taxonomy->name,
            'hide_empty' => false,
        ] );

        $term_options = [];
        if ( ! is_wp_error( $terms ) && is_array( $terms ) ) {
            foreach ( $terms as $term ) {
                $term_options[ $term->slug ] = $term->name;
            }
        }

        if ( ! empty( $term_options ) ) {
            $this->add_control( 'tax_filter_' . $taxonomy->name, [
                'label'       => sprintf( esc_html__( 'Filter by %s', '[project-slug]-elementor-addon' ), $taxonomy->label ),
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'multiple'    => true,
                'options'     => $term_options,
                'label_block' => true,
                'condition'   => [
                    'query_post_type' => $taxonomy->object_type,
                ],
            ] );
        }
    }
}

// Inside render() or build_widget_query():
protected function build_widget_query( array $settings ): array {
    $post_type      = ! empty( $settings['query_post_type'] ) ? sanitize_key( $settings['query_post_type'] ) : 'post';
    $posts_per_page = ! empty( $settings['posts_per_page'] ) ? intval( $settings['posts_per_page'] ) : 6;

    $allowed_orderby = [ 'date', 'title', 'menu_order', 'rand', 'ID' ];
    $orderby_raw     = ! empty( $settings['orderby'] ) ? sanitize_text_field( $settings['orderby'] ) : 'date';
    $orderby         = in_array( $orderby_raw, $allowed_orderby, true ) ? $orderby_raw : 'date';

    $order_raw = ! empty( $settings['order'] ) ? strtoupper( sanitize_key( $settings['order'] ) ) : 'DESC';
    $order     = in_array( $order_raw, [ 'ASC', 'DESC' ], true ) ? $order_raw : 'DESC';

    $args = [
        'post_type'           => $post_type,
        'posts_per_page'      => $posts_per_page,
        'orderby'             => $orderby,
        'order'               => $order,
        'post_status'         => 'publish',
        'ignore_sticky_posts' => true,
    ];

    // Build tax_query dynamically based on selected terms
    $tax_query  = [];
    $taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );
    if ( ! is_wp_error( $taxonomies ) && is_array( $taxonomies ) ) {
        foreach ( $taxonomies as $taxonomy ) {
            $control_key = 'tax_filter_' . $taxonomy->name;
            if ( ! empty( $settings[ $control_key ] ) && is_array( $settings[ $control_key ] ) ) {
                $tax_query[] = [
                    'taxonomy' => $taxonomy->name,
                    'field'    => 'slug',
                    'terms'    => array_map( 'sanitize_key', $settings[ $control_key ] ),
                    'operator' => 'IN',
                ];
            }
        }
    }

    if ( count( $tax_query ) > 1 ) {
        $tax_query['relation'] = 'AND';
    }

    if ( ! empty( $tax_query ) ) {
        $args['tax_query'] = $tax_query;
    }

    return $args;
}
```

### 15.3 Rendering and Dual-Rendering Synchronization (`render` & `content_template`)
Inside the PHP `render()` method, retrieve the post query and output the card HTML layout directly inside the class (never via `card.php`). Then implement the identical HTML layout inside `content_template()` using Underscore.js syntax to ensure real-time preview matches:

```php
protected function render() {
    $settings   = $this->get_settings_for_display();
    $query_args = $this->build_widget_query( $settings );
    $query      = new \WP_Query( $query_args );
    $widget_id  = $this->get_id();

    if ( $query->have_posts() ) {
        // ID comes before class
        echo '<div id="' . esc_attr( 'exat-post-custom-query-' . $widget_id ) . '" class="exat-post-custom-query__grid">';

        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id      = get_the_ID();
            $title        = get_the_title();
            $permalink    = get_permalink();
            $excerpt      = get_the_excerpt();
            $thumb_id     = get_post_thumbnail_id( $post_id );
            $show_excerpt = 'yes' === ( $settings['show_excerpt'] ?? '' );
            ?>
            <article id="<?php echo esc_attr( "exat-post-card-{$widget_id}-{$post_id}" ); ?>" class="exat-post-custom-query__card">
                <?php if ( $thumb_id ) : ?>
                    <div class="exat-post-custom-query__card-image-wrapper">
                        <a href="<?php echo esc_url( $permalink ); ?>">
                            <?php
                            echo wp_get_attachment_image(
                                $thumb_id,
                                'medium_large',
                                false,
                                [
                                    'class' => 'exat-post-custom-query__card-image',
                                    'alt'   => esc_attr( $title ),
                                ]
                            );
                            ?>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="exat-post-custom-query__card-content">
                    <h3 class="exat-post-custom-query__card-title">
                        <a href="<?php echo esc_url( $permalink ); ?>">
                            <?php echo esc_html( $title ); ?>
                        </a>
                    </h3>

                    <?php if ( $show_excerpt && ! empty( $excerpt ) ) : ?>
                        <div class="exat-post-custom-query__card-excerpt">
                            <p><?php echo wp_kses_post( $excerpt ); ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="exat-post-custom-query__card-meta">
                        <span class="exat-post-custom-query__card-date">
                            <?php echo esc_html( get_the_date( '', $post_id ) ); ?>
                        </span>
                    </div>
                </div>
            </article>
            <?php
        }

        echo '</div>';

        // CRITICAL: Reset post data to prevent breaks in WordPress global loop
        wp_reset_postdata();
    } else {
        // Fallback state if no posts match query
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
            echo '<div class="elementor-no-posts-found">' . esc_html__( 'No posts found matching the query.', '[project-slug]-elementor-addon' ) . '</div>';
        }
    }
}

protected function content_template() {
    ?>
    <# if ( settings.query_post_type ) { #>
        <div id="exat-post-custom-query-{{ view.getID() }}" class="exat-post-custom-query__grid">
            <# for ( var i = 0; i < 3; i++ ) { #>
                <article id="exat-post-card-{{ view.getID() }}-{{ i }}" class="exat-post-custom-query__card">
                    <div class="exat-post-custom-query__card-image-wrapper">
                        <a href="#">
                            <div class="exat-post-custom-query__card-image" style="background: #e5e7eb; display: flex; align-items: center; justify-content: center;">
                                <span style="color: #6b7280; font-size: 0.875rem;"><?php esc_html_e( 'Preview Image', '[project-slug]-elementor-addon' ); ?></span>
                            </div>
                        </a>
                    </div>

                    <div class="exat-post-custom-query__card-content">
                        <h3 class="exat-post-custom-query__card-title">
                            <a href="#"><?php esc_html_e( 'Simulated Post Title', '[project-slug]-elementor-addon' ); ?> #{{ i + 1 }}</a>
                        </h3>

                        <# if ( settings.show_excerpt === 'yes' ) { #>
                            <div class="exat-post-custom-query__card-excerpt">
                                <p><?php esc_html_e( 'This is a simulated post excerpt template for the Elementor editor preview.', '[project-slug]-elementor-addon' ); ?></p>
                            </div>
                        <# } #>

                        <div class="exat-post-custom-query__card-meta">
                            <span class="exat-post-custom-query__card-date">
                                <?php echo esc_html( date( 'Y-m-d' ) ); ?>
                            </span>
                        </div>
                    </div>
                </article>
            <# } #>
        </div>
    <# } #>
    <?php
}
```

## 16. Responsive Grid Layout Controls Pattern
To support dynamic columns across multiple devices, avoid writing device-specific hardcoded CSS grid media queries. Instead, utilize Elementor's native `add_responsive_control` to assign column counts to a custom CSS variable mapped dynamically to the wrapper.

### 16.1 Control Schema Definition (PHP)
Register the column layout control using the responsive structure:

```php
$this->add_responsive_control(
    'columns',
    [
        'label'          => esc_html__( 'Columns', '[project-slug]-elementor-addon' ),
        'type'           => \Elementor\Controls_Manager::SELECT,
        'default'        => '3',
        'tablet_default' => '2',
        'mobile_default' => '1',
        'options'        => [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
        ],
        // Dynamically override a CSS variable for the active device width
        'selectors'      => [
            '{{WRAPPER}} .[project-slug]-[widget-name]__grid' => '--[project-slug]-[widget-name]-cols: {{VALUE}};',
        ],
    ]
);
```

### 16.2 Grid Implementation (CSS)
Map the columns selector dynamically in your widget's stylesheet:

```css
.[project-slug]-[widget-name]__grid {
    display: grid;
    /* Uses the responsive CSS variable from controls, falling back to 3 columns */
    grid-template-columns: repeat(var(--[project-slug]-[widget-name]-cols, 3), minmax(0, 1fr));
    gap: var(--[project-slug]-[widget-name]-gap, 1.5rem);
}
```

## 17. Available Widgets Map (15 total)
- `career-archive-tabs`: Tabs for switching career post categories with localized search filters.
- `hero-slider`: Homepage hero banner slider (slides, descriptions, backgrounds, links).
- `icon-grid-custom`: Structured features grid with icons and links.
- `icon-info-grid`: Corporate highlight blocks with top icon headers.
- `parallax-hero`: Top hero banner with parallax background.
- `parallax-image`: Single image block with parallax motion.
- `post-carousel`: Query posts rendered as cards in a carousel.
- `post-icon-grid`: Post types rendered inside icon grids.
- `post-query-split`: Primary post card + secondary title list.
- `post-tabs-slider`: Tabbed CPT filter with Swiper columns.
- `service-grid`: Company services grid with icons.
- `smart-card-repeater`: Custom cards from an Elementor repeater.
- `split-text-image`: Two-column text + image block.
- `strategic-highlights`: Metrics/highlights grid.
- `strategic-timeline`: Chronological milestones timeline.

> All widgets above render their card/item markup inline in `render()` / `content_template()` — none use `card.php`.
