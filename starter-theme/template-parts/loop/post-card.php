<?php
/**
 * Template part for displaying posts in a loop/archive grid
 * 
 * Styled to match premium forex sites
 * 
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$post_id = get_the_ID();
$cat = get_the_category($post_id);
$main_cat = !empty($cat) ? $cat[0] : null;
?>

<article class="starter-theme-post-card group bg-surface-base rounded-2xl border border-border-base shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden flex flex-col h-full">

    <!-- Image Wrap -->
    <a href="<?php the_permalink(); ?>" class="relative block aspect-video overflow-hidden">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110']); ?>
        <?php else : ?>
            <div class="w-full h-full bg-bg-base flex items-center justify-center">
                <span class="w-10 h-10 text-muted opacity-20 flex items-center justify-center">
                    <i class="ri-arrow-right-line"></i>
                </span>
            </div>
        <?php endif; ?>

        <!-- Category Overlay -->
        <?php if ($main_cat) : ?>
            <span class="absolute top-4 left-4 px-3 py-1 bg-primary text-white text-sm font-bold uppercase tracking-widest rounded-full shadow-lg z-10">
                <?php echo esc_html($main_cat->name); ?>
            </span>
        <?php endif; ?>
    </a>

    <!-- Content Wrap -->
    <div class="p-5 md:p-6 flex flex-col flex-1">
        <!-- Meta -->
        <div class="flex items-center gap-2 mb-3 text-[11px] text-muted font-bold uppercase tracking-wider">
                <span class="w-3 h-3 text-primary flex items-center justify-center">
                    <i class="ri-arrow-right-line"></i>
                </span>
            <span><?php echo cttm_thai_date( get_the_ID(), 'short' ); ?></span>
        </div>

        <!-- Title -->
        <h3 class="font-display md:text-[19px] font-bold text-base leading-tight mb-4 group-hover:text-primary transition-colors line-clamp-2">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <!-- Excerpt -->
        <div class="text-xs text-muted leading-relaxed mb-6 line-clamp-2 opacity-80">
            <?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?>
        </div>

        <!-- Footer -->
        <div class="mt-auto pt-4 border-t border-border-base flex items-center justify-between">
            <a href="<?php the_permalink(); ?>" class="text-xs font-bold text-primary flex items-center gap-1 group/btn">
                <?php echo esc_html__('อ่านเพิ่มเติม', 'starter-theme'); ?>
                <span class="w-3 h-3 transition-transform group-hover/btn:translate-x-1 flex items-center justify-center">
                    <i class="ri-arrow-right-line"></i>
                </span>
            </a>

            <div class="flex items-center gap-2 opacity-50">
                <?php
                $word_count = str_word_count(strip_tags(get_the_content()));
                $reading_time = ceil($word_count / 200);
                ?>
                <span class="w-3 h-3 flex items-center justify-center">
                    <i class="ri-arrow-right-line"></i>
                </span>
                <span class="text-[11px] font-medium"><?php echo esc_html($reading_time); ?> min</span>
            </div>
        </div>
    </div>
</article>