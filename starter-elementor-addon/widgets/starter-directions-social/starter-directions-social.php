<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor KU Directions & Social Info Widget
 */
class STARTER_Widget_starter_Directions_Social extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 */
	public function get_name() {
		return 'starter-directions-social';
	}

	/**
	 * Get widget title
	 */
	public function get_title() {
		return esc_html__( 'KU Directions & Social Info', 'starter-elementor-addon' );
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
		return [ 'directions', 'travel', 'social', 'contact', 'how to get here', 'clinic', 'list', 'icons', 'links', 'map', 'google maps', 'subtitle', 'content' ];
	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'starter-starter-directions-social' ];
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
			'widget_subtitle',
			[
				'label'       => esc_html__( 'Subtitle Text', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'เดินทางสะดวกสบาย', 'starter-elementor-addon' ),
				'label_block' => true,
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
				'label'       => esc_html__( 'Title Text', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'การเดินทาง', 'starter-elementor-addon' ),
				'label_block' => true,
				'condition'   => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'widget_content',
			[
				'label'       => esc_html__( 'Content Description', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__( 'รายละเอียดเพิ่มเติมเกี่ยวกับการเดินทางมายังคลินิกของเรา...', 'starter-elementor-addon' ),
				'label_block' => true,
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
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->end_controls_section();

		// =====================================================
		// CONTENT TAB - Map Button Section
		// =====================================================
		$this->start_controls_section(
			'section_map_btn',
			[
				'label' => esc_html__( 'Map Button', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_map_btn',
			[
				'label'     => esc_html__( 'Show Map Button', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'starter-elementor-addon' ),
				'label_off' => esc_html__( 'Hide', 'starter-elementor-addon' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'map_btn_text',
			[
				'label'       => esc_html__( 'Button Text', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'ดูแผนที่ Google Maps', 'starter-elementor-addon' ),
				'label_block' => true,
				'condition'   => [
					'show_map_btn' => 'yes',
				],
			]
		);

		$this->add_control(
			'map_btn_icon',
			[
				'label'       => esc_html__( 'Button Icon', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-map-marker-alt',
					'library' => 'fa-solid',
				],
				'condition'   => [
					'show_map_btn' => 'yes',
				],
			]
		);

		$this->add_control(
			'map_btn_link',
			[
				'label'       => esc_html__( 'Link URL', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://maps.google.com/...', 'starter-elementor-addon' ),
				'default'     => [
					'url'         => '#',
					'is_external' => true,
				],
				'label_block' => true,
				'condition'   => [
					'show_map_btn' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// CONTENT TAB - Social Repeater List
		// =====================================================
		$this->start_controls_section(
			'section_social',
			[
				'label' => esc_html__( 'Social Links Items', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

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
				'label'       => esc_html__( 'Social Icon', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'default'     => [
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
				'placeholder' => esc_html__( 'https://your-link.com', 'starter-elementor-addon' ),
				'default'     => [
					'url' => '#',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'social_list',
			[
				'label'       => esc_html__( 'Social Items', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $social_repeater->get_controls(),
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
				'title_field' => '{{{ social_text }}}',
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
					'{{WRAPPER}} .starter-starter-directions-social__card' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .starter-starter-directions-social__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .starter-starter-directions-social__card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .starter-starter-directions-social__card',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .starter-starter-directions-social__card',
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Header (Subtitle, Title, Content) Style
		// =====================================================
		$this->start_controls_section(
			'style_header',
			[
				'label' => esc_html__( 'Widget Header Styles', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Subtitle Styles
		$this->add_control(
			'heading_subtitle_style',
			[
				'label'     => esc_html__( 'Subtitle Style', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'var(--color-primary, #EA4F89)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions-social__subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .starter-starter-directions-social__subtitle',
				'fields_options' => [
					'font_weight' => [ 'default' => '600' ],
					'font_size'   => [ 'default' => [ 'size' => 14, 'unit' => 'px' ] ],
				],
			]
		);

		$this->add_responsive_control(
			'subtitle_margin',
			[
				'label'      => esc_html__( 'Subtitle Bottom Spacing', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'size' => 6, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions-social__subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Title Styles
		$this->add_control(
			'heading_title_style',
			[
				'label'     => esc_html__( 'Title Style', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
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
					'{{WRAPPER}} .starter-starter-directions-social__main-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .starter-starter-directions-social__main-title',
				'fields_options' => [
					'font_weight' => [ 'default' => '700' ],
					'font_size'   => [ 'default' => [ 'size' => 22, 'unit' => 'px' ] ],
				],
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Title Bottom Spacing', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'size' => 12, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions-social__main-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		// Content Styles
		$this->add_control(
			'heading_content_style',
			[
				'label'     => esc_html__( 'Content Description Style', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Content Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions-social__header-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .starter-starter-directions-social__header-content',
				'fields_options' => [
					'font_weight' => [ 'default' => '400' ],
					'font_size'   => [ 'default' => [ 'size' => 14, 'unit' => 'px' ] ],
					'line_height' => [ 'default' => [ 'size' => 1.6, 'unit' => 'em' ] ],
				],
			]
		);

		$this->add_responsive_control(
			'content_margin',
			[
				'label'      => esc_html__( 'Content Bottom Spacing', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'size' => 24, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions-social__header-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .starter-starter-directions-social__icon-wrap' => 'color: {{VALUE}}; fill: {{VALUE}};',
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
					'{{WRAPPER}} .starter-starter-directions-social__icon-wrap' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .starter-starter-directions-social__icon-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .starter-starter-directions-social__icon-wrap i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .starter-starter-directions-social__icon-wrap svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .starter-starter-directions-social__icon-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .starter-starter-directions-social__icon-wrap' => 'margin-right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .starter-starter-directions-social__item-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'item_title_typography',
				'selector' => '{{WRAPPER}} .starter-starter-directions-social__item-title',
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
					'{{WRAPPER}} .starter-starter-directions-social__item-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .starter-starter-directions-social__item-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'item_desc_typography',
				'selector' => '{{WRAPPER}} .starter-starter-directions-social__item-desc',
				'fields_options' => [
					'font_weight' => [ 'default' => '400' ],
					'font_size'   => [ 'default' => [ 'size' => 14, 'unit' => 'px' ] ],
					'line_height' => [ 'default' => [ 'size' => 1.5, 'unit' => 'em' ] ],
				],
			]
		);

		// Item Vertical Gap spacing
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
					'{{WRAPPER}} .starter-starter-directions-social__list' => '--starter-starter-directions-gap: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .starter-starter-directions-social__list' => '--starter-starter-divider-color: {{VALUE}};',
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
					'{{WRAPPER}} .starter-starter-directions-social__list' => '--starter-starter-divider-width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .starter-starter-directions-social__list' => '--starter-starter-divider-style: {{VALUE}};',
				],
				'condition' => [
					'show_dividers' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Map Button Styling
		// =====================================================
		$this->start_controls_section(
			'style_map_btn',
			[
				'label'     => esc_html__( 'Map Button Styling', 'starter-elementor-addon' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_map_btn' => 'yes',
				],
			]
		);

		$this->add_control(
			'map_btn_bg',
			[
				'label'     => esc_html__( 'Button Background Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'var(--color-primary, #EA4F89)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions-social__map-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'map_btn_hover_bg',
			[
				'label'     => esc_html__( 'Button Hover Background Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#C40072',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions-social__map-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'map_btn_text_color',
			[
				'label'     => esc_html__( 'Button Text Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions-social__map-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'map_btn_hover_text_color',
			[
				'label'     => esc_html__( 'Button Hover Text Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions-social__map-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'map_btn_typography',
				'selector' => '{{WRAPPER}} .starter-starter-directions-social__map-btn',
				'fields_options' => [
					'font_weight' => [ 'default' => '700' ],
					'font_size'   => [ 'default' => [ 'size' => 16, 'unit' => 'px' ] ],
				],
			]
		);

		$this->add_responsive_control(
			'map_btn_padding',
			[
				'label'      => esc_html__( 'Button Padding', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => '14',
					'right'     => '32',
					'bottom'   => '14',
					'left'     => '32',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions-social__map-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'map_btn_radius',
			[
				'label'      => esc_html__( 'Button Border Radius', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'size' => 9999, 'unit' => 'px' ], /* 100% round buttons constraint */
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions-social__map-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'map_btn_margin_top',
			[
				'label'      => esc_html__( 'Spacing Above Button', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'size' => 28, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions-social__map-btn-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'map_btn_box_shadow',
				'selector' => '{{WRAPPER}} .starter-starter-directions-social__map-btn',
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Social Links Styling
		// =====================================================
		$this->start_controls_section(
			'style_social',
			[
				'label' => esc_html__( 'Social Links Styling', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'social_spacing_top',
			[
				'label'      => esc_html__( 'Spacing Above Socials', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default'    => [ 'size' => 28, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions-social__social-wrap' => 'margin-top: {{SIZE}}{{UNIT}}; border-top: 1px solid var(--starter-starter-divider-color, rgba(236, 0, 140, 0.08)); padding-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_btn_bg',
			[
				'label'     => esc_html__( 'Button Background Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#EA4F89',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions-social__social-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_btn_hover_bg',
			[
				'label'     => esc_html__( 'Button Hover Background Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#C40072',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions-social__social-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_btn_text_color',
			[
				'label'     => esc_html__( 'Button Text Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions-social__social-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_btn_hover_text_color',
			[
				'label'     => esc_html__( 'Button Hover Text Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-directions-social__social-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'social_btn_typography',
				'selector' => '{{WRAPPER}} .starter-starter-directions-social__social-btn',
				'fields_options' => [
					'font_weight' => [ 'default' => '600' ],
					'font_size'   => [ 'default' => [ 'size' => 14, 'unit' => 'px' ] ],
				],
			]
		);

		$this->add_responsive_control(
			'social_btn_padding',
			[
				'label'      => esc_html__( 'Button Padding', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => '10',
					'right'     => '24',
					'bottom'   => '10',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions-social__social-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'social_btn_radius',
			[
				'label'      => esc_html__( 'Button Border Radius', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'size' => 9999, 'unit' => 'px' ], /* 100% round buttons constraint */
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-directions-social__social-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
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

		wp_enqueue_style( 'starter-starter-directions-social', STARTER_URL . 'widgets/starter-directions-social/starter-directions-social.css', [], STARTER_VERSION );

		$list_classes = [ 'starter-starter-directions-social__list' ];
		if ( $settings['show_dividers'] === 'yes' ) {
			$list_classes[] = 'starter-starter-directions-social__list--show-dividers';
		}
		?>
		<div class="starter-starter-directions-social">
			<div class="starter-starter-directions-social__card">
				
				<!-- Widget Header (Subtitle, Title, Content Description) -->
				<div class="starter-starter-directions-social__header-wrap">
					<?php if ( ! empty( $settings['widget_subtitle'] ) ) : ?>
						<span class="starter-starter-directions-social__subtitle display-block"><?php echo esc_html( $settings['widget_subtitle'] ); ?></span>
					<?php endif; ?>

					<?php if ( $settings['show_title'] === 'yes' && ! empty( $settings['widget_title'] ) ) : ?>
						<h2 class="starter-starter-directions-social__main-title font-display"><?php echo esc_html( $settings['widget_title'] ); ?></h2>
					<?php endif; ?>

					<?php if ( ! empty( $settings['widget_content'] ) ) : ?>
						<div class="starter-starter-directions-social__header-content"><?php echo wp_kses_post( $settings['widget_content'] ); ?></div>
					<?php endif; ?>
				</div>

				<!-- Items Grid/List -->
				<div class="<?php echo esc_attr( implode( ' ', $list_classes ) ); ?>">
					<?php foreach ( $settings['directions_list'] as $item ) : 
						$title = isset( $item['item_title'] ) ? wp_kses_post( $item['item_title'] ) : '';
						$desc = isset( $item['item_description'] ) ? wp_kses_post( $item['item_description'] ) : '';
					?>
						<div class="starter-starter-directions-social__item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?> flex items-start">
							
							<!-- Left Circular Icon Wrap -->
							<?php if ( ! empty( $item['item_icon']['value'] ) ) : ?>
								<div class="starter-starter-directions-social__icon-wrap flex-shrink-0 flex items-center justify-center">
									<span class="starter-starter-directions-social__icon">
										<?php \Elementor\Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								</div>
							<?php endif; ?>

							<!-- Right Text Content -->
							<div class="starter-starter-directions-social__content">
								<?php if ( ! empty( $title ) ) : ?>
									<h4 class="starter-starter-directions-social__item-title font-display"><?php echo $title; ?></h4>
								<?php endif; ?>

								<?php if ( ! empty( $desc ) ) : ?>
									<p class="starter-starter-directions-social__item-desc"><?php echo nl2br( $desc ); ?></p>
								<?php endif; ?>
							</div>

						</div>
					<?php endforeach; ?>
				</div>

				<!-- Map Button Section -->
				<?php if ( $settings['show_map_btn'] === 'yes' && ! empty( $settings['map_btn_text'] ) ) : 
					$map_link_key = 'map_button_link';
					if ( ! empty( $settings['map_btn_link']['url'] ) ) {
						$this->add_link_attributes( $map_link_key, $settings['map_btn_link'] );
					}
					$this->add_render_attribute( $map_link_key, 'class', 'starter-starter-directions-social__map-btn inline-flex items-center justify-center gap-2 transition-all duration-300 w-full' );
				?>
					<div class="starter-starter-directions-social__map-btn-wrap">
						<a <?php $this->print_render_attribute_string( $map_link_key ); ?>>
							<?php if ( ! empty( $settings['map_btn_icon']['value'] ) ) : ?>
								<span class="starter-starter-directions-social__map-btn-icon flex items-center justify-center">
									<?php \Elementor\Icons_Manager::render_icon( $settings['map_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>
							<span class="starter-starter-directions-social__map-btn-text"><?php echo esc_html( $settings['map_btn_text'] ); ?></span>
						</a>
					</div>
				<?php endif; ?>

				<!-- Social Links Footer Section -->
				<?php if ( ! empty( $settings['social_list'] ) ) : ?>
					<div class="starter-starter-directions-social__social-wrap flex flex-wrap gap-3">
						<?php foreach ( $settings['social_list'] as $social ) : 
							$social_text = isset( $social['social_text'] ) ? esc_html( $social['social_text'] ) : '';
							$social_link_key = 'social_link_' . $social['_id'];
							
							// Setup Link elementor attributes
							if ( ! empty( $social['social_link']['url'] ) ) {
								$this->add_link_attributes( $social_link_key, $social['social_link'] );
							}
							
							// Add button classes
							$this->add_render_attribute( $social_link_key, 'class', 'starter-starter-directions-social__social-btn inline-flex items-center justify-center gap-2 transition-all duration-300' );
						?>
							<a <?php $this->print_render_attribute_string( $social_link_key ); ?>>
								<?php if ( ! empty( $social['social_icon']['value'] ) ) : ?>
									<span class="starter-starter-directions-social__social-icon flex items-center justify-center">
										<?php \Elementor\Icons_Manager::render_icon( $social['social_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
								<?php if ( ! empty( $social_text ) ) : ?>
									<span class="starter-starter-directions-social__social-text"><?php echo $social_text; ?></span>
								<?php endif; ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

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
			var listClasses = 'starter-starter-directions-social__list';
			if ( settings.show_dividers === 'yes' ) {
				listClasses += ' starter-starter-directions-social__list--show-dividers';
			}
		#>
			<div class="starter-starter-directions-social">
				<div class="starter-starter-directions-social__card">
					
					<!-- Widget Header (Subtitle, Title, Content Description) -->
					<div class="starter-starter-directions-social__header-wrap">
						<# if ( settings.widget_subtitle ) { #>
							<span class="starter-starter-directions-social__subtitle display-block">{{{ settings.widget_subtitle }}}</span>
						<# } #>

						<# if ( settings.show_title === 'yes' && settings.widget_title ) { #>
							<h2 class="starter-starter-directions-social__main-title font-display">{{{ settings.widget_title }}}</h2>
						<# } #>

						<# if ( settings.widget_content ) { #>
							<div class="starter-starter-directions-social__header-content">{{{ settings.widget_content }}}</div>
						<# } #>
					</div>

					<!-- Items List -->
					<div class="{{ listClasses }}">
						<# _.each( settings.directions_list, function( item ) { 
							var iconHTML = '';
							if ( item.item_icon && item.item_icon.value ) {
								iconHTML = elementor.helpers.renderIcon( view, item.item_icon, { 'aria-hidden': true }, 'i', 'object' );
							}
							var descWithBr = item.item_description ? item.item_description.replace(/\n/g, '<br>') : '';
						#>
							<div class="starter-starter-directions-social__item elementor-repeater-item-{{ item._id }} flex items-start">
								
								<!-- Circular Icon Wrap -->
								<# if ( item.item_icon && item.item_icon.value ) { #>
									<div class="starter-starter-directions-social__icon-wrap flex-shrink-0 flex items-center justify-center">
										<span class="starter-starter-directions-social__icon">
											<# if ( iconHTML && iconHTML.rendered ) { #>
												{{{ iconHTML.value }}}
											<# } else { #>
												<i class="{{{ item.item_icon.value }}}" aria-hidden="true"></i>
											<# } #>
										</span>
									</div>
								<# } #>

								<!-- Text Content -->
								<div class="starter-starter-directions-social__content">
									<# if ( item.item_title ) { #>
										<h4 class="starter-starter-directions-social__item-title font-display">{{{ item.item_title }}}</h4>
									<# } #>

									<# if ( item.item_description ) { #>
										<p class="starter-starter-directions-social__item-desc">{{{ descWithBr }}}</p>
									<# } #>
								</div>

							</div>
						<# } ); #>
					</div>

					<!-- Map Button Section -->
					<# if ( settings.show_map_btn === 'yes' && settings.map_btn_text ) { 
						var mapIconHTML = '';
						if ( settings.map_btn_icon && settings.map_btn_icon.value ) {
							mapIconHTML = elementor.helpers.renderIcon( view, settings.map_btn_icon, { 'aria-hidden': true }, 'i', 'object' );
						}
						var mapUrl = settings.map_btn_link && settings.map_btn_link.url ? settings.map_btn_link.url : '#';
						var mapTarget = settings.map_btn_link && settings.map_btn_link.is_external ? ' target="_blank"' : '';
						var mapNofollow = settings.map_btn_link && settings.map_btn_link.nofollow ? ' rel="nofollow"' : '';
					#>
						<div class="starter-starter-directions-social__map-btn-wrap">
							<a href="{{ mapUrl }}" class="starter-starter-directions-social__map-btn inline-flex items-center justify-center gap-2 transition-all duration-300 w-full"{{{ mapTarget }}}{{{ mapNofollow }}}>
								<# if ( settings.map_btn_icon && settings.map_btn_icon.value ) { #>
									<span class="starter-starter-directions-social__map-btn-icon flex items-center justify-center">
										<# if ( mapIconHTML && mapIconHTML.rendered ) { #>
											{{{ mapIconHTML.value }}}
										<# } else { #>
											<i class="{{{ settings.map_btn_icon.value }}}" aria-hidden="true"></i>
										<# } #>
									</span>
								<# } #>
								<span class="starter-starter-directions-social__map-btn-text">{{{ settings.map_btn_text }}}</span>
							</a>
						</div>
					<# } #>

					<!-- Social Links -->
					<# if ( settings.social_list && settings.social_list.length ) { #>
						<div class="starter-starter-directions-social__social-wrap flex flex-wrap gap-3">
							<# _.each( settings.social_list, function( social ) { 
								var socialIconHTML = '';
								if ( social.social_icon && social.social_icon.value ) {
									socialIconHTML = elementor.helpers.renderIcon( view, social.social_icon, { 'aria-hidden': true }, 'i', 'object' );
								}
								var socialUrl = social.social_link && social.social_link.url ? social.social_link.url : '#';
								var target = social.social_link && social.social_link.is_external ? ' target="_blank"' : '';
								var nofollow = social.social_link && social.social_link.nofollow ? ' rel="nofollow"' : '';
							#>
								<a href="{{ socialUrl }}" class="starter-starter-directions-social__social-btn inline-flex items-center justify-center gap-2 transition-all duration-300"{{{ target }}}{{{ nofollow }}}>
									<# if ( social.social_icon && social.social_icon.value ) { #>
										<span class="starter-starter-directions-social__social-icon flex items-center justify-center">
											<# if ( socialIconHTML && socialIconHTML.rendered ) { #>
												{{{ socialIconHTML.value }}}
											<# } else { #>
												<i class="{{{ social.social_icon.value }}}" aria-hidden="true"></i>
											<# } #>
										</span>
									<# } #>
									<# if ( social.social_text ) { #>
										<span class="starter-starter-directions-social__social-text">{{{ social.social_text }}}</span>
									<# } #>
								</a>
							<# } ); #>
						</div>
					<# } #>

				</div>
			</div>
		<# } #>
		<?php
	}
}

// Register stylesheet hooks
add_action( 'wp_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-directions-social/starter-directions-social.css';
	wp_register_style(
		'starter-starter-directions-social',
		STARTER_URL . 'widgets/starter-directions-social/starter-directions-social.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );

add_action( 'elementor/editor/after_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-directions-social/starter-directions-social.css';
	wp_enqueue_style(
		'starter-starter-directions-social',
		STARTER_URL . 'widgets/starter-directions-social/starter-directions-social.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );
