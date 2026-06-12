/* ==========================================================================
   KU REVIEWS / TESTIMONIALS WIDGET JS
   ========================================================================== */

/**
 * Initializes Swiper instance for the KU Reviews carousel
 *
 * @param {HTMLElement} swiperEl The swiper element node
 */
function initKuReviewsSwiper( swiperEl ) {
	if ( ! swiperEl ) return;

	// If already initialized by Swiper, destroy it first to apply new configs
	if ( swiperEl.swiper ) {
		swiperEl.swiper.destroy( true, true );
	}

	const configStr = swiperEl.getAttribute( 'data-swiper-config' );
	if ( ! configStr ) return;

	try {
		const swiperConfig = JSON.parse( configStr );
		if ( typeof Swiper !== 'undefined' ) {
			new Swiper( swiperEl, swiperConfig );
		}
	} catch ( e ) {
		console.error( 'Failed to parse Swiper config:', e );
	}
}

// Initialize on normal DOM Load
document.addEventListener( 'DOMContentLoaded', function() {
	const swipers = document.querySelectorAll( '.starter-reviews__swiper' );
	swipers.forEach( function( swiperEl ) {
		initKuReviewsSwiper( swiperEl );
	} );
} );

// Hook into Elementor Frontend ready callback for live editor preview compatibility
jQuery( window ).on( 'elementor/frontend/init', function() {
	elementorFrontend.hooks.addAction( 'frontend/element_ready/starter-reviews.default', function( $scope ) {
		const swiperEl = $scope[0].querySelector( '.starter-reviews__swiper' );
		if ( swiperEl ) {
			initKuReviewsSwiper( swiperEl );
		}
	} );
} );
