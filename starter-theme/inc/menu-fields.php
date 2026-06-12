<?php
/**
 * Custom Navigation Menu Fields (Mega Menu)
 *
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

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
