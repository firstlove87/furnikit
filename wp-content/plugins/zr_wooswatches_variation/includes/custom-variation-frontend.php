<?php 

ob_start();
if( $product->get_type() === 'variable' ){
	global $post;
	$img_size 			  = ( get_option( 'zr_wooswatches_variation_tooltip_size' ) ) ? get_option( 'zr_wooswatches_variation_tooltip_size' ) : 'shop_catalog';
	$attributes 		  = $product->get_variation_attributes();
	$meta_variation_check = get_post_meta( $post->ID,  'zr_variation_check', true );
	$meta_variation       = get_post_meta( $post->ID,  'zr_variation', true ); 
	$random_val			  = substr( rand().time(), -4 ) . $product->get_id();
	if( !empty( $attributes ) && sizeof( $attributes ) > 0 ){
		
		$get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
		$available_variations = $get_variations ? $product->get_available_variations() : false;
		$selected_attributes  = $product->get_default_attributes();
?>
	<div class="zr-variation-frontend" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ); ?>">
		<div class="zr-variation-wrapper">
		<?php 
			$result = array();
			$k = 0;
			foreach( $attributes as $key => $attribute ){			
				$class = array();			
				if( taxonomy_exists( $key ) ){
					$terms = wc_get_product_terms( $product->get_id(), $key, array( 'fields' => 'all' ) );	
					foreach ( $terms as $i => $term ) {
						$color  	= get_term_meta( $term->term_id, 'zr_variation_color', true );
						$thumb_id 	= absint( get_woocommerce_term_meta( $term->term_id, 'variation_thumbnail_id', true ) );						
						
						if( $thumb_id ){					
							$class[$i] = 'variation-image';
						}
						if( $color ){
							$class[$i] = 'variation-color';
						}
					}
				}else{
					$attr = '';
					$variation_check = isset( $meta_variation_check[$key] ) ? $meta_variation_check[$key] : 0;
					
					foreach( $attribute as $j => $option ){
						$variation_color = isset( $meta_variation[$key]['color'][$j] ) ? $meta_variation[$key]['color'][$j] : '';
						$variation_image = isset( $meta_variation[$key]['image'][$j] ) ? $meta_variation[$key]['image'][$j] : 0;
						if( !$variation_check && $variation_color != '' ){
							$class[$j] = 'variation-color';
						}
						if( $variation_check && $variation_image ){
							$class[$j] = 'variation-image';
						}
					}
				}	
				
				$result[$k] = implode( array_unique($class) );
				$k++;
			}
			
			$count = 0;		
			foreach( $attributes as $key => $attribute ){
				$selected_term = isset( $selected_attributes[$key] ) ? $selected_attributes[$key] : '';
		?>	
			<div class="zr-variation-value">
				<div class="zr-custom-variation <?php echo esc_attr( isset( $result[$count] ) ? $result[$count] : '' ); ?>">
				<?php if( taxonomy_exists( $key ) ){ ?>				
					<?php 
						$terms = wc_get_product_terms( $product->get_id(), $key, array( 'fields' => 'all' ) );	
						foreach ( $terms as $i => $term ) {
							$color  	= get_term_meta( $term->term_id, 'zr_variation_color', true );
							$thumb_id 	= absint( get_woocommerce_term_meta( $term->term_id, 'variation_thumbnail_id', true ) );
							$attr 		= ( $color != '' ) ? 'class="variation-color" style="background-color: '. esc_attr( $color ) .';"' : '';
							$active 	= ( checked( sanitize_title( $selected_term ), $term->slug, false ) ) ? ' selected' : '';	
							
							if( $thumb_id ){					
								$attr 	 = ( $thumb_id ) ? 'class="variation-image" style="background-image: url( '. esc_url( wp_get_attachment_thumb_url( $thumb_id ) ) .' );"' : '';
								$img_url = wp_get_attachment_image_src( $thumb_id, $img_size );
							}					
							if ( in_array( $term->slug, $attribute ) ) {
					?>
							<label for="<?php echo esc_attr( $term->slug . '_' . $i . $random_val ) ?>" class="radio-label zr-radio-variation zr-radio-variation-<?php echo esc_attr( $i . $active ) ?>" title="<?php echo esc_attr( $term->slug ) ?>">
								<input type="radio" id="<?php echo esc_attr( $term->slug . '_' . $i . $random_val ) ?>" name="<?php echo esc_attr( 'attribute_' . sanitize_title( $key ) ) ?>" data-attribute_name="attribute_<?php echo esc_attr( sanitize_title( $key ) ) ?>" value="<?php echo esc_attr( $term->slug ) ?>" <?php echo  checked( sanitize_title( $selected_term ), $term->slug, false ) ?>/>
								<span <?php echo $attr; ?>><?php echo $term->name; ?></span>
							</label>
					<?php
							}
						}
					}else{
						$attr = '';
						$variation_check = isset( $meta_variation_check[$key] ) ? $meta_variation_check[$key] : 0;
						foreach( $attribute as $j => $option ){ 
							$variation_color = isset( $meta_variation[$key]['color'][$j] ) ? $meta_variation[$key]['color'][$j] : '';
							$variation_image = isset( $meta_variation[$key]['image'][$j] ) ? $meta_variation[$key]['image'][$j] : 0;
							if( !$variation_check && $variation_color != '' ){
								$attr = 'class="variation-color" style="background-color: '. esc_attr( $variation_color ) .'"';
							}
							if( $variation_check && $variation_image ){
								$attr = 'class="variation-image" style="background-image: url( '. esc_url( wp_get_attachment_thumb_url( $variation_image ) ) .' )"';
							}
							$checked = checked( $selected_term, $option, false );
							$active  = ( $checked ) ? 'selected' : '';
					?>
						<label for="<?php echo esc_attr( $option . '_' . $j . $random_val ) ?>" class="radio-label zr-radio-variation zr-radio-variation-<?php echo esc_attr( $j ) ?>" title="<?php echo esc_attr( $option ) ?>">
							<input type="radio" id="<?php echo esc_attr( $option . '_' . $j . $random_val ) ?>" name="attribute_<?php echo esc_attr( sanitize_title( $key ) ) ?>" data-attribute_name="attribute_<?php echo esc_attr( sanitize_title( $key ) ) ?>" value="<?php echo esc_attr( $option ) ?>" <?php echo $checked ?>/>
							<span <?php echo $attr; ?>><?php echo $option; ?></span>
						</label>
					<?php 
						}
					}
				?>
				</div>
			</div>
			<?php 
				$count ++;
			}
	?>
		</div>
	</div>
<?php 
	}
}
$html = ob_get_clean();
echo apply_filters( 'zr_wooswatches_variation_single_frontend', $html );