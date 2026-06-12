<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class STARTER_Widget_starter_Services extends \Elementor\Widget_Base {

	public function get_name()       { return 'starter-services'; }
	public function get_title()      { return esc_html__( 'KU Services Grid', 'starter-elementor-addon' ); }
	public function get_icon()       { return 'eicon-posts-grid'; }
	public function get_categories() { return [ 'starter-elementor-addon' ]; }
	public function get_keywords()   { return [ 'services', 'grid', 'dental' ]; }

	public function get_style_depends()  { return [ 'starter-starter-services' ]; }
	public function get_script_depends() { return [ 'starter-starter-services' ]; }

	protected function register_controls() {

		$this->start_controls_section( 'section_header', [
			'label' => esc_html__( 'Header', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		$this->add_control( 'badge_text', [
			'label'   => esc_html__( 'Badge Text', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'บริการของเรา',
		] );
		$this->add_control( 'title', [
			'label'   => esc_html__( 'Title', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'บริการของเรา',
		] );
		$this->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'ครบครันด้วยบริการทันตกรรมมาตรฐานสากล รักษาทุกปัญหาช่องปาก',
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_services', [
			'label' => esc_html__( 'Services', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		$repeater = new \Elementor\Repeater();
		
		$repeater->start_controls_tabs( 'icon_tabs' );
		
		$repeater->start_controls_tab( 'tab_elementor_icon', [
			'label' => esc_html__( 'Icon', 'starter-elementor-addon' ),
		] );
		$repeater->add_control( 'selected_icon', [
			'label'            => esc_html__( 'Icon', 'starter-elementor-addon' ),
			'type'             => \Elementor\Controls_Manager::ICONS,
			'fa4compatibility' => 'icon',
			'default'          => [
				'value'   => 'ri-stethoscope-line',
				'library' => 'remixicon',
			],
		] );
		$repeater->end_controls_tab();
		
		$repeater->start_controls_tab( 'tab_image', [
			'label' => esc_html__( 'Image', 'starter-elementor-addon' ),
		] );
		$repeater->add_control( 'icon_image', [
			'label' => esc_html__( 'Icon Image', 'starter-elementor-addon' ),
			'type'  => \Elementor\Controls_Manager::MEDIA,
		] );
		$repeater->end_controls_tab();
		
		$repeater->end_controls_tabs();
		
		$repeater->add_control( 'name', [
			'label'   => esc_html__( 'Service Name', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'บริการ',
		] );
		$repeater->add_control( 'desc', [
			'label'   => esc_html__( 'Description', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'รายละเอียดบริการ',
		] );
		$this->add_control( 'services', [
			'label'       => esc_html__( 'Services', 'starter-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'selected_icon' => [ 'value' => 'ri-stethoscope-line', 'library' => 'remixicon' ],
					'name'          => 'ตรวจสุขภาพฟัน',
					'desc'          => 'ตรวจสุขภาพฟันและวางแผนการรักษา'
				],
				[
					'selected_icon' => [ 'value' => 'ri-medicine-bottle-line', 'library' => 'remixicon' ],
					'name'          => 'อุดฟัน',
					'desc'          => 'อุดฟันผุด้วยวัสดุสีเหมือนธรรมชาติ'
				],
				[
					'selected_icon' => [ 'value' => 'ri-focus-3-line', 'library' => 'remixicon' ],
					'name'          => 'จัดฟัน/เอลไลเนอร์',
					'desc'          => 'จัดฟันแบบใสไม่ต้องใช้เหล็กดั้งเดิม'
				],
				[
					'selected_icon' => [ 'value' => 'ri-plant-line', 'library' => 'remixicon' ],
					'name'          => 'รากฟันเทียม',
					'desc'          => 'รากฟันเทียมนำเข้ามาตรฐานสูง'
				],
				[
					'selected_icon' => [ 'value' => 'ri-sparkling-line', 'library' => 'remixicon' ],
					'name'          => 'ขัดฟัน',
					'desc'          => 'ขัดทำความสะอาดฟันอย่างมืออาชีพ'
				],
				[
					'selected_icon' => [ 'value' => 'ri-surgical-mask-line', 'library' => 'remixicon' ],
					'name'          => 'ผ่าฟันคุด',
					'desc'          => 'ผ่าฟันคุดโดยทีมแพทย์ผู้เชี่ยวชาญ'
				],
			],
			'title_field' => '{{{ name }}}',
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_cta', [
			'label' => esc_html__( 'CTA', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		$this->add_control( 'cta_text', [
			'label'   => esc_html__( 'Button Text', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'ดูบริการทั้งหมด',
		] );
		$this->add_control( 'cta_url', [
			'label'   => esc_html__( 'Button URL', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => '#' ],
		] );
		$this->add_control( 'cta_icon', [
			'label'            => esc_html__( 'Button Icon', 'starter-elementor-addon' ),
			'type'             => \Elementor\Controls_Manager::ICONS,
			'fa4compatibility' => 'icon',
			'default'          => [
				'value'   => 'ri-arrow-right-line',
				'library' => 'remixicon',
			],
		] );
		$this->add_control( 'cta_icon_align', [
			'label'   => esc_html__( 'Icon Position', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'right',
			'options' => [
				'left'  => esc_html__( 'Before Text', 'starter-elementor-addon' ),
				'right' => esc_html__( 'After Text', 'starter-elementor-addon' ),
			],
		] );
		$this->add_responsive_control( 'cta_icon_spacing', [
			'label'      => esc_html__( 'Icon Spacing', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 8, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-services__cta--align-right i, {{WRAPPER}} .starter-services__cta--align-right svg' => 'margin-left: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .starter-services__cta--align-left i, {{WRAPPER}} .starter-services__cta--align-left svg'   => 'margin-right: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'cta_icon_size', [
			'label'      => esc_html__( 'Icon Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 40 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-services__cta i' => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .starter-services__cta svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_layout', [
			'label' => esc_html__( 'Layout Settings', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'layout_type', [
			'label'   => esc_html__( 'Layout', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'grid',
			'options' => [
				'grid'   => esc_html__( 'Grid', 'starter-elementor-addon' ),
				'slider' => esc_html__( 'Swiper Slider', 'starter-elementor-addon' ),
			],
		] );

		$this->add_responsive_control( 'grid_columns', [
			'label'          => esc_html__( 'Grid Columns', 'starter-elementor-addon' ),
			'type'           => \Elementor\Controls_Manager::SELECT,
			'default'        => '3',
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
				'{{WRAPPER}} .starter-services__grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
			],
			'condition'      => [ 'layout_type' => 'grid' ],
		] );

		// Slides Per View selector
		$this->add_responsive_control( 'slides_per_view', [
			'label'   => esc_html__( 'Slides Per View', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => '6',
			'options' => [
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
			],
			'condition' => [ 'layout_type' => 'slider' ],
		] );

		$this->add_control( 'slider_space_between', [
			'label'      => esc_html__( 'Space Between Slides', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 20, 'unit' => 'px' ],
			'condition'  => [
				'layout_type' => 'slider',
			],
		] );

		$this->add_control( 'slider_navigation', [
			'label'        => esc_html__( 'Show Navigation', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'Hide', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'yes',
			'condition'    => [
				'layout_type' => 'slider',
			],
		] );

		$this->add_control( 'slider_pagination', [
			'label'        => esc_html__( 'Show Pagination', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'Hide', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'yes',
			'condition'    => [
				'layout_type' => 'slider',
			],
		] );

		$this->add_control( 'slider_autoplay', [
			'label'        => esc_html__( 'Autoplay', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'No', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'no',
			'condition'    => [
				'layout_type' => 'slider',
			],
		] );

		$this->add_control( 'slider_autoplay_speed', [
			'label'     => esc_html__( 'Autoplay Speed (ms)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 5000,
			'min'       => 1000,
			'step'      => 500,
			'condition' => [
				'layout_type'     => 'slider',
				'slider_autoplay' => 'yes',
			],
		] );

		$this->add_control( 'slider_loop', [
			'label'        => esc_html__( 'Infinite Loop', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'No', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'yes',
			'condition'    => [
				'layout_type' => 'slider',
			],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'style_section', [
			'label' => esc_html__( 'Section', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->add_responsive_control( 'section_padding', [
			'label'      => esc_html__( 'Section Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem', '%' ],
			'selectors'  => [ '{{WRAPPER}} .starter-services' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->add_control( 'section_bg', [
			'label'     => esc_html__( 'Section Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-services' => 'background-color: {{VALUE}};' ],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_header', [
			'label' => esc_html__( 'Header', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->add_control( 'badge_color', [
			'label'     => esc_html__( 'Badge Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-services__badge' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'badge_typography',
			'label'    => esc_html__( 'Badge Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-services__badge',
		] );
		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Title Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#111827',
			'selectors' => [ '{{WRAPPER}} .starter-services__title' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'label'    => esc_html__( 'Title Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-services__title',
		] );
		$this->add_control( 'description_color', [
			'label'     => esc_html__( 'Description Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#9ca3af',
			'selectors' => [ '{{WRAPPER}} .starter-services__desc' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'description_typography',
			'label'    => esc_html__( 'Description Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-services__desc',
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_card', [
			'label' => esc_html__( 'Service Card', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->add_control( 'card_bg', [
			'label'     => esc_html__( 'Card Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-services__card' => 'background-color: {{VALUE}};' ],
		] );
		$this->add_control( 'card_border_heading', [
			'label'     => esc_html__( 'Border Settings', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );
		$this->add_control( 'card_border_type', [
			'label'     => esc_html__( 'Border Type', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'none',
			'options'   => [
				'none'   => esc_html__( 'None', 'starter-elementor-addon' ),
				'solid'  => esc_html__( 'Solid', 'starter-elementor-addon' ),
				'double' => esc_html__( 'Double', 'starter-elementor-addon' ),
				'dotted' => esc_html__( 'Dotted', 'starter-elementor-addon' ),
				'dashed' => esc_html__( 'Dashed', 'starter-elementor-addon' ),
			],
			'selectors' => [ '{{WRAPPER}} .starter-services__card' => 'border-style: {{VALUE}};' ],
		] );
		$this->add_responsive_control( 'card_border_width', [
			'label'      => esc_html__( 'Border Width', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px' ],
			'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true ],
			'selectors'  => [ '{{WRAPPER}} .starter-services__card' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->add_control( 'card_border_color', [
			'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-services__card' => 'border-color: {{VALUE}};' ],
		] );
		$this->add_responsive_control( 'card_padding', [
			'label'      => esc_html__( 'Card Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-services__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			'separator'  => 'before',
		] );
		$this->add_responsive_control( 'card_margin', [
			'label'      => esc_html__( 'Card Margin', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-services__card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'card_border_radius', [
			'label'      => esc_html__( 'Card Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-services__card' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'card_box_shadow',
			'label'    => esc_html__( 'Card Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-services__card',
		] );
		$this->add_responsive_control( 'card_gap', [
			'label'      => esc_html__( 'Card Gap', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 48 ] ],
			'default'    => [ 'size' => 20, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-services__grid' => '--starter-srv-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'card_hover_heading', [
			'label'     => esc_html__( 'Hover Settings', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'card_bg_hover', [
			'label'     => esc_html__( 'Card Background (Hover)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-services__card:hover' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'card_border_color_hover', [
			'label'     => esc_html__( 'Border Color (Hover)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-services__card:hover' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'card_box_shadow_hover',
			'label'    => esc_html__( 'Card Box Shadow (Hover)', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-services__card:hover',
		] );

		$this->add_responsive_control( 'card_transform_hover', [
			'label'      => esc_html__( 'Transform Y (Hover)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => -20, 'max' => 20 ] ],
			'default'    => [ 'size' => 0, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-services__card:hover' => 'transform: translateY({{SIZE}}{{UNIT}});' ],
		] );

		$this->add_responsive_control( 'card_transition_duration', [
			'label'      => esc_html__( 'Transition Duration', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 's', 'ms' ],
			'range'      => [ 's' => [ 'min' => 0, 'max' => 2, 'step' => 0.1 ], 'ms' => [ 'min' => 0, 'max' => 2000, 'step' => 50 ] ],
			'default'    => [ 'size' => 0.3, 'unit' => 's' ],
			'selectors'  => [ '{{WRAPPER}} .starter-services__card' => 'transition-duration: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'card_border_effect_heading', [
			'label'     => esc_html__( 'Gradient Border Effect', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'card_border_effect_color', [
			'label'     => esc_html__( 'Border Gradient Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--color-primary, #EC008C)',
			'selectors' => [ '{{WRAPPER}} .starter-services__card::before' => 'background: linear-gradient(135deg, {{VALUE}}, transparent);' ],
		] );

		$this->add_responsive_control( 'card_border_effect_radius', [
			'label'      => esc_html__( 'Border Effect Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-services__card::before' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_border_effect_width', [
			'label'      => esc_html__( 'Border Effect Width', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 5 ] ],
			'default'    => [ 'size' => 1.5, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-services__card::before' => 'padding: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_border_effect_opacity', [
			'label'      => esc_html__( 'Border Effect Opacity (Normal)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '' ],
			'range'      => [ '' => [ 'min' => 0, 'max' => 1, 'step' => 0.1 ] ],
			'default'    => [ 'size' => 0, 'unit' => '' ],
			'selectors'  => [ '{{WRAPPER}} .starter-services__card::before' => 'opacity: {{SIZE}};' ],
		] );

		$this->add_responsive_control( 'card_border_effect_opacity_hover', [
			'label'      => esc_html__( 'Border Effect Opacity (Hover)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '' ],
			'range'      => [ '' => [ 'min' => 0, 'max' => 1, 'step' => 0.1 ] ],
			'default'    => [ 'size' => 1, 'unit' => '' ],
			'selectors'  => [ '{{WRAPPER}} .starter-services__card:hover::before' => 'opacity: {{SIZE}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'style_icon', [
			'label' => esc_html__( 'Service Icon', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->add_control( 'icon_bg', [
			'label'     => esc_html__( 'Icon Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(236,0,140,0.1)',
			'selectors' => [ '{{WRAPPER}} .starter-services__card-icon' => 'background-color: {{VALUE}};' ],
		] );
		$this->add_control( 'icon_color', [
			'label'     => esc_html__( 'Icon Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-services__card-icon' => 'color: {{VALUE}};' ],
		] );
		$this->add_responsive_control( 'icon_size', [
			'label'      => esc_html__( 'Icon Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 12, 'max' => 48 ] ],
			'default'    => [ 'size' => 26, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-services__card-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .starter-services__card-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .starter-services__card-icon img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'icon_container_size', [
			'label'      => esc_html__( 'Icon Container Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 32, 'max' => 80 ] ],
			'default'    => [ 'size' => 56, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-services__card-icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'icon_radius', [
			'label'      => esc_html__( 'Icon Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-services__card-icon' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_control( 'icon_image_object_fit', [
			'label'     => esc_html__( 'Icon Image Fit', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'contain',
			'options'   => [
				'contain' => esc_html__( 'Contain', 'starter-elementor-addon' ),
				'cover'   => esc_html__( 'Cover', 'starter-elementor-addon' ),
				'fill'    => esc_html__( 'Fill', 'starter-elementor-addon' ),
			],
			'selectors' => [ '{{WRAPPER}} .starter-services__card-icon img' => '--icon-img-fit: {{VALUE}};' ],
		] );
		$this->add_responsive_control( 'icon_image_object_position_x', [
			'label'      => esc_html__( 'Icon Image Focus X (%)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-services__card-icon img' => '--icon-img-x: {{SIZE}}%;' ],
		] );
		$this->add_responsive_control( 'icon_image_object_position_y', [
			'label'      => esc_html__( 'Icon Image Focus Y (%)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-services__card-icon img' => '--icon-img-y: {{SIZE}}%;' ],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_service_text', [
			'label' => esc_html__( 'Service Text', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->add_control( 'service_name_color', [
			'label'     => esc_html__( 'Service Name Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#1f2937',
			'selectors' => [ '{{WRAPPER}} .starter-services__card-title' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'service_name_typography',
			'label'    => esc_html__( 'Service Name Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-services__card-title',
		] );
		$this->add_control( 'service_desc_color', [
			'label'     => esc_html__( 'Service Description Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#6b7280',
			'selectors' => [ '{{WRAPPER}} .starter-services__card-desc' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'service_desc_typography',
			'label'    => esc_html__( 'Service Description Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-services__card-desc',
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_cta', [
			'label' => esc_html__( 'CTA Button', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'cta_align', [
			'label'   => esc_html__( 'Alignment', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'left' => [
					'title' => esc_html__( 'Left', 'starter-elementor-addon' ),
					'icon'  => 'eicon-text-align-left',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'starter-elementor-addon' ),
					'icon'  => 'eicon-text-align-center',
				],
				'right' => [
					'title' => esc_html__( 'Right', 'starter-elementor-addon' ),
					'icon'  => 'eicon-text-align-right',
				],
			],
			'default'   => 'center',
			'selectors' => [
				'{{WRAPPER}} .starter-services__cta-wrap' => 'text-align: {{VALUE}};',
			],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'cta_typography',
			'label'    => esc_html__( 'Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-services__cta',
		] );

		$this->start_controls_tabs( 'cta_tabs' );

		$this->start_controls_tab( 'cta_tab_normal', [
			'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'cta_text_color', [
			'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [
				'{{WRAPPER}} .starter-services__cta' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'cta_bg', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'transparent',
			'selectors' => [
				'{{WRAPPER}} .starter-services__cta' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
			'name'     => 'cta_border',
			'label'    => esc_html__( 'Border', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-services__cta',
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'cta_box_shadow',
			'label'    => esc_html__( 'Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-services__cta',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'cta_tab_hover', [
			'label' => esc_html__( 'Hover', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'cta_hover_text_color', [
			'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [
				'{{WRAPPER}} .starter-services__cta:hover' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'cta_hover_bg', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [
				'{{WRAPPER}} .starter-services__cta:hover' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'cta_hover_border_color', [
			'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .starter-services__cta:hover' => 'border-color: {{VALUE}};',
			],
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'cta_hover_box_shadow',
			'label'    => esc_html__( 'Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-services__cta:hover',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control( 'cta_radius', [
			'label'      => esc_html__( 'Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 12, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-services__cta' => 'border-radius: {{SIZE}}{{UNIT}};',
			],
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'cta_padding', [
			'label'      => esc_html__( 'Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'top' => '12', 'right' => '32', 'bottom' => '12', 'left' => '32', 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-services__cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'style_slider', [
			'label'     => esc_html__( 'Slider Settings', 'starter-elementor-addon' ),
			'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [
				'layout_type' => 'slider',
			],
		] );

		$this->add_control( 'slider_nav_heading', [
			'label'     => esc_html__( 'Navigation Buttons', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'slider_nav_size', [
			'label'      => esc_html__( 'Button Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 24, 'max' => 80 ] ],
			'default'    => [ 'size' => 48, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-services__navigation button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'slider_nav_icon_size', [
			'label'      => esc_html__( 'Icon Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 40 ] ],
			'default'    => [ 'size' => 20, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-services__navigation button' => 'font-size: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'slider_nav_gap', [
			'label'      => esc_html__( 'Gap Between Buttons', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-services__navigation' => 'gap: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->start_controls_tabs( 'slider_nav_tabs' );

		$this->start_controls_tab( 'slider_nav_tab_normal', [
			'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'slider_nav_color', [
			'label'     => esc_html__( 'Arrow Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#6b7280',
			'selectors' => [ '{{WRAPPER}} .starter-services__navigation button' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'slider_nav_bg', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-services__navigation button' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
			'name'     => 'slider_nav_border',
			'label'    => esc_html__( 'Border', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-services__navigation button',
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'slider_nav_box_shadow',
			'label'    => esc_html__( 'Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-services__navigation button',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'slider_nav_tab_hover', [
			'label' => esc_html__( 'Hover', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'slider_nav_hover_color', [
			'label'     => esc_html__( 'Arrow Hover Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-services__navigation button:hover' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'slider_nav_hover_bg', [
			'label'     => esc_html__( 'Background Hover Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-services__navigation button:hover' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'slider_nav_hover_border_color', [
			'label'     => esc_html__( 'Border Hover Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-services__navigation button:hover' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'slider_nav_hover_box_shadow',
			'label'    => esc_html__( 'Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-services__navigation button:hover',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control( 'slider_nav_radius', [
			'label'      => esc_html__( 'Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-services__navigation button' => 'border-radius: {{SIZE}}{{UNIT}};',
			],
			'separator' => 'before',
		] );

		$this->add_control( 'slider_pag_heading', [
			'label'     => esc_html__( 'Pagination Dots', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'slider_pag_color', [
			'label'     => esc_html__( 'Dot Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-services__pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'slider_pag_active_color', [
			'label'     => esc_html__( 'Active Dot Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-services__pagination .swiper-pagination-bullet-active' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$cta_url = ! empty( $settings['cta_url']['url'] ) ? esc_url( $settings['cta_url']['url'] ) : '#';
		$is_slider = ( ! empty( $settings['layout_type'] ) && $settings['layout_type'] === 'slider' );
		?>
		<section class="starter-services">
			<div class="s-container mx-auto px-5 md:px-8 lg:px-10">

				<div class="starter-services__header">
					<?php if ( ! empty( $settings['badge_text'] ) ) : ?>
					<p class="starter-services__badge">
						<?php echo esc_html( $settings['badge_text'] ); ?>
					</p>
					<?php endif; ?>
					<h2 class="starter-services__title">
						<?php echo esc_html( $settings['title'] ); ?>
					</h2>
					<?php if ( ! empty( $settings['description'] ) ) : ?>
					<p class="starter-services__desc">
						<?php echo esc_html( $settings['description'] ); ?>
					</p>
					<?php endif; ?>
				</div>

				<?php if ( ! empty( $settings['services'] ) ) : ?>
					<?php if ( $is_slider ) :
						$swiper_config = [
							'slidesPerView' => ! empty( $settings['slides_per_view_mobile'] ) ? intval( $settings['slides_per_view_mobile'] ) : 2,
							'spaceBetween'  => isset( $settings['slider_space_between']['size'] ) && $settings['slider_space_between']['size'] !== '' ? intval( $settings['slider_space_between']['size'] ) : 20,
							'loop'          => ( $settings['slider_loop'] === 'yes' ),
							'autoplay'      => ( $settings['slider_autoplay'] === 'yes' ) ? [
								'delay'                => ! empty( $settings['slider_autoplay_speed'] ) ? intval( $settings['slider_autoplay_speed'] ) : 5000,
								'disableOnInteraction' => false,
							] : false,
							'breakpoints' => [
								768 => [
									'slidesPerView' => ! empty( $settings['slides_per_view_tablet'] ) ? intval( $settings['slides_per_view_tablet'] ) : 3,
								],
								1024 => [
									'slidesPerView' => ! empty( $settings['slides_per_view'] ) ? intval( $settings['slides_per_view'] ) : 6,
								]
							]
						];
						?>
						<div class="starter-services__swiper swiper" data-swiper-config="<?php echo esc_attr( wp_json_encode( $swiper_config ) ); ?>">
							<div class="swiper-wrapper">
								<?php foreach ( $settings['services'] as $service ) : ?>
								<div class="swiper-slide">
									<div class="starter-services__card">
										<div class="starter-services__card-icon">
											<?php 
											if ( ! empty( $service['selected_icon']['value'] ) ) {
												\Elementor\Icons_Manager::render_icon( $service['selected_icon'], [ 'aria-hidden' => 'true' ], 'i' );
											} elseif ( ! empty( $service['icon_image']['url'] ) ) {
												$img_url = esc_url( $service['icon_image']['url'] );
												echo '<img src="' . $img_url . '" alt="' . esc_attr( $service['name'] ?? '' ) . '">';
											}
											?>
										</div>
										<h3 class="starter-services__card-title">
											<?php echo esc_html( $service['name'] ?? '' ); ?>
										</h3>
										<?php if ( ! empty( $service['desc'] ) ) : ?>
										<p class="starter-services__card-desc">
											<?php echo esc_html( $service['desc'] ); ?>
										</p>
										<?php endif; ?>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
							
							<?php if ( $settings['slider_pagination'] === 'yes' ) : ?>
							<div class="starter-services__pagination swiper-pagination"></div>
							<?php endif; ?>
							
							<?php if ( $settings['slider_navigation'] === 'yes' ) : ?>
							<div class="starter-services__navigation">
								<button class="starter-services__button-prev swiper-button-prev">
									<i class="ri-arrow-left-line"></i>
								</button>
								<button class="starter-services__button-next swiper-button-next">
									<i class="ri-arrow-right-line"></i>
								</button>
							</div>
							<?php endif; ?>
						</div>
					<?php else : 
						$cols_desktop = ! empty( $settings['grid_columns'] ) ? $settings['grid_columns'] : '3';
						$cols_tablet  = ! empty( $settings['grid_columns_tablet'] ) ? $settings['grid_columns_tablet'] : '2';
						$cols_mobile  = ! empty( $settings['grid_columns_mobile'] ) ? $settings['grid_columns_mobile'] : '1';
						
						$grid_style = sprintf(
							'--cols-desktop: %1$s; --cols-tablet: %2$s; --cols-mobile: %3$s;',
							esc_attr( $cols_desktop ),
							esc_attr( $cols_tablet ),
							esc_attr( $cols_mobile )
						);
					?>
						<div class="starter-services__grid">
							<?php foreach ( $settings['services'] as $service ) : ?>
							<div class="starter-services__card">
								<div class="starter-services__card-icon">
									<?php 
									if ( ! empty( $service['selected_icon']['value'] ) ) {
										\Elementor\Icons_Manager::render_icon( $service['selected_icon'], [ 'aria-hidden' => 'true' ], 'i' );
									} elseif ( ! empty( $service['icon_image']['url'] ) ) {
										$img_url = esc_url( $service['icon_image']['url'] );
										echo '<img src="' . $img_url . '" alt="' . esc_attr( $service['name'] ?? '' ) . '">';
									}
									?>
								</div>
								<h3 class="starter-services__card-title">
									<?php echo esc_html( $service['name'] ?? '' ); ?>
								</h3>
								<?php if ( ! empty( $service['desc'] ) ) : ?>
								<p class="starter-services__card-desc">
									<?php echo esc_html( $service['desc'] ); ?>
								</p>
								<?php endif; ?>
							</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( ! empty( $settings['cta_text'] ) ) : 
					$cta_align_class = 'starter-services__cta--align-' . ( $settings['cta_icon_align'] ?? 'right' );
					?>
				<div class="starter-services__cta-wrap">
					<a href="<?php echo $cta_url; ?>" class="starter-services__cta <?php echo esc_attr( $cta_align_class ); ?>">
						<?php if ( $settings['cta_icon_align'] === 'left' && ! empty( $settings['cta_icon']['value'] ) ) : ?>
							<?php \Elementor\Icons_Manager::render_icon( $settings['cta_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						<?php endif; ?>

						<span><?php echo esc_html( $settings['cta_text'] ); ?></span>

						<?php if ( $settings['cta_icon_align'] === 'right' && ! empty( $settings['cta_icon']['value'] ) ) : ?>
							<?php \Elementor\Icons_Manager::render_icon( $settings['cta_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						<?php endif; ?>
					</a>
				</div>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<section class="starter-services">
			<div class="s-container mx-auto px-5 md:px-8 lg:px-10">

				<div class="starter-services__header">
					<# if ( settings.badge_text ) { #>
					<p class="starter-services__badge">
						{{{ settings.badge_text }}}
					</p>
					<# } #>
					<h2 class="starter-services__title">
						{{{ settings.title }}}
					</h2>
					<# if ( settings.description ) { #>
					<p class="starter-services__desc">
						{{{ settings.description }}}
					</p>
					<# } #>
				</div>

				<# if ( settings.services && settings.services.length ) { #>
					<# if ( settings.layout_type === 'slider' ) { 
						var swiperConfig = {
							slidesPerView: parseInt( settings.slides_per_view_mobile ) || 2,
							spaceBetween: parseInt( settings.slider_space_between && settings.slider_space_between.size ) || 20,
							loop: settings.slider_loop === 'yes',
							autoplay: settings.slider_autoplay === 'yes' ? {
								delay: parseInt( settings.slider_autoplay_speed ) || 5000,
								disableOnInteraction: false
							} : false,
							breakpoints: {
								768: {
									slidesPerView: parseInt( settings.slides_per_view_tablet ) || 3
								},
								1024: {
									slidesPerView: parseInt( settings.slides_per_view ) || 6
								}
							}
						};
						var configStr = JSON.stringify( swiperConfig );
					#>
						<div class="starter-services__swiper swiper" data-swiper-config='{{{ configStr }}}'>
							<div class="swiper-wrapper">
								<# _.each( settings.services, function( service ) {
									var iconHtml = '';

									if ( service.selected_icon && service.selected_icon.value ) {
										var iconRender = elementor.helpers.renderIcon( view, service.selected_icon, { 'aria-hidden': true }, 'i', 'object' );
										if ( iconRender && iconRender.value ) {
											iconHtml = iconRender.value;
										}
									} else if ( service.icon_image && service.icon_image.url ) {
										var imgUrl = service.icon_image.url;
										iconHtml = '<img src="' + imgUrl + '" alt="' + ( service.name || '' ) + '">';
									}
								#>
								<div class="swiper-slide">
									<div class="starter-services__card">
										<div class="starter-services__card-icon">
											{{{ iconHtml }}}
										</div>
										<h3 class="starter-services__card-title">
											{{{ service.name }}}
										</h3>
										<# if ( service.desc ) { #>
										<p class="starter-services__card-desc">
											{{{ service.desc }}}
										</p>
										<# } #>
									</div>
								</div>
								<# } ); #>
							</div>
							
							<# if ( settings.slider_pagination === 'yes' ) { #>
							<div class="starter-services__pagination swiper-pagination"></div>
							<# } #>
							
							<# if ( settings.slider_navigation === 'yes' ) { #>
							<div class="starter-services__navigation">
								<button class="starter-services__button-prev swiper-button-prev">
									<i class="ri-arrow-left-line"></i>
								</button>
								<button class="starter-services__button-next swiper-button-next">
									<i class="ri-arrow-right-line"></i>
								</button>
							</div>
							<# } #>
						</div>
					<# } else { 
						var colsDesktop = settings.grid_columns || '3';
						var colsTablet  = settings.grid_columns_tablet || '2';
						var colsMobile  = settings.grid_columns_mobile || '1';
						
						var gridStyle = '--cols-desktop: ' + colsDesktop + '; --cols-tablet: ' + colsTablet + '; --cols-mobile: ' + colsMobile + ';';
					#>
						<div class="starter-services__grid">
							<# _.each( settings.services, function( service ) {
								var iconHtml = '';

								if ( service.selected_icon && service.selected_icon.value ) {
									var iconRender = elementor.helpers.renderIcon( view, service.selected_icon, { 'aria-hidden': true }, 'i', 'object' );
									if ( iconRender && iconRender.value ) {
										iconHtml = iconRender.value;
									}
								} else if ( service.icon_image && service.icon_image.url ) {
									var imgUrl = service.icon_image.url;
									iconHtml = '<img src="' + imgUrl + '" alt="' + ( service.name || '' ) + '">';
								}
							#>
							<div class="starter-services__card">
								<div class="starter-services__card-icon">
									{{{ iconHtml }}}
								</div>
								<h3 class="starter-services__card-title">
									{{{ service.name }}}
								</h3>
								<# if ( service.desc ) { #>
								<p class="starter-services__card-desc">
									{{{ service.desc }}}
								</p>
								<# } #>
							</div>
							<# } ); #>
						</div>
					<# } #>
				<# } #>

				<# if ( settings.cta_text ) { 
					var ctaAlignClass = 'starter-services__cta--align-' + ( settings.cta_icon_align || 'right' );
					var ctaIconHtml = '';
					if ( settings.cta_icon && settings.cta_icon.value ) {
						ctaIconHtml = elementor.helpers.renderIcon( view, settings.cta_icon, { 'aria-hidden': true }, 'i', 'object' );
					}
				#>
				<div class="starter-services__cta-wrap">
					<a href="{{ settings.cta_url.url || '#' }}" class="starter-services__cta {{{ ctaAlignClass }}}">
						<# if ( settings.cta_icon_align === 'left' && ctaIconHtml && ctaIconHtml.value ) { #>
							{{{ ctaIconHtml.value }}}
						<# } #>

						<span>{{{ settings.cta_text }}}</span>

						<# if ( settings.cta_icon_align === 'right' && ctaIconHtml && ctaIconHtml.value ) { #>
							{{{ ctaIconHtml.value }}}
						<# } #>
					</a>
				</div>
				<# } #>

			</div>
		</section>
		<?php
	}
}

add_action( 'wp_enqueue_scripts', function() {
	wp_register_style(  'starter-starter-services', STARTER_URL . 'widgets/starter-services/starter-services.css', [], time() );
	wp_register_script( 'starter-starter-services', STARTER_URL . 'widgets/starter-services/starter-services.js',  [ 'jquery', 'swiper' ], time(), true );
} );
add_action( 'elementor/editor/after_enqueue_scripts', function() {
	wp_enqueue_style( 'starter-starter-services', STARTER_URL . 'widgets/starter-services/starter-services.css', [], time() );
} );
