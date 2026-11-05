   <?php
   if ( ! is_front_page() ) {
      get_template_part( 'template-parts/cta' );
   }
   $footer_page        = get_page_by_path( 'footer', OBJECT, 'page' );
   $footer_settings_id = $footer_page instanceof WP_Post ? $footer_page->ID : 0;
   ob_start();
   ?>

   <footer>

      <!-- footer area start -->
      <div class="tp-footer-area tp-footer-space p-relative z-index-3 black-bg">
         <!-- <div class="tp-footer-shape-1 d-none d-lg-block">
            <img src="assets/img/footer/shape-1-1.png" alt="">
         </div> -->
         <div class="tp-footer-shape-2 d-none d-lg-block">
            <img src="assets/img/footer/shape-1-2.png" alt="">
         </div>
         <div class="container">
            <div class="row">
               <!-- footer-about area start -->
               <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-25 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                  <div class="tp-footer-widget footer-cols-1">
                     <div class="tp-footer-logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="assets/img/logo/white-logo.png" alt=""></a>
                     </div>
                     <div class="tp-footer-text">
                        <p>Cosmotone Conductors Pvt. Ltd. is a leading manufacturer of Auto Electric Wires, Wiring Harnesses, Relays, and Automotive Electrical Components.</p>
                     </div>
                  </div>
               </div>
               <!-- footer-about area end -->
               <!-- footer-links area start -->
               <div class="col-xl-2 col-lg-4 col-md-6 col-sm-6 mb-50 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
                  <div class="tp-footer-widget footer-cols-2">
                     <h4 class="tp-footer-title">Useful Links</h4>
                     <div class="tp-footer-list">
                        <ul>
                           <li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>"><i class="fa-sharp fa-solid fa-plus"></i>About Cosmotone</a></li>
                           <li><a href="<?php echo esc_url( home_url( '/career/' ) ); ?>"><i class="fa-sharp fa-solid fa-plus"></i>Careers</a></li>
                           <li><a href="<?php echo esc_url( home_url( '/products/' ) ); ?>"><i class="fa-sharp fa-solid fa-plus"></i>Our Products</a></li>
                           <li><a href="<?php echo esc_url( home_url( '/media/' ) ); ?>"><i class="fa-sharp fa-solid fa-plus"></i>Media</a></li>
                           <li><a href="<?php echo esc_url( home_url( '/downloads/' ) ); ?>"><i class="fa-sharp fa-solid fa-plus"></i>Downloads</a></li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-50 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".7s">
                  <div class="tp-footer-widget footer-cols-3">
                     <h4 class="tp-footer-title">Services</h4>
                     <div class="tp-footer-list">
                        <ul>
                           <li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><i class="fa-sharp fa-solid fa-plus"></i>Air Conditioning</a></li>
                           <li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><i class="fa-sharp fa-solid fa-plus"></i>Electrical Panels</a></li>
                           <li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><i class="fa-sharp fa-solid fa-plus"></i>Security System</a></li>
                           <li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><i class="fa-sharp fa-solid fa-plus"></i>Indoor Lighting</a></li>
                           <li><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><i class="fa-sharp fa-solid fa-plus"></i>Electrical Services</a></li>
                        </ul>
                     </div>
                  </div>
               </div>
               <!-- footer-links area end -->
               <!-- footer-contact area start -->
               <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-50 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".9s">
                  <div class="tp-footer-widget footer-cols-4">
                     <h4 class="tp-footer-title">Contact Us</h4>
                     <div class="tp-footer-contact">
                        <a href="mailto:info@cosmotone.com"><i
                              class="flaticon-mail-1"></i>info@cosmotone.com</a>
                        <a href="#"><i class="flaticon-location-1"></i>Amballoor Mahadeva Temple Rd<br>Valakom, Ernakulam Dist.<br>Kerala</a>
                     </div>
                  </div>
               </div>
               <!-- footer-contact area end -->
            </div>
         </div>
      </div>
      <!-- footer area end -->

      <!-- copyright area start -->
      <div class="tp-copyright-area tp-copyright-space black-bg-2">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                  <div class="tp-copyright-left text-center text-md-start">
                     <p>© 2026 Cosmotone. All rights reserved.</p>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
                  <div class="tp-copyright-social text-center text-md-end">
                     <a target="_blank" href="#"><i class="fa-brands fa-facebook-f"></i></a>
                     <a target="_blank" href="#"><i class="fa-brands fa-instagram"></i></a>
                     <a target="_blank" href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                     <a target="_blank" href="#"><i class="fa-brands fa-youtube"></i></a>
                     <a href="https://wa.me/919554481761" target="_blank" rel="noopener noreferrer" aria-label="Chat with Cosmotone on WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- copyright area end -->

   </footer>

   <?php
   $footer_markup = ob_get_clean();
   $footer_markup = $footer_settings_id ? cosmotone_apply_page_section_fields( $footer_markup, $footer_settings_id, 'footer' ) : $footer_markup;
   echo cosmotone_optimize_markup_images( $footer_markup, '', '150px' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
   ?>


   <!-- JS here -->
   <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/vendor/jquery.js"></script>
   <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/vendor/waypoints.js"></script>
   <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/bootstrap-bundle.js"></script>
   <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/swiper-bundle.js"></script>
   <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/slick.js"></script>
   <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/magnific-popup.js"></script>
   <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/nice-select.js"></script>
   <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/purecounter.js"></script>
   <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/wow.js"></script>
   <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/isotope-pkgd.js"></script>
   <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/jarallax.js"></script>
   <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/imagesloaded-pkgd.js"></script>
   <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/ajax-form.js"></script>
   <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/main.js?v=abs-urls-1"></script>
   <?php wp_footer(); ?>

   
</body>

</html>
