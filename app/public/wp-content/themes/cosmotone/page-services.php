<?php
/** Template for the services page. @package Cosmotone */
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
                        <h3 class="breadcrumb__title">Service</h3>
                     </div>
                     <div class="breadcrumb__list">
                        <span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
                        <span class="dvdr"><i>/</i></span>
                        <span>Service</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- breadcrumb area end -->

      <!-- feature area start -->
      <div class="tp-feature-2-area p-relative">
         <div class="tp-feature-2-bg pt-120 pb-90" data-background="assets/img/feature/bg-1.png">
            <div class="container">
               <div class="row">
                  <div class="col-xl-3 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                     <div class="tp-feature-2-item">
                        <div class="tp-feature-2-icon">
                           <span><i class="flaticon-lowest-price"></i></span>
                        </div>
                        <div class="tp-feature-2-text">
                           <h5 class="tp-feature-2-title">Affrodable price</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
                     <div class="tp-feature-2-item">
                        <div class="tp-feature-2-icon">
                           <span><i class="flaticon-guaranteed"></i></span>
                        </div>
                        <div class="tp-feature-2-text">
                           <h5 class="tp-feature-2-title">100% Gurantee</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".7s">
                     <div class="tp-feature-2-item active">
                        <div class="tp-feature-2-icon">
                           <span><i class="flaticon-repair"></i></span>
                        </div>
                        <div class="tp-feature-2-text">
                           <h5 class="tp-feature-2-title">24/7 Availabilty</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".9s">
                     <div class="tp-feature-2-item">
                        <div class="tp-feature-2-icon">
                           <span><i class="flaticon-award"></i></span>
                        </div>
                        <div class="tp-feature-2-text">
                           <h5 class="tp-feature-2-title">Award winning</h5>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- feature area end -->

      <!-- service area start -->
      <div class="tp-service-area tp-service-bg p-relative pt-120 pb-90" data-background="assets/img/service/bg-1-2.jpg">
         <div class="tp-service-shape-2 d-none d-xxl-block">
            <img src="assets/img/service/shape-1-3.png" alt="">
         </div>
         <div class="container">
            <div class="row">
               <div class="col-xl-12">
                  <div class="tp-service-section-box text-center mb-50">
                     <span class="tp-section-subtitle">OUR BIDDUT SERVICES</span>
                     <h4 class="tp-section-title">Outstanding residential & <br> commercial services</h4>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                  <div class="tp-service-item p-relative">
                     <div class="tp-service-thumb">
                        <img src="assets/img/service/sv-1-1.jpg" alt="">
                     </div>
                     <div class="tp-service-content-box">
                        <div class="tp-service-content fix">
                           <div class="tp-service-icon p-relative">
                              <span><i class="flaticon-lamp"></i></span>
                              <div class="tp-service-icon-shape">
                                 <img src="assets/img/service/shape-1-1.png" alt="">
                              </div>
                           </div>
                           <div class="tp-service-text pb-5">
                              <h4 class="tp-service-title">
                                 <a href="<?php echo esc_url( home_url( '/service-details/' ) ); ?>">Electrical panels</a>
                              </h4>
                              <p>This box could corrode over time, by
                                 losse connection, dust or debris.</p>
                           </div>
                           <div class="tp-service-arrow">
                              <a href="<?php echo esc_url( home_url( '/service-details/' ) ); ?>">Read More<i class="flaticon-right-arrow"></i></a>
                           </div>
                        </div>
                     </div>
                     <div class="tp-service-shape-1">
                        <img src="assets/img/service/shape-1-2.png" alt="">
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
                  <div class="tp-service-item p-relative">
                     <div class="tp-service-thumb">
                        <img src="assets/img/service/sv-1-2.jpg" alt="">
                     </div>
                     <div class="tp-service-content-box">
                        <div class="tp-service-content fix">
                           <div class="tp-service-icon p-relative">
                              <span><i class="flaticon-air-conditioner"></i></span>
                              <div class="tp-service-icon-shape">
                                 <img src="assets/img/service/shape-1-1.png" alt="">
                              </div>
                           </div>
                           <div class="tp-service-text pb-5">
                              <h4 class="tp-service-title">
                                 <a href="<?php echo esc_url( home_url( '/service-details/' ) ); ?>">Air condition</a>
                              </h4>
                              <p>Air conditioning isn't just used to keep
                                 homes and offices cool.</p>
                           </div>
                           <div class="tp-service-arrow">
                              <a href="<?php echo esc_url( home_url( '/service-details/' ) ); ?>">Read More<i class="flaticon-right-arrow"></i></a>
                           </div>
                        </div>
                     </div>
                     <div class="tp-service-shape-1">
                        <img src="assets/img/service/shape-1-2.png" alt="">
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".7s">
                  <div class="tp-service-item p-relative">
                     <div class="tp-service-thumb">
                        <img src="assets/img/service/sv-1-3.jpg" alt="">
                     </div>
                     <div class="tp-service-content-box">
                        <div class="tp-service-content fix">
                           <div class="tp-service-icon p-relative">
                              <span><i class="flaticon-ac"></i></span>
                              <div class="tp-service-icon-shape">
                                 <img src="assets/img/service/shape-1-1.png" alt="">
                              </div>
                           </div>
                           <div class="tp-service-text pb-5">
                              <h4 class="tp-service-title">
                                 <a href="<?php echo esc_url( home_url( '/service-details/' ) ); ?>">Heating service</a>
                              </h4>
                              <p>This box could corrode over time, by
                                 losse connection, dust or debris.</p>
                           </div>
                           <div class="tp-service-arrow">
                              <a href="<?php echo esc_url( home_url( '/service-details/' ) ); ?>">Read More<i class="flaticon-right-arrow"></i></a>
                           </div>
                        </div>
                     </div>
                     <div class="tp-service-shape-1">
                        <img src="assets/img/service/shape-1-2.png" alt="">
                     </div>
                  </div>
               </div>  
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".8s">
                  <div class="tp-service-item p-relative">
                     <div class="tp-service-thumb">
                        <img src="assets/img/service/sv-1-4.jpg" alt="">
                     </div>
                     <div class="tp-service-content-box">
                        <div class="tp-service-content fix">
                           <div class="tp-service-icon p-relative">
                              <span><i class="flaticon-lamp"></i></span>
                              <div class="tp-service-icon-shape">
                                 <img src="assets/img/service/shape-1-1.png" alt="">
                              </div>
                           </div>
                           <div class="tp-service-text pb-5">
                              <h4 class="tp-service-title">
                                 <a href="<?php echo esc_url( home_url( '/service-details/' ) ); ?>">Ceiling fan instalation</a>
                              </h4>
                              <p>This box could corrode over time, by
                                 losse connection, dust or debris.</p>
                           </div>
                           <div class="tp-service-arrow">
                              <a href="<?php echo esc_url( home_url( '/service-details/' ) ); ?>">Read More<i class="flaticon-right-arrow"></i></a>
                           </div>
                        </div>
                     </div>
                     <div class="tp-service-shape-1">
                        <img src="assets/img/service/shape-1-2.png" alt="">
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay="1s">
                  <div class="tp-service-item p-relative">
                     <div class="tp-service-thumb">
                        <img src="assets/img/service/sv-1-5.jpg" alt="">
                     </div>
                     <div class="tp-service-content-box">
                        <div class="tp-service-content fix">
                           <div class="tp-service-icon p-relative">
                              <span><i class="flaticon-short-circuit"></i></span>
                              <div class="tp-service-icon-shape">
                                 <img src="assets/img/service/shape-1-1.png" alt="">
                              </div>
                           </div>
                           <div class="tp-service-text pb-5">
                              <h4 class="tp-service-title">
                                 <a href="<?php echo esc_url( home_url( '/service-details/' ) ); ?>">Short circuit repair</a>
                              </h4>
                              <p>Air conditioning isn't just used to keep
                                 homes and offices cool.</p>
                           </div>
                           <div class="tp-service-arrow">
                              <a href="<?php echo esc_url( home_url( '/service-details/' ) ); ?>">Read More<i class="flaticon-right-arrow"></i></a>
                           </div>
                        </div>
                     </div>
                     <div class="tp-service-shape-1">
                        <img src="assets/img/service/shape-1-2.png" alt="">
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30  wow tpfadeUp" data-wow-duration=".9s" data-wow-delay="1.2s">
                  <div class="tp-service-item p-relative">
                     <div class="tp-service-thumb">
                        <img src="assets/img/service/sv-1-6.jpg" alt="">
                     </div>
                     <div class="tp-service-content-box">
                        <div class="tp-service-content fix">
                           <div class="tp-service-icon p-relative">
                              <span><i class="flaticon-lighting"></i></span>
                              <div class="tp-service-icon-shape">
                                 <img src="assets/img/service/shape-1-1.png" alt="">
                              </div>
                           </div>
                           <div class="tp-service-text pb-5">
                              <h4 class="tp-service-title">
                                 <a href="<?php echo esc_url( home_url( '/service-details/' ) ); ?>">Outdoor lighting</a>
                              </h4>
                              <p>This box could corrode over time, by
                                 losse connection, dust or debris.</p>
                           </div>
                           <div class="tp-service-arrow">
                              <a href="<?php echo esc_url( home_url( '/service-details/' ) ); ?>">Read More<i class="flaticon-right-arrow"></i></a>
                           </div>
                        </div>
                     </div>
                     <div class="tp-service-shape-1">
                        <img src="assets/img/service/shape-1-2.png" alt="">
                     </div>
                  </div>
               </div>  
            </div>
         </div>
      </div>
      <!-- service area end -->

</main>
<?php get_footer(); ?>
