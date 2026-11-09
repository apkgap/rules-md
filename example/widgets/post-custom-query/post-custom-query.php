<?php
declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class EXAT_Post_Custom_Query_Widget
 *
 * A reference Elementor Widget showing custom post, taxonomy, and terms query pattern
 * with visibility, aspect ratio, and responsive column layout controls (inline card markup, no card.php).
 */
class EXAT_Post_Custom_Query_Widget extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'exat-post-custom-query';
	}

	public function get_title(): string {
		return esc_html__( 'Post Custom Query', 'exat-elementor-addon' );
	}

	public function get_icon(): string {
		return 'eicon-post-list';
	}

	public function get_categories(): array {
		return [ 'general' ];
	}

	public function get_style_depends(): array {
		return [ 'exat-post-custom-query' ];
	}

	public function get_script_depends(): array {
		return [ 'exat-post-custom-query' ];
	}

	/**
	 * Get registered public post types (excluding attachment).
	 */
	protected function get_active_post_types(): array {
		$post_types = get_post_types( [ 'public' => true ], 'objects' );
		$options    = [];
		foreach ( $post_types as $post_type ) {
			if ( 'attachment' === $post_type->name ) {
				continue;
			}
			$options[ $post_type->name ] = $post_type->label;
		}
		return $options;
	}

	/**
	 * Get public taxonomies for controls.
	 */
	protected function get_active_taxonomies(): array {
		$taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );
		$options    = [];
		foreach ( $taxonomies as $taxonomy ) {
			$options[ $taxonomy->name ] = $taxonomy->label;
		}
		return $options;
	}

	protected function register_controls(): void {
		// Query Section
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query Settings', 'exat-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'query_post_type',
			[
				'label'   => esc_html__( 'Post Type', 'exat-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'post',
				'options' => $this->get_active_post_types(),
			]
		);

		// Fetch all public taxonomies dynamically and register a Select2 filter for each
		$taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );
		if ( ! is_wp_error( $taxonomies ) && is_array( $taxonomies ) ) {
			foreach ( $taxonomies as $taxonomy ) {
				$terms = get_terms(
					[
						'taxonomy'   => $taxonomy->name,
						'hide_empty' => false,
					]
				);

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
							'label'       => sprintf( esc_html__( 'Filter by %s', 'exat-elementor-addon' ), $taxonomy->label ),
							'type'        => \Elementor\Controls_Manager::SELECT2,
							'multiple'    => true,
							'options'     => $term_options,
							'label_block' => true,
							'description' => sprintf( esc_html__( 'Select terms to filter from %s. Leave empty to show all.', 'exat-elementor-addon' ), $taxonomy->label ),
							'condition'   => [
								'query_post_type' => $taxonomy->object_type,
							],
						]
					);
				}
			}
		}

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Posts Limit', 'exat-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'max'     => 100,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'exat-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'       => esc_html__( 'Date', 'exat-elementor-addon' ),
					'title'      => esc_html__( 'Title', 'exat-elementor-addon' ),
					'menu_order' => esc_html__( 'Menu Order', 'exat-elementor-addon' ),
					'rand'       => esc_html__( 'Random', 'exat-elementor-addon' ),
					'ID'         => esc_html__( 'Post ID', 'exat-elementor-addon' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'exat-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC'  => esc_html__( 'Ascending', 'exat-elementor-addon' ),
					'DESC' => esc_html__( 'Descending', 'exat-elementor-addon' ),
				],
			]
		);

		$this->end_controls_section();

		// Layout / Visibility Section
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout Options', 'exat-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// Responsive Columns Control feeding a CSS Variable
		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'exat-elementor-addon' ),
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
					'{{WRAPPER}} .exat-post-custom-query__grid' => '--exat-post-custom-query-cols: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_ratio',
			[
				'label'        => esc_html__( 'Image Aspect Ratio', 'exat-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => '16-9',
				'options'      => [
					'16-9' => esc_html__( '16:9', 'exat-elementor-addon' ),
					'4-3'  => esc_html__( '4:3', 'exat-elementor-addon' ),
					'3-2'  => esc_html__( '3:2', 'exat-elementor-addon' ),
					'1-1'  => esc_html__( '1:1 (Square)', 'exat-elementor-addon' ),
				],
				'prefix_class' => 'exat-post-custom-query--ratio-',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'        => esc_html__( 'Show Title', 'exat-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'exat-elementor-addon' ),
				'label_off'    => esc_html__( 'Hide', 'exat-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'        => esc_html__( 'Show Excerpt / Content', 'exat-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'exat-elementor-addon' ),
				'label_off'    => esc_html__( 'Hide', 'exat-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'        => esc_html__( 'Show Date', 'exat-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'exat-elementor-addon' ),
				'label_off'    => esc_html__( 'Hide', 'exat-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_terms',
			[
				'label'        => esc_html__( 'Show Terms (Categories)', 'exat-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'exat-elementor-addon' ),
				'label_off'    => esc_html__( 'Hide', 'exat-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_button',
			[
				'label'        => esc_html__( 'Show Read More Button', 'exat-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'exat-elementor-addon' ),
				'label_off'    => esc_html__( 'Hide', 'exat-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'exat-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'exat-elementor-addon' ),
				'placeholder' => esc_html__( 'Read More', 'exat-elementor-addon' ),
				'condition'   => [
					'show_button' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Build the query arguments safely based on Elementor controls.
	 */
	protected function build_widget_query( array $settings ): array {
		$post_type       = ! empty( $settings['query_post_type'] ) ? sanitize_key( (string) $settings['query_post_type'] ) : 'post';
		$posts_per_page  = ! empty( $settings['posts_per_page'] ) ? (int) $settings['posts_per_page'] : 6;
		$allowed_orderby = [ 'date', 'title', 'menu_order', 'rand', 'ID' ];
		$orderby_raw     = ! empty( $settings['orderby'] ) ? sanitize_text_field( (string) $settings['orderby'] ) : 'date';
		$orderby         = in_array( $orderby_raw, $allowed_orderby, true ) ? $orderby_raw : 'date';
		$order_raw       = ! empty( $settings['order'] ) ? strtoupper( sanitize_text_field( (string) $settings['order'] ) ) : 'DESC';
		$order           = in_array( $order_raw, [ 'ASC', 'DESC' ], true ) ? $order_raw : 'DESC';

		$args = [
			'post_type'           => $post_type,
			'posts_per_page'      => $posts_per_page,
			'orderby'             => $orderby,
			'order'               => $order,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		];

		// Build tax_query dynamically based on selected terms for all taxonomies
		$tax_query  = [];
		$taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );
		if ( ! is_wp_error( $taxonomies ) && is_array( $taxonomies ) ) {
			foreach ( $taxonomies as $taxonomy ) {
				$control_key = 'tax_filter_' . $taxonomy->name;
				if ( ! empty( $settings[ $control_key ] ) && is_array( $settings[ $control_key ] ) ) {
					$tax_query[] = [
						'taxonomy' => $taxonomy->name,
						'field'    => 'slug',
						'terms'    => array_map( 'sanitize_key', $settings[ $control_key ] ),
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

		return $args;
	}

	protected function render(): void {
		$settings   = $this->get_settings_for_display();
		$query_args = $this->build_widget_query( $settings );
		$query      = new \WP_Query( $query_args );

		// Extract Layout Settings
		$show_title   = 'yes' === ( $settings['show_title'] ?? '' );
		$show_excerpt = 'yes' === ( $settings['show_excerpt'] ?? '' );
		$show_date    = 'yes' === ( $settings['show_date'] ?? '' );
		$show_terms   = 'yes' === ( $settings['show_terms'] ?? '' );
		$show_button  = 'yes' === ( $settings['show_button'] ?? '' );
		$button_text  = ! empty( $settings['button_text'] ) ? (string) $settings['button_text'] : esc_html__( 'Read More', 'exat-elementor-addon' );

		if ( $query->have_posts() ) {
			// HTML attributes convention: id must come before class
			echo '<div id="exat-post-custom-query-' . esc_attr( $this->get_id() ) . '" class="exat-post-custom-query__grid">';

			while ( $query->have_posts() ) {
				$query->the_post();
				$post_id   = (int) get_the_ID();
				$title     = get_the_title();
				$permalink = get_permalink();
				$excerpt   = get_the_excerpt();
				$has_thumb = has_post_thumbnail( $post_id );
				?>
				<div id="exat-post-card-<?php echo esc_attr( (string) $post_id ); ?>" class="exat-post-custom-query__card">
					<?php if ( $has_thumb ) : ?>
						<div class="exat-post-custom-query__card-image-wrapper">
							<a href="<?php echo esc_url( (string) $permalink ); ?>">
								<?php
								echo wp_get_attachment_image(
									(int) get_post_thumbnail_id( $post_id ),
									'medium',
									false,
									[
										'class' => 'exat-post-custom-query__card-image',
										'alt'   => $title,
									]
								);
								?>
							</a>
						</div>
					<?php endif; ?>

					<div class="exat-post-custom-query__card-content">
						<?php
						if ( $show_terms ) :
							$post_terms      = [];
							$post_type       = get_post_type( $post_id );
							$post_taxonomies = $post_type ? get_object_taxonomies( $post_type, 'names' ) : [];
							if ( ! empty( $post_taxonomies ) ) {
								foreach ( $post_taxonomies as $tax ) {
									$terms = get_the_terms( $post_id, $tax );
									if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
										foreach ( $terms as $term ) {
											$post_terms[] = $term;
										}
									}
								}
							}
							if ( ! empty( $post_terms ) ) :
								?>
								<div class="exat-post-custom-query__card-terms">
									<?php foreach ( $post_terms as $term ) : ?>
										<span class="exat-post-custom-query__card-term-item">
											<?php echo esc_html( $term->name ); ?>
										</span>
									<?php endforeach; ?>
								</div>
								<?php
							endif;
						endif;
						?>

						<?php if ( $show_title ) : ?>
							<h3 class="exat-post-custom-query__card-title">
								<a href="<?php echo esc_url( (string) $permalink ); ?>">
									<?php echo esc_html( $title ); ?>
								</a>
							</h3>
						<?php endif; ?>

						<?php if ( $show_excerpt && ! empty( $excerpt ) ) : ?>
							<div class="exat-post-custom-query__card-excerpt">
								<p><?php echo wp_kses_post( $excerpt ); ?></p>
							</div>
						<?php endif; ?>

						<?php if ( $show_date || $show_button ) : ?>
							<div class="exat-post-custom-query__card-footer">
								<?php if ( $show_date ) : ?>
									<span class="exat-post-custom-query__card-date">
										<?php echo esc_html( (string) get_the_date( '', $post_id ) ); ?>
									</span>
								<?php endif; ?>

								<?php if ( $show_button ) : ?>
									<a href="<?php echo esc_url( (string) $permalink ); ?>" class="exat-post-custom-query__card-button">
										<?php echo esc_html( $button_text ); ?>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<?php
			}

			echo '</div>';

			wp_reset_postdata();
		} else {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="elementor-no-posts-found">' . esc_html__( 'No posts found matching the query.', 'exat-elementor-addon' ) . '</div>';
			}
		}
	}

	/**
	 * Content template matching the render outputs precisely for real-time editor rendering.
	 */
	protected function content_template(): void {
		?>
		<# if ( settings.query_post_type ) { #>
			<div id="exat-post-custom-query-{{ view.getID() }}" class="exat-post-custom-query__grid">
				<!-- Dual-Rendering: Simulated preview items matching the exact structure of render() -->
				<# for ( var i = 0; i < 3; i++ ) { #>
					<div id="exat-post-card-preview-{{ i }}" class="exat-post-custom-query__card">
						<div class="exat-post-custom-query__card-image-wrapper">
							<a href="#">
								<div class="exat-post-custom-query__card-image" style="background: #e5e7eb; display: flex; align-items: center; justify-content: center;">
									<span style="color: #6b7280; font-size: 0.875rem;"><?php esc_html_e( 'Preview Image', 'exat-elementor-addon' ); ?></span>
								</div>
							</a>
						</div>

						<div class="exat-post-custom-query__card-content">
							<# if ( settings.show_terms === 'yes' ) { #>
								<div class="exat-post-custom-query__card-terms">
									<span class="exat-post-custom-query__card-term-item">
										<?php esc_html_e( 'Category', 'exat-elementor-addon' ); ?>
									</span>
								</div>
							<# } #>

							<# if ( settings.show_title === 'yes' ) { #>
								<h3 class="exat-post-custom-query__card-title">
									<a href="#"><?php esc_html_e( 'Simulated Post Title', 'exat-elementor-addon' ); ?> #{{ i + 1 }}</a>
								</h3>
							<# } #>

							<# if ( settings.show_excerpt === 'yes' ) { #>
								<div class="exat-post-custom-query__card-excerpt">
									<p><?php esc_html_e( 'This is a simulated post excerpt template for the Elementor editor preview.', 'exat-elementor-addon' ); ?></p>
								</div>
							<# } #>

							<# if ( settings.show_date === 'yes' || settings.show_button === 'yes' ) { #>
								<div class="exat-post-custom-query__card-footer">
									<# if ( settings.show_date === 'yes' ) { #>
										<span class="exat-post-custom-query__card-date">
											<?php echo esc_html( gmdate( 'Y-m-d' ) ); ?>
										</span>
									<# } #>

									<# if ( settings.show_button === 'yes' ) { #>
										<a href="#" class="exat-post-custom-query__card-button">
											{{{ _.escape( settings.button_text || 'Read More' ) }}}
										</a>
									<# } #>
								</div>
							<# } #>
						</div>
					</div>
				<# } #>
			</div>
		<# } #>
		<?php
	}
}
