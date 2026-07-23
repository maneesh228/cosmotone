<?php
/** Front page template. @package Cosmotone */
defined( 'ABSPATH' ) || exit;
get_header();
$home_sections = cosmotone_get_home_sections( get_queried_object_id() );
?>
   <main>

      <!-- hero area start -->
      <?php cosmotone_render_managed_home_slider(); ?>
      <!-- hero area end -->

      <!-- about area start -->
      <?php if ( ! empty( $home_sections['about_enabled'] ) ) : ?>
      <div class="tp-about-area p-relative pt-120 pb-120">
         <div class="tp-about-shape-3">
            <img src="assets/img/about/shape-1-4.png" alt="">
         </div>
         <div class="tp-about-shape-4 d-none d-xl-block">
            <img src="assets/img/about/shape-1-5.png" alt="">
         </div>
         <div class="container">
            <div class="row">
               <div class="col-xl-6 col-lg-6 wow tpfadeLeft" data-wow-duration=".9s" data-wow-delay=".5s">
                  <div class="tp-about-left-box">
                     <div class="tp-about-section-box mb-15">
                        <span class="tp-section-subtitle"><i class="flaticon-flash"></i> <?php echo esc_html( $home_sections['about_subtitle'] ); ?></span>
                        <h4 class="tp-section-title"><?php echo wp_kses_post( $home_sections['about_title'] ); ?></h4>
                     </div>
                     <div class="tp-about-text">
                        <div class="tp-about-description"><?php echo wp_kses_post( wpautop( $home_sections['about_description'] ) ); ?></div>
                        <span><?php echo esc_html( $home_sections['about_highlight'] ); ?></span>
                        <div class="tp-about-icon-wrap p-relative d-flex justify-content-between mb-45">
                           <!-- <div class="tp-about-icon-shape d-none d-xl-block">
                              <img src="assets/img/about/shape-1-6.png" alt="">
                           </div> -->
                           <div class="tp-about-icon-box d-flex align-items-center mb-20">
                              <div class="tp-about-icon">
                                 <span><i class="flaticon-electrician"></i></span>
                              </div>
                              <div class="tp-about-icon-text">
                                 <h5><?php echo wp_kses_post( $home_sections['about_feature_1'] ); ?></h5>
                              </div>
                           </div>
                           <div class="tp-about-icon-box d-flex align-items-center mb-20">
                              <div class="tp-about-icon">
                                 <span><i class="flaticon-plug"></i></span>
                              </div>
                              <div class="tp-about-icon-text">
                                 <h5><?php echo wp_kses_post( $home_sections['about_feature_2'] ); ?></h5>
                              </div>
                           </div>
                        </div>
                        <div class="tp-about-button-box d-flex align-items-center">
                           <a class="tp-btn-black" href="<?php echo esc_url( $home_sections['about_button_url'] ); ?>"><span><?php echo esc_html( $home_sections['about_button_text'] ); ?></span></a>
                           <img src="assets/img/about/shape-1-1.png" alt="">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".7s">
                  <div class="tp-about-right-box p-relative text-end">
                     <div class="tp-about-main-thumb">
                        <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'about_main_image' ) ); ?>" alt="">
                     </div>
                     <div class="tp-about-thumb-sm">
                        <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'about_small_image' ) ); ?>" alt="">
                     </div>
                     <div class="tp-about-shape-1 d-none d-lg-block">
                        <img src="assets/img/about/shape-1-2.png?v=blue-theme" alt="">
                     </div>
                     <div class="tp-about-shape-2  d-none d-lg-block">
                        <img src="assets/img/about/shape-1-3.png" alt="">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php endif; ?>
      <!-- about area end -->

      <!-- quality assurance area start -->
      <?php if ( ! empty( $home_sections['quality_enabled'] ) ) : ?>
      <section class="tp-quality-strip-area" aria-label="Our quality commitments">
         <div class="container">
            <div class="tp-quality-strip">
               <div class="row g-0">
                  <div class="col-xl-3 col-md-6">
                     <div class="tp-quality-strip-item">
                        <span class="tp-quality-strip-icon"><i class="fa-regular fa-badge-check"></i></span>
                        <div>
                           <h5><?php echo esc_html( $home_sections['quality_1_title'] ); ?></h5>
                           <div><?php echo wp_kses_post( wpautop( $home_sections['quality_1_description'] ) ); ?></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-md-6">
                     <div class="tp-quality-strip-item">
                        <span class="tp-quality-strip-icon"><i class="fa-regular fa-gears"></i></span>
                        <div>
                           <h5><?php echo esc_html( $home_sections['quality_2_title'] ); ?></h5>
                           <div><?php echo wp_kses_post( wpautop( $home_sections['quality_2_description'] ) ); ?></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-md-6">
                     <div class="tp-quality-strip-item">
                        <span class="tp-quality-strip-icon"><i class="fa-regular fa-truck-fast"></i></span>
                        <div>
                           <h5><?php echo esc_html( $home_sections['quality_3_title'] ); ?></h5>
                           <div><?php echo wp_kses_post( wpautop( $home_sections['quality_3_description'] ) ); ?></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-md-6">
                     <div class="tp-quality-strip-item">
                        <span class="tp-quality-strip-icon"><i class="fa-regular fa-headset"></i></span>
                        <div>
                           <h5><?php echo esc_html( $home_sections['quality_4_title'] ); ?></h5>
                           <div><?php echo wp_kses_post( wpautop( $home_sections['quality_4_description'] ) ); ?></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <?php endif; ?>
      <!-- quality assurance area end -->

      <!-- service area start -->
      <?php if ( ! empty( $home_sections['services_enabled'] ) ) : ?>
      <div class="tp-service-area tp-service-bg p-relative pt-120 pb-120"
         data-background="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'services_background' ) ); ?>">
         <div class="tp-service-shape-2 d-none d-xxl-block">
            <!-- <img src="assets/img/service/shape-1-3.png" alt=""> -->
         </div>
         <div class="container">
            <div class="tp-service-wrap mb-50">
               <div class="row align-items-end">
                  <div class="col-xl-6 col-lg-6 col-md-9">
                     <div class="tp-service-section-box">
                        <span class="tp-section-subtitle"><i class="flaticon-flash"></i><?php echo esc_html( $home_sections['services_subtitle'] ); ?></span>
                        <h4 class="tp-section-title"><?php echo wp_kses_post( $home_sections['services_title'] ); ?></h4>
                     </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-3">
                     <div class="tp-service-slider-arrow d-flex justify-content-start  justify-content-md-end">
                        <button class="test-next"><i class="far fa-arrow-left"></i></button>
                        <button class="test-prev active"><i class="far fa-arrow-right"></i></button>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-xl-12">
                  <div class="tp-service-wrapper">
                     <div class="swiper-container tp-service-active">
                        <div class="swiper-wrapper">
                           <div class="swiper-slide">
                              <div class="tp-service-item p-relative">
                                 <div class="tp-service-thumb">
                                    <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'service_1_image' ) ); ?>" alt="">
                                 </div>
                                 <div class="tp-service-content-box">
                                    <div class="tp-service-content fix">
                                       <div class="tp-service-icon p-relative">
                                          <span><i class="flaticon-battery"></i></span>
                                          <div class="tp-service-icon-shape">
                                             <img src="assets/img/service/shape-1-1.png" alt="">
                                          </div>
                                       </div>
                                       <div class="tp-service-text pb-5">
                                          <h4 class="tp-service-title">
                                             <a href="<?php echo esc_url( $home_sections['service_1_url'] ); ?>"><?php echo esc_html( $home_sections['service_1_title'] ); ?></a>
                                          </h4>
                                          <div><?php echo wp_kses_post( wpautop( $home_sections['service_1_description'] ) ); ?></div>
                                       </div>
                                       <div class="tp-service-arrow">
                                          <a href="<?php echo esc_url( $home_sections['service_1_url'] ); ?>"><?php echo esc_html( $home_sections['service_1_button_text'] ); ?><i
                                                class="flaticon-right-arrow"></i></a>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="tp-service-shape-1">
                                    <img src="assets/img/service/shape-1-2.png" alt="">
                                 </div>
                              </div>
                           </div>
                           <div class="swiper-slide">
                              <div class="tp-service-item p-relative">
                                 <div class="tp-service-thumb">
                                    <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'service_2_image' ) ); ?>" alt="">
                                 </div>
                                 <div class="tp-service-content-box">
                                    <div class="tp-service-content fix">
                                       <div class="tp-service-icon p-relative">
                                          <span><i class="flaticon-plug-1"></i></span>
                                          <div class="tp-service-icon-shape">
                                             <img src="assets/img/service/shape-1-1.png" alt="">
                                          </div>
                                       </div>
                                       <div class="tp-service-text pb-5">
                                          <h4 class="tp-service-title">
                                             <a href="<?php echo esc_url( $home_sections['service_2_url'] ); ?>"><?php echo esc_html( $home_sections['service_2_title'] ); ?></a>
                                          </h4>
                                          <div><?php echo wp_kses_post( wpautop( $home_sections['service_2_description'] ) ); ?></div>
                                       </div>
                                       <div class="tp-service-arrow">
                                          <a href="<?php echo esc_url( $home_sections['service_2_url'] ); ?>"><?php echo esc_html( $home_sections['service_2_button_text'] ); ?><i
                                                class="flaticon-right-arrow"></i></a>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="tp-service-shape-1">
                                    <img src="assets/img/service/shape-1-2.png" alt="">
                                 </div>
                              </div>
                           </div>
                           <div class="swiper-slide">
                              <div class="tp-service-item p-relative">
                                 <div class="tp-service-thumb">
                                    <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'service_3_image' ) ); ?>" alt="">
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
                                             <a href="<?php echo esc_url( $home_sections['service_3_url'] ); ?>"><?php echo esc_html( $home_sections['service_3_title'] ); ?></a>
                                          </h4>
                                          <div><?php echo wp_kses_post( wpautop( $home_sections['service_3_description'] ) ); ?></div>
                                       </div>
                                       <div class="tp-service-arrow">
                                          <a href="<?php echo esc_url( $home_sections['service_3_url'] ); ?>"><?php echo esc_html( $home_sections['service_3_button_text'] ); ?><i
                                                class="flaticon-right-arrow"></i></a>
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
               </div>
            </div>
         </div>
      </div>
      <?php endif; ?>
      <!-- service area end -->

      <!-- choose area start -->
      <?php if ( ! empty( $home_sections['choose_enabled'] ) ) : ?>
      <div class="tp-choose-area tp-choose-space fix p-relative black-bg">
         <div class="tp-choose-shape-1 d-none d-lg-block">
            <img src="assets/img/choose/shape-1-1.png" alt="">
         </div>
         <div class="tp-choose-shape-2 d-none d-xl-block">
            <img src="assets/img/choose/shape-1-2.png" alt="">
         </div>
         <div class="tp-choose-shape-3 d-none d-md-block">
            <img src="assets/img/choose/shape-1-3.png" alt="">
         </div>
         <div class="tp-choose-shape-4 d-none d-md-block">
            <img src="assets/img/choose/shape-1-4.png" alt="">
         </div>
         <div class="tp-choose-shape-5 d-none d-xl-block">
            <img src="assets/img/choose/shape-1-5.png" alt="">
         </div>
         <div class="container">
            <div class="row">
               <div class="col-xl-6 col-lg-6">
                  <div class="tp-choose-content z-index">
                     <div class="tp-choose-section-box mb-30">
                        <span class="tp-section-subtitle text-color"><i class="flaticon-flash"></i><?php echo esc_html( $home_sections['choose_subtitle'] ); ?></span>
                        <h4 class="tp-section-title text-white"><?php echo wp_kses_post( $home_sections['choose_title'] ); ?></h4>
                     </div>
                     <div class="tp-choose-text mb-50">
                        <?php echo wp_kses_post( wpautop( $home_sections['choose_description'] ) ); ?>
                     </div>
                     <div class="tp-choose-wrap">
                        <div class="row">
                           <div class="col-xl-6 col-lg-6 col-md-6 mb-20">
                              <div class="tp-choose-item d-flex align-items-center">
                                 <span><i class="flaticon-battery"></i></span>
                                 <h5 class="tp-choose-item-title"><?php echo esc_html( $home_sections['choose_item_1'] ); ?></h5>
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 mb-20">
                              <div class="tp-choose-item d-flex align-items-center">
                                 <span><i class="flaticon-electrician-1"></i></span>
                                 <h5 class="tp-choose-item-title"><?php echo esc_html( $home_sections['choose_item_2'] ); ?></h5>
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 mb-20">
                              <div class="tp-choose-item d-flex align-items-center">
                                 <span><i class="flaticon-price-tag"></i></span>
                                 <h5 class="tp-choose-item-title"><?php echo esc_html( $home_sections['choose_item_3'] ); ?></h5>
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 mb-20">
                              <div class="tp-choose-item d-flex align-items-center">
                                 <span><i class="flaticon-alarm-clock"></i></span>
                                 <h5 class="tp-choose-item-title"><?php echo esc_html( $home_sections['choose_item_4'] ); ?></h5>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="tp-choose-thumb-box">
            <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'choose_image' ) ); ?>" alt="Automotive wiring harness, relays and electrical components">
         </div>
      </div>
      <?php endif; ?>
      <!-- choose area end -->

      <!-- project area start -->
      <?php if ( ! empty( $home_sections['products_enabled'] ) ) : ?>
      <div class="tp-project-area p-relative pt-120 pb-120">
         <div class="tp-project-shape-1 d-none d-xl-block">
            <img src="assets/img/project/shape-1-1.png" alt="">
         </div>
         <div class="container-fluid">
            <div class="row">
               <div class="col-xl-12">
                  <div class="tp-project-section-box text-center mb-60">
                     <span class="tp-section-subtitle"><i class="flaticon-flash"></i><?php echo esc_html( $home_sections['products_subtitle'] ); ?></span>
                     <h4 class="tp-section-title"><?php echo wp_kses_post( $home_sections['products_title'] ); ?></h4>
                  </div>
               </div>
               <div class="tp-project-plr z-index">
                  <div class="row">
                     <div class="col-xl-12">
                        <div class="tp-project-wrapper">
                           <div class="swiper-container tp-project-active">
                              <div class="swiper-wrapper">
                                 <div class="swiper-slide">
                                    <div class="tp-project-item p-relative">
                                       <div class="tp-project-thumb">
                                          <a class="popup-image tp-product-popup-image" href="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'product_1_image' ) ); ?>" title="<?php echo esc_attr( $home_sections['product_1_title'] ); ?>" aria-label="<?php echo esc_attr( 'View ' . $home_sections['product_1_title'] . ' product image' ); ?>">
                                             <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'product_1_image' ) ); ?>" alt="<?php echo esc_attr( $home_sections['product_1_title'] ); ?>">
                                          </a>
                                       </div>
                                       <div class="tp-project-content">
                                          <a class="tp-project-read-more" href="<?php echo esc_url( $home_sections['product_1_url'] ); ?>"><span><?php echo esc_html( $home_sections['product_1_button_text'] ); ?></span><i class="flaticon-right-arrow"></i></a>
                                          <span><?php echo esc_html( $home_sections['product_1_subtitle'] ); ?></span>
                                          <h4 class="tp-project-title"><a href="<?php echo esc_url( $home_sections['product_1_url'] ); ?>"><?php echo esc_html( $home_sections['product_1_title'] ); ?></a></h4>
                                          <div><?php echo wp_kses_post( wpautop( $home_sections['product_1_description'] ) ); ?></div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="swiper-slide">
                                    <div class="tp-project-item p-relative">
                                       <div class="tp-project-thumb">
                                          <a class="popup-image tp-product-popup-image" href="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'product_2_image' ) ); ?>" title="<?php echo esc_attr( $home_sections['product_2_title'] ); ?>" aria-label="<?php echo esc_attr( 'View ' . $home_sections['product_2_title'] . ' product image' ); ?>">
                                             <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'product_2_image' ) ); ?>" alt="<?php echo esc_attr( $home_sections['product_2_title'] ); ?>">
                                          </a>
                                       </div>
                                       <div class="tp-project-content">
                                          <a class="tp-project-read-more" href="<?php echo esc_url( $home_sections['product_2_url'] ); ?>"><span><?php echo esc_html( $home_sections['product_2_button_text'] ); ?></span><i class="flaticon-right-arrow"></i></a>
                                          <span><?php echo esc_html( $home_sections['product_2_subtitle'] ); ?></span>
                                          <h4 class="tp-project-title"><a href="<?php echo esc_url( $home_sections['product_2_url'] ); ?>"><?php echo esc_html( $home_sections['product_2_title'] ); ?></a></h4>
                                          <div><?php echo wp_kses_post( wpautop( $home_sections['product_2_description'] ) ); ?></div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="swiper-slide">
                                    <div class="tp-project-item p-relative">
                                       <div class="tp-project-thumb">
                                          <a class="popup-image tp-product-popup-image" href="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'product_3_image' ) ); ?>" title="<?php echo esc_attr( $home_sections['product_3_title'] ); ?>" aria-label="<?php echo esc_attr( 'View ' . $home_sections['product_3_title'] . ' product image' ); ?>">
                                             <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'product_3_image' ) ); ?>" alt="<?php echo esc_attr( $home_sections['product_3_title'] ); ?>">
                                          </a>
                                       </div>
                                       <div class="tp-project-content">
                                          <a class="tp-project-read-more" href="<?php echo esc_url( $home_sections['product_3_url'] ); ?>"><span><?php echo esc_html( $home_sections['product_3_button_text'] ); ?></span><i class="flaticon-right-arrow"></i></a>
                                          <span><?php echo esc_html( $home_sections['product_3_subtitle'] ); ?></span>
                                          <h4 class="tp-project-title"><a href="<?php echo esc_url( $home_sections['product_3_url'] ); ?>"><?php echo esc_html( $home_sections['product_3_title'] ); ?></a></h4>
                                          <div><?php echo wp_kses_post( wpautop( $home_sections['product_3_description'] ) ); ?></div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="swiper-slide">
                                    <div class="tp-project-item p-relative">
                                       <div class="tp-project-thumb">
                                          <a class="popup-image tp-product-popup-image" href="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'product_4_image' ) ); ?>" title="<?php echo esc_attr( $home_sections['product_4_title'] ); ?>" aria-label="<?php echo esc_attr( 'View ' . $home_sections['product_4_title'] . ' product image' ); ?>">
                                             <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'product_4_image' ) ); ?>" alt="<?php echo esc_attr( $home_sections['product_4_title'] ); ?>">
                                          </a>
                                       </div>
                                       <div class="tp-project-content">
                                          <a class="tp-project-read-more" href="<?php echo esc_url( $home_sections['product_4_url'] ); ?>"><span><?php echo esc_html( $home_sections['product_4_button_text'] ); ?></span><i class="flaticon-right-arrow"></i></a>
                                          <span><?php echo esc_html( $home_sections['product_4_subtitle'] ); ?></span>
                                          <h4 class="tp-project-title"><a href="<?php echo esc_url( $home_sections['product_4_url'] ); ?>"><?php echo esc_html( $home_sections['product_4_title'] ); ?></a></h4>
                                          <div><?php echo wp_kses_post( wpautop( $home_sections['product_4_description'] ) ); ?></div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="swiper-slide">
                                    <div class="tp-project-item p-relative">
                                       <div class="tp-project-thumb">
                                          <a class="popup-image tp-product-popup-image" href="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'product_5_image' ) ); ?>" title="<?php echo esc_attr( $home_sections['product_5_title'] ); ?>" aria-label="<?php echo esc_attr( 'View ' . $home_sections['product_5_title'] . ' product image' ); ?>">
                                             <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'product_5_image' ) ); ?>" alt="<?php echo esc_attr( $home_sections['product_5_title'] ); ?>">
                                          </a>
                                       </div>
                                       <div class="tp-project-content">
                                          <a class="tp-project-read-more" href="<?php echo esc_url( $home_sections['product_5_url'] ); ?>"><span><?php echo esc_html( $home_sections['product_5_button_text'] ); ?></span><i class="flaticon-right-arrow"></i></a>
                                          <span><?php echo esc_html( $home_sections['product_5_subtitle'] ); ?></span>
                                          <h4 class="tp-project-title"><a href="<?php echo esc_url( $home_sections['product_5_url'] ); ?>"><?php echo esc_html( $home_sections['product_5_title'] ); ?></a></h4>
                                          <div><?php echo wp_kses_post( wpautop( $home_sections['product_5_description'] ) ); ?></div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php endif; ?>
      <!-- project area end -->

      <!-- contact area start -->
      <?php if ( ! empty( $home_sections['contact_enabled'] ) ) : ?>
      <div class="tp-contact-area">
         <div class="tp-contact-bg p-relative jarallax pt-120" data-background="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'contact_background' ) ); ?>">
            <div class="tp-contact-shape-2 d-none d-xl-block">
               <img src="assets/img/contact/shape-1-2.png" alt="">
            </div>
            <div class="container">
               <div class="row">
                  <div class="col-xl-6 col-lg-6">
                     <div class="tp-contact-wrap z-index wow tpfadeLeft" data-wow-duration=".9s" data-wow-delay=".5s">
                        <div class="tp-contact-tab mb-50">
                           <ul class="nav nav-tab" id="myTab" role="tablist">
                              <li class="nav-items" role="presentation">
                                 <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                    aria-selected="true"><?php echo esc_html( $home_sections['contact_tab_1'] ); ?></button>
                              </li>
                              <li class="nav-items" role="presentation">
                                 <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                    aria-selected="false"><?php echo esc_html( $home_sections['contact_tab_2'] ); ?></button>
                              </li>
                              <li class="nav-items" role="presentation">
                                 <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                    data-bs-target="#contact" type="button" role="tab" aria-controls="contact"
                                    aria-selected="false"><?php echo esc_html( $home_sections['contact_tab_3'] ); ?></button>
                              </li>
                           </ul>
                        </div>
                        <div class="tp-contact-tab-content">
                           <div class="tab-content" id="myTabContent">
                              <div class="tab-pane fade show active" id="home" role="tabpanel"
                                 aria-labelledby="home-tab">
                                 <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5">
                                       <div class="tp-contact-tab-content-left p-relative">
                                          <div class="tp-contact-tab-content-thumb">
                                             <img class="w-100" src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'contact_vision_image' ) ); ?>" alt="">
                                          </div>
                                          <div class="tp-contact-tab-play-icon">
                                             <a class="popup-video"
                                                href="#"><i
                                                   class="flaticon-play-button"></i></a>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-7">
                                       <div class="tp-contact-tab-content-right">
                                          <h5 class="tp-contact-tab-content-title"><?php echo wp_kses_post( $home_sections['contact_vision_title'] ); ?></h5>
                                          <div class="tp-contact-tab-content-list">
                                             <ul>
                                                <li><i class="fa-light fa-badge-check"></i><?php echo esc_html( $home_sections['contact_vision_item_1'] ); ?></li>
                                                <li><i class="fa-light fa-badge-check"></i><?php echo esc_html( $home_sections['contact_vision_item_2'] ); ?></li>
                                                <li><i class="fa-light fa-badge-check"></i><?php echo esc_html( $home_sections['contact_vision_item_3'] ); ?></li>
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                 <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5">
                                       <div class="tp-contact-tab-content-left p-relative">
                                          <div class="tp-contact-tab-content-thumb">
                                             <img class="w-100" src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'contact_mission_image' ) ); ?>" alt="">
                                          </div>
                                          <div class="tp-contact-tab-play-icon">
                                             <a class="popup-video"
                                                href="#"><i
                                                   class="flaticon-play-button"></i></a>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-7">
                                       <div class="tp-contact-tab-content-right">
                                          <h5 class="tp-contact-tab-content-title"><?php echo wp_kses_post( $home_sections['contact_mission_title'] ); ?></h5>
                                          <div class="tp-contact-tab-content-list">
                                             <ul>
                                                <li><i class="fa-light fa-badge-check"></i><?php echo esc_html( $home_sections['contact_mission_item_1'] ); ?></li>
                                                <li><i class="fa-light fa-badge-check"></i><?php echo esc_html( $home_sections['contact_mission_item_2'] ); ?></li>
                                                <li><i class="fa-light fa-badge-check"></i><?php echo esc_html( $home_sections['contact_mission_item_3'] ); ?></li>
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                 <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5">
                                       <div class="tp-contact-tab-content-left p-relative">
                                          <div class="tp-contact-tab-content-thumb">
                                             <img class="w-100" src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'contact_values_image' ) ); ?>" alt="">
                                          </div>
                                          <div class="tp-contact-tab-play-icon">
                                             <a class="popup-video"
                                                href="#"><i
                                                   class="flaticon-play-button"></i></a>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-7">
                                       <div class="tp-contact-tab-content-right">
                                          <h5 class="tp-contact-tab-content-title"><?php echo wp_kses_post( $home_sections['contact_values_title'] ); ?></h5>
                                          <div class="tp-contact-tab-content-list">
                                             <ul>
                                                <li><i class="fa-light fa-badge-check"></i><?php echo esc_html( $home_sections['contact_values_item_1'] ); ?></li>
                                                <li><i class="fa-light fa-badge-check"></i><?php echo esc_html( $home_sections['contact_values_item_2'] ); ?></li>
                                                <li><i class="fa-light fa-badge-check"></i><?php echo esc_html( $home_sections['contact_values_item_3'] ); ?></li>
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-6 col-lg-6">
                     <div class="tp-contact-right-box p-relative z-index">
                        <div class="tp-contact-section-box mb-25">
                           <span class="tp-section-subtitle"><?php echo esc_html( $home_sections['contact_subtitle'] ); ?></span>
                           <h4 class="tp-section-title-2"><?php echo wp_kses_post( $home_sections['contact_title'] ); ?></h4>
                        </div>
                        <div class="tp-contact-text">
                           <div class="mb-35"><?php echo wp_kses_post( wpautop( $home_sections['contact_description'] ) ); ?></div>
                           <div class="tp-contact-right-tel-box">
                              <div class="tp-contact-right-tel-icon d-flex align-items-center">
                                 <i class="flaticon-phone-call"></i>
                                 <div class="tp-contact-right-tel-content">
                                    <span><?php echo esc_html( $home_sections['contact_phone_label'] ); ?></span>
                                    <a href="<?php echo esc_url( $home_sections['contact_phone_url'] ); ?>"><?php echo esc_html( $home_sections['contact_phone'] ); ?></a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tp-contact-shape-1">
                           <img src="assets/img/contact/shape-1-1.png" alt="">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php endif; ?>
      <!-- contact area end -->

      <!-- funfact area  start -->
      <?php if ( ! empty( $home_sections['stats_enabled'] ) ) : ?>
      <div class="tp-funfact-area fix p-relative grey-bg pt-180 pb-85">
         <div class="tp-funfact-shape-1">
            <img src="assets/img/funfact/shape-1-1.png" alt="">
         </div>
         <!-- <div class="tp-funfact-shape-2 d-none d-xl-block">
            <img src="assets/img/funfact/shape-1-2.png" alt="">
         </div> -->
         <div class="container">
            <div class="row">
               <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-30">
                  <div class="tp-funfact-item text-center">
                     <div class="tp-funfact-icon">
                        <span><i class="flaticon-solution"></i></span>
                     </div>
                     <div class="tp-funfact-content">
                        <h5 class="tp-funfact-number"><i class="purecounter" data-purecounter-duration="1"
                              data-purecounter-end="<?php echo esc_attr( $home_sections['stat_1_number'] ); ?>">0</i><?php echo esc_html( $home_sections['stat_1_suffix'] ); ?></h5>
                        <span><?php echo esc_html( $home_sections['stat_1_label'] ); ?></span>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-30">
                  <div class="tp-funfact-item text-center">
                     <div class="tp-funfact-icon">
                        <span><i class="flaticon-customer-service"></i></span>
                     </div>
                     <div class="tp-funfact-content">
                        <h5 class="tp-funfact-number"><i class="purecounter" data-purecounter-duration="1"
                              data-purecounter-end="<?php echo esc_attr( $home_sections['stat_2_number'] ); ?>">0</i><?php echo esc_html( $home_sections['stat_2_suffix'] ); ?></h5>
                        <span><?php echo esc_html( $home_sections['stat_2_label'] ); ?></span>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-30">
                  <div class="tp-funfact-item text-center">
                     <div class="tp-funfact-icon">
                        <span><i class="flaticon-customer-service-1"></i></span>
                     </div>
                     <div class="tp-funfact-content">
                        <h5 class="tp-funfact-number"><i class="purecounter" data-purecounter-duration="1"
                              data-purecounter-end="<?php echo esc_attr( $home_sections['stat_3_number'] ); ?>">0</i><?php echo esc_html( $home_sections['stat_3_suffix'] ); ?></h5>
                        <span><?php echo esc_html( $home_sections['stat_3_label'] ); ?></span>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-30">
                  <div class="tp-funfact-item text-center">
                     <div class="tp-funfact-icon">
                        <span><i class="flaticon-trophy"></i></span>
                     </div>
                     <div class="tp-funfact-content">
                        <h5 class="tp-funfact-number"><i class="purecounter" data-purecounter-duration="1"
                              data-purecounter-end="<?php echo esc_attr( $home_sections['stat_4_number'] ); ?>">0</i><?php echo esc_html( $home_sections['stat_4_suffix'] ); ?></h5>
                        <span><?php echo esc_html( $home_sections['stat_4_label'] ); ?></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php endif; ?>
      <!-- funfact area end -->

      <!-- team area start -->
      <?php if ( ! empty( $home_sections['team_enabled'] ) ) : ?>
      <div class="tp-team-area pt-120 pb-120">
         <div class="container">
            <div class="row">
               <div class="col-xl-12">
                  <div class="tp-team-section-box text-center mb-60">
                     <span class="tp-section-subtitle"><i class="flaticon-flash"></i><?php echo esc_html( $home_sections['team_subtitle'] ); ?></span>
                     <h4 class="tp-section-title"><?php echo wp_kses_post( $home_sections['team_title'] ); ?></h4>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                  <div class="tp-team-item text-center">
                     <div class="tp-team-thumb-box p-relative">
                        <div class="tp-team-thumb">
                           <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'team_1_image' ) ); ?>" alt="<?php echo esc_attr( $home_sections['team_1_name'] ); ?>">
                        </div>
                        <div class="tp-team-social-wrap">
                           <span><i class="fa-solid fa-share-nodes"></i></span>
                           <div class="tp-team-social-box">
                              <a href="<?php echo esc_url( $home_sections['team_1_facebook'] ); ?>"><i class="fa-brands fa-facebook-f"></i></a>
                              <a href="<?php echo esc_url( $home_sections['team_1_instagram'] ); ?>"><i class="fa-brands fa-instagram"></i></a>
                              <a href="<?php echo esc_url( $home_sections['team_1_linkedin'] ); ?>"><i class="fa-brands fa-linkedin-in"></i></a>
                           </div>
                        </div>
                     </div>
                     <div class="tp-team-content">
                        <h4 class="tp-team-title"><a href="#"><?php echo esc_html( $home_sections['team_1_name'] ); ?></a></h4>
                        <span><?php echo esc_html( $home_sections['team_1_role'] ); ?></span>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
                  <div class="tp-team-item text-center">
                     <div class="tp-team-thumb-box p-relative">
                        <div class="tp-team-thumb">
                           <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'team_2_image' ) ); ?>" alt="<?php echo esc_attr( $home_sections['team_2_name'] ); ?>">
                        </div>
                        <div class="tp-team-social-wrap">
                           <span><i class="fa-solid fa-share-nodes"></i></span>
                           <div class="tp-team-social-box">
                              <a href="<?php echo esc_url( $home_sections['team_2_facebook'] ); ?>"><i class="fa-brands fa-facebook-f"></i></a>
                              <a href="<?php echo esc_url( $home_sections['team_2_instagram'] ); ?>"><i class="fa-brands fa-instagram"></i></a>
                              <a href="<?php echo esc_url( $home_sections['team_2_linkedin'] ); ?>"><i class="fa-brands fa-linkedin-in"></i></a>
                           </div>
                        </div>
                     </div>
                     <div class="tp-team-content">
                        <h4 class="tp-team-title"><a href="#"><?php echo esc_html( $home_sections['team_2_name'] ); ?></a></h4>
                        <span><?php echo esc_html( $home_sections['team_2_role'] ); ?></span>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".7s">
                  <div class="tp-team-item text-center">
                     <div class="tp-team-thumb-box p-relative">
                        <div class="tp-team-thumb">
                           <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'team_3_image' ) ); ?>" alt="<?php echo esc_attr( $home_sections['team_3_name'] ); ?>">
                        </div>
                        <div class="tp-team-social-wrap">
                           <span><i class="fa-solid fa-share-nodes"></i></span>
                           <div class="tp-team-social-box">
                              <a href="<?php echo esc_url( $home_sections['team_3_facebook'] ); ?>"><i class="fa-brands fa-facebook-f"></i></a>
                              <a href="<?php echo esc_url( $home_sections['team_3_instagram'] ); ?>"><i class="fa-brands fa-instagram"></i></a>
                              <a href="<?php echo esc_url( $home_sections['team_3_linkedin'] ); ?>"><i class="fa-brands fa-linkedin-in"></i></a>
                           </div>
                        </div>
                     </div>
                     <div class="tp-team-content">
                        <h4 class="tp-team-title"><a href="#"><?php echo esc_html( $home_sections['team_3_name'] ); ?></a></h4>
                        <span><?php echo esc_html( $home_sections['team_3_role'] ); ?></span>
                     </div>
                  </div>
               </div>
               <div class="col-xl-12 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                  <div class="tp-team-text text-center">
                     <p><?php echo wp_kses_post( $home_sections['team_footer_text'] ); ?> <a href="<?php echo esc_url( $home_sections['team_footer_link_url'] ); ?>"><?php echo esc_html( $home_sections['team_footer_link_text'] ); ?></a></p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php endif; ?>
      <!-- team area end -->

      <!-- testimonial area start -->
      <?php if ( ! empty( $home_sections['testimonials_enabled'] ) ) : ?>
      <div class="tp-testimonial-area p-relative fix grey-bg pt-120 pb-120">
         <div class="tp-testimonial-shape-1">
            <img src="assets/img/testimonial/shape-1-1.png" alt="">
         </div>
         <div class="tp-testimonial-shape-2 d-none d-xl-block">
            <img src="assets/img/testimonial/shape-1-2.png" alt="">
         </div>
         <div class="container">
            <div class="row">
               <div class="col-xl-12">
                  <div class="tp-testimonial-section-box z-index text-center mb-60">
                     <span class="tp-section-subtitle"><i class="flaticon-flash"></i><?php echo esc_html( $home_sections['testimonials_subtitle'] ); ?></span>
                     <h4 class="tp-section-title"><?php echo wp_kses_post( $home_sections['testimonials_title'] ); ?></h4>
                  </div>
               </div>
               <div class="col-xl-12">
                  <div class="tp-testimonial-wrapper">
                     <div class="swiper-container tp-testimonial-active">
                        <div class="swiper-wrapper">
                           <div class="swiper-slide">
                              <div class="tp-testimonial-item z-index p-relative">
                                 <div class="tp-testimonial-thumb">
                                    <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'testimonial_1_image' ) ); ?>" alt="<?php echo esc_attr( $home_sections['testimonial_1_name'] ); ?>">
                                    <div class="tp-testimonial-thumb-quot">
                                       <span><i class="flaticon-quote"></i></span>
                                    </div>
                                 </div>
                                 <div class="tp-testimonial-text">
                                    <?php echo wp_kses_post( wpautop( $home_sections['testimonial_1_text'] ) ); ?>
                                 </div>
                                 <div
                                    class="tp-testimonial-author-box d-flex align-items-center justify-content-between">
                                    <div class="tp-testimonial-author-info">
                                       <h6 class="tp-testimonial-author-name"><?php echo esc_html( $home_sections['testimonial_1_name'] ); ?></h6>
                                       <span><?php echo esc_html( $home_sections['testimonial_1_role'] ); ?></span>
                                    </div>
                                    <div class="tp-testimonial-star d-none d-sm-block">
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                    </div>
                                 </div>
                                 <div class="tp-testimonial-shape-3">
                                    <img src="assets/img/testimonial/shape-1-3.png" alt="">
                                 </div>
                              </div>
                           </div>
                           <div class="swiper-slide">
                              <div class="tp-testimonial-item z-index p-relative">
                                 <div class="tp-testimonial-thumb">
                                    <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'testimonial_2_image' ) ); ?>" alt="<?php echo esc_attr( $home_sections['testimonial_2_name'] ); ?>">
                                    <div class="tp-testimonial-thumb-quot">
                                       <span><i class="flaticon-quote"></i></span>
                                    </div>
                                 </div>
                                 <div class="tp-testimonial-text">
                                    <?php echo wp_kses_post( wpautop( $home_sections['testimonial_2_text'] ) ); ?>
                                 </div>
                                 <div
                                    class="tp-testimonial-author-box d-flex align-items-center justify-content-between">
                                    <div class="tp-testimonial-author-info">
                                       <h6 class="tp-testimonial-author-name"><?php echo esc_html( $home_sections['testimonial_2_name'] ); ?></h6>
                                       <span><?php echo esc_html( $home_sections['testimonial_2_role'] ); ?></span>
                                    </div>
                                    <div class="tp-testimonial-star d-none d-sm-block">
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                    </div>
                                 </div>
                                 <div class="tp-testimonial-shape-3">
                                    <img src="assets/img/testimonial/shape-1-3.png" alt="">
                                 </div>
                              </div>
                           </div>
                           <div class="swiper-slide">
                              <div class="tp-testimonial-item z-index p-relative">
                                 <div class="tp-testimonial-thumb">
                                    <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'testimonial_3_image' ) ); ?>" alt="<?php echo esc_attr( $home_sections['testimonial_3_name'] ); ?>">
                                    <div class="tp-testimonial-thumb-quot">
                                       <span><i class="flaticon-quote"></i></span>
                                    </div>
                                 </div>
                                 <div class="tp-testimonial-text">
                                    <?php echo wp_kses_post( wpautop( $home_sections['testimonial_3_text'] ) ); ?>
                                 </div>
                                 <div
                                    class="tp-testimonial-author-box d-flex align-items-center justify-content-between">
                                    <div class="tp-testimonial-author-info">
                                       <h6 class="tp-testimonial-author-name"><?php echo esc_html( $home_sections['testimonial_3_name'] ); ?></h6>
                                       <span><?php echo esc_html( $home_sections['testimonial_3_role'] ); ?></span>
                                    </div>
                                    <div class="tp-testimonial-star d-none d-sm-block">
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                    </div>
                                 </div>
                                 <div class="tp-testimonial-shape-3">
                                    <img src="assets/img/testimonial/shape-1-3.png" alt="">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php endif; ?>
      <!-- testimonial area end -->

      <!-- blog area start -->
      <?php if ( ! empty( $home_sections['news_enabled'] ) ) : ?>
      <div class="tp-blog-area p-relative pt-120 pb-120">
         <div class="tp-blog-shape-1">
            <img src="assets/img/blog/shape-1-3.png" alt="">
         </div>
         <div class="container">
            <div class="row">
               <div class="col-xl-12">
                  <div class="tp-blog-section-box text-center mb-55">
                     <span class="tp-section-subtitle"><i class="flaticon-flash"></i><?php echo esc_html( $home_sections['news_subtitle'] ); ?></span>
                     <h4 class="tp-section-title"><?php echo wp_kses_post( $home_sections['news_title'] ); ?></h4>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                  <div class="tp-blog-item">
                     <div class="tp-blog-thumb-wrap p-relative">
                        <div class="tp-blog-thumb-box p-relative">
                           <div class="tp-blog-thumb-main z-index-3 fix">
                              <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'news_1_image' ) ); ?>" alt="<?php echo esc_attr( $home_sections['news_1_title'] ); ?>">
                           </div>
                           <div class="tp-blog-thumb-icon">
                              <a class="popup-image" href="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'news_1_image' ) ); ?>"><i
                                    class="fa-sharp fa-light fa-eye"></i></a>
                           </div>
                        </div>
                        <div class="tp-blog-thumb-shape-1">
                           <img src="assets/img/blog/shape-1-1.png" alt="">
                        </div>
                        <div class="tp-blog-thumb-shape-2">
                           <img src="assets/img/blog/shape-1-2.png" alt="">
                        </div>
                     </div>
                     <div class="tp-blog-content">
                        <div class="tp-blog-meta">
                           <span><i class="fa-light fa-circle-user"></i><?php echo esc_html( $home_sections['news_1_author'] ); ?></span>
                           <span><i class="flaticon-price-tag"></i><?php echo esc_html( $home_sections['news_1_category'] ); ?></span>
                        </div>
                        <h4 class="tp-blog-title"><a href="<?php echo esc_url( $home_sections['news_1_url'] ); ?>"><?php echo esc_html( $home_sections['news_1_title'] ); ?></a></h4>
                        <div class="tp-blog-link d-flex justify-content-between align-items-center">
                           <a href="<?php echo esc_url( $home_sections['news_1_url'] ); ?>"><?php echo esc_html( $home_sections['news_1_button_text'] ); ?></a>
                           <a href="<?php echo esc_url( $home_sections['news_1_url'] ); ?>"><i class="flaticon-right-arrow"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
                  <div class="tp-blog-item">
                     <div class="tp-blog-thumb-wrap p-relative">
                        <div class="tp-blog-thumb-box p-relative">
                           <div class="tp-blog-thumb-main z-index-3 fix">
                              <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'news_2_image' ) ); ?>" alt="<?php echo esc_attr( $home_sections['news_2_title'] ); ?>">
                           </div>
                           <div class="tp-blog-thumb-icon">
                              <a class="popup-image" href="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'news_2_image' ) ); ?>"><i
                                    class="fa-sharp fa-light fa-eye"></i></a>
                           </div>
                        </div>
                        <div class="tp-blog-thumb-shape-1">
                           <img src="assets/img/blog/shape-1-1.png" alt="">
                        </div>
                        <div class="tp-blog-thumb-shape-2">
                           <img src="assets/img/blog/shape-1-2.png" alt="">
                        </div>
                     </div>
                     <div class="tp-blog-content">
                        <div class="tp-blog-meta">
                           <span><i class="fa-light fa-circle-user"></i><?php echo esc_html( $home_sections['news_2_author'] ); ?></span>
                           <span><i class="flaticon-price-tag"></i><?php echo esc_html( $home_sections['news_2_category'] ); ?></span>
                        </div>
                        <h4 class="tp-blog-title"><a href="<?php echo esc_url( $home_sections['news_2_url'] ); ?>"><?php echo esc_html( $home_sections['news_2_title'] ); ?></a></h4>
                        <div class="tp-blog-link d-flex justify-content-between align-items-center">
                           <a href="<?php echo esc_url( $home_sections['news_2_url'] ); ?>"><?php echo esc_html( $home_sections['news_2_button_text'] ); ?></a>
                           <a href="<?php echo esc_url( $home_sections['news_2_url'] ); ?>"><i class="flaticon-right-arrow"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".7s">
                  <div class="tp-blog-item">
                     <div class="tp-blog-thumb-wrap p-relative">
                        <div class="tp-blog-thumb-box p-relative">
                           <div class="tp-blog-thumb-main z-index-3 fix">
                              <img src="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'news_3_image' ) ); ?>" alt="<?php echo esc_attr( $home_sections['news_3_title'] ); ?>">
                           </div>
                           <div class="tp-blog-thumb-icon">
                              <a class="popup-image" href="<?php echo esc_url( cosmotone_home_image_url( $home_sections, 'news_3_image' ) ); ?>"><i
                                    class="fa-sharp fa-light fa-eye"></i></a>
                           </div>
                        </div>
                        <div class="tp-blog-thumb-shape-1">
                           <img src="assets/img/blog/shape-1-1.png" alt="">
                        </div>
                        <div class="tp-blog-thumb-shape-2">
                           <img src="assets/img/blog/shape-1-2.png" alt="">
                        </div>
                     </div>
                     <div class="tp-blog-content">
                        <div class="tp-blog-meta">
                           <span><i class="fa-light fa-circle-user"></i><?php echo esc_html( $home_sections['news_3_author'] ); ?></span>
                           <span><i class="flaticon-price-tag"></i><?php echo esc_html( $home_sections['news_3_category'] ); ?></span>
                        </div>
                        <h4 class="tp-blog-title"><a href="<?php echo esc_url( $home_sections['news_3_url'] ); ?>"><?php echo esc_html( $home_sections['news_3_title'] ); ?></a></h4>
                        <div class="tp-blog-link d-flex justify-content-between align-items-center">
                           <a href="<?php echo esc_url( $home_sections['news_3_url'] ); ?>"><?php echo esc_html( $home_sections['news_3_button_text'] ); ?></a>
                           <a href="<?php echo esc_url( $home_sections['news_3_url'] ); ?>"><i class="flaticon-right-arrow"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php endif; ?>
      <!-- blog area end -->

      <!-- certificates area start -->
      <?php if ( ! empty( $home_sections['certificates_enabled'] ) ) : ?>
      <section class="tp-certificate-area tp-cta-wrap-box p-relative" aria-labelledby="certificate-title">
         <div class="container">
            <div class="tp-certificate-wrap">
               <div class="row align-items-center gy-4">
                  <div class="col-lg-4">
                     <div class="tp-certificate-badge">
                        <div class="tp-certificate-icon" aria-hidden="true">
                           <i class="fa-regular fa-shield-check"></i>
                        </div>
                        <div>
                           <span><?php echo esc_html( $home_sections['certificates_subtitle'] ); ?></span>
                           <h4 id="certificate-title"><?php echo wp_kses_post( $home_sections['certificates_title'] ); ?></h4>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-5">
                     <div class="tp-certificate-copy">
                        <?php echo wp_kses_post( wpautop( $home_sections['certificates_description'] ) ); ?>
                     </div>
                  </div>
                  <div class="col-lg-3">
                     <div class="tp-certificate-action">
                        <a href="<?php echo esc_url( $home_sections['certificates_button_url'] ); ?>" class="tp-certificate-btn"><?php echo esc_html( $home_sections['certificates_button_text'] ); ?> <i class="fa-regular fa-arrow-right-long"></i></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <?php endif; ?>
      <!-- certificates area end -->

   </main>
<?php get_footer(); ?>
