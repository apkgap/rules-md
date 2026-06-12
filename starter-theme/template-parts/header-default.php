<?php

/**
 * Default Header Style — Multi-row layout with separate scrolled variant.
 *
 * Expected variables (set in header.php):
 *  - $desktop_menu_style : 'mega' | 'standard'
 *  - $header_position    : 'relative' | 'sticky' | 'fixed'
 *  - $is_home            : bool
 *  - $menu_walker        : Walker instance or '' (standard)
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
$sticky_disable_on = $args['sticky_disable_on'] ?? 'none';
$position_class = function_exists('starter_theme_get_header_position_class')
	? starter_theme_get_header_position_class($header_position, $sticky_disable_on, 'z-40')
	: 'relative z-40';
?>
<header id="masthead" class="<?php echo esc_attr($position_class); ?> w-full transition-colors duration-300 <?php echo $is_home ? 'bg-bg-base' : 'bg-bg-base border-b border-border-base'; ?>"
	:class="scrolled ? 'is-scrolled max-lg:fixed max-lg:top-0 max-lg:left-0 max-lg:right-0 max-lg:z-50 max-lg:shadow-md lg:opacity-0 lg:pointer-events-none' : ''"
	style="background-color: var(--custom-header-bg, var(--bg-base)); color: var(--custom-header-text, var(--text-base));">
	<div class="Starterbox-container px-[1.5em] md:px-[2em] lg:px-[5em" id="starter-theme-header-container">

		<!-- MOBILE & TABLET HEADER -->
		<div id="starter-theme-mobile-header" class="starter-theme-header__mobile flex lg:hidden items-center justify-between h-18">
			<div class="site-branding shrink-0 starter-theme-header__logo-mobile flex gap-[10px]">
				<?php if (has_custom_logo()) : ?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2 group" rel="home">
						<div class="starter-theme-logo-wrapper [&_.custom-logo]:max-h-10 [&_.custom-logo]:w-auto [&_.custom-logo]:object-contain flex items-center">
							<?php the_custom_logo(); ?>
						</div>
						<div class="leading-tight hidden">
							<p class="text-sm font-extrabold uppercase tracking-wider text-base-content group-hover:text-primary transition-colors duration-300 leading-none"><?php bloginfo('name'); ?></p>
							<?php if ( get_bloginfo('description') ) : ?>
								<p class="text-[9px] font-semibold uppercase tracking-[0.15em] text-base-content/50 transition-colors duration-300 mt-0.5"><?php bloginfo('description'); ?></p>
							<?php endif; ?>
						</div>
					</a>
				<?php else : ?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="starter-theme-logo-link flex items-center gap-2 group" rel="home">
						<span class="text-base-content starter-theme-logo-text text-xl font-bold uppercase tracking-tighter leading-none transition-colors duration-500">
							<?php bloginfo('name'); ?>
						</span>
					</a>
				<?php endif; ?>
			</div>
			<div class="flex items-center gap-2 md:gap-2.5 ml-auto mr-3">
				<div class="[&_.wbl-social-icon-wrapper]:!w-7 [&_.wbl-social-icon-wrapper]:!h-7 [&_.wbl-social-icon-wrapper_svg]:!w-4 [&_.wbl-social-icon-wrapper_svg]:!h-4 [&_.wbl-social-list]:!gap-1.5 flex items-center">
					<?php echo do_shortcode('[wbl_socials id="541"]'); ?>
				</div>
				<button @click="branchesOpen = true"
					class="group inline-flex items-center justify-center gap-1 w-7 h-7 p-1 text-xs font-light rounded-full border border-primary bg-primary text-white transition-all duration-200 hover:bg-primary hover:border-primary active:scale-95"
					aria-label="Our Branches">
					<i class="ri-phone-line text-white text-lg font-light"></i>
					<span class="hidden xs:inline"><?php echo esc_html__('สาขา', 'starter-theme'); ?></span>
				</button>
				<?php if ($dark_mode_enabled) : ?>
				<button @click="toggleTheme()" class="starter-theme-btn--theme w-7 h-7 p-1.5 flex items-center justify-center rounded-full bg-surface-base border border-border-base text-base hover:bg-bg-base transition-all active:scale-95" aria-label="Toggle Theme">
					<span x-show="!darkMode" class="w-5 h-5 flex items-center justify-center"><i class="ri-arrow-right-line text-base"></i></span>
					<span x-show="darkMode" class="w-5 h-5 flex items-center justify-center"><i class="ri-arrow-right-line text-base"></i></span>
				</button>
				<?php endif; ?>
				<button @click="searchOpen = true" class="starter-theme-btn--search w-7 h-7 p-1.5 flex items-center justify-center rounded-full bg-primary text-secondary transition-all active:scale-95" style="background-color: var(--custom-search-bg, var(--custom-link-color, var(--primary))); color: var(--custom-search-color, var(--secondary)); border-color: var(--custom-search-bg, var(--primary));">
										<span class="w-5 h-5 flex items-center justify-center">
											<i class="ri-search-line text-base"></i>
										</span>
				</button>
			</div>
			<button id="mobile-menu-toggle" @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="starter-theme-mobile-toggle relative w-10 h-10 flex flex-col justify-center items-center gap-1.5 focus:outline-none border-0 p-0 text-base" style="background-color: var(--custom-mobile-toggle-bg, transparent);">
				<span class="sr-only">Open main menu</span>
				<span class="starter-theme-mobile-toggle-line block w-6 h-0.5 bg-current"></span>
				<span class="starter-theme-mobile-toggle-line block w-6 h-0.5 bg-current"></span>
				<span class="starter-theme-mobile-toggle-line block w-6 h-0.5 bg-current"></span>
			</button>
		</div>

		<!-- DESKTOP HEADER — Single Row (Logo | Nav | CTA) -->
		<div id="starter-theme-desktop-header"
			class="starter-theme-header__desktop hidden lg:flex items-center justify-between h-[72px] w-full relative z-10">

			<!-- Logo Left -->
			<div id="starter-theme-logo-desktop" class="site-branding starter-theme-header__logo shrink-0 flex gap-[12px]">
				<?php if (has_custom_logo()) : ?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-3 group" rel="home">
						<div class="starter-theme-logo-wrapper [&_.custom-logo]:max-h-16 [&_.custom-logo]:w-auto [&_.custom-logo]:object-contain flex items-center">
							<?php the_custom_logo(); ?>
						</div>
						<div class="leading-tight">
							<p class="text-base font-extrabold uppercase tracking-wider text-base-content group-hover:text-primary transition-colors duration-300 leading-none"><?php bloginfo('name'); ?></p>
							<?php if ( get_bloginfo('description') ) : ?>
								<p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-base-content/50 transition-colors duration-300 mt-1"><?php bloginfo('description'); ?></p>
							<?php endif; ?>
						</div>
					</a>
				<?php else : ?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="starter-theme-logo-link flex items-center gap-2.5 group" rel="home">
						<span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary text-white shadow-md">
							<svg viewBox="0 0 64 64" class="h-6 w-6" aria-hidden="true" focusable="false">
								<path d="M21.5 7.5c-6.6 0-12 5.6-12 12.5 0 4.8 1.7 8.2 3.4 11.8 1.6 3.4 3.3 7.1 3.8 12.7.6 6.4 2.6 12 6.1 12 2.3 0 3.4-4.3 4.5-8.6 1.1-4.5 2.1-8.3 4.7-8.3s3.6 3.8 4.7 8.3c1.1 4.3 2.2 8.6 4.5 8.6 3.5 0 5.5-5.6 6.1-12 .5-5.6 2.2-9.3 3.8-12.7 1.7-3.6 3.4-7 3.4-11.8 0-6.9-5.4-12.5-12-12.5-3.3 0-6 1.1-8.4 2.6-1.4.9-2.8 1.3-4.1 1.3s-2.7-.4-4.1-1.3c-2.4-1.5-5.1-2.6-8.4-2.6Z" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</span>
						<div class="leading-tight">
							<p class="text-sm font-extrabold uppercase tracking-wider text-base transition-colors duration-300 leading-none"><?php bloginfo('name'); ?></p>
							<p class="text-[9px] font-semibold uppercase tracking-[0.25em] text-base/50 transition-colors duration-300 mt-0.5">Dental Clinic</p>
						</div>
					</a>
				<?php endif; ?>
			</div>

			<!-- Nav Center -->
			<nav id="site-navigation" class="starter-theme-nav flex items-center flex-1 justify-center">
				<?php
				$args = array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'menu_class'     => 'starter-theme-nav__list flex items-center gap-1 h-full m-0',
					'items_wrap'     => '<ul class="%2$s" id="starter-theme-primary-menu">%3$s</ul>',
					'fallback_cb'    => false,
				);
				if ($menu_walker) $args['walker'] = $menu_walker;
				wp_nav_menu($args);
				?>
			</nav>

			<!-- Actions Right -->
			<div class="starter-theme-header__actions flex items-center gap-2 shrink-0">

				<?php if ($dark_mode_enabled) : ?>
				<button @click="toggleTheme()" class="starter-theme-btn--theme w-8 h-8 rounded-full bg-surface-base border border-border-base flex items-center justify-center text-base hover:bg-bg-base transition-all active:scale-95" aria-label="Toggle Theme">
					<span x-show="!darkMode" class="w-4 h-4 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
					<span x-show="darkMode" class="w-4 h-4 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
				</button>
				<?php endif; ?>

				<button @click="searchOpen = true" id="starter-theme-btn-search" class="starter-theme-btn starter-theme-btn--search w-8 h-8 rounded-full border border-border-base flex items-center justify-center text-base bg-white hover:bg-primary hover:text-white hover:border-primary transition-all active:scale-95">
					<span class="w-4 h-4 flex items-center justify-center"><i class="ri-search-line"></i></span>
				</button>
				<?php get_template_part('template-parts/header-branches'); ?>
				<?php
				$cta_text = starter_theme_get_option('starter_footer_cta_text', 'นัดหมายแพทย์');
				$cta_url  = starter_theme_get_option('starter_footer_cta_url', '#contact');
				?>
				<a href="<?php echo esc_url($cta_url ?: '#contact'); ?>"
					class="header-cta-btn inline-flex items-center gap-2 bg-primary text-white text-sm font-light px-4 py-2 rounded-full shadow-md hover:shadow-lg transition-all duration-300 active:scale-95">
					<i class="ri-calendar-line ri-1x"></i>
					<?php echo esc_html(starter_theme_get_option('header_cta_text', 'นัดหมายแพทย์')); ?>
				</a>
			</div>
		</div>
	</div>
</header>

<!-- SCROLLED FIXED HEADER — Single Row: Logo | Nav | Actions -->
<div id="masthead-scrolled"
	x-show="scrolled" x-cloak
	x-transition:enter="transition ease-out duration-300"
	x-transition:enter-start="opacity-0 -translate-y-2"
	x-transition:enter-end="opacity-100 translate-y-0"
	x-transition:leave="transition ease-in duration-200"
	x-transition:leave-start="opacity-100 translate-y-0"
	x-transition:leave-end="opacity-0 -translate-y-2"
	class="fixed top-0 left-0 right-0 z-50 w-full bg-bg-base/90 backdrop-blur-md border-b border-border-base shadow-sm hidden lg:block"
	style="background-color: var(--custom-header-bg, var(--bg-base)); color: var(--custom-header-text, var(--text-base));">
	<div class="Starterbox-container px-[1.5em] md:px-[2em] lg:px-[5em">
		<div class="w-full flex items-center justify-between h-[64px] gap-6">

			<!-- Logo -->
			<div class="site-branding shrink-0 flex gap-[12px] items-center">
				<?php if (has_custom_logo()) : ?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2.5 group" rel="home">
						<div class="starter-theme-logo-wrapper [&_.custom-logo]:max-h-12 [&_.custom-logo]:w-auto [&_.custom-logo]:object-contain flex items-center">
							<?php the_custom_logo(); ?>
						</div>
						<div class="leading-tight">
							<p class="text-sm font-extrabold uppercase tracking-wider text-base-content group-hover:text-primary transition-colors duration-300 leading-none"><?php bloginfo('name'); ?></p>
							<?php if ( get_bloginfo('description') ) : ?>
								<p class="text-[9px] font-semibold uppercase tracking-[0.15em] text-base-content/50 transition-colors duration-300 mt-0.5"><?php bloginfo('description'); ?></p>
							<?php endif; ?>
						</div>
					</a>
				<?php else : ?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="starter-theme-logo-link flex items-center gap-2.5" rel="home">
						<span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary text-white shadow-md">
							<svg viewBox="0 0 64 64" class="h-5 w-5" aria-hidden="true" focusable="false">
								<path d="M21.5 7.5c-6.6 0-12 5.6-12 12.5 0 4.8 1.7 8.2 3.4 11.8 1.6 3.4 3.3 7.1 3.8 12.7.6 6.4 2.6 12 6.1 12 2.3 0 3.4-4.3 4.5-8.6 1.1-4.5 2.1-8.3 4.7-8.3s3.6 3.8 4.7 8.3c1.1 4.3 2.2 8.6 4.5 8.6 3.5 0 5.5-5.6 6.1-12 .5-5.6 2.2-9.3 3.8-12.7 1.7-3.6 3.4-7 3.4-11.8 0-6.9-5.4-12.5-12-12.5-3.3 0-6 1.1-8.4 2.6-1.4.9-2.8 1.3-4.1 1.3s-2.7-.4-4.1-1.3c-2.4-1.5-5.1-2.6-8.4-2.6Z" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</span>
						<div class="leading-tight">
							<p class="text-sm font-extrabold uppercase tracking-wider text-base leading-none"><?php bloginfo('name'); ?></p>
							<p class="text-[9px] font-semibold uppercase tracking-[0.25em] text-base/50 mt-0.5">Dental Clinic</p>
						</div>
					</a>
				<?php endif; ?>
			</div>

			<!-- Nav Center -->
			<nav id="site-navigation-scrolled" class="starter-theme-nav flex items-center flex-1 justify-center h-full">
				<?php
				$args = array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu-scrolled',
					'container'      => false,
					'menu_class'     => 'starter-theme-nav__list flex items-center gap-1 h-full m-0',
					'items_wrap'     => '<ul class="%2$s" id="starter-theme-primary-menu-scrolled">%3$s</ul>',
					'fallback_cb'    => false,
				);
				if ($menu_walker) $args['walker'] = $menu_walker;
				wp_nav_menu($args);
				?>
			</nav>

			<!-- Actions Right -->
			<div class="flex items-center gap-2.5 shrink-0">

				<?php if ($dark_mode_enabled) : ?>
				<button @click="toggleTheme()" class="starter-theme-btn--theme w-8 h-8 rounded-full bg-surface-base border border-border-base flex items-center justify-center text-base hover:bg-bg-base transition-all" aria-label="Toggle Theme">
					<span x-show="!darkMode" class="w-4 h-4 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
					<span x-show="darkMode" class="w-4 h-4 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
				</button>
				<?php endif; ?>
				<button @click="searchOpen = true" class="starter-theme-btn--search w-8 h-8 rounded-full bg-surface-base border border-border-base flex items-center justify-center text-base hover:bg-primary hover:text-white hover:border-primary transition-all">
					<span class="w-4 h-4 flex items-center justify-center"><i class="ri-search-line"></i></span>
				</button>
				<?php get_template_part('template-parts/header-branches'); ?>

				<a href="<?php echo esc_url(starter_theme_get_option('starter_footer_cta_url', '#contact') ?: '#contact'); ?>"
					class="header-cta-btn inline-flex items-center gap-1.5 bg-primary text-white text-sm font-light px-4 py-2 rounded-full transition-all active:scale-95">
					<i class="ri-calendar-line ri-1x"></i>
					<?php echo esc_html(starter_theme_get_option('header_cta_text', 'นัดหมายแพทย์')); ?>
				</a>
			</div>
		</div>
	</div>
</div>
