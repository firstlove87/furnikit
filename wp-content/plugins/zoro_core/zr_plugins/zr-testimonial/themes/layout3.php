<?php 
	$widget_id = isset( $widget_id ) ? $widget_id : 'zr_testimonial'.rand().time();
	$default = array(
		'post_type' => 'testimonial',
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
	$list = new WP_Query( $default );
	if ( count($list) > 0 ){
	$i = 0;
	$j = 0;
	$k = 0;
?>
	<div class="widget-testimonial">
		<div class="widget-inner">
			<div class="customersay">
				<h3 class="custom-title"><?php echo $title ?></h3>
				<div id="<?php echo esc_attr( $widget_id ) ?>" class="testimonial-slider carousel slide style3">
					<div class="carousel-inner">
					<?php 
						while($list->have_posts()): $list->the_post();
						global $post;
						$au_name = get_post_meta( $post->ID, 'au_name', true );
						$au_url  = get_post_meta( $post->ID, 'au_url', true );
						$au_info = get_post_meta( $post->ID, 'au_info', true );
						$active = ($i== 0)? 'active' :'';
					?>
						<div class="item <?php echo esc_attr( $active ); ?>">
							<div class="item-inner">
							<?php if( has_post_thumbnail() ){ ?>
								<div class="item-content">
									<div class="item-desc">
									<?php 
										$text = get_the_content($post->ID);
										$content = wp_trim_words($text, $length);
										echo esc_html($content);
									?>
									</div>
								</div>									
								<div class="item-info">
										<h4><span class="author"><?php echo esc_html($au_name)?></span> - <span class="info"><?php echo esc_html($au_info) ?></span></h4>
								</div>
							<?php } ?>
							</div>
						</div> 
					<?php $i++; endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>	
<?php	
}
?>