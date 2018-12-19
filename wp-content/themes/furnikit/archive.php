<?php get_template_part('header'); ?>
<?php 
	$furnikit_sidebar_template = zr_options('sidebar_blog') ;
	$furnikit_blog_styles = ( zr_options('blog_layout') ) ? zr_options('blog_layout') : 'list';
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
		<?php if ( is_active_sidebar('left-blog') && $furnikit_sidebar_template == 'left' ):
			$furnikit_left_span_class = 'col-lg-'.zr_options('sidebar_left_expand');
			$furnikit_left_span_class .= ' col-md-'.zr_options('sidebar_left_expand_md');
			$furnikit_left_span_class .= ' col-sm-'.zr_options('sidebar_left_expand_sm');
		?>
		<aside id="left" class="sidebar <?php echo esc_attr($furnikit_left_span_class); ?>">
			<?php dynamic_sidebar('left-blog'); ?>
		</aside>
		<?php endif; ?>

		<div class="category-contents <?php furnikit_content_blog(); ?>">
			<!-- No Result -->
			<?php if (!have_posts()) : ?>
			<?php get_template_part('templates/no-results'); ?>
			<?php endif; ?>			
			
			<?php 
				$furnikit_blogclass = 'blog-content blog-content-'. $furnikit_blog_styles;
				if( $furnikit_blog_styles == 'grid' ){
					$furnikit_blogclass .= ' row';
				}
			?>
			<div class="<?php echo esc_attr( $furnikit_blogclass ); ?>">
			<?php 			
				while( have_posts() ) : the_post();
					get_template_part( 'templates/content', $furnikit_blog_styles );
				endwhile;
			?>
			<?php get_template_part('templates/pagination'); ?>
			</div>
			<div class="clearfix"></div>
		</div>
		
		<?php if ( is_active_sidebar('right-blog') && $furnikit_sidebar_template =='right' ):
			$furnikit_right_span_class = 'col-lg-'.zr_options('sidebar_right_expand');
			$furnikit_right_span_class .= ' col-md-'.zr_options('sidebar_right_expand_md');
			$furnikit_right_span_class .= ' col-sm-'.zr_options('sidebar_right_expand_sm');
		?>
		<aside id="right" class="sidebar <?php echo esc_attr($furnikit_right_span_class); ?>">
			<?php dynamic_sidebar('right-blog'); ?>
		</aside>
		<?php endif; ?>
	</div>
</div>
<?php get_template_part('footer'); ?>
