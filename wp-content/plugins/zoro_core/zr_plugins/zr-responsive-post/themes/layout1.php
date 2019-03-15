<?php 
	/**
		** Theme: Responsive Slider
		** Author: Zoro
		** Version: 1.0
	**/
	//var_dump($category);
	$default = array(
			'category' => $category, 
			'orderby' => $orderby,
			'order' => $order, 
			'numberposts' => $numberposts,
	);
	$list = get_posts($default);
	do_action( 'before' ); 
	$id = 'sw_reponsive_post_slider_'.rand().time();
	if ( count($list) > 0 ){
?>
<div class="clear"></div>
<div id="<?php echo esc_attr( $id ) ?>" class="responsive-post-slider2 responsive-slider clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
	<div class="resp-slider-container">
		<div class="block-title">
			<?php
			$titles = strpos($title2, ' ');
			$title = ($titles !== false) ? '<span>' . substr($title2, 0, $titles) . '</span>' .' '. substr($title2, $titles + 1): $title2 ;
			echo '<h3>'. $title .'</h3>';
			?>
		</div>
		<div class="slider responsive">
			<?php foreach ($list as $post){ ?>
				<?php if($post->post_content != Null) { ?>
				<div class="item">
					<div class="item-inner">
						<div class="img_over">
							<a href="<?php echo get_permalink($post->ID)?>">
								<?php if( has_post_thumbnail( $post->ID ) ) : ?>
									<?php echo get_the_post_thumbnail($post->ID, 'furnikit_blog-responsive'); ?>
								<?php else : ?>
									<img src="<?php echo esc_url( 'http://placehold.it/370x240' ); ?>" alt=""/>
								<?php endif; ?>
							</a>
						</div>
						<div class="entry-content">	
							<div class="entry-date"><a href="<?php echo get_permalink($post->ID)?>"><?php echo get_the_date( '', $post->ID );?></a></div>
							<div class="widget-title">
								<h4><a href="<?php echo get_permalink($post->ID)?>"><?php echo $post->post_title;?></a></h4>
							</div>					
						</div>
					</div>
				</div>
				<?php } ?>
			<?php }?>
		</div>
	</div>
</div>
<?php } ?>