<?php
/**
 * Template for the dynamic Products listing page.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;
get_header();
$paged          = max( 1, absint( get_query_var( 'paged' ) ), absint( get_query_var( 'page' ) ) );
$product_search = isset( $_GET['product_search'] ) ? sanitize_text_field( wp_unslash( $_GET['product_search'] ) ) : '';
$products = new WP_Query(
	array(
		'post_type'      => 'cosmotone_product',
		'posts_per_page' => 25,
		'post_status'    => 'publish',
		'paged'          => $paged,
		's'              => $product_search,
		'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
		'order'          => 'ASC',
	)
);
$terms    = get_terms( array( 'taxonomy' => 'cosmotone_product_category', 'hide_empty' => false ) );
$terms    = is_wp_error( $terms ) ? array() : $terms;
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
							<h4 class="breadcrumb__subtitle">COSMOTONE PRODUCT RANGE</h4>
							<h3 class="breadcrumb__title">Products</h3>
						</div>
						<div class="breadcrumb__list">
							<span><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></span>
							<span class="dvdr"><i>/</i></span>
							<span>Products</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- breadcrumb area end -->

	<div class="tp-project-area p-relative pt-120 pb-90">
		<div class="tp-project-shape-1 d-none d-xl-block"><img src="assets/img/project/shape-1-1.png" alt=""></div>
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<div class="tp-project-section-box text-center mb-45">
						<span class="tp-section-subtitle">OUR PRODUCTS</span>
						<h4 class="tp-section-title">Explore the Cosmotone product range</h4>
					</div>
				</div>
			</div>

			<form class="cosmotone-product-filters mb-50" id="cosmotone-product-filters" action="<?php echo esc_url( get_permalink() ); ?>" method="get" role="search">
				<div>
					<label for="cosmotone-filter-category">Category</label>
					<select id="cosmotone-filter-category" class="cosmotone-native-select">
						<option value="0">All categories</option>
						<?php foreach ( $terms as $term ) : if ( 0 !== (int) $term->parent ) continue; ?>
							<option value="<?php echo esc_attr( $term->term_id ); ?>"><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div>
					<label for="cosmotone-filter-subcategory">Subcategory</label>
					<select id="cosmotone-filter-subcategory" class="cosmotone-native-select" disabled>
						<option value="0">All subcategories</option>
						<?php foreach ( $terms as $term ) : if ( 1 !== count( get_ancestors( $term->term_id, 'cosmotone_product_category', 'taxonomy' ) ) ) continue; ?>
							<option value="<?php echo esc_attr( $term->term_id ); ?>" data-parent="<?php echo esc_attr( $term->parent ); ?>"><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div>
					<label for="cosmotone-filter-child">Child Category</label>
					<select id="cosmotone-filter-child" class="cosmotone-native-select" disabled>
						<option value="0">All child categories</option>
						<?php foreach ( $terms as $term ) : if ( 2 !== count( get_ancestors( $term->term_id, 'cosmotone_product_category', 'taxonomy' ) ) ) continue; ?>
							<option value="<?php echo esc_attr( $term->term_id ); ?>" data-parent="<?php echo esc_attr( $term->parent ); ?>"><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div>
					<label for="cosmotone-filter-search">Search Products</label>
					<input id="cosmotone-filter-search" name="product_search" type="search" value="<?php echo esc_attr( $product_search ); ?>" placeholder="Enter product name" autocomplete="off">
				</div>
				<button type="submit" class="cosmotone-filter-submit">Search</button>
				<a class="cosmotone-filter-reset" href="<?php echo esc_url( get_permalink() ); ?>">Reset</a>
			</form>

			<div class="row" id="cosmotone-product-grid">
				<?php if ( $products->have_posts() ) : ?>
					<?php $delay = 0.3; while ( $products->have_posts() ) : $products->the_post();
						$product_id  = get_the_ID();
						$term_ids    = wp_get_object_terms( $product_id, 'cosmotone_product_category', array( 'fields' => 'ids' ) );
						$term_ids    = is_wp_error( $term_ids ) ? array() : array_map( 'absint', $term_ids );
						foreach ( $term_ids as $term_id ) {
							$term_ids = array_merge( $term_ids, get_ancestors( $term_id, 'cosmotone_product_category', 'taxonomy' ) );
						}
						$term_ids    = array_values( array_unique( array_map( 'absint', $term_ids ) ) );
						$term_path   = cosmotone_product_category_path( $product_id );
						$term_label  = $term_path ? implode( ' / ', wp_list_pluck( $term_path, 'name' ) ) : 'Uncategorized';
						$product_code = cosmotone_product_code( $product_id );
						?>
						<div class="col-xl-4 col-lg-4 col-md-6 mb-30 wow tpfadeUp cosmotone-product-card" data-categories="<?php echo esc_attr( implode( ' ', $term_ids ) ); ?>" data-wow-duration=".9s" data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
							<div class="tp-project-item p-relative">
								<div class="tp-project-thumb"><a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( cosmotone_catalog_image_url( $product_id, 'large' ) ); ?>" alt="<?php the_title_attribute(); ?>"></a></div>
								<div class="tp-project-content">
									<span><?php echo esc_html( $term_label ); ?></span>
									<h4 class="tp-project-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
									<?php if ( $product_code ) : ?>
										<div class="cosmotone-product-code"><?php esc_html_e( 'Product Code:', 'cosmotone' ); ?> <strong><?php echo esc_html( $product_code ); ?></strong></div>
									<?php endif; ?>
									<a class="cosmotone-listing-read-more" href="<?php the_permalink(); ?>">
										<span style="padding-top: 2px;"><?php esc_html_e( 'Read More', 'cosmotone' ); ?></span>
										<i class="flaticon-right-arrow" aria-hidden="true"></i>
									</a>
								</div>
							</div>
						</div>
						<?php $delay += 0.2; endwhile; wp_reset_postdata(); ?>
					<div class="col-12 text-center cosmotone-filter-empty" style="display:none"><p>No products match the selected category mapping.</p></div>
				<?php else : ?>
					<div class="col-12 text-center"><p><?php echo $product_search ? esc_html__( 'No products match your search.', 'cosmotone' ) : esc_html__( 'No products have been published yet.', 'cosmotone' ); ?></p></div>
				<?php endif; ?>
			</div>
			<?php if ( $products->max_num_pages > 1 ) : ?>
				<nav class="cosmotone-pagination" aria-label="<?php esc_attr_e( 'Products pagination', 'cosmotone' ); ?>">
					<?php
					echo wp_kses_post(
						paginate_links(
							array(
								'total'     => $products->max_num_pages,
								'current'   => $paged,
								'type'      => 'list',
								'prev_text' => '&larr;',
								'next_text' => '&rarr;',
								'add_args'  => $product_search ? array( 'product_search' => $product_search ) : false,
							)
						)
					);
					?>
				</nav>
			<?php endif; ?>
		</div>
	</div>
	<?php get_template_part( 'template-parts/cta' ); ?>
</main>
<style>
.cosmotone-product-filters{position:relative;z-index:20;display:grid;grid-template-columns:repeat(4,minmax(0,1fr)) auto auto;gap:14px;align-items:end;padding:24px;border:1px solid #dbe8f5;border-radius:8px;background:#f5f9fd;box-shadow:0 10px 30px rgba(7,92,229,.06)}
.cosmotone-product-filters>div{min-width:0}
.cosmotone-product-filters label{display:block;margin-bottom:8px;color:#102444;font-size:14px;font-weight:700}
.cosmotone-product-filters select{display:block;width:100%;height:48px;padding:0 42px 0 15px;border:1px solid #cbdced;border-radius:5px;color:#243a57;background:#fff;box-shadow:none;font-size:15px;line-height:46px;cursor:pointer;transition:border-color .2s ease,box-shadow .2s ease}
.cosmotone-product-filters select:hover,.cosmotone-product-filters select:focus{border-color:var(--tp-theme-1);outline:0;box-shadow:0 0 0 3px rgba(7,92,229,.1)}
.cosmotone-product-filters select:disabled{border-color:#e1e8ef;color:#91a0b1;background:#edf1f5;box-shadow:none;cursor:not-allowed;opacity:.85}
.cosmotone-product-filters input[type=search]{display:block;width:100%;height:48px;padding:0 15px;border:1px solid #cbdced;border-radius:5px;color:#243a57;background:#fff;box-shadow:none;font-size:15px;line-height:46px;transition:border-color .2s ease,box-shadow .2s ease}
.cosmotone-product-filters input[type=search]::placeholder{color:#91a0b1}
.cosmotone-product-filters input[type=search]:hover,.cosmotone-product-filters input[type=search]:focus{border-color:var(--tp-theme-1);outline:0;box-shadow:0 0 0 3px rgba(7,92,229,.1)}
.cosmotone-product-filters .nice-select{float:none;width:100%;height:48px;padding:0 42px 0 15px;border:1px solid #cbdced;border-radius:5px;color:#243a57;background:#fff;box-shadow:none;font-size:15px;line-height:46px}
.cosmotone-product-filters .nice-select:hover,.cosmotone-product-filters .nice-select:focus,.cosmotone-product-filters .nice-select.open{border-color:var(--tp-theme-1);box-shadow:0 0 0 3px rgba(7,92,229,.1)}
.cosmotone-product-filters .nice-select::after{right:16px;color:var(--tp-theme-1)}
.cosmotone-product-filters .nice-select .current{display:block;overflow:hidden;text-overflow:ellipsis}
.cosmotone-product-filters .nice-select .list{right:0;left:0;width:100%;max-height:280px;margin-top:7px;overflow-x:hidden;overflow-y:auto;border:1px solid #d7e5f2;border-radius:5px;box-shadow:0 14px 32px rgba(16,36,68,.15)}
.cosmotone-product-filters .nice-select .option{min-height:43px;padding:2px 15px;color:#243a57;line-height:39px;white-space:normal}
.cosmotone-product-filters .nice-select .option:hover,.cosmotone-product-filters .nice-select .option.focus,.cosmotone-product-filters .nice-select .option.selected{color:var(--tp-theme-1);background:#edf6ff}
.cosmotone-product-filters .nice-select .option.disabled{display:none}
.cosmotone-product-filters .nice-select.disabled{border-color:#e1e8ef;color:#91a0b1;background:#edf1f5;box-shadow:none;cursor:not-allowed;opacity:.85}
.cosmotone-product-filters button,.cosmotone-product-filters .cosmotone-filter-reset{display:inline-flex;height:48px;padding:0 22px;align-items:center;justify-content:center;border:0;border-radius:5px;color:#fff;background:var(--tp-theme-1);font-weight:700;line-height:1;transition:background .25s ease,transform .25s ease}
.cosmotone-product-filters button:hover{color:#fff;background:#043f9f;transform:translateY(-1px)}
.cosmotone-product-filters .cosmotone-filter-reset{color:#243a57;background:#e4edf6}
.cosmotone-product-filters .cosmotone-filter-reset:hover{color:#fff;background:#526b88;transform:translateY(-1px)}
.cosmotone-product-code{margin-top:8px;color:#5b6678;font-size:14px;line-height:1.4}.cosmotone-product-code strong{color:#102444;font-weight:700}
.cosmotone-product-card .tp-project-item{display:flex;height:100%;flex-direction:column;border:1px solid #dbe8f5!important;border-radius:10px!important;background:#fff!important;box-shadow:0 10px 28px rgba(16,36,68,.08)!important;transition:border-color .3s ease,box-shadow .3s ease,transform .3s ease}.cosmotone-product-card .tp-project-item:hover{border-color:#a9cef3!important;box-shadow:0 18px 38px rgba(7,92,229,.14)!important;transform:translateY(-5px)}.cosmotone-product-card .tp-project-thumb{border-radius:10px 10px 0 0!important}.cosmotone-product-card .tp-project-content{display:flex!important;flex:1;flex-direction:column;min-height:245px;padding:24px!important}.cosmotone-product-card .cosmotone-product-code{padding:9px 12px;border-left:3px solid var(--tp-theme-1);border-radius:3px;background:#f2f8ff}.cosmotone-product-card .cosmotone-listing-read-more{position:static!important;display:inline-flex!important;flex-wrap:nowrap!important;align-self:flex-end;width:auto!important;height:42px!important;margin:22px 0 0!important;padding:0 18px!important;align-items:center;justify-content:center;gap:9px;border:1px solid var(--tp-theme-1);border-radius:5px!important;color:var(--tp-theme-1)!important;background:#fff!important;font-size:14px!important;font-weight:700;line-height:1!important;white-space:nowrap!important;transition:color .25s ease,background .25s ease,transform .25s ease}.cosmotone-product-card .cosmotone-listing-read-more span{display:inline-block!important;flex:0 0 auto!important;width:auto!important;height:auto!important;overflow:visible!important;color:inherit!important;font-size:inherit!important;font-weight:inherit!important;line-height:1!important;white-space:nowrap!important;opacity:1!important;transform:none!important}.cosmotone-product-card .cosmotone-listing-read-more i{display:inline-flex!important;flex:0 0 auto!important;width:auto!important;height:auto!important;align-items:center;line-height:1!important;white-space:nowrap!important;transform:none!important}.cosmotone-product-card .cosmotone-listing-read-more:hover{color:#fff!important;background:var(--tp-theme-1)!important;transform:translateX(2px)}
.cosmotone-pagination{display:flex;justify-content:center;margin-top:30px}.cosmotone-pagination .page-numbers{display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin:0;padding:0;list-style:none}.cosmotone-pagination a,.cosmotone-pagination span{display:flex;min-width:44px;height:44px;padding:0 12px;align-items:center;justify-content:center;background:#f3f3f3;color:#121212;font-weight:600}.cosmotone-pagination .current,.cosmotone-pagination a:hover{background:var(--tp-theme-1);color:#fff}
@media(max-width:991px){.cosmotone-product-filters{grid-template-columns:1fr 1fr}.cosmotone-product-filters button,.cosmotone-product-filters .cosmotone-filter-reset{width:100%}}
@media(max-width:575px){.cosmotone-product-filters{grid-template-columns:1fr;padding:18px}}
</style>
<script>
(function(){
	var filters=document.getElementById('cosmotone-product-filters');if(!filters)return;
	var category=document.getElementById('cosmotone-filter-category'),subcategory=document.getElementById('cosmotone-filter-subcategory'),child=document.getElementById('cosmotone-filter-child'),cards=document.querySelectorAll('.cosmotone-product-card'),empty=document.querySelector('.cosmotone-filter-empty');
	function filterOptions(select,parent){select.value='0';var visible=0;Array.prototype.forEach.call(select.options,function(option,index){if(index===0)return;var show=String(option.dataset.parent)===String(parent);option.hidden=!show;option.disabled=!show;if(show)visible++;});select.disabled=!parent||!visible;}
	function apply(){var selected=[category.value,subcategory.value,child.value].filter(function(value){return value!=='0';}),shown=0;cards.forEach(function(card){var ids=card.dataset.categories.split(' '),show=selected.every(function(value){return ids.indexOf(value)!==-1;});card.style.display=show?'':'none';if(show)shown++;});if(empty)empty.style.display=shown?'none':'';}
	category.addEventListener('change',function(){filterOptions(subcategory,category.value);filterOptions(child,0);apply();});
	subcategory.addEventListener('change',function(){filterOptions(child,subcategory.value);apply();});
	child.addEventListener('change',apply);
	filterOptions(subcategory,0);filterOptions(child,0);apply();
})();
</script>
<?php
$markup = ob_get_clean();
echo cosmotone_apply_page_section_fields( $markup, get_queried_object_id(), 'products' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
get_footer();
?>
