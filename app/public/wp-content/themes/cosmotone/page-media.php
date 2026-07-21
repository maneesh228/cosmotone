<?php
/** Media page adapted from the Oraxis reference. @package Cosmotone */
defined( 'ABSPATH' ) || exit;
get_header();
$media_images = array(
   array( 'assets/img/project/pro-1-1.jpg', 'Automotive Solutions' ),
   array( 'assets/img/project/pro-1-2.jpg', 'EV Relays' ),
   array( 'assets/img/project/pro-1-3.jpg', 'EV–EVSE Relays' ),
   array( 'assets/img/project/pro-1-4.jpg', 'Electrical Accessories' ),
   array( 'assets/img/project/pro-1-5.jpg', 'Sensors and Connectors' ),
   array( 'assets/img/about/thumb-1-1.jpg', 'Manufacturing Excellence' ),
);
?>
<main>
   <section class="breadcrumb__area breadcrumb__overlay breadcrumb__height p-relative fix" data-background="assets/img/breadcurmb/breadcurmb.jpg">
      <div class="container"><div class="row"><div class="col-12"><div class="breadcrumb__content z-index d-flex justify-content-between align-items-end">
         <div class="breadcrumb__section-title-box"><h4 class="breadcrumb__subtitle">OUR GALLERY</h4><h1 class="breadcrumb__title">Media</h1></div>
         <div class="breadcrumb__list"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span><span class="dvdr"><i>/</i></span><span>Media</span></div>
      </div></div></div></div>
   </section>
   <section class="cosmotone-resource-section">
      <div class="container">
         <div class="tp-team-section-box text-center mb-60"><span class="tp-section-subtitle"><i class="flaticon-flash"></i> OUR GALLERY</span><h2 class="tp-section-title">Inside Cosmotone</h2><p>Explore our products, facilities, people, and engineering work.</p></div>
         <div class="cosmotone-media-filter" role="group" aria-label="Filter media"><button class="active" type="button" data-media-filter="all">All</button><button type="button" data-media-filter="images">Images</button><button type="button" data-media-filter="videos">Videos</button></div>
         <div class="row g-4 cosmotone-media-group" data-media-group="images">
            <?php foreach ( $media_images as $image ) : ?>
               <div class="col-lg-4 col-md-6"><article class="cosmotone-media-card"><a class="popup-image" href="<?php echo esc_url( $image[0] ); ?>"><img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php echo esc_attr( $image[1] ); ?>"></a><h3><?php echo esc_html( $image[1] ); ?></h3></article></div>
            <?php endforeach; ?>
         </div>
         <div class="row g-4 cosmotone-media-group" data-media-group="videos">
            <div class="col-12"><div class="cosmotone-media-video"><video controls preload="metadata" poster="assets/img/hero/banner2.jpg"><source src="assets/video/automotive-wiring-harness.mp4" type="video/mp4"></video></div></div>
         </div>
      </div>
   </section>
</main>
<script>
document.addEventListener('DOMContentLoaded', function () {
   var buttons = document.querySelectorAll('[data-media-filter]');
   var groups = document.querySelectorAll('[data-media-group]');
   buttons.forEach(function (button) {
      button.addEventListener('click', function () {
         var filter = button.getAttribute('data-media-filter');
         buttons.forEach(function (item) { item.classList.remove('active'); });
         button.classList.add('active');
         groups.forEach(function (group) { group.hidden = filter !== 'all' && group.getAttribute('data-media-group') !== filter; });
      });
   });
});
</script>
<?php get_footer(); ?>
