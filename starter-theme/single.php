<?php

/**
 * The template for displaying all single posts
 * 
 * Styled to match premium forex educational sites like forexinthai
 * 
 * @package starter_theme
 */

get_header();

while (have_posts()) : the_post();

    // Data handling
    $post_id    = get_the_ID();
    $image_url  = get_the_post_thumbnail_url($post_id, 'full');
    $cats       = get_the_category();
    $cat_obj    = !empty($cats) ? $cats[0] : null;
    $author_id  = get_the_author_meta('ID');
    $author_name = get_the_author();
    $author_url = get_author_posts_url($author_id);
    $author_avatar = get_avatar($author_id, 96);
?>

    <article id="post-<?php the_ID(); ?>"
        x-data="{ sidebarOpen: false }"
        <?php post_class('starter-theme-single-article bg-bg-base min-h-screen transition-colors duration-500'); ?>>

        <!-- CALL REFACTORED ARTICLE HEADER -->
        <?php starter_theme_article_header(); ?>

        <!-- MAIN LAYOUT -->
        <div class="starter-theme-article-container relative overflow-visible">
            <div class="p-container">
                <div class="flex flex-col lg:flex-row gap-12 xl:gap-20 items-start">

                    <!-- CONTENT COLUMN -->
                    <div class="flex-1 min-w-0">

                        <!-- Featured Image (Modern Floating Frame) -->
                        <?php if ($image_url) : ?>
                            <div class="starter-theme-featured-image-wrap mb-8 md:mb-12 relative group">
                                <div class="absolute -inset-1.5 md:-inset-3 bg-primary/5 rounded-2xl md:rounded-[40px] -z-10 transition-transform duration-700 group-hover:scale-[1.01]"></div>
                                <div class="w-full aspect-21/10 lg:aspect-21/9 overflow-hidden rounded-xl md:rounded-[32px] shadow-xl border border-white/10">
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="starter-theme-article-inner mx-auto">

                            <!-- Content Area -->
                            <div class="starter-theme-entry-content font-sans text-xs text-base/90 prose dark:prose-invert max-w-none">
                                <?php the_content(); ?>
                            </div>

                            <!-- Pagination within post -->
                            <?php wp_link_pages(['before' => '<div class="page-links mt-16 py-8 border-t border-border-base flex items-center gap-6 text-[15px] font-medium">' . esc_html__('สารบัญหน้าถัดไป:', 'starter-theme'), 'after' => '</div>']); ?>

                            <!-- Refined Tag Cloud (Premium Editorial Style) -->
                            <div class="starter-theme-post-tags mt-[2em] pt-[2em] border-t border-border-base/50 flex flex-wrap gap-2.5">
                                <span class="text-[9px] uppercase tracking-[0.15em] text-muted font-medium py-2.5 mr-2"><?php echo esc_html__('แท็ก:', 'starter-theme'); ?></span>
                                <?php
                                $tags = get_the_tags();
                                if ($tags) :
                                    foreach ($tags as $tag) : ?>
                                        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="px-4 py-2 bg-surface-base/40 hover:bg-primary hover:text-secondary text-base text-[11px] font-medium rounded-xl transition-all border border-border-base/60 hover:border-primary group">
                                            <span class="opacity-40 group-hover:opacity-100 italic mr-0.5 transition-opacity">#</span><?php echo $tag->name; ?>
                                        </a>
                                <?php endforeach;
                                endif; ?>
                            </div>

                            <!-- Related Posts Section (Horizontal Grid) -->
                            <div class="starter-theme-related-posts-bottom mt-[2em] pt-[2em] border-t border-border-base">
                                <h3 class="font-display text-2xl font-medium text-base mb-10 tracking-tight flex items-center gap-4">
                                    <span class="w-12 h-1 bg-primary rounded-full"></span>
                                    <?php echo esc_html__('บทความที่เกี่ยวข้อง', 'starter-theme'); ?>
                                </h3>
                                <?php
                                $related_bottom = new WP_Query([
                                    'post_type'      => 'post',
                                    'posts_per_page' => 3,
                                    'post__not_in'   => [get_the_ID()],
                                    'category__in'   => $cat_obj ? [$cat_obj->term_id] : [],
                                    'orderby'        => 'rand'
                                ]);
                                if ($related_bottom->have_posts()) : ?>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-10">
                                        <?php while ($related_bottom->have_posts()) : $related_bottom->the_post(); ?>
                                            <?php get_template_part('template-parts/post-card-grid'); ?>
                                        <?php endwhile;
                                        wp_reset_postdata(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>

                    <!-- REFINED DESKTOP SIDEBAR -->
                    <aside class="hidden lg:block w-[320px] xl:w-[380px] sticky top-28 space-y-12">
                        <?php get_template_part('template-parts/single-sidebar', null, ['cat_obj' => $cat_obj]); ?>
                    </aside>

                </div>
            </div>
        </div>

        <!-- MODERN MOBILE NAVIGATION (Pill Style) -->
        <div class="lg:hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-40">
            <button @click="sidebarOpen = true" class="bg-primary text-secondary px-6 py-3 rounded-full shadow-xl font-medium flex items-center gap-2 hover:bg-primary/90 transition-transform hover:scale-105 active:scale-95">
                <span class="w-5 h-5 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
                <span><?php echo esc_html__('เนื้อหาเพิ่มเติม', 'starter-theme'); ?></span>
            </button>
        </div>

        <!-- MOBILE SIDEBAR (Drawer) -->
        <div x-cloak x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-400"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click.self="sidebarOpen = false"
            class="lg:hidden fixed inset-0 z-50 bg-black/80 backdrop-blur-md">

            <div x-show="sidebarOpen"
                x-transition:enter="transition ease-out duration-500 cubic-bezier(0.16, 1, 0.3, 1)"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-400"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="absolute top-0 right-0 h-full w-[85%] max-w-sm bg-bg-base border-l border-border-base shadow-2xl flex flex-col">

                <!-- Header -->
                <div class="flex items-center justify-between px-8 py-8 border-b border-border-base shrink-0">
                    <h3 class="font-display text-base font-medium text-base m-0"><?php echo esc_html__('เนื้อหาเพิ่มเติ่ม', 'starter-theme'); ?></h3>
                    <button @click="sidebarOpen = false" class="w-10 h-10 flex items-center justify-center rounded-full bg-surface-base text-muted">
                        <span class="w-6 h-6 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
                    </button>
                </div>

                <!-- Content Area -->
                <div class="flex-1 overflow-y-auto p-6 space-y-10">
                    <?php get_template_part('template-parts/single-sidebar', null, ['cat_obj' => $cat_obj]); ?>
                </div>
            </div>
        </div>

    </article>

<?php
endwhile;

get_footer();
?>