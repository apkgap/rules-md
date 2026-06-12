<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor KU Post Grid Widget
 */
class STARTER_Widget_starter_Post_Grid extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 */
	public function get_name() {
		return 'starter-post-grid';
	}

	/**
	 * Get widget title
	 */
	public function get_title() {
		return esc_html__( 'KU Post Grid (Custom)', 'starter-elementor-addon' );
	}

	/**
	 * Get widget icon
	 */
	public function get_icon() {
		return 'eicon-post-grid';
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
		return [ 'post', 'grid', 'query', 'custom post type', 'articles', 'portfolio', 'services' ];
	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'starter-starter-post-grid' ];
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
				'label' => esc_html__( 'Query Configuration', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Fetch all public post types
		$post_types = get_post_types( [ 'public' => true ], 'objects' );
		$post_type_options = [];
		if ( ! is_wp_error( $post_types ) && is_array( $post_types ) ) {
			foreach ( $post_types as $post_type ) {
				if ( $post_type->name === 'attachment' ) {
					continue;
				}
				$post_type_options[ $post_type->name ] = $post_type->label;
			}
		}

		$this->add_control(
			'post_type',
			[
				'label'   => esc_html__( 'Post Type', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'post',
				'options' => $post_type_options,
			]
		);

		// Fetch all public taxonomies dynamically
		$taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );
		if ( ! is_wp_error( $taxonomies ) && is_array( $taxonomies ) ) {
			foreach ( $taxonomies as $taxonomy ) {
				$terms = get_terms( [
					'taxonomy'   => $taxonomy->name,
					'hide_empty' => false,
				] );

				$term_options = [];
				if ( ! is_wp_error( $terms ) && is_array( $terms ) ) {
					foreach ( $terms as $term ) {
						$term_options[ $term->slug ] = $term->name;
					}
				}

				if ( ! empty( $term_options ) ) {
					$this->add_control(
						'tax_filter_' . $taxonomy->name,
						[
							'label'       => sprintf( esc_html__( 'Filter by %s', 'starter-elementor-addon' ), $taxonomy->label ),
							'type'        => \Elementor\Controls_Manager::SELECT2,
							'multiple'    => true,
							'options'     => $term_options,
							'label_block' => true,
							'description' => sprintf( esc_html__( 'Select terms to filter from %s. Leave empty to show all.', 'starter-elementor-addon' ), $taxonomy->label ),
							'condition'   => [
								'post_type' => $taxonomy->object_type,
							],
						]
					);
				}
			}
		}

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Posts Count Limit', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'max'     => 100,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'       => esc_html__( 'Date Published', 'starter-elementor-addon' ),
					'title'      => esc_html__( 'Title', 'starter-elementor-addon' ),
					'rand'       => esc_html__( 'Random', 'starter-elementor-addon' ),
					'menu_order' => esc_html__( 'Menu Order', 'starter-elementor-addon' ),
					'ID'         => esc_html__( 'Post ID', 'starter-elementor-addon' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Sort Order', 'starter-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending', 'starter-elementor-addon' ),
					'ASC'  => esc_html__( 'Ascending', 'starter-elementor-addon' ),
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// CONTENT TAB - Layout Configuration
		// =====================================================
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Grid Layout Settings', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Grid Columns', 'starter-elementor-addon' ),
				'type'           => \Elementor\Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'selectors'      => [
					'{{WRAPPER}} .starter-starter-post-grid' => '--starter-starter-grid-cols: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_gap',
			[
				'label'      => esc_html__( 'Column Gap', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default'    => [ 'size' => 30, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-post-grid' => '--starter-starter-grid-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'      => esc_html__( 'Row Gap', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default'    => [ 'size' => 30, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-post-grid' => '--starter-starter-grid-row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label'     => esc_html__( 'Show Pagination', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'starter-elementor-addon' ),
				'label_off' => esc_html__( 'No', 'starter-elementor-addon' ),
				'default'   => 'no',
			]
		);

		$this->end_controls_section();

		// =====================================================
		// CONTENT TAB - Elements Toggle
		// =====================================================
		$this->start_controls_section(
			'section_elements',
			[
				'label' => esc_html__( 'Card Elements Display', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_thumbnail',
			[
				'label'     => esc_html__( 'Show Featured Image', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'starter-elementor-addon' ),
				'label_off' => esc_html__( 'Hide', 'starter-elementor-addon' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'image_ratio',
			[
				'label'     => esc_html__( 'Featured Image Ratio', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'aspect-16/10',
				'options'   => [
					'aspect-16/9'  => '16:9',
					'aspect-16/10' => '16:10',
					'aspect-4/3'   => '4:3',
					'aspect-square'=> '1:1 (Square)',
				],
				'condition' => [
					'show_thumbnail' => 'yes',
				],
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
			'title_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'h4',
				'options'   => [
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
				],
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_meta',
			[
				'label'     => esc_html__( 'Show Meta Details', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'starter-elementor-addon' ),
				'label_off' => esc_html__( 'Hide', 'starter-elementor-addon' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'     => esc_html__( 'Show Date', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'starter-elementor-addon' ),
				'label_off' => esc_html__( 'Hide', 'starter-elementor-addon' ),
				'default'   => 'yes',
				'condition' => [
					'show_meta' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'     => esc_html__( 'Show First Term (Category)', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'starter-elementor-addon' ),
				'label_off' => esc_html__( 'Hide', 'starter-elementor-addon' ),
				'default'   => 'yes',
				'condition' => [
					'show_meta' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'     => esc_html__( 'Show Excerpt / Description', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'starter-elementor-addon' ),
				'label_off' => esc_html__( 'Hide', 'starter-elementor-addon' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'     => esc_html__( 'Excerpt Word Limit', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 20,
				'min'     => 1,
				'max'     => 100,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_readmore',
			[
				'label'     => esc_html__( 'Show Read More Button', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'starter-elementor-addon' ),
				'label_off' => esc_html__( 'Hide', 'starter-elementor-addon' ),
				'default'   => 'no',
			]
		);

		$this->add_control(
			'readmore_text',
			[
				'label'       => esc_html__( 'Read More Label', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'อ่านเพิ่มเติม', 'starter-elementor-addon' ),
				'label_block' => true,
				'condition'   => [
					'show_readmore' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Card Box Styling
		// =====================================================
		$this->start_controls_section(
			'style_card',
			[
				'label' => esc_html__( 'Card Container', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg',
			[
				'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-post-grid__card' => '--starter-starter-card-bg: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Card Padding', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => '20',
					'right'  => '20',
					'bottom' => '24',
					'left'   => '20',
					'unit'   => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-post-grid__card' => '--starter-starter-card-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 50 ],
				],
				'default'    => [ 'size' => 24, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-post-grid__card' => '--starter-starter-card-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_border_width',
			[
				'label'      => esc_html__( 'Border Width', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 10 ],
				],
				'default'    => [ 'size' => 1, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-post-grid__card' => '--starter-starter-card-border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.05)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-post-grid__card' => '--starter-starter-card-border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_shadow',
				'label'    => esc_html__( 'Box Shadow', 'starter-elementor-addon' ),
				'selector' => '{{WRAPPER}} .starter-starter-post-grid__card',
				'fields_options' => [
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 8,
							'blur'       => 24,
							'spread'     => 0,
							'color'      => 'rgba(0,0,0,0.03)',
						],
					],
				],
			]
		);

		// Hover Animation Controls
		$this->add_responsive_control(
			'card_hover_y',
			[
				'label'      => esc_html__( 'Hover Shift Up (Y Axis)', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => -30, 'max' => 0 ],
				],
				'default'    => [ 'size' => -6, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-post-grid__card' => '--starter-starter-card-hover-y: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Image Styles
		// =====================================================
		$this->start_controls_section(
			'style_image',
			[
				'label' => esc_html__( 'Featured Image Styling', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_thumbnail' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'image_radius',
			[
				'label'      => esc_html__( 'Image Border Radius', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 50 ],
				],
				'default'    => [ 'size' => 16, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-post-grid__image-wrap' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Typography & Elements Color Styling
		// =====================================================
		$this->start_controls_section(
			'style_content',
			[
				'label' => esc_html__( 'Card Typography & Colors', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Meta Section Styles
		$this->add_control(
			'heading_meta_style',
			[
				'label'     => esc_html__( 'Meta Styles', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_meta' => 'yes',
				],
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'     => esc_html__( 'Meta Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'var(--color-primary, #EC008C)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-post-grid__meta' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_meta' => 'yes',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'meta_typography',
				'selector'  => '{{WRAPPER}} .starter-starter-post-grid__meta',
				'condition' => [
					'show_meta' => 'yes',
				],
			]
		);

		// Title Section Styles
		$this->add_control(
			'heading_title_style',
			[
				'label'     => esc_html__( 'Title Styles', 'starter-elementor-addon' ),
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
				'default'   => '#1f2937',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-post-grid__title a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'     => esc_html__( 'Title Hover Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'var(--color-primary, #EC008C)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-post-grid__card:hover .starter-starter-post-grid__title a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'selector'  => '{{WRAPPER}} .starter-starter-post-grid__title',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		// Excerpt Section Styles
		$this->add_control(
			'heading_excerpt_style',
			[
				'label'     => esc_html__( 'Excerpt Styles', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label'     => esc_html__( 'Excerpt Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#6b7280',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-post-grid__excerpt' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'excerpt_typography',
				'selector'  => '{{WRAPPER}} .starter-starter-post-grid__excerpt',
				'condition' => [
					'show_excerpt' => 'yes',
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

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
		
		$args = [
			'post_type'      => esc_attr( $settings['post_type'] ),
			'posts_per_page' => intval( $settings['posts_per_page'] ),
			'paged'          => $paged,
			'orderby'        => esc_attr( $settings['orderby'] ),
			'order'          => esc_attr( $settings['order'] ),
			'post_status'    => 'publish',
		];

		// Dynamic Tax Queries
		$tax_query = [];
		$taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );
		if ( ! is_wp_error( $taxonomies ) && is_array( $taxonomies ) ) {
			foreach ( $taxonomies as $taxonomy ) {
				$control_key = 'tax_filter_' . $taxonomy->name;
				if ( ! empty( $settings[ $control_key ] ) && is_array( $settings[ $control_key ] ) ) {
					$tax_query[] = [
						'taxonomy' => $taxonomy->name,
						'field'    => 'slug',
						'terms'    => $settings[ $control_key ],
						'operator' => 'IN',
					];
				}
			}
		}

		if ( count( $tax_query ) > 1 ) {
			$tax_query['relation'] = 'AND';
		}

		if ( ! empty( $tax_query ) ) {
			$args['tax_query'] = $tax_query;
		}

		$query = new \WP_Query( $args );

		if ( $query->have_posts() ) {
			wp_enqueue_style( 'starter-starter-post-grid', STARTER_URL . 'widgets/starter-post-grid/starter-post-grid.css', [], STARTER_VERSION );

			$columns_desktop = ! empty( $settings['columns'] ) ? $settings['columns'] : 3;
			$columns_tablet  = ! empty( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 2;
			$columns_mobile  = ! empty( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 1;

			$grid_gap = ! empty( $settings['grid_gap']['size'] ) ? $settings['grid_gap']['size'] . $settings['grid_gap']['unit'] : '30px';
			$row_gap  = ! empty( $settings['row_gap']['size'] ) ? $settings['row_gap']['size'] . $settings['row_gap']['unit'] : '30px';

			$style_attr = sprintf(
				'style="--starter-starter-grid-cols: %d; --starter-starter-grid-cols-tablet: %d; --starter-starter-grid-cols-mobile: %d; --starter-starter-grid-gap: %s; --starter-starter-grid-row-gap: %s;"',
				intval( $columns_desktop ),
				intval( $columns_tablet ),
				intval( $columns_mobile ),
				esc_attr( $grid_gap ),
				esc_attr( $row_gap )
			);
			
			echo '<div class="starter-starter-post-grid-wrapper">';
			echo '<div class="starter-starter-post-grid" ' . $style_attr . '>';

			while ( $query->have_posts() ) {
				$query->the_post();
				$post_id = get_the_ID();
				$thumb_url = get_the_post_thumbnail_url( $post_id, 'medium_large' );
				?>
				<article class="starter-starter-post-grid__card group">
					
					<?php if ( $settings['show_thumbnail'] === 'yes' ) : ?>
						<div class="starter-starter-post-grid__image-wrap <?php echo esc_attr( $settings['image_ratio'] ); ?>">
							<a href="<?php the_permalink(); ?>" class="starter-starter-post-grid__image-link block w-full h-full">
								<?php if ( $thumb_url ) : ?>
									<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
								<?php else : ?>
									<div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
										<i class="far fa-image fa-2x"></i>
									</div>
								<?php endif; ?>
							</a>
						</div>
					<?php endif; ?>

					<div class="starter-starter-post-grid__content">
						
						<?php 
						if ( $settings['show_meta'] === 'yes' ) : 
							$has_date = ( $settings['show_date'] === 'yes' );
							$has_term = false;
							$term_name = '';

							if ( $settings['show_category'] === 'yes' ) {
								$taxonomies = get_post_taxonomies( $post_id );
								$selected_taxonomy = '';
								if ( ! empty( $taxonomies ) ) {
									foreach ( $taxonomies as $tax ) {
										if ( is_taxonomy_hierarchical( $tax ) ) {
											$selected_taxonomy = $tax;
											break;
										}
									}
									if ( empty( $selected_taxonomy ) ) {
										$selected_taxonomy = $taxonomies[0];
									}
								}
								
								if ( ! empty( $selected_taxonomy ) ) {
									$terms = get_the_terms( $post_id, $selected_taxonomy );
									if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
										$term_name = $terms[0]->name;
										$has_term = true;
									}
								}
							}

							// If we show at least one meta element, render the meta container
							if ( $has_date || $has_term ) :
							?>
								<div class="starter-starter-post-grid__meta flex items-center gap-3 mb-0">
									<?php if ( $has_date ) : ?>
										<span class="starter-starter-post-grid__date">
											<?php 
											if ( function_exists( 'cttm_thai_date' ) ) {
												echo esc_html( cttm_thai_date( $post_id, 'short' ) );
											} else {
												echo esc_html( get_the_date() );
											}
											?>
										</span>
									<?php endif; ?>

									<?php if ( $has_date && $has_term ) : ?>
										<span class="starter-starter-post-grid__divider"></span>
									<?php endif; ?>

									<?php if ( $has_term ) : ?>
										<span class="starter-starter-post-grid__term">
											<?php echo esc_html( $term_name ); ?>
										</span>
									<?php endif; ?>
								</div>
							<?php 
							endif;
						endif; 
						?>

						<?php if ( $settings['show_title'] === 'yes' ) : ?>
							<<?php echo esc_attr( $settings['title_tag'] ); ?> class="starter-starter-post-grid__title font-display">
								<a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors block">
									<?php the_title(); ?>
								</a>
							</<?php echo esc_attr( $settings['title_tag'] ); ?>>
						<?php endif; ?>

						<?php if ( $settings['show_excerpt'] === 'yes' ) : ?>
							<div class="starter-starter-post-grid__excerpt">
								<?php 
								$excerpt = get_the_excerpt();
								if ( empty( $excerpt ) ) {
									$excerpt = wp_strip_all_tags( get_the_content() );
								}
								echo esc_html( wp_trim_words( $excerpt, intval( $settings['excerpt_length'] ), '...' ) );
								?>
							</div>
						<?php endif; ?>

						<?php if ( $settings['show_readmore'] === 'yes' ) : ?>
							<div class="starter-starter-post-grid__action pt-4">
								<a href="<?php the_permalink(); ?>" class="starter-starter-post-grid__btn flex items-center justify-center font-medium gap-2">
									<?php echo esc_html( $settings['readmore_text'] ); ?>
									<i class="fas fa-arrow-right text-xs"></i>
								</a>
							</div>
						<?php endif; ?>

					</div>

				</article>
				<?php
			}

			echo '</div>';

			// Pagination
			if ( $settings['show_pagination'] === 'yes' ) {
				$big = 999999999;
				$pagination = paginate_links( [
					'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => '?paged=%#%',
					'current'   => max( 1, $paged ),
					'total'     => $query->max_num_pages,
					'prev_text' => '<i class="fas fa-chevron-left"></i>',
					'next_text' => '<i class="fas fa-chevron-right"></i>',
					'type'      => 'plain',
				] );

				if ( ! empty( $pagination ) ) {
					echo '<div class="starter-starter-post-grid-pagination flex justify-center items-center gap-2 mt-12">';
					echo $pagination;
					echo '</div>';
				}
			}

			echo '</div>';
			wp_reset_postdata();

		} else {
			echo '<div class="starter-starter-post-grid-empty">';
			echo esc_html__( 'No matching posts found.', 'starter-elementor-addon' );
			echo '</div>';
		}
	}

	/**
	 * Mock Elementor Editor preview (Synchronization Rule)
	 */
	protected function content_template() {
		?>
		<div class="starter-starter-post-grid-wrapper">
			<#
			var columns = settings.columns ? settings.columns : 3;
			var colsTablet = settings.columns_tablet ? settings.columns_tablet : 2;
			var colsMobile = settings.columns_mobile ? settings.columns_mobile : 1;
			var showThumbnail = settings.show_thumbnail === 'yes';
			var showTitle = settings.show_title === 'yes';
			var showMeta = settings.show_meta === 'yes';
			var showExcerpt = settings.show_excerpt === 'yes';
			var showReadmore = settings.show_readmore === 'yes';
			#>
			<div class="starter-starter-post-grid" style="--starter-starter-grid-cols: {{ columns }}; --starter-starter-grid-cols-tablet: {{ colsTablet }}; --starter-starter-grid-cols-mobile: {{ colsMobile }}; --starter-starter-grid-gap: {{ settings.grid_gap.size }}{{ settings.grid_gap.unit }}; --starter-starter-grid-row-gap: {{ settings.row_gap.size }}{{ settings.row_gap.unit }};">
				<# for ( var i = 1; i <= 3; i++ ) { #>
					<article class="starter-starter-post-grid__card group">
						<# if ( showThumbnail ) { #>
							<div class="starter-starter-post-grid__image-wrap {{ settings.image_ratio }}">
								<a href="#" class="starter-starter-post-grid__image-link block w-full h-full">
									<div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
										<i class="far fa-image fa-2x"></i>
									</div>
								</a>
							</div>
						<# } #>

						<div class="starter-starter-post-grid__content">
							<# if ( showMeta ) { 
								var hasDate = settings.show_date === 'yes';
								var hasCategory = settings.show_category === 'yes';
								if ( hasDate || hasCategory ) {
							#>
								<div class="starter-starter-post-grid__meta flex items-center gap-3 mb-0">
									<# if ( hasDate ) { #>
										<span class="starter-starter-post-grid__date">29 พ.ค. 2569</span>
									<# } #>

									<# if ( hasDate && hasCategory ) { #>
										<span class="starter-starter-post-grid__divider"></span>
									<# } #>

									<# if ( hasCategory ) { #>
										<span class="starter-starter-post-grid__term">ข่าวสาร/บริการ</span>
									<# } #>
								</div>
							<# } } #>

							<# if ( showTitle ) { #>
								<{{ settings.title_tag }} class="starter-starter-post-grid__title font-display">
									<a href="#" class="hover:text-primary transition-colors block">บทความจำลองชิ้นที่ {{ i }} สำหรับทดสอบบน Editor</a>
								</{{ settings.title_tag }}>
							<# } #>

							<# if ( showExcerpt ) { #>
								<div class="starter-starter-post-grid__excerpt">
									นี่คือรายละเอียดจำลองบางส่วนของโพสต์เพื่อความสวยงามในหน้าแก้ไข โดยจำกัดความยาวคำให้สมดุลและเข้าคู่กัน...
								</div>
							<# } #>

							<# if ( showReadmore ) { #>
								<div class="starter-starter-post-grid__action pt-4">
									<a href="#" class="starter-starter-post-grid__btn flex items-center justify-center font-medium gap-2">
										{{{ settings.readmore_text }}}
										<i class="fas fa-arrow-right text-xs"></i>
									</a>
								</div>
							<# } #>
						</div>
					</article>
				<# } #>
			</div>

			<# if ( settings.show_pagination === 'yes' ) { #>
				<div class="starter-starter-post-grid-pagination flex justify-center items-center gap-2 mt-12">
					<span class="page-numbers current">1</span>
					<span class="page-numbers">2</span>
					<span class="page-numbers">3</span>
				</div>
			<# } #>
		</div>
		<?php
	}
}

add_action( 'wp_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-post-grid/starter-post-grid.css';
	wp_register_style(
		'starter-starter-post-grid',
		STARTER_URL . 'widgets/starter-post-grid/starter-post-grid.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );

add_action( 'elementor/editor/after_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-post-grid/starter-post-grid.css';
	wp_enqueue_style(
		'starter-starter-post-grid',
		STARTER_URL . 'widgets/starter-post-grid/starter-post-grid.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );
