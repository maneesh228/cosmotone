<?php
/**
 * Backward-compatible News Details page.
 *
 * Individual news cards now use standard WordPress post permalinks. This page
 * displays the newest post so the existing /news-details/ URL remains useful.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

get_header();

$requested_post = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$news_detail    = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 1,
		'p'                   => $requested_post,
		'ignore_sticky_posts' => true,
	)
);

if ( $news_detail->have_posts() ) {
	$news_detail->the_post();
	ob_start();
	get_template_part( 'template-parts/news-detail' );
	$markup = ob_get_clean();
	echo cosmotone_apply_page_section_fields( $markup, get_queried_object_id(), 'news-details' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	wp_reset_postdata();
} else {
	?>
	<main><section class="postbox__area pt-120 pb-120"><div class="container"><p><?php esc_html_e( 'No news has been published yet.', 'cosmotone' ); ?></p></div></section></main>
	<?php
}

get_footer();
