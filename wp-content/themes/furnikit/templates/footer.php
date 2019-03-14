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
</footer>