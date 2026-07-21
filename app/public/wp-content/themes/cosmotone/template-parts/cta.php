<?php
/**
 * Shared call-to-action displayed above the footer on non-home pages.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- cta area start -->
<section class="tp-cta-area tp-cta-wrap-box fix p-relative" aria-labelledby="cosmotone-cta-title">
   <div class="tp-cta-shape d-none d-lg-block">
      <img src="assets/img/cta/shape-1-1.png" alt="">
   </div>
   <div class="container">
      <div class="tp-cta-wrap theme-bg">
         <div class="row">
            <div class="col-xl-6 col-lg-6">
               <div class="tp-cta-left-box">
                  <h2 id="cosmotone-cta-title" class="tp-cta-title">Dedicated to bring the world powerful energy solutions</h2>
               </div>
            </div>
            <div class="col-xl-6 col-lg-6">
               <form class="tp-cta-right-box p-relative" action="#" method="post">
                  <label class="screen-reader-text" for="cosmotone-cta-email">Email address</label>
                  <input id="cosmotone-cta-email" name="email" type="email" placeholder="Email address" required>
                  <div class="tp-cta-button">
                     <button class="tp-btn white-bg" type="submit"><span>CHECK AVAILABILITY</span></button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- cta area end -->
