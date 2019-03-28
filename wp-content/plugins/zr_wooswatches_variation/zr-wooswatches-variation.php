<?php 
/**
 * Plugin Name: Zr Woocommerce Swatches Variation
 * Plugin URI: http://www.9xthemes.com/
 * Description: A plugin help to display variable product more beauty.
 * Version: 1.0.5
 * Author: 9xthemes
 * Author URI: http://www.9xthemes.com/
 * Requires at least: 4.1
 * Tested up to: WorPress 5.1.x and WooCommerce 3.5.x
 * WC tested up to: 3.5.0
 * Text Domain: zr_wooswatches_variation
 * Domain Path: /languages/
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// define plugin path
if ( ! defined( 'WSPATH' ) ) {
	define( 'WSPATH', plugin_dir_path( __FILE__ ) );
}

// define plugin URL
if ( ! defined( 'WSURL' ) ) {
	define( 'WSURL', plugins_url(). '/zr_wooswatches_variation' );
}

// define plugin theme path
if ( ! defined( 'WSTHEME' ) ) {
	define( 'WSTHEME', plugin_dir_path( __FILE__ ). 'includes/themes' );
}

function zr_wooswatches_variation_construct(){
	global $woocommerce;

	if ( ! isset( $woocommerce ) || ! function_exists( 'WC' ) ) {
		add_action( 'admin_notices', 'zr_wooswatches_variation_admin_notice' );
		return;
	}
	
	/* Enqueue Script */
	add_action( 'wp_enqueue_scripts', 'zr_wooswatches_variation_custom_script', 1001 );
	
	/* Load text domain */
	load_plugin_textdomain( 'zr_wooswatches_variation', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	
	/* Include files */
	require_once( WSPATH . '/admin/admin-settings.php' );
	require_once( WSPATH . '/admin/admin-attribute-metabox.php' );
	require_once( WSPATH . '/includes/inc.php' );
}

add_action( 'plugins_loaded', 'zr_wooswatches_variation_construct', 20 );


/*
** Load admin notice when WooCommerce not active
*/
function zr_wooswatches_variation_admin_notice(){
	?>
	<div class="error">
		<p><?php _e( 'Swatches Variaton is enabled but not effective. It requires WooCommerce in order to work.', 'zr_wooswatches_variation' ); ?></p>
	</div>
<?php
}

/*
** Load Custom variation script
*/
function zr_wooswatches_variation_custom_script(){	
	if( current_theme_supports( 'zr_theme' ) || get_option( 'zr_wooswatches_variation_enable' ) === 'yes' ) :
		wp_dequeue_script('wc-add-to-cart-variation');	
		wp_dequeue_script('wc-single-product');
		wp_deregister_script('wc-add-to-cart-variation');
		wp_deregister_script('wc-single-product');
		$w_folder = ( ! current_theme_supports( 'zr_theme' ) ) ? 'woocommerce' : 'woocommerce/custom';
		if( get_option( 'zr_wooswatches_variation_enable' ) === 'no' ){
			$w_folder = 'woocommerce-select';
		}
		wp_enqueue_style( 'zr-wooswatches', plugins_url( 'css/style.css', __FILE__ ), array(), null );	
		if( is_singular( 'product' ) ) :
			wp_enqueue_script( 'wc-single-product', WSURL . '/js/'. $w_folder .'/single-product.min.js', array( 'jquery' ), null, true );
			wp_enqueue_script( 'wc-add-to-cart-variation', WSURL . '/js/'. $w_folder .'/add-to-cart-variation.min.js', array( 'jquery', 'wp-util' ),null, true  );
		else:
			wp_enqueue_script( 'wc-add-to-cart-variation', WSURL . '/js/'. $w_folder .'/add-to-cart-variation.js', array( 'jquery', 'wp-util' ),null, true  );
		endif;
		
		wp_enqueue_script( 'add-to-cart-variation-ajax', WSURL . '/js/add-to-cart-variation-ajax.js', array( 'jquery' ), null, true );
		wp_localize_script( 'add-to-cart-variation-ajax', 'AddToCartAjax', array(
			'ajaxurl' => WC_AJAX::get_endpoint( "%%endpoint%%" )	 
		));
		
	endif;
}