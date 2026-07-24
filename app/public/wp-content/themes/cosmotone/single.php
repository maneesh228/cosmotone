<?php
/**
 * Standard post detail template.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( have_posts() ) {
	the_post();
	ob_start();
	get_template_part( 'template-parts/news-detail' );
	$markup      = ob_get_clean();
	$details_page = get_page_by_path( 'news-details' );
	$settings_id  = $details_page instanceof WP_Post ? $details_page->ID : 0;
	echo $settings_id ? cosmotone_apply_page_section_fields( $markup, $settings_id, 'news-details' ) : $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

get_footer();
