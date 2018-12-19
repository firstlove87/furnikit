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
	<div id="<?php echo $id; ?>" class="zr-woo-container-slider  responsive-slider best-selling-product clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="zr-content">
			<div class="banner-info">
			<?php 
				$thumb = ( $banner != '' ) ? wp_get_attachment_url( $banner ) : 'http://placehold.it/284x284';
				$class = ( $banner != '' ) ? 'has-banner' : '';
			?>
				<a href="<?php echo esc_url( $viewall ); ?>"><img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $term_name ); ?>"/></a>
				<div class="box-title">
					<h2><span><?php echo ( $title1 != '' ) ? $title1 : $term_name; ?></span></h2>
					<a href="<?php echo esc_url( $viewall ); ?>"><?php esc_html_e( 'Shop Now', 'zr_core' ) ?> <i class="fa fa-caret-right" aria-hidden="true"></i></a>
				</div>
			</div>
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
}else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'Has no product in this category', 'zr_core' ) .'</p>
	</div>';
	}	
?>