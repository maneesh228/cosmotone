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
$category_text = $category_path ? implode( ' / ', wp_list_pluck( $category_path, 'name' ) ) : 'Uncategorized';
$deepest_term  = $category_path ? end( $category_path ) : false;

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
	<div class="breadcrumb__area breadcrumb__overlay breadcrumb__height p-relative fix" data-background="<?php echo esc_url( $product_image ); ?>">
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

	<div class="tp-porfolio-details-area project-details-customize pt-110 pb-105">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<div class="evn-text-box mb-35">
						<h1 class="tp-inner-title pb-10"><?php echo esc_html( $product_title ); ?></h1>
					</div>
					<div class="evn-thumb-wrap mb-40 p-relative">
						<div class="evn-avata-content-wrap z-index">
							<div class="evn-related-info d-flex justify-content-lg-start align-items-center">
								<?php if ( $product_code ) : ?>
									<span><b>Product Code:</b><br><?php echo esc_html( $product_code ); ?></span>
								<?php endif; ?>
								<?php if ( isset( $category_path[0] ) ) : ?>
									<span><b>Category:</b><br><?php echo esc_html( $category_path[0]->name ); ?></span>
								<?php endif; ?>
								<?php if ( isset( $category_path[1] ) ) : ?>
									<span><b>Subcategory:</b><br><?php echo esc_html( $category_path[1]->name ); ?></span>
								<?php endif; ?>
								<?php if ( isset( $category_path[2] ) ) : ?>
									<span><b>Child Category:</b><br><?php echo esc_html( $category_path[2]->name ); ?></span>
								<?php endif; ?>
							</div>
						</div>
						<div class="evn-thumb">
							<img class="w-100" src="<?php echo esc_url( $product_image ); ?>" alt="<?php echo esc_attr( $product_title ); ?>">
						</div>
					</div>
					<div class="evn-text-box cosmotone-product-description mb-45">
						<?php echo apply_filters( 'the_content', $product->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<div class="postbox__details-tag tagcloud mb-45">
						<?php foreach ( $category_path as $term ) : ?>
							<a href="<?php echo esc_url( add_query_arg( 'category', $term->term_id, home_url( '/products/' ) ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if ( $related->have_posts() ) : ?>
		<div class="tp-project-area pb-90">
			<div class="container">
				<div class="row">
					<div class="col-xl-12">
						<div class="tp-project-section-box text-center mb-60">
							<span class="tp-section-subtitle"><?php echo esc_html( $category_text ); ?></span>
							<h4 class="tp-section-title">Related products</h4>
						</div>
					</div>
				</div>
				<div class="row">
					<?php while ( $related->have_posts() ) : $related->the_post(); $related_id = get_the_ID(); $related_code = cosmotone_product_code( $related_id ); ?>
						<div class="col-xl-4 col-lg-4 col-md-6 mb-30">
							<div class="tp-project-item p-relative">
								<div class="tp-project-thumb">
									<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( cosmotone_catalog_image_url( $related_id, 'large' ) ); ?>" alt="<?php the_title_attribute(); ?>"></a>
								</div>
								<div class="tp-project-content">
									<a href="<?php the_permalink(); ?>"><i class="flaticon-right-arrow"></i></a>
									<span><?php echo esc_html( implode( ' / ', wp_list_pluck( cosmotone_product_category_path( $related_id ), 'name' ) ) ); ?></span>
									<h4 class="tp-project-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
									<?php if ( $related_code ) : ?>
										<div class="cosmotone-product-code"><?php esc_html_e( 'Product Code:', 'cosmotone' ); ?> <strong><?php echo esc_html( $related_code ); ?></strong></div>
									<?php endif; ?>
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
<style>
.cosmotone-product-code{margin-top:8px;color:#5b6678;font-size:14px;line-height:1.4}.cosmotone-product-code strong{color:#102444;font-weight:700}
</style>
