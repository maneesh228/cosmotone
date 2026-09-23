<?php
/** FAQ content management. @package Cosmotone */
defined( 'ABSPATH' ) || exit;

function cosmotone_register_faq_post_type() {
	register_post_type( 'cosmotone_faq', array(
		'labels' => array(
			'name' => __( 'FAQs', 'cosmotone' ),
			'singular_name' => __( 'FAQ', 'cosmotone' ),
			'add_new_item' => __( 'Add New FAQ', 'cosmotone' ),
			'edit_item' => __( 'Edit FAQ', 'cosmotone' ),
			'all_items' => __( 'All FAQs', 'cosmotone' ),
			'search_items' => __( 'Search FAQs', 'cosmotone' ),
			'not_found' => __( 'No FAQs found.', 'cosmotone' ),
		),
		'public' => false,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => false,
		'rewrite' => false,
		'menu_icon' => 'dashicons-editor-help',
		'supports' => array( 'title', 'editor', 'page-attributes', 'revisions' ),
		'capability_type' => 'post',
		'map_meta_cap' => true,
	) );
}
add_action( 'init', 'cosmotone_register_faq_post_type', 5 );

function cosmotone_faq_title_placeholder( $title, $post ) {
	return 'cosmotone_faq' === $post->post_type ? __( 'Enter the question', 'cosmotone' ) : $title;
}
add_filter( 'enter_title_here', 'cosmotone_faq_title_placeholder', 10, 2 );

function cosmotone_faq_admin_help() {
	$screen = get_current_screen();
	if ( ! $screen || 'cosmotone_faq' !== $screen->post_type ) return;
	?>
	<div class="notice notice-info"><p><?php esc_html_e( 'Use the title for the question and the editor for the answer. Publish to display it on the FAQ page. Set Order under Attributes to arrange questions (lower numbers appear first). Draft and private FAQs are hidden from visitors.', 'cosmotone' ); ?>
	<a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'View FAQ page', 'cosmotone' ); ?></a></p></div>
	<?php
}
add_action( 'admin_notices', 'cosmotone_faq_admin_help' );

function cosmotone_get_faqs() {
	return new WP_Query( array(
		'post_type' => 'cosmotone_faq',
		'post_status' => 'publish',
		'has_password' => false,
		'posts_per_page' => -1,
		'orderby' => array( 'menu_order' => 'ASC', 'ID' => 'ASC' ),
		'no_found_rows' => true,
	) );
}
