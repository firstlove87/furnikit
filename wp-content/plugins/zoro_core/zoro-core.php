<?php
/**
 * Plugin Name: ZORO Core
 * Plugin URI: http://www.zorotheme.com
 * Description: A plugin developed for many shortcode in theme
 * Version: 1.0.0
 * Author: Zorotheme
 * Author URI: http://www.zorotheme.com
 * This plugin help you build your own site easy with many shortcode.
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

if( !function_exists( 'is_plugin_active' ) ){
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

/* define plugin path */
if ( ! defined( 'ZRPATH' ) ) {
	define( 'ZRPATH', plugin_dir_path( __FILE__ ) );
}

/* define plugin URL */
if ( ! defined( 'ZRURL' ) ) {
	define( 'ZRURL', plugins_url(). '/zoro_core' );
}

/* define plugin URL */
if ( ! defined( 'ZR_OPTIONS_URL' ) ) {
	define( 'ZR_OPTIONS_URL', ZRURL . '/includes' );
}

/* define plugin URL */
if ( ! defined( 'ZR_OPTIONS_DIR' ) ) {
	define( 'ZR_OPTIONS_DIR', ZRPATH . 'includes' );
}


// define plugin theme path
if ( ! defined( 'ZRTHEME' ) ) {
	define( 'ZRTHEME', plugin_dir_path( __FILE__ ). 'woocommerce/themes' );
}

function zr_core_construct(){
	if ( !defined( 'ICL_LANGUAGE_CODE' ) ){
		if( !defined( 'ZR_THEME' ) ){
			define( 'ZR_THEME', 'mocha_theme' );
		}
	}else{
		if( !defined( 'ZR_THEME' ) ){
			define( 'ZR_THEME', 'mocha_theme' . '_' .ICL_LANGUAGE_CODE );
		}
	}
	
	/*
	** Require file
	*/
	require_once( ZRPATH . 'zr_plugins/zr-plugins.php' );	
	require_once( ZRPATH . 'includes/functions.php' );	
	
	if( class_exists( 'WooCommerce' ) ) :
		require_once ( ZRPATH . '/woocommerce/zr-woocommerce.php' );
	endif;
	
	/*
	** Load text domain
	*/
	load_plugin_textdomain( 'zr_core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	
	/*
	** Call action and filter
	*/
	add_filter('style_loader_tag', 'zr_clean_style_tag');
	add_filter('widget_text', 'do_shortcode');
	add_action('init', 'zr_head_cleanup');
	
	global $woocommerce;
	if ( ! isset( $woocommerce ) || ! function_exists( 'WC' ) ) {
		add_action( 'admin_notices', 'zr_core_admin_notice' );
		return;
	}
	
	if ( class_exists( 'Vc_Manager' ) ) {
		add_action( 'vc_frontend_editor_render', 'zr_enqueueJsFrontend' );
	}
	add_action( 'wp_enqueue_scripts', 'zr_addScript', 99 );

}

add_action( 'plugins_loaded', 'zr_core_construct', 20 );

function zr_core_admin_notice(){
	?>
	<div class="error">
		<p><?php _e( 'Zr Woocommerce is enabled but not effective. It requires WooCommerce in order to work.', 'zr_core' ); ?></p>
	</div>
<?php
}

/**
 * Clean up output of stylesheet <link> tags
 */
function zr_clean_style_tag($input) {
	preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
	$media = $matches[3][0] === 'print' ? ' media="print"' : '';
	return '<link rel="stylesheet" href="' . esc_url( $matches[2][0] ) . '"' . $media . '>' . "\n";
}


function zr_head_cleanup() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action('init', 'zr_head_cleanup');

/*
** Enqueue Script
*/
function zr_enqueueJsFrontend(){
	wp_register_script( 'slick-slider', plugins_url( 'js/slick.min.js', __FILE__ ),array(), null, true );	
	wp_register_script( 'custom_js', plugins_url( 'js/custom_js.js', __FILE__ ),array( 'slick-slider' ), null, true );	
	wp_enqueue_script('custom_js');
}

function zr_addScript(){
	wp_register_style('zr_photobox_css', ZRURL . '/css/photobox.css', array(), null);	
	wp_register_script('photobox_js', ZRURL . '/js/photobox.js', array(), null, true);	
	
	wp_register_script( 'slick-slider', ZRURL . '/js/slick.min.js',array(), null, true );		
	if (!wp_script_is('slick-slider')) {
		wp_enqueue_script('slick-slider');
	}
	wp_register_script( 'countdown_slider_js', ZRURL . '/js/jquery.countdown.min.js',array(), null, true );		
	if (!wp_script_is('countdown_slider_js')) {
		wp_enqueue_script('countdown_slider_js');
	}	
}

/*
 * Vertical mega menu
 *
 */
function zr_vertical_megamenu_shortcode($atts){
	extract( shortcode_atts( array(
		'menu_locate' =>'',
		'title'  =>'',
		'el_class' => ''
	), $atts ) );
	ob_start();
	
	$output = '<div class="vc_wp_custommenu wpb_content_element ' . $el_class . '">';
	if($title != ''){
		$output.='<div class="mega-left-title">
			<strong>'.$title.'</strong>
		</div>';
	}
	$output.='<div class="wrapper_vertical_menu vertical_megamenu">';
	
	$output .= wp_nav_menu( array( 'theme_location' => 'vertical_menu', 'menu_class' => 'nav vertical-megamenu' ) );
	$output .= '</div></div>';
	$output .= ob_get_clean();
	return $output;
}
add_shortcode('zr_mega_menu','zr_vertical_megamenu_shortcode');
	
	
/**
 * Clean up gallery_shortcode()
 *
 * Re-create the [gallery] shortcode and use thumbnails styling from Bootstrap
 *
 * @link http://twitter.github.com/bootstrap/components.html#thumbnails
 */
function zr_gallery($attr) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if (!empty($attr['ids'])) {
		if (empty($attr['orderby'])) {
			$attr['orderby'] = 'post__in';
		}
		$attr['include'] = $attr['ids'];
	}

	$output = apply_filters('post_gallery', '', $attr);

	if ($output != '') {
		return $output;
	}

	if (isset($attr['orderby'])) {
		$attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
		if (!$attr['orderby']) {
			unset($attr['orderby']);
		}
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => '',
		'icontag'    => '',
		'captiontag' => '',
		'columns'    => 3,
		'size'       => 'medium',
		'include'    => '',
		'exclude'    => ''
		), $attr)
	);

	$id = intval($id);

	if ($order === 'RAND') {
		$orderby = 'none';
	}

	if (!empty($include)) {
		$_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

		$attachments = array();
		foreach ($_attachments as $key => $val) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif (!empty($exclude)) {
		$attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
	} else {
		$attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
	}

	if (empty($attachments)) {
		return '';
	}

	if (is_feed()) {
		$output = "\n";
		foreach ($attachments as $att_id => $attachment) {
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		}
		return $output;
	}
	
	if (!wp_style_is('zr_photobox_css')){
		wp_enqueue_style('zr_photobox_css');
	}
	
	if (!wp_enqueue_script('photobox_js')){
		wp_enqueue_script('photobox_js');
	}
	
	$output = '<ul id="photobox-gallery-' . esc_attr( $instance ). '" class="thumbnails photobox-gallery gallery gallery-columns-'.esc_attr( $columns ).'">';

	$i = 0;
	$width = 100/$columns - 1;
	foreach ($attachments as $id => $attachment) {
		//$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
		$link = '<a class="thumbnail" href="' .esc_url( wp_get_attachment_url($id) ) . '">';
		$link .= wp_get_attachment_image($id, $size);
		$link .= '</a>';
		
		$output .= '<li style="width: '.esc_attr( $width ).'%;">' . $link;
		$output .= '</li>';
	}

	$output .= '</ul>';
	
	add_action('wp_footer', 'zr_add_script_gallery', 50);
	
	return $output;
}
add_action( 'after_setup_theme', 'zr_setup_gallery', 20 );
function zr_setup_gallery(){
	if ( current_theme_supports('bootstrap-gallery') ) {
		remove_shortcode('gallery');
		add_shortcode('gallery', 'zr_gallery');
	}
}

function zr_add_script_gallery() {
	$script = '';
	$script .= '<script type="text/javascript">
				jQuery(document).ready(function($) {
					try{
						// photobox
						$(".photobox-gallery").each(function(){
							$("#" + this.id).photobox("li a");
							// or with a fancier selector and some settings, and a callback:
							$("#" + this.id).photobox("li:first a", { thumbs:false, time:0 }, imageLoaded);
							function imageLoaded(){
								console.log("image has been loaded...");
							}
						})
					} catch(e){
						console.log( e );
					}
				});
			</script>';
	
	echo $script;
}

/*
* Get URL shortcode
*/
function get_url($atts) {
	if(is_front_page()){
		$frontpage_ID = get_option('page_on_front');
		$link =  get_site_url().'/?page_id='.$frontpage_ID ;
		return $link;
	}
	elseif(is_page()){
		$pageid = get_the_ID();
		$link = get_site_url().'/?page_id='.$pageid ;
		return $link;
	}
	else{
		$link = $_SERVER['REQUEST_URI'];
		return $link;
	}
}
add_shortcode( 'get_url', 'get_url' );