<?php

/**
 * Template part for displaying posts in a small sidebar list
 * 
 * @package starter_theme
 */

$post_id = get_the_ID();
$rel_img = get_the_post_thumbnail_url($post_id, 'thumbnail');
?>

<article id="post-card-sidebar-<?php echo $post_id; ?>" class="starter-theme-post-card-sidebar starter-theme-post-sidebar group flex gap-5 items-center">
    <a id="sidebar-img-<?php echo $post_id; ?>" href="<?php the_permalink(); ?>" class="starter-theme-post-sidebar__image-wrap shrink-0 w-16 h-16 rounded-2xl overflow-hidden bg-surface-base border border-border-base transition-all duration-500 group-hover:scale-105 group-hover:shadow-lg group-hover:shadow-primary/5">
        <?php if ($rel_img) : ?>
            <img src="<?php echo esc_url($rel_img); ?>" alt="<?php the_title_attribute(); ?>" class="starter-theme-post-sidebar__image w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
        <?php else: ?>
            <div class="starter-theme-post-sidebar__placeholder w-full h-full flex items-center justify-center border border-border-base/10 group-hover:bg-primary/5">
                <span class="w-5 h-5 text-muted opacity-20 group-hover:text-primary group-hover:opacity-100 transition-all flex items-center justify-center">
                    <i class="ri-arrow-right-line"></i>
                </span>
            </div>
        <?php endif; ?>
    </a>

    <div id="sidebar-content-<?php echo $post_id; ?>" class="starter-theme-post-sidebar__content flex-1 min-w-0">
        <span id="sidebar-date-<?php echo $post_id; ?>" class="starter-theme-post-sidebar__date text-sm font-medium text-muted mb-1 block uppercase tracking-wider opacity-60"><?php echo cttm_thai_date( get_the_ID(), 'short' ); ?></span>
        <h5 id="sidebar-title-<?php echo $post_id; ?>" class="starter-theme-post-sidebar__title text-sm font-medium text-base leading-tight line-clamp-2 group-hover:text-primary transition-colors duration-300 font-display m-0">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h5>
    </div>
</article>