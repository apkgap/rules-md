<?php
/**
 * Procurement Card Template
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id        = get_the_ID();
$notice_number   = (string) get_post_meta( $post_id, '_procurement_notice_number', true );
$method          = (string) get_post_meta( $post_id, '_procurement_method', true );
$announce_date   = function_exists( 'starter_theme_format_procurement_date' ) ? starter_theme_format_procurement_date( (string) get_post_meta( $post_id, '_procurement_announce_date', true ) ) : '';
$deadline_date   = function_exists( 'starter_theme_format_procurement_date' ) ? starter_theme_format_procurement_date( (string) get_post_meta( $post_id, '_procurement_deadline_date', true ) ) : '';
$document_url    = (string) get_post_meta( $post_id, '_procurement_document_url', true );
$notice_excerpt  = (string) get_post_meta( $post_id, '_procurement_notice_excerpt', true );
$title_permalink = get_permalink( $post_id );
$title_text      = get_the_title( $post_id );
$views           = get_post_meta( $post_id, 'post_views_count', true );
$views_text      = $views ? number_format_i18n( $views ) : '0';
$terms           = get_the_terms( $post_id, 'procurement_category' );
$term_name       = '';
$term_link       = '';
$badge_color     = '#ffffff';
$badge_bg        = 'var(--color-starter-surface-primary)';

if ( is_array( $terms ) && ! empty( $terms ) && $terms[0] instanceof WP_Term ) {
	$term_name   = $terms[0]->name;
	$resolved_link = get_term_link( $terms[0] );
	if ( ! is_wp_error( $resolved_link ) ) {
		$term_link = $resolved_link;
	}
	if ( function_exists( 'starter_theme_get_procurement_category_badge_colors' ) ) {
		$badge_colors = starter_theme_get_procurement_category_badge_colors( $terms[0] );
		$badge_color  = isset( $badge_colors['color'] ) && $badge_colors['color'] ? $badge_colors['color'] : $badge_color;
		$badge_bg     = isset( $badge_colors['bg'] ) && $badge_colors['bg'] ? $badge_colors['bg'] : $badge_bg;
	} elseif ( function_exists( 'starter_theme_get_procurement_category_badge_color' ) ) {
		$badge_color = starter_theme_get_procurement_category_badge_color( $terms[0] );
	}
}
?>
<article class="group rounded-2xl bg-white p-5 md:p-6  ring-gray-100 transition-shadow hover:shadow-md">
	<div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
		<div class="min-w-0 flex-1">
			<div class="mb-3 flex flex-wrap items-center gap-2">
				<?php if ( $term_name ) : ?>
					<a href="<?php echo esc_url( $term_link ? $term_link : '#' ); ?>" class="inline-flex rounded-full px-3 py-1 text-xs font-medium transition-colors hover:opacity-80" style="background-color: <?php echo esc_attr( $badge_bg ); ?>; color: <?php echo esc_attr( $badge_color ); ?>;">
						<?php echo esc_html( $term_name ); ?>
					</a>
				<?php endif; ?>
				<?php if ( $notice_number ) : ?>
					<span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-500">
						<?php echo esc_html( $notice_number ); ?>
					</span>
				<?php endif; ?>
			</div>

			<h3 class="m-0 text-base font-semibold leading-snug text-gray-900 lg:text-lg">
				<a href="<?php echo esc_url( $title_permalink ); ?>" class="transition-colors hover:text-primary">
					<?php echo esc_html( $title_text ); ?>
				</a>
			</h3>

			<?php if ( $notice_excerpt ) : ?>
				<p class="mt-3 max-w-4xl text-sm leading-6 text-gray-500">
					<?php echo esc_html( $notice_excerpt ); ?>
				</p>
			<?php endif; ?>

			<div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-gray-500">
				<?php if ( $method ) : ?>
					<div class="method flex items-center gap-2">
						<span class="w-3.5 h-3.5 flex items-center justify-center text-gray-400 ml-[-4px]">
							<i class="ri-price-tag-3-line"></i>
						</span>
						<span><?php echo esc_html( $method ); ?></span>
					</div>
				<?php endif; ?>

				<div class="announce-date flex items-center gap-2">
					<span class="w-3.5 h-3.5 flex items-center justify-center text-gray-400 ml-[-4px]">
						<i class="ri-calendar-event-line"></i>
					</span>
					<span><?php echo esc_html( $announce_date ?: '—' ); ?></span>
				</div>

				<?php if ( $deadline_date ) : ?>
					<div class="deadline flex items-center gap-2">
						<span class="w-3.5 h-3.5 flex items-center justify-center text-gray-400 ml-[-4px]">
							<i class="ri-time-line"></i>
						</span>
						<span><?php echo esc_html( $deadline_date ); ?></span>
					</div>
				<?php endif; ?>

				<div class="views flex items-center gap-2">
					<span class="w-3.5 h-3.5 flex items-center justify-center text-gray-400 ml-[-4px]">
						<i class="ri-eye-line"></i>
					</span>
					<span><?php echo esc_html( $views_text ); ?></span>
				</div>
			</div>
		</div>

		<div class="flex shrink-0 flex-col items-start gap-2 lg:items-end">
			<a href="<?php echo esc_url( $title_permalink ); ?>" class="inline-flex items-center gap-2 rounded-full bg-primary px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-dark">
				<?php echo esc_html__('อ่านเพิ่มเติม', 'starter-theme'); ?>
				<span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
			</a>
		</div>
	</div>
</article>
