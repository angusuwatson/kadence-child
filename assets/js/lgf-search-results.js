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

		function formatMoney(value) {
			if (window.MPHB && typeof MPHB.format_price === 'function') {
				return MPHB.format_price(value, { trim_zeros: true });
			}
			return value + ' €';
		}

		// ---- Liste des logements sélectionnés --------------------------------

		var list = document.createElement('ul');
		list.className = 'lgf-cart-rooms';
		list.setAttribute('aria-label', 'Logements sélectionnés');

		var details = cart.querySelector('.mphb-reservation-details');
		if (details && details.parentNode) {
			details.parentNode.insertBefore(list, details.nextSibling);
		} else {
			cart.insertBefore(list, cart.firstChild);
		}

		// ---- Barre compacte (mobile) -----------------------------------------
		//
		// Sur mobile, au défilement, le panier se réduit à une fine barre
		// fixée en haut de l'écran. Un appui sur la barre déploie le détail.

		var bar = document.createElement('button');
		bar.type = 'button';
		bar.className = 'lgf-cart-bar';
		bar.setAttribute('aria-expanded', 'false');
		bar.setAttribute('aria-label', 'Afficher le détail de la sélection');
		bar.innerHTML = '<span class="lgf-cart-bar-left"></span>' +
			'<span class="lgf-cart-bar-summary"></span>' +
			'<span class="lgf-cart-bar-chevron" aria-hidden="true">&#9662;</span>';
		cart.insertBefore(bar, cart.firstChild);

		// ---- Pastille de panier réduit (chip) et bouton de fermeture -------

		var chip = document.createElement('button');
		chip.type = 'button';
		chip.className = 'lgf-cart-chip';
		chip.setAttribute('aria-expanded', 'false');
		chip.setAttribute('aria-label', 'Voir le detail de la selection');
		chip.innerHTML = '<svg class="lgf-cart-chip-icon" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 6h15l-1.5 12h-13z"/><path d="M9 9V6a3 3 0 0 1 6 0v3"/></svg>' +
			'<span class="lgf-cart-chip-badge">0</span>';
		cart.insertBefore(chip, bar.nextSibling);

		var closeBtn = document.createElement('button');
		closeBtn.type = 'button';
		closeBtn.className = 'lgf-cart-close';
		closeBtn.setAttribute('aria-label', 'Refermer le detail de la selection');
		closeBtn.innerHTML = '&#10005;';
		cart.appendChild(closeBtn);

		var sentinel = document.createElement('div');
		sentinel.className = 'lgf-cart-sentinel';
		sentinel.setAttribute('aria-hidden', 'true');
		wrapper.insertBefore(sentinel, cart);

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

			var month = new Intl.DateTimeFormat('fr-FR', { month: 'short' });

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

		var nightsText = nights ? nights + (nights > 1 ? ' nuits' : ' nuit') : '';
		var rangeText = formatRange(checkIn, checkOut);
		var datesText = [nightsText, rangeText].filter(Boolean).join(' · ');

		var datesEl = document.createElement('p');
		datesEl.className = 'lgf-cart-dates';
		datesEl.textContent = datesText;
		cart.insertBefore(datesEl, bar.nextSibling);

		// ---- Aide quand aucune chambre n'est sélectionnée --------------------

		var hintEl = document.createElement('p');
		hintEl.className = 'lgf-cart-hint';
		hintEl.textContent = 'Cliquez sur \u00ab Ajouter \u00e0 ma s\u00e9lection \u00bb pour choisir une chambre.';
		cart.insertBefore(hintEl, datesEl.nextSibling);

		function renderBar() {
			var inputs = cart.querySelectorAll('[name^="mphb_rooms_details"]');
			var count = 0;

			Array.prototype.forEach.call(inputs, function (input) {
				count += parseInt(input.value, 10) || 1;
			});

			var totalEl = cart.querySelector('.mphb-cart-total-price-value');
			var total = totalEl ? totalEl.textContent.replace(/\s+/g, ' ').trim() : '';
			var left = count === 0
				? 'Aucun logement'
				: count + (count > 1 ? ' logements' : ' logement');

			bar.querySelector('.lgf-cart-bar-left').textContent = left;
			bar.querySelector('.lgf-cart-bar-summary').textContent = count === 0 ? '' : total;

			var badge = cart.querySelector('.lgf-cart-chip-badge');
			if (badge) {
				badge.textContent = String(count);
			}
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
				var title = section ? section.getAttribute('data-room-type-title') : 'Logement ' + id;
				var price = section ? parseFloat(section.getAttribute('data-room-price')) || 0 : 0;
				var card = section ? section.closest('.mphb-room-type') : null;
				var capacityEl = card ? card.querySelector('.mphb-room-type-total-capacity .mphb-attribute-value') : null;
				var capacity = capacityEl ? capacityEl.textContent.replace(/\s+/g, ' ').trim() : '';
				var capacityHtml = capacity
					? '<span class="lgf-cart-room-capacity">' + capacity + ' pers.</span>'
					: '';

				html += '<li class="lgf-cart-room" data-room-type-id="' + id + '">' +
					'<span class="lgf-cart-room-qty">' + quantity + ' &times;</span>' +
					'<span class="lgf-cart-room-title">' + title + '</span>' +
					capacityHtml +
					'<span class="lgf-cart-room-price">' + formatMoney(price * quantity) + '</span>' +
					'<button type="button" class="lgf-cart-room-remove" data-room-type-id="' + id + '" aria-label="Retirer ce logement">&times;</button>' +
					'</li>';
			});

			list.innerHTML = html;
			list.classList.toggle('lgf-cart-rooms-empty', inputs.length === 0);
			hintEl.style.display = inputs.length ? 'none' : '';
			renderBar();

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

			// Panier vide : on annule la réduction pour laisser apparaître
			// le message "aucun logement".
			if (inputs.length === 0) {
				expanded = false;
				wrapper.classList.remove('lgf-cart-minimized', 'lgf-cart-expanded');
			}
		}

		function removeSectionRoom(id) {
			var section = sectionsById()[id];
			var removeLink = section ? section.querySelector('.mphb-remove-from-reservation') : null;

			if (removeLink) {
				removeLink.click();
			}
		}

		function syncBarAttrs() {
			var isExpanded = wrapper.classList.contains('lgf-cart-expanded');
			bar.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
			chip.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
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

		// ---- Réduction du panier au défilement ------------------------------

		var expanded = false;

		function setMinimized(minimized) {
			wrapper.classList.toggle('lgf-cart-minimized', !!minimized);
			wrapper.classList.toggle('lgf-cart-expanded', !!(minimized && expanded));
			syncBarAttrs();
		}

		if (window.IntersectionObserver) {
			var stickyObserver = new IntersectionObserver(function (entries) {
				var entry = entries[0];
				var stuck = !entry.isIntersecting && entry.boundingClientRect.top < 0;

				if (!stuck) {
					expanded = false;
					wrapper.classList.remove('lgf-cart-minimized', 'lgf-cart-expanded');
					syncBarAttrs();
					return;
				}

				setMinimized(true);
			}, { threshold: 0 });

			stickyObserver.observe(sentinel);
		}

		bar.addEventListener('click', function () {
			expanded = !expanded;
			setMinimized(sentinel.getBoundingClientRect().top < 0);
		});

		// La pastille (vue reduite) bascule le detail, comme la barre.
		chip.addEventListener('click', function () {
			bar.click();
		});

		closeBtn.addEventListener('click', function () {
			expanded = false;
			setMinimized(true);
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
		stripMessagePrefixes(wrapper);

		// Barres en haut de l'ecran (entete sticky, barre admin, menu pin...).
		// La pastille doit rester visible : on la cale sous la barre la plus
		// basse qui occupe le haut de l'ecran, et sous son z-index.
		function applyHeaderMetrics() {
			var wrapperRect = wrapper.getBoundingClientRect();
			var viewportW = window.innerWidth;
			var top = 8;
			var zIndex = 5;
			var candidates = wrapper.ownerDocument.querySelectorAll(
				'#wpadminbar, header, nav, [class*="header"], [class*="site-header"], ' +
				'[class*="bar"], [class*="top-bar"], [class*="topbar"], [class*="sticky"]'
			);

			Array.prototype.forEach.call(candidates, function (el) {
				if (wrapper.contains(el) || el.contains(wrapper)) {
					return;
				}

				var style = window.getComputedStyle(el);
				if (style.position !== 'fixed' && style.position !== 'sticky') {
					return;
				}

				var rect = el.getBoundingClientRect();
				if (rect.top > 6 || rect.bottom <= 0) {
					return;
				}

				// Ignorer les petites bulles (pastille du panier...)
				if (rect.width < viewportW * 0.5) {
					return;
				}

				if (rect.bottom + 4 > top) {
					top = rect.bottom + 4;
				}

				var z = parseInt(style.zIndex, 10);
				if (!isNaN(z) && z > zIndex) {
					zIndex = z;
				}
			});

			var left = Math.max(wrapperRect.left + 12, 12);
			var maxLeft = Math.max(12, viewportW - 150);
			if (left > maxLeft) {
				left = maxLeft;
			}

			var root = wrapper.ownerDocument.documentElement;
			root.style.setProperty('--lgf-cart-top', top + 'px');
			root.style.setProperty('--lgf-cart-z', String(zIndex - 6));
			root.style.setProperty('--lgf-cart-left', left + 'px');
		}

		// L'entete "relative" du theme sort de l'ecran au defilement : on
		// recalcule pour remonter la pastille en haut de l'ecran (debouche).
		var lastMetricStamp = 0;

		function scheduleMetrics() {
			var now = Date.now();
			if (now - lastMetricStamp > 80) {
				lastMetricStamp = now;
				applyHeaderMetrics();
			}
		}

		applyHeaderMetrics();
		window.addEventListener('resize', applyHeaderMetrics);
		window.addEventListener('scroll', scheduleMetrics, { passive: true });
	});
})();
