<?php

/**
 * The template for displaying 404 pages (not found)
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
				404
			</div>
			<div class="text-[100px] sm:text-[140px] font-black leading-none bg-linear-to-br from-primary via-emerald-600 to-[#1b5e20] bg-clip-text text-transparent drop-shadow-md">
				404
			</div>
		</div>

		<!-- Main Error Content Card -->
		<div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md rounded-2xl p-8 sm:p-10 border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none mb-8 transition-transform hover:scale-[1.01] duration-300">
			<!-- Compass Icon badge -->
			<div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 dark:bg-indigo-950/30 text-indigo-500 mb-6 border border-indigo-100 dark:border-indigo-900/30 animate-spin [animation-duration:15s]">
				<i class="ri-compass-3-line text-2xl"></i>
			</div>

			<h1 class="text-2xl sm:text-3xl font-display font-bold text-slate-800 dark:text-slate-100 mb-4">
				<?php esc_html_e('Page Not Found', 'starter-theme'); ?>
			</h1>
			<p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base leading-relaxed max-w-md mx-auto">
				<?php esc_html_e('Oops! The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'starter-theme'); ?>
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
