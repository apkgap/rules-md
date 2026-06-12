<?php
/**
 * Custom Theme Functions (CTTM)
 * 
 * @package starter_theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Render a custom language switcher dropdown for Polylang
 * Supports Alpine.js and custom theme colors
 */
function starter_theme_language_switcher() {
    if ( ! function_exists( 'pll_current_language' ) ) {
        return;
    }

    $current_lang = pll_current_language();
    $languages    = pll_the_languages( array( 'raw' => 1 ) );

    if ( empty( $languages ) ) {
        return;
    }

    // Get the current language object
    $current_lang_obj = null;
    foreach ( $languages as $lang ) {
        if ( $lang['current_lang'] ) {
            $current_lang_obj = $lang;
            break;
        }
    }

    if ( ! $current_lang_obj ) {
        return;
    }

    // Get theme settings for colors
    $lang_color = starter_theme_get_option( 'language_switcher_color', 'var(--text-base)' );
    ?>
    <div class="relative" x-data="{ open: false }">
        <button
            @click="open = !open"
            @click.away="open = false"
            type="button"
            class="flex items-center gap-1 px-2 h-10 text-sm font-bold uppercase transition-opacity hover:opacity-80"
            style="color: <?php echo esc_attr( $lang_color ); ?>;">
            <span><?php echo esc_html( $current_lang_obj['slug'] ); ?></span>
            <span class="w-3.5 h-3.5 transition-transform duration-200 flex items-center justify-center" :class="open ? 'rotate-180' : ''">
                <i class="ri-arrow-right-line"></i>
            </span>
        </button>

        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-1"
            class="absolute right-0 mt-1 w-24 bg-bg-base border border-border-base/60 rounded-xl shadow-xl z-50 overflow-hidden"
            style="display: none;">
            <div class="py-1">
                <?php foreach ( $languages as $lang ) : ?>
                    <a
                        href="<?php echo esc_url( $lang['url'] ); ?>"
                        class="flex items-center justify-between px-4 py-2 text-sm font-medium transition-colors hover:bg-surface-base <?php echo $lang['current_lang'] ? 'text-primary' : 'text-base'; ?>">
                        <span class="uppercase"><?php echo esc_html( $lang['slug'] ); ?></span>
                        <?php if ( $lang['current_lang'] ) : ?>
                            <span class="w-3.5 h-3.5 text-primary flex items-center justify-center">
                                <i class="ri-arrow-right-line"></i>
                            </span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Format post date in Thai language with Buddhist Era (B.E.) year.
 *
 * @param int|WP_Post|null $post   Post ID or post object. Default is global $post.
 * @param string           $format 'short' (e.g. 22 พ.ค. 2569) or 'full' (e.g. 22 พฤษภาคม 2569) or 'no_year' (e.g. 22 พ.ค.).
 * @return string Formatted Thai date.
 */
function cttm_thai_date( $post = null, $format = 'short' ) {
    $post = get_post( $post );
    if ( ! $post ) {
        return '';
    }

    $time = mysql2date( 'G', $post->post_date );
    
    $day = date( 'j', $time );
    $month_num = date( 'n', $time );
    $year = date( 'Y', $time ) + 543; // Convert to Buddhist Era (B.E.)

    $thai_months_short = array(
        1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.', 5 => 'พ.ค.', 6 => 'มิ.ย.',
        7 => 'ก.ค.', 8 => 'ส.ค.', 9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
    );

    $thai_months_full = array(
        1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน', 5 => 'พฤษภาคม', 6 => 'มิถุนายน',
        7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
    );

    if ( $format === 'full' ) {
        return $day . ' ' . $thai_months_full[ $month_num ] . ' ' . $year;
    } elseif ( $format === 'no_year' ) {
        return $day . ' ' . $thai_months_short[ $month_num ];
    }

    // Default 'short'
    return $day . ' ' . $thai_months_short[ $month_num ] . ' ' . $year;
}
