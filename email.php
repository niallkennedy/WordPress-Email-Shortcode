<?php
/**
 * @package email
 */
/*
Plugin Name: Email
Plugin URI: http://www.niallkennedy.com/
Description: Email spammers are bad. Hide your address.
Version: 1.0
Author: niallkennedy
Author URI: http://www.niallkennedy.com/
License: GPLv3
*/

/**
 * Display an obfuscated email address in place of a shortcode
 *
 * @param array $atts shortcode attributes
 * @return string HTML markup
 */
function display_email( array $atts ) {
	extract( shortcode_atts( array(
		'address' => '',
		'subject' => '',
		'body' => ''
	), $atts ) );

	if ( empty( $address ) )
		return '';

	$url = 'mailto:' . $address;

	$parts = array();
	if ( ! empty( $subject ) )
		$parts['subject'] = trim( $subject );
	if ( ! empty( $body ) )
		$parts['body'] = trim( $body );
	if ( ! empty( $parts ) ) {
		$url .= '?' . http_build_query( $parts, null, '&' );
	}
	unset( $parts, $subject, $body );

	$html = '<p id="adr"></p><script type="text/javascript">';
	$html .= 'var el = jQuery("<a>");';
	$html .= 'el.attr("href","mailto:' . esc_url( $url, array( 'mailto' ) ) . '");';
	$html .= 'el.text("' . esc_html( $address ) . '");';
	$html .= 'jQuery("#adr").append(el);el=null;';
	$html .= '</script>';

	return $html;
}
add_shortcode( 'email', 'display_email' );

?>