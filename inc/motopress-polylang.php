<?php

function lgf_motopress_translate_page_id( $page_id ) {
	if ( ( is_admin() && ! wp_doing_ajax() ) || ! function_exists( 'pll_current_language' ) || ! function_exists( 'pll_get_post' ) ) {
		return $page_id;
	}

	$language = pll_current_language( 'slug' );
	if ( ! $language ) {
		return $page_id;
	}

	$translated_id = pll_get_post( (int) $page_id, $language );
	return $translated_id ? (int) $translated_id : $page_id;
}
add_filter( '_mphb_translate_page_id', 'lgf_motopress_translate_page_id' );
