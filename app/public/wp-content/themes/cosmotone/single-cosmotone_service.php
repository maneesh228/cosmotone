<?php
/**
 * Single Service template.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;
get_header();
$cosmotone_service_id = get_queried_object_id();
ob_start();
require get_template_directory() . '/template-parts/service-detail.php';
$markup        = ob_get_clean();
$details_page = get_page_by_path( 'service-details' );
$settings_id  = $details_page instanceof WP_Post ? $details_page->ID : 0;
echo $settings_id ? cosmotone_apply_page_section_fields( $markup, $settings_id, 'service-details' ) : $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
get_footer();
