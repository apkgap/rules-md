<?php

/**
 * Simple Header Style — Single-row layout.
 * Logo + inline nav + actions on one row; transparent on home when fixed.
 *
 * Expected variables:
 *  - $desktop_menu_style : 'mega' | 'standard' | 'woodmart'
 *  - $header_position    : 'relative' | 'sticky' | 'fixed'
 *  - $is_home            : bool
 *  - $menu_walker        : Walker instance or ''
 *
 * @package starter_theme
 */

if (!defined('ABSPATH')) exit;

// Extract args passed from get_template_part().
if (isset($args) && is_array($args)) {
	$desktop_menu_style = $args['desktop_menu_style'] ?? 'mega';
	$header_position    = $args['header_position']    ?? 'relative';
	$dark_mode_enabled  = $args['dark_mode_enabled']  ?? false;
	$is_home            = $args['is_home']            ?? is_front_page();
	$menu_walker        = $args['menu_walker']        ?? '';
}

$is_woocommerce_active = class_exists('WooCommerce');
$show_login_button = starter_theme_get_option('woodmart_show_login_button', '1') === '1';
$login_url = $is_woocommerce_active ? home_url('/my-account') : wp_login_url();

$is_fixed = ($header_position === 'fixed');
$is_sticky = ($header_position === 'sticky');
$sticky_disable_on = $args['sticky_disable_on'] ?? 'none';

// On home + fixed: transparent header that turns opaque on scroll.
$transparent_home = $is_fixed && $is_home;

$wrapper_classes  = 'w-full transition-all duration-300';
$position_class = function_exists('starter_theme_get_header_position_class')
	? starter_theme_get_header_position_class($header_position, $sticky_disable_on, 'z-40')
	: ($is_fixed ? ' fixed top-0 left-0 right-0 z-40' : ($is_sticky ? ' sticky top-0 z-40' : ' relative z-40'));
$wrapper_classes .= $position_class;

$bg_classes = $transparent_home
	? ''  // transparent by default on home when fixed
	: 'bg-bg-base' . ($is_home ? '' : ' border-b border-border-base');
?>
<header id="masthead"
	:class="scrolled
		? 'is-scrolled <?php echo $transparent_home ? "bg-bg-base shadow-md border-b border-border-base" : ""; ?> max-lg:fixed max-lg:top-0 max-lg:left-0 max-lg:right-0 max-lg:z-50 max-lg:shadow-md'
		: '<?php echo $transparent_home ? "bg-transparent" : ""; ?>'"
	class="<?php echo esc_attr(trim($wrapper_classes . ' ' . $bg_classes)); ?>"
	style="background-color: var(--custom-header-bg, var(--bg-base)); color: var(--custom-header-text, var(--text-base));">

	<div class="container flex items-center justify-between h-18 lg:h-24">

		<!-- Logo -->
		<div class="site-branding shrink-0">
			<?php if (has_custom_logo()) : ?>
				<div class="starter-theme-logo-wrapper [&_.custom-logo]:max-h-10 lg:[&_.custom-logo]:max-h-12 [&_.custom-logo]:w-auto [&_.custom-logo]:object-contain flex items-center">
					<?php the_custom_logo(); ?>
				</div>
			<?php else : ?>
				<a href="<?php echo esc_url(home_url('/')); ?>" class="starter-theme-logo-link flex items-center gap-2 group" rel="home">
					<span
						<?php if ($transparent_home) : ?>
						:class="scrolled ? 'text-base' : 'text-white'"
						<?php else : ?>
						class="text-base"
						<?php endif; ?>
						class="text-2xl font-bold uppercase tracking-tighter leading-none transition-colors duration-300">
						<?php bloginfo('name'); ?>
					</span>
				</a>
			<?php endif; ?>
		</div>

		<!-- Desktop Nav -->
		<nav id="site-navigation" class="starter-theme-nav hidden lg:flex items-center h-full">
			<?php
			$args = array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
				'container'      => false,
				'menu_class'     => 'starter-theme-nav__list flex items-center gap-0 h-full m-0',
				'items_wrap'     => '<ul id="starter-theme-primary-menu" class="%2$s">%3$s</ul>',
				'fallback_cb'    => false,
			);
			if ($menu_walker) $args['walker'] = $menu_walker;
			wp_nav_menu($args);
			?>
		</nav>

		<!-- Actions -->
		<div class="flex items-center gap-2 md:gap-3">
			<div class="hidden lg:flex items-center gap-2">
				<?php get_template_part('template-parts/header-branches'); ?>
			</div>

			<?php if ($dark_mode_enabled) : ?>
			<button @click="toggleTheme()" class="starter-theme-btn--theme w-9 h-9 lg:w-10 lg:h-10 flex items-center justify-center rounded-full bg-surface-base border border-border-base text-base hover:bg-bg-base transition-all active:scale-95" aria-label="Toggle Theme">
				<span x-show="!darkMode" class="w-5 h-5 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
				<span x-show="darkMode" class="w-5 h-5 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
			</button>
			<?php endif; ?>

			<?php if ($show_login_button) : ?>
				<a href="<?php echo esc_url($login_url); ?>" class="header-cta-btn hidden sm:inline-flex items-center h-9 lg:h-10 px-4 lg:px-5 rounded-full bg-primary text-secondary text-sm font-semibold shadow-md">
					<?php echo esc_html__('เข้าสู่ระบบ', 'starter-theme'); ?>
				</a>
			<?php endif; ?>

			<button @click="searchOpen = true" class="starter-theme-btn--search w-9 h-9 lg:w-10 lg:h-10 flex items-center justify-center rounded-full bg-primary text-secondary hover:opacity-80 transition-all shadow-md active:scale-95" style="background-color: var(--custom-search-bg, var(--custom-link-color, var(--primary))); color: var(--custom-search-color, var(--secondary)); border-color: var(--custom-search-bg, var(--primary));">
				<span class="w-5 h-5 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
			</button>

			<!-- Mobile Toggle -->
			<button id="mobile-menu-toggle" @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="lg:hidden starter-theme-mobile-toggle relative w-10 h-10 flex flex-col justify-center items-center gap-1.5 focus:outline-none border-0 bg-transparent p-0 text-base">
				<span class="sr-only">Open main menu</span>
				<span class="starter-theme-mobile-toggle-line block w-6 h-0.5 bg-current"></span>
				<span class="starter-theme-mobile-toggle-line block w-6 h-0.5 bg-current"></span>
				<span class="starter-theme-mobile-toggle-line block w-6 h-0.5 bg-current"></span>
			</button>
		</div>
	</div>
</header>
