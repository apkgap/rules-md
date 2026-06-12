<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function starter_theme_body_classes($classes)
{
	// Adds a class of hfeed to non-singular pages.
	if (! is_singular()) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if (! is_active_sidebar('sidebar-1')) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter('body_class', 'starter_theme_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function starter_theme_pingback_header()
{
	if (is_singular() && pings_open()) {
		printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
	}
}
add_action('wp_head', 'starter_theme_pingback_header');

function starter_theme_get_archive_page_title_background($explicit_bg = '', $post_id = null)
{
	$post_type_slug = '';

	if (is_post_type_archive()) {
		$post_type = get_query_var('post_type');
		if (is_array($post_type)) {
			$post_type_slug = isset($post_type[0]) ? sanitize_key($post_type[0]) : '';
		} elseif (is_string($post_type)) {
			$post_type_slug = sanitize_key($post_type);
		}
	} elseif (is_tax()) {
		$tax_obj = get_queried_object();
		if ($tax_obj instanceof WP_Term) {
			$taxonomy = get_taxonomy($tax_obj->taxonomy);
			if ($taxonomy && !empty($taxonomy->object_type) && isset($taxonomy->object_type[0])) {
				$post_type_slug = sanitize_key($taxonomy->object_type[0]);
			}
		}
	} elseif (is_singular() && $post_id) {
		$post_type = get_post_type($post_id);
		if ($post_type) {
			$post_type_slug = sanitize_key($post_type);
		}
	}

	$show_bg = true;
	$bg_image = $explicit_bg;

	if (function_exists('starter_theme_get_option')) {
		if (empty($bg_image) && (is_archive() || is_tax() || is_home() || (is_singular() && $post_id))) {
			$show_bg = starter_theme_get_option('archive_header_show_bg', false);
			$bg_image = starter_theme_get_option('archive_header_bg_image', '');

			if (!empty($post_type_slug)) {
				$show_bg_pt = starter_theme_get_option('archive_header_show_bg_' . $post_type_slug, null);
				$bg_image_pt = starter_theme_get_option('archive_header_bg_image_' . $post_type_slug, '');

				if (null !== $show_bg_pt) {
					$show_bg = in_array($show_bg_pt, array(true, 1, '1', 'yes', 'on'), true);
				}

				if (!empty($bg_image_pt)) {
					$bg_image = $bg_image_pt;
				}
			}
		}

		if (empty($bg_image)) {
			$bg_image = starter_theme_get_option('page_title_bg_image', '');
		}
	}

	if (empty($bg_image)) {
		$bg_image = get_template_directory_uri() . '/assets/images/page-title-Starter.png';
	}

	return array(
		'show_bg' => in_array($show_bg, array(true, 1, '1', 'yes', 'on'), true),
		'bg_image' => $bg_image,
		'post_type_slug' => $post_type_slug,
	);
}

/**
 * Render the shared Page Title Hero Section.
 *
 * Renders a full-width hero section with:
 *   - Featured image as background (falls back to bg-primary)
 *   - Gradient overlay
 *   - A custom h1 title (or falls back to the current post/archive title)
 *   - Yoast SEO breadcrumbs (or a simple fallback)
 *
 * @param array $args {
 *     Optional. Override args.
 *     @type string $title        Custom heading text. Default: current post/page title.
 *     @type int    $post_id      Post ID for thumbnail lookup. Default: current post ID.
 *     @type bool   $use_thumbnail Whether to try to use the featured image. Default: true.
 * }
 */
function starter_theme_page_title_hero($args = [])
{
	$defaults = [
		'title'         => '',
		'post_id'       => get_the_ID(),
		'use_thumbnail' => true,
		'bg_image'      => '',
	];
	$args = wp_parse_args($args, $defaults);

	// Decide background
	$bg_style = '';
	$bg_class = 'bg-primary';
	$has_bg_image = false;

	if ($args['use_thumbnail'] && is_singular() && has_post_thumbnail($args['post_id'])) {
		$bg_url   = get_the_post_thumbnail_url($args['post_id'], 'full');
		$bg_style = 'background-image: url(' . esc_url($bg_url) . '); background-size: cover; background-position: center; background-repeat: no-repeat;';
		$bg_class = '';
		$has_bg_image = true;
	} else {
		$background = starter_theme_get_archive_page_title_background($args['bg_image'], $args['post_id']);
		$fallback_bg = $background['show_bg'] ? $background['bg_image'] : '';

		if (!empty($fallback_bg)) {
			$bg_style = 'background-image: url(' . esc_url($fallback_bg) . '); background-size: cover; background-position: center; background-repeat: no-repeat;';
			$bg_class = '';
			$has_bg_image = true;
		}
	}

	// Title fallback
	$title = $args['title'] ?: get_the_title($args['post_id']);
?>
	<section id="page-title-hero" class="relative w-full h-full py-[3em] md:py-[4em] lg:py-[10em] pt-[5em] lg:pb-[5em] px-[1.5em] md:px-[2em] xl:px-0 flex items-center overflow-hidden <?php echo esc_attr($bg_class); ?>" style="<?php echo esc_attr($bg_style); ?>">

		<?php if ($has_bg_image) : ?>
			<!-- Gradient Overlay for better text readability -->
			<div class="absolute inset-0 bg-linear-to-r from-black/60 via-black/30 to-transparent z-0"></div>
		<?php endif; ?>

		<div class="s-container relative z-10 px-0">
			<div class="flex flex-col">
				<!-- Breadcrumbs Style as Path Title -->
				<div class="starter-theme-breadcrumb-wrapper">
					<?php
					// Force separator to '/' for Yoast
					add_filter('wpseo_breadcrumb_separator', function ($sep) {
						return ' / ';
					});

					if (function_exists('yoast_breadcrumb')) {
						// We use CSS to hide the first item (Home) if it exists, to match the "Path" look in the image
						yoast_breadcrumb(
							'<div id="breadcrumbs" class="text-white text-base font-normal [&_a]:text-white [&_a]:no-underline hover:[&_a]:opacity-70 [&>span]:flex [&>span]:flex-wrap [&>span]:items-center [&>span]:gap-0 [&_.breadcrumb_last]:text-white [&>span>span:first-of-type]:hidden [&>span>span:nth-of-type(2)]:hidden">',
							'</div>'
						);
					} else {
						// Fallback if no Yoast
						echo '<div class="text-white text-base font-normal flex items-center gap-3">';
						// If there's a parent, it would show here. For now, just showing a clean path style
						echo '<span>' . esc_html($title) . '</span>';
						echo '</div>';
					}
					?>
				</div>
				<h1 class="text-white text-3xl md:text-4xl lg:text-5xl font-bold tracking-tight mb-4 drop-shadow-sm">
					<?php echo esc_html($title); ?>
				</h1>
			</div>
		</div>
	</section>
<?php
}

/**
 * Render dark-themed pagination.
 *
 * @param int $total  Total number of pages.
 * @param int $paged  Current page number.
 */
function starter_theme_dark_pagination(int $total, int $paged): void
{
	if ($total <= 1) return;

	$bignum = 999999999;
	$pages  = paginate_links([
		'base'      => str_replace($bignum, '%#%', esc_url(get_pagenum_link($bignum))),
		'format'    => '',
		'current'   => $paged,
		'total'     => $total,
		'prev_text' => '<span class="inline-flex w-3 h-3 items-center justify-center"><i class="ri-arrow-left-s-line"></i></span>',
		'next_text' => '<span class="inline-flex w-3 h-3 items-center justify-center"><i class="ri-arrow-right-s-line"></i></span>',
		'type'      => 'array',
		'end_size'  => 1,
		'mid_size'  => 2,
	]);

	if (! is_array($pages)) return;
?>
	<div id="starter-theme-pagination-wrapper" class="starter-theme-pagination flex items-center justify-center w-max mx-auto mt-16 mb-8">
		<nav id="starter-theme-pagination-nav" class="starter-theme-pagination__nav flex items-center gap-3 sm:gap-4 text-base transition-colors duration-500" aria-label="Pagination">
			<?php if ($paged > 1) : ?>
				<a id="pagination-first"
					class="starter-theme-pagination__btn starter-theme-pagination__btn--first w-10 h-10 flex items-center justify-center text-primary border border-border-base/40 rounded-xl hover:bg-primary hover:text-white transition-all duration-300"
					href="<?php echo esc_url(get_pagenum_link(1)); ?>"
					title="<?php echo esc_attr__('หน้าแรก', 'starter-theme'); ?>">
					<span class="w-3 h-3 flex items-center justify-center">
						<i class="ri-arrow-left-s-line"></i>
					</span>
				</a>
			<?php endif; ?>

			<?php foreach ($pages as $index => $page) :
				$is_current = strpos($page, 'current') !== false;
				$is_dots = strpos($page, 'dots') !== false;

				if ($is_dots) {
					echo str_replace('page-numbers dots', 'starter-theme-pagination__dots w-10 h-10 flex items-center justify-center text-muted/60', $page);
				} elseif ($is_current) {
					echo str_replace('page-numbers current', 'starter-theme-pagination__link starter-theme-pagination__link--current w-10 h-10 flex items-center justify-center rounded-2xl bg-primary text-secondary font-bold text-sm shadow-lg shadow-primary/20 scale-110 z-10', $page);
				} else {
					echo str_replace('page-numbers', 'starter-theme-pagination__link w-10 h-10 flex items-center justify-center text-base/80 hover:text-primary border border-transparent hover:border-primary/30 rounded-xl transition-all duration-300 text-sm font-medium', $page);
				}
			endforeach; ?>

			<?php if ($paged < $total) : ?>
				<a id="pagination-last"
					class="starter-theme-pagination__btn starter-theme-pagination__btn--last w-10 h-10 flex items-center justify-center text-primary border border-border-base/40 rounded-xl hover:bg-primary hover:text-white transition-all duration-300"
					href="<?php echo esc_url(get_pagenum_link($total)); ?>"
					title="<?php echo esc_attr__('หน้าสุดท้าย', 'starter-theme'); ?>">
					<span class="w-3 h-3 flex items-center justify-center">
						<i class="ri-arrow-right-s-line"></i>
					</span>
				</a>
			<?php endif; ?>
		</nav>
	</div>
<?php
}

/**
 * Render the Article Header Section (Single Post)
 * 
 * Supports:
 * - Breadcrumbs & Category link
 * - Dynamic Title
 * - Background Image (Optionally from Theme Options or Featured Image)
 *
 * @param array $args {
 *     @type int    $post_id  Post ID. Default: current post ID.
 *     @type string $bg_image Custom BG Image URL.
 *     @type bool   $has_bg   Whether to show BG image. Default: false.
 * }
 */
function starter_theme_article_header($args = [])
{
	$defaults = [
		'post_id'  => get_the_ID(),
		'bg_image' => starter_theme_get_option('article_header_bg_image'),
		'has_bg'   => starter_theme_get_option('article_header_show_bg', false),
	];
	$args = wp_parse_args($args, $defaults);

	$post_id = $args['post_id'];
	$title   = get_the_title($post_id);
	$cats    = get_the_category($post_id);
	$cat_obj = !empty($cats) ? $cats[0] : null;

	$bg_style = '';
	$header_class = 'bg-bg-base border-b border-border-base/50';
	$text_class = 'text-base';
	$muted_class = 'text-muted';

	if ($args['has_bg'] && !empty($args['bg_image'])) {
		$bg_style = 'background-image: url(' . esc_url($args['bg_image']) . '); background-size: cover; background-position: center;';
		$header_class = 'relative bg-primary overflow-hidden';
		$text_class = 'text-white relative z-10';
		$muted_class = 'text-white/70 relative z-10';
	}
?>
	<header id="starter-theme-article-header-<?php echo esc_attr($post_id); ?>" class="starter-theme-article-header transition-colors duration-500 <?php echo esc_attr($header_class); ?>" style="<?php echo esc_attr($bg_style); ?>">
		<?php if ($args['has_bg'] && !empty($args['bg_image'])) : ?>
			<div class="absolute inset-0 bg-black/40 z-0"></div>
		<?php endif; ?>

		<div class="starter-theme-container">
			<div class="mx-auto">
				<!-- Breadcrumbs & Category Badge -->
				<div class="flex flex-wrap items-center gap-4 mb-10 overflow-hidden">
					<nav class="starter-theme-breadcrumb text-sm uppercase tracking-widest <?php echo esc_attr($muted_class); ?> font-medium flex items-center gap-2">
						<a href="<?php echo esc_url(home_url()); ?>" class="hover:text-primary transition-colors"><?php echo esc_html__('หน้าหลัก', 'starter-theme'); ?></a>
						<span class="w-3 h-3 border-border-base opacity-40 flex items-center justify-center">
							<i class="ri-arrow-right-s-line"></i>
						</span>
						<?php if ($cat_obj) : ?>
							<a href="<?php echo esc_url(get_category_link($cat_obj->term_id)); ?>" class="<?php echo ($args['has_bg']) ? 'text-white' : 'text-primary'; ?> hover:opacity-80 transition-all font-display"><?php echo esc_html($cat_obj->name); ?></a>
						<?php endif; ?>
					</nav>
				</div>

				<!-- Title -->
				<h1 class="starter-theme-article-header__title font-display text-[clamp(1.5rem,8vw,3rem)] font-medium <?php echo esc_attr($text_class); ?> leading-tight mb-0 tracking-tight">
					<?php echo esc_html($title); ?>
				</h1>
			</div>
		</div>
	</header>
<?php
}

/**
 * Shortcode for Article Header
 */
function starter_theme_article_header_shortcode($atts)
{
	$atts = shortcode_atts([
		'has_bg' => 'no',
	], $atts);

	ob_start();
	starter_theme_article_header(['has_bg' => ($atts['has_bg'] === 'yes')]);
	return ob_get_clean();
}
add_shortcode('starter_theme_article_header', 'starter_theme_article_header_shortcode');

if (! function_exists('starter_theme_radio')) {
	function starter_theme_radio($args = [])
	{
		$defaults = [
			'id'            => wp_unique_id('starter-theme-radio-'),
			'name'          => 'starter_theme_radio',
			'value'         => '1',
			'label'         => '',
			'description'   => '',
			'state'         => 'default',
			'checked'       => false,
			'disabled'      => false,
			'show_label'    => true,
			'wrapper_class' => '',
			'input_class'   => '',
		];

		$radio = wp_parse_args($args, $defaults);

		$radio['id']            = sanitize_html_class((string) $radio['id']);
		$radio['name']          = sanitize_key((string) $radio['name']);
		$radio['value']         = sanitize_text_field((string) $radio['value']);
		$radio['label']         = sanitize_text_field((string) $radio['label']);
		$radio['description']   = sanitize_text_field((string) $radio['description']);
		$radio['state']         = in_array($radio['state'], ['default', 'hover', 'error', 'disabled'], true) ? $radio['state'] : 'default';
		$radio['checked']       = ! empty($radio['checked']);
		$radio['disabled']      = ! empty($radio['disabled']);
		$radio['show_label']    = ! empty($radio['show_label']);
		$radio['wrapper_class'] = sanitize_text_field((string) $radio['wrapper_class']);
		$radio['input_class']   = sanitize_text_field((string) $radio['input_class']);

		set_query_var('radio', $radio);
		get_template_part('template-parts/radio');
		set_query_var('radio', null);
	}
}

if (! function_exists('starter_theme_switch')) {
	function starter_theme_switch($args = [])
	{
		$defaults = [
			'id'            => wp_unique_id('starter-theme-switch-'),
			'name'          => 'starter_theme_switch',
			'value'         => '1',
			'label'         => '',
			'description'   => '',
			'state'         => 'default',
			'checked'       => false,
			'disabled'      => false,
			'show_label'    => true,
			'show_control'  => true,
			'size'          => 'desktop',
			'wrapper_class' => '',
			'input_class'   => '',
		];

		$switch = wp_parse_args($args, $defaults);

		$switch['id']            = sanitize_html_class((string) $switch['id']);
		$switch['name']          = sanitize_key((string) $switch['name']);
		$switch['value']         = sanitize_text_field((string) $switch['value']);
		$switch['label']         = sanitize_text_field((string) $switch['label']);
		$switch['description']   = sanitize_text_field((string) $switch['description']);
		$switch['state']         = in_array($switch['state'], ['default', 'hover', 'disabled'], true) ? $switch['state'] : 'default';
		$switch['checked']       = ! empty($switch['checked']);
		$switch['disabled']      = ! empty($switch['disabled']);
		$switch['show_label']    = ! empty($switch['show_label']);
		$switch['show_control']  = ! empty($switch['show_control']);
		$switch['size']          = in_array($switch['size'], ['desktop', 'mobile'], true) ? $switch['size'] : 'desktop';
		$switch['wrapper_class'] = sanitize_text_field((string) $switch['wrapper_class']);
		$switch['input_class']   = sanitize_text_field((string) $switch['input_class']);

		set_query_var('switch', $switch);
		get_template_part('template-parts/switch');
		set_query_var('switch', null);
	}
}

if (! function_exists('starter_theme_select')) {
	function starter_theme_select($args = [])
	{
		$defaults = [
			'id'                 => wp_unique_id('starter-theme-select-'),
			'name'               => 'starter_theme_select',
			'field_label'        => '',
			'placeholder'        => '',
			'search_placeholder' => '',
			'required'           => false,
			'disabled'           => false,
			'multiple'           => false,
			'open'               => false,
			'searchable'         => true,
			'options'            => [],
			'selected'           => [],
			'wrapper_class'      => '',
			'dropdown_class'     => '',
		];

		$select = wp_parse_args($args, $defaults);

		$select['id']                 = sanitize_html_class((string) $select['id']);
		$select['name']               = sanitize_key((string) $select['name']);
		$select['field_label']        = sanitize_text_field((string) $select['field_label']);
		$select['placeholder']        = sanitize_text_field((string) $select['placeholder']);
		$select['search_placeholder'] = sanitize_text_field((string) $select['search_placeholder']);
		$select['required']           = ! empty($select['required']);
		$select['disabled']           = ! empty($select['disabled']);
		$select['multiple']           = ! empty($select['multiple']);
		$select['open']               = ! empty($select['open']);
		$select['searchable']         = ! empty($select['searchable']);
		$select['wrapper_class']      = sanitize_text_field((string) $select['wrapper_class']);
		$select['dropdown_class']     = sanitize_text_field((string) $select['dropdown_class']);

		$select['options'] = array_values(array_filter(array_map(static function ($option) {
			if (! is_array($option)) {
				return null;
			}

			$value = isset($option['value']) ? sanitize_text_field((string) $option['value']) : '';
			$label = isset($option['label']) ? sanitize_text_field((string) $option['label']) : '';

			if ('' === $value && '' === $label) {
				return null;
			}

			return [
				'value' => $value,
				'label' => $label,
			];
		}, is_array($select['options']) ? $select['options'] : [])));

		$select['selected'] = array_values(array_map(static function ($value) {
			return sanitize_text_field((string) $value);
		}, is_array($select['selected']) ? $select['selected'] : []));

		set_query_var('select', $select);
		get_template_part('template-parts/select');
		set_query_var('select', null);
	}
}

