<?php 
/**
	* Layout Featured
	* @version     1.0.0
**/

$viewall = get_permalink( wc_get_page_id( 'shop' ) );
$term_name = esc_html__( 'Featured Products', 'zr_core' );
$default = array(
	'post_type'				=> 'product',
	'post_status' 			=> 'publish',
	'ignore_sticky_posts'	=> 1,
	'posts_per_page' 		=> $numberposts,
	'orderby' 				=> $orderby,
	'order' 				=> $order,
	'meta_query'			=> array(		
		array(
			'key' 		=> '_featured',
			'value' 	=> 'yes'
		)
	)
);
if( $category != '' ){
	$term = get_term_by( 'slug', $category, 'product_cat' );	
	if( $term ) :
		$term_name = $term->name;
	endif;
	
	$default['tax_query']	= array(
		array(
			'taxonomy'	=> 'product_cat',
			'field'		=> 'slug',
			'terms'		=> $category
		)
	);
}
$id = 'zr_featured_'.$this->generateID();
$list = new WP_Query( $default );
if ( $list -> have_posts() ){
?>
	<div id="<?php echo $id; ?>" class="zr-woo-container-slider responsive-slider featured-product clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
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
					<div class="item <?php echo esc_attr( $class )?> product">
				<?php } ?>
						<?php include( ZRTHEME . '/default-item2.php' ); ?>
					<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
				<?php $i++; endwhile; wp_reset_postdata();?>
				</div>
			</div> 
		</div>			
	</div>
<?php
}	else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'Has no product in this category', 'zr_core' ) .'</p>
	</div>';
	}
?>