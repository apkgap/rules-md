<?php

/**
 * Template Name: Home Hybrid
 *
 * @package starter_theme
 */

get_header();

// เช็คว่าหน้าเพจกำลังเปิดใช้งาน Elementor Editor อยู่หรือไม่
$is_elementor_edit_mode = false;
if (class_exists('\Elementor\Plugin')) {
    $is_elementor_edit_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();
}
?>

<main id="home-layout" class="home-hybrid-layout bg-white">

    <!-- TOP -->
    <?php
    // ซ่อนส่วน TOP หากอยู่ในโหมด Editor ของ Elementor เพื่อไม่ให้การแก้ไข MAIN Content เลื่อนหรือเพี้ยน
    if (! $is_elementor_edit_mode) :
    ?>
        <div class="home-top w-full">
            <?php
            // แนะนำให้ดึง ID จาก ACF หรือ Theme Options เช่น get_field('top_template_id')
            // โค้ดด้านล่างเป็นการเรียกใช้แบบระบุ ID (กรุณาไปเปลี่ยน TOP_ID เป็นตัวเลข ID ของ Template จริง)
            echo do_shortcode('[elementor-template id="382"]');
            ?>
        </div>
    <?php endif; ?>

    <!-- MAIN -->
    <div class="home-main starter-theme-container flex flex-col lg:flex-row gap-8">

        <div class="main-content w-full lg:w-3/4">
            <?php
            while (have_posts()) : the_post();
                // ส่วนนี้ Elementor จะแทรกคอนเทนต์ที่ถูกตกแต่งมาให้ตรงนี้ (MAIN)
                the_content();
            endwhile;
            ?>
        </div>

        <aside x-data="{ sidebarOpen: false }" class="main-sidebar w-full lg:w-1/4 relative lg:self-start lg:sticky lg:top-28">

            <!-- Mobile/Tablet Toggle Button -->
            <button
                @click="sidebarOpen = true"
                class="lg:hidden fixed bottom-6 left-1/2 -translate-x-1/2 bg-primary text-secondary px-6 py-3 rounded-full shadow-xl font-medium z-30 flex items-center gap-2 hover:opacity-90 transition-all hover:scale-105 active:scale-95">
                <span class="w-5 h-5 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
                <span><?php echo esc_html__('เมนูเพิ่มเติม', 'starter-theme'); ?></span>
            </button>

            <!-- Backdrop for Mobile -->
            <div x-show="sidebarOpen"
                style="display: none;"
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="sidebarOpen = false"
                class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden">
            </div>

            <div :class="sidebarOpen ? 'translate-y-0' : 'translate-y-full lg:translate-y-0'"
                class="fixed inset-x-0 bottom-0 z-50 flex flex-col w-full bg-bg-base rounded-t-3xl shadow-[0_-10px_40px_rgba(0,0,0,0.2)] max-h-[85vh] transition-transform duration-300 ease-in-out lg:relative lg:z-auto lg:bg-transparent lg:shadow-none lg:rounded-none lg:max-h-none lg:block">

                <!-- Mobile Header -->
                <div class="flex items-center justify-between p-5 border-b border-border-base lg:hidden shrink-0">
                    <h3 class="text-sm font-bold text-base m-0 font-display">
                        <?php echo esc_html__('เมนูเพิ่มเติม', 'starter-theme'); ?>
                    </h3>
                    <button @click="sidebarOpen = false" class="w-9 h-9 flex items-center justify-center rounded-full bg-surface-base text-muted hover:bg-border-base transition-colors">
                        <span class="w-3 h-3 flex items-center justify-center"><i class="ri-arrow-right-line"></i></span>
                    </button>
                </div>

                <!-- Sidebar Content -->
                <div class="p-6 lg:p-0 overflow-y-auto lg:overflow-visible flex-1 overscroll-contain">
                    <?php get_sidebar(); ?>
                </div>
            </div>

        </aside>

    </div>

    <!-- BOTTOM -->
    <?php
    // ซ่อนส่วน BOTTOM ขณะอยู่ในโหมดบรรณาธิการ (Editor Mode) ของ Elementor
    if (! $is_elementor_edit_mode) :
    ?>
        <div class="home-bottom w-full">
            <?php
            // เปลี่ยน BOTTOM_ID เป็นตัวเลข ID ของ Template ที่สร้างไว้ใน Elementor Saved Templates
            echo do_shortcode('[elementor-template id="25"]');
            ?>
        </div>
    <?php endif; ?>

</main>

<?php
get_footer();
