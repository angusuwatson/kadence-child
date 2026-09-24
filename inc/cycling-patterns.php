<?php
/**
 * Cycling itineraries block patterns (EN / FR / NL).
 *
 * Renders the full landing page design as editable Gutenberg blocks.
 * Custom classes are reused from assets/css/cycling-itineraries.css and
 * assets/css/cycling-palette.css so the front-end output is unchanged.
 */

defined( 'ABSPATH' ) || exit;

function lgf_cycling_page_pattern( $lang, $img ) {

	$i18n = [
		'en' => [
			'hero_kicker'    => 'Cycling holidays in southern Burgundy',
			'hero_h1'        => 'Ride slowly.<br><em>Stay beautifully.</em>',
			'hero_intro'     => 'A few days of quiet roads, village cafés and a comfortable base at La Grange Fleurie. Choose your rhythm, download the routes and make southern Burgundy your own.',
			'cta_explore'    => 'Explore the itineraries',
			'cta_plan'       => 'Plan your stay',
			'stamp'          => '<span>01</span><span>Base yourself<br>in Tramayes</span>',
			'intro_kicker'   => 'A better kind of cycling break',
			'intro_h2'       => 'Less luggage.<br>More landscape.',
			'intro_copy'     => 'Leave your bags in one place and ride out each morning from our chambre d’hôtes near Tramayes. These sample itineraries are built around small roads, good food and the kind of views that make you stop without planning to.',
			'note_bold'      => 'Draft routes for discussion.',
			'note'           => 'Distances and GPX files on this page are dummy data and will be replaced with checked local routes.',
			'pick_kicker'    => 'Pick your pace',
			'pick_h2'        => 'Three ways to stay',
			'pick_copy'      => 'Every plan starts and finishes at La Grange Fleurie. Add nights, swap a ride for a rest day, or ask us to shape a week around your legs.',
			'stat_distance'  => 'total distance',
			'stat_climbing'  => 'total climbing',
			'see_plan'       => 'See the plan',
			'details_kick'   => 'A week at a glance',
			'details_h2'     => 'Routes with room<br>to breathe',
			'details_copy'   => 'Illustrative schedule only. On booking, we will confirm route conditions, seasonal stops and the best order for the weather.',
			'nights'         => 'nights',
			'download'       => 'Download sample GPX',
			'why_kicker'     => 'Why stay with us?',
			'why_h2'         => 'Ride out<br>from home.',
			'perk_1_t'       => 'One calm base',
			'perk_1_d'       => 'Unpack once, then start each ride from the front door.',
			'perk_2_t'       => 'Local knowledge',
			'perk_2_d'       => 'We can point you towards the best café, climb or shortcut that day.',
			'perk_3_t'       => 'Proper recovery',
			'perk_3_d'       => 'A quiet room, a generous breakfast and space to let the legs recover.',
			'book_kicker'    => 'Ready when you are',
			'book_h2'        => 'Bring your bike.<br>We’ll take care of the rest.',
			'book_copy'      => 'Tell us how many nights you are thinking about and what kind of riding you enjoy. We’ll help turn this draft into your perfect stay.',
			'book_cta'       => 'Check availability',
		],
		'fr' => [
			'hero_kicker'    => 'Séjours à vélo en Bourgogne du Sud',
			'hero_h1'        => 'Roulez doucement.<br><em>Séjournez en beauté.</em>',
			'hero_intro'     => 'Quelques jours de petites routes tranquilles, de cafés de village et une base confortable à La Grange Fleurie. Choisissez votre rythme, téléchargez les itinéraires et faites de la Bourgogne du Sud votre terrain de jeu.',
			'cta_explore'    => 'Découvrir les séjours',
			'cta_plan'       => 'Préparer votre séjour',
			'stamp'          => '<span>01</span><span>Installez-vous<br>à Tramayes</span>',
			'intro_kicker'   => 'Une pause à vélo, autrement',
			'intro_h2'       => 'Moins de bagages.<br>Plus de paysages.',
			'intro_copy'     => 'Laissez vos bagages au même endroit et partez chaque matin de notre chambre d’hôtes près de Tramayes. Ces séjours d’exemple empruntent de petites routes, de bonnes tables et des points de vue qui donnent envie de s’arrêter sans l’avoir prévu.',
			'note_bold'      => 'Itinéraires de démonstration.',
			'note'           => 'Les distances et les fichiers GPX de cette page sont des données fictives et seront remplacés par de véritables parcours vérifiés.',
			'pick_kicker'    => 'Choisissez votre rythme',
			'pick_h2'        => 'Trois façons de séjourner',
			'pick_copy'      => 'Chaque séjour commence et se termine à La Grange Fleurie. Ajoutez des nuits, échangez une sortie contre une journée de repos, ou laissez-nous façonner une semaine à la hauteur de vos jambes.',
			'stat_distance'  => 'distance totale',
			'stat_climbing'  => 'dénivelé total',
			'see_plan'       => 'Voir le programme',
			'details_kick'   => 'La semaine en un coup d’œil',
			'details_h2'     => 'Des itinéraires<br>qui respirent',
			'details_copy'   => 'Programme indicatif uniquement. Lors de la réservation, nous confirmerons l’état des routes, les haltes de saison et le meilleur ordre selon la météo.',
			'nights'         => 'nuits',
			'download'       => 'Télécharger un GPX d’exemple',
			'why_kicker'     => 'Pourquoi séjourner chez nous ?',
			'why_h2'         => 'Partez à vélo<br>depuis la porte.',
			'perk_1_t'       => 'Une base calme',
			'perk_1_d'       => 'Défaites vos bagages une fois pour toutes, puis partez de la porte.',
			'perk_2_t'       => 'Des conseils locaux',
			'perk_2_d'       => 'Le meilleur café, la meilleure montée ou le raccourci du jour : nous connaissons.',
			'perk_3_t'       => 'Une vraie récupération',
			'perk_3_d'       => 'Une chambre calme, un petit-déjeuner copieux et de quoi laisser récupérer les jambes.',
			'book_kicker'    => 'Prêt·te quand vous voulez',
			'book_h2'        => 'Amenez votre vélo.<br>On s’occupe du reste.',
			'book_copy'      => 'Dites-nous le nombre de nuits que vous envisagez et le type de cyclisme que vous aimez. Nous vous aiderons à transformer ce brouillon en séjour parfait.',
			'book_cta'       => 'Vérifier les disponibilités',
		],
		'nl' => [
			'hero_kicker'    => 'Fietsvakanties in Zuid-Bourgondië',
			'hero_h1'        => 'Rustig fietsen.<br><em>Prachtig verblijven.</em>',
			'hero_intro'     => 'Een paar dagen over stille wegen, langs dorpscafés, met een comfortabele uitvalsbasis in La Grange Fleurie. Kies uw eigen tempo, download de routes en maak van Zuid-Bourgondië uw eigen plek.',
			'cta_explore'    => 'Bekijk de fietsvakanties',
			'cta_plan'       => 'Plan uw verblijf',
			'stamp'          => '<span>01</span><span>Thuisbasis<br>in Tramayes</span>',
			'intro_kicker'   => 'Fietsvakantie, maar dan anders',
			'intro_h2'       => 'Minder bagage.<br>Meer landschap.',
			'intro_copy'     => 'Laat uw bagage op één plek en trek elke ochtend vanuit onze chambre d’hôtes bij Tramayes op pad. Deze voorbeeldroutes gaan over kleine wegen, langs goed eten en uitzichten waar u zonder plan vanzelf stopt.',
			'note_bold'      => 'Voorbeeldroutes ter bespreking.',
			'note'           => 'De afstanden en GPX-bestanden op deze pagina zijn dummygegevens en worden vervangen door gecontroleerde lokale routes.',
			'pick_kicker'    => 'Kies uw tempo',
			'pick_h2'        => 'Drie manieren om te verblijven',
			'pick_copy'      => 'Elke vakantie begint en eindigt bij La Grange Fleurie. Voeg nachten toe, ruil een rit in voor een rustdag of laat ons een week maken die past bij uw benen.',
			'stat_distance'  => 'totale afstand',
			'stat_climbing'  => 'totale hoogtemeters',
			'see_plan'       => 'Bekijk het plan',
			'details_kick'   => 'De week in één oogopslag',
			'details_h2'     => 'Routes met ruimte<br>om te ademen',
			'details_copy'   => 'Alleen een indicatief schema. Bij boeking bevestigen we de staat van de wegen, seizoensgebonden stops en de beste volgorde voor het weer.',
			'nights'         => 'nachten',
			'download'       => 'Download voorbeeld-GPX',
			'why_kicker'     => 'Waarom bij ons verblijven?',
			'why_h2'         => 'Fiets weg<br>vanaf uw deur.',
			'perk_1_t'       => 'Één rustige uitvalsbasis',
			'perk_1_d'       => 'Uitpakken één keer, daarna vertrekt elke rit vanaf de voordeur.',
			'perk_2_t'       => 'Lokale kennis',
			'perk_2_d'       => 'Wij wijzen u het beste café, de mooiste klim of de kortste weg van die dag.',
			'perk_3_t'       => 'Goed herstel',
			'perk_3_d'       => 'Een stille kamer, een ruim ontbijt en ruimte voor uw benen om bij te komen.',
			'book_kicker'    => 'Klaar wanneer u dat bent',
			'book_h2'        => 'Neem uw fiets mee.<br>Wij regelen de rest.',
			'book_copy'      => 'Vertel ons aan hoeveel nachten u denkt en wat voor fietsen u leuk vindt. Wij helpen deze schets om te zetten in uw perfecte verblijf.',
			'book_cta'       => 'Bekijk beschikbaarheid',
		],
	][ $lang ];

	$routes = [
		'en' => [
			[
				'number' => '01', 'nights' => '03', 'eyebrow' => '3 nights', 'title' => 'The first taste',
				'desc'   => 'A gentle introduction to the quiet lanes, golden villages and rolling hills around La Grange Fleurie.',
				'dist'   => '126 km', 'climb' => '1,480 m', 'rides' => '2 rides + arrival day', 'tag' => 'Best for a long weekend',
				'days'   => [
					[ 'Arrival & settle in', 'Welcome drink, bike check and local supper suggestions.' ],
					[ 'Cluny and the greenway', '62 km · 540 m climbing · easy / moderate' ],
					[ 'Château country loop', '64 km · 940 m climbing · moderate' ],
				],
				'file'   => 'draft-cluny-loop.gpx',
			],
			[
				'number' => '02', 'nights' => '05', 'eyebrow' => '5 nights', 'title' => 'The good week',
				'desc'   => 'Enough time to settle into the rhythm: two scenic loops, a longer challenge and a day to explore on foot.',
				'dist'   => '238 km', 'climb' => '3,120 m', 'rides' => '3 rides + 1 rest day', 'tag' => 'Our most popular format',
				'days'   => [
					[ 'Arrival & settle in', 'Welcome drink, bike check and local supper suggestions.' ],
					[ 'Cluny and the greenway', '62 km · 540 m climbing · easy / moderate' ],
					[ 'Morning market, afternoon rest', 'A shorter 34 km loop · cafés and village wandering.' ],
					[ 'The Beaujolais foothills', '88 km · 1,420 m climbing · challenging' ],
					[ 'Château country loop', '54 km · 760 m climbing · moderate' ],
				],
				'file'   => 'draft-beaujolais-foothills.gpx',
			],
			[
				'number' => '03', 'nights' => '07', 'eyebrow' => '7 nights', 'title' => 'The full escape',
				'desc'   => 'A complete week of cycling in southern Burgundy, with room for the best climbs, markets, villages and long lunches.',
				'dist'   => '342 km', 'climb' => '4,760 m', 'rides' => '5 rides + 1 rest day', 'tag' => 'For curious, confident riders',
				'days'   => [
					[ 'Arrival & settle in', 'Welcome drink, bike check and local supper suggestions.' ],
					[ 'Cluny and the greenway', '62 km · 540 m climbing · easy / moderate' ],
					[ 'Two valleys, one long lunch', '78 km · 1,160 m climbing · moderate' ],
					[ 'Rest day in the Mâconnais', 'Market morning, vineyard views and no cycling required.' ],
					[ 'The Beaujolais foothills', '88 km · 1,420 m climbing · challenging' ],
					[ 'Château country loop', '54 km · 760 m climbing · moderate' ],
				],
				'file'   => 'draft-full-escape.gpx',
			],
		],
		'fr' => [
			[
				'number' => '01', 'nights' => '03', 'eyebrow' => '3 nuits', 'title' => 'Premier contact',
				'desc'   => 'Une introduction en douceur aux petites routes tranquilles, aux villages dorés et aux collines vallonnées autour de La Grange Fleurie.',
				'dist'   => '126 km', 'climb' => '1 480 m', 'rides' => '2 sorties + jour d’arrivée', 'tag' => 'Idéal pour un long week-end',
				'days'   => [
					[ 'Arrivée et installation', 'Coupé de bienvenue, vérification du vélo et suggestions de dîner local.' ],
					[ 'Cluny et la voie verte', '62 km · 540 m de dénivelé · facile / modéré' ],
					[ 'Boucle des châteaux', '64 km · 940 m de dénivelé · modéré' ],
				],
				'file'   => 'draft-cluny-loop.gpx',
			],
			[
				'number' => '02', 'nights' => '05', 'eyebrow' => '5 nuits', 'title' => 'La belle semaine',
				'desc'   => 'Le temps de trouver le rythme : deux boucles de caractère, une sortie plus longue et une journée à explorer à pied.',
				'dist'   => '238 km', 'climb' => '3 120 m', 'rides' => '3 sorties + 1 jour de repos', 'tag' => 'Notre formule la plus populaire',
				'days'   => [
					[ 'Arrivée et installation', 'Coupé de bienvenue, vérification du vélo et suggestions de dîner local.' ],
					[ 'Cluny et la voie verte', '62 km · 540 m de dénivelé · facile / modéré' ],
					[ 'Marché le matin, repos l’après-midi', 'Une petite boucle de 34 km · cafés et flâneries de village.' ],
					[ 'Les contreforts du Beaujolais', '88 km · 1 420 m de dénivelé · exigeant' ],
					[ 'Boucle des châteaux', '54 km · 760 m de dénivelé · modéré' ],
				],
				'file'   => 'draft-beaujolais-foothills.gpx',
			],
			[
				'number' => '03', 'nights' => '07', 'eyebrow' => '7 nuits', 'title' => 'L’évasion complète',
				'desc'   => 'Une semaine entière de cyclisme en Bourgogne du Sud, avec la place pour les plus beaux cols, les marchés, les villages et les longs déjeuners.',
				'dist'   => '342 km', 'climb' => '4 760 m', 'rides' => '5 sorties + 1 jour de repos', 'tag' => 'Pour les cyclistes curieux et assurés',
				'days'   => [
					[ 'Arrivée et installation', 'Coupé de bienvenue, vérification du vélo et suggestions de dîner local.' ],
					[ 'Cluny et la voie verte', '62 km · 540 m de dénivelé · facile / modéré' ],
					[ 'Deux vallées, un long déjeuner', '78 km · 1 160 m de dénivelé · modéré' ],
					[ 'Journée de repos dans le Mâconnais', 'Marché le matin, vues sur les vignes et pas de vélo au programme.' ],
					[ 'Les contreforts du Beaujolais', '88 km · 1 420 m de dénivelé · exigeant' ],
					[ 'Boucle des châteaux', '54 km · 760 m de dénivelé · modéré' ],
				],
				'file'   => 'draft-full-escape.gpx',
			],
		],
		'nl' => [
			[
				'number' => '01', 'nights' => '03', 'eyebrow' => '3 nachten', 'title' => 'Eerste indruk',
				'desc'   => 'Een rustige kennismaking met de stille wegen, gouden dorpen en glooiende heuvels rond La Grange Fleurie.',
				'dist'   => '126 km', 'climb' => '1.480 m', 'rides' => '2 ritten + aankomstdag', 'tag' => 'Perfect voor een lang weekend',
				'days'   => [
					[ 'Aankomst en inschikken', 'Welkomstdrankje, fietscheck en suggesties voor een lokale maaltijd.' ],
					[ 'Cluny en de groene weg', '62 km · 540 hoogtemeters · makkelijk / gemiddeld' ],
					[ 'Kastelenrondje', '64 km · 940 hoogtemeters · gemiddeld' ],
				],
				'file'   => 'draft-cluny-loop.gpx',
			],
			[
				'number' => '02', 'nights' => '05', 'eyebrow' => '5 nachten', 'title' => 'De goede week',
				'desc'   => 'Genoeg tijd om in het ritme te komen: twee mooie rondes, een langere uitdaging en een dag te voet op verkenning.',
				'dist'   => '238 km', 'climb' => '3.120 m', 'rides' => '3 ritten + 1 rustdag', 'tag' => 'Onze populairste formule',
				'days'   => [
					[ 'Aankomst en inschikken', 'Welkomstdrankje, fietscheck en suggesties voor een lokale maaltijd.' ],
					[ 'Cluny en de groene weg', '62 km · 540 hoogtemeters · makkelijk / gemiddeld' ],
					[ 'Ochtendmarkt, middag rust', 'Een korter rondje van 34 km · cafés en dorpjes slenteren.' ],
					[ 'De heuvels van de Beaujolais', '88 km · 1.420 hoogtemeters · pittig' ],
					[ 'Kastelenrondje', '54 km · 760 hoogtemeters · gemiddeld' ],
				],
				'file'   => 'draft-beaujolais-foothills.gpx',
			],
			[
				'number' => '03', 'nights' => '07', 'eyebrow' => '7 nachten', 'title' => 'De complete ontsnapping',
				'desc'   => 'Een hele week fietsen in Zuid-Bourgondië, met ruimte voor de mooiste klimmen, markten, dorpen en lange lunches.',
				'dist'   => '342 km', 'climb' => '4.760 m', 'rides' => '5 ritten + 1 rustdag', 'tag' => 'Voor nieuwsgierige, sterke fietsers',
				'days'   => [
					[ 'Aankomst en inschikken', 'Welkomstdrankje, fietscheck en suggesties voor een lokale maaltijd.' ],
					[ 'Cluny en de groene weg', '62 km · 540 hoogtemeters · makkelijk / gemiddeld' ],
					[ 'Twee dalen, een lange lunch', '78 km · 1.160 hoogtemeters · gemiddeld' ],
					[ 'Rustdag in de Mâconnais', 'Markt in de ochtend, uitzicht op wijngaarden en geen fiets nodig.' ],
					[ 'De heuvels van de Beaujolais', '88 km · 1.420 hoogtemeters · pittig' ],
					[ 'Kastelenrondje', '54 km · 760 hoogtemeters · gemiddeld' ],
				],
				'file'   => 'draft-full-escape.gpx',
			],
		],
	][ $lang ];

	$hero_bg = 'url(&#39;' . esc_url( $img ) . '&#39;) center/cover';

	$html  = '<!-- wp:group {"className":"lgf-cycling-page","layout":{"type":"constrained"}} -->' . "\n";
	$html .= '<div class="wp-block-group lgf-cycling-page">' . "\n";

	/* Hero */
	$html .= '<!-- wp:group {"className":"lgf-cycling-hero","layout":{"type":"constrained"}} -->' . "\n";
	$html .= '<div class="wp-block-group lgf-cycling-hero">' . "\n";
	$html .= '<!-- wp:html -->' . "\n" . '<div class="lgf-cycling-hero__texture" aria-hidden="true"></div>' . "\n" . '<!-- /wp:html -->' . "\n";
	$html .= '<!-- wp:group {"className":"lgf-cycling-hero__content lgf-cycling-shell","layout":{"type":"constrained"}} -->' . "\n";
	$html .= '<div class="wp-block-group lgf-cycling-hero__content lgf-cycling-shell">' . "\n";
	$html .= '<!-- wp:paragraph {"fontSize":"small","className":"lgf-cycling-kicker"} -->' . "\n";
	$html .= '<p class="lgf-cycling-kicker has-small-font-size">' . $i18n['hero_kicker'] . '</p>' . "\n";
	$html .= '<!-- /wp:paragraph -->' . "\n";
	$html .= '<!-- wp:heading {"level":1} -->' . "\n";
	$html .= '<h1>' . $i18n['hero_h1'] . '</h1>' . "\n";
	$html .= '<!-- /wp:heading -->' . "\n";
	$html .= '<!-- wp:paragraph {"className":"lgf-cycling-hero__intro"} -->' . "\n";
	$html .= '<p class="lgf-cycling-hero__intro">' . $i18n['hero_intro'] . '</p>' . "\n";
	$html .= '<!-- /wp:paragraph -->' . "\n";
	$html .= '<!-- wp:group {"className":"lgf-cycling-hero__actions","layout":{"type":"flex","flexWrap":"nowrap"}} -->' . "\n";
	$html .= '<div class="wp-block-group lgf-cycling-hero__actions">' . "\n";
	$html .= '<!-- wp:paragraph {"className":"lgf-cycling-button lgf-cycling-button--light"} -->' . "\n";
	$html .= '<p class="lgf-cycling-button lgf-cycling-button--light"><a href="#itineraries">' . $i18n['cta_explore'] . ' <span aria-hidden="true">↓</span></a></p>' . "\n";
	$html .= '<!-- /wp:paragraph -->' . "\n";
	$html .= '<!-- wp:paragraph {"className":"lgf-cycling-text-link"} -->' . "\n";
	$html .= '<p class="lgf-cycling-text-link"><a href="#booking">' . $i18n['cta_plan'] . ' <span aria-hidden="true">↗</span></a></p>' . "\n";
	$html .= '<!-- /wp:paragraph -->' . "\n";
	$html .= '</div>' . "\n";
	$html .= '<!-- /wp:group -->' . "\n";
	$html .= '<!-- wp:html -->' . "\n" . '<div class="lgf-cycling-hero__stamp" aria-hidden="true">' . $i18n['stamp'] . '</div>' . "\n" . '<!-- /wp:html -->' . "\n";
	$html .= '</div>' . "\n";
	$html .= '<!-- /wp:group -->' . "\n";
	$html .= '</div>' . "\n";
	$html .= '<!-- /wp:group -->' . "\n";

	/* Intro */
	$html .= '<!-- wp:group {"className":"lgf-cycling-intro lgf-cycling-shell","layout":{"type":"default"}} -->' . "\n";
	$html .= '<div class="wp-block-group lgf-cycling-intro lgf-cycling-shell">' . "\n";
	$html .= '<!-- wp:columns {"className":""} -->' . "\n";
	$html .= '<div class="wp-block-columns">' . "\n";
	$html .= '<!-- wp:column -->' . "\n" . '<div class="wp-block-column">' . "\n";
	$html .= '<!-- wp:paragraph {"className":"lgf-cycling-kicker"} -->' . "\n" . '<p class="lgf-cycling-kicker">' . $i18n['intro_kicker'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
	$html .= '<!-- wp:heading {"level":2} -->' . "\n" . '<h2>' . $i18n['intro_h2'] . '</h2>' . "\n" . '<!-- /wp:heading -->' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:column -->' . "\n";
	$html .= '<!-- wp:column -->' . "\n" . '<div class="wp-block-column">' . "\n";
	$html .= '<!-- wp:paragraph {"className":"lgf-cycling-intro__copy"} -->' . "\n" . '<p class="lgf-cycling-intro__copy">' . $i18n['intro_copy'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
	$html .= '<!-- wp:paragraph {"className":"lgf-cycling-note"} -->' . "\n" . '<p class="lgf-cycling-note"><span aria-hidden="true">✳</span> <strong>' . $i18n['note_bold'] . '</strong> ' . $i18n['note'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:column -->' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:columns -->' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";

	/* Itineraries */
	$html .= '<!-- wp:group {"className":"lgf-cycling-itineraries","layout":{"type":"constrained"}} -->' . "\n";
	$html .= '<div class="wp-block-group lgf-cycling-itineraries" id="itineraries">' . "\n";
	$html .= '<!-- wp:group {"className":"lgf-cycling-shell","layout":{"type":"constrained"}} -->' . "\n";
	$html .= '<div class="wp-block-group lgf-cycling-shell">' . "\n";
	$html .= '<!-- wp:group {"className":"lgf-cycling-section-heading","layout":{"type":"flex","justifyContent":"space-between"}} -->' . "\n";
	$html .= '<div class="wp-block-group lgf-cycling-section-heading">' . "\n";
	$html .= '<div class="wp-block-group">' . "\n";
	$html .= '<!-- wp:paragraph {"className":"lgf-cycling-kicker"} -->' . "\n" . '<p class="lgf-cycling-kicker">' . $i18n['pick_kicker'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
	$html .= '<!-- wp:heading {"level":2} -->' . "\n" . '<h2>' . $i18n['pick_h2'] . '</h2>' . "\n" . '<!-- /wp:heading -->' . "\n";
	$html .= '</div>' . "\n";
	$html .= '<!-- wp:paragraph {} -->' . "\n" . '<p>' . $i18n['pick_copy'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";
	$html .= '<!-- wp:columns {"className":"lgf-cycling-route-grid"} -->' . "\n";
	$html .= '<div class="wp-block-columns lgf-cycling-route-grid">' . "\n";

	foreach ( $routes as $route ) {
		$html .= '<!-- wp:column {"className":"lgf-cycling-route-card"} -->' . "\n";
		$html .= '<div class="wp-block-column lgf-cycling-route-card">' . "\n";
		$html .= '<!-- wp:group {"className":"lgf-cycling-route-card__top","layout":{"type":"flex","justifyContent":"space-between"}} -->' . "\n";
		$html .= '<div class="wp-block-group lgf-cycling-route-card__top">' . "\n";
		$html .= '<!-- wp:paragraph {"className":"lgf-cycling-route-card__number"} -->' . "\n" . '<p class="lgf-cycling-route-card__number">' . $route['number'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
		$html .= '<!-- wp:paragraph {"className":"lgf-cycling-route-card__tag"} -->' . "\n" . '<p class="lgf-cycling-route-card__tag">' . $route['tag'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
		$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";
		$html .= '<!-- wp:paragraph {"className":"lgf-cycling-kicker"} -->' . "\n" . '<p class="lgf-cycling-kicker">' . $route['eyebrow'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
		$html .= '<!-- wp:heading {"level":3} -->' . "\n" . '<h3>' . $route['title'] . '</h3>' . "\n" . '<!-- /wp:heading -->' . "\n";
		$html .= '<!-- wp:paragraph {"className":""} -->' . "\n" . '<p>' . $route['desc'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
		$html .= '<!-- wp:group {"className":"lgf-cycling-route-card__stats","layout":{"type":"flex"}} -->' . "\n";
		$html .= '<div class="wp-block-group lgf-cycling-route-card__stats">' . "\n";
		$html .= '<div class="wp-block-group"><p><strong>' . $route['dist'] . '</strong> <span>' . $i18n['stat_distance'] . '</span></p></div>' . "\n";
		$html .= '<div class="wp-block-group"><p><strong>' . $route['climb'] . '</strong> <span>' . $i18n['stat_climbing'] . '</span></p></div>' . "\n";
		$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";
		$html .= '<!-- wp:group {"className":"lgf-cycling-route-card__footer","layout":{"type":"flex","justifyContent":"space-between"}} -->' . "\n";
		$html .= '<div class="wp-block-group lgf-cycling-route-card__footer">' . "\n";
		$html .= '<!-- wp:paragraph {"className":""} -->' . "\n" . '<p>' . $route['rides'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
		$html .= '<!-- wp:paragraph {"className":""} -->' . "\n" . '<p><a href="#details-' . $route['number'] . '">' . $i18n['see_plan'] . ' <span aria-hidden="true">↗</span></a></p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
		$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";
		$html .= '</div>' . "\n" . '<!-- /wp:column -->' . "\n";
	}

	$html .= '</div>' . "\n" . '<!-- /wp:columns -->' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";

	/* Details / plans */
	$html .= '<!-- wp:group {"className":"lgf-cycling-details lgf-cycling-shell","layout":{"type":"constrained"}} -->' . "\n";
	$html .= '<div class="wp-block-group lgf-cycling-details lgf-cycling-shell">' . "\n";
	$html .= '<!-- wp:group {"className":"lgf-cycling-section-heading","layout":{"type":"flex","justifyContent":"space-between"}} -->' . "\n";
	$html .= '<div class="wp-block-group lgf-cycling-section-heading">' . "\n";
	$html .= '<div class="wp-block-group">' . "\n";
	$html .= '<!-- wp:paragraph {"className":"lgf-cycling-kicker"} -->' . "\n" . '<p class="lgf-cycling-kicker">' . $i18n['details_kick'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
	$html .= '<!-- wp:heading {"level":2} -->' . "\n" . '<h2>' . $i18n['details_h2'] . '</h2>' . "\n" . '<!-- /wp:heading -->' . "\n";
	$html .= '</div>' . "\n";
	$html .= '<!-- wp:paragraph {} -->' . "\n" . '<p>' . $i18n['details_copy'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";

	foreach ( $routes as $route ) {
		$html .= '<!-- wp:group {"className":"lgf-cycling-plan","layout":{"type":"default"}} -->' . "\n";
		$html .= '<div class="wp-block-group lgf-cycling-plan" id="details-' . $route['number'] . '">' . "\n";
		$html .= '<!-- wp:columns {"className":""} -->' . "\n" . '<div class="wp-block-columns">' . "\n";
		$html .= '<!-- wp:column {"className":"lgf-cycling-plan__label"} -->' . "\n" . '<div class="wp-block-column lgf-cycling-plan__label">' . "\n";
		$html .= '<!-- wp:paragraph {"className":""} -->' . "\n" . '<p><strong>' . $route['nights'] . '</strong><br>' . $i18n['nights'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
		$html .= '</div>' . "\n" . '<!-- /wp:column -->' . "\n";
		$html .= '<!-- wp:column {"className":"lgf-cycling-plan__body"} -->' . "\n" . '<div class="wp-block-column lgf-cycling-plan__body">' . "\n";
		$html .= '<!-- wp:heading {"level":3} -->' . "\n" . '<h3>' . $route['title'] . '</h3>' . "\n" . '<!-- /wp:heading -->' . "\n";
		$html .= '<!-- wp:columns -->' . "\n" . '<div class="wp-block-columns">' . "\n";
		$col_count = count( $route['days'] );

		for ( $i = 0; $i < $col_count; $i++ ) {
			if ( 0 === $i % 2 ) {
				$html .= '</div>' . "\n" . '<!-- /wp:column -->' . "\n" . '<!-- wp:column -->' . "\n" . '<div class="wp-block-column">' . "\n";
			}
			$day_no = sprintf( '%02d', $i + 1 );
			$html  .= '<!-- wp:paragraph {"className":"lgf-cycling-plan__day"} -->' . "\n";
			$html  .= '<p class="lgf-cycling-plan__day"><span>Day ' . $day_no . '</span><strong>' . $route['days'][ $i ][0] . '</strong><small>' . $route['days'][ $i ][1] . '</small></p>' . "\n";
			$html  .= '<!-- /wp:paragraph -->' . "\n";
		}

		$html .= '</div>' . "\n" . '<!-- /wp:column -->' . "\n" . '</div>' . "\n" . '<!-- /wp:columns -->' . "\n";
		$html .= '</div>' . "\n" . '<!-- /wp:column -->' . "\n" . '</div>' . "\n" . '<!-- /wp:columns -->' . "\n";
		$html .= '<!-- wp:paragraph {"className":"lgf-cycling-download"} -->' . "\n" . '<p class="lgf-cycling-download"><a href="' . esc_url( get_stylesheet_directory_uri() . '/assets/routes/' . $route['file'] ) . '" download>' . $i18n['download'] . ' <span aria-hidden="true">↓</span></a></p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
		$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";
	}

	$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";

	/* Why us */
	$html .= '<!-- wp:group {"className":"lgf-cycling-why","layout":{"type":"constrained"}} -->' . "\n";
	$html .= '<div class="wp-block-group lgf-cycling-why">' . "\n";
	$html .= '<!-- wp:group {"className":"lgf-cycling-shell lgf-cycling-why__grid","layout":{"type":"default"}} -->' . "\n";
	$html .= '<div class="wp-block-group lgf-cycling-shell lgf-cycling-why__grid">' . "\n";
	$html .= '<!-- wp:columns {"className":""} -->' . "\n" . '<div class="wp-block-columns">' . "\n";
	$html .= '<!-- wp:column -->' . "\n" . '<div class="wp-block-column">' . "\n";
	$html .= '<!-- wp:paragraph {"className":"lgf-cycling-kicker"} -->' . "\n" . '<p class="lgf-cycling-kicker">' . $i18n['why_kicker'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
	$html .= '<!-- wp:heading {"level":2} -->' . "\n" . '<h2>' . $i18n['why_h2'] . '</h2>' . "\n" . '<!-- /wp:heading -->' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:column -->' . "\n";
	$html .= '<!-- wp:column -->' . "\n" . '<div class="wp-block-column">' . "\n";
	$html .= '<!-- wp:group {"className":"lgf-cycling-perks","layout":{"type":"grid","columnCount":2}} -->' . "\n";
	$html .= '<div class="wp-block-group lgf-cycling-perks">' . "\n";
	$html .= '<div class="wp-block-group"><span>01</span><h3>' . $i18n['perk_1_t'] . '</h3><p>' . $i18n['perk_1_d'] . '</p></div>' . "\n";
	$html .= '<div class="wp-block-group"><span>02</span><h3>' . $i18n['perk_2_t'] . '</h3><p>' . $i18n['perk_2_d'] . '</p></div>' . "\n";
	$html .= '<div class="wp-block-group"><span>03</span><h3>' . $i18n['perk_3_t'] . '</h3><p>' . $i18n['perk_3_d'] . '</p></div>' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:column -->' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:columns -->' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";

	/* Booking */
	$html .= '<!-- wp:group {"className":"lgf-cycling-booking lgf-cycling-shell","layout":{"type":"constrained"}} -->' . "\n";
	$html .= '<div class="wp-block-group lgf-cycling-booking">' . "\n";
	$html .= '<!-- wp:group {"className":"lgf-cycling-booking__inner","layout":{"type":"constrained"}} -->' . "\n";
	$html .= '<div class="wp-block-group lgf-cycling-booking__inner">' . "\n";
	$html .= '<!-- wp:paragraph {"className":"lgf-cycling-kicker"} -->' . "\n" . '<p class="lgf-cycling-kicker">' . $i18n['book_kicker'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
	$html .= '<!-- wp:heading {"level":2} -->' . "\n" . '<h2>' . $i18n['book_h2'] . '</h2>' . "\n" . '<!-- /wp:heading -->' . "\n";
	$html .= '<!-- wp:paragraph {"className":""} -->' . "\n" . '<p>' . $i18n['book_copy'] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
	$html .= '<!-- wp:paragraph {"className":"lgf-cycling-button lgf-cycling-button--dark"} -->' . "\n" . '<p class="lgf-cycling-button lgf-cycling-button--dark"><a href="/booking/">' . $i18n['book_cta'] . ' <span aria-hidden="true">↗</span></a></p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";
	$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";

	$html .= '</div>' . "\n" . '<!-- /wp:group -->' . "\n";

	return $html;
}

function lgf_register_cycling_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	$img = '/wp-content/uploads/2019/06/la-grange-fleurie-cluny07-scaled-2.jpg';

	register_block_pattern(
		'lgf/cycling-itineraries-en',
		array(
			'title'       => 'Cycling Holidays — Southern Burgundy (EN)',
			'description' => 'Full cycling itinerary landing page, English.',
			'categories'  => array( 'layout' ),
			'content'     => lgf_cycling_page_pattern( 'en', $img ),
		)
	);
	register_block_pattern(
		'lgf/cycling-itineraries-fr',
		array(
			'title'       => 'Cycling Holidays — Southern Burgundy (FR)',
			'description' => 'Full cycling itinerary landing page, French.',
			'categories'  => array( 'layout' ),
			'content'     => lgf_cycling_page_pattern( 'fr', $img ),
		)
	);
	register_block_pattern(
		'lgf/cycling-itineraries-nl',
		array(
			'title'       => 'Cycling Holidays — Southern Burgundy (NL)',
			'description' => 'Full cycling itinerary landing page, Dutch.',
			'categories'  => array( 'layout' ),
			'content'     => lgf_cycling_page_pattern( 'nl', $img ),
		)
	);
}
add_action( 'init', 'lgf_register_cycling_patterns' );