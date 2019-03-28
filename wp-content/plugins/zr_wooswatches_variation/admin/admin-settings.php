<?php 
/**
* Admin Settings for SW WooSwatches
**/


class zr_wooswatches_variation_Admin_Settings{
	public static function init(){
		add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
		add_action( 'woocommerce_settings_tabs_settings_zr_wooswatches_variation', __CLASS__ . '::settings_tab' );
		add_action( 'woocommerce_update_options_settings_zr_wooswatches_variation', __CLASS__ . '::update_settings' );
		if( get_option( 'zr_wooswatches_variation_enable' ) == 'yes' ) :
			add_filter( 'woocommerce_product_data_tabs', __CLASS__ . '::add_wooswatches_product_data_tab', 999 );
			add_action( 'woocommerce_product_data_panels',  __CLASS__ . '::add_wooswatches_product_data_fields' );
			add_action( 'woocommerce_process_product_meta',  __CLASS__ . '::save_wooswatches_product_data_fields', 10, 2 );
			add_action( 'admin_print_scripts-post.php', __CLASS__ . '::zr_wooswatches_variation_admin_script', 11 );
		endif;
	}
	
	public static function zr_wooswatches_variation_admin_script(){
		global $post_type;	
		if( 'product' == $post_type ){
			wp_enqueue_script( 'swatches_admin_js', WSURL . '/js/admin/swatches-admin.js' , array(), null, true );
			wp_enqueue_style( 'swatches_admin_style', WSURL . '/css/admin/wooswatches-style.css' , array(), null );
			wp_enqueue_script('category_color_picker_js', WSURL . '/js/admin/category_color_picker.js', array( 'wp-color-picker' ), false, true);
		}
	}
	
	/**
		* Add a new settings tab to the WooCommerce settings tabs array.
		*
		* @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
		* @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
	*/
	public static function add_settings_tab($settings_tabs ) {
		$settings_tabs['settings_zr_wooswatches_variation'] = esc_html__( 'Swatches Variaton', 'zr_wooswatches_variation' );
		return $settings_tabs;
	}
	
	/**
		* Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
		*
		* @uses woocommerce_admin_fields()
		* @uses self::get_settings()
	*/
	public static function settings_tab(){
		woocommerce_admin_fields( self::get_settings() );
	}
	
	/**
	 * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
	 *
	 * @uses woocommerce_update_options()
	 * @uses self::get_settings()
	*/
	public static function update_settings() {
		woocommerce_update_options( self::get_settings() );			
	}
	
	/**
	* Declare option for Swatches Variaton Settings
	**/
	public static function get_settings(){
		$settings = array(
			'section_title' => array(
				'name'     => esc_html__( 'SW WooCommerce Swatches Settings', 'zr_wooswatches_variation' ),
				'type'     => 'title',
				'desc'     => '',
				'id'       => 'wc_setting_section_title'
			),
			
			array(
				'title'         => esc_html__( 'Enable Swatches Variation', 'zr_wooswatches_variation' ),
				'desc'          => esc_html__( 'Uncheck this checkbox to disable WooCommerce Swatches Variation', 'zr_wooswatches_variation' ),
				'id'            => 'zr_wooswatches_variation_enable',
				'default'       => 'yes',
				'type'          => 'checkbox',
				'autoload'      => false,
			),
			
			array(
				'title'         => esc_html__( 'Enable Swatches Variation Listing', 'zr_wooswatches_variation' ),
				'desc'          => esc_html__( 'Check this field to enable swatches variation on product listing.', 'zr_wooswatches_variation' ),
				'id'            => 'zr_wooswatches_variation_enable_listing',
				'default'       => 'no',
				'type'          => 'checkbox',
			),
			
			array(
				'title'         => esc_html__( 'Enable Tooltip', 'zr_wooswatches_variation' ),
				'desc'          => esc_html__( 'Check in this field to enable tooltip on swatches variation.', 'zr_wooswatches_variation' ),
				'id'            => 'zr_wooswatches_variation_tooltip_enable',
				'default'       => 'no',
				'type'          => 'checkbox',
			),
			
			array(
				'title'    => esc_html__( 'Image Tooltip Size', 'zr_wooswatches_variation' ),
				'desc'     => esc_html__( 'Choose image size when tooltip show.', 'zr_wooswatches_variation' ),
				'id'       => 'zr_wooswatches_variation_tooltip_size',
				'class'    => 'wc-enhanced-select',
				'css'      => 'min-width:300px;',
				'default'  => '',
				'type'     => 'select',
				'options'  => array(
					'shop_catalog'  => esc_html__( 'Shop Catalog', 'zr_wooswatches_variation' ),
					'shop_single' 	=> esc_html__( 'Shop Single', 'zr_wooswatches_variation' ),
					'full'          => esc_html__( 'Full', 'zr_wooswatches_variation' ),
				),
				'desc_tip' => true,
			),
						
			array(
				'title'    => esc_html__( 'Product Variation Width', 'zr_wooswatches_variation' ),
				'desc'     => esc_html__( 'px', 'zr_wooswatches_variation' ),
				'id'       => 'zr_wooswatches_variation_w_size',
				'css'      => '',
				'type'     => 'number',
				'default'	 => 40
			),
			
			array(
				'title'    => esc_html__( 'Product Variation Height', 'zr_wooswatches_variation' ),
				'desc'     => esc_html__( 'px', 'zr_wooswatches_variation' ),
				'id'       => 'zr_wooswatches_variation_h_size',
				'css'      => '',
				'type'     => 'number',
				'default'	 => 40
			),
			
			array( 'type' => 'sectionend', 'id' => 'wc_setting_section_endpoint' ),
		);
		return apply_filters( 'zr_wooswatches_variation_settings', $settings );
	}
	
	/**
		* Uses the WooCommerce admin fields API to output settings via the @see woocommerce_product_data_tabs() function.
	*/
	public static function add_wooswatches_product_data_tab( $product_data_tabs ){
		
		$product_data_tabs['zr_wooswatches_variation'] = array(
			'label' => esc_html__( 'Swatches Variaton', 'zr_wooswatches_variation' ),
			'target' => 'zr_wooswatches_variation_data',
			'priority' => 999,
			'class'    => array( 'show_if_variable' ),
		);
		return $product_data_tabs;
	}
	
	/**
		* Uses the WooCommerce admin fields API to output settings via the @see woocommerce_product_data_panels() function.
	*/
	public static function add_wooswatches_product_data_fields(){
		global $post;
		$product       = wc_get_product($post->ID);		  
		$product_type  =  $product->get_type();
		
		$meta_variation_check = get_post_meta( $post->ID,  'zr_variation_check', true );
		$meta_variation       = get_post_meta( $post->ID,  'zr_variation', true ); 
		
		if( $product_type == 'variable' ) :
			$product = new WC_Product_Variable( $post->ID );
			$attributes = $product->get_variation_attributes();
		endif;
		
		
		if( !empty( $attributes ) && sizeof( $attributes ) > 0 ) :
			include( WSPATH. '/admin/admin-metabox.php' ); /* include metabox product variation */
		endif;
	}	
	
	/**
		* Uses the WooCommerce admin fields API to output settings via the @see woocommerce_process_product_meta() function.
	*/
	function save_wooswatches_product_data_fields( $post_id ){
		$variation_check = ( isset( $_POST['zr_variation_check'] ) ) ? $_POST['zr_variation_check'] : array();
		update_post_meta( $post_id, 'zr_variation_check', $variation_check );
		
		if( isset( $_POST['zr_variation'] ) ){
			update_post_meta( $post_id, 'zr_variation', $_POST['zr_variation'] );
		}
	}
}

zr_wooswatches_variation_Admin_Settings::init();