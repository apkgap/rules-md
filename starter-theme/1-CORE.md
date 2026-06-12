# Core Rules & Global Standards

## 1. Mandatory Pre-Execution Rule: Read All Rules (.md)
* **CRITICAL MANDATE**: Before writing any code, modifying configurations, or implementing any features, the AI agent **MUST read the rule/guideline files in the workspace based on priority**. Do not load all files in huge workspaces unless relevant, to avoid token noise.
* **Priority Order for File Inspection**:
  1. **Priority 1 (Core Rules)**: `GEMINI.md` (or specific split files) and any component-specific `AGENTS.md` files.
  2. **Priority 2 (Workflows & Review)**: Windsurf workflow files in `.windsurf/workflows/` (e.g., `write-code.md`, `read-rules.md`, `review.md`).
  3. **Priority 3 (Module Readmes)**: Specific `README.md` files located in the target directory of the module being modified.
  4. **Priority 4 (Deep Reference)**: Other markdown reference documentation, only if directly related to the task.
* The agent must fully understand the codebase's conventions, directory structure, security policies, and asset pipelines before starting work.

## 2. Core Coding Rules
- **Theme Templates:** Keep theme templates focused strictly on presentation.
- **Do Not Place Business Logic Inside Template Parts**: Keep `template-parts/` files strictly focused on presentation.
- **Do Not Query Posts Directly Inside card.php**: The presentation cards inside `template-parts/cards/` must receive pre-queried database records via `get_query_var()` only. Do not execute instances of `WP_Query` or business logic directly inside cards unless explicitly approved.
- **WP_Query Restriction**: Use `WP_Query` only within the controller layer or widget `render()` methods.
- **Reusable Logic:** Place reusable business and backend logic in `inc/` (for themes) or `inc/` (for plugins).
- **Security & Data Sanitization:**
  - Sanitize all incoming PHP data before saving.
  - Escape all outputs in templates using appropriate WordPress escaping functions (e.g., `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`, `esc_html__()`, `esc_html_e()`).
- **Styling & Layout:**
  - Prefer Tailwind CSS utility classes for frontend styling.
  - Use scoped classes and IDs (e.g., `[project-slug]-footer__*`) for reusable sections that may need instance-safe targeting.
  - Keep responsive behavior explicit across mobile, tablet, and desktop.
- **Elementor & Assets:**
  - Do not place Elementor widgets directly in the theme files.
  - Register and enqueue all assets (JS, CSS) through WordPress standard enqueue functions.

## 3. HTML Conventions
- **`id` MUST come before `class`** on every HTML element. Example: `<div id="foo" class="bar">`
- **Formatting Exception**: This rule is a style convention. It must be followed during coding and cleanup/review, but it must not block urgent production hotfixes or security updates.

## 4. Security
- **ABSPATH definition**: Always check `ABSPATH` is defined before execution in all PHP files:
  ```php
  if ( ! defined( 'ABSPATH' ) ) {
      exit; // Exit if accessed directly.
  }
  ```
- **Input Sanitization**: Sanitize all `$_POST` / `$_GET` and control values before use using WordPress sanitization functions: `sanitize_text_field()`, `sanitize_key()`, `esc_url_raw()`, `sanitize_textarea_field()`, `sanitize_email()`.
- **Context-Specific Output Escaping**: Escape all output in templates, widget `render()`, and cards based on the specific context:
  - HTML text elements → `esc_html()` or translation equivalents like `esc_html__()`.
  - HTML attributes → `esc_attr()`.
  - URLs → `esc_url()`.
  - Rich text or editor fields → `wp_kses_post()`.
  - JSON strings inside attributes → `wp_json_encode()` combined with `esc_attr()`.
- **Nonces & Cap Checks**: Use nonces for AJAX / form submissions: `check_ajax_referer()`, `wp_create_nonce()`, `wp_nonce_field()`, `wp_verify_nonce()`. Always verify user capabilities using `current_user_can('manage_options')` before processing administrative actions.
- **Password Exception**: DO NOT sanitize password inputs (use phpcs ignore annotations) — WordPress handles secure password hashing internally.
- **REST API Routes Protection**: All custom REST routes must declare a `permission_callback`.
  - For admin-only routes:
    ```php
    'permission_callback' => function () {
        return current_user_can( 'manage_options' );
    }
    ```
  - For authenticated user routes:
    ```php
    'permission_callback' => function () {
        return is_user_logged_in();
    }
    ```
- **SQL Database Safety**: Always use `$wpdb->prepare()` for all custom SQL queries. Never concatenate user input directly into SQL queries to prevent SQL Injection.
- **File Upload Security**: All custom file upload endpoints must enforce file validation:
  - Check file types using `wp_check_filetype_and_ext()`.
  - Handle file uploads using `wp_handle_upload()`.
  - Enforce whitelisted mime types and file size limitations.

## 5. PHP Patterns
- **Conventional PHP names**: All global namespace items (functions, classes, constants) must be prefixed with the theme-specific or plugin-specific prefix (e.g., `[project_prefix]_`, `[plugin_prefix]_`).
- **Namespace & Autoloading**:
  - For larger themes or plugins, prefer using PHP namespaces under `Inc\` or `App\` namespaces.
  - Integrate Composer autoloading rules only when the plugin or theme already supports it.
- **Strict Typing**: Declare `declare(strict_types=1);` at the top of newly created helper and class PHP files to ensure type safety.
- **Error Handling Pattern**:
  - **Redirect Flow**: Use WordPress Transients for passing errors between redirects, suffixed with `get_current_blog_id()` for multisite safety:
    ```php
    // Set
    set_transient('[project_prefix]_login_errors_' . get_current_blog_id(), $errors, 30);
    // Get + Delete
    $errors = get_transient('[project_prefix]_login_errors_' . get_current_blog_id());
    delete_transient('[project_prefix]_login_errors_' . get_current_blog_id());
    ```
  - **REST API & AJAX Flow**: For REST routes or AJAX actions, return structured `WP_Error` objects or JSON error responses:
    ```php
    return new WP_Error( 'error_code', 'Error message details', [ 'status' => 400 ] );
    // Or
    wp_send_json_error( [ 'message' => 'Error message details' ], 400 );
    ```
- **Polylang Integration**:
  - Register strings via `pll_register_string()` in `after_setup_theme`.
  - `[project_prefix]_get_option($key)` supports multilang: checks `{key}_{lang}` before falling back to `{key}`.
  - Check `function_exists('pll_current_language')` before using Polylang functions.

## 6. Asset Enqueue
- **Safe Versioning (Cache Busting)**: Use file modification time for local asset versioning to avoid caching issues, with a fallback to the theme version to prevent warnings if the file does not exist:
  ```php
  $css_path = get_template_directory() . '/dist/file.css';
  $css_ver  = file_exists($css_path) ? filemtime($css_path) : wp_get_theme()->get('Version');
  wp_enqueue_style('handle', get_template_directory_uri() . '/dist/file.css', [], $css_ver);
  ```
- **File Existence Check**: Always check `file_exists()` before enqueueing optional assets.
- **Footer Scripts**: Load JavaScript scripts in the footer (last parameter `true` in `wp_enqueue_script`).
- **Asset Registration**: Register assets before enqueueing using `wp_register_script()` / `wp_register_style()`. Declare dependencies via `get_style_depends()` / `get_script_depends()` in Elementor.
- **Conditional Enqueue**: Only load heavy third-party assets (like Swiper) on pages that actually require them.
- **Config & Nonce Localization**: Enqueue data/configs to scripts via inline JSON config scripts or standard localization helper functions:
  ```php
  wp_add_inline_script(
      'handle',
      'window.[project_prefix]Config = ' . wp_json_encode($config) . ';',
      'before'
  );
  ```

## 7. JS Stack
- **Alpine.js**: Use Alpine.js for page interactions (available as `window.Alpine`). Keep state declared in `x-data` on wrapper elements rather than global initialization unless needed.
- **Swiper**: Use Swiper for sliders (available globally as `window.Swiper` via theme's `dist/app.js`).
  - Output config attributes safely in PHP:
    ```php
    data-swiper="<?php echo esc_attr( wp_json_encode( $swiper_config ) ); ?>"
    ```
  - Parse Swiper config safely in JS:
    ```js
    let config;
    try {
        config = JSON.parse(el.dataset.swiper || '{}');
    } catch (error) {
        config = {};
    }
    ```
- **Dependency Guarding**: Ensure that frontend JavaScript files verify libraries are loaded before initializing:
  ```js
  if ( ! window.Alpine ) return;
  if ( ! window.Swiper ) return;
  ```
- **React Layer (Theme Options / Profile)**:
  - Mount point pattern: `<div id="[project-slug]-[section]-root"></div>`.
  - Pass endpoint config and nonce via script localization:
    ```php
    wp_localize_script('handle', '[project_prefix]ThemeOptions', [
        'apiUrl' => esc_url_raw(rest_url('[project_prefix]/v1/options')),
        'nonce'  => wp_create_nonce('wp_rest'),
    ]);
    ```
- **No inline scripts**: Do not place inline `<script>` tags inside widget or page HTML.

## 8. CSS & Styling
- **Tailwind CSS Integration with CSS Variables**:
  - Prioritize using Tailwind CSS utility classes for layout, typography, and theme styling.
  - To support dynamic user-controlled dimensions, use Tailwind CSS arbitrary values pointing to a custom CSS variable (e.g., `lg:w-[var(--custom-width-variable,50%)]`) instead of locking layout widths using standard utility classes.
- **Tailwind Content Path Scanning**: Specify content paths in your Tailwind configuration to monitor PHP templates, widgets, and scripts:
  ```js
  content: [
      './**/*.php',
      './src/**/*.js',
      './widgets/**/*.php',
  ]
  ```
- **CSS Variable Naming Convention**: Standardize names of custom CSS variables to avoid naming conflicts across themes and plugins. Use namespace-specific prefixes:
  ```css
  --[project-slug]-widget-gap
  --[project-slug]-card-padding
  --[project-slug]-footer-bg
  ```
- **Spacing Controls CSS Variable Pattern**:
  - When configuring Elementor layout controls for custom spacing (such as gap, margin, or padding), output these properties using CSS variables rather than declaring hardcoded CSS rules. This guarantees seamless style synchronization and real-time updates across both the front-end PHP template render and the Elementor editor JavaScript template.
  - **Control Selector Pattern:** `{{WRAPPER}} .selector { --custom-variable: {{SIZE}}{{UNIT}}; }`
  - **HTML Markup Inline Style Pattern:** `style="padding: var(--custom-variable, default-value);"`
- **Flex & Grid Layout Precedence**:
  - Do not combine `display: flex;` and `display: grid;` declarations on the same CSS class in primary stylesheets. This avoids layout conflicts, overlapping rules, and collision with Tailwind CSS dynamic layout/grid utilities.
  - For dynamic components with customizable column controls, set the layout default to `display: grid;` and manage active column spans using CSS variables declared within the element selectors.
- **Dynamic Columns and Borders**:
  - When drawing vertical separation lines (`border-right`) between elements inside a looped list or loop layout, always omit the border for the final item to ensure clean and clean rendering. Implement this with either CSS `:not(:last-child)` or a targeted override: `.class:last-child { border-right: none !important; }`.
- **No Direct Layout Overwrites**:
  - Avoid defining hardcoded structural dimensions or position styles—such as `display`, `width`, `height`, or `padding`—directly inside widget core stylesheets (`.css`) if these properties are configurable via user controls in Elementor. This permits CSS variables and Elementor wrapper selectors to govern layout geometry and responsiveness correctly.
- **Editor Preview Compatibility**: All widget stylesheets and custom selectors must be designed to function correctly within both the frontend display and the back-end Elementor Editor preview workspace (handling wrapper selector class overrides seamlessly).

## 9. Accessibility
All interactive UI components must:
- Use semantic HTML.
- Use `<button>` for actions instead of clickable `<div>`.
- Include keyboard-accessible focus.
- Include `aria-expanded`, `aria-controls`, or `aria-hidden` where appropriate.
- Provide meaningful image alt text, or empty alt text for decorative images.

## 10. SEO & Schema Rules
- **Heading Hierarchy**: Enforce a strict heading structure. Each template must print exactly one `<h1>` element per page. Sub-sections must flow sequentially from `<h2>` through `<h6>`.
- **Image Accessibility & SEO**: Every render image tag must include an alt attribute. Provide a descriptive string for content-relevant images and an empty `alt=""` for purely decorative images.
- **Schema Integration**: Embed valid JSON-LD metadata schema blocks dynamically on appropriate modules (Organization/LocalBusiness on headers/footers, Article on single posts, Product on catalog items).
- **Polylang SEO Sync**: Ensure that `hreflang` tags are correctly enqueued in the header to point to matching translation variants on multi-language setups.

## 11. Performance
- **Conditional Library Loading**: Only enqueue heavy third-party assets (e.g. Swiper, DateRangePicker) on page templates or widgets that explicitly render those assets.
- **DOM Optimization**: Avoid unnecessary HTML wrapper tags or deep nesting of columns inside Elementor builders to prevent bloating the DOM tree size.
- **WordPress Media Helpers**: Always pull media images using helper tags like `wp_get_attachment_image()` to leverage native responsive source sets (`srcset`) and lazy loading attributes instead of writing raw `<img>` tags.
- **Loop Query Caching**: Avoid issuing custom database or metadata queries inside template loops. Cache expensive queries (like navigation builds or location grids) using WordPress Transients with clear invalidation logic on save actions.

## 12. Design System
- **Custom Properties Definition**: Utilize standardized CSS variables to manage colors, paddings, margins, and borders. Refrain from injecting static CSS styles:
  ```css
  --[project-slug]-color-primary
  --[project-slug]-color-secondary
  --[project-slug]-section-padding
  --[project-slug]-card-radius
  ```
- **Tailwind Compatibility**: Combine Elementor controls with Tailwind utility values to ensure styling scales appropriately across all break points.
