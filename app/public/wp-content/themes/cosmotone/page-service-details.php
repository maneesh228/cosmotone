<?php
/**
 * Fallback Service Details page template.
 *
 * Individual cards use the single Service URL. This page displays a selected
 * service from ?service=ID, or the first published service when opened directly.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;
get_header();
$cosmotone_service_id = isset( $_GET['service'] ) ? absint( $_GET['service'] ) : 0;
if ( ! $cosmotone_service_id ) {
	$service_query = cosmotone_get_services( 1 );
	$cosmotone_service_id = $service_query->have_posts() ? absint( $service_query->posts[0]->ID ) : 0;
}
ob_start();
require get_template_directory() . '/template-parts/service-detail.php';
$markup = ob_get_clean();
echo cosmotone_apply_page_section_fields( $markup, get_queried_object_id(), 'service-details' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
get_footer();
