<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor KU Info Cards Widget (Repeater)
 */
class STARTER_Widget_starter_Info_Cards extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 */
	public function get_name() {
		return 'starter-info-cards';
	}

	/**
	 * Get widget title
	 */
	public function get_title() {
		return esc_html__( 'KU Info Cards (Repeater)', 'starter-elementor-addon' );
	}

	/**
	 * Get widget icon
	 */
	public function get_icon() {
		return 'eicon-inner-section';
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
		return [ 'info', 'cards', 'repeater', 'features', 'services', 'columns' ];
	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'starter-starter-info-cards' ];
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {

		// =====================================================
		// CONTENT TAB - Cards Repeater
		// =====================================================
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Cards Content', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'ใส่ใจในทุกรอยยิ้ม', 'starter-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'เราให้ความสำคัญกับความต้องการของคนไข้เป็นอันดับแรก', 'starter-elementor-addon' ),
				'rows'        => 4,
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label'       => esc_html__( 'Icon', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'far fa-heart',
					'library' => 'fa-regular',
				],
			]
		);

		$repeater->add_control(
			'card_link',
			[
				'label'       => esc_html__( 'Link URL', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'starter-elementor-addon' ),
				'default'     => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'cards_list',
			[
				'label'       => esc_html__( 'Info Cards', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'title'         => esc_html__( 'ใส่ใจในทุกรอยยิ้ม', 'starter-elementor-addon' ),
						'description'   => esc_html__( 'เราให้ความสำคัญกับความต้องการของคนไข้เป็นอันดับแรก', 'starter-elementor-addon' ),
						'selected_icon' => [
							'value'     => 'far fa-heart',
							'library'   => 'fa-regular',
						],
					],
					[
						'title'         => esc_html__( 'มาตรฐานระดับสากล', 'starter-elementor-addon' ),
						'description'   => esc_html__( 'ใช้อุปกรณ์ที่ทันสมัยและวัสดุคุณภาพผ่านการคัดเลือกตามมาตรฐานเพื่อความปลอดภัย', 'starter-elementor-addon' ),
						'selected_icon' => [
							'value'     => 'fas fa-shield-alt',
							'library'   => 'fa-solid',
						],
					],
					[
						'title'         => esc_html__( 'ทีมทันตแพทย์มืออาชีพ', 'starter-elementor-addon' ),
						'description'   => esc_html__( 'ทีมทันตแพทย์เฉพาะทางประสบการณ์สูง พร้อมวางแผนการรักษาอย่างเหมาะสม', 'starter-elementor-addon' ),
						'selected_icon' => [
							'value'     => 'far fa-user',
							'library'   => 'fa-regular',
						],
					],
					[
						'title'         => esc_html__( 'รอยยิ้มที่มั่นใจ', 'starter-elementor-addon' ),
						'description'   => esc_html__( 'ช่วยให้คุณมีรอยยิ้มที่สวยงาม สุขภาพช่องปากแข็งแรง และมั่นใจในทุกวัน', 'starter-elementor-addon' ),
						'selected_icon' => [
							'value'     => 'far fa-smile',
							'library'   => 'fa-regular',
						],
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		// =====================================================
		// CONTENT TAB - Layout & Grid Controls
		// =====================================================
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Grid Layout', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Columns Grid - Responsive via CSS Variables (Rule 2.1)
		$this->add_responsive_control(
			'info_cards_cols',
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
					'{{WRAPPER}} .starter-starter-info-cards-grid' => '--starter-starter-grid-cols: {{VALUE}};',
				],
			]
		);

		// Spacing Variable Grid Gap
		$this->add_responsive_control(
			'grid_gap',
			[
				'label'      => esc_html__( 'Gap Between Cards', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 24,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-info-cards-grid' => '--starter-starter-grid-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Card Wrapper Styles
		// =====================================================
		$this->start_controls_section(
			'section_card_style',
			[
				'label' => esc_html__( 'Card Styles', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Background Color CSS Variable
		$this->add_control(
			'card_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-info-card' => '--starter-starter-card-bg-color: {{VALUE}};',
				],
			]
		);

		// Card Border Radius CSS Variable
		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 24,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-info-card' => '--starter-starter-card-border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Card Padding CSS Variable
		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Padding', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => '40',
					'right'  => '24',
					'bottom' => '40',
					'left'   => '24',
					'unit'   => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-info-card' => '--starter-starter-card-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Card Border Style
		$this->add_control(
			'card_border_width',
			[
				'label'      => esc_html__( 'Border Width', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'default'    => [
					'size' => 0,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-info-card' => '--starter-starter-card-border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#eef2f6',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-info-card' => '--starter-starter-card-border-color: {{VALUE}};',
				],
				'condition' => [
					'card_border_width[size]!' => 0,
				],
			]
		);

		// Card Box Shadow
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .starter-starter-info-card',
				'fields_options' => [
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 10,
							'blur'       => 30,
							'spread'     => 0,
							'color'      => 'rgba(0, 0, 0, 0.04)',
						],
					],
				],
			]
		);

		// Hover Shift Micro-animation (CSS Spacing Control rule)
		$this->add_responsive_control(
			'card_hover_y_offset',
			[
				'label'      => esc_html__( 'Hover Move Up (Translate Y)', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => -50,
						'max' => 0,
					],
				],
				'default'    => [
					'size' => -8,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-info-card' => '--starter-starter-card-hover-y: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Icon Styles
		// =====================================================
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon Styles', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('icon_colors_tabs');

		// Icon Normal Tab
		$this->start_controls_tab(
			'icon_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ff4a7d',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-info-card-icon' => '--starter-starter-icon-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Icon Hover Tab
		$this->start_controls_tab(
			'icon_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'starter-elementor-addon' ),
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label'     => esc_html__( 'Hover Icon Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ff2a65',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-info-card:hover .starter-starter-info-card-icon' => '--starter-starter-icon-hover-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Icon Spacing & Size CSS Variables
		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 120,
					],
				],
				'default'    => [
					'size' => 48,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-info-card-icon' => '--starter-starter-icon-size: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'icon_margin_bottom',
			[
				'label'      => esc_html__( 'Spacing Below Icon', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 20,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-info-card-icon-wrapper' => '--starter-starter-icon-spacing: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Typography & Spacing Styles
		// =====================================================
		$this->start_controls_section(
			'section_text_style',
			[
				'label' => esc_html__( 'Typography & Text Styles', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Title Styles
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
					'{{WRAPPER}} .starter-starter-info-card-title' => '--starter-starter-title-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .starter-starter-info-card-title',
				'fields_options' => [
					'font_weight' => [
						'default' => '700',
					],
					'font_size' => [
						'default' => [
							'size' => '20',
							'unit' => 'px',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'title_margin_bottom',
			[
				'label'      => esc_html__( 'Spacing Below Title', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 12,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-info-card-title' => '--starter-starter-title-margin: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Description Styles
		$this->add_control(
			'heading_description',
			[
				'label'     => esc_html__( 'Description Settings', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Description Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-info-card-desc' => '--starter-starter-desc-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .starter-starter-info-card-desc',
				'fields_options' => [
					'font_weight' => [
						'default' => '400',
					],
					'font_size' => [
						'default' => [
							'size' => '15',
							'unit' => 'px',
						],
					],
					'line_height' => [
						'default' => [
							'size' => '1.6',
							'unit' => 'em',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['cards_list'] ) ) {
			return;
		}

		$style_rules = [];

		// Grid columns (responsive)
		if ( isset( $settings['info_cards_cols'] ) && $settings['info_cards_cols'] !== '' ) {
			$style_rules[] = '--starter-starter-grid-cols: ' . absint( $settings['info_cards_cols'] );
		}
		if ( isset( $settings['info_cards_cols_tablet'] ) && $settings['info_cards_cols_tablet'] !== '' ) {
			$style_rules[] = '--starter-starter-grid-cols-tablet: ' . absint( $settings['info_cards_cols_tablet'] );
		}
		if ( isset( $settings['info_cards_cols_mobile'] ) && $settings['info_cards_cols_mobile'] !== '' ) {
			$style_rules[] = '--starter-starter-grid-cols-mobile: ' . absint( $settings['info_cards_cols_mobile'] );
		}

		// Grid Gap (responsive slider)
		foreach ( ['', '_tablet', '_mobile'] as $suffix ) {
			$gap_key = 'grid_gap' . $suffix;
			if ( ! empty( $settings[$gap_key]['size'] ) || ( isset( $settings[$gap_key]['size'] ) && $settings[$gap_key]['size'] === 0 ) ) {
				$unit = ! empty( $settings[$gap_key]['unit'] ) ? $settings[$gap_key]['unit'] : 'px';
				$style_rules[] = '--starter-starter-grid-gap' . str_replace('_', '-', $suffix) . ': ' . esc_attr( $settings[$gap_key]['size'] . $unit );
			}
		}

		// Card BG Color
		if ( ! empty( $settings['card_bg_color'] ) ) {
			$style_rules[] = '--starter-starter-card-bg-color: ' . esc_attr( $settings['card_bg_color'] );
		}

		// Card Border Radius (responsive slider)
		foreach ( ['', '_tablet', '_mobile'] as $suffix ) {
			$radius_key = 'card_border_radius' . $suffix;
			if ( ! empty( $settings[$radius_key]['size'] ) || ( isset( $settings[$radius_key]['size'] ) && $settings[$radius_key]['size'] === 0 ) ) {
				$unit = ! empty( $settings[$radius_key]['unit'] ) ? $settings[$radius_key]['unit'] : 'px';
				$style_rules[] = '--starter-starter-card-border-radius' . str_replace('_', '-', $suffix) . ': ' . esc_attr( $settings[$radius_key]['size'] . $unit );
			}
		}

		// Card Padding (responsive dimensions)
		foreach ( ['', '_tablet', '_mobile'] as $suffix ) {
			$padding_key = 'card_padding' . $suffix;
			if ( ! empty( $settings[$padding_key] ) ) {
				$pad = $settings[$padding_key];
				if ( isset( $pad['top'] ) || isset( $pad['right'] ) || isset( $pad['bottom'] ) || isset( $pad['left'] ) ) {
					$unit = ! empty( $pad['unit'] ) ? $pad['unit'] : 'px';
					$top = isset( $pad['top'] ) && $pad['top'] !== '' ? $pad['top'] : '0';
					$right = isset( $pad['right'] ) && $pad['right'] !== '' ? $pad['right'] : '0';
					$bottom = isset( $pad['bottom'] ) && $pad['bottom'] !== '' ? $pad['bottom'] : '0';
					$left = isset( $pad['left'] ) && $pad['left'] !== '' ? $pad['left'] : '0';
					
					$padding_val = sprintf( '%s%s %s%s %s%s %s%s', $top, $unit, $right, $unit, $bottom, $unit, $left, $unit );
					$style_rules[] = '--starter-starter-card-padding' . str_replace('_', '-', $suffix) . ': ' . esc_attr( $padding_val );
				}
			}
		}

		// Card Border Width & Color
		if ( ! empty( $settings['card_border_width']['size'] ) || ( isset( $settings['card_border_width']['size'] ) && $settings['card_border_width']['size'] === 0 ) ) {
			$unit = ! empty( $settings['card_border_width']['unit'] ) ? $settings['card_border_width']['unit'] : 'px';
			$style_rules[] = '--starter-starter-card-border-width: ' . esc_attr( $settings['card_border_width']['size'] . $unit );
		}
		if ( ! empty( $settings['card_border_color'] ) ) {
			$style_rules[] = '--starter-starter-card-border-color: ' . esc_attr( $settings['card_border_color'] );
		}

		// Card Hover Y Offset (responsive slider)
		foreach ( ['', '_tablet', '_mobile'] as $suffix ) {
			$hover_key = 'card_hover_y_offset' . $suffix;
			if ( ! empty( $settings[$hover_key]['size'] ) || ( isset( $settings[$hover_key]['size'] ) && $settings[$hover_key]['size'] === 0 ) ) {
				$unit = ! empty( $settings[$hover_key]['unit'] ) ? $settings[$hover_key]['unit'] : 'px';
				$style_rules[] = '--starter-starter-card-hover-y' . str_replace('_', '-', $suffix) . ': ' . esc_attr( $settings[$hover_key]['size'] . $unit );
			}
		}

		// Icon Color & Hover Color
		if ( ! empty( $settings['icon_color'] ) ) {
			$style_rules[] = '--starter-starter-icon-color: ' . esc_attr( $settings['icon_color'] );
		}
		if ( ! empty( $settings['icon_color_hover'] ) ) {
			$style_rules[] = '--starter-starter-icon-hover-color: ' . esc_attr( $settings['icon_color_hover'] );
		}

		// Icon Size (responsive slider)
		foreach ( ['', '_tablet', '_mobile'] as $suffix ) {
			$size_key = 'icon_size' . $suffix;
			if ( ! empty( $settings[$size_key]['size'] ) || ( isset( $settings[$size_key]['size'] ) && $settings[$size_key]['size'] === 0 ) ) {
				$unit = ! empty( $settings[$size_key]['unit'] ) ? $settings[$size_key]['unit'] : 'px';
				$style_rules[] = '--starter-starter-icon-size' . str_replace('_', '-', $suffix) . ': ' . esc_attr( $settings[$size_key]['size'] . $unit );
			}
		}

		// Icon Spacing (responsive slider)
		foreach ( ['', '_tablet', '_mobile'] as $suffix ) {
			$spacing_key = 'icon_margin_bottom' . $suffix;
			if ( ! empty( $settings[$spacing_key]['size'] ) || ( isset( $settings[$spacing_key]['size'] ) && $settings[$spacing_key]['size'] === 0 ) ) {
				$unit = ! empty( $settings[$spacing_key]['unit'] ) ? $settings[$spacing_key]['unit'] : 'px';
				$style_rules[] = '--starter-starter-icon-spacing' . str_replace('_', '-', $suffix) . ': ' . esc_attr( $settings[$spacing_key]['size'] . $unit );
			}
		}

		// Title Color
		if ( ! empty( $settings['title_color'] ) ) {
			$style_rules[] = '--starter-starter-title-color: ' . esc_attr( $settings['title_color'] );
		}

		// Title Margin Spacing (responsive slider)
		foreach ( ['', '_tablet', '_mobile'] as $suffix ) {
			$tmargin_key = 'title_margin_bottom' . $suffix;
			if ( ! empty( $settings[$tmargin_key]['size'] ) || ( isset( $settings[$tmargin_key]['size'] ) && $settings[$tmargin_key]['size'] === 0 ) ) {
				$unit = ! empty( $settings[$tmargin_key]['unit'] ) ? $settings[$tmargin_key]['unit'] : 'px';
				$style_rules[] = '--starter-starter-title-margin' . str_replace('_', '-', $suffix) . ': ' . esc_attr( $settings[$tmargin_key]['size'] . $unit );
			}
		}

		// Description Color
		if ( ! empty( $settings['description_color'] ) ) {
			$style_rules[] = '--starter-starter-desc-color: ' . esc_attr( $settings['description_color'] );
		}

		$style_attr = ! empty( $style_rules ) ? ' style="' . implode( '; ', $style_rules ) . ';"' : '';
		?>
		<div class="starter-starter-info-cards-grid"<?php echo $style_attr; ?>>
			<?php foreach ( $settings['cards_list'] as $index => $item ) : 
				$card_tag = 'div';
				$card_attrs = '';

				if ( ! empty( $item['card_link']['url'] ) ) {
					$card_tag = 'a';
					$this->add_link_attributes( 'card_link_' . $index, $item['card_link'] );
					$card_attrs = $this->get_render_attribute_string( 'card_link_' . $index );
				}
				
				$title = isset( $item['title'] ) ? wp_kses_post( $item['title'] ) : '';
				$desc = isset( $item['description'] ) ? wp_kses_post( $item['description'] ) : '';
				?>
				<<?php echo esc_attr( $card_tag ); ?> <?php echo $card_attrs; ?> class="starter-starter-info-card elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
					<div class="starter-starter-info-card-inner">
						<?php if ( ! empty( $item['selected_icon']['value'] ) ) : ?>
							<div class="starter-starter-info-card-icon-wrapper">
								<span class="starter-starter-info-card-icon">
									<?php \Elementor\Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $title ) ) : ?>
							<h3 class="starter-starter-info-card-title"><?php echo $title; ?></h3>
						<?php endif; ?>

						<?php if ( ! empty( $desc ) ) : ?>
							<p class="starter-starter-info-card-desc"><?php echo $desc; ?></p>
						<?php endif; ?>
					</div>
				</<?php echo esc_attr( $card_tag ); ?>>
			<?php endforeach; ?>
		</div>
		<?php
	}

	/**
	 * Render widget output in the editor (Dual-Rendering Synchronization Rule)
	 */
	protected function content_template() {
		?>
		<# if ( settings.cards_list && settings.cards_list.length ) {
			var style_rules = [];

			// Grid columns (responsive)
			if ( settings.info_cards_cols ) {
				style_rules.push('--starter-starter-grid-cols: ' + settings.info_cards_cols);
			}
			if ( settings.info_cards_cols_tablet ) {
				style_rules.push('--starter-starter-grid-cols-tablet: ' + settings.info_cards_cols_tablet);
			}
			if ( settings.info_cards_cols_mobile ) {
				style_rules.push('--starter-starter-grid-cols-mobile: ' + settings.info_cards_cols_mobile);
			}

			// Grid Gap (responsive slider)
			var suffixes = ['', '_tablet', '_mobile'];
			_.each(suffixes, function(suffix) {
				var gap_key = 'grid_gap' + suffix;
				var val = settings[gap_key];
				if ( val && (val.size || val.size === 0 || val.size === '0') && val.size !== '' ) {
					var unit = val.unit || 'px';
					var css_suffix = suffix.replace('_', '-');
					style_rules.push('--starter-starter-grid-gap' + css_suffix + ': ' + val.size + unit);
				}
			});

			// Card BG Color
			if ( settings.card_bg_color ) {
				style_rules.push('--starter-starter-card-bg-color: ' + settings.card_bg_color);
			}

			// Card Border Radius (responsive slider)
			_.each(suffixes, function(suffix) {
				var radius_key = 'card_border_radius' + suffix;
				var val = settings[radius_key];
				if ( val && (val.size || val.size === 0 || val.size === '0') && val.size !== '' ) {
					var unit = val.unit || 'px';
					var css_suffix = suffix.replace('_', '-');
					style_rules.push('--starter-starter-card-border-radius' + css_suffix + ': ' + val.size + unit);
				}
			});

			// Card Padding (responsive dimensions)
			_.each(suffixes, function(suffix) {
				var padding_key = 'card_padding' + suffix;
				var pad = settings[padding_key];
				if ( pad && (pad.top || pad.right || pad.bottom || pad.left || pad.top === 0 || pad.right === 0 || pad.bottom === 0 || pad.left === 0 || pad.top === '0' || pad.right === '0' || pad.bottom === '0' || pad.left === '0') ) {
					var unit = pad.unit || 'px';
					var top = (pad.top !== undefined && pad.top !== '') ? pad.top : '0';
					var right = (pad.right !== undefined && pad.right !== '') ? pad.right : '0';
					var bottom = (pad.bottom !== undefined && pad.bottom !== '') ? pad.bottom : '0';
					var left = (pad.left !== undefined && pad.left !== '') ? pad.left : '0';
					var css_suffix = suffix.replace('_', '-');
					style_rules.push('--starter-starter-card-padding' + css_suffix + ': ' + top + unit + ' ' + right + unit + ' ' + bottom + unit + ' ' + left + unit);
				}
			});

			// Card Border Width & Color
			if ( settings.card_border_width && (settings.card_border_width.size || settings.card_border_width.size === 0 || settings.card_border_width.size === '0') && settings.card_border_width.size !== '' ) {
				var unit = settings.card_border_width.unit || 'px';
				style_rules.push('--starter-starter-card-border-width: ' + settings.card_border_width.size + unit);
			}
			if ( settings.card_border_color ) {
				style_rules.push('--starter-starter-card-border-color: ' + settings.card_border_color);
			}

			// Card Hover Y Offset (responsive slider)
			_.each(suffixes, function(suffix) {
				var hover_key = 'card_hover_y_offset' + suffix;
				var val = settings[hover_key];
				if ( val && (val.size || val.size === 0 || val.size === '0') && val.size !== '' ) {
					var unit = val.unit || 'px';
					var css_suffix = suffix.replace('_', '-');
					style_rules.push('--starter-starter-card-hover-y' + css_suffix + ': ' + val.size + unit);
				}
			});

			// Icon Color & Hover Color
			if ( settings.icon_color ) {
				style_rules.push('--starter-starter-icon-color: ' + settings.icon_color);
			}
			if ( settings.icon_color_hover ) {
				style_rules.push('--starter-starter-icon-hover-color: ' + settings.icon_color_hover);
			}

			// Icon Size (responsive slider)
			_.each(suffixes, function(suffix) {
				var size_key = 'icon_size' + suffix;
				var val = settings[size_key];
				if ( val && (val.size || val.size === 0 || val.size === '0') && val.size !== '' ) {
					var unit = val.unit || 'px';
					var css_suffix = suffix.replace('_', '-');
					style_rules.push('--starter-starter-icon-size' + css_suffix + ': ' + val.size + unit);
				}
			});

			// Icon Spacing (responsive slider)
			_.each(suffixes, function(suffix) {
				var spacing_key = 'icon_margin_bottom' + suffix;
				var val = settings[spacing_key];
				if ( val && (val.size || val.size === 0 || val.size === '0') && val.size !== '' ) {
					var unit = val.unit || 'px';
					var css_suffix = suffix.replace('_', '-');
					style_rules.push('--starter-starter-icon-spacing' + css_suffix + ': ' + val.size + unit);
				}
			});

			// Title Color
			if ( settings.title_color ) {
				style_rules.push('--starter-starter-title-color: ' + settings.title_color);
			}

			// Title Margin Spacing (responsive slider)
			_.each(suffixes, function(suffix) {
				var tmargin_key = 'title_margin_bottom' + suffix;
				var val = settings[tmargin_key];
				if ( val && (val.size || val.size === 0 || val.size === '0') && val.size !== '' ) {
					var unit = val.unit || 'px';
					var css_suffix = suffix.replace('_', '-');
					style_rules.push('--starter-starter-title-margin' + css_suffix + ': ' + val.size + unit);
				}
			});

			// Description Color
			if ( settings.description_color ) {
				style_rules.push('--starter-starter-desc-color: ' + settings.description_color);
			}

			var style_attr = style_rules.length ? ' style="' + style_rules.join('; ') + ';"' : '';
		#>
		<div class="starter-starter-info-cards-grid"{{{ style_attr }}}>
			<# _.each( settings.cards_list, function( item, index ) {
				var card_tag = 'div';
				var card_attrs = '';
				if ( item.card_link && item.card_link.url ) {
					card_tag = 'a';
					card_attrs = ' href="' + _.escape( item.card_link.url ) + '"' + ( item.card_link.is_external ? ' target="_blank"' : '' ) + ( item.card_link.nofollow ? ' rel="nofollow"' : '' );
				}
				
				// Get Icon HTML
				var iconHTML = '';
				if ( item.selected_icon && item.selected_icon.value ) {
					iconHTML = elementor.helpers.renderIcon( view, item.selected_icon, { 'aria-hidden': true }, 'i', 'object' );
				}
			#>
			<{{{ card_tag }}}{{{ card_attrs }}} class="starter-starter-info-card elementor-repeater-item-{{ item._id }}">
				<div class="starter-starter-info-card-inner">
					<# if ( item.selected_icon && item.selected_icon.value ) { #>
						<div class="starter-starter-info-card-icon-wrapper">
							<span class="starter-starter-info-card-icon">
								<# if ( iconHTML && iconHTML.rendered ) { #>
									{{{ iconHTML.value }}}
								<# } else { #>
									<i class="{{{ item.selected_icon.value }}}" aria-hidden="true"></i>
								<# } #>
							</span>
						</div>
					<# } #>

					<# if ( item.title ) { #>
						<h3 class="starter-starter-info-card-title">{{{ item.title }}}</h3>
					<# } #>

					<# if ( item.description ) { #>
						<p class="starter-starter-info-card-desc">{{{ item.description }}}</p>
					<# } #>
				</div>
			</{{{ card_tag }}}>
			<# } ); #>
		</div>
		<# } #>
		<?php
	}
}

add_action( 'wp_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-info-cards/starter-info-cards.css';
	wp_register_style(
		'starter-starter-info-cards',
		STARTER_URL . 'widgets/starter-info-cards/starter-info-cards.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );

add_action( 'elementor/editor/after_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-info-cards/starter-info-cards.css';
	wp_enqueue_style(
		'starter-starter-info-cards',
		STARTER_URL . 'widgets/starter-info-cards/starter-info-cards.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );
