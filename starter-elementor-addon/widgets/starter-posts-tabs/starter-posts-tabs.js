/* ==========================================================================
   KU POSTS TABS WIDGET JS
   ========================================================================== */

/**
 * Initializes Tabs filter and Mobile Drawer for the KU Posts Tabs widget
 *
 * @param {HTMLElement} widgetEl The widget scope element node
 */
function initKuPostsTabs( widgetEl ) {
	if ( ! widgetEl ) return;

	const tabs = widgetEl.querySelectorAll( '.starter-posts-tabs__tab' );
	const items = widgetEl.querySelectorAll( '.starter-posts-tabs__item' );
	const mobileTrigger = widgetEl.querySelector( '.starter-posts-tabs__mobile-trigger' );
	const triggerText = widgetEl.querySelector( '.starter-posts-tabs__mobile-trigger-text' );
	const backdrop = widgetEl.querySelector( '.starter-posts-tabs__drawer-backdrop' );
	const drawerHeader = widgetEl.querySelector( '.starter-posts-tabs__drawer-header' );
	const closeBtn = widgetEl.querySelector( '.starter-posts-tabs__drawer-close' );

	if ( ! tabs.length || ! items.length ) return;

	// MOBILE DRAWER EVENT LISTENERS
	if ( mobileTrigger ) {
		mobileTrigger.addEventListener( 'click', function( e ) {
			e.preventDefault();
			widgetEl.classList.add( 'starter-posts-tabs--open' );
			document.body.style.overflow = 'hidden'; // Prevent page body scroll when drawer is open
		} );
	}

	function closeDrawer() {
		widgetEl.classList.remove( 'starter-posts-tabs--open' );
		document.body.style.overflow = ''; // Restore body scroll
	}

	if ( backdrop ) {
		backdrop.addEventListener( 'click', closeDrawer );
	}

	if ( closeBtn ) {
		closeBtn.addEventListener( 'click', function( e ) {
			e.stopPropagation();
			closeDrawer();
		} );
	}

	if ( drawerHeader ) {
		drawerHeader.addEventListener( 'click', function( e ) {
			// Only close if we didn't click the title
			if ( ! e.target.closest( '.starter-posts-tabs__drawer-title' ) ) {
				closeDrawer();
			}
		} );
	}

	// TAB CLICK INTERACTION & FILTERING
	tabs.forEach( function( tab ) {
		tab.addEventListener( 'click', function( e ) {
			e.preventDefault();

			// Remove active class from all sibling tabs in this widget
			tabs.forEach( function( t ) {
				t.classList.remove( 'starter-posts-tabs__tab--active' );
			} );

			// Add active class to clicked tab
			tab.classList.add( 'starter-posts-tabs__tab--active' );

			// Update Mobile Trigger text label
			if ( triggerText ) {
				const tabTextEl = tab.querySelector( '.starter-posts-tabs__tab-text' );
				const tabText = tabTextEl ? tabTextEl.textContent : tab.textContent;
				triggerText.textContent = tabText;
			}

			// Close drawer on selection
			closeDrawer();

			const filterValue = tab.getAttribute( 'data-filter' );

			items.forEach( function( item ) {
				const categoriesAttr = item.getAttribute( 'data-category-slugs' );
				const categories = categoriesAttr ? categoriesAttr.split( ',' ) : [];

				if ( filterValue === 'all' || categories.includes( filterValue ) ) {
					// Show matching items
					item.style.display = ''; // Restore default display
					// Trigger standard CSS reflow
					void item.offsetWidth;
					item.classList.add( 'starter-posts-tabs__item--show' );
				} else {
					// Hide non-matching items
					item.classList.remove( 'starter-posts-tabs__item--show' );
					item.style.display = 'none';
				}
			} );
		} );
	} );
}

// Initialize on normal DOM Load
document.addEventListener( 'DOMContentLoaded', function() {
	const widgets = document.querySelectorAll( '.starter-posts-tabs' );
	widgets.forEach( function( widgetEl ) {
		initKuPostsTabs( widgetEl );
	} );
} );

// Hook into Elementor Frontend ready callback for live editor preview compatibility
jQuery( window ).on( 'elementor/frontend/init', function() {
	elementorFrontend.hooks.addAction( 'frontend/element_ready/starter-posts-tabs.default', function( $scope ) {
		const widgetEl = $scope[0].querySelector( '.starter-posts-tabs' );
		if ( widgetEl ) {
			initKuPostsTabs( widgetEl );
		}
	} );
} );
