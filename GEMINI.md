# Global Rules & Coding Patterns ([PROJECT-NAME] / [project-slug] Theme)

> [!NOTE]
> This is a global rule template. Replace the following placeholders with your specific project names and naming conventions:
> - `[PROJECT-NAME]`: The readable project name (e.g., `EXAT`, `KUSMILE`, `FROG`).
> - `[project-slug]`: The lowercase hyphenated slug used for directories, text domains, and CSS namespaces (e.g., `exat-theme`, `exat-account`, `frog-footer`).
> - `[project_prefix]`: The lowercase snake_case prefix used for functions, global variables, and transients (e.g., `exat_theme_`, `exat_account_`).
> - `[PROJECT-PREFIX]`: The uppercase prefix used for PHP classes, constants, and namespaces (e.g., `EXAT_`, `FROG_`).

## 1. Mandatory Pre-Execution Rule: Read All Rules (.md)
* **CRITICAL MANDATE**: Before writing any code, modifying configurations, or implementing any features, the AI agent **MUST read the rule/guideline files in the workspace based on priority**. Do not load all files in huge workspaces unless relevant, to avoid token noise.
* **Priority Order for File Inspection**:
  1. **Priority 1 (Core Rules)**: [GEMINI.md](file:///c:/Users/akega/.gemini/GEMINI.md) and any component-specific `AGENTS.md` files (e.g., in themes or plugins).
  2. **Priority 2 (Workflows & Review)**: Windsurf workflow files in `.windsurf/workflows/` (e.g., `write-code.md`, `read-rules.md`, `review.md`).
  3. **Priority 3 (Module Readmes)**: Specific `README.md` files located in the target directory of the module being modified.
  4. **Priority 4 (Deep Reference)**: Other markdown reference documentation, only if directly related to the task.
* The agent must fully understand the codebase's conventions, directory structure, security policies, and asset pipelines before starting work.

## 2. Core Rules
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

## 9. Elementor Widgets ([project-slug]-elementor-addon)
- **Widget Structure**: Every widget must reside in `widgets/[widget-name]/` and contain exactly 4 files:
  - `[widget-name].php` (Widget class extending `\Elementor\Widget_Base`)
  - `card.php` (Presentation template)
  - `[widget-name].css` (BEM styles)
  - `[widget-name].js` (Asset scripts)
- **Registration**: All widget classes must be required and registered in the plugin bootstrap file (`[project-slug]-elementor-addon.php`).
- **BEM Naming**: CSS class naming must follow: `.[project-slug]-[widget-name]__[element]--[modifier]`.
- **Card Template**: `card.php` is strictly presentation-only. It must receive data via `get_query_var()` and perform no queries or business logic.
- **Dual-Rendering Synchronization Rule**: When editing layout structure, element selectors, tag hierarchies, or class names inside the PHP `render()` function of a widget, you must apply the exact same modifications to the JavaScript `content_template()` function. This prevents rendering discrepancies between the front-end production template and the backend Elementor editor preview.
- **Widget-specific naming**:
  - PHP class: `[PROJECT-PREFIX]_[PascalCase]_Widget`
  - CSS/JS handles: `[project-slug]-[widget-name]`
- **Avoid Duplicate Widgets**: Before creating new widgets, review existing widgets to determine if their functionality can be extended. Avoid duplicate widgets with overlapping layouts and purposes.
- **Available Widgets (15 total) and Purpose Map**:
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

## 10. Theme Specific ([project-slug]-theme)
- **Theme Folder Structure**: Maintain standard layout directories for organizational cleanliness:
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
- **Functions.php Responsibility**: Do not place custom business logic directly inside the main `functions.php` file. Use it solely to include dependencies and register configuration handlers from the `inc/` folder.
- **Mega Menu Keys**: Whitelist and validate keys like `_[project_prefix]_mega_type` and `_[project_prefix]_mega_image_id`. Valid values must be restricted via whitelisting check arrays.

## 11. Component & Configuration Settings

### 11.1 Footer Rules
* The template file `template-parts/footer-[PROJECT-NAME].php` (or its theme-specific equivalents like `footer-[project-slug].php`) must be strictly focused on presentation.
* Footer options and configuration settings are retrieved and managed in the file `inc/theme-options.php`.
* The footer HTML markup must preserve semantic IDs and use scoped class names (such as `[project-slug]-footer__*`) for styling and targeting.
* Tailwind CSS utility classes are preferred within the layout markup instead of writing large blocks of custom CSS.
* Mobile footer layouts and drawer sheet menus must utilize the Alpine.js bottom-sheet pattern.
* All links, strings, URLs, and texts used in the footer must be sanitized on save and escaped using standard escaping functions (like `esc_url()`, `esc_html()`) on output.
* **Fallback Behavior**: If a footer option or link is left empty, render a safe default state or hide the block completely. Do not print empty anchors (`<a href=""></a>`) to the DOM.

### 11.2 Admin Settings Rules
* All theme option pages and options-saving handlers must verify that the current user has the `manage_options` capability before processing.
* Nonces are mandatory for all form submissions to safeguard against CSRF (Cross-Site Request Forgery).
* Save only the options and settings that are relevant to the currently displayed admin settings page.
* Whitelist all allowed keys on submission to avoid parameter pollution.
* Option field names in forms must be kept fully aligned and matched with the keys retrieved via `[project_prefix]_get_option()`.

### 11.3 Widget Customization: `ku-hero` (Example Widget Customization)
* The Elementor Repeater control ID for listing stats is `stats_repeater_list`.
* The control ID for responsive columns is `stats_columns`.
* The control ID for configuring individual item padding is `stat_item_padding`.
* The toggle for displaying dividers is `show_stat_dividers`, and the customizable styling controls are `stat_divider_color`, `stat_divider_width`, and `stat_divider_style`.
* The options for adjusting the content section width and image section width are defined by `content_section_width` and `image_section_width` respectively.
* **Control Configuration Safety**: Do not rename existing control IDs, meta keys, or styling options unless backward compatibility fallbacks are implemented, as Elementor data is stored inside JSON fields in post meta.

### 11.4 Theme Customization: Mobile Branches Sheet
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

## 12. Plugin Specific Guidelines

### 12.1 [project-slug]-account (Member System & React SPA)
- **Authentication Flow**:
  - Redirect users to `/account` after a successful login session.
  - Automatically log in users after a successful registration by invoking `wp_set_current_user()` and `wp_set_auth_cookie()`, then perform the redirect.
  - Password inputs must NOT be sanitized during parsing (add a phpcs ignore rule) since WordPress handles secure hashing internally.
- **REST API Routing**:
  - The namespace must be defined as `account/v1` (do not prefix with the plugin slug like `[project-slug]-account/v1`).
  - Secure all user-specific profile/address routes by checking `is_user_logged_in()` inside the permission callback.
- **Sensitive Identity Data**: Never store citizen IDs in plain text. Always run IDs through `[project_prefix]_account_hash_citizen_id()` for encryption, and show only the masked variant `[project_prefix]_account_mask_citizen_id()`.
- **REST Response Schema**: Format REST responses to follow consistent JSON schemas:
  - **Success**: `{ "success": true, "data": { ... } }`
  - **Failure**: `{ "code": "invalid_postcode", "message": "Invalid postcode" }`
- **User Meta Keys Structure**:
  - Personal Details: `first_name`, `last_name`, `phone`, `line_id`.
  - Address Details: `address_line_1`, `address_line_2`, `province`, `district`, `subdistrict`, `postcode`.
  - Company Details: `company_name`, `company_tax_id`, `company_branch`.
  - authentication meta: `[project-slug]_sub`, `[project-slug]_citizen_id_last4`.
- **Pre-existing Utility Helpers**: Reuse functions registered in `inc/helpers.php`:
  - `[project_prefix]_account_hash_citizen_id($id)`: SHA-256 hash for secure storage of citizen IDs.
  - `[project_prefix]_account_mask_citizen_id($id)`: Masks citizen ID to display only the last 4 digits: `*********XXXX`.
  - `[project_prefix]_account_validate_postcode($postcode)`: Checks for a valid 5-digit postal code.
  - `[project_prefix]_account_sanitize_phone($phone)`: Strips non-essential characters, keeping only numbers and standard formatting symbols: `0-9`, `+`, `-`, `(`, `)`.
  - `[project_prefix]_account_rest_error($code, $message)`: Utility to return formatted `WP_Error` JSON responses.

### 12.2 [project-slug]-core (Core Functional Setup)
- **Settings and Sticky Control Validation**:
  - Store sticky mode configuration settings securely. Ensure sticky disable options are validated against an array of allowed values: `none`, `mobile`, `tablet`, `mobile_tablet`.
  - Clean settings during save processes to prevent parameter injection:
    ```php
    $value = in_array( $value, $allowed, true ) ? $value : 'mobile_tablet';
    ```
- **Paths and URL Helpers**:
  - Use `plugin_dir_path()` and `plugin_dir_url()` to dynamically load local assets and dependencies.
- **Asset Registration & Localization**:
  - Always register assets (scripts and styles) prior to enqueuing.
  - Version assets dynamically using the file modification time (`filemtime()`) to avoid browser caching issues.
  - Load JavaScript in the footer by setting the final argument of `wp_enqueue_script()` to `true`.
  - Inject localized JSON variables or secure nonces via `wp_localize_script()`.

### 12.3 [project-slug]-json-import (JSON Data Importer & AJAX Handlers)
- **Design Pattern**:
  - Implement the Singleton pattern to instantiate and reference the main plugin controller instance.
- **Security Checkpoints**:
  - Verify capabilities using `current_user_can('manage_options')` before executing imports or configuration updates.
  - Implement CSRF protection by validating nonces with `check_ajax_referer()` on all incoming AJAX requests.
  - Sanitize all raw input data: use `sanitize_text_field()` for normal texts, `esc_url_raw()` for import URLs, and `sanitize_textarea_field()` for raw blocks of text.
  - Escape all output statements using translation methods like `esc_html__()` and `esc_html_e()`.
- **AJAX Handler Workflow**:
  - Perform nonce and capability checks.
  - Validate file uploads and catch system upload errors.
  - Ensure the uploaded JSON file has a valid syntax structure.
  - Return JSON responses using `wp_send_json_error()` for failures and `wp_send_json_success()` for completed imports.
- **Post Importing Logic**:
  - Store original post resource URLs in the `_[project_prefix]_original_url` metadata field.
  - Normalize and compare URLs before performing duplicate detection checks (strip trailing slashes, remove scheme variations).
  - Check the source URL against existing database records to avoid importing duplicate posts if the deduplication setting is enabled.
  - Dynamically register custom taxonomies and categories if they do not exist.
  - Set the status of all imported posts to `draft` by default during the `wp_insert_post()` call.
  - Optionally fetch and download external image URLs into the local WordPress Media Library, setting them as the post thumbnail.
- **Import Rate Limiting & Error Management**:
  - Enforce timeout limits during remote queries using `wp_safe_remote_get()` and track progress using logs.
  - If a media download fails, log the issue and continue processing other items. Do not abort the entire import batch.
- **Conditional Asset Enqueue**:
  - Ensure the plugin administration CSS/JS scripts are only loaded on the specific admin page hook registered by the plugin menu.

## 13. CI/CD (GitHub Deploy)
- **Deploy Trigger**: CI/CD runs and deploys only when pushing to the `main` branch. The `dev` branch does not deploy.
- **Build Step**:
  - Run `npm ci && npm run build` for `[project-slug]-theme` and `[project-slug]-account` before deployment.
- **Exclusion Rules**:
  - Automatically exclude `.git*`, `node_modules/`, `src/`, `package.json`, `package-lock.json`, and `AGENTS.md` files from deployment.
- **Secrets Configured**:
  - `FTP_SERVER`, `FTP_USERNAME`, `FTP_PASSWORD`, `FTP_THEME_DIR`, `FTP_PLUGIN_DIR`.

## 14. Git Workflow
- **Commit Messages**: Always follow Conventional Commits format (`feat:`, `fix:`, `style:`, `docs:`, `refactor:`, `chore:`).
- **Target Branching Workflow**: To prevent accidental deployment to production servers, never push to `main` directly during active tasks.
  - Local tasks and features must be merged and pushed to `dev` for testing.
  - Merge features into `main` only when deploying production-ready assets.
  - Recommended Branch commands:
    ```sh
    # For active development tasks:
    git checkout dev
    git add .
    git commit -m "feat: description"
    git push origin dev

    # For production releases (deploy via main):
    git checkout main
    git pull origin main
    git merge dev
    git push origin main
    ```

## 15. Code Review & Bug Prevention Guidelines
When reviewing code changes or performing verification, ensure the following checklist is followed:
- **Logic & Edge Cases**: Verify all logical flows and ensure edge cases (e.g., empty arrays, null/undefined inputs) are handled properly.
- **Security Check**: Scan for common vulnerabilities, including lack of data sanitization/escaping, missing nonces, and improper capability validation.
- **Resource & Caching**: Check for memory leaks, resource exhaustion, and incorrect caching behaviors (e.g., stale cache, wrong keys, incorrect invalidation, or ineffective caching).
- **Conventions & Patterns**: Ensure code adheres strictly to established workspace patterns, WordPress Coding Standards, and global rules.
- **Bug Reporting**: Proactively identify and report pre-existing bugs in code touched during implementation to maintain codebase quality.
- **Confidence & Accuracy**: Rely on a thorough understanding of the codebase; do not flag speculative or low-confidence issues. Check if specific git commits are checked out or if local states differ.
- **Review Checklists by Component**:
  - **PHP / WordPress Specific**: Verify ABSPATH exists, verify nonces/capabilities, verify context escaping, verify all SQL custom statements utilize `$wpdb->prepare()`.
  - **JavaScript Specific**: Check for DOM presence guards, verify external dependency loads, avoid global namespace pollution, ensure zero inline scripting is introduced.
  - **Elementor Specific**: Validate parity between `render()` and `content_template()`, check backward compatibility of control IDs, verify styling rules apply in frontend/editor.
  - **Deployment Specific**: Verify build compiles cleanly, ensure compiled assets are output to `dist/`, check that configuration files exclude node dependencies from build targets.

## 16. WordPress & Node.js Development Environment (Auto-Sync Setup)
When initiating a new WordPress theme or plugin workspace that integrates Node.js assets, a senior engineer must implement a robust local development workflow utilizing hot reloading/browser synchronization. This ensures PHP template modifications and Node.js compiled assets are synchronized in real-time without manual page refreshes.

### 16.1 Package Configuration & Dependencies
To orchestrate watch compilation tasks and live-reloading in parallel, ensure the following developer tools are installed in your `package.json`:
- `browser-sync` (Live reload engine proxying the local WordPress instance)
- `npm-run-all` (Orchestrates parallel and sequential scripts execution)
- Compilers/watchers as appropriate (e.g., `esbuild` for scripts bundling, `@tailwindcss/cli` for styling)

```json
"devDependencies": {
  "browser-sync": "^3.0.4",
  "npm-run-all": "^4.1.5",
  "@tailwindcss/cli": "^4.1.18",
  "esbuild": "^0.27.3"
}
```

### 16.2 Script Definition Schema
Configure scripts in your `package.json` to monitor project assets (`.php`, `.css`, `.js`), ignore dependency paths (`node_modules`, `vendor`), and run compiling watchers in parallel:

```json
"scripts": {
  "start": "npm run dev",
  "dev": "npm-run-all --parallel watch:tailwind watch:js serve",
  "serve": "browser-sync start --proxy \"http://yourproject.local\" --port 3000 --ui-port 3001 --files \"./**/*.php,./dist/**/*.css,./dist/**/*.js\" --ignore \"node_modules/**/*,vendor/**/*,.git/**/*\"",
  "watch:tailwind": "tailwindcss -i ./src/input.css -o ./dist/tailwind.css --watch",
  "watch:js": "esbuild src/js/app.js --bundle --outfile=dist/app.js --watch",
  "build": "npm-run-all build:js build:tailwind",
  "build:tailwind": "tailwindcss -i ./src/input.css -o ./dist/tailwind.css --minify",
  "build:js": "esbuild src/js/app.js --bundle --minify --outfile=dist/app.js"
}
```

### 16.3 Local Execution Workflow
1. Ensure your local WordPress environment (e.g., LocalWP, Laragon, or Docker) is active and accessible via a local domain (e.g., `http://yourproject.local`).
2. Run `npm install` to load all packages.
3. Start the hot-reload server by executing:
   ```bash
   npm run dev
   ```
4. Access the development environment through the BrowserSync proxy endpoint: `http://localhost:3000`. Any code change will inject updated CSS or trigger page refreshes dynamically.

## 17. Senior Execution Protocol
Before making any code change, the agent must:
1. Read the required project rule files based on priority.
2. Inspect existing related files before creating new files.
3. Reuse existing helpers, widgets, option keys, meta keys, REST routes, and CSS patterns when available.
4. Avoid duplicate systems or overlapping widgets.
5. Keep changes minimal and targeted.
6. Preserve backward compatibility for Elementor control IDs, option keys, meta keys, CSS classes, and REST response structures.
7. Apply WordPress security standards: nonce, capability, sanitization, escaping, REST permission callbacks, and `$wpdb->prepare()` for SQL.
8. Verify both frontend and Elementor editor rendering when modifying widgets.
9. Run or document required build steps when touching `src/`, `dist/`, Tailwind, or JS bundles.
10. Summarize changed files, risk areas, and verification steps after completion.

## 18. Backward Compatibility Rules
Do not rename existing:
- Elementor control IDs
- CSS/BEM class names
- WordPress option keys
- post meta keys
- user meta keys
- REST route names
- REST response keys
- AJAX action names
- shortcode names
Unless a migration path or compatibility fallback is implemented.

## 19. Accessibility Rules
All interactive UI components must:
- Use semantic HTML.
- Use `<button>` for actions instead of clickable `<div>`.
- Include keyboard-accessible focus.
- Include `aria-expanded`, `aria-controls`, or `aria-hidden` where appropriate.
- Provide meaningful image alt text, or empty alt text for decorative images.

## 20. Build Script Completion
When defining `npm run build`, all referenced scripts must exist.
Ensure scripts are structured such that running `npm run build` runs all required sub-compilation watchers/builders cleanly.

## 21. WooCommerce Rules & Guidelines
- **No Direct Template Modifications**: Do not modify WooCommerce templates directly. Always prioritize standard action and filter hooks. If template overrides are required, copy the file to `[theme-slug]/woocommerce/` maintaining identical file hierarchy.
- **Data Escaping**: Always escape prices, product titles, and product images in template outputs using context-specific helpers (e.g., `wc_price()`, `esc_html()`, `wp_kses_post()`).
- **Product Import & Deduplication**:
  - Always use SKU as the unique product identifier during manual or automated syncing. Never use the product name as the unique key since translations may alter text strings.
  - Normalize image filenames before matching during imports. Sanitize filenames to lowercase, remove special symbols, and map `.webp` extensions properly to avoid generating duplicate attachments in the Media Library.
- **Multilingual Integration (Polylang/WPML)**:
  - Keep TH and EN records mapped correctly using parent-translation meta.
  - When importing translated catalog assets, verify that the translation linkage is explicitly saved in database relations to prevent isolated, orphaned records.

## 22. Advanced Custom Fields (ACF), Custom Post Types (CPT) & REST API
- **Naming Conventions**: All CPT and taxonomy slugs must be lowercase, snake_case, and prefixed with the project-specific handle: `[project_prefix]_[name]`.
- **Field Keys & JSON Synchronization**:
  - To support version control, enable ACF Local JSON. All custom field configurations must be exported to an `acf-json` folder within the theme directory.
  - Never modify field keys manually in the database; alter configurations in JSON format to support safe database synchronization.
- **ACF Query & Escaping Safety**:
  - Always sanitize fields output based on their data type: `esc_url()` for link fields, `wp_kses_post()` for WYSIWYG, and `esc_html()` for plain text blocks.
  - Always check if custom rows exist before looping repeaters:
    ```php
    if ( have_rows( 'repeater_field_name' ) ) :
        while ( have_rows( 'repeater_field_name' ) ) : the_row();
            // Output template logic
        endwhile;
    endif;
    ```
- **REST Response Schema**: Standardize all JSON outputs for API endpoints:
  - **Success**: `{ "success": true, "data": { ... } }`
  - **Error**: `{ "success": false, "error": { "code": "error_code", "message": "readable error details" } }`

## 23. Forms & AJAX Handlers
- **Nonces Protection**: Every form must output a hidden nonce field using `wp_nonce_field()`. AJAX handlers must verify nonces using `check_ajax_referer()` or `wp_verify_nonce()` immediately upon receipt.
- **Double Validation**: Always validate user data on the server side. Frontend HTML5 or Alpine.js validation is solely for User Experience (UX) and must not replace backend sanitization check steps.
- **Format Verification**: Enforce standard rules for fields:
  - Postal codes must be exactly 5 digits.
  - Phone numbers must be parsed to numbers and standard symbols `0-9`, `+`, `-`, `(`, `)`.
  - Emails must be validated via `is_email()`.
- **Double Submission Guard**: Front-end forms must toggle a `disabled` attribute on submission buttons using Alpine.js or JS submit-handlers to prevent double-click API requests.

## 24. SEO & Schema Rules
- **Heading Hierarchy**: Enforce a strict heading structure. Each template must print exactly one `<h1>` element per page. Sub-sections must flow sequentially from `<h2>` through `<h6>`.
- **Image Accessibility & SEO**: Every render image tag must include an alt attribute. Provide a descriptive string for content-relevant images and an empty `alt=""` for purely decorative images.
- **Schema Integration**: Embed valid JSON-LD metadata schema blocks dynamically on appropriate modules (Organization/LocalBusiness on headers/footers, Article on single posts, Product on catalog items).
- **Polylang SEO Sync**: Ensure that `hreflang` tags are correctly enqueued in the header to point to matching translation variants on multi-language setups.

## 25. Performance Rules
- **Conditional Library Loading**: Only enqueue heavy third-party assets (e.g. Swiper, DateRangePicker) on page templates or widgets that explicitly render those assets.
- **DOM Optimization**: Avoid unnecessary HTML wrapper tags or deep nesting of columns inside Elementor builders to prevent bloating the DOM tree size.
- **WordPress Media Helpers**: Always pull media images using helper tags like `wp_get_attachment_image()` to leverage native responsive source sets (`srcset`) and lazy loading attributes instead of writing raw `<img>` tags.
- **Loop Query Caching**: Avoid issuing custom database or metadata queries inside template loops. Cache expensive queries (like navigation builds or location grids) using WordPress Transients with clear invalidation logic on save actions.

## 26. Design System Rules
- **Custom Properties Definition**: Utilize standardized CSS variables to manage colors, paddings, margins, and borders. Refrain from injecting static CSS styles:
  ```css
  --[project-slug]-color-primary
  --[project-slug]-color-secondary
  --[project-slug]-section-padding
  --[project-slug]-card-radius
  ```
- **Tailwind Compatibility**: Combine Elementor controls with Tailwind utility values to ensure styling scales appropriately across all break points.

## 27. Content & Translation Rules
- **Translation Integrity**:
  - Keep HTML structure, anchor tags, and styling classes intact when translating strings from TH to EN.
  - Never translate model numbers, serial codes, or official product names during string translations.
  - Post and product slugs must always be saved as lowercase hyphenated strings.
- **Tone Guidelines**: Use a formal business tone for corporate settings and legal documents, maintaining terminology alignment.

## 28. Scaffolding Templates & Workflow Actions
The following workflows define the step-by-step actions that developers and AI agents must follow when executing specific tasks.

### 28.1 Elementor Widget Creation Workflow (`create-elementor-widget.md` action)
When instructed to create a new Elementor widget, proceed as follows:
1. **Search Existing Widgets**: Check the widgets catalog to confirm the requested layout does not duplicate existing functionality.
2. **Create File Structure**: Set up 4 files inside `widgets/[widget-name]/`:
   - `[widget-name].php` (PHP controllers and settings schema)
   - `card.php` (Markup representation)
   - `[widget-name].css` (BEM styled attributes)
   - `[widget-name].js` (Interaction scripts)
3. **Register Widget**: Require the controller in the bootstrap class (`[project-slug]-elementor-addon.php`) and register using `$widgets_manager->register()`.
4. **Implement Dual-Rendering**: Code the PHP `render()` output and JavaScript `content_template()` templates identically.
5. **Verify Editor Performance**: Load the Elementor editor and test that options apply in real-time in the editor window.

### 28.2 Code Review Checklist (`review-code.md` action)
Prior to committing changes, inspect files using this checklist:
- **Security Check**: Confirm ABSPATH is checked, nonces are validated, database inputs prepared, and output escaped contextually.
- **JS Check**: Ensure dependencies are guarded, zero global name namespace leaks exist, and no inline scripts are used.
- **Compatibility**: Check that control/option/meta IDs match old layouts to keep data records stable.
- **Accessibility**: Ensure keyboard navigation, buttons, and `aria` indicators are present.

### 28.3 Bug Correction Steps (`fix-bug.md` action)
Follow this flow to debug issues:
1. **Read Rules**: Review priority rules files.
2. **Identify Root Cause**: Locate the bug by tracking execution logs or database dumps.
3. **Targeted Edit**: Implement a targeted patch. Avoid general refactoring of surrounding code.
4. **Backward Compatibility**: Ensure your fix does not alter key layouts or database hooks.
5. **Log Summary**: Summarize the files changed and methods used to correct the bug.