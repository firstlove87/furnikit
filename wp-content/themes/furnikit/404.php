<?php get_template_part('templates/head'); ?>
<div class="wrapper_404">
	<div class="container">
		<div class="row">
			<?php $furnikit_404page = zr_options( 'page_404' ); ?>
			<?php if( $furnikit_404page != '' ) : ?>
				<?php echo sw_get_the_content_by_id( $furnikit_404page ); ?>
			<?php else: ?>	
				<div class="content_404">
					<div class="erro-content">
						<h1><?php esc_html_e( '404', 'furnikit') ?></h1>
						<h2><?php esc_html_e( "Ooops... There's nothing in here", 'furnikit') ?></h2>						
						<p><?php esc_html_e( "Sorry, but the page you are looking for doesn't exist. You may like some inspire below", 'furnikit') ?></p>
						<div class="block-bottom">
							<a href="<?php echo esc_url( home_url('/') ); ?>" class="btn-404 back2home" title="<?php esc_attr__( 'Go Home', 'furnikit' ) ?>"><?php esc_html_e( "BACK TO HOME", 'furnikit' )?></a>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php wp_footer(); ?>