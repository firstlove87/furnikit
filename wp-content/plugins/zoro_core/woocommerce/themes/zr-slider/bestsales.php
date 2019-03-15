<?php 

/**
	* Layout Best Sales
	* @version     1.0.0
**/


$term_name = esc_html__( 'Best Sales', 'zr_core' );
$viewall = get_permalink( wc_get_page_id( 'shop' ) );	
$default = array(
	'post_type' 			=> 'product',		
	'post_status' 			=> 'publish',
	'ignore_sticky_posts'   => 1,
	'showposts'				=> $numberposts,
	'meta_key' 		 		=> 'total_sales',
	'orderby' 		 		=> 'meta_value_num',	
);
if( $category != '' ){
	$term = get_term_by( 'slug', $category, 'product_cat' );	
	if( $term ) :
		$term_name = $term->name;
		$viewall = get_term_link( $term->term_id, 'product_cat' );
	endif;
	
	$default['tax_query'] = array(
		array(
			'taxonomy'	=> 'product_cat',
			'field'	=> 'slug',
			'terms'	=> $category,
			'operator' => 'IN'
		)
	);
}
$id = 'zr_bestsales_'.$this->generateID();
$list = new WP_Query( $default );
if ( $list -> have_posts() ){
?>
	<div id="<?php echo $id; ?>" class="responsive-slider best-selling-product clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<?php if( $title1 != '' ){?>
			<div class="block-title">
				<h3><?php echo ( $title1 != '' ) ? $title1 : ''; ?></h3>
			</div>
		<?php } ?>
		<div class="zr-content">
			<div class="resp-slider-container">
				<div class="slider responsive">	
				<?php 
					$count_items 	= 0;
					$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
					$count_items 	= ( $numberposts >= $numb ) ? $numb : $numberposts;
					$i 				= 0;
					while($list->have_posts()): $list->the_post();global $product, $post;
					$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
					if( $i % $item_row == 0 ){
				?>
					<div class="item-product clearfix">
				<?php } ?>
					<div class="item-wrap clearfix">									
						<div class="item-img pull-left">
							<a href="<?php echo get_permalink($post->ID)?>" >
							<?php 
							if ( has_post_thumbnail( $post->ID ) ){									
								echo get_the_post_thumbnail( $post->ID, 'shop_catalog' ) ? get_the_post_thumbnail( $post->ID, 'shop_catalog' ): '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.'large'.'.png" alt="No thumb">';		
							}else{
								echo '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.'large'.'.png" alt="No thumb">';
							}
							?></a>	
						</div>										
						<div class="item-content">
							<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php zr_trim_words( get_the_title(), $title_length ); ?></a></h4>
							<!-- price -->
							<?php if ( $price_html = $product->get_price_html() ){?>
								<div class="item-price">
									<span>
										<?php echo $price_html; ?>
									</span>
								</div>
							<?php } ?>
							<!-- rating  -->
							<?php 
								$rating_count = $product->get_rating_count();
								$review_count = $product->get_review_count();
								$average      = $product->get_average_rating();
							?>
							<div class="reviews-content">
								<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>
							</div>
						</div>								
					</div>
					<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
				<?php $i++; endwhile; wp_reset_postdata();?>
				</div>
			</div> 
		</div>				
	</div>
<?php
}else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'Has no product in this category', 'zr_core' ) .'</p>
	</div>';
	}	
?>