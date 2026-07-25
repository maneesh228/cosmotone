<?php
/**
 * CTA newsletter subscription handling.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

function cosmotone_register_subscriber_content_type() {
	register_post_type(
		'cosmotone_subscriber',
		array(
			'labels' => array(
				'name'          => __( 'Newsletter Subscribers', 'cosmotone' ),
				'singular_name' => __( 'Subscriber', 'cosmotone' ),
				'all_items'     => __( 'All Subscribers', 'cosmotone' ),
				'edit_item'     => __( 'View Subscriber', 'cosmotone' ),
				'search_items'  => __( 'Search Subscribers', 'cosmotone' ),
				'not_found'     => __( 'No subscribers found.', 'cosmotone' ),
			),
			'public'             => false,
			'show_ui'            => true,
			'show_in_rest'       => false,
			'menu_icon'          => 'dashicons-email-alt',
			'menu_position'      => 11,
			'supports'           => array( 'title' ),
			'map_meta_cap'       => true,
			'capabilities'       => array( 'create_posts' => 'do_not_allow' ),
		)
	);
}
add_action( 'init', 'cosmotone_register_subscriber_content_type' );

function cosmotone_subscriber_columns( $columns ) {
	return array(
		'cb'    => isset( $columns['cb'] ) ? $columns['cb'] : '<input type="checkbox">',
		'title' => __( 'Email Address', 'cosmotone' ),
		'date'  => __( 'Subscribed On', 'cosmotone' ),
	);
}
add_filter( 'manage_cosmotone_subscriber_posts_columns', 'cosmotone_subscriber_columns' );

function cosmotone_get_cta_page_id() {
	$page = get_page_by_path( 'cta', OBJECT, 'page' );
	return $page instanceof WP_Post ? $page->ID : 0;
}

function cosmotone_get_cta_attributes() {
	$page_id  = cosmotone_get_cta_page_id();
	$sections = $page_id ? get_post_meta( $page_id, '_cosmotone_page_sections', true ) : array();
	return is_array( $sections ) && ! empty( $sections['cta']['attributes'] ) && is_array( $sections['cta']['attributes'] )
		? $sections['cta']['attributes']
		: array();
}

function cosmotone_handle_cta_subscription() {
	check_admin_referer( 'cosmotone_cta_subscribe', 'cosmotone_cta_nonce' );

	$email    = isset( $_POST['email'] ) ? strtolower( sanitize_email( wp_unslash( $_POST['email'] ) ) ) : '';
	$redirect = wp_get_referer();
	$redirect = $redirect ? remove_query_arg( 'cta-status', $redirect ) : home_url( '/' );
	$status   = 'invalid';

	if ( $email && is_email( $email ) ) {
		$existing = get_posts(
			array(
				'post_type'      => 'cosmotone_subscriber',
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'meta_key'       => '_cosmotone_subscriber_email',
				'meta_value'     => $email,
			)
		);

		if ( $existing ) {
			$status = 'exists';
		} else {
			$subscriber_id = wp_insert_post(
				array(
					'post_type'   => 'cosmotone_subscriber',
					'post_status' => 'publish',
					'post_title'  => $email,
				),
				true
			);

			if ( ! is_wp_error( $subscriber_id ) ) {
				update_post_meta( $subscriber_id, '_cosmotone_subscriber_email', $email );
				$status     = 'success';
				$attributes = cosmotone_get_cta_attributes();
				$notify     = ! empty( $attributes['notification_email'] ) ? sanitize_email( $attributes['notification_email'] ) : sanitize_email( get_option( 'admin_email' ) );
				if ( $notify ) {
					wp_mail(
						$notify,
						__( 'New Cosmotone newsletter subscription', 'cosmotone' ),
						sprintf( __( 'A new visitor subscribed with the email address: %s', 'cosmotone' ), $email )
					);
				}
			}
		}
	}

	wp_safe_redirect( add_query_arg( 'cta-status', $status, $redirect ) . '#cosmotone-cta-title' );
	exit;
}
add_action( 'admin_post_cosmotone_cta_subscribe', 'cosmotone_handle_cta_subscription' );
add_action( 'admin_post_nopriv_cosmotone_cta_subscribe', 'cosmotone_handle_cta_subscription' );
