<?php
/** Downloads page adapted from the Oraxis reference. @package Cosmotone */
defined( 'ABSPATH' ) || exit;
get_header();
$downloads = cosmotone_get_downloads();
ob_start();
?>
<main>
   <!-- breadcrumb area start -->
   <section class="breadcrumb__area breadcrumb__overlay breadcrumb__height p-relative fix" data-background="assets/img/breadcurmb/breadcurmb.jpg">
      <div class="container"><div class="row"><div class="col-12"><div class="breadcrumb__content z-index d-flex justify-content-between align-items-end">
         <div class="breadcrumb__section-title-box"><h4 class="breadcrumb__subtitle">RESOURCE CENTRE</h4><h1 class="breadcrumb__title">Downloads</h1></div>
         <div class="breadcrumb__list"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span><span class="dvdr"><i>/</i></span><span>Downloads</span></div>
      </div></div></div></div>
   </section>
   <!-- breadcrumb area end -->
   <!-- downloads area start -->
   <section class="cosmotone-resource-section">
      <div class="container">
         <div class="tp-team-section-box text-center mb-60"><span class="tp-section-subtitle"><i class="flaticon-flash"></i> DOWNLOADS</span><h2 class="tp-section-title">Product resources</h2><p>Access company and product information from our resource centre.</p></div>
         <div class="row g-4">
            <?php if ( $downloads->have_posts() ) : ?>
               <?php while ( $downloads->have_posts() ) : $downloads->the_post();
                  $download_id = get_the_ID();
                  $file_url    = get_post_meta( $download_id, '_cosmotone_download_file_url', true );
                  $button_text = get_post_meta( $download_id, '_cosmotone_download_button_text', true );
                  ?>
                  <div class="col-lg-4 col-md-6">
                     <article class="cosmotone-resource-card cosmotone-download-card">
                        <span class="cosmotone-download-icon"><i class="fa-light fa-file-pdf"></i></span>
                        <h3><?php the_title(); ?></h3>
                        <div class="cosmotone-resource-description"><?php echo wp_kses_post( wpautop( get_the_content() ) ); ?></div>
                        <a class="cosmotone-resource-link" href="<?php echo esc_url( $file_url ? $file_url : home_url( '/contact/' ) ); ?>"><?php echo esc_html( $button_text ? $button_text : 'Download document' ); ?> <i class="fa-regular fa-arrow-right"></i></a>
                     </article>
                  </div>
               <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
               <div class="col-12 text-center"><p><?php esc_html_e( 'No downloads are available yet.', 'cosmotone' ); ?></p></div>
            <?php endif; ?>
         </div>
      </div>
   </section>
   <!-- downloads area end -->
</main>
<?php
$markup = ob_get_clean();
echo cosmotone_apply_page_section_fields( $markup, get_queried_object_id(), 'downloads' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
get_footer();
?>
