<?php
/**
 * furnikit initial setup and constants
 */
function furnikit_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'furnikit', get_template_directory() . '/lang' );

	// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
	register_nav_menus(array(
		'primary_menu' => esc_html__('Primary Menu', 'furnikit'),
	));
	
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'zr_theme' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	if( zr_options( 'product_zoom' ) ) :
		add_theme_support( 'wc-product-gallery-zoom' );
	endif;
	
	add_image_size( 'furnikit_blog-responsive', 560, 400, true );
	add_theme_support( "title-tag" );
		
	// Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
	add_theme_support('post-thumbnails');

	// Add post formats (http://codex.wordpress.org/Post_Formats)
	add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
	
	// Custom image header
	$furnikit_header_arr = array(
		'default-image' => get_template_directory_uri().'/assets/img/logo-default.png',
		'uploads'       => true
	);
	add_theme_support( 'custom-header', $furnikit_header_arr );
	
	// Custom Background 
	$furnikit_bgarr = array(
		'default-color' => 'ffffff',
		'default-image' => '',
	);
	add_theme_support( 'custom-background', $furnikit_bgarr );
	
	// Tell the TinyMCE editor to use a custom stylesheet
	add_editor_style( 'css/editor-style.css' );
	
	new Furnikit_Menu();
}
add_action('after_setup_theme', 'furnikit_setup');