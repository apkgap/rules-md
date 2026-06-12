<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class STARTER_Widget_starter_Why_Us extends \Elementor\Widget_Base {

	public function get_name()       { return 'starter-why-us'; }
	public function get_title()      { return esc_html__( 'KU Why Choose Us', 'starter-elementor-addon' ); }
	public function get_icon()       { return 'eicon-star'; }
	public function get_categories() { return [ 'starter-elementor-addon' ]; }
	public function get_keywords()   { return [ 'why us', 'features', 'dental' ]; }

	public function get_style_depends()  { return [ 'starter-starter-why-us' ]; }
	public function get_script_depends() { return [ 'starter-starter-why-us' ]; }

	protected function register_controls() {

		$this->start_controls_section( 'section_layout', [
			'label' => esc_html__( 'Layout', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		$this->add_control( 'image_position', [
			'label'   => esc_html__( 'Image Position', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'right',
			'options' => [
				'left'  => esc_html__( 'Left', 'starter-elementor-addon' ),
				'right' => esc_html__( 'Right', 'starter-elementor-addon' ),
			],
		] );
		$this->add_responsive_control( 'row_direction', [
			'label'          => esc_html__( 'Row Direction', 'starter-elementor-addon' ),
			'type'           => \Elementor\Controls_Manager::SELECT,
			'default'        => 'column',
			'tablet_default' => 'column',
			'mobile_default' => 'column',
			'options'        => [
				'row'            => esc_html__( 'Row (Horizontal)', 'starter-elementor-addon' ),
				'row-reverse'    => esc_html__( 'Row Reverse', 'starter-elementor-addon' ),
				'column'         => esc_html__( 'Column (Vertical)', 'starter-elementor-addon' ),
				'column-reverse' => esc_html__( 'Column Reverse', 'starter-elementor-addon' ),
			],
			'selectors'      => [
				'{{WRAPPER}} .starter-why-us__row' => '--row-direction: {{VALUE}};',
			],
		] );
		$this->add_responsive_control( 'row_gap', [
			'label'          => esc_html__( 'Row Gap (Image ↔ Content)', 'starter-elementor-addon' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px', 'rem' ],
			'range'          => [ 'px' => [ 'min' => 0, 'max' => 120 ], 'rem' => [ 'min' => 0, 'max' => 8 ] ],
			'default'        => [ 'size' => 3, 'unit' => 'rem' ],
			'tablet_default' => [ 'size' => 3, 'unit' => 'rem' ],
			'mobile_default' => [ 'size' => 3, 'unit' => 'rem' ],
			'selectors'      => [
				'{{WRAPPER}} .starter-why-us__row' => '--row-gap: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_header', [
			'label' => esc_html__( 'Header', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		$this->add_control( 'badge_text', [
			'label'   => esc_html__( 'Badge Text', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'ทำไมต้องเลือกเรา',
		] );
		$this->add_control( 'title_line1', [
			'label'   => esc_html__( 'Title Line 1', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'ทำไมต้องเลือก',
		] );
		$this->add_control( 'title_line2', [
			'label'   => esc_html__( 'Title Line 2', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'คลินิกทันตกรรมของเรา',
		] );
		$this->add_control( 'content', [
			'label'   => esc_html__( 'Content', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::WYSIWYG,
			'default' => 'คลินิกทันตกรรมของเราพร้อมดูแลคุณด้วยมาตรฐานระดับสูง ใส่ใจทุกรายละเอียด และให้ความสบายใจในทุกขั้นตอนการรักษา',
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_features', [
			'label' => esc_html__( 'Features', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		$repeater = new \Elementor\Repeater();
		$repeater->add_control( 'selected_icon', [
			'label'            => esc_html__( 'Icon', 'starter-elementor-addon' ),
			'type'             => \Elementor\Controls_Manager::ICONS,
			'fa4compatibility' => 'icon',
			'default'          => [
				'value'   => 'ri-shield-check-line',
				'library' => 'remixicon',
			],
		] );
		$repeater->add_control( 'icon_class', [
			'label'   => esc_html__( 'Remix Icon Class (Fallback)', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '',
		] );
		$repeater->add_control( 'title', [
			'label'   => esc_html__( 'Feature Title', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'คุณสมบัติ',
		] );
		$repeater->add_control( 'desc', [
			'label'   => esc_html__( 'Description', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'รายละเอียดคุณสมบัติ',
		] );
		$this->add_control( 'features', [
			'label'       => esc_html__( 'Features', 'starter-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'selected_icon' => [ 'value' => 'ri-shield-check-line', 'library' => 'remixicon' ],
					'title'          => 'ทีมแพทย์ผู้เชี่ยวชาญ',
					'desc'           => 'แพทย์ทุกท่านจบจากสถาบันชั้นนำ มีใบอนุญาตถูกต้องตามกฎหมาย'
				],
				[
					'selected_icon' => [ 'value' => 'ri-verified-badge-line', 'library' => 'remixicon' ],
					'title'          => 'มาตรฐานการรักษาสูง',
					'desc'           => 'ใช้อุปกรณ์ทันสมัย วัสดุนำเข้าคุณภาพสูง ผ่านการรับรองมาตรฐานสากล'
				],
				[
					'selected_icon' => [ 'value' => 'ri-heart-pulse-line', 'library' => 'remixicon' ],
					'title'          => 'ใส่ใจทุกรายละเอียด',
					'desc'           => 'ดูแลคุณตั้งแต่ขั้นตอนการตรวจจนถึงการติดตามผลการรักษา'
				],
				[
					'selected_icon' => [ 'value' => 'ri-price-tag-3-line', 'library' => 'remixicon' ],
					'title'          => 'ราคาเป็นธรรม',
					'desc'           => 'ราคาโปร่งใส ไม่มีค่าใช้จ่ายซ่อนเร้น มีแผนผ่อนชำระสำหรับการรักษา'
				],
			],
			'title_field' => '{{{ title }}}',
		] );
		$this->add_responsive_control( 'features_columns', [
			'label'          => esc_html__( 'Features Columns', 'starter-elementor-addon' ),
			'type'           => \Elementor\Controls_Manager::SELECT,
			'default'        => '1',
			'tablet_default' => '1',
			'mobile_default' => '1',
			'options'        => [
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
			],
			'selectors'      => [
				'{{WRAPPER}} .starter-why-us__features' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
			],
		] );
		$this->add_control( 'features_layout', [
			'label'   => esc_html__( 'Features Layout', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'vertical',
			'options' => [
				'vertical'   => esc_html__( 'Vertical (Icon Top)', 'starter-elementor-addon' ),
				'horizontal' => esc_html__( 'Horizontal (Icon Left)', 'starter-elementor-addon' ),
			],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_image', [
			'label' => esc_html__( 'Clinic Image', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		$this->add_control( 'clinic_image', [
			'label' => esc_html__( 'Image', 'starter-elementor-addon' ),
			'type'  => \Elementor\Controls_Manager::MEDIA,
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
			'selectors'  => [ '{{WRAPPER}} .starter-why-us' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'section_margin', [
			'label'      => esc_html__( 'Section Margin', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem', '%' ],
			'selectors'  => [ '{{WRAPPER}} .starter-why-us' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->add_control( 'section_bg', [
			'label'     => esc_html__( 'Section Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-why-us' => 'background-color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
			'name'     => 'section_border',
			'label'    => esc_html__( 'Section Border', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-why-us',
		] );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'section_box_shadow',
			'label'    => esc_html__( 'Section Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-why-us',
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
			'selectors' => [ '{{WRAPPER}} .starter-why-us__badge' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'badge_typography',
			'label'    => esc_html__( 'Badge Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-why-us__badge',
		] );
		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Title Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#111827',
			'selectors' => [ '{{WRAPPER}} .starter-why-us__title' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'label'    => esc_html__( 'Title Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-why-us__title',
		] );
		$this->add_responsive_control( 'title_margin', [
			'label'      => esc_html__( 'Margin Bottom', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-why-us__title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_content', [
			'label' => esc_html__( 'Content', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->add_control( 'content_color', [
			'label'     => esc_html__( 'Content Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#6b7280',
			'selectors' => [ '{{WRAPPER}} .starter-why-us__content' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'content_typography',
			'label'    => esc_html__( 'Content Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-why-us__content',
		] );
		$this->add_responsive_control( 'content_align', [
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
			'default'   => 'left',
			'selectors' => [
				'{{WRAPPER}} .starter-why-us__content' => 'text-align: {{VALUE}};',
			],
		] );
		$this->add_responsive_control( 'content_margin', [
			'label'      => esc_html__( 'Margin Bottom', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'size' => 24, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-why-us__content' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_features', [
			'label' => esc_html__( 'Features', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->add_responsive_control( 'features_gap', [
			'label'      => esc_html__( 'Features Gap', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 60 ] ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-why-us__features' => '--starter-why-us-features-gap: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'features_justify', [
			'label'   => esc_html__( 'Justify Content', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'flex-start' => [
					'title' => esc_html__( 'Start', 'starter-elementor-addon' ),
					'icon'  => 'eicon-h-align-left',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'starter-elementor-addon' ),
					'icon'  => 'eicon-h-align-center',
				],
				'flex-end' => [
					'title' => esc_html__( 'End', 'starter-elementor-addon' ),
					'icon'  => 'eicon-h-align-right',
				],
				'space-between' => [
					'title' => esc_html__( 'Space Between', 'starter-elementor-addon' ),
					'icon'  => 'eicon-h-align-stretch',
				],
			],
			'default'   => 'flex-start',
			'selectors' => [
				'{{WRAPPER}} .starter-why-us__features' => '--starter-why-us-features-justify: {{VALUE}};',
			],
		] );
		$this->add_control( 'icon_bg', [
			'label'     => esc_html__( 'Icon Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(236,0,140,0.1)',
			'selectors' => [ '{{WRAPPER}} .starter-why-us__feature-icon' => 'background-color: {{VALUE}};' ],
		] );
		$this->add_control( 'icon_color', [
			'label'     => esc_html__( 'Icon Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-why-us__feature-icon' => 'color: {{VALUE}};' ],
		] );
		$this->add_responsive_control( 'icon_size', [
			'label'      => esc_html__( 'Icon Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 12, 'max' => 48 ] ],
			'default'    => [ 'size' => 20, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__feature-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .starter-why-us__feature-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'icon_container_size', [
			'label'      => esc_html__( 'Icon Container Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 32, 'max' => 80 ] ],
			'default'    => [ 'size' => 48, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-why-us__feature-icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'icon_radius', [
			'label'      => esc_html__( 'Icon Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-why-us__feature-icon' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_control( 'feature_title_color', [
			'label'     => esc_html__( 'Feature Title Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#1f2937',
			'selectors' => [ '{{WRAPPER}} .starter-why-us__feature-title' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'feature_title_typography',
			'label'    => esc_html__( 'Feature Title Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-why-us__feature-title',
		] );
		$this->add_control( 'feature_desc_color', [
			'label'     => esc_html__( 'Feature Description Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#9ca3af',
			'selectors' => [ '{{WRAPPER}} .starter-why-us__feature-desc' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'feature_desc_typography',
			'label'    => esc_html__( 'Feature Description Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-why-us__feature-desc',
		] );
		$this->add_responsive_control( 'feature_gap', [
			'label'      => esc_html__( 'Feature Gap', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 48 ] ],
			'default'    => [ 'size' => 24, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-why-us__features' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_image', [
			'label' => esc_html__( 'Image', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->add_control( 'image_bg', [
			'label'     => esc_html__( 'Image Container Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [ '{{WRAPPER}} .starter-why-us__image-container' => 'background-color: {{VALUE}};' ],
		] );
		$this->add_responsive_control( 'image_width', [
			'label'      => esc_html__( 'Image Container Width', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'vw' ],
			'range'      => [
				'px' => [ 'min' => 200, 'max' => 800 ],
				'%'  => [ 'min' => 20, 'max' => 100 ],
				'vw' => [ 'min' => 20, 'max' => 100 ],
			],
			'default'    => [ 'size' => 100, 'unit' => '%' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__image-container' => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'image_height', [
			'label'      => esc_html__( 'Image Container Height', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem', 'vh' ],
			'range'      => [
				'px' => [ 'min' => 200, 'max' => 800 ],
				'vh' => [ 'min' => 10, 'max' => 100 ],
			],
			'default'    => [ 'size' => 440, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__image-container' => 'height: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'image_border_radius', [
			'label'      => esc_html__( 'Image Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 24, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__image-container' => 'border-radius: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .starter-why-us__image'           => 'border-radius: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'image_box_shadow',
			'label'    => esc_html__( 'Image Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-why-us__image-container',
		] );
		$this->add_control( 'image_object_fit', [
			'label'     => esc_html__( 'Image Object Fit', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'cover',
			'options'   => [
				'cover'   => esc_html__( 'Cover (Crop)', 'starter-elementor-addon' ),
				'contain' => esc_html__( 'Contain (Fit)', 'starter-elementor-addon' ),
				'fill'    => esc_html__( 'Fill (Stretch)', 'starter-elementor-addon' ),
			],
			'selectors' => [
				'{{WRAPPER}} .starter-why-us__image' => '--image-object-fit: {{VALUE}};',
			],
		] );
		$this->add_responsive_control( 'image_object_position_x', [
			'label'      => esc_html__( 'Image Focus position X (%)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__image' => '--image-object-x: {{SIZE}}%;',
			],
		] );
		$this->add_responsive_control( 'image_object_position_y', [
			'label'      => esc_html__( 'Image Focus position Y (%)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__image' => '--image-object-y: {{SIZE}}%;',
			],
		] );
		$this->add_responsive_control( 'image_scale', [
			'label'      => esc_html__( 'Image Scale (Zoom)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0.5, 'max' => 2.5, 'step' => 0.05 ] ],
			'default'    => [ 'size' => 1, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__image' => '--image-scale: {{SIZE}};',
			],
		] );
		$this->add_responsive_control( 'image_x_position', [
			'label'      => esc_html__( 'Image X Translate Offset', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'rem' ],
			'range'      => [
				'px' => [ 'min' => -200, 'max' => 200 ],
				'%'  => [ 'min' => -100, 'max' => 100 ],
			],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__image' => '--image-x: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'image_y_position', [
			'label'      => esc_html__( 'Image Y Translate Offset', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'rem' ],
			'range'      => [
				'px' => [ 'min' => -200, 'max' => 200 ],
				'%'  => [ 'min' => -100, 'max' => 100 ],
			],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__image' => '--image-y: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'circle1_size', [
			'label'      => esc_html__( 'Deco Circle 1 Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 50, 'max' => 500 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__deco-circle--1' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'circle1_x', [
			'label'      => esc_html__( 'Deco Circle 1 X Offset (Left)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => -200, 'max' => 200 ], '%' => [ 'min' => -100, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__deco-circle--1' => 'left: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'circle1_y', [
			'label'      => esc_html__( 'Deco Circle 1 Y Offset (Top)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => -200, 'max' => 200 ], '%' => [ 'min' => -100, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__deco-circle--1' => 'top: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_control( 'deco_circle_1_color', [
			'label'     => esc_html__( 'Deco Circle 1 Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--secondary)',
			'selectors' => [
				'{{WRAPPER}} .starter-why-us__deco-circle--1' => 'background: radial-gradient(circle, {{VALUE}} 0%, rgba(63, 81, 181, 0) 70%);',
			],
		] );
		$this->add_responsive_control( 'circle2_size', [
			'label'      => esc_html__( 'Deco Circle 2 Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 50, 'max' => 500 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__deco-circle--2' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'circle2_x', [
			'label'      => esc_html__( 'Deco Circle 2 X Offset (Right)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => -200, 'max' => 200 ], '%' => [ 'min' => -100, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__deco-circle--2' => 'right: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'circle2_y', [
			'label'      => esc_html__( 'Deco Circle 2 Y Offset (Bottom)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => -200, 'max' => 200 ], '%' => [ 'min' => -100, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__deco-circle--2' => 'bottom: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_control( 'deco_circle_2_color', [
			'label'     => esc_html__( 'Deco Circle 2 Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [
				'{{WRAPPER}} .starter-why-us__deco-circle--2' => 'background: radial-gradient(circle, {{VALUE}} 0%, rgba(236, 0, 140, 0) 70%);',
			],
		] );
		$this->add_responsive_control( 'circles_blur', [
			'label'      => esc_html__( 'Deco Circles Blur', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-why-us__deco-circle' => 'filter: blur({{SIZE}}px);',
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		wp_enqueue_style( 'starter-starter-why-us', STARTER_URL . 'widgets/starter-why-us/starter-why-us.css', [], STARTER_VERSION );

		$img_url = ! empty( $settings['clinic_image']['url'] ) ? esc_url( $settings['clinic_image']['url'] ) : '';
		
		$row_class = 'starter-why-us__row';
		if ( ! empty( $settings['image_position'] ) && 'left' === $settings['image_position'] ) {
			$row_class .= ' starter-why-us__row--image-left';
		}

		$features_layout = ! empty( $settings['features_layout'] ) ? $settings['features_layout'] : 'vertical';
		$feature_layout_class = 'starter-why-us__feature--' . $features_layout;
		?>
		<section class="starter-why-us">
			<div class="starter-why-us__container">
				<div class="<?php echo esc_attr( $row_class ); ?>">

					<!-- Left: Features -->
					<div class="starter-why-us__col starter-why-us__col--features">
						<?php if ( ! empty( $settings['badge_text'] ) ) : ?>
						<span class="starter-why-us__badge">
							<?php echo esc_html( $settings['badge_text'] ); ?>
						</span>
						<?php endif; ?>
						<h2 class="starter-why-us__title">
							<?php echo esc_html( $settings['title_line1'] ); ?><br>
							<?php echo esc_html( $settings['title_line2'] ); ?>
						</h2>

						<?php if ( ! empty( $settings['content'] ) ) : ?>
						<div class="starter-why-us__content mb-6 text-base font-light leading-7 text-gray-600">
							<?php echo wp_kses_post( $settings['content'] ); ?>
						</div>
						<?php endif; ?>

						<?php if ( ! empty( $settings['features'] ) ) : ?>
						<div class="starter-why-us__features">
							<?php foreach ( $settings['features'] as $feature ) : ?>
							<div class="starter-why-us__feature <?php echo esc_attr( $feature_layout_class ); ?>">
								<div class="starter-why-us__feature-icon">
									<?php
									if ( ! empty( $feature['selected_icon']['value'] ) ) {
										\Elementor\Icons_Manager::render_icon( $feature['selected_icon'], [ 'aria-hidden' => 'true' ] );
									} elseif ( ! empty( $feature['icon_class'] ) ) {
										echo '<i class="' . esc_attr( $feature['icon_class'] ) . '" aria-hidden="true"></i>';
									} else {
										echo '<i class="ri-star-line" aria-hidden="true"></i>';
									}
									?>
								</div>
								<div class="starter-why-us__feature-content">
									<h3 class="starter-why-us__feature-title">
										<?php echo esc_html( $feature['title'] ?? '' ); ?>
									</h3>
									<p class="starter-why-us__feature-desc">
										<?php echo esc_html( $feature['desc'] ?? '' ); ?>
									</p>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
					</div>

					<!-- Right: Image -->
					<div class="starter-why-us__col starter-why-us__col--image">
						<div class="starter-why-us__image-container">
							<?php if ( $img_url ) : ?>
								<img src="<?php echo $img_url; ?>" alt="<?php echo esc_attr__( 'Clinic', 'starter-elementor-addon' ); ?>" class="starter-why-us__image">
							<?php else : ?>
								<div class="starter-why-us__image-placeholder">
									<i class="ri-hospital-line starter-why-us__placeholder-icon" aria-hidden="true"></i>
									<p class="starter-why-us__placeholder-text"><?php echo esc_html__( 'Clinic Image', 'starter-elementor-addon' ); ?></p>
								</div>
							<?php endif; ?>
						</div>
						<div class="starter-why-us__deco-circle starter-why-us__deco-circle--1 starter-why-us__deco-circle--top-left"></div>
						<div class="starter-why-us__deco-circle starter-why-us__deco-circle--2 starter-why-us__deco-circle--bottom-right"></div>
					</div>

				</div>
			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<#
		var rowClass = 'starter-why-us__row';
		if ( settings.image_position === 'left' ) {
			rowClass += ' starter-why-us__row--image-left';
		}
		var featuresLayout = settings.features_layout || 'vertical';
		var featureLayoutClass = 'starter-why-us__feature--' + featuresLayout;
		#>
		<section class="starter-why-us">
			<div class="starter-why-us__container">
				<div class="{{ rowClass }}">

					<!-- Left: Features -->
					<div class="starter-why-us__col starter-why-us__col--features">
						<# if ( settings.badge_text ) { #>
						<span class="starter-why-us__badge">
							{{{ settings.badge_text }}}
						</span>
						<# } #>
						<h2 class="starter-why-us__title">
							{{{ settings.title_line1 }}}<br>
							{{{ settings.title_line2 }}}
						</h2>

						<# if ( settings.content ) { #>
						<div class="starter-why-us__content mb-6 text-base font-light leading-7 text-gray-600">
							{{{ settings.content }}}
						</div>
						<# } #>

						<# if ( settings.features && settings.features.length ) { #>
						<div class="starter-why-us__features">
							<# _.each( settings.features, function( feature ) {
								var iconHtml = '';
								if ( feature.selected_icon && feature.selected_icon.value ) {
									var iconRender = elementor.helpers.renderIcon( view, feature.selected_icon, { 'aria-hidden': true }, 'i', 'object' );
									if ( iconRender && iconRender.value ) {
										iconHtml = iconRender.value;
									}
								} else if ( feature.icon_class ) {
									iconHtml = '<i class="' + feature.icon_class + '" aria-hidden="true"></i>';
								} else {
									iconHtml = '<i class="ri-star-line" aria-hidden="true"></i>';
								}
							#>
							<div class="starter-why-us__feature {{ featureLayoutClass }}">
								<div class="starter-why-us__feature-icon">
									{{{ iconHtml }}}
								</div>
								<div class="starter-why-us__feature-content">
									<h3 class="starter-why-us__feature-title">
										{{{ feature.title }}}
									</h3>
									<p class="starter-why-us__feature-desc">
										{{{ feature.desc }}}
									</p>
								</div>
							</div>
							<# } ); #>
						</div>
						<# } #>
					</div>

					<!-- Right: Image -->
					<div class="starter-why-us__col starter-why-us__col--image">
						<div class="starter-why-us__image-container">
							<# if ( settings.clinic_image.url ) { #>
								<img src="{{ settings.clinic_image.url }}" alt="<?php echo esc_attr__( 'Clinic', 'starter-elementor-addon' ); ?>" class="starter-why-us__image">
							<# } else { #>
								<div class="starter-why-us__image-placeholder">
									<i class="ri-hospital-line starter-why-us__placeholder-icon" aria-hidden="true"></i>
									<p class="starter-why-us__placeholder-text"><?php echo esc_html__( 'Clinic Image', 'starter-elementor-addon' ); ?></p>
								</div>
							<# } #>
						</div>
						<div class="starter-why-us__deco-circle starter-why-us__deco-circle--1 starter-why-us__deco-circle--top-left"></div>
						<div class="starter-why-us__deco-circle starter-why-us__deco-circle--2 starter-why-us__deco-circle--bottom-right"></div>
					</div>

				</div>
			</div>
		</section>
		<?php
	}
}

add_action( 'wp_enqueue_scripts', function() {
	wp_register_style(  'starter-starter-why-us', STARTER_URL . 'widgets/starter-why-us/starter-why-us.css', [], STARTER_VERSION );
	wp_register_script( 'starter-starter-why-us', STARTER_URL . 'widgets/starter-why-us/starter-why-us.js',  [], STARTER_VERSION, true );
} );
add_action( 'elementor/editor/before_enqueue_scripts', function() {
	wp_enqueue_style( 'starter-starter-why-us', STARTER_URL . 'widgets/starter-why-us/starter-why-us.css', [], STARTER_VERSION );
} );
