<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor KU Directions Widget
 */
class STARTER_Widget_starter_Directions extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 */
	public function get_name() {
		return 'starter-directions';
	}

	/**
	 * Get widget title
	 */
	public function get_title() {
		return esc_html__( 'KU Directions / Travel Info', 'starter-elementor-addon' );
	}

	/**
	 * Get widget icon
	 */
	public function get_icon() {
		return 'eicon-editor-list-ul';
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
		return [ 'directions', 'travel', 'transport', 'how to get here', 'clinic', 'list', 'icons' ];
	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'starter-starter-directions' ];
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {

		// =====================================================
		// CONTENT TAB - Section Header
		// =====================================================
		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Widget Header', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'     => esc_html__( 'Show Title', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'starter-elementor-addon' ),
				'label_off' => esc_html__( 'Hide', 'starter-elementor-addon' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'widget_title',
			[
				'label'       => esc_html__( 'Title text', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'การเดินทาง', 'starter-elementor-addon' ),
				'label_block' => true,
				'condition'   => [
					'show_title' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// CONTENT TAB - Directions Repeater List
		// =====================================================
		$this->start_controls_section(
			'section_list',
			[
				'label' => esc_html__( 'Directions List Items', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'label'       => esc_html__( 'Item Label (Reference Only)', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'รถยนต์ส่วนตัว', 'starter-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'item_icon',
			[
				'label'       => esc_html__( 'Item Icon', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-car',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'item_title',
			[
				'label'       => esc_html__( 'Heading Title', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'รถยนต์ส่วนตัว', 'starter-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'item_description',
			[
				'label'   => esc_html__( 'Detailed Description', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'มีที่จอดรถสะดวกสบายภายในคลินิก', 'starter-elementor-addon' ),
				'rows'    => 3,
			]
		);

		$this->add_control(
			'directions_list',
			[
				'label'       => esc_html__( 'List Items', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'tab_title'        => esc_html__( 'รถยนต์ส่วนตัว', 'starter-elementor-addon' ),
						'item_title'       => esc_html__( 'รถยนต์ส่วนตัว', 'starter-elementor-addon' ),
						'item_description' => esc_html__( 'มีที่จอดรถสะดวกสบายภายในคลินิก', 'starter-elementor-addon' ),
						'item_icon'        => [ 'value' => 'fas fa-car', 'library' => 'fa-solid' ],
					],
					[
						'tab_title'        => esc_html__( 'BTS', 'starter-elementor-addon' ),
						'item_title'       => esc_html__( 'BTS', 'starter-elementor-addon' ),
						'item_description' => esc_html__( "ลงสถานีทองหล่อ ทางออก 2\nเดินต่อประมาณ 5 นาที", 'starter-elementor-addon' ),
						'item_icon'        => [ 'value' => 'fas fa-subway', 'library' => 'fa-solid' ],
					],
					[
						'tab_title'        => esc_html__( 'รถประจำทาง', 'starter-elementor-addon' ),
						'item_title'       => esc_html__( 'รถประจำทาง', 'starter-elementor-addon' ),
						'item_description' => esc_html__( 'สาย 38, 48, 98, 501, 508', 'starter-elementor-addon' ),
						'item_icon'        => [ 'value' => 'fas fa-bus', 'library' => 'fa-solid' ],
					],
					[
						'tab_title'        => esc_html__( 'Taxi / Grab', 'starter-elementor-addon' ),
						'item_title'       => esc_html__( 'Taxi / Grab', 'starter-elementor-addon' ),
						'item_description' => esc_html__( 'พิมพ์ "คลินิกทันตกรรม Smile Dental Clinic"', 'starter-elementor-addon' ),
						'item_icon'        => [ 'value' => 'fas fa-taxi', 'library' => 'fa-solid' ],
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Card Container Settings
		// =====================================================
		$this->start_controls_section(
			'style_card',
			[
				'label' => esc_html__( 'Card Container Style', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg',
			[
				'label'     => esc_html__( 'Card Background Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFF8FA',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions__card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Inner Spacing Padding', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => '48',
					'right'     => '40',
					'bottom'   => '48',
					'left'     => '40',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_radius',
			[
				'label'      => esc_html__( 'Card Border Radius', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default'    => [ 'size' => 32, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions__card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .starter-starter-directions__card',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .starter-starter-directions__card',
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Header Title Settings
		// =====================================================
		$this->start_controls_section(
			'style_header',
			[
				'label'     => esc_html__( 'Widget Header Title Style', 'starter-elementor-addon' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#2c003e',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions__main-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .starter-starter-directions__main-title',
				'fields_options' => [
					'font_weight' => [ 'default' => '700' ],
					'font_size'   => [ 'default' => [ 'size' => 22, 'unit' => 'px' ] ],
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Spacing Below Title', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default'    => [ 'size' => 28, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions__main-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Circular Icon Settings
		// =====================================================
		$this->start_controls_section(
			'style_icons',
			[
				'label' => esc_html__( 'Circular Icon Style', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'var(--color-primary, #EC008C)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions__icon-wrap' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bg',
			[
				'label'     => esc_html__( 'Circular Background Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(236, 0, 140, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions__icon-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_circle_size',
			[
				'label'      => esc_html__( 'Circle Diameter', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 30, 'max' => 100 ],
				],
				'default'    => [ 'size' => 54, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions__icon-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_glyph_size',
			[
				'label'      => esc_html__( 'Icon Glyph Size', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 10, 'max' => 50 ],
				],
				'default'    => [ 'size' => 22, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions__icon-wrap i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .starter-starter-directions__icon-wrap svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_circle_radius',
			[
				'label'      => esc_html__( 'Circle Border Radius', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'size' => 50, 'unit' => '%' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions__icon-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_margin_right',
			[
				'label'      => esc_html__( 'Spacing to Content Right', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'size' => 20, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions__icon-wrap' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - List Typography & Colors
		// =====================================================
		$this->start_controls_section(
			'style_list_content',
			[
				'label' => esc_html__( 'List Content Styles', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Item Titles
		$this->add_control(
			'heading_item_title',
			[
				'label'     => esc_html__( 'Item Heading Title', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label'     => esc_html__( 'Heading Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions__item-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'item_title_typography',
				'selector' => '{{WRAPPER}} .starter-starter-directions__item-title',
				'fields_options' => [
					'font_weight' => [ 'default' => '700' ],
					'font_size'   => [ 'default' => [ 'size' => 16, 'unit' => 'px' ] ],
				],
			]
		);

		$this->add_responsive_control(
			'item_title_spacing',
			[
				'label'      => esc_html__( 'Title Bottom Margin', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default'    => [ 'size' => 4, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions__item-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Item Descriptions
		$this->add_control(
			'heading_item_desc',
			[
				'label'     => esc_html__( 'Item Detailed Description', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'item_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions__item-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'item_desc_typography',
				'selector' => '{{WRAPPER}} .starter-starter-directions__item-desc',
				'fields_options' => [
					'font_weight' => [ 'default' => '400' ],
					'font_size'   => [ 'default' => [ 'size' => 14, 'unit' => 'px' ] ],
					'line_height' => [ 'default' => [ 'size' => 1.5, 'unit' => 'em' ] ],
				],
			]
		);

		// Item Vertical Gap spacing (Rule 2.1 CSS Variables Spacing pattern)
		$this->add_responsive_control(
			'items_vertical_spacing',
			[
				'label'      => esc_html__( 'Spacing Between List Items', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 10, 'max' => 100 ],
				],
				'default'    => [ 'size' => 24, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions__list' => '--starter-starter-directions-gap: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Dividers Styling
		// =====================================================
		$this->start_controls_section(
			'style_dividers',
			[
				'label' => esc_html__( 'Divider Lines Style', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'show_dividers',
			[
				'label'     => esc_html__( 'Show Divider Lines', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'starter-elementor-addon' ),
				'label_off' => esc_html__( 'Hide', 'starter-elementor-addon' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(236, 0, 140, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions__list' => '--starter-starter-divider-color: {{VALUE}};',
				],
				'condition' => [
					'show_dividers' => 'yes',
				],
			]
		);

		$this->add_control(
			'divider_thickness',
			[
				'label'      => esc_html__( 'Divider Thickness', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 1, 'max' => 10 ],
				],
				'default'    => [ 'size' => 1, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions__list' => '--starter-starter-divider-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'show_dividers' => 'yes',
				],
			]
		);

		$this->add_control(
			'divider_style',
			[
				'label'   => esc_html__( 'Divider Style', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'solid'  => esc_html__( 'Solid', 'starter-elementor-addon' ),
					'dashed' => esc_html__( 'Dashed', 'starter-elementor-addon' ),
					'dotted' => esc_html__( 'Dotted', 'starter-elementor-addon' ),
				],
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions__list' => '--starter-starter-divider-style: {{VALUE}};',
				],
				'condition' => [
					'show_dividers' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on frontend
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['directions_list'] ) ) {
			return;
		}

		wp_enqueue_style( 'starter-starter-directions', STARTER_URL . 'widgets/starter-directions/starter-directions.css', [], STARTER_VERSION );

		$list_classes = [ 'starter-starter-directions__list' ];
		if ( $settings['show_dividers'] === 'yes' ) {
			$list_classes[] = 'starter-starter-directions__list--show-dividers';
		}
		?>
		<div class="starter-starter-directions">
			<div class="starter-starter-directions__card">
				
				<!-- Main Card Title -->
				<?php if ( $settings['show_title'] === 'yes' && ! empty( $settings['widget_title'] ) ) : ?>
					<h2 class="starter-starter-directions__main-title font-display"><?php echo esc_html( $settings['widget_title'] ); ?></h2>
				<?php endif; ?>

				<!-- Items Grid/List -->
				<div class="<?php echo esc_attr( implode( ' ', $list_classes ) ); ?>">
					<?php foreach ( $settings['directions_list'] as $item ) : 
						$title = isset( $item['item_title'] ) ? wp_kses_post( $item['item_title'] ) : '';
						$desc = isset( $item['item_description'] ) ? wp_kses_post( $item['item_description'] ) : '';
					?>
						<div class="starter-starter-directions__item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?> flex items-start">
							
							<!-- Left Circular Icon Wrap -->
							<?php if ( ! empty( $item['item_icon']['value'] ) ) : ?>
								<div class="starter-starter-directions__icon-wrap flex-shrink-0 flex items-center justify-center">
									<span class="starter-starter-directions__icon">
										<?php \Elementor\Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								</div>
							<?php endif; ?>

							<!-- Right Text Content -->
							<div class="starter-starter-directions__content">
								<?php if ( ! empty( $title ) ) : ?>
									<h4 class="starter-starter-directions__item-title font-display"><?php echo $title; ?></h4>
								<?php endif; ?>

								<?php if ( ! empty( $desc ) ) : ?>
									<p class="starter-starter-directions__item-desc"><?php echo nl2br( $desc ); ?></p>
								<?php endif; ?>
							</div>

						</div>
					<?php endforeach; ?>
				</div>

			</div>
		</div>
		<?php
	}

	/**
	 * Render widget output in the editor canvas (Dual-Rendering Synchronization Rule)
	 */
	protected function content_template() {
		?>
		<# if ( settings.directions_list && settings.directions_list.length ) { 
			var listClasses = 'starter-starter-directions__list';
			if ( settings.show_dividers === 'yes' ) {
				listClasses += ' starter-starter-directions__list--show-dividers';
			}
		#>
			<div class="starter-starter-directions">
				<div class="starter-starter-directions__card">
					
					<!-- Main Card Title -->
					<# if ( settings.show_title === 'yes' && settings.widget_title ) { #>
						<h2 class="starter-starter-directions__main-title font-display">{{{ settings.widget_title }}}</h2>
					<# } #>

					<!-- Items List -->
					<div class="{{ listClasses }}">
						<# _.each( settings.directions_list, function( item ) { 
							var iconHTML = '';
							if ( item.item_icon && item.item_icon.value ) {
								iconHTML = elementor.helpers.renderIcon( view, item.item_icon, { 'aria-hidden': true }, 'i', 'object' );
							}
							var descWithBr = item.item_description ? item.item_description.replace(/\n/g, '<br>') : '';
						#>
							<div class="starter-starter-directions__item elementor-repeater-item-{{ item._id }} flex items-start">
								
								<!-- Circular Icon Wrap -->
								<# if ( item.item_icon && item.item_icon.value ) { #>
									<div class="starter-starter-directions__icon-wrap flex-shrink-0 flex items-center justify-center">
										<span class="starter-starter-directions__icon">
											<# if ( iconHTML && iconHTML.rendered ) { #>
												{{{ iconHTML.value }}}
											<# } else { #>
												<i class="{{{ item.item_icon.value }}}" aria-hidden="true"></i>
											<# } #>
										</span>
									</div>
								<# } #>

								<!-- Text Content -->
								<div class="starter-starter-directions__content">
									<# if ( item.item_title ) { #>
										<h4 class="starter-starter-directions__item-title font-display">{{{ item.item_title }}}</h4>
									<# } #>

									<# if ( item.item_description ) { #>
										<p class="starter-starter-directions__item-desc">{{{ descWithBr }}}</p>
									<# } #>
								</div>

							</div>
						<# } ); #>
					</div>

				</div>
			</div>
		<# } #>
		<?php
	}
}

// Register stylesheet hooks
add_action( 'wp_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-directions/starter-directions.css';
	wp_register_style(
		'starter-starter-directions',
		STARTER_URL . 'widgets/starter-directions/starter-directions.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );

add_action( 'elementor/editor/after_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-directions/starter-directions.css';
	wp_enqueue_style(
		'starter-starter-directions',
		STARTER_URL . 'widgets/starter-directions/starter-directions.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );
