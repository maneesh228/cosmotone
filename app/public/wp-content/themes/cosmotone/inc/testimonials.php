<?php
/**
 * Testimonial content management.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the Testimonials admin menu.
 */
function cosmotone_register_testimonial_post_type() {
	register_post_type(
		'cosmotone_review',
		array(
			'labels' => array(
				'name'          => __( 'Testimonials', 'cosmotone' ),
				'singular_name' => __( 'Testimonial', 'cosmotone' ),
				'add_new'       => __( 'Add New Testimonial', 'cosmotone' ),
				'add_new_item'  => __( 'Add New Testimonial', 'cosmotone' ),
				'edit_item'     => __( 'Edit Testimonial', 'cosmotone' ),
				'new_item'      => __( 'New Testimonial', 'cosmotone' ),
				'all_items'     => __( 'All Testimonials', 'cosmotone' ),
				'search_items'  => __( 'Search Testimonials', 'cosmotone' ),
				'not_found'     => __( 'No testimonials found.', 'cosmotone' ),
				'menu_name'     => __( 'Testimonials', 'cosmotone' ),
			),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => false,
			'menu_icon'          => 'dashicons-format-quote',
			'menu_position'      => 8,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'capability_type'    => 'post',
			'map_meta_cap'       => true,
		)
	);
}
add_action( 'init', 'cosmotone_register_testimonial_post_type', 5 );

/**
 * Keep the testimonial edit screen simple and consistent with the card fields.
 */
function cosmotone_testimonial_use_classic_editor( $use_block_editor, $post_type ) {
	return 'cosmotone_review' === $post_type ? false : $use_block_editor;
}
add_filter( 'use_block_editor_for_post_type', 'cosmotone_testimonial_use_classic_editor', 10, 2 );

/**
 * Add role and rating fields. Name, review, image and order use core fields.
 */
function cosmotone_add_testimonial_metabox() {
	add_meta_box(
		'cosmotone_testimonial_details',
		__( 'Testimonial Card Details', 'cosmotone' ),
		'cosmotone_render_testimonial_metabox',
		'cosmotone_review',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'cosmotone_add_testimonial_metabox' );

function cosmotone_render_testimonial_metabox( $post ) {
	$role   = get_post_meta( $post->ID, '_cosmotone_testimonial_role', true );
	$rating = absint( get_post_meta( $post->ID, '_cosmotone_testimonial_rating', true ) );
	$rating = $rating ? min( 5, $rating ) : 5;

	wp_nonce_field( 'cosmotone_save_testimonial', 'cosmotone_testimonial_nonce' );
	?>
	<p class="description">
		<?php esc_html_e( 'Use the title for the client name, the main editor for the testimonial text, Featured Image for the client photo, and Order to control the card sequence.', 'cosmotone' ); ?>
	</p>
	<table class="form-table" role="presentation">
		<tr>
			<th scope="row"><label for="cosmotone_testimonial_role"><?php esc_html_e( 'Client Role', 'cosmotone' ); ?></label></th>
			<td><input class="regular-text" type="text" id="cosmotone_testimonial_role" name="cosmotone_testimonial_role" value="<?php echo esc_attr( $role ); ?>" placeholder="<?php esc_attr_e( 'Project Manager', 'cosmotone' ); ?>"></td>
		</tr>
		<tr>
			<th scope="row"><label for="cosmotone_testimonial_rating"><?php esc_html_e( 'Star Rating', 'cosmotone' ); ?></label></th>
			<td>
				<select id="cosmotone_testimonial_rating" name="cosmotone_testimonial_rating">
					<?php for ( $star = 5; $star >= 1; $star-- ) : ?>
						<option value="<?php echo esc_attr( $star ); ?>" <?php selected( $rating, $star ); ?>><?php echo esc_html( sprintf( _n( '%d star', '%d stars', $star, 'cosmotone' ), $star ) ); ?></option>
					<?php endfor; ?>
				</select>
			</td>
		</tr>
	</table>
	<?php
}

function cosmotone_save_testimonial( $post_id ) {
	if (
		! isset( $_POST['cosmotone_testimonial_nonce'] )
		|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cosmotone_testimonial_nonce'] ) ), 'cosmotone_save_testimonial' )
		|| wp_is_post_autosave( $post_id )
		|| wp_is_post_revision( $post_id )
		|| ! current_user_can( 'edit_post', $post_id )
	) {
		return;
	}

	$role   = isset( $_POST['cosmotone_testimonial_role'] ) ? sanitize_text_field( wp_unslash( $_POST['cosmotone_testimonial_role'] ) ) : '';
	$rating = isset( $_POST['cosmotone_testimonial_rating'] ) ? absint( $_POST['cosmotone_testimonial_rating'] ) : 5;

	update_post_meta( $post_id, '_cosmotone_testimonial_role', $role );
	update_post_meta( $post_id, '_cosmotone_testimonial_rating', max( 1, min( 5, $rating ) ) );
}
add_action( 'save_post_cosmotone_review', 'cosmotone_save_testimonial' );

/**
 * Resolve the testimonial card image.
 */
function cosmotone_testimonial_image_url( $post_id, $size = 'medium' ) {
	$image = get_the_post_thumbnail_url( $post_id, $size );
	if ( $image ) {
		return $image;
	}

	$fallback = get_post_meta( $post_id, '_cosmotone_testimonial_image_fallback', true );
	if ( $fallback ) {
		return preg_match( '#^https?://#i', $fallback )
			? $fallback
			: trailingslashit( get_template_directory_uri() ) . ltrim( $fallback, '/' );
	}

	return get_template_directory_uri() . '/assets/img/testimonial/author-1-1.png';
}

/**
 * Return the published testimonial cards in their configured order.
 */
function cosmotone_get_testimonials( $limit = -1 ) {
	return new WP_Query(
		array(
			'post_type'      => 'cosmotone_review',
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
			'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
			'order'          => 'ASC',
		)
	);
}

/**
 * Show useful card data on the testimonial listing screen.
 */
function cosmotone_testimonial_admin_columns( $columns ) {
	$updated = array();
	foreach ( $columns as $key => $label ) {
		$updated[ $key ] = $label;
		if ( 'cb' === $key ) {
			$updated['cosmotone_testimonial_image'] = __( 'Image', 'cosmotone' );
		}
		if ( 'title' === $key ) {
			$updated['cosmotone_testimonial_role']   = __( 'Role', 'cosmotone' );
			$updated['cosmotone_testimonial_rating'] = __( 'Rating', 'cosmotone' );
			$updated['cosmotone_testimonial_order']  = __( 'Order', 'cosmotone' );
		}
	}
	return $updated;
}
add_filter( 'manage_cosmotone_review_posts_columns', 'cosmotone_testimonial_admin_columns' );

function cosmotone_testimonial_admin_column_content( $column, $post_id ) {
	if ( 'cosmotone_testimonial_image' === $column ) {
		printf(
			'<img src="%1$s" alt="" style="width:56px;height:56px;object-fit:cover;border-radius:50%%">',
			esc_url( cosmotone_testimonial_image_url( $post_id, 'thumbnail' ) )
		);
	} elseif ( 'cosmotone_testimonial_role' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_cosmotone_testimonial_role', true ) );
	} elseif ( 'cosmotone_testimonial_rating' === $column ) {
		echo esc_html( str_repeat( '★', max( 1, min( 5, absint( get_post_meta( $post_id, '_cosmotone_testimonial_rating', true ) ) ) ) ) );
	} elseif ( 'cosmotone_testimonial_order' === $column ) {
		echo esc_html( (string) get_post_field( 'menu_order', $post_id ) );
	}
}
add_action( 'manage_cosmotone_review_posts_custom_column', 'cosmotone_testimonial_admin_column_content', 10, 2 );

/**
 * Seed the original three cards once so the existing homepage is preserved.
 */
function cosmotone_seed_testimonials() {
	if ( '1.0.1' === get_option( 'cosmotone_testimonial_seed_version' ) ) {
		return;
	}

	if ( ! get_posts( array( 'post_type' => 'cosmotone_review', 'posts_per_page' => 1, 'post_status' => 'any', 'fields' => 'ids' ) ) ) {
		$home = function_exists( 'cosmotone_get_home_sections' ) ? cosmotone_get_home_sections() : array();
		$defaults = array(
			array( "We've been using Cosmotone automotive electrical components for years. The product quality, consistency, and reliability have always exceeded our expectations.", 'Arun Kumar', 'Project Manager', 'assets/img/testimonial/author-1-1.png' ),
			array( 'Cosmotone delivers premium-quality wiring harnesses and relays with excellent technical support. A dependable partner for our manufacturing needs', 'Anil Patel', 'OEM Procurement Manager', 'assets/img/testimonial/author-1-2.png' ),
			array( 'The durability and performance of Cosmotone products have significantly improved our customer satisfaction. Highly recommended', 'Deepak Nair', 'Manager, Automotive Service Centre', 'assets/img/testimonial/author-1-3.png' ),
		);

		foreach ( $defaults as $index => $default ) {
			$number   = $index + 1;
			$text_key = "testimonial_{$number}_text";
			$name_key = "testimonial_{$number}_name";
			$role_key = "testimonial_{$number}_role";
			$image_key = "testimonial_{$number}_image";
			$text      = ! empty( $home[ $text_key ] ) ? $home[ $text_key ] : $default[0];
			$name      = ! empty( $home[ $name_key ] ) ? $home[ $name_key ] : $default[1];
			$role      = ! empty( $home[ $role_key ] ) ? $home[ $role_key ] : $default[2];
			$image_id  = ! empty( $home[ $image_key . '_id' ] ) ? absint( $home[ $image_key . '_id' ] ) : 0;
			$fallback  = ! empty( $home[ $image_key . '_url' ] ) ? $home[ $image_key . '_url' ] : $default[3];

			$post_id = wp_insert_post(
				array(
					'post_type'    => 'cosmotone_review',
					'post_status'  => 'publish',
					'post_title'   => sanitize_text_field( $name ),
					'post_content' => wp_kses_post( wpautop( $text ) ),
					'menu_order'   => $number,
				)
			);

			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, '_cosmotone_testimonial_role', sanitize_text_field( $role ) );
				update_post_meta( $post_id, '_cosmotone_testimonial_rating', 5 );
				update_post_meta( $post_id, '_cosmotone_testimonial_image_fallback', $fallback );
				if ( $image_id ) {
					set_post_thumbnail( $post_id, $image_id );
				}
			}
		}
	}

	update_option( 'cosmotone_testimonial_seed_version', '1.0.1' );
}
add_action( 'init', 'cosmotone_seed_testimonials', 30 );
