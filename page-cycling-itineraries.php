<?php
/**
 * Template Name: Cycling Itineraries Draft
 * Description: Public cycling holiday itinerary concept page.
 */

defined( 'ABSPATH' ) || exit;

get_header();

$theme_uri = get_stylesheet_directory_uri();
$lang      = 'en';

if ( is_singular() ) {
	$slug = get_post_field( 'post_name', get_the_ID() );

	if ( false !== stripos( $slug, 'fiets' ) ) {
		$lang = 'nl';
	} elseif ( false !== stripos( $slug, 'sejour' ) || false !== stripos( $slug, 'cycliste' ) ) {
		$lang = 'fr';
	}
}

$i18n = [
	'en' => [
		'hero_kicker'     => 'Cycling holidays in southern Burgundy',
		'hero_title_1'    => 'Ride slowly.',
		'hero_title_2'    => 'Stay beautifully.',
		'hero_intro'      => 'A few days of quiet roads, village cafés and a comfortable base at La Grange Fleurie. Choose your rhythm, download the routes and make southern Burgundy your own.',
		'cta_explore'     => 'Explore the itineraries',
		'cta_plan'        => 'Plan your stay',
		'stamp'           => "Base yourself\nin Tramayes",
		'intro_kicker'    => 'A better kind of cycling break',
		'intro_title_1'   => 'Less luggage.',
		'intro_title_2'   => 'More landscape.',
		'intro_copy'      => 'Leave your bags in one place and ride out each morning from our chambre d’hôtes near Tramayes. These sample itineraries are built around small roads, good food and the kind of views that make you stop without planning to.',
		'note_bold'       => 'Draft routes for discussion.',
		'note'            => 'Distances and GPX files on this page are dummy data and will be replaced with checked local routes.',
		'pick_kicker'     => 'Pick your pace',
		'pick_title'      => 'Three ways to stay',
		'pick_copy'       => 'Every plan starts and finishes at La Grange Fleurie. Add nights, swap a ride for a rest day, or ask us to shape a week around your legs.',
		'stat_distance'   => 'total distance',
		'stat_climbing'   => 'total climbing',
		'see_plan'        => 'See the plan',
		'details_kicker'  => 'A week at a glance',
		'details_title_1' => 'Routes with room',
		'details_title_2' => 'to breathe',
		'details_copy'    => 'Illustrative schedule only. On booking, we will confirm route conditions, seasonal stops and the best order for the weather.',
		'nights'          => 'nights',
		'download'        => 'Download sample GPX',
		'why_kicker'      => 'Why stay with us?',
		'why_title_1'     => 'Ride out',
		'why_title_2'     => 'from home.',
		'perk_1_t'        => 'One calm base',
		'perk_1_d'        => 'Unpack once, then start each ride from the front door.',
		'perk_2_t'        => 'Local knowledge',
		'perk_2_d'        => 'We can point you towards the best café, climb or shortcut that day.',
		'perk_3_t'        => 'Proper recovery',
		'perk_3_d'        => 'A quiet room, a generous breakfast and space to let the legs recover.',
		'book_kicker'     => 'Ready when you are',
		'book_title_1'    => 'Bring your bike.',
		'book_title_2'    => 'We’ll take care of the rest.',
		'book_copy'       => 'Tell us how many nights you are thinking about and what kind of riding you enjoy. We’ll help turn this draft into your perfect stay.',
		'book_cta'        => 'Check availability',
		'book_url'        => '/booking/',
	],
	'fr' => [
		'hero_kicker'     => 'Séjours à vélo en Bourgogne du Sud',
		'hero_title_1'    => 'Roulez doucement.',
		'hero_title_2'    => 'Séjournez en beauté.',
		'hero_intro'      => 'Quelques jours de petites routes tranquilles, de cafés de village et une base confortable à La Grange Fleurie. Choisissez votre rythme, téléchargez les itinéraires et faites de la Bourgogne du Sud votre terrain de jeu.',
		'cta_explore'     => 'Découvrir les séjours',
		'cta_plan'        => 'Préparer votre séjour',
		'stamp'           => "Installez-vous\nà Tramayes",
		'intro_kicker'    => 'Une pause à vélo, autrement',
		'intro_title_1'   => 'Moins de bagages.',
		'intro_title_2'   => 'Plus de paysages.',
		'intro_copy'      => 'Laissez vos bagages au même endroit et partez chaque matin de notre chambre d’hôtes près de Tramayes. Ces séjours d’exemple empruntent de petites routes, de bonnes tables et des points de vue qui donnent envie de s’arrêter sans l’avoir prévu.',
		'note_bold'       => 'Itinéraires de démonstration.',
		'note'            => 'Les distances et les fichiers GPX de cette page sont des données fictives et seront remplacés par de véritables parcours vérifiés.',
		'pick_kicker'     => 'Choisissez votre rythme',
		'pick_title'      => 'Trois façons de séjourner',
		'pick_copy'       => 'Chaque séjour commence et se termine à La Grange Fleurie. Ajoutez des nuits, échangez une sortie contre une journée de repos, ou laissez-nous façonner une semaine à la hauteur de vos jambes.',
		'stat_distance'   => 'distance totale',
		'stat_climbing'   => 'dénivelé total',
		'see_plan'        => 'Voir le programme',
		'details_kicker'  => 'La semaine en un coup d’œil',
		'details_title_1' => 'Des itinéraires',
		'details_title_2' => 'qui respirent',
		'details_copy'    => 'Programme indicatif uniquement. Lors de la réservation, nous confirmerons l’état des routes, les haltes de saison et le meilleur ordre selon la météo.',
		'nights'          => 'nuits',
		'download'        => 'Télécharger un GPX d’exemple',
		'why_kicker'      => 'Pourquoi séjourner chez nous ?',
		'why_title_1'     => 'Partez à vélo',
		'why_title_2'     => 'depuis la porte.',
		'perk_1_t'        => 'Une base calme',
		'perk_1_d'        => 'Défaites vos bagages une fois pour toutes, puis partez de la porte.',
		'perk_2_t'        => 'Des conseils locaux',
		'perk_2_d'        => 'Le meilleur café, la meilleure montée ou le raccourci du jour : nous connaissons.',
		'perk_3_t'        => 'Une vraie récupération',
		'perk_3_d'        => 'Une chambre calme, un petit-déjeuner copieux et de quoi laisser récupérer les jambes.',
		'book_kicker'     => 'Prêt·te quand vous voulez',
		'book_title_1'    => 'Amenez votre vélo.',
		'book_title_2'    => 'On s’occupe du reste.',
		'book_copy'       => 'Dites-nous le nombre de nuits que vous envisagez et le type de cyclisme que vous aimez. Nous vous aiderons à transformer ce brouillon en séjour parfait.',
		'book_cta'        => 'Vérifier les disponibilités',
		'book_url'        => '/booking/',
	],
	'nl' => [
		'hero_kicker'     => 'Fietsvakanties in Zuid-Bourgondië',
		'hero_title_1'    => 'Rustig fietsen.',
		'hero_title_2'    => 'Prachtig verblijven.',
		'hero_intro'      => 'Een paar dagen over stille wegen, langs dorpscafés, met een comfortabele uitvalsbasis in La Grange Fleurie. Kies uw eigen tempo, download de routes en maak van Zuid-Bourgondië uw eigen plek.',
		'cta_explore'     => 'Bekijk de fietsvakanties',
		'cta_plan'        => 'Plan uw verblijf',
		'stamp'           => "Thuisbasis\nin Tramayes",
		'intro_kicker'    => 'Fietsvakantie, maar dan anders',
		'intro_title_1'   => 'Minder bagage.',
		'intro_title_2'   => 'Meer landschap.',
		'intro_copy'      => 'Laat uw bagage op één plek en trek elke ochtend vanuit onze chambre d’hôtes bij Tramayes op pad. Deze voorbeeldroutes gaan over kleine wegen, langs goed eten en uitzichten waar u zonder plan vanzelf stopt.',
		'note_bold'       => 'Voorbeeldroutes ter bespreking.',
		'note'            => 'De afstanden en GPX-bestanden op deze pagina zijn dummygegevens en worden vervangen door gecontroleerde lokale routes.',
		'pick_kicker'     => 'Kies uw tempo',
		'pick_title'      => 'Drie manieren om te verblijven',
		'pick_copy'       => 'Elke vakantie begint en eindigt bij La Grange Fleurie. Voeg nachten toe, ruil een rit in voor een rustdag of laat ons een week maken die past bij uw benen.',
		'stat_distance'   => 'totale afstand',
		'stat_climbing'   => 'totale hoogtemeters',
		'see_plan'        => 'Bekijk het plan',
		'details_kicker'  => 'De week in één oogopslag',
		'details_title_1' => 'Routes met ruimte',
		'details_title_2' => 'om te ademen',
		'details_copy'    => 'Alleen een indicatief schema. Bij boeking bevestigen we de staat van de wegen, seizoensgebonden stops en de beste volgorde voor het weer.',
		'nights'          => 'nachten',
		'download'        => 'Download voorbeeld-GPX',
		'why_kicker'      => 'Waarom bij ons verblijven?',
		'why_title_1'     => 'Fiets weg',
		'why_title_2'     => 'vanaf uw deur.',
		'perk_1_t'        => 'Één rustige uitvalsbasis',
		'perk_1_d'        => 'Uitpakken één keer, daarna vertrekt elke rit vanaf de voordeur.',
		'perk_2_t'        => 'Lokale kennis',
		'perk_2_d'        => 'Wij wijzen u het beste café, de mooiste klim of de kortste weg van die dag.',
		'perk_3_t'        => 'Goed herstel',
		'perk_3_d'        => 'Een stille kamer, een ruim ontbijt en ruimte voor uw benen om bij te komen.',
		'book_kicker'     => 'Klaar wanneer u dat bent',
		'book_title_1'    => 'Neem uw fiets mee.',
		'book_title_2'    => 'Wij regelen de rest.',
		'book_copy'       => 'Vertel ons aan hoeveel nachten u denkt en wat voor fietsen u leuk vindt. Wij helpen deze schets om te zetten in uw perfecte verblijf.',
		'book_cta'        => 'Bekijk beschikbaarheid',
		'book_url'        => '/booking/',
	],
][ $lang ];

$routes = [
	'en' => [
		[
			'number'      => '01',
			'nights'      => '03',
			'eyebrow'     => '3 nights',
			'title'       => 'The first taste',
			'description' => 'A gentle introduction to the quiet lanes, golden villages and rolling hills around La Grange Fleurie.',
			'distance'    => '126 km',
			'elevation'   => '1,480 m',
			'rides'       => '2 rides + arrival day',
			'tag'         => 'Best for a long weekend',
			'details'     => [
				[ "Arrival & settle in", 'Welcome drink, bike check and local supper suggestions.' ],
				[ 'Cluny and the greenway', '62 km · 540 m climbing · easy / moderate' ],
				[ 'Château country loop', '64 km · 940 m climbing · moderate' ],
			],
			'file'        => 'draft-cluny-loop.gpx',
		],
		[
			'number'      => '02',
			'nights'      => '05',
			'eyebrow'     => '5 nights',
			'title'       => 'The good week',
			'description' => 'Enough time to settle into the rhythm: two scenic loops, a longer challenge and a day to explore on foot.',
			'distance'    => '238 km',
			'elevation'   => '3,120 m',
			'rides'       => '3 rides + 1 rest day',
			'tag'         => 'Our most popular format',
			'details'     => [
				[ "Arrival & settle in", 'Welcome drink, bike check and local supper suggestions.' ],
				[ 'Cluny and the greenway', '62 km · 540 m climbing · easy / moderate' ],
				[ 'Morning market, afternoon rest', 'A shorter 34 km loop · cafés and village wandering.' ],
				[ 'The Beaujolais foothills', '88 km · 1,420 m climbing · challenging' ],
				[ 'Château country loop', '54 km · 760 m climbing · moderate' ],
			],
			'file'        => 'draft-beaujolais-foothills.gpx',
		],
		[
			'number'      => '03',
			'nights'      => '07',
			'eyebrow'     => '7 nights',
			'title'       => 'The full escape',
			'description' => 'A complete week of cycling in southern Burgundy, with room for the best climbs, markets, villages and long lunches.',
			'distance'    => '342 km',
			'elevation'   => '4,760 m',
			'rides'       => '5 rides + 1 rest day',
			'tag'         => 'For curious, confident riders',
			'details'     => [
				[ "Arrival & settle in", 'Welcome drink, bike check and local supper suggestions.' ],
				[ 'Cluny and the greenway', '62 km · 540 m climbing · easy / moderate' ],
				[ 'Two valleys, one long lunch', '78 km · 1,160 m climbing · moderate' ],
				[ 'Rest day in the Mâconnais', 'Market morning, vineyard views and no cycling required.' ],
				[ 'The Beaujolais foothills', '88 km · 1,420 m climbing · challenging' ],
				[ 'Château country loop', '54 km · 760 m climbing · moderate' ],
			],
			'file'        => 'draft-full-escape.gpx',
		],
	],
	'fr' => [
		[
			'number'      => '01',
			'nights'      => '03',
			'eyebrow'     => '3 nuits',
			'title'       => 'Premier contact',
			'description' => 'Une introduction en douceur aux petites routes tranquilles, aux villages dorés et aux collines vallonnées autour de La Grange Fleurie.',
			'distance'    => '126 km',
			'elevation'   => '1 480 m',
			'rides'       => '2 sorties + jour d’arrivée',
			'tag'         => 'Idéal pour un long week-end',
			'details'     => [
				[ 'Arrivée et installation', 'Coupé de bienvenue, vérification du vélo et suggestions de dîner local.' ],
				[ 'Cluny et la voie verte', '62 km · 540 m de dénivelé · facile / modéré' ],
				[ 'Boucle des châteaux', '64 km · 940 m de dénivelé · modéré' ],
			],
			'file'        => 'draft-cluny-loop.gpx',
		],
		[
			'number'      => '02',
			'nights'      => '05',
			'eyebrow'     => '5 nuits',
			'title'       => 'La belle semaine',
			'description' => 'Le temps de trouver le rythme : deux boucles de caractère, une sortie plus longue et une journée à explorer à pied.',
			'distance'    => '238 km',
			'elevation'   => '3 120 m',
			'rides'       => '3 sorties + 1 jour de repos',
			'tag'         => 'Notre formule la plus populaire',
			'details'     => [
				[ 'Arrivée et installation', 'Coupé de bienvenue, vérification du vélo et suggestions de dîner local.' ],
				[ 'Cluny et la voie verte', '62 km · 540 m de dénivelé · facile / modéré' ],
				[ 'Marché le matin, repos l’après-midi', 'Une petite boucle de 34 km · cafés et flâneries de village.' ],
				[ 'Les contreforts du Beaujolais', '88 km · 1 420 m de dénivelé · exigeant' ],
				[ 'Boucle des châteaux', '54 km · 760 m de dénivelé · modéré' ],
			],
			'file'        => 'draft-beaujolais-foothills.gpx',
		],
		[
			'number'      => '03',
			'nights'      => '07',
			'eyebrow'     => '7 nuits',
			'title'       => 'L’évasion complète',
			'description' => 'Une semaine entière de cyclisme en Bourgogne du Sud, avec la place pour les plus beaux cols, les marchés, les villages et les longs déjeuners.',
			'distance'    => '342 km',
			'elevation'   => '4 760 m',
			'rides'       => '5 sorties + 1 jour de repos',
			'tag'         => 'Pour les cyclistes curieux et assurés',
			'details'     => [
				[ 'Arrivée et installation', 'Coupé de bienvenue, vérification du vélo et suggestions de dîner local.' ],
				[ 'Cluny et la voie verte', '62 km · 540 m de dénivelé · facile / modéré' ],
				[ 'Deux vallées, un long déjeuner', '78 km · 1 160 m de dénivelé · modéré' ],
				[ 'Journée de repos dans le Mâconnais', 'Marché le matin, vues sur les vignes et pas de vélo au programme.' ],
				[ 'Les contreforts du Beaujolais', '88 km · 1 420 m de dénivelé · exigeant' ],
				[ 'Boucle des châteaux', '54 km · 760 m de dénivelé · modéré' ],
			],
			'file'        => 'draft-full-escape.gpx',
		],
	],
	'nl' => [
		[
			'number'      => '01',
			'nights'      => '03',
			'eyebrow'     => '3 nachten',
			'title'       => 'Eerste indruk',
			'description' => 'Een rustige kennismaking met de stille wegen, gouden dorpen en glooiende heuvels rond La Grange Fleurie.',
			'distance'    => '126 km',
			'elevation'   => '1.480 m',
			'rides'       => '2 ritten + aankomstdag',
			'tag'         => 'Perfect voor een lang weekend',
			'details'     => [
				[ 'Aankomst en inschikken', 'Welkomstdrankje, fietscheck en suggesties voor een lokale maaltijd.' ],
				[ 'Cluny en de groene weg', '62 km · 540 hoogtemeters · makkelijk / gemiddeld' ],
				[ 'Kastelenrondje', '64 km · 940 hoogtemeters · gemiddeld' ],
			],
			'file'        => 'draft-cluny-loop.gpx',
		],
		[
			'number'      => '02',
			'nights'      => '05',
			'eyebrow'     => '5 nachten',
			'title'       => 'De goede week',
			'description' => 'Genoeg tijd om in het ritme te komen: twee mooie rondes, een langere uitdaging en een dag te voet op verkenning.',
			'distance'    => '238 km',
			'elevation'   => '3.120 m',
			'rides'       => '3 ritten + 1 rustdag',
			'tag'         => 'Onze populairste formule',
			'details'     => [
				[ 'Aankomst en inschikken', 'Welkomstdrankje, fietscheck en suggesties voor een lokale maaltijd.' ],
				[ 'Cluny en de groene weg', '62 km · 540 hoogtemeters · makkelijk / gemiddeld' ],
				[ 'Ochtendmarkt, middag rust', 'Een korter rondje van 34 km · cafés en dorpjes slenteren.' ],
				[ 'De heuvels van de Beaujolais', '88 km · 1.420 hoogtemeters · pittig' ],
				[ 'Kastelenrondje', '54 km · 760 hoogtemeters · gemiddeld' ],
			],
			'file'        => 'draft-beaujolais-foothills.gpx',
		],
		[
			'number'      => '03',
			'nights'      => '07',
			'eyebrow'     => '7 nachten',
			'title'       => 'De complete ontsnapping',
			'description' => 'Een hele week fietsen in Zuid-Bourgondië, met ruimte voor de mooiste klimmen, markten, dorpen en lange lunches.',
			'distance'    => '342 km',
			'elevation'   => '4.760 m',
			'rides'       => '5 ritten + 1 rustdag',
			'tag'         => 'Voor nieuwsgierige, sterke fietsers',
			'details'     => [
				[ 'Aankomst en inschikken', 'Welkomstdrankje, fietscheck en suggesties voor een lokale maaltijd.' ],
				[ 'Cluny en de groene weg', '62 km · 540 hoogtemeters · makkelijk / gemiddeld' ],
				[ 'Twee dalen, een lange lunch', '78 km · 1.160 hoogtemeters · gemiddeld' ],
				[ 'Rustdag in de Mâconnais', 'Markt in de ochtend, uitzicht op wijngaarden en geen fiets nodig.' ],
				[ 'De heuvels van de Beaujolais', '88 km · 1.420 hoogtemeters · pittig' ],
				[ 'Kastelenrondje', '54 km · 760 hoogtemeters · gemiddeld' ],
			],
			'file'        => 'draft-full-escape.gpx',
		],
	],
];
?>
<main class="lgf-cycling-page">
	<section class="lgf-cycling-hero">
		<div class="lgf-cycling-hero__texture" aria-hidden="true"></div>
		<div class="lgf-cycling-shell lgf-cycling-hero__content">
			<p class="lgf-cycling-kicker"><?php echo esc_html( $i18n['hero_kicker'] ); ?></p>
			<h1><?php echo esc_html( $i18n['hero_title_1'] ); ?><br><em><?php echo esc_html( $i18n['hero_title_2'] ); ?></em></h1>
			<p class="lgf-cycling-hero__intro"><?php echo esc_html( $i18n['hero_intro'] ); ?></p>
			<div class="lgf-cycling-hero__actions">
				<a class="lgf-cycling-button lgf-cycling-button--light" href="#itineraries"><?php echo esc_html( $i18n['cta_explore'] ); ?> <span aria-hidden="true">↓</span></a>
				<a class="lgf-cycling-text-link" href="#booking"><?php echo esc_html( $i18n['cta_plan'] ); ?> <span aria-hidden="true">↗</span></a>
			</div>
			<div class="lgf-cycling-hero__stamp"><span>01</span><span><?php echo esc_html( $i18n['stamp'] ); ?></span></div>
		</div>
	</section>

	<section class="lgf-cycling-intro lgf-cycling-shell">
		<div>
			<p class="lgf-cycling-kicker"><?php echo esc_html( $i18n['intro_kicker'] ); ?></p>
			<h2><?php echo esc_html( $i18n['intro_title_1'] ); ?><br><?php echo esc_html( $i18n['intro_title_2'] ); ?></h2>
		</div>
		<div class="lgf-cycling-intro__copy">
			<p><?php echo esc_html( $i18n['intro_copy'] ); ?></p>
			<p class="lgf-cycling-note"><span aria-hidden="true">✳</span> <strong><?php echo esc_html( $i18n['note_bold'] ); ?></strong> <?php echo esc_html( $i18n['note'] ); ?></p>
		</div>
	</section>

	<section class="lgf-cycling-itineraries" id="itineraries">
		<div class="lgf-cycling-shell">
			<div class="lgf-cycling-section-heading">
				<div><p class="lgf-cycling-kicker"><?php echo esc_html( $i18n['pick_kicker'] ); ?></p><h2><?php echo esc_html( $i18n['pick_title'] ); ?></h2></div>
				<p><?php echo esc_html( $i18n['pick_copy'] ); ?></p>
			</div>
			<div class="lgf-cycling-route-grid">
				<?php foreach ( $routes[ $lang ] as $route ) : ?>
					<article class="lgf-cycling-route-card">
						<div class="lgf-cycling-route-card__top"><span class="lgf-cycling-route-card__number"><?php echo esc_html( $route['number'] ); ?></span><span class="lgf-cycling-route-card__tag"><?php echo esc_html( $route['tag'] ); ?></span></div>
						<p class="lgf-cycling-kicker"><?php echo esc_html( $route['eyebrow'] ); ?></p>
						<h3><?php echo esc_html( $route['title'] ); ?></h3>
						<p><?php echo esc_html( $route['description'] ); ?></p>
						<div class="lgf-cycling-route-card__stats"><div><strong><?php echo esc_html( $route['distance'] ); ?></strong><span><?php echo esc_html( $i18n['stat_distance'] ); ?></span></div><div><strong><?php echo esc_html( $route['elevation'] ); ?></strong><span><?php echo esc_html( $i18n['stat_climbing'] ); ?></span></div></div>
						<div class="lgf-cycling-route-card__footer"><span><?php echo esc_html( $route['rides'] ); ?></span><a href="#details-<?php echo esc_attr( $route['number'] ); ?>"><?php echo esc_html( $i18n['see_plan'] ); ?> <span aria-hidden="true">↗</span></a></div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="lgf-cycling-details lgf-cycling-shell">
		<div class="lgf-cycling-section-heading"><div><p class="lgf-cycling-kicker"><?php echo esc_html( $i18n['details_kicker'] ); ?></p><h2><?php echo esc_html( $i18n['details_title_1'] ); ?><br><?php echo esc_html( $i18n['details_title_2'] ); ?></h2></div><p><?php echo esc_html( $i18n['details_copy'] ); ?></p></div>
		<?php foreach ( $routes[ $lang ] as $route ) : ?>
			<div class="lgf-cycling-plan" id="details-<?php echo esc_attr( $route['number'] ); ?>">
				<div class="lgf-cycling-plan__label"><span><?php echo esc_html( $route['nights'] ); ?></span><strong><?php echo esc_html( $i18n['nights'] ); ?></strong></div>
				<div class="lgf-cycling-plan__body"><h3><?php echo esc_html( $route['title'] ); ?></h3><ol>
					<?php $day = 0; foreach ( $route['details'] as $detail ) : $day++; ?>
						<li><span><?php echo esc_html( sprintf( '%02d', $day ) ); ?></span><div><strong><?php echo esc_html( $detail[0] ); ?></strong><small><?php echo esc_html( $detail[1] ); ?></small></div></li>
					<?php endforeach; ?>
				</ol><a class="lgf-cycling-download" href="<?php echo esc_url( $theme_uri . '/assets/routes/' . $route['file'] ); ?>" download><?php echo esc_html( $i18n['download'] ); ?> <span aria-hidden="true">↓</span></a></div>
			</div>
		<?php endforeach; ?>
	</section>

	<section class="lgf-cycling-why">
		<div class="lgf-cycling-shell lgf-cycling-why__grid"><div><p class="lgf-cycling-kicker"><?php echo esc_html( $i18n['why_kicker'] ); ?></p><h2><?php echo esc_html( $i18n['why_title_1'] ); ?><br><?php echo esc_html( $i18n['why_title_2'] ); ?></h2></div><div class="lgf-cycling-perks"><div><span>01</span><h3><?php echo esc_html( $i18n['perk_1_t'] ); ?></h3><p><?php echo esc_html( $i18n['perk_1_d'] ); ?></p></div><div><span>02</span><h3><?php echo esc_html( $i18n['perk_2_t'] ); ?></h3><p><?php echo esc_html( $i18n['perk_2_d'] ); ?></p></div><div><span>03</span><h3><?php echo esc_html( $i18n['perk_3_t'] ); ?></h3><p><?php echo esc_html( $i18n['perk_3_d'] ); ?></p></div></div></div>
	</section>

	<section class="lgf-cycling-booking lgf-cycling-shell" id="booking"><div class="lgf-cycling-booking__inner"><p class="lgf-cycling-kicker"><?php echo esc_html( $i18n['book_kicker'] ); ?></p><h2><?php echo esc_html( $i18n['book_title_1'] ); ?><br><?php echo esc_html( $i18n['book_title_2'] ); ?></h2><p><?php echo esc_html( $i18n['book_copy'] ); ?></p><a class="lgf-cycling-button lgf-cycling-button--dark" href="<?php echo esc_url( $i18n['book_url'] ); ?>"><?php echo esc_html( $i18n['book_cta'] ); ?> <span aria-hidden="true">↗</span></a></div></section>
</main>

<?php get_footer(); ?>