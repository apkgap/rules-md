<?php
/**
 * Template part for displaying procurement content.
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id        = get_the_ID();
$notice_number  = (string) get_post_meta( $post_id, '_procurement_notice_number', true );
$method         = (string) get_post_meta( $post_id, '_procurement_method', true );
$announce_date  = function_exists( 'starter_theme_format_procurement_date' ) ? starter_theme_format_procurement_date( (string) get_post_meta( $post_id, '_procurement_announce_date', true ) ) : '';
$deadline_date  = function_exists( 'starter_theme_format_procurement_date' ) ? starter_theme_format_procurement_date( (string) get_post_meta( $post_id, '_procurement_deadline_date', true ) ) : '';
$document_url   = (string) get_post_meta( $post_id, '_procurement_document_url', true );
$notice_excerpt = (string) get_post_meta( $post_id, '_procurement_notice_excerpt', true );
$terms          = get_the_terms( $post_id, 'procurement_category' );
$category_name   = '';

if ( is_array( $terms ) && ! empty( $terms ) ) {
	$first_term = $terms[0];
	if ( $first_term instanceof WP_Term ) {
		$category_name = $first_term->name;
	}
}
?>

<article id="procurement-single-<?php the_ID(); ?>" <?php post_class( 'procurement-single bg-[#FAFAFA] ' ); ?>>
	<div class="starter-container">
		<div class="rounded-[24px] bg-white  ring-gray-100">
			<div class="border-b border-gray-100 px-6 py-6 md:px-10 md:py-8">
				<div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
					<div>
						<?php if ( $category_name ) : ?>
							<p class="mb-2 text-sm font-semibold uppercase tracking-wide text-primary"><?php echo esc_html( $category_name ); ?></p>
						<?php endif; ?>
						<h1 class="text-2xl font-bold text-gray-900 md:text-3xl"><?php the_title(); ?></h1>
						<?php if ( $notice_number ) : ?>
							<p class="mt-2 text-sm text-gray-500"><?php echo esc_html__( 'เลขที่ประกาศ', 'starter-theme' ); ?>: <?php echo esc_html( $notice_number ); ?></p>
						<?php endif; ?>
					</div>
					<?php if ( $document_url ) : ?>
						<a href="<?php echo esc_url( $document_url ); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-primary px-5 py-3 text-sm font-semibold text-white shadow-md shadow-primary/20 transition hover:bg-primary-dark">
							<span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
							<?php echo esc_html__( 'ดาวน์โหลดเอกสาร', 'starter-theme' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<div class="grid gap-8 px-6 py-8 md:px-10 md:py-12 lg:grid-cols-[minmax(0,1fr)_320px]">
				<div class="space-y-8">
					<?php if ( $notice_excerpt ) : ?>
						<div class="rounded-2xl bg-gray-50 p-6">
							<p class="m-0 text-base leading-7 text-gray-700"><?php echo esc_html( $notice_excerpt ); ?></p>
						</div>
					<?php endif; ?>

					<div class="prose prose-slate max-w-none prose-headings:font-semibold prose-headings:text-gray-900 prose-p:text-gray-700 prose-li:text-gray-700">
						<?php the_content(); ?>
					</div>
				</div>

				<aside class="space-y-4 rounded-2xl bg-gray-50 p-6">
					<h2 class="text-lg font-bold text-gray-900"><?php echo esc_html__( 'ข้อมูลประกาศ', 'starter-theme' ); ?></h2>

					<div class="space-y-4 text-sm text-gray-700">
						<div>
							<p class="mb-1 font-semibold text-gray-900"><?php echo esc_html__( 'วิธีจัดซื้อจัดจ้าง', 'starter-theme' ); ?></p>
							<p class="m-0"><?php echo esc_html( $method ?: '—' ); ?></p>
						</div>

						<div>
							<p class="mb-1 font-semibold text-gray-900"><?php echo esc_html__( 'วันที่ประกาศ', 'starter-theme' ); ?></p>
							<p class="m-0"><?php echo esc_html( $announce_date ?: '—' ); ?></p>
						</div>

						<div>
							<p class="mb-1 font-semibold text-gray-900"><?php echo esc_html__( 'วันที่ยื่นซอง', 'starter-theme' ); ?></p>
							<p class="m-0"><?php echo esc_html( $deadline_date ?: '—' ); ?></p>
						</div>
					</div>
				</aside>
			</div>
		</div>
	</div>
</article>
