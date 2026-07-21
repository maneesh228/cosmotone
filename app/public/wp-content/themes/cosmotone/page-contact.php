<?php
/** Template for the contact page. @package Cosmotone */
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
                        <h3 class="breadcrumb__title">Contact us</h3>
                     </div>
                     <div class="breadcrumb__list">
                        <span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
                        <span class="dvdr"><i>/</i></span>
                        <span>Contact us</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- breadcrumb area end -->

      <!-- contact area start -->
      <div class="tp-contact-3-area pt-120 pb-90">
         <div class="container">
            <div class="row">
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                  <div class="tp-contact-3-item text-center">
                     <div class="tp-contact-3-icon">
                        <span><img class="z-index" src="assets/img/contact/icon-1.png" alt=""></span>
                     </div>
                     <div class="tp-contact-3-text">
                        <h5 class="tp-contact-3-title">Visit our place</h5>
                        <a href="#">88 New South Head Rd, Triple <br>
                           New York</a>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
                  <div class="tp-contact-3-item text-center">
                     <div class="tp-contact-3-icon">
                        <span><img class="z-index" src="assets/img/contact/icon-2.png" alt=""></span>
                     </div>
                     <div class="tp-contact-3-text">
                        <h5 class="tp-contact-3-title">Contact us</h5>
                        <a href="mailto:biddut@website.com">biddut@website.com</a> <br>
                        <a href="tel:+60276247296">+(602) 762 472 96</a>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".7s">
                  <div class="tp-contact-3-item text-center">
                     <div class="tp-contact-3-icon">
                        <span><img class="z-index" src="assets/img/contact/icon-3.png" alt=""></span>
                     </div>
                     <div class="tp-contact-3-text">
                        <h5 class="tp-contact-3-title">Office time</h5>
                        <a href="#">Five days 8:00 am -  5:00 pm <br>
                           Firday is closed</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- contact area end -->

      <!-- form area start -->
      <div class="tp-contact-form-area pb-130">
         <div class="container">
            <div class="row">
               <div class="col-xl-12">
                  <div class="tp-contact-form-border">
                     <h4 class="tp-contact-form-title">Send your message</h4>
                     <form action="#">
                        <div class="row">
                           <div class="col-xl-6 col-lg-6 col-md-6 col-12 mb-20">
                              <div class="tp-contact-form-input-box">
                                 <input type="text" placeholder="Enter your name">
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg- col-md-6 col-12 mb-20">
                              <div class="tp-contact-form-input-box">
                                 <input type="text" placeholder="Enter your email">
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-12 mb-20">
                              <div class="tp-contact-form-input-box">
                                 <input type="text" placeholder="Your website">
                              </div>
                           </div>
                           <div class="col-xl-6 col-lg-6 col-md-6 col-12 mb-20">
                              <div class="tp-contact-form-input-box">
                                 <input type="text" placeholder="Your subject">
                              </div>
                           </div>
                           <div class="col-12 mb-20">
                              <div class="tp-contact-form-input-box">
                                 <textarea placeholder="Write your message"></textarea>
                              </div>
                           </div>
                        </div>
                     </form>
                     <button type="submit" class="tp-btn"><span>SEND message</span></button>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- form area end -->

      <!-- map area end -->
      <div class="tp-map-area">
         <div class="tp-map__item">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d146513.05509247648!2d73.19133525789097!3d54.98596156928781!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x43aafde2f601090b%3A0x5eefc33861a69b1a!2z4KaT4Kau4Ka44KeN4KaVLCBPbXNrIE9ibGFzdCwg4Kaw4Ka-4Ka24Ka_4Kav4Ka84Ka-!5e0!3m2!1sbn!2sbd!4v1689181288902!5m2!1sbn!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
      <!-- map area start -->


   </main>
<?php get_footer(); ?>
