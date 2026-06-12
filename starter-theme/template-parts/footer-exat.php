<?php

/**
 * Starter Footer Bar
 *
 * Minimal dark-navy footer with:
 *   - Horizontal navigation links (left)
 *   - Optional pill CTA button (right)
 *   - Copyright row (bottom)
 *
 * Options managed via Theme Options → Starter Footer (React admin).
 *
 * @package starter_theme
 */

if (! defined('ABSPATH')) {
	exit;
}

$brand_title     = starter_theme_get_option('starter_footer_brand_title', 'SMILE CARE');
$brand_subtitle  = starter_theme_get_option('starter_footer_brand_subtitle', 'Dental Clinic');
$footer_logo     = starter_theme_get_option('starter_footer_logo', '');
$address_title   = starter_theme_get_option('starter_footer_address_title', 'คลินิกทันตกรรมครบวงจร');
$address_lines   = starter_theme_get_option('starter_footer_address_lines', "คลินิกทันตกรรมครบวงจร\nเพื่อสุขภาพช่องปากที่ดีของคุณ\nด้วยมาตรฐานการรักษาและ\nการบริการที่คุณไว้วางใจ");
$map_label       = starter_theme_get_option('starter_footer_map_label', 'แผนที่คลินิก');
$map_url         = starter_theme_get_option('starter_footer_map_url', '#');
$contact_title   = starter_theme_get_option('starter_footer_contact_title', 'ติดต่อเรา');
$hotline         = starter_theme_get_option('starter_footer_hotline', '091-234-5678');
$email           = starter_theme_get_option('starter_footer_email', 'smilecare.dental@gmail.com');
$phone           = starter_theme_get_option('starter_footer_phone', '02-123-4567');
$fax             = starter_theme_get_option('starter_footer_fax', "จันทร์ - เสาร์ 10.00 - 20.00 น.\nอาทิตย์ 10.00 - 18.00 น.");
$social_title    = starter_theme_get_option('starter_footer_social_title', 'ติดตามข่าวสาร');
$facebook_label  = starter_theme_get_option('starter_footer_facebook_label', 'Facebook');
$facebook_url    = starter_theme_get_option('starter_footer_facebook_url', '#');
$x_label         = starter_theme_get_option('starter_footer_x_label', 'LINE');
$x_url           = starter_theme_get_option('starter_footer_x_url', '#');
$youtube_label   = starter_theme_get_option('starter_footer_youtube_label', 'Instagram');
$youtube_url     = starter_theme_get_option('starter_footer_youtube_url', '#');
$nav_menu_id    = intval(starter_theme_get_option('starter_footer_nav_menu', 0));
$cta_enabled    = starter_theme_get_option('starter_footer_cta_enabled', '1');
$cta_text       = starter_theme_get_option('starter_footer_cta_text', 'สมัครรับข่าวสาร →');
$cta_url        = starter_theme_get_option('starter_footer_cta_url', '#');
$cta_external   = starter_theme_get_option('starter_footer_cta_external', '0');
$copyright_raw  = starter_theme_get_option(
	'starter_footer_copyright',
	'&copy; 2024 Smile Care Dental Clinic. All Rights Reserved.'
);
$copyright = str_replace('{year}', (string) ((int) date('Y') + 543), $copyright_raw);
$phone_href = preg_replace('/[^0-9+]/', '', $phone);
$fax_href   = preg_replace('/[^0-9+]/', '', $fax);
?>
<footer id="starter-footer" class="starter-footer bg-primary text-white" role="contentinfo">
	<div id="starter-footer-inner" class="starter-footer__inner s-container mx-auto w-full px-5 py-8 md:px-8 md:py-10 lg:px-10">
		<div id="starter-footer-columns" class="starter-footer__columns grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-[1.15fr_1fr_0.8fr_1.45fr] lg:gap-12">
			<section id="starter-footer-brand" class="starter-footer__section starter-footer__section--brand min-w-0" aria-labelledby="starter-footer-brand-title">
				<div id="starter-footer-logo" class="starter-footer__logo mb-4 flex items-center gap-3">
					<?php if (! empty($footer_logo)) : ?>
						<img src="<?php echo esc_url($footer_logo); ?>" alt="<?php echo esc_attr($brand_title); ?>" class="h-14 w-auto object-contain">
					<?php else : ?>
					<span class="starter-footer__logo-mark inline-flex h-14 w-14 shrink-0 items-center justify-center text-white">
						<svg viewBox="0 0 64 64" class="h-full w-full" aria-hidden="true" focusable="false">
							<path d="M21.5 7.5c-6.6 0-12 5.6-12 12.5 0 4.8 1.7 8.2 3.4 11.8 1.6 3.4 3.3 7.1 3.8 12.7.6 6.4 2.6 12 6.1 12 2.3 0 3.4-4.3 4.5-8.6 1.1-4.5 2.1-8.3 4.7-8.3s3.6 3.8 4.7 8.3c1.1 4.3 2.2 8.6 4.5 8.6 3.5 0 5.5-5.6 6.1-12 .5-5.6 2.2-9.3 3.8-12.7 1.7-3.6 3.4-7 3.4-11.8 0-6.9-5.4-12.5-12-12.5-3.3 0-6 1.1-8.4 2.6-1.4.9-2.8 1.3-4.1 1.3s-2.7-.4-4.1-1.3c-2.4-1.5-5.1-2.6-8.4-2.6Z" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
							<path d="M22 18c2.4 1.6 5.7 2.4 10 2.4s7.6-.8 10-2.4" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
						</svg>
					</span>
					<?php endif; ?>
					<div class="starter-footer__logo-text">
						<h2 id="starter-footer-brand-title" class="starter-footer__brand-title m-0 text-sm font-bold uppercase leading-none tracking-wide"><?php echo esc_html($brand_title); ?></h2>
						<p class="starter-footer__brand-subtitle m-0 mt-1 text-xs font-semibold uppercase tracking-[0.22em] text-white/80"><?php echo esc_html($brand_subtitle); ?></p>
					</div>
				</div>
				<div id="starter-footer-address-content" class="starter-footer__content starter-footer__content--address max-w-[17rem] text-sm font-light leading-7 text-white/90"><?php echo wp_kses_post(nl2br($address_lines)); ?></div>
				<div id="starter-footer-social-list" class="starter-footer__list starter-footer__list--social mt-6">
					<?php echo do_shortcode('[wbl_socials id="541"]'); ?>
				</div>
			</section>

			<section id="starter-footer-contact" class="starter-footer__section starter-footer__section--contact min-w-0" aria-labelledby="starter-footer-contact-title">
				<h2 id="starter-footer-contact-title" class="starter-footer__title starter-footer__title--contact m-0 mb-4 text-lg font-bold text-white"><?php echo esc_html($contact_title); ?></h2>
				<ul id="starter-footer-contact-list" class="starter-footer__list starter-footer__list--contact m-0 flex list-none flex-col gap-3 p-0 text-lg leading-7 text-white/90">
					<?php if (! empty($phone)) : ?>
						<li id="starter-footer-phone-item" class="starter-footer__item starter-footer__item--phone flex items-center gap-3">
							<span class="starter-footer__item-icon inline-flex h-5 w-5 shrink-0 items-center justify-center text-white"><i class="ri-phone-line text-base"></i></span>
							<a id="starter-footer-phone-link" class="starter-footer__link starter-footer__link--phone text-white/90 font-light no-underline hover:text-white text-sm" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
						</li>
					<?php endif; ?>
					<?php if (! empty($hotline)) : ?>
						<li id="starter-footer-hotline-item" class="starter-footer__item starter-footer__item--hotline flex items-center gap-3">
							<span class="starter-footer__item-icon inline-flex h-5 w-5 shrink-0 items-center justify-center text-white"><i class="ri-smartphone-line text-base"></i></span>
							<a id="starter-footer-hotline-link" class="starter-footer__link starter-footer__link--hotline text-white/90 font-light no-underline hover:text-white text-sm" href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $hotline)); ?>"><?php echo esc_html($hotline); ?></a>
						</li>
					<?php endif; ?>
					<?php if (! empty($email)) : ?>
						<li id="starter-footer-email-item" class="starter-footer__item starter-footer__item--email flex items-center gap-3">
							<span class="starter-footer__item-icon inline-flex h-5 w-5 shrink-0 items-center justify-center text-white"><i class="ri-mail-line text-base"></i></span>
							<a id="starter-footer-email-link" class="starter-footer__link starter-footer__link--email text-white/90 font-light no-underline hover:text-white text-sm" href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
						</li>
					<?php endif; ?>
					<?php if (! empty($fax)) : ?>
						<li id="starter-footer-fax-item" class="starter-footer__item starter-footer__item--fax flex items-start gap-3">
							<span class="starter-footer__item-icon mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center text-white"><i class="ri-printer-line text-base"></i></span>
							<span class="starter-footer__link starter-footer__link--fax text-white/90 font-light text-sm"><?php echo esc_html($fax); ?></span>
						</li>
					<?php endif; ?>
				</ul>
			</section>

			<section id="starter-footer-menu" class="starter-footer__section starter-footer__section--menu min-w-0" aria-labelledby="starter-footer-menu-title">
				<h2 id="starter-footer-menu-title" class="starter-footer__title starter-footer__title--menu m-0 mb-4 text-lg font-bold text-white"><?php esc_html_e('เมนู', 'starter-theme'); ?></h2>
				<nav id="starter-footer-nav" class="starter-footer__nav" aria-label="<?php esc_attr_e('Footer Navigation', 'starter-theme'); ?>">
					<?php
					wp_nav_menu([
						'menu'           => $nav_menu_id ?: 0,
						'theme_location' => $nav_menu_id ? '' : 'starter-footer-nav',
						'container'      => false,
						'menu_class'     => 'starter-footer__menu m-0 flex list-none flex-col gap-0 p-0 text-sm leading-6 text-white/90',
						'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
						'fallback_cb'    => false,
						'walker'         => new Footer_Bottom_Toggle_Walker(),
					]);
					?>
				</nav>
			</section>

			<section id="starter-footer-map" class="starter-footer__section starter-footer__section--map min-w-0" aria-labelledby="starter-footer-map-title">
				<h2 id="starter-footer-map-title" class="starter-footer__title starter-footer__title--map m-0 mb-4 text-base font-bold text-white"><?php echo esc_html($map_label ?: $address_title); ?></h2>
				<a id="starter-footer-map-link" class="starter-footer__map-link block overflow-hidden rounded-xl bg-white/95 no-underline shadow-lg transition-opacity hover:opacity-95" href="<?php echo esc_url($map_url); ?>">
					<span class="starter-footer__map-preview relative block h-28 w-full overflow-hidden bg-[#fdf1f8] md:h-32">
						<span class="absolute inset-0 opacity-80" style="background-image: linear-gradient(90deg, rgba(236,0,140,.12) 1px, transparent 1px), linear-gradient(0deg, rgba(142,43,175,.12) 1px, transparent 1px); background-size: 38px 38px;"></span>
						<span class="absolute left-[18%] top-0 h-full w-2 -rotate-12 bg-white/80"></span>
						<span class="absolute left-[54%] top-0 h-full w-2 rotate-12 bg-white/80"></span>
						<span class="absolute left-0 top-[42%] h-2 w-full bg-white/80"></span>
						<span class="absolute left-1/2 top-1/2 inline-flex -translate-x-1/2 -translate-y-1/2 flex-col items-center gap-1 text-center text-[10px] font-bold uppercase leading-tight text-[#8E2BAF]">
							<span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#EC008C] text-white shadow-md"><i class="ri-map-pin-2-line text-base"></i></span>
							<span><?php echo esc_html($brand_title); ?></span>
						</span>
					</span>
				</a>
				<div id="starter-footer-map-address" class="starter-footer__map-address mt-4 text-sm leading-6 text-white/90 font-light"><?php echo wp_kses_post(nl2br($address_lines)); ?></div>
			</section>
		</div>

		<div id="starter-footer-bottom" class="starter-footer__bottom mt-8 border-t border-white/20 pt-4 text-center">
			<p id="starter-footer-copyright" class="starter-footer__copyright m-0 text-sm font-normal text-white/80"><?php echo wp_kses_post($copyright); ?></p>
		</div>
	</div>
</footer>
