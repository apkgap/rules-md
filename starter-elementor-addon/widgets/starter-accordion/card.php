<?php
/**
 * Single Accordion Item Template Component for KU Accordion Widget
 *
 * @package starter-elementor-addon
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Retrieve variables passed through set_query_var
$item     = get_query_var( 'accordion_item' );
$index    = get_query_var( 'accordion_index' );
$settings = get_query_var( 'accordion_settings' );

if ( empty( $item ) ) {
	return;
}

$default_open = isset( $settings['default_open_index'] ) ? intval( $settings['default_open_index'] ) : 1;
$is_active    = ( intval( $index ) === $default_open );

// Build classes
$item_classes = [ 'starter-accordion__item' ];
if ( $is_active ) {
	$item_classes[] = 'starter-accordion__item--active';
}

$header_classes = [ 'starter-accordion__header' ];
$icon_position  = ! empty( $settings['icon_position'] ) ? $settings['icon_position'] : 'left';
$header_classes[] = 'starter-accordion__header--icon-' . $icon_position;

// Determine toggle indicator style
$toggle_type = ! empty( $settings['toggle_type'] ) ? $settings['toggle_type'] : 'chevron';

// Question text & Answer text
$question = ! empty( $item['question'] ) ? $item['question'] : '';
$answer   = ! empty( $item['answer'] ) ? $item['answer'] : '';

// Icon rendering
$icon_html = '';
if ( ! empty( $item['selected_icon']['value'] ) ) {
	ob_start();
	\Elementor\Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] );
	$icon_html = ob_get_clean();
} elseif ( ! empty( $item['icon_class'] ) ) {
	$icon_html = '<i class="' . esc_attr( $item['icon_class'] ) . '" aria-hidden="true"></i>';
}
?>

<div class="<?php echo esc_attr( implode( ' ', $item_classes ) ); ?>" data-index="<?php echo intval( $index ); ?>">
	<button class="<?php echo esc_attr( implode( ' ', $header_classes ) ); ?>" aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>">
		
		<?php if ( 'left' === $icon_position && $icon_html ) : ?>
			<span class="starter-accordion__question-icon">
				<?php echo $icon_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</span>
		<?php endif; ?>

		<span class="starter-accordion__question-text"><?php echo esc_html( $question ); ?></span>

		<?php if ( 'right' === $icon_position && $icon_html ) : ?>
			<span class="starter-accordion__question-icon">
				<?php echo $icon_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</span>
		<?php endif; ?>

		<?php if ( 'chevron' === $toggle_type ) : ?>
			<span class="starter-accordion__toggle-icon">
				<i class="ri-arrow-down-s-line" aria-hidden="true"></i>
			</span>
		<?php elseif ( 'plus' === $toggle_type ) : ?>
			<span class="starter-accordion__toggle-plus"></span>
		<?php endif; ?>

	</button>

	<div class="starter-accordion__content-wrapper" style="<?php echo $is_active ? 'display: block;' : 'display: none;'; ?>">
		<div class="starter-accordion__content">
			<div class="starter-accordion__answer">
				<?php echo wp_kses_post( $answer ); ?>
			</div>
		</div>
	</div>
</div>
