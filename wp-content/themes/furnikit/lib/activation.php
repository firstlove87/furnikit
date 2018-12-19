<?php
/**
 * Theme activation
 */

function zr_verify_envato_purchase_code($code) {
	
	$url = esc_url( 'https://api.envato.com/v3/market/author/sale?code=' . $code );
	$request_headers = array(
		'method' => 'GET',
		'user-agent' => 'Magentech WordPress',
		'timeout'    => 20,
		'sslverify'    => false,
		'headers' => array(
			'Authorization' => 'Bearer 7OyX1WLVaAQsqBHupCN8u7HwO2y3IneI',
		)
	);
	$response = wp_remote_request( $url, $request_headers );
	$body = wp_remote_retrieve_body( $response );
	$body = json_decode( $body, true );
	return $body;
}

function zr_verify_purchase_code_result( $input ){
	$result = zr_verify_envato_purchase_code( $input );
	if( isset( $result['item']['id'] ) ){
		return true;
	}else{
		return false;
	}
}

 
if (is_admin() && isset($_GET['activated']) && 'themes.php' == $GLOBALS['pagenow']) {
	wp_redirect(admin_url('themes.php?page=zr_activation_options'));
	exit;
}

add_action('admin_menu', 'zr_activation_options_add_page', 50);

function zr_activation_options_add_page() {
	$zr_activation_options = get_option( 'zr_purchase_code' );	
	if ( $zr_activation_options == '' ) {
		$theme_page = add_theme_page(
				esc_html__('Theme Activation', 'furnikit'),
				esc_html__('Theme Activation', 'furnikit'),
				'edit_theme_options',
				'zr_activation_options',
				'zr_activation_options_render_page'
		);		
	} else {
		if (is_admin() && isset($_GET['page']) && $_GET['page'] === 'zr_activation_options'  ) {
			global $wp_rewrite;
			$wp_rewrite->flush_rules();			
			wp_redirect( esc_url( admin_url('themes.php?page=tgmpa-install-plugins') ) );
			exit;
		}
	}
	add_action('admin_init', 'zr_activation_options_init');
}

function zr_activation_options_init() {
	register_setting( 'section', 'zr_purchase_code', 'zr_validate_purchase_code' );
}

function zr_get_default_activation_options() {
	$default_activation_options = '';

	return apply_filters('zr_default_activation_options', $default_activation_options);
}

function zr_activation_options_render_page() { 
	wp_enqueue_style('admin-style', get_template_directory_uri() . '/lib/admin/css/admin.css', array(), null);
?>
<div class="zr-activation-form">
	<div class="activation-form-inner">
		<h2>
			<?php printf( esc_html__( '%s Theme Activation', 'furnikit' ), wp_get_theme() ); ?>
			<a href="<?php echo esc_url( 'http://wpthemego.com/document/how-to-get-purchase-code-for-items-from-envato/' ); ?>" target="_blank" class="zr-activation-help" title="<?php echo esc_attr__( 'Need help? Please follow this url', 'furnikit' ); ?>"><?php echo esc_html__( 'Help', 'furnikit' ); ?></a>
		</h2>
		<?php settings_errors(); ?>
		

		<form method="post" action="options.php">

			<?php
				settings_fields('section');
				do_settings_sections( 'section' );
			?>			
			<div class="zr-activation">
				<ul>
					<li>
						<label for="zr_purchase_code" class="clearfix">
							<input type="text" id="zr_purchase_code" placeholder="<?php echo esc_attr__( 'Enter Your Purchase Code', 'furnikit' ); ?>" name="zr_purchase_code" value="<?php echo esc_attr( get_option( 'zr_purchase_code' ) ); ?>"/>
						</label>
					</li>
				</ul>
			</div>
			
			<?php submit_button(); ?>
		</form>
	</div>
</div>

<?php }

function zr_validate_purchase_code( $input ){
	$new_input = '';
	if( zr_verify_purchase_code_result( $input ) ) {
		$new_input = $input; 
	}else{
		 add_settings_error(
			'myUniqueIdentifier',
			esc_attr( 'settings_updated' ),
			esc_html__( 'Your Purchase Code are invalid, please fill correct code to action theme', 'furnikit' ),
			'error'
		);
	}
	return  $new_input;
}
if( !zr_verify_purchase_code_result( get_option( 'zr_purchase_code' ) ) ) {
	function zr_admin_notice_validate_purchase_code() {
		$class = 'notice notice-error';
		$message = esc_html__( 'Your theme is not active now, please fill your purchase code to active your theme!', 'furnikit' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
	}
	add_action( 'admin_notices', 'zr_admin_notice_validate_purchase_code' );
}else{
	require_once ( get_template_directory().'/lib/plugin-requirement.php' );			// Custom functions
	if( class_exists( 'OCDI_Plugin' ) ) :
		require_once ( get_template_directory().'/lib/import/zr-import.php' );
	endif;
}
