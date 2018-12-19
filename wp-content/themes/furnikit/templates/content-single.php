<?php get_template_part('header'); ?>

<div class="furnikit_breadcrumbs">
	<div class="container">
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

		<?php if ( is_active_sidebar('left-blog') && furnikit_sidebar_template() == 'left' ):
			$furnikit_left_span_class = 'col-lg-'.zr_options('sidebar_left_expand');
			$furnikit_left_span_class .= ' col-md-'.zr_options('sidebar_left_expand_md');
			$furnikit_left_span_class .= ' col-sm-'.zr_options('sidebar_left_expand_sm');
		?>
		<aside id="left" class="sidebar <?php echo esc_attr($furnikit_left_span_class); ?>">
			<?php dynamic_sidebar('left-blog'); ?>
		</aside>
		<?php endif; ?>
			
		<div class="single main <?php furnikit_content_blog(); ?>" >
			<?php while (have_posts()) : the_post(); ?>
			<?php $related_post_column = zr_options('sidebar_blog'); ?>
			<div <?php post_class(); ?>>
				<?php $pfm = get_post_format();?>
				<div class="entry-wrap">
					<?php if( $pfm == '' || $pfm == 'image' ){?>
						<?php if( has_post_thumbnail() ){ ?>
							<div class="entry-thumb single-thumb">
								<?php the_post_thumbnail('furnikit_detail_thumb'); ?>
							</div>
						<?php }?>
					<?php } ?>
					<h1 class="entry-title clearfix"><?php the_title(); ?></h1>
					<div class="entry-content clearfix">
						<div class="entry-meta clearfix">
							<span class="entry-author">
								<i class="fa fa-user"></i><?php esc_html_e('Post By:', 'furnikit'); ?> <?php the_author_posts_link(); ?>
							</span>
							<div class="entry-comment">
								<a href="<?php comments_link(); ?>">
									<i class="fa fa-comments-o"></i>
									<?php echo _n( ' Comment', ' Comments', $post-> comment_count , 'furnikit' ); ?>
								</a>
							</div>
							<?php if( ! has_post_thumbnail() ){ ?>
								<span class="entry-date">
									<i class="fa fa-clock-o"></i><?php echo ( get_the_title() ) ? date( 'M j, Y',strtotime($post->post_date)) : '<a href="'.get_the_permalink().'">'.date( 'l, F j, Y',strtotime($post->post_date)).'</a>'; ?>
								</span>
							<?php } ?>
						</div>
						<div class="entry-summary single-content ">
							<?php the_content(); ?>
							
							<div class="clear"></div>
							<!-- link page -->
							<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'furnikit' ).'</span>', 'after' => '</div>' , 'link_before' => '<span>', 'link_after'  => '</span>' ) ); ?>	
						</div>
						
						<div class="clear"></div>			
						<div class="single-content-bottom clearfix">
							<!-- Tag -->
							<?php if(get_the_tag_list()) { ?>
								<div class="entry-tag single-tag clearfix">
									<?php echo get_the_tag_list('<label class="title-tag">TAGS </label>',' ','');  ?>
								</div>
							<?php } ?>
							<!-- Social -->
							<?php furnikit_get_social() ?>
						</div>
					</div>
				</div>
				
				<div class="clearfix"></div> 
				<?php if( get_the_author_meta( 'description',  $post->post_author ) != '' ): ?>
				<div id="authorDetails" class="clearfix">
					<div class="authorDetail">
						<div class="avatar">
							<?php echo get_avatar( $post->post_author , 100 ); ?>
						</div>
						<div class="infomation">
							<h4 class="name-author"><span><?php echo get_the_author_meta( 'user_nicename', $post->post_author )?></span></h4>
							<p><?php the_author_meta( 'description',  $post->post_author ) ;?></p>
						</div>
					</div>
				</div> 
				<?php endif; ?>
				<div class="clearfix"></div>
				<!-- Relate Post -->
				<?php 
					global $post;
					global $related_term;
					$class_col= "";
					$categories = get_the_category($post->ID);								
					$category_ids = array();
					foreach($categories as $individual_category) {$category_ids[] = $individual_category->term_id;}
					if ($categories) {
						if($related_post_column =='full'){
							$class_col .= 'col-lg-4 col-md-4 col-sm-4';
							$related = array(
								'category__in' => $category_ids,
								'post__not_in' => array($post->ID),
								'showposts'=>3,
								'orderby'	=> 'name',	
								'ignore_sticky_posts'=>1
								 );
						} else {
							$class_col .= 'col-lg-6 col-md-6 col-sm-6';
							$related = array(
								'category__in' => $category_ids,
								'post__not_in' => array($post->ID),
								'showposts'=>2,
								'orderby'	=> 'name',	
								'ignore_sticky_posts'=>1
								 );
						} 
				?>
						<div class="single-post-relate">
							<h4><?php esc_html_e('Related News', 'furnikit'); ?></h4>
							<div class="row">
							<?php
								$related_term = new WP_Query($related);
								while($related_term -> have_posts()):$related_term -> the_post();
									$format = get_post_format();
							?>
								<div <?php post_class( $class_col ); ?> >
									<?php if ( get_the_post_thumbnail() ) { ?>
									<div class="item-relate-img">
										<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('furnikit_related_post'); ?></a>
									</div>
									<?php } ?>
									<div class="item-relate-content">
										<div class="item-title">
											<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										</div>
										<div class="entry-meta">
											<div class="entry-date"><?php furnikit_get_time(); ?> - </div>
											<div class="entry-comment">
												<?php echo _n( ' Comment', ' Comments', $post-> comment_count , 'furnikit' ); ?>
											</div>
										</div>
										<div class="readmore"><a href="<?php the_permalink(); ?>"><?php echo esc_html__('Read More','furnikit');?></a></div>
									</div>
								</div>
								<?php
									endwhile;
									wp_reset_postdata();
								?>
							</div>
						</div>
						<?php } ?>
					
					<div class="clearfix"></div>
					<!-- Comment Form -->
					<?php comments_template('/templates/comments.php'); ?>
			</div>
			<?php endwhile; ?>
		</div>
	
		<?php if ( is_active_sidebar('right-blog') && furnikit_sidebar_template() == 'right' ):
			$furnikit_right_span_class = 'col-lg-'.zr_options('sidebar_right_expand');
			$furnikit_right_span_class .= ' col-md-'.zr_options('sidebar_right_expand_md');
			$furnikit_right_span_class .= ' col-sm-'.zr_options('sidebar_right_expand_sm');
		?>
		<aside id="right" class="sidebar <?php echo esc_attr( $furnikit_right_span_class ); ?>">
			<?php dynamic_sidebar('right-blog'); ?>
		</aside>
		<?php endif; ?>
	</div>	
</div>
<?php get_template_part('footer'); ?>
