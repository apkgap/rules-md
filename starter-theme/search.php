<?php

/**
 * The template for displaying search results pages
 *
 * @package starter_theme
 */

get_header();

$paged       = max(1, get_query_var('paged'));
$search_q    = get_search_query();
$filter_year = absint($_GET['year'] ?? 0);
$archive_url = home_url('/');

// Total results count
global $wp_query;
$total_results = $wp_query->found_posts;
$total_pages   = $wp_query->max_num_pages;

// Years available (to filter search results by year if needed)
global $wpdb;
$year_sql = "SELECT DISTINCT YEAR(p.post_date) AS y FROM {$wpdb->posts} p WHERE p.post_status = 'publish' AND p.post_type = 'post'";
$years    = $wpdb->get_col($year_sql . " ORDER BY y DESC");
?>

<div x-data="{ sidebarOpen: false }" class="bg-bg-base min-h-screen pb-20">

    <!-- PAGE HEADER -->
    <?php get_template_part('template-parts/archive-header', null, [
        'title'       => $search_q,
        'description' => sprintf(esc_html__('พบข้อมูลทั้งหมด %s รายการที่ตรงกับคำค้นหาของคุณ', 'starter-theme'), '<strong class="text-base">' . $total_results . '</strong>')
    ]); ?>

    <!-- CONTENT BODY -->
    <div id="search-content-body" class="starter-theme-archive-body  relative z-10">
        <div class="p-container">
            <div class="flex flex-col lg:flex-row gap-12 xl:gap-20 items-start">

                <!-- MAIN LIST COLUMN -->
                <div class="flex-1 min-w-0">

                    <?php if (have_posts()) : ?>
                        <div class="space-y-12">
                            <?php while (have_posts()) : the_post(); ?>
                                <?php get_template_part('template-parts/post-card-row'); ?>
                            <?php endwhile; ?>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-16">
                            <?php starter_theme_render_pagination(); ?>
                        </div>

                    <?php else : ?>
                        <?php get_template_part('template-parts/content-none'); ?>
                    <?php endif; ?>
                </div>

                <!-- DESKTOP SIDEBAR -->
                <aside id="desktop-sidebar" class="hidden lg:block w-[320px] xl:w-[350px] sticky top-28 space-y-8">
                    <?php get_template_part('template-parts/archive-sidebar', null, [
                        'archive_url'       => home_url('/'),
                        'search_q'          => $search_q,
                        'years'             => $years,
                        'filter_year'       => $filter_year,
                        'search_field_name' => 's',
                        'is_search'         => true
                    ]); ?>
                </aside>
            </div>
        </div>
    </div>

    <!-- MOBILE STICKY FAB -->
    <div class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur-md border-t border-[#e2e6ee] px-4 py-3">
        <div class="flex gap-3 max-w-lg mx-auto">
            <button @click="sidebarOpen = true"
                class="flex-1 inline-flex items-center justify-center gap-2 py-3 bg-primary hover:bg-primary/90 text-white rounded-full font-light text-sm transition-all shadow-lg shadow-primary/20">
                <span class="w-5 h-5 flex items-center justify-center"><i class="ri-search-line"></i></span>
                <?php echo esc_html__('ค้นหาและหมวดหมู่', 'starter-theme'); ?>
            </button>
        </div>
    </div>

    <!-- MOBILE SIDEBAR DRAWER -->
    <div x-cloak x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-400"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click.self="sidebarOpen = false"
        class="lg:hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm">

        <div x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-500 cubic-bezier(0.16, 1, 0.3, 1)"
            x-transition:enter-start="translate-y-full"
            x-transition:enter-end="translate-y-0"
            x-transition:leave="transition ease-in duration-400"
            x-transition:leave-start="translate-y-0"
            x-transition:leave-end="translate-y-full"
            class="absolute bottom-0 inset-x-0 bg-[#f9fafb] rounded-t-[2.5rem] shadow-2xl max-h-[90vh] overflow-hidden flex flex-col">

            <!-- Handle -->
            <div @click="sidebarOpen = false" class="flex justify-center pt-4 pb-2 shrink-0">
                <div class="w-12 h-1.5 bg-gray-300 rounded-full opacity-50"></div>
            </div>

            <!-- Content Area -->
            <div class="flex-1 overflow-y-auto p-8 pb-32">
                <div id="mobile-sidebar-content" class="space-y-8">
                    <?php get_template_part('template-parts/archive-sidebar', null, [
                        'archive_url'       => home_url('/'),
                        'search_q'          => $search_q,
                        'years'             => $years,
                        'filter_year'       => $filter_year,
                        'search_field_name' => 's',
                        'is_search'         => true
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
