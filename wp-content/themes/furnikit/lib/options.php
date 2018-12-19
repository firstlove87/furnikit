<?php
/*
 *
 * Require the framework class before doing anything else, so we can use the defined urls and dirs
 * Also if running on windows you may have url problems, which can be fixed by defining the framework url first
 *
 */
 
if( !function_exists( 'zr_options' ) ) :
function zr_options( $opt_name, $default = null ){
	$options = get_option( ZR_THEME );
	if( is_array( $options ) ){
		if ( array_key_exists( $opt_name, $options ) ){
			return $options[$opt_name];
		}
	}
	return $default;
}
endif;

?>