<?php
/**
 * Procurement Filter Form Template Part
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$search_term        = get_query_var( 'procurement_filter_search_term', '' );
$selected_category  = get_query_var( 'procurement_filter_category', '' );
$start_date         = get_query_var( 'procurement_filter_start_date', '' );
$end_date           = get_query_var( 'procurement_filter_end_date', '' );
$has_filters        = get_query_var( 'procurement_filter_has_filters', false );
$archive_link       = get_query_var( 'procurement_filter_archive_link', home_url( '/' ) );
$archive_categories = function_exists( 'starter_theme_get_procurement_category_definitions' ) ? starter_theme_get_procurement_category_definitions() : array();
$action_url         = ! empty( $archive_link ) ? $archive_link : home_url( '/' );
$id_suffix          = get_query_var( 'procurement_filter_id_suffix', '' );
?>

<form method="get" action="<?php echo esc_url( $action_url ); ?>" class="procurement-archive__search-form flex flex-col gap-4 md:flex-row xl:flex-row xl:items-end">
	<!-- Search input -->
	<p class="m-0 w-full md:w-auto md:flex-1 xl:w-auto xl:flex-1 relative">
		<input id="procurement-search-input-<?php echo esc_attr( $id_suffix ); ?>" type="search" name="s" value="<?php echo esc_attr( $search_term ); ?>" placeholder="<?php echo esc_attr__( 'เลขที่ประกาศ / รายละเอียด', 'starter-theme' ); ?>" aria-label="<?php echo esc_attr__( 'เลขที่ประกาศ / รายละเอียด', 'starter-theme' ); ?>" class="w-full rounded-[8px] border border-gray-200 px-4 pr-10 py-3 text-sm outline-none transition focus:border-primary" />
		<span class="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400"><i class="ri-search-line"></i></span>
	</p>

	<!-- Category select dropdown -->
	<p class="m-0">
		<select id="procurement-category-select-<?php echo esc_attr( $id_suffix ); ?>" name="procurement_category" class="w-full rounded-[8px] border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-primary">
			<option value=""><?php echo esc_html__( 'ทั้งหมด', 'starter-theme' ); ?></option>
			<?php foreach ( $archive_categories as $definition ) : ?>
				<option value="<?php echo esc_attr( $definition['slug'] ); ?>" <?php selected( $selected_category, $definition['slug'] ); ?>>
					<?php echo esc_html( $definition['label_th'] ); ?>
				</option>
			<?php endforeach; ?>
		</select>
	</p>

	<!-- Start date input -->
	<p class="m-0 relative">
		<input id="procurement-start-date-<?php echo esc_attr( $id_suffix ); ?>" type="text" name="procurement_start_date" value="<?php echo esc_attr( $start_date ); ?>" placeholder="<?php echo esc_attr__( 'วันที่เริ่มต้นประกาศ', 'starter-theme' ); ?>" aria-label="<?php echo esc_attr__( 'วันที่เริ่มต้นประกาศ', 'starter-theme' ); ?>" autocomplete="off" data-datepicker="true" class="procurement-date-input w-full rounded-[8px] border border-gray-200 px-4 pr-10 py-3 text-sm outline-none transition focus:border-primary" />
		<span class="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400"><i class="ri-calendar-line"></i></span>
	</p>

	<!-- End date input (disabled) -->
	<?php
	/*
	<p class="m-0">
		<input id="procurement-end-date-<?php echo esc_attr( $id_suffix ); ?>" type="text" name="procurement_end_date" value="<?php echo esc_attr( $end_date ); ?>" placeholder="<?php echo esc_attr__( 'วันที่สิ้นสุดประกาศ', 'starter-theme' ); ?>" aria-label="<?php echo esc_attr__( 'วันที่สิ้นสุดประกาศ', 'starter-theme' ); ?>" autocomplete="off" data-datepicker="true" class="procurement-date-input w-full rounded-[8px] border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-primary" />
	</p>
	*/
	?>

	<!-- Submit and clear buttons -->
	<div class="m-0 xl:self-end flex flex-col items-center gap-4 text-center">
		<button type="submit" class="inline-flex w-fit items-center justify-center rounded-full bg-primary px-6 py-3 text-base font-normal text-white shadow-md shadow-primary/20 transition hover:bg-primary-dark">
			<?php echo esc_html__( 'ค้นหา', 'starter-theme' ); ?>
		</button>
		<?php if ( $has_filters ) : ?>
			<a href="<?php echo esc_url( $archive_link ); ?>" class="clear-filter-btn text-red-700 text-sm underline hover:text-red-800">
				<?php echo esc_html__( 'ล้างตัวกรอง', 'starter-theme' ); ?>
			</a>
		<?php endif; ?>
	</div>
</form>
