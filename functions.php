<?php

// ==========================================================================
// Auto-updates from GitHub (plugin-update-checker by Janis Elsts).
// Push to the 'main' branch of the GitHub repo, then Appearance → Themes
// shows an update on the live site. Repo must stay PUBLIC unless you add a
// token: $lgfThemeUpdater->setAuthentication( '<TOKEN>' ); (keep it out of
// this theme). NEVER commit secrets into this theme.
// ==========================================================================
use YahnisElsts\PluginUpdateChecker\v5p7\PucFactory;

if ( file_exists( get_stylesheet_directory() . '/lib/plugin-update-checker/plugin-update-checker.php' ) ) {
	require_once get_stylesheet_directory() . '/lib/plugin-update-checker/plugin-update-checker.php';
	$lgfThemeUpdater = PucFactory::buildUpdateChecker(
		'https://github.com/angusuwatson/kadence-child/',
		get_stylesheet_directory(),
		'kadence-child'
	);
	$lgfThemeUpdater->setBranch( 'main' );

	// Force a fresh check whenever Dashboard → Updates (update-core.php) or
	// Appearance → Themes (themes.php) loads, so a push shows up immediately
	// instead of waiting for the default 12-hour / cached check to expire.
	add_action( 'load-update-core.php', function () { global $lgfThemeUpdater; $lgfThemeUpdater->checkForUpdates(); } );
	add_action( 'load-themes.php', function () { global $lgfThemeUpdater; $lgfThemeUpdater->checkForUpdates(); } );

	// Diagnostic probe: log into wp-admin, then open /?lgf_probe=1
	add_action( 'init', function () {
		if ( isset( $_GET['lgf_probe'] ) && current_user_can( 'manage_options' ) ) {
			header( 'Content-Type: text/plain; charset=utf-8' );
			$theme = wp_get_theme();
			echo 'Theme folder: ' . $theme->get_template() . PHP_EOL;
			echo 'Theme name:   ' . $theme->get( 'Name' ) . PHP_EOL;
			echo 'Installed version (style.css): ' . $theme->get( 'Version' ) . PHP_EOL;
			echo 'PUC lib present: ' . ( file_exists( get_stylesheet_directory() . '/lib/plugin-update-checker/plugin-update-checker.php' ) ? 'yes' : 'NO' ) . PHP_EOL;
			$check = null;
			if ( isset( $GLOBALS['lgfThemeUpdater'] ) ) {
				$check = $GLOBALS['lgfThemeUpdater']->checkForUpdates();
			}
			echo 'Updater active: ' . ( isset( $GLOBALS['lgfThemeUpdater'] ) ? 'yes' : 'NO' ) . PHP_EOL;
			echo 'Forced check result: ' . ( is_object( $check ) ? 'update found' : 'none / failed' ) . PHP_EOL;
			if ( is_object( $check ) ) {
				echo 'Update version: ' . $check->version . PHP_EOL;
				echo 'Update from:    ' . $check->download_url . PHP_EOL;
			}
			exit;
		}
	}, 9 );
}

// Enqueue the parent theme's styles
function kadence_child_enqueue_styles() {
    wp_enqueue_style('kadence-parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('kadence-child-style', get_stylesheet_directory_uri() . '/style.css', array('kadence-parent-style'));
}
add_action('wp_enqueue_scripts', 'kadence_child_enqueue_styles');

// Cycling landing pages are now regular Gutenberg pages that reuse the
// custom classes below, so the styles always load (front end + editor).
function lgf_enqueue_cycling_assets() {
	wp_register_style(
		'lgf-cycling-itineraries',
		get_stylesheet_directory_uri() . '/assets/css/cycling-itineraries.css',
		array( 'kadence-child-style' ),
		'1.0.28'
	);
	wp_register_style(
		'lgf-cycling-palette',
		get_stylesheet_directory_uri() . '/assets/css/cycling-palette.css',
		array( 'lgf-cycling-itineraries' ),
		'1.0.28'
	);

	wp_enqueue_style( 'lgf-cycling-itineraries' );
	wp_enqueue_style( 'lgf-cycling-palette' );
}
add_action( 'wp_enqueue_scripts', 'lgf_enqueue_cycling_assets' );

// Make the cycling design render correctly inside the block editor.
function lgf_enqueue_cycling_editor_assets() {
	wp_enqueue_style(
		'lgf-cycling-itineraries',
		get_stylesheet_directory_uri() . '/assets/css/cycling-itineraries.css',
		array(),
		'1.0.28'
	);
	wp_enqueue_style(
		'lgf-cycling-palette',
		get_stylesheet_directory_uri() . '/assets/css/cycling-palette.css',
		array( 'lgf-cycling-itineraries' ),
		'1.0.28'
	);
}
add_action( 'enqueue_block_editor_assets', 'lgf_enqueue_cycling_editor_assets' );

require_once get_stylesheet_directory() . '/inc/cycling-patterns.php';
require_once get_stylesheet_directory() . '/inc/cycling-admin.php';
require_once get_stylesheet_directory() . '/inc/motopress-polylang.php';


// Language Detection - Simple, but can be improved with more sophisticated methods
function get_user_language() {
  if (isset($_GET['lang'])) {
    return sanitize_text_field($_GET['lang']);
  }

  // Default to browser language if not specified in URL
  return apply_filters( 'preferred_locale', function() {
    return isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? str_replace([';', '/'], '', explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'])[0]) : '';
  });
}

// Function to switch the language and update the menu
function kadence_language_switcher() {
  $user_language = get_user_language();

  if (empty($user_language)) {
    return; // Don't do anything if no language is selected
  }

  // Check which menu to display based on language
  if ($user_language === 'fr') {
    $menu_slug = 'primary'; // Or whatever your main menu slug is in Kadence
  } else {
    $menu_slug = 'primary'; // Again, adjust if needed.
  }

  // Get the menu object
  $menus = wp_get_nav_menus( array('theme_slug' => 'kadence') ); // Important: Specify theme slug
  if ( ! empty( $menus ) ) {
    foreach ( $menus as $menu ) {
      if ( strpos( $menu->slug, $menu_slug ) === 0 ) { // Check if the menu slug matches
        wp_update_nav_menu_item( $menu->ID, 0, array( 'menu-name' => $user_language ));  // Update first item. Adjust as needed.
        break;
      }
    }
  }

}
add_action('wp_footer', 'kadence_language_switcher'); // Run on footer for menu update


// Search results: relabel each room card's "Book" button as "Ajouter à ma sélection"
// so guests understand they can build their own combination. The recommendation
// block keeps its own "Réserver" button (source string is "Reserve").
function lgf_search_results_book_button_label( $translation, $text, $domain ) {
	if ( 'motopress-hotel-booking' === $domain && 'Book' === $text
		&& function_exists( 'mphb_is_search_results_page' ) && mphb_is_search_results_page()
		&& function_exists( 'MPHB' ) && ! MPHB()->settings()->main()->isDirectSearchResultsBooking() ) {
		return function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' )
			? 'Add to selection'
			: 'Ajouter à ma sélection';
	}
	return $translation;
}
add_filter( 'gettext', 'lgf_search_results_book_button_label', 10, 3 );


// Search results: hide the "Prices start at:" label in front of card prices.
function lgf_search_results_hide_price_label( $translation, $text, $domain ) {
	if ( 'motopress-hotel-booking' === $domain && 'Prices start at:' === $text
		&& function_exists( 'mphb_is_search_results_page' ) && mphb_is_search_results_page() ) {
		return '';
	}
	return $translation;
}
add_filter( 'gettext', 'lgf_search_results_hide_price_label', 10, 3 );

// Checkout: shorten the booking-details heading.
function lgf_checkout_booking_details_title( $translation, $text, $domain ) {
	if ( 'motopress-hotel-booking' === $domain && 'Booking Details' === $text
		&& function_exists( 'mphb_is_checkout_page' ) && mphb_is_checkout_page() ) {
		return function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' )
			? 'Your stay'
			: 'Réservation';
	}
	return $translation;
}
add_filter( 'gettext', 'lgf_checkout_booking_details_title', 10, 3 );


// Search results: the reservation cart replaces the recommendation block and is
// pre-filled with the recommended combination (see assets/js/lgf-search-results.js).
function lgf_search_results_cart_title() {
	return function_exists( 'pll_current_language' ) && 'en' === pll_current_language( 'slug' )
		? 'Your selection'
		: 'Votre sélection';
}
add_filter( 'mphb_sc_search_results_reservation_cart_title', 'lgf_search_results_cart_title' );

function lgf_enqueue_search_results_script() {
	if ( function_exists( 'mphb_is_search_results_page' ) && mphb_is_search_results_page() ) {
		wp_enqueue_style(
			'lgf-search-results',
			get_stylesheet_directory_uri() . '/assets/css/lgf-search-results.css',
			array(),
			'1.0.28'
		);
		wp_enqueue_script(
			'lgf-search-results',
			get_stylesheet_directory_uri() . '/assets/js/lgf-search-results.js',
			array( 'jquery', 'mphb' ),
			'1.0.28',
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'lgf_enqueue_search_results_script' );

// Checkout (MotoPress premium): two-column layout + summary card. Reuses the
// search-results stylesheet (page-targeted selectors, no JS needed).
function lgf_enqueue_checkout_css() {
	if ( function_exists( 'mphb_is_checkout_page' ) && mphb_is_checkout_page() ) {
		wp_enqueue_style(
			'lgf-search-results',
			get_stylesheet_directory_uri() . '/assets/css/lgf-search-results.css',
			array(),
			'1.0.28'
		);
		wp_enqueue_script(
			'lgf-checkout',
			get_stylesheet_directory_uri() . '/assets/js/lgf-checkout.js',
			array( 'jquery', 'mphb' ),
			'1.0.28',
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'lgf_enqueue_checkout_css' );
