<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class STARTER_Widget_starter_Feature_Cards extends \Elementor\Widget_Base {

	public function get_name()       { return 'starter-feature-cards'; }
	public function get_title()      { return esc_html__( 'KU Feature Cards', 'starter-elementor-addon' ); }
	public function get_icon()       { return 'eicon-gallery-grid'; }
	public function get_categories() { return [ 'starter-elementor-addon' ]; }
	public function get_keywords()   { return [ 'feature', 'cards', 'benefits', 'trust', 'dental' ]; }

	public function get_style_depends() { return [ 'starter-starter-feature-cards' ]; }

	protected function register_controls() {

		$this->start_controls_section( 'section_layout', [
			'label' => esc_html__( 'Layout', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_responsive_control( 'cards_columns', [
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
				'{{WRAPPER}} .starter-feature-cards__grid' => '--starter-feature-cols: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'cards_gap', [
			'label'      => esc_html__( 'Gap', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [
				'px'  => [ 'min' => 8, 'max' => 48 ],
				'rem' => [ 'min' => 0.5, 'max' => 3 ],
			],
			'default'    => [ 'size' => 20, 'unit' => 'px' ],
			'tablet_default' => [ 'size' => 16, 'unit' => 'px' ],
			'mobile_default' => [ 'size' => 14, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-feature-cards__grid' => '--starter-feature-gap: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_cards', [
			'label' => esc_html__( 'Cards', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$repeater = new \Elementor\Repeater();
		$repeater->add_control( 'selected_icon', [
			'label'            => esc_html__( 'Icon', 'starter-elementor-addon' ),
			'type'             => \Elementor\Controls_Manager::ICONS,
			'fa4compatibility' => 'icon',
			'default'          => [
				'value'   => 'ri-heart-line',
				'library' => 'remixicon',
			],
		] );
		$repeater->add_control( 'icon_class', [
			'label'   => esc_html__( 'Remix Icon Class (Fallback)', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '',
		] );
		$repeater->add_control( 'title', [
			'label'   => esc_html__( 'Title', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'หัวข้อ',
		] );
		$repeater->add_control( 'desc', [
			'label'   => esc_html__( 'Description', 'starter-elementor-addon' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'รายละเอียดการ์ด',
		] );

		$this->add_control( 'cards', [
			'label'       => esc_html__( 'Cards', 'starter-elementor-addon' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'selected_icon' => [ 'value' => 'ri-heart-line', 'library' => 'remixicon' ],
					'title'         => 'ใส่ใจในทุกยิ้ม',
					'desc'          => 'เราให้ความสำคัญกับรอยยิ้มของคุณเป็นอันดับแรก',
				],
				[
					'selected_icon' => [ 'value' => 'ri-shield-check-line', 'library' => 'remixicon' ],
					'title'         => 'มาตรฐานระดับสากล',
					'desc'          => 'ดูแลด้วยเครื่องมือและกระบวนการที่สะอาดปลอดภัย',
				],
				[
					'selected_icon' => [ 'value' => 'ri-user-smile-line', 'library' => 'remixicon' ],
					'title'         => 'ทีมทันตแพทย์มืออาชีพ',
					'desc'          => 'ทันตแพทย์ของเราพร้อมให้คำปรึกษาและดูแลอย่างใกล้ชิด',
				],
				[
					'selected_icon' => [ 'value' => 'ri-emotion-happy-line', 'library' => 'remixicon' ],
					'title'         => 'รอยยิ้มที่มั่นใจ',
					'desc'          => 'ช่วยให้คุณยิ้มได้อย่างมั่นใจในทุกวัน',
				],
			],
			'title_field' => '{{{ title }}}',
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'style_section', [
			'label' => esc_html__( 'Section', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'section_padding', [
			'label'      => esc_html__( 'Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem', '%' ],
			'default'    => [ 'top' => '64', 'right' => '0', 'bottom' => '64', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
			'selectors'  => [ '{{WRAPPER}} .starter-feature-cards' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'section_bg', [
			'label'     => esc_html__( 'Background Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#fff8fb',
			'selectors' => [ '{{WRAPPER}} .starter-feature-cards' => 'background-color: {{VALUE}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'style_card', [
			'label' => esc_html__( 'Card', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'card_bg', [
			'label'     => esc_html__( 'Card Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [ '{{WRAPPER}} .starter-feature-cards__card' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'card_padding', [
			'label'      => esc_html__( 'Card Padding', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'rem' ],
			'default'    => [ 'top' => '28', 'right' => '24', 'bottom' => '28', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
			'selectors'  => [ '{{WRAPPER}} .starter-feature-cards__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_radius', [
			'label'      => esc_html__( 'Border Radius', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'default'    => [ 'size' => 24, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-feature-cards__card' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'card_shadow',
			'label'    => esc_html__( 'Shadow', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-feature-cards__card',
		] );

		$this->add_control( 'card_border_color', [
			'label'     => esc_html__( 'Border Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(244, 114, 182, 0.14)',
			'selectors' => [ '{{WRAPPER}} .starter-feature-cards__card' => 'border-color: {{VALUE}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'style_icon', [
			'label' => esc_html__( 'Icon', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'icon_bg', [
			'label'     => esc_html__( 'Icon Background', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => 'rgba(244, 114, 182, 0.10)',
			'selectors' => [ '{{WRAPPER}} .starter-feature-cards__icon' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'icon_color', [
			'label'     => esc_html__( 'Icon Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ff5a8d',
			'selectors' => [ '{{WRAPPER}} .starter-feature-cards__icon' => 'color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'icon_box_size', [
			'label'      => esc_html__( 'Icon Box Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 40, 'max' => 100 ] ],
			'default'    => [ 'size' => 72, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .starter-feature-cards__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'icon_size', [
			'label'      => esc_html__( 'Icon Size', 'starter-elementor-addon' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 12, 'max' => 48 ] ],
			'default'    => [ 'size' => 30, 'unit' => 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .starter-feature-cards__icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .starter-feature-cards__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
		],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'style_text', [
			'label' => esc_html__( 'Text', 'starter-elementor-addon' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Title Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#111827',
			'selectors' => [ '{{WRAPPER}} .starter-feature-cards__title' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'label'    => esc_html__( 'Title Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-feature-cards__title',
		] );

		$this->add_control( 'desc_color', [
			'label'     => esc_html__( 'Description Color', 'starter-elementor-addon' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#6b7280',
			'selectors' => [ '{{WRAPPER}} .starter-feature-cards__desc' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'desc_typography',
			'label'    => esc_html__( 'Description Typography', 'starter-elementor-addon' ),
			'selector' => '{{WRAPPER}} .starter-feature-cards__desc',
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="starter-feature-cards">
			<div class="starter-feature-cards__ambient starter-feature-cards__ambient--left" aria-hidden="true"></div>
			<div class="starter-feature-cards__ambient starter-feature-cards__ambient--right" aria-hidden="true"></div>
			<div class="s-container mx-auto px-5 md:px-8 lg:px-10 relative z-10">
				<?php if ( ! empty( $settings['cards'] ) ) : ?>
				<div class="starter-feature-cards__grid">
					<?php foreach ( $settings['cards'] as $card ) :
						$title = ! empty( $card['title'] ) ? $card['title'] : '';
						$desc  = ! empty( $card['desc'] ) ? $card['desc'] : '';
					?>
					<article class="starter-feature-cards__card">
						<div class="starter-feature-cards__icon">
							<?php if ( ! empty( $card['selected_icon']['value'] ) ) : ?>
								<?php \Elementor\Icons_Manager::render_icon( $card['selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							<?php elseif ( ! empty( $card['icon_class'] ) ) : ?>
								<i class="<?php echo esc_attr( $card['icon_class'] ); ?>"></i>
							<?php endif; ?>
						</div>

						<?php if ( ! empty( $title ) ) : ?>
						<h3 class="starter-feature-cards__title"><?php echo esc_html( $title ); ?></h3>
						<?php endif; ?>

						<?php if ( ! empty( $desc ) ) : ?>
						<p class="starter-feature-cards__desc"><?php echo esc_html( $desc ); ?></p>
						<?php endif; ?>
					</article>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}

add_action( 'wp_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-feature-cards/starter-feature-cards.css';
	wp_register_style(
		'starter-starter-feature-cards',
		STARTER_URL . 'widgets/starter-feature-cards/starter-feature-cards.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );

add_action( 'elementor/editor/after_enqueue_scripts', function() {
	$css_path = STARTER_PATH . 'widgets/starter-feature-cards/starter-feature-cards.css';
	wp_enqueue_style(
		'starter-starter-feature-cards',
		STARTER_URL . 'widgets/starter-feature-cards/starter-feature-cards.css',
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : STARTER_VERSION
	);
} );
