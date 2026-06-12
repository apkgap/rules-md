<?php
/**
 * Template part for displaying loading spinner
 *
 * @package starter_theme
 */

$size = isset( $size ) ? $size : 'md';

$size_classes = array(
	'sm' => 'w-12 h-12',
	'md' => 'w-20 h-20',
	'lg' => 'w-32 h-32',
);

$size_class = isset( $size_classes[ $size ] ) ? $size_classes[ $size ] : $size_classes['md'];
?>

<div class="starter-theme-loading-spinner flex items-center justify-center">
	<img
		src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/loader/loader.svg' ); ?>"
		alt="Loading..."
		class="<?php echo esc_attr( $size_class ); ?> animate-spin"
		width="80"
		height="80"
	>
</div>
