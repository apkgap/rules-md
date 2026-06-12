<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! isset( $pagination ) || ! is_array( $pagination ) ) {
	$pagination = get_query_var( 'pagination' );
}


if ( empty( $pagination ) || ! is_array( $pagination ) ) {
	return;
}

$prev_label = esc_html__('ก่อนหน้า', 'starter-theme');
$next_label = esc_html__('ถัดไป', 'starter-theme');
$page_label = sprintf(
	esc_html__('หน้า %1$d จาก %2$d', 'starter-theme'),
	(int) $pagination['current'],
	(int) $pagination['total']
);
?>
<nav class="starter-theme-pagination starter-theme-pagination--primary my-8" aria-label="<?php echo esc_attr__( 'Pagination', 'starter-theme' ); ?>">
	<div class="flex items-center justify-between gap-4 md:grid md:grid-cols-[140px_minmax(0,1fr)_140px] md:gap-6">
		<div class="flex min-w-[40px] justify-start md:min-w-[140px]">
			<?php if ( ! empty( $pagination['prev_url'] ) ) : ?>
				<a class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-starter-text-primary text-starter-text-primary no-underline transition-opacity hover:opacity-80 md:min-h-11 md:w-auto md:gap-2 md:px-4 md:py-2 md:text-[0.95rem] md:font-medium" href="<?php echo esc_url( $pagination['prev_url'] ); ?>">
					<span class="w-5 h-5 flex items-center justify-center">
						<i class="ri-arrow-right-line"></i>
					</span>
					<span class="hidden md:inline"><?php echo esc_html( $prev_label ); ?></span>
				</a>
			<?php else : ?>
				<span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-[#dbe3ef] text-starter-icon-subdued md:hidden" aria-hidden="true">
					<span class="w-5 h-5 flex items-center justify-center">
						<i class="ri-arrow-right-line"></i>
					</span>
			</span>
			<?php endif; ?>
		</div>

		<div class="flex flex-1 items-center justify-center md:hidden">
			<span class="text-[0.95rem] text-starter-icon-subdued"><?php echo esc_html( $page_label ); ?></span>
		</div>

		<div class="hidden flex-wrap items-center justify-center gap-2 md:flex md:flex-1">
			<?php foreach ( $pagination['items'] as $item ) : ?>
				<?php if ( 'dots' === $item['type'] ) : ?>
					<span class="inline-flex h-10 min-w-10 items-center justify-center px-2 text-[0.95rem] text-starter-text-black">...</span>
				<?php elseif ( ! empty( $item['current'] ) ) : ?>
					<span aria-current="page" class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl bg-[#f5f5f5] px-3 text-[0.95rem] font-medium text-starter-text-black"><?php echo esc_html( $item['label'] ); ?></span>
				<?php else : ?>
					<a class="inline-flex h-10 min-w-10 items-center justify-center px-3 text-[0.95rem] text-starter-text-black no-underline transition-opacity hover:opacity-70" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>

		<div class="flex min-w-[40px] justify-end md:min-w-[140px] md:justify-end">
			<?php if ( ! empty( $pagination['next_url'] ) ) : ?>
				<a class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-starter-text-primary text-starter-text-primary no-underline transition-opacity hover:opacity-80 md:min-h-11 md:w-auto md:gap-2 md:px-4 md:py-2 md:text-[0.95rem] md:font-medium" href="<?php echo esc_url( $pagination['next_url'] ); ?>">
					<span class="hidden md:inline"><?php echo esc_html( $next_label ); ?></span>
					<span class="w-5 h-5 flex items-center justify-center">
						<i class="ri-arrow-right-line"></i>
					</span>
				</a>
			<?php else : ?>
				<span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-[#dbe3ef] text-starter-icon-subdued md:hidden" aria-hidden="true">
					<span class="w-5 h-5 flex items-center justify-center">
						<i class="ri-arrow-right-line"></i>
					</span>
			</span>
			<?php endif; ?>
		</div>
	</div>
</nav>
