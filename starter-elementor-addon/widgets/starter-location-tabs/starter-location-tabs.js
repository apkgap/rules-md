/* ==========================================================================
   KU LOCATION TABS WIDGET JS
   ========================================================================== */

/**
 * Initializes click switching for the KU Location Tabs widget
 *
 * @param {HTMLElement} widgetEl The widget scope element node
 */
function initKuLocationTabs( widgetEl ) {
	if ( ! widgetEl ) return;

	const tabs = widgetEl.querySelectorAll( '.starter-starter-location-tabs__tab' );
	const panes = widgetEl.querySelectorAll( '.starter-starter-location-tabs__pane' );

	if ( ! tabs.length || ! panes.length ) return;

	tabs.forEach( function( tab ) {
		tab.addEventListener( 'click', function( e ) {
			e.preventDefault();

			const targetId = tab.getAttribute( 'data-target' );
			if ( ! targetId ) return;

			// 1. Remove active state from all navigation tabs
			tabs.forEach( function( t ) {
				t.classList.remove( 'starter-starter-location-tabs__tab--active' );
			} );

			// 2. Remove active state from all details panes
			panes.forEach( function( p ) {
				p.classList.remove( 'starter-starter-location-tabs__pane--active' );
			} );

			// 3. Mark clicked tab as active
			tab.classList.add( 'starter-starter-location-tabs__tab--active' );

			// 4. Show corresponding panel
			const targetPane = widgetEl.querySelector( '#' + targetId );
			if ( targetPane ) {
				targetPane.classList.add( 'starter-starter-location-tabs__pane--active' );
			}
		} );
	} );
}

// Initialize on standard page DOM Load
document.addEventListener( 'DOMContentLoaded', function() {
	const widgets = document.querySelectorAll( '.starter-starter-location-tabs' );
	widgets.forEach( function( widgetEl ) {
		initKuLocationTabs( widgetEl );
	} );
} );

// Hook into Elementor Frontend ready callback for live editor preview compatibility
jQuery( window ).on( 'elementor/frontend/init', function() {
	elementorFrontend.hooks.addAction( 'frontend/element_ready/starter-location-tabs.default', function( $scope ) {
		const widgetEl = $scope[0].querySelector( '.starter-starter-location-tabs' );
		if ( widgetEl ) {
			initKuLocationTabs( widgetEl );
		}
	} );
} );
