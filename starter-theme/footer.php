<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package starter_theme
 */

?>
<?php get_template_part('template-parts/footer-exat'); ?>

</div><!-- #page -->

<!-- Scroll to Top Button (Alpine.js) -->
<div x-data="{ show: false }"
	@scroll.window="show = (window.pageYOffset > 300)"
	x-show="show"
	x-transition:enter="transition ease-out duration-300"
	x-transition:enter-start="opacity-0 scale-90 translate-y-4"
	x-transition:enter-end="opacity-100 scale-100 translate-y-0"
	x-transition:leave="transition ease-in duration-200"
	x-transition:leave-start="opacity-100 scale-100 translate-y-0"
	x-transition:leave-end="opacity-0 scale-90 translate-y-4"
	class="fixed bottom-32 right-6 z-50">
	<button @click="window.scrollTo({top: 0, behavior: 'smooth'})"
		class="bg-primary text-white w-10 h-10 rounded-full shadow-2xl cursor-pointer transition-all duration-500 hover:bg-primary/90 flex items-center justify-center hover:scale-110 active:scale-95 border border-border-base/10"
		aria-label="Scroll to top">
		<span class="w-5 h-5 flex items-center justify-center"><i class="ri-arrow-up-s-line text-xl"></i></span>
	</button>
</div>

<?php
// Show filter sticky button only on procurement archive and taxonomy pages
$is_procurement_page = is_post_type_archive( 'procurement' ) || is_tax( 'procurement_category' );
if ( $is_procurement_page ) :
$current_term       = is_tax( 'procurement_category' ) ? get_queried_object() : null;
$selected_category  = isset( $_GET['procurement_category'] ) ? sanitize_text_field( wp_unslash( $_GET['procurement_category'] ) ) : '';
if ( $current_term instanceof WP_Term && '' === $selected_category ) {
	$selected_category = $current_term->slug;
}
$archive_link       = get_post_type_archive_link( 'procurement' );
?>
<!-- Sidebar Sticky Button & Bottom Sheet for Mobile/Tablet -->
<div x-data="{ sidebarOpen: false }" class="lg:hidden">
	<!-- Sidebar Sticky Button -->
	<button @click="sidebarOpen = true"
		class="fixed bottom-6 left-6 z-50 bg-white text-gray-700 w-14 h-14 rounded-full shadow-2xl cursor-pointer transition-all duration-500 hover:bg-gray-50 flex items-center justify-center hover:scale-110 active:scale-95 border border-gray-200"
		aria-label="Categories">
		<span class="w-6 h-6 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
	</button>

	<!-- Backdrop -->
	<div x-show="sidebarOpen"
		style="display: none;"
		x-transition:enter="transition-opacity ease-linear duration-300"
		x-transition:enter-start="opacity-0"
		x-transition:enter-end="opacity-100"
		x-transition:leave="transition-opacity ease-linear duration-300"
		x-transition:leave-start="opacity-100"
		x-transition:leave-end="opacity-0"
		@click="sidebarOpen = false"
		class="fixed inset-0 z-80 bg-black/60 backdrop-blur-sm">
	</div>

	<!-- Bottom Sheet -->
	<div x-cloak :class="sidebarOpen ? 'translate-y-0' : 'translate-y-full'"
		class="fixed inset-x-0 bottom-0 z-90 flex flex-col w-full bg-white rounded-t-3xl shadow-[0_-10px_40px_rgba(0,0,0,0.2)] max-h-[85vh] transition-transform duration-300 ease-in-out">

		<!-- Mobile Header -->
		<div class="flex items-center justify-between p-5 border-b border-gray-200 shrink-0">
			<h3 class="text-lg font-bold text-gray-900 m-0">
				<?php echo esc_html__( 'ประเภทจัดซื้อจัดจ้าง', 'starter-theme' ); ?>
			</h3>
			<button @click="sidebarOpen = false" class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">
				<span class="w-5 h-5 flex items-center justify-center">
					<i class="ri-arrow-right-line"></i>
				</span>
			</button>
		</div>

		<!-- Sidebar Navigation Content -->
		<div class="p-6 overflow-y-auto flex-1 overscroll-contain">
			<?php
			set_query_var( 'procurement_sidebar_category', $selected_category );
			set_query_var( 'procurement_sidebar_current_term', $current_term );
			set_query_var( 'procurement_sidebar_archive_link', $archive_link );
			set_query_var( 'procurement_sidebar_render_mode', 'mobile_popup' );
			get_template_part( 'template-parts/procurement-sidebar-nav' );
			?>
		</div>
	</div>
</div>

<!-- Filter Sticky Button & Bottom Sheet for Mobile/Tablet -->
<div x-data="{ filterOpen: false }" class="lg:hidden">
	<!-- Filter Sticky Button -->
	<button @click="filterOpen = true"
		class="fixed bottom-6 right-6 z-50 bg-primary text-white w-14 h-14 rounded-full shadow-2xl cursor-pointer transition-all duration-500 hover:bg-primary/90 flex items-center justify-center hover:scale-110 active:scale-95 border border-border-base/10"
		aria-label="Filter">
		<span class="w-6 h-6 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
	</button>

	<!-- Backdrop -->
	<div x-show="filterOpen"
		style="display: none;"
		x-transition:enter="transition-opacity ease-linear duration-300"
		x-transition:enter-start="opacity-0"
		x-transition:enter-end="opacity-100"
		x-transition:leave="transition-opacity ease-linear duration-300"
		x-transition:leave-start="opacity-100"
		x-transition:leave-end="opacity-0"
		@click="filterOpen = false"
		class="fixed inset-0 z-60 bg-black/60 backdrop-blur-sm">
	</div>

	<!-- Bottom Sheet -->
	<div x-cloak :class="filterOpen ? 'translate-y-0' : 'translate-y-full'"
		class="fixed inset-x-0 bottom-0 z-70 flex flex-col w-full bg-white rounded-t-3xl shadow-[0_-10px_40px_rgba(0,0,0,0.2)] max-h-[85vh] transition-transform duration-300 ease-in-out">

		<!-- Mobile Header -->
		<div class="flex items-center justify-between p-5 border-b border-gray-200 shrink-0">
			<h3 class="text-lg font-bold text-gray-900 m-0">
				<?php echo esc_html__( 'ตัวกรอง', 'starter-theme' ); ?>
			</h3>
			<button @click="filterOpen = false" class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">
				<span class="w-5 h-5 flex items-center justify-center">
					<i class="ri-arrow-right-line"></i>
				</span>
			</button>
		</div>

		<!-- Filter Form Content -->
		<div class="p-6 overflow-y-auto flex-1 overscroll-contain">
			<?php
			set_query_var( 'procurement_filter_search_term', isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '' );
			set_query_var( 'procurement_filter_category', isset( $_GET['procurement_category'] ) ? sanitize_text_field( wp_unslash( $_GET['procurement_category'] ) ) : '' );
			set_query_var( 'procurement_filter_start_date', isset( $_GET['procurement_start_date'] ) ? sanitize_text_field( wp_unslash( $_GET['procurement_start_date'] ) ) : '' );
			set_query_var( 'procurement_filter_end_date', isset( $_GET['procurement_end_date'] ) ? sanitize_text_field( wp_unslash( $_GET['procurement_end_date'] ) ) : '' );
			set_query_var( 'procurement_filter_has_filters', '' !== ( isset( $_GET['procurement_category'] ) ? sanitize_text_field( wp_unslash( $_GET['procurement_category'] ) ) : '' ) || '' !== ( isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '' ) || '' !== ( isset( $_GET['procurement_start_date'] ) ? sanitize_text_field( wp_unslash( $_GET['procurement_start_date'] ) ) : '' ) || '' !== ( isset( $_GET['procurement_end_date'] ) ? sanitize_text_field( wp_unslash( $_GET['procurement_end_date'] ) ) : '' ) );
			set_query_var( 'procurement_filter_archive_link', get_post_type_archive_link( 'procurement' ) );
			get_template_part( 'template-parts/procurement-filter-form' );
			?>
		</div>
	</div>
</div>
<?php endif; ?>

<?php wp_footer(); ?>

</body>

</html>