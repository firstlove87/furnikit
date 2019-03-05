<?php 
/**
 * ZR WooCommerce Widget Functions
 *
 * Widget related functions and widget registration
 *
 * @author 		flytheme
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include_once( 'zr-widgets/zr-brand.php' );
include_once( 'zr-widgets/zr-slider-widget.php' );
include_once( 'zr-widgets/zr-slider-countdown-widget.php' );
include_once( 'zr-widgets/zr-woo-tab-slider-widget.php' );
include_once( 'zr-widgets/zr-category-slider-widget.php' );
include_once( 'zr-widgets/zr-related-upsell-widget.php' );
include_once( 'zr-widgets/zr-woo-tab-categories.php' );

/**
 * Register Widgets
**/
function zr_register_widgets() {
	register_widget( 'zr_brand_slider_widget' );
	register_widget( 'zr_woo_cat_slider_widget' );
	register_widget( 'zr_woo_slider_widget' );	
	register_widget( 'zr_woo_slider_countdown_widget' );	
	register_widget( 'zr_woo_tab_slider_widget' );
	register_widget( 'zr_woo_tab_categories' );
	register_widget( 'zr_related_upsell_widget' );
}
add_action( 'widgets_init', 'zr_register_widgets' );

/*
** Get timezone offset for countdown
*/
function zr_timezone_offset( $countdowntime ){
	$timeOffset = 0;	
	if( get_option( 'timezone_string' ) != '' ) :
		$timezone = get_option( 'timezone_string' );
		$dateTimeZone = new DateTimeZone( $timezone );
		$dateTime = new DateTime( "now", $dateTimeZone );
		$timeOffset = $dateTimeZone->getOffset( $dateTime );
	else :
		$dateTime = get_option( 'gmt_offset' );
		$dateTime = intval( $dateTime );
		$timeOffset = $dateTime * 3600;
	endif;
	$offset =  ( $timeOffset < 0 ) ? '-' . gmdate( "H:i", abs( $timeOffset ) ) : '+' . gmdate( "H:i", $timeOffset );
	
	$date = date( 'Y/m/d H:i:s', $countdowntime );
	$date1 = new DateTime( $date );
	$cd_date =  $date1->format('Y-m-d H:i:s') . $offset;
	
	return strtotime( $cd_date ); 
}

/*
** Sales label
*/
function zr_label_sales(){
	global $product;
	$product_id = ( zr_woocommerce_version_check( '3.0' ) ) ? $product->get_id() : $product->id;
	$forginal_price 	= get_post_meta( $product_id, '_regular_price', true );	
	$fsale_price 		= get_post_meta( $product_id, '_sale_price', true );
	if( $fsale_price > 0 && $product->is_on_sale() ){ 
	$sale_off = 100 - ( ( $fsale_price/$forginal_price ) * 100 ); 
?>
		<div class="sale-off">
			<?php echo '-' . round( $sale_off ).'%';?>
		</div>

<?php 
	} 
}

/*
** Check quickview
*/
function zr_quickview(){
	global $product;
	$html='';
	if( function_exists( 'mocha_options' ) ){
		$quickview = mocha_options()->getCpanelValue( 'product_quickview' );
	}
	if( $quickview ):
		$html = '<a href="javascript:void(0)" data-product_id="'. esc_attr( $product->get_id() ) .'" class="zr-quickview" data-type="quickview" data-ajax_url="' . WC_AJAX::get_endpoint( "%%endpoint%%" ) . '">'. esc_html__( 'Quick View ', 'mocha' ) .'</a>';	
	endif;
	return $html;
}

/*
** Trim Words
*/
function zr_trim_words( $title, $title_length = 0 ){
	$html = '';
	if( $title_length > 0 ){
		$html .= wp_trim_words( $title, $title_length, '...' );
	}else{
		$html .= $title;
	}
	echo esc_html( $html );
}

/*
** Zr Ajax URL
*/
function zr_ajax_url(){
	$ajaxurl = version_compare( WC()->version, '2.4', '>=' ) ? WC_AJAX::get_endpoint( "%%endpoint%%" ) : admin_url( 'admin-ajax.php', 'relative' );
	return $ajaxurl;
}

/*
** Check override template
*/
function zr_override_check( $path, $file ){
	$paths = '';
	if( locate_template( 'zr_woocommerce/'.$path . '/' . $file ) ){
		$paths = get_template_directory() . '/zr_woocommerce/' . $path . '/' . $file . '.php';
	}else{
		$paths = ZRTHEME . '/' . $path . '/' . $file . '.php';
	}
	return $paths;
}

/*
** Add Multi Select Param
*/
if( class_exists( 'Vc_Manager' ) ) :
	vc_add_shortcode_param( 'multiselect', 'zr_mselect_settings_field' );
	function zr_mselect_settings_field( $settings, $value ) {
		$output = '';
		$values = explode( ',', $value );
		$output .= '<select name="'
							 . $settings['param_name']
							 . '" class="wpb_vc_param_value wpb-input wpb-select '
							 . $settings['param_name']
							 . ' ' . $settings['type']
							 . '" multiple="multiple">';
		if ( is_array( $value ) ) {
			$value = isset( $value['value'] ) ? $value['value'] : array_shift( $value );
		}
		if ( ! empty( $settings['value'] ) ) {
			foreach ( $settings['value'] as $index => $data ) {
				if ( is_numeric( $index ) && ( is_string( $data ) || is_numeric( $data ) ) ) {
					$option_label = $data;
					$option_value = $data;
				} elseif ( is_numeric( $index ) && is_array( $data ) ) {
					$option_label = isset( $data['label'] ) ? $data['label'] : array_pop( $data );
					$option_value = isset( $data['value'] ) ? $data['value'] : array_pop( $data );
				} else {
					$option_value = $data;
					$option_label = $index;
				}
				$selected = '';
				$option_value_string = (string) $option_value;
				$value_string = (string) $value;
				$selected = (is_array($values) && in_array($option_value, $values))?' selected="selected"':'';
				$option_class = str_replace( '#', 'hash-', $option_value );
				$output .= '<option class="' . esc_attr( $option_class ) . '" value="' . esc_attr( $option_value ) . '"' . $selected . '>'
									 . htmlspecialchars( $option_label ) . '</option>';
			}
		}
		$output .= '</select>';

		return $output;
	}
endif;

/*
** WooCommerce Compare Version
*/
if( !function_exists( 'zr_woocommerce_version_check' ) ) :
	function zr_woocommerce_version_check( $version = '3.0' ) {
		global $woocommerce;
		if( version_compare( $woocommerce->version, $version, ">=" ) ) {
			return true;
		}else{
			return false;
		}
	}
endif;

/*
** Check Visible
*/
function zr_check_product_visiblity( $query ) {
	$query['tax_query']['relation'] = 'AND';
	$product_visibility_terms  = wc_get_product_visibility_term_ids();
	if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
		$product_visibility_not_in[] = $product_visibility_terms['outofstock'];
	}
	if ( ! empty( $product_visibility_not_in ) ) {
		$query['tax_query'][] = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'term_taxonomy_id',
			'terms'    => $product_visibility_not_in,
			'operator' => 'NOT IN',
		);
	}
	return $query;
}

/*
** Product Meta
*/
add_action("admin_init", "post_init");
add_action( 'save_post', 'zr_product_save_meta', 10, 1 );
function post_init(){
	add_meta_box("zr_product_meta", esc_html__( 'Product Meta:', 'zr_woocommerce' ), "zr_product_meta", "product", "side", "low");
	add_meta_box("zr_product_video_meta", esc_html__( 'Featured Video Product', 'zr_woocommerce' ), "zr_product_video_meta", "product", "side", "low");
}	
function zr_product_meta(){
	global $post;
	$recommend_product = get_post_meta( $post->ID, 'recommend_product', true );
	$newproduct 	   = get_post_meta( $post->ID, 'newproduct', true );
?>
	<p><label><b><?php esc_html_e( 'Recommend Product:', 'zr_woocommerce' ) ?></b></label> &nbsp;&nbsp;
	<input type="checkbox" name="recommend_product" value="1" <?php echo checked( $recommend_product, 1 ) ?> /></p>
	
	<p><label><b><?php esc_html_e( 'New Product', 'zr_woocommerce' ) ?></b></label> &nbsp;&nbsp;
		<input type="number" name="newproduct" value="<?php echo esc_attr( $newproduct ) ?>"/>
		<span class="p-description"><?php echo esc_html__( 'Set day for the new product label from the date publish product.', 'zr_woocommerce' ); ?></span>
	</p>
<?php }

function zr_product_video_meta(){
	global $post;
	$featured_video_product = get_post_meta( $post->ID, 'featured_video_product', true );
?>
	<div class="featured-image">
		<?php if( $featured_video_product != '' ) : ?>
		<div class="video-wrapper">
			<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo esc_attr( $featured_video_product ); ?>" frameborder="0" allowfullscreen></iframe>
		</div>
		<?php endif; ?>
		<p><input type="text" name="featured_video_product" placeholder="<?php echo esc_attr__( 'Youtube Video ID', 'zr_woocommerce' ) ?>" value="<?php echo esc_attr( $featured_video_product ); ?>"/></p>
	</div>
<?php 
}

function zr_product_save_meta( $post_id ){
	$meta_val = ( isset( $_POST['recommend_product'] ) ) ? $_POST['recommend_product'] : 0;
	update_post_meta( $post_id, 'recommend_product', $meta_val );
	if( isset( $_POST['featured_video_product'] ) ){
		update_post_meta( $post_id, 'featured_video_product', $_POST['featured_video_product'] );
	}
	if( isset( $_POST['newproduct'] ) ){
		update_post_meta( $post_id, 'newproduct', intval( $_POST['newproduct'] ) );
	}
}
/*end product meta*/