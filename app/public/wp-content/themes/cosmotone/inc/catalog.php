<?php
/**
 * Services and Products content management.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

function cosmotone_register_catalog_content_types() {
	register_post_type(
		'cosmotone_service',
		array(
			'labels' => array(
				'name'          => 'Services',
				'singular_name' => 'Service',
				'add_new_item'  => 'Add New Service',
				'edit_item'     => 'Edit Service',
				'all_items'     => 'All Services',
			),
			'public'       => true,
			'show_in_rest' => true,
			'has_archive'  => false,
			'rewrite'      => array( 'slug' => 'service', 'with_front' => false ),
			'supports'     => array( 'title', 'editor' ),
			'menu_icon'    => 'dashicons-admin-tools',
			'menu_position'=> 6,
			'show_in_nav_menus' => true,
		)
	);

	register_post_type(
		'cosmotone_product',
		array(
			'labels' => array(
				'name'          => 'Products',
				'singular_name' => 'Product',
				'add_new_item'  => 'Add New Product',
				'edit_item'     => 'Edit Product',
				'all_items'     => 'All Products',
			),
			'public'       => true,
			'show_in_rest' => true,
			'has_archive'  => false,
			'rewrite'      => array( 'slug' => 'product', 'with_front' => false ),
			'supports'     => array( 'title', 'editor' ),
			'menu_icon'    => 'dashicons-products',
			'menu_position'=> 7,
			'show_in_nav_menus' => true,
		)
	);

	register_taxonomy(
		'cosmotone_product_category',
		array( 'cosmotone_product' ),
		array(
			'labels' => array(
				'name'              => 'Product Categories',
				'singular_name'     => 'Product Category',
				'add_new_item'      => 'Add New Product Category',
				'edit_item'         => 'Edit Product Category',
				'parent_item'       => 'Parent Category',
				'parent_item_colon' => 'Parent Category:',
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'meta_box_cb'       => false,
			'rewrite'           => array( 'slug' => 'product-category', 'with_front' => false ),
		)
	);
}
add_action( 'init', 'cosmotone_register_catalog_content_types' );

function cosmotone_catalog_use_classic_editor( $use_block_editor, $post_type ) {
	return in_array( $post_type, array( 'cosmotone_service', 'cosmotone_product' ), true ) ? false : $use_block_editor;
}
add_filter( 'use_block_editor_for_post_type', 'cosmotone_catalog_use_classic_editor', 10, 2 );

function cosmotone_product_editor_toolbar( $buttons, $editor_id ) {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'cosmotone_product' !== $screen->post_type || 'content' !== $editor_id ) {
		return $buttons;
	}

	$format_controls = array( 'fontselect', 'fontsizeselect', 'forecolor', 'backcolor' );
	foreach ( $format_controls as $control ) {
		if ( ! in_array( $control, $buttons, true ) ) {
			$buttons[] = $control;
		}
	}

	return $buttons;
}
add_filter( 'mce_buttons_2', 'cosmotone_product_editor_toolbar', 10, 2 );

function cosmotone_product_editor_settings( $settings, $editor_id ) {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( $screen && 'cosmotone_product' === $screen->post_type && 'content' === $editor_id ) {
		$settings['fontsize_formats'] = '10px 12px 14px 16px 18px 20px 24px 28px 32px 36px 48px 60px';
	}
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'cosmotone_product_editor_settings', 10, 2 );

function cosmotone_catalog_admin_media( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( $screen && in_array( $screen->post_type, array( 'cosmotone_service', 'cosmotone_product' ), true ) ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'cosmotone_catalog_admin_media' );

function cosmotone_add_catalog_metaboxes() {
	add_meta_box( 'cosmotone_service_details', 'Service Card Details', 'cosmotone_render_catalog_details_metabox', 'cosmotone_service', 'normal', 'high' );
	add_meta_box( 'cosmotone_product_details', 'Product Card Details', 'cosmotone_render_catalog_details_metabox', 'cosmotone_product', 'normal', 'high' );
	add_meta_box( 'cosmotone_product_category_mapping', 'Category Mapping', 'cosmotone_render_product_category_mapping', 'cosmotone_product', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'cosmotone_add_catalog_metaboxes' );

function cosmotone_catalog_admin_columns( $columns ) {
	$updated = array();
	foreach ( $columns as $key => $label ) {
		$updated[ $key ] = $label;
		if ( 'cb' === $key ) {
			$updated['cosmotone_catalog_image'] = 'Image';
		}
		if ( 'title' === $key ) {
			$updated['cosmotone_catalog_order'] = 'Order';
		}
	}
	return $updated;
}

function cosmotone_product_admin_columns( $columns ) {
	$columns = cosmotone_catalog_admin_columns( $columns );
	$updated = array();
	foreach ( $columns as $key => $label ) {
		$updated[ $key ] = $label;
		if ( 'title' === $key ) {
			$updated['cosmotone_product_code'] = 'Product Code';
		}
	}
	return $updated;
}
add_filter( 'manage_cosmotone_service_posts_columns', 'cosmotone_catalog_admin_columns' );
add_filter( 'manage_cosmotone_product_posts_columns', 'cosmotone_product_admin_columns' );

function cosmotone_catalog_admin_column_content( $column, $post_id ) {
	if ( 'cosmotone_catalog_image' === $column ) {
		printf(
			'<img src="%1$s" alt="" style="width:56px;height:56px;object-fit:cover;border-radius:3px">',
			esc_url( cosmotone_catalog_image_url( $post_id, 'thumbnail' ) )
		);
	} elseif ( 'cosmotone_product_code' === $column && 'cosmotone_product' === get_post_type( $post_id ) ) {
		$product_code = cosmotone_product_code( $post_id );
		echo $product_code ? esc_html( $product_code ) : '&mdash;';
	} elseif ( 'cosmotone_catalog_order' === $column ) {
		echo esc_html( (string) absint( get_post_meta( $post_id, '_cosmotone_catalog_order', true ) ) );
	}
}
add_action( 'manage_cosmotone_service_posts_custom_column', 'cosmotone_catalog_admin_column_content', 10, 2 );
add_action( 'manage_cosmotone_product_posts_custom_column', 'cosmotone_catalog_admin_column_content', 10, 2 );

function cosmotone_catalog_image_url( $post_id, $size = 'large' ) {
	$image_id = absint( get_post_meta( $post_id, '_cosmotone_catalog_image_id', true ) );
	if ( $image_id ) {
		$url = wp_get_attachment_image_url( $image_id, $size );
		if ( $url ) {
			return $url;
		}
	}
	$fallback = get_post_meta( $post_id, '_cosmotone_catalog_image_fallback', true );
	if ( $fallback ) {
		return trailingslashit( get_template_directory_uri() ) . ltrim( $fallback, '/' );
	}
	return get_template_directory_uri() . '/assets/img/project/pro-1-1.jpg';
}

function cosmotone_product_code( $post_id ) {
	return (string) get_post_meta( $post_id, '_cosmotone_product_code', true );
}

function cosmotone_render_catalog_details_metabox( $post ) {
	wp_nonce_field( 'cosmotone_save_catalog_details', 'cosmotone_catalog_details_nonce' );
	$order      = absint( get_post_meta( $post->ID, '_cosmotone_catalog_order', true ) );
	$image_id   = absint( get_post_meta( $post->ID, '_cosmotone_catalog_image_id', true ) );
	$image_url  = cosmotone_catalog_image_url( $post->ID, 'medium' );
	$icon_class = get_post_meta( $post->ID, '_cosmotone_service_icon', true );
	$product_code = cosmotone_product_code( $post->ID );
	?>
	<p class="description">Use the WordPress title field for the card title and the main WordPress editor below it for the full description. The editor supports formatted text through TinyMCE.</p>
	<div class="cosmotone-catalog-grid">
		<div class="cosmotone-catalog-field">
			<label for="cosmotone_catalog_order">Order Number</label>
			<input type="number" min="0" step="1" id="cosmotone_catalog_order" name="cosmotone_catalog_order" value="<?php echo esc_attr( $order ); ?>">
			<p class="description">Lower numbers appear first.</p>
		</div>
		<?php if ( 'cosmotone_product' === $post->post_type ) : ?>
			<div class="cosmotone-catalog-field">
				<label for="cosmotone_product_code">Product Code</label>
				<input class="widefat" type="text" id="cosmotone_product_code" name="cosmotone_product_code" value="<?php echo esc_attr( $product_code ); ?>" placeholder="e.g. CT-1001">
				<p class="description">Shown on the product listing and product detail pages.</p>
			</div>
		<?php endif; ?>
		<?php if ( 'cosmotone_service' === $post->post_type ) : ?>
			<div class="cosmotone-catalog-field">
				<label for="cosmotone_service_icon">Icon Class</label>
				<input class="widefat" type="text" id="cosmotone_service_icon" name="cosmotone_service_icon" value="<?php echo esc_attr( $icon_class ); ?>" placeholder="flaticon-lamp">
				<p class="description">Optional icon class used in the service card.</p>
			</div>
		<?php endif; ?>
		<div class="cosmotone-catalog-field cosmotone-catalog-image-field">
			<label><?php echo 'cosmotone_service' === $post->post_type ? 'Service Image' : 'Product Image'; ?></label>
			<img class="cosmotone-catalog-image-preview" src="<?php echo esc_url( $image_url ); ?>" alt="">
			<input class="cosmotone-catalog-image-id" type="hidden" name="cosmotone_catalog_image_id" value="<?php echo esc_attr( $image_id ); ?>">
			<button type="button" class="button button-primary cosmotone-catalog-select-image">Select Image</button>
			<button type="button" class="button cosmotone-catalog-remove-image">Remove Image</button>
		</div>
	</div>
	<style>
	.cosmotone-catalog-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px;margin-top:18px}.cosmotone-catalog-field{padding:14px;border:1px solid #dcdcde;background:#fff}.cosmotone-catalog-field label{display:block;margin-bottom:8px;font-weight:600}.cosmotone-catalog-image-field{grid-column:1/-1}.cosmotone-catalog-image-preview{display:block;width:220px;max-width:100%;height:140px;object-fit:contain;margin-bottom:12px;background:#f0f0f1}.cosmotone-catalog-image-field .button{margin-right:6px}@media(max-width:782px){.cosmotone-catalog-grid{grid-template-columns:1fr}.cosmotone-catalog-image-field{grid-column:auto}}
	</style>
	<script>
	(function(){
		var holder=document.currentScript.previousElementSibling.previousElementSibling;
		var imageField=holder.querySelector('.cosmotone-catalog-image-field');
		imageField.querySelector('.cosmotone-catalog-select-image').addEventListener('click',function(event){
			event.preventDefault();
			var frame=wp.media({title:'Select Image',button:{text:'Use this image'},multiple:false,library:{type:'image'}});
			frame.on('select',function(){var image=frame.state().get('selection').first().toJSON();imageField.querySelector('.cosmotone-catalog-image-id').value=image.id||0;imageField.querySelector('.cosmotone-catalog-image-preview').src=image.url||'';});
			frame.open();
		});
		imageField.querySelector('.cosmotone-catalog-remove-image').addEventListener('click',function(event){event.preventDefault();imageField.querySelector('.cosmotone-catalog-image-id').value=0;imageField.querySelector('.cosmotone-catalog-image-preview').src='';});
	})();
	</script>
	<?php
}

function cosmotone_product_selected_category_chain( $post_id ) {
	$terms = wp_get_object_terms( $post_id, 'cosmotone_product_category' );
	if ( is_wp_error( $terms ) || ! $terms ) {
		return array( 0, 0, 0 );
	}
	$deepest = reset( $terms );
	$depth   = -1;
	foreach ( $terms as $term ) {
		$term_depth = count( get_ancestors( $term->term_id, 'cosmotone_product_category', 'taxonomy' ) );
		if ( $term_depth > $depth ) {
			$deepest = $term;
			$depth   = $term_depth;
		}
	}
	$chain = array_reverse( get_ancestors( $deepest->term_id, 'cosmotone_product_category', 'taxonomy' ) );
	$chain[] = $deepest->term_id;
	return array_pad( array_slice( $chain, 0, 3 ), 3, 0 );
}

function cosmotone_render_product_category_mapping( $post ) {
	$terms = get_terms(
		array(
			'taxonomy'   => 'cosmotone_product_category',
			'hide_empty' => false,
		)
	);
	$terms = is_wp_error( $terms ) ? array() : $terms;
	list( $category_id, $subcategory_id, $child_id ) = cosmotone_product_selected_category_chain( $post->ID );
	?>
	<p class="description">Create and organize terms from Products → Product Categories, then map this product through the three levels below.</p>
	<p><label for="cosmotone_product_category"><strong>Category</strong></label><br>
		<select class="widefat" id="cosmotone_product_category" name="cosmotone_product_category">
			<option value="0">Select category</option>
			<?php foreach ( $terms as $term ) : if ( 0 !== (int) $term->parent ) continue; ?>
				<option value="<?php echo esc_attr( $term->term_id ); ?>" <?php selected( $category_id, $term->term_id ); ?>><?php echo esc_html( $term->name ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p><label for="cosmotone_product_subcategory"><strong>Subcategory</strong></label><br>
		<select class="widefat" id="cosmotone_product_subcategory" name="cosmotone_product_subcategory">
			<option value="0">Select subcategory</option>
			<?php foreach ( $terms as $term ) : if ( 0 === (int) $term->parent ) continue; ?>
				<option value="<?php echo esc_attr( $term->term_id ); ?>" data-parent="<?php echo esc_attr( $term->parent ); ?>" <?php selected( $subcategory_id, $term->term_id ); ?>><?php echo esc_html( $term->name ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p><label for="cosmotone_product_child_category"><strong>Child Category</strong></label><br>
		<select class="widefat" id="cosmotone_product_child_category" name="cosmotone_product_child_category">
			<option value="0">Select child category</option>
			<?php foreach ( $terms as $term ) : if ( 0 === (int) $term->parent ) continue; ?>
				<option value="<?php echo esc_attr( $term->term_id ); ?>" data-parent="<?php echo esc_attr( $term->parent ); ?>" <?php selected( $child_id, $term->term_id ); ?>><?php echo esc_html( $term->name ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<script>
	(function(){
		var category=document.getElementById('cosmotone_product_category'),subcategory=document.getElementById('cosmotone_product_subcategory'),child=document.getElementById('cosmotone_product_child_category');
		function filter(select,parent,keep){Array.prototype.forEach.call(select.options,function(option,index){if(index===0)return;var visible=String(option.dataset.parent)===String(parent);option.hidden=!visible;option.disabled=!visible;if(!visible&&String(option.value)===String(select.value)&&!keep)select.value='0';});}
		function updateCategory(keep){filter(subcategory,category.value,keep);filter(child,subcategory.value,keep);}
		category.addEventListener('change',function(){subcategory.value='0';child.value='0';updateCategory(false);});
		subcategory.addEventListener('change',function(){child.value='0';filter(child,subcategory.value,false);});
		updateCategory(true);
	})();
	</script>
	<?php
}

function cosmotone_save_catalog_details( $post_id ) {
	if ( ! isset( $_POST['cosmotone_catalog_details_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cosmotone_catalog_details_nonce'] ) ), 'cosmotone_save_catalog_details' ) || wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$order = isset( $_POST['cosmotone_catalog_order'] ) ? absint( $_POST['cosmotone_catalog_order'] ) : 0;
	update_post_meta( $post_id, '_cosmotone_catalog_order', $order );
	update_post_meta( $post_id, '_cosmotone_catalog_image_id', isset( $_POST['cosmotone_catalog_image_id'] ) ? absint( $_POST['cosmotone_catalog_image_id'] ) : 0 );
	if ( 'cosmotone_service' === get_post_type( $post_id ) ) {
		update_post_meta( $post_id, '_cosmotone_service_icon', isset( $_POST['cosmotone_service_icon'] ) ? sanitize_html_class( wp_unslash( $_POST['cosmotone_service_icon'] ) ) : '' );
	}
	if ( 'cosmotone_product' === get_post_type( $post_id ) ) {
		update_post_meta( $post_id, '_cosmotone_product_code', isset( $_POST['cosmotone_product_code'] ) ? sanitize_text_field( wp_unslash( $_POST['cosmotone_product_code'] ) ) : '' );
	}
	remove_action( 'save_post_cosmotone_service', 'cosmotone_save_catalog_details' );
	remove_action( 'save_post_cosmotone_product', 'cosmotone_save_catalog_details' );
	wp_update_post( array( 'ID' => $post_id, 'menu_order' => $order ) );
	add_action( 'save_post_cosmotone_service', 'cosmotone_save_catalog_details' );
	add_action( 'save_post_cosmotone_product', 'cosmotone_save_catalog_details' );

	if ( 'cosmotone_product' === get_post_type( $post_id ) ) {
		$category = isset( $_POST['cosmotone_product_category'] ) ? absint( $_POST['cosmotone_product_category'] ) : 0;
		$sub      = isset( $_POST['cosmotone_product_subcategory'] ) ? absint( $_POST['cosmotone_product_subcategory'] ) : 0;
		$child    = isset( $_POST['cosmotone_product_child_category'] ) ? absint( $_POST['cosmotone_product_child_category'] ) : 0;
		$selected = $child ? $child : ( $sub ? $sub : $category );
		$term_ids = array();
		if ( $selected && term_exists( $selected, 'cosmotone_product_category' ) ) {
			$term_ids   = array_reverse( get_ancestors( $selected, 'cosmotone_product_category', 'taxonomy' ) );
			$term_ids[] = $selected;
			$term_ids   = array_slice( array_map( 'absint', $term_ids ), 0, 3 );
		}
		wp_set_object_terms( $post_id, $term_ids, 'cosmotone_product_category', false );
	}
}
add_action( 'save_post_cosmotone_service', 'cosmotone_save_catalog_details' );
add_action( 'save_post_cosmotone_product', 'cosmotone_save_catalog_details' );

function cosmotone_get_services( $limit = -1, $exclude = 0 ) {
	return new WP_Query(
		array(
			'post_type'      => 'cosmotone_service',
			'posts_per_page' => $limit,
			'post_status'    => 'publish',
			'post__not_in'   => $exclude ? array( absint( $exclude ) ) : array(),
			'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
			'order'          => 'ASC',
		)
	);
}

function cosmotone_get_products( $limit = -1, $exclude = 0 ) {
	return new WP_Query(
		array(
			'post_type'      => 'cosmotone_product',
			'posts_per_page' => $limit,
			'post_status'    => 'publish',
			'post__not_in'   => $exclude ? array( absint( $exclude ) ) : array(),
			'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
			'order'          => 'ASC',
		)
	);
}

function cosmotone_product_category_path( $post_id ) {
	$terms = wp_get_object_terms( $post_id, 'cosmotone_product_category' );
	if ( is_wp_error( $terms ) || ! $terms ) {
		return array();
	}
	usort(
		$terms,
		static function ( $a, $b ) {
			return count( get_ancestors( $a->term_id, 'cosmotone_product_category', 'taxonomy' ) ) <=> count( get_ancestors( $b->term_id, 'cosmotone_product_category', 'taxonomy' ) );
		}
	);
	return $terms;
}

function cosmotone_seed_catalog_content() {
	if ( '1.0.0' === get_option( 'cosmotone_catalog_seed_version' ) ) {
		return;
	}

	if ( ! get_posts( array( 'post_type' => 'cosmotone_service', 'posts_per_page' => 1, 'post_status' => 'any', 'fields' => 'ids' ) ) ) {
		$services = array(
			array( 'Electrical Panels', 'Reliable panel installation, inspection and repair services for safe electrical distribution.', 'assets/img/service/sv-1-1.jpg', 'flaticon-lamp' ),
			array( 'Air Conditioning', 'Professional electrical support for efficient residential and commercial air-conditioning systems.', 'assets/img/service/sv-1-2.jpg', 'flaticon-air-conditioner' ),
			array( 'Heating Service', 'Dependable electrical installation and maintenance for modern heating equipment.', 'assets/img/service/sv-1-3.jpg', 'flaticon-ac' ),
			array( 'Ceiling Fan Installation', 'Safe installation, rewiring and replacement of ceiling fans and controls.', 'assets/img/service/sv-1-4.jpg', 'flaticon-lamp' ),
			array( 'Short Circuit Repair', 'Fast diagnosis and repair of short circuits, damaged wiring and unsafe connections.', 'assets/img/service/sv-1-5.jpg', 'flaticon-short-circuit' ),
			array( 'Outdoor Lighting', 'Durable outdoor and architectural lighting installation for homes and businesses.', 'assets/img/service/sv-1-6.jpg', 'flaticon-lighting' ),
		);
		foreach ( $services as $index => $service ) {
			$post_id = wp_insert_post(
				array(
					'post_type'    => 'cosmotone_service',
					'post_status'  => 'publish',
					'post_title'   => $service[0],
					'post_content' => '<p>' . esc_html( $service[1] ) . '</p>',
					'menu_order'   => $index + 1,
				)
			);
			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, '_cosmotone_catalog_order', $index + 1 );
				update_post_meta( $post_id, '_cosmotone_catalog_image_fallback', $service[2] );
				update_post_meta( $post_id, '_cosmotone_service_icon', $service[3] );
			}
		}
	}

	if ( ! get_posts( array( 'post_type' => 'cosmotone_product', 'posts_per_page' => 1, 'post_status' => 'any', 'fields' => 'ids' ) ) ) {
		$root = wp_insert_term( 'Automotive Electrical', 'cosmotone_product_category' );
		$existing_root = term_exists( 'Automotive Electrical', 'cosmotone_product_category' );
		$root_id = is_wp_error( $root ) ? ( is_array( $existing_root ) ? absint( $existing_root['term_id'] ) : absint( $existing_root ) ) : absint( $root['term_id'] );
		$systems = wp_insert_term( 'Electrical Systems', 'cosmotone_product_category', array( 'parent' => $root_id ) );
		$ev      = wp_insert_term( 'EV Components', 'cosmotone_product_category', array( 'parent' => $root_id ) );
		$access  = wp_insert_term( 'Accessories', 'cosmotone_product_category', array( 'parent' => $root_id ) );
		$existing_systems = term_exists( 'Electrical Systems', 'cosmotone_product_category', $root_id );
		$existing_ev      = term_exists( 'EV Components', 'cosmotone_product_category', $root_id );
		$existing_access  = term_exists( 'Accessories', 'cosmotone_product_category', $root_id );
		$systems_id = is_wp_error( $systems ) ? ( is_array( $existing_systems ) ? absint( $existing_systems['term_id'] ) : absint( $existing_systems ) ) : absint( $systems['term_id'] );
		$ev_id      = is_wp_error( $ev ) ? ( is_array( $existing_ev ) ? absint( $existing_ev['term_id'] ) : absint( $existing_ev ) ) : absint( $ev['term_id'] );
		$access_id  = is_wp_error( $access ) ? ( is_array( $existing_access ) ? absint( $existing_access['term_id'] ) : absint( $existing_access ) ) : absint( $access['term_id'] );
		$child_names = array(
			'Panels & Wiring'      => $systems_id,
			'Relays'               => $ev_id,
			'Charging & Control'   => $ev_id,
			'Vehicle Accessories'  => $access_id,
			'Sensors & Connectors' => $access_id,
		);
		$children = array();
		foreach ( $child_names as $name => $parent_id ) {
			$term = wp_insert_term( $name, 'cosmotone_product_category', array( 'parent' => $parent_id ) );
			$existing_child = term_exists( $name, 'cosmotone_product_category', $parent_id );
			$children[ $name ] = is_wp_error( $term ) ? ( is_array( $existing_child ) ? absint( $existing_child['term_id'] ) : absint( $existing_child ) ) : absint( $term['term_id'] );
		}
		$products = array(
			array( 'Automotive Electrical', 'Complete electrical solutions engineered for vehicle safety, consistency and dependable performance.', 'assets/img/project/pro-1-1.jpg', $systems_id, $children['Panels & Wiring'] ),
			array( 'EV Relays', 'High-performance switching components designed for electric vehicle power systems.', 'assets/img/project/pro-1-2.jpg', $ev_id, $children['Relays'] ),
			array( 'EV-EVSE Relays', 'Reliable relays for charging infrastructure, energy control and EVSE applications.', 'assets/img/project/pro-1-3.jpg', $ev_id, $children['Charging & Control'] ),
			array( 'Electrical Accessories', 'Precision accessories that support secure automotive electrical installations.', 'assets/img/project/pro-1-4.jpg', $access_id, $children['Vehicle Accessories'] ),
			array( 'Sensors & Connectors', 'Accurate sensing and secure connector systems for dependable vehicle performance.', 'assets/img/project/pro-1-5.jpg', $access_id, $children['Sensors & Connectors'] ),
			array( 'Wiring Harness Systems', 'Custom wiring harness assemblies built for durability and efficient integration.', 'assets/img/project/pro-1-6.jpg', $systems_id, $children['Panels & Wiring'] ),
		);
		foreach ( $products as $index => $product ) {
			$post_id = wp_insert_post(
				array(
					'post_type'    => 'cosmotone_product',
					'post_status'  => 'publish',
					'post_title'   => $product[0],
					'post_content' => '<p>' . esc_html( $product[1] ) . '</p>',
					'menu_order'   => $index + 1,
				)
			);
			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, '_cosmotone_catalog_order', $index + 1 );
				update_post_meta( $post_id, '_cosmotone_catalog_image_fallback', $product[2] );
				wp_set_object_terms( $post_id, array( $root_id, $product[3], $product[4] ), 'cosmotone_product_category', false );
			}
		}
	}

	update_option( 'cosmotone_catalog_seed_version', '1.0.0' );
}
add_action( 'init', 'cosmotone_seed_catalog_content', 30 );

function cosmotone_catalog_rewrite_rules() {
	if ( '1.0.0' !== get_option( 'cosmotone_catalog_rewrite_version' ) ) {
		flush_rewrite_rules( false );
		update_option( 'cosmotone_catalog_rewrite_version', '1.0.0' );
	}
}
add_action( 'init', 'cosmotone_catalog_rewrite_rules', 40 );
