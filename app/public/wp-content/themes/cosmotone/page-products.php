<?php
/**
 * Template for the dynamic Products listing page.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;
get_header();
$products = cosmotone_get_products();
$terms    = get_terms( array( 'taxonomy' => 'cosmotone_product_category', 'hide_empty' => false ) );
$terms    = is_wp_error( $terms ) ? array() : $terms;
?>
<main>
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

			<div class="cosmotone-product-filters mb-50" id="cosmotone-product-filters">
				<div>
					<label for="cosmotone-filter-category">Category</label>
					<select id="cosmotone-filter-category">
						<option value="0">All categories</option>
						<?php foreach ( $terms as $term ) : if ( 0 !== (int) $term->parent ) continue; ?>
							<option value="<?php echo esc_attr( $term->term_id ); ?>"><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div>
					<label for="cosmotone-filter-subcategory">Subcategory</label>
					<select id="cosmotone-filter-subcategory" disabled>
						<option value="0">All subcategories</option>
						<?php foreach ( $terms as $term ) : if ( 1 !== count( get_ancestors( $term->term_id, 'cosmotone_product_category', 'taxonomy' ) ) ) continue; ?>
							<option value="<?php echo esc_attr( $term->term_id ); ?>" data-parent="<?php echo esc_attr( $term->parent ); ?>"><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div>
					<label for="cosmotone-filter-child">Child Category</label>
					<select id="cosmotone-filter-child" disabled>
						<option value="0">All child categories</option>
						<?php foreach ( $terms as $term ) : if ( 2 !== count( get_ancestors( $term->term_id, 'cosmotone_product_category', 'taxonomy' ) ) ) continue; ?>
							<option value="<?php echo esc_attr( $term->term_id ); ?>" data-parent="<?php echo esc_attr( $term->parent ); ?>"><?php echo esc_html( $term->name ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<button type="button" id="cosmotone-filter-reset">Reset</button>
			</div>

			<div class="row" id="cosmotone-product-grid">
				<?php if ( $products->have_posts() ) : ?>
					<?php $delay = 0.3; while ( $products->have_posts() ) : $products->the_post();
						$product_id  = get_the_ID();
						$term_ids    = wp_get_object_terms( $product_id, 'cosmotone_product_category', array( 'fields' => 'ids' ) );
						$term_ids    = is_wp_error( $term_ids ) ? array() : array_map( 'absint', $term_ids );
						$term_path   = cosmotone_product_category_path( $product_id );
						$term_label  = $term_path ? implode( ' / ', wp_list_pluck( $term_path, 'name' ) ) : 'Uncategorized';
						?>
						<div class="col-xl-4 col-lg-4 col-md-6 mb-30 wow tpfadeUp cosmotone-product-card" data-categories="<?php echo esc_attr( implode( ' ', $term_ids ) ); ?>" data-wow-duration=".9s" data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
							<div class="tp-project-item p-relative">
								<div class="tp-project-thumb"><a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( cosmotone_catalog_image_url( $product_id, 'large' ) ); ?>" alt="<?php the_title_attribute(); ?>"></a></div>
								<div class="tp-project-content">
									<a href="<?php the_permalink(); ?>"><i class="flaticon-right-arrow"></i></a>
									<span><?php echo esc_html( $term_label ); ?></span>
									<h4 class="tp-project-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								</div>
							</div>
						</div>
						<?php $delay += 0.2; endwhile; wp_reset_postdata(); ?>
					<div class="col-12 text-center cosmotone-filter-empty" style="display:none"><p>No products match the selected category mapping.</p></div>
				<?php else : ?>
					<div class="col-12 text-center"><p>No products have been published yet.</p></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php get_template_part( 'template-parts/cta' ); ?>
</main>
<style>
.cosmotone-product-filters{display:grid;grid-template-columns:repeat(3,minmax(0,1fr)) auto;gap:14px;align-items:end;padding:22px;background:#f5f5f5;border:1px solid #e5e5e5}.cosmotone-product-filters label{display:block;margin-bottom:6px;font-weight:600;color:#121212}.cosmotone-product-filters select{width:100%;height:48px;padding:0 14px;border:1px solid #d6d6d6;background:#fff}.cosmotone-product-filters button{height:48px;padding:0 24px;border:0;background:var(--tp-theme-1);color:#fff;font-weight:600}@media(max-width:991px){.cosmotone-product-filters{grid-template-columns:1fr 1fr}}@media(max-width:575px){.cosmotone-product-filters{grid-template-columns:1fr}}
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
	document.getElementById('cosmotone-filter-reset').addEventListener('click',function(){category.value='0';filterOptions(subcategory,0);filterOptions(child,0);apply();});
	filterOptions(subcategory,0);filterOptions(child,0);apply();
})();
</script>
<?php get_footer(); ?>
