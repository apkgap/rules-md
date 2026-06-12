<?php

/**
 * Template Name: Page Title Template
 * 
 * @package starter_theme
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php while (have_posts()) : the_post(); ?>

            <!-- Page Title Hero -->
            <?php starter_theme_page_title_hero(); ?>

            <!-- Main Page Content Section -->
            <div id="page-content" class="p-0">
                <div class="w-full px-0">
                    <div class="prose prose-lg max-w-none">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
