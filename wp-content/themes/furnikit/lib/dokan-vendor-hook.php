<?php 
/*
	* Name: Dokan Vendor Hook
	* Develop: SmartAddons
*/

add_action( 'wp', 'furnikit_dokan_hook' );
function furnikit_dokan_hook(){
	 if ( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page () ) {
		remove_action( 'woocommerce_before_main_content', 'furnikit_banner_listing', 10 );
	}
}
