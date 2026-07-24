<?php
/**
 * Careers and Downloads content management.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

function cosmotone_register_resource_content_types() {
	register_post_type(
		'cosmotone_job',
		array(
			'labels' => array(
				'name'          => __( 'Careers', 'cosmotone' ),
				'singular_name' => __( 'Job', 'cosmotone' ),
				'add_new_item'  => __( 'Add New Job', 'cosmotone' ),
				'edit_item'     => __( 'Edit Job', 'cosmotone' ),
				'all_items'     => __( 'All Jobs', 'cosmotone' ),
			),
			'public'        => false,
			'show_ui'       => true,
			'show_in_rest'  => false,
			'menu_icon'     => 'dashicons-businessperson',
			'menu_position' => 9,
			'supports'      => array( 'title', 'editor', 'page-attributes' ),
		)
	);

	register_post_type(
		'cosmotone_download',
		array(
			'labels' => array(
				'name'          => __( 'Downloads', 'cosmotone' ),
				'singular_name' => __( 'Download', 'cosmotone' ),
				'add_new_item'  => __( 'Add New Download', 'cosmotone' ),
				'edit_item'     => __( 'Edit Download', 'cosmotone' ),
				'all_items'     => __( 'All Downloads', 'cosmotone' ),
			),
			'public'        => false,
			'show_ui'       => true,
			'show_in_rest'  => false,
			'menu_icon'     => 'dashicons-download',
			'menu_position' => 10,
			'supports'      => array( 'title', 'editor', 'page-attributes' ),
		)
	);
}
add_action( 'init', 'cosmotone_register_resource_content_types' );

function cosmotone_resource_use_classic_editor( $use_block_editor, $post_type ) {
	return in_array( $post_type, array( 'cosmotone_job', 'cosmotone_download' ), true ) ? false : $use_block_editor;
}
add_filter( 'use_block_editor_for_post_type', 'cosmotone_resource_use_classic_editor', 10, 2 );

function cosmotone_add_resource_metaboxes() {
	add_meta_box( 'cosmotone_job_details', __( 'Job Card Details', 'cosmotone' ), 'cosmotone_render_job_metabox', 'cosmotone_job', 'normal', 'high' );
	add_meta_box( 'cosmotone_download_details', __( 'Download Details', 'cosmotone' ), 'cosmotone_render_download_metabox', 'cosmotone_download', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'cosmotone_add_resource_metaboxes' );

function cosmotone_get_media_page_id() {
	$page = get_page_by_path( 'media', OBJECT, 'page' );
	return $page instanceof WP_Post ? $page->ID : 0;
}

function cosmotone_media_uses_automatic_images( $page_id ) {
	if ( ! metadata_exists( 'post', $page_id, '_cosmotone_media_auto_images' ) ) {
		return false;
	}
	return (bool) get_post_meta( $page_id, '_cosmotone_media_auto_images', true );
}

function cosmotone_sanitize_media_video_urls( $value ) {
	$urls = preg_split( '/\R/u', (string) $value, -1, PREG_SPLIT_NO_EMPTY );
	$urls = array_filter(
		array_map(
			static function ( $url ) {
				return esc_url_raw( trim( $url ) );
			},
			$urls
		)
	);
	return implode( "\n", $urls );
}

function cosmotone_media_embed_url( $url ) {
	$parts = wp_parse_url( $url );
	if ( empty( $parts['host'] ) ) {
		return '';
	}
	$host = strtolower( preg_replace( '/^www\./', '', $parts['host'] ) );

	if ( 'youtu.be' === $host ) {
		$video_id = trim( isset( $parts['path'] ) ? $parts['path'] : '', '/' );
	} elseif ( in_array( $host, array( 'youtube.com', 'm.youtube.com' ), true ) ) {
		$video_id = '';
		if ( ! empty( $parts['query'] ) ) {
			parse_str( $parts['query'], $query );
			$video_id = isset( $query['v'] ) ? $query['v'] : '';
		}
		if ( ! $video_id && ! empty( $parts['path'] ) && preg_match( '#/(?:embed|shorts)/([^/?]+)#', $parts['path'], $match ) ) {
			$video_id = $match[1];
		}
	}

	if ( ! empty( $video_id ) && preg_match( '/^[A-Za-z0-9_-]{6,20}$/', $video_id ) ) {
		return 'https://www.youtube.com/embed/' . rawurlencode( $video_id );
	}

	if ( in_array( $host, array( 'vimeo.com', 'player.vimeo.com' ), true ) && ! empty( $parts['path'] ) && preg_match( '#(?:video/)?(\d+)#', $parts['path'], $match ) ) {
		return 'https://player.vimeo.com/video/' . $match[1];
	}

	return '';
}

function cosmotone_media_upload_gallery_defaults( $settings ) {
	global $pagenow;
	if ( 'media-new.php' === $pagenow ) {
		$settings['multipart_params'] = isset( $settings['multipart_params'] ) && is_array( $settings['multipart_params'] ) ? $settings['multipart_params'] : array();
		$settings['multipart_params']['cosmotone_show_in_gallery'] = '1';
	}
	return $settings;
}
add_filter( 'plupload_init', 'cosmotone_media_upload_gallery_defaults' );

function cosmotone_set_new_attachment_gallery_flag( $attachment_id ) {
	if ( ! isset( $_REQUEST['cosmotone_show_in_gallery'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}
	$mime = (string) get_post_mime_type( $attachment_id );
	if ( 0 !== strpos( $mime, 'image/' ) && 0 !== strpos( $mime, 'video/' ) ) {
		return;
	}
	update_post_meta( $attachment_id, '_cosmotone_show_in_gallery', ! empty( $_REQUEST['cosmotone_show_in_gallery'] ) ? 1 : 0 ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
}
add_action( 'add_attachment', 'cosmotone_set_new_attachment_gallery_flag' );

function cosmotone_attachment_gallery_field( $form_fields, $attachment ) {
	$checked = (bool) get_post_meta( $attachment->ID, '_cosmotone_show_in_gallery', true );
	$name    = 'attachments[' . absint( $attachment->ID ) . '][cosmotone_show_in_gallery]';
	$form_fields['cosmotone_show_in_gallery'] = array(
		'label' => __( 'Media Page Gallery', 'cosmotone' ),
		'input' => 'html',
		'html'  => '<input type="hidden" name="' . esc_attr( $name ) . '" value="0"><label><input type="checkbox" name="' . esc_attr( $name ) . '" value="1" ' . checked( $checked, true, false ) . '> ' . esc_html__( 'Show this item in the public Media gallery', 'cosmotone' ) . '</label>',
		'helps' => __( 'Only checked images and videos are shown unless they were manually selected in Media → Media Page.', 'cosmotone' ),
	);
	return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'cosmotone_attachment_gallery_field', 10, 2 );

function cosmotone_save_attachment_gallery_field( $post, $attachment ) {
	if ( array_key_exists( 'cosmotone_show_in_gallery', $attachment ) ) {
		update_post_meta( $post['ID'], '_cosmotone_show_in_gallery', ! empty( $attachment['cosmotone_show_in_gallery'] ) ? 1 : 0 );
	}
	return $post;
}
add_filter( 'attachment_fields_to_save', 'cosmotone_save_attachment_gallery_field', 10, 2 );

function cosmotone_handle_media_video_submission() {
	if ( empty( $_POST['cosmotone_add_media_video'] ) ) {
		return;
	}
	if ( ! current_user_can( 'upload_files' ) ) {
		wp_die( esc_html__( 'You do not have permission to add media.', 'cosmotone' ) );
	}
	check_admin_referer( 'cosmotone_add_media_video', 'cosmotone_add_media_video_nonce' );

	$url       = isset( $_POST['cosmotone_media_video_url'] ) ? esc_url_raw( trim( wp_unslash( $_POST['cosmotone_media_video_url'] ) ) ) : '';
	$is_embed  = $url && cosmotone_media_embed_url( $url );
	$is_direct = $url && preg_match( '/\.mp4(?:\?.*)?$/i', $url );
	$redirect  = 'media-new.php';

	if ( ! $url || ( ! $is_embed && ! $is_direct ) ) {
		wp_safe_redirect( add_query_arg( 'cosmotone-video-error', 'invalid', admin_url( $redirect ) ) );
		exit;
	}

	$page_id = cosmotone_get_media_page_id();
	if ( ! $page_id ) {
		wp_safe_redirect( add_query_arg( 'cosmotone-video-error', 'page', admin_url( $redirect ) ) );
		exit;
	}

	$videos = preg_split( '/\R/u', (string) get_post_meta( $page_id, '_cosmotone_media_video_urls', true ), -1, PREG_SPLIT_NO_EMPTY );
	$videos = array_map( 'trim', $videos );
	if ( ! in_array( $url, $videos, true ) ) {
		$videos[] = $url;
	}
	update_post_meta( $page_id, '_cosmotone_media_video_urls', implode( "\n", $videos ) );
	update_post_meta( $page_id, '_cosmotone_media_configured', 1 );

	wp_safe_redirect( add_query_arg( 'cosmotone-video-added', '1', admin_url( $redirect ) ) );
	exit;
}
add_action( 'admin_init', 'cosmotone_handle_media_video_submission' );

function cosmotone_render_add_media_video_box() {
	global $pagenow;
	if ( 'media-new.php' !== $pagenow || ! current_user_can( 'upload_files' ) ) {
		return;
	}
	?>
	<?php if ( isset( $_GET['cosmotone-video-added'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
		<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'YouTube video added to the Media page.', 'cosmotone' ); ?></p></div>
	<?php elseif ( isset( $_GET['cosmotone-video-error'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
		<div class="notice notice-error is-dismissible"><p><?php esc_html_e( 'Enter a valid YouTube, Vimeo, or direct MP4 URL.', 'cosmotone' ); ?></p></div>
	<?php endif; ?>
	<div class="notice inline cosmotone-add-media-video" style="padding:16px 20px;margin:16px 20px 16px 0;border-left-color:#2271b1">
		<h2 style="margin:0 0 8px"><?php esc_html_e( 'Media Gallery Visibility', 'cosmotone' ); ?></h2>
		<label style="display:block;margin:8px 0 18px;font-weight:600">
			<input id="cosmotone-upload-show-gallery" type="checkbox" checked>
			<?php esc_html_e( 'Show uploaded images or videos in the public Media gallery', 'cosmotone' ); ?>
		</label>
		<p class="description" style="margin-top:-10px"><?php esc_html_e( 'This is checked by default. Uncheck it before uploading files intended only for another page.', 'cosmotone' ); ?></p>
		<hr style="margin:18px 0">
		<h2 style="margin:0 0 8px"><?php esc_html_e( 'Add YouTube Video to Media Page', 'cosmotone' ); ?></h2>
		<p class="description"><?php esc_html_e( 'Paste a YouTube URL here. It will appear in the Videos section of the public Media page.', 'cosmotone' ); ?></p>
		<form method="post" style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin-top:12px">
			<?php wp_nonce_field( 'cosmotone_add_media_video', 'cosmotone_add_media_video_nonce' ); ?>
			<input class="regular-text" type="url" name="cosmotone_media_video_url" required placeholder="https://www.youtube.com/watch?v=..." aria-label="<?php esc_attr_e( 'YouTube video URL', 'cosmotone' ); ?>" style="min-width:420px;max-width:100%">
			<button class="button button-primary" type="submit" name="cosmotone_add_media_video" value="1"><?php esc_html_e( 'Add YouTube Video', 'cosmotone' ); ?></button>
			<a class="button" href="<?php echo esc_url( admin_url( 'upload.php?page=cosmotone-media-page' ) ); ?>"><?php esc_html_e( 'Manage Media Page', 'cosmotone' ); ?></a>
		</form>
	</div>
	<script>
	document.addEventListener('DOMContentLoaded',function(){
		var checkbox=document.getElementById('cosmotone-upload-show-gallery');
		var uploadForm=document.getElementById('file-form');
		if(!checkbox)return;
		var hidden=document.createElement('input');
		hidden.type='hidden';hidden.name='cosmotone_show_in_gallery';hidden.value='1';
		if(uploadForm)uploadForm.appendChild(hidden);
		function sync(){
			var value=checkbox.checked?'1':'0';
			hidden.value=value;
			if(window.wpUploaderInit){
				window.wpUploaderInit.multipart_params=window.wpUploaderInit.multipart_params||{};
				window.wpUploaderInit.multipart_params.cosmotone_show_in_gallery=value;
			}
			if(window.wp&&wp.Uploader&&wp.Uploader.defaults){
				wp.Uploader.defaults.multipart_params=wp.Uploader.defaults.multipart_params||{};
				wp.Uploader.defaults.multipart_params.cosmotone_show_in_gallery=value;
			}
			if(window.uploader&&window.uploader.settings){
				window.uploader.settings.multipart_params=window.uploader.settings.multipart_params||{};
				window.uploader.settings.multipart_params.cosmotone_show_in_gallery=value;
			}
		}
		checkbox.addEventListener('change',sync);sync();
	});
	</script>
	<?php
}
add_action( 'admin_notices', 'cosmotone_render_add_media_video_box' );

function cosmotone_add_media_management_page() {
	add_media_page(
		__( 'Media Page Gallery', 'cosmotone' ),
		__( 'Media Page', 'cosmotone' ),
		'upload_files',
		'cosmotone-media-page',
		'cosmotone_render_media_management_page'
	);
}
add_action( 'admin_menu', 'cosmotone_add_media_management_page' );

function cosmotone_render_media_management_fields( $page_id ) {
	$ids_raw    = (string) get_post_meta( $page_id, '_cosmotone_media_gallery_ids', true );
	$ids        = array_filter( array_map( 'absint', explode( ',', $ids_raw ) ) );
	$video_urls = (string) get_post_meta( $page_id, '_cosmotone_media_video_urls', true );
	?>
	<p class="description"><?php esc_html_e( 'Only the images selected below are displayed on the public Media page. Other Media Library uploads remain private to the pages where they are used.', 'cosmotone' ); ?></p>
	<input type="hidden" id="cosmotone-media-gallery-ids" name="cosmotone_media_gallery_ids" value="<?php echo esc_attr( implode( ',', $ids ) ); ?>">
	<div id="cosmotone-media-gallery-preview" style="display:flex;flex-wrap:wrap;gap:10px;margin:12px 0">
		<?php foreach ( $ids as $image_id ) :
			$thumb = wp_get_attachment_image_url( $image_id, 'thumbnail' );
			if ( $thumb ) :
				?>
				<img src="<?php echo esc_url( $thumb ); ?>" alt="" style="width:90px;height:70px;object-fit:cover;border:1px solid #dcdcde">
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<p>
		<button type="button" class="button button-primary" id="cosmotone-media-gallery-select"><?php esc_html_e( 'Choose Manual Gallery Images', 'cosmotone' ); ?></button>
		<button type="button" class="button" id="cosmotone-media-gallery-clear"><?php esc_html_e( 'Clear Manual Selection', 'cosmotone' ); ?></button>
	</p>
	<p><label for="cosmotone-media-video-urls"><strong><?php esc_html_e( 'YouTube, Vimeo, or MP4 URLs (one per line)', 'cosmotone' ); ?></strong></label></p>
	<textarea class="large-text code" id="cosmotone-media-video-urls" name="cosmotone_media_video_urls" rows="8" placeholder="https://www.youtube.com/watch?v=..."><?php echo esc_textarea( $video_urls ); ?></textarea>
	<p class="description"><?php esc_html_e( 'Each valid URL is displayed as a video card on the public Media page.', 'cosmotone' ); ?></p>
	<?php
}

function cosmotone_render_media_management_page() {
	if ( ! current_user_can( 'upload_files' ) ) {
		wp_die( esc_html__( 'You do not have permission to manage media.', 'cosmotone' ) );
	}
	$page_id = cosmotone_get_media_page_id();
	if ( ! $page_id ) {
		echo '<div class="wrap"><h1>' . esc_html__( 'Media Page', 'cosmotone' ) . '</h1><div class="notice notice-error"><p>' . esc_html__( 'The Media page could not be found.', 'cosmotone' ) . '</p></div></div>';
		return;
	}

	if ( isset( $_POST['cosmotone_media_manager_action'] ) ) {
		check_admin_referer( 'cosmotone_save_media_manager', 'cosmotone_media_manager_nonce' );
		$ids    = isset( $_POST['cosmotone_media_gallery_ids'] ) ? array_filter( array_map( 'absint', explode( ',', sanitize_text_field( wp_unslash( $_POST['cosmotone_media_gallery_ids'] ) ) ) ) ) : array();
		$videos = isset( $_POST['cosmotone_media_video_urls'] ) ? cosmotone_sanitize_media_video_urls( wp_unslash( $_POST['cosmotone_media_video_urls'] ) ) : '';
		update_post_meta( $page_id, '_cosmotone_media_gallery_ids', implode( ',', $ids ) );
		update_post_meta( $page_id, '_cosmotone_media_video_urls', $videos );
		update_post_meta( $page_id, '_cosmotone_media_auto_images', 0 );
		update_post_meta( $page_id, '_cosmotone_media_configured', 1 );
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Media page settings saved.', 'cosmotone' ) . '</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Media Page Gallery', 'cosmotone' ); ?></h1>
		<p><?php esc_html_e( 'Manage the images and videos displayed on the public Media page.', 'cosmotone' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'cosmotone_save_media_manager', 'cosmotone_media_manager_nonce' ); ?>
			<input type="hidden" name="cosmotone_media_manager_action" value="save">
			<?php cosmotone_render_media_management_fields( $page_id ); ?>
			<?php submit_button( __( 'Save Media Page', 'cosmotone' ) ); ?>
		</form>
		<p><a class="button" href="<?php echo esc_url( get_edit_post_link( $page_id ) ); ?>"><?php esc_html_e( 'Edit Media Page Sections', 'cosmotone' ); ?></a> <a class="button" href="<?php echo esc_url( get_permalink( $page_id ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'View Media Page', 'cosmotone' ); ?></a></p>
	</div>
	<script>
	document.addEventListener('DOMContentLoaded',function(){
		var select=document.getElementById('cosmotone-media-gallery-select');
		var clear=document.getElementById('cosmotone-media-gallery-clear');
		var input=document.getElementById('cosmotone-media-gallery-ids');
		var preview=document.getElementById('cosmotone-media-gallery-preview');
		if(!select||typeof wp==='undefined'||!wp.media)return;
		select.addEventListener('click',function(event){
			event.preventDefault();
			var frame=wp.media({title:'Choose gallery images',button:{text:'Use these images'},multiple:true,library:{type:'image'}});
			frame.on('select',function(){
				var ids=[],html='';
				frame.state().get('selection').each(function(item){
					var image=item.toJSON(),thumb=image.sizes&&image.sizes.thumbnail?image.sizes.thumbnail.url:image.url;
					ids.push(image.id);html+='<img src="'+thumb+'" alt="" style="width:90px;height:70px;object-fit:cover;border:1px solid #dcdcde">';
				});
				input.value=ids.join(',');preview.innerHTML=html;
			});
			frame.open();
		});
		clear.addEventListener('click',function(event){event.preventDefault();input.value='';preview.innerHTML='';});
	});
	</script>
	<?php
}

function cosmotone_add_media_page_metabox( $post ) {
	if ( $post instanceof WP_Post && 'media' === cosmotone_page_sections_type( $post->ID ) ) {
		add_meta_box( 'cosmotone_media_library', __( 'Media Gallery and Videos', 'cosmotone' ), 'cosmotone_render_media_page_metabox', 'page', 'normal', 'default' );
	}
}
add_action( 'add_meta_boxes_page', 'cosmotone_add_media_page_metabox' );

function cosmotone_render_media_page_metabox( $post ) {
	wp_nonce_field( 'cosmotone_save_media_page', 'cosmotone_media_page_nonce' );
	?>
	<p class="description"><?php esc_html_e( 'These settings are also available from Media → Media Page.', 'cosmotone' ); ?></p>
	<?php cosmotone_render_media_management_fields( $post->ID ); ?>
	<?php
}

function cosmotone_render_job_metabox( $post ) {
	wp_nonce_field( 'cosmotone_save_resource_details', 'cosmotone_resource_details_nonce' );
	$department   = get_post_meta( $post->ID, '_cosmotone_job_department', true );
	$requirements = get_post_meta( $post->ID, '_cosmotone_job_requirements', true );
	$button_text  = get_post_meta( $post->ID, '_cosmotone_job_button_text', true );
	$apply_url    = get_post_meta( $post->ID, '_cosmotone_job_apply_url', true );
	?>
	<p><label for="cosmotone-job-department"><strong><?php esc_html_e( 'Department', 'cosmotone' ); ?></strong></label><br>
	<input class="widefat" id="cosmotone-job-department" name="cosmotone_job_department" type="text" value="<?php echo esc_attr( $department ); ?>"></p>
	<p><label for="cosmotone-job-requirements"><strong><?php esc_html_e( 'Requirements (one per line)', 'cosmotone' ); ?></strong></label><br>
	<textarea class="widefat" id="cosmotone-job-requirements" name="cosmotone_job_requirements" rows="5"><?php echo esc_textarea( $requirements ); ?></textarea></p>
	<p><label for="cosmotone-job-button"><strong><?php esc_html_e( 'Application Button Text', 'cosmotone' ); ?></strong></label><br>
	<input class="widefat" id="cosmotone-job-button" name="cosmotone_job_button_text" type="text" value="<?php echo esc_attr( $button_text ? $button_text : 'APPLY NOW' ); ?>"></p>
	<p><label for="cosmotone-job-url"><strong><?php esc_html_e( 'Application URL', 'cosmotone' ); ?></strong></label><br>
	<input class="widefat" id="cosmotone-job-url" name="cosmotone_job_apply_url" type="url" value="<?php echo esc_url( $apply_url ? $apply_url : home_url( '/contact/' ) ); ?>"></p>
	<p class="description"><?php esc_html_e( 'Use the main editor above for the job description. Use Order in Page Attributes to control card order.', 'cosmotone' ); ?></p>
	<?php
}

function cosmotone_render_download_metabox( $post ) {
	wp_nonce_field( 'cosmotone_save_resource_details', 'cosmotone_resource_details_nonce' );
	$file_url    = get_post_meta( $post->ID, '_cosmotone_download_file_url', true );
	$button_text = get_post_meta( $post->ID, '_cosmotone_download_button_text', true );
	?>
	<p><label for="cosmotone-download-url"><strong><?php esc_html_e( 'File or Page URL', 'cosmotone' ); ?></strong></label></p>
	<p class="cosmotone-download-file-row">
		<input class="widefat" id="cosmotone-download-url" name="cosmotone_download_file_url" type="text" value="<?php echo esc_attr( $file_url ); ?>">
		<button type="button" class="button cosmotone-select-download-file"><?php esc_html_e( 'Choose File', 'cosmotone' ); ?></button>
	</p>
	<p><label for="cosmotone-download-button"><strong><?php esc_html_e( 'Link Text', 'cosmotone' ); ?></strong></label><br>
	<input class="widefat" id="cosmotone-download-button" name="cosmotone_download_button_text" type="text" value="<?php echo esc_attr( $button_text ? $button_text : 'Download document' ); ?>"></p>
	<p class="description"><?php esc_html_e( 'Use the main editor above for the download description. Use Order in Page Attributes to control card order.', 'cosmotone' ); ?></p>
	<?php
}

function cosmotone_save_resource_details( $post_id ) {
	if ( ! isset( $_POST['cosmotone_resource_details_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cosmotone_resource_details_nonce'] ) ), 'cosmotone_save_resource_details' ) || wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$post_type = get_post_type( $post_id );
	if ( 'cosmotone_job' === $post_type ) {
		update_post_meta( $post_id, '_cosmotone_job_department', isset( $_POST['cosmotone_job_department'] ) ? sanitize_text_field( wp_unslash( $_POST['cosmotone_job_department'] ) ) : '' );
		update_post_meta( $post_id, '_cosmotone_job_requirements', isset( $_POST['cosmotone_job_requirements'] ) ? sanitize_textarea_field( wp_unslash( $_POST['cosmotone_job_requirements'] ) ) : '' );
		update_post_meta( $post_id, '_cosmotone_job_button_text', isset( $_POST['cosmotone_job_button_text'] ) ? sanitize_text_field( wp_unslash( $_POST['cosmotone_job_button_text'] ) ) : '' );
		update_post_meta( $post_id, '_cosmotone_job_apply_url', isset( $_POST['cosmotone_job_apply_url'] ) ? esc_url_raw( wp_unslash( $_POST['cosmotone_job_apply_url'] ) ) : '' );
	} elseif ( 'cosmotone_download' === $post_type ) {
		update_post_meta( $post_id, '_cosmotone_download_file_url', isset( $_POST['cosmotone_download_file_url'] ) ? cosmotone_sanitize_page_section_link_url( wp_unslash( $_POST['cosmotone_download_file_url'] ) ) : '' );
		update_post_meta( $post_id, '_cosmotone_download_button_text', isset( $_POST['cosmotone_download_button_text'] ) ? sanitize_text_field( wp_unslash( $_POST['cosmotone_download_button_text'] ) ) : '' );
	}
}
add_action( 'save_post_cosmotone_job', 'cosmotone_save_resource_details' );
add_action( 'save_post_cosmotone_download', 'cosmotone_save_resource_details' );

function cosmotone_save_media_page( $post_id ) {
	if ( ! isset( $_POST['cosmotone_media_page_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cosmotone_media_page_nonce'] ) ), 'cosmotone_save_media_page' ) || wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_page', $post_id ) || 'media' !== cosmotone_page_sections_type( $post_id ) ) {
		return;
	}
	$ids = isset( $_POST['cosmotone_media_gallery_ids'] ) ? array_filter( array_map( 'absint', explode( ',', sanitize_text_field( wp_unslash( $_POST['cosmotone_media_gallery_ids'] ) ) ) ) ) : array();
	$videos = isset( $_POST['cosmotone_media_video_urls'] ) ? cosmotone_sanitize_media_video_urls( wp_unslash( $_POST['cosmotone_media_video_urls'] ) ) : '';
	update_post_meta( $post_id, '_cosmotone_media_gallery_ids', implode( ',', $ids ) );
	update_post_meta( $post_id, '_cosmotone_media_video_urls', $videos );
	update_post_meta( $post_id, '_cosmotone_media_auto_images', 0 );
	update_post_meta( $post_id, '_cosmotone_media_configured', 1 );
}
add_action( 'save_post_page', 'cosmotone_save_media_page', 30 );

function cosmotone_resource_admin_assets( $hook ) {
	if ( 'media_page_cosmotone-media-page' === $hook ) {
		wp_enqueue_media();
		return;
	}
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( $screen && in_array( $screen->post_type, array( 'cosmotone_download', 'page' ), true ) ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'cosmotone_resource_admin_assets' );

function cosmotone_resource_admin_footer() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	$post_id  = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$is_media = $screen && 'page' === $screen->post_type && $post_id && 'media' === cosmotone_page_sections_type( $post_id );
	if ( ! $screen || ( 'cosmotone_download' !== $screen->post_type && ! $is_media ) ) {
		return;
	}
	if ( 'cosmotone_download' === $screen->post_type ) :
	?>
	<script>
	(function(){
		var button=document.querySelector('.cosmotone-select-download-file');
		if(!button||typeof wp==='undefined'||!wp.media)return;
		button.addEventListener('click',function(event){
			event.preventDefault();
			var frame=wp.media({title:'Choose download file',button:{text:'Use this file'},multiple:false});
			frame.on('select',function(){
				var file=frame.state().get('selection').first().toJSON();
				document.getElementById('cosmotone-download-url').value=file.url||'';
			});
			frame.open();
		});
	})();
	</script>
	<?php
	endif;
	if ( $is_media ) :
	?>
	<script>
	(function(){
		var select=document.getElementById('cosmotone-media-gallery-select');
		var clear=document.getElementById('cosmotone-media-gallery-clear');
		var input=document.getElementById('cosmotone-media-gallery-ids');
		var preview=document.getElementById('cosmotone-media-gallery-preview');
		if(!select||typeof wp==='undefined'||!wp.media)return;
		select.addEventListener('click',function(event){
			event.preventDefault();
			var frame=wp.media({title:'Choose gallery images',button:{text:'Use these images'},multiple:true,library:{type:'image'}});
			frame.on('select',function(){
				var ids=[],html='';
				frame.state().get('selection').each(function(item){
					var image=item.toJSON(),thumb=image.sizes&&image.sizes.thumbnail?image.sizes.thumbnail.url:image.url;
					ids.push(image.id);html+='<img src="'+thumb+'" alt="" style="width:90px;height:70px;object-fit:cover;border:1px solid #dcdcde">';
				});
				input.value=ids.join(',');preview.innerHTML=html;
			});
			frame.open();
		});
		clear.addEventListener('click',function(event){event.preventDefault();input.value='';preview.innerHTML='';});
	})();
	</script>
	<?php
	endif;
}
add_action( 'admin_footer-post.php', 'cosmotone_resource_admin_footer' );
add_action( 'admin_footer-post-new.php', 'cosmotone_resource_admin_footer' );

function cosmotone_get_jobs() {
	return new WP_Query(
		array(
			'post_type'      => 'cosmotone_job',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
			'order'          => 'ASC',
		)
	);
}

function cosmotone_get_downloads() {
	return new WP_Query(
		array(
			'post_type'      => 'cosmotone_download',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
			'order'          => 'ASC',
		)
	);
}

function cosmotone_seed_resource_content() {
	if ( get_option( 'cosmotone_resource_content_version' ) ) {
		return;
	}

	if ( ! get_posts( array( 'post_type' => 'cosmotone_job', 'post_status' => 'any', 'posts_per_page' => 1 ) ) ) {
		$jobs = array(
			array( 'Engineering', 'Electrical Design Engineer', 'Develop wiring harnesses, electrical systems, drawings, specifications, and validation documentation for automotive applications.', "Full-time position\nEngineering experience preferred" ),
			array( 'Production', 'Quality Control Engineer', 'Maintain product quality through incoming, in-process, and final inspections while supporting continuous improvement initiatives.', "Full-time position\nQuality systems knowledge preferred" ),
			array( 'Operations', 'Production Supervisor', 'Coordinate production teams, daily targets, materials, safety requirements, and manufacturing process compliance.', "Full-time position\nManufacturing experience preferred" ),
			array( 'Business Development', 'Sales Executive', 'Develop customer relationships, identify new opportunities, prepare proposals, and support long-term account growth.', "Full-time position\nB2B sales experience preferred" ),
		);
		foreach ( $jobs as $order => $job ) {
			$post_id = wp_insert_post( array( 'post_type' => 'cosmotone_job', 'post_status' => 'publish', 'post_title' => $job[1], 'post_content' => $job[2], 'menu_order' => $order ) );
			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, '_cosmotone_job_department', $job[0] );
				update_post_meta( $post_id, '_cosmotone_job_requirements', $job[3] );
				update_post_meta( $post_id, '_cosmotone_job_button_text', 'APPLY NOW' );
				update_post_meta( $post_id, '_cosmotone_job_apply_url', home_url( '/contact/' ) );
			}
		}
	}

	if ( ! get_posts( array( 'post_type' => 'cosmotone_download', 'post_status' => 'any', 'posts_per_page' => 1 ) ) ) {
		$downloads = array(
			array( 'Company Profile', 'An introduction to Cosmotone, our capabilities, facilities, and commitment to quality.' ),
			array( 'Product Catalogue', 'Explore our automotive electrical products, relays, accessories, sensors, and connectors.' ),
			array( 'Quality Policy', 'Review our approach to consistent quality, process control, safety, and continuous improvement.' ),
		);
		foreach ( $downloads as $order => $download ) {
			$post_id = wp_insert_post( array( 'post_type' => 'cosmotone_download', 'post_status' => 'publish', 'post_title' => $download[0], 'post_content' => $download[1], 'menu_order' => $order ) );
			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, '_cosmotone_download_file_url', home_url( '/contact/' ) );
				update_post_meta( $post_id, '_cosmotone_download_button_text', 'Request document' );
			}
		}
	}

	update_option( 'cosmotone_resource_content_version', '1.0.0' );
}
add_action( 'init', 'cosmotone_seed_resource_content', 25 );
