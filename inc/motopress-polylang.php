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

function lgf_motopress_customer_fields_for_english( $fields ) {
	if ( ! function_exists( 'pll_current_language' ) || 'en' !== pll_current_language( 'slug' ) || ! function_exists( 'mphb_get_default_customer_fields' ) ) {
		return $fields;
	}

	if ( ! is_array( $fields ) ) {
		$fields = array();
	}
	foreach ( mphb_get_default_customer_fields() as $name => $field ) {
		if ( ! isset( $fields[ $name ] ) || empty( $fields[ $name ]['enabled'] ) ) {
			$fields[ $name ] = $field;
		}
	}
	if ( ! isset( $fields['arrival-time'] ) ) {
		$fields['arrival-time'] = array(
			'label'    => 'Arrival time',
			'type'     => 'select',
			'enabled'  => true,
			'required' => true,
			'labels'   => array( 'required_error' => 'Please select an arrival time.' ),
		);
	}
	return $fields;
}
add_filter( 'mphb_customer_fields', 'lgf_motopress_customer_fields_for_english', 9999 );

function lgf_motopress_checkout_customer_fields_fallback( $output, $tag ) {
	if ( ! is_string( $output ) || 'mphb_checkout' !== $tag || ( is_admin() && ! wp_doing_ajax() ) || ! function_exists( 'MPHB' ) ) {
		return $output;
	}

	$section_start = strpos( $output, '<section id="mphb-customer-details"' );
	$section_end   = false !== $section_start ? strpos( $output, '</section>', $section_start ) : false;
	if ( false === $section_start || false === $section_end ) {
		return $output;
	}

	$section = substr( $output, $section_start, $section_end - $section_start );
	if ( false !== strpos( $section, 'id="mphb_email"' ) ) {
		return $output;
	}

	$settings = MPHB()->settings()->main();
	$required = ' required="required"';
	$fields   = '';
	$specs    = array(
		'first_name' => array( 'First Name', 'mphb-customer-name', 'text' ),
		'last_name'  => array( 'Last Name', 'mphb-customer-last-name', 'text' ),
		'email'      => array( 'Email', 'mphb-customer-email', 'email' ),
		'phone'      => array( 'Phone', 'mphb-customer-phone', 'text' ),
	);
	if ( false === strpos( $section, 'id="mphb_arrival-time"' ) ) {
		$fields .= '<p class="mphb-customer-arrival-time"><label for="mphb_arrival-time">' . esc_html__( 'Arrival time', 'motopress-hotel-booking' ) . ' <abbr title="' . esc_attr__( 'Required', 'motopress-hotel-booking' ) . '">*</abbr></label><br /><select name="mphb_arrival-time" id="mphb_arrival-time" required="required"><option value="">' . esc_html__( 'Select a time', 'motopress-hotel-booking' ) . '</option><option value="je ne sais pas">' . esc_html__( 'Not sure yet', 'motopress-hotel-booking' ) . '</option><option value="15H00 - 17H00">15:00 - 17:00</option><option value="17H00 - 19H00">17:00 - 19:00</option><option value="19H00 - 21H00">19:00 - 21:00</option><option value="21H00 - 22H00">21:00 - 22:00</option></select></p>';
	}

	foreach ( $specs as $name => $spec ) {
		$id = 'mphb_' . $name;
		if ( false !== strpos( $section, 'id="' . $id . '"' ) ) {
			continue;
		}
		$label = esc_html__( $spec[0], 'motopress-hotel-booking' );
		$fields .= '<p class="' . esc_attr( $spec[1] ) . '"><label for="' . esc_attr( $id ) . '">' . $label . ' <abbr title="' . esc_attr__( 'Required', 'motopress-hotel-booking' ) . '">*</abbr></label><br /><input type="' . esc_attr( $spec[2] ) . '" name="' . esc_attr( $id ) . '" id="' . esc_attr( $id ) . '"' . $required . ' /></p>';
	}

	if ( $settings->isRequireCountry() && false === strpos( $section, 'id="mphb_country"' ) ) {
		$country_id = 'mphb_country';
		$country    = $settings->getDefaultCountry();
		$fields    .= '<p class="mphb-customer-country"><label for="' . esc_attr( $country_id ) . '">' . esc_html__( 'Country of residence', 'motopress-hotel-booking' ) . ' <abbr title="' . esc_attr__( 'Required', 'motopress-hotel-booking' ) . '">*</abbr></label><br /><select name="' . esc_attr( $country_id ) . '" id="' . esc_attr( $country_id ) . '"' . $required . '><option value=""></option>';
		foreach ( $settings->getCountriesBundle()->getCountriesList() as $code => $label ) {
			$fields .= '<option value="' . esc_attr( $code ) . '"' . selected( $country, $code, false ) . '>' . esc_html( $label ) . '</option>';
		}
		$fields .= '</select></p>';
	}

	if ( $settings->isRequireFullAddress() ) {
		$address_fields = array(
			'address1' => array( 'Address', 'mphb-customer-address1' ),
			'city'     => array( 'City', 'mphb-customer-city' ),
			'state'    => array( 'State / County', 'mphb-customer-state' ),
			'zip'      => array( 'Postcode', 'mphb-customer-zip' ),
		);
		foreach ( $address_fields as $name => $spec ) {
			$id = 'mphb_' . $name;
			if ( false !== strpos( $section, 'id="' . $id . '"' ) ) {
				continue;
			}
			$fields .= '<p class="' . esc_attr( $spec[1] ) . '"><label for="' . esc_attr( $id ) . '">' . esc_html__( $spec[0], 'motopress-hotel-booking' ) . ' <abbr title="' . esc_attr__( 'Required', 'motopress-hotel-booking' ) . '">*</abbr></label><br /><input type="text" name="' . esc_attr( $id ) . '" id="' . esc_attr( $id ) . '"' . $required . ' /></p>';
		}
	}

	if ( false === strpos( $section, 'id="mphb_note"' ) ) {
		$fields .= '<p class="mphb-customer-note"><label for="mphb_note">' . esc_html__( 'Notes', 'motopress-hotel-booking' ) . '</label><br /><textarea name="mphb_note" id="mphb_note" rows="4"></textarea></p>';
	}

	$tip_start = strpos( $output, 'class="mphb-required-fields-tip"', $section_start );
	$tip_end   = false !== $tip_start ? strpos( $output, '</p>', $tip_start ) : false;
	if ( false === $tip_end || $tip_end > $section_end ) {
		$tip_end = $section_start + strlen( '<section id="mphb-customer-details" class="mphb-checkout-section mphb-customer-details">' );
		$insert_at = $tip_end;
	} else {
		$insert_at = $tip_end + strlen( '</p>' );
	}
	return substr( $output, 0, $insert_at ) . $fields . substr( $output, $insert_at );
}
add_filter( 'do_shortcode_tag', 'lgf_motopress_checkout_customer_fields_fallback', 999, 4 );
