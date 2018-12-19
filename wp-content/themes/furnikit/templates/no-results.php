<?php
	global $furnikit_detect;
	$mobile_check   = zr_options( 'mobile_enable' );
	if( !empty( $furnikit_detect ) && ( $furnikit_detect->isMobile() ) && $mobile_check ) :?>
	<?php if (!have_posts()) : ?>
	<div class="no-result">
		<div class="no-result-image">
			<span class="image">
				<img class="img_logo" alt="404" src="<?php echo get_template_directory_uri(); ?>/assets/img/no-result.png">
			</span>
		</div>
		<h3><?php esc_html_e('no products found','furnikit');?></h3>
		<p><?php esc_html_e('Sorry, but nothing matched your search terms.','furnikit');?><br/><?php  esc_html_e('Please try again with some different keywords.', 'furnikit'); ?></p>
		<button class="back-to"><?php esc_html_e('back to categories','furnikit');?></button>
	</div>
<?php endif; ?>
<?php else : ?>
<?php if (!have_posts()) : ?>
	<div class="no-result">		
			<p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'furnikit'); ?></p>
		<?php get_search_form(); ?>
	</div>
<?php endif; ?>
<?php endif; ?>