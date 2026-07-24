<?php
/**
 * Editable Media gallery page.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

get_header();

$page_id      = get_queried_object_id();
$media_images = array();
$gallery_ids  = array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $page_id, '_cosmotone_media_gallery_ids', true ) ) ) );
$media_videos = preg_split( '/\R/u', (string) get_post_meta( $page_id, '_cosmotone_media_video_urls', true ), -1, PREG_SPLIT_NO_EMPTY );
$flagged_images = get_posts(
	array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'post_mime_type' => 'image',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'fields'         => 'ids',
		'meta_key'       => '_cosmotone_show_in_gallery',
		'meta_value'     => '1',
	)
);
$gallery_ids = array_values( array_unique( array_merge( $gallery_ids, array_map( 'absint', $flagged_images ) ) ) );

$flagged_videos = get_posts(
	array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'post_mime_type' => 'video',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'fields'         => 'ids',
		'meta_key'       => '_cosmotone_show_in_gallery',
		'meta_value'     => '1',
	)
);
foreach ( $flagged_videos as $video_id ) {
	$video_url = wp_get_attachment_url( $video_id );
	if ( $video_url ) {
		$media_videos[] = $video_url;
	}
}
$media_videos = array_values( array_unique( array_map( 'trim', $media_videos ) ) );

if ( $gallery_ids ) {
	foreach ( $gallery_ids as $image_id ) {
		$image_url = wp_get_attachment_image_url( $image_id, 'large' );
		if ( ! $image_url ) {
			continue;
		}
		$title          = get_the_title( $image_id );
		$alt            = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		$media_images[] = array( $image_url, $title ? $title : __( 'Gallery image', 'cosmotone' ), $alt ? $alt : $title );
	}
}

ob_start();
?>
<main>
	<!-- breadcrumb area start -->
	<section class="breadcrumb__area breadcrumb__overlay breadcrumb__height p-relative fix" data-background="assets/img/breadcurmb/breadcurmb.jpg">
		<div class="container"><div class="row"><div class="col-12"><div class="breadcrumb__content z-index d-flex justify-content-between align-items-end">
			<div class="breadcrumb__section-title-box"><h4 class="breadcrumb__subtitle">OUR GALLERY</h4><h1 class="breadcrumb__title">Media</h1></div>
			<div class="breadcrumb__list"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span><span class="dvdr"><i>/</i></span><span>Media</span></div>
		</div></div></div></div>
	</section>
	<!-- breadcrumb area end -->

	<!-- media area start -->
	<section class="cosmotone-resource-section">
		<div class="container">
			<div class="tp-team-section-box text-center mb-60"><span class="tp-section-subtitle"><i class="flaticon-flash"></i> OUR GALLERY</span><h2 class="tp-section-title">Inside Cosmotone</h2><p>Explore our products, facilities, people, and engineering work.</p></div>
			<div class="cosmotone-media-filter" role="group" aria-label="<?php esc_attr_e( 'Filter media', 'cosmotone' ); ?>"><button class="active" type="button" data-media-filter="all">All</button><button type="button" data-media-filter="images">Images</button><button type="button" data-media-filter="videos">Videos</button></div>

			<div class="row g-4 cosmotone-media-group" data-media-group="images">
				<?php if ( $media_images ) : ?>
					<?php foreach ( $media_images as $image ) : ?>
						<div class="col-lg-4 col-md-6"><article class="cosmotone-media-card"><a class="popup-image" href="<?php echo esc_url( $image[0] ); ?>"><img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php echo esc_attr( $image[2] ); ?>"></a><h3><?php echo esc_html( $image[1] ); ?></h3></article></div>
					<?php endforeach; ?>
				<?php else : ?>
					<div class="col-12 text-center"><p><?php esc_html_e( 'No gallery images have been added yet.', 'cosmotone' ); ?></p></div>
				<?php endif; ?>
			</div>

			<div class="row g-4 cosmotone-media-group" data-media-group="videos">
				<?php if ( $media_videos ) : ?>
					<?php foreach ( $media_videos as $video_url ) :
						$video_url = trim( $video_url );
						if ( ! $video_url ) {
							continue;
						}
						$embed_url = function_exists( 'cosmotone_media_embed_url' ) ? cosmotone_media_embed_url( $video_url ) : '';
						?>
						<div class="col-lg-6"><div class="cosmotone-media-video">
							<?php if ( preg_match( '/\.mp4(?:\?.*)?$/i', $video_url ) || ! wp_http_validate_url( $video_url ) ) : ?>
								<video controls preload="metadata" poster="assets/img/hero/banner2.jpg"><source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4"></video>
							<?php elseif ( $embed_url ) : ?>
								<iframe src="<?php echo esc_url( $embed_url ); ?>" title="<?php esc_attr_e( 'Media video', 'cosmotone' ); ?>" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
							<?php else :
								$embed = wp_oembed_get( $video_url, array( 'width' => 900 ) );
								echo $embed ? wp_kses_post( $embed ) : '<p><a href="' . esc_url( $video_url ) . '">' . esc_html__( 'Watch video', 'cosmotone' ) . '</a></p>';
							endif; ?>
						</div></div>
					<?php endforeach; ?>
				<?php else : ?>
					<div class="col-12 text-center"><p><?php esc_html_e( 'No videos have been added yet.', 'cosmotone' ); ?></p></div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<!-- media area end -->
</main>
<script>
document.addEventListener('DOMContentLoaded', function () {
	var buttons = document.querySelectorAll('[data-media-filter]');
	var groups = document.querySelectorAll('[data-media-group]');
	buttons.forEach(function (button) {
		button.addEventListener('click', function () {
			var filter = button.getAttribute('data-media-filter');
			buttons.forEach(function (item) { item.classList.remove('active'); });
			button.classList.add('active');
			groups.forEach(function (group) { group.hidden = filter !== 'all' && group.getAttribute('data-media-group') !== filter; });
		});
	});
});
</script>
<?php
$markup = ob_get_clean();
echo cosmotone_apply_page_section_fields( $markup, $page_id, 'media' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
get_footer();
