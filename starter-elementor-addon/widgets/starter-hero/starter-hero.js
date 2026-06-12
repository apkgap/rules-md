/* starter-hero.js — Swiper initialization for hero slider */

(function($) {
	const initHeroSlider = function( $scope ) {
		const swiperEl = $scope.find( '.starter-hero__swiper' )[0];
		if ( ! swiperEl ) return;
		
		// Prevent double initialization
		if ( swiperEl.classList.contains( 'swiper-initialized' ) ) {
			return;
		}
		
		if ( swiperEl.dataset.swiperConfig ) {
			try {
				const config = JSON.parse( swiperEl.dataset.swiperConfig );
				
				// Isolate pagination and navigation to the current widget instance to prevent conflicts
				const paginationEl = $scope.find( '.starter-hero__pagination' )[0];
				const prevEl = $scope.find( '.starter-hero__button-prev' )[0];
				const nextEl = $scope.find( '.starter-hero__button-next' )[0];
				
				if ( paginationEl ) {
					config.pagination = {
						el: paginationEl,
						clickable: true
					};
				}
				if ( prevEl && nextEl ) {
					config.navigation = {
						prevEl: prevEl,
						nextEl: nextEl
					};
				}
				
				// Initialize Swiper
				if ( typeof Swiper !== 'undefined' ) {
					new Swiper( swiperEl, config );
				} else if ( window.elementorFrontend && window.elementorFrontend.utils && window.elementorFrontend.utils.swiper ) {
					new window.elementorFrontend.utils.swiper( swiperEl, config ).then( function( swiperInstance ) {
						// Managed async Swiper
					} );
				}
			} catch ( e ) {
				console.error( 'Invalid Swiper config:', e );
			}
		}
	};

	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/starter-hero.default', initHeroSlider );
	} );

	// Fallback for non-Elementor or direct page load
	$(document).ready(function() {
		if ( ! window.elementorFrontend ) {
			$( '.starter-hero' ).each( function() {
				initHeroSlider( $(this) );
			} );
		}
	});
})(jQuery);

