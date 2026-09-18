<?php
/**
 * Kadence Child — coller ce fichier en entier à la place de functions.php.
 * Cause de l'erreur critique : l'ancien fichier avait tout le contenu d'origine
 * EN DOUBLE (fonctions redéclarées). Ce fichier ne contient chaque fonction
 * qu'une seule fois.
 */

// ==========================================================================
// Auto-updates from GitHub (plugin-update-checker by Janis Elsts).
// Remplacez USERNAME/kadence-child par votre dépôt. Ne mettez JAMAIS de
// secret dans ce thème. `use` doit rester tout en haut du fichier.
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


// Language Detection - Simple, but can be improved with more sophisticated methods
function get_user_language() {
  if ( isset( $_GET['lang'] ) ) {
    return sanitize_text_field( $_GET['lang'] );
  }

  // Default to browser language if not specified in URL
  $preferred_locale = isset( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) ? strtolower( str_replace( array(';', '/'), '', explode( ',', $_SERVER['HTTP_ACCEPT_LANGUAGE'] )[0] ) ) : '';
  return apply_filters( 'preferred_locale', $preferred_locale );
}

// Function to switch the language and update the menu
function kadence_language_switcher() {
  $user_language = get_user_language();

  if ( empty( $user_language ) || ! is_string( $user_language ) ) {
    return; // Don't do anything if no language is selected
  }

  if ( strpos( $user_language, 'fr' ) !== 0 && strpos( $user_language, 'FR' ) !== 0 ) {
    $user_language = 'en';
  } else {
    $user_language = 'fr';
  }

  // Get the menu object
  $menus = wp_get_nav_menus();
  if ( ! empty( $menus ) ) {
    foreach ( $menus as $menu ) {
      if ( isset( $menu->slug ) && strpos( $menu->slug, 'primary' ) === 0 ) {
        wp_update_nav_menu_item( $menu->ID, 0, array( 'menu-name' => $user_language ) );
        break;
      }
    }
  }
}
add_action('wp_footer', 'kadence_language_switcher'); // Run on footer for menu update

/* La Grange Fleurie — Bed and breakfast schema */
add_action('wp_head', 'lgf_bnb_schema');
function lgf_bnb_schema() {
    if ( ! is_front_page() ) {
        return;
    }
?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BedAndBreakfast",
  "@id": "https://lagrangefleurie.fr/",
  "name": "La Grange Fleurie",
  "description": "Chambre d'hôtes à Tramayes, Bourgogne du Sud — 5 chambres avec vue sur la vallée du Valouzin, petit-déjeuner fait maison et table d'hôtes.",
  "url": "https://lagrangefleurie.fr/",
  "image": [
    "https://lagrangefleurie.fr/wp-content/uploads/2025/04/lagrangefleurie-view.jpg",
    "https://lagrangefleurie.fr/bookings/wp-content/uploads/2024/10/lagrangefleurie-salon.jpg",
    "https://lagrangefleurie.fr/bookings/wp-content/uploads/2024/10/lagrangefleurie-foyer.jpg"
  ],
  "telephone": "+33385505936",
  "email": "bonjour@lagrangefleurie.fr",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "10 Route des Pierres Blanches",
    "addressLocality": "Tramayes",
    "postalCode": "71520",
    "addressRegion": "Bourgogne-Franche-Comté",
    "addressCountry": "FR"
  },
  "geo": { "@type": "GeoCoordinates", "latitude": 46.308865, "longitude": 4.6769256 },
  "priceRange": "99€ - 156€ / nuit",
  "numberOfRooms": 5,
  "checkinTime": "15:00",
  "checkoutTime": "10:00",
  "petsAllowed": false,
  "amenityFeature": [
    { "@type": "LocationFeatureSpecification", "name": "Free WiFi", "value": true },
    { "@type": "LocationFeatureSpecification", "name": "Breakfast", "value": true },
    { "@type": "LocationFeatureSpecification", "name": "Free Parking", "value": true },
    { "@type": "LocationFeatureSpecification", "name": "Garden", "value": true },
    { "@type": "LocationFeatureSpecification", "name": "Family Rooms", "value": true }
  ]
}
</script>
<?php
}

// Search results: relabel each room card's "Book" button as "Ajouter à ma sélection"
// so guests understand they can build their own combination. The recommendation
// block keeps its own "Réserver" button (source string is "Reserve").
function lgf_search_results_book_button_label( $translation, $text, $domain ) {
	if ( 'motopress-hotel-booking' === $domain && 'Book' === $text
		&& function_exists( 'mphb_is_search_results_page' ) && mphb_is_search_results_page()
		&& function_exists( 'MPHB' ) && ! MPHB()->settings()->main()->isDirectSearchResultsBooking() ) {
		return 'Ajouter à ma sélection';
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


// Search results: the reservation cart replaces the recommendation block and is
// pre-filled with the recommended combination (see assets/js/lgf-search-results.js).
function lgf_search_results_cart_title() {
	return 'Votre sélection';
}
add_filter( 'mphb_sc_search_results_reservation_cart_title', 'lgf_search_results_cart_title' );

function lgf_enqueue_search_results_script() {
	if ( function_exists( 'mphb_is_search_results_page' ) && mphb_is_search_results_page() ) {
		wp_enqueue_style(
			'lgf-search-results',
			get_stylesheet_directory_uri() . '/assets/css/lgf-search-results.css',
			array(),
			'1.0.3'
		);
		wp_enqueue_script(
			'lgf-search-results',
			get_stylesheet_directory_uri() . '/assets/js/lgf-search-results.js',
			array( 'jquery', 'mphb' ),
			'1.0.3',
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'lgf_enqueue_search_results_script' );