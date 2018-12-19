<?php 
if ( !class_exists( 'WooCommerce' ) ) { 
	return false;
}
global $woocommerce; ?>
<div class="top-form top-form-minicart furnikit-minicart2 pull-right">
	<div class="top-minicart-icon pull-right">
		<a class="cart-contents" href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" title="<?php esc_attr_e('View your shopping cart', 'furnikit'); ?>"><?php echo '<span class="minicart-number">'.$woocommerce->cart->cart_contents_count.'</span>';?>
				<span class="text-cart"><?php esc_html_e('My Bag', 'furnikit'); ?></span>
		</a>
	</div>
	<div class="wrapp-minicart">
		<div class="minicart-padding">
			<div class="number-item"><?php echo esc_html__('There are ','furnikit').'<span class="item">' .$woocommerce->cart->cart_contents_count.' item(s)</span>'.esc_html__(' in your cart','furnikit');?></div>
			<ul class="minicart-content">
				<?php foreach($woocommerce->cart->cart_contents as $cart_item_key => $cart_item): ?>
					<li>
						<a href="<?php echo get_permalink($cart_item['product_id']); ?>" class="product-image">
							<?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>
							<?php echo get_the_post_thumbnail($thumbnail_id, array(100,100)); ?>
						</a>
						<?php 	global $product, $post, $wpdb, $average; ?>
						<div class="detail-item">
							<div class="product-details"> 
								<h4><a class="title-item" href="<?php echo get_permalink($cart_item['product_id']); ?>"><?php echo esc_html( $cart_item['data']->post->post_title ); ?></a></h4>	  		
								<div class="product-price">
									<span class="price"><?php echo sprintf( '%s', $woocommerce->cart->get_product_subtotal($cart_item['data'], 1) ); ?></span>	      
									<div class="qty">
										<?php echo '<span class="qty-number">'.esc_html( $cart_item['quantity'] ).'</span>'; ?>
									</div>
								</div>
								<div class="product-action clearfix">
									<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="btn-remove" title="%s"><span class="fa fa-trash-o"></span></a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_html__( 'Remove this item', 'furnikit' ) ), $cart_item_key ); ?>           
									<a class="btn-edit" href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'furnikit'); ?>"><i class="fa fa-pencil"></i><span></span></a>    
								</div>
							</div>	
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
			<div class="cart-checkout">
			    <div class="price-total">
				   <span class="label-price-total"><?php esc_html_e('Subtotal:', 'furnikit'); ?></span>
				   <span class="price-total-w"><span class="price"><?php echo sprintf( '%s', $woocommerce->cart->get_cart_total() ); ?></span></span>			
				</div>
				<div class="cart-links clearfix">
					<div class="cart-link"><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>" title="<?php esc_attr_e( 'Cart', 'furnikit' ) ?>"><?php esc_html_e('View Cart', 'furnikit'); ?></a></div>
					<div class="checkout-link"><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>" title="<?php esc_attr_e( 'Check Out', 'furnikit' ) ?>"><?php esc_html_e('Check Out', 'furnikit'); ?></a></div>
				</div>
			</div>
		</div>
	</div>
</div>