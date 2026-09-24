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

function lgf_cycling_field_row( $label, $name, $value, $type = 'text', $hint = '' ) {
	static $n = 0;
	$n++;
	$id  = 'lgf-cyc-f' . $n;
	$cls = ( 'textarea' === $type ) ? 'large-text' : 'regular-text';
	echo '<tr><th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label></th><td>';
	if ( 'textarea' === $type ) {
		echo '<textarea class="' . esc_attr( $cls ) . '" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" rows="3">' . esc_textarea( $value ) . '</textarea>';
	} else {
		echo '<input type="text" class="' . esc_attr( $cls ) . '" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
	}
	if ( $hint ) {
		echo '<p class="description">' . esc_html( $hint ) . '</p>';
	}
	echo '</td></tr>';
}

function lgf_cycling_purge_page_cache( $lang ) {
	$slugs = array(
		'en' => 'cycling-itineraries',
		'fr' => 'sejours-cyclistes',
		'nl' => 'fietsvakanties',
	);
	if ( isset( $slugs[ $lang ] ) ) {
		do_action( 'litespeed_purge_url', home_url( '/' . $slugs[ $lang ] . '/' ) );
	}
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
	$data = lgf_cycling_form_data( $lang );
	?>
	<div class="wrap">
		<h1>Cycling content — <?php echo esc_html( lgf_cycling_lang_label( $lang ) ); ?></h1>
		<p>Feeds the cycling pages via the legacy template. Blank detail rows are hidden on the front end.</p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=' . $page ) ); ?>">
			<?php wp_nonce_field( 'lgf_cycling_save_' . $lang, 'lgf_cycling_nonce' ); ?>
			<?php foreach ( lgf_cycling_i18n_spec() as $section => $fields ) : ?>
				<h2><?php echo esc_html( $section ); ?></h2>
				<table class="form-table" role="presentation">
					<?php
					foreach ( $fields as $key => $meta ) {
						lgf_cycling_field_row( $meta[0], 'cycling[i18n][' . $key . ']', $data['i18n'][ $key ], $meta[1] );
					}
					?>
				</table>
			<?php endforeach; ?>
			<h2>Route cards</h2>
			<?php $nums = array( '01', '02', '03' ); ?>
			<?php foreach ( $data['routes'] as $i => $route ) : ?>
				<h3>Route card <?php echo esc_html( isset( $nums[ $i ] ) ? $nums[ $i ] : ( $i + 1 ) ); ?></h3>
				<table class="form-table" role="presentation">
					<?php
					foreach ( lgf_cycling_route_field_spec() as $key => $meta ) {
						$val = isset( $route[ $key ] ) ? $route[ $key ] : '';
						lgf_cycling_field_row( $meta[0], 'cycling[routes][' . $i . '][' . $key . ']', $val, $meta[1] );
					}
					?>
				</table>
				<h4>Details (blank rows hidden)</h4>
				<table class="form-table" role="presentation">
					<?php for ( $r = 0; $r < 6; $r++ ) : ?>
						<tr>
							<th scope="row">Row <?php echo esc_html( $r + 1 ); ?></th>
							<td>
								<input type="text" class="regular-text" name="cycling[routes][<?php echo esc_attr( $i ); ?>][details][<?php echo esc_attr( $r ); ?>][title]" value="<?php echo esc_attr( $route['details'][ $r ][0] ); ?>" placeholder="Title" />
								<br />
								<input type="text" class="large-text" name="cycling[routes][<?php echo esc_attr( $i ); ?>][details][<?php echo esc_attr( $r ); ?>][desc]" value="<?php echo esc_attr( $route['details'][ $r ][1] ); ?>" placeholder="Description" />
							</td>
						</tr>
					<?php endfor; ?>
				</table>
			<?php endforeach; ?>
			<p class="submit"><input type="submit" name="lgf_cycling_save" class="button button-primary" value="Save Changes" /></p>
		</form>
	</div>
	<?php
}
