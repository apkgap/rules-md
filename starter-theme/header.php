<?php



/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package starter_theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php $dark_mode_enabled = (starter_theme_get_option('enable_dark_mode', '0') === '1'); ?>
	<?php
	$header_bg_color        = starter_theme_get_option('header_bg_color', '');
	$header_text_color      = starter_theme_get_option('header_text_color', '');
	$link_color             = starter_theme_get_option('link_color', '');
	$link_hover_color       = starter_theme_get_option('link_hover_color', '');
	$mobile_menu_bg_color   = starter_theme_get_option('mobile_menu_bg_color', '');
	$mobile_menu_text_color = starter_theme_get_option('mobile_menu_text_color', '');
	$mobile_menu_hover_bg   = starter_theme_get_option('mobile_menu_hover_bg', '');
	$mobile_menu_hover_text = starter_theme_get_option('mobile_menu_hover_text', '');
	$mobile_menu_active_bg  = starter_theme_get_option('mobile_menu_active_bg', '');
	$mobile_menu_active_text = starter_theme_get_option('mobile_menu_active_text', '');
	$login_button_bg_color  = starter_theme_get_option('login_button_bg_color', '');
	$login_button_text_color = starter_theme_get_option('login_button_text_color', '');
	$login_button_bg_hover_color = starter_theme_get_option('login_button_bg_hover_color', '');
	$login_button_text_hover_color = starter_theme_get_option('login_button_text_hover_color', '');
	$mobile_toggle_bg_color = starter_theme_get_option('mobile_toggle_bg_color', '');
	$mobile_toggle_text_color = starter_theme_get_option('mobile_toggle_text_color', '');
	$language_switcher_color = starter_theme_get_option('language_switcher_color', '');
	$header_search_bg_color = starter_theme_get_option('header_search_bg_color', '');
	$header_search_color = starter_theme_get_option('header_search_color', '');
	$header_dark_mode_bg_color = starter_theme_get_option('header_dark_mode_bg_color', '');
	$header_dark_mode_color = starter_theme_get_option('header_dark_mode_color', '');
	$header_branch_bg_color = starter_theme_get_option('header_branch_bg_color', '');
	$header_branch_color = starter_theme_get_option('header_branch_color', '');
	$header_branch_border_color = starter_theme_get_option('header_branch_border_color', '');
	$header_branch_active_bg_color = starter_theme_get_option('header_branch_active_bg_color', '');
	$header_branch_active_color = starter_theme_get_option('header_branch_active_color', '');
	$header_branch_phone_bg = starter_theme_get_option('header_branch_phone_bg', '');
	$header_branch_phone_color = starter_theme_get_option('header_branch_phone_color', '');
	$header_dropdown_bg_color = starter_theme_get_option('header_dropdown_bg_color', '');
	$header_dropdown_text_color = starter_theme_get_option('header_dropdown_text_color', '');
	$header_popup_bg_color = starter_theme_get_option('header_popup_bg_color', '');
	$header_popup_text_color = starter_theme_get_option('header_popup_text_color', '');
	$header_scroll_bg_color = starter_theme_get_option('header_scroll_bg_color', '');
	$header_scroll_text_color = starter_theme_get_option('header_scroll_text_color', '');
	?>
	<script>
		// Respect Theme Options setting for dark mode.
		(() => {
			const darkModeEnabled = <?php echo $dark_mode_enabled ? 'true' : 'false'; ?>;
			if (!darkModeEnabled) {
				document.documentElement.classList.remove('dark');
				localStorage.removeItem('theme');
				return;
			}

			if (localStorage.getItem('theme') === 'dark') {
				document.documentElement.classList.add('dark');
			} else {
				document.documentElement.classList.remove('dark');
			}
		})();
	</script>
	<style>
		/* Pre-load background to ensure zero flicker */
		html:not(.dark) {
			background-color: #ffffff;
		}

		html.dark {
			background-color: #000000;
		}

		:root {
			<?php if (!empty($header_bg_color)): ?>--custom-header-bg: <?php echo esc_attr($header_bg_color); ?>;
			<?php endif; ?><?php if (!empty($header_text_color)): ?>--custom-header-text: <?php echo esc_attr($header_text_color); ?>;
			<?php endif; ?><?php if (!empty($link_color)): ?>--custom-link-color: <?php echo esc_attr($link_color); ?>;
			<?php endif; ?><?php if (!empty($link_hover_color)): ?>--custom-link-hover-color: <?php echo esc_attr($link_hover_color); ?>;
			<?php endif; ?><?php if (!empty($mobile_menu_bg_color)): ?>--custom-mobile-menu-bg: <?php echo esc_attr($mobile_menu_bg_color); ?>;
			<?php endif; ?><?php if (!empty($mobile_menu_text_color)): ?>--custom-mobile-menu-text: <?php echo esc_attr($mobile_menu_text_color); ?>;
			<?php endif; ?><?php if (!empty($mobile_menu_hover_bg)): ?>--custom-mobile-menu-hover-bg: <?php echo esc_attr($mobile_menu_hover_bg); ?>;
			<?php endif; ?><?php if (!empty($mobile_menu_hover_text)): ?>--custom-mobile-menu-hover-text: <?php echo esc_attr($mobile_menu_hover_text); ?>;
			<?php endif; ?><?php if (!empty($mobile_menu_active_bg)): ?>--custom-mobile-menu-active-bg: <?php echo esc_attr($mobile_menu_active_bg); ?>;
			<?php endif; ?><?php if (!empty($mobile_menu_active_text)): ?>--custom-mobile-menu-active-text: <?php echo esc_attr($mobile_menu_active_text); ?>;
			<?php endif; ?><?php if (!empty($login_button_bg_color)): ?>--custom-login-button-bg: <?php echo esc_attr($login_button_bg_color); ?>;
			<?php endif; ?><?php if (!empty($login_button_text_color)): ?>--custom-login-button-text: <?php echo esc_attr($login_button_text_color); ?>;
			<?php endif; ?><?php if (!empty($login_button_bg_hover_color)): ?>--custom-login-button-bg-hover: <?php echo esc_attr($login_button_bg_hover_color); ?>;
			<?php endif; ?><?php if (!empty($login_button_text_hover_color)): ?>--custom-login-button-text-hover: <?php echo esc_attr($login_button_text_hover_color); ?>;
			<?php endif; ?><?php if (!empty($mobile_toggle_bg_color)): ?>--custom-mobile-toggle-bg: <?php echo esc_attr($mobile_toggle_bg_color); ?>;
			<?php endif; ?><?php if (!empty($mobile_toggle_text_color)): ?>--custom-mobile-toggle-text: <?php echo esc_attr($mobile_toggle_text_color); ?>;
			<?php endif; ?><?php if (!empty($language_switcher_color)): ?>--custom-lang-color: <?php echo esc_attr($language_switcher_color); ?>;
			<?php endif; ?><?php if (!empty($header_search_bg_color)): ?>--custom-search-bg: <?php echo esc_attr($header_search_bg_color); ?>;
			<?php endif; ?><?php if (!empty($header_search_color)): ?>--custom-search-color: <?php echo esc_attr($header_search_color); ?>;
			<?php endif; ?><?php if (!empty($header_dark_mode_bg_color)): ?>--custom-dark-bg: <?php echo esc_attr($header_dark_mode_bg_color); ?>;
			<?php endif; ?><?php if (!empty($header_dark_mode_color)): ?>--custom-dark-color: <?php echo esc_attr($header_dark_mode_color); ?>;
			<?php endif; ?><?php if (!empty($header_branch_bg_color)): ?>--custom-header-branch-bg: <?php echo esc_attr($header_branch_bg_color); ?>;
			<?php endif; ?><?php if (!empty($header_branch_color)): ?>--custom-header-branch-color: <?php echo esc_attr($header_branch_color); ?>;
			<?php endif; ?><?php if (!empty($header_branch_border_color)): ?>--custom-header-branch-border: <?php echo esc_attr($header_branch_border_color); ?>;
			<?php endif; ?><?php if (!empty($header_branch_active_bg_color)): ?>--custom-header-branch-active-bg: <?php echo esc_attr($header_branch_active_bg_color); ?>;
			<?php endif; ?><?php if (!empty($header_branch_active_color)): ?>--custom-header-branch-active-color: <?php echo esc_attr($header_branch_active_color); ?>;
			<?php endif; ?><?php if (!empty($header_branch_phone_bg)): ?>--custom-header-branch-phone-bg: <?php echo esc_attr($header_branch_phone_bg); ?>;
			<?php endif; ?><?php if (!empty($header_branch_phone_color)): ?>--custom-header-branch-phone-color: <?php echo esc_attr($header_branch_phone_color); ?>;
			<?php endif; ?><?php if (!empty($header_dropdown_bg_color)): ?>--custom-dropdown-bg: <?php echo esc_attr($header_dropdown_bg_color); ?>;
			<?php endif; ?><?php if (!empty($header_dropdown_text_color)): ?>--custom-dropdown-text: <?php echo esc_attr($header_dropdown_text_color); ?>;
			<?php endif; ?><?php if (!empty($header_popup_bg_color)): ?>--custom-popup-bg: <?php echo esc_attr($header_popup_bg_color); ?>;
			<?php endif; ?><?php if (!empty($header_popup_text_color)): ?>--custom-popup-text: <?php echo esc_attr($header_popup_text_color); ?>;
			<?php endif; ?><?php if (!empty($header_scroll_bg_color)): ?>--custom-header-scroll-bg: <?php echo esc_attr($header_scroll_bg_color); ?>;
			<?php endif; ?><?php if (!empty($header_scroll_text_color)): ?>--custom-header-scroll-text: <?php echo esc_attr($header_scroll_text_color); ?>;
			<?php endif; ?>
		}

		/* Scrolled header custom colors */
		header#masthead.is-scrolled,
		#masthead-scrolled {
			background-color: var(--custom-header-scroll-bg, var(--custom-header-bg, var(--bg-base))) !important;
			color: var(--custom-header-scroll-text, var(--custom-header-text, var(--text-base))) !important;
		}

		/* Reusable CTA/Login button overrides that support custom states */
		.header-cta-btn {
			background-color: var(--custom-login-button-bg, var(--color-primary)) !important;
			color: var(--custom-login-button-text, #ffffff) !important;
			transition: all 0.3s ease !important;
		}
		.header-cta-btn:hover {
			background-color: var(--custom-login-button-bg-hover, var(--custom-link-hover-color, #C40072)) !important;
			color: var(--custom-login-button-text-hover, #ffffff) !important;
		}

		/* Reusable toggle/search/dark-mode button overrides */
		.starter-theme-mobile-toggle {
			background-color: var(--custom-mobile-toggle-bg, transparent) !important;
			color: var(--custom-mobile-toggle-text, var(--color-base, inherit)) !important;
		}
		.starter-theme-btn--search {
			background-color: var(--custom-search-bg, transparent) !important;
			color: var(--custom-search-color, var(--color-base, inherit)) !important;
			border-color: var(--custom-search-bg, var(--border-base)) !important;
		}
		.starter-theme-btn--theme {
			background-color: var(--custom-dark-bg, transparent) !important;
			color: var(--custom-dark-color, var(--color-base, inherit)) !important;
			border-color: var(--custom-dark-bg, var(--border-base)) !important;
		}

		/* Custom Dropdown Sub-menu backgrounds and text colors */
		.sub-menu,
		.starter-theme-nav__list .sub-menu,
		.starter-theme-nav .sub-menu {
			background-color: var(--custom-dropdown-bg, var(--bg-base)) !important;
		}
		.sub-menu a,
		.sub-menu li a {
			color: var(--custom-dropdown-text, var(--text-base)) !important;
		}
		.sub-menu a:hover,
		.sub-menu li a:hover {
			color: var(--custom-link-hover-color, var(--custom-dropdown-text, var(--text-base))) !important;
		}
	</style>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<?php
	$header_style       = starter_theme_get_option('header_style', 'default');
	$desktop_menu_style = starter_theme_get_option('desktop_menu_style', 'mega');
	$header_position    = starter_theme_get_option('header_position', 'relative');
	$sticky_disable_on  = starter_theme_get_option('sub_sticky_disable_on', 'none');
	$dark_mode_enabled  = (starter_theme_get_option('enable_dark_mode', '0') === '1');
	$is_home            = is_front_page();
	$menu_walker        = ($desktop_menu_style === 'mega') ? new Header_Menu_Walker() : '';

	$sticky_disable_css = '';
	if ($header_position === 'sticky') {
		$sticky_disable_mode = sanitize_key((string) $sticky_disable_on);

		if ($sticky_disable_mode === 'mobile') {
			$sticky_disable_css = '@media (max-width: 767px) { #masthead { position: static !important; top: auto !important; left: auto !important; right: auto !important; } }';
		} elseif ($sticky_disable_mode === 'tablet') {
			$sticky_disable_css = '@media (min-width: 768px) and (max-width: 1024px) { #masthead { position: static !important; top: auto !important; left: auto !important; right: auto !important; } }';
		} elseif ($sticky_disable_mode === 'mobile_tablet') {
			$sticky_disable_css = '@media (max-width: 1024px) { #masthead { position: static !important; top: auto !important; left: auto !important; right: auto !important; } }';
		}
	}
	?>
	<div id="page" class="site"
		x-data="{
			mobileMenuOpen: false,
			branchesOpen: false,
			searchOpen: false,
			scrolled: false,
			darkModeEnabled: <?php echo $dark_mode_enabled ? 'true' : 'false'; ?>,
			darkMode: document.documentElement.classList.contains('dark'),
			toggleTheme() {
				if (!this.darkModeEnabled) {
					return;
				}
				this.darkMode = !this.darkMode;
				if (this.darkMode) {
					document.documentElement.classList.add('dark');
					localStorage.setItem('theme', 'dark');
				} else {
					document.documentElement.classList.remove('dark');
					localStorage.setItem('theme', 'light');
				}
			}
		}"
		@scroll.window="scrolled = (window.pageYOffset > 50)">
		<?php if (!empty($sticky_disable_css)) : ?>
			<style id="starter-theme-header-sticky-disable"><?php echo $sticky_disable_css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></style>
		<?php endif; ?>
		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'starter-theme'); ?></a>

		<!-- ========================================== -->
		<!-- HEADER (selectable layout via Theme Options) -->
		<!-- ========================================== -->
		<?php
		if ($header_style === 'woodmart') {
			$header_partial = 'header-woodmart';
		} elseif ($header_style === 'simple') {
			$header_partial = 'header-simple';
		} else {
			$header_partial = 'header-default';
		}
		get_template_part('template-parts/' . $header_partial, null, array(
			'desktop_menu_style' => $desktop_menu_style,
			'header_position'    => $header_position,
			'sticky_disable_on'  => $sticky_disable_on,
			'dark_mode_enabled'  => $dark_mode_enabled,
			'is_home'            => $is_home,
			'menu_walker'        => $menu_walker,
		));
		?>

		<?php if ($header_style === 'woodmart') : ?>
			<?php
			get_template_part('template-parts/mobile-menu-woodmart', null, array(
				'dark_mode_enabled' => $dark_mode_enabled,
				'menu_walker' => new Mobile_Menu_Walker(),
			));
			?>
		<?php else : ?>
			<!-- Mobile Menu Drawer (Clean White) -->
			<div x-show="mobileMenuOpen"
				x-data="{ view: 'main', parentId: null }"
				x-init="$watch('mobileMenuOpen', value => { if(!value) view = 'main' })"
				@click.self="mobileMenuOpen = false; view = 'main'"
				x-cloak
				x-transition:enter="transition ease-out duration-300"
				x-transition:enter-start="opacity-0 translate-x-full"
				x-transition:enter-end="opacity-100 translate-x-0"
				x-transition:leave="transition ease-in duration-200"
				x-transition:leave-start="opacity-100 translate-x-0"
				x-transition:leave-end="opacity-0 translate-x-full"
				class="fixed inset-y-0 right-0 w-full max-w-full flex flex-col lg:hidden overflow-hidden shadow-2xl bg-bg-base"
				style="z-index: 99999; border-left: 1px solid var(--border-base); background-color: var(--custom-mobile-menu-bg, var(--bg-base)); color: var(--custom-mobile-menu-text, var(--text-base));"
				id="mobile-menu">

				<!-- Close Button -->
				<button id="mobile-menu-close" @click="mobileMenuOpen = false; view = 'main'"
					class="absolute top-5 right-5 z-20 flex items-center justify-center w-9 h-9 bg-surface-base hover:bg-border-base rounded-xl transition-all duration-200 hover:rotate-90 hover:scale-105 active:scale-95 focus:outline-none border border-border-base text-muted hover:text-base"
					aria-label="Close menu">
					<span class="w-5 h-5 flex items-center justify-center"><i class="ri-close-line"></i></span>
				</button>

				<div id="mobile-menu-content" class="relative z-10 flex flex-col h-full overflow-y-auto">

					<!-- Logo / Brand -->
					<div class="w-full px-5 pt-5 pb-4 border-none flex items-center gap-3">
						<?php if (has_custom_logo()) : ?>
							<div class="[&_.custom-logo]:max-h-5 lg:[&_.custom-logo]:max-h-8 [&_.custom-logo]:w-auto [&_.custom-logo]:object-contain flex items-center">
								<?php the_custom_logo(); ?>
							</div>
						<?php else : ?>
							<span class="text-base font-bold text-base tracking-tight transition-colors duration-500"><?php bloginfo('name'); ?></span>
						<?php endif; ?>
					</div>

					<!-- MIDDLE SECTION: Navigation -->
					<div class="flex-1 px-4 py-5">
						<div class="flex items-center justify-between mb-4 px-2">
							<p class="text-xs font-semibold text-muted uppercase tracking-[0.18em]">Main Menu</p>
							<?php if ($dark_mode_enabled) : ?>
								<button @click="toggleTheme()" class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-surface-base border border-border-base text-xs font-semibold text-base transition-all active:scale-95" aria-label="Toggle Theme">
									<span x-text="darkMode ? 'Dark Mode' : 'Light Mode'"></span>
									<span x-show="!darkMode" class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
									<span x-show="darkMode" class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
								</button>
							<?php endif; ?>
						</div>

						<style>
							#primary-menu-mobile a:hover,
							#primary-menu-mobile button:hover {
								background-color: var(--custom-mobile-menu-hover-bg, var(--starter-surface-primary-subdued)) !important;
								color: var(--custom-mobile-menu-hover-text, var(--starter-text-primary)) !important;
							}
							#primary-menu-mobile a.bg-starter-surface-primary-subdued,
							#primary-menu-mobile a.text-starter-text-primary {
								background-color: var(--custom-mobile-menu-active-bg, var(--starter-surface-primary-subdued)) !important;
								color: var(--custom-mobile-menu-active-text, var(--starter-text-primary)) !important;
							}
						</style>
						<div class="rounded-2xl bg-bg-base border border-border-base p-2 relative min-h-[400px] overflow-hidden transition-colors duration-500">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_id'        => 'primary-menu-mobile',
									'container'      => false,
									'items_wrap'     => '<ul id="%1$s" class="%2$s space-y-0.5 p-0 m-0 list-none">%3$s</ul>',
									'fallback_cb'    => false,
									'walker'         => new Mobile_Menu_Walker(),
								)
							);
							?>
						</div>
					</div>

					<!-- BOTTOM SECTION: Social -->
					<div class="px-4 pb-3">
						<div class="bg-surface-base border border-border-base rounded-2xl p-4">
							<div class="flex items-center justify-center">
								<?php echo do_shortcode('[wbl_socials id="541"]'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<!-- Search Overlay Popup -->
		<div x-show="searchOpen"
			x-cloak
			x-transition:enter="transition ease-out duration-300"
			x-transition:enter-start="opacity-0"
			x-transition:enter-end="opacity-100"
			x-transition:leave="transition ease-in duration-200"
			x-transition:leave-start="opacity-100"
			x-transition:leave-end="opacity-0"
			@keydown.escape.window="searchOpen = false"
			class="fixed inset-0 z-99999 flex items-center justify-center bg-bg-base/96 backdrop-blur-2xl p-6 transition-colors duration-500">

			<!-- Close Button -->
			<button @click="searchOpen = false" class="absolute top-8 right-8 w-12 h-12 flex items-center justify-center rounded-full bg-surface-base border border-border-base/60 text-gray-500 hover:text-white hover:bg-primary shadow-lg transition-all duration-300 active:scale-95 group/close" aria-label="Close search">
				<i class="ri-close-line text-2xl transition-transform duration-300 group-hover/close:rotate-90"></i>
			</button>

			<div class="w-full max-w-3xl transform transition-all"
				x-show="searchOpen"
				x-transition:enter="transition ease-out duration-300 delay-100"
				x-transition:enter-start="opacity-0 scale-95"
				x-transition:enter-end="opacity-100 scale-100">

				<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="relative group">
					<!-- Label -->
					<div class="flex items-center gap-2 mb-4">
						<span class="w-1.5 h-4 bg-primary rounded-full"></span>
						<label class="block text-primary text-xs font-bold uppercase tracking-widest opacity-80"><?php esc_html_e('ค้นหาข้อมูลเว็บไซต์', 'starter-theme'); ?></label>
					</div>

					<!-- Search Input Container -->
					<div class="relative flex items-center bg-surface-base border border-border-base/80 rounded-[2rem] p-2 md:p-3 shadow-xl shadow-black/[0.02] group-focus-within:border-primary/50 group-focus-within:shadow-md group-focus-within:shadow-primary/5 transition-all duration-500">
						<!-- Search Icon Left -->
						<span class="w-12 h-12 md:w-16 md:h-16 flex items-center justify-center text-muted opacity-40 shrink-0">
							<i class="ri-search-line text-xl md:text-2xl"></i>
						</span>

						<!-- Big Input (Explicitly override global input styles) -->
						<input type="text"
							name="s"
							x-ref="searchInput"
							placeholder="<?php echo esc_attr__('พิมพ์คำที่คุณต้องการค้นหา...', 'starter-theme'); ?>"
							class="w-full bg-transparent border-none text-lg md:text-xl font-display font-normal placeholder:text-gray-300 text-gray-900 focus:ring-0 focus:outline-none py-3 md:py-4 pr-16 md:pr-20"
							style="border: none !important; box-shadow: none !important; background-color: transparent !important; outline: none !important;"
							x-init="$watch('searchOpen', value => { if(value) setTimeout(() => $refs.searchInput.focus(), 300) })">

						<!-- Submit Button (Solid Primary color button inside the bar) -->
						<button type="submit" class="absolute right-2 md:right-3 top-1/2 -translate-y-1/2 w-12 h-12 md:w-16 md:h-16 rounded-[1.5rem] bg-primary text-white flex items-center justify-center transition-all duration-300 shadow-md shadow-primary/20 hover:shadow-lg hover:shadow-primary/35 hover:bg-primary/95 active:scale-95 group/btn">
							<i class="ri-arrow-right-line text-lg md:text-xl transition-transform duration-300 group-hover/btn:translate-x-1"></i>
						</button>
					</div>

					<!-- Helper Info -->
					<div class="mt-6 flex flex-wrap items-center justify-between gap-4 text-xs font-medium text-muted/60 pl-6">
						<p><?php esc_html_e('กด Enter เพื่อค้นหา หรือปุ่ม ESC เพื่อปิดหน้าต่างนี้', 'starter-theme'); ?></p>
					</div>

					<!-- Popular Search Terms tags (Chef's Kiss Premium Feature!) -->
					<div class="mt-12 pt-8 border-t border-border-base/50">
						<span class="text-xs font-bold text-muted/80 uppercase tracking-wider block mb-4 flex items-center gap-1.5">
							<i class="ri-fire-line text-orange-500 text-sm"></i>
							<?php echo esc_html__('คำค้นหายอดนิยม:', 'starter-theme'); ?>
						</span>
						<div class="flex flex-wrap gap-2.5">
							<a href="<?php echo esc_url(home_url('/?s=จัดฟัน')); ?>" class="px-4 py-2 bg-surface-base hover:bg-primary/5 border border-border-base hover:border-primary/25 rounded-2xl text-xs font-medium text-gray-700 hover:text-primary transition-all duration-300">จัดฟันแบบใส Invisalign</a>
							<a href="<?php echo esc_url(home_url('/?s=รากฟันเทียม')); ?>" class="px-4 py-2 bg-surface-base hover:bg-primary/5 border border-border-base hover:border-primary/25 rounded-2xl text-xs font-medium text-gray-700 hover:text-primary transition-all duration-300">รากฟันเทียม</a>
							<a href="<?php echo esc_url(home_url('/?s=ฟอกสีฟัน')); ?>" class="px-4 py-2 bg-surface-base hover:bg-primary/5 border border-border-base hover:border-primary/25 rounded-2xl text-xs font-medium text-gray-700 hover:text-primary transition-all duration-300">ฟอกสีฟัน Zoom</a>
							<a href="<?php echo esc_url(home_url('/?s=ทันตแพทย์')); ?>" class="px-4 py-2 bg-surface-base hover:bg-primary/5 border border-border-base hover:border-primary/25 rounded-2xl text-xs font-medium text-gray-700 hover:text-primary transition-all duration-300">ทีมทันตแพทย์</a>
						</div>
					</div>
				</form>
			</div>
		</div>
<?php get_template_part('template-parts/mobile-branches-sheet'); ?>
