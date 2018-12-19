<?php
/**
 * Wordpress Less
*/

if($wp_config = @file_get_contents(ABSPATH."wp-config.php") ){
	if( !preg_match_all("/WP_MEMORY_LIMIT/", $wp_config, $output_array) ) {
		$wp_config = str_replace("\$table_prefix", "define('WP_MEMORY_LIMIT', '256M');\n\$table_prefix", $wp_config);
		@file_put_contents(ABSPATH."wp-config.php", $wp_config);
	}
}

function recurse_copy($src,$dst) {
	$dir = opendir($src);
	@mkdir($dst);
	while(false !== ( $file = readdir($dir)) ) {
		if (( $file != '.' ) && ( $file != '..' )) {
			if ( is_dir($src . '/' . $file) ) {
				recurse_copy($src . '/' . $file,$dst . '/' . $file);
			}
			else {
				copy($src . '/' . $file,$dst . '/' . $file);
			}
		}
	}
	closedir($dir);
}

add_action( 'wp', 'zr_less_construct', 20 );
function zr_less_construct(){
	if( function_exists( 'zr_options' ) ) :	
	
	$custom_color =  zr_options('custom_color');
	$color 		  =  zr_options('scheme_color');
	$bd_color 	  =  zr_options('scheme_body');
	$bdr_color 	  =  zr_options('scheme_border');
	
	$path = get_template_directory().'/css';
	if( $custom_color ){
		$zr_dirname = '';
		$upload_dir   = wp_upload_dir();		
		if ( ! empty( $upload_dir['basedir'] ) ) {
			$zr_dirname = $upload_dir['basedir'].'/zr_theme';
			if ( ! file_exists( $zr_dirname ) ) {
				wp_mkdir_p( $zr_dirname );
			}
			if ( ! file_exists( $zr_dirname . '/css' ) ) {
				wp_mkdir_p( $zr_dirname . '/css' );
			}
			if ( ! file_exists( $zr_dirname . '/assets/img' ) ) {
				wp_mkdir_p( $zr_dirname . '/assets/img' );
			}
			recurse_copy( get_template_directory(). '/assets/img', $zr_dirname . '/assets/img' );
		}
		if( ! empty( $upload_dir['baseurl'] ) ){
			define( 'CSS_URL', $upload_dir['baseurl'] . '/zr_theme/css' );
		}
		$path = $zr_dirname . '/css';
		add_action( 'wp_enqueue_scripts', 'zr_custom_color', 1000 );
	}
	
	if ( zr_options('developer_mode') ){
		
		require_once ( ZR_OPTIONS_DIR .'/lessphp/3rdparty/lessc.inc.php' );
		define( 'LESS_PATH', get_template_directory().'/assets/less' );
		define( 'CSS__PATH', $path );
		
		$scheme_meta = get_post_meta( get_the_ID(), 'scheme', true );
		$scheme = ( $scheme_meta != '' && $scheme_meta != 'none' ) ? $scheme_meta : zr_options('scheme');
		$ya_direction = zr_options( 'direction' );
		$scheme_vars = get_template_directory().'/templates/presets/default.php';
		$output_cssf = CSS__PATH.'/app-default.css';
		if ( $scheme && file_exists(get_template_directory().'/templates/presets/'.$scheme.'.php') ){
			$scheme_vars = get_template_directory().'/templates/presets/'.$scheme.'.php';
			$output_cssm = CSS__PATH."/mobile-{$scheme}.css";
			$output_cssf = CSS__PATH."/app-{$scheme}.css";
		}
		if ( file_exists($scheme_vars) ){
			include $scheme_vars;
			if( $color != '' ){
				$less_variables['color'] = $color;
			}
			if(  $bd_color != '' ) {
				$less_variables['body-color'] = $bd_color;
			}
			if(  $bdr_color != '' ){
				$less_variables['border-color'] = $bdr_color;
			}
			
			try {				
				$less = new lessc();
				
				
				$less->setImportDir( array(LESS_PATH.'/app/', LESS_PATH.'/bootstrap/') );
				
				$less->setVariables($less_variables);
				
				$cache = $less->cachedCompile(LESS_PATH.'/app.less');
				file_put_contents($output_cssf, $cache["compiled"]);
								
				/* RTL Language */
				$rtl_cache = $less->cachedCompile(LESS_PATH.'/app/rtl.less');
				file_put_contents(CSS__PATH.'/rtl.css', $rtl_cache["compiled"]);
				
				$responsive_cache = $less->cachedCompile(LESS_PATH.'/app-responsive.less');
				file_put_contents(CSS__PATH.'/app-responsive.css', $responsive_cache["compiled"]);
			} catch (Exception $e){
				var_dump($e);exit;
			}
		}
	}
	endif;
}

/*
** Custom color
*/
function zr_custom_color(){
	if( defined( 'CSS_URL' ) ){
		$scheme_meta = get_post_meta( get_the_ID(), 'scheme', true );
		$scheme = ( $scheme_meta != '' && $scheme_meta != 'none' ) ? $scheme_meta : zr_options('scheme');		
		$app_css = CSS_URL . '/app-default.css';
		$mobile_css = CSS_URL . '/mobile-default.css';
		if ( $scheme ){
			$app_css = CSS_URL . '/app-'.$scheme.'.css';
			$mobile_css = CSS_URL . '/mobile-'.$scheme.'.css';
		}
		wp_dequeue_style( 'zr_css' );
		if( function_exists( 'zr_mobile_check' ) ){
			if( zr_mobile_check() ) {
				wp_dequeue_style( 'mobile_css' );
				wp_enqueue_style('mobile_css_custom', $mobile_css, array(), null);
			}
		}		
		wp_enqueue_style('zr_css_custom', $app_css, array(), null);
	}
}