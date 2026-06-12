<?php

/**
 * Template part for displaying a news card in archive/index loops
 *
 * @package starter_theme
 */

$image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
$cats      = get_the_category();
$cat_name  = !empty($cats) ? esc_html($cats[0]->name) : '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('group h-full flex flex-col transition-all duration-500 hover:-translate-y-2'); ?>>

    <!-- Thumbnail -->
    <a href="<?php the_permalink(); ?>" class="relative aspect-4/3 rounded-sm overflow-hidden mb-5 block bg-[#f0f2f5] shrink-0">
        <?php if ($image_url) : ?>
            <img src="<?php echo esc_url($image_url); ?>"
                alt="<?php the_title_attribute(); ?>"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
        <?php else : ?>
            <div class="w-full h-full flex items-center justify-center bg-[#e8ecf0]">
                <span class="w-10 h-10 flex items-center justify-center text-[#adb5c2]"><i class="ri-arrow-right-line"></i></span>
            </div>
        <?php endif; ?>
        <?php if ($cat_name) : ?>
            <span class="absolute top-3 left-3 bg-primary text-white text-sm font-semibold uppercase tracking-wider px-2.5 py-1 rounded-sm">
                <?php echo $cat_name; ?>
            </span>
        <?php endif; ?>
    </a>

    <!-- Meta + Title + Read More -->
    <div class="flex flex-col grow gap-2">
        <span class="text-primary text-[13px] font-medium"><?php echo get_the_date('d F Y'); ?></span>
        <h3 class="text-sm font-medium text-[#27303f] line-clamp-2 m-0 group-hover:text-primary transition-colors duration-300">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <div class="mt-auto pt-2">
            <a href="<?php the_permalink(); ?>"
                class="inline-flex items-center gap-2 text-xs font-medium text-gray-800 group-hover:text-primary transition-colors duration-300">
                <span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
                <span class="group-hover:font-medium transition-all duration-300">อ่านเพิ่มเติม</span>
            </a>
        </div>
    </div>

</article>