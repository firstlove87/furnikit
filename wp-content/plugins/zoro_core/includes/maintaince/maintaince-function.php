<?php 
/*
** Maintaince Function
*/

/*
** Maintaince Mode
*/
function zr_template_load( $template ){ 
	if( !is_user_logged_in() && zr_options('maintaince_enable') ){
		$template = ZRPATH . 'includes/maintaince/maintaince.php';
	}
	return $template;
}
add_filter( 'template_include', 'zr_template_load' );

/*
** Maintaince Mode
*/
function zr_maintaince_script(){
	$output = '';
	$countdown = zr_options('maintaince_date');
	if( $countdown != '' ):
		$output .= 'jQuery(function($){
		"use strict";
		function zr_check_height(){
			var W_height = $( window ).height();
			if( W_height > 767) {
				setTimeout(function(){
					var cm_height = $( window ).height();
					var cm_target = $( "body > .body-wrapper" );
					cm_target.css( "height", cm_height );
				}, 1000);
			}
		}
		$(window).on( "load", function(){
			zr_check_height();
		});
			$(document).ready(function(){ 
				var end_date = new Date( "'. esc_js( $countdown ) .'" ).getTime()/1000;
				$("#countdown-container").ClassyCountdown({
					theme: "white", 
					end: end_date, 
					now: $.now()/1000,
					labelsOptions: {
						lang: {
						days: "'. esc_html__( 'Days', 'zr_core' ) .'",
						hours: "'. esc_html__( 'Hours', 'zr_core' ) .'",
						minutes: "'. esc_html__( 'Mins', 'zr_core' ) .'",
						seconds: "'. esc_html__( 'Secs', 'zr_core' ) .'"
						},
						style: "font-size: 0.5em;"
					},
				});
			});
		});';
	endif;
	
	wp_enqueue_style('countdown_css', ZRURL . '/css/jquery.classycountdown.min.css', array(), null);
	wp_enqueue_style('maintaince_css', ZRURL . '/css/style-maintaince.css', array(), null);
	wp_register_script('countdown', ZRURL . '/js/maintaince/jquery.classycountdown.min.js', array(), null, true);
	wp_enqueue_script( 'knob', ZRURL . '/js/maintaince/jquery.knob.js', array(), null, true);	
	wp_enqueue_script( 'throttle', ZRURL . '/js/maintaince/jquery.throttle.js', array(), null, true);	
	wp_enqueue_script( 'countdown' );
	wp_add_inline_script( 'countdown', $output );
}

if( !is_user_logged_in() && zr_options('maintaince_enable') ){ 
	add_action( 'wp_enqueue_scripts', 'zr_maintaince_script' );
}