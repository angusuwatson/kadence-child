<?php
/**
 * Available variables
 * - array $errors Array of error messages
 *
 * @version 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$errors = array_map(
	function( $error ) {
		/**
		 * @hooked \MPHB\Views\GlobalView::prependBr - 10
		 */
		return apply_filters( 'mphb_sc_search_results_error', $error );
	},
	$errors
);

$errorsWrapperClass = apply_filters( 'mphb_sc_search_results_errors_wrapper_class', 'mphb-errors-wrapper' );
?>
<div class="<?php echo esc_attr( $errorsWrapperClass ); ?>">
	<div class="mphb-errors-card">
		<h3 class="mphb-errors-card-title"><?php esc_html_e( 'Aucun logement disponible pour ces dates', 'motopress-hotel-booking' ); ?></h3>
		<ul class="mphb-errors-card-list">
			<?php foreach ( $errors as $error ) : ?>
				<li><?php echo wp_kses_post( preg_replace( '/^(\s*<br\s*\/?\s*>)+/i', '', $error ) ); ?></li>
			<?php endforeach; ?>
		</ul>
		<a class="button mphb-errors-card-link" href="<?php echo esc_url( home_url( '/rechercher-la-disponibilite/' ) ); ?>">
			<?php esc_html_e( 'Modifier ma recherche', 'motopress-hotel-booking' ); ?>
		</a>
	</div>
</div>