<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class STARTER_Widget_starter_Hero extends \Elementor\Widget_Base {

	public function get_name()       { return 'starter-hero'; }
	public function get_title()      { return esc_html__( 'KU Hero Section', 'starter-elementor-addon' ); }
	public function get_icon()       { return 'eicon-banner'; }
	public function get_categories() { return [ 'starter-elementor-addon' ]; }
	public function get_keywords()   { return [ 'hero', 'banner', 'dental', 'smile' ]; }

	public function get_style_depends()  { return [ 'starter-starter-hero' ]; }
	public function get_script_depends() { return [ 'starter-starter-hero' ]; }

	protected function register_controls() {

		/* ── CONTENT TAB ───────────────────────────── */

		$this->start_controls_section( 'section_hero_slides', [
			'label' => esc_html__( 'Hero Slides', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control( 'badge_icon_class', [
			'label'   => esc_html__( 'Badge Icon Class', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '',
		] );
		$repeater->add_control( 'badge_text', [
			'label'   => esc_html__( 'Badge Text', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '',
		] );
		$repeater->add_control( 'heading_line1', [
			'label'   => esc_html__( 'Heading Line 1', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'ดูแลรอยยิ้มของคุณ',
		] );
		$repeater->add_control( 'heading_highlight', [
			'label'   => esc_html__( 'Heading Highlight', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'ด้วยความใส่ใจ',
		] );
		$repeater->add_control( 'subtitle', [
			'label'   => esc_html__( 'Subtitle', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'ให้คุณยิ้มได้อย่างมั่นใจในทุกวัน',
		] );
		$repeater->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'คลินิกทันตกรรมครบวงจร ด้วยเทคโนโลยีที่ทันสมัย และทีมทันตแพทย์ผู้เชี่ยวชาญ พร้อมดูแลสุขภาพช่องปากของคุณ',
		] );
		$repeater->add_control( 'cta_primary_text', [
			'label'   => esc_html__( 'Primary Button Text', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'นัดหมายออนไลน์',
		] );
		$repeater->add_control( 'cta_primary_url', [
			'label'         => esc_html__( 'Primary Button URL', 'starter-elementor-addon' ),
			'type'          => \Elementor\Controls_Manager::URL,
			'default'       => [ 'url' => '#contact' ],
			'show_external' => true,
		] );
		$repeater->add_control( 'cta_primary_icon', [
			'label' => esc_html__( 'Primary Button Icon', 'starter-elementor-addon' ),
			'type'  => \Elementor\Controls_Manager::ICONS,
			'default' => [
				'value' => 'far fa-calendar-alt',
				'library' => 'fa-regular',
			],
		] );
		$repeater->add_control( 'cta_secondary_text', [
			'label'   => esc_html__( 'Secondary Button Text', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'ดูบริการของเรา',
		] );
		$repeater->add_control( 'cta_secondary_url', [
			'label'         => esc_html__( 'Secondary Button URL', 'starter-elementor-addon' ),
			'type'          => \Elementor\Controls_Manager::URL,
			'default'       => [ 'url' => '#services' ],
			'show_external' => true,
		] );
		$repeater->add_control( 'cta_secondary_icon', [
			'label' => esc_html__( 'Secondary Button Icon', 'starter-elementor-addon' ),
			'type'  => \Elementor\Controls_Manager::ICONS,
			'default' => [
				'value' => '',
				'library' => '',
			],
		] );
		$repeater->add_control( 'hero_image', [
			'label' => esc_html__( 'Hero Image', 'starter-elementor-addon' ),
			'type'  => \Elementor\Controls_Manager::MEDIA,
		] );

		$repeater->add_control( 'slide_bg_type', [
			'label'   => esc_html__( 'Background Type', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'color',
			'options' => [
				'color' => esc_html__( 'Solid / Gradient', 'starter-elementor-addon' ),
				'image' => esc_html__( 'Image', 'starter-elementor-addon' ),
			],
		] );

		$repeater->add_control( 'slide_bg_color', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '',
			'condition' => [
				'slide_bg_type' => 'color',
			],
		] );

		$repeater->add_control( 'slide_bg_gradient_start', [
			'label'     => esc_html__( 'Gradient Start Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '',
			'condition' => [
				'slide_bg_type' => 'color',
			],
		] );

		$repeater->add_control( 'slide_bg_gradient_end', [
			'label'     => esc_html__( 'Gradient End Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '',
			'condition' => [
				'slide_bg_type' => 'color',
			],
		] );

		$repeater->add_control( 'slide_bg_gradient_angle', [
			'label'     => esc_html__( 'Gradient Angle (Degrees)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 360 ] ],
			'default'   => [ 'size' => 180 ],
			'condition' => [
				'slide_bg_type' => 'color',
			],
		] );

		$repeater->add_control( 'slide_bg_image', [
			'label'     => esc_html__( 'Background Image', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::MEDIA,
			'condition' => [
				'slide_bg_type' => 'image',
			],
		] );

		$repeater->add_control( 'slide_bg_overlay_color', [
			'label'     => esc_html__( 'Background Overlay Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '',
		] );
		
		$this->add_control( 'hero_slides', [
			'label'       => esc_html__( 'Slides', 'starter-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'badge_icon_class' => '',
					'badge_text' => '',
					'heading_line1' => 'ดูแลรอยยิ้มของคุณ',
					'heading_highlight' => 'ด้วยความใส่ใจ',
					'subtitle' => 'ให้คุณยิ้มได้อย่างมั่นใจในทุกวัน',
					'description' => 'คลินิกทันตกรรมครบวงจร ด้วยเทคโนโลยีที่ทันสมัย และทีมทันตแพทย์ผู้เชี่ยวชาญ พร้อมดูแลสุขภาพช่องปากของคุณ',
					'cta_primary_text' => 'นัดหมายออนไลน์',
					'cta_primary_url' => [ 'url' => '#contact' ],
					'cta_secondary_text' => 'ดูบริการของเรา',
					'cta_secondary_url' => [ 'url' => '#services' ],
				],
			],
			'title_field' => '{{{ heading_line1 }}}',
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_carousel', [
			'label' => esc_html__( 'Carousel Settings', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'carousel_effect', [
			'label'   => esc_html__( 'Effect', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'slide',
			'options' => [
				'slide' => esc_html__( 'Slide', 'starter-elementor-addon' ),
				'fade'  => esc_html__( 'Fade', 'starter-elementor-addon' ),
			],
		] );

		$this->add_control( 'carousel_loop', [
			'label'        => esc_html__( 'Loop', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'No', 'starter-elementor-addon' ),
			'default'      => 'yes',
		] );

		$this->add_control( 'carousel_autoplay', [
			'label'        => esc_html__( 'Autoplay', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'No', 'starter-elementor-addon' ),
			'default'      => 'yes',
		] );

		$this->add_control( 'carousel_autoplay_delay', [
			'label'      => esc_html__( 'Autoplay Delay (ms)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 1000, 'max' => 15000, 'step' => 500 ] ],
			'default'    => [ 'size' => 6000 ],
			'condition'  => [ 'carousel_autoplay' => 'yes' ],
		] );

		$this->add_control( 'carousel_speed', [
			'label'      => esc_html__( 'Transition Speed (ms)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 100, 'max' => 2000, 'step' => 100 ] ],
			'default'    => [ 'size' => 500 ],
		] );

		$this->add_control( 'carousel_pause_on_hover', [
			'label'        => esc_html__( 'Pause on Hover', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'No', 'starter-elementor-addon' ),
			'default'      => 'no',
			'condition'    => [ 'carousel_autoplay' => 'yes' ],
		] );

		$this->add_control( 'carousel_show_navigation', [
			'label'        => esc_html__( 'Show Navigation Arrows', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'Hide', 'starter-elementor-addon' ),
			'default'      => 'yes',
			'separator'    => 'before',
		] );

		$this->add_control( 'carousel_show_pagination', [
			'label'        => esc_html__( 'Show Pagination Dots', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'Hide', 'starter-elementor-addon' ),
			'default'      => 'yes',
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_stats', [
			'label' => esc_html__( 'Footer Stats', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		
		$this->add_control( 'show_stats', [
			'label'        => esc_html__( 'Show Stats', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'Hide', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_responsive_control( 'stats_columns', [
			'label'     => esc_html__( 'Columns', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => '4',
			'tablet_default' => '2',
			'mobile_default' => '2',
			'options'   => [
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
			],
			'condition' => [ 'show_stats' => 'yes' ],
			'selectors' => [
				'{{WRAPPER}} .starter-hero__stats-list' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				'{{WRAPPER}} .starter-hero__stat-item' => 'border-right: 1px solid #F3F4F6;',
				'{{WRAPPER}} .starter-hero__stat-item:nth-child({{VALUE}}n)' => 'border-right: none;',
			],
		] );

		$stats_repeater = new \Elementor\Repeater();

		$stats_repeater->add_control( 'stat_icon', [
			'label'   => esc_html__( 'Icon Class', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'ri-diamond-line',
		] );

		$stats_repeater->add_control( 'stat_label', [
			'label'   => esc_html__( 'Label Line 1', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'มาตรฐานระดับสากล',
		] );

		$stats_repeater->add_control( 'stat_value', [
			'label'   => esc_html__( 'Value Line 2', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => "เครื่องมือทันสมัย\nได้มาตรฐาน",
		] );

		$this->add_control( 'stats_repeater_list', [
			'label'       => esc_html__( 'Stats List Items', 'starter-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $stats_repeater->get_controls(),
			'default'     => [
				[
					'stat_icon'  => 'ri-diamond-line',
					'stat_label' => 'มาตรฐานระดับสากล',
					'stat_value' => "เครื่องมือทันสมัย\nได้มาตรฐาน",
				],
				[
					'stat_icon'  => 'ri-tooth-line',
					'stat_label' => 'เทคโนโลยีทันสมัย',
					'stat_value' => "เทคโนโลยีและนวัตกรรม\nเพื่อการรักษาที่แม่นยำ",
				],
				[
					'stat_icon'  => 'ri-shield-line',
					'stat_label' => 'ปลอดภัย อ่อนโยน',
					'stat_value' => "ใส่ใจความปลอดภัย\nทุกขั้นตอนการรักษา",
				],
				[
					'stat_icon'  => 'ri-heart-line',
					'stat_label' => 'ดูแลด้วยความใส่ใจ',
					'stat_value' => "ให้คำปรึกษาและติดตาม\nผลการรักษาอย่างใกล้ชิด",
				],
			],
			'title_field' => '{{{ stat_label }}}',
			'condition'   => [ 'show_stats' => 'yes' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_float_cards', [
			'label' => esc_html__( 'Floating Cards (Optional)', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );
		
		$this->add_control( 'show_float_cards', [
			'label'        => esc_html__( 'Show Floating Cards', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'Hide', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'no', // Default to no to match the mockup
		] );

		$this->add_control( 'fc1_icon',  [ 'label' => esc_html__( 'Card 1 Icon', 'starter-elementor-addon' ),  'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ri-check-double-line', 'condition' => [ 'show_float_cards' => 'yes' ] ] );
		$this->add_control( 'fc1_label', [ 'label' => esc_html__( 'Card 1 Label', 'starter-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ผู้รับบริการ', 'condition' => [ 'show_float_cards' => 'yes' ] ] );
		$this->add_control( 'fc1_value', [ 'label' => esc_html__( 'Card 1 Value', 'starter-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '5,000+ ครอบครัว', 'condition' => [ 'show_float_cards' => 'yes' ] ] );
		$this->add_control( 'fc2_icon',  [ 'label' => esc_html__( 'Card 2 Icon', 'starter-elementor-addon' ),  'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ri-award-line', 'condition' => [ 'show_float_cards' => 'yes' ] ] );
		$this->add_control( 'fc2_label', [ 'label' => esc_html__( 'Card 2 Label', 'starter-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ประสบการณ์', 'condition' => [ 'show_float_cards' => 'yes' ] ] );
		$this->add_control( 'fc2_value', [ 'label' => esc_html__( 'Card 2 Value', 'starter-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '10+ ปี', 'condition' => [ 'show_float_cards' => 'yes' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_decorators', [
			'label' => esc_html__( 'Decorative Elements', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_dots_grid', [
			'label'        => esc_html__( 'Show Dotted Grid Decorator', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'Hide', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'show_floating_hearts', [
			'label'        => esc_html__( 'Show Floating Hearts', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'Hide', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'show_sparkles', [
			'label'        => esc_html__( 'Show Sparkles', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'Hide', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'show_bottom_wave', [
			'label'        => esc_html__( 'Show Bottom Waves', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'Hide', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->end_controls_section();


		/* ── STYLE TAB ─────────────────────────────── */

		/* 1. SECTION & BACKGROUND STYLE */
		$this->start_controls_section( 'style_section', [
			'label' => esc_html__( 'Section & Background', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'section_padding', [
			'label'      => esc_html__( 'Section Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem', '%' ],
			'default'    => [
				'top'      => '80',
				'bottom'   => '100',
				'left'     => '0',
				'right'    => '0',
				'unit'     => 'px',
				'isLinked' => false,
			],
			'selectors'  => [ '{{WRAPPER}} .starter-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'slide_min_height', [
			'label'      => esc_html__( 'Slide Min Height', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'vh', 'em' ],
			'range'      => [
				'px' => [ 'min' => 200, 'max' => 1200, 'step' => 10 ],
				'vh' => [ 'min' => 20, 'max' => 100 ],
			],
			'selectors'  => [
				'{{WRAPPER}} .starter-hero__slide-row' => 'min-height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'slide_row_padding', [
			'label'      => esc_html__( 'Slide Row Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%', 'rem' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-hero__slide-row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'content_section_width', [
			'label'      => esc_html__( 'Content Width (%)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'range'      => [
				'%' => [ 'min' => 10, 'max' => 90, 'step' => 1 ],
			],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-hero__slide-row' => '--hero-content-width: {{SIZE}}%;',
			],
		] );

		$this->add_responsive_control( 'image_section_width', [
			'label'      => esc_html__( 'Image Width (%)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'range'      => [
				'%' => [ 'min' => 10, 'max' => 90, 'step' => 1 ],
			],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-hero__slide-row' => '--hero-image-width: {{SIZE}}%;',
			],
		] );

		$this->add_control( 'section_bg_gradient_start', [
			'label'     => esc_html__( 'Gradient Start Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFF2F6',
			'selectors' => [ '{{WRAPPER}} .starter-hero' => '--bg-gradient-start: {{VALUE}};' ],
		] );

		$this->add_control( 'section_bg_gradient_end', [
			'label'     => esc_html__( 'Gradient End Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [ '{{WRAPPER}} .starter-hero' => '--bg-gradient-end: {{VALUE}};' ],
		] );

		$this->add_control( 'section_bg_gradient_angle', [
			'label'     => esc_html__( 'Gradient Angle (Degrees)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 360 ] ],
			'default'   => [ 'size' => 180 ],
			'selectors' => [ '{{WRAPPER}} .starter-hero' => '--bg-gradient-angle: {{SIZE}}deg;' ],
		] );

		$this->end_controls_section();

		/* 2. DECORATORS STYLE */
		$this->start_controls_section( 'style_dots_decor', [
			'label' => esc_html__( 'Decorators (Dots, Hearts, Sparkles)', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'dots_grid_color', [
			'label'     => esc_html__( 'Dots Grid Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(244, 63, 94, 0.15)',
			'condition' => [ 'show_dots_grid' => 'yes' ],
			'selectors' => [ '{{WRAPPER}} .starter-hero' => '--dots-color: {{VALUE}};' ],
		] );

		$this->add_control( 'floating_heart_color', [
			'label'     => esc_html__( 'Floating Hearts Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#F43F5E',
			'condition' => [ 'show_floating_hearts' => 'yes' ],
			'selectors' => [ '{{WRAPPER}} .starter-hero' => '--heart-color: {{VALUE}};' ],
		] );

		$this->add_control( 'floating_sparkle_color', [
			'label'     => esc_html__( 'Floating Sparkles Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'condition' => [ 'show_sparkles' => 'yes' ],
			'selectors' => [ '{{WRAPPER}} .starter-hero' => '--sparkle-color: {{VALUE}};' ],
		] );

		$this->end_controls_section();

		/* 3. HERO IMAGE FRAME & GLOW */
		$this->start_controls_section( 'style_image_frame', [
			'label' => esc_html__( 'Hero Image Frame & Glow', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'image_border_radius', [
			'label'       => esc_html__( 'Organic Frame Radius', 'starter-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '42% 58% 70% 30% / 45% 45% 55% 55%',
			'description' => esc_html__( 'Use 8 values separated by slashes to define organic shapes.', 'starter-elementor-addon' ),
			'selectors'   => [ '{{WRAPPER}} .starter-hero__image-container' => 'border-radius: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'image_border_width', [
			'label'      => esc_html__( 'White Border Width (px)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
			'default'    => [ 'size' => 12 ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__image-container' => 'border-width: {{SIZE}}px;' ],
		] );

		$this->add_control( 'image_border_color', [
			'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-hero__image-container' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'image_glow_shadow',
			'label'    => esc_html__( 'Glow Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-hero__image-container',
			'fields_options' => [
				'box_shadow' => [
					'default' => [
						'horizontal' => 0,
						'vertical'   => 20,
						'blur'       => 50,
						'spread'     => 10,
						'color'      => 'rgba(244, 63, 94, 0.12)',
					]
				]
			]
		] );

		$this->add_responsive_control( 'image_container_height', [
			'label'      => esc_html__( 'Image Container Height', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem', 'vh' ],
			'range'      => [
				'px' => [ 'min' => 200, 'max' => 800 ],
				'vh' => [ 'min' => 10, 'max' => 100 ],
			],
			'selectors'  => [
				'{{WRAPPER}} .starter-hero__image-container' => 'height: {{SIZE}}{{UNIT}};',
			],
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
				'{{WRAPPER}} .starter-hero__image' => '--image-object-fit: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'image_object_position_x', [
			'label'      => esc_html__( 'Image Focus position X (%)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-hero__image' => '--image-object-x: {{SIZE}}%;',
			],
		] );

		$this->add_responsive_control( 'image_object_position_y', [
			'label'      => esc_html__( 'Image Focus position Y (%)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'range'      => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors'  => [
				'{{WRAPPER}} .starter-hero__image' => '--image-object-y: {{SIZE}}%;',
			],
		] );

		$this->add_responsive_control( 'image_scale', [
			'label'      => esc_html__( 'Image Scale (Zoom)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0.5, 'max' => 2.5, 'step' => 0.05 ] ],
			'default'    => [ 'size' => 1, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-hero__image' => '--image-scale: {{SIZE}};',
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
				'{{WRAPPER}} .starter-hero__image' => '--image-x: {{SIZE}}{{UNIT}};',
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
				'{{WRAPPER}} .starter-hero__image' => '--image-y: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		/* 3.5. BADGE STYLE */
		$this->start_controls_section( 'style_badge', [
			'label' => esc_html__( 'Badge', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'badge_text_color', [
			'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-hero__badge' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'badge_bg_color', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(236, 0, 140, 0.1)',
			'selectors' => [ '{{WRAPPER}} .starter-hero__badge' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'badge_icon_color', [
			'label'     => esc_html__( 'Icon Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-hero__badge-icon' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'badge_typography',
			'label'    => esc_html__( 'Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-hero__badge',
		] );

		$this->add_responsive_control( 'badge_padding', [
			'label'      => esc_html__( 'Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem', '%' ],
			'default'    => [
				'top'      => '8',
				'bottom'   => '8',
				'left'     => '16',
				'right'    => '16',
				'unit'     => 'px',
				'isLinked' => false,
			],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'badge_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem', '%' ],
			'default'    => [
				'top'      => '50',
				'bottom'   => '50',
				'left'     => '50',
				'right'    => '50',
				'unit'     => 'px',
				'isLinked' => true,
			],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'badge_margin_bottom', [
			'label'      => esc_html__( 'Margin Bottom', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'size' => 24 ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__badge-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		/* 4. HEADING STYLE */
		$this->start_controls_section( 'style_heading', [
			'label' => esc_html__( 'Heading', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'heading_typography',
			'label'    => esc_html__( 'Heading Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-hero__heading',
		] );

		$this->add_control( 'heading_color', [
			'label'     => esc_html__( 'Heading Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#B91C5C', // Elegant deep magenta pink matching mockup
			'selectors' => [ '{{WRAPPER}} .starter-hero__heading' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'highlight_color', [
			'label'     => esc_html__( 'Highlight Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#B91C5C',
			'selectors' => [ '{{WRAPPER}} .starter-hero__highlight' => 'color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'heading_margin_bottom', [
			'label'      => esc_html__( 'Margin Bottom', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'size' => 16 ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__heading' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		/* 5. SUBTITLE STYLE */
		$this->start_controls_section( 'style_subtitle', [
			'label' => esc_html__( 'Subtitle', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'subtitle_color', [
			'label'     => esc_html__( 'Subtitle Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#EC4899', // Matching pink subtitle in mockup
			'selectors' => [ '{{WRAPPER}} .starter-hero__subtitle' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'subtitle_typography',
			'label'    => esc_html__( 'Subtitle Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-hero__subtitle',
		] );

		$this->add_control( 'smiley_color', [
			'label'     => esc_html__( 'Smiley Face Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#EC4899',
			'selectors' => [ '{{WRAPPER}} .starter-hero__smiley' => 'stroke: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'subtitle_margin_bottom', [
			'label'      => esc_html__( 'Margin Bottom', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'size' => 20 ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		/* 6. DESCRIPTION STYLE */
		$this->start_controls_section( 'style_description', [
			'label' => esc_html__( 'Description', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'desc_color', [
			'label'     => esc_html__( 'Description Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#4B5563', // gray-600
			'selectors' => [ '{{WRAPPER}} .starter-hero__description' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'desc_typography',
			'label'    => esc_html__( 'Description Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-hero__description',
		] );

		$this->add_responsive_control( 'desc_margin_bottom', [
			'label'      => esc_html__( 'Margin Bottom', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'size' => 32 ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__description' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		/* 7. BUTTONS STYLE */
		$this->start_controls_section( 'style_buttons', [
			'label' => esc_html__( 'Buttons', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'buttons_typography',
			'label'    => esc_html__( 'Buttons Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-hero__btn-primary, {{WRAPPER}} .starter-hero__btn-secondary',
		] );

		/* Primary Button Styling */
		$this->add_control( 'heading_btn_primary', [
			'label'     => esc_html__( 'Primary Button', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->start_controls_tabs( 'tabs_btn_primary' );
		
		$this->start_controls_tab( 'tab_btn_primary_normal', [
			'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
		] );
		$this->add_control( 'btn_primary_bg', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#F43F5E',
			'selectors' => [ '{{WRAPPER}} .starter-hero__btn-primary' => 'background-color: {{VALUE}} !important;' ],
		] );
		$this->add_control( 'btn_primary_text', [
			'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-hero__btn-primary' => 'color: {{VALUE}} !important;' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'btn_primary_shadow',
			'label'    => esc_html__( 'Button Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-hero__btn-primary',
		] );
		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_btn_primary_hover', [
			'label' => esc_html__( 'Hover', 'starter-elementor-addon' ),
		] );
		$this->add_control( 'btn_primary_bg_hover', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#E11D48',
			'selectors' => [ '{{WRAPPER}} .starter-hero__btn-primary:hover' => 'background-color: {{VALUE}} !important;' ],
		] );
		$this->add_control( 'btn_primary_text_hover', [
			'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-hero__btn-primary:hover' => 'color: {{VALUE}} !important;' ],
		] );
		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'btn_primary_shadow_hover',
			'label'    => esc_html__( 'Button Shadow Hover', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-hero__btn-primary:hover',
		] );
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control( 'btn_primary_padding', [
			'label'      => esc_html__( 'Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [
				'top'      => '14',
				'bottom'   => '14',
				'left'     => '32',
				'right'    => '32',
				'unit'     => 'px',
				'isLinked' => false,
			],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__btn-primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ],
		] );
		$this->add_responsive_control( 'btn_primary_radius', [
			'label'      => esc_html__( 'Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 12, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__btn-primary' => 'border-radius: {{SIZE}}{{UNIT}} !important;' ],
		] );

		/* Secondary Button Styling */
		$this->add_control( 'heading_btn_secondary', [
			'label'     => esc_html__( 'Secondary Button', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->start_controls_tabs( 'tabs_btn_secondary' );
		
		$this->start_controls_tab( 'tab_btn_secondary_normal', [
			'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
		] );
		$this->add_control( 'btn_secondary_bg', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'transparent',
			'selectors' => [ '{{WRAPPER}} .starter-hero__btn-secondary' => 'background-color: {{VALUE}} !important;' ],
		] );
		$this->add_control( 'btn_secondary_text', [
			'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#B91C5C',
			'selectors' => [ '{{WRAPPER}} .starter-hero__btn-secondary' => 'color: {{VALUE}} !important;' ],
		] );
		$this->add_control( 'btn_secondary_border', [
			'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFF1F2',
			'selectors' => [ '{{WRAPPER}} .starter-hero__btn-secondary' => 'border-color: {{VALUE}} !important;' ],
		] );
		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_btn_secondary_hover', [
			'label' => esc_html__( 'Hover', 'starter-elementor-addon' ),
		] );
		$this->add_control( 'btn_secondary_bg_hover', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFF1F2', // Light pastel pink hover
			'selectors' => [ '{{WRAPPER}} .starter-hero__btn-secondary:hover' => 'background-color: {{VALUE}} !important;' ],
		] );
		$this->add_control( 'btn_secondary_text_hover', [
			'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#B91C5C',
			'selectors' => [ '{{WRAPPER}} .starter-hero__btn-secondary:hover' => 'color: {{VALUE}} !important;' ],
		] );
		$this->add_control( 'btn_secondary_border_hover', [
			'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#B91C5C',
			'selectors' => [ '{{WRAPPER}} .starter-hero__btn-secondary:hover' => 'border-color: {{VALUE}} !important;' ],
		] );
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control( 'btn_secondary_padding', [
			'label'      => esc_html__( 'Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [
				'top'      => '14',
				'bottom'   => '14',
				'left'     => '32',
				'right'    => '32',
				'unit'     => 'px',
				'isLinked' => false,
			],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__btn-secondary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;' ],
		] );
		$this->add_responsive_control( 'btn_secondary_radius', [
			'label'      => esc_html__( 'Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 12, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__btn-secondary' => 'border-radius: {{SIZE}}{{UNIT}} !important;' ],
		] );

		$this->end_controls_section();

		/* 8. FOOTER STATS STYLE */
		$this->start_controls_section( 'style_stats', [
			'label' => esc_html__( 'Footer Stats Style', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_stats' => 'yes' ],
		] );

		$this->add_responsive_control( 'stat_gap', [
			'label'      => esc_html__( 'Gap between Stats (px)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 100 ] ],
			'default'    => [ 'size' => 24 ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__stats-list' => 'gap: {{SIZE}}px;' ],
		] );

		$this->add_responsive_control( 'stat_item_padding', [
			'label'      => esc_html__( 'Item Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'default'    => [
				'top'      => '0',
				'bottom'   => '0',
				'left'     => '16',
				'right'     => '16',
				'unit'     => 'px',
				'isLinked' => false,
			],
			'selectors'  => [
				'{{WRAPPER}} .starter-hero__stat-item' => '--stat-item-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_control( 'show_stat_dividers', [
			'label'        => esc_html__( 'Show Dividers', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'No', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'stat_divider_color', [
			'label'     => esc_html__( 'Divider Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#F3F4F6',
			'selectors' => [
				'{{WRAPPER}} .starter-hero__stat-item' => '--stat-divider-color: {{VALUE}};',
			],
			'condition' => [ 'show_stat_dividers' => 'yes' ],
		] );

		$this->add_control( 'stat_divider_width', [
			'label'      => esc_html__( 'Divider Width', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [
				'px' => [ 'min' => 1, 'max' => 10 ],
			],
			'default'    => [ 'size' => 1, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-hero__stat-item' => '--stat-divider-width: {{SIZE}}{{UNIT}};',
			],
			'condition' => [ 'show_stat_dividers' => 'yes' ],
		] );

		$this->add_control( 'stat_divider_style', [
			'label'     => esc_html__( 'Divider Style', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'solid',
			'options'   => [
				'solid'  => esc_html__( 'Solid', 'starter-elementor-addon' ),
				'dashed' => esc_html__( 'Dashed', 'starter-elementor-addon' ),
				'dotted' => esc_html__( 'Dotted', 'starter-elementor-addon' ),
			],
			'selectors' => [
				'{{WRAPPER}} .starter-hero__stat-item' => '--stat-divider-style: {{VALUE}};',
			],
			'condition' => [ 'show_stat_dividers' => 'yes' ],
		] );

		$this->add_control( 'stat_icon_bg', [
			'label'     => esc_html__( 'Icon Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FDE3F1', // Soft pastel pink bg
			'selectors' => [ '{{WRAPPER}} .starter-hero__stat-icon-wrap' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'stat_icon_color', [
			'label'     => esc_html__( 'Icon Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#EA4F89', // Deep vibrant pink brand color
			'selectors' => [ '{{WRAPPER}} .starter-hero__stat-icon-wrap i' => 'color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'stat_icon_wrapper_size', [
			'label'      => esc_html__( 'Icon Wrapper Size (px)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'range'      => [ 'px' => [ 'min' => 24, 'max' => 80 ] ],
			'default'    => [ 'size' => 54 ],
			'selectors'  => [
				'{{WRAPPER}} .starter-hero__stat-icon-wrap' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
			],
		] );

		$this->add_responsive_control( 'stat_icon_size', [
			'label'      => esc_html__( 'Icon Font Size (px)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 40 ] ],
			'default'    => [ 'size' => 22 ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__stat-icon-wrap i' => 'font-size: {{SIZE}}px;' ],
		] );

		$this->add_control( 'stat_label_color', [
			'label'     => esc_html__( 'Stat Label Line 1 Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#EA4F89', // Brand pink as standard header color in mockup
			'selectors' => [ '{{WRAPPER}} .starter-hero__stat-label' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'stat_label_typography',
			'label'    => esc_html__( 'Stat Label Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-hero__stat-label',
		] );

		$this->add_control( 'stat_value_color', [
			'label'     => esc_html__( 'Stat Value Line 2 Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#111827', // gray-900 (Bold secondary line)
			'selectors' => [ '{{WRAPPER}} .starter-hero__stat-value' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'stat_value_typography',
			'label'    => esc_html__( 'Stat Value Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-hero__stat-value',
		] );

		$this->end_controls_section();

		/* 9. BOTTOM WAVE DESIGN */
		$this->start_controls_section( 'style_bottom_wave', [
			'label' => esc_html__( 'Bottom Wave Swoop', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_bottom_wave' => 'yes' ],
		] );

		$this->add_control( 'wave_color_1', [
			'label'     => esc_html__( 'Bottom Wave Layer 1 Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-hero__wave-1' => 'fill: {{VALUE}};' ],
		] );

		$this->add_control( 'wave_color_2', [
			'label'     => esc_html__( 'Bottom Wave Layer 2 Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#FFE4E6', // Soft pink wave outline
			'selectors' => [ '{{WRAPPER}} .starter-hero__wave-2' => 'fill: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'wave_height', [
			'label'      => esc_html__( 'Wave Height (px)', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'range'      => [ 'px' => [ 'min' => 20, 'max' => 200 ] ],
			'default'    => [ 'size' => 80 ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__wave-container' => 'height: {{SIZE}}px;' ],
		] );

		$this->end_controls_section();

		/* 10. PAGINATION & NAVIGATION STYLE */
		$this->start_controls_section( 'style_pagination', [
			'label' => esc_html__( 'Pagination & Navigation', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'pagination_heading', [
			'label'     => esc_html__( 'Pagination Dots', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
		] );

		$this->add_control( 'pagination_dot_color', [
			'label'     => esc_html__( 'Dot Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(0, 0, 0, 0.15)',
			'selectors' => [ '{{WRAPPER}} .starter-hero__pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'pagination_dot_active_color', [
			'label'     => esc_html__( 'Active Dot Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--heart-color, #F43F5E)',
			'selectors' => [ '{{WRAPPER}} .starter-hero__pagination .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'pagination_dot_size', [
			'label'      => esc_html__( 'Dot Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 4, 'max' => 16 ] ],
			'default'    => [ 'size' => 8, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'pagination_dot_active_width', [
			'label'      => esc_html__( 'Active Dot Width', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
			'default'    => [ 'size' => 20, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__pagination .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'pagination_dot_active_radius', [
			'label'      => esc_html__( 'Active Dot Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 20 ] ],
			'default'    => [ 'size' => 4, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__pagination .swiper-pagination-bullet-active' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'pagination_position_heading', [
			'label'     => esc_html__( 'Pagination Position', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'pagination_align_x', [
			'label'      => esc_html__( 'Horizontal Position', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::CHOOSE,
			'options'    => [
				'left'   => [ 'title' => esc_html__( 'Left', 'starter-elementor-addon' ), 'icon' => 'eicon-h-align-left' ],
				'center' => [ 'title' => esc_html__( 'Center', 'starter-elementor-addon' ), 'icon' => 'eicon-h-align-center' ],
				'right'  => [ 'title' => esc_html__( 'Right', 'starter-elementor-addon' ), 'icon' => 'eicon-h-align-right' ],
			],
			'default'    => 'center',
			'selectors'  => [
				'{{WRAPPER}} .starter-hero__pagination' => 'left: {{VALUE}}; transform: translateX({{VALUE}} === "center" ? "-50%" : {{VALUE}} === "left" ? "0" : "-100%");',
			],
		] );

		$this->add_responsive_control( 'pagination_align_y', [
			'label'      => esc_html__( 'Vertical Position', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::CHOOSE,
			'options'    => [
				'top'    => [ 'title' => esc_html__( 'Top', 'starter-elementor-addon' ), 'icon' => 'eicon-v-align-top' ],
				'middle' => [ 'title' => esc_html__( 'Middle', 'starter-elementor-addon' ), 'icon' => 'eicon-v-align-middle' ],
				'bottom' => [ 'title' => esc_html__( 'Bottom', 'starter-elementor-addon' ), 'icon' => 'eicon-v-align-bottom' ],
			],
			'default'    => 'bottom',
			'selectors'  => [
				'{{WRAPPER}} .starter-hero__pagination' => 'top: {{VALUE}}; bottom: auto; transform: translateY({{VALUE}} === "middle" ? "-50%" : {{VALUE}} === "top" ? "0" : "0");',
			],
		] );

		$this->add_responsive_control( 'pagination_offset_x', [
			'label'      => esc_html__( 'Horizontal Offset', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => -200, 'max' => 200 ], '%' => [ 'min' => -50, 'max' => 50 ] ],
			'default'    => [ 'size' => 0, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__pagination' => 'margin-left: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'pagination_offset_y', [
			'label'      => esc_html__( 'Vertical Offset', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => -200, 'max' => 200 ], '%' => [ 'min' => -50, 'max' => 50 ] ],
			'default'    => [ 'size' => 40, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__pagination' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'navigation_heading', [
			'label'     => esc_html__( 'Navigation Buttons', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'nav_button_size', [
			'label'      => esc_html__( 'Button Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 30, 'max' => 80 ] ],
			'default'    => [ 'size' => 44, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__button-prev, {{WRAPPER}} .starter-hero__button-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'nav_button_icon_size', [
			'label'      => esc_html__( 'Icon Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 12, 'max' => 32 ] ],
			'default'    => [ 'size' => 20, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__button-prev, {{WRAPPER}} .starter-hero__button-next' => 'font-size: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'nav_button_radius', [
			'label'      => esc_html__( 'Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 50, 'unit' => '%' ],
			'selectors'  => [ '{{WRAPPER}} .starter-hero__button-prev, {{WRAPPER}} .starter-hero__button-next' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->start_controls_tabs( 'nav_button_tabs' );

		$this->start_controls_tab( 'nav_button_tab_normal', [
			'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'nav_button_bg', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-hero__button-prev, {{WRAPPER}} .starter-hero__button-next' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'nav_button_color', [
			'label'     => esc_html__( 'Icon Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#6b7280',
			'selectors' => [ '{{WRAPPER}} .starter-hero__button-prev, {{WRAPPER}} .starter-hero__button-next' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'nav_button_box_shadow',
			'label'    => esc_html__( 'Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-hero__button-prev, {{WRAPPER}} .starter-hero__button-next',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'nav_button_tab_hover', [
			'label' => esc_html__( 'Hover', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'nav_button_hover_bg', [
			'label'     => esc_html__( 'Background Hover Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--color-primary, #EC008C)',
			'selectors' => [ '{{WRAPPER}} .starter-hero__button-prev:hover, {{WRAPPER}} .starter-hero__button-next:hover' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'nav_button_hover_color', [
			'label'     => esc_html__( 'Icon Hover Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-hero__button-prev:hover, {{WRAPPER}} .starter-hero__button-next:hover' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'nav_button_hover_box_shadow',
			'label'    => esc_html__( 'Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-hero__button-prev:hover, {{WRAPPER}} .starter-hero__button-next:hover',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		wp_enqueue_style( 'starter-starter-hero', STARTER_URL . 'widgets/starter-hero/starter-hero.css', [], STARTER_VERSION );
		wp_enqueue_script( 'starter-starter-hero', STARTER_URL . 'widgets/starter-hero/starter-hero.js', [], STARTER_VERSION, true );
		?>
		<section class="starter-hero relative overflow-hidden bg-white <?php echo ( $settings['show_bottom_wave'] === 'yes' ) ? 'starter-hero--has-wave' : ''; ?>">
			
			<!-- Decorative Background Grid Pattern -->
			<?php if ( $settings['show_dots_grid'] === 'yes' ) : ?>
			<div class="starter-hero__dot-grid absolute top-8 left-8 w-40 h-40 opacity-20 pointer-events-none z-0"></div>
			<?php endif; ?>



			<?php
				$_loop       = ( $settings['carousel_loop'] === 'yes' ) ? 'true' : 'false';
				$_effect     = ! empty( $settings['carousel_effect'] ) ? $settings['carousel_effect'] : 'slide';
				$_speed      = ! empty( $settings['carousel_speed']['size'] ) ? intval( $settings['carousel_speed']['size'] ) : 500;
				$_autoplay   = $settings['carousel_autoplay'] === 'yes';
				$_delay      = ! empty( $settings['carousel_autoplay_delay']['size'] ) ? intval( $settings['carousel_autoplay_delay']['size'] ) : 6000;
				$_pause      = ( $settings['carousel_pause_on_hover'] === 'yes' ) ? 'true' : 'false';
				$_autoplay_json = $_autoplay ? '"autoplay": { "delay": ' . $_delay . ', "disableOnInteraction": false, "pauseOnMouseEnter": ' . $_pause . ' },' : '';
				$_effect_json   = ( $_effect !== 'slide' ) ? '"effect": "' . esc_attr( $_effect ) . '",' : '';
			?>
			<div class="starter-hero__swiper swiper w-full relative z-10"
				data-swiper-config='{
					"slidesPerView": 1,
					"loop": <?php echo $_loop; ?>,
					"speed": <?php echo $_speed; ?>,
					<?php echo $_effect_json; ?>
					<?php echo $_autoplay_json; ?>
					"pagination": { "el": ".starter-hero__pagination", "clickable": true },
					"navigation": {
						"nextEl": ".starter-hero__button-next",
						"prevEl": ".starter-hero__button-prev"
					}
				}'>
				<div class="swiper-wrapper">
					<?php foreach ( $settings['hero_slides'] as $slide ) :
						$cta1_url = ! empty( $slide['cta_primary_url']['url'] ) ? esc_url( $slide['cta_primary_url']['url'] ) : '#contact';
						$cta2_url = ! empty( $slide['cta_secondary_url']['url'] ) ? esc_url( $slide['cta_secondary_url']['url'] ) : '#services';

						$has_cta1 = ! empty( $slide['cta_primary_text'] ) && ! empty( $slide['cta_primary_url']['url'] );
						$has_cta2 = ! empty( $slide['cta_secondary_text'] ) && ! empty( $slide['cta_secondary_url']['url'] );
						$has_heading = ! empty( $slide['heading_line1'] ) || ! empty( $slide['heading_highlight'] );

						// Background styles for each slide
						$slide_bg_styles = '';
						if ( ! empty( $slide['slide_bg_type'] ) ) {
							if ( $slide['slide_bg_type'] === 'color' ) {
								if ( ! empty( $slide['slide_bg_gradient_start'] ) && ! empty( $slide['slide_bg_gradient_end'] ) ) {
									$angle = ! empty( $slide['slide_bg_gradient_angle']['size'] ) ? $slide['slide_bg_gradient_angle']['size'] . 'deg' : '180deg';
									$slide_bg_styles = "background: linear-gradient({$angle}, {$slide['slide_bg_gradient_start']} 0%, {$slide['slide_bg_gradient_end']} 100%);";
								} elseif ( ! empty( $slide['slide_bg_color'] ) ) {
									$slide_bg_styles = "background-color: {$slide['slide_bg_color']};";
								}
							} elseif ( $slide['slide_bg_type'] === 'image' && ! empty( $slide['slide_bg_image']['url'] ) ) {
								$slide_bg_styles = "background-image: url('" . esc_url( $slide['slide_bg_image']['url'] ) . "'); background-size: cover; background-position: center;";
							}
						}

						// Overlay styles for each slide
						$slide_overlay_styles = '';
						if ( ! empty( $slide['slide_bg_overlay_color'] ) ) {
							$slide_overlay_styles = "background-color: {$slide['slide_bg_overlay_color']};";
						}

						$has_image = ! empty( $slide['hero_image']['url'] );
					?>
					<div class="swiper-slide relative overflow-hidden">
						<!-- Slide Background and Overlay -->
						<?php if ( ! empty( $slide_bg_styles ) ) : ?>
						<div class="starter-hero__slide-bg absolute inset-0 z-0 pointer-events-none" style="<?php echo esc_attr( $slide_bg_styles ); ?>"></div>
						<?php endif; ?>
						<?php if ( ! empty( $slide_overlay_styles ) ) : ?>
						<div class="starter-hero__slide-overlay absolute inset-0 z-0 pointer-events-none" style="<?php echo esc_attr( $slide_overlay_styles ); ?>"></div>
						<?php endif; ?>

						<div class="s-container mx-auto px-5 md:px-8 lg:px-12 relative z-10">
							<div class="starter-hero__slide-row flex flex-col lg:flex-row items-center justify-center gap-12 lg:gap-16 w-full text-left py-6 lg:py-12">
								
								<!-- Left: Content Section -->
								<div class="w-full lg:w-[var(--hero-content-width,50%)] z-10 text-center lg:text-left">
									<?php if ( ! empty( $slide['badge_text'] ) ) : ?>
									<div class="starter-hero__badge-wrapper badge-wrapper mb-6">
										<div class="starter-hero__badge inline-flex items-center gap-2 bg-primary/10 text-primary rounded-full px-4 py-2 text-sm font-semibold">
											<?php if ( ! empty( $slide['badge_icon_class'] ) ) : ?>
											<i class="starter-hero__badge-icon <?php echo esc_attr( $slide['badge_icon_class'] ); ?> ri-1x"></i>
											<?php endif; ?>
											<span class="starter-hero__badge-text"><?php echo esc_html( $slide['badge_text'] ); ?></span>
										</div>
									</div>
									<?php endif; ?>

									<?php if ( $has_heading ) : ?>
									<h1 class="starter-hero__heading font-bold leading-tight">
										<?php echo esc_html( $slide['heading_line1'] ); ?><br>
										<span class="starter-hero__highlight"><?php echo esc_html( $slide['heading_highlight'] ); ?></span>
									</h1>
									<?php endif; ?>

									<?php if ( ! empty( $slide['subtitle'] ) ) : ?>
									<p class="starter-hero__subtitle font-sriracha text-lg md:text-xl mb-4 font-light inline-flex items-center justify-center lg:justify-start gap-2">
										<span><?php echo esc_html( $slide['subtitle'] ); ?></span>
										<!-- Cute custom hand-drawn smile SVG at the end -->
										<svg class="starter-hero__smiley" width="28" height="24" viewBox="0 0 32 20" fill="none" stroke="var(--heart-color, #F43F5E)" stroke-width="2.5" stroke-linecap="round" xmlns="http://www.w3.org/2000/svg">
											<!-- Eyes -->
											<circle cx="9" cy="5" r="1.5" fill="var(--heart-color, #F43F5E)"/>
											<circle cx="23" cy="5" r="1.5" fill="var(--heart-color, #F43F5E)"/>
											<!-- Smile curve -->
											<path d="M5,10 C10,18 22,18 27,10" />
										</svg>
									</p>
									<?php endif; ?>

									<?php if ( ! empty( $slide['description'] ) ) : ?>
									<p class="starter-hero__description text-base mb-8 leading-relaxed max-w-lg mx-auto lg:mx-0 font-light">
										<?php echo esc_html( $slide['description'] ); ?>
									</p>
									<?php endif; ?>

									<!-- CTA Buttons -->
									<div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
										<?php if ( $has_cta1 ) : ?>
										<a href="<?php echo $cta1_url; ?>" class="starter-hero__btn-primary">
											<?php if ( ! empty( $slide['cta_primary_icon']['value'] ) ) : ?>
												<?php \Elementor\Icons_Manager::render_icon( $slide['cta_primary_icon'], [ 'aria-hidden' => 'true', 'style' => 'width: 18px; height: 18px; font-size: 18px; display: inline-flex; align-items: center; justify-content: center;' ] ); ?>
											<?php endif; ?>
											<span><?php echo esc_html( $slide['cta_primary_text'] ); ?></span>
										</a>
										<?php endif; ?>
										<?php if ( $has_cta2 ) : ?>
										<a href="<?php echo $cta2_url; ?>" class="starter-hero__btn-secondary">
											<?php if ( ! empty( $slide['cta_secondary_icon']['value'] ) ) : ?>
												<?php \Elementor\Icons_Manager::render_icon( $slide['cta_secondary_icon'], [ 'aria-hidden' => 'true', 'style' => 'width: 18px; height: 18px; font-size: 18px; display: inline-flex; align-items: center; justify-content: center;' ] ); ?>
											<?php endif; ?>
											<span><?php echo esc_html( $slide['cta_secondary_text'] ); ?></span>
										</a>
										<?php endif; ?>
									</div>

									<!-- Bottom Stats / Features List -->
									<?php if ( $settings['show_stats'] === 'yes' && ! empty( $settings['stats_repeater_list'] ) ) : ?>
									<div class="starter-hero__stats-list grid mt-10 relative z-20 w-full max-w-5xl">
										<?php 
										$total_stats = count( $settings['stats_repeater_list'] );
										foreach ( $settings['stats_repeater_list'] as $index => $stat ) :
											$is_last = ($index === $total_stats - 1);
											$stat_icon = ! empty( $stat['stat_icon'] ) ? $stat['stat_icon'] : '';
											$stat_label = ! empty( $stat['stat_label'] ) ? $stat['stat_label'] : '';
											$stat_value = ! empty( $stat['stat_value'] ) ? $stat['stat_value'] : '';
											$icon_bg_color = ! empty( $settings['stat_icon_bg'] ) ? $settings['stat_icon_bg'] : '#FDE3F1';
											$icon_color = ! empty( $settings['stat_icon_color'] ) ? $settings['stat_icon_color'] : '#EA4F89';
											$label_color = ! empty( $settings['stat_label_color'] ) ? $settings['stat_label_color'] : '#EA4F89';
										?>
										<div class="starter-hero__stat-item flex flex-col items-center text-center relative" style="padding: var(--stat-item-padding);">
											<?php if ( ! empty( $stat_icon ) ) : ?>
											<span class="starter-hero__stat-icon-wrap inline-flex items-center justify-center rounded-full mb-3" style="background-color: <?php echo esc_attr( $icon_bg_color ); ?>;">
												<i class="<?php echo esc_attr( $stat_icon ); ?>" style="color: <?php echo esc_attr( $icon_color ); ?>;"></i>
											</span>
											<?php endif; ?>
											<div class="leading-snug">
												<p class="starter-hero__stat-label text-sm font-bold mb-1" style="color: <?php echo esc_attr( $label_color ); ?>;"><?php echo esc_html( $stat_label ); ?></p>
												<p class="starter-hero__stat-value text-xs text-gray-500 font-normal whitespace-pre-line leading-relaxed"><?php echo esc_html( $stat_value ); ?></p>
											</div>
										</div>
										<?php endforeach; ?>
									</div>
									<?php endif; ?>
								</div>

								<!-- Right: Hero Image with Organic Mask, Glow, and Sparkles -->
								<div class="w-full lg:w-[var(--hero-image-width,50%)] relative flex justify-center lg:justify-end">
									<?php if ( $has_image ) : ?>
									<div class="relative w-full max-w-[500px] hidden lg:block">
										
										<!-- Soft background glowing blur -->
										<div class="starter-hero__image-glow absolute -inset-6 bg-pink-100 rounded-full blur-3xl opacity-60 z-0 pointer-events-none"
											style="background-color: var(--heart-color, #F43F5E); opacity: 0.12;"></div>

										<!-- The main organic-shaped image container -->
										<div class="starter-hero__image-container relative z-10 overflow-hidden hidden lg:flex items-center justify-center bg-gradient-to-tr from-[#FFF0F6] to-[#FFF5F8]">
											<img src="<?php echo esc_url( $slide['hero_image']['url'] ); ?>" 
												alt="<?php echo esc_attr( $slide['heading_line1'] ); ?>" 
												class="starter-hero__image">
										</div>

										<!-- Floating Sparkles around the frame -->
										<?php if ( $settings['show_sparkles'] === 'yes' ) : ?>
										<div class="starter-hero__floating-sparkles absolute inset-0 z-20 pointer-events-none">
											<span class="starter-hero__decor-sparkle absolute top-6 -right-6 scale-90" style="animation: twinkle 3s ease-in-out infinite;">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="var(--sparkle-color, #ffffff)"><path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.8-7.2L2 12l7.2-2.8z"/></svg>
											</span>
											<span class="starter-hero__decor-sparkle absolute bottom-20 -left-6 scale-75" style="animation: twinkle 4s ease-in-out infinite 1s;">
												<svg width="20" height="20" viewBox="0 0 24 24" fill="var(--sparkle-color, #ffffff)"><path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.8-7.2L2 12l7.2-2.8z"/></svg>
											</span>
										</div>
										<?php endif; ?>

										<!-- Optional Floating Cards (backward compatibility) -->
										<?php if ( $settings['show_float_cards'] === 'yes' ) : ?>
										<div class="absolute inset-0 z-30 pointer-events-none">
											<?php if ( ! empty( $settings['fc1_label'] ) ) : ?>
											<div class="absolute top-8 -left-4 md:-left-6 text-white rounded-2xl shadow-xl px-6 py-5 text-center pointer-events-auto"
												style="background: linear-gradient(135deg, var(--heart-color, #F43F5E), var(--color-primary, #EC008C));">
												<div class="flex items-center gap-2 mb-1">
													<i class="<?php echo esc_attr( $settings['fc1_icon'] ); ?>"></i>
													<span class="text-xs font-light opacity-80"><?php echo esc_html( $settings['fc1_label'] ); ?></span>
												</div>
												<p class="text-2xl font-black leading-none"><?php echo esc_html( $settings['fc1_value'] ); ?></p>
											</div>
											<?php endif; ?>
											
											<?php if ( ! empty( $settings['fc2_label'] ) ) : ?>
											<div class="absolute bottom-8 -right-4 md:-right-6 text-white rounded-2xl shadow-xl px-6 py-5 text-center pointer-events-auto"
												style="background: linear-gradient(135deg, var(--heart-color, #F43F5E), var(--color-primary, #EC008C));">
												<div class="flex items-center gap-2 mb-1">
													<i class="<?php echo esc_attr( $settings['fc2_icon'] ); ?>"></i>
													<span class="text-xs font-light opacity-80"><?php echo esc_html( $settings['fc2_label'] ); ?></span>
												</div>
												<p class="text-2xl font-black leading-none"><?php echo esc_html( $settings['fc2_value'] ); ?></p>
											</div>
											<?php endif; ?>
										</div>
										<?php endif; ?>

									</div>
									<?php endif; ?>
								</div>

							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>

				<!-- Static navigation and pagination -->
				<?php if ( count( $settings['hero_slides'] ) > 1 ) : ?>
				<?php if ( $settings['carousel_show_pagination'] !== 'no' ) : ?>
				<div class="starter-hero__pagination"></div>
				<?php endif; ?>
				<?php if ( $settings['carousel_show_navigation'] !== 'no' ) : ?>
				<button class="starter-hero__button-prev">
					<i class="ri-arrow-left-s-line ri-lg"></i>
				</button>
				<button class="starter-hero__button-next">
					<i class="ri-arrow-right-s-line ri-lg"></i>
				</button>
				<?php endif; ?>
				<?php endif; ?>
			</div>

			<!-- Bottom layered SVG wave swoop -->
			<?php if ( $settings['show_bottom_wave'] === 'yes' ) : ?>
			<div class="starter-hero__wave-container absolute bottom-0 left-0 w-full overflow-hidden pointer-events-none z-10">
				<svg viewBox="0 0 1440 120" preserveAspectRatio="none" class="w-full h-full block">
					<path class="starter-hero__wave-2" d="M0,64 C400,120 800,20 1200,80 C1320,95 1400,90 1440,80 L1440,120 L0,120 Z" fill="#FFE4E6" opacity="0.5"/>
					<path class="starter-hero__wave-1" d="M0,80 C360,110 720,50 1080,80 C1260,95 1380,90 1440,80 L1440,120 L0,120 Z" fill="#ffffff"/>
				</svg>
			</div>
			<?php endif; ?>

		</section>
		<?php
	}

	protected function content_template() {
		?>
		<section class="starter-hero relative overflow-hidden bg-white <# if ( settings.show_bottom_wave === 'yes' ) { #>starter-hero--has-wave<# } #>">
			
			<!-- Decorative Background Grid Pattern -->
			<# if ( settings.show_dots_grid === 'yes' ) { #>
			<div class="starter-hero__dot-grid absolute top-8 left-8 w-40 h-40 opacity-20 pointer-events-none z-0"></div>
			<# } #>



			<# 
			var _loop     = ( settings.carousel_loop === 'yes' ) ? true : false;
			var _effect   = settings.carousel_effect || 'slide';
			var _speed    = ( settings.carousel_speed && settings.carousel_speed.size ) ? settings.carousel_speed.size : 500;
			var _autoplay = settings.carousel_autoplay === 'yes';
			var _delay    = ( settings.carousel_autoplay_delay && settings.carousel_autoplay_delay.size ) ? settings.carousel_autoplay_delay.size : 6000;
			var _pause    = settings.carousel_pause_on_hover === 'yes';
			var _config   = { slidesPerView: 1, loop: _loop, speed: _speed };
			if ( _effect !== 'slide' ) _config.effect = _effect;
			if ( _autoplay ) _config.autoplay = { delay: _delay, disableOnInteraction: false, pauseOnMouseEnter: _pause };
			#>
			<div class="starter-hero__swiper swiper w-full relative z-10"
				data-swiper-config='{{ JSON.stringify( _config ) }}'>
				<div class="swiper-wrapper">
					<# _.each( settings.hero_slides, function( slide ) { 
						var cta1_url = ( slide.cta_primary_url && slide.cta_primary_url.url ) ? slide.cta_primary_url.url : '#contact';
						var cta2_url = ( slide.cta_secondary_url && slide.cta_secondary_url.url ) ? slide.cta_secondary_url.url : '#services';
						var has_image = ( slide.hero_image && slide.hero_image.url ) ? true : false;

						// Background styles for each slide
						var slide_bg_styles = '';
						if ( slide.slide_bg_type ) {
							if ( slide.slide_bg_type === 'color' ) {
								if ( slide.slide_bg_gradient_start && slide.slide_bg_gradient_end ) {
									var angle = ( slide.slide_bg_gradient_angle && slide.slide_bg_gradient_angle.size ) ? slide.slide_bg_gradient_angle.size + 'deg' : '180deg';
									slide_bg_styles = "background: linear-gradient(" + angle + ", " + slide.slide_bg_gradient_start + " 0%, " + slide.slide_bg_gradient_end + " 100%);";
								} else if ( slide.slide_bg_color ) {
									slide_bg_styles = "background-color: " + slide.slide_bg_color + ";";
								}
							} else if ( slide.slide_bg_type === 'image' && slide.slide_bg_image && slide.slide_bg_image.url ) {
								slide_bg_styles = "background-image: url('" + slide.slide_bg_image.url + "'); background-size: cover; background-position: center;";
							}
						}

						// Overlay styles for each slide
						var slide_overlay_styles = '';
						if ( slide.slide_bg_overlay_color ) {
							slide_overlay_styles = "background-color: " + slide.slide_bg_overlay_color + ";";
						}
					#>
					<div class="swiper-slide relative overflow-hidden">

						<!-- Slide Background and Overlay -->
						<# if ( slide_bg_styles ) { #>
						<div class="starter-hero__slide-bg absolute inset-0 z-0 pointer-events-none" style="{{ slide_bg_styles }}"></div>
						<# } #>
						<# if ( slide_overlay_styles ) { #>
						<div class="starter-hero__slide-overlay absolute inset-0 z-0 pointer-events-none" style="{{ slide_overlay_styles }}"></div>
						<# } #>

						<div class="s-container mx-auto px-5 md:px-8 lg:px-12 relative z-10">
							<div class="starter-hero__slide-row flex flex-col lg:flex-row items-center justify-center gap-12 lg:gap-16 w-full text-left py-6 lg:py-12">

								<!-- Left: Content Section -->
								<div class="w-full lg:w-[var(--hero-content-width,50%)] z-10 text-center lg:text-left">
									<# if ( slide.badge_text ) { #>
									<div class="starter-hero__badge-wrapper badge-wrapper mb-6">
										<div class="starter-hero__badge inline-flex items-center gap-2 bg-primary/10 text-primary rounded-full px-4 py-2 text-sm font-semibold">
											<# if ( slide.badge_icon_class ) { #>
											<i class="starter-hero__badge-icon {{ slide.badge_icon_class }} ri-1x"></i>
											<# } #>
											<span class="starter-hero__badge-text">{{{ slide.badge_text }}}</span>
										</div>
									</div>
									<# } #>

									<h1 class="starter-hero__heading font-bold leading-tight">
										{{{ slide.heading_line1 }}}<br>
										<span class="starter-hero__highlight">{{{ slide.heading_highlight }}}</span>
									</h1>

									<# if ( slide.subtitle ) { #>
									<p class="starter-hero__subtitle font-sriracha text-lg md:text-xl mb-4 font-light inline-flex items-center justify-center lg:justify-start gap-2">
										<span>{{{ slide.subtitle }}}</span>
										<!-- Cute custom hand-drawn smile SVG at the end -->
										<svg class="starter-hero__smiley" width="28" height="24" viewBox="0 0 32 20" fill="none" stroke="var(--heart-color, #F43F5E)" stroke-width="2.5" stroke-linecap="round" xmlns="http://www.w3.org/2000/svg">
											<!-- Eyes -->
											<circle cx="9" cy="5" r="1.5" fill="var(--heart-color, #F43F5E)"/>
											<circle cx="23" cy="5" r="1.5" fill="var(--heart-color, #F43F5E)"/>
											<!-- Smile curve -->
											<path d="M5,10 C10,18 22,18 27,10" />
										</svg>
									</p>
									<# } #>

									<# if ( slide.description ) { #>
									<p class="starter-hero__description text-base mb-8 leading-relaxed max-w-lg mx-auto lg:mx-0 font-light">
										{{{ slide.description }}}
									</p>
									<# } #>

									<!-- CTA Buttons -->
									<div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
										<a href="{{ cta1_url }}" class="starter-hero__btn-primary">
											<# 
											var primaryIconHTML = elementor.helpers.renderIcon( view, slide.cta_primary_icon, { 'aria-hidden': true, 'style': 'width: 18px; height: 18px; font-size: 18px; display: inline-flex; align-items: center; justify-content: center;' }, 'i', 'object' ); 
											if ( primaryIconHTML && primaryIconHTML.value ) { 
											#>
												{{{ primaryIconHTML.value }}}
											<# } #>
											<span>{{{ slide.cta_primary_text }}}</span>
										</a>
										<a href="{{ cta2_url }}" class="starter-hero__btn-secondary">
											<# 
											var secondaryIconHTML = elementor.helpers.renderIcon( view, slide.cta_secondary_icon, { 'aria-hidden': true, 'style': 'width: 18px; height: 18px; font-size: 18px; display: inline-flex; align-items: center; justify-content: center;' }, 'i', 'object' ); 
											if ( secondaryIconHTML && secondaryIconHTML.value ) { 
											#>
												{{{ secondaryIconHTML.value }}}
											<# } #>
											<span>{{{ slide.cta_secondary_text }}}</span>
										</a>
									</div>

									<!-- Bottom Stats / Features List -->
									<# if ( settings.show_stats === 'yes' && settings.stats_repeater_list && settings.stats_repeater_list.length ) { #>
									<div class="starter-hero__stats-list grid mt-10 relative z-20 w-full max-w-5xl">
										<# 
										var total_stats = settings.stats_repeater_list.length;
										_.each( settings.stats_repeater_list, function( stat, index ) {
											var is_last = (index === total_stats - 1);
											var stat_icon = stat.stat_icon || '';
											var stat_label = stat.stat_label || '';
											var stat_value = stat.stat_value || '';
										#>
										<div class="starter-hero__stat-item flex flex-col items-center text-center relative" style="padding: var(--stat-item-padding);">
											<# if ( stat_icon ) { #>
											<span class="starter-hero__stat-icon-wrap inline-flex items-center justify-center rounded-full mb-3" style="background-color: {{ settings.stat_icon_bg }};">
												<i class="{{ stat_icon }}" style="color: {{ settings.stat_icon_color }};"></i>
											</span>
											<# } #>
											<div class="leading-snug">
												<p class="starter-hero__stat-label text-sm font-bold mb-1" style="color: {{ settings.stat_label_color }};">{{{ stat_label }}}</p>
												<p class="starter-hero__stat-value text-xs text-gray-500 font-normal whitespace-pre-line leading-relaxed">{{{ stat_value }}}</p>
											</div>
										</div>
										<# }); #>
									</div>
									<# } #>
								</div>

								<!-- Right: Hero Image with Organic Mask, Glow, and Sparkles -->
								<div class="w-full lg:w-[var(--hero-image-width,50%)] relative flex justify-center lg:justify-end">
									<# if ( has_image ) { #>
									<div class="relative w-full max-w-[500px] hidden lg:block">
										
										<!-- Soft background glowing blur -->
										<div class="starter-hero__image-glow absolute -inset-6 bg-pink-100 rounded-full blur-3xl opacity-60 z-0 pointer-events-none"
											style="background-color: var(--heart-color, #F43F5E); opacity: 0.12;"></div>

										<!-- The main organic-shaped image container -->
										<div class="starter-hero__image-container relative z-10 overflow-hidden hidden lg:flex items-center justify-center bg-gradient-to-tr from-[#FFF0F6] to-[#FFF5F8]">
											<img src="{{ slide.hero_image.url }}" 
												alt="{{{ slide.heading_line1 }}}" 
												class="starter-hero__image">
										</div>

										<!-- Floating Sparkles around the frame -->
										<# if ( settings.show_sparkles === 'yes' ) { #>
										<div class="starter-hero__floating-sparkles absolute inset-0 z-20 pointer-events-none">
											<span class="starter-hero__decor-sparkle absolute top-6 -right-6 scale-90" style="animation: twinkle 3s ease-in-out infinite;">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="var(--sparkle-color, #ffffff)"><path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.8-7.2L2 12l7.2-2.8z"/></svg>
											</span>
											<span class="starter-hero__decor-sparkle absolute bottom-20 -left-6 scale-75" style="animation: twinkle 4s ease-in-out infinite 1s;">
												<svg width="20" height="20" viewBox="0 0 24 24" fill="var(--sparkle-color, #ffffff)"><path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.8-7.2L2 12l7.2-2.8z"/></svg>
											</span>
										</div>
										<# } #>



										<!-- Optional Floating Cards (backward compatibility) -->
										<# if ( settings.show_float_cards === 'yes' ) { #>
										<div class="absolute inset-0 z-30 pointer-events-none">
											<# if ( settings.fc1_label ) { #>
											<div class="absolute top-8 -left-4 md:-left-6 text-white rounded-2xl shadow-xl px-6 py-5 text-center pointer-events-auto"
												style="background: linear-gradient(135deg, var(--heart-color, #F43F5E), var(--color-primary, #EC008C));">
												<div class="flex items-center gap-2 mb-1">
													<i class="{{ settings.fc1_icon }}"></i>
													<span class="text-xs font-light opacity-80">{{{ settings.fc1_label }}}</span>
												</div>
												<p class="text-2xl font-black leading-none">{{{ settings.fc1_value }}}</p>
											</div>
											<# } #>

											<# if ( settings.fc2_label ) { #>
											<div class="absolute bottom-8 -right-4 md:-right-6 text-white rounded-2xl shadow-xl px-6 py-5 text-center pointer-events-auto"
												style="background: linear-gradient(135deg, var(--heart-color, #F43F5E), var(--color-primary, #EC008C));">
												<div class="flex items-center gap-2 mb-1">
													<i class="{{ settings.fc2_icon }}"></i>
													<span class="text-xs font-light opacity-80">{{{ settings.fc2_label }}}</span>
												</div>
												<p class="text-2xl font-black leading-none">{{{ settings.fc2_value }}}</p>
											</div>
											<# } #>
										</div>
										<# } #>
									</div>
								</div>
								<# } #>

							</div>
						</div>
					</div>
					<# } ); #>
				</div>

				<!-- Static navigation and pagination -->
				<# if ( settings.hero_slides.length > 1 ) { #>
				<# if ( settings.carousel_show_pagination !== 'no' ) { #>
				<div class="starter-hero__pagination"></div>
				<# } #>
				<# if ( settings.carousel_show_navigation !== 'no' ) { #>
				<button class="starter-hero__button-prev">
					<i class="ri-arrow-left-s-line ri-lg"></i>
				</button>
				<button class="starter-hero__button-next">
					<i class="ri-arrow-right-s-line ri-lg"></i>
				</button>
				<# } #>
				<# } #>
			</div>

			<!-- Bottom layered SVG wave swoop -->
			<# if ( settings.show_bottom_wave === 'yes' ) { #>
			<div class="starter-hero__wave-container absolute bottom-0 left-0 w-full overflow-hidden pointer-events-none z-10">
				<svg viewBox="0 0 1440 120" preserveAspectRatio="none" class="w-full h-full block">
					<path class="starter-hero__wave-2" d="M0,64 C400,120 800,20 1200,80 C1320,95 1400,90 1440,80 L1440,120 L0,120 Z" fill="#FFE4E6" opacity="0.5"/>
					<path class="starter-hero__wave-1" d="M0,80 C360,110 720,50 1080,80 C1260,95 1380,90 1440,80 L1440,120 L0,120 Z" fill="#ffffff"/>
				</svg>
			</div>
			<# } #>

		</section>
		<?php
	}
}

add_action( 'wp_enqueue_scripts', function() {
	wp_register_style(  'starter-starter-hero', STARTER_URL . 'widgets/starter-hero/starter-hero.css', [], STARTER_VERSION );
	wp_register_script( 'starter-starter-hero', STARTER_URL . 'widgets/starter-hero/starter-hero.js',  [ 'jquery', 'swiper' ], STARTER_VERSION, true );
} );
add_action( 'elementor/editor/before_enqueue_scripts', function() {
	wp_enqueue_style( 'starter-starter-hero', STARTER_URL . 'widgets/starter-hero/starter-hero.css', [], STARTER_VERSION );
} );
