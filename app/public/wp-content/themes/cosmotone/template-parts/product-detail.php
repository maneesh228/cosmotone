<?php
/**
 * Shared Product detail layout.
 *
 * Expects $cosmotone_product_id.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

$product = get_post( isset( $cosmotone_product_id ) ? absint( $cosmotone_product_id ) : 0 );
if ( ! $product || 'cosmotone_product' !== $product->post_type ) {
	echo '<main><div class="container pt-120 pb-120"><p>Product not found.</p></div></main>';
	return;
}

$product_id    = $product->ID;
$product_title = get_the_title( $product_id );
$product_image = cosmotone_catalog_image_url( $product_id, 'full' );
$product_code  = cosmotone_product_code( $product_id );
$category_path = cosmotone_product_category_path( $product_id );
$deepest_term  = $category_path ? end( $category_path ) : false;
$description   = trim( $product->post_content );

// Products page filter parameter for each category depth (top level, sub, child).
$filter_params = array( 'product_category', 'product_subcategory', 'product_child_category' );
$category_rows = array( __( 'Category', 'cosmotone' ), __( 'Subcategory', 'cosmotone' ), __( 'Child Category', 'cosmotone' ) );
$category_link = static function ( $depth ) use ( $category_path, $filter_params ) {
	$args = array();
	foreach ( array_slice( $category_path, 0, $depth + 1 ) as $index => $term ) {
		$args[ $filter_params[ $index ] ] = $term->term_id;
	}
	return add_query_arg( $args, home_url( '/products/' ) );
};

$enquiry_text = sprintf( 'Hello Cosmotone, I would like to enquire about %s%s.', $product_title, $product_code ? ' (' . $product_code . ')' : '' );

$related_args = array(
	'post_type'      => 'cosmotone_product',
	'post_status'    => 'publish',
	'posts_per_page' => 3,
	'post__not_in'   => array( $product_id ),
	'orderby'        => array(
		'menu_order' => 'ASC',
		'date'       => 'DESC',
	),
);
if ( $deepest_term ) {
	$related_args['tax_query'] = array(
		array(
			'taxonomy' => 'cosmotone_product_category',
			'field'    => 'term_id',
			'terms'    => array( $deepest_term->term_id ),
		),
	);
}
$related = new WP_Query( $related_args );

if ( ! $related->have_posts() && $deepest_term ) {
	unset( $related_args['tax_query'] );
	$related = new WP_Query( $related_args );
}
?>
<main>
	<!-- breadcrumb area start -->
	<div class="breadcrumb__area breadcrumb__overlay breadcrumb__height p-relative fix" data-background="assets/img/breadcurmb/breadcurmb.jpg">
		<div class="container">
			<div class="row">
				<div class="col-xxl-12">
					<div class="breadcrumb__content z-index d-flex justify-content-between align-items-end">
						<div class="breadcrumb__section-title-box">
							<h4 class="breadcrumb__subtitle">COSMOTONE PRODUCT</h4>
							<h3 class="breadcrumb__title"><?php echo esc_html( $product_title ); ?></h3>
						</div>
						<div class="breadcrumb__list">
							<span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
							<span class="dvdr"><i>/</i></span>
							<span><a href="<?php echo esc_url( home_url( '/products/' ) ); ?>">Products</a></span>
							<span class="dvdr"><i>/</i></span>
							<span><?php echo esc_html( $product_title ); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- breadcrumb area end -->

	<section class="cosmotone-product-detail pt-110 pb-80">
		<div class="container">
			<div class="row g-4 g-lg-5 align-items-start">
				<div class="col-lg-6">
					<div class="cosmotone-product-detail__media">
						<img src="<?php echo esc_url( $product_image ); ?>" alt="<?php echo esc_attr( $product_title ); ?>">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="cosmotone-product-detail__info">
						<?php if ( $category_path ) : ?>
							<span class="cosmotone-product-detail__eyebrow"><?php echo esc_html( implode( ' / ', wp_list_pluck( $category_path, 'name' ) ) ); ?></span>
						<?php endif; ?>
						<h1 class="cosmotone-product-detail__title"><?php echo esc_html( $product_title ); ?></h1>

						<table class="cosmotone-product-detail__specs">
							<tbody>
								<?php if ( $product_code ) : ?>
									<tr><th scope="row"><?php esc_html_e( 'Product Code', 'cosmotone' ); ?></th><td><?php echo esc_html( $product_code ); ?></td></tr>
								<?php endif; ?>
								<?php foreach ( $category_path as $depth => $term ) : if ( ! isset( $category_rows[ $depth ] ) ) break; ?>
									<tr><th scope="row"><?php echo esc_html( $category_rows[ $depth ] ); ?></th><td><a href="<?php echo esc_url( $category_link( $depth ) ); ?>"><?php echo esc_html( $term->name ); ?></a></td></tr>
								<?php endforeach; ?>
							</tbody>
						</table>

						<?php if ( '' !== $description ) : ?>
							<div class="cosmotone-product-detail__description cosmotone-product-description">
								<h2><?php esc_html_e( 'Description', 'cosmotone' ); ?></h2>
								<?php echo apply_filters( 'the_content', $product->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						<?php endif; ?>

						<div class="cosmotone-product-detail__actions">
							<a class="tp-btn" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><span><?php esc_html_e( 'Enquire Now', 'cosmotone' ); ?></span></a>
							<a class="cosmotone-product-detail__whatsapp" href="<?php echo esc_url( 'https://wa.me/919554481761?text=' . rawurlencode( $enquiry_text ) ); ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i><?php esc_html_e( 'Chat on WhatsApp', 'cosmotone' ); ?></a>
						</div>

						<?php if ( $category_path ) : ?>
							<div class="cosmotone-product-detail__tags tagcloud">
								<?php foreach ( $category_path as $depth => $term ) : if ( ! isset( $filter_params[ $depth ] ) ) break; ?>
									<a href="<?php echo esc_url( $category_link( $depth ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php if ( $related->have_posts() ) : ?>
		<div class="tp-project-area pb-90">
			<div class="container">
				<div class="row">
					<div class="col-xl-12">
						<div class="tp-project-section-box text-center mb-50">
							<?php if ( $deepest_term ) : ?>
								<span class="tp-section-subtitle"><?php echo esc_html( $deepest_term->name ); ?></span>
							<?php endif; ?>
							<h4 class="tp-section-title"><?php esc_html_e( 'Related products', 'cosmotone' ); ?></h4>
						</div>
					</div>
				</div>
				<div class="row">
					<?php while ( $related->have_posts() ) : $related->the_post(); $related_id = get_the_ID(); $related_code = cosmotone_product_code( $related_id ); $related_path = cosmotone_product_category_path( $related_id ); ?>
						<div class="col-xl-4 col-lg-4 col-md-6 mb-30 cosmotone-product-card">
							<div class="tp-project-item p-relative">
								<div class="tp-project-thumb"><a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( cosmotone_catalog_image_url( $related_id, 'large' ) ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" decoding="async"></a></div>
								<div class="tp-project-content">
									<span><?php echo esc_html( $related_path ? implode( ' / ', wp_list_pluck( $related_path, 'name' ) ) : 'Uncategorized' ); ?></span>
									<h4 class="tp-project-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
									<?php if ( $related_code ) : ?>
										<div class="cosmotone-product-code"><?php esc_html_e( 'Product Code:', 'cosmotone' ); ?> <strong><?php echo esc_html( $related_code ); ?></strong></div>
									<?php endif; ?>
									<a class="cosmotone-listing-read-more" href="<?php the_permalink(); ?>">
										<span><?php esc_html_e( 'Read More', 'cosmotone' ); ?></span>
										<i class="flaticon-right-arrow" aria-hidden="true"></i>
									</a>
								</div>
							</div>
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/cta' ); ?>
</main>
