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
