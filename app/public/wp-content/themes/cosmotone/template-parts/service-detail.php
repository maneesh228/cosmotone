<?php
/**
 * Shared Service detail layout.
 *
 * Expects $cosmotone_service_id.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;
$service = get_post( isset( $cosmotone_service_id ) ? absint( $cosmotone_service_id ) : 0 );
if ( ! $service || 'cosmotone_service' !== $service->post_type ) {
	echo '<main><div class="container pt-120 pb-120"><p>Service not found.</p></div></main>';
	return;
}
$service_id    = $service->ID;
$service_image = cosmotone_catalog_image_url( $service_id, 'full' );
$all_services  = cosmotone_get_services();
$related       = cosmotone_get_services( 3, $service_id );
?>
<main>
	<div class="breadcrumb__area breadcrumb__overlay breadcrumb__height p-relative fix" data-background="<?php echo esc_url( $service_image ); ?>">
		<div class="container">
			<div class="row">
				<div class="col-xxl-12">
					<div class="breadcrumb__content z-index d-flex justify-content-between align-items-end">
						<div class="breadcrumb__section-title-box">
							<h4 class="breadcrumb__subtitle">COSMOTONE SERVICE</h4>
							<h3 class="breadcrumb__title"><?php echo esc_html( get_the_title( $service_id ) ); ?></h3>
						</div>
						<div class="breadcrumb__list">
							<span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
							<span class="dvdr"><i>/</i></span>
							<span><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Services</a></span>
							<span class="dvdr"><i>/</i></span>
							<span><?php echo esc_html( get_the_title( $service_id ) ); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="tp-service-details-area pt-120 pb-120">
		<div class="container">
			<div class="row">
				<div class="col-xl-4 col-lg-4">
					<div class="tp-service-details-left-box">
						<div class="tp-service-details-widget mb-30">
							<div class="tp-service-details-category">
								<h4 class="tp-service-details-title">Our Services</h4>
								<ul>
									<?php if ( $all_services->have_posts() ) : while ( $all_services->have_posts() ) : $all_services->the_post(); ?>
										<li<?php echo get_the_ID() === $service_id ? ' class="active"' : ''; ?>>
											<a class="p-relative<?php echo get_the_ID() === $service_id ? ' active' : ''; ?>" href="<?php the_permalink(); ?>"><span><?php the_title(); ?></span><i class="flaticon-right-arrow"></i></a>
										</li>
									<?php endwhile; wp_reset_postdata(); endif; ?>
								</ul>
							</div>
						</div>
						<div class="tp-service-details-widget mb-30">
							<div class="tp-service-details-thumb-box text-center">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo/black-logo.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"></a>
								<h4 class="tp-service-details-title mt-35 mb-25">Get the full range<br>of Cosmotone services</h4>
								<div class="tp-service-details-thumb"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/service/Service-Details.png' ); ?>" alt=""></div>
							</div>
						</div>
						<div class="tp-service-details-widget mb-30">
							<div class="tp-service-details-contact-box d-flex align-items-center">
								<div class="tp-service-details-contact-icon"><span><i class="flaticon-phone-call"></i></span></div>
								<div class="tp-service-details-contact-text"><span>Talk to an expert</span><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Us</a></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-8 col-lg-8">
					<div class="tp-service-details-right-wrap">
						<div class="tp-service-details-right-thumb mb-50">
							<img class="w-100" src="<?php echo esc_url( $service_image ); ?>" alt="<?php echo esc_attr( get_the_title( $service_id ) ); ?>">
						</div>
						<div class="tp-service-details-text">
							<h2 class="tp-inner-title pb-20"><?php echo esc_html( get_the_title( $service_id ) ); ?></h2>
							<div class="cosmotone-service-description"><?php echo apply_filters( 'the_content', $service->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if ( $related->have_posts() ) : ?>
		<div class="tp-service-area tp-service-bg p-relative pt-120 pb-90" data-background="assets/img/service/bg-1-2.jpg">
			<div class="container">
				<div class="row"><div class="col-xl-12"><div class="tp-service-section-box text-center mb-50"><span class="tp-section-subtitle">EXPLORE MORE</span><h4 class="tp-section-title">Related services</h4></div></div></div>
				<div class="row">
					<?php while ( $related->have_posts() ) : $related->the_post(); $related_id = get_the_ID(); ?>
						<div class="col-xl-4 col-lg-4 col-md-6 mb-30">
							<div class="tp-service-item p-relative">
								<div class="tp-service-thumb"><a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( cosmotone_catalog_image_url( $related_id, 'large' ) ); ?>" alt="<?php the_title_attribute(); ?>"></a></div>
								<div class="tp-service-content-box"><div class="tp-service-content fix"><div class="tp-service-text pb-5"><h4 class="tp-service-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4><p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_content() ), 15 ) ); ?></p></div><div class="tp-service-arrow"><a href="<?php the_permalink(); ?>">Read More<i class="flaticon-right-arrow"></i></a></div></div></div>
							</div>
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php get_template_part( 'template-parts/cta' ); ?>
</main>

