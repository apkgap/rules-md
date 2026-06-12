<?php
/**
 * Template part for displaying posts in a grid
 * 
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$post_id = get_the_ID();
$thumb_url = get_the_post_thumbnail_url($post_id, 'medium_large');
?>

<article id="post-card-grid-<?php echo esc_attr($post_id); ?>" class="starter-theme-post-card-grid starter-theme-post-grid group block space-y-4">
    <a href="<?php the_permalink(); ?>" class="starter-theme-post-grid__link block">
        <!-- Image Wrap -->
        <div id="post-card-grid-img-<?php echo esc_attr($post_id); ?>" class="starter-theme-post-grid__image-wrap aspect-16/10 rounded-2xl overflow-hidden border border-border-base/50 shadow-sm transition-all duration-500 group-hover:scale-[1.03] group-hover:shadow-lg group-hover:shadow-primary/5">
            <?php if ($thumb_url) : ?>
                <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <?php else : ?>
                <div class="w-full h-full bg-surface-base flex items-center justify-center">
                    <span class="w-10 h-10 flex items-center justify-center text-muted/20"><i class="ri-arrow-right-line"></i></span>
                </div>
            <?php endif; ?>
        </div>
    </a>

    <!-- Meta & Title -->
    <div id="post-card-grid-content-<?php echo esc_attr($post_id); ?>" class="starter-theme-post-grid__content space-y-2 px-1">
        <div id="post-card-grid-meta-<?php echo esc_attr($post_id); ?>" class="starter-theme-post-grid__meta flex items-center gap-3">
            <span id="post-card-grid-date-<?php echo esc_attr($post_id); ?>" class="starter-theme-post-grid__date text-xs font-medium text-primary uppercase tracking-widest"><?php echo cttm_thai_date( get_the_ID(), 'short' ); ?></span>
            <span class="starter-theme-post-grid__divider w-1 h-1 bg-border-base rounded-full opacity-50"></span>
            <?php
            $cats = get_the_category();
            if ($cats) : ?>
                <span id="post-card-grid-cat-<?php echo esc_attr($post_id); ?>" class="starter-theme-post-grid__category text-xs font-light text-muted uppercase tracking-wider"><?php echo esc_html($cats[0]->name); ?></span>
            <?php endif; ?>
        </div>
        <h4 id="post-card-grid-title-<?php echo esc_attr($post_id); ?>" class="starter-theme-post-grid__title font-medium text-sm leading-snug group-hover:text-primary transition-colors line-clamp-2 m-0 font-display">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h4>
    </div>
</article>