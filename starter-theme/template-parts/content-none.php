<?php
/**
 * Template part for displaying a message that posts cannot be found
 * 
 * Elegant, dynamic and unified empty state view for all archives, category, tag, search and index pages.
 *
 * @package starter_theme
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$has_filter  = $args['has_filter'] ?? false;
$archive_url = $args['archive_url'] ?? home_url('/');
?>

<div class="bg-surface-base rounded-3xl p-16 md:p-20 text-center border border-border-base shadow-sm">
	<span class="w-16 h-16 flex items-center justify-center mx-auto text-muted opacity-20 mb-6 bg-bg-base rounded-full border border-border-base/50">
		<i class="ri-search-line text-3xl"></i>
	</span>
	
	<?php if ( is_search() ) : ?>
		<!-- SEARCH EMPTY STATE -->
		<h3 class="font-display text-2xl font-bold mb-4 text-base">
			<?php echo esc_html__('ไม่พบข้อมูลที่ต้องการ', 'starter-theme'); ?>
		</h3>
		<p class="text-muted text-sm leading-relaxed mb-8 max-w-md mx-auto">
			<?php echo esc_html__('ขออภัย เราไม่พบข้อมูลที่ตรงกับคำค้นหาของคุณ ลองใช้คำค้นหาอื่นดูอีกครั้ง', 'starter-theme'); ?>
		</p>
		
		<div class="max-w-md mx-auto">
			<form role="search" method="get" action="<?php echo esc_url( home_url('/') ); ?>" class="relative">
				<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr__('ค้นหาข้อมูลใหม่...', 'starter-theme'); ?>" class="w-full bg-bg-base border border-border-base rounded-2xl py-4 pl-6 pr-14 text-sm text-base focus:outline-none focus:border-primary transition-all">
				<button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center shadow-lg shadow-primary/20 hover:bg-primary/90 transition-colors">
					<span class="w-5 h-5 flex items-center justify-center"><i class="ri-search-line"></i></span>
				</button>
			</form>
		</div>
		
	<?php else : ?>
		<!-- GENERAL ARCHIVE EMPTY STATE -->
		<h3 class="font-display text-2xl font-bold mb-4 text-base">
			<?php echo esc_html__('ไม่พบบทความ', 'starter-theme'); ?>
		</h3>
		<p class="text-muted text-sm leading-relaxed mb-8 max-w-md mx-auto">
			<?php echo esc_html__('ลองใช้วิธีค้นหาแบบอื่น หรือลบตัวกรองออก', 'starter-theme'); ?>
		</p>
		
		<?php if ($has_filter) : ?>
			<a href="<?php echo esc_url($archive_url); ?>" class="inline-flex items-center gap-2 px-8 py-3 bg-primary text-white rounded-full font-bold hover:bg-primary/95 hover:shadow-lg transition-all active:scale-95">
				<span class="w-3.5 h-3.5 flex items-center justify-center"><i class="ri-refresh-line"></i></span>
				<span><?php echo esc_html__('ล้างการค้นหา', 'starter-theme'); ?></span>
			</a>
		<?php endif; ?>
		
	<?php endif; ?>
</div>
