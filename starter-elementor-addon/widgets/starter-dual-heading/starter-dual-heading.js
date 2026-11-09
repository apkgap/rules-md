/* starter-dual-heading.js — Elementor frontend lifecycle handler */
(function ($) {
	'use strict';

	const initWidget = function ($scope) {
		const $root = $scope.find('.starter-dual-heading');
		if (!$root.length) {
			return;
		}
	};

	$(window).on('elementor/frontend/init', function () {
		if (window.elementorFrontend && window.elementorFrontend.hooks) {
			window.elementorFrontend.hooks.addAction(
				'frontend/element_ready/starter-dual-heading.default',
				initWidget
			);
		}
	});
})(jQuery);