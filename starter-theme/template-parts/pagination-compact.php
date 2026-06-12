<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! isset($pagination) || ! is_array($pagination)) {
	$pagination = get_query_var('pagination');
}

if (empty($pagination) || ! is_array($pagination)) {
	return;
}

$jump_base = isset($pagination['jump_base']) ? (string) $pagination['jump_base'] : '';

$summary_text = sprintf(
	esc_html__('แสดง %1$d-%2$d จาก %3$d รายการ', 'starter-theme'),
	(int) $pagination['start_item'],
	(int) $pagination['end_item'],
	(int) $pagination['total_posts']
);
?>
<nav class="starter-theme-pagination starter-theme-pagination--compact my-8" aria-label="<?php echo esc_attr__('Pagination', 'starter-theme'); ?>">
	<div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
		<div class="flex items-center justify-center gap-1.5 text-starter-icon-subdued md:justify-start md:gap-3">
			<?php if (! empty($pagination['first_url'])) : ?>
				<a class="inline-flex h-8 w-8 items-center justify-center rounded-full text-starter-icon-subdued no-underline transition-colors hover:bg-[#f5f5f5] hover:text-starter-text-black md:h-10 md:w-10" href="<?php echo esc_url($pagination['first_url']); ?>" aria-label="<?php echo esc_attr__('First page', 'starter-theme'); ?>">
					<div class="flex -space-x-2.5">
						<span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
						<span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
					</div>
				</a>
			<?php else : ?>
				<span class="inline-flex h-8 w-8 items-center justify-center rounded-full text-[#d1d5db] md:h-10 md:w-10" aria-hidden="true">
					<div class="flex -space-x-2.5">
						<span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
						<span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
					</div>
				</span>
			<?php endif; ?>

			<?php if (! empty($pagination['prev_url'])) : ?>
				<a class="inline-flex h-8 w-8 items-center justify-center rounded-full text-starter-icon-subdued no-underline transition-colors hover:bg-[#f5f5f5] hover:text-starter-text-black md:h-10 md:w-10" href="<?php echo esc_url($pagination['prev_url']); ?>" aria-label="<?php echo esc_attr__('Previous page', 'starter-theme'); ?>">
					<span class="w-3 h-3 flex items-center justify-center">
						<i class="ri-arrow-right-line"></i>
					</span>
				</a>
			<?php else : ?>
				<span class="inline-flex h-8 w-8 items-center justify-center rounded-full text-[#d1d5db] md:h-10 md:w-10" aria-hidden="true"><span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span></span>
			<?php endif; ?>

			<form class="starter-theme-pagination__jump-form flex items-center gap-2 text-[0.8125rem] text-starter-text-black md:gap-2 md:text-[1rem]" method="get" action="" data-jump-base="<?php echo esc_url($jump_base); ?>">
				<label class="sr-only" for="starter-theme-pagination-page"><?php echo esc_html__('Page number', 'starter-theme'); ?></label>
				<input id="starter-theme-pagination-page" class="h-8 w-[42px] rounded-lg border border-[#d1d5db] bg-white px-2 text-center text-[0.8125rem] text-starter-text-black outline-none transition-colors focus:border-starter-text-primary md:min-h-10 md:w-[58px] md:rounded-xl md:px-3 md:text-[1rem]" type="number" name="paged" min="1" max="<?php echo esc_attr((string) $pagination['total']); ?>" value="<?php echo esc_attr((string) $pagination['current']); ?>">
				<span><?php echo esc_html__('จาก', 'starter-theme'); ?> <?php echo esc_html((string) $pagination['total']); ?></span>
			</form>

			<?php if (! empty($pagination['next_url'])) : ?>
				<a class="inline-flex h-8 w-8 items-center justify-center rounded-full text-starter-icon-subdued no-underline transition-colors hover:bg-[#f5f5f5] hover:text-starter-text-black md:h-10 md:w-10" href="<?php echo esc_url($pagination['next_url']); ?>" aria-label="<?php echo esc_attr__('Next page', 'starter-theme'); ?>">
					<span class="w-3 h-3 flex items-center justify-center">
						<i class="ri-arrow-right-line"></i>
					</span>
				</a>
			<?php else : ?>
				<span class="inline-flex h-8 w-8 items-center justify-center rounded-full text-[#d1d5db] md:h-10 md:w-10" aria-hidden="true"><span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span></span>
			<?php endif; ?>

			<?php if (! empty($pagination['last_url'])) : ?>
				<a class="inline-flex h-8 w-8 items-center justify-center rounded-full text-starter-icon-subdued no-underline transition-colors hover:bg-[#f5f5f5] hover:text-starter-text-black md:h-10 md:w-10" href="<?php echo esc_url($pagination['last_url']); ?>" aria-label="<?php echo esc_attr__('Last page', 'starter-theme'); ?>">
					<div class="flex -space-x-2.5">
						<span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
						<span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
					</div>
				</a>
			<?php else : ?>
				<span class="inline-flex h-8 w-8 items-center justify-center rounded-full text-[#d1d5db] md:h-10 md:w-10" aria-hidden="true">
					<div class="flex -space-x-2.5">
						<span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
						<span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
					</div>
				</span>
			<?php endif; ?>

		</div>

		<p class="m-0 text-center text-[0.6875rem] text-starter-icon-subdued md:text-right md:text-[0.95rem]"><?php echo esc_html($summary_text); ?></p>
	</div>
</nav>