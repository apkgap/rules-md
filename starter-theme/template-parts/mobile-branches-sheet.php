<?php
/**
 * Mobile Branches Bottom Sheet
 * Triggered by: @click="branchesOpen = true"
 * State lives in #page x-data: branchesOpen
 *
 * @package starter_theme
 */

if (!defined('ABSPATH')) exit;

$mob_branches = starter_theme_get_option('header_branches');
if (empty($mob_branches) || !is_array($mob_branches)) {
	$mob_branches = array(
		array('title' => 'สาขา 1', 'label' => 'สาขา 1 :', 'color' => '#7a22cb', 'phones' => array('092-886-9926', '063-661-4666', '089-451-6664')),
		array('title' => 'สาขา 2', 'label' => 'สาขา 2 :', 'color' => '#bf80ff', 'phones' => array('099-249-3636', '086-996-4165')),
	);
}
?>
<div x-show="branchesOpen"
	x-cloak
	@click.self="branchesOpen = false"
	@keydown.escape.window="branchesOpen = false"
	x-transition:enter="transition ease-out duration-300"
	x-transition:enter-start="opacity-0"
	x-transition:enter-end="opacity-100"
	x-transition:leave="transition ease-in duration-200"
	x-transition:leave-start="opacity-100"
	x-transition:leave-end="opacity-0"
	class="fixed inset-0 z-99998 bg-black/50 backdrop-blur-sm lg:hidden">

	<div
		x-show="branchesOpen"
		x-transition:enter="transition ease-out duration-300"
		x-transition:enter-start="translate-y-full"
		x-transition:enter-end="translate-y-0"
		x-transition:leave="transition ease-in duration-200"
		x-transition:leave-start="translate-y-0"
		x-transition:leave-end="translate-y-full"
		class="absolute bottom-0 inset-x-0 rounded-t-2xl shadow-2xl overflow-hidden"
		style="background-color: var(--custom-popup-bg, var(--bg-base)); color: var(--custom-popup-text, inherit);">

		<div class="flex justify-center pt-3 pb-1">
			<div class="w-10 h-1 rounded-full bg-border-base opacity-60"></div>
		</div>

		<div class="flex items-center justify-between px-5 py-3 border-b border-border-base">
			<div class="flex items-center gap-2">
				<i class="ri-map-pin-line" style="color: var(--custom-header-branch-color, var(--color-primary, #ec008c));"></i>
				<span class="text-sm font-bold"><?php echo esc_html__('สาขา', 'starter-theme'); ?></span>
			</div>
			<button @click="branchesOpen = false" class="w-8 h-8 flex items-center justify-center rounded-lg bg-surface-base border border-border-base text-muted hover:text-base transition-all active:scale-95">
				<i class="ri-close-line"></i>
			</button>
		</div>

		<div class="px-5 py-4 flex flex-col gap-4 max-h-[60vh] overflow-y-auto">
			<?php foreach ($mob_branches as $branch) :
				$title      = esc_html($branch['title'] ?? '');
				$label      = esc_html($branch['label'] ?? $title);
				$color      = esc_attr($branch['color'] ?? '#7a22cb');
				$phones_raw = $branch['phones'] ?? '';
				$phones     = is_array($phones_raw)
					? array_filter(array_map('trim', $phones_raw))
					: array_filter(array_map('trim', explode(',', $phones_raw)));
				if (empty($title)) continue;
			?>
			<div class="flex items-center gap-3 pb-4 border-b border-border-base last:border-b-0 last:pb-0">
				<div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0" style="background-color: var(--custom-header-branch-phone-bg, #fde3f1);">
					<i class="ri-phone-fill text-xl" style="color: var(--custom-header-branch-phone-color, #ec008c);"></i>
				</div>
				<div class="flex flex-col gap-2 w-full">
					<span class="text-sm font-bold"><?php echo $label; ?></span>
					<div class="flex flex-wrap gap-2">
						<?php foreach ($phones as $phone) :
							$clean = preg_replace('/[^0-9]/', '', $phone);
						?>
						<a href="tel:<?php echo esc_attr($clean); ?>"
							class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-light text-white rounded-full transition-all duration-300 hover:scale-105 active:scale-95 shadow-sm"
							style="background-color: <?php echo $color; ?>;">
							<i class="ri-phone-line"></i><?php echo esc_html($phone); ?>
						</a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
