<?php
/**
 * Template part for displaying archive headers (Title, Breadcrumbs, Description)
 * 
 * @package starter_theme
 * 
 * Expected $args:
 * - title (string|null)
 * - description (string|null)
 * - breadcrumb_custom (string|null)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$title       = $args['title'] ?? '';
$description = $args['description'] ?? get_the_archive_description();
$cat_title   = is_category() ? single_cat_title('', false) : '';
$tag_title   = is_tag() ? single_tag_title('', false) : '';
$author_name = is_author() ? get_the_author() : '';

// Resolve title if not provided
if (empty($title)) {
    if (is_category()) {
        $title = $cat_title;
    } elseif (is_tag()) {
        $title = $tag_title;
    } elseif (is_author()) {
        $title = $author_name;
    } else {
        $title = wp_strip_all_tags(get_the_archive_title());
    }
}
$background = function_exists('starter_theme_get_archive_page_title_background') ? starter_theme_get_archive_page_title_background() : array('show_bg' => false, 'bg_image' => '');
$show_bg = !empty($background['show_bg']);
$bg_image = isset($background['bg_image']) ? $background['bg_image'] : '';

$bg_style = '';
$header_class = 'starter-theme-archive-header pt-12 pb-16 bg-surface-base border-b border-border-base transition-colors duration-500';
$text_class = 'text-base';
$muted_class = 'text-muted';

if ($show_bg && !empty($bg_image)) {
    $bg_style = 'background-image: url(' . esc_url($bg_image) . '); background-size: cover; background-position: center;';
    $header_class = 'starter-theme-archive-header relative w-full h-full py-[3em] md:py-[4em] lg:py-[10em] pt-[5em] lg:pb-[5em] px-[1.5em] md:px-[2em] xl:px-0 flex items-center overflow-hidden';
    $text_class = 'text-white relative z-10';
    $muted_class = 'text-white/70 relative z-10';
}
?>

<header id="archive-header" class="<?php echo esc_attr($header_class); ?>" style="<?php echo esc_attr($bg_style); ?>">
    <?php if ($show_bg && !empty($bg_image)) : ?>
        <div class="absolute inset-0 bg-black/40 z-0"></div>
    <?php endif; ?>
    <div class="starter-theme-container">
        <div id="archive-header-inner" class="max-w-4xl">
            <!-- Breadcrumbs -->
            <nav id="archive-breadcrumb" class="starter-theme-breadcrumb mb-8">
                <?php if (function_exists('yoast_breadcrumb')) : ?>
                    <?php yoast_breadcrumb('<div id="breadcrumbs" class="text-sm uppercase tracking-widest ' . $muted_class . ' font-medium [&_a]:hover:text-primary transition-all">', '</div>'); ?>
                <?php else : ?>
                    <div id="archive-breadcrumb-list" class="text-sm uppercase tracking-widest <?php echo esc_attr($muted_class); ?> font-medium flex items-center gap-2">
                        <a href="<?php echo esc_url(home_url()); ?>" class="hover:text-primary transition-colors"><?php echo esc_html__('หน้าหลัก', 'starter-theme'); ?></a>
                        <span class="w-3 h-3 flex items-center justify-center border-border-base opacity-40"><i class="ri-arrow-right-line"></i></span>
                        <span class="<?php echo $show_bg ? 'text-white' : 'text-primary'; ?>">
                            <?php
                            if (is_category()) echo esc_html($cat_title);
                            elseif (is_tag()) echo esc_html($tag_title);
                            elseif (is_author()) echo esc_html($author_name);
                            else echo esc_html($title);
                            ?>
                        </span>
                    </div>
                <?php endif; ?>
            </nav>

            <h1 id="archive-main-title" class="font-display text-[clamp(2.5rem,5vw,3.5rem)] font-medium <?php echo esc_attr($text_class); ?> leading-tight mb-6 tracking-tight">
                <?php if (is_tag()) : ?>
                    <span class="w-10 h-10 inline-flex items-center justify-center <?php echo $show_bg ? 'text-white/30' : 'text-primary opacity-30'; ?>"><i class="ri-arrow-right-line"></i></span>
                <?php endif; ?>
                <?php echo esc_html($title); ?>
            </h1>

            <?php if ($description) : ?>
                <p id="archive-description" class="<?php echo esc_attr($muted_class); ?> text-base md:text-lg max-w-2xl leading-relaxed opacity-80">
                    <?php echo wp_kses_post($description); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</header>