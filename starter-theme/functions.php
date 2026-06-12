<?php

/**
 * starter_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package starter_theme
 */

if (! defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function starter_theme_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on starter_theme, use a find and replace
		* to change 'starter-theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('starter-theme', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1'               => esc_html__('Primary', 'starter-theme'),
			'footer-main'          => esc_html__('Footer Main', 'starter-theme'),
			'footer-bottom'        => esc_html__('Footer Bottom', 'starter-theme'),
			'footer-community-nav' => esc_html__('Footer Community Nav (Quick Links)', 'starter-theme'),
			'footer-about'         => esc_html__('Footer About Links', 'starter-theme'),
			'starter-footer-nav'      => esc_html__('Starter Footer Nav', 'starter-theme'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'starter_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);


	if (get_option('elementor_disable_typography_schemes') !== 'yes') {
		update_option('elementor_disable_typography_schemes', 'yes');
	}
}
add_action('after_setup_theme', 'starter_theme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function starter_theme_content_width()
{
	$GLOBALS['content_width'] = apply_filters('starter_theme_content_width', 640);
}
add_action('after_setup_theme', 'starter_theme_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function starter_theme_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'starter-theme'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'starter-theme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'starter_theme_widgets_init');



/**
 * Load Footer Menu Walker.
 */
require get_template_directory() . '/inc/footer-menu-walker.php';
require get_template_directory() . '/inc/footer-bottom-toggle-walker.php';
require get_template_directory() . '/inc/footer-simple-walker.php';
require get_template_directory() . '/inc/header-menu-walker.php';
require get_template_directory() . '/inc/mobile-menu-walker.php';



/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue-scripts.php';
require get_template_directory() . '/inc/pagination.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Admin Columns modifications.
 */
require get_template_directory() . '/inc/admin-columns.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load Auto Loader.
 */
require get_template_directory() . '/inc/autoloader.php';

/**
 * Load Theme Options.
 */
require get_template_directory() . '/inc/theme-options.php';
require get_template_directory() . '/inc/cttm-functions.php';
require get_template_directory() . '/inc/post-types.php';

/**
 * Load Elementor Widgets.
 */
require get_template_directory() . '/inc/elementor-widgets.php';

add_filter('wp_setup_nav_menu_item', function ($menu_item) {
	$menu_item->starter_theme_mega_type = get_post_meta($menu_item->ID, '_starter_theme_mega_type', true);
	$menu_item->starter_theme_mega_image_id = get_post_meta($menu_item->ID, '_starter_theme_mega_image_id', true);
	$menu_item->starter_theme_mega_image = get_post_meta($menu_item->ID, '_starter_theme_mega_image', true);
	return $menu_item;
});

add_action('wp_nav_menu_item_custom_fields', function ($item_id, $item, $depth, $args) {
	$type = get_post_meta($item_id, '_starter_theme_mega_type', true);
	$image_id = get_post_meta($item_id, '_starter_theme_mega_image_id', true);
	$image_url = '';
	if (is_numeric($image_id) && (int) $image_id > 0) {
		$image_url = wp_get_attachment_image_url((int) $image_id, 'medium');
		if (!is_string($image_url)) {
			$image_url = '';
		}
	}

	if (!is_string($type)) {
		$type = '';
	}
	$image_id = is_numeric($image_id) ? (int) $image_id : 0;

	$type_options = [
		'' => 'None',
		'mega-1' => 'Mega 1',
		'mega-2' => 'Mega 2',
		'mega-3' => 'Mega 3 (Grid with Images)',
	];
?>
	<p class="field-starter-theme-mega-type description description-wide">
		<label for="edit-menu-item-starter-theme-mega-type-<?php echo esc_attr($item_id); ?>">
			<?php echo esc_html__('Mega Menu Type', 'starter-theme'); ?><br>
			<select id="edit-menu-item-starter-theme-mega-type-<?php echo esc_attr($item_id); ?>" class="widefat" name="menu-item-starter-theme-mega-type[<?php echo esc_attr($item_id); ?>]">
				<?php foreach ($type_options as $value => $label) : ?>
					<option value="<?php echo esc_attr($value); ?>" <?php selected($type, $value); ?>><?php echo esc_html($label); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
	</p>
	<div class="field-starter-theme-mega-image description description-wide">
		<label>
			<?php echo esc_html__('Mega Image (Mega 1)', 'starter-theme'); ?><br>
		</label>
		<input type="hidden" class="starter-theme-mega-image-id" name="menu-item-starter-theme-mega-image-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($image_id); ?>">
		<div class="starter-theme-mega-image-preview" style="margin-top:8px;">
			<?php if ($image_url) : ?>
				<img src="<?php echo esc_url($image_url); ?>" alt="" style="max-width:240px;height:auto;display:block;border:1px solid #dcdcde;border-radius:8px;" />
			<?php endif; ?>
		</div>
		<p style="margin-top:8px;">
			<button type="button" class="button starter-theme-mega-image-select"><?php echo esc_html__('Select Image', 'starter-theme'); ?></button>
			<button type="button" class="button starter-theme-mega-image-remove" <?php echo $image_url ? '' : 'style="display:none;"'; ?>><?php echo esc_html__('Remove', 'starter-theme'); ?></button>
		</p>
	</div>
<?php
}, 10, 4);

add_action('wp_update_nav_menu_item', function ($menu_id, $menu_item_db_id, $args) {
	if (isset($_POST['menu-item-starter-theme-mega-type'][$menu_item_db_id])) {
		$type = sanitize_text_field(wp_unslash($_POST['menu-item-starter-theme-mega-type'][$menu_item_db_id]));
		$allowed = ['', 'mega-1', 'mega-2', 'mega-3'];
		if (!in_array($type, $allowed, true)) {
			$type = '';
		}
		update_post_meta($menu_item_db_id, '_starter_theme_mega_type', $type);
	}

	if (isset($_POST['menu-item-starter-theme-mega-image-id'][$menu_item_db_id])) {
		$image_id = (int) sanitize_text_field(wp_unslash($_POST['menu-item-starter-theme-mega-image-id'][$menu_item_db_id]));
		if ($image_id < 0) {
			$image_id = 0;
		}
		update_post_meta($menu_item_db_id, '_starter_theme_mega_image_id', $image_id);
	}
}, 10, 3);

add_action('admin_enqueue_scripts', function ($hook) {
	if ($hook !== 'nav-menus.php') {
		return;
	}

	wp_enqueue_media();
	$starter_theme_mega_menu_js = <<<'JS'
(function($){
	function bindTAEMegaImage($container){
		var frame;
		$container.on('click', '.starter-theme-mega-image-select', function(e){
			e.preventDefault();
			var $wrap = $(this).closest('.field-starter-theme-mega-image');
			var $id = $wrap.find('.starter-theme-mega-image-id');
			var $preview = $wrap.find('.starter-theme-mega-image-preview');
			var $remove = $wrap.find('.starter-theme-mega-image-remove');
			frame = wp.media({ title: 'Select Image', button: { text: 'Use this image' }, multiple: false });
			frame.on('select', function(){
				var attachment = frame.state().get('selection').first().toJSON();
				$id.val(attachment.id || 0);
				var url = (attachment.sizes && attachment.sizes.medium && attachment.sizes.medium.url) ? attachment.sizes.medium.url : attachment.url;
				$preview.html('<img src="' + url + '" alt="" style="max-width:240px;height:auto;display:block;border:1px solid #dcdcde;border-radius:8px;" />' );
				$remove.show();
			});
			frame.open();
		});

		$container.on('click', '.starter-theme-mega-image-remove', function(e){
			e.preventDefault();
			var $wrap = $(this).closest('.field-starter-theme-mega-image');
			$wrap.find('.starter-theme-mega-image-id').val('0');
			$wrap.find('.starter-theme-mega-image-preview').empty();
			$(this).hide();
		});
	}

	$(document).ready(function(){
		bindTAEMegaImage($(document));
	});
})(jQuery);
JS;

	wp_add_inline_script('jquery-core', $starter_theme_mega_menu_js);
});
