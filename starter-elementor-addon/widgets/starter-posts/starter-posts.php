<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class STARTER_Widget_starter_Posts extends \Elementor\Widget_Base {

	public function get_name()       { return 'starter-posts'; }
	public function get_title()      { return esc_html__( 'KU Posts / Articles', 'starter-elementor-addon' ); }
	public function get_icon()       { return 'eicon-post-list'; }
	public function get_categories() { return [ 'starter-elementor-addon' ]; }
	public function get_keywords()   { return [ 'posts', 'articles', 'blog', 'news', 'query' ]; }

	public function get_style_depends()  { return [ 'starter-starter-posts' ]; }
	public function get_script_depends() { return [ 'starter-starter-posts' ]; }

	protected function register_controls() {

		// Content Tab
		$this->start_controls_section( 'section_layout', [
			'label' => esc_html__( 'Layout', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'layout_type', [
			'label'   => esc_html__( 'Layout Style', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'grid',
			'options' => [
				'grid' => esc_html__( 'Grid Layout', 'starter-elementor-addon' ),
				'list' => esc_html__( 'Sidebar List Layout', 'starter-elementor-addon' ),
				'row'  => esc_html__( 'Large Row Layout', 'starter-elementor-addon' ),
			],
		] );

		$this->add_responsive_control( 'columns', [
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
			'condition'      => [
				'layout_type' => 'grid',
			],
		] );

		$this->add_control( 'posts_per_page', [
			'label'   => esc_html__( 'Posts Limit', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'default' => 6,
			'min'     => 1,
			'max'     => 100,
		] );

		$this->end_controls_section();

		// Query Settings
		$this->start_controls_section( 'section_query', [
			'label' => esc_html__( 'Query Settings', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

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

		$this->add_control( 'post_type', [
			'label'   => esc_html__( 'Post Type', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'post',
			'options' => $post_type_options,
		] );

		// Fetch all public taxonomies dynamically
		$taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );
		if ( ! is_wp_error( $taxonomies ) && is_array( $taxonomies ) ) {
			foreach ( $taxonomies as $taxonomy ) {
				// Fetch terms for this taxonomy
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
					$this->add_control( 'tax_filter_' . $taxonomy->name, [
						'label'       => sprintf( esc_html__( 'Filter by %s', 'starter-elementor-addon' ), $taxonomy->label ),
						'type'        => \Elementor\Controls_Manager::SELECT2,
						'multiple'    => true,
						'options'     => $term_options,
						'label_block' => true,
						'description' => sprintf( esc_html__( 'Select terms to filter from %s. Leave empty to show all.', 'starter-elementor-addon' ), $taxonomy->label ),
						'condition'   => [
							'post_type' => $taxonomy->object_type,
						],
					] );
				}
			}
		}

		$this->add_control( 'orderby', [
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
		] );

		$this->add_control( 'order', [
			'label'   => esc_html__( 'Sort Order', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'DESC',
			'options' => [
				'DESC' => esc_html__( 'Descending', 'starter-elementor-addon' ),
				'ASC'  => esc_html__( 'Ascending', 'starter-elementor-addon' ),
			],
		] );

		$this->end_controls_section();

		// Pagination Settings
		$this->start_controls_section( 'section_pagination', [
			'label' => esc_html__( 'Pagination Settings', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_pagination', [
			'label'     => esc_html__( 'Show Pagination', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Yes', 'starter-elementor-addon' ),
			'label_off' => esc_html__( 'No', 'starter-elementor-addon' ),
			'default'   => 'no',
		] );

		$this->end_controls_section();

		// Style Tab
		$this->start_controls_section( 'style_layout', [
			'label' => esc_html__( 'Layout Spacing', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'row_gap', [
			'label'      => esc_html__( 'Row Gap', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'    => [ 'size' => 30, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-posts' => '--starter-posts-row-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'col_gap', [
			'label'      => esc_html__( 'Column Gap', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'    => [ 'size' => 30, 'unit' => 'px' ],
			'condition'  => [
				'layout_type' => 'grid',
			],
			'selectors'  => [ '{{WRAPPER}} .starter-posts' => '--starter-posts-col-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// Pagination Styles
		$this->start_controls_section( 'style_pagination', [
			'label'     => esc_html__( 'Pagination Settings', 'starter-elementor-addon' ),
			'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [
				'show_pagination' => 'yes',
			],
		] );

		$this->add_responsive_control( 'pagination_align', [
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
			'selectors' => [ '{{WRAPPER}} .starter-posts__pagination' => 'justify-content: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'pagination_typography',
			'label'    => esc_html__( 'Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-posts__pagination .page-numbers',
		] );

		$this->add_responsive_control( 'pagination_margin_top', [
			'label'      => esc_html__( 'Margin Top', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 150 ] ],
			'default'    => [ 'size' => 48, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-posts__pagination' => 'margin-top: {{SIZE}}{{UNIT}};' ],
		] );

		$this->start_controls_tabs( 'tabs_pagination_style' );

		$this->start_controls_tab( 'tab_pagination_normal', [
			'label' => esc_html__( 'Normal', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'pagination_color', [
			'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--base-muted, #7A8B9B)',
			'selectors' => [ '{{WRAPPER}} .starter-posts__pagination .page-numbers:not(.current)' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'pagination_bg', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-posts__pagination .page-numbers:not(.current)' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'pagination_border_color', [
			'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(0,0,0,0.08)',
			'selectors' => [ '{{WRAPPER}} .starter-posts__pagination .page-numbers:not(.current)' => 'border-color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_pagination_active', [
			'label' => esc_html__( 'Active / Hover', 'starter-elementor-addon' ),
		] );

		$this->add_control( 'pagination_active_color', [
			'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ 
				'{{WRAPPER}} .starter-posts__pagination .page-numbers.current' => 'color: {{VALUE}};',
				'{{WRAPPER}} .starter-posts__pagination .page-numbers:hover:not(.current)' => 'color: {{VALUE}};'
			],
		] );

		$this->add_control( 'pagination_active_bg', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--color-primary, #EC008C)',
			'selectors' => [ 
				'{{WRAPPER}} .starter-posts__pagination .page-numbers.current' => 'background-color: {{VALUE}};',
				'{{WRAPPER}} .starter-posts__pagination .page-numbers:hover:not(.current)' => 'background-color: {{VALUE}};'
			],
		] );

		$this->add_control( 'pagination_active_border_color', [
			'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'var(--color-primary, #EC008C)',
			'selectors' => [ 
				'{{WRAPPER}} .starter-posts__pagination .page-numbers.current' => 'border-color: {{VALUE}};',
				'{{WRAPPER}} .starter-posts__pagination .page-numbers:hover:not(.current)' => 'border-color: {{VALUE}};'
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control( 'pagination_padding', [
			'label'      => esc_html__( 'Item Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [
				'top'      => '10',
				'right'    => '16',
				'bottom'   => '10',
				'left'     => '16',
				'unit'     => 'px',
				'isLinked' => false,
			],
			'selectors'  => [ '{{WRAPPER}} .starter-posts__pagination .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'pagination_radius', [
			'label'      => esc_html__( 'Item Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 12, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-posts__pagination .page-numbers' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();
	}

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

		// Construct tax_query based on active terms selected in dynamic controls
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
			wp_enqueue_style( 'starter-starter-posts', STARTER_URL . 'widgets/starter-posts/starter-posts.css', [], STARTER_VERSION );

			$columns_desktop = ! empty( $settings['columns'] ) ? $settings['columns'] : 3;
			$columns_tablet  = ! empty( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 2;
			$columns_mobile  = ! empty( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 1;

			$style_attr = '';
			if ( $settings['layout_type'] === 'grid' ) {
				$style_attr = sprintf(
					'style="--starter-posts-columns-desktop: %d; --starter-posts-columns-tablet: %d; --starter-posts-columns-mobile: %d;"',
					intval( $columns_desktop ),
					intval( $columns_tablet ),
					intval( $columns_mobile )
				);
			}

			$wrapper_classes = [ 'starter-posts__wrapper' ];
			if ( $settings['layout_type'] === 'grid' ) {
				$wrapper_classes[] = 'starter-posts__wrapper--grid';
			} elseif ( $settings['layout_type'] === 'list' ) {
				$wrapper_classes[] = 'starter-posts__wrapper--list';
			} elseif ( $settings['layout_type'] === 'row' ) {
				$wrapper_classes[] = 'starter-posts__wrapper--row';
			}

			echo '<div class="starter-posts starter-posts--layout-' . esc_attr( $settings['layout_type'] ) . '">';
			echo '<div class="' . esc_attr( implode( ' ', $wrapper_classes ) ) . '" ' . $style_attr . '>';

			while ( $query->have_posts() ) {
				$query->the_post();
				get_template_part( 'template-parts/post-card', $settings['layout_type'] );
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
					'prev_text' => '<i class="ri-arrow-left-s-line"></i>',
					'next_text' => '<i class="ri-arrow-right-s-line"></i>',
					'type'      => 'plain',
				] );

				if ( ! empty( $pagination ) ) {
					echo '<div class="starter-posts__pagination">';
					echo $pagination;
					echo '</div>';
				}
			}

			echo '</div>';
			wp_reset_postdata();
		} else {
			echo '<div class="starter-posts-empty">';
			echo esc_html__( 'No posts found.', 'starter-elementor-addon' );
			echo '</div>';
		}
	}

	protected function content_template() {
		?>
		<div class="starter-posts starter-posts--layout-{{{ settings.layout_type }}}">
			<#
			var colsDesktop = settings.columns ? settings.columns : 3;
			var colsTablet = settings.columns_tablet ? settings.columns_tablet : 2;
			var colsMobile = settings.columns_mobile ? settings.columns_mobile : 1;
			
			var wrapperClass = 'starter-posts__wrapper';
			if ( settings.layout_type === 'grid' ) {
				wrapperClass += ' starter-posts__wrapper--grid';
			} else if ( settings.layout_type === 'list' ) {
				wrapperClass += ' starter-posts__wrapper--list';
			} else if ( settings.layout_type === 'row' ) {
				wrapperClass += ' starter-posts__wrapper--row';
			}
			
			var styleAttr = '';
			if ( settings.layout_type === 'grid' ) {
				styleAttr = 'style="--starter-posts-columns-desktop: ' + colsDesktop + '; --starter-posts-columns-tablet: ' + colsTablet + '; --starter-posts-columns-mobile: ' + colsMobile + ';"';
			}
			#>
			
			<div class="{{ wrapperClass }}" {{{ styleAttr }}}>
				<# for ( var i = 1; i <= 3; i++ ) { #>
					<# if ( settings.layout_type === 'grid' ) { #>
						<!-- Mock Grid Post Card matching template-parts/post-card-grid.php structure -->
						<article class="starter-theme-post-card-grid starter-theme-post-grid group block space-y-4">
							<a href="#" class="starter-theme-post-grid__link block">
								<div class="starter-theme-post-grid__image-wrap aspect-16/10 rounded-2xl overflow-hidden border border-border-base/50 shadow-sm transition-all duration-500 group-hover:scale-[1.03]">
									<div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
										<i class="ri-image-2-line ri-2x"></i>
									</div>
								</div>
							</a>
							<div class="starter-theme-post-grid__content space-y-2 px-1">
								<div class="starter-theme-post-grid__meta flex items-center gap-3">
									<span class="starter-theme-post-grid__date text-xs font-medium text-primary uppercase tracking-widest">MAY 22, 2026</span>
									<span class="starter-theme-post-grid__divider w-1 h-1 bg-border-base rounded-full opacity-50"></span>
									<span class="starter-theme-post-grid__category text-xs font-light text-muted uppercase tracking-wider">LIFESTYLE</span>
								</div>
								<h4 class="starter-theme-post-grid__title font-medium text-sm leading-snug group-hover:text-primary transition-colors line-clamp-2 m-0 font-display">
									<a href="#">บทความจำลองข่าวสารและกิจกรรมชิ้นที่ {{{ i }}} สำหรับทดสอบการแสดงผลในหน้าแก้ไข</a>
								</h4>
							</div>
						</article>
					<# } else if ( settings.layout_type === 'list' ) { #>
						<!-- Mock List Post Card matching template-parts/post-card-list.php structure -->
						<article class="starter-theme-post-card-sidebar starter-theme-post-sidebar group flex gap-5 items-center">
							<a href="#" class="starter-theme-post-sidebar__image-wrap shrink-0 w-16 h-16 rounded-2xl overflow-hidden bg-surface-base border border-border-base transition-all duration-500">
								<div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
									<i class="ri-image-2-line"></i>
								</div>
							</a>
							<div class="starter-theme-post-sidebar__content flex-1 min-w-0">
								<span class="starter-theme-post-sidebar__date text-sm font-medium text-muted mb-1 block uppercase tracking-wider opacity-60">MAY 22, 2026</span>
								<h5 class="starter-theme-post-sidebar__title text-sm font-medium text-base leading-tight line-clamp-2 group-hover:text-primary transition-colors duration-300 font-display m-0">
									<a href="#">บทความจำลองข่าวสารชิ้นที่ {{{ i }}} สำหรับแสดงผลใน List ด้านข้าง</a>
								</h5>
							</div>
						</article>
					<# } else if ( settings.layout_type === 'row' ) { #>
						<!-- Mock Row Post Card matching template-parts/post-card-row.php structure -->
						<article class="starter-theme-post-card-row starter-theme-post-row group mb-10 md:mb-14 transition-all">
							<div class="starter-theme-post-row__inner flex flex-col md:flex-row gap-6 lg:gap-10 items-start">
								<div class="starter-theme-post-row__image-wrap w-full md:w-64 lg:w-[320px] shrink-0">
									<a href="#" class="starter-theme-post-row__image-link block relative aspect-16/10 md:aspect-square rounded-4xl md:rounded-[3rem] overflow-hidden shadow-2xl shadow-black/5 transition-all duration-500 border border-border-base/10">
										<div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
											<i class="ri-image-2-line ri-3x"></i>
										</div>
									</a>
								</div>
								<div class="flex-1 min-w-0 pt-1">
									<div class="starter-theme-post-row__category-wrap flex flex-wrap gap-2 mb-4">
										<span class="starter-theme-post-row__category px-4 py-1.5 bg-primary/5 text-primary rounded-full text-sm font-medium uppercase tracking-widest leading-none border border-primary/10">
											CLINIC NEWS
										</span>
									</div>
									<h3 class="starter-theme-post-row__title font-display text-[22px] md:text-[28px] font-medium text-base leading-tight mb-4 group-hover:text-primary transition-colors duration-300 tracking-tight">
										<a href="#">บทความจำลองชิ้นที่ {{{ i }}} สำหรับทดสอบ Layout แบบแถวแนวนอนความกว้างเต็มขนาด</a>
									</h3>
									<div class="starter-theme-post-row__excerpt text-[13px] leading-relaxed mb-6 line-clamp-2 md:line-clamp-3 text-muted/80 opacity-90">
										นี่คือรายละเอียดเนื้อหาจำลองบางส่วนของบทความที่จะดึงมาแสดงผล โดยระบบจะทำการตัดข้อความอัตโนมัติเพื่อให้ขนาดของแถวมีสัดส่วนที่สวยงามและอ่านง่ายสูงสุด...
									</div>
									<div class="starter-theme-post-row__meta flex flex-wrap items-center gap-x-6 gap-y-3 pt-5 border-t border-border-base/40 text-[11px] font-medium text-muted uppercase tracking-wider">
										<div class="starter-theme-post-row__date flex items-center gap-2">
											<span class="w-5 h-5 flex items-center justify-center text-gray-800"><i class="ri-arrow-right-line"></i></span>
											MAY 22, 2026
										</div>
										<div class="starter-theme-post-row__reading-time flex items-center gap-2">
											<span class="w-5 h-5 flex items-center justify-center text-gray-800"><i class="ri-arrow-right-line"></i></span>
											3 นาที
										</div>
									</div>
								</div>
							</div>
						</article>
					<# } #>
				<# } #>
			</div>
			
			<# if ( settings.show_pagination === 'yes' ) { #>
				<div class="starter-posts__pagination">
					<span class="page-numbers current">1</span>
					<a class="page-numbers" href="#">2</a>
					<a class="page-numbers" href="#">3</a>
					<span class="page-numbers dots">…</span>
				</div>
			<# } #>
		</div>
		<?php
	}
}

add_action( 'wp_enqueue_scripts', function() {
	wp_register_style(  'starter-starter-posts', STARTER_URL . 'widgets/starter-posts/starter-posts.css', [], STARTER_VERSION );
	wp_register_script( 'starter-starter-posts', STARTER_URL . 'widgets/starter-posts/starter-posts.js',  [], STARTER_VERSION, true );
} );
add_action( 'elementor/editor/before_enqueue_scripts', function() {
	wp_enqueue_style( 'starter-starter-posts', STARTER_URL . 'widgets/starter-posts/starter-posts.css', [], STARTER_VERSION );
} );
