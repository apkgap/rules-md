<?php

/**
 * The template for displaying archive pages
 *
 * @package starter_theme
 */

get_header();

$paged       = max(1, get_query_var('paged'));
$search_q    = sanitize_text_field($_GET['keyword'] ?? '');
$filter_year = absint($_GET['year'] ?? 0);
$queried_obj = get_queried_object();
$archive_url = '';

if ( is_category() ) {
	$archive_url = get_category_link( $queried_obj );
} elseif ( $queried_obj instanceof WP_Term ) {
	$archive_url = get_term_link( $queried_obj );
} elseif ( is_author() ) {
	$archive_url = get_author_posts_url( get_queried_object_id() );
} else {
	$archive_url = get_post_type_archive_link( get_post_type() );
}

if ( is_wp_error( $archive_url ) ) {
	$archive_url = '';
}
$archive_title = wp_strip_all_tags(get_the_archive_title());
$cat_obj = is_category() ? get_queried_object() : null;

// Apply search/year on top of the current archive query
$query_args = $GLOBALS['wp_query']->query_vars;
$query_args['posts_per_page'] = 12;
$query_args['paged']          = $paged;
if (!empty($search_q))    $query_args['s']    = $search_q;
if (!empty($filter_year)) $query_args['year'] = $filter_year;

$posts_query = new WP_Query($query_args);
$total       = $posts_query->max_num_pages;
$has_filter  = $search_q || $filter_year;

// Years available in this archive
global $wpdb;
$year_sql = "SELECT DISTINCT YEAR(p.post_date) AS y FROM {$wpdb->posts} p WHERE p.post_status = 'publish' AND p.post_type = 'post'";
$years    = $wpdb->get_col($year_sql . " ORDER BY y DESC");
?>

<div x-data="{ sidebarOpen: false }" class="bg-bg-base min-h-screen pb-20">

    <!-- PAGE HEADER -->
    <?php get_template_part('template-parts/archive-header'); ?>

    <!-- CONTENT BODY -->
    <div id="archive-content-body" class="starter-theme-archive-body  relative z-10">
        <div class="container">
            <div class="flex flex-col lg:flex-row gap-12 xl:gap-20 items-start">

                <!-- MAIN LIST COLUMN -->
                <div class="flex-1 min-w-0">

                    <!-- Result Info -->
                    <?php if ($has_filter) : ?>
                        <div class="bg-primary/5 border border-primary/10 rounded-2xl p-6 mb-10 flex items-center justify-between">
                            <p class="text-sm font-bold text-primary m-0 flex items-center">
                                <span class="w-3 h-3 flex items-center justify-center mr-2"><i class="ri-arrow-right-line"></i></span>
                                <?php printf(esc_html__('พบ %s รายการที่ตรงกับการค้นหา', 'starter-theme'), '<strong>' . $posts_query->found_posts . '</strong>'); ?>
                            </p>
                            <a href="<?php echo esc_url($archive_url); ?>" class="text-xs font-bold text-muted hover:text-red-500 transition-colors uppercase tracking-widest flex items-center">
                                <span class="w-3 h-3 flex items-center justify-center mr-1"><i class="ri-arrow-right-line"></i></span> <?php echo esc_html__('ล้างทั้งหมด', 'starter-theme'); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if ($posts_query->have_posts()) : ?>
                        <div class="space-y-12">
                            <?php while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
                                <?php get_template_part('template-parts/post-card-row'); ?>
                            <?php endwhile;
                            wp_reset_postdata(); ?>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-16">
                            <?php starter_theme_render_pagination($posts_query); ?>
                        </div>

                    <?php else : ?>
                        <?php get_template_part('template-parts/content-none', null, [
                            'has_filter'  => $has_filter,
                            'archive_url' => $archive_url,
                        ]); ?>
                    <?php endif; ?>
                </div>

                <!-- DESKTOP SIDEBAR -->
                <aside id="desktop-sidebar" class="hidden lg:block w-[320px] xl:w-[350px] sticky top-28 space-y-8">
                    <?php get_template_part('template-parts/archive-sidebar', null, [
                        'archive_url' => $archive_url,
                        'search_q'    => $search_q,
                        'years'       => $years,
                        'filter_year' => $filter_year,
                        'cat_obj'     => $cat_obj
                    ]); ?>
                </aside>
            </div>
        </div>
    </div>

    <!-- MOBILE STICKY FAB -->
    <div class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-surface-base/95 backdrop-blur-md border-t border-border-base px-4 py-3 transition-colors duration-500">
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
            class="absolute bottom-0 inset-x-0 bg-bg-base rounded-t-[2.5rem] shadow-2xl max-h-[90vh] overflow-hidden flex flex-col">

            <!-- Handle -->
            <div @click="sidebarOpen = false" class="flex justify-center pt-4 pb-2 shrink-0">
                <div class="w-12 h-1.5 bg-border-base rounded-full opacity-50"></div>
            </div>

            <!-- Content Area -->
            <div class="flex-1 overflow-y-auto p-8 pb-32">
                <!-- Reuse Filter in Drawer too? Yes, but inside the same template part approach -->
                <div id="mobile-sidebar-content" class="space-y-8">
                    <?php get_template_part('template-parts/archive-sidebar', null, [
                        'archive_url' => $archive_url,
                        'search_q'    => $search_q,
                        'years'       => $years,
                        'filter_year' => $filter_year,
                        'cat_obj'     => $cat_obj
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
