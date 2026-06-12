/**
 * Elementor Custom Post Query Widget Frontend Handler
 */
(function ($) {
    'use strict';

    var ExatPostCustomQueryHandler = function ($element, $) {
        var $grid = $element.find('.exat-post-custom-query__grid');
        if (!$grid.length) {
            return;
        }

        // Initialize any dynamic frontend animations or interactions here
        // Example: Checking for third-party libraries before execution
        if (window.Alpine) {
            // Guarded interaction using Alpine or other libraries
        }
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/exat-post-custom-query.default',
            ExatPostCustomQueryHandler
        );
    });

})(jQuery);
