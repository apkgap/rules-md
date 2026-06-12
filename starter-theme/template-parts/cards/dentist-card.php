<?php
/**
 * Dentist Card Template Part
 *
 * Renders a premium, vertical dentist portrait card matching the BEM standard.
 *
 * @package starter_theme
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$post_id  = get_the_ID();

// Get dentist specialty
$specialties = get_the_terms($post_id, 'dentist_specialty');
$specialty = (! empty($specialties) && ! is_wp_error($specialties)) ? $specialties[0] : null;

// Get experience meta
$experience = get_post_meta($post_id, 'dentist_experience', true);

$card_classes = 'dentist-card group relative bg-surface-base rounded-[2rem] border border-border-base shadow-sm hover:shadow-xl hover:border-primary/20 transition-all duration-500 overflow-hidden flex flex-col h-full';
$img_wrap_classes = 'dentist-card__image-wrapper relative block overflow-hidden shrink-0 w-full aspect-[3/4]';
?>

<article class="<?php echo esc_attr($card_classes); ?>">

	<!-- PORTRAIT WRAPPER -->
	<a href="<?php the_permalink(); ?>" class="<?php echo esc_attr($img_wrap_classes); ?>">
		<?php if (has_post_thumbnail()) : ?>
			<?php the_post_thumbnail('medium_large', array('class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105')); ?>
		<?php else : ?>
			<div class="w-full h-full bg-bg-base flex flex-col items-center justify-center text-muted opacity-30 gap-2">
				<span class="text-4xl"><i class="ri-user-line"></i></span>
				<span class="text-xs"><?php echo esc_html__('ไม่มีรูปภาพแพทย์', 'starter-theme'); ?></span>
			</div>
		<?php endif; ?>

		<!-- SPECIALTY OVERLAY -->
		<?php if ($specialty) : ?>
			<span class="dentist-card__badge absolute top-4 left-4 px-4 py-1.5 bg-primary/5 text-primary rounded-full text-xs font-light uppercase tracking-widest leading-none border border-primary/10 transition-colors">
				<?php echo esc_html($specialty->name); ?>
			</span>
		<?php endif; ?>
	</a>

	<!-- CONTENT WRAPPER -->
	<div class="dentist-card__content p-[15px] md:p-[20px] flex flex-col flex-1">

		<!-- Dentist Name -->
		<h3 class="dentist-card__title font-display text-lg font-bold text-gray-900 leading-tight mb-2 group-hover:text-primary transition-colors line-clamp-1 m-0 mb-2">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<!-- Subtitle: Specialty Details -->
		<?php if ($specialty) : ?>
			<div class="text-xs text-primary font-semibold tracking-wide mb-4 uppercase">
				<?php echo esc_html($specialty->name); ?>
			</div>
		<?php endif; ?>

		<!-- Experience & Short Info -->
		<div class="dentist-card__excerpt text-xs text-muted leading-relaxed mb-6 line-clamp-2 opacity-80 flex flex-col gap-2">
			<?php if (!empty($experience)) : ?>
				<span class="flex items-center gap-2 text-gray-800 font-semibold bg-gray-50 px-3 py-1.5 rounded-lg border border-border-base/50 self-start">
					<i class="ri-briefcase-line text-primary"></i>
					<?php echo sprintf(esc_html__('ประสบการณ์ %s ปี', 'starter-theme'), esc_html($experience)); ?>
				</span>
			<?php endif; ?>
			<p class="text-muted/80 mt-1"><?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?></p>
		</div>

		<!-- Card Footer -->
		<div class="dentist-card__footer mt-auto pt-5 border-t border-black/10 flex items-center justify-between">
			<a href="<?php the_permalink(); ?>" class="text-xs font-normal text-primary flex items-center gap-1.5 group/btn">
				<?php echo esc_html__('นัดหมายแพทย์ / ดูประวัติ', 'starter-theme'); ?>
				<span class="w-3.5 h-3.5 transition-transform group-hover/btn:translate-x-1 flex items-center justify-center">
					<i class="ri-arrow-right-line"></i>
				</span>
			</a>
		</div>
	</div>

</article>
