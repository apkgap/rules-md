<?php
/**
 * Service Card Template Part
 *
 * Renders a premium, vertical service card matching the BEM standard.
 *
 * @package starter_theme
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$post_id  = get_the_ID();
$variant  = $args['variant'] ?? 'vertical';

// Get service categories
$terms = get_the_terms($post_id, 'service_category');
$main_term = (! empty($terms) && ! is_wp_error($terms)) ? $terms[0] : null;

$card_classes = 'service-card group relative bg-surface-base rounded-3xl border border-border-base shadow-sm hover:shadow-xl hover:border-primary/20 transition-all duration-500 overflow-hidden flex flex-col h-full';
$img_wrap_classes = 'service-card__image-wrapper relative block overflow-hidden shrink-0 w-full aspect-[4/3]';
?>

<article class="<?php echo esc_attr($card_classes); ?>">

	<!-- IMAGE WRAPPER -->
	<a href="<?php the_permalink(); ?>" class="<?php echo esc_attr($img_wrap_classes); ?>">
		<?php if (has_post_thumbnail()) : ?>
			<?php the_post_thumbnail('medium_large', array('class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110')); ?>
		<?php else : ?>
			<div class="w-full h-full bg-bg-base flex items-center justify-center">
				<span class="text-muted opacity-20 text-3xl"><i class="ri-heart-line"></i></span>
			</div>
		<?php endif; ?>

		<!-- CATEGORY OVERLAY -->
		<?php if ($main_term) : ?>
			<span class="service-card__badge absolute top-4 left-4 px-4 py-1.5 bg-primary/95 text-white text-[11px] font-bold uppercase tracking-widest rounded-full shadow-lg backdrop-blur-sm z-10">
				<?php echo esc_html($main_term->name); ?>
			</span>
		<?php endif; ?>
	</a>

	<!-- CONTENT WRAPPER -->
	<div class="service-card__content p-[15px] md:p-[20px] flex flex-col flex-1">
		<!-- Title -->
		<h3 class="service-card__title font-display text-lg font-bold text-gray-900 leading-tight group-hover:text-primary transition-colors line-clamp-2 m-0 mb-1">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<!-- Excerpt -->
		<div class="service-card__excerpt text-xs text-muted leading-relaxed mb-6 line-clamp-2 opacity-80">
			<?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?>
		</div>

		<!-- Card Footer -->
		<div class="service-card__footer mt-auto pt-5 border-t border-black/10 flex items-center justify-between">
			<a href="<?php the_permalink(); ?>" class="text-xs font-normal text-primary flex items-center gap-1.5 group/btn">
				<?php echo esc_html__('ดูรายละเอียดบริการ', 'starter-theme'); ?>
				<span class="w-3.5 h-3.5 transition-transform group-hover/btn:translate-x-1 flex items-center justify-center">
					<i class="ri-arrow-right-line"></i>
				</span>
			</a>
		</div>
	</div>

</article>
