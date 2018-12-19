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
			<div class="header-left col-lg-4 col-md-4 col-sm-4">
				<a class="top-icon" href="javascript:void(0)"><i class="fa fa-bars" aria-hidden="true"></i></a>
				<?php if ( is_active_sidebar( 'top2' ) ) { ?>	
					<div class="header-bar">
					<?php dynamic_sidebar( 'top2' ); ?>
					</div>
				<?php } ?>
			</div>	
			<!-- Logo -->
			<div class="furnikit-logo col-lg-4 col-md-4 col-sm-4">
				<?php furnikit_logo(); ?>
			</div>				
			<div class="header-right col-lg-4 col-md-4 col-sm-4">
				<div class="header-right-inner clearfix">
					<!-- Sidebar right -->
					<?php if ( is_active_sidebar( 'header-right' ) ) { ?>
						<div class="right-header pull-right">		
							<?php dynamic_sidebar( 'header-right' ); ?>
						</div>	
						<div class="header-wishlist pull-right">
							<a href="<?php echo get_permalink( get_option('yith_wcwl_wishlist_page_id') ); ?>" title="<?php esc_attr_e('Wishlist','furnikit'); ?>"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
						</div>
					<?php } ?>
					<?php if( !zr_options( 'disable_search' ) ) : ?>
						<div class="search-cate pull-right">
							<div class="icon-search">
								<i class="fa fa-search"></i>
							</div>
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
				</div>
			</div>
		</div>
	</div>
	<div class="header-mid">
		<div class="container">
			<!-- Primary navbar -->
			<?php if ( has_nav_menu( 'primary_menu' ) ) { ?>
				<div id="main-menu" class="main-menu clearfix">
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
		</div>
	</div>
</header>