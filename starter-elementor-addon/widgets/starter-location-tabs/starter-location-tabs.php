<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor KU Location Tabs Widget
 */
class STARTER_Widget_starter_Location_Tabs extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 */
	public function get_name() {
		return 'starter-location-tabs';
	}

	/**
	 * Get widget title
	 */
	public function get_title() {
		return esc_html__( 'KU Location Tabs', 'starter-elementor-addon' );
	}

	/**
	 * Get widget icon
	 */
	public function get_icon() {
		return 'eicon-tabs';
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
		return [ 'location', 'branch', 'tabs', 'map', 'social', 'phone', 'contact', 'directions' ];
	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'starter-starter-location-tabs', 'starter-starter-directions-social' ];
	}

	/**
	 * Get script dependencies
	 */
	public function get_script_depends() {
		return [ 'starter-starter-location-tabs' ];
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {

		// =====================================================
		// CONTENT TAB - Branches Repeater Configuration
		// =====================================================
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Branches List', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'label'       => esc_html__( 'Tab Label (Branch Name)', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'สาขา สยามสแควร์', 'starter-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'branch_image',
			[
				'label'   => esc_html__( 'Branch Image', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'branch_subtitle',
			[
				'label'       => esc_html__( 'Branch Subtitle / Tag', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'เปิดให้บริการทุกวัน 10:00 - 20:00 น.', 'starter-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'branch_title',
			[
				'label'       => esc_html__( 'Branch Heading Title', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'คลินิกทันตกรรม คูสไมล์ สาขาสยาม', 'starter-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'branch_content',
			[
				'label'       => esc_html__( 'Branch Address Details', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::WYSIWYG,
				'default'     => esc_html__( '<p>สยามสแควร์ ซอย 5 แขวงปทุมวัน เขตปทุมวัน กรุงเทพมหานคร 10330 เดินทางสะดวกด้วยรถไฟฟ้า BTS สถานีสยาม ทางออก 4</p>', 'starter-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'branch_phone',
			[
				'label'       => esc_html__( 'Phone Number', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( '02-123-4567', 'starter-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'branch_map_link',
			[
				'label'       => esc_html__( 'Google Map Link', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://maps.google.com/...', 'starter-elementor-addon' ),
				'default'     => [
					'url'         => '',
					'is_external' => true,
				],
				'label_block' => true,
			]
		);

		// Nested Directions List Repeater
		$directions_repeater = new \Elementor\Repeater();

		$directions_repeater->add_control(
			'item_icon',
			[
				'label'   => esc_html__( 'Icon', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-car',
					'library' => 'fa-solid',
				],
			]
		);

		$directions_repeater->add_control(
			'item_title',
			[
				'label'   => esc_html__( 'Title', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'รถยนต์ส่วนตัว', 'starter-elementor-addon' ),
			]
		);

		$directions_repeater->add_control(
			'item_description',
			[
				'label' => esc_html__( 'Description', 'starter-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
				'rows'  => 2,
			]
		);

		$repeater->add_control(
			'directions_list',
			[
				'label'       => esc_html__( 'Directions List / วิธีการเดินทาง', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $directions_repeater->get_controls(),
				'title_field' => '{{{ item_title }}}',
				'default'     => [
					[
						'item_title'       => esc_html__( 'รถยนต์ส่วนตัว', 'starter-elementor-addon' ),
						'item_description' => esc_html__( 'มีที่จอดรถสะดวกสบายภายในคลินิก', 'starter-elementor-addon' ),
						'item_icon'        => [ 'value' => 'fas fa-car', 'library' => 'fa-solid' ],
					],
				],
			]
		);

		// Nested Social List Repeater
		$social_repeater = new \Elementor\Repeater();

		$social_repeater->add_control(
			'social_text',
			[
				'label'       => esc_html__( 'Social Label', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Line Us', 'starter-elementor-addon' ),
				'label_block' => true,
			]
		);

		$social_repeater->add_control(
			'social_icon',
			[
				'label'   => esc_html__( 'Social Icon', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fab fa-line',
					'library' => 'fa-brands',
				],
			]
		);

		$social_repeater->add_control(
			'social_link',
			[
				'label'       => esc_html__( 'Social Link URL', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://line.me/...', 'starter-elementor-addon' ),
				'default'     => [
					'url'         => '',
					'is_external' => true,
				],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'social_list',
			[
				'label'       => esc_html__( 'Social Media Links', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $social_repeater->get_controls(),
				'title_field' => '{{{ social_text }}}',
				'default'     => [
					[
						'social_text' => esc_html__( 'Line', 'starter-elementor-addon' ),
						'social_icon' => [ 'value' => 'fab fa-line', 'library' => 'fa-brands' ],
						'social_link' => [ 'url' => '#' ],
					],
					[
						'social_text' => esc_html__( 'Facebook', 'starter-elementor-addon' ),
						'social_icon' => [ 'value' => 'fab fa-facebook-f', 'library' => 'fa-brands' ],
						'social_link' => [ 'url' => '#' ],
					],
				],
			]
		);

		$this->add_control(
			'branches_list',
			[
				'label'       => esc_html__( 'Branches / Locations', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'tab_title'       => esc_html__( 'สาขา สยามสแควร์', 'starter-elementor-addon' ),
						'branch_title'     => esc_html__( 'คลินิกทันตกรรม คูสไมล์ สาขาสยามสแควร์', 'starter-elementor-addon' ),
						'branch_subtitle'  => esc_html__( 'เปิดให้บริการทุกวัน 10:00 - 20:00 น.', 'starter-elementor-addon' ),
						'branch_content'   => esc_html__( '<p>สยามสแควร์ ซอย 5 แขวงปทุมวัน เขตปทุมวัน กรุงเทพมหานคร 10330 เดินทางสะดวกด้วยรถไฟฟ้า BTS สถานีสยาม ทางออก 4</p>', 'starter-elementor-addon' ),
						'branch_phone'     => esc_html__( '02-123-4567', 'starter-elementor-addon' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->end_controls_section();

		// =====================================================
		// CONTENT TAB - Layout Options & Grid Alignments
		// =====================================================
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout Configurations', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout_type',
			[
				'label'   => esc_html__( 'Tab Navigation Layout', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__( 'Horizontal Tabs (Top)', 'starter-elementor-addon' ),
					'vertical'   => esc_html__( 'Vertical Sidebar Tabs (Left)', 'starter-elementor-addon' ),
				],
				'prefix_class' => 'starter-starter-location-tabs--layout-',
			]
		);

		$this->add_responsive_control(
			'tabs_alignment',
			[
				'label'     => esc_html__( 'Tab Buttons Alignment', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'starter-elementor-addon' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'starter-elementor-addon' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'starter-elementor-addon' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'condition' => [
					'layout_type' => 'horizontal',
				],
				'selectors' => [
					'{{WRAPPER}} .starter-starter-location-tabs__nav' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_direction',
			[
				'label'   => esc_html__( 'Content Columns Ordering', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'row-reverse',
				'options' => [
					'row-reverse' => esc_html__( 'Image Left, Text Right', 'starter-elementor-addon' ),
					'row'         => esc_html__( 'Text Left, Image Right', 'starter-elementor-addon' ),
				],
			]
		);

		$this->add_responsive_control(
			'tabs_gap',
			[
				'label'      => esc_html__( 'Spacing Between Tab Buttons', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 60 ],
				],
				'default'    => [ 'size' => 12, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-location-tabs__nav' => '--starter-starter-tabs-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Navigation Buttons Customization
		// =====================================================
		$this->start_controls_section(
			'style_tabs',
			[
				'label' => esc_html__( 'Tab Buttons Styling', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'tabs_typography',
				'selector' => '{{WRAPPER}} .starter-starter-location-tabs__tab',
			]
		);

		$this->start_controls_tabs( 'tabs_color_tabs' );

		// Normal State Control
		$this->start_controls_tab(
			'tabs_color_normal',
			[
				'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
			]
		);

		$this->add_control(
			'tab_color',
			[
				'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-location-tabs__tab:not(.starter-starter-location-tabs__tab--active)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_bg',
			[
				'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(241, 245, 249, 0.6)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-location-tabs__tab:not(.starter-starter-location-tabs__tab--active)' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-location-tabs__tab:not(.starter-starter-location-tabs__tab--active)' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Active & Hover State Control
		$this->start_controls_tab(
			'tabs_color_active',
			[
				'label' => esc_html__( 'Active / Hover', 'starter-elementor-addon' ),
			]
		);

		$this->add_control(
			'tab_color_active',
			[
				'label'     => esc_html__( 'Active Text Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-location-tabs__tab.starter-starter-location-tabs__tab--active' => 'color: {{VALUE}};',
					'{{WRAPPER}} .starter-starter-location-tabs__tab:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tab_bg_active',
			[
				'label'     => esc_html__( 'Active Background Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'var(--color-primary, #EC008C)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-location-tabs__tab.starter-starter-location-tabs__tab--active' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}} .starter-starter-location-tabs__tab:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'tab_padding',
			[
				'label'      => esc_html__( 'Button Padding', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '14',
					'right'     => '24',
					'bottom'   => '14',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-location-tabs__tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'tab_radius',
			[
				'label'      => esc_html__( 'Button Border Radius', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 60 ],
				],
				'default'    => [ 'size' => 16, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-location-tabs__tab' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_margin_bottom',
			[
				'label'      => esc_html__( 'Navigation Spacing Margins', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '0',
					'right'     => '0',
					'bottom'   => '40',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-location-tabs__nav-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Details Wrapper Card Styling
		// =====================================================
		$this->start_controls_section(
			'style_card',
			[
				'label' => esc_html__( 'Content Card Styling', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg',
			[
				'label'     => esc_html__( 'Card Background Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-location-tabs__pane' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Card Inner Padding', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => '32',
					'right'     => '32',
					'bottom'   => '32',
					'left'     => '32',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-location-tabs__pane' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .starter-starter-location-tabs__pane' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .starter-starter-location-tabs__pane',
				'fields_options' => [
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 20,
							'blur'       => 40,
							'spread'     => 0,
							'color'      => 'rgba(0, 0, 0, 0.03)',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Content Typography & Colors
		// =====================================================
		$this->start_controls_section(
			'style_content_texts',
			[
				'label' => esc_html__( 'Content Typography & Colors', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Tag / Subtitle
		$this->add_control(
			'heading_subtitle',
			[
				'label'     => esc_html__( 'Subtitle Settings', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'var(--color-primary, #EC008C)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-location-tabs__subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .starter-starter-location-tabs__subtitle',
			]
		);

		// Title
		$this->add_control(
			'heading_title',
			[
				'label'     => esc_html__( 'Title Settings', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-location-tabs__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .starter-starter-location-tabs__title',
			]
		);

		// Description Content
		$this->add_control(
			'heading_desc',
			[
				'label'     => esc_html__( 'Description Settings', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-location-tabs__desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .starter-starter-location-tabs__desc',
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Phone CTA & Social Media Customization
		// =====================================================
		$this->start_controls_section(
			'style_ctas',
			[
				'label' => esc_html__( 'Phone CTA & Social Customization', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_phone_style',
			[
				'label'     => esc_html__( 'Phone Callout Pill', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'phone_card_bg',
			[
				'label'     => esc_html__( 'Phone Background', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(236, 0, 140, 0.05)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-location-tabs__phone-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'phone_card_border',
			[
				'label'     => esc_html__( 'Phone Border Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(236, 0, 140, 0.1)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-location-tabs__phone-card' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'phone_text_color',
			[
				'label'     => esc_html__( 'Phone Number Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-location-tabs__phone-card span:last-child' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'phone_icon_bg',
			[
				'label'     => esc_html__( 'Phone Icon Background', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'var(--color-primary, #EC008C)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-location-tabs__phone-card > div:first-child' => 'background-color: {{VALUE}};',
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

		if ( empty( $settings['branches_list'] ) ) {
			return;
		}

		wp_enqueue_style( 'starter-starter-location-tabs', STARTER_URL . 'widgets/starter-location-tabs/starter-location-tabs.css', [], STARTER_VERSION );
		wp_enqueue_style( 'starter-starter-directions-social', STARTER_URL . 'widgets/starter-directions-social/starter-directions-social.css', [], STARTER_VERSION );
		wp_enqueue_script( 'starter-starter-location-tabs', STARTER_URL . 'widgets/starter-location-tabs/starter-location-tabs.js', [], STARTER_VERSION, true );

		$layout = ! empty( $settings['layout_type'] ) ? $settings['layout_type'] : 'horizontal';
		$direction = ! empty( $settings['content_direction'] ) ? $settings['content_direction'] : 'row-reverse';
		
		$wrapper_classes = [
			'starter-starter-location-tabs',
			'starter-starter-location-tabs--layout-' . esc_attr( $layout ),
		];
		?>
		<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>">
			
			<!-- Navigation Tabs Bar -->
			<div class="starter-starter-location-tabs__nav-wrap">
				<div class="starter-starter-location-tabs__nav flex flex-row flex-nowrap overflow-x-auto justify-start md:flex-wrap">
					<?php foreach ( $settings['branches_list'] as $index => $item ) : ?>
						<button type="button" class="starter-starter-location-tabs__tab <?php echo $index === 0 ? 'starter-starter-location-tabs__tab--active' : ''; ?>" data-target="branch-<?php echo esc_attr( $item['_id'] ); ?>">
							<span class="starter-starter-location-tabs__tab-text"><?php echo esc_html( $item['tab_title'] ); ?></span>
						</button>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Branch Detail Panels -->
			<div class="starter-starter-location-tabs__panes relative">
				<?php foreach ( $settings['branches_list'] as $index => $item ) : 
					$pane_id = 'branch-' . esc_attr( $item['_id'] );
					$pane_classes = [
						'starter-starter-location-tabs__pane',
						'elementor-repeater-item-' . esc_attr( $item['_id'] ),
					];
					if ( $index === 0 ) {
						$pane_classes[] = 'starter-starter-location-tabs__pane--active';
					}

					$direction_class = 'flex-col';
					if ( $direction === 'row' ) {
						$direction_class .= ' md:flex-row';
					} else {
						$direction_class .= ' md:flex-row-reverse';
					}
				?>
					<div id="<?php echo esc_attr( $pane_id ); ?>" class="<?php echo esc_attr( implode( ' ', $pane_classes ) ); ?>">
						<div class="starter-starter-location-tabs__grid flex <?php echo esc_attr( $direction_class ); ?> gap-8 items-stretch">
							
							<!-- Image Column -->
							<?php if ( ! empty( $item['branch_image']['url'] ) ) : ?>
								<div class="starter-starter-location-tabs__image-col flex-1 relative overflow-hidden rounded-3xl group shadow-md min-h-[300px] md:min-h-[400px]">
									<img src="<?php echo esc_url( $item['branch_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['tab_title'] ); ?>" class="starter-starter-location-tabs__image absolute inset-0 w-full h-full object-cover transition-all duration-700 group-hover:scale-[1.03]" />
									<div class="absolute inset-0 bg-gradient-to-t from-black/25 via-transparent to-transparent opacity-60 pointer-events-none"></div>
								</div>
							<?php endif; ?>

							<!-- Text Content Details Column -->
							<div class="starter-starter-location-tabs__content-col flex-1 flex flex-col justify-center space-y-6">
								
								<!-- Subtitle & Title -->
								<div class="space-y-2">
									<?php if ( ! empty( $item['branch_subtitle'] ) ) : ?>
										<span class="starter-starter-location-tabs__subtitle text-xs uppercase tracking-widest font-semibold text-primary block">
											<?php echo esc_html( $item['branch_subtitle'] ); ?>
										</span>
									<?php endif; ?>
									<?php if ( ! empty( $item['branch_title'] ) ) : ?>
										<h3 class="starter-starter-location-tabs__title text-2xl md:text-3xl font-bold font-display text-slate-800 leading-tight">
											<?php echo esc_html( $item['branch_title'] ); ?>
										</h3>
									<?php endif; ?>
								</div>

								<!-- Address / Details Editor -->
								<?php if ( ! empty( $item['branch_content'] ) ) : ?>
									<div class="starter-starter-location-tabs__desc text-slate-600 leading-relaxed text-sm md:text-base">
										<?php echo wp_kses_post( $item['branch_content'] ); ?>
									</div>
								<?php endif; ?>

								<!-- Directions List styled exactly as requested -->
								<?php if ( ! empty( $item['directions_list'] ) ) : ?>
									<div class="starter-starter-directions-social__list starter-starter-directions-social__list--show-dividers mt-4">
										<?php foreach ( $item['directions_list'] as $dir_item ) : 
											$dir_title = isset( $dir_item['item_title'] ) ? wp_kses_post( $dir_item['item_title'] ) : '';
											$dir_desc = isset( $dir_item['item_description'] ) ? wp_kses_post( $dir_item['item_description'] ) : '';
										?>
											<div class="starter-starter-directions-social__item flex items-start">
												<?php if ( ! empty( $dir_item['item_icon']['value'] ) ) : ?>
													<div class="starter-starter-directions-social__icon-wrap flex-shrink-0 flex items-center justify-center">
														<span class="starter-starter-directions-social__icon">
															<?php \Elementor\Icons_Manager::render_icon( $dir_item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
														</span>
													</div>
												<?php endif; ?>
												<div class="starter-starter-directions-social__content">
													<?php if ( ! empty( $dir_title ) ) : ?>
														<h4 class="starter-starter-directions-social__item-title font-display"><?php echo $dir_title; ?></h4>
													<?php endif; ?>
													<?php if ( ! empty( $dir_desc ) ) : ?>
														<p class="starter-starter-directions-social__item-desc"><?php echo nl2br( $dir_desc ); ?></p>
													<?php endif; ?>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>

								<!-- Phone Callout -->
								<?php if ( ! empty( $item['branch_phone'] ) ) : ?>
									<div class="starter-starter-location-tabs__phone-card-wrap">
										<a href="tel:<?php echo esc_attr( str_replace( ' ', '', $item['branch_phone'] ) ); ?>" class="starter-starter-location-tabs__phone-card inline-flex items-center gap-4 px-6 py-4 bg-primary/5 border border-primary/10 rounded-2xl hover:bg-primary/10 hover:border-primary/20 transition-all duration-300 group/phone">
											<div class="w-12 h-12 rounded-xl bg-primary text-white flex items-center justify-center shadow-md shadow-primary/25 transition-all duration-300 group-hover/phone:scale-110">
												<i class="ri-phone-fill text-xl"></i>
											</div>
											<div class="text-left">
												<span class="text-xs text-slate-400 block font-medium uppercase tracking-wider">โทรติดต่อสอบถาม</span>
												<span class="text-base md:text-lg font-bold text-slate-800 transition-colors group-hover/phone:text-primary"><?php echo esc_html( $item['branch_phone'] ); ?></span>
											</div>
										</a>
									</div>
								<?php endif; ?>

								<!-- Google Map Button (Goes directly to map URL) -->
								<?php if ( ! empty( $item['branch_map_link']['url'] ) ) : 
									$map_link_key = 'map_link_' . $item['_id'];
									$this->add_link_attributes( $map_link_key, $item['branch_map_link'] );
									$this->add_render_attribute( $map_link_key, 'class', 'starter-starter-location-tabs__map-btn inline-flex items-center justify-center gap-2 px-6 py-3 text-white bg-primary rounded-full hover:bg-primary-hover hover:-translate-y-0.5 transition-all duration-300 shadow-sm font-bold text-sm' );
								?>
									<div class="starter-starter-location-tabs__map-btn-wrap">
										<a <?php echo $this->get_render_attribute_string( $map_link_key ); ?>>
											<i class="ri-map-pin-line text-lg"></i>
											<span>ดูแผนที่ Google Maps</span>
										</a>
									</div>
								<?php endif; ?>

								<!-- Social Media Accounts Repeater -->
								<?php if ( ! empty( $item['social_list'] ) ) : ?>
									<div class="starter-starter-location-tabs__socials space-y-2 mt-4">
										<span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">ช่องทางติดต่อออนไลน์</span>
										<div class="flex flex-wrap gap-3 items-center">
											<?php foreach ( $item['social_list'] as $social ) : 
												$social_text = isset( $social['social_text'] ) ? esc_html( $social['social_text'] ) : '';
												$social_link_key = 'social_link_' . $item['_id'] . '_' . $social['_id'];
												
												if ( ! empty( $social['social_link']['url'] ) ) {
													$this->add_link_attributes( $social_link_key, $social['social_link'] );
												}
												
												// Round button constraint: rounded-full 100% round
												$this->add_render_attribute( $social_link_key, 'class', 'starter-starter-location-tabs__social-btn inline-flex items-center justify-center gap-2 px-5 py-2.5 text-white bg-primary rounded-full hover:scale-105 hover:-translate-y-0.5 transition-all duration-300 shadow-sm text-xs font-semibold' );
											?>
												<a <?php echo $this->get_render_attribute_string( $social_link_key ); ?>>
													<?php if ( ! empty( $social['social_icon']['value'] ) ) : ?>
														<span class="flex items-center justify-center">
															<?php \Elementor\Icons_Manager::render_icon( $social['social_icon'], [ 'aria-hidden' => 'true' ] ); ?>
														</span>
													<?php endif; ?>
													<?php if ( ! empty( $social_text ) ) : ?>
														<span class="starter-starter-location-tabs__social-text"><?php echo $social_text; ?></span>
													<?php endif; ?>
												</a>
											<?php endforeach; ?>
										</div>
									</div>
								<?php endif; ?>

							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

		</div>
		<?php
	}

	/**
	 * Render widget output in the editor canvas (Dual-Rendering Synchronization Rule)
	 */
	protected function content_template() {
		?>
		<# if ( settings.branches_list && settings.branches_list.length ) { 
			var layout = settings.layout_type ? settings.layout_type : 'horizontal';
			var direction = settings.content_direction ? settings.content_direction : 'row-reverse';
		#>
			<div class="starter-starter-location-tabs starter-starter-location-tabs--layout-{{ layout }}">
				
				<!-- Navigation Tabs Bar -->
				<div class="starter-starter-location-tabs__nav-wrap">
					<div class="starter-starter-location-tabs__nav flex flex-row flex-nowrap overflow-x-auto justify-start md:flex-wrap">
						<# _.each( settings.branches_list, function( item, index ) { #>
							<button type="button" class="starter-starter-location-tabs__tab {{ index === 0 ? 'starter-starter-location-tabs__tab--active' : '' }}" data-target="branch-{{ item._id }}">
								<span class="starter-starter-location-tabs__tab-text">{{{ item.tab_title }}}</span>
							</button>
						<# } ); #>
					</div>
				</div>

				<!-- Branch Detail Panels -->
				<div class="starter-starter-location-tabs__panes relative">
					<# _.each( settings.branches_list, function( item, index ) { 
						var paneId = 'branch-' + item._id;
						var paneClasses = 'starter-starter-location-tabs__pane elementor-repeater-item-' + item._id;
						if ( index === 0 ) {
							paneClasses += ' starter-starter-location-tabs__pane--active';
						}

						var directionClass = 'flex-col';
						if ( direction === 'row' ) {
							directionClass += ' md:flex-row';
						} else {
							directionClass += ' md:flex-row-reverse';
						}
					#>
						<div id="{{ paneId }}" class="{{ paneClasses }}">
							<div class="starter-starter-location-tabs__grid flex {{ directionClass }} gap-8 items-stretch">
								
								<!-- Image Column -->
								<# if ( item.branch_image && item.branch_image.url ) { #>
									<div class="starter-starter-location-tabs__image-col flex-1 relative overflow-hidden rounded-3xl group shadow-md min-h-[300px] md:min-h-[400px]">
										<img src="{{ item.branch_image.url }}" alt="{{ item.tab_title }}" class="starter-starter-location-tabs__image absolute inset-0 w-full h-full object-cover transition-all duration-700 group-hover:scale-[1.03]" />
										<div class="absolute inset-0 bg-gradient-to-t from-black/25 via-transparent to-transparent opacity-60 pointer-events-none"></div>
									</div>
								<# } #>

								<!-- Text Content Details Column -->
								<div class="starter-starter-location-tabs__content-col flex-1 flex flex-col justify-center space-y-6">
									
									<!-- Subtitle & Title -->
									<div class="space-y-2">
										<# if ( item.branch_subtitle ) { #>
											<span class="starter-starter-location-tabs__subtitle text-xs uppercase tracking-widest font-semibold text-primary block">
												{{{ item.branch_subtitle }}}
											</span>
										<# } #>
										<# if ( item.branch_title ) { #>
											<h3 class="starter-starter-location-tabs__title text-2xl md:text-3xl font-bold font-display text-slate-800 leading-tight">
												{{{ item.branch_title }}}
											</h3>
										<# } #>
									</div>

									<!-- Address / Details -->
									<# if ( item.branch_content ) { #>
										<div class="starter-starter-location-tabs__desc text-slate-600 leading-relaxed text-sm md:text-base">
											{{{ item.branch_content }}}
										</div>
									<# } #>

									<!-- Directions List -->
									<# if ( item.directions_list && item.directions_list.length ) { #>
										<div class="starter-starter-directions-social__list starter-starter-directions-social__list--show-dividers mt-4">
											<# _.each( item.directions_list, function( dirItem ) { 
												var dirIconHTML = '';
												if ( dirItem.item_icon && dirItem.item_icon.value ) {
													dirIconHTML = elementor.helpers.renderIcon( view, dirItem.item_icon, { 'aria-hidden': true }, 'i', 'object' );
												}
												var dirDescWithBr = dirItem.item_description ? dirItem.item_description.replace(/\n/g, '<br>') : '';
											#>
												<div class="starter-starter-directions-social__item flex items-start">
													<# if ( dirItem.item_icon && dirItem.item_icon.value ) { #>
														<div class="starter-starter-directions-social__icon-wrap flex-shrink-0 flex items-center justify-center">
															<span class="starter-starter-directions-social__icon">
																<# if ( dirIconHTML && dirIconHTML.rendered ) { #>
																	{{{ dirIconHTML.value }}}
																<# } else { #>
																	<i class="{{{ dirItem.item_icon.value }}}" aria-hidden="true"></i>
																<# } #>
															</span>
														</div>
													<# } #>
													<div class="starter-starter-directions-social__content">
														<# if ( dirItem.item_title ) { #>
															<h4 class="starter-starter-directions-social__item-title font-display">{{{ dirItem.item_title }}}</h4>
														<# } #>
														<# if ( dirItem.item_description ) { #>
															<p class="starter-starter-directions-social__item-desc">{{{ dirDescWithBr }}}</p>
														<# } #>
													</div>
												</div>
											<# } ); #>
										</div>
									<# } #>

									<!-- Phone Callout -->
									<# if ( item.branch_phone ) { 
										var phoneLink = item.branch_phone.replace(/\s+/g, '');
									#>
										<div class="starter-starter-location-tabs__phone-card-wrap">
											<a href="tel:{{ phoneLink }}" class="starter-starter-location-tabs__phone-card inline-flex items-center gap-4 px-6 py-4 bg-primary/5 border border-primary/10 rounded-2xl hover:bg-primary/10 hover:border-primary/20 transition-all duration-300 group/phone">
												<div class="w-12 h-12 rounded-xl bg-primary text-white flex items-center justify-center shadow-md shadow-primary/25 transition-all duration-300 group-hover/phone:scale-110">
													<i class="ri-phone-fill text-xl"></i>
												</div>
												<div class="text-left">
													<span class="text-xs text-slate-400 block font-medium uppercase tracking-wider">โทรติดต่อสอบถาม</span>
													<span class="text-base md:text-lg font-bold text-slate-800 transition-colors group-hover/phone:text-primary">{{{ item.branch_phone }}}</span>
												</div>
											</a>
										</div>
									<# } #>

									<!-- Google Map Button -->
									<# if ( item.branch_map_link && item.branch_map_link.url ) { 
										var mapUrl = item.branch_map_link.url;
										var mapTarget = item.branch_map_link.is_external ? ' target="_blank"' : '';
										var mapNofollow = item.branch_map_link.nofollow ? ' rel="nofollow"' : '';
									#>
										<div class="starter-starter-location-tabs__map-btn-wrap">
											<a href="{{ mapUrl }}" class="starter-starter-location-tabs__map-btn inline-flex items-center justify-center gap-2 px-6 py-3 text-white bg-primary rounded-full hover:bg-primary-hover hover:-translate-y-0.5 transition-all duration-300 shadow-sm font-bold text-sm"{{{ mapTarget }}}{{{ mapNofollow }}}>
												<i class="ri-map-pin-line text-lg"></i>
												<span>ดูแผนที่ Google Maps</span>
											</a>
										</div>
									<# } #>

									<!-- Social Media Accounts Repeater -->
									<# if ( item.social_list && item.social_list.length ) { #>
										<div class="starter-starter-location-tabs__socials space-y-2 mt-4">
											<span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">ช่องทางติดต่อออนไลน์</span>
											<div class="flex flex-wrap gap-3 items-center">
												<# _.each( item.social_list, function( social ) { 
													var socialIconHTML = '';
													if ( social.social_icon && social.social_icon.value ) {
														socialIconHTML = elementor.helpers.renderIcon( view, social.social_icon, { 'aria-hidden': true }, 'i', 'object' );
													}
													var socialUrl = social.social_link && social.social_link.url ? social.social_link.url : '#';
													var target = social.social_link && social.social_link.is_external ? ' target="_blank"' : '';
													var nofollow = social.social_link && social.social_link.nofollow ? ' rel="nofollow"' : '';
												#>
													<a href="{{ socialUrl }}" class="starter-starter-location-tabs__social-btn inline-flex items-center justify-center gap-2 px-5 py-2.5 text-white bg-primary rounded-full hover:scale-105 hover:-translate-y-0.5 transition-all duration-300 shadow-sm text-xs font-semibold"{{{ target }}}{{{ nofollow }}}>
														<# if ( social.social_icon && social.social_icon.value ) { #>
															<span class="flex items-center justify-center">
																<# if ( socialIconHTML && socialIconHTML.rendered ) { #>
																	{{{ socialIconHTML.value }}}
																<# } else { #>
																	<i class="{{{ social.social_icon.value }}}" aria-hidden="true"></i>
																<# } #>
															</span>
														<# } #>
														<# if ( social.social_text ) { #>
															<span class="starter-starter-location-tabs__social-text">{{{ social.social_text }}}</span>
														<# } #>
													</a>
												<# } ); #>
											</div>
										</div>
									<# } #>

								</div>
							</div>
						</div>
					<# } ); #>
				</div>

			</div>
		<# } #>
		<?php
	}
}

// Register scripts and stylesheet actions
add_action( 'wp_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-location-tabs/starter-location-tabs.css';
	wp_register_style(
		'starter-starter-location-tabs',
		STARTER_URL . 'widgets/starter-location-tabs/starter-location-tabs.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);

	$js_path = STARTER_PATH . 'widgets/starter-location-tabs/starter-location-tabs.js';
	wp_register_script(
		'starter-starter-location-tabs',
		STARTER_URL . 'widgets/starter-location-tabs/starter-location-tabs.js',
		[],
		file_exists( $js_path ) ? filemtime( $js_path ) : STARTER_VERSION,
		true
	);
} );

add_action( 'elementor/editor/after_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-location-tabs/starter-location-tabs.css';
	wp_enqueue_style(
		'starter-starter-location-tabs',
		STARTER_URL . 'widgets/starter-location-tabs/starter-location-tabs.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );
