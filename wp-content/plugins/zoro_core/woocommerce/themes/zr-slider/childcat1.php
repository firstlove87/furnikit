<?php 

/**
	* Layout Child Category 1
	* @version     1.0.0
**/
if( $category == '' ){
	return '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'Please select a category for ZR Woo Slider. Layout ', 'zr_core' ) . $layout .'</p>
	</div>';
}

$widget_id = isset( $widget_id ) ? $widget_id : $this->generateID();
$viewall = get_permalink( wc_get_page_id( 'shop' ) );
$default = array();
if( $category != '' ){
	$default = array(
		'post_type' => 'product',
		'tax_query' => array(
		array(
			'taxonomy'  => 'product_cat',
			'field'     => 'slug',
			'terms'     => $category ) ),
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
}

$term_name = '';
$term = get_term_by( 'slug', $category, 'product_cat' );
if( $term ) :
	$term_name = $term->name;
	$viewall = get_term_link( $term->term_id, 'product_cat' );
endif;

$list = new WP_Query( $default );
if ( $list -> have_posts() ){ ?>
	<div id="<?php echo 'slider_' . $widget_id; ?>" class="zr-child-cat-listing">
		<div class="zr-childcat-container clearfix">
			<div class="zr-childcat-top clearfix">
				<div class="zr-child-cat-top-inner">
				<div class="zr-child-cat-top-info">
				<?php 
					$thumb = ( $banner != '' ) ? wp_get_attachment_url( $banner ) : 'http://placehold.it/284x284';
					$class = ( $banner != '' ) ? 'has-banner' : '';
				?>
					<div class="child-left <?php echo esc_attr( $class ); ?>">
						<div class="box-title clearfix">
							<h3><?php echo ( $title1 != '' ) ? $title1 : $term_name; ?></h3>
							<?php echo ( $description != '' ) ? '<div class="slider-description">'. $description .'</div>' : ''; ?></div>
						<?php 
						if( $term ) :
							$termchild 		= get_terms( 'product_cat', array( 'parent' => $term->term_id, 'hide_empty' => 0, 'number' => 10 ) );
							if( count( $termchild ) > 0 ){
						?>			
							<div class="childcat-content"  id="<?php echo 'child_' . $widget_id; ?>">				
							<?php 					
								echo '<ul>';
								foreach ( $termchild as $key => $child ) {
									echo '<li><a href="' . get_term_link( $child->term_id, 'product_cat' ) . '">' . $child->name . '</a></li>';
								}
								echo '</ul>';
							?>
							</div>
							<?php } ?>
						<?php endif; ?>					
					</div>
					<div class="banner-child-cat">
						<a href="<?php echo esc_url( $viewall ); ?>"><img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $term_name ); ?>"/></a>
					</div>
					</div>
				</div>
			</div>		
			<?php 
				$attribute = 
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
	<?php
	}else{
		echo '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'Has no product in this category', 'zr_core' ) .'</p>
	</div>';
	}
?>