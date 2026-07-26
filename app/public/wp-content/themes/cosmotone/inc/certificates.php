<?php
/**
 * Certificate content management.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

function cosmotone_register_certificate_content_type() {
	register_post_type(
		'cosmotone_cert',
		array(
			'labels' => array(
				'name'          => __( 'Certificates', 'cosmotone' ),
				'singular_name' => __( 'Certificate', 'cosmotone' ),
				'add_new_item'  => __( 'Add New Certificate', 'cosmotone' ),
				'edit_item'     => __( 'Edit Certificate', 'cosmotone' ),
				'all_items'     => __( 'All Certificates', 'cosmotone' ),
			),
			'public'             => true,
			'show_in_rest'       => false,
			'has_archive'        => 'certificates',
			'rewrite'            => array( 'slug' => 'certificate', 'with_front' => false ),
			'supports'           => array( 'title', 'page-attributes' ),
			'menu_icon'          => 'dashicons-awards',
			'menu_position'      => 11,
			'show_in_nav_menus'  => true,
			'exclude_from_search'=> false,
		)
	);
}
add_action( 'init', 'cosmotone_register_certificate_content_type' );

function cosmotone_certificate_flush_rewrites() {
	if ( '1.0.1' !== get_option( 'cosmotone_certificate_rewrite_version' ) ) {
		flush_rewrite_rules();
		update_option( 'cosmotone_certificate_rewrite_version', '1.0.1' );
	}
}
add_action( 'init', 'cosmotone_certificate_flush_rewrites', 99 );

function cosmotone_certificate_admin_media( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( $screen && 'cosmotone_cert' === $screen->post_type ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'cosmotone_certificate_admin_media' );

function cosmotone_add_certificate_metabox() {
	add_meta_box(
		'cosmotone_certificate_file',
		__( 'Certificate Image or PDF', 'cosmotone' ),
		'cosmotone_render_certificate_metabox',
		'cosmotone_cert',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'cosmotone_add_certificate_metabox' );

function cosmotone_certificate_attachment_id( $post_id ) {
	return absint( get_post_meta( $post_id, '_cosmotone_certificate_attachment_id', true ) );
}

function cosmotone_render_certificate_metabox( $post ) {
	$attachment_id = cosmotone_certificate_attachment_id( $post->ID );
	$file_url      = $attachment_id ? wp_get_attachment_url( $attachment_id ) : '';
	$mime_type     = $attachment_id ? (string) get_post_mime_type( $attachment_id ) : '';
	$image_url     = $attachment_id && 0 === strpos( $mime_type, 'image/' ) ? wp_get_attachment_image_url( $attachment_id, 'medium' ) : '';
	wp_nonce_field( 'cosmotone_save_certificate', 'cosmotone_certificate_nonce' );
	?>
	<p class="description"><?php esc_html_e( 'Upload or select one certificate image or PDF. The title and file will appear on the public Certificates page.', 'cosmotone' ); ?></p>
	<div id="cosmotone-certificate-file-wrap" style="padding:18px;margin-top:15px;border:1px solid #dcdcde;background:#fff">
		<img id="cosmotone-certificate-preview" src="<?php echo esc_url( $image_url ); ?>" alt="" style="<?php echo $image_url ? '' : 'display:none;'; ?>width:220px;max-width:100%;height:160px;object-fit:contain;margin-bottom:14px;background:#f0f0f1">
		<p id="cosmotone-certificate-filename" style="margin:0 0 14px;font-weight:600"><?php echo $file_url ? esc_html( wp_basename( $file_url ) ) : esc_html__( 'No file selected', 'cosmotone' ); ?></p>
		<input id="cosmotone-certificate-attachment-id" type="hidden" name="cosmotone_certificate_attachment_id" value="<?php echo esc_attr( $attachment_id ); ?>">
		<button id="cosmotone-certificate-select" class="button button-primary" type="button"><?php esc_html_e( 'Select Image or PDF', 'cosmotone' ); ?></button>
		<button id="cosmotone-certificate-remove" class="button" type="button"><?php esc_html_e( 'Remove File', 'cosmotone' ); ?></button>
	</div>
	<script>
	(function(){
		var select=document.getElementById('cosmotone-certificate-select'),remove=document.getElementById('cosmotone-certificate-remove'),input=document.getElementById('cosmotone-certificate-attachment-id'),preview=document.getElementById('cosmotone-certificate-preview'),filename=document.getElementById('cosmotone-certificate-filename');
		select.addEventListener('click',function(event){
			event.preventDefault();
			var frame=wp.media({title:'Select Certificate Image or PDF',button:{text:'Use this file'},multiple:false,library:{type:['image','application/pdf']}});
			frame.on('select',function(){
				var file=frame.state().get('selection').first().toJSON();
				input.value=file.id||0;filename.textContent=file.filename||'Selected file';
				if(file.type==='image'){preview.src=(file.sizes&&file.sizes.medium?file.sizes.medium.url:file.url)||'';preview.style.display='block';}else{preview.src='';preview.style.display='none';}
			});
			frame.open();
		});
		remove.addEventListener('click',function(event){event.preventDefault();input.value=0;preview.src='';preview.style.display='none';filename.textContent='No file selected';});
	})();
	</script>
	<?php
}

function cosmotone_save_certificate( $post_id ) {
	if ( ! isset( $_POST['cosmotone_certificate_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cosmotone_certificate_nonce'] ) ), 'cosmotone_save_certificate' ) || wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$attachment_id = isset( $_POST['cosmotone_certificate_attachment_id'] ) ? absint( $_POST['cosmotone_certificate_attachment_id'] ) : 0;
	if ( $attachment_id ) {
		$mime_type = (string) get_post_mime_type( $attachment_id );
		if ( 0 !== strpos( $mime_type, 'image/' ) && 'application/pdf' !== $mime_type ) {
			$attachment_id = 0;
		}
	}
	update_post_meta( $post_id, '_cosmotone_certificate_attachment_id', $attachment_id );
}
add_action( 'save_post_cosmotone_cert', 'cosmotone_save_certificate' );

function cosmotone_certificate_admin_columns( $columns ) {
	$updated = array();
	foreach ( $columns as $key => $label ) {
		$updated[ $key ] = $label;
		if ( 'cb' === $key ) {
			$updated['cosmotone_certificate_file'] = __( 'File', 'cosmotone' );
		}
	}
	return $updated;
}
add_filter( 'manage_cosmotone_cert_posts_columns', 'cosmotone_certificate_admin_columns' );

function cosmotone_certificate_admin_column_content( $column, $post_id ) {
	if ( 'cosmotone_certificate_file' !== $column ) {
		return;
	}
	$attachment_id = cosmotone_certificate_attachment_id( $post_id );
	if ( ! $attachment_id ) {
		echo '&mdash;';
		return;
	}
	$mime_type = (string) get_post_mime_type( $attachment_id );
	if ( 0 === strpos( $mime_type, 'image/' ) ) {
		echo wp_get_attachment_image( $attachment_id, array( 64, 64 ), false, array( 'style' => 'width:64px;height:64px;object-fit:contain' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		echo '<span class="dashicons dashicons-pdf" style="font-size:34px;width:40px;height:40px;color:#d63638"></span>';
	}
}
add_action( 'manage_cosmotone_cert_posts_custom_column', 'cosmotone_certificate_admin_column_content', 10, 2 );
