/* starter-gallery.js — Elementor frontend lifecycle handler */
(function ($) {
	'use strict';

	const initWidget = function ($scope) {
		const $root = $scope.find('.starter-gallery');
		if (!$root.length) {
			return;
		}
	};

	$(window).on('elementor/frontend/init', function () {
		if (window.elementorFrontend && window.elementorFrontend.hooks) {
			window.elementorFrontend.hooks.addAction(
				'frontend/element_ready/starter-gallery.default',
				initWidget
			);
		}
	});
})(jQuery);