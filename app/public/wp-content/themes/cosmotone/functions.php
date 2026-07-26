<?php
/**
 * Theme setup.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

require_once get_template_directory() . '/inc/sliders.php';
require_once get_template_directory() . '/inc/page-sections.php';
require_once get_template_directory() . '/inc/home-sections.php';
require_once get_template_directory() . '/inc/catalog.php';
require_once get_template_directory() . '/inc/testimonials.php';
require_once get_template_directory() . '/inc/resources.php';
require_once get_template_directory() . '/inc/certificates.php';
require_once get_template_directory() . '/inc/subscribers.php';

function cosmotone_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'cosmotone_setup' );

/**
 * Create the pages represented by the supplied static-demo navigation.
 * Existing pages are preserved.
 */
function cosmotone_create_theme_pages() {
	$pages = array(
		'home'     => 'Home',
		'about-us' => 'About Us',
		'services' => 'Services',
		'products' => 'Products',
		'career'   => 'Career',
		'news'     => 'News & Articles',
		'contact'  => 'Contact',
		'product-details' => 'Product Details',
		'service-details' => 'Service Details',
		'news-details'    => 'News Details',
		'downloads'       => 'Downloads',
		'media'           => 'Media',
		'header'          => 'Header',
		'footer'          => 'Footer',
		'cta'             => 'CTA',
	);

	foreach ( $pages as $slug => $title ) {
		if ( ! get_page_by_path( $slug, OBJECT, 'page' ) ) {
			wp_insert_post(
				array(
					'post_title'  => $title,
					'post_name'   => $slug,
					'post_type'   => 'page',
					'post_status' => in_array( $slug, array( 'header', 'footer', 'cta' ), true ) ? 'private' : 'publish',
				)
			);
		}
	}

	$home_page = get_page_by_path( 'home', OBJECT, 'page' );
	if ( $home_page && ( 'page' !== get_option( 'show_on_front' ) || ! get_option( 'page_on_front' ) ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $home_page->ID );
	}

	flush_rewrite_rules();
	update_option( 'cosmotone_pages_version', '1.6.0' );
}
add_action( 'after_switch_theme', 'cosmotone_create_theme_pages' );

/** Create pages once for installations where the theme was already active. */
function cosmotone_maybe_create_theme_pages() {
	if ( '1.6.0' !== get_option( 'cosmotone_pages_version' ) ) {
		cosmotone_create_theme_pages();
	}
}
add_action( 'init', 'cosmotone_maybe_create_theme_pages' );
