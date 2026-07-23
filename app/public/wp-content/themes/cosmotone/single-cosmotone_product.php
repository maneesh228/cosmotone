<?php
/**
 * Single Product template.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;
get_header();

$cosmotone_product_id = get_queried_object_id();
require get_template_directory() . '/template-parts/product-detail.php';

get_footer();
