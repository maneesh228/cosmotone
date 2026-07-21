<?php
/** Careers page adapted from the Oraxis reference. @package Cosmotone */
defined( 'ABSPATH' ) || exit;
get_header();
?>
<main>
   <section class="breadcrumb__area breadcrumb__overlay breadcrumb__height p-relative fix" data-background="assets/img/breadcurmb/breadcurmb.jpg">
      <div class="container"><div class="row"><div class="col-12"><div class="breadcrumb__content z-index d-flex justify-content-between align-items-end">
         <div class="breadcrumb__section-title-box"><h4 class="breadcrumb__subtitle">JOIN COSMOTONE</h4><h1 class="breadcrumb__title">Careers</h1></div>
         <div class="breadcrumb__list"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span><span class="dvdr"><i>/</i></span><span>Careers</span></div>
      </div></div></div></div>
   </section>
   <section class="cosmotone-resource-section">
      <div class="container">
         <div class="tp-team-section-box text-center mb-60"><span class="tp-section-subtitle"><i class="flaticon-flash"></i> CAREERS</span><h2 class="tp-section-title">Open Positions</h2><p>Build the future of dependable electrical and automotive solutions with our team.</p></div>
         <div class="row g-4">
            <div class="col-lg-6"><article class="cosmotone-resource-card"><span class="cosmotone-card-label">Engineering</span><h3>Electrical Design Engineer</h3><p>Develop wiring harnesses, electrical systems, drawings, specifications, and validation documentation for automotive applications.</p><ul><li>Full-time position</li><li>Engineering experience preferred</li></ul><a class="tp-btn" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><span>APPLY NOW</span></a></article></div>
            <div class="col-lg-6"><article class="cosmotone-resource-card"><span class="cosmotone-card-label">Production</span><h3>Quality Control Engineer</h3><p>Maintain product quality through incoming, in-process, and final inspections while supporting continuous improvement initiatives.</p><ul><li>Full-time position</li><li>Quality systems knowledge preferred</li></ul><a class="tp-btn" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><span>APPLY NOW</span></a></article></div>
            <div class="col-lg-6"><article class="cosmotone-resource-card"><span class="cosmotone-card-label">Operations</span><h3>Production Supervisor</h3><p>Coordinate production teams, daily targets, materials, safety requirements, and manufacturing process compliance.</p><ul><li>Full-time position</li><li>Manufacturing experience preferred</li></ul><a class="tp-btn" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><span>APPLY NOW</span></a></article></div>
            <div class="col-lg-6"><article class="cosmotone-resource-card"><span class="cosmotone-card-label">Business Development</span><h3>Sales Executive</h3><p>Develop customer relationships, identify new opportunities, prepare proposals, and support long-term account growth.</p><ul><li>Full-time position</li><li>B2B sales experience preferred</li></ul><a class="tp-btn" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><span>APPLY NOW</span></a></article></div>
         </div>
      </div>
   </section>
</main>
<?php get_footer(); ?>
