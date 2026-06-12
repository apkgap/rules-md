<?php

/**
 * Sidebar content for single posts
 * 
 * @package starter_theme
 */

$cat_obj = $args['cat_obj'] ?? null;
?>

<!-- Search Widget (Elegant) -->
<div class="starter-theme-sidebar-widget mb-12">
    <form role="search" method="get" class="relative group" action="<?php echo home_url('/'); ?>">
        <input type="search" class="w-full bg-surface-base border border-border-base rounded-2xl py-4 pl-5 pr-12 text-sm text-base focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all font-sans shadow-sm"
            placeholder="<?php echo esc_attr_x('Search Articles...', 'placeholder', 'starter-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-muted group-hover:text-primary transition-colors">
                <span class="w-5 h-5 flex items-center justify-center">
                    <i class="ri-arrow-right-line"></i>
                </span>
        </button>
    </form>
</div>

<!-- Related Posts Widget (Premium List) -->
<?php
$related_args = [
    'post_type'      => 'post',
    'posts_per_page' => 5,
    'post__not_in'   => [get_the_ID()],
    'orderby'        => 'date',
    'order'          => 'DESC',
];
if ($cat_obj) {
    $related_args['category__in'] = [$cat_obj->term_id];
}
$related = new WP_Query($related_args);
if ($related->have_posts()) : ?>
    <div class="starter-theme-sidebar-widget mb-12">
        <h4 class="font-display text-[14px] font-medium text-muted mb-8 uppercase tracking-[0.2em] flex items-center gap-3">
            <span class="w-8 h-px bg-primary opacity-30"></span>
            <?php echo esc_html__('บทความที่น่าสนใจ', 'starter-theme'); ?>
        </h4>
        <div class="space-y-8">
            <?php while ($related->have_posts()) : $related->the_post(); ?>
                <?php get_template_part('template-parts/post-card-list'); ?>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
    </div>
<?php endif; ?>