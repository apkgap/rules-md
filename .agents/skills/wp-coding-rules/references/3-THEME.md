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

    if ( isset( $_POST['menu-item-[project-slug]-mega-image-id'][ $menu_item_db_id ] ) ) {
        $image_id = (int) sanitize_text_field( wp_unslash( $_POST['menu-item-[project-slug]-mega-image-id'][ $menu_item_db_id ] ) );
        update_post_meta( $menu_item_db_id, '_[project_prefix]_mega_image_id', $image_id >= 0 ? $image_id : 0 );
    }
}, 10, 3 );

// 4. Enqueue media and bind image selector script in admin panel
add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( $hook !== 'nav-menus.php' ) {
        return;
    }
    wp_enqueue_media();
    $mega_menu_js = <<<'JS'
(function($){
    function bindMegaImage($container){
        var frame;
        $container.on('click', '.[project-slug]-mega-image-select', function(e){
            e.preventDefault();
            var $wrap = $(this).closest('.field-[project-slug]-mega-image');
            var $id = $wrap.find('.[project-slug]-mega-image-id');
            var $preview = $wrap.find('.[project-slug]-mega-image-preview');
            var $remove = $wrap.find('.[project-slug]-mega-image-remove');
            frame = wp.media({ title: 'Select Image', button: { text: 'Use this image' }, multiple: false });
            frame.on('select', function(){
                var attachment = frame.state().get('selection').first().toJSON();
                $id.val(attachment.id || 0);
                var url = (attachment.sizes && attachment.sizes.medium && attachment.sizes.medium.url) ? attachment.sizes.medium.url : attachment.url;
                $preview.html('<img src="' + url + '" alt="" style="max-width:240px;height:auto;display:block;border:1px solid #dcdcde;border-radius:8px;" />' );
                $remove.show();
            });
            frame.open();
        });
        $container.on('click', '.[project-slug]-mega-image-remove', function(e){
            e.preventDefault();
            var $wrap = $(this).closest('.field-[project-slug]-mega-image');
            $wrap.find('.[project-slug]-mega-image-id').val('0');
            $wrap.find('.[project-slug]-mega-image-preview').empty();
            $(this).hide();
        });
    }
    $(document).ready(function(){
        bindMegaImage($(document));
    });
})(jQuery);
JS;
    wp_add_inline_script( 'jquery-core', $mega_menu_js );
} );
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

## 9. Thai Buddhist Era (B.E.) Date Helper
For Thai localizations, use a helper to format post dates into the Buddhist Era (+543 years) in short, full, or yearless formats:

```php
/**
 * Format post date in Thai language with Buddhist Era (B.E.) year.
 *
 * @param int|WP_Post|null $post   Post ID or post object. Default is global $post.
 * @param string           $format 'short' (e.g. 22 พ.ค. 2569) or 'full' (e.g. 22 พฤษภาคม 2569) or 'no_year' (e.g. 22 พ.ค.).
 * @return string Formatted Thai date.
 */
function [project_prefix]_thai_date( $post = null, $format = 'short' ) {
    $post = get_post( $post );
    if ( ! $post ) {
        return '';
    }

    $time = mysql2date( 'G', $post->post_date );
    $day = date( 'j', $time );
    $month_num = date( 'n', $time );
    $year = date( 'Y', $time ) + 543;

    $thai_months_short = [
        1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.', 5 => 'พ.ค.', 6 => 'มิ.ย.',
        7 => 'ก.ค.', 8 => 'ส.ค.', 9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
    ];

    $thai_months_full = [
        1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน', 5 => 'พฤษภาคม', 6 => 'มิถุนายน',
        7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
    ];

    if ( $format === 'full' ) {
        return $day . ' ' . $thai_months_full[ $month_num ] . ' ' . $year;
    } elseif ( $format === 'no_year' ) {
        return $day . ' ' . $thai_months_short[ $month_num ];
    }

    return $day . ' ' . $thai_months_short[ $month_num ] . ' ' . $year;
}
```

## 10. Custom Language Switcher (Polylang + Alpine.js)
Implement an accessible and elegant dropdown language switcher driven by Alpine.js transition states:

```php
function [project_prefix]_language_switcher() {
    if ( ! function_exists( 'pll_current_language' ) ) {
        return;
    }

    $languages = pll_the_languages( [ 'raw' => 1 ] );
    if ( empty( $languages ) ) {
        return;
    }

    $current_lang_obj = null;
    foreach ( $languages as $lang ) {
        if ( $lang['current_lang'] ) {
            $current_lang_obj = $lang;
            break;
        }
    }

    if ( ! $current_lang_obj ) {
        return;
    }

    $lang_color = [project_prefix]_get_option( 'language_switcher_color', 'var(--text-base)' );
    ?>
    <div class="relative" x-data="{ open: false }">
        <button
            @click="open = !open"
            @click.away="open = false"
            type="button"
            class="flex items-center gap-1 px-2 h-10 text-sm font-bold uppercase transition-opacity hover:opacity-80"
            style="color: <?php echo esc_attr( $lang_color ); ?>;">
            <span><?php echo esc_html( $current_lang_obj['slug'] ); ?></span>
            <span class="w-3.5 h-3.5 transition-transform duration-200 flex items-center justify-center" :class="open ? 'rotate-180' : ''">
                <i class="ri-arrow-right-line"></i>
            </span>
        </button>

        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-1"
            class="absolute right-0 mt-1 w-24 bg-bg-base border border-border-base/60 rounded-xl shadow-xl z-50 overflow-hidden"
            style="display: none;">
            <div class="py-1">
                <?php foreach ( $languages as $lang ) : ?>
                    <a
                        href="<?php echo esc_url( $lang['url'] ); ?>"
                        class="flex items-center justify-between px-4 py-2 text-sm font-medium transition-colors hover:bg-surface-base <?php echo $lang['current_lang'] ? 'text-primary' : 'text-base'; ?>">
                        <span class="uppercase"><?php echo esc_html( $lang['slug'] ); ?></span>
                        <?php if ( $lang['current_lang'] ) : ?>
                            <span class="w-3.5 h-3.5 text-primary flex items-center justify-center">
                                <i class="ri-arrow-right-line"></i>
                            </span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
}
```

