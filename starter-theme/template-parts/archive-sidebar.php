<?php

/**
 * Template part for displaying archive sidebar (Filters + Single Sidebar)
 *
 * @package starter_theme
 *
 * Expected $args:
 * - archive_url (string)
 * - search_q (string)
 * - years (array)
 * - filter_year (int)
 * - cat_obj (object|null)
 */

$archive_url       = $args['archive_url'] ?? '';
$search_q          = $args['search_q'] ?? '';
$years              = $args['years'] ?? [];
$filter_year        = $args['filter_year'] ?? 0;
$cat_obj            = $args['cat_obj'] ?? null;
$search_field_name  = $args['search_field_name'] ?? 'keyword';
$is_search_mode     = $args['is_search'] ?? false;
?>

<!-- Archive Filter Widget (Universal) -->
<div id="starter-theme-archive-filter-widget" class="starter-theme-sidebar-widget bg-surface-base p-6 rounded-2xl border border-border-base shadow-sm transition-colors duration-500">
    <h4 id="archive-filter-title" class="font-display text-base font-bold text-base mb-6 uppercase tracking-wider flex items-center gap-2">
        <span class="w-5 h-5 flex items-center justify-center text-primary"><?php echo $is_search_mode ? '<i class="ri-search-line"></i>' : '<i class="ri-filter-3-line"></i>'; ?></span>
        <?php echo $is_search_mode ? esc_html__('ค้นหาใหม่', 'starter-theme') : esc_html__('กรองบทความ', 'starter-theme'); ?>
    </h4>
    <form id="archive-filter-form" method="GET" action="<?php echo esc_url($archive_url); ?>" class="space-y-4 text-left">
        <div id="filter-keyword-group">
            <?php if (!$is_search_mode) : ?>
                <label id="label-keyword" class="text-sm font-bold text-muted uppercase tracking-widest mb-2 block"><?php echo esc_html__('ค้นหา', 'starter-theme'); ?></label>
            <?php endif; ?>
            <div class="relative">
                <input id="filter-keyword-input" type="text" name="<?php echo esc_attr($search_field_name); ?>" value="<?php echo esc_attr($search_q); ?>" placeholder="<?php echo $is_search_mode ? esc_attr__('พิมพ์คำค้นหา...', 'starter-theme') : '...'; ?>" class="w-full bg-bg-base border border-border-base rounded-xl py-3 pl-4 pr-10 text-sm text-base focus:outline-none focus:border-primary transition-all">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 w-3 h-3 flex items-center justify-center text-border-base/50"><i class="ri-search-line"></i></span>
            </div>
        </div>
        <div id="filter-year-group">
            <label id="label-year" class="text-sm font-bold text-muted uppercase tracking-widest mb-2 block"><?php echo esc_html__('เลือกปี', 'starter-theme'); ?></label>
            <div class="relative">
                <select id="filter-year-select" name="year" class="w-full bg-bg-base border border-border-base rounded-xl py-3 px-4 text-sm text-base focus:outline-none focus:border-primary transition-all appearance-none cursor-pointer">
                    <option value=""><?php echo esc_html__('ทุกปี', 'starter-theme'); ?></option>
                    <?php if (!empty($years)) : ?>
                        <?php foreach ($years as $y) : ?>
                            <option value="<?php echo esc_attr($y); ?>" <?php selected($filter_year, $y); ?>><?php echo esc_html($y + 543); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <span class="absolute right-3 top-1/2 -translate-y-1/2 w-3 h-3 flex items-center justify-center text-border-base/50 pointer-events-none"><i class="ri-arrow-down-s-line"></i></span>
            </div>
        </div>
        <button id="filter-submit-btn" type="submit" class="group w-full py-3 flex items-center justify-center gap-2 bg-primary hover:bg-primary/95 text-white rounded-full font-light text-sm tracking-wide shadow-md shadow-primary/20 hover:shadow-lg hover:shadow-primary/35 transition-all duration-300 active:scale-[0.98]">
            <i class="ri-search-line text-base transition-transform duration-300 group-hover:scale-110"></i>
            <span><?php echo $is_search_mode ? esc_html__('ค้นหาข้อมูล', 'starter-theme') : esc_html__('กรองข้อมูล', 'starter-theme'); ?></span>
        </button>
    </form>
</div>

<!-- Recommended Posts Widget -->
<?php
$recommended_args = [
    'post_type'      => 'post',
    'posts_per_page' => 5,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
];
if ($cat_obj) {
    $recommended_args['category__in'] = [$cat_obj->term_id];
}
$recommended = new WP_Query($recommended_args);
if ($recommended->have_posts()) : ?>
    <div id="starter-theme-sidebar-recommended" class="starter-theme-sidebar-widget bg-surface-base p-6 rounded-2xl border border-border-base shadow-sm transition-colors duration-500 mt-6">
        <h4 id="sidebar-recommended-title" class="font-display text-sm font-bold text-muted uppercase tracking-[0.18em] mb-5 flex items-center gap-2.5">
            <span class="w-6 h-0.5 bg-primary opacity-40 rounded-full"></span>
            <?php echo esc_html__('บทความแนะนำ', 'starter-theme'); ?>
        </h4>
        <div id="sidebar-recommended-list" class="space-y-0 divide-y divide-border-base">
            <?php while ($recommended->have_posts()) : $recommended->the_post(); ?>
                <a id="sidebar-rec-<?php the_ID(); ?>" href="<?php echo esc_url(get_permalink()); ?>"
                    class="flex gap-3 items-start py-3.5 group hover:opacity-80 transition-opacity">
                    <!-- Thumbnail -->
                    <div class="shrink-0 w-16 h-16 rounded-xl overflow-hidden bg-border-base">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'thumbnail')); ?>"
                                alt="<?php the_title_attribute(); ?>"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" loading="lazy">
                        <?php else : ?>
                            <div class="w-full h-full bg-surface-base flex items-center justify-center">
                                <span class="w-6 h-6 flex items-center justify-center text-muted/40"><i class="ri-arrow-right-line"></i></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Text -->
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-base leading-snug line-clamp-2 group-hover:text-primary transition-colors font-display">
                            <?php echo wp_trim_words(get_the_title(), 10, '...'); ?>
                        </p>
                        <span class="text-[11px] text-muted mt-1 block"><?php echo get_the_date('j M Y'); ?></span>
                    </div>
                </a>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
    </div>
<?php endif; ?>
