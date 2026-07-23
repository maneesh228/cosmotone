<?php
/**
 * Single Service template.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;
get_header();
$cosmotone_service_id = get_queried_object_id();
require get_template_directory() . '/template-parts/service-detail.php';
get_footer();

