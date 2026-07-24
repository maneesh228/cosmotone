<?php
/**
 * Structured Page Sections editor for the theme's public pages.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

function cosmotone_page_sections_config() {
	return array(
		'about' => array(
			'slug'     => 'about-us',
			'template' => 'page-about-us.php',
			'sections' => array(
				'breadcrumb' => 'Page Banner', 'about' => 'About',
				'team' => 'Expert Team',
			),
		),
		'services' => array(
			'slug'     => 'services',
			'template' => 'page-services.php',
			'sections' => array( 'breadcrumb' => 'Page Banner' ),
		),
		'products' => array(
			'slug'     => 'products',
			'template' => 'page-products.php',
			'sections' => array( 'breadcrumb' => 'Page Banner' ),
		),
		'product-details' => array(
			'slug'     => 'product-details',
			'template' => 'template-parts/product-detail.php',
			'sections' => array( 'breadcrumb' => 'Page Banner' ),
		),
		'career' => array(
			'slug'     => 'career',
			'template' => 'page-career.php',
			'sections' => array(
				'breadcrumb' => 'Page Banner',
				'career'     => 'Careers',
			),
		),
		'news' => array(
			'slug'     => 'news',
			'template' => 'page-news.php',
			'sections' => array( 'breadcrumb' => 'Page Banner' ),
		),
		'news-details' => array(
			'slug'     => 'news-details',
			'template' => 'template-parts/news-detail.php',
			'sections' => array( 'breadcrumb' => 'Page Banner' ),
		),
		'contact' => array(
			'slug'     => 'contact',
			'template' => 'page-contact.php',
			'sections' => array(
				'breadcrumb' => 'Page Banner',
				'contact'    => 'Contact Information',
				'form'       => 'Enquiry Form',
				'map'        => 'Map',
			),
		),
		'service-details' => array(
			'slug'     => 'service-details',
			'template' => 'template-parts/service-detail.php',
			'sections' => array( 'breadcrumb' => 'Page Banner' ),
		),
		'downloads' => array(
			'slug'     => 'downloads',
			'template' => 'page-downloads.php',
			'sections' => array(
				'breadcrumb' => 'Page Banner',
				'downloads'  => 'Downloads',
			),
		),
		'media' => array(
			'slug'     => 'media',
			'template' => 'page-media.php',
			'sections' => array(
				'breadcrumb' => 'Page Banner',
				'media'      => 'Media',
			),
		),
	);
}

function cosmotone_page_sections_type( $post_id ) {
	$slug = get_post_field( 'post_name', $post_id );
	foreach ( cosmotone_page_sections_config() as $type => $page ) {
		if ( isset( $page['slug'] ) && $slug === $page['slug'] ) {
			return $type;
		}
	}
	return '';
}

function cosmotone_page_section_default_html( $type, $key ) {
	$config = cosmotone_page_sections_config();
	$path   = isset( $config[ $type ]['template'] ) ? get_template_directory() . '/' . $config[ $type ]['template'] : '';
	if ( ! $path || ! is_readable( $path ) ) {
		return '';
	}
	$source  = file_get_contents( $path );
	$pattern = '#<!--\s*' . preg_quote( $key, '#' ) . ' area start\s*-->(.*?)<!--\s*' . preg_quote( $key, '#' ) . ' area end\s*-->#is';
	if ( ! preg_match( $pattern, $source, $match ) ) {
		return '';
	}
	$html = trim( $match[1] );
	$html = preg_replace_callback(
		'#<\?php\s+echo\s+esc_url\(\s*home_url\(\s*[\'\"]([^\'\"]*)[\'\"]\s*\)\s*\);\s*\?>#',
		static function ( $url ) { return esc_url( home_url( $url[1] ) ); },
		$html
	);
	return preg_replace( '#<\?php.*?\?>#s', '', $html );
}

function cosmotone_page_section_dom( $html ) {
	if ( ! class_exists( 'DOMDocument' ) ) {
		return false;
	}
	$document = new DOMDocument( '1.0', 'UTF-8' );
	$old      = libxml_use_internal_errors( true );
	$document->loadHTML( '<?xml encoding="utf-8"?><div id="cosmotone-fields-root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
	libxml_clear_errors();
	libxml_use_internal_errors( $old );
	$xpath = new DOMXPath( $document );
	$root  = $xpath->query( '//*[@id="cosmotone-fields-root"]' )->item( 0 );
	return $root ? array( 'document' => $document, 'xpath' => $xpath, 'root' => $root ) : false;
}

function cosmotone_page_section_nodes( $dom ) {
	$texts = $dom['xpath']->query( './/text()[normalize-space(.) != "" and not(ancestor::script) and not(ancestor::style)]', $dom['root'] );
	$links = $dom['xpath']->query( './/a[@href]', $dom['root'] );
	$media = $dom['xpath']->query( './/img | .//*[@data-background] | .//video[@poster]', $dom['root'] );
	return array(
		'texts' => $texts ? iterator_to_array( $texts ) : array(),
		'links' => $links ? iterator_to_array( $links ) : array(),
		'media' => $media ? iterator_to_array( $media ) : array(),
	);
}

function cosmotone_page_section_text_type( $node ) {
	$tag   = strtolower( $node->parentNode->nodeName );
	$class = $node->parentNode instanceof DOMElement ? strtolower( $node->parentNode->getAttribute( 'class' ) ) : '';
	if ( preg_match( '/^h[1-6]$/', $tag ) ) return 'Heading';
	if ( 'p' === $tag ) return 'Paragraph';
	if ( 'a' === $tag ) return 'Link / button text';
	if ( 'button' === $tag ) return 'Button text';
	if ( 'li' === $tag ) return 'List item';
	if ( false !== strpos( $class, 'subtitle' ) || false !== strpos( $class, 'sub-title' ) ) return 'Subtitle';
	if ( 'span' === $tag ) return 'Label';
	return 'Text';
}

function cosmotone_page_section_media_attr( $node ) {
	if ( 'img' === strtolower( $node->nodeName ) ) return 'src';
	if ( 'video' === strtolower( $node->nodeName ) ) return 'poster';
	return 'data-background';
}

function cosmotone_page_section_dom_html( $dom ) {
	$html = '';
	foreach ( $dom['root']->childNodes as $child ) {
		$html .= $dom['document']->saveHTML( $child );
	}
	return $html;
}

function cosmotone_page_section_normalize_asset_url( $url ) {
	$url = trim( (string) $url );
	if ( preg_match( '#^https?://assets/(.+)$#i', $url, $match ) ) {
		return 'assets/' . $match[1];
	}
	return $url;
}

function cosmotone_sanitize_page_section_media_url( $url ) {
	$url = cosmotone_page_section_normalize_asset_url( $url );
	if ( preg_match( '#^https?://#i', $url ) ) {
		return esc_url_raw( $url );
	}
	return ltrim( sanitize_text_field( $url ), '/' );
}

function cosmotone_sanitize_page_section_link_url( $url ) {
	$url = cosmotone_page_section_normalize_asset_url( $url );
	if ( '' === $url || '#' === $url ) {
		return $url;
	}
	if ( preg_match( '#^https?://#i', $url ) || preg_match( '#^(mailto|tel):#i', $url ) ) {
		return esc_url_raw( $url );
	}
	if ( false !== strpos( $url, ':' ) ) {
		return '';
	}
	return sanitize_text_field( $url );
}

function cosmotone_page_banner_defaults( $type ) {
	$defaults = array(
		'about'     => array( 'BIDDUT ELCETRIC SERVICE', 'About us', 'About us' ),
		'services'  => array( 'COSMOTONE SERVICES', 'Services', 'Services' ),
		'products'  => array( 'COSMOTONE PRODUCT RANGE', 'Products', 'Products' ),
		'career'    => array( 'JOIN COSMOTONE', 'Careers', 'Careers' ),
		'news'      => array( 'NEWS & ARTICLES', 'Our blog', 'Our blog' ),
		'news-details' => array( 'NEWS & ARTICLES', 'Blog details', 'Blog details' ),
		'contact'   => array( 'GET IN TOUCH', 'Contact us', 'Contact us' ),
		'downloads' => array( 'RESOURCE CENTRE', 'Downloads', 'Downloads' ),
		'media'     => array( 'OUR GALLERY', 'Media', 'Media' ),
	);
	return isset( $defaults[ $type ] ) ? $defaults[ $type ] : array( 'COSMOTONE', 'Page', 'Page' );
}

function cosmotone_default_contact_form_shortcode() {
	if ( ! post_type_exists( 'wpcf7_contact_form' ) ) {
		return '';
	}
	$forms = get_posts(
		array(
			'post_type'      => 'wpcf7_contact_form',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'orderby'        => 'date',
			'order'          => 'ASC',
		)
	);
	return $forms ? sprintf( '[contact-form-7 id="%d" title="%s"]', $forms[0]->ID, esc_attr( $forms[0]->post_title ) ) : '';
}

function cosmotone_page_section_custom_schema( $type, $key ) {
	if ( 'breadcrumb' === $key && in_array( $type, array( 'product-details', 'service-details' ), true ) ) {
		$is_product = 'product-details' === $type;
		return array(
			'texts' => array(
				0 => array( 'label' => 'Banner Subtitle', 'default' => $is_product ? 'COSMOTONE PRODUCT' : 'COSMOTONE SERVICE' ),
				2 => array( 'label' => 'Breadcrumb Home Label', 'default' => 'Home' ),
				4 => array( 'label' => 'Breadcrumb Listing Label', 'default' => $is_product ? 'Products' : 'Services' ),
			),
			'links' => array(
				0 => array( 'label' => 'Breadcrumb Home Link', 'default' => home_url( '/' ) ),
				1 => array( 'label' => 'Breadcrumb Listing Link', 'default' => home_url( $is_product ? '/products/' : '/services/' ) ),
			),
			'images' => array(
				0 => array( 'label' => 'Banner Background Image', 'default' => 'assets/img/breadcurmb/breadcurmb.jpg' ),
			),
		);
	}

	if ( 'breadcrumb' === $key ) {
		$defaults = cosmotone_page_banner_defaults( $type );
		return array(
			'texts' => array(
				0 => array( 'label' => 'Banner Subtitle', 'default' => $defaults[0] ),
				1 => array( 'label' => 'Banner Title', 'default' => $defaults[1] ),
				2 => array( 'label' => 'Breadcrumb Home Label', 'default' => 'Home' ),
				4 => array( 'label' => 'Breadcrumb Current Page Label', 'default' => $defaults[2] ),
			),
			'links' => array(
				0 => array( 'label' => 'Breadcrumb Home Link', 'default' => home_url( '/' ) ),
			),
			'images' => array(
				0 => array( 'label' => 'Banner Background Image', 'default' => 'assets/img/breadcurmb/breadcurmb.jpg' ),
			),
		);
	}

	if ( 'career' === $type && 'career' === $key ) {
		return array(
			'texts' => array(
				0 => array( 'label' => 'Section Subtitle', 'default' => 'CAREERS' ),
				1 => array( 'label' => 'Section Heading', 'default' => 'Open Positions' ),
				2 => array( 'label' => 'Section Description', 'default' => 'Build the future of dependable electrical and automotive solutions with our team.', 'type' => 'textarea' ),
			),
		);
	}

	if ( 'downloads' === $type && 'downloads' === $key ) {
		return array(
			'texts' => array(
				0 => array( 'label' => 'Section Subtitle', 'default' => 'DOWNLOADS' ),
				1 => array( 'label' => 'Section Heading', 'default' => 'Product resources' ),
				2 => array( 'label' => 'Section Description', 'default' => 'Access company and product information from our resource centre.', 'type' => 'textarea' ),
			),
		);
	}

	if ( 'media' === $type && 'media' === $key ) {
		return array(
			'texts' => array(
				0 => array( 'label' => 'Section Subtitle', 'default' => 'OUR GALLERY' ),
				1 => array( 'label' => 'Section Heading', 'default' => 'Inside Cosmotone' ),
				2 => array( 'label' => 'Section Description', 'default' => 'Explore our products, facilities, people, and engineering work.', 'type' => 'textarea' ),
				3 => array( 'label' => 'All Filter Label', 'default' => 'All' ),
				4 => array( 'label' => 'Images Filter Label', 'default' => 'Images' ),
				5 => array( 'label' => 'Videos Filter Label', 'default' => 'Videos' ),
			),
		);
	}

	if ( 'contact' === $type && 'contact' === $key ) {
		return array(
			'texts' => array(
				0 => array( 'label' => 'Address Card Title', 'default' => 'Visit our place' ),
				1 => array( 'label' => 'Address (one line per row)', 'default' => "88 New South Head Rd, Triple\nNew York", 'type' => 'textarea', 'indexes' => array( 1, 2 ) ),
				3 => array( 'label' => 'Contact Card Title', 'default' => 'Contact us' ),
				4 => array( 'label' => 'Email Address', 'default' => 'biddut@website.com' ),
				5 => array( 'label' => 'Phone Number', 'default' => '+(602) 762 472 96' ),
				6 => array( 'label' => 'Office Hours Card Title', 'default' => 'Office time' ),
				7 => array( 'label' => 'Office Hours (one line per row)', 'default' => "Five days 8:00 am - 5:00 pm\nFriday is closed", 'type' => 'textarea', 'indexes' => array( 7, 8 ) ),
			),
			'links' => array(
				0 => array( 'label' => 'Address Link', 'default' => '#' ),
				1 => array( 'label' => 'Email Link', 'default' => 'mailto:biddut@website.com' ),
				2 => array( 'label' => 'Phone Link', 'default' => 'tel:+60276247296' ),
				3 => array( 'label' => 'Office Hours Link', 'default' => '#' ),
			),
			'images' => array(
				0 => array( 'label' => 'Address Card Icon', 'default' => 'assets/img/contact/icon-1.png' ),
				1 => array( 'label' => 'Contact Card Icon', 'default' => 'assets/img/contact/icon-2.png' ),
				2 => array( 'label' => 'Office Hours Card Icon', 'default' => 'assets/img/contact/icon-3.png' ),
			),
		);
	}

	if ( 'contact' === $type && 'form' === $key ) {
		return array(
			'texts' => array(
				0 => array( 'label' => 'Form Heading', 'default' => 'Send your message' ),
			),
			'attributes' => array(
				'contact_form_shortcode' => array(
					'label'     => 'Contact Form 7 Shortcode',
					'default'   => cosmotone_default_contact_form_shortcode(),
					'type'      => 'shortcode',
					'xpath'     => './/*[@data-cosmotone-contact-form]',
					'attribute' => 'data-contact-form-shortcode',
				),
			),
		);
	}

	if ( 'contact' === $type && 'map' === $key ) {
		return array(
			'attributes' => array(
				'map_url' => array(
					'label'     => 'Google Maps Embed URL',
					'default'   => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d146513.05509247648!2d73.19133525789097!3d54.98596156928781!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x43aafde2f601090b%3A0x5eefc33861a69b1a!2z4KaT4Kau4Ka44KeN4KaVLCBPbXNrIE9ibGFzdCwg4Kaw4Ka-4Ka24Ka_4Kav4Ka84Ka-!5e0!3m2!1sbn!2sbd!4v1689181288902!5m2!1sbn!2sbd',
					'type'      => 'url',
					'xpath'     => './/iframe',
					'attribute' => 'src',
				),
			),
		);
	}

	if ( 'about' !== $type ) {
		return array();
	}

	if ( 'about' === $key ) {
		return array(
			'texts' => array(
				2  => array( 'label' => 'Experience Label', 'default' => 'Years of experience' ),
				4  => array( 'label' => 'Section Subtitle', 'default' => 'WE ARE BIDDUT ELECTRIC COMPANY' ),
				5  => array( 'label' => 'Section Heading', 'default' => 'Produce your own clean save the environment' ),
				6  => array( 'label' => 'Description', 'default' => 'Nullam eu nibh vitae est tempor molestie id sed ex. Quisque dignissim maximus ipsum, sed rutrum metus tincidunt et. Sed eget tincidunt ipsum. Eget tincidunt', 'type' => 'textarea' ),
				7  => array( 'label' => 'Feature 1 Title (one line per row)', 'default' => "Expert\nelectrician", 'type' => 'textarea', 'indexes' => array( 7, 8 ) ),
				9  => array( 'label' => 'Feature 2 Title (one line per row)', 'default' => "Safety\nassurance", 'type' => 'textarea', 'indexes' => array( 9, 10 ) ),
				11 => array( 'label' => 'List Item 1', 'default' => 'At vero eos et accusamus et iusto odio.' ),
				12 => array( 'label' => 'List Item 2', 'default' => 'Sed ut perspiciatis unde omnis iste natus sit.' ),
				13 => array( 'label' => 'List Item 3', 'default' => 'Established fact that a reader will be distracted.' ),
			),
			'combined_values' => array(
				'experience_value' => array(
					'label'         => 'Experience Number',
					'default'       => '35+',
					'attribute_key' => 'experience_number',
					'text_index'    => 1,
					'default_number' => '35',
					'default_suffix' => '+',
				),
			),
			'attributes' => array(
				'experience_number' => array(
					'label'     => 'Years of Experience Number',
					'default'   => '35',
					'type'      => 'number',
					'admin_visible' => false,
					'xpath'     => './/*[contains(concat(" ", normalize-space(@class), " "), " purecounter ")]',
					'attribute' => 'data-purecounter-end',
				),
			),
			'images' => array(
				0 => array( 'label' => 'Experience Badge Background', 'default' => 'assets/img/about/bg-2.jpg' ),
				1 => array( 'label' => 'Main About Image', 'default' => 'assets/img/about/thumb-3-2.jpg' ),
				2 => array( 'label' => 'Secondary About Image', 'default' => 'assets/img/about/thumb-3-1.jpg' ),
			),
		);
	}

	if ( 'team' === $key ) {
		$texts = array(
			0 => array( 'label' => 'Section Subtitle', 'default' => 'OUR EXPERT TEAM' ),
			1 => array( 'label' => 'Section Heading (one line per row)', 'default' => "Meet our experienced\nteam people", 'type' => 'textarea', 'indexes' => array( 1, 2 ) ),
		);
		$links  = array();
		$images = array();
		$members = array(
			array( 'Alberta Infantino', 'Electrician', 'assets/img/team/team-1-2.jpg', 'team-details.html' ),
			array( 'Jessica Robinson', 'Architect', 'assets/img/team/team-1-1.jpg', 'team-details.html' ),
			array( 'Tomaas Hirschi', 'Support', 'assets/img/team/team-1-3.jpg', 'team-details.html' ),
			array( 'Belal Mahmud', 'Architect', 'assets/img/team/team-1-4.jpg', '#' ),
			array( 'Diane Lloyd', 'Contractor', 'assets/img/team/team-1-5.jpg', '#' ),
			array( 'Willie Boyd', 'Support', 'assets/img/team/team-1-6.jpg', '#' ),
		);

		foreach ( $members as $index => $member ) {
			$number = $index + 1;
			$text_index = 3 + ( $index * 2 );
			$texts[ $text_index ]     = array( 'label' => "Member {$number} Name", 'default' => $member[0] );
			$texts[ $text_index + 1 ] = array( 'label' => "Member {$number} Role", 'default' => $member[1] );
			$links[ $index ]          = array( 'label' => "Member {$number} Profile Link", 'default' => $member[3] );
			$images[ $index ]         = array( 'label' => "Member {$number} Image", 'default' => $member[2] );
		}

		return array(
			'texts'  => $texts,
			'links'  => $links,
			'images' => $images,
		);
	}

	return array();
}

function cosmotone_page_section_value( $section, $group, $index, $default ) {
	return isset( $section[ $group ][ $index ] ) ? $section[ $group ][ $index ] : $default;
}

function cosmotone_render_page_section_image_field( $section_key, $index, $label, $default, $image, $default_alt = '' ) {
	$image      = is_array( $image ) ? $image : array();
	$value      = isset( $image['url'] ) ? $image['url'] : $default;
	$image_id   = isset( $image['id'] ) ? absint( $image['id'] ) : 0;
	$alt        = isset( $image['alt'] ) ? $image['alt'] : $default_alt;
	$field_id   = 'cosmotone-' . sanitize_html_class( $section_key ) . '-image-' . absint( $index );
	$preview_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : cosmotone_page_section_preview_url( $value );
	?>
	<div class="cosmotone-image-field" id="<?php echo esc_attr( $field_id ); ?>" data-default-preview="<?php echo esc_url( cosmotone_page_section_preview_url( $default ) ); ?>">
		<div class="cosmotone-image-preview"><?php if ( $preview_url ) : ?><img src="<?php echo esc_url( $preview_url ); ?>" alt=""><?php endif; ?></div>
		<div>
			<strong><?php echo esc_html( $label ); ?></strong>
			<input class="cosmotone-image-id" type="hidden" name="cosmotone_sections[<?php echo esc_attr( $section_key ); ?>][images][<?php echo esc_attr( $index ); ?>][id]" value="<?php echo esc_attr( $image_id ); ?>" data-default="0">
			<input class="cosmotone-image-url" type="hidden" name="cosmotone_sections[<?php echo esc_attr( $section_key ); ?>][images][<?php echo esc_attr( $index ); ?>][url]" value="<?php echo esc_attr( $value ); ?>" data-default="<?php echo esc_attr( $default ); ?>">
			<input class="cosmotone-image-alt" type="hidden" name="cosmotone_sections[<?php echo esc_attr( $section_key ); ?>][images][<?php echo esc_attr( $index ); ?>][alt]" value="<?php echo esc_attr( $alt ); ?>" data-default="<?php echo esc_attr( $default_alt ); ?>">
			<div class="cosmotone-image-controls">
				<button type="button" class="button cosmotone-select-image"><?php esc_html_e( 'Select Image', 'cosmotone' ); ?></button>
				<button type="button" class="button cosmotone-remove-image"<?php echo $preview_url ? '' : ' style="display:none"'; ?>><?php esc_html_e( 'Remove', 'cosmotone' ); ?></button>
			</div>
		</div>
	</div>
	<?php
}

function cosmotone_render_custom_page_section_fields( $section_key, $section, $schema ) {
	if ( ! empty( $schema['combined_values'] ) ) :
		?>
		<h4 class="cosmotone-group-title"><?php esc_html_e( 'Numbers and settings', 'cosmotone' ); ?></h4>
		<div class="cosmotone-fields-grid">
		<?php foreach ( $schema['combined_values'] as $field_key => $field ) :
			$default_number = isset( $field['default_number'] ) ? $field['default_number'] : '';
			$default_suffix = isset( $field['default_suffix'] ) ? $field['default_suffix'] : '';
			$number = isset( $section['attributes'][ $field['attribute_key'] ] ) ? $section['attributes'][ $field['attribute_key'] ] : $default_number;
			$suffix = isset( $section['texts'][ $field['text_index'] ] ) ? $section['texts'][ $field['text_index'] ] : $default_suffix;
			$value  = $number . $suffix;
			?>
			<label class="cosmotone-field"><span><?php echo esc_html( $field['label'] ); ?></span><input type="text" name="cosmotone_sections[<?php echo esc_attr( $section_key ); ?>][combined_values][<?php echo esc_attr( $field_key ); ?>]" value="<?php echo esc_attr( $value ); ?>" data-default="<?php echo esc_attr( $field['default'] ); ?>" placeholder="35+"></label>
		<?php endforeach; ?>
		</div>
		<?php
	endif;

	if ( ! empty( $schema['texts'] ) ) :
		?>
		<h4 class="cosmotone-group-title"><?php esc_html_e( 'Text and paragraphs', 'cosmotone' ); ?></h4>
		<div class="cosmotone-fields-grid">
		<?php foreach ( $schema['texts'] as $index => $field ) :
			$default = isset( $field['default'] ) ? $field['default'] : '';
			if ( ! empty( $field['indexes'] ) && is_array( $field['indexes'] ) ) {
				$default_parts = preg_split( '/\R/u', $default );
				$value_parts   = array();
				foreach ( $field['indexes'] as $part_index => $text_index ) {
					$value_parts[] = cosmotone_page_section_value( $section, 'texts', $text_index, isset( $default_parts[ $part_index ] ) ? $default_parts[ $part_index ] : '' );
				}
				$value = implode( "\n", $value_parts );
			} else {
				$value = cosmotone_page_section_value( $section, 'texts', $index, $default );
			}
			$type    = isset( $field['type'] ) ? $field['type'] : 'text';
			$name_group = ! empty( $field['indexes'] ) ? 'combined_texts' : 'texts';
			?>
			<label class="cosmotone-field"><span><?php echo esc_html( $field['label'] ); ?></span>
			<?php if ( 'textarea' === $type ) : ?>
				<textarea rows="4" name="cosmotone_sections[<?php echo esc_attr( $section_key ); ?>][<?php echo esc_attr( $name_group ); ?>][<?php echo esc_attr( $index ); ?>]" data-default="<?php echo esc_attr( $default ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
			<?php else : ?>
				<input type="text" name="cosmotone_sections[<?php echo esc_attr( $section_key ); ?>][<?php echo esc_attr( $name_group ); ?>][<?php echo esc_attr( $index ); ?>]" value="<?php echo esc_attr( $value ); ?>" data-default="<?php echo esc_attr( $default ); ?>">
			<?php endif; ?>
			</label>
		<?php endforeach; ?>
		</div>
		<?php
	endif;

	$visible_attributes = ! empty( $schema['attributes'] )
		? array_filter( $schema['attributes'], static function ( $field ) { return ! isset( $field['admin_visible'] ) || $field['admin_visible']; } )
		: array();
	if ( $visible_attributes ) :
		?>
		<h4 class="cosmotone-group-title"><?php esc_html_e( 'Settings', 'cosmotone' ); ?></h4>
		<div class="cosmotone-fields-grid">
		<?php foreach ( $visible_attributes as $field_key => $field ) :
			$default = isset( $field['default'] ) ? $field['default'] : '';
			$value   = isset( $section['attributes'][ $field_key ] ) ? $section['attributes'][ $field_key ] : $default;
			$type    = isset( $field['type'] ) && 'number' === $field['type'] ? 'number' : 'text';
			?>
			<label class="cosmotone-field"><span><?php echo esc_html( $field['label'] ); ?></span><input type="<?php echo esc_attr( $type ); ?>"<?php echo 'number' === $type ? ' min="0"' : ''; ?> name="cosmotone_sections[<?php echo esc_attr( $section_key ); ?>][attributes][<?php echo esc_attr( $field_key ); ?>]" value="<?php echo esc_attr( $value ); ?>" data-default="<?php echo esc_attr( $default ); ?>"></label>
		<?php endforeach; ?>
		</div>
		<?php
	endif;

	if ( ! empty( $schema['links'] ) ) :
		?>
		<h4 class="cosmotone-group-title"><?php esc_html_e( 'Button and link destinations', 'cosmotone' ); ?></h4>
		<div class="cosmotone-fields-grid">
		<?php foreach ( $schema['links'] as $index => $field ) :
			$default = isset( $field['default'] ) ? $field['default'] : '';
			$value   = cosmotone_page_section_value( $section, 'links', $index, $default );
			?>
			<label class="cosmotone-field"><span><?php echo esc_html( $field['label'] ); ?></span><input type="text" name="cosmotone_sections[<?php echo esc_attr( $section_key ); ?>][links][<?php echo esc_attr( $index ); ?>]" value="<?php echo esc_attr( $value ); ?>" data-default="<?php echo esc_attr( $default ); ?>"></label>
		<?php endforeach; ?>
		</div>
		<?php
	endif;

	if ( ! empty( $schema['images'] ) ) :
		?>
		<h4 class="cosmotone-group-title"><?php esc_html_e( 'Images', 'cosmotone' ); ?></h4>
		<div class="cosmotone-image-grid">
		<?php foreach ( $schema['images'] as $index => $field ) :
			$default = isset( $field['default'] ) ? $field['default'] : '';
			$image   = isset( $section['images'][ $index ] ) && is_array( $section['images'][ $index ] ) ? $section['images'][ $index ] : array();
			cosmotone_render_page_section_image_field( $section_key, $index, $field['label'], $default, $image );
		endforeach; ?>
		</div>
		<?php
	endif;
}

function cosmotone_register_page_sections_box( $post_type, $post ) {
	if ( 'page' === $post_type && $post && cosmotone_page_sections_type( $post->ID ) ) {
		add_meta_box( 'cosmotone_page_sections', __( 'Page Sections', 'cosmotone' ), 'cosmotone_render_page_sections_box', 'page', 'normal', 'high' );
	}
}
add_action( 'add_meta_boxes', 'cosmotone_register_page_sections_box', 10, 2 );

function cosmotone_page_sections_media_assets( $hook ) {
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'cosmotone_page_sections_media_assets' );

function cosmotone_repair_page_section_urls() {
	if ( get_option( 'cosmotone_page_sections_url_repair_v2' ) ) {
		return;
	}

	$page_ids = get_posts(
		array(
			'post_type' => 'page',
			'post_status' => 'any',
			'posts_per_page' => -1,
			'fields' => 'ids',
			'meta_key' => '_cosmotone_page_sections',
		)
	);

	foreach ( $page_ids as $page_id ) {
		$sections = get_post_meta( $page_id, '_cosmotone_page_sections', true );
		if ( ! is_array( $sections ) ) {
			continue;
		}

		$changed = false;
		foreach ( $sections as $section_key => $section ) {
			if ( ! empty( $section['links'] ) && is_array( $section['links'] ) ) {
				foreach ( $section['links'] as $index => $url ) {
					$clean_url = cosmotone_sanitize_page_section_link_url( $url );
					if ( $clean_url !== $url ) {
						$sections[ $section_key ]['links'][ $index ] = $clean_url;
						$changed = true;
					}
				}
			}

			if ( empty( $section['images'] ) || ! is_array( $section['images'] ) ) {
				continue;
			}

			foreach ( $section['images'] as $index => $image ) {
				if ( ! is_array( $image ) || empty( $image['url'] ) ) {
					continue;
				}
				$clean_url = cosmotone_sanitize_page_section_media_url( $image['url'] );
				if ( $clean_url !== $image['url'] ) {
					$sections[ $section_key ]['images'][ $index ]['url'] = $clean_url;
					$changed = true;
				}
			}
		}

		if ( $changed ) {
			update_post_meta( $page_id, '_cosmotone_page_sections', $sections );
		}
	}

	update_option( 'cosmotone_page_sections_url_repair_v2', 1 );
}
add_action( 'init', 'cosmotone_repair_page_section_urls', 35 );

function cosmotone_page_section_preview_url( $url ) {
	$url = cosmotone_page_section_normalize_asset_url( $url );
	return preg_match( '#^https?://#i', $url ) ? $url : trailingslashit( get_template_directory_uri() ) . ltrim( $url, '/' );
}

function cosmotone_render_page_sections_box( $post ) {
	$type   = cosmotone_page_sections_type( $post->ID );
	$config = cosmotone_page_sections_config();
	$saved  = get_post_meta( $post->ID, '_cosmotone_page_sections', true );
	$saved  = is_array( $saved ) ? $saved : array();
	wp_nonce_field( 'cosmotone_save_page_sections', 'cosmotone_page_sections_nonce' );
	?>
	<div class="cosmotone-page-tabs">
		<p class="description"><?php esc_html_e( 'Edit the visible text, paragraphs, links, and images for each section. Theme layout and styling are kept automatically.', 'cosmotone' ); ?></p>
		<?php if ( 'about' === $type ) :
			$home_page_id = absint( get_option( 'page_on_front' ) );
			?>
			<p class="description"><?php esc_html_e( 'Vision, Mission, Values, Contact Information, and Fun Facts are shared with the Home page and are managed only from the Home page editor.', 'cosmotone' ); ?></p>
			<?php if ( $home_page_id ) : ?>
				<p><a class="button" href="<?php echo esc_url( get_edit_post_link( $home_page_id ) ); ?>"><?php esc_html_e( 'Edit Shared Home Sections', 'cosmotone' ); ?></a></p>
			<?php endif; ?>
		<?php endif; ?>
		<?php if ( in_array( $type, array( 'news', 'news-details' ), true ) ) : ?>
			<p class="description"><?php esc_html_e( 'News cards and news detail pages are populated from WordPress Posts.', 'cosmotone' ); ?></p>
			<p>
				<a class="button button-primary" href="<?php echo esc_url( admin_url( 'edit.php' ) ); ?>"><?php esc_html_e( 'Manage News', 'cosmotone' ); ?></a>
				<a class="button" href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>"><?php esc_html_e( 'Add News', 'cosmotone' ); ?></a>
			</p>
		<?php endif; ?>
		<div class="cosmotone-page-tabs-nav">
		<?php $tab = 0; foreach ( $config[ $type ]['sections'] as $key => $label ) : ?>
			<button type="button" class="button cosmotone-page-tab-button<?php echo 0 === $tab ? ' active' : ''; ?>" data-tab="cosmotone-tab-<?php echo esc_attr( sanitize_title( $key ) ); ?>"><?php echo esc_html( $label ); ?></button>
		<?php ++$tab; endforeach; ?>
		</div>

		<?php $tab = 0; foreach ( $config[ $type ]['sections'] as $key => $label ) :
			$dom     = cosmotone_page_section_dom( cosmotone_page_section_default_html( $type, $key ) );
			$nodes   = $dom ? cosmotone_page_section_nodes( $dom ) : array( 'texts' => array(), 'links' => array(), 'media' => array() );
			$section = isset( $saved[ $key ] ) && is_array( $saved[ $key ] ) ? $saved[ $key ] : array();
			$enabled = ! array_key_exists( 'enabled', $section ) || ! empty( $section['enabled'] );
		?>
		<div id="cosmotone-tab-<?php echo esc_attr( sanitize_title( $key ) ); ?>" class="cosmotone-page-tab-pane<?php echo 0 === $tab ? ' active' : ''; ?>">
			<h3><?php echo esc_html( $label ); ?></h3>
			<?php if ( 'home' === $type && 'slider' === $key ) : ?>
				<p class="description"><?php esc_html_e( 'Homepage slides are managed from the dedicated Sliders menu. Images and MP4 videos are supported.', 'cosmotone' ); ?></p>
				<p><a class="button button-primary button-hero" href="<?php echo esc_url( admin_url( 'edit.php?post_type=cosmotone_slider' ) ); ?>"><?php esc_html_e( 'Manage Sliders', 'cosmotone' ); ?></a></p>
			</div>
			<?php ++$tab; continue; ?>
			<?php endif; ?>
			<?php if ( 'career' === $type && 'career' === $key ) : ?>
				<p>
					<a class="button button-primary" href="<?php echo esc_url( admin_url( 'edit.php?post_type=cosmotone_job' ) ); ?>"><?php esc_html_e( 'Manage Jobs', 'cosmotone' ); ?></a>
					<a class="button" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=cosmotone_job' ) ); ?>"><?php esc_html_e( 'Add Job', 'cosmotone' ); ?></a>
				</p>
			<?php elseif ( 'downloads' === $type && 'downloads' === $key ) : ?>
				<p>
					<a class="button button-primary" href="<?php echo esc_url( admin_url( 'edit.php?post_type=cosmotone_download' ) ); ?>"><?php esc_html_e( 'Manage Downloads', 'cosmotone' ); ?></a>
					<a class="button" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=cosmotone_download' ) ); ?>"><?php esc_html_e( 'Add Download', 'cosmotone' ); ?></a>
				</p>
			<?php endif; ?>
			<?php if ( 'contact' === $type && 'form' === $key ) : ?>
				<?php if ( shortcode_exists( 'contact-form-7' ) ) : ?>
					<p><a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=wpcf7' ) ); ?>"><?php esc_html_e( 'Manage Contact Forms', 'cosmotone' ); ?></a></p>
				<?php else : ?>
					<p class="notice notice-warning inline"><?php esc_html_e( 'Contact Form 7 must be installed and activated before the shortcode can render.', 'cosmotone' ); ?></p>
				<?php endif; ?>
			<?php endif; ?>
			<label class="cosmotone-section-toggle"><input type="checkbox" name="cosmotone_sections[<?php echo esc_attr( $key ); ?>][enabled]" value="1" <?php checked( $enabled ); ?>> <?php esc_html_e( 'Show this section', 'cosmotone' ); ?></label>

			<?php
			$custom_fields = cosmotone_page_section_custom_schema( $type, $key );
			if ( $custom_fields ) {
				cosmotone_render_custom_page_section_fields( $key, $section, $custom_fields );
				?>
				<p><button type="button" class="button cosmotone-restore-fields">Restore Section Defaults</button></p>
		</div>
				<?php
				++$tab;
				continue;
			}
			?>

			<?php if ( $nodes['texts'] ) : ?><h4 class="cosmotone-group-title">Text and paragraphs</h4><div class="cosmotone-fields-grid"><?php endif; ?>
			<?php foreach ( $nodes['texts'] as $index => $node ) :
				$default = trim( $node->nodeValue );
				$value   = isset( $section['texts'][ $index ] ) ? $section['texts'][ $index ] : $default;
				$type_label = cosmotone_page_section_text_type( $node );
				$label_text = $type_label . ' - ' . wp_trim_words( $default, 8, '...' );
				$is_paragraph = 'Paragraph' === $type_label || strlen( $default ) > 110;
			?>
			<label class="cosmotone-field"><span><?php echo esc_html( $label_text ); ?></span>
			<?php if ( $is_paragraph ) : ?><textarea rows="4" name="cosmotone_sections[<?php echo esc_attr( $key ); ?>][texts][<?php echo esc_attr( $index ); ?>]" data-default="<?php echo esc_attr( $default ); ?>"><?php echo esc_textarea( $value ); ?></textarea><?php else : ?><input type="text" name="cosmotone_sections[<?php echo esc_attr( $key ); ?>][texts][<?php echo esc_attr( $index ); ?>]" value="<?php echo esc_attr( $value ); ?>" data-default="<?php echo esc_attr( $default ); ?>"><?php endif; ?>
			</label>
			<?php endforeach; ?>
			<?php if ( $nodes['texts'] ) : ?></div><?php endif; ?>

			<?php if ( $nodes['links'] ) : ?><h4 class="cosmotone-group-title">Button and link destinations</h4><div class="cosmotone-fields-grid"><?php endif; ?>
			<?php foreach ( $nodes['links'] as $index => $link ) :
				$default = $link->getAttribute( 'href' );
				$value   = isset( $section['links'][ $index ] ) ? $section['links'][ $index ] : $default;
				$text    = trim( $link->textContent );
			?>
			<label class="cosmotone-field"><span><?php echo esc_html( $text ? 'Link - ' . wp_trim_words( $text, 7, '...' ) : 'Link ' . ( $index + 1 ) ); ?></span><input type="text" name="cosmotone_sections[<?php echo esc_attr( $key ); ?>][links][<?php echo esc_attr( $index ); ?>]" value="<?php echo esc_attr( $value ); ?>" data-default="<?php echo esc_attr( $default ); ?>"></label>
			<?php endforeach; ?>
			<?php if ( $nodes['links'] ) : ?></div><?php endif; ?>

			<?php if ( $nodes['media'] ) : ?><h4 class="cosmotone-group-title">Images</h4><div class="cosmotone-image-grid"><?php endif; ?>
			<?php foreach ( $nodes['media'] as $index => $node ) :
				$attribute = cosmotone_page_section_media_attr( $node );
				$default   = $node->getAttribute( $attribute );
				$image     = isset( $section['images'][ $index ] ) && is_array( $section['images'][ $index ] ) ? $section['images'][ $index ] : array();
				$alt       = 'img' === strtolower( $node->nodeName ) ? $node->getAttribute( 'alt' ) : '';
				$image_label = 'data-background' === $attribute ? 'Background image' : ( 'poster' === $attribute ? 'Video poster' : 'Image' );
				cosmotone_render_page_section_image_field( $key, $index, $image_label . ' ' . ( $index + 1 ), $default, $image, $alt );
			endforeach; ?>
			<?php if ( $nodes['media'] ) : ?></div><?php endif; ?>
			<p><button type="button" class="button cosmotone-restore-fields">Restore Section Defaults</button></p>
		</div>
		<?php ++$tab; endforeach; ?>
	</div>
	<style>
	.cosmotone-page-tabs-nav{display:flex;flex-wrap:wrap;gap:8px;margin:16px 0}.cosmotone-page-tab-button.active{background:#f6fbff;border-color:#2271b1;color:#0a4b78}.cosmotone-page-tab-pane{display:none}.cosmotone-page-tab-pane.active{display:block}.cosmotone-section-toggle{display:block;margin:10px 0 18px;font-weight:600}.cosmotone-group-title{margin:22px 0 12px;padding-top:14px;border-top:1px solid #dcdcde}.cosmotone-fields-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}.cosmotone-field{display:flex;flex-direction:column;gap:5px}.cosmotone-field span{font-weight:600}.cosmotone-field input,.cosmotone-field textarea{width:100%}.cosmotone-image-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}.cosmotone-image-field{display:grid;grid-template-columns:110px 1fr;gap:12px;padding:12px;border:1px solid #dcdcde;background:#fff}.cosmotone-image-preview{display:flex;height:90px;align-items:center;justify-content:center;background:#f0f0f1}.cosmotone-image-preview img{max-width:100%;max-height:90px}.cosmotone-image-controls{display:flex;gap:8px;margin:7px 0}.cosmotone-image-controls .button{white-space:nowrap}@media(max-width:782px){.cosmotone-fields-grid,.cosmotone-image-grid{grid-template-columns:1fr}.cosmotone-image-field{grid-template-columns:1fr}}
	</style>
	<script>
	(function(){
		var root = document.querySelector('.cosmotone-page-tabs');
		if (!root) return;
		var buttons = root.querySelectorAll('.cosmotone-page-tab-button');
		var panes = root.querySelectorAll('.cosmotone-page-tab-pane');

		function activate(id) {
			buttons.forEach(function(button){ button.classList.toggle('active', button.dataset.tab === id); });
			panes.forEach(function(pane){ pane.classList.toggle('active', pane.id === id); });
		}

		function showPreview(holder, url) {
			var preview = holder.querySelector('.cosmotone-image-preview');
			preview.innerHTML = url ? '<img src="' + url + '" alt="">' : '';
		}

		buttons.forEach(function(button){
			button.addEventListener('click', function(){
				activate(button.dataset.tab);
				window.history.replaceState(null, '', '#' + button.dataset.tab);
			});
		});
		if (window.location.hash && root.querySelector(window.location.hash)) activate(window.location.hash.slice(1));

		root.addEventListener('click', function(event){
			var select = event.target.closest('.cosmotone-select-image');
			if (select) {
				event.preventDefault();
				var holder = select.closest('.cosmotone-image-field');
				var urlInput = holder.querySelector('.cosmotone-image-url');
				var idInput = holder.querySelector('.cosmotone-image-id');
				var altInput = holder.querySelector('.cosmotone-image-alt');
				var removeButton = holder.querySelector('.cosmotone-remove-image');
				var frame = wp.media({title:'Select Image', button:{text:'Use this image'}, multiple:false, library:{type:'image'}});
				frame.on('select', function(){
					var image = frame.state().get('selection').first().toJSON();
					urlInput.value = image.url || '';
					idInput.value = image.id || 0;
					altInput.value = image.alt || '';
					showPreview(holder, image.url || '');
					removeButton.style.display = '';
				});
				frame.open();
				return;
			}

			var remove = event.target.closest('.cosmotone-remove-image');
			if (remove) {
				event.preventDefault();
				var imageHolder = remove.closest('.cosmotone-image-field');
				imageHolder.querySelector('.cosmotone-image-id').value = 0;
				imageHolder.querySelector('.cosmotone-image-url').value = '';
				imageHolder.querySelector('.cosmotone-image-alt').value = '';
				showPreview(imageHolder, '');
				remove.style.display = 'none';
				return;
			}

			var restore = event.target.closest('.cosmotone-restore-fields');
			if (restore) {
				event.preventDefault();
				if (!window.confirm('Restore all fields in this section?')) return;
				var pane = restore.closest('.cosmotone-page-tab-pane');
				pane.querySelectorAll('[data-default]').forEach(function(field){ field.value = field.dataset.default; });
				pane.querySelectorAll('.cosmotone-image-field').forEach(function(holder){
					showPreview(holder, holder.dataset.defaultPreview || '');
					var removeButton = holder.querySelector('.cosmotone-remove-image');
					if (removeButton) removeButton.style.display = holder.dataset.defaultPreview ? '' : 'none';
				});
				pane.querySelector('input[type="checkbox"]').checked = true;
			}
		});
	})();
	</script>
	<?php
}

function cosmotone_save_page_sections( $post_id ) {
	if ( ! isset( $_POST['cosmotone_page_sections_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cosmotone_page_sections_nonce'] ) ), 'cosmotone_save_page_sections' ) || wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_page', $post_id ) ) return;
	$type   = cosmotone_page_sections_type( $post_id );
	$config = cosmotone_page_sections_config();
	if ( ! $type ) return;
	$raw = isset( $_POST['cosmotone_sections'] ) && is_array( $_POST['cosmotone_sections'] ) ? wp_unslash( $_POST['cosmotone_sections'] ) : array();
	$out = array();
	foreach ( $config[ $type ]['sections'] as $key => $label ) {
		$item = isset( $raw[ $key ] ) && is_array( $raw[ $key ] ) ? $raw[ $key ] : array();
		$out[ $key ] = array( 'enabled' => ! empty( $item['enabled'] ) ? 1 : 0, 'texts' => array(), 'attributes' => array(), 'links' => array(), 'images' => array() );
		foreach ( isset( $item['texts'] ) && is_array( $item['texts'] ) ? $item['texts'] : array() as $i => $value ) $out[ $key ]['texts'][ absint( $i ) ] = sanitize_textarea_field( $value );

		$custom_schema = cosmotone_page_section_custom_schema( $type, $key );
		if ( ! empty( $custom_schema['texts'] ) && ! empty( $item['combined_texts'] ) && is_array( $item['combined_texts'] ) ) {
			foreach ( $custom_schema['texts'] as $field_index => $field ) {
				if ( empty( $field['indexes'] ) || ! is_array( $field['indexes'] ) || ! array_key_exists( $field_index, $item['combined_texts'] ) ) {
					continue;
				}

				$parts = preg_split( '/\R/u', (string) $item['combined_texts'][ $field_index ], count( $field['indexes'] ) );
				foreach ( $field['indexes'] as $part_index => $text_index ) {
					$out[ $key ]['texts'][ absint( $text_index ) ] = sanitize_text_field( isset( $parts[ $part_index ] ) ? $parts[ $part_index ] : '' );
				}
			}
		}

		if ( ! empty( $custom_schema['attributes'] ) ) {
			foreach ( $custom_schema['attributes'] as $field_key => $field ) {
				$value = isset( $item['attributes'][ $field_key ] ) ? $item['attributes'][ $field_key ] : '';
				if ( isset( $field['type'] ) && 'number' === $field['type'] ) {
					$out[ $key ]['attributes'][ $field_key ] = (string) absint( $value );
				} elseif ( isset( $field['type'] ) && 'url' === $field['type'] ) {
					$out[ $key ]['attributes'][ $field_key ] = cosmotone_sanitize_page_section_media_url( $value );
				} else {
					$out[ $key ]['attributes'][ $field_key ] = sanitize_text_field( $value );
				}
			}
		}

		if ( ! empty( $custom_schema['combined_values'] ) ) {
			foreach ( $custom_schema['combined_values'] as $field_key => $field ) {
				$value = isset( $item['combined_values'][ $field_key ] ) ? sanitize_text_field( $item['combined_values'][ $field_key ] ) : $field['default'];
				if ( ! preg_match( '/^\s*(\d+)\s*(.*?)\s*$/u', $value, $matches ) ) {
					preg_match( '/^\s*(\d+)\s*(.*?)\s*$/u', $field['default'], $matches );
				}

				$out[ $key ]['attributes'][ $field['attribute_key'] ] = isset( $matches[1] ) ? $matches[1] : $field['default_number'];
				$out[ $key ]['texts'][ absint( $field['text_index'] ) ] = isset( $matches[2] ) ? sanitize_text_field( $matches[2] ) : $field['default_suffix'];
			}
		}

		foreach ( isset( $item['links'] ) && is_array( $item['links'] ) ? $item['links'] : array() as $i => $value ) $out[ $key ]['links'][ absint( $i ) ] = cosmotone_sanitize_page_section_link_url( $value );
		foreach ( isset( $item['images'] ) && is_array( $item['images'] ) ? $item['images'] : array() as $i => $image ) $out[ $key ]['images'][ absint( $i ) ] = array( 'id' => isset( $image['id'] ) ? absint( $image['id'] ) : 0, 'url' => isset( $image['url'] ) ? cosmotone_sanitize_page_section_media_url( $image['url'] ) : '', 'alt' => isset( $image['alt'] ) ? sanitize_text_field( $image['alt'] ) : '' );
	}
	update_post_meta( $post_id, '_cosmotone_page_sections', $out );
}
add_action( 'save_post_page', 'cosmotone_save_page_sections' );

function cosmotone_apply_section_values( $html, $values, $schema = array() ) {
	$dom = cosmotone_page_section_dom( $html );
	if ( ! $dom ) return $html;
	$nodes = cosmotone_page_section_nodes( $dom );
	foreach ( $nodes['texts'] as $i => $node ) {
		if ( ! isset( $values['texts'][ $i ] ) ) continue;
		$old = $node->nodeValue; preg_match( '/^\s*/u', $old, $left ); preg_match( '/\s*$/u', $old, $right );
		$node->nodeValue = $left[0] . $values['texts'][ $i ] . $right[0];
	}
	foreach ( $nodes['links'] as $i => $node ) {
		if ( ! isset( $values['links'][ $i ] ) || '' === $values['links'][ $i ] ) continue;
		$node->setAttribute( 'href', cosmotone_page_section_normalize_asset_url( $values['links'][ $i ] ) );
	}
	foreach ( $nodes['media'] as $i => $node ) {
		if ( empty( $values['images'][ $i ]['url'] ) ) continue;
		$image_url = cosmotone_page_section_normalize_asset_url( $values['images'][ $i ]['url'] );
		$node->setAttribute( cosmotone_page_section_media_attr( $node ), $image_url );
		if ( 'img' === strtolower( $node->nodeName ) && isset( $values['images'][ $i ]['alt'] ) ) $node->setAttribute( 'alt', $values['images'][ $i ]['alt'] );
		if ( 'img' === strtolower( $node->nodeName ) && $node->parentNode instanceof DOMElement && 'a' === strtolower( $node->parentNode->nodeName ) && false !== strpos( ' ' . $node->parentNode->getAttribute( 'class' ) . ' ', ' popup-image ' ) ) {
			$node->parentNode->setAttribute( 'href', $image_url );
		}
	}
	foreach ( ! empty( $schema['attributes'] ) ? $schema['attributes'] : array() as $field_key => $field ) {
		if ( ! isset( $values['attributes'][ $field_key ], $field['xpath'], $field['attribute'] ) ) continue;
		$attribute_nodes = $dom['xpath']->query( $field['xpath'], $dom['root'] );
		$attribute_node  = $attribute_nodes ? $attribute_nodes->item( 0 ) : null;
		if ( $attribute_node instanceof DOMElement ) {
			$attribute_node->setAttribute( $field['attribute'], $values['attributes'][ $field_key ] );
		}
	}
	return cosmotone_page_section_dom_html( $dom );
}

function cosmotone_apply_page_section_fields( $content, $post_id, $type ) {
	$config = cosmotone_page_sections_config();
	$saved  = get_post_meta( $post_id, '_cosmotone_page_sections', true );
	if ( ! is_array( $saved ) || empty( $config[ $type ]['sections'] ) ) return $content;
	foreach ( $config[ $type ]['sections'] as $key => $label ) {
		if ( ! isset( $saved[ $key ] ) ) continue;
		$pattern = '#<!--\s*' . preg_quote( $key, '#' ) . ' area start\s*-->(.*?)<!--\s*' . preg_quote( $key, '#' ) . ' area end\s*-->#is';
		if ( empty( $saved[ $key ]['enabled'] ) ) { $content = preg_replace( $pattern, '', $content, 1 ); continue; }
		$schema = cosmotone_page_section_custom_schema( $type, $key );
		$content = preg_replace_callback( $pattern, static function ( $match ) use ( $saved, $key, $schema ) { return '<!-- ' . $key . ' area start -->' . cosmotone_apply_section_values( $match[1], $saved[ $key ], $schema ) . '<!-- ' . $key . ' area end -->'; }, $content, 1 );
	}
	return $content;
}
