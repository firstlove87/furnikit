<?php 	
$furnikit_page_footer   	 = ( get_post_meta( get_the_ID(), 'page_footer_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_footer_style', true ) : zr_options( 'footer_style' );
$furnikit_copyright_text 	 = zr_options( 'footer_copyright' ); 
?>
<footer id="footer" class="footer default theme-clearfix">
	<div class="footer-top-wrapper">
		<!-- Content footer -->
		<div class="container">
			<?php 
			if( $furnikit_page_footer != '' ) :
				echo furnikit_get_the_content_by_id( $furnikit_page_footer ); 
			endif;
			?>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			<?php if (is_active_sidebar('footer-copyright1')){ ?>
			<div class="sidebar-copyright">
				<?php dynamic_sidebar('footer-copyright1'); ?>
			</div>
			<?php } ?>
			<!-- Copyright text -->
			<div class="copyright-text">
				<?php if( $furnikit_copyright_text == '' ) : ?>
					<p>&copy;<?php echo date('Y') .' '. esc_html__('WordPress Theme Furnikit Fashion. All Rights Reserved. Designed by ','furnikit'); ?><a class="mysite" href="<?php echo esc_url( 'http://www.zorotheme.com/' ); ?>"><?php esc_html_e('ZoroTheme','furnikit');?></a>.</p>
				<?php else : ?>
					<?php echo wp_kses( $furnikit_copyright_text, array( 'a' => array( 'href' => array(), 'title' => array(), 'class' => array() ), 'p' => array()  ) ) ; ?>
				<?php endif; ?>
			</div>
			<?php if (is_active_sidebar('footer-copyright2')){ ?>
			<div class="sidebar-copyright">
				<?php dynamic_sidebar('footer-copyright2'); ?>
			</div>
			<?php } ?>
		</div>
	</div>
</footer>