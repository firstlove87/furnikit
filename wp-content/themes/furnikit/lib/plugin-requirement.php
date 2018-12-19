<?php
/***** Active Plugin ********/
require_once( get_template_directory().'/lib/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'furnikit_register_required_plugins' );
function furnikit_register_required_plugins() {
    $plugins = array(
		array(
            'name'               => esc_html__( 'WooCommerce', 'furnikit' ), 
            'slug'               => 'woocommerce', 
            'required'           => true, 
			'version'			 => '3.4.5'
        ),

         array(
            'name'               => esc_html__( 'Revslider', 'furnikit' ), 
            'slug'               => 'revslider', 
            'source'             => esc_url( get_template_directory_uri() . '/lib/plugins/revslider.zip' ), 
            'required'           => true, 
            'version'            => '5.4.8'
        ),
		
		array(
            'name'     			 => esc_html__( 'SW Core', 'furnikit' ),
            'slug'      		 => 'zr_core',
			'source'         	 => esc_url( get_template_directory_uri() . '/lib/plugins/zr_core.zip' ), 
            'required'  		 => true,   
			'version'			 => '1.6.0'
		),
		
		array(
            'name'     			 => esc_html__( 'SW WooCommerce', 'furnikit' ),
            'slug'      		 => 'zr_woocommerce',
			'source'         	 => esc_url( get_template_directory_uri() . '/lib/plugins/zr_woocommerce.zip' ), 
            'required'  		 => true,
			'version'			 => '1.6.2'
        ),
		
		array(
            'name'     			 => esc_html__( 'SW Ajax Woocommerce Search', 'furnikit' ),
            'slug'      		 => 'zr_ajax_woocommerce_search',
			'source'         	 => esc_url( get_template_directory_uri() . '/lib/plugins/zr_ajax_woocommerce_search.zip' ), 
            'required'  		 => true,
			'version'			 => '1.1.5'
        ),
		
		array(
            'name'     			 => esc_html__( 'SW Wooswatches', 'furnikit' ),
            'slug'      		 => 'zr_wooswatches',
			'source'         	 => esc_url( get_template_directory_uri() . '/lib/plugins/zr_wooswatches.zip' ), 
            'required'  		 => true,
			'version'			 => '1.0.5'
        ),
				
		array(
            'name'               => esc_html__( 'One Click Install', 'furnikit' ), 
            'slug'               => 'one-click-demo-import', 
            'source'             => esc_url( get_template_directory_uri() . '/lib/plugins/one-click-demo-import.zip' ), 
            'required'           => true, 
        ),
		array(
            'name'               => esc_html__( 'Visual Composer', 'furnikit' ), 
            'slug'               => 'js_composer', 
            'source'             => esc_url( get_template_directory_uri() . '/lib/plugins/js_composer.zip' ), 
            'required'           => true, 
            'version'            => '5.5.4'
        ),	
		array(
            'name'      		 => esc_html__( 'MailChimp for WordPress Lite', 'furnikit' ),
            'slug'     			 => 'mailchimp-for-wp',
            'required' 			 => false,
        ),
		array(
            'name'      		 => esc_html__( 'Contact Form 7', 'furnikit' ),
            'slug'     			 => 'contact-form-7',
            'required' 			 => false,
        ),
		array(
            'name'      		 => esc_html__( 'YITH Woocommerce Compare', 'furnikit' ),
            'slug'      		 => 'yith-woocommerce-compare',
            'required'			 => false
        ),
		 array(
            'name'     			 => esc_html__( 'YITH Woocommerce Wishlist', 'furnikit' ),
            'slug'      		 => 'yith-woocommerce-wishlist',
            'required' 			 => false
        ), 
		array(
            'name'     			 => esc_html__( 'WordPress Seo', 'furnikit' ),
            'slug'      		 => 'wordpress-seo',
            'required'  		 => false,
        ),

    );		
    $config = array();

    tgmpa( $plugins, $config );

}
add_action( 'vc_before_init', 'furnikit_vcSetAsTheme' );
function furnikit_vcSetAsTheme() {
    vc_set_as_theme();
}