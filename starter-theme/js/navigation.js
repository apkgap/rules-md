/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	const siteNavigation = document.getElementById( 'site-navigation' );

	// Return early if the navigation doesn't exist.
	if ( ! siteNavigation ) {
		return;
	}

	const button = siteNavigation.getElementsByTagName( 'button' )[ 0 ];

	// Return early if the button doesn't exist.
	if ( 'undefined' === typeof button ) {
		return;
	}

	const menu = siteNavigation.getElementsByTagName( 'ul' )[ 0 ];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	if ( ! menu.classList.contains( 'nav-menu' ) ) {
		menu.classList.add( 'nav-menu' );
	}

	// Toggle the .toggled class and the aria-expanded value each time the button is clicked.
	button.addEventListener( 'click', function() {
		siteNavigation.classList.toggle( 'toggled' );

		if ( button.getAttribute( 'aria-expanded' ) === 'true' ) {
			button.setAttribute( 'aria-expanded', 'false' );
		} else {
			button.setAttribute( 'aria-expanded', 'true' );
		}
	} );

	// Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
	document.addEventListener( 'click', function( event ) {
		const isClickInside = siteNavigation.contains( event.target );

		if ( ! isClickInside ) {
			siteNavigation.classList.remove( 'toggled' );
			button.setAttribute( 'aria-expanded', 'false' );
		}
	} );

	// Get all the link elements within the menu.
	const links = menu.getElementsByTagName( 'a' );

	// Get all the link elements with children within the menu.
	const linksWithChildren = menu.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

	// Toggle focus each time a menu link is focused or blurred.
	for ( const link of links ) {
		link.addEventListener( 'focus', toggleFocus, true );
		link.addEventListener( 'blur', toggleFocus, true );
	}

	// Toggle focus each time a menu link with children receive a touch event.
	for ( const link of linksWithChildren ) {
		link.addEventListener( 'touchstart', toggleFocus, false );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		if ( event.type === 'focus' || event.type === 'blur' ) {
			let self = this;
			// Move up through the ancestors of the current link until we hit .nav-menu.
			while ( ! self.classList.contains( 'nav-menu' ) ) {
				// On li elements toggle the class .focus.
				if ( 'li' === self.tagName.toLowerCase() ) {
					self.classList.toggle( 'focus' );
				}
				self = self.parentNode;
			}
		}

		if ( event.type === 'touchstart' ) {
			const menuItem = this.parentNode;
			event.preventDefault();
			for ( const link of menuItem.parentNode.children ) {
				if ( menuItem !== link ) {
					link.classList.remove( 'focus' );
				}
			}
			menuItem.classList.toggle( 'focus' );
		}
	}
}() );

/**
 * Handle pagination page jump form submit events globally
 */
document.addEventListener('submit', function(event) {
	var form = event.target;
	if (!form || !form.classList || !form.classList.contains('starter-theme-pagination__jump-form')) {
		return;
	}
	event.preventDefault();
	var input = form.querySelector('input[name="paged"]');
	var value = parseInt(input && input.value ? input.value : '1', 10);
	var total = parseInt(input && input.max ? input.max : '1', 10);
	if (Number.isNaN(value)) {
		value = 1;
	}
	if (value < 1) {
		value = 1;
	}
	if (value > total) {
		value = total;
	}
	var base = form.getAttribute('data-jump-base');
	if (base && base.indexOf('%#%') !== -1) {
		window.location.href = base.replace('%#%', value);
		return;
	}
	form.submit();
});

/**
 * Global Switchery Initializer (replacing inline scripts)
 */
function initStarterThemeSwitches() {
	if (typeof Switchery !== 'undefined') {
		var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
		elems.forEach(function(html) {
			// Check if already initialized by checking for the Switchery sibling
			if (!html.nextSibling || !html.nextSibling.classList || !html.nextSibling.classList.contains('switchery')) {
				var size = html.getAttribute('data-size') || 'default';
				var disabled = html.disabled;
				new Switchery(html, {
					size: size,
					disabled: disabled
				});
			}
		});
	}
}
document.addEventListener('DOMContentLoaded', initStarterThemeSwitches);
window.initStarterThemeSwitches = initStarterThemeSwitches;


