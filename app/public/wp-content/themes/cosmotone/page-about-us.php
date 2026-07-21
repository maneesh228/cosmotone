<?php
/** Template for the about-us page. @package Cosmotone */
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
                        <h3 class="breadcrumb__title">About us</h3>
                     </div>
                     <div class="breadcrumb__list">
                        <span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
                        <span class="dvdr"><i>/</i></span>
                        <span>About us</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- breadcrumb area end -->

      <!-- about area start -->
      <div class="tp-about-area p-relative pt-120 pb-120">
         <div class="container">
            <div class="row">
               <div class="col-xl-6 col-lg-6 wow tpfadeLeft" data-wow-duration=".9s" data-wow-delay=".5s">
                  <div class="tp-about-right-box tp-about-right-wrap text-end p-relative">
                     <div class="tp-about-2-thumb-text text-start d-none d-lg-block" data-background="assets/img/about/bg-2.jpg">
                        <h6><i class="purecounter" data-purecounter-duration="1" data-purecounter-end="35">0</i>+</h6>
                        <span>Years of experience</span>
                     </div>
                     <div class="tp-about-main-thumb">
                        <img src="assets/img/about/thumb-3-2.jpg" alt="">
                     </div>
                     <div class="tp-about-thumb-sm">
                        <img src="assets/img/about/thumb-3-1.jpg" alt="">
                     </div>
                     <div class="tp-about-shape-2  d-none d-lg-block">
                        <img src="assets/img/about/shape-1-3.png" alt="">
                     </div>
                     <div class="tp-about-shape-6 d-none d-xl-block">
                        <img src="assets/img/about/shape-3-2.png" alt="">
                     </div>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".7s">
                  <div class="tp-about-left-box tp-about-ml">
                     <div class="tp-about-section-box mb-15">
                        <span class="tp-section-subtitle"><span>//</span> WE ARE BIDDUT ELECTRIC COMPANY</span>
                        <h4 class="tp-section-title">Produce your own clean save the environment</h4>
                     </div>
                     <div class="tp-about-text">
                        <p class="pb-15">Nullam eu nibh vitae est tempor molestie id sed ex. Quisque dignissim maximus ipsum, sed rutrum metus tincidunt et. Sed eget tincidunt
                           ipsum. Eget tincidunt</p>
                        <div class="tp-about-icon-wrap p-relative d-flex justify-content-between mb-40">
                           <div class="tp-about-icon-shape d-none d-xl-block">
                              <img src="assets/img/about/shape-1-6.png" alt="">
                           </div>
                           <div class="tp-about-icon-box d-flex align-items-center mb-20">
                              <div class="tp-about-icon icon-color">
                                 <span><i class="flaticon-electrician"></i></span>
                              </div>
                              <div class="tp-about-icon-text">
                                 <h5>Expert <br> electrician</h5>
                              </div>
                           </div>
                           <div class="tp-about-icon-box d-flex align-items-center mb-20">
                              <div class="tp-about-icon">
                                 <span><i class="flaticon-plug"></i></span>
                              </div>
                              <div class="tp-about-icon-text">
                                 <h5>Safety <br>assurance</h5>
                              </div>
                           </div>
                        </div>
                        <div class="tp-about-list mb-45">
                           <ul>
                              <li><i class="fa-light fa-badge-check"></i>At vero eos et accusamus et iusto odio.</li>
                              <li><i class="fa-light fa-badge-check"></i>Sed ut perspiciatis unde omnis iste natus sit. </li>
                              <li><i class="fa-light fa-badge-check"></i>Established fact that a reader will be distracted. </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- about area end -->

      <!-- contact area start -->
      <div class="tp-contact-area">
         <div class="tp-contact-bg p-relative jarallax pt-120" data-background="assets/img/contact/cosmotone-vision-bg.png">
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
                                    aria-selected="true">VISION</button>
                              </li>
                              <li class="nav-items" role="presentation">
                                 <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                    aria-selected="false">MISSION</button>
                              </li>
                              <li class="nav-items" role="presentation">
                                 <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                    data-bs-target="#contact" type="button" role="tab" aria-controls="contact"
                                    aria-selected="false">VALUES</button>
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
                                             <img class="w-100" src="assets/img/contact/contact1-1.jpg" alt="">
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
                                          <h5 class="tp-contact-tab-content-title">Shaping the Future of Automotive Components </h5>
                                          <div class="tp-contact-tab-content-list">
                                             <ul>
                                                <li><i class="fa-light fa-badge-check"></i>Product Design & Development </li>
                                                <li><i class="fa-light fa-badge-check"></i>Advanced Manufacturing</li>
                                                <li><i class="fa-light fa-badge-check"></i>Quality Assurance</li>
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
                                             <img class="w-100" src="assets/img/contact/contact1-2.jpg" alt="">
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
                                          <h5 class="tp-contact-tab-content-title">Future Electricity
                                             and Problem Solution</h5>
                                          <div class="tp-contact-tab-content-list">
                                             <ul>
                                                <li><i class="fa-light fa-badge-check"></i>Full-service electrical
                                                   layout </li>
                                                <li><i class="fa-light fa-badge-check"></i>AC instalation in one hour
                                                </li>
                                                <li><i class="fa-light fa-badge-check"></i>Wiring and installation</li>
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
                                             <img class="w-100" src="assets/img/contact/contact1-3.jpg" alt="">
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
                                          <h5 class="tp-contact-tab-content-title">Electricity can transform
                                             people's lives, not just living </h5>
                                          <div class="tp-contact-tab-content-list">
                                             <ul>
                                                <li><i class="fa-light fa-badge-check"></i>Full-service electrical
                                                   layout </li>
                                                <li><i class="fa-light fa-badge-check"></i>AC instalation in one hour
                                                </li>
                                                <li><i class="fa-light fa-badge-check"></i>Wiring and installation</li>
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
                           <span class="tp-section-subtitle">NEED HELP?</span>
                           <h4 class="tp-section-title-2">Have a question? <br>We're ready to help</h4>
                        </div>
                        <div class="tp-contact-text">
                           <p class="mb-35">Don’t hesitate to call us on any product related query, our team wait for
                              your call</p>
                           <div class="tp-contact-right-tel-box">
                              <div class="tp-contact-right-tel-icon d-flex align-items-center">
                                 <i class="flaticon-phone-call"></i>
                                 <div class="tp-contact-right-tel-content">
                                    <span>For emergency </span>
                                    <a href="#">+91 485 220 8431</a>
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
      <!-- contact area end -->

      <!-- funfact area  start -->
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
                              data-purecounter-end="820">0</i>+</h5>
                        <span>Succesfull Projects</span>
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
                              data-purecounter-end="9">0</i>M</h5>
                        <span>Satisfied Clients</span>
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
                              data-purecounter-end="45">0</i>+</h5>
                        <span>Experienced Staff</span>
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
                              data-purecounter-end="848">0</i>+</h5>
                        <span>Awards Winning</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- funfact area end -->

      <!-- team area start -->
      <div class="tp-team-area cosmotone-about-team pb-90">
         <div class="container">
            <div class="row">
               <div class="col-xl-12">
                  <div class="tp-team-section-box text-center mb-60">
                     <span class="tp-section-subtitle"><i class="flaticon-flash"></i>OUR EXPERT TEAM</span>
                     <h4 class="tp-section-title">Meet our experienced <br>team people</h4>
                  </div> 
               </div>
               <div class="col-12">
                  <div class="swiper cosmotone-about-team-slider">
                     <div class="swiper-wrapper">
               <div class="swiper-slide">
                  <div class="tp-team-item text-center">
                     <div class="tp-team-thumb-box p-relative">
                        <div class="tp-team-thumb">
                           <img src="assets/img/team/team-1-2.jpg" alt="">
                        </div>

                     </div>
                     <div class="tp-team-content">
                        <h4 class="tp-team-title"><a href="team-details.html">Alberta Infantino</a></h4>
                        <span>Electrician</span>
                     </div>
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="tp-team-item text-center">
                     <div class="tp-team-thumb-box p-relative">
                        <div class="tp-team-thumb">
                           <img src="assets/img/team/team-1-1.jpg" alt="">
                        </div>
                     </div>
                     <div class="tp-team-content">
                        <h4 class="tp-team-title"><a href="team-details.html">Jessica Robinson</a></h4>
                        <span>Architect</span>
                     </div>
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="tp-team-item text-center">
                     <div class="tp-team-thumb-box p-relative">
                        <div class="tp-team-thumb">
                           <img src="assets/img/team/team-1-3.jpg" alt="">
                        </div>
                       
                     </div>
                     <div class="tp-team-content">
                        <h4 class="tp-team-title"><a href="team-details.html">Tomaas Hirschi</a></h4>
                        <span>Support</span>
                     </div>
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="tp-team-item text-center">
                     <div class="tp-team-thumb-box p-relative">
                        <div class="tp-team-thumb"><img src="assets/img/team/team-1-4.jpg" alt="Belal Mahmud"></div>
                        
                     </div>
                     <div class="tp-team-content"><h4 class="tp-team-title"><a href="#">Belal Mahmud</a></h4><span>Architect</span></div>
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="tp-team-item text-center">
                     <div class="tp-team-thumb-box p-relative">
                        <div class="tp-team-thumb"><img src="assets/img/team/team-1-5.jpg" alt="Diane Lloyd"></div>
                        
                     </div>
                     <div class="tp-team-content"><h4 class="tp-team-title"><a href="#">Diane Lloyd</a></h4><span>Contractor</span></div>
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="tp-team-item text-center">
                     <div class="tp-team-thumb-box p-relative">
                        <div class="tp-team-thumb"><img src="assets/img/team/team-1-6.jpg" alt="Willie Boyd"></div>
                        
                     </div>
                     <div class="tp-team-content"><h4 class="tp-team-title"><a href="#">Willie Boyd</a></h4><span>Support</span></div>
                  </div>
               </div>
                     </div>
                     <div class="cosmotone-team-slider-controls">
                        <button class="cosmotone-team-prev" type="button" aria-label="Previous team member"><i class="fa-regular fa-arrow-left"></i></button>
                        <div class="cosmotone-team-pagination"></div>
                        <button class="cosmotone-team-next" type="button" aria-label="Next team member"><i class="fa-regular fa-arrow-right"></i></button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- team area end -->

</main>
<?php get_footer(); ?>
