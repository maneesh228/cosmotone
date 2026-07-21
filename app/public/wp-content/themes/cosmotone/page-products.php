<?php
/** Template for the products page. @package Cosmotone */
defined( 'ABSPATH' ) || exit;
get_header();
?>
   <main>

      <!-- breadcrumb area start -->
      <div class="breadcrumb__area breadcrumb__overlay breadcrumb__height p-relative fix" data-background="assets/img/breadcurmb/breadcurmb.jpg">
         <div class="container">
            <div class="row">
               <div class="col-xxl-12">
                  <div class="breadcrumb__content z-index d-flex justify-content-between align-items-end">
                     <div class="breadcrumb__section-title-box">
                        <h4 class="breadcrumb__subtitle">BIDDUT ELCETRIC SERVICE</h4>
                        <h3 class="breadcrumb__title">Project</h3>
                     </div>
                     <div class="breadcrumb__list">
                        <span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
                        <span class="dvdr"><i>/</i></span>
                        <span>Project</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- breadcrumb area end -->


      <!-- project area start -->
      <div class="tp-project-area p-relative pt-120 pb-90">
         <div class="tp-project-shape-1 d-none d-xl-block">
            <img src="assets/img/project/shape-1-1.png" alt="">
         </div>
         <div class="container">
            <div class="row">
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                  <div class="tp-project-item p-relative">
                     <div class="tp-project-thumb">
                        <img src="assets/img/project/pro-1-1.jpg" alt="">
                     </div>
                     <div class="tp-project-content">
                        <a href="<?php echo esc_url( home_url( '/product-details/' ) ); ?>"><i class="flaticon-right-arrow"></i></a>
                        <span>Repair</span>
                        <h4 class="tp-project-title"><a href="<?php echo esc_url( home_url( '/product-details/' ) ); ?>">Electrical Repair</a></h4>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
                  <div class="tp-project-item p-relative">
                     <div class="tp-project-thumb">
                        <img src="assets/img/project/pro-1-2.jpg" alt="">
                     </div>
                     <div class="tp-project-content">
                        <a href="<?php echo esc_url( home_url( '/product-details/' ) ); ?>"><i class="flaticon-right-arrow"></i></a>
                        <span>Repair</span>
                        <h4 class="tp-project-title"><a href="<?php echo esc_url( home_url( '/product-details/' ) ); ?>">Inspections & Testing</a></h4>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".7s">
                  <div class="tp-project-item p-relative">
                     <div class="tp-project-thumb">
                        <img src="assets/img/project/pro-1-3.jpg" alt="">
                     </div>
                     <div class="tp-project-content">
                        <a href="<?php echo esc_url( home_url( '/product-details/' ) ); ?>"><i class="flaticon-right-arrow"></i></a>
                        <span>Repair</span>
                        <h4 class="tp-project-title"><a href="<?php echo esc_url( home_url( '/product-details/' ) ); ?>">Industrial Solution</a></h4>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".8s">
                  <div class="tp-project-item p-relative">
                     <div class="tp-project-thumb">
                        <img src="assets/img/project/pro-1-4.jpg" alt="">
                     </div>
                     <div class="tp-project-content">
                        <a href="<?php echo esc_url( home_url( '/product-details/' ) ); ?>"><i class="flaticon-right-arrow"></i></a>
                        <span>Repair</span>
                        <h4 class="tp-project-title"><a href="<?php echo esc_url( home_url( '/product-details/' ) ); ?>">Data System Wiring</a></h4>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay="1s">
                  <div class="tp-project-item p-relative">
                     <div class="tp-project-thumb">
                        <img src="assets/img/project/pro-1-5.jpg" alt="">
                     </div>
                     <div class="tp-project-content">
                        <a href="<?php echo esc_url( home_url( '/product-details/' ) ); ?>"><i class="flaticon-right-arrow"></i></a>
                        <span>Repair</span>
                        <h4 class="tp-project-title"><a href="<?php echo esc_url( home_url( '/product-details/' ) ); ?>">Circuit Breaker Panels</a></h4>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay="1.2s">
                  <div class="tp-project-item p-relative">
                     <div class="tp-project-thumb">
                        <img src="assets/img/project/pro-1-6.jpg" alt="">
                     </div>
                     <div class="tp-project-content">
                        <a href="<?php echo esc_url( home_url( '/product-details/' ) ); ?>"><i class="flaticon-right-arrow"></i></a>
                        <span>Repair</span>
                        <h4 class="tp-project-title"><a href="<?php echo esc_url( home_url( '/product-details/' ) ); ?>">Data System Wiring</a></h4>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- project area end -->

</main>
<?php get_footer(); ?>
