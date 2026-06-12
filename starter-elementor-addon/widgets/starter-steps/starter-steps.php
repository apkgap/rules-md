<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor KU Steps Widget
 */
class STARTER_Widget_starter_Steps extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 */
	public function get_name() {
		return 'starter-steps';
	}

	/**
	 * Get widget title
	 */
	public function get_title() {
		return esc_html__( 'KU Treatment Steps', 'starter-elementor-addon' );
	}

	/**
	 * Get widget icon
	 */
	public function get_icon() {
		return 'eicon-editor-list-ol';
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
		return [ 'steps', 'process', 'treatment', 'workflow', 'timeline', 'columns' ];
	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'starter-starter-steps' ];
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {

		// =====================================================
		// CONTENT TAB - Section Header
		// =====================================================
		$this->start_controls_section(
			'section_header_settings',
			[
				'label' => esc_html__( 'Section Header', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_header',
			[
				'label'     => esc_html__( 'Show Section Title', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'starter-elementor-addon' ),
				'label_off' => esc_html__( 'Hide', 'starter-elementor-addon' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'header_title',
			[
				'label'       => esc_html__( 'Title text', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'ขั้นตอนการรักษา', 'starter-elementor-addon' ),
				'label_block' => true,
				'condition'   => [
					'show_header' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// CONTENT TAB - Steps Content Repeater
		// =====================================================
		$this->start_controls_section(
			'section_steps_content',
			[
				'label' => esc_html__( 'Steps Configuration', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Step Title', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'หัวข้อขั้นตอน', 'starter-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'   => esc_html__( 'Step Description', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'รายละเอียดเนื้อหาจำลองบางส่วนเพื่ออธิบายการทำงานในขั้นตอนนี้', 'starter-elementor-addon' ),
				'rows'    => 3,
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label'       => esc_html__( 'Main Icon', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'far fa-comment-dots',
					'library' => 'fa-regular',
				],
			]
		);

		$repeater->add_control(
			'badge_icon',
			[
				'label'       => esc_html__( 'Top Floating Badge Icon', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-heart',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'steps_list',
			[
				'label'       => esc_html__( 'Treatment Steps', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'title'       => esc_html__( 'ปรึกษาและประเมิน', 'starter-elementor-addon' ),
						'description' => esc_html__( 'พูดคุยและประเมินปัญหาโดยทันตแพทย์', 'starter-elementor-addon' ),
						'selected_icon' => [ 'value' => 'far fa-comment-dots', 'library' => 'fa-regular' ],
						'badge_icon'  => [ 'value' => 'fas fa-heart', 'library' => 'fa-solid' ],
					],
					[
						'title'       => esc_html__( 'ตรวจวินิจฉัย', 'starter-elementor-addon' ),
						'description' => esc_html__( 'เอกซเรย์และตรวจช่องปากเพื่อวางแผนการรักษา', 'starter-elementor-addon' ),
						'selected_icon' => [ 'value' => 'far fa-window-close', 'library' => 'fa-regular' ],
						'badge_icon'  => [ 'value' => 'fas fa-shield-alt', 'library' => 'fa-solid' ],
					],
					[
						'title'       => esc_html__( 'วางแผนการรักษา', 'starter-elementor-addon' ),
						'description' => esc_html__( 'ทันตแพทย์แนะนำแผนการรักษาที่เหมาะสมกับคุณ', 'starter-elementor-addon' ),
						'selected_icon' => [ 'value' => 'far fa-clipboard', 'library' => 'fa-regular' ],
						'badge_icon'  => [ 'value' => 'fas fa-user-md', 'library' => 'fa-solid' ],
					],
					[
						'title'       => esc_html__( 'เข้ารับการรักษา', 'starter-elementor-addon' ),
						'description' => esc_html__( 'ดำเนินการรักษาด้วยมาตรฐานและความใส่ใจ', 'starter-elementor-addon' ),
						'selected_icon' => [ 'value' => 'fas fa-teeth', 'library' => 'fa-solid' ],
						'badge_icon'  => [ 'value' => 'fas fa-check', 'library' => 'fa-solid' ],
					],
					[
						'title'       => esc_html__( 'ติดตามผล', 'starter-elementor-addon' ),
						'description' => esc_html__( 'นัดตรวจติดตามอาการและดูแลต่อเนื่อง', 'starter-elementor-addon' ),
						'selected_icon' => [ 'value' => 'far fa-heart', 'library' => 'fa-regular' ],
						'badge_icon'  => [ 'value' => 'fas fa-star', 'library' => 'fa-solid' ],
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		// =====================================================
		// CONTENT TAB - Grid & Layout
		// =====================================================
		$this->start_controls_section(
			'section_layout_settings',
			[
				'label' => esc_html__( 'Responsive Grid Spacing', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Grid Columns', 'starter-elementor-addon' ),
				'type'           => \Elementor\Controls_Manager::SELECT,
				'default'        => '5',
				'tablet_default' => '3',
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
					'{{WRAPPER}} .starter-starter-steps-grid' => '--starter-starter-steps-cols: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_gap',
			[
				'label'      => esc_html__( 'Step Column Gap', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 150 ],
				],
				'default'    => [ 'size' => 20, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-steps-grid' => '--starter-starter-steps-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Section Title Style
		// =====================================================
		$this->start_controls_section(
			'style_header',
			[
				'label'     => esc_html__( 'Section Header Style', 'starter-elementor-addon' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_header' => 'yes',
				],
			]
		);

		$this->add_control(
			'header_color',
			[
				'label'     => esc_html__( 'Title Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-steps-header__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'header_typography',
				'selector' => '{{WRAPPER}} .starter-starter-steps-header__title',
			]
		);

		$this->add_responsive_control(
			'header_margin_bottom',
			[
				'label'      => esc_html__( 'Margin Below Title', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'size' => 48, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-steps-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Circular Rings & Connecting Lines
		// =====================================================
		$this->start_controls_section(
			'style_circles_lines',
			[
				'label' => esc_html__( 'Circles & Spacing Lines', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'circle_bg',
			[
				'label'     => esc_html__( 'Ring Background', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#fffcfd',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-steps__circle' => '--starter-starter-ststarter-circle-bg: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'circle_border_inner',
			[
				'label'     => esc_html__( 'Inner Circle Border Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(236, 0, 140, 0.12)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-steps__circle' => '--starter-starter-ststarter-border-inner: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'circle_border_outer',
			[
				'label'     => esc_html__( 'Outer Circle Border Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(236, 0, 140, 0.35)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-steps__circle' => '--starter-starter-ststarter-border-outer: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'circle_border_hover',
			[
				'label'     => esc_html__( 'Hover/Active Ring Border Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'var(--color-primary, #EC008C)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-steps__item:hover .starter-starter-steps__circle' => '--starter-starter-ststarter-border-outer: {{VALUE}}; --starter-starter-ststarter-border-inner: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'circle_icon_color',
			[
				'label'     => esc_html__( 'Main Icon Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'var(--color-primary, #EC008C)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-steps__icon' => 'color: {{VALUE}};',
				],
			]
		);

		// Stepper line controls
		$this->add_control(
			'heading_line_style',
			[
				'label'     => esc_html__( 'Connecting Line Styles', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'line_type',
			[
				'label'     => esc_html__( 'Line Type', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'dashed',
				'options'   => [
					'dashed' => 'Dashed',
					'dotted' => 'Dotted',
					'solid'  => 'Solid',
					'none'   => 'None / Hidden',
				],
				'selectors' => [
					'{{WRAPPER}} .starter-starter-steps-grid' => '--starter-starter-ststarter-line-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'line_color',
			[
				'label'     => esc_html__( 'Line Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(236, 0, 140, 0.25)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-steps-grid' => '--starter-starter-ststarter-line-color: {{VALUE}};',
				],
				'condition' => [
					'line_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'line_thickness',
			[
				'label'      => esc_html__( 'Line Thickness', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 1, 'max' => 10 ],
				],
				'default'    => [ 'size' => 1, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-steps-grid' => '--starter-starter-ststarter-line-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'line_type!' => 'none',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Floating Top-Right Mini Badge
		// =====================================================
		$this->start_controls_section(
			'style_badge',
			[
				'label' => esc_html__( 'Top-Right Floating Badge', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'badge_bg',
			[
				'label'     => esc_html__( 'Badge Background', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#fffcfd',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-steps__badge' => '--starter-starter-ststarter-badge-bg: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_border',
			[
				'label'     => esc_html__( 'Badge Border Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(236, 0, 140, 0.25)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-steps__badge' => '--starter-starter-ststarter-badge-border: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_icon_color',
			[
				'label'     => esc_html__( 'Badge Icon Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'var(--color-primary, #EC008C)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-steps__badge' => '--starter-starter-ststarter-badge-icon: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Step Texts & Typography
		// =====================================================
		$this->start_controls_section(
			'style_step_texts',
			[
				'label' => esc_html__( 'Step Numbers & Texts', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Sequential Numbers
		$this->add_control(
			'heading_number_style',
			[
				'label'     => esc_html__( 'Step Numbers', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'number_color',
			[
				'label'     => esc_html__( 'Number Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'var(--color-primary, #EC008C)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-steps__number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'number_typography',
				'selector'  => '{{WRAPPER}} .starter-starter-steps__number',
				'fields_options' => [
					'font_weight' => [ 'default' => '700' ],
				],
			]
		);

		// Step Titles
		$this->add_control(
			'heading_title_style',
			[
				'label'     => esc_html__( 'Step Title', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1e293b',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-steps__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .starter-starter-steps__title',
			]
		);

		// Step Descriptions
		$this->add_control(
			'heading_desc_style',
			[
				'label'     => esc_html__( 'Step Description', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-steps__desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .starter-starter-steps__desc',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['steps_list'] ) ) {
			return;
		}

		wp_enqueue_style( 'starter-starter-steps', STARTER_URL . 'widgets/starter-steps/starter-steps.css', [], STARTER_VERSION );

		$columns_desktop = ! empty( $settings['columns'] ) ? $settings['columns'] : 5;
		$columns_tablet  = ! empty( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 3;
		$columns_mobile  = ! empty( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 1;

		$style_attr = sprintf(
			'style="--starter-starter-steps-cols: %d; --starter-starter-steps-cols-tablet: %d; --starter-starter-steps-cols-mobile: %d;"',
			intval( $columns_desktop ),
			intval( $columns_tablet ),
			intval( $columns_mobile )
		);
		?>
		<div class="starter-starter-steps-wrapper">
			
			<?php if ( $settings['show_header'] === 'yes' && ! empty( $settings['header_title'] ) ) : ?>
				<div class="starter-starter-steps-header text-center">
					<h3 class="starter-starter-steps-header__title font-display"><?php echo esc_html( $settings['header_title'] ); ?></h3>
				</div>
			<?php endif; ?>

			<div class="starter-starter-steps-grid" <?php echo $style_attr; ?>>
				
				<?php 
				$total_items = count( $settings['steps_list'] );
				foreach ( $settings['steps_list'] as $index => $item ) : 
					$step_num = sprintf( '%02d', $index + 1 );
					$title = isset( $item['title'] ) ? wp_kses_post( $item['title'] ) : '';
					$desc = isset( $item['description'] ) ? wp_kses_post( $item['description'] ) : '';
					
					// Determine if first or last for timeline line exceptions
					$item_classes = [ 'starter-starter-steps__item' ];
					if ( $index === 0 ) {
						$item_classes[] = 'starter-starter-steps__item--first';
					}
					if ( $index === $total_items - 1 ) {
						$item_classes[] = 'starter-starter-steps__item--last';
					}
					?>
					<div class="<?php echo esc_attr( implode( ' ', $item_classes ) ); ?>">
						
						<!-- Circular Icon Block & Float Badge -->
						<div class="starter-starter-steps__graphic-wrap">
							<div class="starter-starter-steps__circle">
								<?php if ( ! empty( $item['selected_icon']['value'] ) ) : ?>
									<span class="starter-starter-steps__icon">
										<?php \Elementor\Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
							</div>

							<?php if ( ! empty( $item['badge_icon']['value'] ) ) : ?>
								<div class="starter-starter-steps__badge">
									<?php \Elementor\Icons_Manager::render_icon( $item['badge_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</div>
							<?php endif; ?>
						</div>

						<!-- Step Texts -->
						<div class="starter-starter-steps__content text-center pt-5">
							<div class="starter-starter-steps__number font-display mb-1"><?php echo esc_html( $step_num ); ?></div>
							
							<?php if ( ! empty( $title ) ) : ?>
								<h4 class="starter-starter-steps__title font-display mb-2"><?php echo $title; ?></h4>
							<?php endif; ?>

							<?php if ( ! empty( $desc ) ) : ?>
								<p class="starter-starter-steps__desc mb-0"><?php echo $desc; ?></p>
							<?php endif; ?>
						</div>

					</div>
				<?php endforeach; ?>

			</div>

		</div>
		<?php
	}

	/**
	 * Mock Elementor Editor preview (Synchronization Rule)
	 */
	protected function content_template() {
		?>
		<div class="starter-starter-steps-wrapper">
			<#
			var showHeader = settings.show_header === 'yes';
			var columns = settings.columns ? settings.columns : 5;
			var colsTablet = settings.columns_tablet ? settings.columns_tablet : 3;
			var colsMobile = settings.columns_mobile ? settings.columns_mobile : 1;
			#>
			
			<# if ( showHeader && settings.header_title ) { #>
				<div class="starter-starter-steps-header text-center">
					<h3 class="starter-starter-steps-header__title font-display">{{{ settings.header_title }}}</h3>
				</div>
			<# } #>

			<# if ( settings.steps_list && settings.steps_list.length ) { #>
				<div class="starter-starter-steps-grid" style="--starter-starter-steps-cols: {{ columns }}; --starter-starter-steps-cols-tablet: {{ colsTablet }}; --starter-starter-steps-cols-mobile: {{ colsMobile }};">
					<# 
					var totalItems = settings.steps_list.length;
					_.each( settings.steps_list, function( item, index ) { 
						var stepNum = ( '0' + (index + 1) ).slice(-2);
						
						// Main Icon
						var iconHTML = '';
						if ( item.selected_icon && item.selected_icon.value ) {
							iconHTML = elementor.helpers.renderIcon( view, item.selected_icon, { 'aria-hidden': true }, 'i', 'object' );
						}

						// Badge Icon
						var badgeHTML = '';
						if ( item.badge_icon && item.badge_icon.value ) {
							badgeHTML = elementor.helpers.renderIcon( view, item.badge_icon, { 'aria-hidden': true }, 'i', 'object' );
						}

						// Classes
						var itemClass = 'starter-starter-steps__item';
						if ( index === 0 ) {
							itemClass += ' starter-starter-steps__item--first';
						}
						if ( index === totalItems - 1 ) {
							itemClass += ' starter-starter-steps__item--last';
						}
					#>
						<div class="{{ itemClass }}">
							
							<div class="starter-starter-steps__graphic-wrap">
								<div class="starter-starter-steps__circle">
									<# if ( item.selected_icon && item.selected_icon.value ) { #>
										<span class="starter-starter-steps__icon">
											<# if ( iconHTML && iconHTML.rendered ) { #>
												{{{ iconHTML.value }}}
											<# } else { #>
												<i class="{{{ item.selected_icon.value }}}" aria-hidden="true"></i>
											<# } #>
										</span>
									<# } #>
								</div>

								<# if ( item.badge_icon && item.badge_icon.value ) { #>
									<div class="starter-starter-steps__badge">
										<# if ( badgeHTML && badgeHTML.rendered ) { #>
											{{{ badgeHTML.value }}}
										<# } else { #>
											<i class="{{{ item.badge_icon.value }}}" aria-hidden="true"></i>
										<# } #>
									</div>
								<# } #>
							</div>

							<div class="starter-starter-steps__content text-center pt-5">
								<div class="starter-starter-steps__number font-display mb-1">{{ stepNum }}</div>
								
								<# if ( item.title ) { #>
									<h4 class="starter-starter-steps__title font-display mb-2">{{{ item.title }}}</h4>
								<# } #>

								<# if ( item.description ) { #>
									<p class="starter-starter-steps__desc mb-0">{{{ item.description }}}</p>
								<# } #>
							</div>

						</div>
					<# } ); #>
				</div>
			<# } #>

		</div>
		<?php
	}
}

add_action( 'wp_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-steps/starter-steps.css';
	wp_register_style(
		'starter-starter-steps',
		STARTER_URL . 'widgets/starter-steps/starter-steps.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );

add_action( 'elementor/editor/after_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-steps/starter-steps.css';
	wp_enqueue_style(
		'starter-starter-steps',
		STARTER_URL . 'widgets/starter-steps/starter-steps.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );
