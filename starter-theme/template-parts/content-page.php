<?php
$is_elementor = false;
if (did_action('elementor/loaded')) {
	$document = \Elementor\Plugin::$instance->documents->get(get_the_ID());
	$is_elementor = $document && $document->is_built_with_elementor();
}

if ($is_elementor) :
	the_content();
else :
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('bg-bg-base transition-colors duration-500'); ?>>
		<div class="container mx-auto px-6 py-16">
			<header class="entry-header mb-12">
				<?php the_title('<h1 class="font-display text-4xl md:text-5xl font-bold text-base mb-6">', '</h1>'); ?>
			</header><!-- .entry-header -->

			<?php if (has_post_thumbnail()) : ?>
				<div class="mb-12 rounded-3xl overflow-hidden shadow-xl">
					<?php the_post_thumbnail('full', ['class' => 'w-full h-auto']); ?>
				</div>
			<?php endif; ?>

			<div class="entry-content prose prose-lg dark:prose-invert max-w-none prose-headings:text-base prose-p:text-muted">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links mt-8 py-4 border-t border-border-base font-bold text-base">' . esc_html__('Pages:', 'starter-theme'),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->

			<?php if (get_edit_post_link()) : ?>
				<footer class="entry-footer mt-12 pt-8 border-t border-border-base">
					<?php
					edit_post_link(
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__('Edit <span class="screen-reader-text">%s</span>', 'starter-theme'),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							wp_kses_post(get_the_title())
						),
						'<span class="px-6 py-2 bg-surface-base border border-border-base rounded-full text-muted hover:text-primary transition-colors text-xs font-bold">',
						'</span>'
					);
					?>
				</footer><!-- .entry-footer -->
			<?php endif; ?>
		</div>
	</article><!-- #post-<?php the_ID(); ?> -->
<?php endif; ?>