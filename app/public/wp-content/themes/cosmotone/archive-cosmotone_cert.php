<?php
/**
 * Certificates archive.
 *
 * @package Cosmotone
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main>
	<div class="breadcrumb__area breadcrumb__overlay breadcrumb__height p-relative fix" data-background="assets/img/breadcurmb/breadcurmb.jpg">
		<div class="container">
			<div class="breadcrumb__content z-index d-flex justify-content-between align-items-end">
				<div class="breadcrumb__section-title-box">
					<h4 class="breadcrumb__subtitle"><?php esc_html_e( 'QUALITY YOU CAN TRUST', 'cosmotone' ); ?></h4>
					<h1 class="breadcrumb__title"><?php esc_html_e( 'Certificates', 'cosmotone' ); ?></h1>
				</div>
				<div class="breadcrumb__list">
					<span><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'cosmotone' ); ?></a></span>
					<span class="dvdr"><i>/</i></span>
					<span><?php esc_html_e( 'Certificates', 'cosmotone' ); ?></span>
				</div>
			</div>
		</div>
	</div>

	<section class="cosmotone-certificates-area pt-120 pb-120">
		<div class="container">
			<div class="tp-project-section-box text-center mb-60">
				<span class="tp-section-subtitle"><?php esc_html_e( 'OUR ACCREDITATIONS', 'cosmotone' ); ?></span>
				<h2 class="tp-section-title"><?php esc_html_e( 'Company Certificates', 'cosmotone' ); ?></h2>
			</div>
			<div class="row">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php
						$certificate_id = get_the_ID();
						$attachment_id  = cosmotone_certificate_attachment_id( $certificate_id );
						$file_url       = $attachment_id ? wp_get_attachment_url( $attachment_id ) : '';
						$mime_type      = $attachment_id ? (string) get_post_mime_type( $attachment_id ) : '';
						$is_pdf         = 'application/pdf' === $mime_type;
						$preview_url    = ! $is_pdf && $attachment_id ? wp_get_attachment_image_url( $attachment_id, 'large' ) : '';
						?>
						<div class="col-xl-4 col-lg-4 col-md-6 mb-30">
							<article class="cosmotone-certificate-card">
								<button class="cosmotone-certificate-open" type="button" data-url="<?php echo esc_url( $file_url ); ?>" data-type="<?php echo $is_pdf ? 'pdf' : 'image'; ?>" data-title="<?php the_title_attribute(); ?>" <?php disabled( ! $file_url ); ?>>
									<div class="cosmotone-certificate-preview">
										<?php if ( $preview_url ) : ?>
											<img src="<?php echo esc_url( $preview_url ); ?>" alt="<?php the_title_attribute(); ?>">
										<?php elseif ( $is_pdf ) : ?>
											<span class="cosmotone-certificate-pdf"><i class="fa-regular fa-file-pdf"></i><small><?php esc_html_e( 'PDF', 'cosmotone' ); ?></small></span>
										<?php else : ?>
											<span class="cosmotone-certificate-pdf"><i class="fa-regular fa-award"></i></span>
										<?php endif; ?>
										<span class="cosmotone-certificate-view"><i class="fa-regular fa-magnifying-glass-plus"></i> <?php esc_html_e( 'View Certificate', 'cosmotone' ); ?></span>
									</div>
									<h2><?php the_title(); ?></h2>
								</button>
							</article>
						</div>
					<?php endwhile; ?>
				<?php else : ?>
					<div class="col-12 text-center"><p><?php esc_html_e( 'No certificates have been published yet.', 'cosmotone' ); ?></p></div>
				<?php endif; ?>
			</div>
			<?php the_posts_pagination(); ?>
		</div>
	</section>
</main>

<div class="cosmotone-certificate-modal" id="cosmotone-certificate-modal" hidden>
	<div class="cosmotone-certificate-modal-backdrop" data-certificate-close></div>
	<div class="cosmotone-certificate-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="cosmotone-certificate-modal-title">
		<div class="cosmotone-certificate-modal-header">
			<h2 id="cosmotone-certificate-modal-title"></h2>
			<button type="button" data-certificate-close aria-label="<?php esc_attr_e( 'Close certificate', 'cosmotone' ); ?>"><i class="fa-regular fa-xmark"></i></button>
		</div>
		<div class="cosmotone-certificate-modal-content"></div>
	</div>
</div>

<style>
.cosmotone-certificates-area{background:#f6f9fd}.cosmotone-certificate-card{height:100%;overflow:hidden;border:1px solid #dce8f4;border-radius:10px;background:#fff;box-shadow:0 10px 28px rgba(16,36,68,.08);transition:transform .3s ease,box-shadow .3s ease}.cosmotone-certificate-card:hover{transform:translateY(-5px);box-shadow:0 18px 38px rgba(7,92,229,.14)}.cosmotone-certificate-open{display:block;width:100%;padding:0;border:0;background:none;text-align:left;cursor:pointer}.cosmotone-certificate-open:disabled{cursor:default}.cosmotone-certificate-preview{position:relative;display:flex;height:310px;align-items:center;justify-content:center;overflow:hidden;background:#eef5fc}.cosmotone-certificate-preview>img{width:100%;height:100%;padding:18px;object-fit:contain;transition:transform .35s ease}.cosmotone-certificate-card:hover .cosmotone-certificate-preview>img{transform:scale(1.03)}.cosmotone-certificate-pdf{display:flex;flex-direction:column;align-items:center;gap:12px;color:#d63638}.cosmotone-certificate-pdf i{font-size:78px}.cosmotone-certificate-pdf small{font-size:15px;font-weight:800;letter-spacing:1px}.cosmotone-certificate-view{position:absolute;right:15px;bottom:15px;padding:9px 13px;border-radius:5px;color:#fff;background:rgba(7,92,229,.92);font-size:13px;font-weight:700;opacity:0;transform:translateY(6px);transition:opacity .25s ease,transform .25s ease}.cosmotone-certificate-card:hover .cosmotone-certificate-view,.cosmotone-certificate-open:focus-visible .cosmotone-certificate-view{opacity:1;transform:none}.cosmotone-certificate-card h2{margin:0;padding:22px 24px;color:#102444;font-size:20px;line-height:1.35}.cosmotone-certificate-modal[hidden]{display:none}.cosmotone-certificate-modal{position:fixed;inset:0;z-index:999999;display:flex;padding:25px;align-items:center;justify-content:center}.cosmotone-certificate-modal-backdrop{position:absolute;inset:0;background:rgba(2,12,29,.82);backdrop-filter:blur(4px)}.cosmotone-certificate-modal-dialog{position:relative;display:flex;width:min(1100px,96vw);height:min(850px,92vh);flex-direction:column;overflow:hidden;border-radius:10px;background:#fff;box-shadow:0 30px 80px rgba(0,0,0,.35)}.cosmotone-certificate-modal-header{display:flex;min-height:64px;padding:13px 18px 13px 24px;align-items:center;justify-content:space-between;border-bottom:1px solid #dce8f4}.cosmotone-certificate-modal-header h2{margin:0;color:#102444;font-size:20px}.cosmotone-certificate-modal-header button{display:flex;width:40px;height:40px;align-items:center;justify-content:center;border:0;border-radius:50%;color:#102444;background:#edf4fb;font-size:20px;cursor:pointer}.cosmotone-certificate-modal-content{display:flex;min-height:0;flex:1;align-items:center;justify-content:center;background:#e8eff7}.cosmotone-certificate-modal-content img{max-width:100%;max-height:100%;padding:20px;object-fit:contain}.cosmotone-certificate-modal-content iframe{width:100%;height:100%;border:0;background:#fff}.cosmotone-certificate-modal-open{overflow:hidden}@media(max-width:575px){.cosmotone-certificate-preview{height:260px}.cosmotone-certificate-modal{padding:10px}.cosmotone-certificate-modal-dialog{width:100%;height:94vh}.cosmotone-certificate-modal-header h2{font-size:16px}}
</style>
<script>
(function(){
	var modal=document.getElementById('cosmotone-certificate-modal'),content=modal.querySelector('.cosmotone-certificate-modal-content'),title=modal.querySelector('#cosmotone-certificate-modal-title'),lastTrigger=null;
	function closeModal(){modal.hidden=true;content.innerHTML='';document.body.classList.remove('cosmotone-certificate-modal-open');if(lastTrigger)lastTrigger.focus();}
	document.querySelectorAll('.cosmotone-certificate-open[data-url]').forEach(function(button){
		button.addEventListener('click',function(){
			var url=button.dataset.url;if(!url)return;lastTrigger=button;title.textContent=button.dataset.title||'Certificate';content.innerHTML='';
			if(button.dataset.type==='pdf'){var frame=document.createElement('iframe');frame.src=url;frame.title=title.textContent;content.appendChild(frame);}else{var image=document.createElement('img');image.src=url;image.alt=title.textContent;content.appendChild(image);}
			modal.hidden=false;document.body.classList.add('cosmotone-certificate-modal-open');modal.querySelector('[data-certificate-close]').focus();
		});
	});
	modal.querySelectorAll('[data-certificate-close]').forEach(function(button){button.addEventListener('click',closeModal);});
	document.addEventListener('keydown',function(event){if(event.key==='Escape'&&!modal.hidden)closeModal();});
})();
</script>
<?php get_footer(); ?>
