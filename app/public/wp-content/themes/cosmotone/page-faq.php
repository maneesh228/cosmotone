<?php
/** Public FAQ page. @package Cosmotone */
defined( 'ABSPATH' ) || exit;
get_header();
$faqs = cosmotone_get_faqs();
ob_start();
?>
<main>
	<!-- breadcrumb area start -->
	<section class="breadcrumb__area breadcrumb__overlay breadcrumb__height p-relative fix" data-background="assets/img/breadcurmb/breadcurmb.jpg">
		<div class="container"><div class="breadcrumb__content z-index d-flex justify-content-between align-items-end">
			<div class="breadcrumb__section-title-box"><h4 class="breadcrumb__subtitle">HOW CAN WE HELP?</h4><h1 class="breadcrumb__title">FAQ</h1></div>
			<div class="breadcrumb__list"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span><span class="dvdr"><i>/</i></span><span>FAQ</span></div>
		</div></div>
	</section>
	<!-- breadcrumb area end -->
	<section class="cosmotone-faq-section" aria-labelledby="faq-heading">
		<div class="container">
			<div class="text-center mb-40"><span class="tp-section-subtitle"><?php esc_html_e( 'FAQ', 'cosmotone' ); ?></span><h2 class="tp-section-title" id="faq-heading"><?php esc_html_e( 'Frequently asked questions', 'cosmotone' ); ?></h2></div>
			<div class="cosmotone-faq-list">
				<?php if ( $faqs->have_posts() ) : ?>
					<?php while ( $faqs->have_posts() ) : $faqs->the_post(); ?>
						<details class="cosmotone-faq-item">
							<summary><?php echo esc_html( get_the_title() ); ?></summary>
							<div class="cosmotone-faq-answer"><?php echo wp_kses_post( wpautop( get_the_content() ) ); ?></div>
						</details>
					<?php endwhile; wp_reset_postdata(); ?>
				<?php else : ?>
					<p class="text-center"><?php esc_html_e( 'Have a question? Contact our team and we will be happy to help.', 'cosmotone' ); ?></p>
				<?php endif; ?>
			</div>
			<div class="text-center mt-40"><p><?php esc_html_e( 'Need more information?', 'cosmotone' ); ?></p><a class="tp-btn" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><span><?php esc_html_e( 'Contact us', 'cosmotone' ); ?></span></a></div>
		</div>
	</section>
</main>
<?php
$markup = ob_get_clean();
echo cosmotone_apply_page_section_fields( $markup, get_queried_object_id(), 'faq' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
get_footer();
