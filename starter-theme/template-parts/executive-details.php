<?php
/**
 * Executive Details Template Part
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_the_ID();
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

if ( empty( $details ) ) {
	return;
}
?>
<section class="executive-details ">
	<div class="starter-container">
		<h2 class="mb-8 text-2xl font-bold text-gray-900 md:text-3xl">
			<?php echo esc_html__('รายละเอียดเพิ่มเติม', 'starter-theme'); ?>
		</h2>

		<div class="executive-details__list space-y-8">
			<?php foreach ( $details as $detail ) : ?>
				<div class="executive-detail-item rounded-lg border border-gray-200 bg-white p-6 md:p-8">
					<?php if ( ! empty( $detail['title'] ) ) : ?>
						<h3 class="mb-4 text-xl font-semibold text-gray-900 md:text-2xl">
							<?php echo esc_html( $detail['title'] ); ?>
						</h3>
					<?php endif; ?>

					<?php if ( ! empty( $detail['content'] ) ) : ?>
						<div class="executive-detail-content prose prose-lg max-w-none text-gray-700">
							<?php echo wp_kses_post( $detail['content'] ); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
