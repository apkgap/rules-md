<?php
/**
 * Procurement Sidebar Navigation Template Part
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$archive_categories = function_exists( 'starter_theme_get_procurement_category_definitions' ) ? starter_theme_get_procurement_category_definitions() : array();
$selected_category  = get_query_var( 'procurement_sidebar_category', '' );
$current_term       = get_query_var( 'procurement_sidebar_current_term', null );
$archive_link       = get_query_var( 'procurement_sidebar_archive_link', home_url( '/' ) );
$render_mode        = get_query_var( 'procurement_sidebar_render_mode', 'desktop' );
$nav_classes        = 'mobile_popup' === $render_mode ? 'flex flex-col gap-2' : 'hidden lg:flex flex-col gap-2 overflow-y-auto max-h-[60vh] bg-surface-100 p-4 rounded-[8]';
?>

<nav class="<?php echo esc_attr( $nav_classes ); ?>" aria-label="<?php echo esc_attr__( 'ประเภทจัดซื้อจัดจ้าง', 'starter-theme' ); ?>">
	<a href="<?php echo esc_url( $archive_link ); ?>" class="procurement-archive__sidebar-link <?php echo esc_attr( empty( $selected_category ) ? 'bg-primary text-white  shadow-primary/20' : 'bg-surface-100 text-gray-700 hover:bg-white hover:text-black' ); ?> block rounded-[100px] px-4 py-2 text-sm font-light transition-colors duration-200">
		<?php echo esc_html__( 'ทั้งหมด', 'starter-theme' ); ?>
	</a>
	<?php foreach ( $archive_categories as $definition ) : ?>
		<?php
		$term = get_term_by( 'slug', $definition['slug'], 'procurement_category' );
		if ( ! ( $term instanceof WP_Term ) ) {
			continue;
		}

		$term_link = get_term_link( $term );
		if ( is_wp_error( $term_link ) ) {
			continue;
		}

		$is_active = ( $current_term instanceof WP_Term && (int) $current_term->term_id === (int) $term->term_id ) || $selected_category === $term->slug;
		$sidebar_link_classes = $is_active ? 'bg-primary text-white  shadow-primary/20' : 'bg-surface-100 text-gray-700 hover:bg-white hover:text-black';
		?>
		<a href="<?php echo esc_url( $term_link ); ?>" class="procurement-archive__sidebar-link <?php echo esc_attr( $sidebar_link_classes ); ?> block rounded-[100px] px-4 py-2 text-sm font-semibold transition-colors duration-200">
			<?php echo esc_html( $definition['label_th'] ); ?>
		</a>
	<?php endforeach; ?>
</nav>
