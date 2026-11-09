---
name: wp-coding-rules
description: >-
  Enforces WordPress theme, Elementor widget (strict 3-file structure with NO card.php),
  and custom plugin coding standards, security rules, Tailwind/BEM styling patterns, and
  dual-rendering workflows. Always activate this skill before creating, editing, debugging,
  or reviewing any WordPress PHP, Elementor widget, theme template, Alpine.js/Swiper script,
  Tailwind CSS, WooCommerce, ACF/CPT, or WP REST/AJAX code.
---

# WordPress, Elementor & Theme Coding Rules (`wp-coding-rules`)

Activate and follow this skill whenever working on a WordPress theme (`[project-slug]-theme`), Elementor widget addon (`[project-slug]-elementor-addon`), or custom WordPress plugin (`[project-slug]-account`, `[project-slug]-core`, `[project-slug]-json-import`).

---

## 1. Which Reference File to Read

Read only the reference file(s) relevant to the current task to keep context focused:

| Task Scope | Reference File to Read |
| :--- | :--- |
| **Core PHP, Security, HTML (`id` before `class`), Asset Enqueue, Alpine/Swiper JS, Tailwind/CSS Variables** | [1-CORE.md](./references/1-CORE.md) |
| **Elementor Widgets (Strict 3-file structure, NO `card.php`, Inline Card Markup, Dual-Rendering `render()` + `content_template()`)** | [2-ELEMENTOR.md](./references/2-ELEMENTOR.md) |
| **WordPress Theme (`inc/`, `template-parts/`, Mega Menu, Footer, Polylang, Thai B.E. Date, Mobile Branches Sheet)** | [3-THEME.md](./references/3-THEME.md) |
| **Custom Plugins (Account SPA, Core Sticky Settings, JSON Importer, WooCommerce, ACF/CPT, Forms & AJAX)** | [4-PLUGINS.md](./references/4-PLUGINS.md) |
| **CI/CD, Git Branching (`dev` vs `main`), BrowserSync/Node Setup, Code Review & Bug-Fix Checklists** | [5-WORKFLOWS.md](./references/5-WORKFLOWS.md) |

---

## 2. Non-Negotiable Rules Summary (Always Enforce)

### A. Elementor Widgets — Strict 3-File Structure (NO `card.php`)
1. **Exactly 3 files per widget** in `widgets/[widget-name]/`:
   - `[widget-name].php` — Widget class extending `\Elementor\Widget_Base` (`get_name()`, `get_style_depends()`, `get_script_depends()`, `register_controls()`, `render()`, `content_template()`).
   - `[widget-name].css` — Scoped BEM styles (`.[project-slug]-[widget-name]__[element]--[modifier]`).
   - `[widget-name].js` — Frontend script hooked to `elementor/frontend/init` -> `frontend/element_ready/[widget-name].default`.
2. **NO `card.php` or external partials**:
   - **Never** create `card.php`, `template.php`, or `partials/` inside a widget folder.
   - **Never** use `set_query_var()` / `get_query_var()`, `include` / `require`, or `get_template_part()` to render widget cards/items.
   - Write all card/item HTML **inline** inside `render()` (or a `protected function render_card(...): void` method on the same widget class).
3. **Dual-Rendering Parity**:
   - Every structural HTML change, `id`/`class` attribute, or BEM class in `render()` **must** be mirrored in `content_template()`.
   - Use CSS variables in Elementor control `selectors` (`{{WRAPPER}} .selector { --[project-slug]-cols: {{VALUE}}; }`) so live preview updates without re-rendering PHP.
4. **Asset Registration**:
   - Register widget CSS/JS on `wp_enqueue_scripts` in the plugin bootstrap file (`[project-slug]-elementor-addon.php`) with `file_exists()` + `filemtime()` versioning and `true` (footer) for scripts.
   - Return handles from `get_style_depends()` and `get_script_depends()`. Never call `wp_enqueue_style()` or `wp_enqueue_script()` inside `render()`.

### B. Theme vs. Widget Card Separation
- **Theme Card Partials (`template-parts/cards/*.php`)**: Used **only** by theme templates (`archive.php`, `index.php`, `search.php`). They receive pre-queried data via `get_query_var()` and never execute `WP_Query` or business logic.
- **Elementor Widgets (`widgets/[widget-name]/[widget-name].php`)**: Self-contained inside the plugin; never call theme partials.

### C. HTML, Security & PHP Standards
- **`id` Before `class`**: Every HTML element with an `id` must place `id` before `class` (`<div id="item-1" class="card">`). Append unique post IDs or `$this->get_id()` in loops to avoid duplicate DOM IDs.
- **ABSPATH & Strict Types**: Start PHP files with `declare(strict_types=1);` (for classes/helpers) and `if ( ! defined( 'ABSPATH' ) ) { exit; }`.
- **Sanitization & Whitelisting**: Sanitize all inputs (`sanitize_text_field()`, `sanitize_key()`, `esc_url_raw()`, `sanitize_email()`). Whitelist `orderby` (`['date', 'title', 'menu_order', 'rand', 'ID']`) and `order` (`['ASC', 'DESC']`). Exclude `'attachment'` in `get_active_post_types()`.
- **Context-Specific Escaping**: Escape all outputs (`esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`, `esc_attr( wp_json_encode( ... ) )`). Use `wp_get_attachment_image()` instead of raw `<img>` tags.
- **Database, REST & AJAX**: Use `$wpdb->prepare()` for custom SQL, declare `permission_callback` on all REST routes, and verify nonces (`check_ajax_referer()` / `wp_verify_nonce()`) + capabilities (`current_user_can()`).

---

## 3. Pre-Completion Verification Checklist
Before finishing any task, verify:
1. [ ] Zero `card.php`, `set_query_var()`, or `get_template_part()` inside Elementor widgets; all 3 files (`.php`, `.css`, `.js`) exist for every widget.
2. [ ] `render()` and `content_template()` have matching HTML hierarchy and BEM classes.
3. [ ] `id` appears before `class` on HTML elements, and loop IDs are unique.
4. [ ] All inputs are sanitized/whitelisted and all outputs are escaped for their context.
5. [ ] Existing Elementor control IDs, option keys, meta keys, and REST schemas remain backward-compatible.
