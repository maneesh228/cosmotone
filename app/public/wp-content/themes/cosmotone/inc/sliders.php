<?php
/**
 * Homepage slider management.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

/** Default homepage slides, matching the original design. */
function cosmotone_home_slider_defaults() {
	return array(
		array(
			'enabled' => 1, 'media_type' => 'video',
			'media_url' => 'assets/video/automotive-wiring-harness.mp4',
			'poster_url' => 'assets/img/hero/cosmotone-blue-hero.png',
			'title' => 'Strengthening the <br>automotive industry with <br>world-class <span>electrical solutions</span>',
			'description' => 'Trusted by automotive OEMs across the globe, we deliver high-quality electrical components built for performance and reliability.',
			'button_text' => 'Discover More', 'button_url' => '#',
		),
		array(
			'enabled' => 1, 'media_type' => 'image',
			'media_url' => 'assets/img/hero/banner2.jpg', 'poster_url' => '',
			'title' => 'Reliable components <br>engineered to <br><span>perform</span>',
			'description' => 'Expert & Experienced Electricians for Residential to Commercial services with 100% satisfaction guarantee.',
			'button_text' => 'Discover More', 'button_url' => '#',
		),
		array(
			'enabled' => 1, 'media_type' => 'image',
			'media_url' => 'assets/img/hero/cosmotone-blue-hero.png', 'poster_url' => '',
			'title' => 'Powering mobility <br>through trusted <br><span>innovation</span>',
			'description' => 'Expert & Experienced Electricians for Residential to Commercial services with 100% satisfaction guarantee.',
			'button_text' => 'Discover More', 'button_url' => '#',
		),
	);
}

/** Register the dedicated Sliders menu in wp-admin. */
function cosmotone_register_slider_post_type() {
	register_post_type(
		'cosmotone_slider',
		array(
			'labels' => array(
				'name' => __( 'Sliders', 'cosmotone' ),
				'singular_name' => __( 'Slider', 'cosmotone' ),
				'add_new' => __( 'Add New Slider', 'cosmotone' ),
				'add_new_item' => __( 'Add New Slider', 'cosmotone' ),
				'edit_item' => __( 'Edit Slider', 'cosmotone' ),
				'new_item' => __( 'New Slider', 'cosmotone' ),
				'view_items' => __( 'View Sliders', 'cosmotone' ),
				'search_items' => __( 'Search Sliders', 'cosmotone' ),
				'not_found' => __( 'No sliders found.', 'cosmotone' ),
				'all_items' => __( 'All Sliders', 'cosmotone' ),
				'menu_name' => __( 'Sliders', 'cosmotone' ),
			),
			'public' => false,
			'publicly_queryable' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_rest' => false,
			'menu_icon' => 'dashicons-slides',
			'menu_position' => 22,
			'supports' => array( 'page-attributes' ),
			'capability_type' => 'post',
			'map_meta_cap' => true,
		)
	);
}
add_action( 'init', 'cosmotone_register_slider_post_type', 5 );

/** Resolve relative theme media paths and absolute Media Library URLs. */
function cosmotone_home_slider_url( $url ) {
	if ( ! $url ) return '';
	// Repair theme-relative paths that an earlier esc_url_raw() call expanded to http://assets/....
	if ( preg_match( '#^https?://assets/(.+)$#i', $url, $match ) ) {
		$url = 'assets/' . $match[1];
	}
	return preg_match( '#^https?://#i', $url ) ? $url : trailingslashit( get_template_directory_uri() ) . ltrim( $url, '/' );
}

/** Sanitize either a Media Library URL or a theme-relative assets path. */
function cosmotone_sanitize_slider_media_url( $url ) {
	$url = trim( wp_unslash( $url ) );
	if ( preg_match( '#^https?://assets/(.+)$#i', $url, $match ) ) {
		return 'assets/' . sanitize_text_field( $match[1] );
	}
	if ( preg_match( '#^https?://#i', $url ) ) {
		return esc_url_raw( $url );
	}
	return ltrim( sanitize_text_field( $url ), '/' );
}

/** Convert a formatted slider heading into its plain wp-admin title. */
function cosmotone_slider_plain_title( $heading ) {
	$heading = preg_replace( '#<br\s*/?>#i', ' ', (string) $heading );
	$heading = wp_strip_all_tags( $heading );
	return trim( preg_replace( '/\s+/', ' ', $heading ) );
}

/** Convert one slider post to the format used by the frontend renderer. */
function cosmotone_slider_post_data( $post_id ) {
	$slider_title = (string) get_post_meta( $post_id, '_cosmotone_slider_title', true );
	return array(
		'enabled' => '0' !== get_post_meta( $post_id, '_cosmotone_slider_enabled', true ) ? 1 : 0,
		'media_type' => 'video' === get_post_meta( $post_id, '_cosmotone_slider_media_type', true ) ? 'video' : 'image',
		'media_url' => (string) get_post_meta( $post_id, '_cosmotone_slider_media_url', true ),
		'poster_url' => (string) get_post_meta( $post_id, '_cosmotone_slider_poster_url', true ),
		'title' => $slider_title ? $slider_title : get_the_title( $post_id ),
		'description' => (string) get_post_meta( $post_id, '_cosmotone_slider_description', true ),
		'button_text' => (string) get_post_meta( $post_id, '_cosmotone_slider_button_text', true ),
		'button_url' => (string) get_post_meta( $post_id, '_cosmotone_slider_button_url', true ),
	);
}

/** Return slides from the Sliders admin menu. */
function cosmotone_get_home_slider_items( $post_id = 0 ) {
	$posts = get_posts(
		array(
			'post_type' => 'cosmotone_slider',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
			'order' => 'ASC',
		)
	);
	if ( $posts ) {
		return array_map( static function ( $slide ) { return cosmotone_slider_post_data( $slide->ID ); }, $posts );
	}

	// Keep the old Home-page data available until the one-time migration runs.
	if ( ! get_option( 'cosmotone_slider_cpt_migrated' ) ) {
		$post_id = $post_id ? $post_id : (int) get_option( 'page_on_front' );
		$saved   = $post_id ? get_post_meta( $post_id, '_cosmotone_home_slider', true ) : array();
		return is_array( $saved ) && $saved ? $saved : cosmotone_home_slider_defaults();
	}
	return array();
}

/** Migrate the former repeatable Home slider records into individual Slider posts. */
function cosmotone_migrate_home_sliders_to_posts() {
	if ( get_option( 'cosmotone_slider_cpt_migrated' ) ) return;
	$existing = get_posts( array( 'post_type' => 'cosmotone_slider', 'post_status' => 'any', 'posts_per_page' => 1, 'fields' => 'ids' ) );
	if ( ! $existing ) {
		$home_id = (int) get_option( 'page_on_front' );
		$slides  = $home_id ? get_post_meta( $home_id, '_cosmotone_home_slider', true ) : array();
		$slides  = is_array( $slides ) && $slides ? $slides : cosmotone_home_slider_defaults();
		foreach ( array_values( $slides ) as $index => $slide ) {
			$label = trim( wp_strip_all_tags( preg_replace( '#<br\s*/?>#i', ' ', isset( $slide['title'] ) ? $slide['title'] : '' ) ) );
			$post_id = wp_insert_post(
				array(
					'post_type' => 'cosmotone_slider',
					'post_status' => 'publish',
					'post_title' => $label ? wp_trim_words( $label, 8, '' ) : sprintf( __( 'Slide %d', 'cosmotone' ), $index + 1 ),
					'menu_order' => $index,
				)
			);
			if ( is_wp_error( $post_id ) || ! $post_id ) continue;
			update_post_meta( $post_id, '_cosmotone_slider_enabled', ! empty( $slide['enabled'] ) ? '1' : '0' );
			update_post_meta( $post_id, '_cosmotone_slider_media_type', isset( $slide['media_type'] ) && 'video' === $slide['media_type'] ? 'video' : 'image' );
			foreach ( array( 'media_url', 'poster_url', 'title', 'description', 'button_text', 'button_url' ) as $field ) {
				update_post_meta( $post_id, '_cosmotone_slider_' . $field, isset( $slide[ $field ] ) ? $slide[ $field ] : '' );
			}
		}
	}
	update_option( 'cosmotone_slider_cpt_migrated', 1 );
}
add_action( 'init', 'cosmotone_migrate_home_sliders_to_posts', 20 );

/**
 * One-time repair for edits made in the standard WordPress title field before
 * the title and Slider Heading fields were synchronized.
 */
function cosmotone_sync_existing_slider_titles() {
	if ( get_option( 'cosmotone_slider_title_sync_v2' ) ) return;
	$slider_ids = get_posts( array( 'post_type' => 'cosmotone_slider', 'post_status' => 'any', 'posts_per_page' => -1, 'fields' => 'ids' ) );
	foreach ( $slider_ids as $slider_id ) {
		$admin_title = get_the_title( $slider_id );
		$heading     = (string) get_post_meta( $slider_id, '_cosmotone_slider_title', true );
		if ( $admin_title && $heading && $admin_title !== cosmotone_slider_plain_title( $heading ) ) {
			update_post_meta( $slider_id, '_cosmotone_slider_title', esc_html( $admin_title ) );
		}
		$media_url = (string) get_post_meta( $slider_id, '_cosmotone_slider_media_url', true );
		if ( preg_match( '#^https?://assets/#i', $media_url ) ) {
			update_post_meta( $slider_id, '_cosmotone_slider_media_url', cosmotone_sanitize_slider_media_url( $media_url ) );
		}
	}
	update_option( 'cosmotone_slider_title_sync_v2', 1 );
}
add_action( 'init', 'cosmotone_sync_existing_slider_titles', 25 );

/** Restore media lost by the earlier relative-URL sanitizer. */
function cosmotone_repair_empty_slider_media() {
	if ( get_option( 'cosmotone_slider_media_repair_v3' ) ) return;
	$defaults = cosmotone_home_slider_defaults();
	$sliders  = get_posts( array( 'post_type' => 'cosmotone_slider', 'post_status' => 'any', 'posts_per_page' => -1, 'orderby' => array( 'menu_order' => 'ASC', 'date' => 'ASC' ), 'order' => 'ASC' ) );
	foreach ( $sliders as $index => $slider ) {
		$media_url = (string) get_post_meta( $slider->ID, '_cosmotone_slider_media_url', true );
		if ( '' === $media_url && isset( $defaults[ $index ]['media_url'] ) ) {
			update_post_meta( $slider->ID, '_cosmotone_slider_media_url', $defaults[ $index ]['media_url'] );
		}
	}
	update_option( 'cosmotone_slider_media_repair_v3', 1 );
}
add_action( 'init', 'cosmotone_repair_empty_slider_media', 30 );

/** Add Slider Details to each slider Add/Edit screen. */
function cosmotone_add_slider_meta_box() {
	add_meta_box( 'cosmotone_slider_details', __( 'Slider Details', 'cosmotone' ), 'cosmotone_render_slider_meta_box', 'cosmotone_slider', 'normal', 'high' );
}
add_action( 'add_meta_boxes_cosmotone_slider', 'cosmotone_add_slider_meta_box' );

/** Render the individual slider editor. */
function cosmotone_render_slider_meta_box( $post ) {
	wp_nonce_field( 'cosmotone_save_slider', 'cosmotone_slider_nonce' );
	$slide   = cosmotone_slider_post_data( $post->ID );
	$preview = cosmotone_home_slider_url( 'video' === $slide['media_type'] && $slide['poster_url'] ? $slide['poster_url'] : $slide['media_url'] );
	?>
	<div class="cosmotone-slider-editor">
		<p><label><input type="checkbox" name="cosmotone_slider_enabled" value="1" <?php checked( ! empty( $slide['enabled'] ) ); ?>> <strong><?php esc_html_e( 'Show this slide on the Home page', 'cosmotone' ); ?></strong></label></p>
		<div class="cosmotone-slider-editor-grid">
			<label><span><?php esc_html_e( 'Media Type', 'cosmotone' ); ?></span><select name="cosmotone_slider_media_type" id="cosmotone-slider-media-type"><option value="image" <?php selected( $slide['media_type'], 'image' ); ?>><?php esc_html_e( 'Image', 'cosmotone' ); ?></option><option value="video" <?php selected( $slide['media_type'], 'video' ); ?>><?php esc_html_e( 'MP4 Video', 'cosmotone' ); ?></option></select></label>
			<div class="wide"><span class="field-label"><?php esc_html_e( 'Slider Image or MP4', 'cosmotone' ); ?></span><div id="cosmotone-slider-preview"><?php if ( $preview ) : ?><img src="<?php echo esc_url( $preview ); ?>" alt=""><?php endif; ?></div><div class="media-row"><input class="widefat" id="cosmotone-slider-media-url" type="text" name="cosmotone_slider_media_url" value="<?php echo esc_attr( $slide['media_url'] ); ?>"><button type="button" class="button" id="cosmotone-select-slider-media"><?php esc_html_e( 'Select Image or MP4', 'cosmotone' ); ?></button></div></div>
			<div class="wide"><span class="field-label"><?php esc_html_e( 'Video Poster Image', 'cosmotone' ); ?></span><div class="media-row"><input class="widefat" id="cosmotone-slider-poster-url" type="text" name="cosmotone_slider_poster_url" value="<?php echo esc_attr( $slide['poster_url'] ); ?>"><button type="button" class="button" id="cosmotone-select-slider-poster"><?php esc_html_e( 'Select Poster', 'cosmotone' ); ?></button></div><small><?php esc_html_e( 'Optional. Used as the preview/background for MP4 slides.', 'cosmotone' ); ?></small></div>
			<div class="wide cosmotone-slider-editor-field"><span class="field-label"><?php esc_html_e( 'Slider Heading', 'cosmotone' ); ?></span><?php
			wp_editor(
				$slide['title'],
				'cosmotone_slider_title_editor',
				array(
					'textarea_name' => 'cosmotone_slider_title',
					'textarea_rows' => 5,
					'media_buttons' => false,
					'teeny' => false,
					'quicktags' => true,
					'tinymce' => array(
						'forced_root_block' => false,
						'toolbar1' => 'bold,italic,forecolor,removeformat,undo,redo',
						'toolbar2' => '',
					),
				)
			);
			?><small><?php esc_html_e( 'This is the visible slider title. Its plain-text version is also used in the Sliders list.', 'cosmotone' ); ?></small></div>
			<div class="wide cosmotone-slider-editor-field"><span class="field-label"><?php esc_html_e( 'Description', 'cosmotone' ); ?></span><?php
			wp_editor(
				$slide['description'],
				'cosmotone_slider_description_editor',
				array(
					'textarea_name' => 'cosmotone_slider_description',
					'textarea_rows' => 7,
					'media_buttons' => false,
					'teeny' => false,
					'quicktags' => true,
					'tinymce' => array(
						'toolbar1' => 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,forecolor,removeformat,undo,redo',
					),
				)
			);
			?></div>
			<label><span><?php esc_html_e( 'Button Text', 'cosmotone' ); ?></span><input type="text" name="cosmotone_slider_button_text" value="<?php echo esc_attr( $slide['button_text'] ); ?>"></label>
			<label><span><?php esc_html_e( 'Button URL', 'cosmotone' ); ?></span><input type="text" name="cosmotone_slider_button_url" value="<?php echo esc_attr( $slide['button_url'] ); ?>"></label>
		</div>
		<p class="description"><?php esc_html_e( 'Use the Order field in the Attributes box to control slide order (lower numbers appear first).', 'cosmotone' ); ?></p>
	</div>
	<?php
}

/** Load the media picker and Slider editor styling. */
function cosmotone_slider_admin_assets( $hook ) {
	$screen = get_current_screen();
	if ( ! $screen || 'cosmotone_slider' !== $screen->post_type || ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) return;
	wp_enqueue_media();
	wp_add_inline_style( 'common', '.cosmotone-slider-editor-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}.cosmotone-slider-editor-grid label,.cosmotone-slider-editor-grid>div{display:flex;flex-direction:column;gap:6px}.cosmotone-slider-editor-grid label>span,.cosmotone-slider-editor .field-label{font-weight:600}.cosmotone-slider-editor-grid input,.cosmotone-slider-editor-grid textarea,.cosmotone-slider-editor-grid select{width:100%}.cosmotone-slider-editor-grid .wide{grid-column:1/-1}.cosmotone-slider-editor .wp-editor-wrap{display:block;width:100%}.cosmotone-slider-editor .media-row{display:flex;gap:8px}.cosmotone-slider-editor .media-row .button{white-space:nowrap}.cosmotone-slider-editor #cosmotone-slider-preview{display:flex;align-items:center;justify-content:center;min-height:120px;background:#f0f0f1}.cosmotone-slider-editor #cosmotone-slider-preview img,.cosmotone-slider-editor #cosmotone-slider-preview video{max-width:100%;max-height:220px}@media(max-width:782px){.cosmotone-slider-editor-grid{grid-template-columns:1fr}.cosmotone-slider-editor-grid .wide{grid-column:auto}}' );
}
add_action( 'admin_enqueue_scripts', 'cosmotone_slider_admin_assets' );

/** Media Library behavior for the Slider editor. */
function cosmotone_slider_admin_script() {
	$screen = get_current_screen();
	if ( ! $screen || 'cosmotone_slider' !== $screen->post_type ) return;
	?>
	<script>
	(function(){
		var mediaButton=document.getElementById('cosmotone-select-slider-media');
		if(!mediaButton||!window.wp||!wp.media)return;
		mediaButton.addEventListener('click',function(e){e.preventDefault();var frame=wp.media({title:'Select image or MP4',button:{text:'Use this media'},multiple:false});frame.on('select',function(){var file=frame.state().get('selection').first().toJSON(),url=document.getElementById('cosmotone-slider-media-url'),type=document.getElementById('cosmotone-slider-media-type'),preview=document.getElementById('cosmotone-slider-preview');url.value=file.url;type.value=file.type==='video'?'video':'image';preview.innerHTML=file.type==='video'?'<video src="'+file.url+'" muted controls></video>':'<img src="'+file.url+'" alt="">';});frame.open();});
		var posterButton=document.getElementById('cosmotone-select-slider-poster');if(posterButton)posterButton.addEventListener('click',function(e){e.preventDefault();var frame=wp.media({title:'Select video poster',button:{text:'Use this image'},multiple:false,library:{type:'image'}});frame.on('select',function(){document.getElementById('cosmotone-slider-poster-url').value=frame.state().get('selection').first().toJSON().url;});frame.open();});
	})();
	</script>
	<?php
}
add_action( 'admin_footer-post.php', 'cosmotone_slider_admin_script' );
add_action( 'admin_footer-post-new.php', 'cosmotone_slider_admin_script' );

/** Save one Slider post. */
function cosmotone_save_slider_post( $post_id ) {
	static $syncing_title = false;
	if ( $syncing_title ) return;
	if ( ! isset( $_POST['cosmotone_slider_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cosmotone_slider_nonce'] ) ), 'cosmotone_save_slider' ) || wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) return;
	$old_heading    = (string) get_post_meta( $post_id, '_cosmotone_slider_title', true );
	$posted_heading = isset( $_POST['cosmotone_slider_title'] ) ? wp_kses( wp_unslash( $_POST['cosmotone_slider_title'] ), array( 'br' => array(), 'span' => array( 'class' => true, 'style' => true ), 'strong' => array(), 'em' => array(), 'b' => array(), 'i' => array() ) ) : '';
	$admin_title    = isset( $_POST['post_title'] ) ? sanitize_text_field( wp_unslash( $_POST['post_title'] ) ) : get_the_title( $post_id );

	// If only the standard WordPress title changed, use it as the visible heading.
	if ( $posted_heading === $old_heading && $admin_title && $admin_title !== cosmotone_slider_plain_title( $old_heading ) ) {
		$posted_heading = esc_html( $admin_title );
	}
	update_post_meta( $post_id, '_cosmotone_slider_enabled', isset( $_POST['cosmotone_slider_enabled'] ) ? '1' : '0' );
	update_post_meta( $post_id, '_cosmotone_slider_media_type', isset( $_POST['cosmotone_slider_media_type'] ) && 'video' === $_POST['cosmotone_slider_media_type'] ? 'video' : 'image' );
	update_post_meta( $post_id, '_cosmotone_slider_media_url', isset( $_POST['cosmotone_slider_media_url'] ) ? cosmotone_sanitize_slider_media_url( $_POST['cosmotone_slider_media_url'] ) : '' );
	update_post_meta( $post_id, '_cosmotone_slider_poster_url', isset( $_POST['cosmotone_slider_poster_url'] ) ? cosmotone_sanitize_slider_media_url( $_POST['cosmotone_slider_poster_url'] ) : '' );
	update_post_meta( $post_id, '_cosmotone_slider_title', $posted_heading );
	update_post_meta( $post_id, '_cosmotone_slider_description', isset( $_POST['cosmotone_slider_description'] ) ? wp_kses_post( wp_unslash( $_POST['cosmotone_slider_description'] ) ) : '' );
	update_post_meta( $post_id, '_cosmotone_slider_button_text', isset( $_POST['cosmotone_slider_button_text'] ) ? sanitize_text_field( wp_unslash( $_POST['cosmotone_slider_button_text'] ) ) : '' );
	update_post_meta( $post_id, '_cosmotone_slider_button_url', isset( $_POST['cosmotone_slider_button_url'] ) ? esc_url_raw( wp_unslash( $_POST['cosmotone_slider_button_url'] ) ) : '' );

	// If the formatted Slider Heading changed, keep the list-table title in sync.
	$plain_heading = cosmotone_slider_plain_title( $posted_heading );
	if ( $plain_heading && $plain_heading !== get_the_title( $post_id ) ) {
		$syncing_title = true;
		wp_update_post( array( 'ID' => $post_id, 'post_title' => $plain_heading ) );
		$syncing_title = false;
	}
}
add_action( 'save_post_cosmotone_slider', 'cosmotone_save_slider_post' );

/** Render the managed image/MP4 homepage slider. */
function cosmotone_render_managed_home_slider() {
	$slides = array_values( array_filter( cosmotone_get_home_slider_items(), static function ( $slide ) { return ! empty( $slide['enabled'] ) && ! empty( $slide['media_url'] ); } ) );
	if ( ! $slides ) return;
	?>
	<div class="tp-slider-area z-index p-relative">
		<div class="tp-slider-arrow-box"><button class="slider-prev" type="button" aria-label="Previous slide"><i class="fa-regular fa-arrow-left-long"></i></button><button class="slider-next active" type="button" aria-label="Next slide"><i class="fa-regular fa-arrow-right-long"></i></button></div>
		<div class="tp-slider-wrapper"><div class="swiper-container tp-slider-active"><div class="swiper-wrapper">
		<?php foreach ( $slides as $slide ) :
			$type   = isset( $slide['media_type'] ) && 'video' === $slide['media_type'] ? 'video' : 'image';
			$media  = cosmotone_home_slider_url( $slide['media_url'] );
			$poster = cosmotone_home_slider_url( ! empty( $slide['poster_url'] ) ? $slide['poster_url'] : ( 'image' === $type ? $slide['media_url'] : '' ) );
		?>
		<div class="swiper-slide"><div class="tp-slider-height tp-slider-overly">
			<div class="tp-slider-shape-2 d-none d-xl-block"><img src="assets/img/hero/bg-1-2.png" alt=""></div><div class="tp-slider-shape-3 d-none d-md-block"><img src="assets/img/hero/bg-1-3.png" alt=""></div>
			<div class="tp-slider-bg<?php echo 'video' === $type ? ' tp-slider-video-bg' : ''; ?>" data-background="<?php echo esc_url( $poster ? $poster : $media ); ?>"><?php if ( 'video' === $type ) : ?><video muted playsinline preload="metadata"<?php echo $poster ? ' poster="' . esc_url( $poster ) . '"' : ''; ?> aria-hidden="true"><source src="<?php echo esc_url( $media ); ?>" type="video/mp4"></video><?php endif; ?></div>
			<div class="container z-index-5"><div class="row"><div class="col-xl-8 col-lg-8"><div class="tp-slider-content z-index-5"><div class="tp-slider-title-box"><h1 class="tp-slider-title"><?php echo wp_kses( $slide['title'], array( 'br' => array(), 'span' => array( 'class' => true, 'style' => true ), 'strong' => array(), 'em' => array(), 'b' => array(), 'i' => array() ) ); ?></h1></div><div class="tp-slider-text"><?php echo wp_kses_post( wpautop( $slide['description'] ) ); ?><?php if ( ! empty( $slide['button_text'] ) ) : ?><a class="tp-btn" href="<?php echo esc_url( $slide['button_url'] ); ?>"><span><?php echo esc_html( $slide['button_text'] ); ?></span></a><?php endif; ?></div></div></div></div></div>
		</div></div>
		<?php endforeach; ?>
		</div></div></div>
	</div>
	<?php
}
