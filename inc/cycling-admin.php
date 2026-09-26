<?php

function lgf_cycling_defaults() {
	static $d = null;
	if ( null === $d ) {
		$d = require __DIR__ . '/cycling-defaults.php';
	}
	return $d;
}

function lgf_cycling_languages() {
	return array(
		'lgf-cycling-en' => 'en',
		'lgf-cycling-fr' => 'fr',
		'lgf-cycling-nl' => 'nl',
	);
}

function lgf_cycling_current_lang() {
	$page = isset( $_GET['page'] ) ? sanitize_key( $_GET['page'] ) : '';
	$map  = lgf_cycling_languages();
	return isset( $map[ $page ] ) ? $map[ $page ] : 'en';
}

function lgf_cycling_lang_label( $lang ) {
	$labels = array( 'en' => 'English', 'fr' => 'Français', 'nl' => 'Nederlands' );
	return isset( $labels[ $lang ] ) ? $labels[ $lang ] : $lang;
}

function lgf_cycling_get_saved( $lang ) {
	$v = get_option( 'lgf_cycling_' . $lang, null );
	return is_array( $v ) ? $v : null;
}

function lgf_cycling_data( $lang ) {
	$d = lgf_cycling_defaults();
	if ( ! isset( $d['i18n'][ $lang ] ) ) {
		$lang = 'en';
	}
	$i18n   = $d['i18n'][ $lang ];
	$routes = $d['routes'][ $lang ];
	$saved  = lgf_cycling_get_saved( $lang );
	if ( ! $saved ) {
		return compact( 'i18n', 'routes' );
	}
	if ( ! empty( $saved['i18n'] ) && is_array( $saved['i18n'] ) ) {
		foreach ( $saved['i18n'] as $k => $val ) {
			if ( array_key_exists( $k, $i18n ) ) {
				$i18n[ $k ] = $val;
			}
		}
	}
	if ( ! empty( $saved['routes'] ) && is_array( $saved['routes'] ) ) {
		foreach ( $routes as $i => $def ) {
			if ( ! isset( $saved['routes'][ $i ] ) || ! is_array( $saved['routes'][ $i ] ) ) {
				continue;
			}
			$sv = $saved['routes'][ $i ];
			foreach ( $def as $k => $v ) {
				if ( 'details' === $k ) {
					continue;
				}
				if ( array_key_exists( $k, $sv ) ) {
					$def[ $k ] = $sv[ $k ];
				}
			}
			if ( isset( $sv['details'] ) && is_array( $sv['details'] ) ) {
				$rows = array();
				for ( $r = 0; $r < 6; $r++ ) {
					$t = isset( $sv['details'][ $r ][0] ) ? (string) $sv['details'][ $r ][0] : '';
					$s = isset( $sv['details'][ $r ][1] ) ? (string) $sv['details'][ $r ][1] : '';
					if ( '' === trim( $t ) && '' === trim( $s ) ) {
						continue;
					}
					$rows[] = array( $t, $s );
				}
				$def['details'] = $rows;
			}
			$routes[ $i ] = $def;
		}
	}
	return compact( 'i18n', 'routes' );
}

function lgf_cycling_form_data( $lang ) {
	$data = lgf_cycling_data( $lang );
	foreach ( $data['routes'] as $i => $r ) {
		$rows = array();
		for ( $x = 0; $x < 6; $x++ ) {
			$rows[ $x ] = array(
				isset( $r['details'][ $x ][0] ) ? (string) $r['details'][ $x ][0] : '',
				isset( $r['details'][ $x ][1] ) ? (string) $r['details'][ $x ][1] : '',
			);
		}
		$data['routes'][ $i ]['details'] = $rows;
	}
	return $data;
}

function lgf_cycling_i18n_spec() {
	return array(
		'Hero' => array(
			'hero_kicker'  => array( 'Kicker (small label)', 'text' ),
			'hero_title_1' => array( 'Title line 1', 'text' ),
			'hero_title_2' => array( 'Title line 2 (italic line)', 'text' ),
			'hero_intro'   => array( 'Intro paragraph', 'textarea' ),
			'cta_explore'  => array( 'Primary button label', 'text' ),
			'cta_plan'     => array( 'Secondary link label', 'text' ),
			'stamp'        => array( 'Round stamp (line break preserved)', 'textarea' ),
		),
		'Intro' => array(
			'intro_kicker'  => array( 'Kicker', 'text' ),
			'intro_title_1' => array( 'Title line 1', 'text' ),
			'intro_title_2' => array( 'Title line 2', 'text' ),
			'intro_copy'    => array( 'Copy paragraph', 'textarea' ),
			'note_bold'     => array( 'Note lead (bold)', 'text' ),
			'note'          => array( 'Note text', 'textarea' ),
		),
		'Pick your pace' => array(
			'pick_kicker'  => array( 'Kicker', 'text' ),
			'pick_title'   => array( 'Title', 'text' ),
			'pick_copy'    => array( 'Copy paragraph', 'textarea' ),
			'stat_distance'=> array( 'Stats label: distance', 'text' ),
			'stat_climbing'=> array( 'Stats label: climbing', 'text' ),
			'see_plan'     => array( 'Card link label', 'text' ),
		),
		'Week plan' => array(
			'details_kicker'  => array( 'Kicker', 'text' ),
			'details_title_1' => array( 'Title line 1', 'text' ),
			'details_title_2' => array( 'Title line 2', 'text' ),
			'details_copy'    => array( 'Copy paragraph', 'textarea' ),
			'nights'          => array( 'Nights label (under card numbers)', 'text' ),
			'download'        => array( 'GPX download label', 'text' ),
		),
		'Why stay with us' => array(
			'why_kicker'  => array( 'Kicker', 'text' ),
			'why_title_1' => array( 'Title line 1', 'text' ),
			'why_title_2' => array( 'Title line 2', 'text' ),
			'perk_1_t'    => array( 'Perk 1 title', 'text' ),
			'perk_1_d'    => array( 'Perk 1 description', 'textarea' ),
			'perk_2_t'    => array( 'Perk 2 title', 'text' ),
			'perk_2_d'    => array( 'Perk 2 description', 'textarea' ),
			'perk_3_t'    => array( 'Perk 3 title', 'text' ),
			'perk_3_d'    => array( 'Perk 3 description', 'textarea' ),
		),
		'Booking' => array(
			'book_kicker'  => array( 'Kicker', 'text' ),
			'book_title_1' => array( 'Title line 1', 'text' ),
			'book_title_2' => array( 'Title line 2', 'text' ),
			'book_copy'    => array( 'Copy paragraph', 'textarea' ),
			'book_cta'     => array( 'Button label', 'text' ),
			'book_url'     => array( 'Button URL (relative ok, e.g. /booking/)', 'text' ),
		),
	);
}

function lgf_cycling_route_field_spec() {
	return array(
		'number'      => array( 'Card number', 'text' ),
		'nights'      => array( 'Nights number', 'text' ),
		'eyebrow'     => array( 'Card kicker', 'text' ),
		'title'       => array( 'Card title', 'text' ),
		'description' => array( 'Card description', 'textarea' ),
		'distance'    => array( 'Stat: distance', 'text' ),
		'elevation'   => array( 'Stat: climbing', 'text' ),
		'rides'       => array( 'Card footer: rides', 'text' ),
		'tag'         => array( 'Top tag', 'text' ),
		'file'        => array( 'GPX filename (in assets/routes/)', 'text' ),
	);
}

function lgf_cycling_sanitize( $in ) {
	$defaults = lgf_cycling_defaults();
	$out      = array( 'i18n' => array(), 'routes' => array() );
	if ( ! is_array( $in ) ) {
		$in = array();
	}
	$in_i18n = isset( $in['i18n'] ) && is_array( $in['i18n'] ) ? $in['i18n'] : array();
	$spec    = lgf_cycling_i18n_spec();
	foreach ( $spec as $fields ) {
		foreach ( $fields as $key => $meta ) {
			$type = $meta[1];
			if ( ! array_key_exists( $key, $in_i18n ) ) {
				continue;
			}
			$raw = is_scalar( $in_i18n[ $key ] ) ? (string) $in_i18n[ $key ] : '';
			$out['i18n'][ $key ] = ( 'textarea' === $type ) ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
		}
	}
	$in_routes = isset( $in['routes'] ) && is_array( $in['routes'] ) ? $in['routes'] : array();
	$rfields   = lgf_cycling_route_field_spec();
	foreach ( $defaults['routes']['en'] as $i => $dummy ) {
		$rout = array();
		$sv   = isset( $in_routes[ $i ] ) && is_array( $in_routes[ $i ] ) ? $in_routes[ $i ] : array();
		foreach ( $rfields as $key => $meta ) {
			$type = $meta[1];
			if ( ! array_key_exists( $key, $sv ) ) {
				continue;
			}
			$raw = is_scalar( $sv[ $key ] ) ? (string) $sv[ $key ] : '';
			$rout[ $key ] = ( 'textarea' === $type ) ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
		}
		$details = array();
		for ( $r = 0; $r < 6; $r++ ) {
			$t = isset( $sv['details'][ $r ]['title'] ) && is_scalar( $sv['details'][ $r ]['title'] ) ? (string) $sv['details'][ $r ]['title'] : '';
			$d = isset( $sv['details'][ $r ]['desc'] ) && is_scalar( $sv['details'][ $r ]['desc'] ) ? (string) $sv['details'][ $r ]['desc'] : '';
			$details[ $r ] = array( sanitize_text_field( $t ), sanitize_text_field( $d ) );
		}
		$rout['details'] = $details;
		$out['routes'][ $i ] = $rout;
	}
	return $out;
}

function lgf_cycling_menu() {
	add_menu_page(
		'Cycling content',
		'Cycling',
		'manage_options',
		'lgf-cycling-en',
		'lgf_cycling_render_page',
		'dashicons-palmtree',
		61
	);
	add_submenu_page( 'lgf-cycling-en', 'Cycling — English', 'EN', 'manage_options', 'lgf-cycling-en', 'lgf_cycling_render_page' );
	add_submenu_page( 'lgf-cycling-en', 'Cycling — Français', 'FR', 'manage_options', 'lgf-cycling-fr', 'lgf_cycling_render_page' );
	add_submenu_page( 'lgf-cycling-en', 'Cycling — Nederlands', 'NL', 'manage_options', 'lgf-cycling-nl', 'lgf_cycling_render_page' );
}
add_action( 'admin_menu', 'lgf_cycling_menu' );

// Admin-only stylesheet for the Cycling screens. It is never enqueued on the
// front end, so it can lay the form out in columns without touching the pages.
function lgf_cycling_admin_enqueue() {
	$page = isset( $_GET['page'] ) ? sanitize_key( $_GET['page'] ) : '';
	if ( 0 !== strpos( $page, 'lgf-cycling-' ) ) {
		return;
	}
	wp_enqueue_style(
		'lgf-cycling-admin',
		get_stylesheet_directory_uri() . '/assets/css/cycling-admin.css',
		array(),
		'1.0.33'
	);
}
add_action( 'admin_enqueue_scripts', 'lgf_cycling_admin_enqueue' );

// The sidebar icon has to work on every admin screen, not just the editor
// pages, so it gets its own always-on stylesheet.
function lgf_cycling_menu_icon_enqueue() {
	wp_enqueue_style(
		'lgf-cycling-admin-menu',
		get_stylesheet_directory_uri() . '/assets/css/cycling-admin-menu.css',
		array(),
		'1.0.33'
	);
}
add_action( 'admin_enqueue_scripts', 'lgf_cycling_menu_icon_enqueue' );

function lgf_cycling_field_id() {
	static $n = 0;
	$n++;
	return 'lgf-cyc-f' . $n;
}

// One label-above field, sized to the card it sits in.
function lgf_cycling_field( $label, $name, $value, $type = 'text', $rows = 3, $hint = '' ) {
	$id = lgf_cycling_field_id();
	echo '<label class="lgf-cyc-field" for="' . esc_attr( $id ) . '">';
	echo '<span class="lgf-cyc-field__label">' . esc_html( $label ) . '</span>';
	if ( 'textarea' === $type ) {
		echo '<textarea class="lgf-cyc-textarea" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" rows="' . (int) $rows . '">' . esc_textarea( $value ) . '</textarea>';
	} else {
		echo '<input type="text" class="lgf-cyc-input" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
	}
	if ( $hint ) {
		echo '<span class="lgf-cyc-field__hint">' . esc_html( $hint ) . '</span>';
	}
	echo '</label>';
}

// Placeholder-only input, for the dense day rows where a label per input is noise.
function lgf_cycling_compact_field( $name, $value, $placeholder = '' ) {
	$id = lgf_cycling_field_id();
	echo '<input type="text" class="lgf-cyc-input" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" placeholder="' . esc_attr( $placeholder ) . '" aria-label="' . esc_attr( $placeholder ) . '" />';
}

// lgf_cycling_i18n_spec() is grouped by section; flatten it to key => label/type
// so panels can ask for fields by name.
function lgf_cycling_i18n_field_spec() {
	$flat = array();
	foreach ( lgf_cycling_i18n_spec() as $fields ) {
		foreach ( $fields as $key => $meta ) {
			$flat[ $key ] = $meta;
		}
	}
	return $flat;
}

// Renders the requested keys of a language section, using the labels in the spec.
function lgf_cycling_i18n_fields( $i18n, $keys, $rows = array(), $hints = array() ) {
	$spec = lgf_cycling_i18n_field_spec();
	foreach ( $keys as $key ) {
		if ( ! isset( $spec[ $key ] ) ) {
			continue;
		}
		list( $label, $type ) = $spec[ $key ];
		lgf_cycling_field(
			$label,
			'cycling[i18n][' . $key . ']',
			isset( $i18n[ $key ] ) ? $i18n[ $key ] : '',
			$type,
			isset( $rows[ $key ] ) ? $rows[ $key ] : 3,
			isset( $hints[ $key ] ) ? $hints[ $key ] : ''
		);
	}
}

function lgf_cycling_route_field( $index, $route, $key, $rows = 3, $hint = '' ) {
	$spec = lgf_cycling_route_field_spec();
	if ( ! isset( $spec[ $key ] ) ) {
		return;
	}
	list( $label, $type ) = $spec[ $key ];
	lgf_cycling_field(
		$label,
		'cycling[routes][' . (int) $index . '][' . $key . ']',
		isset( $route[ $key ] ) ? $route[ $key ] : '',
		$type,
		$rows,
		$hint
	);
}

function lgf_cycling_slugs() {
	return array(
		'en' => 'cycling-itineraries',
		'fr' => 'sejours-cyclistes',
		'nl' => 'fietsvakanties',
	);
}

function lgf_cycling_purge_page_cache( $lang ) {
	$slugs = lgf_cycling_slugs();
	if ( isset( $slugs[ $lang ] ) ) {
		do_action( 'litespeed_purge_url', home_url( '/' . $slugs[ $lang ] . '/' ) );
	}
}

// The form is laid out one panel per live-page section, in the same order and
// the same column rhythm, so the admin screen reads like the page it feeds.
function lgf_cycling_panel_hero( $i18n ) {
	?>
	<section class="lgf-cyc-panel lgf-cyc-hero" id="lgf-cyc-hero">
		<h2>Hero</h2>
		<div class="lgf-cyc-body">
			<div class="lgf-cyc-col">
				<?php lgf_cycling_i18n_fields( $i18n, array( 'hero_kicker', 'hero_title_1', 'hero_title_2' ) ); ?>
			</div>
			<div class="lgf-cyc-col">
				<?php
				lgf_cycling_i18n_fields( $i18n, array( 'hero_intro' ), array( 'hero_intro' => 4 ) );
				?>
				<div class="lgf-cyc-hero__actions">
					<?php
					lgf_cycling_i18n_fields(
						$i18n,
						array( 'cta_explore', 'cta_plan' ),
						array(),
						array(
							'cta_explore' => 'Button text on the live page.',
							'cta_plan'    => 'Link text next to the button.',
						)
					);
					?>
				</div>
				<div class="lgf-cyc-hero__stamp">
					<?php
					lgf_cycling_i18n_fields(
						$i18n,
						array( 'stamp' ),
						array( 'stamp' => 2 ),
						array( 'stamp' => 'Two lines. Shown bottom-right of the hero on the live page.' )
					);
					?>
				</div>
			</div>
		</div>
	</section>
	<?php
}

function lgf_cycling_panel_intro( $i18n ) {
	?>
	<section class="lgf-cyc-panel" id="lgf-cyc-intro">
		<h2>Intro</h2>
		<div class="lgf-cyc-grid lgf-cyc-grid--intro lgf-cyc-pad">
			<div class="lgf-cyc-col">
				<?php lgf_cycling_i18n_fields( $i18n, array( 'intro_kicker', 'intro_title_1', 'intro_title_2' ) ); ?>
			</div>
			<div class="lgf-cyc-col">
				<?php
				lgf_cycling_i18n_fields(
					$i18n,
					array( 'intro_copy', 'note_bold', 'note' ),
					array( 'intro_copy' => 6, 'note' => 4 ),
					array( 'note' => 'Tinted note box under the copy, marked with a small flower.' )
				);
				?>
			</div>
		</div>
	</section>
	<?php
}

function lgf_cycling_panel_pace( $i18n, $routes ) {
	?>
	<section class="lgf-cyc-panel lgf-cyc-panel--aqua" id="lgf-cyc-pace">
		<h2>Pick your pace — three route cards</h2>
		<div class="lgf-cyc-head">
			<div class="lgf-cyc-col">
				<?php lgf_cycling_i18n_fields( $i18n, array( 'pick_kicker', 'pick_title' ) ); ?>
			</div>
			<div class="lgf-cyc-col">
				<?php lgf_cycling_i18n_fields( $i18n, array( 'pick_copy' ), array( 'pick_copy' => 3 ) ); ?>
			</div>
		</div>
		<div class="lgf-cyc-shared">
			<h3>Labels shared by all three cards</h3>
			<div class="lgf-cyc-grid lgf-cyc-grid--3">
				<?php lgf_cycling_i18n_fields( $i18n, array( 'stat_distance', 'stat_climbing', 'see_plan' ) ); ?>
			</div>
		</div>
		<div class="lgf-cyc-grid lgf-cyc-grid--3 lgf-cyc-pad">
			<?php foreach ( $routes as $i => $route ) : ?>
				<?php $file = isset( $route['file'] ) ? (string) $route['file'] : ''; ?>
				<article class="lgf-cyc-card">
					<div class="lgf-cyc-card__top">
						<?php
						lgf_cycling_route_field( $i, $route, 'number' );
						lgf_cycling_route_field( $i, $route, 'tag' );
						?>
					</div>
					<?php
					lgf_cycling_route_field( $i, $route, 'eyebrow' );
					lgf_cycling_route_field( $i, $route, 'title' );
					lgf_cycling_route_field( $i, $route, 'description', 5 );
					?>
					<div class="lgf-cyc-stats">
						<?php
						lgf_cycling_route_field( $i, $route, 'distance' );
						lgf_cycling_route_field( $i, $route, 'elevation' );
						?>
					</div>
					<div class="lgf-cyc-card__foot">
						<?php
						lgf_cycling_route_field( $i, $route, 'rides' );
						lgf_cycling_route_field(
							$i,
							$route,
							'file',
							3,
							'' === trim( $file )
								? ''
								: ( file_exists( get_stylesheet_directory() . '/assets/routes/' . $file )
									? 'Found in assets/routes.'
									: 'Missing from assets/routes — the download link will 404.' )
						);
						?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}

function lgf_cycling_panel_plans( $i18n, $routes ) {
	?>
	<section class="lgf-cyc-panel" id="lgf-cyc-plan">
		<h2>Week plan — one card per route</h2>
		<div class="lgf-cyc-head">
			<div class="lgf-cyc-col">
				<?php lgf_cycling_i18n_fields( $i18n, array( 'details_kicker', 'details_title_1', 'details_title_2' ) ); ?>
			</div>
			<div class="lgf-cyc-col">
				<?php
				lgf_cycling_i18n_fields(
					$i18n,
					array( 'details_copy', 'download', 'nights' ),
					array( 'details_copy' => 3 ),
					array(
						'download' => 'Link label on every plan card, next to the GPX download.',
						'nights'   => 'Unit word under the night count, e.g. nights / nuits / nachten.',
					)
				);
				?>
			</div>
		</div>
		<div class="lgf-cyc-grid lgf-cyc-grid--3 lgf-cyc-pad">
			<?php foreach ( $routes as $i => $route ) : ?>
				<article class="lgf-cyc-plan">
					<div class="lgf-cyc-plan__head">
						<?php lgf_cycling_route_field( $i, $route, 'nights' ); ?>
						<span class="lgf-cyc-plan__unit"><?php echo esc_html( isset( $i18n['nights'] ) ? $i18n['nights'] : '' ); ?></span>
					</div>
					<p class="lgf-cyc-plan__title"><?php echo esc_html( isset( $route['title'] ) ? $route['title'] : '' ); ?></p>
					<div class="lgf-cyc-days">
						<?php
						$day = 0;
						$blank = 0;
						for ( $r = 0; $r < 6; $r++ ) :
							$title = isset( $route['details'][ $r ][0] ) ? (string) $route['details'][ $r ][0] : '';
							$desc  = isset( $route['details'][ $r ][1] ) ? (string) $route['details'][ $r ][1] : '';
							$empty = '' === trim( $title ) && '' === trim( $desc );
							if ( $empty ) {
								$blank++;
							} else {
								$day++;
							}
							?>
							<div class="lgf-cyc-days__row<?php echo $empty ? ' lgf-cyc-days--empty' : ''; ?>">
								<span class="lgf-cyc-days__num"><?php echo $empty ? 'Not used' : esc_html( sprintf( 'Day %02d', $day ) ); ?></span>
								<?php
								lgf_cycling_compact_field( 'cycling[routes][' . (int) $i . '][details][' . (int) $r . '][title]', $title, 'Title' );
								lgf_cycling_compact_field( 'cycling[routes][' . (int) $i . '][details][' . (int) $r . '][desc]', $desc, 'Description' );
								?>
							</div>
						<?php endfor; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}

function lgf_cycling_panel_why( $i18n ) {
	$perks = array(
		1 => array( 'perk_1_t', 'perk_1_d' ),
		2 => array( 'perk_2_t', 'perk_2_d' ),
		3 => array( 'perk_3_t', 'perk_3_d' ),
	);
	?>
	<section class="lgf-cyc-panel lgf-cyc-panel--grey" id="lgf-cyc-why">
		<h2>Why stay with us</h2>
		<div class="lgf-cyc-grid lgf-cyc-grid--why lgf-cyc-pad">
			<div class="lgf-cyc-col">
				<?php lgf_cycling_i18n_fields( $i18n, array( 'why_kicker', 'why_title_1', 'why_title_2' ) ); ?>
			</div>
			<div class="lgf-cyc-perks">
				<?php foreach ( $perks as $n => $keys ) : ?>
					<div class="lgf-cyc-perk<?php echo ( 3 === $n ) ? ' lgf-cyc-perk--wide' : ''; ?>">
						<span class="lgf-cyc-perk__num"><?php echo esc_html( sprintf( '%02d', $n ) ); ?></span>
						<?php lgf_cycling_i18n_fields( $i18n, $keys, array( $keys[1] => 3 ) ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
}

function lgf_cycling_panel_booking( $i18n ) {
	?>
	<section class="lgf-cyc-panel lgf-cyc-booking" id="lgf-cyc-booking">
		<h2>Booking</h2>
		<div class="lgf-cyc-body">
			<div class="lgf-cyc-col">
				<?php lgf_cycling_i18n_fields( $i18n, array( 'book_kicker', 'book_title_1', 'book_title_2' ) ); ?>
			</div>
			<div class="lgf-cyc-col">
				<?php
				lgf_cycling_i18n_fields(
					$i18n,
					array( 'book_copy', 'book_cta', 'book_url' ),
					array( 'book_copy' => 4 ),
					array( 'book_url' => 'Relative paths are fine, e.g. /booking/' )
				);
				?>
			</div>
		</div>
	</section>
	<?php
}

function lgf_cycling_render_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Unauthorized' );
	}
	$lang = lgf_cycling_current_lang();
	$page = 'lgf-cycling-' . $lang;
	if ( isset( $_POST['lgf_cycling_save'] ) ) {
		check_admin_referer( 'lgf_cycling_save_' . $lang, 'lgf_cycling_nonce' );
		$in = isset( $_POST['cycling'] ) ? wp_unslash( $_POST['cycling'] ) : array();
		update_option( 'lgf_cycling_' . $lang, lgf_cycling_sanitize( $in ) );
		lgf_cycling_purge_page_cache( $lang );
		echo '<div class="notice notice-success is-dismissible"><p>Saved ' . esc_html( lgf_cycling_lang_label( $lang ) ) . ' copy.</p></div>';
	}
	$data   = lgf_cycling_form_data( $lang );
	$i18n   = $data['i18n'];
	$routes = $data['routes'];
	?>
	<div class="wrap lgf-cyc-wrap">
		<div class="lgf-cyc-bar">
			<h1>Cycling content — <?php echo esc_html( lgf_cycling_lang_label( $lang ) ); ?></h1>
			<div class="lgf-cyc-tabs">
				<?php foreach ( lgf_cycling_languages() as $code ) : ?>
					<a class="<?php echo ( $code === $lang ) ? 'is-current' : ''; ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=lgf-cycling-' . $code ) ); ?>"><?php echo esc_html( strtoupper( $code ) ); ?></a>
				<?php endforeach; ?>
			</div>
			<a class="lgf-cyc-live" href="<?php echo esc_url( home_url( '/' . lgf_cycling_slugs()[ $lang ] . '/' ) ); ?>" target="_blank" rel="noopener">View live page &nearr;</a>
		</div>
		<nav class="lgf-cyc-nav">
			<a href="#lgf-cyc-hero">Hero</a>
			<a href="#lgf-cyc-intro">Intro</a>
			<a href="#lgf-cyc-pace">Route cards</a>
			<a href="#lgf-cyc-plan">Week plans</a>
			<a href="#lgf-cyc-why">Perks</a>
			<a href="#lgf-cyc-booking">Booking</a>
		</nav>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=' . $page ) ); ?>">
			<?php wp_nonce_field( 'lgf_cycling_save_' . $lang, 'lgf_cycling_nonce' ); ?>
			<?php
			lgf_cycling_panel_hero( $i18n );
			lgf_cycling_panel_intro( $i18n );
			lgf_cycling_panel_pace( $i18n, $routes );
			lgf_cycling_panel_plans( $i18n, $routes );
			lgf_cycling_panel_why( $i18n );
			lgf_cycling_panel_booking( $i18n );
			?>
			<div class="lgf-cyc-save">
				<p>Panels follow the live page top to bottom. Blank day rows are hidden on the front end.</p>
				<button type="submit" class="button button-primary" name="lgf_cycling_save" value="1">Save Changes</button>
			</div>
		</form>
	</div>
	<?php
}
