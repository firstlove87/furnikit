<?php 
	
	$widget_id = isset( $widget_id ) ? $widget_id : 'category_slide_'.$this->generateID();
	if( $category == '' ){
		return '<div class="alert alert-warning alert-dismissible" role="alert">
			<a class="close" data-dismiss="alert">&times;</a>
			<p>'. esc_html__( 'Please select a category for ZR Woocommerce Category Slider. Layout ', 'zr_core' ) . $layout .'</p>
		</div>';
	}
?>
<div id="<?php echo 'slider_' . $widget_id; ?>" class="responsive-slider zr-category-slider2 loading"  data-append=".resp-slider-container" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
	<?php if( $title1 != '' ){ ?>
	<div class="block-title">
		<h3><?php echo $title1; ?></h3>
	</div>
	<?php } ?>
	<div class="resp-slider-container">
		<div class="slider responsive">
		<?php
			if( !is_array( $category ) ){
				$category = explode( ',', $category );
			}
			$i = 0;
			foreach( $category as $cat ){
			$term = get_term_by('slug', $cat, 'product_cat');	
			if( $term ) :
			$thumbnail_id 	= get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
			$thumb = wp_get_attachment_image( $thumbnail_id,'full' );
			if( $i % $item_row == 0 ){	
		?>
			<div class="item item-product-cat">
				<?php } ?>
				<div class="item-wrap">
					<div class="item-image pull-left">
						<a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php echo $thumb; ?></a>
					</div>
					<h4><a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php zr_trim_words( $term->name, $title_length ); ?></a></h4>
				</div>
				<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == count($category) ){?> </div><?php } ?>
				<?php $i++;?>
			<?php endif; ?>
		<?php } ?>
		</div>
	</div>
</div>		