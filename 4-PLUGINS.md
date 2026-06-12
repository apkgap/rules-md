# Plugin Specific Guidelines

This document details the coding guidelines and standards for custom plugins, ACF configurations, forms, AJAX handlers, and WooCommerce integrations.

## 1. Member System & React SPA (`[project-slug]-account`)
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

## 2. Core Functional Setup (`[project-slug]-core`)
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

## 3. JSON Data Importer & AJAX Handlers (`[project-slug]-json-import`)
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

## 4. Admin Settings Rules
* All theme option pages and options-saving handlers must verify that the current user has the `manage_options` capability before processing.
* Nonces are mandatory for all form submissions to safeguard against CSRF (Cross-Site Request Forgery).
* Save only the options and settings that are relevant to the currently displayed admin settings page.
* Whitelist all allowed keys on submission to avoid parameter pollution.
* Option field names in forms must be kept fully aligned and matched with the keys retrieved via `[project_prefix]_get_option()`.

## 5. Advanced Custom Fields (ACF), Custom Post Types (CPT) & REST API
- **Naming Conventions**: All CPT and taxonomy slugs must be lowercase, snake_case, and prefixed with the project-specific handle: `[project_prefix]_[name]`.
- **Field Keys & JSON Synchronization**:
  - To support version control, enable ACF Local JSON. All custom field configurations must be exported to an `acf-json` folder within the theme directory.
  - Never modify field keys manually in the database; alter configurations in JSON format to support safe database synchronization.
- **ACF Query & Escaping Safety**:
  - Sanitize fields output: `esc_url()` for link fields, `wp_kses_post()` for WYSIWYG, and `esc_html()` for plain text blocks.
  - Check if custom rows exist before looping repeaters:
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

## 6. Forms & AJAX Handlers
- **Nonces Protection**: Every form must output a hidden nonce field using `wp_nonce_field()`. AJAX handlers must verify nonces using `check_ajax_referer()` or `wp_verify_nonce()` immediately upon receipt.
- **Double Validation**: Always validate user data on the server side. Frontend HTML5 or Alpine.js validation is solely for User Experience (UX) and must not replace backend sanitization check steps.
- **Format Verification**: Enforce standard rules for fields:
  - Postal codes must be exactly 5 digits.
  - Phone numbers must be parsed to numbers and standard symbols `0-9`, `+`, `-`, `(`, `)`.
  - Emails must be validated via `is_email()`.
- **Double Submission Guard**: Front-end forms must toggle a `disabled` attribute on submission buttons using Alpine.js or JS submit-handlers to prevent double-click API requests.

## 7. WooCommerce Rules & Guidelines
- **No Direct Template Modifications**: Do not modify WooCommerce templates directly. Always prioritize standard action and filter hooks. If template overrides are required, copy the file to `[theme-slug]/woocommerce/` maintaining identical file hierarchy.
- **Data Escaping**: Always escape prices, product titles, and product images in template outputs using context-specific helpers (e.g., `wc_price()`, `esc_html()`, `wp_kses_post()`).
- **Product Import & Deduplication**:
  - Always use SKU as the unique product identifier during manual or automated syncing. Never use the product name as the unique key since translations may alter text strings.
  - Normalize image filenames before matching during imports. Sanitize filenames to lowercase, remove special symbols, and map `.webp` extensions properly to avoid generating duplicate attachments in the Media Library.
- **Multilingual Integration (Polylang/WPML)**:
  - Keep TH and EN records mapped correctly using parent-translation meta.
  - When importing translated catalog assets, verify that the translation linkage is explicitly saved in database relations to prevent isolated, orphaned records.
