# Starter Elementor Addon — AGENTS.md

## Plugin Purpose
Custom Elementor widgets for Starter dental clinic site.

## Widget Stack
- **Interaction**: Alpine.js (`x-data`, `x-show`, etc.) / Swiper / PhotoSwipe
- **Styling**: Tailwind CSS v4 utility classes (from theme build) + BEM CSS variables
- **Icons**: Remix Icon `<i class="ri-*">` tags & `\Elementor\Icons_Manager::render_icon()`

## Widget Structure (per widget — 3 files, no `card.php`)
```
widgets/[name]/
├── [name].php   — Elementor Widget_Base class, controls, render() + content_template() (inline markup)
├── [name].css   — CSS variables + any non-Tailwind custom styles
└── [name].js    — Frontend interaction handler (optional if widget has no JS)
```

## Rules
1. Each widget class name: `STARTER_Widget_[Pascal_Case_Slug]` (resolved dynamically in `starter-elementor-addon.php`).
2. Assets registered on `wp_enqueue_scripts` and declared **only** via `get_style_depends()` / `get_script_depends()` — never call `wp_enqueue_*()` inside `render()`.
3. **No `card.php`** — card/item markup is written inline in `render()` (or a private `render_*()` helper method on the widget class) and mirrored in `content_template()`. Never use `card.php`, `set_query_var()` / `get_query_var()`, `include`, or `get_template_part()` inside widgets.
4. All style selectors must use `{{WRAPPER}}` to prevent cross-instance leakage.
5. CSS variable pattern for Elementor spacing/column controls:
   - Control selector: `'{{WRAPPER}} .starter-[name]__grid' => '--starter-[name]-gap: {{SIZE}}{{UNIT}};'`
   - Stylesheet: `gap: var(--starter-[name]-gap, 1.5rem);`
6. `content_template()` must match `render()` structure and stay safe — avoid complex Underscore.js logic that may trigger Elementor Safe Mode.
7. All output in PHP templates must be escaped (`esc_html()`, `esc_url()`, `esc_attr()`, `wp_kses_post()`).
8. Colors default to theme CSS variables: `var(--primary)`, `var(--secondary)`.

## Registered Widgets (20 total)
| Slug | Class | Section / Purpose |
|---|---|---|
| `starter-hero` | `STARTER_Widget_Starter_Hero` | Hero Banner Slider & Footer Stats |
| `starter-services` | `STARTER_Widget_Starter_Services` | Services Grid / Swiper Slider |
| `starter-why-us` | `STARTER_Widget_Starter_Why_Us` | Why Choose Us Highlights |
| `starter-feature-cards` | `STARTER_Widget_Starter_Feature_Cards` | Feature / Benefit Icon Cards |
| `starter-promo` | `STARTER_Widget_Starter_Promo` | Pricing / Promotions |
| `starter-reviews` | `STARTER_Widget_Starter_Reviews` | Patient Testimonials / Reviews |
| `starter-cta-banner` | `STARTER_Widget_Starter_Cta_Banner` | Call-to-Action Banner |
| `starter-posts` | `STARTER_Widget_Starter_Posts` | Posts / Articles Loop (Grid, List, Row) |
| `starter-posts-tabs` | `STARTER_Widget_Starter_Posts_Tabs` | Posts / Articles with Category Tabs |
| `starter-accordion` | `STARTER_Widget_Starter_Accordion` | Responsive Q&A / FAQ Accordion |
| `starter-info-cards` | `STARTER_Widget_Starter_Info_Cards` | Informational Cards Grid |
| `starter-post-grid` | `STARTER_Widget_Starter_Post_Grid` | Custom Post Type & Taxonomy Grid |
| `starter-steps` | `STARTER_Widget_Starter_Steps` | Step-by-Step Process Flow |
| `starter-gallery` | `STARTER_Widget_Starter_Gallery` | PhotoSwipe Lightbox Gallery |
| `starter-dual-heading` | `STARTER_Widget_Starter_Dual_Heading` | Dual-Tone Section Heading |
| `starter-stats` | `STARTER_Widget_Starter_Stats` | Key Metrics / Statistics Counter |
| `starter-dentists` | `STARTER_Widget_Starter_Dentists` | Dentists / Team Member Profiles |
| `starter-location-tabs` | `STARTER_Widget_Starter_Location_Tabs` | Clinic Branch Locations with Tabs |
| `starter-directions` | `STARTER_Widget_Starter_Directions` | Map & Clinic Directions |
| `starter-directions-social` | `STARTER_Widget_Starter_Directions_Social` | Directions & Social Channels |
