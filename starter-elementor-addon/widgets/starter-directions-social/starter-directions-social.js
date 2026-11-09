/* starter-directions-social.js — Elementor frontend lifecycle handler */
(function ($) {
	'use strict';

	const initWidget = function ($scope) {
		const $root = $scope.find('.starter-directions-social');
		if (!$root.length) {
			return;
		}
	};

	$(window).on('elementor/frontend/init', function () {
		if (window.elementorFrontend && window.elementorFrontend.hooks) {
			window.elementorFrontend.hooks.addAction(
				'frontend/element_ready/starter-directions-social.default',
				initWidget
			);
		}
	});
})(jQuery);