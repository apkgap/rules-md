<?php
/**
 * Fallback Card Template for KU Posts Widget
 *
 * @package starter-elementor-addon
 */

$post_id = get_the_ID();
$thumb_url = get_the_post_thumbnail_url( $post_id, 'medium_large' );
?>

<article class="starter-theme-post-card-grid starter-theme-post-grid group block space-y-4">
	<a href="<?php the_permalink(); ?>" class="starter-theme-post-grid__link block">
		<div class="starter-theme-post-grid__image-wrap aspect-16/10 rounded-2xl overflow-hidden border border-border-base/50 shadow-sm transition-all duration-500 group-hover:scale-[1.03] group-hover:shadow-lg">
			<?php if ( $thumb_url ) : ?>
				<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
			<?php else : ?>
				<div class="w-full h-full bg-slate-100 flex items-center justify-center">
					<span class="w-10 h-10 flex items-center justify-center text-slate-300"><i class="ri-arrow-right-line"></i></span>
				</div>
			<?php endif; ?>
		</div>
	</a>

	<div class="starter-theme-post-grid__content space-y-2 px-1">
		<div class="starter-theme-post-grid__meta flex items-center gap-3">
			<span class="starter-theme-post-grid__date text-xs font-medium text-primary uppercase tracking-widest"><?php echo cttm_thai_date( get_the_ID(), 'short' ); ?></span>
			<span class="starter-theme-post-grid__divider w-1 h-1 bg-border-base rounded-full opacity-50"></span>
			<?php
			$cats = get_the_category();
			if ( $cats ) : ?>
				<span class="starter-theme-post-grid__category text-xs font-light text-muted uppercase tracking-wider"><?php echo esc_html( $cats[0]->name ); ?></span>
			<?php endif; ?>
		</div>
		<h4 class="starter-theme-post-grid__title font-medium text-sm leading-snug group-hover:text-primary transition-colors line-clamp-2 m-0 font-display">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h4>
	</div>
</article>
