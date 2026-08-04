<?php
/**
 * CSV product importer.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

function cosmotone_add_product_import_page() {
	add_submenu_page(
		'edit.php?post_type=cosmotone_product',
		__( 'Import Products', 'cosmotone' ),
		__( 'Import Products', 'cosmotone' ),
		'edit_posts',
		'cosmotone-product-import',
		'cosmotone_render_product_import_page'
	);
}
add_action( 'admin_menu', 'cosmotone_add_product_import_page' );

function cosmotone_product_import_headers() {
	return array( 'product_title', 'product_code', 'description', 'category', 'subcategory', 'child_category', 'order_number', 'image_url', 'status' );
}

function cosmotone_render_product_import_page() {
	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_die( esc_html__( 'You do not have permission to import products.', 'cosmotone' ) );
	}

	$result_key = isset( $_GET['result'] ) ? sanitize_key( wp_unslash( $_GET['result'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$results    = $result_key ? get_transient( 'cosmotone_product_import_' . $result_key ) : false;
	$history    = cosmotone_product_import_history();
	if ( $result_key ) {
		delete_transient( 'cosmotone_product_import_' . $result_key );
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Import Products', 'cosmotone' ); ?></h1>
		<p><?php esc_html_e( 'Upload a UTF-8 CSV file to create products or update existing products with the same Product Code.', 'cosmotone' ); ?></p>

		<?php if ( is_array( $results ) ) : ?>
			<div class="notice <?php echo ! empty( $results['errors'] ) ? 'notice-warning' : 'notice-success'; ?> is-dismissible">
				<?php if ( ! empty( $results['rolled_back'] ) ) : ?>
					<p><strong><?php echo esc_html( sprintf( __( 'Rollback complete: %1$d newly created products moved to Trash, %2$d updated products restored, %3$d errors.', 'cosmotone' ), $results['trashed'], $results['restored'], count( $results['errors'] ) ) ); ?></strong></p>
				<?php else : ?>
					<p><strong><?php echo esc_html( sprintf( __( 'Import complete: %1$d created, %2$d updated, %3$d skipped, %4$d errors.', 'cosmotone' ), $results['created'], $results['updated'], $results['skipped'], count( $results['errors'] ) ) ); ?></strong></p>
				<?php endif; ?>
			</div>
			<?php if ( ! empty( $results['errors'] ) ) : ?>
				<div class="notice notice-error"><h2><?php esc_html_e( 'Rows requiring attention', 'cosmotone' ); ?></h2><ul style="list-style:disc;padding-left:22px">
					<?php foreach ( $results['errors'] as $error ) : ?><li><?php echo esc_html( $error ); ?></li><?php endforeach; ?>
				</ul></div>
			<?php endif; ?>
			<?php if ( ! empty( $results['batch_id'] ) && empty( $results['rolled_back'] ) ) : ?>
				<p><strong><?php esc_html_e( 'Need to undo this import?', 'cosmotone' ); ?></strong></p>
				<?php cosmotone_render_product_import_rollback_form( $results['batch_id'] ); ?>
			<?php endif; ?>
		<?php endif; ?>

		<div class="card" style="max-width:920px;padding:22px;margin-top:20px">
			<h2><?php esc_html_e( 'CSV requirements', 'cosmotone' ); ?></h2>
			<p><code><?php echo esc_html( implode( ', ', cosmotone_product_import_headers() ) ); ?></code></p>
			<ul style="list-style:disc;padding-left:22px">
				<li><?php esc_html_e( 'Product Title and Product Code are required.', 'cosmotone' ); ?></li>
				<li><?php esc_html_e( 'Product Code is the unique key. Matching products are updated instead of duplicated.', 'cosmotone' ); ?></li>
				<li><?php esc_html_e( 'Categories are created automatically in Category → Subcategory → Child Category order.', 'cosmotone' ); ?></li>
				<li><?php esc_html_e( 'Image URL must be a public HTTP or HTTPS URL. Leave it blank to keep an existing image.', 'cosmotone' ); ?></li>
				<li><?php esc_html_e( 'Status accepts publish or draft; blank values default to draft.', 'cosmotone' ); ?></li>
			</ul>
			<p><a class="button" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=cosmotone_product_csv_template' ), 'cosmotone_product_csv_template' ) ); ?>"><?php esc_html_e( 'Download Sample CSV', 'cosmotone' ); ?></a></p>

			<hr style="margin:24px 0">
			<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="cosmotone_import_products">
				<?php wp_nonce_field( 'cosmotone_import_products', 'cosmotone_product_import_nonce' ); ?>
				<label for="cosmotone-product-csv"><strong><?php esc_html_e( 'Choose CSV file', 'cosmotone' ); ?></strong></label><br><br>
				<input id="cosmotone-product-csv" type="file" name="product_csv" accept=".csv,text/csv" required>
				<p class="submit"><button class="button button-primary" type="submit"><?php esc_html_e( 'Import Products', 'cosmotone' ); ?></button></p>
			</form>
		</div>

		<?php if ( $history ) : ?>
			<div class="card" style="max-width:920px;padding:22px;margin-top:20px">
				<h2><?php esc_html_e( 'Recent imports', 'cosmotone' ); ?></h2>
				<table class="widefat striped">
					<thead><tr><th><?php esc_html_e( 'Date', 'cosmotone' ); ?></th><th><?php esc_html_e( 'Created', 'cosmotone' ); ?></th><th><?php esc_html_e( 'Updated', 'cosmotone' ); ?></th><th><?php esc_html_e( 'Status', 'cosmotone' ); ?></th><th><?php esc_html_e( 'Action', 'cosmotone' ); ?></th></tr></thead>
					<tbody>
					<?php foreach ( $history as $import ) : ?>
						<tr>
							<td><?php echo esc_html( wp_date( 'M j, Y g:i a', absint( $import['time'] ) ) ); ?></td>
							<td><?php echo esc_html( absint( $import['created'] ) ); ?></td>
							<td><?php echo esc_html( absint( $import['updated'] ) ); ?></td>
							<td><?php echo ! empty( $import['rolled_back'] ) ? esc_html__( 'Rolled back', 'cosmotone' ) : esc_html__( 'Active', 'cosmotone' ); ?></td>
							<td><?php ! empty( $import['rolled_back'] ) ? esc_html_e( '—', 'cosmotone' ) : cosmotone_render_product_import_rollback_form( $import['id'] ); ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

function cosmotone_render_product_import_rollback_form( $batch_id ) {
	?>
	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" style="display:inline" onsubmit="return confirm('<?php echo esc_js( __( 'Rollback this import? Newly created products will be moved to Trash and updated products will be restored.', 'cosmotone' ) ); ?>');">
		<input type="hidden" name="action" value="cosmotone_rollback_product_import">
		<input type="hidden" name="batch_id" value="<?php echo esc_attr( $batch_id ); ?>">
		<?php wp_nonce_field( 'cosmotone_rollback_product_import_' . $batch_id, 'cosmotone_rollback_nonce' ); ?>
		<button class="button" type="submit"><?php esc_html_e( 'Rollback Import', 'cosmotone' ); ?></button>
	</form>
	<?php
}

function cosmotone_product_import_history() {
	$history = get_option( 'cosmotone_product_import_history', array() );
	return is_array( $history ) ? $history : array();
}

function cosmotone_product_import_save_history( $summary ) {
	$history = cosmotone_product_import_history();
	array_unshift( $history, $summary );
	$removed = array_slice( $history, 10 );
	foreach ( $removed as $old_import ) {
		if ( ! empty( $old_import['id'] ) ) {
			delete_option( 'cosmotone_product_import_batch_' . sanitize_key( $old_import['id'] ) );
		}
	}
	update_option( 'cosmotone_product_import_history', array_slice( $history, 0, 10 ), false );
}

function cosmotone_product_import_update_history( $batch_id, $changes ) {
	$history = cosmotone_product_import_history();
	foreach ( $history as &$import ) {
		if ( isset( $import['id'] ) && $batch_id === $import['id'] ) {
			$import = array_merge( $import, $changes );
			break;
		}
	}
	unset( $import );
	update_option( 'cosmotone_product_import_history', $history, false );
}

function cosmotone_product_import_snapshot( $post_id ) {
	$post      = get_post( $post_id );
	$meta_keys = array( '_cosmotone_product_code', '_cosmotone_catalog_order', '_cosmotone_catalog_image_id', '_cosmotone_catalog_image_fallback', '_cosmotone_import_image_url' );
	$snapshot  = array(
		'post'  => array(
			'ID'           => $post_id,
			'post_title'   => $post ? $post->post_title : '',
			'post_content' => $post ? $post->post_content : '',
			'post_status'  => $post ? $post->post_status : 'draft',
			'menu_order'   => $post ? absint( $post->menu_order ) : 0,
		),
		'meta'  => array(),
		'terms' => wp_get_object_terms( $post_id, 'cosmotone_product_category', array( 'fields' => 'ids' ) ),
	);
	$snapshot['terms'] = is_wp_error( $snapshot['terms'] ) ? array() : array_map( 'absint', $snapshot['terms'] );
	foreach ( $meta_keys as $meta_key ) {
		$snapshot['meta'][ $meta_key ] = array(
			'existed' => metadata_exists( 'post', $post_id, $meta_key ),
			'value'   => get_post_meta( $post_id, $meta_key, true ),
		);
	}
	return $snapshot;
}

function cosmotone_download_product_csv_template() {
	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_die( esc_html__( 'You do not have permission to download this template.', 'cosmotone' ) );
	}
	check_admin_referer( 'cosmotone_product_csv_template' );

	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=cosmotone-product-import-template.csv' );
	header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );
	$output = fopen( 'php://output', 'w' );
	if ( false !== $output ) {
		fputcsv( $output, cosmotone_product_import_headers() );
		fputcsv( $output, array( 'Wiring Harness System', 'CT-WHS-001', 'Custom automotive wiring harness engineered for reliable electrical connections and durability.', 'Automotive Electrical', 'Electrical Systems', 'Panels & Wiring', '1', 'https://example.com/images/wiring-harness.jpg', 'publish' ) );
		fclose( $output );
	}
	exit;
}
add_action( 'admin_post_cosmotone_product_csv_template', 'cosmotone_download_product_csv_template' );

function cosmotone_import_find_product_by_code( $product_code ) {
	$ids = get_posts(
		array(
			'post_type'      => 'cosmotone_product',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_cosmotone_product_code', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value'     => $product_code, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
		)
	);
	return $ids ? absint( $ids[0] ) : 0;
}

function cosmotone_import_get_or_create_term( $name, $parent_id = 0 ) {
	$name = sanitize_text_field( $name );
	if ( '' === $name ) {
		return 0;
	}
	$existing = term_exists( $name, 'cosmotone_product_category', $parent_id );
	if ( $existing ) {
		return absint( is_array( $existing ) ? $existing['term_id'] : $existing );
	}
	$created = wp_insert_term( $name, 'cosmotone_product_category', array( 'parent' => $parent_id ) );
	return is_wp_error( $created ) ? $created : absint( $created['term_id'] );
}

function cosmotone_import_product_categories( $post_id, $row ) {
	$term_ids = array();
	$parent   = 0;
	foreach ( array( 'category', 'subcategory', 'child_category' ) as $column ) {
		$name = isset( $row[ $column ] ) ? trim( $row[ $column ] ) : '';
		if ( '' === $name ) {
			continue;
		}
		$term_id = cosmotone_import_get_or_create_term( $name, $parent );
		if ( is_wp_error( $term_id ) ) {
			return $term_id;
		}
		$term_ids[] = $term_id;
		$parent     = $term_id;
	}
	if ( $term_ids ) {
		wp_set_object_terms( $post_id, $term_ids, 'cosmotone_product_category', false );
	}
	return true;
}

function cosmotone_import_product_image( $post_id, $image_url, $product_title ) {
	$image_url = esc_url_raw( trim( $image_url ) );
	if ( ! $image_url || ! wp_http_validate_url( $image_url ) ) {
		return new WP_Error( 'invalid_image_url', __( 'Image URL is not a valid public HTTP or HTTPS URL.', 'cosmotone' ) );
	}
	if ( $image_url === get_post_meta( $post_id, '_cosmotone_import_image_url', true ) && absint( get_post_meta( $post_id, '_cosmotone_catalog_image_id', true ) ) ) {
		return true;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$attachment_id = media_sideload_image( $image_url, $post_id, $product_title, 'id' );
	if ( is_wp_error( $attachment_id ) ) {
		return $attachment_id;
	}
	update_post_meta( $post_id, '_cosmotone_catalog_image_id', absint( $attachment_id ) );
	update_post_meta( $post_id, '_cosmotone_import_image_url', $image_url );
	return true;
}

function cosmotone_handle_product_csv_import() {
	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_die( esc_html__( 'You do not have permission to import products.', 'cosmotone' ) );
	}
	check_admin_referer( 'cosmotone_import_products', 'cosmotone_product_import_nonce' );

	$results = array( 'created' => 0, 'updated' => 0, 'skipped' => 0, 'errors' => array() );
	$file    = isset( $_FILES['product_csv'] ) ? $_FILES['product_csv'] : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	if ( empty( $file['tmp_name'] ) || ! empty( $file['error'] ) || ! is_uploaded_file( $file['tmp_name'] ) ) {
		$results['errors'][] = __( 'The CSV file was not uploaded successfully.', 'cosmotone' );
		cosmotone_redirect_product_import_results( $results );
	}

	$extension = strtolower( pathinfo( isset( $file['name'] ) ? sanitize_file_name( $file['name'] ) : '', PATHINFO_EXTENSION ) );
	if ( 'csv' !== $extension ) {
		$results['errors'][] = __( 'Upload a file with the .csv extension.', 'cosmotone' );
		cosmotone_redirect_product_import_results( $results );
	}

	$handle = fopen( $file['tmp_name'], 'r' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen
	if ( false === $handle ) {
		$results['errors'][] = __( 'WordPress could not read the uploaded CSV.', 'cosmotone' );
		cosmotone_redirect_product_import_results( $results );
	}

	$headers = fgetcsv( $handle );
	if ( ! is_array( $headers ) ) {
		fclose( $handle );
		$results['errors'][] = __( 'The CSV is empty.', 'cosmotone' );
		cosmotone_redirect_product_import_results( $results );
	}
	$headers[0] = preg_replace( '/^\xEF\xBB\xBF/', '', (string) $headers[0] );
	$headers    = array_map( static function ( $header ) { return sanitize_key( trim( (string) $header ) ); }, $headers );
	$missing    = array_diff( array( 'product_title', 'product_code' ), $headers );
	if ( $missing ) {
		fclose( $handle );
		$results['errors'][] = sprintf( __( 'Missing required columns: %s.', 'cosmotone' ), implode( ', ', $missing ) );
		cosmotone_redirect_product_import_results( $results );
	}

	$batch_id = sanitize_key( gmdate( 'YmdHis' ) . '-' . wp_generate_password( 6, false, false ) );
	$batch    = array(
		'id'          => $batch_id,
		'time'        => time(),
		'user_id'     => get_current_user_id(),
		'created'     => array(),
		'updated'     => array(),
		'rolled_back' => false,
	);

	$row_number = 1;
	while ( ( $values = fgetcsv( $handle ) ) !== false ) {
		$row_number++;
		if ( $row_number > 501 ) {
			$results['errors'][] = __( 'Only the first 500 product rows were processed.', 'cosmotone' );
			break;
		}
		$values = array_pad( $values, count( $headers ), '' );
		$row    = array_combine( $headers, array_slice( $values, 0, count( $headers ) ) );
		$title  = isset( $row['product_title'] ) ? sanitize_text_field( trim( $row['product_title'] ) ) : '';
		$code   = isset( $row['product_code'] ) ? sanitize_text_field( trim( $row['product_code'] ) ) : '';
		if ( '' === $title && '' === $code ) {
			$results['skipped']++;
			continue;
		}
		if ( '' === $title || '' === $code ) {
			$results['errors'][] = sprintf( __( 'Row %d: Product Title and Product Code are required.', 'cosmotone' ), $row_number );
			continue;
		}

		$post_id   = cosmotone_import_find_product_by_code( $code );
		$is_update = (bool) $post_id;
		$created_in_batch = $post_id && in_array( absint( $post_id ), $batch['created'], true );
		$previous_state   = ( $is_update && ! $created_in_batch && ! isset( $batch['updated'][ $post_id ] ) ) ? cosmotone_product_import_snapshot( $post_id ) : null;
		$status    = isset( $row['status'] ) ? sanitize_key( trim( $row['status'] ) ) : 'draft';
		$status    = in_array( $status, array( 'publish', 'draft' ), true ) ? $status : 'draft';
		$order     = isset( $row['order_number'] ) ? absint( $row['order_number'] ) : 0;
		$post_data = array(
			'post_type'    => 'cosmotone_product',
			'post_title'   => $title,
			'post_content' => isset( $row['description'] ) ? wp_kses_post( $row['description'] ) : '',
			'post_status'  => $status,
			'menu_order'   => $order,
		);
		if ( $post_id ) {
			$post_data['ID'] = $post_id;
			$saved_id        = wp_update_post( $post_data, true );
		} else {
			$saved_id = wp_insert_post( $post_data, true );
		}
		if ( is_wp_error( $saved_id ) ) {
			$results['errors'][] = sprintf( __( 'Row %1$d (%2$s): %3$s', 'cosmotone' ), $row_number, $code, $saved_id->get_error_message() );
			continue;
		}
		$post_id = absint( $saved_id );
		if ( $is_update ) {
			if ( null !== $previous_state ) {
				$batch['updated'][ $post_id ] = $previous_state;
			}
		} else {
			$batch['created'][] = $post_id;
		}
		update_post_meta( $post_id, '_cosmotone_product_code', $code );
		update_post_meta( $post_id, '_cosmotone_catalog_order', $order );

		$category_result = cosmotone_import_product_categories( $post_id, $row );
		if ( is_wp_error( $category_result ) ) {
			$results['errors'][] = sprintf( __( 'Row %1$d (%2$s) category: %3$s', 'cosmotone' ), $row_number, $code, $category_result->get_error_message() );
		}
		if ( ! empty( $row['image_url'] ) ) {
			$image_result = cosmotone_import_product_image( $post_id, $row['image_url'], $title );
			if ( is_wp_error( $image_result ) ) {
				$results['errors'][] = sprintf( __( 'Row %1$d (%2$s) image: %3$s', 'cosmotone' ), $row_number, $code, $image_result->get_error_message() );
			}
		}
		if ( $is_update ) {
			$results['updated']++;
		} else {
			$results['created']++;
		}
	}
	fclose( $handle );
	if ( $batch['created'] || $batch['updated'] ) {
		$results['batch_id'] = $batch_id;
		update_option( 'cosmotone_product_import_batch_' . $batch_id, $batch, false );
		cosmotone_product_import_save_history(
			array(
				'id'          => $batch_id,
				'time'        => $batch['time'],
				'created'     => count( $batch['created'] ),
				'updated'     => count( $batch['updated'] ),
				'rolled_back' => false,
			)
		);
	}
	cosmotone_redirect_product_import_results( $results );
}
add_action( 'admin_post_cosmotone_import_products', 'cosmotone_handle_product_csv_import' );

function cosmotone_handle_product_import_rollback() {
	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_die( esc_html__( 'You do not have permission to rollback product imports.', 'cosmotone' ) );
	}

	$batch_id = isset( $_POST['batch_id'] ) ? sanitize_key( wp_unslash( $_POST['batch_id'] ) ) : '';
	check_admin_referer( 'cosmotone_rollback_product_import_' . $batch_id, 'cosmotone_rollback_nonce' );
	$results = array( 'created' => 0, 'updated' => 0, 'skipped' => 0, 'trashed' => 0, 'restored' => 0, 'rolled_back' => true, 'errors' => array() );
	$batch   = $batch_id ? get_option( 'cosmotone_product_import_batch_' . $batch_id, false ) : false;

	if ( ! is_array( $batch ) ) {
		$results['errors'][] = __( 'The selected import batch could not be found.', 'cosmotone' );
		cosmotone_redirect_product_import_results( $results );
	}
	if ( ! empty( $batch['rolled_back'] ) ) {
		$results['errors'][] = __( 'This import has already been rolled back.', 'cosmotone' );
		cosmotone_redirect_product_import_results( $results );
	}

	foreach ( (array) $batch['created'] as $post_id ) {
		$post_id = absint( $post_id );
		if ( ! $post_id || ! get_post( $post_id ) ) {
			continue;
		}
		if ( ! current_user_can( 'delete_post', $post_id ) || ! wp_trash_post( $post_id ) ) {
			$results['errors'][] = sprintf( __( 'Product ID %d could not be moved to Trash.', 'cosmotone' ), $post_id );
			continue;
		}
		$results['trashed']++;
	}

	foreach ( (array) $batch['updated'] as $post_id => $snapshot ) {
		$post_id = absint( $post_id );
		if ( ! $post_id || ! current_user_can( 'edit_post', $post_id ) || empty( $snapshot['post'] ) ) {
			$results['errors'][] = sprintf( __( 'Product ID %d could not be restored.', 'cosmotone' ), $post_id );
			continue;
		}
		$restored = wp_update_post( wp_parse_args( $snapshot['post'], array( 'ID' => $post_id ) ), true );
		if ( is_wp_error( $restored ) ) {
			$results['errors'][] = sprintf( __( 'Product ID %1$d could not be restored: %2$s', 'cosmotone' ), $post_id, $restored->get_error_message() );
			continue;
		}
		foreach ( (array) $snapshot['meta'] as $meta_key => $meta_state ) {
			if ( ! empty( $meta_state['existed'] ) ) {
				update_post_meta( $post_id, $meta_key, $meta_state['value'] );
			} else {
				delete_post_meta( $post_id, $meta_key );
			}
		}
		wp_set_object_terms( $post_id, array_map( 'absint', (array) $snapshot['terms'] ), 'cosmotone_product_category', false );
		$results['restored']++;
	}

	$batch['rolled_back']    = true;
	$batch['rolled_back_at'] = time();
	$batch['rolled_back_by'] = get_current_user_id();
	update_option( 'cosmotone_product_import_batch_' . $batch_id, $batch, false );
	cosmotone_product_import_update_history( $batch_id, array( 'rolled_back' => true ) );
	cosmotone_redirect_product_import_results( $results );
}
add_action( 'admin_post_cosmotone_rollback_product_import', 'cosmotone_handle_product_import_rollback' );

function cosmotone_redirect_product_import_results( $results ) {
	$key = wp_generate_password( 12, false, false );
	set_transient( 'cosmotone_product_import_' . $key, $results, 5 * MINUTE_IN_SECONDS );
	wp_safe_redirect( add_query_arg( array( 'post_type' => 'cosmotone_product', 'page' => 'cosmotone-product-import', 'result' => $key ), admin_url( 'edit.php' ) ) );
	exit;
}
