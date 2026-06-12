<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor KU Gallery Widget (PhotoSwipe v5)
 */
class STARTER_Widget_starter_Gallery extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 */
	public function get_name() {
		return 'starter-gallery';
	}

	/**
	 * Get widget title
	 */
	public function get_title() {
		return esc_html__( 'KU PhotoSwipe Gallery', 'starter-elementor-addon' );
	}

	/**
	 * Get widget icon
	 */
	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	/**
	 * Get widget categories
	 */
	public function get_categories() {
		return [ 'starter-elementor-addon' ];
	}

	/**
	 * Get widget keywords
	 */
	public function get_keywords() {
		return [ 'gallery', 'photoswipe', 'lightbox', 'popup', 'images', 'grid' ];
	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'photoswipe-css', 'starter-starter-gallery' ];
	}

	/**
	 * Get script dependencies
	 */
	public function get_script_depends() {
		return [ 'photoswipe-core', 'photoswipe-lightbox', 'starter-starter-gallery' ];
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {

		// =====================================================
		// CONTENT TAB - Gallery Images
		// =====================================================
		$this->start_controls_section(
			'section_images',
			[
				'label' => esc_html__( 'Gallery Images', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'gallery',
			[
				'label'   => esc_html__( 'Add Images', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// CONTENT TAB - Layout Settings
		// =====================================================
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout & Grid Options', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Grid Columns', 'starter-elementor-addon' ),
				'type'           => \Elementor\Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'selectors'      => [
					'{{WRAPPER}} .starter-starter-gallery-grid' => '--starter-starter-gallery-cols: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_gap',
			[
				'label'      => esc_html__( 'Column Gap', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default'    => [ 'size' => 20, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-gallery-grid' => '--starter-starter-gallery-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'      => esc_html__( 'Row Gap', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default'    => [ 'size' => 20, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-gallery-grid' => '--starter-starter-gallery-row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_ratio',
			[
				'label'   => esc_html__( 'Image Aspect Ratio', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'ratio-16-10',
				'options' => [
					'ratio-16-9'  => '16:9',
					'ratio-16-10' => '16:10',
					'ratio-4-3'   => '4:3',
					'ratio-square'=> '1:1 (Square)',
					'ratio-auto'  => 'Original Auto',
				],
			]
		);

		$this->add_control(
			'show_caption',
			[
				'label'     => esc_html__( 'Hover Overlay Caption', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'starter-elementor-addon' ),
				'label_off' => esc_html__( 'Hide', 'starter-elementor-addon' ),
				'default'   => 'yes',
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Grid Cards & Overlays
		// =====================================================
		$this->start_controls_section(
			'style_images',
			[
				'label' => esc_html__( 'Images & Hover Effects', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 50 ],
				],
				'default'    => [ 'size' => 20, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-gallery__card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'overlay_bg',
			[
				'label'     => esc_html__( 'Hover Overlay Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(236, 0, 140, 0.75)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-gallery__overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_icon_color',
			[
				'label'     => esc_html__( 'Hover Zoom Icon Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-gallery__zoom-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Caption Text
		// =====================================================
		$this->start_controls_section(
			'style_caption',
			[
				'label'     => esc_html__( 'Caption Typography', 'starter-elementor-addon' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_caption' => 'yes',
				],
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label'     => esc_html__( 'Caption Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-gallery__caption' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'caption_typography',
				'selector' => '{{WRAPPER}} .starter-starter-gallery__caption',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['gallery'] ) ) {
			return;
		}

		$columns_desktop = ! empty( $settings['columns'] ) ? $settings['columns'] : 4;
		$columns_tablet  = ! empty( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 2;
		$columns_mobile  = ! empty( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 1;

		$style_attr = sprintf(
			'style="--starter-starter-gallery-cols: %d; --starter-starter-gallery-cols-tablet: %d; --starter-starter-gallery-cols-mobile: %d;"',
			intval( $columns_desktop ),
			intval( $columns_tablet ),
			intval( $columns_mobile )
		);

		// Unique ID for the PhotoSwipe gallery container
		$gallery_id = 'starter-starter-gallery-' . $this->get_id();
		?>
		<div class="starter-starter-gallery-wrapper">
			
			<div id="<?php echo esc_attr( $gallery_id ); ?>" class="starter-starter-gallery-grid <?php echo esc_attr( $settings['image_ratio'] ); ?>" <?php echo $style_attr; ?>>
				
				<?php foreach ( $settings['gallery'] as $image ) : 
					if ( empty( $image['url'] ) ) {
						continue;
					}

					$img_url = esc_url( $image['url'] );
					$img_id  = isset( $image['id'] ) ? intval( $image['id'] ) : 0;
					
					// Dynamically retrieve Caption or Alt from Media attachment!
					$caption = '';
					if ( $img_id ) {
						$caption = wp_get_attachment_caption( $img_id );
						if ( empty( $caption ) ) {
							$caption = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
						}
					}
					
					// Detect physical dimensions of the image to satisfy PhotoSwipe's dynamic size requirements!
					$width = 1200;
					$height = 800;
					if ( $img_id ) {
						$meta = wp_get_attachment_metadata( $img_id );
						if ( ! empty( $meta['width'] ) && ! empty( $meta['height'] ) ) {
							$width = intval( $meta['width'] );
							$height = intval( $meta['height'] );
						}
					}
					?>
					<div class="starter-starter-gallery__card-wrap">
						<a href="<?php echo $img_url; ?>" 
						   data-pswp-width="<?php echo $width; ?>" 
						   data-pswp-height="<?php echo $height; ?>" 
						   target="_blank" 
						   class="starter-starter-gallery__card group block w-full h-full relative overflow-hidden">
							
							<!-- Featured Thumbnail -->
							<img src="<?php echo $img_url; ?>" alt="<?php echo esc_attr( $caption ); ?>" class="starter-starter-gallery__image w-full !h-full object-cover transition-transform duration-700 group-hover:scale-105">

							<!-- Premium Blur Accent Hover Overlay -->
							<div class="starter-starter-gallery__overlay absolute inset-0 opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center p-4 transition-all duration-400">
								
								<!-- Zoom Icon -->
								<div class="starter-starter-gallery__zoom-icon mb-3 transform translate-y-3 group-hover:translate-y-0 transition-transform duration-400">
									<i class="fas fa-search-plus fa-2x"></i>
								</div>

								<!-- Caption -->
								<?php if ( $settings['show_caption'] === 'yes' && ! empty( $caption ) ) : ?>
									<p class="starter-starter-gallery__caption text-center font-display text-sm font-medium mb-0 transform translate-y-3 group-hover:translate-y-0 transition-transform duration-500">
										<?php echo esc_html( $caption ); ?>
									</p>
								<?php endif; ?>

							</div>

						</a>
					</div>
				<?php endforeach; ?>

			</div>

			<!-- Dynamic local PhotoSwipe Lightbox initialization script -->
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					// Check if PhotoSwipeLightbox is loaded
					if (typeof PhotoSwipeLightbox !== 'undefined') {
						const lightbox = new PhotoSwipeLightbox({
							gallery: '#<?php echo esc_attr( $gallery_id ); ?>',
							children: 'a',
							pswpModule: PhotoSwipe
						});
						lightbox.init();
					}
				});
			</script>

		</div>
		<?php
	}

	/**
	 * Mock Elementor Editor preview (Synchronization Rule)
	 */
	protected function content_template() {
		?>
		<div class="starter-starter-gallery-wrapper">
			<#
			var columns = settings.columns ? settings.columns : 4;
			var colsTablet = settings.columns_tablet ? settings.columns_tablet : 2;
			var colsMobile = settings.columns_mobile ? settings.columns_mobile : 1;
			#>
			<div class="starter-starter-gallery-grid {{ settings.image_ratio }}" style="--starter-starter-gallery-cols: {{ columns }}; --starter-starter-gallery-cols-tablet: {{ colsTablet }}; --starter-starter-gallery-cols-mobile: {{ colsMobile }};">
				<# if ( settings.gallery && settings.gallery.length ) { #>
					<# _.each( settings.gallery, function( image ) { 
						if ( ! image.url ) { return; }
					#>
						<div class="starter-starter-gallery__card-wrap">
							<div class="starter-starter-gallery__card group block w-full h-full relative overflow-hidden">
								
								<img src="{{ image.url }}" class="starter-starter-gallery__image w-full !h-full object-cover transition-transform duration-700 group-hover:scale-105">

								<div class="starter-starter-gallery__overlay absolute inset-0 opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center p-4 transition-all duration-400">
									
									<div class="starter-starter-gallery__zoom-icon mb-3 transform translate-y-3 group-hover:translate-y-0 transition-transform duration-400">
										<i class="fas fa-search-plus fa-2x"></i>
									</div>

								</div>

							</div>
						</div>
					<# } ); #>
				<# } #>
			</div>
		</div>
		<?php
	}
}

add_action( 'wp_enqueue_scripts', function() {
	// Register local PhotoSwipe css asset enqueued globally or on-demand
	wp_register_style(
		'photoswipe-css',
		STARTER_URL . 'assets/css/photoswipe.css',
		[],
		STARTER_VERSION
	);

	// Register local PhotoSwipe core js asset
	wp_register_script(
		'photoswipe-core',
		STARTER_URL . 'assets/js/photoswipe.umd.min.js',
		[],
		STARTER_VERSION,
		true
	);

	// Register local PhotoSwipe Lightbox js asset
	wp_register_script(
		'photoswipe-lightbox',
		STARTER_URL . 'assets/js/photoswipe-lightbox.umd.min.js',
		[ 'photoswipe-core' ],
		STARTER_VERSION,
		true
	);

	// Register local Gallery CSS
	wp_register_style(
		'starter-starter-gallery',
		STARTER_URL . 'widgets/starter-gallery/starter-gallery.css',
		[ 'photoswipe-css' ],
		STARTER_VERSION
	);
} );
