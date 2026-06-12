<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Elementor KU Dual Color Heading Widget
 */
class STARTER_Widget_starter_Dual_Heading extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 */
	public function get_name() {
		return 'starter-dual-heading';
	}

	/**
	 * Get widget title
	 */
	public function get_title() {
		return esc_html__( 'KU Dual Color Heading', 'starter-elementor-addon' );
	}

	/**
	 * Get widget icon
	 */
	public function get_icon() {
		return 'eicon-heading';
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
		return [ 'heading', 'title', 'dual color', 'color text', 'split heading', 'accent' ];
	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'starter-starter-dual-heading' ];
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {

		// =====================================================
		// CONTENT TAB - Heading Configuration
		// =====================================================
		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Dual Heading Text', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'first_text',
			[
				'label'       => esc_html__( 'First Part Text', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'รีวิวจากคนไข้', 'starter-elementor-addon' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'second_text',
			[
				'label'       => esc_html__( 'Second Part Text (Accent)', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'ของเรา', 'starter-elementor-addon' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'     => esc_html__( 'HTML Tag', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'h2',
				'options'   => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
				],
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'     => esc_html__( 'Alignment', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => esc_html__( 'Left', 'starter-elementor-addon' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'starter-elementor-addon' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'starter-elementor-addon' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'starter-elementor-addon' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-dual-heading-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// CONTENT TAB - Subtitle Configuration
		// =====================================================
		$this->start_controls_section(
			'section_subtitle',
			[
				'label' => esc_html__( 'Subtitle Settings', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_subtitle',
			[
				'label'     => esc_html__( 'Show Subtitle', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'starter-elementor-addon' ),
				'label_off' => esc_html__( 'Hide', 'starter-elementor-addon' ),
				'default'   => 'no',
			]
		);

		$this->add_control(
			'subtitle_text',
			[
				'label'       => esc_html__( 'Subtitle Text', 'starter-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'REVIEWS FROM CLIENTS', 'starter-elementor-addon' ),
				'label_block' => true,
				'condition'   => [
					'show_subtitle' => 'yes',
				],
			]
		);

		$this->add_control(
			'subtitle_position',
			[
				'label'     => esc_html__( 'Subtitle Position', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'below',
				'options'   => [
					'above' => esc_html__( 'Above Heading', 'starter-elementor-addon' ),
					'below' => esc_html__( 'Below Heading', 'starter-elementor-addon' ),
				],
				'condition' => [
					'show_subtitle' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - First Part Style
		// =====================================================
		$this->start_controls_section(
			'style_first_text',
			[
				'label' => esc_html__( 'First Part Text Styles', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'first_color',
			[
				'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1f2937',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-dual-heading__first' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'first_typography',
				'selector' => '{{WRAPPER}} .starter-starter-dual-heading__first',
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Second Part (Accent) Style
		// =====================================================
		$this->start_controls_section(
			'style_second_text',
			[
				'label' => esc_html__( 'Second Part Text (Accent) Styles', 'starter-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'second_color',
			[
				'label'     => esc_html__( 'Text Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'var(--color-primary, #EC008C)',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-dual-heading__second' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'second_typography',
				'selector' => '{{WRAPPER}} .starter-starter-dual-heading__second',
			]
		);

		$this->end_controls_section();

		// =====================================================
		// STYLE TAB - Subtitle Style
		// =====================================================
		$this->start_controls_section(
			'style_subtitle',
			[
				'label'     => esc_html__( 'Subtitle Typography & Colors', 'starter-elementor-addon' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_subtitle' => 'yes',
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'starter-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .starter-starter-dual-heading__subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .starter-starter-dual-heading__subtitle',
			]
		);

		$this->add_responsive_control(
			'subtitle_spacing',
			[
				'label'      => esc_html__( 'Spacing from Heading', 'starter-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'size' => 10, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .starter-starter-dual-heading-wrapper.subtitle-above .starter-starter-dual-heading__subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-top: 0;',
					'{{WRAPPER}} .starter-starter-dual-heading-wrapper.subtitle-below .starter-starter-dual-heading__subtitle' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: 0;',
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

		$first  = isset( $settings['first_text'] ) ? wp_kses_post( $settings['first_text'] ) : '';
		$second = isset( $settings['second_text'] ) ? wp_kses_post( $settings['second_text'] ) : '';
		$tag    = esc_attr( $settings['title_tag'] );
		
		$show_subtitle = ( $settings['show_subtitle'] === 'yes' && ! empty( $settings['subtitle_text'] ) );
		$sub_pos = esc_attr( $settings['subtitle_position'] );
		$sub_text = esc_html( $settings['subtitle_text'] );

		// Enqueue widget styles
		wp_enqueue_style( 'starter-starter-dual-heading', STARTER_URL . 'widgets/starter-dual-heading/starter-dual-heading.css', [], STARTER_VERSION );

		$wrap_classes = [ 'starter-starter-dual-heading-wrapper' ];
		if ( $show_subtitle ) {
			$wrap_classes[] = 'subtitle-' . $sub_pos;
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $wrap_classes ) ); ?>">
			
			<?php if ( $show_subtitle && $sub_pos === 'above' ) : ?>
				<div class="starter-starter-dual-heading__subtitle font-display"><?php echo $sub_text; ?></div>
			<?php endif; ?>

			<<?php echo $tag; ?> class="starter-starter-dual-heading__title font-display m-0">
				<?php if ( ! empty( $first ) ) : ?>
					<span class="starter-starter-dual-heading__first"><?php echo $first; ?></span>
				<?php endif; ?>
				
				<?php if ( ! empty( $second ) ) : ?>
					<span class="starter-starter-dual-heading__second"><?php echo $second; ?></span>
				<?php endif; ?>
			</<?php echo $tag; ?>>

			<?php if ( $show_subtitle && $sub_pos === 'below' ) : ?>
				<div class="starter-starter-dual-heading__subtitle font-display"><?php echo $sub_text; ?></div>
			<?php endif; ?>

		</div>
		<?php
	}

	/**
	 * Mock Elementor Editor preview (Synchronization Rule)
	 */
	protected function content_template() {
		?>
		<#
		var first = settings.first_text ? settings.first_text : '';
		var second = settings.second_text ? settings.second_text : '';
		var tag = settings.title_tag ? settings.title_tag : 'h2';
		var showSubtitle = settings.show_subtitle === 'yes' && settings.subtitle_text;
		var subPos = settings.subtitle_position;
		
		var wrapClass = 'starter-starter-dual-heading-wrapper';
		if ( showSubtitle ) {
			wrapClass += ' subtitle-' + subPos;
		}
		#>
		<div class="{{ wrapClass }}">
			
			<# if ( showSubtitle && subPos === 'above' ) { #>
				<div class="starter-starter-dual-heading__subtitle font-display">{{{ settings.subtitle_text }}}</div>
			<# } #>

			<{{{ tag }}} class="starter-starter-dual-heading__title font-display m-0">
				<# if ( first ) { #>
					<span class="starter-starter-dual-heading__first">{{{ first }}}</span>
				<# } #>
				
				<# if ( second ) { #>
					<span class="starter-starter-dual-heading__second">{{{ second }}}</span>
				<# } #>
			</{{{ tag }}}>

			<# if ( showSubtitle && subPos === 'below' ) { #>
				<div class="starter-starter-dual-heading__subtitle font-display">{{{ settings.subtitle_text }}}</div>
			<# } #>

		</div>
		<?php
	}
}

add_action( 'wp_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-dual-heading/starter-dual-heading.css';
	wp_register_style(
		'starter-starter-dual-heading',
		STARTER_URL . 'widgets/starter-dual-heading/starter-dual-heading.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );

add_action( 'elementor/editor/after_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-dual-heading/starter-dual-heading.css';
	wp_enqueue_style(
		'starter-starter-dual-heading',
		STARTER_URL . 'widgets/starter-dual-heading/starter-dual-heading.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );
