/**
 * Switchery - Custom version with theme tokens
 * iOS 7 style switches for checkboxes
 */

(function() {
	'use strict';

	function Switchery(elem, options) {
		this.defaults = {
			color: '#8fd11f',
			secondaryColor: 'var(--starter-bg-neutral, #d9d9de)',
			jackColor: '#fff',
			jackSecondaryColor: null,
			className: 'switchery',
			disabled: false,
			disabledOpacity: 0.5,
			speed: '0.1s',
			size: 'default'
		};

		this.elem = elem;
		this.options = Object.assign({}, this.defaults, options);

		this.hide();
		this.create();
		this.observe();
		this.position();

		if (this.options.disabled) {
			this.disable();
		}
	}

	Switchery.prototype.hide = function() {
		this.elem.style.display = 'none';
	};

	Switchery.prototype.create = function() {
		this.switcher = document.createElement('span');
		this.jack = document.createElement('small');
		this.switcher.appendChild(this.jack);
		this.switcher.className = this.options.className;

		if (this.options.size !== 'default') {
			this.switcher.classList.add('switchery-' + this.options.size);
		}

		this.elem.parentNode.insertBefore(this.switcher, this.elem);
	};

	Switchery.prototype.observe = function() {
		var self = this;

		this.switcher.addEventListener('click', function(e) {
			e.preventDefault();
			self.toggle();
		});

		this.elem.addEventListener('change', function() {
			self.position();
		});
	};

	Switchery.prototype.toggle = function() {
		if (this.options.disabled) {
			return;
		}

		this.elem.checked = !this.elem.checked;
		this.position();
	};

	Switchery.prototype.position = function() {
		var checked = this.elem.checked;
		var jack = this.jack;

		if (checked) {
			this.setColor(true);
			jack.style.left = 'auto';
			jack.style.right = '2px';
		} else {
			this.setColor(false);
			jack.style.left = '2px';
			jack.style.right = 'auto';
		}
	};

	Switchery.prototype.setColor = function(state) {
		var switcher = this.switcher;
		var jack = this.jack;
		var color = state ? this.options.color : this.options.secondaryColor;
		var jackColor = state ? this.options.jackColor : this.options.jackSecondaryColor;

		switcher.style.backgroundColor = color;

		if (jackColor) {
			jack.style.backgroundColor = jackColor;
		}
	};

	Switchery.prototype.disable = function() {
		this.switcher.style.opacity = this.options.disabledOpacity;
		this.switcher.style.cursor = 'default';
		this.options.disabled = true;
	};

	Switchery.prototype.enable = function() {
		this.switcher.style.opacity = 1;
		this.switcher.style.cursor = 'pointer';
		this.options.disabled = false;
	};

	// Export to global
	window.Switchery = Switchery;

	// Auto-initialize
	document.addEventListener('DOMContentLoaded', function() {
		var switches = document.querySelectorAll('.js-switch');
		switches.forEach(function(elem) {
			var size = elem.dataset.size || 'default';
			var disabled = elem.disabled;
			new Switchery(elem, {
				size: size,
				disabled: disabled
			});
		});
	});

})();
