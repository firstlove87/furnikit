<?php
$lib_dir = trailingslashit( str_replace( '\\', '/', get_template_directory() . '/lib/' ) );

if( !defined('FURNIKIT_DIR') ){
	define( 'FURNIKIT_DIR', $lib_dir );
}

if( !defined('FURNIKIT_URL') ){
	define( 'FURNIKIT_URL', trailingslashit( get_template_directory_uri() ) . 'lib' );
}

if (!isset($content_width)) { $content_width = 940; }

define("FURNIKIT_PRODUCT_TYPE","product");
define("FURNIKIT_PRODUCT_DETAIL_TYPE","product_detail");

if ( !defined('ZR_THEME') ){
	define( 'ZR_THEME', 'furnikit_theme' );
}

require_once( get_template_directory().'/lib/options.php' );

if( class_exists( 'ZR_Options' ) ) :
function furnikit_Options_Setup(){
	global $zr_options, $options, $options_args;

	$options = array();
	$options[] = array(
			'title' => esc_html__('General', 'furnikit'),
			'desc' => wp_kses( __('<p class="description">The theme allows to build your own styles right out of the backend without any coding knowledge. Upload new logo and favicon or get their URL.</p>', 'furnikit'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it furnikit for default.
			'icon' => FURNIKIT_URL.'/admin/img/glyphicons/glyphicons_019_cogwheel.png',
			//Lets leave this as a furnikit section, no options just some intro text set above.
			'fields' => array(	
					
					array(
						'id' => 'sitelogo',
						'type' => 'upload',
						'title' => esc_html__('Logo Image', 'furnikit'),
						'sub_desc' => esc_html__( 'Use the Upload button to upload the new logo and get URL of the logo', 'furnikit' ),
						'std' => get_template_directory_uri().'/assets/img/logo-default.png'
					),
					
					array(
						'id' => 'favicon',
						'type' => 'upload',
						'title' => esc_html__('Favicon', 'furnikit'),
						'sub_desc' => esc_html__( 'Use the Upload button to upload the custom favicon', 'furnikit' ),
						'std' => ''
					),
					
					array(
						'id' => 'title_length',
						'type' => 'text',
						'title' => esc_html__('Title Length Of Item Listing Page', 'furnikit'),
						'sub_desc' => esc_html__( 'Choose title length if you want to trim word, leave 0 to not trim word', 'furnikit' ),
						'std' => 0
					),
					
					array(
					   'id' => 'page_404',
					   'type' => 'pages_select',
					   'title' => esc_html__('404 Page Content', 'furnikit'),
					   'sub_desc' => esc_html__('Select page 404 content', 'furnikit'),
					   'std' => ''
					),
			)		
		);
	
	$options[] = array(
			'title' => esc_html__('Schemes', 'furnikit'),
			'desc' => wp_kses( __('<p class="description">Custom color scheme for theme. Unlimited color that you can choose.</p>', 'furnikit'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it furnikit for default.
			'icon' => FURNIKIT_URL.'/admin/img/glyphicons/glyphicons_163_iphone.png',
			//Lets leave this as a furnikit section, no options just some intro text set above.
			'fields' => array(		
				array(
					'id' => 'scheme',
					'type' => 'radio_img',
					'title' => esc_html__('Color Scheme', 'furnikit'),
					'sub_desc' => esc_html__( 'Select one of 1 predefined schemes', 'furnikit' ),
					'desc' => '',
					'options' => array(
									'default' => array('title' => 'Default', 'img' => get_template_directory_uri().'/assets/img/default.png'),
									), //Must provide key => value(array:title|img) pairs for radio options
					'std' => 'default'
				),
				
				array(
					'id' => 'custom_color',
					'title' => esc_html__( 'Enable Custom Color', 'furnikit' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Check this field to enable custom color and when you update your theme, custom color will not lose.', 'furnikit' ),
					'desc' => '',
					'std' => '0'
				),
					
				array(
					'id' => 'developer_mode',
					'title' => esc_html__( 'Developer Mode', 'furnikit' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Turn on/off compile less to css and custom color', 'furnikit' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
					'id' => 'scheme_color',
					'type' => 'color',
					'title' => esc_html__('Color', 'furnikit'),
					'sub_desc' => esc_html__('Select main custom color.', 'furnikit'),
					'std' => ''
				)	
			)
	);
	
	$options[] = array(
			'title' => esc_html__('Layout', 'furnikit'),
			'desc' => wp_kses( __('<p class="description">WpThemeGo Framework comes with a layout setting that allows you to build any number of stunning layouts and apply theme to your entries.</p>', 'furnikit'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it furnikit for default.
			'icon' => FURNIKIT_URL.'/admin/img/glyphicons/glyphicons_319_sort.png',
			//Lets leave this as a furnikit section, no options just some intro text set above.
			'fields' => array(
					array(
						'id' => 'layout',
						'type' => 'select',
						'title' => esc_html__('Box Layout', 'furnikit'),
						'sub_desc' => esc_html__( 'Select Layout Box or Wide', 'furnikit' ),
						'options' => array(
							'full' => esc_html__( 'Wide', 'furnikit' ),
							'boxed' => esc_html__( 'Boxed', 'furnikit' )
						),
						'std' => 'wide'
					),
				
					array(
						'id' => 'bg_box_img',
						'type' => 'upload',
						'title' => esc_html__('Background Box Image', 'furnikit'),
						'sub_desc' => '',
						'std' => ''
					),
					array(
							'id' => 'sidebar_left_expand',
							'type' => 'select',
							'title' => esc_html__('Left Sidebar Expand', 'furnikit'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12', 
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '3',
							'sub_desc' => esc_html__( 'Select width of left sidebar.', 'furnikit' ),
						),
					
					array(
							'id' => 'sidebar_right_expand',
							'type' => 'select',
							'title' => esc_html__('Right Sidebar Expand', 'furnikit'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '3',
							'sub_desc' => esc_html__( 'Select width of right sidebar medium desktop.', 'furnikit' ),
						),
						array(
							'id' => 'sidebar_left_expand_md',
							'type' => 'select',
							'title' => esc_html__('Left Sidebar Medium Desktop Expand', 'furnikit'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of left sidebar medium desktop.', 'furnikit' ),
						),
					array(
							'id' => 'sidebar_right_expand_md',
							'type' => 'select',
							'title' => esc_html__('Right Sidebar Medium Desktop Expand', 'furnikit'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of right sidebar.', 'furnikit' ),
						),
						array(
							'id' => 'sidebar_left_expand_sm',
							'type' => 'select',
							'title' => esc_html__('Left Sidebar Tablet Expand', 'furnikit'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of left sidebar tablet.', 'furnikit' ),
						),
					array(
							'id' => 'sidebar_right_expand_sm',
							'type' => 'select',
							'title' => esc_html__('Right Sidebar Tablet Expand', 'furnikit'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => esc_html__( 'Select width of right sidebar tablet.', 'furnikit' ),
						),				
				)
		);
	$options[] = array(
			'title' => esc_html__('Mobile Layout', 'furnikit'),
			'desc' => wp_kses( __('<p class="description">WpThemeGo Framework comes with a mobile setting home page layout.</p>', 'furnikit'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it furnikit for default.
			'icon' => FURNIKIT_URL.'/admin/img/glyphicons/glyphicons_163_iphone.png',
			//Lets leave this as a furnikit section, no options just some intro text set above.
			'fields' => array(				
				array(
					'id' => 'mobile_enable',
					'type' => 'checkbox',
					'title' => esc_html__('Enable Mobile Layout', 'furnikit'),
					'sub_desc' => '',
					'desc' => '',
							'std' => '1'// 1 = on | 0 = off
						),

				array(
					'id' => 'mobile_logo',
					'type' => 'upload',
					'title' => esc_html__('Logo Mobile Image', 'furnikit'),
					'sub_desc' => esc_html__( 'Use the Upload button to upload the new mobile logo', 'furnikit' ),
					'std' => get_template_directory_uri().'/assets/img/logo-default.png'
				),
				
				array(
					'id' => 'mobile_logo_account',
					'type' => 'upload',
					'title' => esc_html__('Logo Mobile My Account Page', 'furnikit'),
					'sub_desc' => esc_html__( 'Use the Upload button to upload the new mobile logo in my account page', 'furnikit' ),
					'std' => get_template_directory_uri().'/assets/img/icon-myaccount.png'
				),

				array(
					'id' => 'sticky_mobile',
					'type' => 'checkbox',
					'title' => esc_html__('Sticky Mobile', 'furnikit'),
					'sub_desc' => '',
					'desc' => '',
							'std' => '0'// 1 = on | 0 = off
						),

				array(
					'id' => 'mobile_content',
					'type' => 'pages_select',
					'title' => esc_html__('Mobile Layout Content', 'furnikit'),
					'sub_desc' => esc_html__('Select content index for this mobile layout', 'furnikit'),
					'std' => ''
				),

				array(
					'id' => 'mobile_header_style',
					'type' => 'select',
					'title' => esc_html__('Header Mobile Style', 'furnikit'),
					'sub_desc' => esc_html__('Select header mobile style', 'furnikit'),
					'options' => array(
						'mstyle1'  => esc_html__( 'Style 1', 'furnikit' ),
						'mstyle2'  => esc_html__( 'Style 2', 'furnikit' ),
						'mstyle3'  => esc_html__( 'Style 3', 'furnikit' ),
						'mstyle4'  => esc_html__( 'Style 4', 'furnikit' ),
						'mstyle5'  => esc_html__( 'Style 5', 'furnikit' ),
					),
					'std' => 'style1'
				),

				array(
					'id' => 'mobile_footer_style',
					'type' => 'select',
					'title' => esc_html__('Footer Mobile Style', 'furnikit'),
					'sub_desc' => esc_html__('Select footer mobile style', 'furnikit'),
					'options' => array(
						'mstyle1'  => esc_html__( 'Style 1', 'furnikit' ),
						'mstyle2'  => esc_html__( 'Style 2', 'furnikit' ),
						'mstyle3'  => esc_html__( 'Style 3', 'furnikit' ),
					),
					'std' => 'style1'
				),

				array(
					'id' => 'mobile_addcart',
					'type' => 'checkbox',
					'title' => esc_html__('Enable Add To Cart Button', 'furnikit'),
					'sub_desc' => esc_html__( 'Enable Add To Cart Button on product listing', 'furnikit' ),
					'desc' => '',
						'std' => '0'// 1 = on | 0 = off
				),
				
				array(
					'id' => 'mobile_header_inside',
					'type' => 'checkbox',
					'title' => esc_html__('Enable Header Other Pages', 'furnikit'),
					'sub_desc' => esc_html__( 'Enable header in other pages which are different with homepage', 'furnikit' ),
					'desc' => '',
						'std' => '0'// 1 = on | 0 = off
				),
				
				array(
					'id' => 'mobile_jquery',
					'type' => 'checkbox',
					'title' => esc_html__('Include Jquery Furnikitlution', 'furnikit'),
					'sub_desc' => esc_html__( 'Enable jquery furnikitlution slider on mobile layout.', 'furnikit' ),
					'desc' => '',
						'std' => '0'// 1 = on | 0 = off
				),
			)
	);
			
	$options[] = array(
		'title' => esc_html__('Header & Footer', 'furnikit'),
			'desc' => wp_kses( __('<p class="description">WpThemeGo Framework comes with a header and footer setting that allows you to build style header.</p>', 'furnikit'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it furnikit for default.
			'icon' => FURNIKIT_URL.'/admin/img/glyphicons/glyphicons_336_read_it_later.png',
			//Lets leave this as a furnikit section, no options just some intro text set above.
			'fields' => array(
				 array(
					'id' => 'header_style',
					'type' => 'select',
					'title' => esc_html__('Header Style', 'furnikit'),
					'sub_desc' => esc_html__('Select Header style', 'furnikit'),
					'options' => array(
							'style1'  => esc_html__( 'Style 1', 'furnikit' ),
							'style2'  => esc_html__( 'Style 2', 'furnikit' ),
							'style3'  => esc_html__( 'Style 3', 'furnikit' ),
							'style4'  => esc_html__( 'Style 4', 'furnikit' ),
							),
					'std' => 'style1'
				),				
					
				array(
					'id' => 'disable_search',
					'title' => esc_html__( 'Disable Search', 'furnikit' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Check this to disable search on header', 'furnikit' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
					'id' => 'disable_cart',
					'title' => esc_html__( 'Disable Cart', 'furnikit' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Check this to disable cart on header', 'furnikit' ),
					'desc' => '',
					'std' => '0'
				),				
				
				array(
				   'id' => 'footer_style',
				   'type' => 'pages_select',
				   'title' => esc_html__('Footer Style', 'furnikit'),
				   'sub_desc' => esc_html__('Select Footer style', 'furnikit'),
				   'std' => ''
				),
				
				array(
					'id' => 'footer_copyright',
					'type' => 'editor',
					'sub_desc' => '',
					'title' => esc_html__( 'Copyright text', 'furnikit' )
				),	
				
			)
	);
	$options[] = array(
			'title' => esc_html__('Navbar Options', 'furnikit'),
			'desc' => wp_kses( __('<p class="description">If you got a big site with a lot of sub menus we recommend using a mega menu. Just select the dropbox to display a menu as mega menu or dropdown menu.</p>', 'furnikit'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it furnikit for default.
			'icon' => FURNIKIT_URL.'/admin/img/glyphicons/glyphicons_157_show_lines.png',
			//Lets leave this as a furnikit section, no options just some intro text set above.
			'fields' => array(
				array(
						'id' => 'menu_type',
						'type' => 'select',
						'title' => esc_html__('Menu Type', 'furnikit'),
						'options' => array( 
							'dropdown' => esc_html__( 'Dropdown Menu', 'furnikit' ), 
							'mega' => esc_html__( 'Mega Menu', 'furnikit' ) 
						),
						'std' => 'mega'
					),	
				
				array(
						'id' => 'menu_location',
						'type' => 'menu_location_multi_select',
						'title' => esc_html__('Theme Location', 'furnikit'),
						'sub_desc' => esc_html__( 'Select theme location to active mega menu and menu responsive.', 'furnikit' ),
						'std' => 'primary_menu'
					),		
					
				array(
						'id' => 'sticky_menu',
						'type' => 'checkbox',
						'title' => esc_html__('Active sticky menu', 'furnikit'),
						'sub_desc' => '',
						'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),
				
				array(
						'id' => 'more_menu',
						'type' => 'checkbox',
						'title' => esc_html__('Active More Menu', 'furnikit'),
						'sub_desc' => esc_html__('Active more menu if your primary menu is too long', 'furnikit'),
						'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),
					
				array(
						'id' => 'menu_event',
						'type' => 'select',
						'title' => esc_html__('Menu Event', 'furnikit'),
						'options' => array( 
							'' 		=> esc_html__( 'Hover Event', 'furnikit' ), 
							'click' => esc_html__( 'Click Event', 'furnikit' ) 
						),
						'std' => ''
					),
				
				array(
					'id' => 'menu_number_item',
					'type' => 'text',
					'title' => esc_html__( 'Number Item Vertical', 'furnikit' ),
					'sub_desc' => esc_html__( 'Number item vertical to show', 'furnikit' ),
					'std' => 8
				),	
				
				array(
					'id' => 'menu_title_text',
					'type' => 'text',
					'title' => esc_html__('Vertical Title Text', 'furnikit'),
					'sub_desc' => esc_html__( 'Change title text on vertical menu', 'furnikit' ),
					'std' => ''
				),
				
				array(
					'id' => 'menu_more_text',
					'type' => 'text',
					'title' => esc_html__('Vertical More Text', 'furnikit'),
					'sub_desc' => esc_html__( 'Change more text on vertical menu', 'furnikit' ),
					'std' => ''
				),
					
				array(
					'id' => 'menu_less_text',
					'type' => 'text',
					'title' => esc_html__('Vertical Less Text', 'furnikit'),
					'sub_desc' => esc_html__( 'Change less text on vertical menu', 'furnikit' ),
					'std' => ''
				)	
			)
		);
	$options[] = array(
		'title' => esc_html__('Blog Options', 'furnikit'),
		'desc' => wp_kses( __('<p class="description">Select layout in blog listing page.</p>', 'furnikit'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it furnikit for default.
		'icon' => FURNIKIT_URL.'/admin/img/glyphicons/glyphicons_071_book.png',
		//Lets leave this as a furnikit section, no options just some intro text set above.
		'fields' => array(
				array(
						'id' => 'sidebar_blog',
						'type' => 'select',
						'title' => esc_html__('Sidebar Blog Layout', 'furnikit'),
						'options' => array(
								'full' 	=> esc_html__( 'Full Layout', 'furnikit' ),		
								'left'	=> esc_html__( 'Left Sidebar', 'furnikit' ),
								'right' => esc_html__( 'Right Sidebar', 'furnikit' ),
						),
						'std' => 'left',
						'sub_desc' => esc_html__( 'Select style sidebar blog', 'furnikit' ),
					),
					array(
						'id' => 'blog_layout',
						'type' => 'select',
						'title' => esc_html__('Layout blog', 'furnikit'),
						'options' => array(
								'list'	=>  esc_html__( 'List Layout', 'furnikit' ),
								'list2'	=>  esc_html__( 'List Layout2', 'furnikit' ),
								'grid' 	=>  esc_html__( 'Grid Layout', 'furnikit' ),
								'grid2' 	=>  esc_html__( 'Grid Layout2', 'furnikit' )						
						),
						'std' => 'list',
						'sub_desc' => esc_html__( 'Select style layout blog', 'furnikit' ),
					),
					array(
						'id' => 'blog_column',
						'type' => 'select',
						'title' => esc_html__('Blog column', 'furnikit'),
						'options' => array(								
								'2' =>  esc_html__( '2 Columns', 'furnikit' ),
								'3' =>  esc_html__( '3 Columns', 'furnikit' ),
								'4' =>  esc_html__( '4 Columns', 'furnikit' )								
							),
						'std' => '2',
						'sub_desc' => esc_html__( 'Select style number column blog', 'furnikit' ),
					),
			)
	);	
	$options[] = array(
		'title' => esc_html__('Product Options', 'furnikit'),
		'desc' => wp_kses( __('<p class="description">Select layout in product listing page.</p>', 'furnikit'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it furnikit for default.
		'icon' => FURNIKIT_URL.'/admin/img/glyphicons/glyphicons_202_shopping_cart.png',
		//Lets leave this as a furnikit section, no options just some intro text set above.
		'fields' => array(
			array(
				'id' => 'info_typo1',
				'type' => 'info',
				'title' => esc_html( 'Product Categories Config', 'furnikit' ),
				'desc' => '',
				'class' => 'furnikit-opt-info'
				),
			
			array(
				'id' => 'product_colcat_large',
				'type' => 'select',
				'title' => esc_html__('Product Category Listing column Desktop', 'furnikit'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',							
					),
				'std' => '4',
				'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'furnikit' ),
				),

			array(
				'id' => 'product_colcat_medium',
				'type' => 'select',
				'title' => esc_html__('Product Listing Category column Medium Desktop', 'furnikit'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6',
					),
				'std' => '3',
				'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'furnikit' ),
				),

			array(
				'id' => 'product_colcat_sm',
				'type' => 'select',
				'title' => esc_html__('Product Listing Category column Tablet', 'furnikit'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6'
					),
				'std' => '2',
				'sub_desc' => esc_html__( 'Select number of column on Tablet Screen', 'furnikit' ),
				),
			
			array(
				'id' => 'info_typo1',
				'type' => 'info',
				'title' => esc_html( 'Product General Config', 'furnikit' ),
				'desc' => '',
				'class' => 'furnikit-opt-info'
				),
				
			array(
				'id' => 'product_banner',
				'title' => esc_html__( 'Select Banner', 'furnikit' ),
				'type' => 'select',
				'sub_desc' => '',
				'options' => array(
					'' 			=> esc_html__( 'Use Banner', 'furnikit' ),
					'listing' 	=> esc_html__( 'Use Category Product Image', 'furnikit' ),
					),
				'std' => '',
				),

			array(
				'id' => 'product_listing_banner',
				'type' => 'upload',
				'title' => esc_html__('Listing Banner Product', 'furnikit'),
				'sub_desc' => esc_html__( 'Use the Upload button to upload banner product listing', 'furnikit' ),
				'std' => get_template_directory_uri().'/assets/img/logo-default.png'
				),

			array(
				'id' => 'product_col_large',
				'type' => 'select',
				'title' => esc_html__('Product Listing column Desktop', 'furnikit'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',							
					),
				'std' => '3',
				'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'furnikit' ),
				),

			array(
				'id' => 'product_col_medium',
				'type' => 'select',
				'title' => esc_html__('Product Listing column Medium Desktop', 'furnikit'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6',
					),
				'std' => '2',
				'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'furnikit' ),
				),

			array(
				'id' => 'product_col_sm',
				'type' => 'select',
				'title' => esc_html__('Product Listing column Tablet', 'furnikit'),
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',	
					'5' => '5',
					'6' => '6'
					),
				'std' => '2',
				'sub_desc' => esc_html__( 'Select number of column on Tablet Screen', 'furnikit' ),
				),

			array(
				'id' => 'sidebar_product',
				'type' => 'select',
				'title' => esc_html__('Sidebar Product Layout', 'furnikit'),
				'options' => array(
					'left'	=> esc_html__( 'Left Sidebar', 'furnikit' ),
					'full' 	=> esc_html__( 'Full Layout', 'furnikit' ),		
					'right' => esc_html__( 'Right Sidebar', 'furnikit' )
					),
				'std' => 'left',
				'sub_desc' => esc_html__( 'Select style sidebar product', 'furnikit' ),
				),

			array(
				'id' => 'product_quickview',
				'title' => esc_html__( 'Quickview', 'furnikit' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off Product Quickview', 'furnikit' ),
				'std' => '1'
				),
			
			array(
				'id' => 'product_listing_countdown',
				'title' => esc_html__( 'Enable Countdown', 'furnikit' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off Product Countdown on product listing', 'furnikit' ),
				'std' => '1'
				),
			
			
			array(
				'id' => 'product_number',
				'type' => 'text',
				'title' => esc_html__('Product Listing Number', 'furnikit'),
				'sub_desc' => esc_html__( 'Show number of product in listing product page.', 'furnikit' ),
				'std' => 12
				),
			
			array(
				'id' => 'newproduct_time',
				'title' => esc_html__( 'New Product', 'furnikit' ),
				'type' => 'number',
				'sub_desc' => '',
				'desc' => esc_html__( 'Set day for the new product label from the date publish product.', 'furnikit' ),
				'std' => '1'
				),
			
			array(
				'id' => 'info_typo1',
				'type' => 'info',
				'title' => esc_html( 'Product Single Config', 'furnikit' ),
				'desc' => '',
				'class' => 'furnikit-opt-info'
				),
			
			array(
				'id' => 'sidebar_product_detail',
				'type' => 'select',
				'title' => esc_html__('Sidebar Product Single Layout', 'furnikit'),
				'options' => array(
					'left'	=> esc_html__( 'Left Sidebar', 'furnikit' ),
					'full' 	=> esc_html__( 'Full Layout', 'furnikit' ),		
					'right' => esc_html__( 'Right Sidebar', 'furnikit' )
					),
				'std' => 'left',
				'sub_desc' => esc_html__( 'Select style sidebar product single', 'furnikit' ),
				),
			
			array(
				'id' => 'product_single_style',
				'type' => 'select',
				'title' => esc_html__('Product Detail Style', 'furnikit'),
				'options' => array(
					'default'	=> esc_html__( 'Default', 'furnikit' ),
					'style1' 	=> esc_html__( 'Full Width', 'furnikit' ),	
					'style2' 	=> esc_html__( 'Full Width With Accordion', 'furnikit' ),	
					'style3' 	=> esc_html__( 'Full Width With Accordion 1', 'furnikit' ),	
				),
				'std' => 'default',
				'sub_desc' => esc_html__( 'Select style for product single', 'furnikit' ),
				),
			
			array(
				'id' => 'product_single_thumbnail',
				'type' => 'select',
				'title' => esc_html__('Product Thumbnail Position', 'furnikit'),
				'options' => array(
					'bottom'	=> esc_html__( 'Bottom', 'furnikit' ),
					'left' 		=> esc_html__( 'Left', 'furnikit' ),	
					'right' 	=> esc_html__( 'Right', 'furnikit' ),	
					'top' 		=> esc_html__( 'Top', 'furnikit' ),					
				),
				'std' => 'bottom',
				'sub_desc' => esc_html__( 'Select style for product single thumbnail', 'furnikit' ),
				),		
			
			
			array(
				'id' => 'product_zoom',
				'title' => esc_html__( 'Product Zoom', 'furnikit' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off image zoom when hover on single product', 'furnikit' ),
				'std' => '1'
				),
			
			array(
				'id' => 'product_brand',
				'title' => esc_html__( 'Enable Product Brand Image', 'furnikit' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off product brand image show on single product.', 'furnikit' ),
				'std' => '1'
				),

			array(
				'id' => 'product_single_countdown',
				'title' => esc_html__( 'Enable Countdown Single', 'furnikit' ),
				'type' => 'checkbox',
				'sub_desc' => '',
				'desc' => esc_html__( 'Turn On/Off Product Countdown on product single', 'furnikit' ),
				'std' => '1'
				),
			
			array(
				'id' => 'info_typo1',
				'type' => 'info',
				'title' => esc_html( 'Config For Product Categories Widget', 'furnikit' ),
				'desc' => '',
				'class' => 'furnikit-opt-info'
				),

			array(
				'id' => 'product_number_item',
				'type' => 'text',
				'title' => esc_html__( 'Category Number Item Show', 'furnikit' ),
				'sub_desc' => esc_html__( 'Choose to number of item category that you want to show, leave 0 to show all category', 'furnikit' ),
				'std' => 8
				),	

			array(
				'id' => 'product_more_text',
				'type' => 'text',
				'title' => esc_html__( 'Category More Text', 'furnikit' ),
				'sub_desc' => esc_html__( 'Change more text on category product', 'furnikit' ),
				'std' => ''
				),

			array(
				'id' => 'product_less_text',
				'type' => 'text',
				'title' => esc_html__( 'Category Less Text', 'furnikit' ),
				'sub_desc' => esc_html__( 'Change less text on category product', 'furnikit' ),
				'std' => ''
			)	
		)
);		
	$options[] = array(
			'title' => esc_html__('Typography', 'furnikit'),
			'desc' => wp_kses( __('<p class="description">Change the font style of your blog, custom with Google Font.</p>', 'furnikit'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it furnikit for default.
			'icon' => FURNIKIT_URL.'/admin/img/glyphicons/glyphicons_151_edit.png',
			//Lets leave this as a furnikit section, no options just some intro text set above.
			'fields' => array(
				array(
					'id' => 'info_typo1',
					'type' => 'info',
					'title' => esc_html( 'Global Typography', 'furnikit' ),
					'desc' => '',
					'class' => 'furnikit-opt-info'
				),

				array(
					'id' => 'google_webfonts',
					'type' => 'google_webfonts',
					'title' => esc_html__('Use Google Webfont', 'furnikit'),
					'sub_desc' => esc_html__( 'Insert font style that you actually need on your webpage.', 'furnikit' ), 
					'std' => ''
				),

				array(
					'id' => 'webfonts_weight',
					'type' => 'multi_select',
					'sub_desc' => esc_html__( 'For weight, see Google Fonts to custom for each font style.', 'furnikit' ),
					'title' => esc_html__('Webfont Weight', 'furnikit'),
					'options' => array(
						'100' => '100',
						'200' => '200',
						'300' => '300',
						'400' => '400',
						'500' => '500',
						'600' => '600',
						'700' => '700',
						'800' => '800',
						'900' => '900'
					),
					'std' => ''
				),

				array(
					'id' => 'info_typo2',
					'type' => 'info',
					'title' => esc_html( 'Header Tag Typography', 'furnikit' ),
					'desc' => '',
					'class' => 'furnikit-opt-info'
				),

				array(
					'id' => 'header_tag_font',
					'type' => 'google_webfonts',
					'title' => esc_html__('Header Tag Font', 'furnikit'),
					'sub_desc' => esc_html__( 'Select custom font for header tag ( h1...h6 )', 'furnikit' ), 
					'std' => ''
				),

				array(
					'id' => 'info_typo2',
					'type' => 'info',
					'title' => esc_html( 'Main Menu Typography', 'furnikit' ),
					'desc' => '',
					'class' => 'furnikit-opt-info'
				),

				array(
					'id' => 'menu_font',
					'type' => 'google_webfonts',
					'title' => esc_html__('Main Menu Font', 'furnikit'),
					'sub_desc' => esc_html__( 'Select custom font for main menu', 'furnikit' ), 
					'std' => ''
				),
				
				array(
					'id' => 'info_typo2',
					'type' => 'info',
					'title' => esc_html( 'Custom Typography', 'furnikit' ),
					'desc' => '',
					'class' => 'furnikit-opt-info'
				),

				array(
					'id' => 'custom_font',
					'type' => 'google_webfonts',
					'title' => esc_html__('Custom Font', 'furnikit'),
					'sub_desc' => esc_html__( 'Select custom font for custom class', 'furnikit' ), 
					'std' => ''
				),
				
				array(
					'id' => 'custom_font_class',
					'title' => esc_html__( 'Custom Font Class', 'furnikit' ),
					'type' => 'text',
					'sub_desc' => esc_html__( 'Put custom class to this field. Each class separated by commas.', 'furnikit' ),
					'desc' => '',
					'std' => '',
				),
				
			)
		);
	
	$options[] = array(
		'title' => __('Social', 'furnikit'),
		'desc' => wp_kses( __('<p class="description">This feature allow to you link to your social.</p>', 'furnikit'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => FURNIKIT_URL.'/admin/img/glyphicons/glyphicons_222_share.png',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(
				array(
						'id' => 'social-share-fb',
						'title' => esc_html__( 'Facebook', 'furnikit' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
				array(
						'id' => 'social-share-tw',
						'title' => esc_html__( 'Twitter', 'furnikit' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
				array(
						'id' => 'social-share-tumblr',
						'title' => esc_html__( 'Tumblr', 'furnikit' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
				array(
						'id' => 'social-share-in',
						'title' => esc_html__( 'Linkedin', 'furnikit' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
					array(
						'id' => 'social-share-instagram',
						'title' => esc_html__( 'Instagram', 'furnikit' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
				array(
						'id' => 'social-share-go',
						'title' => esc_html__( 'Google+', 'furnikit' ),
						'type' => 'text',
						'sub_desc' => '',
						'desc' => '',
						'std' => '',
					),
				array(
					'id' => 'social-share-pi',
					'title' => esc_html__( 'Pinterest', 'furnikit' ),
					'type' => 'text',
					'sub_desc' => '',
					'desc' => '',
					'std' => '',
				)
					
			)
	);
	
	$options[] = array(
			'title' => esc_html__('Popup Config', 'furnikit'),
			'desc' => wp_kses( __('<p class="description">Enable popup and more config for Popup.</p>', 'furnikit'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it furnikit for default.
			'icon' => FURNIKIT_URL.'/admin/img/glyphicons/glyphicons_318_more-items.png',
			//Lets leave this as a furnikit section, no options just some intro text set above.
			'fields' => array(
					array(
						'id' => 'popup_active',
						'type' => 'checkbox',
						'title' => esc_html__( 'Active Popup Subscribe', 'furnikit' ),
						'sub_desc' => esc_html__( 'Check to active popup subscribe', 'furnikit' ),
						'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),	
					
					array(
						'id' => 'popup_background',
						'title' => esc_html__( 'Popup Background', 'furnikit' ),
						'type' => 'upload',
						'sub_desc' => esc_html__( 'Choose popup background image', 'furnikit' ),
						'desc' => '',
						'std' => get_template_directory_uri().'/assets/img/popup/bg-main.jpg'
					),
					
					array(
						'id' => 'popup_content',
						'title' => esc_html__( 'Popup Content', 'furnikit' ),
						'type' => 'editor',
						'sub_desc' => esc_html__( 'Change text of popup mode', 'furnikit' ),
						'desc' => '',
						'std' => ''
					),	
					
					array(
						'id' => 'popup_form',
						'title' => esc_html__( 'Popup Form', 'furnikit' ),
						'type' => 'text',
						'sub_desc' => esc_html__( 'Put shortcode form to this field and it will be shown on popup mode frontend.', 'furnikit' ),
						'desc' => '',
						'std' => ''
					),
					
				)
		);
	
	$options[] = array(
			'title' => esc_html__('Advanced', 'furnikit'),
			'desc' => wp_kses( __('<p class="description">Custom advanced with Cpanel, Widget advanced, Developer mode </p>', 'furnikit'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it furnikit for default.
			'icon' => FURNIKIT_URL.'/admin/img/glyphicons/glyphicons_083_random.png',
			//Lets leave this as a furnikit section, no options just some intro text set above.
			'fields' => array(
					array(
						'id' => 'show_cpanel',
						'title' => esc_html__( 'Show cPanel', 'furnikit' ),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn on/off Cpanel', 'furnikit' ),
						'desc' => '',
						'std' => ''
					),
					
					array(
						'id' => 'widget-advanced',
						'title' => esc_html__('Widget Advanced', 'furnikit'),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn on/off Widget Advanced', 'furnikit' ),
						'desc' => '',
						'std' => '1'
					),					
					
					array(
						'id' => 'social_share',
						'title' => esc_html__( 'Social Share', 'furnikit' ),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn on/off social share', 'furnikit' ),
						'desc' => '',
						'std' => '1'
					),
					
					array(
						'id' => 'breadcrumb_active',
						'title' => esc_html__( 'Turn Off Breadcrumb', 'furnikit' ),
						'type' => 'checkbox',
						'sub_desc' => esc_html__( 'Turn off breadcumb on all page', 'furnikit' ),
						'desc' => '',
						'std' => '0'
					),
					
					array(
						'id' => 'back_active',
						'type' => 'checkbox',
						'title' => esc_html__('Back to top', 'furnikit'),
						'sub_desc' => '',
						'desc' => '',
						'std' => '1'// 1 = on | 0 = off
					),	
					
					array(
						'id' => 'direction',
						'type' => 'select',
						'title' => esc_html__('Direction', 'furnikit'),
						'options' => array( 'ltr' => 'Left to Right', 'rtl' => 'Right to Left' ),
						'std' => 'ltr'
					),
					
					
					array(
						'id' => 'advanced_css',
						'type' => 'textarea',
						'sub_desc' => esc_html__( 'Insert your own CSS into this block. This overrides all default styles located throughout the theme', 'furnikit' ),
						'title' => esc_html__( 'Custom CSS', 'furnikit' )
					),
					
					array(
						'id' => 'advanced_js',
						'type' => 'textarea',
						'placeholder' => esc_html__( 'Example: $("p").hide()', 'furnikit' ),
						'sub_desc' => esc_html__( 'Insert your own JS into this block. This customizes js throughout the theme', 'furnikit' ),
						'title' => esc_html__( 'Custom JS', 'furnikit' )
					)
				)
		);

	$options_args = array();

	//Setup custom links in the footer for share icons
	$options_args['share_icons']['facebook'] = array(
			'link' => 'http://www.facebook.com/wpthemego',
			'title' => 'Facebook',
			'img' => FURNIKIT_URL.'/admin/img/glyphicons/glyphicons_320_facebook.png'
	);
	$options_args['share_icons']['twitter'] = array(
			'link' => 'https://twitter.com/wpthemego/',
			'title' => 'Folow me on Twitter',
			'img' => FURNIKIT_URL.'/admin/img/glyphicons/glyphicons_322_twitter.png'
	);


	//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
	$options_args['opt_name'] = ZR_THEME;
	$webfonts = ( zr_options( 'google_webfonts_api' ) ) ? zr_options( 'google_webfonts_api' ) : 'AIzaSyAL_XMT9t2KuBe2MIcofGl6YF1IFzfB4L4';
	$options_args['google_api_key'] = $webfonts; //must be defined for use with google webfonts field type

	//Custom menu title for options page - default is "Options"
	$options_args['menu_title'] = esc_html__('Theme Options', 'furnikit');

	//Custom Page Title for options page - default is "Options"
	$options_args['page_title'] = esc_html__('Furnikit Options ', 'furnikit');

	//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "furnikit_theme_options"
	$options_args['page_slug'] = 'furnikit_theme_options';

	//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
	$options_args['page_type'] = 'submenu';

	//custom page location - default 100 - must be unique or will override other items
	$options_args['page_position'] = 27;
	$zr_options = new ZR_Options( $options, $options_args );
}
add_action( 'init', 'furnikit_Options_Setup', 0 );
// furnikit_Options_Setup();
endif; 


/*
** Define widget
*/
function furnikit_widget_setup_args(){
	$furnikit_widget_areas = array(
		
		array(
				'name' => esc_html__('Sidebar Left Blog', 'furnikit'),
				'id'   => 'left-blog',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		array(
				'name' => esc_html__('Sidebar Right Blog', 'furnikit'),
				'id'   => 'right-blog',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Top Header', 'furnikit'),
				'id'   => 'top',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),		
			
		array(
				'name' => esc_html__('Search', 'furnikit'),
				'id'   => 'search',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),

		array(
				'name' => esc_html__('Top Header2', 'furnikit'),
				'id'   => 'top2',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
					
		array(
				'name' => esc_html__('Header Right', 'furnikit'),
				'id'   => 'header-right',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		
		array(
				'name' => esc_html__('Sidebar Left Product', 'furnikit'),
				'id'   => 'left-product',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Sidebar Right Product', 'furnikit'),
				'id'   => 'right-product',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Sidebar Left Detail Product', 'furnikit'),
				'id'   => 'left-product-detail',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Sidebar Right Detail Product', 'furnikit'),
				'id'   => 'right-product-detail',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => esc_html__('Sidebar Bottom Detail Product', 'furnikit'),
				'id'   => 'bottom-detail-product',
				'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
	
		array(
				'name' => esc_html__('Footer Copyright1', 'furnikit'),
				'id'   => 'footer-copyright1',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),

		array(
				'name' => esc_html__('Footer Copyright2', 'furnikit'),
				'id'   => 'footer-copyright2',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
	);
	return apply_filters( 'furnikit_widget_register', $furnikit_widget_areas );
}