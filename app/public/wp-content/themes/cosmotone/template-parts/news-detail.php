<?php
/**
 * Shared standard-post detail markup.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;

$post_id    = get_the_ID();
$image      = get_the_post_thumbnail_url( $post_id, 'full' );
$image      = $image ? $image : get_template_directory_uri() . '/assets/img/blog/blog-details-1-1.jpg';
$categories = get_the_category( $post_id );
$recent     = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'post__not_in'        => array( $post_id ),
		'ignore_sticky_posts' => true,
	)
);
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
							<h3 class="breadcrumb__title">Blog details</h3>
						</div>
						<div class="breadcrumb__list">
							<span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
							<span class="dvdr"><i>/</i></span>
							<span>Blog details</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- breadcrumb area end -->

	<section class="postbox__area pt-120 pb-70">
		<div class="container">
			<div class="row">
				<div class="col-xxl-8 col-xl-8 col-lg-8 mb-50">
					<article class="postbox__item format-image transition-3">
						<div class="postbox__thumb p-relative m-img">
							<div class="postbox__thumb-text-2 d-none d-md-block"><span><?php echo esc_html( get_the_date( 'd M' ) ); ?></span></div>
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php the_title_attribute(); ?>">
						</div>
						<div class="postbox__content mb-50">
							<div class="postbox__meta-box pb-5">
								<div class="postbox__meta">
									<span><i class="fa-light fa-user"></i><?php echo esc_html( sprintf( __( 'By %s', 'cosmotone' ), get_the_author() ) ); ?></span>
									<?php if ( $categories ) : ?>
										<span><i class="fa-light fa-tag tag"></i><?php echo esc_html( $categories[0]->name ); ?></span>
									<?php endif; ?>
									<span><i class="fa-sharp fa-light fa-comments"></i><?php echo esc_html( get_comments_number_text( __( 'No Comments', 'cosmotone' ), __( '1 Comment', 'cosmotone' ), __( '% Comments', 'cosmotone' ), $post_id ) ); ?></span>
								</div>
							</div>
							<h1 class="postbox__title pb-10"><?php the_title(); ?></h1>
							<div class="postbox__text cosmotone-news-content">
								<?php the_content(); ?>
							</div>
							<?php if ( has_tag() ) : ?>
								<div class="postbox__details-tag tagcloud mt-40">
									<span><?php esc_html_e( 'Tags:', 'cosmotone' ); ?></span>
									<?php the_tags( '', ' ', '' ); ?>
								</div>
							<?php endif; ?>
						</div>
					</article>
					<?php
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>
				</div>

				<div class="col-xxl-4 col-xl-4 col-lg-4 mb-50">
					<aside class="sidebar__wrapper">
						<div class="sidebar__widget sidebar__widget-theme-bg mb-30">
							<div class="sidebar__widget-content">
								<div class="sidebar__search">
									<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
										<div class="sidebar__search-input-2">
											<input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search news', 'cosmotone' ); ?>">
											<button type="submit"><i class="far fa-search"></i></button>
										</div>
									</form>
								</div>
							</div>
						</div>

						<?php if ( $recent->have_posts() ) : ?>
							<div class="sidebar__widget mb-30">
								<h3 class="sidebar__widget-title"><?php esc_html_e( 'Latest News', 'cosmotone' ); ?></h3>
								<div class="sidebar__widget-content"><div class="sidebar__post">
									<?php while ( $recent->have_posts() ) : $recent->the_post(); ?>
										<div class="rc__post mb-25 d-flex align-items-center">
											<div class="rc__post-thumb mr-20">
												<a href="<?php the_permalink(); ?>">
													<?php if ( has_post_thumbnail() ) : ?>
														<?php the_post_thumbnail( 'thumbnail' ); ?>
													<?php else : ?>
														<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/blog/blog-details-sm-1-2.jpg' ); ?>" alt="">
													<?php endif; ?>
												</a>
											</div>
											<div class="rc__post-content">
												<div class="rc__meta"><span><i class="fa-light fa-clock"></i><?php echo esc_html( get_the_date() ); ?></span></div>
												<h3 class="rc__post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											</div>
										</div>
									<?php endwhile; ?>
									<?php wp_reset_postdata(); ?>
								</div></div>
							</div>
						<?php endif; ?>

						<div class="sidebar__widget mb-30">
							<h3 class="sidebar__widget-title"><?php esc_html_e( 'Categories', 'cosmotone' ); ?></h3>
							<div class="sidebar__widget-content">
								<ul><?php wp_list_categories( array( 'title_li' => '', 'show_count' => true ) ); ?></ul>
							</div>
						</div>

						<div class="sidebar__widget mb-30">
							<h3 class="sidebar__widget-title"><?php esc_html_e( 'Tags', 'cosmotone' ); ?></h3>
							<div class="sidebar__widget-content"><div class="tagcloud"><?php wp_tag_cloud( array( 'smallest' => 14, 'largest' => 14, 'unit' => 'px' ) ); ?></div></div>
						</div>
					</aside>
				</div>
			</div>
		</div>
	</section>
</main>
