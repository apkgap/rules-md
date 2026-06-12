<?php

/**
 * Template part for displaying posts in a loop/archive (Large Row Style)
 *
 * @package starter_theme
 */

$post_id = get_the_ID();
$categories = get_the_category($post_id);
$tags = get_the_tags($post_id);

// Reading Time Calculation
$content = get_the_content($post_id);
$char_count = mb_strlen(strip_tags($content), 'UTF-8');
$reading_time = ceil($char_count / 800);
$reading_time = $reading_time > 0 ? $reading_time : 1;
?>

<article id="post-card-row-<?php echo $post_id; ?>" class="starter-theme-post-card-row starter-theme-post-row group mb-10 md:mb-14 transition-all">
    <div id="row-inner-<?php echo $post_id; ?>" class="starter-theme-post-row__inner flex flex-col md:flex-row gap-6 lg:gap-10 items-start">

        <!-- Image Section -->
        <div id="row-img-wrap-<?php echo $post_id; ?>" class="starter-theme-post-row__image-wrap w-full md:w-64 lg:w-[320px] shrink-0">
            <a id="row-img-link-<?php echo $post_id; ?>" href="<?php the_permalink(); ?>" class="starter-theme-post-row__image-link block relative aspect-16/10 md:aspect-square rounded-4xl md:rounded-[3rem] overflow-hidden shadow-2xl shadow-black/5 transition-all duration-500 group-hover:-translate-y-1 group-hover:shadow-primary/10 border border-border-base/10">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110']); ?>
                <?php else : ?>
                    <div class="w-full h-full bg-surface-base flex items-center justify-center">
                        <span class="w-12 h-12 flex items-center justify-center text-muted opacity-20"><i class="ri-arrow-right-line"></i></span>
                    </div>
                <?php endif; ?>
                <div class="absolute inset-0 bg-primary/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </a>
        </div>

        <!-- Content Section -->
        <div class="flex-1 min-w-0 pt-1">

            <!-- Category Badge -->
            <?php if (!empty($categories)) : ?>
                <div id="row-cat-wrap-<?php echo $post_id; ?>" class="starter-theme-post-row__category-wrap flex flex-wrap gap-2 mb-4">
                    <span id="row-cat-badge-<?php echo $post_id; ?>" class="starter-theme-post-row__category px-4 py-1.5 bg-primary/5 text-primary rounded-full text-xs font-light uppercase tracking-widest leading-none border border-primary/10 transition-colors">
                        <?php echo esc_html($categories[0]->name); ?>
                    </span>
                </div>
            <?php endif; ?>

            <!-- Title -->
            <h3 id="row-title-<?php echo $post_id; ?>" class="starter-theme-post-row__title font-display text-[22px] md:text-[28px] font-medium text-base leading-tight mb-4 group-hover:text-primary transition-colors duration-300 tracking-tight">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>

            <!-- Excerpt -->
            <div id="row-excerpt-<?php echo $post_id; ?>" class="starter-theme-post-row__excerpt text-[13px] leading-relaxed mb-5 line-clamp-2 md:line-clamp-3 text-muted/80 opacity-90">
                <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
            </div>

            <!-- Read More Button -->
            <div id="row-readmore-<?php echo $post_id; ?>" class="starter-theme-post-row__readmore mb-6">
                <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary hover:text-primary/80 transition-colors duration-300 group/btn tracking-wider uppercase">
                    <span><?php echo esc_html__('อ่านเพิ่มเติม', 'starter-theme'); ?></span>
                    <i class="ri-arrow-right-line transition-transform duration-300 group-hover/btn:translate-x-1"></i>
                </a>
            </div>

            <!-- Meta Footer -->
            <div id="row-meta-<?php echo $post_id; ?>" class="starter-theme-post-row__meta flex flex-wrap items-center gap-x-6 gap-y-3 pt-5 border-t border-border-base/40 text-sm font-medium text-muted uppercase tracking-wider">
                <div id="row-date-<?php echo $post_id; ?>" class="starter-theme-post-row__date flex items-center gap-2">
                    <span class="w-5 h-5 flex items-center justify-center text-gray-800"><i class="ri-calendar-line"></i></span>
                    <?php echo cttm_thai_date( get_the_ID(), 'short' ); ?>
                </div>
                <div class="starter-theme-post-row__reading-time flex items-center gap-2">
                    <span class="w-5 h-5 flex items-center justify-center text-gray-800"><i class="ri-timer-line"></i></span>
                    <?php echo $reading_time; ?> <?php echo esc_html__('นาที', 'starter-theme'); ?>
                </div>
                <?php if (!empty($tags)) : ?>
                    <div id="row-tag-<?php echo $post_id; ?>" class="starter-theme-post-row__tag hidden sm:flex items-center gap-2 max-w-[200px] truncate">
                        <span class="w-5 h-5 flex items-center justify-center text-gray-800"><i class="ri-price-tag-3-line"></i></span>
                        <?php echo esc_html($tags[0]->name); ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</article>
