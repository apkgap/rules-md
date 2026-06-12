<?php
/**
 * Template part for displaying branch selector buttons with dropdown pills.
 *
 * @package starter_theme
 */

$branches = starter_theme_get_option('header_branches');

if (empty($branches) || !is_array($branches)) {
	// Fallback data matching the user request screenshot
	$branches = array(
		array(
			'title'  => 'สาขา 1',
			'label'  => 'สาขา 1 :',
			'color'  => '#7a22cb',
			'phones' => array('092-886-9926', '063-661-4666', '089-451-6664'),
		),
		array(
			'title'  => 'สาขา 2',
			'label'  => 'สาขา 2 :',
			'color'  => '#bf80ff',
			'phones' => array('099-249-3636', '086-996-4165'),
		),
	);
}
?>
<div x-data="{ open: false }" class="relative z-50" @click.outside="open = false">
	<button
		@click="open = !open"
		class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-light rounded-full border transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer"
		:style="open ? {
			backgroundColor: 'var(--custom-header-branch-active-bg, var(--color-primary, #ec008c)) !important',
			borderColor: 'var(--custom-header-branch-active-bg, var(--color-primary, #ec008c)) !important',
			color: 'var(--custom-header-branch-active-color, #ffffff) !important'
		} : {
			backgroundColor: 'var(--custom-header-branch-bg, var(--bg-surface, #ffffff)) !important',
			borderColor: 'var(--custom-header-branch-border, var(--border-base, #e5e7eb)) !important',
			color: 'var(--custom-header-branch-color, var(--text-base, #111827)) !important'
		}"
	>
		<i class="ri-map-pin-line"></i>
		<span class="text-sm font-light"><?php echo esc_html__('สาขา', 'starter-theme'); ?></span>
		<i class="ri-arrow-down-s-line text-xs opacity-70 transition-transform duration-300" 
			:class="open ? 'rotate-180' : ''"
			:style="open ? {
				color: 'var(--custom-header-branch-active-color, #ffffff)'
			} : {
				color: 'var(--custom-header-branch-color, inherit)'
			}"
		></i>
	</button>

	<!-- Consolidated Dropdown Menu -->
	<div 
		x-show="open"
		x-cloak
		x-transition:enter="transition ease-out duration-200"
		x-transition:enter-start="opacity-0 translate-y-2 scale-95"
		x-transition:enter-end="opacity-100 translate-y-0 scale-100"
		x-transition:leave="transition ease-in duration-150"
		x-transition:leave-start="opacity-100 translate-y-0 scale-100"
		x-transition:leave-end="opacity-0 translate-y-2 scale-95"
		class="absolute right-0 mt-3 bg-bg-base border border-border-base rounded-2xl shadow-xl p-5 z-50 min-w-[320px] md:min-w-[480px] flex flex-col gap-4"
		style="background-color: var(--custom-popup-bg, var(--bg-base)); color: var(--custom-popup-text, inherit);"
	>
		<?php foreach ($branches as $index => $branch) : 
			$title = esc_html($branch['title'] ?? '');
			$label = esc_html($branch['label'] ?? '');
			$color = esc_attr($branch['color'] ?? '#7a22cb');
			$phones_raw = $branch['phones'] ?? '';
			
			if (is_array($phones_raw)) {
				$phones = array_filter(array_map('trim', $phones_raw));
			} else {
				$phones = array_filter(array_map('trim', explode(',', $phones_raw)));
			}
			
			if (empty($title)) continue;
		?>
			<!-- Branch Row -->
			<div class="flex items-center gap-3 w-full border-b border-border-base pb-3 last:border-b-0 last:pb-0">
				<!-- Pink Phone Icon -->
				<div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0" style="background-color: var(--custom-header-branch-phone-bg, #fde3f1);">
					<i class="ri-phone-fill text-xl" style="color: var(--custom-header-branch-phone-color, #ec008c);"></i>
				</div>
				
				<!-- Branch Info & Phones -->
				<div class="flex flex-col md:flex-row md:items-center gap-3 w-full">
					<span class="text-base md:text-lg font-bold whitespace-nowrap" style="color: var(--custom-header-text, var(--text-base));">
						<?php echo $label; ?>
					</span>
					
					<!-- Phone Pills -->
					<div class="flex flex-wrap gap-2">
						<?php foreach ($phones as $phone) : 
							$clean_phone = preg_replace('/[^0-9]/', '', $phone);
						?>
							<a 
								href="tel:<?php echo esc_attr($clean_phone); ?>"
								class="inline-flex items-center justify-center px-4 py-1.5 text-xs font-light text-white rounded-2xl transition-all duration-300 hover:scale-105 active:scale-95 shadow-sm hover:shadow-md"
								style="background-color: <?php echo $color; ?>; color: #ffffff;"
							>
								<?php echo esc_html($phone); ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
