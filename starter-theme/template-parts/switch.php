<?php
if ( ! isset( $switch ) || ! is_array( $switch ) ) {
	$switch = get_query_var( 'switch' );
}

if ( empty( $switch ) || ! is_array( $switch ) ) {
	return;
}

$id            = isset( $switch['id'] ) ? (string) $switch['id'] : wp_unique_id( 'starter-theme-switch-' );
$name          = isset( $switch['name'] ) ? (string) $switch['name'] : 'starter_theme_switch';
$value         = isset( $switch['value'] ) ? (string) $switch['value'] : '1';
$label         = isset( $switch['label'] ) ? (string) $switch['label'] : '';
$description   = isset( $switch['description'] ) ? (string) $switch['description'] : '';
$state         = isset( $switch['state'] ) ? (string) $switch['state'] : 'default';
$checked       = ! empty( $switch['checked'] );
$disabled      = ! empty( $switch['disabled'] );
$show_label    = array_key_exists( 'show_label', $switch ) ? (bool) $switch['show_label'] : true;
$size          = isset( $switch['size'] ) ? (string) $switch['size'] : 'default';
$wrapper_class = isset( $switch['wrapper_class'] ) ? (string) $switch['wrapper_class'] : '';
$input_class   = isset( $switch['input_class'] ) ? (string) $switch['input_class'] : '';
$hint_id       = $description !== '' ? $id . '-description' : '';

if ( 'disabled' === $state ) {
	$disabled = true;
}

$label_class = $disabled ? 'text-starter-icon-disabled' : 'text-starter-text-black';
?>
<label class="starter-theme-switch inline-flex items-center gap-3 <?php echo esc_attr( $wrapper_class ); ?> <?php echo $disabled ? 'cursor-not-allowed' : 'cursor-pointer'; ?>">
	<input
		id="<?php echo esc_attr( $id ); ?>"
		class="js-switch sr-only <?php echo esc_attr( $input_class ); ?>"
		type="checkbox"
		name="<?php echo esc_attr( $name ); ?>"
		value="<?php echo esc_attr( $value ); ?>"
		data-size="<?php echo esc_attr( $size ); ?>"
		<?php checked( $checked ); ?>
		<?php disabled( $disabled ); ?>
		<?php echo $hint_id ? 'aria-describedby="' . esc_attr( $hint_id ) . '"' : ''; ?>
	>
	<script>
		(function() {
			var elem = document.getElementById('<?php echo esc_js( $id ); ?>');
			if (elem && window.Switchery) {
				new Switchery(elem, {
					size: '<?php echo esc_js( $size ); ?>',
					disabled: <?php echo $disabled ? 'true' : 'false'; ?>
				});
			}
		})();
	</script>
	<?php if ( $show_label && ( '' !== $label || '' !== $description ) ) : ?>
		<span class="starter-theme-switch__content flex min-w-0 flex-col gap-0.5">
			<?php if ( '' !== $label ) : ?>
				<span class="starter-theme-switch__label font-medium text-[0.95rem] leading-6 <?php echo esc_attr( $label_class ); ?>"><?php echo esc_html( $label ); ?></span>
			<?php endif; ?>
			<?php if ( '' !== $description ) : ?>
				<span id="<?php echo esc_attr( $hint_id ); ?>" class="starter-theme-switch__description text-sm leading-5 text-starter-icon-subdued"><?php echo esc_html( $description ); ?></span>
			<?php endif; ?>
		</span>
	<?php endif; ?>
</label>
