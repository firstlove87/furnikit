<?php get_header(); ?>
<?php 
	$furnikit_sidebar_template	= get_post_meta( get_the_ID(), 'page_sidebar_layout', true );
	$furnikit_sidebar = get_post_meta( get_the_ID(), 'page_sidebar_template', true );
	?>

	<div class="furnikit_breadcrumbs">
		<div class="container">	
			<div class="listing-title">			
				<h1><span><?php furnikit_title(); ?></span></h1>				
			</div>	
			<?php
				if (!is_front_page() ) {
					if (function_exists('furnikit_breadcrumb')){
						furnikit_breadcrumb('<div class="breadcrumbs custom-font theme-clearfix">', '</div>');
					} 
				} 
			?>
		</div>
	</div>

	<div class="container">
		<div class="row">
		<?php 
			if ( is_active_sidebar( $furnikit_sidebar ) && $furnikit_sidebar_template != 'right' && $furnikit_sidebar_template !='full' ):
			$furnikit_left_span_class = 'col-lg-'.zr_options('sidebar_left_expand');
			$furnikit_left_span_class .= ' col-md-'.zr_options('sidebar_left_expand_md');
			$furnikit_left_span_class .= ' col-sm-'.zr_options('sidebar_left_expand_sm');
		?>
			<aside id="left" class="sidebar <?php echo esc_attr( $furnikit_left_span_class ); ?>">
				<?php dynamic_sidebar( $furnikit_sidebar ); ?>
			</aside>
		<?php endif; ?>
		
			<div id="contents" role="main" class="main-page <?php furnikit_content_page(); ?>">
				<?php
				get_template_part('templates/content', 'page')
				?>
			</div>
			<?php 
			if ( is_active_sidebar( $furnikit_sidebar ) && $furnikit_sidebar_template != 'left' && $furnikit_sidebar_template !='full' ):
				$furnikit_left_span_class = 'col-lg-'.zr_options('sidebar_left_expand');
				$furnikit_left_span_class .= ' col-md-'.zr_options('sidebar_left_expand_md');
				$furnikit_left_span_class .= ' col-sm-'.zr_options('sidebar_left_expand_sm');
			?>
				<aside id="right" class="sidebar <?php echo esc_attr($furnikit_left_span_class); ?>">
					<?php dynamic_sidebar( $furnikit_sidebar ); ?>
				</aside>
			<?php endif; ?>
		</div>		
	</div>
<?php get_footer(); ?>

