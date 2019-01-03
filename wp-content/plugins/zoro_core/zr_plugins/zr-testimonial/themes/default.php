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
?>
	<div id="<?php echo esc_attr( $widget_id ) ?>" class="testimonial-slider responsive-slider clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<?php if($title !=''){ ?>
		<div class="box-title">
			<h3><?php echo $title ?></h3>
		</div>
		<?php } ?>
		<div class="resp-slider-container">
			<div class="slider responsive">
			<?php 
				while($list->have_posts()): $list->the_post();
				global $post;
				$au_name = get_post_meta( $post->ID, 'au_name', true );
				$au_url  = get_post_meta( $post->ID, 'au_url', true );
				$active = ($i== 0) ? 'active' :'';
			?>
				<div class="item">
					<div class="item-inner clearfix">							
						<div class="client-say-info clearfix">
							<div class="image-client">
								<?php the_post_thumbnail( 'thumbnail' ) ?>
							</div>
							<h3><?php echo esc_html($au_name) ?></h3>
						</div>
						<div class="client-comment clearfix">
						<?php
							$text = get_the_content($post->ID);	
							$content = wp_trim_words($text, $length);
							echo esc_html($content);
						?>
						</div>
					</div>
				</div> 
				<?php $i++; endwhile; wp_reset_postdata();  ?>
			</div>
		</div>		
	</div>
<?php	
}
?>