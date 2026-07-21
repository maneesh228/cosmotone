<?php
/** Downloads page adapted from the Oraxis reference. @package Cosmotone */
defined( 'ABSPATH' ) || exit;
get_header();
?>
<main>
   <section class="breadcrumb__area breadcrumb__overlay breadcrumb__height p-relative fix" data-background="assets/img/breadcurmb/breadcurmb.jpg">
      <div class="container"><div class="row"><div class="col-12"><div class="breadcrumb__content z-index d-flex justify-content-between align-items-end">
         <div class="breadcrumb__section-title-box"><h4 class="breadcrumb__subtitle">RESOURCE CENTRE</h4><h1 class="breadcrumb__title">Downloads</h1></div>
         <div class="breadcrumb__list"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span><span class="dvdr"><i>/</i></span><span>Downloads</span></div>
      </div></div></div></div>
   </section>
   <section class="cosmotone-resource-section">
      <div class="container">
         <div class="tp-team-section-box text-center mb-60"><span class="tp-section-subtitle"><i class="flaticon-flash"></i> DOWNLOADS</span><h2 class="tp-section-title">Product resources</h2><p>Access company and product information from our resource centre.</p></div>
         <div class="row g-4">
            <?php
            $downloads = array(
               array( 'Company Profile', 'An introduction to Cosmotone, our capabilities, facilities, and commitment to quality.' ),
               array( 'Product Catalogue', 'Explore our automotive electrical products, relays, accessories, sensors, and connectors.' ),
               array( 'Quality Policy', 'Review our approach to consistent quality, process control, safety, and continuous improvement.' ),
            );
            foreach ( $downloads as $download ) :
            ?>
               <div class="col-lg-4 col-md-6"><article class="cosmotone-resource-card cosmotone-download-card"><span class="cosmotone-download-icon"><i class="fa-light fa-file-pdf"></i></span><h3><?php echo esc_html( $download[0] ); ?></h3><p><?php echo esc_html( $download[1] ); ?></p><a class="cosmotone-resource-link" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Request document <i class="fa-regular fa-arrow-right"></i></a></article></div>
            <?php endforeach; ?>
         </div>
      </div>
   </section>
</main>
<?php get_footer(); ?>
