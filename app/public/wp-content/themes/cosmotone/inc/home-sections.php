<?php
/**
 * Structured Home page fields and admin tabs.
 *
 * This follows the page-specific metabox pattern used by the Spaceengineers
 * reference theme: named fields are saved in one Home meta array and the
 * front-page template reads those values directly.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

function cosmotone_home_field( $key, $label, $type, $default = '', $legacy = array() ) {
	return array_merge(
		array(
			'key'     => $key,
			'label'   => $label,
			'type'    => $type,
			'default' => $default,
		),
		$legacy
	);
}

function cosmotone_home_sections_schema() {
	$schema = array(
		'about' => array(
			'label' => 'About',
			'legacy_section' => 'about',
			'fields' => array(
				cosmotone_home_field( 'about_subtitle', 'Subtitle', 'text', 'ABOUT COSMOTONE', array( 'legacy_text' => 0 ) ),
				cosmotone_home_field( 'about_title', 'Heading', 'editor', 'Empowering Mobility with Reliable Electrical Solutions', array( 'legacy_text' => 1 ) ),
				cosmotone_home_field( 'about_description', 'Description', 'editor', 'Cosmotone manufactures automotive electrical components, wiring harnesses, relays and sensors engineered for dependable performance.', array( 'legacy_text' => 2 ) ),
				cosmotone_home_field( 'about_highlight', 'Highlight Text', 'text', 'A legacy of quality, reliability, and innovation.', array( 'legacy_text' => 3 ) ),
				cosmotone_home_field( 'about_feature_1', 'Feature 1', 'editor', 'Driven by<br>Excellence', array( 'legacy_text' => array( 4, 5 ), 'legacy_join' => '<br>' ) ),
				cosmotone_home_field( 'about_feature_2', 'Feature 2', 'editor', 'Powering<br>Connections', array( 'legacy_text' => array( 6, 7 ), 'legacy_join' => '<br>' ) ),
				cosmotone_home_field( 'about_button_text', 'Button Text', 'text', 'KNOW MORE', array( 'legacy_text' => 8 ) ),
				cosmotone_home_field( 'about_button_url', 'Button Link', 'url', '#', array( 'legacy_link' => 0 ) ),
				cosmotone_home_field( 'about_main_image', 'Main About Image', 'image', 'assets/img/about/thumb-1-1.jpg', array( 'legacy_image' => 4 ) ),
				cosmotone_home_field( 'about_small_image', 'Small About Image', 'image', 'assets/img/about/thumb-1-2.jpg', array( 'legacy_image' => 5 ) ),
			),
		),
		'quality' => array(
			'label' => 'Quality Assurance',
			'legacy_section' => 'quality assurance',
			'fields' => array(),
		),
		'services' => array(
			'label' => 'Services',
			'legacy_section' => 'service',
			'fields' => array(
				cosmotone_home_field( 'services_subtitle', 'Subtitle', 'text', 'OUR BUSINESS SEGMENT', array( 'legacy_text' => 0 ) ),
				cosmotone_home_field( 'services_title', 'Heading', 'editor', 'Engineered for Performance and Reliability', array( 'legacy_text' => 1 ) ),
				cosmotone_home_field( 'services_background', 'Section Background', 'image', 'assets/img/service/bg-1-1.png', array( 'legacy_image' => 0 ) ),
			),
		),
		'choose' => array(
			'label' => 'Why Choose Us',
			'legacy_section' => 'choose',
			'fields' => array(
				cosmotone_home_field( 'choose_subtitle', 'Subtitle', 'text', 'WHY CHOOSE COSMOTONE', array( 'legacy_text' => 0 ) ),
				cosmotone_home_field( 'choose_title', 'Heading', 'editor', 'Comprehensive Automotive Electrical Solutions Tailored to Your Needs', array( 'legacy_text' => 1 ) ),
				cosmotone_home_field( 'choose_description', 'Description', 'editor', 'Innovative engineering, stringent quality control, and a customer-centric approach enable us to deliver dependable automotive electrical solutions that keep you ahead of the road.', array( 'legacy_text' => 2 ) ),
				cosmotone_home_field( 'choose_image', 'Section Image', 'image', 'assets/img/hero/banner2.jpg', array( 'legacy_image' => 5 ) ),
			),
		),
		'products' => array(
			'label' => 'Products',
			'legacy_section' => 'project',
			'fields' => array(
				cosmotone_home_field( 'products_subtitle', 'Subtitle', 'text', 'TOP PRODUCTS', array( 'legacy_text' => 0 ) ),
				cosmotone_home_field( 'products_title', 'Heading', 'editor', 'Check our latest products', array( 'legacy_text' => 1 ) ),
			),
		),
		'contact' => array(
			'label' => 'Vision, Mission & Contact',
			'legacy_section' => 'contact',
			'fields' => array(
				cosmotone_home_field( 'contact_tab_1', 'Tab 1 Label', 'text', 'VISION', array( 'legacy_text' => 0 ) ),
				cosmotone_home_field( 'contact_tab_2', 'Tab 2 Label', 'text', 'MISSION', array( 'legacy_text' => 1 ) ),
				cosmotone_home_field( 'contact_tab_3', 'Tab 3 Label', 'text', 'VALUES', array( 'legacy_text' => 2 ) ),
				cosmotone_home_field( 'contact_vision_title', 'Vision Title', 'editor', 'Shaping the Future of Automotive Components', array( 'legacy_text' => 3 ) ),
				cosmotone_home_field( 'contact_mission_title', 'Mission Title', 'editor', 'Future Electricity and Problem Solution', array( 'legacy_text' => 7 ) ),
				cosmotone_home_field( 'contact_values_title', 'Values Title', 'editor', "Electricity can transform people's lives, not just living", array( 'legacy_text' => 11 ) ),
				cosmotone_home_field( 'contact_subtitle', 'Contact Subtitle', 'text', 'NEED HELP?', array( 'legacy_text' => 15 ) ),
				cosmotone_home_field( 'contact_title', 'Contact Heading', 'editor', "Have a question?<br>We're ready to help", array( 'legacy_text' => array( 16, 17 ), 'legacy_join' => '<br>' ) ),
				cosmotone_home_field( 'contact_description', 'Contact Description', 'editor', 'Don’t hesitate to call us on any product related query, our team wait for your call', array( 'legacy_text' => 18 ) ),
				cosmotone_home_field( 'contact_phone_label', 'Phone Label', 'text', 'For emergency', array( 'legacy_text' => 19 ) ),
				cosmotone_home_field( 'contact_phone', 'Phone Number', 'text', '+91 485 220 8431', array( 'legacy_text' => 20 ) ),
				cosmotone_home_field( 'contact_phone_url', 'Phone Link', 'url', 'tel:+914852208431', array( 'legacy_link' => 3 ) ),
				cosmotone_home_field( 'contact_background', 'Section Background', 'image', 'assets/img/contact/cosmotone-vision-bg.png', array( 'legacy_image' => 0 ) ),
				cosmotone_home_field( 'contact_vision_image', 'Vision Image', 'image', 'assets/img/contact/contact1-1.jpg', array( 'legacy_image' => 2 ) ),
				cosmotone_home_field( 'contact_vision_item_1', 'Vision List Item 1', 'text', 'Product Design & Development', array( 'legacy_text' => 4 ) ),
				cosmotone_home_field( 'contact_vision_item_2', 'Vision List Item 2', 'text', 'Advanced Manufacturing', array( 'legacy_text' => 5 ) ),
				cosmotone_home_field( 'contact_vision_item_3', 'Vision List Item 3', 'text', 'Quality Assurance', array( 'legacy_text' => 6 ) ),
				cosmotone_home_field( 'contact_mission_image', 'Mission Image', 'image', 'assets/img/contact/contact1-2.jpg', array( 'legacy_image' => 3 ) ),
				cosmotone_home_field( 'contact_mission_item_1', 'Mission List Item 1', 'text', 'Full-service electrical layout', array( 'legacy_text' => 8 ) ),
				cosmotone_home_field( 'contact_mission_item_2', 'Mission List Item 2', 'text', 'AC installation in one hour', array( 'legacy_text' => 9 ) ),
				cosmotone_home_field( 'contact_mission_item_3', 'Mission List Item 3', 'text', 'Wiring and installation', array( 'legacy_text' => 10 ) ),
				cosmotone_home_field( 'contact_values_image', 'Values Image', 'image', 'assets/img/contact/contact1-3.jpg', array( 'legacy_image' => 4 ) ),
				cosmotone_home_field( 'contact_values_item_1', 'Values List Item 1', 'text', 'Full-service electrical layout', array( 'legacy_text' => 12 ) ),
				cosmotone_home_field( 'contact_values_item_2', 'Values List Item 2', 'text', 'AC installation in one hour', array( 'legacy_text' => 13 ) ),
				cosmotone_home_field( 'contact_values_item_3', 'Values List Item 3', 'text', 'Wiring and installation', array( 'legacy_text' => 14 ) ),
			),
		),
		'stats' => array(
			'label' => 'Statistics',
			'fields' => array(),
		),
		'team' => array(
			'label' => 'Team',
			'legacy_section' => 'team',
			'fields' => array(
				cosmotone_home_field( 'team_subtitle', 'Subtitle', 'text', 'OUR EXPERT TEAM', array( 'legacy_text' => 0 ) ),
				cosmotone_home_field( 'team_title', 'Heading', 'editor', 'Meet our experienced<br>team people', array( 'legacy_text' => array( 1, 2 ), 'legacy_join' => '<br>' ) ),
				cosmotone_home_field( 'team_footer_text', 'Footer Text', 'editor', 'Contact Our Expert Team Member To Take Our', array( 'legacy_text' => 9 ) ),
				cosmotone_home_field( 'team_footer_link_text', 'Footer Link Text', 'text', 'Best Services', array( 'legacy_text' => 10 ) ),
				cosmotone_home_field( 'team_footer_link_url', 'Footer Link', 'url', '#', array( 'legacy_link' => 12 ) ),
			),
		),
		'testimonials' => array(
			'label' => 'Testimonials',
			'legacy_section' => 'testimonial',
			'fields' => array(
				cosmotone_home_field( 'testimonials_subtitle', 'Subtitle', 'text', 'OUR CLIENTS REVIEW', array( 'legacy_text' => 0 ) ),
				cosmotone_home_field( 'testimonials_title', 'Heading', 'editor', 'What our partners say about<br>Cosmotone', array( 'legacy_text' => array( 1, 2 ), 'legacy_join' => '<br>' ) ),
			),
		),
		'news' => array(
			'label' => 'News',
			'legacy_section' => 'blog',
			'fields' => array(
				cosmotone_home_field( 'news_subtitle', 'Subtitle', 'text', 'NEWS & ARTICLES', array( 'legacy_text' => 0 ) ),
				cosmotone_home_field( 'news_title', 'Heading', 'editor', 'Latest news & articles<br>from the blog', array( 'legacy_text' => array( 1, 2 ), 'legacy_join' => '<br>' ) ),
			),
		),
		'certificates' => array(
			'label' => 'Certificates',
			'legacy_section' => 'certificates',
			'fields' => array(
				cosmotone_home_field( 'certificates_subtitle', 'Subtitle', 'text', 'QUALITY YOU CAN TRUST', array( 'legacy_text' => 0 ) ),
				cosmotone_home_field( 'certificates_title', 'Heading', 'editor', 'ISO 9001:2015<br>Certified Company', array( 'legacy_text' => array( 1, 2 ), 'legacy_join' => '<br>' ) ),
				cosmotone_home_field( 'certificates_description', 'Description', 'editor', 'We are committed to quality and continuous improvement. Our products comply with international standards and undergo rigorous testing to ensure reliability and safety.', array( 'legacy_text' => 3 ) ),
				cosmotone_home_field( 'certificates_button_text', 'Button Text', 'text', 'VIEW CERTIFICATES', array( 'legacy_text' => 4 ) ),
				cosmotone_home_field( 'certificates_button_url', 'Button Link', 'url', '/downloads', array( 'legacy_link' => 0 ) ),
			),
		),
	);

	$quality_defaults = array(
		array( 'Quality Assurance', 'Stringent testing at every stage' ),
		array( 'Custom Solutions', 'Designed to meet customer needs' ),
		array( 'On-time Delivery', 'Reliable production and dispatch' ),
		array( 'Expert Support', 'Technical support you can rely on' ),
	);
	foreach ( $quality_defaults as $index => $item ) {
		$number = $index + 1;
		$schema['quality']['fields'][] = cosmotone_home_field( "quality_{$number}_title", "Item {$number} Title", 'text', $item[0], array( 'legacy_text' => $index * 2 ) );
		$schema['quality']['fields'][] = cosmotone_home_field( "quality_{$number}_description", "Item {$number} Description", 'editor', $item[1], array( 'legacy_text' => $index * 2 + 1 ) );
	}

	$service_defaults = array(
		array( 'Automotive Electrical', 'Reliable electrical components engineered for vehicle safety and performance.', 'assets/img/service/sv-1-1.jpg' ),
		array( 'Wires and Cables', 'Precision-engineered wires and cables ensuring secure connections and dependable performance.', 'assets/img/service/sv-1-2.jpg' ),
		array( 'Automotive', 'High-quality automotive solutions designed to deliver reliable power, safety, and long-lasting performance.', 'assets/img/service/sv-1-3.jpg' ),
	);
	foreach ( $service_defaults as $index => $item ) {
		$number = $index + 1;
		$schema['services']['fields'][] = cosmotone_home_field( "service_{$number}_title", "Service {$number} Title", 'text', $item[0], array( 'legacy_text' => 2 + $index * 3 ) );
		$schema['services']['fields'][] = cosmotone_home_field( "service_{$number}_description", "Service {$number} Description", 'editor', $item[1], array( 'legacy_text' => 3 + $index * 3 ) );
		$schema['services']['fields'][] = cosmotone_home_field( "service_{$number}_button_text", "Service {$number} Button Text", 'text', 'Read More', array( 'legacy_text' => 4 + $index * 3 ) );
		$schema['services']['fields'][] = cosmotone_home_field( "service_{$number}_url", "Service {$number} Link", 'url', '#', array( 'legacy_link' => 1 + $index * 2 ) );
		$schema['services']['fields'][] = cosmotone_home_field( "service_{$number}_image", "Service {$number} Image", 'image', $item[2], array( 'legacy_image' => 1 + $index * 3 ) );
	}

	$choose_items = array( 'Industry Expertise', 'Superior Product Quality', 'ISO 9001:2015 Certified', 'Innovative Solutions' );
	foreach ( $choose_items as $index => $title ) {
		$schema['choose']['fields'][] = cosmotone_home_field( 'choose_item_' . ( $index + 1 ), 'Feature ' . ( $index + 1 ), 'text', $title, array( 'legacy_text' => $index + 3 ) );
	}

	$product_defaults = array(
		array( 'Automotive electrical solutions', 'Automotive', 'Wide range of electrical solutions for modern vehicles, built for safety.', 'assets/img/project/pro-1-1.jpg' ),
		array( 'High-performance relays', 'EV Relays', 'Reliable and efficient relays engineered for electric vehicles.', 'assets/img/project/pro-1-2.jpg' ),
		array( 'Charging and energy control', 'EV–EVSE Relays', 'Custom wiring and switching solutions built for durability.', 'assets/img/project/pro-1-3.jpg' ),
		array( 'Precision components', 'Electrical Accessories', 'High-quality accessories for every automotive requirement.', 'assets/img/project/pro-1-4.jpg' ),
		array( 'Engineered connections', 'Sensors & Connectors', 'Accurate sensing and secure connections for dependable performance.', 'assets/img/project/pro-1-5.jpg' ),
	);
	foreach ( $product_defaults as $index => $item ) {
		$number = $index + 1;
		$text_base = 2 + $index * 4;
		$schema['products']['fields'][] = cosmotone_home_field( "product_{$number}_subtitle", "Product {$number} Subtitle", 'text', $item[0], array( 'legacy_text' => $text_base + 1 ) );
		$schema['products']['fields'][] = cosmotone_home_field( "product_{$number}_title", "Product {$number} Title", 'text', $item[1], array( 'legacy_text' => $text_base + 2 ) );
		$schema['products']['fields'][] = cosmotone_home_field( "product_{$number}_description", "Product {$number} Description", 'editor', $item[2], array( 'legacy_text' => $text_base + 3 ) );
		$schema['products']['fields'][] = cosmotone_home_field( "product_{$number}_button_text", "Product {$number} Button Text", 'text', 'Read More', array( 'legacy_text' => $text_base ) );
		$schema['products']['fields'][] = cosmotone_home_field( "product_{$number}_url", "Product {$number} Link", 'url', '#', array( 'legacy_link' => 1 + $index * 3 ) );
		$schema['products']['fields'][] = cosmotone_home_field( "product_{$number}_image", "Product {$number} Image", 'image', $item[3], array( 'legacy_image' => $number ) );
	}

	$stats = array(
		array( '820', '+', 'Successful Projects' ),
		array( '9', 'M', 'Satisfied Clients' ),
		array( '45', '+', 'Experienced Staff' ),
		array( '848', '+', 'Awards Winning' ),
	);
	foreach ( $stats as $index => $item ) {
		$number = $index + 1;
		$schema['stats']['fields'][] = cosmotone_home_field( "stat_{$number}_number", "Statistic {$number} Number", 'text', $item[0] );
		$schema['stats']['fields'][] = cosmotone_home_field( "stat_{$number}_suffix", "Statistic {$number} Suffix", 'text', $item[1] );
		$schema['stats']['fields'][] = cosmotone_home_field( "stat_{$number}_label", "Statistic {$number} Label", 'text', $item[2] );
	}

	$team_defaults = array(
		array( 'Alberta Infantino', 'Electrician', 'assets/img/team/team-1-2.jpg' ),
		array( 'Jessica Robinson', 'Architect', 'assets/img/team/team-1-1.jpg' ),
		array( 'Tomaas Hirschi', 'Support', 'assets/img/team/team-1-3.jpg' ),
	);
	foreach ( $team_defaults as $index => $item ) {
		$number = $index + 1;
		$schema['team']['fields'][] = cosmotone_home_field( "team_{$number}_name", "Member {$number} Name", 'text', $item[0], array( 'legacy_text' => 3 + $index * 2 ) );
		$schema['team']['fields'][] = cosmotone_home_field( "team_{$number}_role", "Member {$number} Role", 'text', $item[1], array( 'legacy_text' => 4 + $index * 2 ) );
		$schema['team']['fields'][] = cosmotone_home_field( "team_{$number}_image", "Member {$number} Image", 'image', $item[2], array( 'legacy_image' => $index ) );
		$schema['team']['fields'][] = cosmotone_home_field( "team_{$number}_facebook", "Member {$number} Facebook", 'url', '#' );
		$schema['team']['fields'][] = cosmotone_home_field( "team_{$number}_instagram", "Member {$number} Instagram", 'url', '#' );
		$schema['team']['fields'][] = cosmotone_home_field( "team_{$number}_linkedin", "Member {$number} LinkedIn", 'url', '#' );
	}

	$testimonial_defaults = array(
		array( "We've been using Cosmotone automotive electrical components for years. The product quality, consistency, and reliability have always exceeded our expectations.", 'Arun Kumar', 'Project Manager', 'assets/img/testimonial/author-1-1.png' ),
		array( 'Cosmotone delivers premium-quality wiring harnesses and relays with excellent technical support. A dependable partner for our manufacturing needs', 'Anil Patel', 'OEM Procurement Manager', 'assets/img/testimonial/author-1-2.png' ),
		array( 'The durability and performance of Cosmotone products have significantly improved our customer satisfaction. Highly recommended', 'Deepak Nair', 'Manager, Automotive Service Centre', 'assets/img/testimonial/author-1-3.png' ),
	);
	foreach ( $testimonial_defaults as $index => $item ) {
		$number = $index + 1;
		$schema['testimonials']['fields'][] = cosmotone_home_field( "testimonial_{$number}_text", "Testimonial {$number} Text", 'editor', $item[0], array( 'legacy_text' => 3 + $index * 3 ) );
		$schema['testimonials']['fields'][] = cosmotone_home_field( "testimonial_{$number}_name", "Testimonial {$number} Name", 'text', $item[1], array( 'legacy_text' => 4 + $index * 3 ) );
		$schema['testimonials']['fields'][] = cosmotone_home_field( "testimonial_{$number}_role", "Testimonial {$number} Role", 'text', $item[2], array( 'legacy_text' => 5 + $index * 3 ) );
		$schema['testimonials']['fields'][] = cosmotone_home_field( "testimonial_{$number}_image", "Testimonial {$number} Image", 'image', $item[3], array( 'legacy_image' => 2 + $index * 2 ) );
	}

	$news_defaults = array(
		array( 'By thempure', 'Repair', 'Why Quality Wiring Harnesses Matter', 'assets/img/blog/blog-1-1.jpg' ),
		array( 'By thempure', 'Repair', 'Advancements in EV Relay Technology', 'assets/img/blog/blog-1-2.jpg' ),
		array( 'By thempure', 'Repair', 'Latest Trends in Automotive Electronics', 'assets/img/blog/blog-1-3.jpg' ),
	);
	foreach ( $news_defaults as $index => $item ) {
		$number = $index + 1;
		$text_base = 3 + $index * 4;
		$schema['news']['fields'][] = cosmotone_home_field( "news_{$number}_author", "Article {$number} Author", 'text', $item[0], array( 'legacy_text' => $text_base ) );
		$schema['news']['fields'][] = cosmotone_home_field( "news_{$number}_category", "Article {$number} Category", 'text', $item[1], array( 'legacy_text' => $text_base + 1 ) );
		$schema['news']['fields'][] = cosmotone_home_field( "news_{$number}_title", "Article {$number} Title", 'text', $item[2], array( 'legacy_text' => $text_base + 2 ) );
		$schema['news']['fields'][] = cosmotone_home_field( "news_{$number}_button_text", "Article {$number} Button Text", 'text', 'Read More', array( 'legacy_text' => $text_base + 3 ) );
		$schema['news']['fields'][] = cosmotone_home_field( "news_{$number}_url", "Article {$number} Link", 'url', '#', array( 'legacy_link' => 1 + $index * 4 ) );
		$schema['news']['fields'][] = cosmotone_home_field( "news_{$number}_image", "Article {$number} Image", 'image', $item[3], array( 'legacy_image' => 1 + $index * 3 ) );
	}

	return $schema;
}

function cosmotone_home_sections_defaults() {
	$defaults = array();
	foreach ( cosmotone_home_sections_schema() as $section_key => $section ) {
		$defaults[ $section_key . '_enabled' ] = 1;
		foreach ( $section['fields'] as $field ) {
			if ( 'image' === $field['type'] ) {
				$defaults[ $field['key'] . '_id' ]  = 0;
				$defaults[ $field['key'] . '_url' ] = '';
			} else {
				$defaults[ $field['key'] ] = $field['default'];
			}
		}
	}
	return $defaults;
}

function cosmotone_migrate_legacy_home_sections( $post_id ) {
	$legacy = get_post_meta( $post_id, '_cosmotone_page_sections', true );
	if ( ! is_array( $legacy ) || empty( $legacy ) ) {
		return array();
	}

	$migrated = array();
	foreach ( cosmotone_home_sections_schema() as $section_key => $section ) {
		$legacy_key = isset( $section['legacy_section'] ) ? $section['legacy_section'] : '';
		$source     = $legacy_key && isset( $legacy[ $legacy_key ] ) && is_array( $legacy[ $legacy_key ] ) ? $legacy[ $legacy_key ] : array();
		$migrated[ $section_key . '_enabled' ] = empty( $source ) || ! array_key_exists( 'enabled', $source ) ? 1 : absint( $source['enabled'] );

		foreach ( $section['fields'] as $field ) {
			if ( 'image' === $field['type'] ) {
				$image = isset( $field['legacy_image'], $source['images'][ $field['legacy_image'] ] ) && is_array( $source['images'][ $field['legacy_image'] ] ) ? $source['images'][ $field['legacy_image'] ] : array();
				$migrated[ $field['key'] . '_id' ]  = isset( $image['id'] ) ? absint( $image['id'] ) : 0;
				$migrated[ $field['key'] . '_url' ] = isset( $image['url'] ) ? cosmotone_sanitize_page_section_media_url( $image['url'] ) : '';
				continue;
			}

			if ( isset( $field['legacy_text'] ) ) {
				$indexes = is_array( $field['legacy_text'] ) ? $field['legacy_text'] : array( $field['legacy_text'] );
				$parts   = array();
				foreach ( $indexes as $index ) {
					if ( isset( $source['texts'][ $index ] ) ) {
						$parts[] = $source['texts'][ $index ];
					}
				}
				if ( $parts ) {
					$migrated[ $field['key'] ] = implode( isset( $field['legacy_join'] ) ? $field['legacy_join'] : '', $parts );
				}
			} elseif ( isset( $field['legacy_link'], $source['links'][ $field['legacy_link'] ] ) ) {
				$migrated[ $field['key'] ] = $source['links'][ $field['legacy_link'] ];
			}
		}
	}

	if ( $migrated ) {
		update_post_meta( $post_id, '_cosmotone_home_sections', $migrated );
	}
	return $migrated;
}

function cosmotone_get_home_sections( $post_id = 0 ) {
	$post_id  = $post_id ? absint( $post_id ) : absint( get_option( 'page_on_front' ) );
	$saved    = $post_id ? get_post_meta( $post_id, '_cosmotone_home_sections', true ) : array();
	$saved    = is_array( $saved ) ? $saved : array();
	if ( ! $saved && $post_id ) {
		$saved = cosmotone_migrate_legacy_home_sections( $post_id );
	}
	return array_replace( cosmotone_home_sections_defaults(), $saved );
}

function cosmotone_home_image_url( $sections, $key ) {
	$image_id = isset( $sections[ $key . '_id' ] ) ? absint( $sections[ $key . '_id' ] ) : 0;
	if ( $image_id ) {
		$url = wp_get_attachment_image_url( $image_id, 'full' );
		if ( $url ) {
			return $url;
		}
	}
	if ( ! empty( $sections[ $key . '_url' ] ) ) {
		$url = $sections[ $key . '_url' ];
		return preg_match( '#^https?://#i', $url ) ? $url : trailingslashit( get_template_directory_uri() ) . ltrim( $url, '/' );
	}
	foreach ( cosmotone_home_sections_schema() as $section ) {
		foreach ( $section['fields'] as $field ) {
			if ( 'image' === $field['type'] && $key === $field['key'] ) {
				return trailingslashit( get_template_directory_uri() ) . ltrim( $field['default'], '/' );
			}
		}
	}
	return '';
}

function cosmotone_register_home_sections_metabox() {
	$post_id       = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
	$front_page_id = absint( get_option( 'page_on_front' ) );
	if ( $post_id && $front_page_id && $post_id === $front_page_id ) {
		add_meta_box( 'cosmotone_home_sections', 'Home Page Sections', 'cosmotone_render_home_sections_metabox', 'page', 'normal', 'high' );
	}
}
add_action( 'add_meta_boxes', 'cosmotone_register_home_sections_metabox' );

function cosmotone_home_admin_assets( $hook ) {
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'cosmotone_home_admin_assets' );

function cosmotone_render_home_sections_metabox( $post ) {
	$sections = cosmotone_get_home_sections( $post->ID );
	$schema   = cosmotone_home_sections_schema();
	wp_nonce_field( 'cosmotone_home_sections_nonce', 'cosmotone_home_sections_nonce_field' );
	?>
	<div class="cosmotone-home-tabs">
		<div class="cosmotone-home-tabs-nav">
			<button type="button" class="button cosmotone-home-tab active" data-tab="cosmotone-home-slider">Slider</button>
			<?php foreach ( $schema as $section_key => $section ) : ?>
				<button type="button" class="button cosmotone-home-tab" data-tab="cosmotone-home-<?php echo esc_attr( $section_key ); ?>"><?php echo esc_html( $section['label'] ); ?></button>
			<?php endforeach; ?>
		</div>

		<div class="cosmotone-home-pane active" id="cosmotone-home-slider">
			<p><?php esc_html_e( 'Slides are managed from the separate Sliders menu.', 'cosmotone' ); ?></p>
			<p><a class="button button-primary" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=cosmotone_slider' ) ); ?>">Add New Slider</a> <a class="button" href="<?php echo esc_url( admin_url( 'edit.php?post_type=cosmotone_slider' ) ); ?>">Manage Sliders</a></p>
		</div>

		<?php foreach ( $schema as $section_key => $section ) : ?>
			<div class="cosmotone-home-pane" id="cosmotone-home-<?php echo esc_attr( $section_key ); ?>">
				<label class="cosmotone-home-enabled"><input type="checkbox" name="cosmotone_home_sections[<?php echo esc_attr( $section_key ); ?>_enabled]" value="1" <?php checked( ! empty( $sections[ $section_key . '_enabled' ] ) ); ?>> Show this section</label>
				<div class="cosmotone-home-grid">
				<?php foreach ( $section['fields'] as $field ) :
					$key = $field['key'];
					if ( 'image' === $field['type'] ) :
						$image_id  = isset( $sections[ $key . '_id' ] ) ? absint( $sections[ $key . '_id' ] ) : 0;
						$image_url = cosmotone_home_image_url( $sections, $key );
						?>
						<div class="cosmotone-home-field cosmotone-home-image-field">
							<label><?php echo esc_html( $field['label'] ); ?></label>
							<img class="cosmotone-home-image-preview" src="<?php echo esc_url( $image_url ); ?>" alt="">
							<input class="cosmotone-home-image-id" type="hidden" name="cosmotone_home_sections[<?php echo esc_attr( $key ); ?>_id]" value="<?php echo esc_attr( $image_id ); ?>">
							<input class="cosmotone-home-image-url" type="hidden" name="cosmotone_home_sections[<?php echo esc_attr( $key ); ?>_url]" value="<?php echo esc_attr( isset( $sections[ $key . '_url' ] ) ? $sections[ $key . '_url' ] : '' ); ?>">
							<button type="button" class="button cosmotone-home-image-select">Select Image</button>
							<button type="button" class="button cosmotone-home-image-remove">Remove Image</button>
						</div>
					<?php elseif ( 'editor' === $field['type'] ) : ?>
						<div class="cosmotone-home-field cosmotone-home-field-wide">
							<label><?php echo esc_html( $field['label'] ); ?></label>
							<?php
							wp_editor(
								isset( $sections[ $key ] ) ? $sections[ $key ] : $field['default'],
								'cosmotone_home_' . sanitize_key( $key ),
								array(
									'textarea_name' => 'cosmotone_home_sections[' . $key . ']',
									'textarea_rows' => 5,
									'media_buttons' => false,
									'teeny'         => false,
								)
							);
							?>
						</div>
					<?php else : ?>
						<div class="cosmotone-home-field">
							<label><?php echo esc_html( $field['label'] ); ?></label>
							<input type="<?php echo 'url' === $field['type'] ? 'text' : 'text'; ?>" name="cosmotone_home_sections[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( isset( $sections[ $key ] ) ? $sections[ $key ] : $field['default'] ); ?>">
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<style>
	.cosmotone-home-tabs-nav{display:flex;flex-wrap:wrap;gap:7px;margin:16px 0 20px;padding-bottom:12px;border-bottom:1px solid #dcdcde}.cosmotone-home-tab.active{color:#fff;background:#2271b1;border-color:#2271b1}.cosmotone-home-pane{display:none}.cosmotone-home-pane.active{display:block}.cosmotone-home-enabled{display:block;margin:0 0 18px;font-weight:600}.cosmotone-home-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}.cosmotone-home-field{padding:12px;border:1px solid #dcdcde;background:#fff}.cosmotone-home-field-wide{grid-column:1/-1}.cosmotone-home-field>label{display:block;margin-bottom:8px;font-weight:600}.cosmotone-home-field>input[type=text]{width:100%}.cosmotone-home-image-preview{display:block;width:auto;max-width:220px;height:110px;object-fit:contain;margin:0 0 10px;background:#f0f0f1}.cosmotone-home-image-field .button{margin-right:6px}@media(max-width:782px){.cosmotone-home-grid{grid-template-columns:1fr}.cosmotone-home-field-wide{grid-column:auto}}
	</style>
	<script>
	(function(){
		var root=document.querySelector('.cosmotone-home-tabs');if(!root)return;
		var tabs=root.querySelectorAll('.cosmotone-home-tab'),panes=root.querySelectorAll('.cosmotone-home-pane');
		function activate(id){tabs.forEach(function(tab){tab.classList.toggle('active',tab.dataset.tab===id);});panes.forEach(function(pane){pane.classList.toggle('active',pane.id===id);});}
		tabs.forEach(function(tab){tab.addEventListener('click',function(){activate(tab.dataset.tab);window.history.replaceState(null,'','#'+tab.dataset.tab);});});
		if(window.location.hash&&root.querySelector(window.location.hash))activate(window.location.hash.substring(1));
		root.addEventListener('click',function(event){
			var select=event.target.closest('.cosmotone-home-image-select');
			if(select){event.preventDefault();var holder=select.closest('.cosmotone-home-image-field'),frame=wp.media({title:'Select Image',button:{text:'Use this image'},multiple:false,library:{type:'image'}});frame.on('select',function(){var image=frame.state().get('selection').first().toJSON();holder.querySelector('.cosmotone-home-image-id').value=image.id||0;holder.querySelector('.cosmotone-home-image-url').value=image.url||'';holder.querySelector('.cosmotone-home-image-preview').src=image.url||'';});frame.open();return;}
			var remove=event.target.closest('.cosmotone-home-image-remove');
			if(remove){event.preventDefault();var holder=remove.closest('.cosmotone-home-image-field');holder.querySelector('.cosmotone-home-image-id').value=0;holder.querySelector('.cosmotone-home-image-url').value='';holder.querySelector('.cosmotone-home-image-preview').src='';}
		});
	})();
	</script>
	<?php
}

function cosmotone_save_home_sections( $post_id ) {
	$front_page_id = absint( get_option( 'page_on_front' ) );
	if ( ! $front_page_id || $post_id !== $front_page_id || wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
		return;
	}
	if ( ! isset( $_POST['cosmotone_home_sections_nonce_field'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cosmotone_home_sections_nonce_field'] ) ), 'cosmotone_home_sections_nonce' ) || ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$raw = isset( $_POST['cosmotone_home_sections'] ) && is_array( $_POST['cosmotone_home_sections'] ) ? wp_unslash( $_POST['cosmotone_home_sections'] ) : array();
	$out = array();
	foreach ( cosmotone_home_sections_schema() as $section_key => $section ) {
		$out[ $section_key . '_enabled' ] = ! empty( $raw[ $section_key . '_enabled' ] ) ? 1 : 0;
		foreach ( $section['fields'] as $field ) {
			$key = $field['key'];
			if ( 'image' === $field['type'] ) {
				$out[ $key . '_id' ]  = isset( $raw[ $key . '_id' ] ) ? absint( $raw[ $key . '_id' ] ) : 0;
				$out[ $key . '_url' ] = isset( $raw[ $key . '_url' ] ) ? esc_url_raw( $raw[ $key . '_url' ] ) : '';
			} elseif ( 'editor' === $field['type'] ) {
				$out[ $key ] = isset( $raw[ $key ] ) ? wp_kses_post( $raw[ $key ] ) : '';
			} elseif ( 'url' === $field['type'] ) {
				$out[ $key ] = isset( $raw[ $key ] ) ? cosmotone_sanitize_page_section_link_url( $raw[ $key ] ) : '';
			} else {
				$out[ $key ] = isset( $raw[ $key ] ) ? sanitize_text_field( $raw[ $key ] ) : '';
			}
		}
	}
	update_post_meta( $post_id, '_cosmotone_home_sections', $out );
}
add_action( 'save_post_page', 'cosmotone_save_home_sections', 20 );
