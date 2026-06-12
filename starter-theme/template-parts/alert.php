<?php
/**
 * Template part for displaying alert/notification
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$type     = isset( $type ) ? $type : 'info';
$title    = isset( $title ) ? $title : '';
$message  = isset( $message ) ? $message : '';
$dismissible = isset( $dismissible ) ? $dismissible : true;
$action_label = isset( $action_label ) ? $action_label : '';
$action_url   = isset( $action_url ) ? $action_url : '#';

$type_classes = array(
	'info'    => 'border-[#d1d5db] bg-white',
	'success' => 'border-[#84cc16] bg-[#f7fde8]',
	'warning' => 'border-[#facc15] bg-[#fffbed]',
	'error'   => 'border-[#ff4d4f] bg-[#fff5f5]',
	'critical' => 'border-[#ff4d4f] bg-[#fff5f5]',
);

$type_class = isset( $type_classes[ $type ] ) ? $type_classes[ $type ] : $type_classes['info'];

$icon_wrap_classes = array(
	'info'     => 'bg-[#f5f5f5] text-[#111827] border-[#111827]',
	'success'  => 'bg-[#95db10] text-white border-white',
	'warning'  => 'bg-[#ffc814] text-white border-white',
	'error'    => 'bg-[#ff4d4f] text-white border-white',
	'critical' => 'bg-[#ff4d4f] text-white border-white',
);

$icon_wrap_class = isset( $icon_wrap_classes[ $type ] ) ? $icon_wrap_classes[ $type ] : $icon_wrap_classes['info'];

$icon_map = array(
	'info'     => 'ri-information-line',
	'success'  => 'ri-checkbox-circle-line',
	'warning'  => 'ri-error-warning-line',
	'error'    => 'ri-close-circle-line',
	'critical' => 'ri-alarm-warning-line',
);

$icon = isset( $icon_map[ $type ] ) ? $icon_map[ $type ] : $icon_map['info'];
?>

<div class="starter-theme-alert <?php echo esc_attr( $type_class ); ?> rounded-[22px] border px-6 py-4 shadow-[0_0_0_1px_rgba(0,0,0,0.01)]" role="alert" x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2">
	<div class="flex items-center gap-4">
		<div class="starter-theme-alert__icon-wrap <?php echo esc_attr( $icon_wrap_class ); ?> inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-full">
			<span class="inline-flex h-6 w-6 items-center justify-center rounded-full border-2 border-dashed text-[0.95rem] leading-none">
				<span class="w-3 h-3 flex items-center justify-center"><i class="<?php echo esc_attr($icon); ?>"></i></span>
			</span>
		</div>
		<div class="min-w-0 flex-1">
			<?php if ( ! empty( $title ) ) : ?>
				<h4 class="mb-1 text-[1.05rem] leading-6 font-normal text-starter-text-black"><?php echo esc_html( $title ); ?></h4>
			<?php endif; ?>
			<?php if ( ! empty( $message ) ) : ?>
				<p class="text-[0.92rem] leading-6 text-starter-icon-disabled"><?php echo wp_kses_post( $message ); ?></p>
			<?php endif; ?>
		</div>
		<?php if ( ! empty( $action_label ) ) : ?>
			<a class="inline-flex shrink-0 items-center text-[1rem] font-semibold text-starter-text-primary no-underline hover:opacity-80" href="<?php echo esc_url( $action_url ); ?>"><?php echo esc_html( $action_label ); ?></a>
		<?php endif; ?>
		<?php if ( $dismissible ) : ?>
			<button type="button" class="ml-2 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-starter-icon-subdued transition-colors hover:bg-black/5" @click="show = false" aria-label="<?php esc_attr_e( 'Dismiss', 'starter-theme' ); ?>">
				<span class="w-5 h-5 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
			</button>
		<?php endif; ?>
	</div>
</div>
