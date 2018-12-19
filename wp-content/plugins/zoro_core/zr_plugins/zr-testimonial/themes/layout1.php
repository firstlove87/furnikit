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
	if ( $list->have_posts() ){
	$i = 0;
	$j = 0;
	$k = 0;
?>
	<div id="<?php echo esc_attr( $widget_id ) ?>" class="testimonial-slider carousel slide" data-interval="0">
	<?php if($title !=''){ ?>
		<div class="block-title">
			<h2><?php echo $title ?></h2>
		</div>
	<?php } ?>
		<ul class="carousel-indicators">
		<?php 
			while ( $list->have_posts() ) : $list->the_post();
			if( $j % 1 == 0 ) {  $k++;
			$active = ($j== 0)? 'active' :'';
		?>
			<li class="'.$active.'" data-slide-to="<?php echo ($k-1) ?>" data-target="#<?php echo esc_attr( $widget_id ) ?>">
		<?php } if( ( $j+1 ) % 1 == 0 || ( $j+1 ) == $numberposts ){ ?>
			</li>
		<?php 
				}					
			$j++; 
			endwhile; 
			wp_reset_postdata(); 
		?>
		</ul>
		<div class="carousel-inner">
		<?php 
			while($list->have_posts()): $list->the_post();
			global $post;
			$au_name = get_post_meta( $post->ID, 'au_name', true );
			$au_url  = get_post_meta( $post->ID, 'au_url', true );
			$au_info = get_post_meta( $post->ID, 'au_info', true );
			$active = ($i== 0) ? 'active' :'';
		?>
			<div class="item <?php echo esc_attr( $active ) ?>">
				<div class="item-inner">							
					<div class="client-comment">
					" <?php
						$text = get_the_content($post->ID);	
						$content = wp_trim_words($text, $length);
						echo esc_html($content);
					?> "
					</div>
					<div class="client-say-info">
						<div class="image-client">
							<?php the_post_thumbnail( 'thumbnail' ) ?>
						</div>
						<div class="name-client">
							<h2><?php echo esc_html($au_name) ?> - <span><?php echo esc_html($au_info) ?></span></h2>
						</div>
					</div>
				</div>
			</div> 
			<?php $i++; endwhile; wp_reset_postdata();  ?>
		</div>
	</div>	
<?php	
}
?>