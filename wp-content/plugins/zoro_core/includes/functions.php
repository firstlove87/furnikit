<?php 

require_once( ZRPATH . 'includes/options/options.php' );
require_once( ZRPATH . 'includes/maintaince/maintaince-function.php' );
require_once( ZRPATH . 'includes/widgets/widget-advanced.php' );
require_once( ZRPATH . 'includes/lessphp/less.php' );
require_once( ZRPATH . 'includes/metabox.php' );

$add_query_vars = array();
function zr_query_vars( $qvars ){
	global $options, $add_query_vars;
	if( is_array( $options ) ) {
		foreach ($options as $option) {
			if (isset($option['fields'])) {
				
				foreach ($option['fields'] as $field) {
					$add_query_vars[] = $field['id'];
				}
			}
		}
	}
	
	if ( is_array($add_query_vars) ){
		foreach ( $add_query_vars as $field ){
			$qvars[] = $field;
		}
	}
	
	return $qvars;
}

function zr_parse_request( &$wp ){
	global $add_query_vars, $options_args, $zr_options;
	if( function_exists( 'zr_options' ) ) {
		if ( is_array($add_query_vars) ){
			foreach ( $add_query_vars as $field ){
				if ( array_key_exists($field, $wp->query_vars) ){
					$current_value = zr_options( $field );
					$request_value = $wp->query_vars[$field];
					$field_name = $options_args['opt_name'] . '_' . $field;
					if ($request_value != $current_value){
						setcookie(
							$field_name,
							$request_value,
							time() + 86400,
							'/',
							COOKIE_DOMAIN,
							0
						);
						if (!isset($_COOKIE[$field_name]) || $request_value != $_COOKIE[$field_name]){
							$_COOKIE[$field_name] = $request_value;
						}
					}
				}
			}
		}
	}
}

if (!is_admin()){
	add_filter('query_vars', 'zr_query_vars');
	add_action('parse_request', 'zr_parse_request');
}

function zr_options( $opt_name, $default = null ){
	$options = get_option( ZR_THEME );
	if ( !is_admin() ){
		$cookie_opt_name = ZR_THEME.'_' . $opt_name;
		if ( array_key_exists( $cookie_opt_name, $_COOKIE ) ){
			return $_COOKIE[$cookie_opt_name];
		}
	}
	if( is_array( $options ) ){
		if ( array_key_exists( $opt_name, $options ) ){
			return $options[$opt_name];
		}
	}
	return $default;
}

add_filter( 'ZR_Options_sections_'. ZR_THEME, 'zr_custom_section' );
function zr_custom_section( $sections ){
	$sections[] = array(
		'title' => esc_html__('Maintaince Mode', 'zr_core'),
		'desc' => wp_kses( __('<p class="description">Enable and config for Maintaincludesece mode.</p>', 'zr_core'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are includesluded in the options folder, so you can hook into them, or link to your own custom ones.
		'icon' => ZR_OPTIONS_URL.'/options/img/glyphicons/glyphicons_136_computer_locked.png',
		'fields' => array(
				array(
					'id' => 'maintaince_enable',
					'title' => esc_html__( 'Enable Maintaince Mode', 'zr_core' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Turn on/off Maintaincludese mode on this website', 'zr_core' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
					'id' => 'maintance_background',
					'title' => esc_html__( 'Maintaince Background', 'zr_core' ),
					'type' => 'upload',
					'sub_desc' => esc_html__( 'Choose maintance background image', 'zr_core' ),
					'desc' => '',
					'std' => get_template_directory_uri().'/assets/img/maintance/bg-main.jpg'
				),
				
				array(
					'id' => 'maintance_content',
					'title' => esc_html__( 'Maintaince Content', 'zr_core' ),
					'type' => 'editor',
					'sub_desc' => esc_html__( 'Change text of maintance mode', 'zr_core' ),
					'desc' => '',
					'std' => ''
				),
				
				array(
					'id' => 'maintance_date',
					'title' => esc_html__( 'Maintaince Date', 'zr_core' ),
					'type' => 'date',
					'sub_desc' => esc_html__( 'Put date to this field to show countdown date on maintance mode.', 'zr_core' ),
					'desc' => '',
					'placeholder' => 'mm/dd/yy',
					'std' => ''
				),
				
				array(
					'id' => 'maintance_form',
					'title' => esc_html__( 'Maintaincludese Form', 'zr_core' ),
					'type' => 'text',
					'sub_desc' => esc_html__( 'Put shortcode form to this field and it will be shown on maintance mode frontend.', 'zr_core' ),
					'desc' => '',
					'std' => ''
				),
				
			)
	);
	return $sections;
}