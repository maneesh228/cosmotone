<?php
/**
 * Shared call-to-action displayed above the footer on non-home pages.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

// Some page templates include this component in addition to footer.php.
if ( ! empty( $GLOBALS['cosmotone_cta_rendered'] ) ) {
	return;
}

$GLOBALS['cosmotone_cta_rendered'] = true;

$cta_page_id = function_exists( 'cosmotone_get_cta_page_id' ) ? cosmotone_get_cta_page_id() : 0;
$cta_fields  = $cta_page_id ? get_post_meta( $cta_page_id, '_cosmotone_page_sections', true ) : array();
$cta_fields  = isset( $cta_fields['cta'] ) && is_array( $cta_fields['cta'] ) ? $cta_fields['cta'] : array();
$attributes  = isset( $cta_fields['attributes'] ) && is_array( $cta_fields['attributes'] ) ? $cta_fields['attributes'] : array();

$email_placeholder = ! empty( $attributes['email_placeholder'] ) ? $attributes['email_placeholder'] : 'Email address';
$success_message   = ! empty( $attributes['success_message'] ) ? $attributes['success_message'] : 'Thank you. Your email has been subscribed successfully.';
$duplicate_message = ! empty( $attributes['duplicate_message'] ) ? $attributes['duplicate_message'] : 'This email address is already subscribed.';
$invalid_message   = ! empty( $attributes['invalid_message'] ) ? $attributes['invalid_message'] : 'Please enter a valid email address.';
$status            = isset( $_GET['cta-status'] ) ? sanitize_key( wp_unslash( $_GET['cta-status'] ) ) : '';
$status_message    = '';
$status_class      = '';

if ( 'success' === $status ) {
	$status_message = $success_message;
	$status_class   = 'success';
} elseif ( 'exists' === $status ) {
	$status_message = $duplicate_message;
	$status_class   = 'info';
} elseif ( 'invalid' === $status ) {
	$status_message = $invalid_message;
	$status_class   = 'error';
}

ob_start();
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
               <form class="tp-cta-right-box p-relative" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
                  <input type="hidden" name="action" value="cosmotone_cta_subscribe">
                  <?php wp_nonce_field( 'cosmotone_cta_subscribe', 'cosmotone_cta_nonce' ); ?>
                  <label class="screen-reader-text" for="cosmotone-cta-email">Email address</label>
                  <input id="cosmotone-cta-email" name="email" type="email" placeholder="<?php echo esc_attr( $email_placeholder ); ?>" autocomplete="email" required>
                  <div class="tp-cta-button">
                     <button class="tp-btn white-bg" type="submit"><span>CHECK AVAILABILITY</span></button>
                  </div>
               </form>
               <?php if ( $status_message ) : ?>
                  <p class="cosmotone-cta-message cosmotone-cta-message--<?php echo esc_attr( $status_class ); ?>" role="status"><?php echo esc_html( $status_message ); ?></p>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- cta area end -->
<?php
$cta_markup = ob_get_clean();

if ( $cta_page_id && function_exists( 'cosmotone_apply_page_section_fields' ) ) {
	$cta_markup = cosmotone_apply_page_section_fields( $cta_markup, $cta_page_id, 'cta' );
}

echo $cta_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
