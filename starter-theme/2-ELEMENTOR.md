# Elementor Widgets Guidelines

This document details the standards and rules for creating, customizing, and maintaining Elementor widgets in the `[project-slug]-elementor-addon` plugin.

## 1. Widget File Structure
Every widget must reside in `widgets/[widget-name]/` and contain exactly 4 files:
- `[widget-name].php` (Widget class extending `\Elementor\Widget_Base`)
- `card.php` (Presentation template)
- `[widget-name].css` (BEM styles)
- `[widget-name].js` (Asset scripts)

## 2. Widget Naming Conventions
- **PHP class**: `[PROJECT-PREFIX]_[PascalCase]_Widget`
- **CSS/JS handles**: `[project-slug]-[widget-name]`
- **BEM Naming**: CSS class naming must follow: `.[project-slug]-[widget-name]__[element]--[modifier]`

## 3. Widget Registration
All widget classes must be registered dynamically in the plugin bootstrap file (`[project-slug]-elementor-addon.php`) using a loop to resolve widget filenames and class names dynamically, reducing boilerplate:

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


## 4. Dual-Rendering Synchronization Rule
When editing layout structure, element selectors, tag hierarchies, or class names inside the PHP `render()` function of a widget, you must apply the exact same modifications to the JavaScript `content_template()` function. This prevents rendering discrepancies between the front-end production template and the backend Elementor editor preview.

## 5. Card Template Rules
- `card.php` is strictly presentation-only.
- It must receive data via `get_query_var()` and perform no database queries or business logic.
- **Exception for Query Widgets**: For widgets that perform custom queries, do NOT use a separate `card.php` file. Instead, render the card HTML layout directly inside the widget's PHP class file (both in `render()` and `content_template()`). This prevents rendering issues and ensures full compatibility with Elementor's real-time editor preview.


## 6. CSS Rules & Editor Preview Compatibility
- **No Direct Layout Overwrites**: Avoid defining hardcoded structural dimensions or position styles—such as `display`, `width`, `height`, or `padding`—directly inside widget core stylesheets (`.css`) if these properties are configurable via user controls in Elementor. This permits CSS variables and Elementor wrapper selectors to govern layout geometry and responsiveness correctly.
- **Editor Preview Compatibility**: All widget stylesheets and custom selectors must be designed to function correctly within both the frontend display and the back-end Elementor Editor preview workspace (handling wrapper selector class overrides seamlessly).

## 7. Spacing Controls CSS Variable Pattern
When configuring Elementor layout controls for custom spacing (such as gap, margin, or padding), output these properties using CSS variables rather than declaring hardcoded CSS rules. This guarantees seamless style synchronization and real-time updates across both the front-end PHP template render and the Elementor editor JavaScript template.
- **Control Selector Pattern:** `{{WRAPPER}} .selector { --custom-variable: {{SIZE}}{{UNIT}}; }`
- **HTML Markup Inline Style Pattern:** `style="padding: var(--custom-variable, default-value);"`

## 8. Avoid Duplicate Widgets
Before creating new widgets, review existing widgets to determine if their functionality can be extended. Avoid duplicate widgets with overlapping layouts and purposes.

## 9. Available Widgets Map (15 total)
- `career-archive-tabs`: Renders tabs for switching career post categories with localized search filters.
- `hero-slider`: Homepage hero banner slider showing slides, slide descriptions, background images, and links.
- `icon-grid-custom`: Layout displaying structured features inside a grid layout utilizing icons and links.
- `icon-info-grid`: Grid displaying corporate highlight blocks with top icon headers.
- `parallax-hero`: Top section hero page banner scrolling background image under parallax effects.
- `parallax-image`: Displays a single asset image block scrolling with parallax motion.
- `post-carousel`: Loops query posts and displays cards in a carousel slider layout.
- `post-icon-grid`: Displays list of post types formatted inside custom icon grids.
- `post-query-split`: Splits lists of posts by combining primary post cards with secondary title items.
- `post-tabs-slider`: Tabbed switcher filtering custom post types in Swiper slider columns.
- `service-grid`: Renders grid items showing standard company services with icons.
- `smart-card-repeater`: Renders custom cards in a layout loop fed from Elementor repeaters.
- `split-text-image`: Simple two-column block pairing details text with an image banner.
- `strategic-highlights`: Metrics and highlights grid used to showcase organizational achievements.
- `strategic-timeline`: Timeline layout listing milestones in chronological progression.

## 10. Example Customization: `ku-hero` Control IDs
* The Elementor Repeater control ID for listing stats is `stats_repeater_list`.
* The control ID for responsive columns is `stats_columns`.
* The control ID for configuring individual item padding is `stat_item_padding`.
* The toggle for displaying dividers is `show_stat_dividers`, and the customizable styling controls are `stat_divider_color`, `stat_divider_width`, and `stat_divider_style`.
* The options for adjusting the content section width and image section width are defined by `content_section_width` and `image_section_width` respectively.
* **Control Configuration Safety**: Do not rename existing control IDs, meta keys, or styling options unless backward compatibility fallbacks are implemented, as Elementor data is stored inside JSON fields in post meta.

## 11. Widget Creation Workflow Action (`create-elementor-widget.md`)
1. **Search Existing Widgets**: Check the widgets catalog to confirm the requested layout does not duplicate existing functionality.
2. **Create File Structure**: Set up 4 files inside `widgets/[widget-name]/` (`.php`, `card.php`, `.css`, `.js`).
3. **Register Widget**: Require the controller in the bootstrap class (`[project-slug]-elementor-addon.php`) and register using `$widgets_manager->register()`.
4. **Implement Dual-Rendering**: Code the PHP `render()` output and JavaScript `content_template()` templates identically.
5. **Verify Editor Performance**: Load the Elementor editor and test that options apply in real-time in the editor window.

## 12. Widget Post & Taxonomy Query Pattern
When creating a widget that queries database records dynamically (e.g., custom post types, taxonomies, terms), follow these practices and helper methods to fetch settings and build secure queries.

### 12.1 Control Options Helpers
Use these helper methods inside the Widget class to populate Elementor Control options dynamically:

```php
/**
 * Get registered post types for Elementor select controls.
 */
protected function get_active_post_types(): array {
    $post_types = get_post_types( [ 'public' => true ], 'objects' );
    $options    = [];
    foreach ( $post_types as $post_type ) {
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

### 12.2 Constructing and Executing Queries Safely
Construct `WP_Query` arguments strictly within the controller layer (never inside the presentation files). Pass settings to a dedicated query builder method inside the Widget class:

```php
/**
 * Build WP_Query argument array from Elementor settings.
 */
protected function build_widget_query( array $settings ): array {
    $post_type = ! empty( $settings['query_post_type'] ) ? sanitize_key( $settings['query_post_type'] ) : 'post';
    $posts_per_page = ! empty( $settings['posts_per_page'] ) ? intval( $settings['posts_per_page'] ) : 6;
    $orderby = ! empty( $settings['orderby'] ) ? sanitize_key( $settings['orderby'] ) : 'date';
    $order   = ! empty( $settings['order'] ) ? sanitize_key( $settings['order'] ) : 'DESC';

    $args = [
        'post_type'           => $post_type,
        'posts_per_page'      => $posts_per_page,
        'orderby'             => $orderby,
        'order'               => $order,
        'post_status'         => 'publish',
        'ignore_sticky_posts' => true,
    ];

    // Conditionally apply Taxonomy / Term Query filters
    if ( ! empty( $settings['filter_taxonomy'] ) && ! empty( $settings['filter_terms'] ) ) {
        $taxonomy = sanitize_key( $settings['filter_taxonomy'] );
        $terms    = array_map( 'sanitize_key', (array) $settings['filter_terms'] );

        $args['tax_query'] = [
            [
                'taxonomy'         => $taxonomy,
                'field'            => 'slug',
                'terms'            => $terms,
                'operator'         => 'IN',
                'include_children' => true,
            ]
        ];
    }

    return $args;
}
```

### 12.3 Rendering and Dual-Rendering synchronization (render & content_template)
Inside the PHP `render()` method, retrieve the post query and output the card HTML layout directly inside the class. Then implement the identical HTML layout inside `content_template()` using Underscore.js syntax to ensure real-time preview matches:

```php
protected function render() {
    $settings = $this->get_settings_for_display();
    $query_args = $this->build_widget_query( $settings );
    $query = new \WP_Query( $query_args );

    if ( $query->have_posts() ) {
        // ID comes before class
        echo '<div class="' . esc_attr( '[project-slug]-widget-posts-grid' ) . '">';
        
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id   = get_the_ID();
            $title     = get_the_title();
            $permalink = get_permalink();
            $excerpt   = get_the_excerpt();
            $thumbnail = get_the_post_thumbnail_url( $post_id, 'medium' );
            $show_excerpt = $settings['show_excerpt'] === 'yes';
            ?>
            <div id="exat-post-card-<?php echo esc_attr( $post_id ); ?>" class="exat-post-custom-query__card">
                <?php if ( $thumbnail ) : ?>
                    <div class="exat-post-custom-query__card-image-wrapper">
                        <a href="<?php echo esc_url( $permalink ); ?>">
                            <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="exat-post-custom-query__card-image" />
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
            </div>
            <?php
        }
        
        echo '</div>';
        
        // CRITICAL: Reset post data to prevent breaks in WordPress global loop
        wp_reset_postdata();
    } else {
        // Fallback state if no posts match query
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
            echo '<div class="elementor-no-posts-found">' . esc_html__( 'No posts found matching the query.', '[project-slug]' ) . '</div>';
        }
    }
}

protected function content_template() {
    ?>
    <# if ( settings.query_post_type ) { #>
        <div class="exat-post-custom-query__grid">
            <# for ( var i = 0; i < 3; i++ ) { #>
                <div id="exat-post-card-preview-{{ i }}" class="exat-post-custom-query__card">
                    <div class="exat-post-custom-query__card-image-wrapper">
                        <a href="#">
                            <div class="exat-post-custom-query__card-image" style="background: #e5e7eb; display: flex; align-items: center; justify-content: center;">
                                <span style="color: #6b7280; font-size: 0.875rem;"><?php esc_html_e( 'Preview Image', '[project-slug]' ); ?></span>
                            </div>
                        </a>
                    </div>

                    <div class="exat-post-custom-query__card-content">
                        <h3 class="exat-post-custom-query__card-title">
                            <a href="#"><?php esc_html_e( 'Simulated Post Title', '[project-slug]' ); ?> #{{ i + 1 }}</a>
                        </h3>

                        <# if ( settings.show_excerpt === 'yes' ) { #>
                            <div class="exat-post-custom-query__card-excerpt">
                                <p><?php esc_html_e( 'This is a simulated post excerpt template for the Elementor editor preview.', '[project-slug]' ); ?></p>
                            </div>
                        <# } #>

                        <div class="exat-post-custom-query__card-meta">
                            <span class="exat-post-custom-query__card-date">
                                <?php echo esc_html( date('Y-m-d') ); ?>
                            </span>
                        </div>
                    </div>
                </div>
            <# } #>
        </div>
    <# } #>
    <?php
}
```

## 13. Responsive Grid Layout Controls Pattern
To support dynamic columns across multiple devices, avoid writing device-specific hardcoded CSS grid media queries. Instead, utilize Elementor's native `add_responsive_control` to assign column counts to a custom CSS variable mapped dynamically to the wrapper.

### 13.1 Control Schema Definition (PHP)
Register the column layout control using the responsive structure:

```php
$this->add_responsive_control(
    'columns',
    [
        'label'          => esc_html__( 'Columns', '[project-slug]' ),
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
            '{{WRAPPER}} .[project-slug]-widget-posts-grid' => '--[project-slug]-widget-cols: {{VALUE}};',
        ],
    ]
);
```

### 13.2 Grid Implementation (CSS)
Map the columns selector dynamically in your widget's stylesheet:

```css
.[project-slug]-widget-posts-grid {
    display: grid;
    /* Uses the responsive CSS variable from controls, falling back to 3 columns */
    grid-template-columns: repeat(var(--[project-slug]-widget-cols, 3), minmax(0, 1fr));
    gap: var(--[project-slug]-widget-gap, 1.5rem);
}
```



