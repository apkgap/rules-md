# Global Rules & Coding Patterns ([PROJECT-NAME] / [project-slug] Theme)

> [!NOTE]
> Replace the following placeholders with your specific project names and naming conventions:
> - `[PROJECT-NAME]`: Readable project name (e.g., `EXAT`, `KUSMILE`, `FROG`).
> - `[project-slug]`: Lowercase hyphenated slug for directories, text domains, and CSS namespaces (e.g., `exat-theme`, `exat-account`, `frog-footer`).
> - `[project_prefix]`: Lowercase snake_case prefix for functions, globals, and transients (e.g., `exat_theme_`, `exat_account_`).
> - `[PROJECT-PREFIX]`: Uppercase prefix for PHP classes, constants, and namespaces (e.g., `EXAT_`, `FROG_`).

## 1. Mandatory Pre-Execution Rule: Read Rules & Activate `wp-coding-rules` Skill
* **CRITICAL MANDATE**: Before writing any code, modifying configurations, or implementing any features, the AI agent **MUST activate the `wp-coding-rules` skill (`SKILL.md`) and read the relevant reference files based on priority**. Do not guess conventions or skip rule inspection.
* **Skill & Priority Order for File Inspection**:
  1. **Priority 0 (Skill Activation)**: Read the `wp-coding-rules` skill (`~/.gemini/config/skills/wp-coding-rules/SKILL.md` or `.agents/skills/wp-coding-rules/SKILL.md`) whenever working on WordPress, Elementor widgets, themes, or plugins.
  2. **Priority 1 (Core & Component Rules)**: `GEMINI.md`, component `AGENTS.md` files, and the modular rules (`1-CORE.md`, `2-ELEMENTOR.md`, `3-THEME.md`, `4-PLUGINS.md`, `5-WORKFLOWS.md`).
  3. **Priority 2 (Workflows & Review)**: `.windsurf/workflows/` (`write-code.md`, `read-rules.md`, `review.md`).
  4. **Priority 3 (Module Readmes)**: `README.md` in the target module directory.

## 2. Core Rules
- **Theme Templates & `template-parts/`**: Keep strictly focused on presentation. Never place business logic or `WP_Query` inside template parts.
- **Theme Card Partials (`template-parts/cards/`)**: Receive pre-queried data via `get_query_var()` only and must not run `WP_Query` or business logic.
- **No `card.php` in Elementor Widgets (STRICT)**: Elementor widgets must **NEVER** use `card.php`, `set_query_var()` / `get_query_var()`, `include`, or `get_template_part()` for their markup. All card/item markup must be written inline inside the widget class (`render()` or a private/protected `render_*()` helper method + mirrored in `content_template()`). See Section 9 and `2-ELEMENTOR.md`.
- **WP_Query Restriction**: Use `WP_Query` only within the controller layer or Elementor widget `render()` methods.
- **Reusable Logic**: Place reusable business and backend logic in `inc/` (for themes and plugins).
- **Security & Data Sanitization**: Sanitize all incoming PHP data before saving; escape all outputs in templates/widgets using context-specific WordPress escaping functions (`esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`, `esc_html__()`, `esc_html_e()`).
- **Styling & Layout**: Prefer Tailwind CSS utility classes for frontend styling, scoped BEM classes/IDs (`[project-slug]-[component]__*`), and explicit responsive behavior across mobile, tablet, and desktop.
- **Elementor & Assets**: Do not place Elementor widgets directly inside theme files. Register and enqueue all assets (JS, CSS) through standard WordPress enqueue functions.

## 3. HTML Conventions
- **`id` MUST come before `class`** on every HTML element that has an `id`. Example: `<div id="foo-1" class="bar">`.
- **Dynamic Loop IDs**: For repeating blocks or loops, append unique identifiers (e.g., post ID or widget instance `$this->get_id()` + loop index) to prevent duplicate DOM IDs.
- **Formatting Exception**: Follow during coding and review; must not block urgent production hotfixes.

## 4. Security
- **ABSPATH Check**: Every PHP file must start with:
  ```php
  if ( ! defined( 'ABSPATH' ) ) {
      exit; // Exit if accessed directly.
  }
  ```
- **Input Sanitization**: Sanitize all `$_POST`, `$_GET`, and control values before use (`sanitize_text_field()`, `sanitize_key()`, `esc_url_raw()`, `sanitize_textarea_field()`, `sanitize_email()`). Whitelist `orderby` and `order` parameters against allowed arrays.
- **Context-Specific Output Escaping**:
  - HTML text → `esc_html()` / `esc_html__()` / `esc_html_e()`
  - HTML attributes → `esc_attr()`
  - URLs → `esc_url()`
  - Rich text / WYSIWYG → `wp_kses_post()`
  - JSON in HTML attributes → `esc_attr( wp_json_encode( $data ) )`
- **Nonces & Capabilities**: Validate nonces (`check_ajax_referer()`, `wp_verify_nonce()`, `wp_nonce_field()`) and check capabilities (`current_user_can( 'manage_options' )`) before processing admin/form actions.
- **Password Exception**: NEVER sanitize password inputs (use phpcs ignore annotations) — WordPress hashes passwords internally.
- **REST API Protection**: Every `register_rest_route()` must declare a `permission_callback` (`current_user_can( 'manage_options' )` for admin routes, `is_user_logged_in()` for authenticated user routes).
- **SQL Safety**: Always use `$wpdb->prepare()` for custom SQL queries. Never concatenate user input into SQL.
- **File Upload Security**: Validate uploads with `wp_check_filetype_and_ext()`, handle via `wp_handle_upload()`, and enforce whitelisted MIME types and size limits.

## 5. PHP Patterns
- **Prefixing**: Prefix all global functions, classes, constants, and transients with `[project_prefix]_` or `[PROJECT-PREFIX]_`.
- **Namespaces & Strict Typing**: Declare `declare(strict_types=1);` at the top of newly created helper and class PHP files. Use `Inc\` or `App\` namespaces when supported.
- **Error Handling**:
  - **Redirect Flow**: Store errors in multisite-safe transients: `set_transient( '[project_prefix]_login_errors_' . get_current_blog_id(), $errors, 30 )`, then `get_transient()` + `delete_transient()`.
  - **REST & AJAX**: Return `new WP_Error( 'code', 'Message', [ 'status' => 400 ] )` or `wp_send_json_error( [ 'message' => '...' ], 400 )`.
- **Polylang Integration**: Always guard with `function_exists( 'pll_current_language' )` / `function_exists( 'pll_register_string' )`. Register strings in `after_setup_theme`. `[project_prefix]_get_option( $key )` checks `{key}_{lang}` before falling back to `{key}`.

## 6. Asset Enqueue
- **Safe Versioning (Cache Busting)**: Always check `file_exists()` and use `filemtime()` with theme/plugin version fallback:
  ```php
  $ver = file_exists( $path ) ? (string) filemtime( $path ) : $fallback_version;
  ```
- **Registration & Footer Loading**: Register assets via `wp_register_style()` / `wp_register_script()` before enqueueing. Load JS in the footer (`true` as 5th argument). Declare widget asset dependencies via `get_style_depends()` / `get_script_depends()` — never call `wp_enqueue_*()` inside widget `render()`.
- **Conditional Enqueue**: Load heavy libraries (Swiper, Lightbox, DateRangePicker) only on pages/widgets that require them.
- **Config & Nonce Localization**: Pass config via `wp_localize_script()` or `wp_add_inline_script( 'handle', 'window.[project_prefix]Config = ' . wp_json_encode( $config ) . ';', 'before' )`.

## 7. JS Stack
- **Alpine.js**: Declare state in `x-data` on wrapper elements. Guard with `if ( ! window.Alpine ) return;`.
- **Swiper**: Pass config via `data-swiper="<?php echo esc_attr( wp_json_encode( $swiper_config ) ); ?>"` and parse with `try { config = JSON.parse( el.dataset.swiper || '{}' ); } catch (e) { config = {}; }`. Guard with `if ( ! window.Swiper ) return;`.
- **React Layer**: Mount on `<div id="[project-slug]-[section]-root"></div>` and pass `apiUrl` + `nonce` (`wp_create_nonce( 'wp_rest' )`) via `wp_localize_script()`.
- **No Inline Scripts**: Never place inline `<script>` tags inside widget or page HTML templates.

## 8. CSS & Styling
- **Tailwind + CSS Variables**: Prioritize Tailwind utility classes. Use arbitrary values backed by CSS variables (e.g., `lg:w-[var(--custom-width,50%)]`) for user-controlled dimensions.
- **Tailwind Content Paths**: Scan `'./**/*.php'`, `'./src/**/*.js'`, `'./widgets/**/*.php'`.
- **CSS Variable Naming**: Prefix all custom properties (`--[project-slug]-widget-gap`, `--[project-slug]-card-padding`).
- **Elementor Spacing / Column Controls**: Output Elementor control values as CSS variables on selectors (`{{WRAPPER}} .selector { --[project-slug]-cols: {{VALUE}}; }`) and consume them with fallbacks in `.css` (`grid-template-columns: repeat(var(--[project-slug]-cols, 3), minmax(0, 1fr));`).
- **Flex & Grid Precedence**: Never combine `display: flex` and `display: grid` on the same class.
- **Loop Borders**: Omit `border-right` on the last item via `:not(:last-child)` or `:last-child { border-right: none !important; }`.
- **No Direct Layout Overwrites**: Do not hardcode dimensions/padding in widget `.css` when controlled by Elementor controls. Ensure styles work identically on frontend and Elementor Editor preview.

## 9. Elementor Widgets (`[project-slug]-elementor-addon`)
> [!IMPORTANT]
> **STRICT 3-FILE WIDGET RULE — NO `card.php`!**
> Every widget in `widgets/[widget-name]/` must contain **exactly 3 files**:
> 1. `[widget-name].php` — Widget class extending `\Elementor\Widget_Base` (controls, query helper, `render()`, `content_template()`, and inline card/item markup).
> 2. `[widget-name].css` — Scoped BEM styles (`.[project-slug]-[widget-name]__[element]--[modifier]`).
> 3. `[widget-name].js` — Frontend script bound to `elementor/frontend/init` -> `frontend/element_ready/[widget-name].default`.
>
> **FORBIDDEN inside widgets**: `card.php`, `template.php`, `partials/`, `set_query_var()`, `get_query_var()` (for passing template data), `include`/`require` of markup partials, or `get_template_part()`.

- **Widget Naming & Registration**:
  - Widget slug (`get_name()`): `[project-slug]-[widget-name]` (or `starter-[widget-name]`).
  - PHP class: `[PROJECT-PREFIX]_Widget_[Pascal_Case_Slug]` (e.g., `STARTER_Widget_Starter_Hero`).
  - CSS/JS handles: `[project-slug]-[widget-name]` registered in `[project-slug]-elementor-addon.php` on `wp_enqueue_scripts` and returned by `get_style_depends()` / `get_script_depends()`.
  - Text domain: `[project-slug]-elementor-addon`.
- **Inline Card Rendering**: Write card/item HTML directly inside the loop in `render()` (or in a `protected function render_card( ... ): void` method inside the same widget class). Never load external partial files.
- **Dual-Rendering Synchronization**: Any HTML structure, `id`/`class` order, wrapper tag, or BEM selector change in `render()` MUST be mirrored in `content_template()` (Underscore.js `<# ... #>` template; escape dynamic strings with `{{{ _.escape( settings.foo ) }}}` or `{{ settings.foo }}`; only output `{{{ iconHTML.value }}}` unescaped).
- **Safe Queries & Media in Widgets**:
  - Exclude `'attachment'` in `get_active_post_types()`.
  - Whitelist `orderby` (`['date', 'title', 'menu_order', 'rand', 'ID']`) and `order` (`['ASC', 'DESC']`).
  - Render post thumbnails with `wp_get_attachment_image()`, never raw `<img>` tags.
  - Always call `wp_reset_postdata()` after custom `WP_Query` loops.
- **Avoid Duplicate Widgets**: Check existing widgets before creating a new one:
  `career-archive-tabs`, `hero-slider`, `icon-grid-custom`, `icon-info-grid`, `parallax-hero`, `parallax-image`, `post-carousel`, `post-icon-grid`, `post-query-split`, `post-tabs-slider`, `service-grid`, `smart-card-repeater`, `split-text-image`, `strategic-highlights`, `strategic-timeline` (and the 20 `starter-*` widgets in `starter-elementor-addon/AGENTS.md`).

## 10. Theme Specific (`[project-slug]-theme`)
- **Theme Structure**:
  - `inc/`: `enqueue-scripts.php`, `theme-options.php`, `post-types.php`, `menu-fields.php`, `helpers.php`, `setup.php`.
  - `template-parts/`: `header/`, `footer/`, `cards/` (theme-only partials receiving data via `get_query_var()`), `sections/`.
- **`functions.php`**: Only includes files from `inc/` and hooks setup callbacks; zero business logic.
- **Mega Menu Fields (`inc/menu-fields.php`)**: Hook `wp_nav_menu_item_custom_fields` and `wp_update_nav_menu_item`. Whitelist `_[project_prefix]_mega_type` (`['', 'mega-1', 'mega-2', 'mega-3']`) and cast `_[project_prefix]_mega_image_id` to non-negative `(int)`. Enqueue `wp_enqueue_media()` on `nav-menus.php` only.
- **Theme Helpers (`inc/helpers.php`)**:
  - `[project_prefix]_get_header_position_class( $header_position, $sticky_disable_on = 'none', $sticky_z_class = 'z-40' )`: Returns Tailwind classes for `fixed`, `sticky` (with responsive disable breakpoints `none`, `mobile`, `tablet`, `mobile_tablet`), or `relative`.
  - `[project_prefix]_thai_date( $post = null, $format = 'short' )`: Converts post date to Thai Buddhist Era (`year + 543`) in `short`, `full`, or `no_year` format.
  - `[project_prefix]_language_switcher()`: Polylang + Alpine.js (`x-data="{ open: false }"`) dropdown switcher with escaped URLs and slugs.

## 11. Component & Configuration Settings
- **11.1 Footer (`template-parts/footer-[project-slug].php`)**: Presentation-only; options managed in `inc/theme-options.php`. Use scoped BEM (`[project-slug]-footer__*`) + Tailwind utilities + Alpine.js bottom-sheet for mobile drawers. Hide empty links/blocks (never render `<a href=""></a>`).
- **11.2 Admin Settings**: Verify `current_user_can( 'manage_options' )` and nonces on save; whitelist allowed option keys per page; align form field names with `[project_prefix]_get_option()`.
- **11.3 `ku-hero` Control IDs (Backward Compatibility)**: Preserve `stats_repeater_list`, `stats_columns`, `stat_item_padding`, `show_stat_dividers`, `stat_divider_color`, `stat_divider_width`, `stat_divider_style`, `content_section_width`, `image_section_width`.
- **11.4 Mobile Branches Sheet**: Retrieved via `[project_prefix]_get_option( 'header_branches' )` (Fallback colors: Branch 1 `#7a22cb`, Branch 2 `#bf80ff`). Schema: `[ [ 'title' => '', 'url' => '', 'color' => '', 'description' => '' ] ]`.

## 12. Plugin Specific Guidelines
- **12.1 `[project-slug]-account` (Member System & React SPA)**:
  - Redirect to `/account` after login/registration (`wp_set_current_user()` + `wp_set_auth_cookie()`). Never sanitize password inputs.
  - REST namespace: `account/v1` with `is_user_logged_in()` permission callback.
  - Citizen ID: Never store plain text; hash with `[project_prefix]_account_hash_citizen_id($id)` (SHA-256) and display via `[project_prefix]_account_mask_citizen_id($id)` (`*********XXXX`).
  - Meta keys: `first_name`, `last_name`, `phone`, `line_id`, `address_line_1`, `address_line_2`, `province`, `district`, `subdistrict`, `postcode`, `company_name`, `company_tax_id`, `company_branch`, `[project-slug]_sub`, `[project-slug]_citizen_id_last4`.
  - Reuse helpers in `inc/helpers.php`: `_hash_citizen_id`, `_mask_citizen_id`, `_validate_postcode` (5 digits), `_sanitize_phone` (`0-9 + - ( )`), `_rest_error`.
- **12.2 `[project-slug]-core`**: Whitelist sticky disable setting against `['none', 'mobile', 'tablet', 'mobile_tablet']` (default `'mobile_tablet'`). Use `plugin_dir_path()` / `plugin_dir_url()`, register assets before enqueueing, version with `filemtime()`, load JS in footer.
- **12.3 `[project-slug]-json-import`**: Singleton controller; verify `current_user_can( 'manage_options' )` + `check_ajax_referer()`; normalize URLs and deduplicate via `_[project_prefix]_original_url`; import posts as `draft` via `wp_insert_post()`; use `wp_safe_remote_get()` with timeouts and continue batch if a single media download fails; enqueue admin assets only on the plugin's admin page hook.

## 13. CI/CD (GitHub Deploy)
- Deploys only on push to `main` (`dev` does not deploy).
- Runs `npm ci && npm run build` for theme and account plugin before deploy.
- Excludes `.git*`, `node_modules/`, `src/`, `package.json`, `package-lock.json`, `AGENTS.md`.
- Secrets: `FTP_SERVER`, `FTP_USERNAME`, `FTP_PASSWORD`, `FTP_THEME_DIR`, `FTP_PLUGIN_DIR`.

## 14. Git Workflow
- **Commit Messages**: Conventional Commits (`feat:`, `fix:`, `style:`, `docs:`, `refactor:`, `chore:`).
- **Branching**: Active work goes to `dev` (`git checkout dev && git add . && git commit -m "..." && git push origin dev`). Merge `dev` into `main` and push `origin main` only when deploying or when explicitly instructed by the user.

## 15. Code Review & Bug Prevention Guidelines
- Verify logic, edge cases (empty arrays/nulls), security (ABSPATH, nonces, capabilities, context escaping, `$wpdb->prepare()`), and caching/transients.
- **JS Check**: DOM presence guards, library guards (`window.Alpine`, `window.Swiper`), no global leaks, no inline `<script>`.
- **Elementor Check**: Confirm **3-file widget structure** (`.php`, `.css`, `.js`) with **inline card markup** (zero `card.php`, `get_template_part()`, or `set_query_var()`), exact parity between `render()` and `content_template()`, `id` before `class`, and backward-compatible control IDs.

## 16. WordPress & Node.js Development Environment (Auto-Sync Setup)
- Use `browser-sync`, `npm-run-all`, `@tailwindcss/cli`, and `esbuild`.
- Standard scripts in `package.json`: `start` (`npm run dev`), `dev` (`npm-run-all --parallel watch:tailwind watch:js serve`), `serve` (BrowserSync proxy watching `./**/*.php,./dist/**/*.css,./dist/**/*.js` and ignoring `node_modules`, `vendor`, `.git`), `watch:tailwind`, `watch:js`, `build` (`npm-run-all build:js build:tailwind`), `build:tailwind` (`--minify`), `build:js` (`--bundle --minify`).

## 17. Senior Execution Protocol
1. Activate `wp-coding-rules` skill and read priority rule files before coding.
2. Inspect existing related files and reuse helpers, widgets, option/meta keys, REST routes, and CSS patterns.
3. Avoid duplicate systems or overlapping widgets; keep changes minimal and targeted.
4. Preserve backward compatibility for all persisted IDs and keys.
5. Apply full WordPress security standards and verify both frontend and Elementor editor rendering.
6. Run or document build steps when modifying `src/`, `dist/`, Tailwind, or JS bundles, and summarize changes clearly.

## 18. Backward Compatibility Rules
Never rename existing Elementor control IDs, CSS/BEM class names, WordPress option keys, post/user meta keys, REST route names, REST response keys, AJAX action names, or shortcode names unless a migration path or fallback is implemented.

## 19. Accessibility Rules
Use semantic HTML, `<button type="button">` instead of clickable `<div>`, keyboard-accessible focus states, appropriate `aria-expanded` / `aria-controls` / `aria-hidden` attributes, and meaningful `alt` text (or `alt=""` for decorative images).

## 20. Build Script Completion
All sub-scripts referenced by `npm run build` (`build:js`, `build:tailwind`) must exist and compile cleanly into `dist/`.

## 21. WooCommerce Rules
- Never modify core WooCommerce plugin templates directly; use hooks/filters or override in `[theme-slug]/woocommerce/`.
- Escape prices (`wc_price()`, ` wp_kses_post()`), titles (`esc_html()`), and images.
- Use **SKU** (never product title) as the unique identifier during imports/syncs, normalize image filenames (lowercase, strip special chars, map `.webp`), and preserve Polylang/WPML translation linkage.

## 22. ACF, Custom Post Types (CPT) & REST API
- Prefix CPT and taxonomy slugs in lowercase `snake_case`: `[project_prefix]_[name]`.
- Enable ACF Local JSON in `[theme-slug]/acf-json/`; never edit ACF field keys manually in the database.
- Guard repeater loops with `if ( have_rows( 'field' ) ) : while ( have_rows( 'field' ) ) : the_row(); ...` and escape outputs by field type.
- Standard REST responses: Success `{ "success": true, "data": { ... } }`, Error `{ "success": false, "error": { "code": "...", "message": "..." } }`.

## 23. Forms & AJAX Handlers
- Include `wp_nonce_field()` in every form and validate via `check_ajax_referer()` / `wp_verify_nonce()` on the server.
- Enforce server-side validation: 5-digit postcode, phone symbols `0-9 + - ( )`, `is_email()`.
- Guard submit buttons against double submission (`disabled` state via Alpine.js/JS).

## 24. SEO & Schema Rules
- Enforce a single `<h1>` per page with sequential `<h2>`–`<h6>` hierarchy.
- Output valid JSON-LD schema (`Organization`/`LocalBusiness`, `Article`, `Product`) and ensure Polylang `hreflang` tags are present.

## 25. Performance Rules
- Conditionally enqueue heavy assets only where used; minimize DOM nesting; always use `wp_get_attachment_image()` for native `srcset` and lazy loading; avoid SQL/meta queries inside template loops and cache expensive queries with WordPress Transients invalidated on save.

## 26. Design System Rules
- Define and consume scoped CSS variables (`--[project-slug]-color-primary`, `--[project-slug]-color-secondary`, `--[project-slug]-section-padding`, `--[project-slug]-card-radius`) combined with Tailwind responsive utilities.

## 27. Content & Translation Rules
- Preserve HTML tags, classes, model numbers, serial codes, and brand names when translating between TH and EN. Save slugs as lowercase hyphenated strings and maintain formal corporate terminology.

## 28. Scaffolding & Workflow Actions
- **28.1 Create Elementor Widget**: (1) Check existing widgets to avoid duplicates; (2) Create **3 files** in `widgets/[widget-name]/` (`[widget-name].php`, `.css`, `.js` — **never create `card.php`**); (3) Register widget & assets in `[project-slug]-elementor-addon.php`; (4) Implement inline card markup in `render()` and mirror it in `content_template()`; (5) Verify frontend and Elementor editor preview.
- **28.2 Code Review**: Verify Security (`ABSPATH`, nonces, caps, `$wpdb->prepare()`, escaping), JS guards, Elementor 3-file inline structure + dual-rendering parity, `id` before `class`, backward compatibility, and accessibility.
- **28.3 Bug Fix**: Read rules -> identify root cause -> apply minimal targeted patch preserving backward compatibility -> summarize changed files and verification steps.
