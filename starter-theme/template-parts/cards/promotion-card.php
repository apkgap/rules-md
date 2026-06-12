<?php
/**
 * Promotion Card Template Part
 *
 * Renders a premium, vertical/portrait aspect promotion card matching the BEM standard.
 * Supports horizontal, compact, and featured variants via $args['variant'].
 *
 * @package starter_theme
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$post_id  = get_the_ID();
$variant  = $args['variant'] ?? 'vertical'; // vertical, horizontal, compact, featured

// Get promotion categories
$terms = get_the_terms($post_id, 'promotion_cat');
$main_term = (! empty($terms) && ! is_wp_error($terms)) ? $terms[0] : null;

// Determine layout classes based on variant
$card_classes = 'promotion-card group relative bg-surface-base rounded-3xl border border-border-base shadow-sm hover:shadow-xl hover:border-primary/20 transition-all duration-500 overflow-hidden flex';
$img_wrap_classes = 'promotion-card__image-wrapper relative block overflow-hidden shrink-0';

if ($variant === 'horizontal') {
	$card_classes .= ' flex-col md:flex-row h-full';
	$img_wrap_classes .= ' w-full md:w-[240px] aspect-[3/4]';
} elseif ($variant === 'compact') {
	$card_classes .= ' flex-row items-center gap-4 p-4';
	$img_wrap_classes .= ' w-24 h-24 rounded-2xl aspect-square';
} else {
	// Default: vertical
	$card_classes .= ' flex-col h-full';
	$img_wrap_classes .= ' w-full aspect-[3/4]'; // Strict portrait/vertical aspect ratio
}
?>

<article class="<?php echo esc_attr($card_classes); ?>">

	<!-- IMAGE WRAPPER -->
	<a href="<?php the_permalink(); ?>" class="<?php echo esc_attr($img_wrap_classes); ?>">
		<?php if (has_post_thumbnail()) : ?>
			<?php the_post_thumbnail('medium_large', array('class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110')); ?>
		<?php else : ?>
			<div class="w-full h-full bg-bg-base flex items-center justify-center">
				<span class="text-muted opacity-20 text-3xl"><i class="ri-image-line"></i></span>
			</div>
		<?php endif; ?>

		<!-- CATEGORY OVERLAY (Not shown in compact) -->
		<?php if ($main_term && $variant !== 'compact') : ?>
			<span class="promotion-card__badge absolute top-4 left-4 px-3 py-1 bg-primary/95 text-white text-xs font-light uppercase tracking-widest rounded-full shadow-lg backdrop-blur-sm z-10">
				<?php echo esc_html($main_term->name); ?>
			</span>
		<?php endif; ?>
	</a>

	<!-- CONTENT WRAPPER -->
	<?php if ($variant === 'compact') : ?>
		<div class="promotion-card__content flex-1 min-w-0 flex flex-col gap-1">
			<span class="text-[10px] text-primary font-bold uppercase tracking-wider">
				<?php echo cttm_thai_date($post_id, 'short'); ?>
			</span>
			<h4 class="promotion-card__title text-sm font-bold text-gray-900 m-0 group-hover:text-primary transition-colors line-clamp-2">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h4>
		</div>
	<?php else : ?>
		<div class="promotion-card__content p-6 md:p-8 flex flex-col flex-1">
			<!-- Date Meta -->
			<div class="promotion-card__meta flex items-center gap-2 mb-4 text-[11px] text-muted font-bold uppercase tracking-wider">
				<span class="w-3.5 h-3.5 text-primary flex items-center justify-center">
					<i class="ri-calendar-event-line"></i>
				</span>
				<span><?php echo cttm_thai_date($post_id, 'short'); ?></span>
			</div>

			<!-- Title -->
			<h3 class="promotion-card__title font-display text-lg font-bold text-gray-900 leading-tight mt-0 mb-2 group-hover:text-primary transition-colors line-clamp-2">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>

			<!-- Excerpt -->
			<div class="promotion-card__excerpt text-xs text-muted leading-relaxed mb-6 line-clamp-2 opacity-80">
				<?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?>
			</div>

			<!-- Card Footer -->
			<div class="promotion-card__footer mt-auto pt-5 border-t border-black/10 flex items-center justify-between">
				<a href="<?php the_permalink(); ?>" class="text-sm font-normal text-primary flex items-center gap-1.5 group/btn">
					<?php echo esc_html__('ดูรายละเอียดโปรโมชั่น', 'starter-theme'); ?>
					<span class="w-3.5 h-3.5 transition-transform group-hover/btn:translate-x-1 flex items-center justify-center">
						<i class="ri-arrow-right-line"></i>
					</span>
				</a>
			</div>
		</div>
	<?php endif; ?>

</article>
