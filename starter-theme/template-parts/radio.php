<?php
if ( ! isset( $radio ) || ! is_array( $radio ) ) {
	$radio = get_query_var( 'radio' );
}

if ( empty( $radio ) || ! is_array( $radio ) ) {
	return;
}

$id            = isset( $radio['id'] ) ? (string) $radio['id'] : wp_unique_id( 'starter-theme-radio-' );
$name          = isset( $radio['name'] ) ? (string) $radio['name'] : 'starter_theme_radio';
$value         = isset( $radio['value'] ) ? (string) $radio['value'] : '1';
$label         = isset( $radio['label'] ) ? (string) $radio['label'] : '';
$description   = isset( $radio['description'] ) ? (string) $radio['description'] : '';
$error_message = isset( $radio['error_message'] ) ? (string) $radio['error_message'] : '';
$state         = isset( $radio['state'] ) ? (string) $radio['state'] : 'default';
$checked       = ! empty( $radio['checked'] );
$disabled      = ! empty( $radio['disabled'] );
$show_label    = array_key_exists( 'show_label', $radio ) ? (bool) $radio['show_label'] : true;
$layout        = isset( $radio['layout'] ) ? (string) $radio['layout'] : 'left';
$wrapper_class = isset( $radio['wrapper_class'] ) ? (string) $radio['wrapper_class'] : '';
$input_class   = isset( $radio['input_class'] ) ? (string) $radio['input_class'] : '';
$hint_id       = $description !== '' ? $id . '-description' : '';

if ( 'disabled' === $state ) {
	$disabled = true;
}

$state_classes = array(
	'default'  => 'border-starter-border-default bg-white peer-checked:border-[#0f67d3] peer-disabled:border-starter-border-disabled',
	'hover'    => 'border-[#0f67d3] bg-white',
	'error'    => 'border-[#e53e3e] bg-white',
	'disabled' => 'border-starter-border-disabled bg-white',
);

$ring_class = isset( $state_classes[ $state ] ) ? $state_classes[ $state ] : $state_classes['default'];

$dot_class = 'default' === $state
	? 'bg-transparent peer-checked:bg-[#0f67d3] peer-disabled:bg-transparent'
	: ( $checked ? ( 'disabled' === $state ? 'bg-[#a1a1aa]' : 'bg-[#0f67d3]' ) : 'bg-transparent' );

$label_class       = 'disabled' === $state ? 'text-starter-icon-disabled' : 'text-starter-text-black';
$description_class = 'disabled' === $state ? 'text-starter-icon-disabled' : 'text-starter-icon-subdued';
$layout_class      = 'right' === $layout ? 'flex-row-reverse' : '';
?>
<label class="starter-theme-radio inline-flex items-start gap-2.5 <?php echo esc_attr( $layout_class ); ?> <?php echo esc_attr( $wrapper_class ); ?> <?php echo $disabled ? 'cursor-not-allowed' : 'cursor-pointer'; ?>">
	<input
		id="<?php echo esc_attr( $id ); ?>"
		class="peer sr-only <?php echo esc_attr( $input_class ); ?>"
		type="radio"
		name="<?php echo esc_attr( $name ); ?>"
		value="<?php echo esc_attr( $value ); ?>"
		<?php checked( $checked ); ?>
		<?php disabled( $disabled ); ?>
		<?php echo $hint_id ? 'aria-describedby="' . esc_attr( $hint_id ) . '"' : ''; ?>
	>
	<span class="starter-theme-radio__control mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full border-[1.5px] transition-colors <?php echo esc_attr( $ring_class ); ?>">
		<span class="starter-theme-radio__dot h-[7px] w-[7px] rounded-full <?php echo esc_attr( $dot_class ); ?>"></span>
	</span>
	<?php if ( $show_label && ( '' !== $label || '' !== $description ) ) : ?>
		<span class="starter-theme-radio__content flex min-w-0 flex-col gap-0.5">
			<?php if ( '' !== $label ) : ?>
				<span class="starter-theme-radio__label text-[0.95rem] font-medium leading-5 <?php echo esc_attr( $label_class ); ?>"><?php echo esc_html( $label ); ?></span>
			<?php endif; ?>
			<?php if ( '' !== $description ) : ?>
				<span id="<?php echo esc_attr( $hint_id ); ?>" class="starter-theme-radio__description text-sm leading-5 <?php echo esc_attr( $description_class ); ?>"><?php echo esc_html( $description ); ?></span>
			<?php endif; ?>
			<?php if ( 'error' === $state && '' !== $error_message ) : ?>
				<span class="starter-theme-radio__error text-sm leading-5 text-[#e53e3e]"><?php echo esc_html( $error_message ); ?></span>
			<?php endif; ?>
		</span>
	<?php endif; ?>
</label>
