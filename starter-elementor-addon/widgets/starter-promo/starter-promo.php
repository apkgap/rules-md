<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class STARTER_Widget_starter_Promo extends \Elementor\Widget_Base {

	public function get_name()       { return 'starter-promo'; }
	public function get_title()      { return esc_html__( 'KU Promotion / Pricing', 'starter-elementor-addon' ); }
	public function get_icon()       { return 'eicon-price-list'; }
	public function get_categories() { return [ 'starter-elementor-addon' ]; }
	public function get_keywords()   { return [ 'promo', 'pricing', 'promotion', 'dental' ]; }

	public function get_style_depends()  { return [ 'starter-starter-promo' ]; }
	public function get_script_depends() { return [ 'starter-starter-promo' ]; }

	protected function register_controls() {

		// ==========================================
		// CONTENT TAB
		// ==========================================

		$this->start_controls_section( 'section_layout', [
			'label' => esc_html__( 'Layout', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		$this->add_control( 'image_position', [
			'label'   => esc_html__( 'Image Position', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'left',
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
				'{{WRAPPER}} .starter-promo__row' => '--row-direction: {{VALUE}};',
			],
		] );
		$this->add_responsive_control( 'row_gap', [
			'label'          => esc_html__( 'Row Gap', 'starter-elementor-addon' ),
			'type'           => \Elementor\Controls_Manager::SLIDER,
			'size_units'     => [ 'px', 'rem' ],
			'range'          => [ 'px' => [ 'min' => 0, 'max' => 120 ], 'rem' => [ 'min' => 0, 'max' => 8 ] ],
			'default'        => [ 'size' => 3, 'unit' => 'rem' ],
			'tablet_default' => [ 'size' => 3, 'unit' => 'rem' ],
			'mobile_default' => [ 'size' => 3, 'unit' => 'rem' ],
			'selectors'      => [
				'{{WRAPPER}} .starter-promo__row' => '--row-gap: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_header', [
			'label' => esc_html__( 'Header', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		$this->add_control( 'badge_text',    [ 'label' => esc_html__( 'Badge Text',         'starter-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'โปรโมชั่นพิเศษ' ] );
		$this->add_control( 'title_line1',   [ 'label' => esc_html__( 'Title Line 1',        'starter-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'จัดฟันใส เริ่มต้น' ] );
		$this->add_control( 'title_highlight', [ 'label' => esc_html__( 'Title Highlight',   'starter-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT,     'default' => '999.-/เดือน' ] );
		$this->add_control( 'description',   [ 'label' => esc_html__( 'Description',         'starter-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'ผ่อนง่าย ไม่มีดอกเบี้ย ทำได้ทันที' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_price', [
			'label' => esc_html__( 'Price Badge', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		$this->add_control( 'price_prefix', [ 'label' => esc_html__( 'Prefix Text',  'starter-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'เริ่มต้นเพียง' ] );
		$this->add_control( 'price_amount', [ 'label' => esc_html__( 'Amount',       'starter-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '999.-' ] );
		$this->add_control( 'price_unit',   [ 'label' => esc_html__( 'Unit Text',    'starter-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ต่อเดือน' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_benefits', [
			'label' => esc_html__( 'Benefits', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		$repeater = new \Elementor\Repeater();
		$repeater->add_control( 'selected_icon', [
			'label'            => esc_html__( 'Icon', 'starter-elementor-addon' ),
			'type'             => \Elementor\Controls_Manager::ICONS,
			'fa4compatibility' => 'icon',
			'default'          => [
				'value'   => 'ri-check-line',
				'library' => 'remixicon',
			],
		] );
		$repeater->add_control( 'icon_class', [
			'label'   => esc_html__( 'Remix Icon Class (Fallback)', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '',
		] );
		$repeater->add_control( 'text', [
			'label'   => esc_html__( 'Benefit Text', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'สิทธิประโยชน์',
		] );
		$this->add_control( 'benefits', [
			'label'       => esc_html__( 'Benefits', 'starter-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'selected_icon' => [ 'value' => 'ri-check-line', 'library' => 'remixicon' ],
					'text' => 'ฟรี ตรวจประเมินก่อนจัดฟัน'
				],
				[
					'selected_icon' => [ 'value' => 'ri-check-line', 'library' => 'remixicon' ],
					'text' => 'ฟรี โพสต์และติดตามผลทุกเดือน'
				],
				[
					'selected_icon' => [ 'value' => 'ri-check-line', 'library' => 'remixicon' ],
					'text' => 'รับประกันมาตรฐานการรักษา'
				],
			],
			'title_field' => '{{{ text }}}',
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_stats', [
			'label' => esc_html__( 'Stats', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$stats_repeater = new \Elementor\Repeater();
		$stats_repeater->add_control( 'selected_icon', [
			'label'            => esc_html__( 'Icon', 'starter-elementor-addon' ),
			'type'             => \Elementor\Controls_Manager::ICONS,
			'fa4compatibility' => 'icon',
			'default'          => [
				'value'   => '',
				'library' => '',
			],
		] );
		$stats_repeater->add_control( 'icon_class', [
			'label'   => esc_html__( 'Remix Icon Class (Fallback)', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '',
		] );
		$stats_repeater->add_control( 'text', [
			'label'   => esc_html__( 'Text/Value', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '',
		] );
		$stats_repeater->add_control( 'subtitle', [
			'label'   => esc_html__( 'Subtitle/Label', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '',
		] );

		$this->add_control( 'stats_items', [
			'label'       => esc_html__( 'Stats Items', 'starter-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $stats_repeater->get_controls(),
			'default'     => [
				[
					'selected_icon' => [ 'value' => '', 'library' => '' ],
					'text'          => '5,000+',
					'subtitle'      => 'ครอบครัว',
				],
				[
					'selected_icon' => [ 'value' => '', 'library' => '' ],
					'text'          => '10+',
					'subtitle'      => 'ปีประสบการณ์',
				],
				[
					'selected_icon' => [ 'value' => 'ri-map-pin-line', 'library' => 'remixicon' ],
					'text'          => '',
					'subtitle'      => 'สะดวกสบาย',
				],
			],
			'title_field' => '{{{ text || subtitle }}}',
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_cta', [
			'label' => esc_html__( 'CTA', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		$this->add_control( 'cta_text', [ 'label' => esc_html__( 'Button Text', 'starter-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT,    'default' => 'นัดหมายแพทย์วันนี้' ] );
		$this->add_control( 'cta_url',  [ 'label' => esc_html__( 'Button URL',  'starter-elementor-addon' ), 'type' => \Elementor\Controls_Manager::URL,     'default' => [ 'url' => '#contact' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_image', [
			'label' => esc_html__( 'Promo Image', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		$this->add_control( 'promo_image', [ 'label' => esc_html__( 'Image', 'starter-elementor-addon' ), 'type' => \Elementor\Controls_Manager::MEDIA ] );
		$this->end_controls_section();

		// ==========================================
		// STYLE TAB
		// ==========================================

		$this->start_controls_section( 'style_section', [
			'label' => esc_html__( 'Section', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->add_responsive_control( 'section_padding', [
			'label'      => esc_html__( 'Section Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem', '%' ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'section_margin', [
			'label'      => esc_html__( 'Section Margin', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem', '%' ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->add_control( 'section_bg', [
			'label'     => esc_html__( 'Section Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#f9fafb',
			'selectors' => [ '{{WRAPPER}} .starter-promo' => 'background-color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
			'name'     => 'section_border',
			'label'    => esc_html__( 'Section Border', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo',
		] );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'section_box_shadow',
			'label'    => esc_html__( 'Section Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo',
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_header', [
			'label' => esc_html__( 'Header', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->add_responsive_control( 'header_alignment', [
			'label'     => esc_html__( 'Alignment', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::CHOOSE,
			'options'   => [
				'left'   => [ 'title' => esc_html__( 'Left', 'starter-elementor-addon' ), 'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => esc_html__( 'Center', 'starter-elementor-addon' ), 'icon' => 'eicon-text-align-center' ],
				'right'  => [ 'title' => esc_html__( 'Right', 'starter-elementor-addon' ), 'icon' => 'eicon-text-align-right' ],
			],
			'selectors' => [
				'{{WRAPPER}} .starter-promo__col--content' => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
			],
			'prefix_class' => 'elementor-align-',
		] );
		$this->add_control( 'badge_color', [
			'label'     => esc_html__( 'Badge Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-promo__badge' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'badge_typography',
			'label'    => esc_html__( 'Badge Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__badge',
		] );
		$this->add_responsive_control( 'badge_bottom_space', [
			'label'      => esc_html__( 'Badge Bottom Spacing', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__badge' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Title Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#111827',
			'selectors' => [ '{{WRAPPER}} .starter-promo__title' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'label'    => esc_html__( 'Title Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__title',
		] );
		$this->add_responsive_control( 'title_bottom_space', [
			'label'      => esc_html__( 'Title Bottom Spacing', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_control( 'highlight_color', [
			'label'     => esc_html__( 'Highlight Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-promo__highlight' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'highlight_typography',
			'label'    => esc_html__( 'Highlight Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__highlight',
		] );
		$this->add_control( 'description_color', [
			'label'     => esc_html__( 'Description Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#6b7280',
			'selectors' => [ '{{WRAPPER}} .starter-promo__desc' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'description_typography',
			'label'    => esc_html__( 'Description Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__desc',
		] );
		$this->add_responsive_control( 'description_bottom_space', [
			'label'      => esc_html__( 'Description Bottom Spacing', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__desc' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_price', [
			'label' => esc_html__( 'Price Badge', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->add_control( 'price_bg', [
			'label'     => esc_html__( 'Price Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'linear-gradient(135deg, var(--color-primary, #EC008C), var(--secondary, #8E2BAF))',
			'selectors' => [ '{{WRAPPER}} .starter-promo__price-badge' => 'background: {{VALUE}};' ],
		] );
		$this->add_control( 'price_color', [
			'label'     => esc_html__( 'Price Color (Base)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-promo__price-badge' => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'price_prefix_color', [
			'label'     => esc_html__( 'Prefix Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-promo__price-prefix' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'price_prefix_typography',
			'label'    => esc_html__( 'Prefix Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__price-prefix',
		] );
		$this->add_control( 'price_amount_color', [
			'label'     => esc_html__( 'Amount Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-promo__price-amount' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'price_amount_typography',
			'label'    => esc_html__( 'Amount Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__price-amount',
		] );
		$this->add_control( 'price_unit_color', [
			'label'     => esc_html__( 'Unit Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-promo__price-unit' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'price_unit_typography',
			'label'    => esc_html__( 'Unit Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__price-unit',
		] );
		$this->add_responsive_control( 'price_padding', [
			'label'      => esc_html__( 'Price Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'top' => '20', 'right' => '24', 'bottom' => '20', 'left' => '24', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__price-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'price_radius', [
			'label'      => esc_html__( 'Price Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__price-badge' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'price_width', [
			'label'      => esc_html__( 'Price Width', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'rem', 'vw' ],
			'range'      => [
				'px' => [ 'min' => 50, 'max' => 500 ],
				'%'  => [ 'min' => 10, 'max' => 100 ],
			],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__price-badge' => 'width: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'price_height', [
			'label'      => esc_html__( 'Price Height', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'rem', 'vh' ],
			'range'      => [
				'px' => [ 'min' => 50, 'max' => 500 ],
				'%'  => [ 'min' => 10, 'max' => 100 ],
			],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__price-badge' => 'height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'price_border_heading', [
			'label'     => esc_html__( 'Border Settings', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'price_border_type', [
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
			'selectors' => [ '{{WRAPPER}} .starter-promo__price-badge' => 'border-style: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'price_border_width', [
			'label'      => esc_html__( 'Border Width', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px' ],
			'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__price-badge' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'price_border_color', [
			'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-promo__price-badge' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'price_margin', [
			'label'      => esc_html__( 'Price Margin', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__price-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			'separator'  => 'before',
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'price_box_shadow',
			'label'    => esc_html__( 'Price Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__price-badge',
		] );
		$this->add_responsive_control( 'price_x_position', [
			'label'      => esc_html__( 'Price X Offset (Horizontal)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'rem' ],
			'range'      => [
				'px' => [ 'min' => -200, 'max' => 200 ],
				'%'  => [ 'min' => -100, 'max' => 100 ],
			],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__price-badge' => '--price-x: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'price_y_position', [
			'label'      => esc_html__( 'Price Y Offset (Vertical)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'rem' ],
			'range'      => [
				'px' => [ 'min' => -200, 'max' => 200 ],
				'%'  => [ 'min' => -100, 'max' => 100 ],
			],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__price-badge' => '--price-y: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_benefits', [
			'label' => esc_html__( 'Benefits', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->add_control( 'benefit_icon_color', [
			'label'     => esc_html__( 'Benefit Icon Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-promo__benefit-icon' => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'benefit_icon_bg_color', [
			'label'     => esc_html__( 'Benefit Icon BG Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-promo__benefit-icon' => 'background-color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
			'name'     => 'benefit_icon_border',
			'label'    => esc_html__( 'Icon Border', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__benefit-icon',
		] );
		$this->add_responsive_control( 'benefit_icon_radius', [
			'label'      => esc_html__( 'Icon Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__benefit-icon' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'benefit_icon_box_size', [
			'label'      => esc_html__( 'Icon Circle Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 50 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__benefit-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'benefit_icon_size', [
			'label'      => esc_html__( 'Icon Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 30 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__benefit-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .starter-promo__benefit-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_control( 'benefit_text_color', [
			'label'     => esc_html__( 'Benefit Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#374151',
			'selectors' => [ '{{WRAPPER}} .starter-promo__benefit-text' => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'benefit_text_hover_color', [
			'label'     => esc_html__( 'Benefit Text Hover Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-promo__benefit-item:hover .starter-promo__benefit-text' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'benefit_typography',
			'label'    => esc_html__( 'Benefit Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__benefit-text',
		] );
		$this->add_responsive_control( 'benefit_item_spacing', [
			'label'      => esc_html__( 'Item Spacing', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__benefits' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_cta', [
			'label' => esc_html__( 'CTA Button', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->start_controls_tabs( 'cta_tabs' );

		$this->start_controls_tab( 'cta_normal_tab', [
			'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
		] );
		$this->add_control( 'cta_bg', [
			'label'     => esc_html__( 'Button Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-promo__cta' => 'background: {{VALUE}};' ],
		] );
		$this->add_control( 'cta_text_color', [
			'label'     => esc_html__( 'Button Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-promo__cta' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
			'name'     => 'cta_border',
			'label'    => esc_html__( 'Border', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__cta',
		] );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'cta_box_shadow',
			'label'    => esc_html__( 'Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__cta',
		] );
		$this->end_controls_tab();

		$this->start_controls_tab( 'cta_hover_tab', [
			'label' => esc_html__( 'Hover', 'starter-elementor-addon' ),
		] );
		$this->add_control( 'cta_bg_hover', [
			'label'     => esc_html__( 'Button Background Hover', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-promo__cta:hover' => 'background: {{VALUE}};' ],
		] );
		$this->add_control( 'cta_text_color_hover', [
			'label'     => esc_html__( 'Button Text Color Hover', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-promo__cta:hover' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
			'name'     => 'cta_border_hover',
			'label'    => esc_html__( 'Border Hover', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__cta:hover',
		] );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'cta_box_shadow_hover',
			'label'    => esc_html__( 'Box Shadow Hover', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__cta:hover',
		] );
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control( 'cta_padding', [
			'label'      => esc_html__( 'Button Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'top' => '16', 'right' => '32', 'bottom' => '16', 'left' => '32', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'cta_radius', [
			'label'      => esc_html__( 'Button Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 12, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__cta' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'cta_typography',
			'label'    => esc_html__( 'Button Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__cta',
		] );
		$this->add_responsive_control( 'cta_icon_size', [
			'label'      => esc_html__( 'CTA Icon Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 40 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__cta-icon' => 'font-size: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'cta_icon_spacing', [
			'label'      => esc_html__( 'CTA Icon Spacing', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__cta' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'cta_width', [
			'label'     => esc_html__( 'CTA Width', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'auto',
			'options'   => [
				'auto'  => esc_html__( 'Auto', 'starter-elementor-addon' ),
				'block' => esc_html__( 'Full Width', 'starter-elementor-addon' ),
			],
			'selectors' => [
				'{{WRAPPER}} .starter-promo__cta' => 'width: {{VALUE}} == "block" ? 100% : auto; display: {{VALUE}} == "block" ? flex : inline-flex;',
			],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_image', [
			'label' => esc_html__( 'Promo Image', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->add_control( 'image_bg', [
			'label'     => esc_html__( 'Image Container Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [ '{{WRAPPER}} .starter-promo__image-container' => 'background-color: {{VALUE}};' ],
		] );
		$this->add_control( 'image_border_heading', [
			'label'     => esc_html__( 'Border Settings', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );
		$this->add_control( 'image_border_type', [
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
			'selectors' => [ '{{WRAPPER}} .starter-promo__image-container' => 'border-style: {{VALUE}};' ],
		] );
		$this->add_responsive_control( 'image_border_width', [
			'label'      => esc_html__( 'Border Width', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px' ],
			'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => true ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__image-container' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->add_control( 'image_border_color', [
			'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-promo__image-container' => 'border-color: {{VALUE}};' ],
		] );
		$this->add_responsive_control( 'image_padding', [
			'label'      => esc_html__( 'Image Container Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__image-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			'separator'  => 'before',
		] );
		$this->add_responsive_control( 'image_margin', [
			'label'      => esc_html__( 'Image Container Margin', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__image-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
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
				'{{WRAPPER}} .starter-promo__image-container' => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
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
			'default'    => [ 'size' => 420, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__image-container' => 'height: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'image_border_radius', [
			'label'      => esc_html__( 'Image Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 24, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__image-container' => 'border-radius: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .starter-promo__image'           => 'border-radius: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'image_box_shadow',
			'label'    => esc_html__( 'Image Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__image-container',
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
				'{{WRAPPER}} .starter-promo__image' => '--image-object-fit: {{VALUE}};',
			],
		] );
		$this->add_responsive_control( 'image_object_position_x', [
			'label'      => esc_html__( 'Image Focus position X (%)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__image' => '--image-object-x: {{SIZE}}%;',
			],
		] );
		$this->add_responsive_control( 'image_object_position_y', [
			'label'      => esc_html__( 'Image Focus position Y (%)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__image' => '--image-object-y: {{SIZE}}%;',
			],
		] );
		$this->add_responsive_control( 'image_scale', [
			'label'      => esc_html__( 'Image Scale (Zoom)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0.5, 'max' => 2.5, 'step' => 0.05 ] ],
			'default'    => [ 'size' => 1, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__image' => '--image-scale: {{SIZE}};',
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
				'{{WRAPPER}} .starter-promo__image' => '--image-x: {{SIZE}}{{UNIT}};',
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
				'{{WRAPPER}} .starter-promo__image' => '--image-y: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'circle1_size', [
			'label'      => esc_html__( 'Deco Circle 1 Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 50, 'max' => 500 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__deco-circle--1' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'circle1_x', [
			'label'      => esc_html__( 'Deco Circle 1 X Offset (Left)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => -200, 'max' => 200 ], '%' => [ 'min' => -100, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__deco-circle--1' => 'left: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'circle1_y', [
			'label'      => esc_html__( 'Deco Circle 1 Y Offset (Top)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => -200, 'max' => 200 ], '%' => [ 'min' => -100, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__deco-circle--1' => 'top: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_control( 'deco_circle_1_color', [
			'label'     => esc_html__( 'Deco Circle 1 Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [
				'{{WRAPPER}} .starter-promo__deco-circle--1' => 'background: radial-gradient(circle, {{VALUE}} 0%, rgba(236, 0, 140, 0) 70%);',
			],
		] );
		$this->add_responsive_control( 'circle2_size', [
			'label'      => esc_html__( 'Deco Circle 2 Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 50, 'max' => 500 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__deco-circle--2' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'circle2_x', [
			'label'      => esc_html__( 'Deco Circle 2 X Offset (Right)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => -200, 'max' => 200 ], '%' => [ 'min' => -100, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__deco-circle--2' => 'right: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_responsive_control( 'circle2_y', [
			'label'      => esc_html__( 'Deco Circle 2 Y Offset (Bottom)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => -200, 'max' => 200 ], '%' => [ 'min' => -100, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__deco-circle--2' => 'bottom: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->add_control( 'deco_circle_2_color', [
			'label'     => esc_html__( 'Deco Circle 2 Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--secondary)',
			'selectors' => [
				'{{WRAPPER}} .starter-promo__deco-circle--2' => 'background: radial-gradient(circle, {{VALUE}} 0%, rgba(142, 43, 175, 0) 70%);',
			],
		] );
		$this->add_responsive_control( 'circles_blur', [
			'label'      => esc_html__( 'Deco Circles Blur', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__deco-circle' => 'filter: blur({{SIZE}}px);',
			],
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'style_stats', [
			'label' => esc_html__( 'Stats Block', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );
		$this->add_control( 'stats_bg', [
			'label'     => esc_html__( 'Stats Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'transparent',
			'selectors' => [ '{{WRAPPER}} .starter-promo__stats' => 'background-color: {{VALUE}};' ],
		] );
		$this->add_control( 'stats_border_color', [
			'label'     => esc_html__( 'Stats Border Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#e5e7eb',
			'selectors' => [
				'{{WRAPPER}} .starter-promo__stats' => 'border-color: {{VALUE}};',
				'{{WRAPPER}} .starter-promo__stat--divider' => 'border-color: {{VALUE}};',
			],
		] );
		$this->add_responsive_control( 'stats_padding', [
			'label'      => esc_html__( 'Stats Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__stats' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );
		$this->add_responsive_control( 'stats_radius', [
			'label'      => esc_html__( 'Stats Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-promo__stats' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_control( 'stat_value_color', [
			'label'     => esc_html__( 'Stat Value Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-promo__stat-value' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'stat_value_typography',
			'label'    => esc_html__( 'Stat Value Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__stat-value',
		] );
		$this->add_control( 'stat_label_color', [
			'label'     => esc_html__( 'Stat Label Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#6b7280',
			'selectors' => [ '{{WRAPPER}} .starter-promo__stat-label' => 'color: {{VALUE}};' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'stat_label_typography',
			'label'    => esc_html__( 'Stat Label Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-promo__stat-label',
		] );
		$this->add_control( 'stat_icon_color', [
			'label'     => esc_html__( 'Stat Icon Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-promo__stat-icon' => 'color: {{VALUE}};' ],
		] );
		$this->add_responsive_control( 'stat_icon_size', [
			'label'      => esc_html__( 'Stat Icon Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 12, 'max' => 48 ] ],
			'default'    => [ 'size' => 28, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-promo__stat-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .starter-promo__stat-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .starter-promo__stat-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		wp_enqueue_style( 'starter-starter-promo', STARTER_URL . 'widgets/starter-promo/starter-promo.css', [], STARTER_VERSION );

		$cta_url  = ! empty( $settings['cta_url']['url'] )     ? esc_url( $settings['cta_url']['url'] )     : '#contact';
		$img_url  = ! empty( $settings['promo_image']['url'] ) ? esc_url( $settings['promo_image']['url'] ) : '';

		$row_class = 'starter-promo__row';
		if ( ! empty( $settings['image_position'] ) && 'right' === $settings['image_position'] ) {
			$row_class .= ' starter-promo__row--image-right';
		}
		?>
		<section class="starter-promo">
			<div class="starter-promo__container s-container">
				<div class="<?php echo esc_attr( $row_class ); ?>">

					<!-- Image Column -->
					<div class="starter-promo__col starter-promo__col--image">
						<div class="starter-promo__deco-circle starter-promo__deco-circle--1"></div>
						<div class="starter-promo__deco-circle starter-promo__deco-circle--2"></div>
						
						<div class="starter-promo__image-container">
							<?php if ( $img_url ) : ?>
								<img src="<?php echo $img_url; ?>" alt="Promotion" class="starter-promo__image">
							<?php else : ?>
								<div class="starter-promo__image-placeholder">
									<i class="ri-emotion-happy-line starter-promo__placeholder-icon"></i>
								</div>
							<?php endif; ?>
						</div>
						
						<?php if ( ! empty( $settings['price_amount'] ) ) : ?>
						<div class="starter-promo__price-badge">
							<?php if ( ! empty( $settings['price_prefix'] ) ) : ?>
							<p class="starter-promo__price-prefix"><?php echo esc_html( $settings['price_prefix'] ); ?></p>
							<?php endif; ?>
							<p class="starter-promo__price-amount"><?php echo esc_html( $settings['price_amount'] ); ?></p>
							<?php if ( ! empty( $settings['price_unit'] ) ) : ?>
							<p class="starter-promo__price-unit"><?php echo esc_html( $settings['price_unit'] ); ?></p>
							<?php endif; ?>
						</div>
						<?php endif; ?>
					</div>

					<!-- Content Column -->
					<div class="starter-promo__col starter-promo__col--content">
						<?php if ( ! empty( $settings['badge_text'] ) ) : ?>
						<p class="starter-promo__badge">
							<?php echo esc_html( $settings['badge_text'] ); ?>
						</p>
						<?php endif; ?>

						<h2 class="starter-promo__title">
							<?php echo esc_html( $settings['title_line1'] ?? '' ); ?><br>
							<?php if ( ! empty( $settings['title_highlight'] ) ) : ?>
							<span class="starter-promo__highlight">
								<?php echo esc_html( $settings['title_highlight'] ); ?>
							</span>
							<?php endif; ?>
						</h2>

						<?php if ( ! empty( $settings['description'] ) ) : ?>
						<p class="starter-promo__desc"><?php echo esc_html( $settings['description'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['benefits'] ) ) : ?>
						<ul class="starter-promo__benefits">
							<?php foreach ( $settings['benefits'] as $benefit ) : ?>
							<li class="starter-promo__benefit-item">
								<span class="starter-promo__benefit-icon">
									<?php
									if ( ! empty( $benefit['selected_icon']['value'] ) ) {
										\Elementor\Icons_Manager::render_icon( $benefit['selected_icon'], [ 'aria-hidden' => 'true' ] );
									} elseif ( ! empty( $benefit['icon_class'] ) ) {
										echo '<i class="' . esc_attr( $benefit['icon_class'] ) . '" aria-hidden="true"></i>';
									} else {
										echo '<i class="ri-check-line" aria-hidden="true"></i>';
									}
									?>
								</span>
								<span class="starter-promo__benefit-text">
									<?php echo esc_html( $benefit['text'] ?? '' ); ?>
								</span>
							</li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>

						<?php if ( ! empty( $settings['stats_items'] ) ) : ?>
						<div class="starter-promo__stats">
							<?php foreach ( $settings['stats_items'] as $index => $stat ) :
								$class = 'starter-promo__stat';
								if ( $index === 1 ) {
									$class .= ' starter-promo__stat--divider';
								}
								?>
								<div class="<?php echo esc_attr( $class ); ?>">
									<?php if ( ! empty( $stat['selected_icon']['value'] ) || ! empty( $stat['icon_class'] ) ) : ?>
										<span class="starter-promo__stat-icon hidden sm:inline-flex">
											<?php
											if ( ! empty( $stat['selected_icon']['value'] ) ) {
												\Elementor\Icons_Manager::render_icon( $stat['selected_icon'], [ 'aria-hidden' => 'true' ] );
											} else {
												echo '<i class="' . esc_attr( $stat['icon_class'] ) . '" aria-hidden="true"></i>';
											}
											?>
										</span>
									<?php endif; ?>

									<?php if ( ! empty( $stat['text'] ) ) : ?>
										<p class="starter-promo__stat-value">
											<?php echo esc_html( $stat['text'] ); ?>
										</p>
									<?php endif; ?>

									<?php if ( ! empty( $stat['subtitle'] ) ) : ?>
										<p class="starter-promo__stat-label">
											<?php echo esc_html( $stat['subtitle'] ); ?>
										</p>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>

						<?php if ( ! empty( $settings['cta_text'] ) ) : ?>
						<a href="<?php echo $cta_url; ?>" class="starter-promo__cta">
							<i class="ri-calendar-line starter-promo__cta-icon"></i>
							<span class="starter-promo__cta-text"><?php echo esc_html( $settings['cta_text'] ); ?></span>
						</a>
						<?php endif; ?>
					</div>

				</div>
			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<section class="starter-promo">
			<div class="starter-promo__container s-container">
				<div class="starter-promo__row<# if ( settings.image_position === 'right' ) { #> starter-promo__row--image-right<# } #>">

					<!-- Image Column -->
					<div class="starter-promo__col starter-promo__col--image">
						<div class="starter-promo__deco-circle starter-promo__deco-circle--1"></div>
						<div class="starter-promo__deco-circle starter-promo__deco-circle--2"></div>
						
						<div class="starter-promo__image-container">
							<# if ( settings.promo_image.url ) { #>
								<img src="{{ settings.promo_image.url }}" alt="Promotion" class="starter-promo__image">
							<# } else { #>
								<div class="starter-promo__image-placeholder">
									<i class="ri-emotion-happy-line starter-promo__placeholder-icon"></i>
								</div>
							<# } #>
						</div>
						<# if ( settings.price_amount ) { #>
						<div class="starter-promo__price-badge">
							<# if ( settings.price_prefix ) { #>
							<p class="starter-promo__price-prefix">{{{ settings.price_prefix }}}</p>
							<# } #>
							<p class="starter-promo__price-amount">{{{ settings.price_amount }}}</p>
							<# if ( settings.price_unit ) { #>
							<p class="starter-promo__price-unit">{{{ settings.price_unit }}}</p>
							<# } #>
						</div>
						<# } #>
					</div>

					<!-- Content Column -->
					<div class="starter-promo__col starter-promo__col--content">
						<# if ( settings.badge_text ) { #>
						<p class="starter-promo__badge">
							{{{ settings.badge_text }}}
						</p>
						<# } #>

						<h2 class="starter-promo__title">
							{{{ settings.title_line1 }}}<br>
							<# if ( settings.title_highlight ) { #>
							<span class="starter-promo__highlight">
								{{{ settings.title_highlight }}}
							</span>
							<# } #>
						</h2>

						<# if ( settings.description ) { #>
						<p class="starter-promo__desc">{{{ settings.description }}}</p>
						<# } #>

						<# if ( settings.benefits && settings.benefits.length ) { #>
						<ul class="starter-promo__benefits">
							<# _.each( settings.benefits, function( benefit ) { #>
							<#
							var iconHtml = '';
							if ( benefit.selected_icon && benefit.selected_icon.value ) {
								var iconRender = elementor.helpers.renderIcon( view, benefit.selected_icon, { 'aria-hidden': true }, 'i', 'object' );
								if ( iconRender && iconRender.value ) {
									iconHtml = iconRender.value;
								}
							} else if ( benefit.icon_class ) {
								iconHtml = '<i class="' + benefit.icon_class + '" aria-hidden="true"></i>';
							} else {
								iconHtml = '<i class="ri-check-line" aria-hidden="true"></i>';
							}
							#>
							<li class="starter-promo__benefit-item">
								<span class="starter-promo__benefit-icon">
									{{{ iconHtml }}}
								</span>
								<span class="starter-promo__benefit-text">
									{{{ benefit.text }}}
								</span>
							</li>
							<# } ); #>
						</ul>
						<# } #>

						<# if ( settings.stats_items && settings.stats_items.length ) { #>
						<div class="starter-promo__stats">
							<# _.each( settings.stats_items, function( stat, index ) { 
								var statClass = 'starter-promo__stat';
								if ( index === 1 ) {
									statClass += ' starter-promo__stat--divider';
								}
								
								var iconHtml = '';
								if ( stat.selected_icon && stat.selected_icon.value ) {
									var iconRender = elementor.helpers.renderIcon( view, stat.selected_icon, { 'aria-hidden': true }, 'i', 'object' );
									if ( iconRender && iconRender.value ) {
										iconHtml = iconRender.value;
									}
								} else if ( stat.icon_class ) {
									iconHtml = '<i class="' + stat.icon_class + '" aria-hidden="true"></i>';
								}
							#>
							<div class="{{ statClass }}">
								<# if ( iconHtml ) { #>
									<span class="starter-promo__stat-icon hidden sm:inline-flex">
										{{{ iconHtml }}}
									</span>
								<# } #>

								<# if ( stat.text ) { #>
									<p class="starter-promo__stat-value">
										{{{ stat.text }}}
									</p>
								<# } #>

								<# if ( stat.subtitle ) { #>
									<p class="starter-promo__stat-label">
										{{{ stat.subtitle }}}
									</p>
								<# } #>
							</div>
							<# } ); #>
						</div>
						<# } #>

						<# if ( settings.cta_text ) { #>
						<a href="{{ settings.cta_url.url || '#contact' }}" class="starter-promo__cta">
							<i class="ri-calendar-line starter-promo__cta-icon"></i>
							<span class="starter-promo__cta-text">{{{ settings.cta_text }}}</span>
						</a>
						<# } #>
					</div>

				</div>
			</div>
		</section>
		<?php
	}
}

add_action( 'wp_enqueue_scripts', function() {
	wp_register_style(  'starter-starter-promo', STARTER_URL . 'widgets/starter-promo/starter-promo.css', [], STARTER_VERSION );
	wp_register_script( 'starter-starter-promo', STARTER_URL . 'widgets/starter-promo/starter-promo.js',  [], STARTER_VERSION, true );
} );
add_action( 'elementor/editor/before_enqueue_scripts', function() {
	wp_enqueue_style( 'starter-starter-promo', STARTER_URL . 'widgets/starter-promo/starter-promo.css', [], STARTER_VERSION );
} );
