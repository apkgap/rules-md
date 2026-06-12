<?php
/**
 * Annual Report Card Template
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id    = get_the_ID();
$views      = get_post_meta( $post_id, 'post_views_count', true );
$views_text = $views ? number_format_i18n( $views ) : '0';
$date       = get_the_date( 'd/m/Y' );
?>

<article class="annual-report-card group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col h-full">
	<div class="annual-report-card__media relative aspect-[2/3] overflow-hidden bg-gray-100">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110' ) ); ?>
		<?php else : ?>
			<div class="w-full h-full flex items-center justify-center text-5xl text-gray-300">
				<span class="w-20 h-20">
					<i class="ri-file-pdf-line"></i>
				</span>
			</div>
		<?php endif; ?>
		
		<!-- Overlay on hover -->
		<div class="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
			<div class="w-12 h-12 rounded-full bg-white text-primary flex items-center justify-center scale-75 group-hover:scale-100 transition-transform duration-500 shadow-lg">
				<span class="w-6 h-6">
					<i class="ri-arrow-right-line"></i>
				</span>
			</div>
		</div>
	</div>

	<div class="annual-report-card__body p-4 flex flex-col flex-grow">
		<h3 class="m-0 text-base md:text-lg font-bold text-gray-900 leading-snug line-clamp-2 mb-3">
			<a href="<?php the_permalink(); ?>" class="after:absolute after:inset-0 hover:text-primary transition-colors">
				<?php the_title(); ?>
			</a>
		</h3>
		
		<div class="mt-auto flex items-center justify-between text-[11px] md:text-xs text-gray-500 font-medium border-t border-gray-50 pt-3">
			<div class="flex items-center gap-2">
				<span class="w-3.5 h-3.5 text-gray-800 flex items-center justify-center ml-[-4px]">
					<i class="ri-calendar-event-line"></i>
				</span>
				<span><?php echo esc_html( $date ); ?></span>
			</div>
			<div class="flex items-center gap-2">
				<span class="w-3.5 h-3.5 text-gray-800 flex items-center justify-center ml-[-4px]">
					<i class="ri-eye-line"></i>
				</span>
				<span><?php echo esc_html( $views_text ); ?></span>
			</div>
		</div>
	</div>
</article>