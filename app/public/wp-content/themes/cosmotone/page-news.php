<?php
/**
 * Template for the News listing page.
 *
 * News entries are standard WordPress Posts and are managed from Posts in wp-admin.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

get_header();

$paged = max( 1, absint( get_query_var( 'paged' ) ), absint( get_query_var( 'page' ) ) );
$news  = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 9,
		'paged'               => $paged,
		'ignore_sticky_posts' => true,
	)
);

ob_start();
?>
<main>
	<!-- breadcrumb area start -->
	<div class="breadcrumb__area breadcrumb__overlay breadcrumb__height p-relative fix" data-background="assets/img/breadcurmb/breadcurmb.jpg">
		<div class="container">
			<div class="row">
				<div class="col-xxl-12">
					<div class="breadcrumb__content z-index d-flex justify-content-between align-items-end">
						<div class="breadcrumb__section-title-box">
							<h4 class="breadcrumb__subtitle">NEWS &amp; ARTICLES</h4>
							<h3 class="breadcrumb__title">Our blog</h3>
						</div>
						<div class="breadcrumb__list">
							<span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
							<span class="dvdr"><i>/</i></span>
							<span>Our blog</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- breadcrumb area end -->

	<div class="tp-blog-3-area pt-120 pb-90">
		<div class="container">
			<div class="row">
				<?php if ( $news->have_posts() ) : ?>
					<?php
					$delay = 0.3;
					while ( $news->have_posts() ) :
						$news->the_post();
						$categories = get_the_category();
						$category   = $categories ? $categories[0]->name : __( 'News', 'cosmotone' );
						$image      = get_the_post_thumbnail_url( get_the_ID(), 'large' );
						$image      = $image ? $image : get_template_directory_uri() . '/assets/img/blog/blog-3-1.jpg';
						?>
						<div class="col-xl-4 col-lg-4 col-md-6 mb-30 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
							<article class="tp-blog-3-item">
								<div class="tp-blog-3-thumb p-relative">
									<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $image ); ?>" alt="<?php the_title_attribute(); ?>"></a>
									<div class="tp-blog-3-icon"><a href="<?php the_permalink(); ?>"><i class="flaticon-right-arrow"></i></a></div>
								</div>
								<div class="tp-blog-3-content text-center z-index">
									<div class="tp-blog-meta pb-10">
										<span><i class="fa-light fa-circle-user"></i><?php echo esc_html( sprintf( __( 'By %s', 'cosmotone' ), get_the_author() ) ); ?></span>
										<span><i class="flaticon-price-tag"></i><?php echo esc_html( $category ); ?></span>
									</div>
									<h4 class="tp-blog-3-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								</div>
							</article>
						</div>
						<?php
						$delay = min( 1.2, $delay + 0.2 );
					endwhile;
					?>
				<?php else : ?>
					<div class="col-12 text-center"><p><?php esc_html_e( 'No news has been published yet.', 'cosmotone' ); ?></p></div>
				<?php endif; ?>
			</div>

			<?php if ( $news->max_num_pages > 1 ) : ?>
				<nav class="cosmotone-pagination" aria-label="<?php esc_attr_e( 'News pagination', 'cosmotone' ); ?>">
					<?php
					echo wp_kses_post(
						paginate_links(
							array(
								'total'     => $news->max_num_pages,
								'current'   => $paged,
								'type'      => 'list',
								'prev_text' => '&larr;',
								'next_text' => '&rarr;',
							)
						)
					);
					?>
				</nav>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
</main>
<style>
.cosmotone-pagination{display:flex;justify-content:center;margin-top:20px}.cosmotone-pagination .page-numbers{display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin:0;padding:0;list-style:none}.cosmotone-pagination a,.cosmotone-pagination span{display:flex;min-width:44px;height:44px;padding:0 12px;align-items:center;justify-content:center;background:#f3f3f3;color:#121212;font-weight:600}.cosmotone-pagination .current,.cosmotone-pagination a:hover{background:var(--tp-theme-1);color:#fff}
</style>
<?php
$markup = ob_get_clean();
echo cosmotone_apply_page_section_fields( $markup, get_queried_object_id(), 'news' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
get_footer();
