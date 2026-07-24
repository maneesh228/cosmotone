<?php
/** Careers page adapted from the Oraxis reference. @package Cosmotone */
defined( 'ABSPATH' ) || exit;
get_header();
$jobs = cosmotone_get_jobs();
ob_start();
?>
<main>
   <!-- breadcrumb area start -->
   <section class="breadcrumb__area breadcrumb__overlay breadcrumb__height p-relative fix" data-background="assets/img/breadcurmb/breadcurmb.jpg">
      <div class="container"><div class="row"><div class="col-12"><div class="breadcrumb__content z-index d-flex justify-content-between align-items-end">
         <div class="breadcrumb__section-title-box"><h4 class="breadcrumb__subtitle">JOIN COSMOTONE</h4><h1 class="breadcrumb__title">Careers</h1></div>
         <div class="breadcrumb__list"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span><span class="dvdr"><i>/</i></span><span>Careers</span></div>
      </div></div></div></div>
   </section>
   <!-- breadcrumb area end -->
   <!-- career area start -->
   <section class="cosmotone-resource-section">
      <div class="container">
         <div class="tp-team-section-box text-center mb-60"><span class="tp-section-subtitle"><i class="flaticon-flash"></i> CAREERS</span><h2 class="tp-section-title">Open Positions</h2><p>Build the future of dependable electrical and automotive solutions with our team.</p></div>
         <div class="row g-4">
            <?php if ( $jobs->have_posts() ) : ?>
               <?php while ( $jobs->have_posts() ) : $jobs->the_post();
                  $job_id       = get_the_ID();
                  $department   = get_post_meta( $job_id, '_cosmotone_job_department', true );
                  $requirements = preg_split( '/\R/u', (string) get_post_meta( $job_id, '_cosmotone_job_requirements', true ), -1, PREG_SPLIT_NO_EMPTY );
                  $button_text  = get_post_meta( $job_id, '_cosmotone_job_button_text', true );
                  $apply_url    = get_post_meta( $job_id, '_cosmotone_job_apply_url', true );
                  ?>
                  <div class="col-lg-6">
                     <article class="cosmotone-resource-card">
                        <?php if ( $department ) : ?><span class="cosmotone-card-label"><?php echo esc_html( $department ); ?></span><?php endif; ?>
                        <h3><?php the_title(); ?></h3>
                        <div class="cosmotone-resource-description"><?php echo wp_kses_post( wpautop( get_the_content() ) ); ?></div>
                        <?php if ( $requirements ) : ?><ul><?php foreach ( $requirements as $requirement ) : ?><li><?php echo esc_html( $requirement ); ?></li><?php endforeach; ?></ul><?php endif; ?>
                        <a class="tp-btn" href="<?php echo esc_url( $apply_url ? $apply_url : home_url( '/contact/' ) ); ?>"><span><?php echo esc_html( $button_text ? $button_text : 'APPLY NOW' ); ?></span></a>
                     </article>
                  </div>
               <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
               <div class="col-12 text-center"><p><?php esc_html_e( 'No open positions are available at the moment.', 'cosmotone' ); ?></p></div>
            <?php endif; ?>
         </div>
      </div>
   </section>
   <!-- career area end -->
</main>
<?php
$markup = ob_get_clean();
echo cosmotone_apply_page_section_fields( $markup, get_queried_object_id(), 'career' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
get_footer();
?>
