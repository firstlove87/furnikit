<?php 
/* 
** Content Header
*/
$furnikit_page_header = get_post_meta( get_the_ID(), 'page_header_style', true );
$furnikit_colorset = zr_options('scheme');
$furnikit_logo = zr_options('sitelogo');
$furnikit_page_header  = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : zr_options('header_style');
?>
<header id="header" class="header header-<?php echo esc_attr( $furnikit_page_header ); ?>">
	<div class="header-top clearfix">	
		<div class="container">
			<!-- Logo -->
			<div class="furnikit-logo">
				<?php furnikit_logo(); ?>
			</div>		
		</div>
	</div>
	<div class="header-mid clearfix">	
		<div class="container">
			<div class="row">
				<!-- Sidebar right -->
				<?php if( !zr_options( 'disable_search' ) ) : ?>
					<div class="search-cate col-lg-1 pull-left">
						<div class="icon-search"><span class="icon-zoom-2"></span></div>
						<?php if( is_active_sidebar( 'search' ) && class_exists( 'zr_woo_search_widget' ) ): ?>
							<?php dynamic_sidebar( 'search' ); ?>
						<?php else : ?>
							<div class="widget furnikit_top non-margin">
								<div class="widget-inner">
									<?php get_template_part( 'widgets/zr_top/searchcate' ); ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>	
				<!-- Primary navbar -->
				<?php if ( has_nav_menu( 'primary_menu' ) ) { ?>
				<div id="main-menu" class="main-menu col-lg-10 pull-left clearfix">
					<div class="navbar-menu clearfix">
						<?php
						$furnikit_menu_class = 'nav nav-pills';
						if ( 'mega' == zr_options( 'menu_type' ) ){
							$furnikit_menu_class .= ' nav-mega';
						} else $furnikit_menu_class .= ' nav-css';
						?>
						<?php wp_nav_menu( array( 'theme_location' => 'primary_menu', 'menu_class' => $furnikit_menu_class ) ); ?>
					</div>
				</div>			
				<?php } ?>
				<!-- /Primary navbar -->
				<?php if( !zr_options( 'disable_cart' ) ) : ?>
					<div class="header-cart col-lg-1 pull-left">
						<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</header>