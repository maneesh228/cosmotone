<?php
/**
 * Template for the dynamic Services listing page.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;
get_header();
$services = cosmotone_get_services();
ob_start();
?>
<main>
	<!-- breadcrumb area start -->
	<div class="breadcrumb__area breadcrumb__overlay breadcrumb__height p-relative fix" data-background="assets/img/breadcurmb/breadcurmb.jpg">
		<div class="container">
			<div class="row">
				<div class="col-xxl-12">
					<div class="breadcrumb__content z-index d-flex justify-content-between align-items-end">
						<div class="breadcrumb__section-title-box">
							<h4 class="breadcrumb__subtitle">COSMOTONE SERVICES</h4>
							<h3 class="breadcrumb__title">Services</h3>
						</div>
						<div class="breadcrumb__list">
							<span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
							<span class="dvdr"><i>/</i></span>
							<span>Services</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- breadcrumb area end -->

	<div class="tp-feature-2-area p-relative">
		<div class="tp-feature-2-bg pt-120 pb-90" data-background="assets/img/feature/bg-1.png">
			<div class="container">
				<div class="row">
					<?php
					$features = array(
						array( 'flaticon-lowest-price', 'Competitive Pricing' ),
						array( 'flaticon-guaranteed', 'Quality Assurance' ),
						array( 'flaticon-repair', 'Reliable Support' ),
						array( 'flaticon-award', 'Proven Expertise' ),
					);
					foreach ( $features as $index => $feature ) :
						?>
						<div class="col-xl-3 col-lg-4 col-md-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay="<?php echo esc_attr( 0.3 + $index * 0.2 ); ?>s">
							<div class="tp-feature-2-item<?php echo 2 === $index ? ' active' : ''; ?>">
								<div class="tp-feature-2-icon"><span><i class="<?php echo esc_attr( $feature[0] ); ?>"></i></span></div>
								<div class="tp-feature-2-text"><h5 class="tp-feature-2-title"><?php echo esc_html( $feature[1] ); ?></h5></div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="tp-service-area tp-service-bg p-relative pt-120 pb-90" data-background="assets/img/service/bg-1-2.jpg">
		<div class="tp-service-shape-2 d-none d-xxl-block"><img src="assets/img/service/shape-1-3.png" alt=""></div>
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<div class="tp-service-section-box text-center mb-50">
						<span class="tp-section-subtitle">COSMOTONE SERVICES</span>
						<h4 class="tp-section-title">Reliable electrical solutions<br>built around your needs</h4>
					</div>
				</div>
			</div>
			<div class="row">
				<?php if ( $services->have_posts() ) : ?>
					<?php $delay = 0.3; while ( $services->have_posts() ) : $services->the_post();
						$service_id = get_the_ID();
						$icon       = get_post_meta( $service_id, '_cosmotone_service_icon', true );
						$icon       = $icon ? $icon : 'flaticon-flash';
						$summary    = wp_trim_words( wp_strip_all_tags( get_the_content() ), 18 );
						?>
						<div class="col-xl-4 col-lg-4 col-md-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
							<div class="tp-service-item p-relative">
								<div class="tp-service-thumb">
									<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( cosmotone_catalog_image_url( $service_id, 'large' ) ); ?>" alt="<?php the_title_attribute(); ?>"></a>
								</div>
								<div class="tp-service-content-box">
									<div class="tp-service-content fix">
										<div class="tp-service-icon p-relative">
											<span><i class="<?php echo esc_attr( $icon ); ?>"></i></span>
											<div class="tp-service-icon-shape"><img src="assets/img/service/shape-1-1.png" alt=""></div>
										</div>
										<div class="tp-service-text pb-5">
											<h4 class="tp-service-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
											<p><?php echo esc_html( $summary ); ?></p>
										</div>
										<div class="tp-service-arrow"><a href="<?php the_permalink(); ?>">Read More<i class="flaticon-right-arrow"></i></a></div>
									</div>
								</div>
								<div class="tp-service-shape-1"><img src="assets/img/service/shape-1-2.png" alt=""></div>
							</div>
						</div>
						<?php $delay += 0.2; endwhile; wp_reset_postdata(); ?>
				<?php else : ?>
					<div class="col-12 text-center"><p>No services have been published yet.</p></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php get_template_part( 'template-parts/cta' ); ?>
</main>
<?php
$markup = ob_get_clean();
echo cosmotone_apply_page_section_fields( $markup, get_queried_object_id(), 'services' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
get_footer();
?>
