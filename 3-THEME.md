# Theme Specific Guidelines

This document details the layout structure, options, and rules for the `[project-slug]-theme` WordPress theme.

## 1. Theme Folder Structure
Maintain standard layout directories for organizational cleanliness:
```
inc/
├── enqueue-scripts.php    # Enqueues theme stylesheets and scripts
├── theme-options.php      # Controls WordPress custom settings pages and API option keys
├── post-types.php         # Contains registrations for Custom Post Types (CPT)
├── menu-fields.php        # Configures custom nav menu meta controls (e.g. Mega Menus)
├── helpers.php            # Houses global helper functions
└── setup.php              # Standard theme setup actions

template-parts/
├── header/                # Theme headers
├── footer/                # Theme footers
├── cards/                 # Shared content display loops
└── sections/              # Outer layouts and inner sections
```

## 2. Functions.php Responsibility
Do not place custom business logic directly inside the main `functions.php` file. Use it solely to include dependencies and register configuration handlers from the `inc/` folder.

## 3. Mega Menu Keys
Whitelist and validate keys like `_[project_prefix]_mega_type` and `_[project_prefix]_mega_image_id`. Valid values must be restricted via whitelisting check arrays.

## 4. Footer Rules
* The template file `template-parts/footer-[PROJECT-NAME].php` (or its theme-specific equivalents like `footer-[project-slug].php`) must be strictly focused on presentation.
* Footer options and configuration settings are retrieved and managed in the file `inc/theme-options.php`.
* The footer HTML markup must preserve semantic IDs and use scoped class names (such as `[project-slug]-footer__*`) for styling and targeting.
* Tailwind CSS utility classes are preferred within the layout markup instead of writing large blocks of custom CSS.
* Mobile footer layouts and drawer sheet menus must utilize the Alpine.js bottom-sheet pattern.
* All links, strings, URLs, and texts used in the footer must be sanitized on save and escaped using standard escaping functions (like `esc_url()`, `esc_html()`) on output.
* **Fallback Behavior**: If a footer option or link is left empty, render a safe default state or hide the block completely. Do not print empty anchors (`<a href=""></a>`) to the DOM.

## 5. Mobile Branches Sheet Customization
* The branches configuration data must be retrieved using `[project_prefix]_get_option('header_branches')`.
* This configuration is managed under the WordPress Admin Menu: "Theme Options" > "Header/Branches".
* The default fallback colors for branch highlights are defined as follows: Branch 1 uses `#7a22cb`, and Branch 2 uses `#bf80ff`.
* **Structured Data Schema**: The `header_branches` variable must conform to the following schema definition:
  ```php
  [
    [
      'title'       => (string) '',
      'url'         => (string) '',
      'color'       => (string) '',
      'description' => (string) ''
    ]
  ]
  ```

## 6. Custom Navigation Menu Fields (Mega Menu)
To extend navigation menu items with custom meta fields (such as mega menu types and custom icons/images), use the following WordPress hooks:
- `wp_setup_nav_menu_item`: Loads custom meta data when setup menu items.
- `wp_nav_menu_item_custom_fields`: Outputs the HTML markup for custom field options in the admin menu editor screen.
- `wp_update_nav_menu_item`: Sanitizes and saves custom field choices on update.

```php
// 1. Setup metadata on menu item load
add_filter( 'wp_setup_nav_menu_item', function ( $menu_item ) {
    $menu_item->[project_prefix]_mega_type = get_post_meta( $menu_item->ID, '_[project_prefix]_mega_type', true );
    $menu_item->[project_prefix]_mega_image_id = get_post_meta( $menu_item->ID, '_[project_prefix]_mega_image_id', true );
    return $menu_item;
} );

// 2. Render input controls in WordPress admin menu screen
add_action( 'wp_nav_menu_item_custom_fields', function ( $item_id, $item, $depth, $args ) {
    $type = get_post_meta( $item_id, '_[project_prefix]_mega_type', true );
    $image_id = get_post_meta( $item_id, '_[project_prefix]_mega_image_id', true );
    ?>
    <p class="field-[project-slug]-mega-type description description-wide">
        <label for="edit-menu-item-[project-slug]-mega-type-<?php echo esc_attr( $item_id ); ?>">
            <?php echo esc_html__( 'Mega Menu Type', '[project-slug]' ); ?><br>
            <select id="edit-menu-item-[project-slug]-mega-type-<?php echo esc_attr( $item_id ); ?>" class="widefat" name="menu-item-[project-slug]-mega-type[<?php echo esc_attr( $item_id ); ?>]">
                <option value="" <?php selected( $type, '' ); ?>>None</option>
                <option value="mega-1" <?php selected( $type, 'mega-1' ); ?>>Mega Style 1</option>
            </select>
        </label>
    </p>
    <?php
}, 10, 4 );

// 3. Sanitize and save data on menu update
add_action( 'wp_update_nav_menu_item', function ( $menu_id, $menu_item_db_id, $args ) {
    if ( isset( $_POST['menu-item-[project-slug]-mega-type'][ $menu_item_db_id ] ) ) {
        $type = sanitize_text_field( wp_unslash( $_POST['menu-item-[project-slug]-mega-type'][ $menu_item_db_id ] ) );
        $allowed = [ '', 'mega-1', 'mega-2', 'mega-3' ];
        $type = in_array( $type, $allowed, true ) ? $type : '';
        update_post_meta( $menu_item_db_id, '_[project_prefix]_mega_type', $type );
    }
}, 10, 3 );
```

## 7. Responsive Header Position Helper
When configuring the header layout to be sticky or fixed, use a helper function to convert the options into responsive Tailwind CSS classes rather than writing custom breakpoints:

```php
function [project_prefix]_get_header_position_class( $header_position, $sticky_disable_on = 'none', $sticky_z_class = 'z-40' ) {
    $header_position = sanitize_key( (string) $header_position );
    $sticky_disable_on = sanitize_key( (string) $sticky_disable_on );

    if ( $header_position === 'fixed' ) {
        return trim( 'fixed top-0 left-0 right-0 ' . $sticky_z_class );
    }

    if ( $header_position !== 'sticky' ) {
        return trim( 'relative ' . $sticky_z_class );
    }

    switch ( $sticky_disable_on ) {
        case 'none':
            return trim( 'sticky top-0 ' . $sticky_z_class );
        case 'mobile':
            return trim( 'sticky top-0 max-[767px]:static min-[768px]:sticky min-[768px]:top-0 ' . $sticky_z_class );
        case 'tablet':
            return trim( 'sticky top-0 max-[767px]:sticky max-[767px]:top-0 min-[768px]:static min-[1025px]:sticky min-[1025px]:top-0 ' . $sticky_z_class );
        case 'mobile_tablet':
        default:
            return trim( 'sticky top-0 max-[1024px]:static min-[1025px]:sticky min-[1025px]:top-0 ' . $sticky_z_class );
    }
}
```

## 8. Polylang String Translation Registrations
For multilingual support using Polylang, register custom headers and common theme strings inside the `after_setup_theme` action:

```php
function [project_prefix]_register_polylang_strings() {
    if ( ! function_exists( 'pll_register_string' ) ) {
        return;
    }

    // Register theme-specific strings
    pll_register_string( '[project-slug]', 'Search Articles', 'Header', false );
    pll_register_string( '[project-slug]', 'Read More', 'Common', false );
}
add_action( 'after_setup_theme', '[project_prefix]_register_polylang_strings' );
```

