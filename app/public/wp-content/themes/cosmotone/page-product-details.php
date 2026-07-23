<?php
/**
 * Fallback Product Details page template.
 *
 * Product cards use the product post type's single template. This page remains
 * available for an explicitly-created WordPress page and accepts ?product=ID.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;
get_header();

$cosmotone_product_id = isset( $_GET['product'] ) ? absint( wp_unslash( $_GET['product'] ) ) : 0;
if ( ! $cosmotone_product_id ) {
	$products = cosmotone_get_products( 1 );
	if ( $products->have_posts() ) {
		$products->the_post();
		$cosmotone_product_id = get_the_ID();
		wp_reset_postdata();
	}
}

require get_template_directory() . '/template-parts/product-detail.php';
get_footer();
