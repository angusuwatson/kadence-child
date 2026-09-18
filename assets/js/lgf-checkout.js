/**
 * Set each checkout room to its maximum adult capacity by default.
 * Guests can still change selectors before submitting.
 */
(function () {
	'use strict';

	function applyMaxCapacityDefaults() {
		document.querySelectorAll('.mphb_sc_checkout-form .mphb-room-details').forEach(function (room) {
			var adults = room.querySelector('select[name*="[adults]"]');
			var children = room.querySelector('select[name*="[children]"]');
			var adultsChanged = false;
			var childrenChanged = false;

			if (adults && !adults.value) {
				var adultOptions = Array.prototype.filter.call(adults.options, function (option) {
					return /^\d+$/.test(option.value);
				});
				var maxAdults = adultOptions[adultOptions.length - 1];

				if (maxAdults) {
					adults.value = maxAdults.value;
					adultsChanged = true;
				}
			}

			if (children && !children.value && children.querySelector('option[value="0"]')) {
				children.value = '0';
				childrenChanged = true;
			}

			if (adultsChanged) {
				adults.dispatchEvent(new Event('change', { bubbles: true }));
			}
			if (childrenChanged) {
				children.dispatchEvent(new Event('change', { bubbles: true }));
			}
		});
	}

	if (document.readyState === 'complete') {
		applyMaxCapacityDefaults();
	} else {
		window.addEventListener('load', applyMaxCapacityDefaults);
	}

	// MotoPress may rebuild guest selectors after the adult change.
	window.setTimeout(applyMaxCapacityDefaults, 500);
})();
