<?php get_template_part('header'); ?>
<div class="wrapper_404">
	<div class="container">
		<div class="row">
			<div class="content_404">
				<div class="item-left col-lg-5 col-md-5">
					<div class="erro-image">
						<span class="erro-key">
							<img class="img_logo" alt="404" src="<?php echo get_template_directory_uri(); ?>/assets/img/img-404.png">
						</span>
					</div>
				</div>
				<div class="item-right col-lg-7 col-md-7">
					<div class="block-top">
						<h2><span><?php esc_html_e( 'Oops, This Page Clould Not Be Found', 'furnikit' ) ?></span></h2>
						<div class="warning-code"><p><?php esc_html_e( 'The page you are looking for does not appear to exit. Please Check the URL', 'furnikit' ) ?><br><?php esc_html_e( 'or try the search box below.', 'furnikit' ) ?></p></div>
					</div>
					<div class="block-middle">
						<div class="furnikit_search_404">
							<?php get_template_part( 'widgets/zr_top/search' ); ?>
						</div>
					</div>
					<div class="block-bottom">
						<a href="<?php echo esc_url( home_url('/') ); ?>" class="btn-404 back2home" title="<?php esc_attr_e( 'Go Home', 'furnikit' ) ?>"><?php esc_html_e( "Go Home", 'furnikit' )?></a>
						<a href="#" class=" btn-404 support" title="<?php esc_attr_e( 'Go Support', 'furnikit' ) ?>"><?php esc_html_e( "Go Support", 'furnikit' )?></a>					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_template_part('footer'); ?>