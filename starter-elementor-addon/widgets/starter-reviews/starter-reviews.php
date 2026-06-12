<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class STARTER_Widget_starter_Reviews extends \Elementor\Widget_Base {

	public function get_name()       { return 'starter-reviews'; }
	public function get_title()      { return esc_html__( 'KU Reviews / Testimonials', 'starter-elementor-addon' ); }
	public function get_icon()       { return 'eicon-testimonial'; }
	public function get_categories() { return [ 'starter-elementor-addon' ]; }
	public function get_keywords()   { return [ 'reviews', 'testimonials', 'rating', 'dental' ]; }

	public function get_style_depends()  { return [ 'starter-starter-reviews' ]; }
	public function get_script_depends() { return [ 'starter-starter-reviews' ]; }

	protected function register_controls() {

		// CONTENT TAB: Header Section
		$this->start_controls_section( 'section_header', [
			'label' => esc_html__( 'Header', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'badge_text', [
			'label'   => esc_html__( 'Badge Text', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'รีวิวจากลูกค้า',
		] );

		$this->add_control( 'title', [
			'label'   => esc_html__( 'Title', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'รีวิวจากผู้รับบริการ',
		] );

		$this->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'ความประทับใจจากผู้ที่ไว้วางใจเรา',
		] );

		$this->add_responsive_control( 'header_align', [
			'label'     => esc_html__( 'Alignment', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::CHOOSE,
			'options'   => [
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
			'default'   => 'center',
			'selectors' => [
				'{{WRAPPER}} .starter-reviews__header' => 'text-align: {{VALUE}};',
			],
		] );

		$this->end_controls_section();

		// CONTENT TAB: Reviews Repeater Section
		$this->start_controls_section( 'section_reviews', [
			'label' => esc_html__( 'Reviews', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'reviewer_name', [
			'label'   => esc_html__( 'Reviewer Name', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'คุณลูกค้า',
		] );

		$repeater->add_control( 'avatar_image', [
			'label'   => esc_html__( 'Avatar Image', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => '' ],
		] );

		$repeater->add_control( 'verified_text', [
			'label'   => esc_html__( 'Verified Text', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => function_exists( 'cttm_text' ) ? cttm_text( 'ลูกค้าจริง ✓', 'Verified Client ✓' ) : 'ลูกค้าจริง ✓',
		] );

		$repeater->add_control( 'review_text', [
			'label'   => esc_html__( 'Review Text', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'บริการดีมาก คุณหมอใจดีมาก',
		] );

		$repeater->add_control( 'stars', [
			'label'   => esc_html__( 'Stars (1-5)', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'min'     => 1,
			'max'     => 5,
			'default' => 5,
		] );

		$this->add_control( 'reviews', [
			'label'       => esc_html__( 'Reviews', 'starter-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'reviewer_name' => 'คุณกนกพร',
					'review_text'   => 'บริการดีมาก คุณหมอใจดีมาก ทำให้รู้สึกผ่อนคลาย ไม่กลัวทันตแพทย์อีกต่อไปแล้ว',
					'stars'         => 5,
					'verified_text' => 'ลูกค้าจริง ✓',
				],
				[
					'reviewer_name' => 'คุณปฎิภาณ',
					'review_text'   => 'คลินิกสะอาด อุปกรณ์ทันสมัย บริการประทับใจมาก จัดฟันใสเห็นผลชัดเจนภายใน 3 เดือน',
					'stars'         => 5,
					'verified_text' => 'ลูกค้าจริง ✓',
				],
				[
					'reviewer_name' => 'คุณรภัทร',
					'review_text'   => 'ทีมงานดูแลเอาใจใส่ ราคาคุ้มค่า แนะนำให้ทุกคนที่กำลังมองหาคลินิกทันตกรรมดีๆ',
					'stars'         => 5,
					'verified_text' => 'ลูกค้าจริง ✓',
				],
			],
			'title_field' => '{{{ reviewer_name }}}',
		] );

		$this->end_controls_section();

		// CONTENT TAB: Slider Options Section
		$this->start_controls_section( 'section_slider_options', [
			'label' => esc_html__( 'Slider Options', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_responsive_control( 'slides_per_view', [
			'label'   => esc_html__( 'Slides Per View', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'options' => [
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
			],
			'default'        => '3',
			'tablet_default' => '2',
			'mobile_default' => '1',
		] );

		$this->add_control( 'autoplay', [
			'label'        => esc_html__( 'Autoplay', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'No', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'autoplay_delay', [
			'label'     => esc_html__( 'Autoplay Delay (ms)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 5000,
			'condition' => [
				'autoplay' => 'yes',
			],
		] );

		$this->add_control( 'loop', [
			'label'        => esc_html__( 'Infinite Loop', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'No', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'show_navigation', [
			'label'        => esc_html__( 'Show Navigation Arrows', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'No', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'show_pagination', [
			'label'        => esc_html__( 'Show Pagination Dots', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'No', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->end_controls_section();

		// STYLE TAB: Section Container
		$this->start_controls_section( 'style_section', [
			'label' => esc_html__( 'Section Container', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'section_padding', [
			'label'      => esc_html__( 'Section Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem', '%' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'section_margin', [
			'label'      => esc_html__( 'Section Margin', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem', '%' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'section_bg', [
			'label'     => esc_html__( 'Section Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-reviews' => 'background-color: {{VALUE}};' ],
		] );

		$this->end_controls_section();

		// STYLE TAB: Header
		$this->start_controls_section( 'style_header', [
			'label' => esc_html__( 'Header', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'badge_color', [
			'label'     => esc_html__( 'Badge Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__badge' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'badge_typography',
			'label'    => esc_html__( 'Badge Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-reviews__badge',
		] );

		$this->add_responsive_control( 'badge_margin_bottom', [
			'label'      => esc_html__( 'Badge Margin Bottom', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__badge' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Title Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#111827',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__title' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'label'    => esc_html__( 'Title Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-reviews__title',
		] );

		$this->add_responsive_control( 'title_margin_bottom', [
			'label'      => esc_html__( 'Title Margin Bottom', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'description_color', [
			'label'     => esc_html__( 'Description Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#9ca3af',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__desc' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'description_typography',
			'label'    => esc_html__( 'Description Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-reviews__desc',
		] );

		$this->add_responsive_control( 'header_margin_bottom', [
			'label'      => esc_html__( 'Header Area Margin Bottom', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__header' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
			'default'    => [ 'size' => 48, 'unit' => 'px' ],
		] );

		$this->end_controls_section();

		// STYLE TAB: Card Container
		$this->start_controls_section( 'style_card', [
			'label' => esc_html__( 'Card Container', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->start_controls_tabs( 'tabs_card_style' );

		$this->start_controls_tab( 'tab_card_normal', [
			'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'card_bg', [
			'label'     => esc_html__( 'Card Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#f9fafb',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__card' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'card_box_shadow',
			'label'    => esc_html__( 'Card Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-reviews__card',
		] );

		$this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
			'name'     => 'card_border',
			'label'    => esc_html__( 'Card Border', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-reviews__card',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_card_hover', [
			'label' => esc_html__( 'Hover', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'card_bg_hover', [
			'label'     => esc_html__( 'Card Background (Hover)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-reviews__card:hover' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'card_box_shadow_hover',
			'label'    => esc_html__( 'Card Box Shadow (Hover)', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-reviews__card:hover',
		] );

		$this->add_control( 'card_border_color_hover', [
			'label'     => esc_html__( 'Border Color (Hover)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-reviews__card:hover' => 'border-color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control( 'card_padding', [
			'label'      => esc_html__( 'Card Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			'separator'  => 'before',
		] );

		$this->add_responsive_control( 'card_border_radius', [
			'label'      => esc_html__( 'Card Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__card' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_gap', [
			'label'      => esc_html__( 'Card Gap', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 48 ] ],
			'default'    => [ 'size' => 24, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__swiper' => '--swiper-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'quote_icon_heading', [
			'label'     => esc_html__( 'Quote Icon Decoration', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'quote_icon_color', [
			'label'     => esc_html__( 'Quote Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(236, 0, 140, 0.08)',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__quote-icon' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'quote_icon_hover_color', [
			'label'     => esc_html__( 'Quote Color (Hover)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(236, 0, 140, 0.15)',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__card:hover .starter-reviews__quote-icon' => 'color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'quote_icon_size', [
			'label'      => esc_html__( 'Quote Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem', 'em' ],
			'range'      => [
				'px'  => [ 'min' => 10, 'max' => 120 ],
				'rem' => [ 'min' => 1, 'max' => 8 ],
			],
			'default'    => [ 'size' => 3, 'unit' => 'rem' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__quote-icon' => 'font-size: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'quote_icon_x', [
			'label'      => esc_html__( 'Quote Offset X (Right)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem', '%' ],
			'range'      => [
				'px' => [ 'min' => 0, 'max' => 150 ],
			],
			'default'    => [ 'size' => 24, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__quote-icon' => 'right: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'quote_icon_y', [
			'label'      => esc_html__( 'Quote Offset Y (Top)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem', '%' ],
			'range'      => [
				'px' => [ 'min' => 0, 'max' => 150 ],
			],
			'default'    => [ 'size' => 24, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__quote-icon' => 'top: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// STYLE TAB: Review Content
		$this->start_controls_section( 'style_review', [
			'label' => esc_html__( 'Review Content', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'star_settings_heading', [
			'label' => esc_html__( 'Star Ratings', 'starter-elementor-addon' ),
			'type'  => \Elementor\Controls_Manager::HEADING,
		] );

		$this->add_responsive_control( 'star_align', [
			'label'     => esc_html__( 'Star Alignment', 'starter-elementor-addon' ),
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
			'default'   => 'flex-start',
			'selectors' => [
				'{{WRAPPER}} .starter-reviews__stars' => 'justify-content: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'star_size', [
			'label'      => esc_html__( 'Star Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [
				'px' => [ 'min' => 10, 'max' => 48 ],
			],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__stars i' => 'font-size: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'star_spacing', [
			'label'      => esc_html__( 'Star Spacing', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [
				'px' => [ 'min' => 0, 'max' => 16 ],
			],
			'default'    => [ 'size' => 4, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__stars' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'star_margin_bottom', [
			'label'      => esc_html__( 'Star Margin Bottom', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__stars' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'star_color', [
			'label'     => esc_html__( 'Star Color (Active)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#fbbf24',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__stars .ri-star-fill' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'star_empty_color', [
			'label'     => esc_html__( 'Star Color (Empty)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#d1d5db',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__stars .ri-star-line' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'review_text_heading', [
			'label'     => esc_html__( 'Review Text', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'review_text_color', [
			'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#6b7280',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__text' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'review_text_typography',
			'label'    => esc_html__( 'Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-reviews__text',
		] );

		$this->add_responsive_control( 'review_text_margin_bottom', [
			'label'      => esc_html__( 'Text Margin Bottom', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'size' => 20, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__text' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// STYLE TAB: Reviewer Info & Badge
		$this->start_controls_section( 'style_reviewer_info', [
			'label' => esc_html__( 'Reviewer Info & Badge', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'reviewer_avatar_heading', [
			'label' => esc_html__( 'Avatar Frame', 'starter-elementor-addon' ),
			'type'  => \Elementor\Controls_Manager::HEADING,
		] );

		$this->add_responsive_control( 'avatar_size', [
			'label'      => esc_html__( 'Avatar Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [
				'px' => [ 'min' => 20, 'max' => 100 ],
			],
			'default'    => [ 'size' => 40, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-reviews__avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'avatar_bg', [
			'label'     => esc_html__( 'Fallback Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'linear-gradient(135deg, var(--color-primary, #EC008C), var(--secondary, #8E2BAF))',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__avatar' => 'background: {{VALUE}};' ],
		] );

		$this->add_control( 'avatar_text_color', [
			'label'     => esc_html__( 'Fallback Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__avatar' => 'color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'avatar_border_radius', [
			'label'      => esc_html__( 'Avatar Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__avatar' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );
		$this->add_control( 'avatar_object_fit', [
			'label'     => esc_html__( 'Avatar Image Fit', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'cover',
			'options'   => [
				'cover'   => esc_html__( 'Cover (Crop)', 'starter-elementor-addon' ),
				'contain' => esc_html__( 'Contain (Fit)', 'starter-elementor-addon' ),
				'fill'    => esc_html__( 'Fill (Stretch)', 'starter-elementor-addon' ),
			],
			'selectors' => [ '{{WRAPPER}} .starter-reviews__avatar-img' => '--avatar-img-fit: {{VALUE}};' ],
		] );
		$this->add_responsive_control( 'avatar_object_position_x', [
			'label'      => esc_html__( 'Avatar Focus X (%)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__avatar-img' => '--avatar-img-x: {{SIZE}}%;' ],
		] );
		$this->add_responsive_control( 'avatar_object_position_y', [
			'label'      => esc_html__( 'Avatar Focus Y (%)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [ '{{WRAPPER}} .starter-reviews__avatar-img' => '--avatar-img-y: {{SIZE}}%;' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'avatar_box_shadow',
			'label'    => esc_html__( 'Avatar Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-reviews__avatar',
		] );

		$this->add_control( 'reviewer_name_heading', [
			'label'     => esc_html__( 'Name Typography & Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'reviewer_name_color', [
			'label'     => esc_html__( 'Name Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#1f2937',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__name' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'reviewer_name_typography',
			'label'    => esc_html__( 'Name Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-reviews__name',
		] );

		$this->add_control( 'reviewer_verified_heading', [
			'label'     => esc_html__( 'Verified Badge Style', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'verified_text_color', [
			'label'     => esc_html__( 'Badge Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#9ca3af',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__verified' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'verified_typography',
			'label'    => esc_html__( 'Badge Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-reviews__verified',
		] );

		$this->add_control( 'verified_bg_color', [
			'label'     => esc_html__( 'Badge Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-reviews__verified' => 'background-color: {{VALUE}}; padding: 2px 6px; border-radius: 4px; display: inline-block;' ],
		] );

		$this->end_controls_section();

		// STYLE TAB: Navigation & Pagination
		$this->start_controls_section( 'style_navigation', [
			'label' => esc_html__( 'Navigation & Pagination', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'heading_navigation', [
			'label' => esc_html__( 'Navigation Arrows', 'starter-elementor-addon' ),
			'type'  => \Elementor\Controls_Manager::HEADING,
		] );

		$this->add_responsive_control( 'nav_button_size', [
			'label'      => esc_html__( 'Button Container Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 24, 'max' => 80 ] ],
			'default'    => [ 'size' => 48, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-reviews__button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'nav_arrow_size', [
			'label'      => esc_html__( 'Arrow Icon Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 40 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-reviews__button i' => 'font-size: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->start_controls_tabs( 'tabs_nav_button_style' );

		$this->start_controls_tab( 'tab_nav_button_normal', [
			'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'nav_button_color', [
			'label'     => esc_html__( 'Arrow Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#6b7280',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__button' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'nav_button_bg', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-reviews__button' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'nav_button_border_color', [
			'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#e5e7eb',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__button' => 'border-color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_nav_button_hover', [
			'label' => esc_html__( 'Hover', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'nav_button_hover_color', [
			'label'     => esc_html__( 'Arrow Hover Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__button:hover' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'nav_button_hover_bg', [
			'label'     => esc_html__( 'Background Hover Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#EC008C',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__button:hover' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'nav_button_hover_border', [
			'label'     => esc_html__( 'Border Hover Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#EC008C',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__button:hover' => 'border-color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control( 'heading_pagination', [
			'label'     => esc_html__( 'Pagination Dots', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'pagination_color', [
			'label'     => esc_html__( 'Dots Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-reviews__pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'pagination_active_color', [
			'label'     => esc_html__( 'Active Dot Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#EC008C',
			'selectors' => [ '{{WRAPPER}} .starter-reviews__pagination .swiper-pagination-bullet-active' => 'background-color: {{VALUE}} !important;' ],
		] );

		$this->add_responsive_control( 'pagination_dot_size', [
			'label'      => esc_html__( 'Dot Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 4, 'max' => 16 ] ],
			'default'    => [ 'size' => 8, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-reviews__pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		wp_enqueue_style( 'starter-starter-reviews', STARTER_URL . 'widgets/starter-reviews/starter-reviews.css', [], STARTER_VERSION );
		wp_enqueue_script( 'starter-starter-reviews', STARTER_URL . 'widgets/starter-reviews/starter-reviews.js', [], STARTER_VERSION, true );

		// Dynamic Swiper Configurations
		$slides_per_view        = isset( $settings['slides_per_view'] ) ? intval( $settings['slides_per_view'] ) : 3;
		$slides_per_view_tablet = isset( $settings['slides_per_view_tablet'] ) ? intval( $settings['slides_per_view_tablet'] ) : 2;
		$slides_per_view_mobile = isset( $settings['slides_per_view_mobile'] ) ? intval( $settings['slides_per_view_mobile'] ) : 1;

		$autoplay_enabled = ( $settings['autoplay'] === 'yes' );
		$loop_enabled     = ( $settings['loop'] === 'yes' );

		$swiper_config = [
			'slidesPerView' => $slides_per_view_mobile,
			'spaceBetween'  => isset( $settings['card_gap']['size'] ) ? intval( $settings['card_gap']['size'] ) : 24,
			'breakpoints'   => [
				'768'  => [
					'slidesPerView' => $slides_per_view_tablet,
				],
				'1024' => [
					'slidesPerView' => $slides_per_view,
				],
			],
			'loop'          => $loop_enabled,
		];

		if ( $autoplay_enabled ) {
			$swiper_config['autoplay'] = [
				'delay'                => isset( $settings['autoplay_delay'] ) ? intval( $settings['autoplay_delay'] ) : 5000,
				'disableOnInteraction' => false,
			];
		} else {
			$swiper_config['autoplay'] = false;
		}

		if ( $settings['show_pagination'] === 'yes' ) {
			$swiper_config['pagination'] = [
				'el'        => '.starter-reviews__pagination',
				'clickable' => true,
			];
		}

		if ( $settings['show_navigation'] === 'yes' ) {
			$swiper_config['navigation'] = [
				'nextEl' => '.starter-reviews__button--next',
				'prevEl' => '.starter-reviews__button--prev',
			];
		}

		$swiper_config_json = json_encode( $swiper_config );
		?>
		<section class="starter-reviews">
			<div class="starter-reviews__container s-container">

				<div class="starter-reviews__header">
					<?php if ( ! empty( $settings['badge_text'] ) ) : ?>
						<p class="starter-reviews__badge">
							<?php echo esc_html( $settings['badge_text'] ); ?>
						</p>
					<?php endif; ?>
					
					<?php if ( ! empty( $settings['title'] ) ) : ?>
						<h2 class="starter-reviews__title">
							<?php echo esc_html( $settings['title'] ); ?>
						</h2>
					<?php endif; ?>
					
					<?php if ( ! empty( $settings['description'] ) ) : ?>
						<p class="starter-reviews__desc">
							<?php echo esc_html( $settings['description'] ); ?>
						</p>
					<?php endif; ?>
				</div>

				<?php if ( ! empty( $settings['reviews'] ) ) : ?>
				<div class="starter-reviews__swiper swiper" data-swiper-config='<?php echo esc_attr( $swiper_config_json ); ?>'>
					<div class="swiper-wrapper">
						<?php foreach ( $settings['reviews'] as $review ) :
							$stars      = intval( $review['stars'] ?? 5 );
							$stars      = max( 1, min( 5, $stars ) );
							$name       = $review['reviewer_name'] ?? '';
							$avatar     = $review['avatar_image'] ?? null;
							$has_avatar = ! empty( $avatar['url'] );

							$clean_name = preg_replace( '/^คุณ/', '', $name );
							$letter     = mb_substr( $clean_name, 0, 1 );
						?>
						<div class="swiper-slide">
							<div class="starter-reviews__card">
								<!-- Floating Background Quote Decoration -->
								<div class="starter-reviews__quote-icon">
									<i class="ri-double-quotes-r"></i>
								</div>

								<!-- Rating Stars -->
								<div class="starter-reviews__stars">
									<?php for ( $s = 0; $s < $stars; $s++ ) : ?>
										<i class="ri-star-fill starter-reviews__star starter-reviews__star--active"></i>
									<?php endfor; ?>
									<?php for ( $s = $stars; $s < 5; $s++ ) : ?>
										<i class="ri-star-line starter-reviews__star starter-reviews__star--empty"></i>
									<?php endfor; ?>
								</div>

								<!-- Review Text -->
								<p class="starter-reviews__text">
									"<?php echo esc_html( $review['review_text'] ?? '' ); ?>"
								</p>

								<!-- Reviewer Info Meta -->
								<div class="starter-reviews__meta">
									<div class="starter-reviews__avatar">
										<?php if ( $has_avatar ) : ?>
											<img class="starter-reviews__avatar-img" src="<?php echo esc_url( $avatar['url'] ); ?>" alt="<?php echo esc_attr( $name ); ?>">
										<?php else : ?>
											<span class="starter-reviews__avatar-text"><?php echo esc_html( $letter ); ?></span>
										<?php endif; ?>
									</div>
									<div class="starter-reviews__author">
										<p class="starter-reviews__name"><?php echo esc_html( $name ); ?></p>
										<?php if ( ! empty( $review['verified_text'] ) ) : ?>
											<span class="starter-reviews__verified"><?php echo esc_html( $review['verified_text'] ); ?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
					</div>

					<?php if ( $settings['show_pagination'] === 'yes' ) : ?>
						<div class="starter-reviews__pagination swiper-pagination"></div>
					<?php endif; ?>

					<?php if ( $settings['show_navigation'] === 'yes' ) : ?>
						<div class="starter-reviews__navigation">
							<button class="starter-reviews__button starter-reviews__button--prev swiper-button-prev">
								<i class="ri-arrow-left-line"></i>
							</button>
							<button class="starter-reviews__button starter-reviews__button--next swiper-button-next">
								<i class="ri-arrow-right-line"></i>
							</button>
						</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<section class="starter-reviews">
			<div class="starter-reviews__container s-container">

				<div class="starter-reviews__header">
					<# if ( settings.badge_text ) { #>
					<p class="starter-reviews__badge">
						{{{ settings.badge_text }}}
					</p>
					<# } #>
					<h2 class="starter-reviews__title">
						{{{ settings.title }}}
					</h2>
					<# if ( settings.description ) { #>
					<p class="starter-reviews__desc">
						{{{ settings.description }}}
					</p>
					<# } #>
				</div>

				<# if ( settings.reviews && settings.reviews.length ) { #>
				<#
				var slidesPerView       = settings.slides_per_view || 3;
				var slidesPerViewTablet = settings.slides_per_view_tablet || 2;
				var slidesPerViewMobile = settings.slides_per_view_mobile || 1;
				
				var cardGap = ( settings.card_gap && settings.card_gap.size ) ? parseInt( settings.card_gap.size ) : 24;
				
				var swiperConfig = {
					slidesPerView: parseInt( slidesPerViewMobile ),
					spaceBetween: cardGap,
					breakpoints: {
						768: { slidesPerView: parseInt( slidesPerViewTablet ) },
						1024: { slidesPerView: parseInt( slidesPerView ) }
					},
					loop: settings.loop === 'yes'
				};
				
				if ( settings.autoplay === 'yes' ) {
					swiperConfig.autoplay = {
						delay: parseInt( settings.autoplay_delay || 5000 ),
						disableOnInteraction: false
					};
				} else {
					swiperConfig.autoplay = false;
				}
				
				if ( settings.show_pagination === 'yes' ) {
					swiperConfig.pagination = {
						el: '.starter-reviews__pagination',
						clickable: true
					};
				}
				
				if ( settings.show_navigation === 'yes' ) {
					swiperConfig.navigation = {
						nextEl: '.starter-reviews__button--next',
						prevEl: '.starter-reviews__button--prev'
					};
				}
				
				var swiperConfigStr = JSON.stringify( swiperConfig );
				#>
				<div class="starter-reviews__swiper swiper" data-swiper-config='{{{ swiperConfigStr }}}'>
					<div class="swiper-wrapper">
						<# _.each( settings.reviews, function( review ) {
							var stars     = Math.max( 1, Math.min( 5, review.stars || 5 ) );
							var name      = review.reviewer_name || '';
							var cleanName = name.replace( /^คุณ/, '' );
							var letter    = cleanName.substring( 0, 1 );
							var hasAvatar = review.avatar_image && review.avatar_image.url;
						#>
						<div class="swiper-slide">
							<div class="starter-reviews__card">
								<!-- Floating Background Quote Decoration -->
								<div class="starter-reviews__quote-icon">
									<i class="ri-double-quotes-r"></i>
								</div>

								<!-- Rating Stars -->
								<div class="starter-reviews__stars">
									<# for ( var s = 0; s < stars; s++ ) { #>
										<i class="ri-star-fill starter-reviews__star starter-reviews__star--active"></i>
									<# } #>
									<# for ( var s = stars; s < 5; s++ ) { #>
										<i class="ri-star-line starter-reviews__star starter-reviews__star--empty"></i>
									<# } #>
								</div>

								<!-- Review Text -->
								<p class="starter-reviews__text">
									"{{{ review.review_text }}}"
								</p>

								<!-- Reviewer Info Meta -->
								<div class="starter-reviews__meta">
									<div class="starter-reviews__avatar">
										<# if ( hasAvatar ) { #>
											<img class="starter-reviews__avatar-img" src="{{{ review.avatar_image.url }}}" alt="{{{ name }}}">
										<# } else { #>
											<span class="starter-reviews__avatar-text">{{{ letter }}}</span>
										<# } #>
									</div>
									<div class="starter-reviews__author">
										<p class="starter-reviews__name">{{{ name }}}</p>
										<# if ( review.verified_text ) { #>
											<span class="starter-reviews__verified">{{{ review.verified_text }}}</span>
										<# } #>
									</div>
								</div>
							</div>
						</div>
						<# } ); #>
					</div>

					<# if ( settings.show_pagination === 'yes' ) { #>
					<div class="starter-reviews__pagination swiper-pagination"></div>
					<# } #>

					<# if ( settings.show_navigation === 'yes' ) { #>
					<div class="starter-reviews__navigation">
						<button class="starter-reviews__button starter-reviews__button--prev swiper-button-prev">
							<i class="ri-arrow-left-line"></i>
						</button>
						<button class="starter-reviews__button starter-reviews__button--next swiper-button-next">
							<i class="ri-arrow-right-line"></i>
						</button>
					</div>
					<# } #>
				</div>
				<# } #>

			</div>
		</section>
		<?php
	}
}

add_action( 'wp_enqueue_scripts', function() {
	wp_register_style(  'starter-starter-reviews', STARTER_URL . 'widgets/starter-reviews/starter-reviews.css', [], STARTER_VERSION );
	wp_register_script( 'starter-starter-reviews', STARTER_URL . 'widgets/starter-reviews/starter-reviews.js',  [], STARTER_VERSION, true );
} );
add_action( 'elementor/editor/before_enqueue_scripts', function() {
	wp_enqueue_style( 'starter-starter-reviews', STARTER_URL . 'widgets/starter-reviews/starter-reviews.css', [], STARTER_VERSION );
} );
