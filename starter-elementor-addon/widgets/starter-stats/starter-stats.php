<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor KU Stats Banner Widget
 */
class STARTER_Widget_starter_Stats extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 */
	public function get_name() {
		return 'starter-stats';
	}

	/**
	 * Get widget title
	 */
	public function get_title() {
		return esc_html__( 'KU Stats Banner', 'starter-elementor-addon' );
	}

	/**
	 * Get widget icon
	 */
	public function get_icon() {
		return 'eicon-counter-block';
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
		return [ 'stats', 'counter', 'banner', 'numbers', 'features' ];
	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'starter-starter-stats' ];
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {

		// =====================================================
		// CONTENT TAB - Stats Repeater
		// =====================================================
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Stats Content', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'stat_number',
			[
				'label'       => esc_html__( 'Stat Number', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( '5,000+', 'starter-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'stat_label',
			[
				'label'       => esc_html__( 'Description Label', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'เคสดูแลคนไข้', 'starter-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label'       => esc_html__( 'Outline Icon', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-tooth',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'stats_repeater_list',
			[
				'label'       => esc_html__( 'Stats List', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'stat_number' => esc_html__( '5,000+', 'starter-elementor-addon' ),
						'stat_label'  => esc_html__( 'เคสดูแลคนไข้', 'starter-elementor-addon' ),
						'selected_icon' => [ 'value' => 'fas fa-tooth', 'library' => 'fa-solid' ],
					],
					[
						'stat_number' => esc_html__( '10+', 'starter-elementor-addon' ),
						'stat_label'  => esc_html__( 'ปีประสบการณ์', 'starter-elementor-addon' ),
						'selected_icon' => [ 'value' => 'fas fa-briefcase', 'library' => 'fa-solid' ],
					],
					[
						'stat_number' => esc_html__( '4.9', 'starter-elementor-addon' ),
						'stat_label'  => esc_html__( 'คะแนนรีวิวจาก Google', 'starter-elementor-addon' ),
						'selected_icon' => [ 'value' => 'far fa-star', 'library' => 'fa-regular' ],
					],
					[
						'stat_number' => esc_html__( '98%', 'starter-elementor-addon' ),
						'stat_label'  => esc_html__( 'ความพึงพอใจของคนไข้', 'starter-elementor-addon' ),
						'selected_icon' => [ 'value' => 'far fa-heart', 'library' => 'fa-regular' ],
					],
				],
				'title_field' => '{{{ stat_number }}} - {{{ stat_label }}}',
			]
		);

		$this->end_controls_section();

		// =====================================================
		// CONTENT TAB - Grid & Layout Configuration
		// =====================================================
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Grid Layout', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'stats_columns',
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
					'{{WRAPPER}} .starter-starter-stats-grid' => '--starter-starter-stats-cols: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_gap',
			[
				'label'      => esc_html__( 'Gap Between Items', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default'    => [ 'size' => 24, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-stats-grid' => '--starter-starter-stats-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Banner Container
		// =====================================================
		$this->start_controls_section(
			'style_container',
			[
				'label' => esc_html__( 'Banner Container Style', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'banner_bg_type',
			[
				'label'     => esc_html__( 'Background Theme', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'pink-gradient',
				'options'   => [
					'pink-gradient' => 'Default Light Pink Gradient',
					'custom'        => 'Custom Color',
				],
			]
		);

		$this->add_control(
			'banner_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#fff5f8',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-stats-grid' => 'background-color: {{VALUE}}; background-image: none;',
				],
				'condition' => [
					'banner_bg_type' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'banner_padding',
			[
				'label'      => esc_html__( 'Banner Padding', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => '20',
					'right'  => '40',
					'bottom' => '20',
					'left'   => '40',
					'unit'   => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-stats-grid' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'stat_item_padding',
			[
				'label'      => esc_html__( 'Individual Item Padding', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => '10',
					'right'  => '15',
					'bottom' => '10',
					'left'   => '15',
					'unit'   => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-stats__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'banner_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default'    => [ 'size' => 100, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-stats-grid' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Vertical Dividers (Rule 3.3 and 2.3)
		// =====================================================
		$this->start_controls_section(
			'style_dividers',
			[
				'label' => esc_html__( 'Item Vertical Dividers', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'show_stat_dividers',
			[
				'label'     => esc_html__( 'Show Dividers', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'starter-elementor-addon' ),
				'label_off' => esc_html__( 'No', 'starter-elementor-addon' ),
				'default'   => 'no',
			]
		);

		$this->add_control(
			'stat_divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(236, 0, 140, 0.15)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-stats-grid' => '--starter-starter-stats-divider-color: {{VALUE}};',
				],
				'condition' => [
					'show_stat_dividers' => 'yes',
				],
			]
		);

		$this->add_control(
			'stat_divider_width',
			[
				'label'      => esc_html__( 'Divider Thickness', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 1, 'max' => 10 ],
				],
				'default'    => [ 'size' => 1, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-stats-grid' => '--starter-starter-stats-divider-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'show_stat_dividers' => 'yes',
				],
			]
		);

		$this->add_control(
			'stat_divider_style',
			[
				'label'     => esc_html__( 'Divider Style', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => [
					'solid'  => 'Solid',
					'dashed' => 'Dashed',
					'dotted' => 'Dotted',
				],
				'selectors' => [
					'{{WRAPPER}} .starter-starter-stats-grid' => '--starter-starter-stats-divider-style: {{VALUE}};',
				],
				'condition' => [
					'show_stat_dividers' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Icons
		// =====================================================
		$this->start_controls_section(
			'style_icon',
			[
				'label' => esc_html__( 'Stat Icons', 'starter-elementor-addon' ),
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
					'{{WRAPPER}} .starter-starter-stats__icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 10, 'max' => 100 ],
				],
				'default'    => [ 'size' => 46, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-stats__icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Stat Numbers
		// =====================================================
		$this->start_controls_section(
			'style_number',
			[
				'label' => esc_html__( 'Stat Numbers', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'number_color',
			[
				'label'     => esc_html__( 'Number Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'var(--color-primary, #EC008C)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-stats__number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'number_typography',
				'selector'  => '{{WRAPPER}} .starter-starter-stats__number',
				'fields_options' => [
					'font_weight' => [ 'default' => '700' ],
					'font_size'   => [ 'default' => [ 'size' => '32', 'unit' => 'px' ] ],
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Labels
		// =====================================================
		$this->start_controls_section(
			'style_label',
			[
				'label' => esc_html__( 'Description Labels', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Label Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#334155',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-stats__label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .starter-starter-stats__label',
				'fields_options' => [
					'font_weight' => [ 'default' => '600' ],
					'font_size'   => [ 'default' => [ 'size' => '13', 'unit' => 'px' ] ],
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

		if ( empty( $settings['stats_repeater_list'] ) ) {
			return;
		}

		wp_enqueue_style( 'starter-starter-stats', STARTER_URL . 'widgets/starter-stats/starter-stats.css', [], STARTER_VERSION );

		$columns_desktop = ! empty( $settings['stats_columns'] ) ? $settings['stats_columns'] : 4;
		$columns_tablet  = ! empty( $settings['stats_columns_tablet'] ) ? $settings['stats_columns_tablet'] : 2;
		$columns_mobile  = ! empty( $settings['stats_columns_mobile'] ) ? $settings['stats_columns_mobile'] : 1;

		$style_attr = sprintf(
			'style="--starter-starter-stats-cols: %d; --starter-starter-stats-cols-tablet: %d; --starter-starter-stats-cols-mobile: %d;"',
			intval( $columns_desktop ),
			intval( $columns_tablet ),
			intval( $columns_mobile )
		);

		$grid_classes = [ 'starter-starter-stats-grid' ];
		if ( $settings['banner_bg_type'] === 'pink-gradient' ) {
			$grid_classes[] = 'starter-starter-stats-grid--pink-gradient';
		}
		if ( $settings['show_stat_dividers'] === 'yes' ) {
			$grid_classes[] = 'starter-starter-stats-grid--has-dividers';
		}
		?>
		<div class="starter-starter-stats-wrapper">
			
			<div class="<?php echo esc_attr( implode( ' ', $grid_classes ) ); ?>" <?php echo $style_attr; ?>>
				
				<?php foreach ( $settings['stats_repeater_list'] as $item ) : 
					$number = isset( $item['stat_number'] ) ? wp_kses_post( $item['stat_number'] ) : '';
					$label = isset( $item['stat_label'] ) ? wp_kses_post( $item['stat_label'] ) : '';
					?>
					<div class="starter-starter-stats__item flex items-center">
						
						<!-- Large Outline Icon Left -->
						<?php if ( ! empty( $item['selected_icon']['value'] ) ) : ?>
							<div class="starter-starter-stats__icon-wrap flex-shrink-0 flex items-center justify-center mr-4">
								<span class="starter-starter-stats__icon">
									<?php 
									$icon_val = $item['selected_icon']['value'];
									if ( $icon_val === 'fas fa-tooth' ) {
										echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="custom-outline-svg" style="width: 1em; height: 1em;"><path d="M12 2C8.5 2 6 4.5 6 8c0 2 .5 3.5 1 5 .5 1.5.5 3 0 4.5-.5 1.5-2 2-2 3.5 0 2 3.5 3 7 3 3.5 0 7-1 7-3 0-1.5-1.5-2-2-3.5s-.5-3 0-4.5c.5-1.5 1-3 1-5 0-3.5-2.5-6-6-6z"/><path d="M12 12c-1.5 0-2.5-1-2.5-2.5S10.5 7 12 7"/></svg>';
									} elseif ( $icon_val === 'fas fa-briefcase' ) {
										echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="custom-outline-svg" style="width: 1em; height: 1em;"><rect x="6" y="5" width="12" height="15" rx="3" /><path d="M9 5V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1" /><path d="M12 9v6" /><path d="m10 13 2 2 2-2"/></svg>';
									} elseif ( $icon_val === 'far fa-star' ) {
										echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="custom-outline-svg" style="width: 1em; height: 1em;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>';
									} elseif ( $icon_val === 'far fa-heart' ) {
										echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="custom-outline-svg" style="width: 1em; height: 1em;"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" /></svg>';
									} else {
										\Elementor\Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] );
									}
									?>
								</span>
							</div>
						<?php endif; ?>

						<!-- Stats Content Right (Number on top, label underneath) -->
						<div class="starter-starter-stats__content flex flex-col justify-center">
							<?php if ( ! empty( $number ) ) : ?>
								<div class="starter-starter-stats__number font-display"><?php echo $number; ?></div>
							<?php endif; ?>

							<?php if ( ! empty( $label ) ) : ?>
								<div class="starter-starter-stats__label text-xs font-medium"><?php echo $label; ?></div>
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
		<div class="starter-starter-stats-wrapper">
			<#
			var columns = settings.stats_columns ? settings.stats_columns : 4;
			var colsTablet = settings.stats_columns_tablet ? settings.stats_columns_tablet : 2;
			var colsMobile = settings.stats_columns_mobile ? settings.stats_columns_mobile : 1;
			
			var gridClass = 'starter-starter-stats-grid';
			if ( settings.banner_bg_type === 'pink-gradient' ) {
				gridClass += ' starter-starter-stats-grid--pink-gradient';
			}
			if ( settings.show_stat_dividers === 'yes' ) {
				gridClass += ' starter-starter-stats-grid--has-dividers';
			}
			#>
			<# if ( settings.stats_repeater_list && settings.stats_repeater_list.length ) { #>
				<div class="{{ gridClass }}" style="--starter-starter-stats-cols: {{ columns }}; --starter-starter-stats-cols-tablet: {{ colsTablet }}; --starter-starter-stats-cols-mobile: {{ colsMobile }};">
					<# _.each( settings.stats_repeater_list, function( item, index ) { 
						
						// Get Icon HTML
						var iconHTML = '';
						if ( item.selected_icon && item.selected_icon.value ) {
							iconHTML = elementor.helpers.renderIcon( view, item.selected_icon, { 'aria-hidden': true }, 'i', 'object' );
						}
					#>
						<div class="starter-starter-stats__item flex items-center">
							
							<# if ( item.selected_icon && item.selected_icon.value ) { #>
								<div class="starter-starter-stats__icon-wrap flex-shrink-0 flex items-center justify-center mr-4">
									<span class="starter-starter-stats__icon">
										<# if ( item.selected_icon.value === 'fas fa-tooth' ) { #>
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="custom-outline-svg" style="width: 1em; height: 1em;"><path d="M12 2C8.5 2 6 4.5 6 8c0 2 .5 3.5 1 5 .5 1.5.5 3 0 4.5-.5 1.5-2 2-2 3.5 0 2 3.5 3 7 3 3.5 0 7-1 7-3 0-1.5-1.5-2-2-3.5s-.5-3 0-4.5c.5-1.5 1-3 1-5 0-3.5-2.5-6-6-6z"/><path d="M12 12c-1.5 0-2.5-1-2.5-2.5S10.5 7 12 7"/></svg>
										<# } else if ( item.selected_icon.value === 'fas fa-briefcase' ) { #>
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="custom-outline-svg" style="width: 1em; height: 1em;"><rect x="6" y="5" width="12" height="15" rx="3" /><path d="M9 5V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1" /><path d="M12 9v6" /><path d="m10 13 2 2 2-2"/></svg>
										<# } else if ( item.selected_icon.value === 'far fa-star' ) { #>
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="custom-outline-svg" style="width: 1em; height: 1em;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg>
										<# } else if ( item.selected_icon.value === 'far fa-heart' ) { #>
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="custom-outline-svg" style="width: 1em; height: 1em;"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" /></svg>
										<# } else { #>
											<# if ( iconHTML && iconHTML.rendered ) { #>
												{{{ iconHTML.value }}}
											<# } else { #>
												<i class="{{{ item.selected_icon.value }}}" aria-hidden="true"></i>
											<# } #>
										<# } #>
									</span>
								</div>
							<# } #>

							<div class="starter-starter-stats__content flex flex-col justify-center">
								<# if ( item.stat_number ) { #>
									<div class="starter-starter-stats__number font-display">{{{ item.stat_number }}}</div>
								<# } #>

								<# if ( item.stat_label ) { #>
									<div class="starter-starter-stats__label text-xs font-medium">{{{ item.stat_label }}}</div>
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
	$css_path = STARTER_PATH . 'widgets/starter-stats/starter-stats.css';
	wp_register_style(
		'starter-starter-stats',
		STARTER_URL . 'widgets/starter-stats/starter-stats.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );

add_action( 'elementor/editor/after_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-stats/starter-stats.css';
	wp_enqueue_style(
		'starter-starter-stats',
		STARTER_URL . 'widgets/starter-stats/starter-stats.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );
