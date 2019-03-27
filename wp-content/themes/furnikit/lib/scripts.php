<?php
/**
 * Enqueue scripts and stylesheets
 *
 */

function furnikit_scripts() {	
	$scheme_meta = get_post_meta( get_the_ID(), 'scheme', true );
	$scheme = ( $scheme_meta != '' && $scheme_meta != 'none' ) ? $scheme_meta : zr_options('scheme');
	$furnikit_direction = zr_options('direction');
	
	$app_css 	= get_template_directory_uri() . '/css/app-default.css';
	$mobile_css = get_template_directory_uri() . '/css/mobile/mobile-default.css';
	if ( $scheme ){
		$app_css 	= get_template_directory_uri() . '/css/app-'.$scheme.'.css';
		$mobile_css = get_template_directory_uri() . '/css/mobile-'.$scheme.'.css';
		
	} 
	wp_dequeue_style('fontawesome');
	wp_dequeue_style('slick-slider_css');
	wp_dequeue_style('fontawesome_css');
	wp_dequeue_style('shortcode_css');
	wp_dequeue_style('yith-wcwl-font-awesome');
	wp_dequeue_style('tabcontent_styles');	
	
	/* enqueue script & style */
	if ( !is_admin() ){			
		wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), null);	
		wp_enqueue_style('furnikit_css', $app_css, array(), null);
		wp_enqueue_script('plugins', get_template_directory_uri() . '/js/jquery.plugin.min.js', array('jquery'), null, true);
		wp_enqueue_script('loadimage', get_template_directory_uri() . '/js/load-image.min.js', array('jquery'), null, true);
		wp_enqueue_script('bootstrap_js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), null, true);
		wp_enqueue_script('slick-slider',get_template_directory_uri().'/js/slick.min.js',array(),null,true);
		wp_enqueue_script('isotope_script', get_template_directory_uri() . '/js/isotope.js', array(), null, true);
		wp_enqueue_script('wc-quantity', get_template_directory_uri() . '/js/wc-quantity-increment.min.js', array('jquery'), null, true);
		
		if( is_rtl() || $furnikit_direction == 'rtl' ){
			wp_enqueue_style('rtl_css', get_template_directory_uri() . '/css/rtl.css', array(), null);
		}
		wp_enqueue_style('furnikit_responsive_css', get_template_directory_uri() . '/css/app-responsive.css', array(), null);
		
		/* Load style.css from child theme */
		if (is_child_theme()) {
			wp_enqueue_style('furnikit_child_css', get_stylesheet_uri(), false, null);
		}
		
		if( !wp_script_is( 'jquery-cookie' ) ){
			wp_enqueue_script('plugins_js');
		}
	}
	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}		
	
	if ( !is_admin() ){
		wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr-2.6.2.min.js', false, null, false);
		
		$translation_text = array(
			'cart_text' 		 => esc_html__( 'Add To Cart', 'furnikit' ),
			'compare_text' 	 => esc_html__( 'Add To Compare', 'furnikit' ),
			'wishlist_text'  => esc_html__( 'Add To WishList', 'furnikit' ),
			'quickview_text' => esc_html__( 'QuickView', 'furnikit' ),
			'ajax_url' => admin_url( 'admin-ajax.php', 'relative' ), 
			'redirect' => get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ),
			'message' => esc_html__( 'Please enter your usename and password', 'furnikit' ),
		);
		
		wp_localize_script( 'furnikit_custom_js', 'custom_text', $translation_text );
		wp_enqueue_script( 'furnikit_custom_js', get_template_directory_uri() . '/js/main.js', array(), null, true );
	}
	
	$overflow_text = array(
		'more_text' => esc_html__( 'More...', 'furnikit' ),
		'more_menu'	=> zr_options( 'more_menu' )
	);
	wp_register_script('menu-overflow', get_template_directory_uri() . '/js/menu-overflow.js', array(), null, true);
	wp_localize_script( 'menu-overflow', 'menu_text', $overflow_text );
	wp_enqueue_script( 'menu-overflow' );
	
	/*
	** QuickView
	*/
	if( class_exists( 'WooCommerce' ) ) {
		global $woocommerce;
		$assets_path          = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';
		$frontend_script_path = $assets_path . 'js/frontend/';
		$wc_ajax_url 					= WC_AJAX::get_endpoint( "%%endpoint%%" );
		$admin_url 						= admin_url('admin-ajax.php');	
		$furnikit_dest_folder = ( function_exists( 'zr_wooswatches_construct' ) ) ? 'woocommerce' : 'woocommerce_select';
		$woocommerce_params = array(
			'ajax'  => array(
				'url'	=> $admin_url
			)
		);
		$_wpUtilSettings = array(
			'ajax_url'     => $woocommerce->ajax_url(),
			'wc_ajax_url'  => 	$wc_ajax_url
		);
		$wc_add_to_cart_variation_params = array(
			'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'furnikit' ),
			'i18n_make_a_selection_text'       => esc_attr__( 'Please select some product options before adding this product to your cart.', 'furnikit' ),
			'i18n_unavailable_text'            => esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.', 'furnikit' ),
		);
		
		$quickview_text = array(			
			'ajax_url' => WC_AJAX::get_endpoint( "%%endpoint%%" ), 			
			'wp_embed' => esc_url ( home_url('/') . 'wp-includes/js/wp-embed.min.js' ),
			'underscore' =>  esc_url ( home_url('/') . 'wp-includes/js/underscore.min.js' ),
			'wp_util' =>  esc_url ( home_url('/') . 'wp-includes/js/wp-util.min.js' ),
			'add_to_cart' => esc_url( $frontend_script_path . 'add-to-cart.min.js' ),
			'woocommerce' => esc_url( $frontend_script_path . 'woocommerce.min.js' ),
			'add_to_cart_variable' => esc_url( get_template_directory_uri() . '/js/'. $furnikit_dest_folder .'/add-to-cart-variation.min.js' ),
			'wpUtilSettings' => json_encode( $_wpUtilSettings ),
			'woocommerce_params' => json_encode( $woocommerce_params ),
			'wc_add_to_cart_variation_params' => json_encode( $wc_add_to_cart_variation_params )
		);
		wp_register_script('zr-quickview', get_template_directory_uri() . '/js/quickview.js', array(), null, true);
		wp_localize_script( 'zr-quickview', 'quickview_param', $quickview_text );
		wp_enqueue_script( 'zr-quickview' );
		
	}
	
	/*
	** Dequeue and enqueue css, js mobile
	*/
	if( furnikit_mobile_check() ) :
		if( is_front_page() || is_home() ) :
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		endif;
		if( !zr_options( 'mobile_jquery' ) ){
			wp_dequeue_script( 'tp-tools' );
			wp_dequeue_script( 'revmin' );
		}
		wp_dequeue_style( 'jquery-colorbox' );
		wp_dequeue_style( 'colorbox' );
		wp_dequeue_script( 'jquery-colorbox' );
		wp_dequeue_script( 'isotope_script' );		
		wp_dequeue_script( 'furnikit_megamenu' );
		wp_dequeue_script( 'moneyjs' );
		wp_dequeue_script( 'accountingjs' );
		wp_dequeue_script( 'wc_currency_converter' );
		wp_dequeue_script( 'yith-woocompare-main' );
		wp_enqueue_style('mobile_css', $mobile_css, array(), null);
	endif;
	
	/*
	** Dequeue some css and jquery mobile responsive
	*/
	
	global $zr_detect;
	if( !empty( $zr_detect ) && $zr_detect->isMobile() && !$zr_detect->isTablet() ){
		wp_dequeue_style( 'jquery-colorbox' );
		wp_dequeue_style( 'colorbox' );
		wp_dequeue_script( 'jquery-colorbox' );
		wp_dequeue_script( 'isotope_script' );
		wp_dequeue_script( 'furnikit_megamenu' );
		wp_dequeue_script( 'yith-woocompare-main' );
		wp_enqueue_script( 'furnikit_mobile_js', get_template_directory_uri(). '/js/mobiles.js', array(), null, true);	
		if( !is_singular( 'product' ) ){
			wp_dequeue_script( 'slick-slider' );
		}
	}
}
add_action('wp_enqueue_scripts', 'furnikit_scripts', 100);
