<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * KU CTA Banner Widget
 *
 * An Elementor widget that displays a beautiful, highly-responsive call-to-action
 * banner with micro-animations, customizable colors, and direct settings binding.
 */
class STARTER_Widget_starter_Cta_Banner extends \Elementor\Widget_Base {

	public function get_name()       { return 'starter-cta-banner'; }
	public function get_title()      { return esc_html__( 'KU CTA Banner', 'starter-elementor-addon' ); }
	public function get_icon()       { return 'eicon-call-to-action'; }
	public function get_categories() { return [ 'starter-elementor-addon' ]; }
	public function get_keywords()   { return [ 'cta', 'banner', 'call to action', 'dental' ]; }

	public function get_style_depends()  { return [ 'starter-starter-cta-banner' ]; }
	public function get_script_depends() { return [ 'starter-starter-cta-banner' ]; }

	protected function register_controls() {

		// ==========================================
		// CONTENT TAB
		// ==========================================
		$this->start_controls_section( 'section_content', [
			'label' => esc_html__( 'Content', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'icon_class', [
			'label'   => esc_html__( 'Remix Icon Class', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'ri-calendar-check-line',
		] );

		$this->add_control( 'title', [
			'label'   => esc_html__( 'Title', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'นัดหมายล่วงหน้า สะดวก ไม่ต้องรอนาน',
		] );

		$this->add_control( 'subtitle', [
			'label'   => esc_html__( 'Subtitle / Hours', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'เปิดให้บริการ จันทร์-เสาร์ 10:00-20:00 น.  |  อาทิตย์ 10:00-18:00 น.',
		] );

		$this->add_control( 'btn_text', [
			'label'   => esc_html__( 'Button Text', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'นัดหมายแพทย์วันนี้',
		] );

		$this->add_control( 'btn_url', [
			'label'   => esc_html__( 'Button URL', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => 'tel:021234567' ],
		] );

		$this->add_control( 'btn_icon', [
			'label'   => esc_html__( 'Button Icon Class (Optional)', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'ri-calendar-line',
			'separator' => 'before',
		] );

		$this->add_control( 'bg_image', [
			'label'   => esc_html__( 'Background Image (Optional)', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => '' ],
		] );

		$this->add_control( 'show_icon', [
			'label'        => esc_html__( 'Show Icon', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'label_on'     => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'No', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'separator'    => 'before',
		] );

		$this->add_control( 'show_title', [
			'label'        => esc_html__( 'Show Title', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'label_on'     => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'No', 'starter-elementor-addon' ),
			'return_value' => 'yes',
		] );

		$this->add_control( 'show_subtitle', [
			'label'        => esc_html__( 'Show Subtitle', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'label_on'     => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'No', 'starter-elementor-addon' ),
			'return_value' => 'yes',
		] );

		$this->add_control( 'show_button', [
			'label'        => esc_html__( 'Show Button', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'label_on'     => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'No', 'starter-elementor-addon' ),
			'return_value' => 'yes',
		] );
		$this->add_responsive_control( 'inner_direction', [
			'label'          => esc_html__( 'Inner Direction', 'starter-elementor-addon' ),
			'type'           => \Elementor\Controls_Manager::SELECT,
			'default'        => 'column',
			'tablet_default' => 'row',
			'mobile_default' => 'column',
			'options'        => [
				'row'            => esc_html__( 'Row (Horizontal)', 'starter-elementor-addon' ),
				'row-reverse'    => esc_html__( 'Row Reverse', 'starter-elementor-addon' ),
				'column'         => esc_html__( 'Column (Vertical)', 'starter-elementor-addon' ),
				'column-reverse' => esc_html__( 'Column Reverse', 'starter-elementor-addon' ),
			],
			'selectors'      => [
				'{{WRAPPER}} .starter-cta-banner__inner' => '--inner-direction: {{VALUE}};',
			],
		] );
		$this->add_responsive_control( 'inner_gap', [
			'label'          => esc_html__( 'Inner Gap', 'starter-elementor-addon' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px', 'rem' ],
			'range'          => [ 'px' => [ 'min' => 0, 'max' => 120 ], 'rem' => [ 'min' => 0, 'max' => 8 ] ],
			'default'        => [ 'size' => 24, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 32, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 24, 'unit' => 'px' ],
			'selectors'      => [
				'{{WRAPPER}} .starter-cta-banner__inner' => '--inner-gap: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'content_alignment', [
			'label'          => esc_html__( 'Content Alignment', 'starter-elementor-addon' ),
			'type'           => \Elementor\Controls_Manager::CHOOSE,
			'default'        => 'center',
			'tablet_default' => 'center',
			'mobile_default' => 'center',
			'options'        => [
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
			'selectors'      => [
				'{{WRAPPER}} .starter-cta-banner__inner' => 'justify-content: {{VALUE}}; align-items: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'text_alignment', [
			'label'          => esc_html__( 'Text Alignment', 'starter-elementor-addon' ),
			'type'           => \Elementor\Controls_Manager::CHOOSE,
			'default'        => 'left',
			'tablet_default' => 'left',
			'mobile_default' => 'center',
			'options'        => [
				'left'   => [
					'title' => esc_html__( 'Left', 'starter-elementor-addon' ),
					'icon'  => 'eicon-text-align-left',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'starter-elementor-addon' ),
					'icon'  => 'eicon-text-align-center',
				],
				'right'  => [
					'title' => esc_html__( 'Right', 'starter-elementor-addon' ),
					'icon'  => 'eicon-text-align-right',
				],
			],
			'selectors'      => [
				'{{WRAPPER}} .starter-cta-banner__text' => 'text-align: {{VALUE}};',
			],
		] );

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: SECTION
		// ==========================================
		$this->start_controls_section( 'style_section', [
			'label' => esc_html__( 'Section Wrapper', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'section_padding', [
			'label'      => esc_html__( 'Section Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem', '%' ],
			'default'    => [
				'top'      => '48',
				'right'    => '0',
				'bottom'   => '48',
				'left'     => '0',
				'unit'     => 'px',
				'isLinked' => false,
			],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'section_radius', [
			'label'      => esc_html__( 'Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem', '%' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'gradient_from', [
			'label'     => esc_html__( 'Gradient From Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--color-primary, #EC008C)',
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner' => '--starter-cta-from: {{VALUE}};' ],
		] );

		$this->add_control( 'gradient_to', [
			'label'     => esc_html__( 'Gradient To Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--secondary, #8E2BAF)',
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner' => '--starter-cta-to: {{VALUE}};' ],
		] );

		$this->add_control( 'gradient_angle', [
			'label'      => esc_html__( 'Gradient Angle', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'deg' ],
			'range'      => [ 'deg' => [ 'min' => 0, 'max' => 360 ] ],
			'default'    => [ 'size' => 135, 'unit' => 'deg' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner' => '--starter-cta-angle: {{SIZE}}deg;' ],
		] );

		$this->add_control( 'border_heading', [
			'label'     => esc_html__( 'Border Settings', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'section_border_type', [
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
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner' => 'border-style: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'section_border_width', [
			'label'      => esc_html__( 'Border Width', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px' ],
			'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'section_border_color', [
			'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_control( 'section_bg_type', [
			'label'     => esc_html__( 'Background Type', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'gradient',
			'options'   => [
				'gradient' => esc_html__( 'Gradient', 'starter-elementor-addon' ),
				'solid'    => esc_html__( 'Solid Color', 'starter-elementor-addon' ),
			],
			'separator' => 'before',
		] );

		$this->add_control( 'section_bg_solid', [
			'label'     => esc_html__( 'Solid Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--color-primary, #EC008C)',
			'condition' => [ 'section_bg_type' => 'solid' ],
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'content_max_width', [
			'label'      => esc_html__( 'Content Max Width', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 300, 'max' => 1400 ], '%' => [ 'min' => 50, 'max' => 100 ] ],
			'default'    => [ 'size' => 1200, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .s-container' => 'max-width: {{SIZE}}{{UNIT}};' ],
			'separator'  => 'before',
		] );

		$this->add_responsive_control( 'content_margin', [
			'label'      => esc_html__( 'Content Margin', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px' ],
			'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .s-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'section_box_shadow',
			'label'    => esc_html__( 'Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-cta-banner',
		] );

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: ICON
		// ==========================================
		$this->start_controls_section( 'style_icon', [
			'label' => esc_html__( 'Icon Container', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'icon_bg', [
			'label'     => esc_html__( 'Icon Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(255,255,255,0.2)',
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner__icon-wrap' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'icon_color', [
			'label'     => esc_html__( 'Icon Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner__icon' => 'color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'icon_size', [
			'label'      => esc_html__( 'Icon Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 12, 'max' => 64 ] ],
			'default'    => [ 'size' => 28, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__icon' => 'font-size: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'icon_wrap_size', [
			'label'      => esc_html__( 'Container Dimensions', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 32, 'max' => 96 ] ],
			'default'    => [ 'size' => 56, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-cta-banner__icon-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'icon_wrap_radius', [
			'label'      => esc_html__( 'Container Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__icon-wrap' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'icon_margin', [
			'label'      => esc_html__( 'Icon Margin', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px' ],
			'default'    => [ 'top' => '0', 'right' => '16', 'bottom' => '0', 'left' => '0', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__icon-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			'separator'  => 'before',
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'icon_box_shadow',
			'label'    => esc_html__( 'Icon Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-cta-banner__icon-wrap',
		] );

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: CONTENT
		// ==========================================
		$this->start_controls_section( 'style_content', [
			'label' => esc_html__( 'Typography & Texts', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'title_heading', [
			'label'     => esc_html__( 'Title Styles', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Title Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner__title' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'label'    => esc_html__( 'Title Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-cta-banner__title',
		] );

		$this->add_responsive_control( 'title_size', [
			'label'      => esc_html__( 'Title Font Size (Fallback)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 14, 'max' => 64 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__title' => 'font-size: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'title_line_height', [
			'label'      => esc_html__( 'Title Line Height', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 16, 'max' => 80 ], 'em' => [ 'min' => 1, 'max' => 2.5, 'step' => 0.1 ] ],
			'default'    => [ 'size' => 1.2, 'unit' => 'em' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__title' => 'line-height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'title_letter_spacing', [
			'label'      => esc_html__( 'Title Letter Spacing', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => -5, 'max' => 20 ], 'em' => [ 'min' => -0.2, 'max' => 0.5, 'step' => 0.01 ] ],
			'default'    => [ 'size' => 0, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__title' => 'letter-spacing: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Text_Shadow::get_type(), [
			'name'     => 'title_text_shadow',
			'label'    => esc_html__( 'Title Text Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-cta-banner__title',
		] );

		$this->add_control( 'subtitle_heading', [
			'label'     => esc_html__( 'Subtitle Styles', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'subtitle_color', [
			'label'     => esc_html__( 'Subtitle Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(255,255,255,0.85)',
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner__subtitle' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'subtitle_typography',
			'label'    => esc_html__( 'Subtitle Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-cta-banner__subtitle',
		] );

		$this->add_responsive_control( 'subtitle_line_height', [
			'label'      => esc_html__( 'Subtitle Line Height', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 12, 'max' => 40 ], 'em' => [ 'min' => 1, 'max' => 2.5, 'step' => 0.1 ] ],
			'default'    => [ 'size' => 1.5, 'unit' => 'em' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__subtitle' => 'line-height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'subtitle_letter_spacing', [
			'label'      => esc_html__( 'Subtitle Letter Spacing', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => -5, 'max' => 20 ], 'em' => [ 'min' => -0.2, 'max' => 0.5, 'step' => 0.01 ] ],
			'default'    => [ 'size' => 0, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__subtitle' => 'letter-spacing: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Text_Shadow::get_type(), [
			'name'     => 'subtitle_text_shadow',
			'label'    => esc_html__( 'Subtitle Text Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-cta-banner__subtitle',
		] );

		$this->add_responsive_control( 'content_padding', [
			'label'      => esc_html__( 'Content Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			'separator'  => 'before',
		] );

		$this->add_control( 'content_bg', [
			'label'     => esc_html__( 'Content Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'transparent',
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner__content' => 'background-color: {{VALUE}};' ],
		] );

		$this->end_controls_section();

		// ==========================================
		// STYLE TAB: BUTTON
		// ==========================================
		$this->start_controls_section( 'style_button', [
			'label' => esc_html__( 'Action Button', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->start_controls_tabs( 'btn_style_tabs' );

		// Normal State Tab
		$this->start_controls_tab( 'btn_normal_tab', [
			'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'btn_bg', [
			'label'     => esc_html__( 'Button Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner__btn' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'btn_text_color', [
			'label'     => esc_html__( 'Button Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--color-primary, #EC008C)',
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner__btn' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'btn_box_shadow',
			'label'    => esc_html__( 'Button Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-cta-banner__btn',
		] );

		$this->end_controls_tab();

		// Hover State Tab
		$this->start_controls_tab( 'btn_hover_tab', [
			'label' => esc_html__( 'Hover', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'btn_bg_hover', [
			'label'     => esc_html__( 'Button Background (Hover)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(255, 255, 255, 0.95)',
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner__btn:hover' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'btn_text_color_hover', [
			'label'     => esc_html__( 'Button Text Color (Hover)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--color-primary, #EC008C)',
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner__btn:hover' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'btn_box_shadow_hover',
			'label'    => esc_html__( 'Button Box Shadow (Hover)', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-cta-banner__btn:hover',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Global Button Customizations
		$this->add_responsive_control( 'btn_padding', [
			'label'      => esc_html__( 'Button Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'top' => '14', 'right' => '32', 'bottom' => '14', 'left' => '32', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			'separator'  => 'before',
		] );

		$this->add_responsive_control( 'btn_radius', [
			'label'      => esc_html__( 'Button Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'size' => 12, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__btn' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'btn_typography',
			'label'    => esc_html__( 'Button Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-cta-banner__btn',
		] );

		$this->add_responsive_control( 'btn_icon_size', [
			'label'      => esc_html__( 'Button Icon Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 12, 'max' => 32 ] ],
			'default'    => [ 'size' => 18, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__btn-icon' => 'font-size: {{SIZE}}{{UNIT}};' ],
			'separator'  => 'before',
		] );

		$this->add_responsive_control( 'btn_gap', [
			'label'      => esc_html__( 'Button Icon Gap', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 24 ] ],
			'default'    => [ 'size' => 8, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__btn' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Text_Shadow::get_type(), [
			'name'     => 'btn_text_shadow',
			'label'    => esc_html__( 'Button Text Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-cta-banner__btn',
		] );

		$this->add_control( 'btn_transition_duration', [
			'label'      => esc_html__( 'Transition Duration', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 's', 'ms' ],
			'range'      => [ 's' => [ 'min' => 0, 'max' => 2, 'step' => 0.1 ], 'ms' => [ 'min' => 0, 'max' => 2000, 'step' => 50 ] ],
			'default'    => [ 'size' => 0.3, 'unit' => 's' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__btn' => 'transition-duration: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'btn_border_heading', [
			'label'     => esc_html__( 'Button Border', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'btn_border_type', [
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
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner__btn' => 'border-style: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'btn_border_width', [
			'label'      => esc_html__( 'Border Width', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px' ],
			'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'btn_border_color', [
			'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'transparent',
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner__btn' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_control( 'btn_border_color_hover', [
			'label'     => esc_html__( 'Border Color (Hover)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'transparent',
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner__btn:hover' => 'border-color: {{VALUE}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'style_bg_image', [
			'label' => esc_html__( 'Background Image', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->add_control( 'bg_image_object_fit', [
			'label'     => esc_html__( 'Image Fit', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'cover',
			'options'   => [
				'cover'   => esc_html__( 'Cover (Crop)', 'starter-elementor-addon' ),
				'contain' => esc_html__( 'Contain (Fit)', 'starter-elementor-addon' ),
				'fill'    => esc_html__( 'Fill (Stretch)', 'starter-elementor-addon' ),
			],
			'selectors' => [ '{{WRAPPER}} .starter-cta-banner__bg' => '--bg-img-fit: {{VALUE}};' ],
		] );
		$this->add_responsive_control( 'bg_image_object_position_x', [
			'label'      => esc_html__( 'Focus X (%)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__bg' => '--bg-img-x: {{SIZE}}%;' ],
		] );
		$this->add_responsive_control( 'bg_image_object_position_y', [
			'label'      => esc_html__( 'Focus Y (%)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__bg' => '--bg-img-y: {{SIZE}}%;' ],
		] );
		$this->add_responsive_control( 'bg_image_scale', [
			'label'      => esc_html__( 'Scale (Zoom)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0.5, 'max' => 2.5, 'step' => 0.05 ] ],
			'default'    => [ 'size' => 1, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__bg' => '--bg-img-scale: {{SIZE}};' ],
		] );
		$this->add_responsive_control( 'bg_image_x_offset', [
			'label'      => esc_html__( 'X Translate Offset', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => -200, 'max' => 200 ], '%' => [ 'min' => -100, 'max' => 100 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__bg' => '--bg-img-tx: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'bg_image_y_offset', [
			'label'      => esc_html__( 'Y Translate Offset', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => -200, 'max' => 200 ], '%' => [ 'min' => -100, 'max' => 100 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__bg' => '--bg-img-ty: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'bg_image_opacity', [
			'label'      => esc_html__( 'Opacity', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
			'default'    => [ 'size' => 0.15, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-cta-banner__bg' => '--bg-img-opacity: {{SIZE}};' ],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		wp_enqueue_style( 'starter-starter-cta-banner', STARTER_URL . 'widgets/starter-cta-banner/starter-cta-banner.css', [], STARTER_VERSION );

		$this->add_render_attribute( 'wrapper', 'class', 'starter-cta-banner' );

		// Apply background type (gradient or solid)
		$bg_type = $settings['section_bg_type'] ?? 'gradient';
		if ( 'solid' === $bg_type ) {
			$bg_color = $settings['section_bg_solid'] ?? 'var(--color-primary, #EC008C)';
			$this->add_render_attribute( 'wrapper', 'style', sprintf( 'background-color: %s;', esc_attr( $bg_color ) ) );
		} else {
			// Apply gradient angle
			$angle = isset( $settings['gradient_angle'] ) ? $settings['gradient_angle']['size'] : 135;
			$this->add_render_attribute( 'wrapper', 'style', sprintf( 'background: linear-gradient(%sdeg, var(--starter-cta-from, var(--color-primary, #EC008C)), var(--starter-cta-to, var(--secondary, #8E2BAF)));', esc_attr( $angle ) ) );
		}

		// Map Elementor standard URL control
		if ( ! empty( $settings['btn_url']['url'] ) ) {
			$this->add_link_attributes( 'button', $settings['btn_url'] );
		}
		$this->add_render_attribute( 'button', 'class', 'starter-cta-banner__btn' );
		?>
		<section <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( ! empty( $settings['bg_image']['url'] ) ) : ?>
			<img src="<?php echo esc_url( $settings['bg_image']['url'] ); ?>" alt="" class="starter-cta-banner__bg" aria-hidden="true">
			<?php endif; ?>
			<div class="s-container mx-auto px-5 md:px-8 lg:px-10">
				<div class="starter-cta-banner__inner">

					<div class="starter-cta-banner__content">
						<?php if ( ! empty( $settings['icon_class'] ) && 'yes' === $settings['show_icon'] ) : ?>
						<div class="starter-cta-banner__icon-wrap">
							<i class="<?php echo esc_attr( $settings['icon_class'] ); ?> starter-cta-banner__icon"></i>
						</div>
						<?php endif; ?>
						<div class="starter-cta-banner__text">
							<?php if ( 'yes' === $settings['show_title'] ) : ?>
							<h3 class="starter-cta-banner__title">
								<?php echo esc_html( $settings['title'] ?? '' ); ?>
							</h3>
							<?php endif; ?>
							<?php if ( ! empty( $settings['subtitle'] ) && 'yes' === $settings['show_subtitle'] ) : ?>
							<p class="starter-cta-banner__subtitle">
								<?php echo esc_html( $settings['subtitle'] ); ?>
							</p>
							<?php endif; ?>
						</div>
					</div>

					<?php if ( ! empty( $settings['btn_text'] ) && 'yes' === $settings['show_button'] ) : ?>
					<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
						<?php if ( ! empty( $settings['btn_icon'] ) ) : ?>
						<i class="starter-cta-banner__btn-icon <?php echo esc_attr( $settings['btn_icon'] ); ?>"></i>
						<?php else : ?>
						<i class="starter-cta-banner__btn-icon ri-calendar-line"></i>
						<?php endif; ?>
						<span class="starter-cta-banner__btn-text"><?php echo esc_html( $settings['btn_text'] ); ?></span>
					</a>
					<?php endif; ?>

				</div>
			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<#
		var bgType = settings.section_bg_type || 'gradient';
		var bgStyle = '';
		if ( bgType === 'solid' ) {
			var bgColor = settings.section_bg_solid || 'var(--color-primary, #EC008C)';
			bgStyle = 'background-color: ' + bgColor + ';';
		} else {
			var angle = settings.gradient_angle && settings.gradient_angle.size ? settings.gradient_angle.size : 135;
			bgStyle = 'background: linear-gradient(' + angle + 'deg, var(--starter-cta-from, var(--color-primary, #EC008C)), var(--starter-cta-to, var(--secondary, #8E2BAF)));';
		}
		#>
		<section class="starter-cta-banner" style="{{{ bgStyle }}}">
			<# if ( settings.bg_image && settings.bg_image.url ) { #>
			<img src="{{ settings.bg_image.url }}" alt="" class="starter-cta-banner__bg" aria-hidden="true">
			<# } #>
			<div class="s-container mx-auto px-5 md:px-8 lg:px-10">
				<div class="starter-cta-banner__inner">

					<div class="starter-cta-banner__content">
						<# if ( settings.icon_class && settings.show_icon === 'yes' ) { #>
						<div class="starter-cta-banner__icon-wrap">
							<i class="{{ settings.icon_class }} starter-cta-banner__icon"></i>
						</div>
						<# } #>
						<div class="starter-cta-banner__text">
							<# if ( settings.show_title === 'yes' ) { #>
							<h3 class="starter-cta-banner__title">
								{{{ settings.title }}}
							</h3>
							<# } #>
							<# if ( settings.subtitle && settings.show_subtitle === 'yes' ) { #>
							<p class="starter-cta-banner__subtitle">
								{{{ settings.subtitle }}}
							</p>
							<# } #>
						</div>
					</div>

					<# if ( settings.btn_text && settings.show_button === 'yes' ) { #>
					<# 
					var target = settings.btn_url.is_external ? ' target="_blank"' : '';
					var nofollow = settings.btn_url.nofollow ? ' rel="nofollow"' : '';
					var btnIcon = settings.btn_icon || 'ri-calendar-line';
					#>
					<a class="starter-cta-banner__btn" href="{{ settings.btn_url.url || '#' }}"{{{ target }}}{{{ nofollow }}}>
						<i class="starter-cta-banner__btn-icon {{{ btnIcon }}}"></i>
						<span class="starter-cta-banner__btn-text">{{{ settings.btn_text }}}</span>
					</a>
					<# } #>

				</div>
			</div>
		</section>
		<?php
	}
}

add_action( 'wp_enqueue_scripts', function() {
	wp_register_style(  'starter-starter-cta-banner', STARTER_URL . 'widgets/starter-cta-banner/starter-cta-banner.css', [], STARTER_VERSION );
	wp_register_script( 'starter-starter-cta-banner', STARTER_URL . 'widgets/starter-cta-banner/starter-cta-banner.js',  [], STARTER_VERSION, true );
} );
add_action( 'elementor/editor/before_enqueue_scripts', function() {
	wp_enqueue_style( 'starter-starter-cta-banner', STARTER_URL . 'widgets/starter-cta-banner/starter-cta-banner.css', [], STARTER_VERSION );
} );
