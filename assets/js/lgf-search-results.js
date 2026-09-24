/**
 * La Grange Fleurie — page de résultats MotoPress.
 *
 * 1. Pré-remplit le panier avec la combinaison de chambres recommandée
 *    (les données sont déjà présentes dans le formulaire #mphb-recommendation,
 *    que le CSS masque).
 * 2. Affiche la liste des logements sélectionnés dans le panier, avec un
 *    bouton "retirer" pour chacun.
 */
(function () {
	'use strict';

	function onLoad(fn) {
		if (document.readyState === 'complete') {
			fn();
		} else {
			window.addEventListener('load', fn);
		}
	}

		onLoad(function () {
		var wrapper = document.querySelector('.mphb_sc_search_results-wrapper');
		if (!wrapper) {
			return;
		}
		var isEnglish = /^en(?:-|$)/i.test(document.documentElement.lang || '');
		var labels = isEnglish ? {
			selectedRooms: 'Selected rooms',
			showSelection: 'Show selection details',
			viewSelection: 'View selection details',
			closeSelection: 'Close selection details',
			addHint: 'Click “Add to selection” to choose a room.',
			noRooms: 'No rooms',
			room: 'room',
			rooms: 'rooms',
			guests: 'guests',
			removeRoom: 'Remove this room',
			dateLocale: 'en-GB'
		} : {
			selectedRooms: 'Logements sélectionnés',
			showSelection: 'Afficher le détail de la sélection',
			viewSelection: 'Voir le détail de la sélection',
			closeSelection: 'Refermer le détail de la sélection',
			addHint: 'Cliquez sur « Ajouter à ma sélection » pour choisir un logement.',
			noRooms: 'Aucun logement',
			room: 'logement',
			rooms: 'logements',
			guests: 'pers.',
			removeRoom: 'Retirer ce logement',
			dateLocale: 'fr-FR'
		};

		// Mode "réservation directe" (option mphb_direct_search_results) :
		// cliquer sur le bouton d'une chambre redirige immédiatement vers le
		// paiement. Il n'y a alors pas de panier à pré-remplir, et le faire
		// déclencherait une redirection non voulue.
		var mphbSettings = window.MPHB && window.MPHB._data ? window.MPHB._data.settings : null;
		if (mphbSettings && mphbSettings.isDirectBooking) {
			return;
		}

		var cart = wrapper.querySelector('#mphb-reservation-cart');
		if (!cart) {
			return;
		}

		var recForm = wrapper.querySelector('#mphb-recommendation');

		function sectionsById() {
			var map = {};
			wrapper.querySelectorAll('.mphb-reserve-room-section').forEach(function (section) {
				map[section.getAttribute('data-room-type-id')] = section;
			});
			return map;
		}

		// Room cards are priced for the current search occupancy. Fetch the same
		// result set at each room's maximum adult capacity so adding guests does
		// not reveal a higher price later.
		function updateMaxCapacityPrices() {
			var sections = sectionsById();
			var capacities = {};

			Object.keys(sections).forEach(function (id) {
				var card = sections[id].closest('.mphb-room-type');
				var capacityEl = card ? card.querySelector('.mphb-room-type-total-capacity .mphb-attribute-value') : null;
				var match = capacityEl ? capacityEl.textContent.match(/\d+/) : null;

				if (match) {
					capacities[match[0]] = true;
				}
			});

			Object.keys(capacities).forEach(function (capacity) {
				var url = new URL(window.location.href);
				url.searchParams.set('mphb_adults', capacity);
				url.searchParams.set('mphb_children', '0');

				window.fetch(url.toString(), { credentials: 'same-origin' })
					.then(function (response) { return response.text(); })
					.then(function (html) {
						var parsed = new DOMParser().parseFromString(html, 'text/html');

						parsed.querySelectorAll('.mphb-reserve-room-section[data-room-type-id]').forEach(function (source) {
							var id = source.getAttribute('data-room-type-id');
							var target = sections[id];
							var sourcePrice = source.getAttribute('data-room-price');
							var targetCard = target ? target.closest('.mphb-room-type') : null;
							var targetCapacityEl = targetCard
								? targetCard.querySelector('.mphb-room-type-total-capacity .mphb-attribute-value')
								: null;
							var targetCapacity = targetCapacityEl ? targetCapacityEl.textContent.match(/\d+/) : null;
							var sourcePriceEl = source.closest('.mphb-room-type')
								? source.closest('.mphb-room-type').querySelector('.mphb-regular-price .mphb-price')
								: null;
							var targetPriceEl = targetCard
								? targetCard.querySelector('.mphb-regular-price .mphb-price')
								: null;

							if (!target || !sourcePrice || !targetCapacity || targetCapacity[0] !== capacity) {
								return;
							}

							target.setAttribute('data-room-price', sourcePrice);
							if (sourcePriceEl && targetPriceEl) {
								targetPriceEl.innerHTML = sourcePriceEl.innerHTML;
							}
						});

						render();
					})
					.catch(function () {
						// Keep the server-rendered price if an auxiliary request fails.
					});
			});
		}

		function formatMoney(value) {
			if (window.MPHB && typeof MPHB.format_price === 'function') {
				return MPHB.format_price(value, { trim_zeros: true });
			}
			return value + ' €';
		}

		// ---- Liste des logements sélectionnés --------------------------------

		var list = document.createElement('ul');
		list.className = 'lgf-cart-rooms';
		list.setAttribute('aria-label', labels.selectedRooms);

		var details = cart.querySelector('.mphb-reservation-details');
		if (details && details.parentNode) {
			details.parentNode.insertBefore(list, details.nextSibling);
		} else {
			cart.insertBefore(list, cart.firstChild);
		}

		var chip = document.createElement('button');
		chip.type = 'button';
		chip.className = 'lgf-cart-chip';
		chip.setAttribute('aria-label', labels.viewSelection);
		chip.innerHTML = '<svg class="lgf-cart-chip-icon" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 6h15l-1.5 12h-13z"/><path d="M9 9V6a3 3 0 0 1 6 0v3"/></svg>' +
			'<span class="lgf-cart-chip-badge">0</span>';
		cart.insertBefore(chip, cart.firstChild);

		// ---- Dates du séjour --------------------------------------------------

		function readDate(name) {
			var input = cart.querySelector('input[name="' + name + '"]');
			if (!input || !input.value) {
				return null;
			}

			var date = new Date(input.value + 'T00:00:00');
			return isNaN(date.getTime()) ? null : date;
		}

		var checkIn = readDate('mphb_check_in_date');
		var checkOut = readDate('mphb_check_out_date');
		var nights = (checkIn && checkOut)
			? Math.round((checkOut.getTime() - checkIn.getTime()) / 86400000)
			: 0;

		function formatRange(start, end) {
			if (!start || !end) {
				return '';
			}

			var month = new Intl.DateTimeFormat(labels.dateLocale, { month: 'short' });

			if (start.getTime() === end.getTime()) {
				return start.getDate() + ' ' + month.format(start) + ' ' + start.getFullYear();
			}

			var sameMonth = start.getMonth() === end.getMonth() && start.getFullYear() === end.getFullYear();

			if (sameMonth) {
				return start.getDate() + '\u2013' + end.getDate() + ' ' + month.format(end) + ' ' + end.getFullYear();
			}

			return start.getDate() + ' ' + month.format(start) + ' \u2013 ' +
				end.getDate() + ' ' + month.format(end) + ' ' + end.getFullYear();
		}

		var nightsText = nights ? nights + (nights > 1 ? (isEnglish ? ' nights' : ' nuits') : (isEnglish ? ' night' : ' nuit')) : '';
		var rangeText = formatRange(checkIn, checkOut);
		var datesText = [nightsText, rangeText].filter(Boolean).join(' · ');

		var datesEl = document.createElement('p');
		datesEl.className = 'lgf-cart-dates';
		datesEl.textContent = datesText;
		cart.insertBefore(datesEl, chip.nextSibling);

		// ---- Aide quand aucune chambre n'est sélectionnée --------------------

		var hintEl = document.createElement('p');
		hintEl.className = 'lgf-cart-hint';
		hintEl.textContent = labels.addHint;
		cart.insertBefore(hintEl, datesEl.nextSibling);

		function updateCartIconVisibility() {
			var hasSelection = cart.querySelectorAll('[name^="mphb_rooms_details"]').length > 0;
			var cartBounds = cart.getBoundingClientRect();
			var cartHasLeftViewport = cartBounds.bottom < 0;
			wrapper.classList.toggle('lgf-cart-icon-visible', hasSelection && cartHasLeftViewport);
		}

		function renderChip() {
			var inputs = cart.querySelectorAll('[name^="mphb_rooms_details"]');
			var count = 0;

			Array.prototype.forEach.call(inputs, function (input) {
				count += parseInt(input.value, 10) || 1;
			});

			var badge = cart.querySelector('.lgf-cart-chip-badge');
			if (badge) {
				badge.textContent = String(count);
			}
			updateCartIconVisibility();
		}

		function render() {
			var sections = sectionsById();
			var inputs = cart.querySelectorAll('[name^="mphb_rooms_details"]');
			var inCart = {};
			var html = '';

			Array.prototype.forEach.call(inputs, function (input) {
				var match = input.name.match(/mphb_rooms_details\[(\d+)\]/);
				if (match) {
					inCart[match[1]] = true;
				}
			});

			Array.prototype.forEach.call(inputs, function (input) {
				var match = input.name.match(/mphb_rooms_details\[(\d+)\]/);
				if (!match) {
					return;
				}

				var id = match[1];
				var quantity = parseInt(input.value, 10) || 1;
				var section = sections[id];
				var title = section ? section.getAttribute('data-room-type-title') : (isEnglish ? 'Room ' : 'Logement ') + id;
				var price = section ? parseFloat(section.getAttribute('data-room-price')) || 0 : 0;
				var card = section ? section.closest('.mphb-room-type') : null;
				var capacityEl = card ? card.querySelector('.mphb-room-type-total-capacity .mphb-attribute-value') : null;
				var capacity = capacityEl ? capacityEl.textContent.replace(/\s+/g, ' ').trim() : '';
				var capacityHtml = capacity
					? '<span class="lgf-cart-room-capacity">' + capacity + ' ' + labels.guests + '</span>'
					: '';

				html += '<li class="lgf-cart-room" data-room-type-id="' + id + '">' +
					'<span class="lgf-cart-room-qty">' + quantity + ' &times;</span>' +
					'<span class="lgf-cart-room-title">' + title + '</span>' +
					capacityHtml +
					'<span class="lgf-cart-room-price">' + formatMoney(price * quantity) + '</span>' +
					'<button type="button" class="lgf-cart-room-remove" data-room-type-id="' + id + '" aria-label="' + labels.removeRoom + '">&times;</button>' +
					'</li>';
			});

			list.innerHTML = html;
			list.classList.toggle('lgf-cart-rooms-empty', inputs.length === 0);
			hintEl.style.display = inputs.length ? 'none' : '';
			renderChip();

			// Le bouton de la carte devient "Supprimer" (lien natif de MotoPress
			// stylé en bouton) dès que la chambre est dans la sélection.
			Object.keys(sections).forEach(function (id) {
				var bookButton = sections[id].querySelector('.mphb-book-button');
				var removeLink = sections[id].querySelector('.mphb-remove-from-reservation');

				if (!bookButton) {
					return;
				}

				bookButton.style.display = inCart[id] ? 'none' : '';
				if (removeLink) {
					removeLink.classList.toggle('lgf-remove-button', !!inCart[id]);
				}
			});

			// Panier vide : le raccourci flottant disparaît.
			if (inputs.length === 0) {
				wrapper.classList.remove('lgf-cart-icon-visible');
			}
		}

		function removeSectionRoom(id) {
			var section = sectionsById()[id];
			var removeLink = section ? section.querySelector('.mphb-remove-from-reservation') : null;

			if (removeLink) {
				removeLink.click();
			}
		}

		// Retrait d'un logement : on déclenche le lien "Retirer" de la carte
		// correspondante, ce qui met à jour le panier géré par MotoPress.
		list.addEventListener('click', function (event) {
			var button = event.target.closest('.lgf-cart-room-remove');
			if (!button) {
				return;
			}

			event.preventDefault();
			removeSectionRoom(button.getAttribute('data-room-type-id'));
			window.setTimeout(render, 60);
		});

		// Le plugin reconstruit les champs cachés du panier à chaque changement :
		// on réaffiche la liste quand c'est le cas.
		if (window.MutationObserver) {
			var observer = new MutationObserver(function () {
				window.setTimeout(render, 0);
			});
			observer.observe(cart, {
				childList: true,
				attributes: true,
				attributeFilter: ['class']
			});
		}

		// Message "X ajoute a votre reservation" : retirer le prefixe
		// "1 x " genere par MotoPress ("%1$d &times; &ldquo;%2$s&rdquo;").
		function stripMessagePrefixes(root) {
			var nodes = root.querySelectorAll('.mphb-rooms-reservation-message');
			Array.prototype.forEach.call(nodes, function (el) {
				if (el.textContent && /^\s*\d+\s*\u00d7/.test(el.textContent)) {
					el.textContent = el.textContent.replace(/^\s*\d+\s*\u00d7\s*/, '');
				}
			});
		}

		if (window.MutationObserver) {
			var wrapperObserver = new MutationObserver(function () {
				window.setTimeout(function () {
					stripMessagePrefixes(wrapper);
				}, 0);
			});
			wrapperObserver.observe(wrapper, {
				childList: true,
				subtree: true
			});
		}

		if (window.IntersectionObserver) {
			var cartObserver = new IntersectionObserver(function () {
				updateCartIconVisibility();
			}, { threshold: 0 });
			cartObserver.observe(cart);
		}
		window.addEventListener('scroll', updateCartIconVisibility, { passive: true });
		window.addEventListener('resize', updateCartIconVisibility);

		chip.addEventListener('click', function () {
			cart.scrollIntoView({ behavior: 'smooth', block: 'start' });
		});

		// ---- Pré-remplissage avec la recommandation --------------------------
		//
		// Le script MotoPress attache les gestionnaires de clic seulement
		// après l'événement "load" ; un simple clic au chargement ne fait
		// donc rien. On réessaie jusqu'à ce que le panier accepte les clics,
		// en ne traitant que les logements pas encore ajoutés (idempotent).

		function recommendedRooms() {
			var rooms = [];
			if (!recForm) {
				return rooms;
			}

			recForm.querySelectorAll('[name^="mphb_rooms_details"]').forEach(function (input) {
				var match = input.name.match(/mphb_rooms_details\[(\d+)\]/);
				if (match) {
					rooms.push({
						id: match[1],
						quantity: parseInt(input.value, 10) || 1
					});
				}
			});

			return rooms;
		}

		function roomsInCart() {
			var ids = {};
			cart.querySelectorAll('[name^="mphb_rooms_details"]').forEach(function (input) {
				var match = input.name.match(/mphb_rooms_details\[(\d+)\]/);
				if (match) {
					ids[match[1]] = true;
				}
			});
			return ids;
		}

		var seedAttempts = 0;

		function seedFromRecommendation() {
			var inCart = roomsInCart();
			var pending = recommendedRooms().filter(function (room) {
				return !inCart[room.id];
			});

			if (!pending.length || seedAttempts >= 40) {
				render();
				return;
			}

			seedAttempts++;
			var sections = sectionsById();

			pending.forEach(function (room) {
				var section = sections[room.id];
				if (!section) {
					return;
				}

				var select = section.querySelector('.mphb-rooms-quantity');
				if (select && select.querySelector('option[value="' + room.quantity + '"]')) {
					select.value = String(room.quantity);
				}

				var bookButton = section.querySelector('.mphb-book-button');
				if (bookButton) {
					bookButton.click();
				}
			});

			render();
			window.setTimeout(seedFromRecommendation, 100);
		}

		seedFromRecommendation();
		render();
		updateMaxCapacityPrices();
		stripMessagePrefixes(wrapper);

		updateCartIconVisibility();
	});
})();
