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
require_once get_template_directory() . '/inc/product-importer.php';
require_once get_template_directory() . '/inc/testimonials.php';
require_once get_template_directory() . '/inc/resources.php';
require_once get_template_directory() . '/inc/certificates.php';
require_once get_template_directory() . '/inc/subscribers.php';
require_once get_template_directory() . '/inc/faqs.php';

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
		'faq'             => 'FAQ',
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
	update_option( 'cosmotone_pages_version', '1.7.0' );
}
add_action( 'after_switch_theme', 'cosmotone_create_theme_pages' );

/** Create pages once for installations where the theme was already active. */
function cosmotone_maybe_create_theme_pages() {
	if ( '1.7.0' !== get_option( 'cosmotone_pages_version' ) ) {
		cosmotone_create_theme_pages();
	}
}
add_action( 'init', 'cosmotone_maybe_create_theme_pages' );

/**
 * Lazy-load images in rendered markup and let browsers pick a resized copy of uploaded images.
 *
 * Section fields store the full "-scaled" upload URL (often 1MB+), sometimes on the old
 * http://cosmotone.in host, which costs a redirect per image.
 *
 * @param string $markup     Rendered HTML.
 * @param string $lazy_after Images before this marker stay eager (above the fold). Empty = lazy-load all.
 * @param string $sizes      sizes attribute for uploaded images given a srcset.
 * @return string
 */
function cosmotone_optimize_markup_images( $markup, $lazy_after = '', $sizes = '(max-width: 767px) 100vw, 768px' ) {
	$split = $lazy_after ? strpos( $markup, $lazy_after ) : 0;
	if ( false === $split ) {
		$split = 0;
	}
	$uploads_url = wp_get_upload_dir()['baseurl'];
	$images      = new WP_HTML_Tag_Processor( substr( $markup, $split ) );
	while ( $images->next_tag( 'IMG' ) ) {
		$src = (string) $images->get_attribute( 'src' );
		if ( preg_match( '#/wp-content/uploads/(.+)$#', $src, $match ) ) {
			$src = $uploads_url . '/' . $match[1];
			$images->set_attribute( 'src', $src );
			$attachment_id = attachment_url_to_postid( $src );
			$srcset        = $attachment_id ? wp_get_attachment_image_srcset( $attachment_id, 'full' ) : false;
			if ( $srcset && null === $images->get_attribute( 'srcset' ) ) {
				$images->set_attribute( 'srcset', $srcset );
				$images->set_attribute( 'sizes', $sizes );
			}
		}
		if ( null === $images->get_attribute( 'loading' ) ) {
			$images->set_attribute( 'loading', 'lazy' );
		}
		$images->set_attribute( 'decoding', 'async' );
	}
	return substr( $markup, 0, $split ) . $images->get_updated_html();
}

/**
 * Drop plugin <script>/<link> tags a page's markup doesn't use.
 *
 * header.php/footer.php print every theme library on every page. Each entry maps asset
 * paths to a pattern that marks the plugin as needed; with no match the tags are removed.
 * A null pattern means no template uses the plugin at all.
 *
 * @param string $html Full page HTML.
 * @return string
 */
function cosmotone_prune_unused_assets( $html ) {
	if ( false === stripos( $html, '</html>' ) ) {
		return $html; // Not a full page (error output, partial response).
	}
	$rules = array(
		'#class="[^"]*\bswiper-wrapper\b#'                                         => array( 'assets/js/swiper-bundle.js', 'assets/css/swiper-bundle.css' ),
		'#class="[^"]*\b(?:popup-image|popup-video|tp-product-popup-image)\b#'     => array( 'assets/js/magnific-popup.js', 'assets/css/magnific-popup.css' ),
		'#<select\b(?![^>]*cosmotone-native-select)#i'                              => array( 'assets/js/nice-select.js' ),
		'#class="[^"]*\bpurecounter\b#'                                            => array( 'assets/js/purecounter.js' ),
		'#class="[^"]*\bjarallax\b#'                                               => array( 'assets/js/jarallax.js' ),
		'#class="(?:[^"]*\s)?grid[\s"]#'                                           => array( 'assets/js/isotope-pkgd.js', 'assets/js/imagesloaded-pkgd.js' ),
		'#id="contact-form"#'                                                      => array( 'assets/js/ajax-form.js' ),
	);
	$unused = array( 'assets/js/slick.js', 'assets/css/slick.css', 'assets/js/vendor/waypoints.js' );
	foreach ( $rules as $pattern => $assets ) {
		if ( ! preg_match( $pattern, $html ) ) {
			$unused = array_merge( $unused, $assets );
		}
	}
	foreach ( $unused as $asset ) {
		$file = preg_quote( $asset, '#' );
		$html = preg_replace( '#<script[^>]*\ssrc="[^"]*/' . $file . '[^"]*"[^>]*></script>\s*#', '', $html );
		$html = preg_replace( '#<link[^>]*\shref="[^"]*/' . $file . '[^"]*"[^>]*>\s*#', '', $html );
	}
	// Contact Form 7 enqueues its files on every page; keep them only where a form renders.
	if ( false === strpos( $html, 'class="wpcf7' ) ) {
		$html = preg_replace( '#<link[^>]*id=[\'"]contact-form-7-css[\'"][^>]*>\s*#', '', $html );
		// wp-hooks / wp-i18n are only enqueued on the front end as Contact Form 7 dependencies.
		$html = preg_replace( '#<script[^>]*id=[\'"](?:swv-js|contact-form-7-js(?:-before|-translations)?|wp-hooks-js|wp-i18n-js(?:-after)?)[\'"][^>]*>.*?</script>\s*#s', '', $html );
	}
	return $html;
}

function cosmotone_start_asset_pruning() {
	if ( is_admin() || wp_doing_ajax() || is_feed() || is_customize_preview() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	ob_start( 'cosmotone_prune_unused_assets' );
}
add_action( 'template_redirect', 'cosmotone_start_asset_pruning', 1 );

/**
 * Get header section logo image URL.
 *
 * @return string The logo image URL, or empty string if not found.
 */
function cosmotone_get_header_logo_url() {
	$header_page = get_page_by_path( 'header', OBJECT, 'page' );
	if ( ! $header_page ) {
		return '';
	}

	$sections = get_post_meta( $header_page->ID, '_cosmotone_page_sections', true );
	if ( ! is_array( $sections ) || ! isset( $sections['header-main']['images'][0]['url'] ) ) {
		return '';
	}

	$image_url = $sections['header-main']['images'][0]['url'];
	if ( empty( $image_url ) ) {
		return '';
	}

	// Normalize the URL
	$image_url = trim( $image_url );
	if ( preg_match( '#^https?://assets/(.+)$#i', $image_url, $match ) ) {
		$image_url = 'assets/' . $match[1];
	}

	// Return as full URL if it's relative
	if ( ! preg_match( '#^https?://#i', $image_url ) ) {
		$image_url = esc_url_raw( trailingslashit( get_template_directory_uri() ) . ltrim( $image_url, '/' ) );
	}

	return esc_url( $image_url );
}
