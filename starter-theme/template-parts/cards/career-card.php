<?php

/**
 * Career Card Template
 *
 * @package starter_theme
 */

if (! defined('ABSPATH')) {
	exit;
}

$post_id = get_the_ID();
$date    = get_the_date('d/m/Y');
// Note: You might need a plugin like Post Views Counter for actual view counts, 
// for now we'll use a dummy value or check if a common meta exists.
$views   = get_post_meta($post_id, 'post_views_count', true) ?: '0';
?>

<article class="career-card group relative bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:shadow-md hover:border-primary/20 flex flex-col md:flex-row md:items-center justify-between gap-6">
	<div class="career-card__content flex-1 flex flex-col gap-3">
		<h3 class="career-card__title text-base font-semibold text-gray-900 m-0 group-hover:text-primary transition-colors line-clamp-2">
			<a href="<?php the_permalink(); ?>" class="after:absolute after:inset-0">
				<?php the_title(); ?>
			</a>
		</h3>

		<div class="career-card__meta flex flex-wrap items-center gap-6 text-gray-400 text-sm">
			<div class="flex items-center gap-2">
				<span class="w-3 h-3 opacity-50 flex items-center justify-center">
					<i class="ri-arrow-right-line"></i>
				</span>
				<span><?php echo esc_html($date); ?></span>
			</div>

			<div class="flex items-center gap-2">
				<span class="w-3 h-3 opacity-50 flex items-center justify-center">
					<i class="ri-arrow-right-line"></i>
				</span>
				<span><?php echo esc_html($views); ?></span>
			</div>
		</div>
	</div>

	<div class="career-card__action flex-shrink-0 relative z-10">
		<a href="<?php the_permalink(); ?>" class="inline-flex items-start justify-center gap-2 px-6 py-2 bg-primary text-white text-sm font-medium rounded-full transition-all duration-300 hover:bg-primary-dark">
			<span><?php echo esc_html__('อ่านเพิ่มเติม', 'starter-theme'); ?></span>
			<span class="w-3 h-3 transition-transform duration-300 group-hover/btn:translate-x-1 flex items-center justify-center">
				<i class="ri-arrow-right-line"></i>
			</span>
		</a>
	</div>
</article>