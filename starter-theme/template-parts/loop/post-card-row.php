<?php

/**
 * Template part for displaying posts in a loop/archive (Row/Horizontal Style)
 * 
 * Styled to match the horizontal card design with rich meta information.
 * 
 * @package starter_theme
 */

$post_id = get_the_ID();
$categories = get_the_category($post_id);
$tags = get_the_tags($post_id);

// Reading Time Calculation (Thai-friendly approximation)
$content = get_the_content($post_id);
$char_count = mb_strlen(strip_tags($content), 'UTF-8');
$reading_time = ceil($char_count / 800); // ~800-1000 chars per min for Thai
$reading_time = $reading_time > 0 ? $reading_time : 1;
?>

<article class="starter-theme-post-card-row group mb-12 md:mb-16 transition-all">
    <div class="flex flex-col md:flex-row gap-5 lg:gap-8 items-start">

        <!-- Image Section -->
        <div class="w-full md:w-72 lg:w-[340px] shrink-0">
            <a href="<?php the_permalink(); ?>" class="block relative aspect-1/1 rounded-4xl overflow-hidden shadow-2xl shadow-black/10 transition-all duration-500 group-hover:-translate-y-1 group-hover:shadow-primary/20">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
                <?php else : ?>
                    <div class="w-full h-full bg-bg-base flex items-center justify-center border border-border-base">
                <span class="text-5xl text-muted opacity-20 flex items-center justify-center">
                    <i class="ri-arrow-right-line"></i>
                </span>
                    </div>
                <?php endif; ?>

                <!-- Hover Overlay -->
                <div class="absolute inset-0 bg-primary/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </a>
        </div>

        <!-- Content Section -->
        <div class="flex-1 min-w-0 pt-1 lg:pt-2">

            <!-- Tags / Labels (colored capsules) -->
            <?php if (!empty($categories)) : ?>
                <div class="flex flex-wrap gap-1.5 mb-3">
                    <?php
                    $color_classes = ['bg-pink-100 dark:bg-pink-500/10 text-pink-500', 'bg-red-100 dark:bg-red-500/10 text-red-500', 'bg-blue-100 dark:bg-blue-500/10 text-blue-500', 'bg-purple-100 dark:bg-purple-500/10 text-purple-500'];
                    foreach (array_slice($categories, 0, 3) as $key => $cat) :
                        $color = $color_classes[$key % count($color_classes)];
                    ?>
                        <span class="px-4 py-1.5 <?php echo $color; ?> rounded-full text-[11px] font-bold uppercase tracking-widest leading-none border border-border-base/10 transition-colors">
                            <?php echo esc_html($cat->name); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Title -->
            <h3 class="font-display text-[20px] md:text-[24px] lg:text-[26px] font-bold text-base leading-tight mb-2 group-hover:text-primary transition-colors duration-300">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>

            <!-- Excerpt -->
            <div class="text-xs leading-relaxed mb-3 line-clamp-2 md:line-clamp-3 font-sans text-muted transition-colors">
                <?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?>
            </div>

            <!-- Meta Footer Area -->
            <div class="space-y-1 pt-3 border-t border-border-base transition-colors">
                <!-- Date -->
                <div class="flex items-center gap-2 text-muted/60">
                    <span class="w-3 h-3 text-gray-800 flex items-center justify-center">
                        <i class="ri-arrow-right-line"></i>
                    </span>
                    <span class="text-xs font-bold text-muted"><?php echo cttm_thai_date( get_the_ID(), 'full' ); ?></span>
                </div>

                <!-- Tags -->
                <?php if (!empty($tags)) : ?>
                    <div class="flex items-start gap-2 text-gray-400/80">
                        <span class="w-3 h-3 shrink-0 pt-0.5 flex items-center justify-center">
                            <i class="ri-arrow-right-line"></i>
                        </span>
                        <div class="text-xs font-medium leading-tight">
                            <?php
                            $tag_names = array_map(function ($t) {
                                return $t->name;
                            }, array_slice($tags, 0, 4));
                            echo esc_html(implode(', ', $tag_names));
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Reading Time -->
                <div class="flex items-center gap-2 text-muted/60">
                    <span class="w-3 h-3 flex items-center justify-center">
                        <i class="ri-arrow-right-line"></i>
                    </span>
                    <span class="text-xs font-medium"><?php echo $reading_time; ?> minute</span>
                </div>
            </div>

        </div>
    </div>
</article>