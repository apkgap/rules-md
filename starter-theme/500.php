<?php

/**
 * The template for displaying 500 pages (internal server error)
 *
 * @package starter_theme
 */

get_header();
?>

<main class="site-main min-h-[75vh] flex items-center justify-center bg-radial from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-950 py-16 px-4">
	<div class="max-w-xl w-full text-center">
		<!-- Huge, Stylized 3D-like status code -->
		<div class="relative mb-6 select-none pointer-events-none">
			<div class="text-[120px] sm:text-[160px] font-black leading-none bg-linear-to-r from-primary to-[#2e7d32] bg-clip-text text-transparent opacity-10 blur-xs absolute inset-0 flex justify-center items-center">
				500
			</div>
			<div class="text-[100px] sm:text-[140px] font-black leading-none bg-linear-to-br from-primary via-emerald-600 to-[#1b5e20] bg-clip-text text-transparent drop-shadow-md">
				500
			</div>
		</div>

		<!-- Main Error Content Card -->
		<div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md rounded-2xl p-8 sm:p-10 border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none mb-8 transition-transform hover:scale-[1.01] duration-300">
			<!-- Gear Icon badge -->
			<div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 dark:bg-slate-950/30 text-slate-500 mb-6 border border-slate-100 dark:border-slate-900/30 relative">
				<i class="ri-settings-3-line text-2xl animate-spin [animation-duration:8s]"></i>
				<i class="ri-settings-5-line text-sm absolute top-4 right-4 animate-spin [animation-duration:4s] [animation-direction:reverse]"></i>
			</div>

			<h1 class="text-2xl sm:text-3xl font-display font-bold text-slate-800 dark:text-slate-100 mb-4">
				<?php esc_html_e('Internal Server Error', 'starter-theme'); ?>
			</h1>
			<p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base leading-relaxed max-w-md mx-auto">
				<?php esc_html_e('Something went wrong on our end. Our technical team has been notified. Please try again later.', 'starter-theme'); ?>
			</p>
		</div>

		<!-- Action Buttons -->
		<div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-xl shadow-lg shadow-primary/20 hover:shadow-primary/30 transform hover:-translate-y-0.5 transition-all duration-300">
				<i class="ri-home-line"></i>
				<span><?php esc_html_e('Back to Home', 'starter-theme'); ?></span>
			</a>
			<button onclick="history.back()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 text-sm font-medium rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transform hover:-translate-y-0.5 transition-all duration-300">
				<i class="ri-arrow-left-line"></i>
				<span><?php esc_html_e('Go Back', 'starter-theme'); ?></span>
			</button>
		</div>
	</div>
</main>

<?php
get_footer();
