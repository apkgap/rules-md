<?php
/**
 * Executive Card Template
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id        = get_the_ID();
$position_terms = get_the_terms( $post_id, 'executive_position' );
$position_name  = '';

if ( is_array( $position_terms ) && ! empty( $position_terms ) ) {
	$first_term = $position_terms[0];
	if ( $first_term instanceof WP_Term ) {
		$position_name = $first_term->name;
	}
}
?>

<article class="executive-card group relative rounded-2xl border border-[#d8dde4] bg-white overflow-hidden transition-all duration-300 hover:shadow-md">
	<div class="executive-card__media bg-[#f3f5f8] flex items-end justify-center overflow-hidden">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full aspect-5/7 object-contain object-bottom' ) ); ?>
		<?php else : ?>
			<div class="w-full aspect-5/7 flex items-center justify-center text-4xl text-gray-300">
				<span class="w-16 h-16 flex items-center justify-center opacity-30">
					<i class="ri-arrow-right-line"></i>
				</span>
			</div>
		<?php endif; ?>
	</div>

	<div class="executive-card__body px-3 py-4 text-center border-t border-[#e5e9ef]">
		<h3 class="m-0 text-base font-semibold text-[#111827] leading-tight">
			<a href="<?php the_permalink(); ?>" class="after:absolute after:inset-0 focus-visible:outline-2 focus-visible:outline-primary rounded-sm">
				<?php the_title(); ?>
			</a>
		</h3>
		<?php if ( $position_name ) : ?>
			<p class="mt-2 mb-0 text-sm text-[#4b5563] leading-snug"><?php echo esc_html( $position_name ); ?></p>
		<?php endif; ?>
	</div>
</article>
