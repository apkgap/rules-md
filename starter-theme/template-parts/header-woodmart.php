<?php

/**
 * Woodmart-style Header Layout — Floating pill (Starter style).
 *
 * @package starter_theme
 */

if (!defined('ABSPATH')) {
	exit;
}

if (isset($args) && is_array($args)) {
	$desktop_menu_style = $args['desktop_menu_style'] ?? 'woodmart';
	$header_position    = $args['header_position'] ?? 'relative';
	$dark_mode_enabled  = $args['dark_mode_enabled'] ?? false;
	$is_home            = $args['is_home'] ?? is_front_page();
	$menu_walker        = $args['menu_walker'] ?? '';
}

$is_woocommerce_active = class_exists('WooCommerce');

$sticky_disable_on = $args['sticky_disable_on'] ?? 'none';
$position_class = function_exists('starter_theme_get_header_position_class')
	? starter_theme_get_header_position_class($header_position, $sticky_disable_on, 'z-50')
	: 'sticky top-0 z-50';

// Optional quick-action pill buttons — configurable via Theme Options in the future.
$quick_actions = array(
	array('label' => esc_html__('บริการ', 'starter-theme'), 'url' => '#'),
	array('label' => esc_html__('Easy Pass', 'starter-theme'), 'url' => '#'),
);
$hotline_number = starter_theme_get_option('hotline_number', '1543');
$show_quick_actions = starter_theme_get_option('woodmart_show_quick_actions', '1') === '1';
$show_hotline_button = starter_theme_get_option('woodmart_show_hotline_button', '1') === '1';
$show_search_button = starter_theme_get_option('woodmart_show_search_button', '1') === '1';
$show_cart_button = starter_theme_get_option('woodmart_show_cart_button', '1') === '1';
$show_login_button = starter_theme_get_option('woodmart_show_login_button', '1') === '1';
$login_url      = $is_woocommerce_active ? home_url('/my-account') : wp_login_url();
?>
<header id="masthead"
	:class="scrolled ? 'is-scrolled max-lg:fixed max-lg:top-0 max-lg:left-0 max-lg:right-0 max-lg:z-50 max-lg:shadow-md' : ''"
	class="<?php echo esc_attr($position_class); ?> w-full transition-all duration-300 will-change-transform">
	<div class="s-container py-0 px-[1.5em] md:px-[2em] lg:px-0 transition-all duration-300"
		:class="scrolled ? 'top-3 relative' : 'top-5 relative'">
		<div class="bg-bg-base rounded-full border border-border-base/60 pl-4 pr-4 lg:pl-5 lg:pr-5 flex items-center gap-3 lg:gap-4 transition-all duration-300"
			:class="scrolled ? 'h-14 lg:h-16 shadow-2xl shadow-black/10 backdrop-blur-md bg-bg-base/95' : 'h-16 lg:h-18 shadow-lg'"
			style="background-color: var(--custom-header-bg, var(--bg-base)); color: var(--custom-header-text, var(--text-base));">

			<div class="site-branding flex items-center shrink-0 gap-2">
				<?php if (has_custom_logo()) : ?>
					<div class="starter-theme-logo-wrapper [&_.custom-logo]:max-h-9 lg:[&_.custom-logo]:max-h-11 [&_.custom-logo]:w-auto [&_.custom-logo]:object-contain flex items-center">
						<?php the_custom_logo(); ?>
					</div>
				<?php else : ?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2" rel="home">
						<span class="text-base lg:text-lg font-semibold text-base leading-none tracking-tight">
							<?php bloginfo('name'); ?>
						</span>
					</a>
				<?php endif; ?>

				<?php
				$toggle_bg    = starter_theme_get_option('mobile_toggle_bg_color', 'transparent');
				$toggle_color = starter_theme_get_option('mobile_toggle_text_color', 'var(--custom-link-color, var(--primary))');

				$search_bg    = starter_theme_get_option('header_search_bg_color', 'transparent');
				$search_color = starter_theme_get_option('header_search_color', 'var(--custom-link-color, var(--primary))');

				$dark_bg      = starter_theme_get_option('header_dark_mode_bg_color', 'transparent');
				$dark_color   = starter_theme_get_option('header_dark_mode_color', 'var(--custom-link-color, var(--primary))');

				$cart_bg      = starter_theme_get_option('header_cart_bg_color', 'transparent');
				$cart_color   = starter_theme_get_option('header_cart_color', 'var(--custom-link-color, var(--primary))');
				?>
				<!-- Desktop Menu Toggle (next to logo) -->
				<button id="desktop-menu-toggle" @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="hidden lg:flex items-center gap-2 px-3 h-10 rounded-full text-base hover:bg-surface-base transition-colors" style="background-color: <?php echo esc_attr($toggle_bg); ?>; color: <?php echo esc_attr($toggle_color); ?>;" aria-label="Open menu">
					<span class="w-5 h-5 flex items-center justify-center">
						<i class="ri-arrow-right-line"></i>
					</span>
					<span class="text-sm font-medium"><?php echo esc_html__('เมนูหลัก', 'starter-theme'); ?></span>
				</button>
			</div>

			<div class="flex-1"></div>

			<?php if ($show_quick_actions) : ?>
				<div class="hidden lg:flex items-center gap-2">
					<?php foreach ($quick_actions as $action) : ?>
						<a href="<?php echo esc_url($action['url']); ?>" id="quick-action-btn" class="inline-flex items-center h-10 px-4 rounded-full border border-primary/40 text-primary text-sm font-medium transition-colors" style="border-color: var(--custom-link-color, var(--primary)); color: var(--custom-link-color, var(--primary));" onmouseover="this.style.color=var(--custom-link-hover-color, '#005177'); this.style.borderColor=var(--custom-link-hover-color, '#005177');" onmouseout="this.style.color=var(--custom-link-color, var(--primary)); this.style.borderColor=var(--custom-link-color, var(--primary));">
							<?php echo esc_html($action['label']); ?>
						</a>
					<?php endforeach; ?>
					<?php if ($show_hotline_button && !empty($hotline_number)) : ?>
						<a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $hotline_number)); ?>" class="inline-flex items-center gap-2 h-10 px-4 rounded-full border border-primary/40 text-primary text-sm font-medium transition-colors" style="border-color: var(--custom-link-color, var(--primary)); color: var(--custom-link-color, var(--primary));" onmouseover="this.style.color=var(--custom-link-hover-color, '#005177'); this.style.borderColor=var(--custom-link-hover-color, '#005177');" onmouseout="this.style.color=var(--custom-link-color, var(--primary)); this.style.borderColor=var(--custom-link-color, var(--primary));">
							<span class="w-3 h-3 flex items-center justify-center">
								<i class="ri-arrow-right-line"></i>
							</span>
							<span><?php echo esc_html($hotline_number); ?></span>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="hidden lg:flex items-center gap-2">
				<?php get_template_part('template-parts/header-branches'); ?>
			</div>

			<div class="flex items-center gap-1 lg:gap-2">
				<?php if (function_exists('starter_theme_language_switcher')) : ?>
					<div id="language-btn" class="hidden md:block">
						<?php starter_theme_language_switcher(); ?>
					</div>
				<?php endif; ?>

				<?php if ($show_search_button) : ?>
					<button id="search-btn" @click="searchOpen = true" class="w-10 h-10 flex items-center justify-center rounded-full text-base hover:bg-surface-base transition-colors" style="background-color: <?php echo esc_attr($search_bg); ?>; color: <?php echo esc_attr($search_color); ?>;" aria-label="Search">
						<span class="w-5 h-5 flex items-center justify-center">
							<i class="ri-arrow-right-line"></i>
						</span>
					</button>
				<?php endif; ?>

				<?php if ($dark_mode_enabled) : ?>
					<button @click="toggleTheme()" class="w-10 h-10 flex items-center justify-center rounded-full text-base hover:bg-surface-base transition-colors" style="background-color: <?php echo esc_attr($dark_bg); ?>; color: <?php echo esc_attr($dark_color); ?>;" aria-label="Toggle Theme">
						<span x-show="!darkMode" class="w-5 h-5 flex items-center justify-center">
							<i class="ri-arrow-right-line"></i>
						</span>
						<span x-show="darkMode" class="w-5 h-5 flex items-center justify-center">
							<i class="ri-arrow-right-line"></i>
						</span>
					</button>
				<?php endif; ?>

				<?php if ($show_login_button) : ?>
					<a href="<?php echo esc_url($login_url); ?>" id="login-btn" class="header-cta-btn hidden sm:inline-flex items-center h-10 px-4 lg:px-5 rounded-full bg-primary text-secondary text-sm font-light transition-opacity shadow-md">
						<?php echo esc_html__('เข้าสู่ระบบ', 'starter-theme'); ?>
					</a>
				<?php endif; ?>

				<?php if ($is_woocommerce_active && $show_cart_button) : ?>
					<a href="<?php echo esc_url(home_url('/cart')); ?>" class="hidden lg:inline-flex w-10 h-10 items-center justify-center rounded-full text-base hover:bg-surface-base transition-colors" style="background-color: <?php echo esc_attr($cart_bg); ?>; color: <?php echo esc_attr($cart_color); ?>;" aria-label="Cart">
						<span class="w-5 h-5 flex items-center justify-center">
							<i class="ri-arrow-right-line"></i>
						</span>
					</a>
				<?php endif; ?>

				<button id="mobile-menu-toggle" @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="flex sm:hidden items-center gap-2 px-3 h-10 rounded-full text-base hover:bg-surface-base transition-colors" style="background-color: <?php echo esc_attr($toggle_bg); ?>; color: <?php echo esc_attr($toggle_color); ?>;" aria-label="Open menu">
					<span class="w-5 h-5 flex items-center justify-center">
						<i class="ri-arrow-right-line"></i>
					</span>
				</button>
			</div>
		</div>
	</div>
</header>