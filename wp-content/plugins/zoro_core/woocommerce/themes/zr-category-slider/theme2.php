<?php 
	
	$widget_id = isset( $widget_id ) ? $widget_id : 'category_slide_'.$this->generateID();
	if( $category == '' ){
		return '<div class="alert alert-warning alert-dismissible" role="alert">
			<a class="close" data-dismiss="alert">&times;</a>
			<p>'. esc_html__( 'Please select a category for ZR Woocommerce Category Slider. Layout ', 'zr_core' ) . $layout .'</p>
		</div>';
	}
?>
<div id="<?php echo 'slider_' . $widget_id; ?>" class="zr-category-slider3">
	<?php	if( $title1 != '' ){ ?>
	<div class="block-title">
		<h3><span><?php echo $title1; ?></span></h3>
	</div>
	<?php } ?>
	<div class="childcat-slider-content clearfix">
		<?php 
		$banner_links = explode( ',', $banner_links );
		if( $image != '' ) :
			$image = explode( ',', $image );	
		endif;
		?>
		<div class="banner-category">
			<div id="<?php echo esc_attr( 'banner_' . $widget_id ); ?>" class="banner-slider" data-lg="1" data-md="1" data-sm="1" data-xs="1" data-mobile="1" data-dots="true" data-arrow="false" data-fade="false">
				<div class="banner-responsive">
					<?php foreach( $image as $key => $img ) : ?>
						<div class="item">
							<a href="<?php echo esc_url( $banner_links[$key] ); ?>"><?php echo wp_get_attachment_image( $img, 'full' ); ?></a>
						</div>
					<?php endforeach;?>
				</div>
			</div>									
		</div>	
		<div class="resp-slider-container">
			<div class="items-wrapper clearfix">
			<?php
				if( !is_array( $category ) ){
					$category = explode( ',', $category );
				}
					foreach( $category as $cat ){
					$term = get_term_by('slug', $cat, 'product_cat');
					if( $term ) :
					$thumbnail_id1 	= get_woocommerce_term_meta( $term->term_id, 'thumbnail_id1', true );
					$thumb = wp_get_attachment_image( $thumbnail_id1,'full' );
			?>
				<div class="item item-product-cat">
					<div class="item-inner">
						<div class="item-image">
							<a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php echo $thumb; ?></a>
						</div>
						<div class="item-content">
							<h3><a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php zr_trim_words( $term->name, $title_length ); ?></a></h3>
							<a class="shop-now" href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php echo esc_html__('Shop now','zr_core'); ?></a>
						</div>
					</div>
				</div>
				<?php endif; ?>
			<?php } ?>
			</div>
		</div>
	</div>
</div>		