<?php

/**
 * Woodmart-style Mobile Menu Drawer.
 *
 * @package starter_theme
 */

if (!defined('ABSPATH')) {
	exit;
}

$menu_walker = null;
if (isset($args) && is_array($args) && isset($args['menu_walker'])) {
	$menu_walker = $args['menu_walker'];
}

$my_account_url = home_url('/my-account');
$is_woocommerce_active = class_exists('WooCommerce');
$show_login_button = starter_theme_get_option('woodmart_show_login_button', '1') === '1';
$login_url      = $is_woocommerce_active ? home_url('/my-account') : wp_login_url();

$phone_header = starter_theme_get_option('contact_phone', '');
$email_header = starter_theme_get_option('contact_email', '');
?>
<div id="mobileMenuWrapper" x-cloak>
	<div x-show="mobileMenuOpen" x-transition.opacity.duration.50ms class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[9998]" @click="mobileMenuOpen = false"></div>

	<aside x-show="mobileMenuOpen"
		x-data="{ view: 'main' }"
		class="fixed top-[20px] left-[14px] right-[14px] md:left-[24px] md:right-auto md:w-[420px] h-[calc(100vh-40px)] bg-bg-base z-[9999] rounded-xl shadow-2xl overflow-hidden"
		role="dialog" aria-modal="true" aria-label="Navigation menu"
		style="background-color: var(--custom-mobile-menu-bg, var(--bg-base)); color: var(--custom-mobile-menu-text, var(--text-base));">
		<div class="relative flex items-center gap-4 px-6 pt-6 pb-4 border-b border-border-base">
			<button @click="mobileMenuOpen = false" class="w-10 h-10 rounded-sm bg-surface-base border border-border-base flex items-center justify-center text-base" aria-label="Close menu">
				<span class="w-6 h-6 flex items-center justify-center">
					<i class="ri-arrow-right-line"></i>
				</span>
			</button>
			<div class="site-branding flex items-center min-h-[32px]">
				<?php if (has_custom_logo()) : ?>
					<div class="starter-theme-logo-wrapper [&_.custom-logo]:max-h-8 [&_.custom-logo]:w-auto [&_.custom-logo]:object-contain flex items-center">
						<?php the_custom_logo(); ?>
					</div>
				<?php else : ?>
					<span class="text-lg font-semibold text-base"><?php bloginfo('name'); ?></span>
				<?php endif; ?>
			</div>
		</div>

		<div class="h-[calc(100%-80px)] overflow-y-auto px-6 py-5">
			<nav class="relative z-10">
				<?php
				$menu_args = array(
					'theme_location' => 'menu-1',
					'menu_class'     => 'space-y-0.5 relative min-h-[280px] m-0 bg-bg-base border border-border-base rounded-2xl p-2 z-20 transition-colors duration-500',
					'container'      => false,
					'fallback_cb'    => false,
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				);
				if ($menu_walker instanceof Walker_Nav_Menu) {
					$menu_args['walker'] = $menu_walker;
				}
				wp_nav_menu($menu_args);
				?>
			</nav>

			<?php if ($is_woocommerce_active) : ?>
				<section class="mt-8 border-t border-border-base pt-6">
					<h3 class="text-xs uppercase tracking-widest text-base/70 mb-4"><?php echo esc_html__('บัญชีของฉัน', 'starter-theme'); ?></h3>
					<article class="rounded-2xl bg-surface-base border border-border-base p-4">
						<div class="flex items-start gap-3 mb-4">
							<div class="w-10 h-10 rounded-full bg-bg-base flex items-center justify-center text-base">
								<span class="w-5 h-5 flex items-center justify-center">
									<i class="ri-arrow-right-line"></i>
								</span>
							</div>
							<div>
								<h4 class="text-sm font-medium text-base"><?php echo esc_html__('บัญชีของคุณ', 'starter-theme'); ?></h4>
								<p class="text-xs text-base/60"><?php echo esc_html__('เข้าสู่ระบบเพื่อสิทธิพิเศษ', 'starter-theme'); ?></p>
							</div>
						</div>
						<div class="flex flex-col gap-2">
							<?php if ($show_login_button) : ?>
								<a href="<?php echo esc_url($login_url); ?>" class="header-cta-btn inline-flex items-center h-10 px-4 rounded-full bg-primary text-secondary text-sm font-semibold shadow-md">
									<?php echo esc_html__('เข้าสู่ระบบ', 'starter-theme'); ?>
								</a>
							<?php endif; ?>
							<a href="<?php echo esc_url($my_account_url); ?>" class="w-full text-center px-3 py-2 rounded-lg border border-border-base text-base text-sm font-medium hover:bg-surface-base transition"><?php echo esc_html__('สมัครสมาชิก', 'starter-theme'); ?></a>
						</div>
					</article>
				</section>
			<?php endif; ?>


		</div>
	</aside>
</div>