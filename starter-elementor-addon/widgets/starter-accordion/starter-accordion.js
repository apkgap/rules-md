/* ==========================================================================
   KU ACCORDION WIDGET JS
   ========================================================================== */

/**
 * Initializes Q&A Accordion interactive toggle behaviors
 *
 * @param {HTMLElement} widgetEl The widget container element node
 */
function initKuAccordion( widgetEl ) {
	if ( ! widgetEl ) return;

	const $accordion = jQuery( widgetEl );
	
	// Prevent double initialization
	if ( $accordion.data( 'accordion-initialized' ) ) {
		return;
	}
	$accordion.data( 'accordion-initialized', true );

	const isMultiOpen = $accordion.attr( 'data-multi-open' ) === 'true';
	const $items = $accordion.find( ' > .starter-accordion__item' );

	$items.each( function() {
		const $item = jQuery( this );
		const $header = $item.find( ' > .starter-accordion__header' );
		const $wrapper = $item.find( ' > .starter-accordion__content-wrapper' );

		$header.on( 'click', function( e ) {
			e.preventDefault();

			const isOpen = $item.hasClass( 'starter-accordion__item--active' );

			if ( isOpen ) {
				// Collapse current item
				$wrapper.slideUp( 300, function() {
					$item.removeClass( 'starter-accordion__item--active' );
					$header.attr( 'aria-expanded', 'false' );
				} );
			} else {
				// Expand current item
				if ( ! isMultiOpen ) {
					// Collapse siblings if multi-open is disabled
					const $siblings = $item.siblings( '.starter-accordion__item--active' );
					$siblings.each( function() {
						const $sib = jQuery( this );
						$sib.find( ' > .starter-accordion__content-wrapper' ).slideUp( 300, function() {
							$sib.removeClass( 'starter-accordion__item--active' );
							$sib.find( ' > .starter-accordion__header' ).attr( 'aria-expanded', 'false' );
						} );
					} );
				}

				// Expand clicked item
				$wrapper.slideDown( 300, function() {
					$item.addClass( 'starter-accordion__item--active' );
					$header.attr( 'aria-expanded', 'true' );
				} );
			}
		} );
	} );
}

// Initialize on standard DOM Content Loaded for public pages
document.addEventListener( 'DOMContentLoaded', function() {
	const accordions = document.querySelectorAll( '.starter-accordion' );
	accordions.forEach( function( widgetEl ) {
		initKuAccordion( widgetEl );
	} );
} );

// Hook into Elementor Frontend ready callback for live editor frame compatibility
jQuery( window ).on( 'elementor/frontend/init', function() {
	elementorFrontend.hooks.addAction( 'frontend/element_ready/starter-accordion.default', function( $scope ) {
		const widgetEl = $scope[0].querySelector( '.starter-accordion' );
		if ( widgetEl ) {
			initKuAccordion( widgetEl );
		}
	} );
} );
