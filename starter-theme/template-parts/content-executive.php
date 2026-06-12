<?php
/**
 * Executive single content template
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id        = get_the_ID();
$position_terms = get_the_terms( $post_id, 'executive_position' );
$position_name  = '';

if ( is_array( $position_terms ) && ! empty( $position_terms ) ) {
	$first_term = $position_terms[0];
	if ( $first_term instanceof WP_Term ) {
		$position_name = $first_term->name;
	}
}

$details = get_post_meta( $post_id, '_executive_details', true );

if ( is_string( $details ) ) {
	$decoded = json_decode( wp_unslash( $details ), true );
	if ( json_last_error() === JSON_ERROR_NONE && is_array( $decoded ) ) {
		$details = $decoded;
	}
}

if ( ! is_array( $details ) ) {
	$details = array();
}

$details = array_values( array_filter( array_map(
	static function ( $detail ) {
		if ( ! is_array( $detail ) ) {
			return null;
		}

		$title   = isset( $detail['title'] ) ? sanitize_text_field( (string) $detail['title'] ) : '';
		$content = isset( $detail['content'] ) ? wp_kses_post( (string) $detail['content'] ) : '';

		if ( '' === $title && '' === trim( wp_strip_all_tags( $content ) ) ) {
			return null;
		}

		return array(
			'title'   => $title,
			'content' => $content,
		);
	},
	$details
) ) );
?>

<article id="executive-single-<?php the_ID(); ?>" <?php post_class( 'executive-single executive-single__article bg-[#FAFAFA] ' ); ?>>
	<div class="starter-container">
		<div class="executive-single__panel overflow-hidden bg-white">
			<div class="grid grid-cols-1 lg:grid-cols-[320px_minmax(0,1fr)] gap-0">
				<div class="executive-single__media bg-[#f3f5f8] flex items-center justify-center p-6 md:p-8">
					<div class="executive-single__portrait w-full max-w-[320px] aspect-7/8 overflow-hidden rounded-[20px] border border-[#d8dde4] bg-white flex items-end justify-center">
						<?php if ( has_post_thumbnail( $post_id ) ) : ?>
							<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-contain object-bottom' ) ); ?>
						<?php else : ?>
							<div class="flex h-full w-full items-center justify-center text-gray-300">
								<span class="w-16 h-16 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="executive-single__content px-6 py-8 md:px-10 md:py-12 lg:px-12">
					<p class="executive-single__eyebrow mb-3 text-sm font-semibold uppercase tracking-[0.16em] text-starter-icon-subdued">
						<?php echo esc_html__('คณะผู้บริหาร', 'starter-theme'); ?>
					</p>

					<h1 id="executive-single-title-<?php the_ID(); ?>" class="executive-single__title m-0 text-3xl font-bold leading-tight text-[#111827] md:text-4xl lg:text-5xl">
						<?php the_title(); ?>
					</h1>

					<?php if ( $position_name ) : ?>
						<p class="executive-single__position mt-3 mb-0 text-base font-medium text-[#374151] md:text-lg">
							<?php echo esc_html( $position_name ); ?>
						</p>
					<?php endif; ?>

					<div class="executive-single__entry prose prose-slate mt-8 max-w-none prose-headings:font-semibold prose-headings:text-[#111827] prose-p:text-[#374151] prose-li:text-[#374151] prose-li:marker:text-[#6b7280]">
						<?php the_content(); ?>
					</div>

					<?php if ( ! empty( $details ) ) : ?>
						<div class="mt-12">
							<h2 class="mb-8 text-2xl font-bold text-gray-900 md:text-3xl">
								<?php echo esc_html__('รายละเอียดเพิ่มเติม', 'starter-theme'); ?>
							</h2>

							<div class="space-y-8">
								<?php foreach ( $details as $detail ) : ?>
									<div class="bg-white p-0">
										<?php if ( ! empty( $detail['title'] ) ) : ?>
											<h3 class="mb-4 text-xl font-semibold text-gray-900 md:text-2xl">
												<?php echo esc_html( $detail['title'] ); ?>
											</h3>
										<?php endif; ?>

										<?php if ( ! empty( $detail['content'] ) ) : ?>
											<div class="prose prose-lg max-w-none text-gray-700">
												<?php echo wp_kses_post( $detail['content'] ); ?>
											</div>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</article>
