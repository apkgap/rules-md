<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor KU Dentists Widget (REST API Query)
 */
class STARTER_Widget_starter_Dentists extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 */
	public function get_name() {
		return 'starter-dentists';
	}

	/**
	 * Get widget title
	 */
	public function get_title() {
		return esc_html__( 'KU Dentists (REST API)', 'starter-elementor-addon' );
	}

	/**
	 * Get widget icon
	 */
	public function get_icon() {
		return 'eicon-person';
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
		return [ 'dentists', 'doctors', 'staff', 'team', 'rest', 'api', 'specialty' ];
	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'starter-starter-dentists' ];
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {

		// =====================================================
		// CONTENT TAB - Query Settings
		// =====================================================
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Dentists Query', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Specialty filter (dynamic terms list)
		$specialties = get_terms( array(
			'taxonomy'   => 'dentist_specialty',
			'hide_empty' => false,
		) );
		
		$specialty_options = array( '' => esc_html__( 'ทั้งหมด (All)', 'starter-elementor-addon' ) );
		if ( ! is_wp_error( $specialties ) && ! empty( $specialties ) ) {
			foreach ( $specialties as $term ) {
				$specialty_options[$term->term_id] = $term->name;
			}
		}

		$this->add_control(
			'dentist_specialty_filter',
			[
				'label'   => esc_html__( 'Filter by Specialty', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $specialty_options,
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Number of Dentists', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 50,
				'step'    => 1,
				'default' => 4,
			]
		);

		$this->end_controls_section();

		// =====================================================
		// CONTENT TAB - Grid Layout
		// =====================================================
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Grid Layout', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Grid columns (Rule 2.1)
		$this->add_responsive_control(
			'dentist_cols',
			[
				'label'          => esc_html__( 'Columns', 'starter-elementor-addon' ),
				'type'           => \Elementor\Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'selectors'      => [
					'{{WRAPPER}} .starter-starter-dentists-grid' => '--starter-starter-grid-cols: {{VALUE}};',
				],
			]
		);

		// Grid Gap
		$this->add_responsive_control(
			'grid_gap',
			[
				'label'      => esc_html__( 'Gap Between Cards', 'starter-elementor-addon' ),
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
					'{{WRAPPER}} .starter-starter-dentists-grid' => '--starter-starter-grid-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Dividers Toggle (Rule 2.3)
		$this->add_control(
			'show_dividers',
			[
				'label'        => esc_html__( 'Show Vertical Dividers', 'starter-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'starter-elementor-addon' ),
				'label_off'    => esc_html__( 'Hide', 'starter-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f1f5f9',
				'condition' => [
					'show_dividers' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .starter-starter-dentists-grid' => '--starter-starter-divider-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// CONTENT TAB - Action Button (View All)
		// =====================================================
		$this->start_controls_section(
			'section_action_button',
			[
				'label' => esc_html__( 'Action Button', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_view_all',
			[
				'label'        => esc_html__( 'Show "View All" Button', 'starter-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'starter-elementor-addon' ),
				'label_off'    => esc_html__( 'Hide', 'starter-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'view_all_text',
			[
				'label'     => esc_html__( 'Button Text', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'ดูทีมทันตแพทย์ทั้งหมด', 'starter-elementor-addon' ),
				'condition' => [
					'show_view_all' => 'yes',
				],
			]
		);

		$this->add_control(
			'view_all_link',
			[
				'label'       => esc_html__( 'Button Link', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'starter-elementor-addon' ),
				'default'     => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition' => [
					'show_view_all' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Card Styles
		// =====================================================
		$this->start_controls_section(
			'section_card_style',
			[
				'label' => esc_html__( 'Card Styles', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label'     => esc_html__( 'Card Background Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-dentist-card' => '--starter-starter-card-bg: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default'    => [
					'size' => 24,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-dentist-card' => '--starter-starter-card-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Padding', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => '24',
					'right'  => '24',
					'bottom' => '24',
					'left'   => '24',
					'unit'   => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-dentist-card' => '--starter-starter-card-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_hover_y',
			[
				'label'      => esc_html__( 'Card Hover Move Up', 'starter-elementor-addon' ),
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
					'{{WRAPPER}} .starter-starter-dentist-card' => '--starter-starter-card-hover-y: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Typography & Colors
		// =====================================================
		$this->start_controls_section(
			'section_typo_colors',
			[
				'label' => esc_html__( 'Typography & Colors', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Name (Title) Styles
		$this->add_control(
			'name_color',
			[
				'label'     => esc_html__( 'Name Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-dentist-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'name_typography',
				'selector' => '{{WRAPPER}} .starter-starter-dentist-name',
				'fields_options' => [
					'font_weight' => [
						'default' => '700',
					],
					'font_size' => [
						'default' => [
							'size' => '18',
							'unit' => 'px',
						],
					],
				],
			]
		);

		// Specialty Styles
		$this->add_control(
			'specialty_color',
			[
				'label'     => esc_html__( 'Specialty Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ff4a7d',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-dentist-specialty' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'specialty_typography',
				'selector' => '{{WRAPPER}} .starter-starter-dentist-specialty',
				'fields_options' => [
					'font_size' => [
						'default' => [
							'size' => '14',
							'unit' => 'px',
						],
					],
				],
			]
		);

		// Experience Styles
		$this->add_control(
			'experience_color',
			[
				'label'     => esc_html__( 'Experience Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#94a3b8',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-dentist-experience' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'experience_typography',
				'selector' => '{{WRAPPER}} .starter-starter-dentist-experience',
				'fields_options' => [
					'font_size' => [
						'default' => [
							'size' => '13',
							'unit' => 'px',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Button Styles
		// =====================================================
		$this->start_controls_section(
			'section_button_style',
			[
				'label'     => esc_html__( 'Action Button', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_view_all' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		// Button Normal state
		$this->start_controls_tab(
			'button_normal',
			[
				'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ff4a7d',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-dentists-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-dentists-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Button Hover state
		$this->start_controls_tab(
			'button_hover',
			[
				'label' => esc_html__( 'Hover', 'starter-elementor-addon' ),
			]
		);

		$this->add_control(
			'button_bg_hover',
			[
				'label'     => esc_html__( 'Hover Background Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ff2a65',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-dentists-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_text_hover',
			[
				'label'     => esc_html__( 'Hover Text Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-dentists-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Button dimensions and radius
		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default'    => [
					'size' => 30,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-dentists-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => '14',
					'right'  => '36',
					'bottom' => '14',
					'left'   => '36',
					'unit'   => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-dentists-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend (Server-Side local REST API Request)
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		// Fetch dentists using internal WP_REST_Request
		$request = new \WP_REST_Request( 'GET', '/wp/v2/dentist' );
		$request->set_param( 'per_page', ! empty( $settings['posts_per_page'] ) ? intval( $settings['posts_per_page'] ) : 4 );
		
		if ( ! empty( $settings['dentist_specialty_filter'] ) ) {
			$request->set_param( 'dentist_specialty', intval( $settings['dentist_specialty_filter'] ) );
		}

		$response = rest_do_request( $request );
		$dentists = rest_get_server()->response_to_data( $response, true );

		if ( empty( $dentists ) || is_wp_error( $dentists ) ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="notice notice-warning" style="padding:20px;text-align:center;">' .
					esc_html__( 'ไม่พบข้อมูลทันตแพทย์ (กรุณาเพิ่มข้อมูลทันตแพทย์ หรือเลือกหมวดหมู่ใหม่)', 'starter-elementor-addon' ) .
					'</div>';
			}
			return;
		}

		$style_rules = [];

		// Responsive Grid Columns
		if ( isset( $settings['dentist_cols'] ) && $settings['dentist_cols'] !== '' ) {
			$style_rules[] = '--starter-starter-grid-cols: ' . absint( $settings['dentist_cols'] );
		}
		if ( isset( $settings['dentist_cols_tablet'] ) && $settings['dentist_cols_tablet'] !== '' ) {
			$style_rules[] = '--starter-starter-grid-cols-tablet: ' . absint( $settings['dentist_cols_tablet'] );
		}
		if ( isset( $settings['dentist_cols_mobile'] ) && $settings['dentist_cols_mobile'] !== '' ) {
			$style_rules[] = '--starter-starter-grid-cols-mobile: ' . absint( $settings['dentist_cols_mobile'] );
		}

		// Grid Gap
		foreach ( ['', '_tablet', '_mobile'] as $suffix ) {
			$gap_key = 'grid_gap' . $suffix;
			if ( ! empty( $settings[$gap_key]['size'] ) || ( isset( $settings[$gap_key]['size'] ) && $settings[$gap_key]['size'] === 0 ) ) {
				$unit = ! empty( $settings[$gap_key]['unit'] ) ? $settings[$gap_key]['unit'] : 'px';
				$style_rules[] = '--starter-starter-grid-gap' . str_replace('_', '-', $suffix) . ': ' . esc_attr( $settings[$gap_key]['size'] . $unit );
			}
		}

		// Divider settings
		$has_dividers = ( ! empty( $settings['show_dividers'] ) && $settings['show_dividers'] === 'yes' ) ? 'yes' : 'no';
		$style_rules[] = '--starter-starter-show-dividers: ' . ( $has_dividers === 'yes' ? 'block' : 'none' );
		if ( ! empty( $settings['divider_color'] ) ) {
			$style_rules[] = '--starter-starter-divider-color: ' . esc_attr( $settings['divider_color'] );
		}

		// Card Background
		if ( ! empty( $settings['card_bg_color'] ) ) {
			$style_rules[] = '--starter-starter-card-bg: ' . esc_attr( $settings['card_bg_color'] );
		}

		// Card Border Radius
		foreach ( ['', '_tablet', '_mobile'] as $suffix ) {
			$radius_key = 'card_border_radius' . $suffix;
			if ( ! empty( $settings[$radius_key]['size'] ) || ( isset( $settings[$radius_key]['size'] ) && $settings[$radius_key]['size'] === 0 ) ) {
				$unit = ! empty( $settings[$radius_key]['unit'] ) ? $settings[$radius_key]['unit'] : 'px';
				$style_rules[] = '--starter-starter-card-radius' . str_replace('_', '-', $suffix) . ': ' . esc_attr( $settings[$radius_key]['size'] . $unit );
			}
		}

		// Card Padding
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

		// Card Hover Y
		foreach ( ['', '_tablet', '_mobile'] as $suffix ) {
			$hover_key = 'card_hover_y' . $suffix;
			if ( ! empty( $settings[$hover_key]['size'] ) || ( isset( $settings[$hover_key]['size'] ) && $settings[$hover_key]['size'] === 0 ) ) {
				$unit = ! empty( $settings[$hover_key]['unit'] ) ? $settings[$hover_key]['unit'] : 'px';
				$style_rules[] = '--starter-starter-card-hover-y' . str_replace('_', '-', $suffix) . ': ' . esc_attr( $settings[$hover_key]['size'] . $unit );
			}
		}

		$style_attr = ! empty( $style_rules ) ? ' style="' . implode( '; ', $style_rules ) . ';"' : '';
		?>
		<div class="starter-starter-dentists-grid-wrap"<?php echo $style_attr; ?>>
			<div class="starter-starter-dentists-grid">
				<?php foreach ( $dentists as $item ) : 
					$title = isset( $item['title']['rendered'] ) ? esc_html( $item['title']['rendered'] ) : '';
					$exp_text = isset( $item['experience_text'] ) ? esc_html( $item['experience_text'] ) : '';
					$specialty = '';
					if ( ! empty( $item['specialties'] ) ) {
						$specialty = esc_html( $item['specialties'][0]['name'] );
					}
					$img_url = ! empty( $item['featured_image_url'] ) ? esc_url( $item['featured_image_url'] ) : STARTER_URL . 'assets/images/placeholder.jpg';
					?>
					<div class="starter-starter-dentist-card">
						<div class="starter-starter-dentist-card-inner">
							<div class="starter-starter-dentist-image-wrapper">
								<img src="<?php echo $img_url; ?>" alt="<?php echo $title; ?>" class="starter-starter-dentist-img" />
							</div>
							<div class="starter-starter-dentist-info">
								<h4 class="starter-starter-dentist-name"><?php echo $title; ?></h4>
								<?php if ( ! empty( $specialty ) ) : ?>
									<div class="starter-starter-dentist-specialty"><?php echo $specialty; ?></div>
								<?php endif; ?>
								<?php if ( ! empty( $exp_text ) ) : ?>
									<div class="starter-starter-dentist-experience"><?php echo $exp_text; ?></div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( ! empty( $settings['show_view_all'] ) && $settings['show_view_all'] === 'yes' ) : 
				$btn_text = ! empty( $settings['view_all_text'] ) ? esc_html( $settings['view_all_text'] ) : esc_html__( 'ดูทั้งหมด', 'starter-elementor-addon' );
				$btn_url = ! empty( $settings['view_all_link']['url'] ) ? esc_url( $settings['view_all_link']['url'] ) : '#';
				$btn_target = ! empty( $settings['view_all_link']['is_external'] ) ? ' target="_blank"' : '';
				$btn_nofollow = ! empty( $settings['view_all_link']['nofollow'] ) ? ' rel="nofollow"' : '';
				?>
				<div class="starter-starter-dentists-action">
					<a href="<?php echo $btn_url; ?>" class="starter-starter-dentists-btn"<?php echo $btn_target . $btn_nofollow; ?>>
						<?php echo $btn_text; ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Render widget output in the editor (Dual-Rendering client-side REST fetch)
	 */
	protected function content_template() {
		?>
		<div class="starter-starter-dentists-loading" style="text-align:center; padding:40px;">
			<i class="eicon-loading eicon-animation-spin" style="font-size:30px; color:#ff4a7d; display:block; margin-bottom:10px;"></i>
			<p>กำลังโหลดข้อมูลทีมทันตแพทย์ด้วย REST API...</p>
		</div>
		<div class="starter-starter-dentists-grid-wrap" style="display:none;">
			<!-- Rendered dynamically by Ajax inside editor -->
		</div>

		<script>
		(function() {
			var container = jQuery('#elementor-element-{{ view.model.cid }}');
			
			function fetchDentists() {
				var gridWrap = container.find('.starter-starter-dentists-grid-wrap');
				var loading = container.find('.starter-starter-dentists-loading');
				
				// Build Inline Styles dynamically for live preview
				var style_rules = [];
				if (settings.dentist_cols) style_rules.push('--starter-starter-grid-cols: ' + settings.dentist_cols);
				if (settings.dentist_cols_tablet) style_rules.push('--starter-starter-grid-cols-tablet: ' + settings.dentist_cols_tablet);
				if (settings.dentist_cols_mobile) style_rules.push('--starter-starter-grid-cols-mobile: ' + settings.dentist_cols_mobile);

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

				var showDivs = settings.show_dividers === 'yes' ? 'block' : 'none';
				style_rules.push('--starter-starter-show-dividers: ' + showDivs);
				if (settings.divider_color) style_rules.push('--starter-starter-divider-color: ' + settings.divider_color);

				if (settings.card_bg_color) style_rules.push('--starter-starter-card-bg: ' + settings.card_bg_color);

				_.each(suffixes, function(suffix) {
					var radius_key = 'card_border_radius' + suffix;
					var val = settings[radius_key];
					if ( val && (val.size || val.size === 0 || val.size === '0') && val.size !== '' ) {
						var unit = val.unit || 'px';
						var css_suffix = suffix.replace('_', '-');
						style_rules.push('--starter-starter-card-radius' + css_suffix + ': ' + val.size + unit);
					}
				});

				_.each(suffixes, function(suffix) {
					var padding_key = 'card_padding' + suffix;
					var pad = settings[padding_key];
					if ( pad && (pad.top || pad.right || pad.bottom || pad.left || pad.top === 0 || pad.right === 0 || pad.bottom === 0 || pad.left === 0) ) {
						var unit = pad.unit || 'px';
						var top = (pad.top !== undefined && pad.top !== '') ? pad.top : '0';
						var right = (pad.right !== undefined && pad.right !== '') ? pad.right : '0';
						var bottom = (pad.bottom !== undefined && pad.bottom !== '') ? pad.bottom : '0';
						var left = (pad.left !== undefined && pad.left !== '') ? pad.left : '0';
						var css_suffix = suffix.replace('_', '-');
						style_rules.push('--starter-starter-card-padding' + css_suffix + ': ' + top + unit + ' ' + right + unit + ' ' + bottom + unit + ' ' + left + unit);
					}
				});

				_.each(suffixes, function(suffix) {
					var hover_key = 'card_hover_y' + suffix;
					var val = settings[hover_key];
					if ( val && (val.size || val.size === 0 || val.size === '0') && val.size !== '' ) {
						var unit = val.unit || 'px';
						var css_suffix = suffix.replace('_', '-');
						style_rules.push('--starter-starter-card-hover-y' + css_suffix + ': ' + val.size + unit);
					}
				});

				gridWrap.attr('style', style_rules.join('; '));

				// Build REST API request URL
				var url = '/wp-json/wp/v2/dentist?per_page=' + (settings.posts_per_page || 4);
				if (settings.dentist_specialty_filter) {
					url += '&dentist_specialty=' + settings.dentist_specialty_filter;
				}

				jQuery.ajax({
					url: url,
					method: 'GET',
					success: function(data) {
						loading.hide();
						gridWrap.show();

						if (!data || data.length === 0) {
							gridWrap.html('<div class="notice notice-warning" style="padding:20px;text-align:center;">ไม่พบข้อมูลทันตแพทย์ (กรุณาเพิ่มข้อมูลทันตแพทย์)</div>');
							return;
						}

						var html = '<div class="starter-starter-dentists-grid">';
						jQuery.each(data, function(index, item) {
							var title = item.title ? item.title.rendered : '';
							var expText = item.experience_text || '';
							var specialties = '';
							if (item.specialties && item.specialties.length > 0) {
								specialties = item.specialties[0].name;
							}
							var imgUrl = item.featured_image_url || '<?php echo STARTER_URL; ?>widgets/starter-info-cards/placeholder.jpg';

							html += '<div class="starter-starter-dentist-card">';
							html += '  <div class="starter-starter-dentist-card-inner">';
							html += '    <div class="starter-starter-dentist-image-wrapper">';
							html += '      <img src="' + imgUrl + '" alt="' + title + '" class="starter-starter-dentist-img" />';
							html += '    </div>';
							html += '    <div class="starter-starter-dentist-info">';
							html += '      <h4 class="starter-starter-dentist-name">' + title + '</h4>';
							if (specialties) {
								html += '      <div class="starter-starter-dentist-specialty">' + specialties + '</div>';
							}
							if (expText) {
								html += '      <div class="starter-starter-dentist-experience">' + expText + '</div>';
							}
							html += '    </div>';
							html += '  </div>';
							html += '</div>';
						});
						html += '</div>';

						// View all button
						if (settings.show_view_all === 'yes') {
							var btnText = settings.view_all_text || 'ดูทั้งหมด';
							var btnLink = (settings.view_all_link && settings.view_all_link.url) ? settings.view_all_link.url : '#';
							html += '<div class="starter-starter-dentists-action">';
							html += '  <a href="' + btnLink + '" class="starter-starter-dentists-btn">' + btnText + '</a>';
							html += '</div>';
						}

						gridWrap.html(html);
					},
					error: function() {
						loading.hide();
						gridWrap.show().html('<div class="notice notice-danger" style="padding:20px;text-align:center;color:red;">เกิดข้อผิดพลาดในการเชื่อมต่อ REST API</div>');
					}
				});
			}

			// Run on load and listen to control updates in the editor
			fetchDentists();
			
			// Re-fetch only when query parameters change, and dynamically update CSS variables for style controls
			if (window.elementor) {
				elementor.channels.editor.on('change', function(controlView) {
					var changed = controlView.model.get('name');
					if (changed === 'dentist_specialty_filter' || changed === 'posts_per_page') {
						loading.show();
						gridWrap.hide();
						fetchDentists();
					} else {
						// Instantly apply spacing/design controls without full Ajax re-fetch
						fetchDentists();
					}
				});
			}
		})();
		</script>
		<?php
	}
}

add_action( 'wp_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-dentists/starter-dentists.css';
	wp_register_style(
		'starter-starter-dentists',
		STARTER_URL . 'widgets/starter-dentists/starter-dentists.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );

add_action( 'elementor/editor/after_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-dentists/starter-dentists.css';
	wp_enqueue_style(
		'starter-starter-dentists',
		STARTER_URL . 'widgets/starter-dentists/starter-dentists.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );
