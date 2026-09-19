<?php
/**
 * Template Name: Cycling Itineraries Draft
 * Description: Public cycling holiday itinerary concept page.
 */

defined( 'ABSPATH' ) || exit;

get_header();

$theme_uri = get_stylesheet_directory_uri();
$routes    = [
	[
		'number'      => '01',
		'eyebrow'     => '3 nights',
		'title'       => 'The first taste',
		'description' => 'A gentle introduction to the quiet lanes, golden villages and rolling hills around La Grange Fleurie.',
		'distance'    => '126 km',
		'elevation'   => '1,480 m',
		'rides'       => '2 rides + arrival day',
		'tag'         => 'Best for a long weekend',
	],
	[
		'number'      => '02',
		'eyebrow'     => '5 nights',
		'title'       => 'The good week',
		'description' => 'Enough time to settle into the rhythm: two scenic loops, a longer challenge and a day to explore on foot.',
		'distance'    => '238 km',
		'elevation'   => '3,120 m',
		'rides'       => '3 rides + 1 rest day',
		'tag'         => 'Our most popular format',
	],
	[
		'number'      => '03',
		'eyebrow'     => '7 nights',
		'title'       => 'The full escape',
		'description' => 'A complete week of cycling in southern Burgundy, with room for the best climbs, markets, villages and long lunches.',
		'distance'    => '342 km',
		'elevation'   => '4,760 m',
		'rides'       => '5 rides + 1 rest day',
		'tag'         => 'For curious, confident riders',
	],
];
?>

<main class="lgf-cycling-page">
	<section class="lgf-cycling-hero">
		<div class="lgf-cycling-hero__texture" aria-hidden="true"></div>
		<div class="lgf-cycling-shell lgf-cycling-hero__content">
			<p class="lgf-cycling-kicker">Cycling holidays in southern Burgundy</p>
			<h1>Ride slowly.<br><em>Stay beautifully.</em></h1>
			<p class="lgf-cycling-hero__intro">A few days of quiet roads, village cafés and a comfortable base at La Grange Fleurie. Choose your rhythm, download the routes and make southern Burgundy your own.</p>
			<div class="lgf-cycling-hero__actions">
				<a class="lgf-cycling-button lgf-cycling-button--light" href="#itineraries">Explore the itineraries <span aria-hidden="true">↓</span></a>
				<a class="lgf-cycling-text-link" href="#booking">Plan your stay <span aria-hidden="true">↗</span></a>
			</div>
			<div class="lgf-cycling-hero__stamp"><span>01</span><span>Base yourself<br>in Tramayes</span></div>
		</div>
	</section>

	<section class="lgf-cycling-intro lgf-cycling-shell">
		<div>
			<p class="lgf-cycling-kicker">A better kind of cycling break</p>
			<h2>Less luggage.<br>More landscape.</h2>
		</div>
		<div class="lgf-cycling-intro__copy">
			<p>Leave your bags in one place and ride out each morning from our chambre d'hôtes near Tramayes. These sample itineraries are built around small roads, good food and the kind of views that make you stop without planning to.</p>
			<p class="lgf-cycling-note"><span aria-hidden="true">✳</span> <strong>Draft routes for discussion.</strong> Distances and GPX files on this page are dummy data and will be replaced with checked local routes.</p>
		</div>
	</section>

	<section class="lgf-cycling-itineraries" id="itineraries">
		<div class="lgf-cycling-shell">
			<div class="lgf-cycling-section-heading">
				<div><p class="lgf-cycling-kicker">Pick your pace</p><h2>Three ways to stay</h2></div>
				<p>Every plan starts and finishes at La Grange Fleurie. Add nights, swap a ride for a rest day, or ask us to shape a week around your legs.</p>
			</div>
			<div class="lgf-cycling-route-grid">
				<?php foreach ( $routes as $route ) : ?>
					<article class="lgf-cycling-route-card">
						<div class="lgf-cycling-route-card__top"><span class="lgf-cycling-route-card__number"><?php echo esc_html( $route['number'] ); ?></span><span class="lgf-cycling-route-card__tag"><?php echo esc_html( $route['tag'] ); ?></span></div>
						<p class="lgf-cycling-kicker"><?php echo esc_html( $route['eyebrow'] ); ?></p>
						<h3><?php echo esc_html( $route['title'] ); ?></h3>
						<p><?php echo esc_html( $route['description'] ); ?></p>
						<div class="lgf-cycling-route-card__stats"><div><strong><?php echo esc_html( $route['distance'] ); ?></strong><span>total distance</span></div><div><strong><?php echo esc_html( $route['elevation'] ); ?></strong><span>total climbing</span></div></div>
						<div class="lgf-cycling-route-card__footer"><span><?php echo esc_html( $route['rides'] ); ?></span><a href="#details-<?php echo esc_attr( $route['number'] ); ?>">See the plan <span aria-hidden="true">↗</span></a></div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="lgf-cycling-details lgf-cycling-shell">
		<div class="lgf-cycling-section-heading"><div><p class="lgf-cycling-kicker">A week at a glance</p><h2>Routes with room<br>to breathe</h2></div><p>Illustrative schedule only. On booking, we will confirm route conditions, seasonal stops and the best order for the weather.</p></div>
		<div class="lgf-cycling-plan" id="details-01"><div class="lgf-cycling-plan__label"><span>03</span><strong>nights</strong></div><div class="lgf-cycling-plan__body"><h3>The first taste</h3><ol><li><span>01</span><div><strong>Arrival &amp; settle in</strong><small>Welcome drink, bike check and local supper suggestions.</small></div></li><li><span>02</span><div><strong>Cluny and the greenway</strong><small>62 km · 540 m climbing · easy / moderate</small></div></li><li><span>03</span><div><strong>Château country loop</strong><small>64 km · 940 m climbing · moderate</small></div></li></ol><a class="lgf-cycling-download" href="<?php echo esc_url( $theme_uri . '/assets/routes/draft-cluny-loop.gpx' ); ?>" download>Download sample GPX <span aria-hidden="true">↓</span></a></div></div>
		<div class="lgf-cycling-plan" id="details-02"><div class="lgf-cycling-plan__label"><span>05</span><strong>nights</strong></div><div class="lgf-cycling-plan__body"><h3>The good week</h3><ol><li><span>01</span><div><strong>Arrival &amp; settle in</strong><small>Welcome drink, bike check and local supper suggestions.</small></div></li><li><span>02</span><div><strong>Cluny and the greenway</strong><small>62 km · 540 m climbing · easy / moderate</small></div></li><li><span>03</span><div><strong>Morning market, afternoon rest</strong><small>A shorter 34 km loop · cafés and village wandering.</small></div></li><li><span>04</span><div><strong>The Beaujolais foothills</strong><small>88 km · 1,420 m climbing · challenging</small></div></li><li><span>05</span><div><strong>Château country loop</strong><small>54 km · 760 m climbing · moderate</small></div></li></ol><a class="lgf-cycling-download" href="<?php echo esc_url( $theme_uri . '/assets/routes/draft-beaujolais-foothills.gpx' ); ?>" download>Download sample GPX <span aria-hidden="true">↓</span></a></div></div>
		<div class="lgf-cycling-plan" id="details-03"><div class="lgf-cycling-plan__label"><span>07</span><strong>nights</strong></div><div class="lgf-cycling-plan__body"><h3>The full escape</h3><ol><li><span>01</span><div><strong>Arrival &amp; settle in</strong><small>Welcome drink, bike check and local supper suggestions.</small></div></li><li><span>02</span><div><strong>Cluny and the greenway</strong><small>62 km · 540 m climbing · easy / moderate</small></div></li><li><span>03</span><div><strong>Two valleys, one long lunch</strong><small>78 km · 1,160 m climbing · moderate</small></div></li><li><span>04</span><div><strong>Rest day in the Mâconnais</strong><small>Market morning, vineyard views and no cycling required.</small></div></li><li><span>05</span><div><strong>The Beaujolais foothills</strong><small>88 km · 1,420 m climbing · challenging</small></div></li><li><span>06</span><div><strong>Château country loop</strong><small>54 km · 760 m climbing · moderate</small></div></li></ol><a class="lgf-cycling-download" href="<?php echo esc_url( $theme_uri . '/assets/routes/draft-full-escape.gpx' ); ?>" download>Download sample GPX <span aria-hidden="true">↓</span></a></div></div>
	</section>

	<section class="lgf-cycling-why">
		<div class="lgf-cycling-shell lgf-cycling-why__grid"><div><p class="lgf-cycling-kicker">Why stay with us?</p><h2>Ride out<br>from home.</h2></div><div class="lgf-cycling-perks"><div><span>01</span><h3>One calm base</h3><p>Unpack once, then start each ride from the front door.</p></div><div><span>02</span><h3>Local knowledge</h3><p>We can point you towards the best café, climb or shortcut that day.</p></div><div><span>03</span><h3>Proper recovery</h3><p>A quiet room, a generous breakfast and space to let the legs recover.</p></div></div></div>
	</section>

	<section class="lgf-cycling-booking lgf-cycling-shell" id="booking"><div class="lgf-cycling-booking__inner"><p class="lgf-cycling-kicker">Ready when you are</p><h2>Bring your bike.<br>We’ll take care of the rest.</h2><p>Tell us how many nights you are thinking about and what kind of riding you enjoy. We’ll help turn this draft into your perfect stay.</p><a class="lgf-cycling-button lgf-cycling-button--dark" href="/booking/">Check availability <span aria-hidden="true">↗</span></a></div></section>
</main>

<?php get_footer(); ?>
