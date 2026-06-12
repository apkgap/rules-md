<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * STARTER_Widget_starter_Accordion
 *
 * Custom Elementor Widget for responsive Q&A accordion section.
 * Supports individual item icons, customizable open modes, and dynamic styling controls.
 *
 * @package starter-elementor-addon
 */
class STARTER_Widget_starter_Accordion extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'starter-accordion';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'KU Accordion Q&A', 'starter-elementor-addon' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-accordion';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array
	 */
	public function get_categories() {
		return [ 'starter-elementor-addon' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return [ 'accordion', 'q&a', 'faq', 'question', 'answer', 'toggle' ];
	}

	/**
	 * Enqueue styles.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return [ 'starter-starter-accordion' ];
	}

	/**
	 * Enqueue scripts.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'starter-starter-accordion' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {

		// ==========================================
		// CONTENT TAB
		// ==========================================

		// Section: Q&A Items
		$this->start_controls_section( 'section_items', [
			'label' => esc_html__( 'Q&A Items', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'question', [
			'label'       => esc_html__( 'Question Text', 'starter-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'คำถามทั่วไปของคุณคืออะไร?',
			'label_block' => true,
		] );

		$repeater->add_control( 'answer', [
			'label'   => esc_html__( 'Answer Content', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::WYSIWYG,
			'default' => 'นี่คือกล่องข้อความคำตอบจำลองสำหรับอธิบายคำถามที่คุณต้องการชี้แจง คุณสามารถปรับแต่งข้อความ สี ขนาด และใส่องค์ประกอบอื่นๆ เข้ามาได้',
		] );

		$repeater->add_control( 'selected_icon', [
			'label'            => esc_html__( 'Item Icon', 'starter-elementor-addon' ),
			'type'             => \Elementor\Controls_Manager::ICONS,
			'fa4compatibility' => 'icon',
			'default'          => [
				'value'   => 'ri-questionnaire-line',
				'library' => 'remixicon',
			],
		] );

		$repeater->add_control( 'icon_class', [
			'label'       => esc_html__( 'Icon Class (Fallback)', 'starter-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '',
			'description' => esc_html__( 'Input custom Remixicon or fontawesome class if selected icon isn\'t loading.', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'accordion_items', [
			'label'       => esc_html__( 'Accordion Items', 'starter-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'question'      => function_exists( 'cttm_text' ) ? cttm_text( 'คลินิกทันตกรรมเปิดทำการวันไหนและเวลาใดบ้าง?', 'What are the clinic\'s opening hours?' ) : 'คลินิกทันตกรรมเปิดทำการวันไหนและเวลาใดบ้าง?',
					'selected_icon' => [ 'value' => 'ri-time-line', 'library' => 'remixicon' ],
				],
				[
					'question'      => function_exists( 'cttm_text' ) ? cttm_text( 'สามารถทำการจองคิวออนไลน์ล่วงหน้าได้หรือไม่?', 'Can I make an appointment online in advance?' ) : 'สามารถทำการจองคิวออนไลน์ล่วงหน้าได้หรือไม่?',
					'selected_icon' => [ 'value' => 'ri-calendar-todo-line', 'library' => 'remixicon' ],
				],
				[
					'question'      => function_exists( 'cttm_text' ) ? cttm_text( 'มีบริการที่จอดรถสำหรับคนไข้หรือไม่?', 'Is there parking space available for patients?' ) : 'มีบริการที่จอดรถสำหรับคนไข้หรือไม่?',
					'selected_icon' => [ 'value' => 'ri-parking-box-line', 'library' => 'remixicon' ],
				],
			],
			'title_field' => '{{{ question }}}',
		] );

		$this->end_controls_section();

		// Section: Settings
		$this->start_controls_section( 'section_settings', [
			'label' => esc_html__( 'Behavior Settings', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'multi_open', [
			'label'        => esc_html__( 'Allow Multiple Open', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'No', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'no',
			'description'  => esc_html__( 'Allow keeping multiple accordion items open at the same time.', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'default_open_index', [
			'label'       => esc_html__( 'Default Open Item Index', 'starter-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::NUMBER,
			'min'         => 0,
			'default'     => 1,
			'description' => esc_html__( 'Index of the item to be open by default (e.g. 1 for first item, 0 to close all by default).', 'starter-elementor-addon' ),
		] );

		$this->end_controls_section();


		// ==========================================
		// STYLE TAB
		// ==========================================

		// Style: General Wrapper
		$this->start_controls_section( 'style_wrapper', [
			'label' => esc_html__( 'General / Wrapper', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'items_gap', [
			'label'      => esc_html__( 'Gap between Items', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-accordion' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'wrapper_padding', [
			'label'      => esc_html__( 'Wrapper Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem', '%' ],
			'selectors'  => [ '{{WRAPPER}} .starter-accordion' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'wrapper_bg_color', [
			'label'     => esc_html__( 'Wrapper Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-accordion' => 'background-color: {{VALUE}};' ],
		] );

		$this->end_controls_section();

		// Style: Item Block
		$this->start_controls_section( 'style_item', [
			'label' => esc_html__( 'Accordion Item', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->start_controls_tabs( 'item_tabs' );

		$this->start_controls_tab( 'item_normal_tab', [
			'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'item_bg_color', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#F9FAFB',
			'selectors' => [ '{{WRAPPER}} .starter-accordion__item' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
			'name'     => 'item_border',
			'label'    => esc_html__( 'Border', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-accordion__item',
		] );

		$this->add_responsive_control( 'item_radius', [
			'label'      => esc_html__( 'Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'rem' ],
			'default'    => [
				'top'      => '16',
				'right'    => '16',
				'bottom'   => '16',
				'left'     => '16',
				'unit'     => 'px',
				'isLinked' => true,
			],
			'selectors'  => [ '{{WRAPPER}} .starter-accordion__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'item_box_shadow',
			'label'    => esc_html__( 'Box Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-accordion__item',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'item_active_tab', [
			'label' => esc_html__( 'Active', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'item_active_bg_color', [
			'label'     => esc_html__( 'Background Color (Active)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-accordion__item--active' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
			'name'     => 'item_active_border',
			'label'    => esc_html__( 'Border (Active)', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-accordion__item--active',
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'item_active_box_shadow',
			'label'    => esc_html__( 'Box Shadow (Active)', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-accordion__item--active',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// Style: Header (Question)
		$this->start_controls_section( 'style_header', [
			'label' => esc_html__( 'Question Header', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'header_typography',
			'label'    => esc_html__( 'Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-accordion__question-text',
		] );

		$this->add_responsive_control( 'header_padding', [
			'label'      => esc_html__( 'Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [
				'top'      => '20',
				'right'    => '24',
				'bottom'   => '20',
				'left'     => '24',
				'unit'     => 'px',
				'isLinked' => false,
			],
			'selectors'  => [ '{{WRAPPER}} .starter-accordion__header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->start_controls_tabs( 'header_colors' );

		$this->start_controls_tab( 'header_normal_tab', [
			'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'header_text_color', [
			'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#111827',
			'selectors' => [ '{{WRAPPER}} .starter-accordion__question-text' => 'color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'header_hover_tab', [
			'label' => esc_html__( 'Hover', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'header_text_hover_color', [
			'label'     => esc_html__( 'Text Color (Hover)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-accordion__header:hover .starter-accordion__question-text' => 'color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'header_active_tab', [
			'label' => esc_html__( 'Active', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'header_text_active_color', [
			'label'     => esc_html__( 'Text Color (Active)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-accordion__item--active .starter-accordion__question-text' => 'color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// Style: Question Icon
		$this->start_controls_section( 'style_icon', [
			'label' => esc_html__( 'Question Icon', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'icon_position', [
			'label'   => esc_html__( 'Icon Position', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'left',
			'options' => [
				'left'  => esc_html__( 'Before (Left)', 'starter-elementor-addon' ),
				'right' => esc_html__( 'After (Right)', 'starter-elementor-addon' ),
			],
		] );

		$this->add_responsive_control( 'icon_size', [
			'label'      => esc_html__( 'Icon Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 12, 'max' => 36 ] ],
			'default'    => [ 'size' => 20, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-accordion__question-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .starter-accordion__question-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'icon_spacing', [
			'label'      => esc_html__( 'Spacing to Text', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 4, 'max' => 30 ] ],
			'default'    => [ 'size' => 12, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-accordion__header--icon-left .starter-accordion__question-icon'  => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',
				'{{WRAPPER}} .starter-accordion__header--icon-right .starter-accordion__question-icon' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
			],
		] );

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab( 'icon_normal_tab', [
			'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'icon_color', [
			'label'     => esc_html__( 'Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [ '{{WRAPPER}} .starter-accordion__question-icon' => 'color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'icon_active_tab', [
			'label' => esc_html__( 'Active / Hover', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'icon_active_color', [
			'label'     => esc_html__( 'Color (Active)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [
				'{{WRAPPER}} .starter-accordion__item--active .starter-accordion__question-icon' => 'color: {{VALUE}};',
				'{{WRAPPER}} .starter-accordion__header:hover .starter-accordion__question-icon' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// Style: Toggle Indicator (Chevron / Plus-Minus)
		$this->start_controls_section( 'style_toggle', [
			'label' => esc_html__( 'Toggle Indicator', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'toggle_type', [
			'label'   => esc_html__( 'Indicator Style', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'chevron',
			'options' => [
				'chevron' => esc_html__( 'Chevron Icon', 'starter-elementor-addon' ),
				'plus'    => esc_html__( 'Plus / Minus', 'starter-elementor-addon' ),
				'none'    => esc_html__( 'None', 'starter-elementor-addon' ),
			],
		] );

		$this->add_responsive_control( 'toggle_size', [
			'label'      => esc_html__( 'Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 30 ] ],
			'default'    => [ 'size' => 16, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-accordion__toggle-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .starter-accordion__toggle-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .starter-accordion__toggle-plus'     => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
			'condition'  => [
				'toggle_type!' => 'none',
			],
		] );

		$this->start_controls_tabs( 'toggle_colors' );

		$this->start_controls_tab( 'toggle_normal_tab', [
			'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'toggle_color', [
			'label'     => esc_html__( 'Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#9CA3AF',
			'selectors' => [
				'{{WRAPPER}} .starter-accordion__toggle-icon'           => 'color: {{VALUE}};',
				'{{WRAPPER}} .starter-accordion__toggle-plus::before'  => 'background-color: {{VALUE}};',
				'{{WRAPPER}} .starter-accordion__toggle-plus::after'   => 'background-color: {{VALUE}};',
			],
			'condition' => [
				'toggle_type!' => 'none',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'toggle_active_tab', [
			'label' => esc_html__( 'Active / Hover', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'toggle_active_color', [
			'label'     => esc_html__( 'Color (Active)', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--primary)',
			'selectors' => [
				'{{WRAPPER}} .starter-accordion__item--active .starter-accordion__toggle-icon'          => 'color: {{VALUE}};',
				'{{WRAPPER}} .starter-accordion__header:hover .starter-accordion__toggle-icon'          => 'color: {{VALUE}};',
				'{{WRAPPER}} .starter-accordion__item--active .starter-accordion__toggle-plus::before' => 'background-color: {{VALUE}};',
				'{{WRAPPER}} .starter-accordion__item--active .starter-accordion__toggle-plus::after'  => 'background-color: {{VALUE}};',
				'{{WRAPPER}} .starter-accordion__header:hover .starter-accordion__toggle-plus::before' => 'background-color: {{VALUE}};',
				'{{WRAPPER}} .starter-accordion__header:hover .starter-accordion__toggle-plus::after'  => 'background-color: {{VALUE}};',
			],
			'condition' => [
				'toggle_type!' => 'none',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// Style: Answer Content
		$this->start_controls_section( 'style_content', [
			'label' => esc_html__( 'Answer Content', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'content_typography',
			'label'    => esc_html__( 'Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-accordion__answer',
		] );

		$this->add_responsive_control( 'content_padding', [
			'label'      => esc_html__( 'Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [
				'top'      => '0',
				'right'    => '24',
				'bottom'   => '24',
				'left'     => '24',
				'unit'     => 'px',
				'isLinked' => false,
			],
			'selectors'  => [ '{{WRAPPER}} .starter-accordion__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'content_bg_color', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .starter-accordion__content-wrapper' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'content_text_color', [
			'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#4B5563',
			'selectors' => [ '{{WRAPPER}} .starter-accordion__answer' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'show_divider', [
			'label'        => esc_html__( 'Divider Line (Header & Content)', 'starter-elementor-addon' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Show', 'starter-elementor-addon' ),
			'label_off'    => esc_html__( 'Hide', 'starter-elementor-addon' ),
			'return_value' => 'yes',
			'default'      => 'no',
		] );

		$this->add_control( 'divider_color', [
			'label'     => esc_html__( 'Divider Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#E5E7EB',
			'selectors' => [ '{{WRAPPER}} .starter-accordion__content-wrapper' => 'border-top: 1px solid {{VALUE}};' ],
			'condition' => [
				'show_divider' => 'yes',
			],
		] );

		$this->add_responsive_control( 'divider_margin', [
			'label'      => esc_html__( 'Divider Margin', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [
				'top'      => '0',
				'right'    => '24',
				'bottom'   => '16',
				'left'     => '24',
				'unit'     => 'px',
				'isLinked' => false,
			],
			'selectors'  => [ '{{WRAPPER}} .starter-accordion__content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			'condition'  => [
				'show_divider' => 'yes',
			],
		] );

		$this->end_controls_section();
	}

	/**
	 * Render widget frontend HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		// Ensure asset registration enqueuing works cleanly.
		wp_enqueue_style( 'starter-starter-accordion', STARTER_URL . 'widgets/starter-accordion/starter-accordion.css', [], STARTER_VERSION );
		wp_enqueue_script( 'starter-starter-accordion', STARTER_URL . 'widgets/starter-accordion/starter-accordion.js', [ 'jquery' ], STARTER_VERSION, true );

		$accordion_items = ! empty( $settings['accordion_items'] ) ? $settings['accordion_items'] : [];

		if ( empty( $accordion_items ) ) {
			return;
		}

		$multi_open   = 'yes' === $settings['multi_open'] ? 'true' : 'false';
		$default_open = isset( $settings['default_open_index'] ) ? intval( $settings['default_open_index'] ) : 1;

		?>
		<div class="starter-accordion" data-multi-open="<?php echo esc_attr( $multi_open ); ?>" data-default-open="<?php echo esc_attr( $default_open ); ?>">
			<?php
			foreach ( $accordion_items as $index => $item ) {
				// Pass fields to the separate card component via set_query_var
				set_query_var( 'accordion_item', $item );
				set_query_var( 'accordion_index', $index + 1 ); // 1-indexed for matching behavior
				set_query_var( 'accordion_settings', $settings );

				include STARTER_PATH . 'widgets/starter-accordion/card.php';
			}
			?>
		</div>
		<?php
	}

	/**
	 * Render live editor preview using Underscore.js template.
	 */
	protected function content_template() {
		?>
		<#
		var accordion_items = settings.accordion_items ? settings.accordion_items : [];
		if ( accordion_items.length ) {
			var multi_open = settings.multi_open === 'yes' ? 'true' : 'false';
			var default_open = settings.default_open_index !== undefined ? settings.default_open_index : 1;
		#>
		<div class="starter-accordion" data-multi-open="{{ multi_open }}" data-default-open="{{ default_open }}">
			<# _.each( accordion_items, function( item, index ) {
				var itemIndex = index + 1;
				var isActiveClass = ( itemIndex === parseInt( default_open ) ) ? ' starter-accordion__item--active' : '';
				var isContentStyle = ( itemIndex === parseInt( default_open ) ) ? 'display: block;' : 'display: none;';
				
				var headerClass = 'starter-accordion__header';
				if ( settings.icon_position === 'right' ) {
					headerClass += ' starter-accordion__header--icon-right';
				} else {
					headerClass += ' starter-accordion__header--icon-left';
				}

				// Item icon
				var iconHtml = '';
				if ( item.selected_icon && item.selected_icon.value ) {
					var iconRender = elementor.helpers.renderIcon( view, item.selected_icon, { 'aria-hidden': true }, 'i', 'object' );
					if ( iconRender && iconRender.value ) {
						iconHtml = iconRender.value;
					}
				} else if ( item.icon_class ) {
					iconHtml = '<i class="' + item.icon_class + '" aria-hidden="true"></i>';
				}
			#>
			<div class="starter-accordion__item{{ isActiveClass }}" data-index="{{ itemIndex }}">
				<button class="{{ headerClass }}" aria-expanded="{{ ( itemIndex === parseInt( default_open ) ) ? 'true' : 'false' }}">
					
					<# if ( settings.icon_position === 'left' && iconHtml ) { #>
					<span class="starter-accordion__question-icon">
						{{{ iconHtml }}}
					</span>
					<# } #>

					<span class="starter-accordion__question-text">{{{ item.question }}}</span>

					<# if ( settings.icon_position === 'right' && iconHtml ) { #>
					<span class="starter-accordion__question-icon">
						{{{ iconHtml }}}
					</span>
					<# } #>

					<# if ( settings.toggle_type === 'chevron' ) { #>
					<span class="starter-accordion__toggle-icon">
						<i class="ri-arrow-down-s-line" aria-hidden="true"></i>
					</span>
					<# } else if ( settings.toggle_type === 'plus' ) { #>
					<span class="starter-accordion__toggle-plus"></span>
					<# } #>
				</button>

				<div class="starter-accordion__content-wrapper" style="{{ isContentStyle }}">
					<div class="starter-accordion__content">
						<div class="starter-accordion__answer">{{{ item.answer }}}</div>
					</div>
				</div>
			</div>
			<# } ); #>
		</div>
		<# } #>
		<?php
	}
}

// Register style and script locally with Starter Elementor Addon
add_action( 'wp_enqueue_scripts', function() {
	wp_register_style(  'starter-starter-accordion', STARTER_URL . 'widgets/starter-accordion/starter-accordion.css', [], STARTER_VERSION );
	wp_register_script( 'starter-starter-accordion', STARTER_URL . 'widgets/starter-accordion/starter-accordion.js',  [ 'jquery' ], STARTER_VERSION, true );
} );
add_action( 'elementor/editor/before_enqueue_scripts', function() {
	wp_enqueue_style( 'starter-starter-accordion', STARTER_URL . 'widgets/starter-accordion/starter-accordion.css', [], STARTER_VERSION );
} );
