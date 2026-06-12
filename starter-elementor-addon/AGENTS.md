# Starter Elementor Addon — AGENTS.md

## Plugin Purpose
Custom Elementor widgets for Starter dental clinic site.

## Widget Stack
- **Interaction**: Alpine.js (`x-data`, `x-show`, etc.)
- **Styling**: Tailwind CSS v4 utility classes (from theme build)
- **Icons**: Remix Icon `<i class="ri-*">` tags

## Widget Structure (per widget)
```
widgets/[name]/
├── [name].php   — Elementor Widget_Base class, controls, render()
├── card.php     — Presentation-only template, uses $settings
├── [name].css   — CSS variables + any non-Tailwind custom styles
└── [name].js    — Alpine.js data factory or minimal init
```

## Rules
1. Each widget class name: `STARTER_Widget_[Name_With_Underscores]`
2. Assets registered ONLY via `get_style_depends()` / `get_script_depends()`
3. `card.php` must be presentation-only — no WP_Query, no heavy logic
4. All style selectors must use `{{WRAPPER}}` to prevent cross-instance leakage
5. CSS variable pattern for Elementor spacing controls:
   - Control selector: `'{{WRAPPER}} .widget-root' => '--starter-gap: {{SIZE}}{{UNIT}};'`
   - HTML: `style="gap: var(--starter-gap, 1.5rem);"`
6. `content_template()` must be safe — avoid complex Underscore.js logic that may trigger Safe Mode
7. All output in PHP templates must be escaped (`esc_html()`, `esc_url()`, `esc_attr()`, `wp_kses_post()`)
8. Colors default to theme CSS variables: `var(--primary)`, `var(--secondary)`

## Registered Widgets
| Slug          | Class                     | Section          |
|---------------|---------------------------|------------------|
| starter-hero       | STARTER_Widget_starter_Hero         | Hero Section     |
| starter-services   | STARTER_Widget_starter_Services     | Services Grid    |
| starter-why-us     | STARTER_Widget_starter_Why_Us       | Why Choose Us    |
| starter-promo      | STARTER_Widget_starter_Promo        | Pricing/Promo    |
| starter-reviews    | STARTER_Widget_starter_Reviews      | Testimonials     |
| starter-cta-banner | STARTER_Widget_starter_Cta_Banner   | CTA Banner       |
