<?php 
/**
 * Theme wrapper
 *
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */



/**
 * Page titles
 */
function furnikit_title() {
	if (is_home()) {
		if (get_option('page_for_posts', true)) {
			echo get_the_title(get_option('page_for_posts', true));
		} else {
			esc_html_e('Latest Posts', 'furnikit');
		}
	} elseif (is_archive()) {
		$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
		if ($term) {
			echo esc_html( $term->name );
		} elseif (is_post_type_archive()) {
			echo get_queried_object()->labels->name;
		} elseif (is_day()) {
			printf(__('Daily Archives: %s', 'furnikit'), get_the_date());
		} elseif (is_month()) {
			printf(__('Monthly Archives: %s', 'furnikit'), get_the_date('F Y'));
		} elseif (is_year()) {
			printf(__('Yearly Archives: %s', 'furnikit'), get_the_date('Y'));
		} elseif (is_author()) {
			printf(__('Author Archives: %s', 'furnikit'), get_the_author());
		} else {
			single_cat_title();
		}
	} elseif (is_search()) {
		printf(__('Search Results for <small>%s</small>', 'furnikit'), get_search_query());
	} elseif (is_404()) {
		esc_html_e('Not Found', 'furnikit');
	} else {
		the_title();
	}
}

/*
** Get content page by ID
*/
function furnikit_get_the_content_by_id( $post_id ) {
  $page_data = get_page( $post_id );
  if ( $page_data ) {
    $content = do_shortcode( $page_data->post_content );
		return $content;
  }
  else return false;
}

function furnikit_element_empty($element) {
	$element = trim($element);
	return empty($element) ? false : true;
}
	
/*
** Get Social share
*/
function furnikit_get_social() {
	global $post;
	
	$social = zr_options('social_share');	
	
	if ( !$social ) return false;
	ob_start();
?>
	<div class="social-share">
		<div class="title-share"><?php esc_html_e( 'Share','furnikit' ) ?></div>
		<div class="wrap-content">
			<a href="http://www.facebook.com/share.php?u=<?php echo get_permalink( $post->ID ); ?>&title=<?php echo get_the_title( $post->ID ); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-facebook"></i></a>
			<a href="http://twitter.com/home?status=<?php echo get_the_title( $post->ID ); ?>+<?php echo get_permalink( $post->ID ); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter"></i></a>
			<a href="https://plus.google.com/share?url=<?php echo get_permalink( $post->ID ); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus"></i></a>				
		</div>
	</div>
<?php 
	$data = ob_get_clean();
	echo sprintf( '%s', $data );

}

/**
 * Use Bootstrap's media object for listing comments
 *
 * @link http://twitter.github.com/bootstrap/components.html#media
 */

function furnikit_get_avatar($avatar) {
	$avatar = str_replace("class='avatar", "class='avatar pull-left media-object", $avatar);
	return $avatar;
}
add_filter('get_avatar', 'furnikit_get_avatar');


/*
** Check col for sidebar and content product
*/
function furnikit_content_product(){ 
	$left_span_class 			= zr_options('sidebar_left_expand');
	$left_span_md_class 	= zr_options('sidebar_left_expand_md');
	$left_span_sm_class 	= zr_options('sidebar_left_expand_sm');
	$right_span_class 		= zr_options('sidebar_right_expand');
	$right_span_md_class 	= zr_options('sidebar_right_expand_md');
	$right_span_sm_class 	= zr_options('sidebar_right_expand_sm');
	$sidebar 							= zr_options('sidebar_product');
	if( !is_post_type_archive( 'product' ) && !is_search() ){
		$term_id = get_queried_object()->term_id;
		$sidebar = ( get_term_meta( $term_id, 'term_sidebar', true ) != '' ) ? get_term_meta( $term_id, 'term_sidebar', true ) : zr_options('sidebar_product');
	}
	
	if( is_active_sidebar('left-product') && is_active_sidebar('right-product') && $sidebar =='lr' ){
		$content_span_class 	= 12 - ( $left_span_class + $right_span_class );
		$content_span_md_class 	= 12 - ( $left_span_md_class +  $right_span_md_class );
		$content_span_sm_class 	= 12 - ( $left_span_sm_class + $right_span_sm_class );
	} 
	elseif( is_active_sidebar('left-product') && $sidebar =='left' ) {
		$content_span_class 		= (	$left_span_class >= 12	) ? 12 : 12 - $left_span_class ;
		$content_span_md_class 	= ( $left_span_md_class >= 12 ) ? 12 : 12 - $left_span_md_class ;
		$content_span_sm_class 	= ( $left_span_sm_class >= 12 ) ? 12 : 12 - $left_span_sm_class ;
	}
	elseif( is_active_sidebar('right-product') && $sidebar =='right' ) {
		$content_span_class 	= ($right_span_class >= 12) ? 12 : 12 - $right_span_class;
		$content_span_md_class 	= ($right_span_md_class >= 12) ? 12 : 12 - $right_span_md_class ;
		$content_span_sm_class 	= ($right_span_sm_class >= 12) ? 12 : 12 - $right_span_sm_class ;
	}
	else {
		$content_span_class 	= 12;
		$content_span_md_class 	= 12;
		$content_span_sm_class 	= 12;
	}
	$classes = array( 'content' );
	
	$classes[] = 'col-lg-'.$content_span_class.' col-md-'.$content_span_md_class .' col-sm-'.$content_span_sm_class;
	
	echo 'class="' . join( ' ', $classes ) . '"';
}

/*
** Check col for sidebar and content product detail
*/
function furnikit_content_product_detail(){
	$left_span_class 		= zr_options('sidebar_left_expand');
	$left_span_md_class 	= zr_options('sidebar_left_expand_md');
	$left_span_sm_class 	= zr_options('sidebar_left_expand_sm');
	$right_span_class 		= zr_options('sidebar_right_expand');
	$right_span_md_class 	= zr_options('sidebar_right_expand_md');
	$right_span_sm_class 	= zr_options('sidebar_right_expand_sm');
	$sidebar_template 		= zr_options('sidebar_product_detail');
	
	if( is_singular( 'product' ) ) :
		$sidebar_template = ( get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) : zr_options('sidebar_product_detail');
		$sidebar 					= ( get_post_meta( get_the_ID(), 'page_sidebar_template', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_sidebar_template', true ) : 'left-product-detail';
	endif;
	
	if( is_active_sidebar($sidebar) && $sidebar_template == 'left' ) {
		$content_span_class 		= (	$left_span_class >= 12	) ? 12 : 12 - $left_span_class ;
		$content_span_md_class 	= ( $left_span_md_class >= 12 ) ? 12 : 12 - $left_span_md_class ;
		$content_span_sm_class 	= ( $left_span_sm_class >= 12 ) ? 12 : 12 - $left_span_sm_class ;
	}
	elseif( is_active_sidebar($sidebar) && $sidebar_template == 'right' ) {
		$content_span_class 	= ($right_span_class >= 12) ? 12 : 12 - $right_span_class;
		$content_span_md_class 	= ($right_span_md_class >= 12) ? 12 : 12 - $right_span_md_class ;
		$content_span_sm_class 	= ($right_span_sm_class >= 12) ? 12 : 12 - $right_span_sm_class ;
	}
	else {
		$content_span_class 	= 12;
		$content_span_md_class 	= 12;
		$content_span_sm_class 	= 12;
	}
	$classes = array( 'content' );
	
	$classes[] = 'col-lg-'.$content_span_class.' col-md-'.$content_span_md_class .' col-sm-'.$content_span_sm_class;
	
	echo 'class="' . join( ' ', $classes ) . '"';
}

/*
** Check col for sidebar and content blog
*/
function furnikit_content_blog(){
	$left_span_class 		= zr_options('sidebar_left_expand');
	$left_span_md_class 	= zr_options('sidebar_left_expand_md');
	$left_span_sm_class 	= zr_options('sidebar_left_expand_sm');
	$right_span_class 		= ( zr_options('sidebar_right_expand') ) ? zr_options('sidebar_right_expand') : 3;
	$right_span_md_class 	= ( zr_options('sidebar_right_expand_md') ) ? zr_options('sidebar_right_expand_md') : 3;
	$right_span_sm_class 	= ( zr_options('sidebar_right_expand_sm') ) ? zr_options('sidebar_right_expand_sm') : 3;
	$sidebar_template 		= ( zr_options('sidebar_blog') ) ? zr_options('sidebar_blog') : 'right';
	$sidebar  				= 'right-blog';
	if( is_single() ) :
		$sidebar_template = ( strlen( get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) ) > 0 ) ? get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) : zr_options('sidebar_blog');
		$sidebar 					= ( strlen( get_post_meta( get_the_ID(), 'page_sidebar_template', true ) ) > 0 ) ? get_post_meta( get_the_ID(), 'page_sidebar_template', true ) : 'left-blog';
	endif;
	
	if( is_active_sidebar($sidebar) && $sidebar_template == 'left' ) {
		$content_span_class 	= ($left_span_class >= 12) ? 12 : 12 - $left_span_class ;
		$content_span_md_class 	= ($left_span_md_class >= 12) ? 12 : 12 - $left_span_md_class ;
		$content_span_sm_class 	= ($left_span_sm_class >= 12) ? 12 : 12 - $left_span_sm_class ;
	} 
	elseif( is_active_sidebar($sidebar) && $sidebar_template == 'right' ) {
		$content_span_class 	= ($right_span_class >= 12) ? 12 : 12 - $right_span_class;
		$content_span_md_class 	= ($right_span_md_class >= 12) ? 12 : 12 - $right_span_md_class ;
		$content_span_sm_class 	= ($right_span_sm_class >= 12) ? 12 : 12 - $right_span_sm_class ;
	} 
	else {
		$content_span_class 	= 12;
		$content_span_md_class 	= 12;
		$content_span_sm_class 	= 12;
	}
	$classes = array( '' );
	
	$classes[] = 'col-lg-'.$content_span_class.' col-md-'.$content_span_md_class .' col-sm-'.$content_span_sm_class . ' col-xs-12';
	
	echo  join( ' ', $classes ) ;
}

/*
** Check sidebar blog
*/
function furnikit_sidebar_template(){
	$furnikit_sidebar_teplate = zr_options('sidebar_blog');
	if( !is_archive() ){
		$furnikit_sidebar_teplate = ( get_term_meta( get_queried_object()->term_id, 'term_sidebar', true ) != '' ) ? get_term_meta( get_queried_object()->term_id, 'term_sidebar', true ) : zr_options('sidebar_blog');
	}	
	if( is_single() ) {
		$furnikit_sidebar_teplate = ( get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) : zr_options('sidebar_blog');
	}
	return $furnikit_sidebar_teplate;
}

/*
** Check col for sidebar and content page
*/
function furnikit_content_page(){
	$left_span_class 		= zr_options('sidebar_left_expand');
	$left_span_md_class 	= zr_options('sidebar_left_expand_md');
	$left_span_sm_class 	= zr_options('sidebar_left_expand_sm');
	$right_span_class 		= zr_options('sidebar_right_expand');
	$right_span_md_class 	= zr_options('sidebar_right_expand_md');
	$right_span_sm_class 	= zr_options('sidebar_right_expand_sm');
	$sidebar_template 		= get_post_meta( get_the_ID(), 'page_sidebar_layout', true );
	$sidebar 				= get_post_meta( get_the_ID(), 'page_sidebar_template', true );
	
	if( is_active_sidebar( $sidebar ) && $sidebar_template == 'left' ) {
		$content_span_class 		= ( $left_span_class >= 12 ) ? 12 : 12 - $left_span_class ;
		$content_span_md_class 	= ( $left_span_md_class >= 12) ? 12 : 12 - $left_span_md_class ;
		$content_span_sm_class 	= ( $left_span_sm_class >= 12) ? 12 : 12 - $left_span_sm_class ;
	} 
	elseif( is_active_sidebar( $sidebar ) && $sidebar_template == 'right' ) {
		$content_span_class 	= ($right_span_class >= 12) ? 12 : 12 - $right_span_class;
		$content_span_md_class 	= ($right_span_md_class >= 12) ? 12 : 12 - $right_span_md_class ;
		$content_span_sm_class 	= ($right_span_sm_class >= 12) ? 12 : 12 - $right_span_sm_class ;
	} 
	else {
		$content_span_class 	= 12;
		$content_span_md_class 	= 12;
		$content_span_sm_class 	= 12;
	}
	$classes = array( '' );
	
	$classes[] = 'col-lg-'.$content_span_class.' col-md-'.$content_span_md_class .' col-sm-'.$content_span_sm_class . ' col-xs-12';
	
	echo  join( ' ', $classes ) ;
}

/*
** Typography
*/
function furnikit_typography_css(){
	$styles = '';
	$page_webfonts  = get_post_meta( get_the_ID(), 'google_webfonts', true );
	$webfont 		= ( $page_webfonts != '' ) ? $page_webfonts : zr_options( 'google_webfonts' );
	$header_webfont = zr_options( 'header_tag_font' );
	$menu_webfont 	= zr_options( 'menu_font' );
	$custom_webfont = zr_options( 'custom_font' );
	$custom_class 	= zr_options( 'custom_font_class' );
	$webfont1 = ( $webfont == '' ) ? 'Roboto' : $webfont;
	$styles = '<style>';
	if ( $webfont ):	
		$webfonts_assign = ( get_post_meta( get_the_ID(), 'webfonts_assign', true ) != '' ) ? get_post_meta( get_the_ID(), 'webfonts_assign', true ) : '';
		if ( $webfonts_assign == 'headers' ){
			$styles .= 'h1, h2, h3, h4, h5, h6 {';
		} else if ( $webfonts_assign == 'custom' ){
			$custom_assign = ( get_post_meta( get_the_ID(), 'webfonts_custom', true ) ) ? get_post_meta( get_the_ID(), 'webfonts_custom', true ) : '';
			$custom_assign = trim($custom_assign);
			if ( !$custom_assign ) return '';
			$styles .= $custom_assign . ' {';
		} else {
			$styles .= 'body, input, button, select, textarea, .search-query {';
		}
		$styles .= 'font-family: ' . esc_attr( $webfont ) . ' !important;}';
	endif;
	
	/* Header webfont */
	if( $header_webfont ) :
		$styles .= 'h1, h2, h3, h4, h5, h6 {';
		$styles .= 'font-family: ' . esc_attr( $header_webfont ) . ' !important;}';
	endif;
	
	/* Menu Webfont */
	if( $menu_webfont ) :
		$styles .= '.primary-menu .menu-title, .vertical_megamenu .menu-title {';
		$styles .= 'font-family: ' . esc_attr( $menu_webfont ) . ' !important;}';
	endif;
	
	/* Custom Webfont */
	if( $custom_webfont && trim( $custom_class ) ) :
		$styles .= $custom_class . ' {';
		$styles .= 'font-family: ' . esc_attr( $custom_webfont ) . ' !important;}';
	endif;
	
	$styles .= '</style>';
	return $styles;
}

function furnikit_typography_css_cache(){ 
		
	/* Custom Css */
	if ( zr_options('advanced_css') != '' ){
		echo'<style>'. zr_options( 'advanced_css' ) .'</style>';
	}
	$data = furnikit_typography_css();
	echo sprintf( '%s', $data );
}
add_action( 'wp_head', 'furnikit_typography_css_cache', 12, 0 );

function furnikit_typography_webfonts(){
	$page_google_webfonts = get_post_meta( get_the_ID(), 'google_webfonts', true );
	$webfont 		= ( $page_google_webfonts != '' ) ? $page_google_webfonts : zr_options('google_webfonts');
	$header_webfont = zr_options( 'header_tag_font' );
	$menu_webfont 	= zr_options( 'menu_font' );
	$custom_webfont = zr_options( 'custom_font' );
	$webfont = ( $webfont == '' ) ? 'Roboto' : $webfont;

	if ( $webfont || $header_webfont || $menu_webfont || $custom_webfont ):
		$font_url = '';
		$webfont_weight = array();
		$webfont_weight	= ( get_post_meta( get_the_ID(), 'webfonts_weight', true ) ) ? get_post_meta( get_the_ID(), 'webfonts_weight', true ) : zr_options('webfonts_weight');
		$font_weight = '';
		if( empty($webfont_weight) ){
			$font_weight = '400';
		}
		else{
			foreach( $webfont_weight as $i => $wf_weight ){
				( $i < 1 )?	$font_weight .= '' : $font_weight .= ',';
				$font_weight .= $wf_weight;
			}
		}
		
		$webfont = $webfont . ':' . $font_weight;
		
		if( $header_webfont ){
			$webfont1 = ( $webfont ) ? '|' . $header_webfont : $header_webfont;
			$webfont .= $webfont1 . ':' . $font_weight;
		}
		
		if( $menu_webfont ){
			$webfont1 = ( $webfont ) ? '|' . $menu_webfont : $menu_webfont;
			$webfont .= $webfont1 . ':' . $font_weight;
		}
		
		if( $custom_webfont ){
			$webfont1 = ( $webfont ) ? '|' . $custom_webfont : $custom_webfont;
			$webfont .= $webfont1 . ':' . $font_weight;
		}
		if ( 'off' !== _x( 'on', 'Google font: on or off', 'furnikit' ) ) {
			$font_url = add_query_arg( 'family', urlencode( $webfont ), "//fonts.googleapis.com/css" );
		}
		return $font_url;
	endif;
}

function furnikit_googlefonts_script() {
    wp_enqueue_style( 'furnikit-googlefonts', furnikit_typography_webfonts(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'furnikit_googlefonts_script' );


/* 
** Get video or iframe from content 
*/
function furnikit_get_entry_content_asset( $post_id ){
	global $post;
	$post = get_post( $post_id );
	
	$content = apply_filters ("the_content", $post->post_content);
	
	$value=preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU',$content,$results);
	if($value){
		return $results[0];
	}else{
		return '';
	}
}

/*
** Tag cloud size
*/
add_filter( 'widget_tag_cloud_args', 'furnikit_tag_clound' );
function furnikit_tag_clound($args){
	$args['largest'] = 8;
	return $args;
}

/*
** Footer Adnvanced
*/
add_action( 'wp_footer', 'furnikit_footer_advanced' );
function furnikit_footer_advanced(){
	/* 
	** Back To Top 
	*/
	if( zr_options( 'back_active' ) ) :
		echo '<a id="furnikit-totop" href="#" ></a>';
	endif;
	
	/* 
	** Popup 
	*/
	if( zr_options( 'popup_active' ) ) :
		$furnikit_content = zr_options( 'popup_content' );
		$furnikit_shortcode = zr_options( 'popup_form' );
		$popup_attr = ( zr_options( 'popup_background' ) != '' ) ? 'style="background: url( '. esc_url( zr_options( 'popup_background' ) ) .' )"' : '';
?>
		<div id="subscribe_popup" class="subscribe-popup"<?php echo sprintf( '%s', $popup_attr ); ?>>
			<div class="subscribe-popup-container">
				<?php if( $furnikit_content != '' ) : ?>
				<div class="popup-content">
					<?php echo sprintf( '%s', $furnikit_content ); ?>
				</div>
				<?php endif; ?>
				
				<?php if( $furnikit_shortcode != '' ) : ?>
				<div class="subscribe-form">
					<?php	echo do_shortcode( $furnikit_shortcode ); ?>
				</div>
				<?php endif; ?>
				
				<div class="subscribe-checkbox">
					<label for="popup_check">
						<input id="popup_check" name="popup_check" type="checkbox" />
						<?php echo '<span>' . esc_html__( "Don't show this popup again!", "furnikit" ) . '</span>'; ?>
					</label>
				</div>				
			</div>
			<div class="subscribe-social">
				<h3><?php echo esc_html__('follow us','furnikit'); ?></h3>
				<div class="subscribe-social-inner">
					<?php zr_social_link() ?>
				</div>
			</div>
		</div>
	<?php 
	endif;
	
	/*
	** Login Form 
	*/
	if( class_exists( 'WooCommerce' ) ){		
?>
	<div class="modal fade" id="login_form" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog block-popup-login">
			<?php ob_start(); ?>
			<a href="javascript:void(0)" title="<?php esc_attr_e( 'Close', 'furnikit' ) ?>" class="close close-login" data-dismiss="modal"><?php esc_html_e( 'Close', 'furnikit' ) ?></a>
			<div class="tt_popup_login"><?php esc_html_e('Sign in Or Register', 'furnikit'); ?></div>
			<?php get_template_part('woocommerce/myaccount/login-form'); ?>
			<?php 
				if( class_exists( 'APSL_Lite_Class' ) ) :
					echo '<div class="login-line"><span>'. esc_html__( 'Or', 'furnikit' ) .'</span></div>';
						echo do_shortcode('[apsl-login-lite]'); 
				endif;
				
				$html = ob_get_clean();
				echo apply_filters( 'furnikit_custom_login_filter', $html );
			?>
		</div>
	</div>
<?php 	
	
	/*
	** Quickview Footer
	*/
	if( zr_options( 'product_quickview' ) ){
?>
	<div class="zr-quickview-bottom">
		<div class="quickview-content" id="quickview_content">
			<a href="javascript:void(0)" class="quickview-close">x</a>
			<div class="quickview-inner"></div>
		</div>	
	</div>
<?php 
		}
	}
}

/**
* Popup Newsletter & Menu Sticky
**/
function furnikit_advanced(){	
	$furnikit_popup	 		= zr_options( 'popup_active' );
	$sticky_mobile	 		= zr_options( 'sticky_mobile' );
	$output  = '';
	$output .= '(function($) {';
	if( !furnikit_mobile_check() ) : 
		$sticky_menu 		= zr_options( 'sticky_menu' );
		$furnikit_header_style 	= ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : zr_options('header_style');
		$output_css = '';
		$layout = zr_options('layout');
		$bg_image = zr_options('bg_box_img');
		$header_mid = zr_options('header_mid');
		$bg_header_mid = zr_options('bg_header_mid');			
		
		if( $layout == 'boxed' ){
			$output_css .= 'body{';		
			$output_css .= ( $bg_image != '' ) ? 'background-image: url('.esc_attr( $bg_image ).');
				background-position: top center; 
				background-attachment: fixed;' : '';
			$output_css .= '}';
			wp_enqueue_style(	'furnikit_custom_css',	get_template_directory_uri() . '/css/custom_css.css' );
			wp_add_inline_style( 'furnikit_custom_css', $output_css );
		}
		
		/*
		** Add background header mid
		*/
		
		if( $header_mid ){
			$output_css .= '#header .header-mid{';		
			$output_css .= ( $bg_header_mid != '' ) ? 'background-image: url('.esc_attr( $bg_header_mid ).');
				background-position: top center; 
				background-attachment: fixed;' : '';
			$output_css .= '}';
			wp_enqueue_style(	'furnikit_custom_css',	get_template_directory_uri() . '/css/custom_css.css' );
			wp_add_inline_style( 'furnikit_custom_css', $output_css );
		}
		
		/*
		** Menu Sticky 
		*/
		if( $sticky_menu ) :	
			if( $furnikit_header_style == 'style10' ){		
				$output .= 'var sticky_navigation_offset = $("#header .header-top").offset();';
				$output .= 'if( typeof sticky_navigation_offset != "undefined" ) {';
				$output .= 'var sticky_navigation_offset_top = sticky_navigation_offset.top;';
				$output .= 'var sticky_navigation = function(){';
				$output .= 'var scroll_top = $(window).scrollTop();';
				$output .= 'if (scroll_top > sticky_navigation_offset_top) {';
				$output .= '$("#header .header-top").addClass("sticky-menu");';
				$output .= '$("#header .header-top").css({ "top":0, "left":0, "right" : 0 });';
				$output .= '} else {';
				$output .= '$("#header .header-top").removeClass("sticky-menu");';
				$output .= '}';
				$output .= '};';
				$output .= 'sticky_navigation();';
				$output .= '$(window).scroll(function() {';
				$output .= 'sticky_navigation();';
				$output .= '}); }';
			}
			elseif( $furnikit_header_style == 'style1' || $furnikit_header_style == 'style2' || $furnikit_header_style == 'style3' || $furnikit_header_style == 'style4' ){
				$output .= 'var sticky_navigation_offset = $("#header .header-mid ").offset();';
				$output .= 'if( typeof sticky_navigation_offset != "undefined" ) {';
				$output .= 'var sticky_navigation_offset_top = sticky_navigation_offset.top;';
				$output .= 'var sticky_navigation = function(){';
				$output .= 'var scroll_top = $(window).scrollTop();';
				$output .= 'if (scroll_top > sticky_navigation_offset_top) {';
				$output .= '$("#header .header-mid ").addClass("sticky-menu");';
				$output .= '$("#header .header-mid ").css({ "top":0, "left":0, "right" : 0 });';
				$output .= '} else {';
				$output .= '$("#header .header-mid ").removeClass("sticky-menu");';
				$output .= '}';
				$output .= '};';
				$output .= 'sticky_navigation();';
				$output .= '$(window).scroll(function() {';
				$output .= 'sticky_navigation();';
				$output .= '}); }';
			}
			endif;
			
			/*
			** Adnvanced JS
			*/
			if( zr_options( 'advanced_js' ) != '' ) :
				$output .= zr_options( 'advanced_js' );
			endif;
			
		endif;			
			/*
			** Popup Newsletter
			*/
			if( $furnikit_popup ){
				$output .= '$(document).ready(function() {
						var check_cookie = $.cookie("subscribe_popup");
						if(check_cookie == null || check_cookie == "shown") {
							 popupNewsletter();
						 }
						$("#subscribe_popup input#popup_check").on("click", function(){
							if($(this).parent().find("input:checked").length){        
								var check_cookie = $.cookie("subscribe_popup");
								 if(check_cookie == null || check_cookie == "shown") {
									$.cookie("subscribe_popup","dontshowitagain");            
								}
								else
								{
									$.cookie("subscribe_popup","shown");
									popupNewsletter();
								}
							} else {
								$.cookie("subscribe_popup","shown");
							}
						}); 
					});

					function popupNewsletter() {
						jQuery.fancybox({
							href: "#subscribe_popup",
							autoResize: true
						});
						jQuery("#subscribe_popup").trigger("click");
						jQuery("#subscribe_popup").parents(".fancybox-overlay").addClass("popup-fancy");
					};';
			}
		$output .= '}(jQuery));';
		
		$translation_text = array(
			'cart_text' 	 => esc_html__( 'Add To Cart', 'furnikit' ),
			'compare_text' 	 => esc_html__( 'Add To Compare', 'furnikit' ),
			'wishlist_text'  => esc_html__( 'Add To WishList', 'furnikit' ),
			'quickview_text' => esc_html__( 'QuickView', 'furnikit' ),
			'ajax_url' => admin_url( 'admin-ajax.php', 'relative' ), 
			'redirect' => get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ),
			'message' => esc_html__( 'Please enter your usename and password', 'furnikit' ),
		);
		
		wp_localize_script( 'furnikit_custom_js', 'custom_text', $translation_text );
		wp_enqueue_script( 'furnikit_custom_js', get_template_directory_uri() . '/js/adminc.js', array(), null, true );
		wp_add_inline_script( 'furnikit_custom_js', $output );
	
}
add_action( 'wp_enqueue_scripts', 'furnikit_advanced', 101 );


/**
* Set and Get view count
**/
function furnikit_getPostViews($postID){    
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
		return "0";
	}
	return $count;
}

function furnikit_setPostViews($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
	}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
	}
}  

/*
** Create Postview on header
*/
add_action( 'wp_head', 'furnikit_create_postview' );
function furnikit_create_postview(){
	if( is_single() || is_singular( 'product' ) ) :
		furnikit_setPostViews( get_the_ID() );
	endif;
}

/*
** Furnikit Logo
*/
function furnikit_logo(){
	$scheme_meta = get_post_meta( get_the_ID(), 'scheme', true );
	$scheme 	 = ( $scheme_meta != '' && $scheme_meta != 'none' ) ? $scheme_meta : zr_options( 'scheme' );
	$meta_img_ID = get_post_meta( get_the_ID(), 'page_logo', true );
	$meta_img 	 = ( $meta_img_ID != '' ) ? wp_get_attachment_image_url( $meta_img_ID, 'full' ) : '';
	$mobile_logo = zr_options( 'mobile_logo' );
	$logo_select = ( furnikit_mobile_check() && $mobile_logo != ''  ) ? $mobile_logo : zr_options( 'sitelogo' );
	$main_logo	 = ( $meta_img != '' )? $meta_img : $logo_select;
?>
	<a  href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php if( $main_logo != '' ){ ?>
			<img src="<?php echo esc_url( $main_logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
		<?php }else{
			$logo = get_template_directory_uri().'/assets/img/logo-default.png';
			if ( $scheme ){ 
				$logo = get_template_directory_uri().'/assets/img/logo-'. $scheme .'.png'; 
			}
		?>
			<img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
		<?php } ?>
	</a>
<?php 
}

/*
** Function Get datetime blog 
*/
function furnikit_get_time(){
	global $post;
	echo '<span class="entry-date latest_post_date">
		<span class="day-time">'. get_the_time( 'd', $post->ID ) . '</span>
		<span class="month-time">'. get_the_time( 'M', $post->ID ) . '</span>
	</span>';
}

/*
** BLog columns
*/
function furnikit_blogcol(){
	global $zr_blogcol;
	$blog_col = ( isset( $zr_blogcol ) && $zr_blogcol > 0 ) ? $zr_blogcol : zr_options('blog_column');
	$col = 'col-md-'.( 12/$blog_col ).' col-sm-6 col-xs-12 theme-clearfix';
	$col .= ( get_the_post_thumbnail() ) ? '' : ' no-thumb';
	return $col;
}

/*
** Trimword Title
*/

function furnikit_trim_words( $title ){
	$title_length = intval( zr_options( 'title_length' ) );
	$html = '';
	if( $title_length > 0 ){
		$html .= wp_trim_words( $title, $title_length, '...' );
	}else{
		$html .= $title;
	}
	echo esc_html( $html );
}

/*
** Advanced Favico
*/
add_filter( 'get_site_icon_url', 'furnikit_site_favicon', 10, 1 );
function furnikit_site_favicon( $url ){
	if ( zr_options('favicon') ){
		$url = esc_url( zr_options('favicon') );
	}
	return $url;
}

/*
** Social Link
*/
if( !function_exists( 'zr_social_link' ) ) {
	function zr_social_link(){
		$fb_link = zr_options('social-share-fb');
		$tw_link = zr_options('social-share-tw');
		$tb_link = zr_options('social-share-tumblr');
		$li_link = zr_options('social-share-in');
		$gg_link = zr_options('social-share-go');
		$pt_link = zr_options('social-share-pi');
		$it_link = zr_options('social-share-instagram');

		$html = '';
		if( $fb_link != '' || $tw_link != '' || $tb_link != '' || $li_link != '' || $gg_link != '' || $pt_link != '' ):
		$html .= '<div class="furnikit-socials"><ul>';
			if( $fb_link != '' ):
				$html .= '<li><a href="'. esc_url( $fb_link ) .'" title="'. esc_attr__( 'Facebook', 'furnikit' ) .'"><i class="fa fa-facebook"></i></a></li>';
			endif;
			
			if( $tw_link != '' ):
				$html .= '<li><a href="'. esc_url( $tw_link ) .'" title="'. esc_attr__( 'Twitter', 'furnikit' ) .'"><i class="fa fa-twitter"></i></a></li>';
			endif;
			
			if( $tb_link != '' ):
				$html .= '<li><a href="'. esc_url( $tb_link ) .'" title="'. esc_attr__( 'Tumblr', 'furnikit' ) .'"><i class="fa fa-tumblr"></i></a></li>';
			endif;
			
			if( $li_link != '' ):
				$html .= '<li><a href="'. esc_url( $li_link ) .'" title="'. esc_attr__( 'Linkedin', 'furnikit' ) .'"><i class="fa fa-linkedin"></i></a></li>';
			endif;
			
			if( $it_link != '' ):
				$html .= '<li><a href="'. esc_url( $it_link ) .'" title="'. esc_attr__( 'Instagram', 'furnikit' ) .'"><i class="fa fa-instagram"></i></a></li>';
			endif;
			
			if( $gg_link != '' ):
				$html .= '<li><a href="'. esc_url( $gg_link ) .'" title="'. esc_attr__( 'Google+', 'furnikit' ) .'"><i class="fa fa-google-plus"></i></a></li>';
			endif;
			
			if( $pt_link != '' ):
				$html .= '<li><a href="'. esc_url( $pt_link ) .'" title="'. esc_attr__( 'Pinterest', 'furnikit' ) .'"><i class="fa fa-pinterest"></i></a></li>';
			endif;
		$html .= '</ul></div>';
		endif;
		echo wp_kses( $html, array( 'div' => array( 'class' => array() ), 'ul' => array(), 'li' => array(), 'a' => array( 'href' => array(), 'class' => array(), 'title' => array() ), 'i' => array( 'class' => array() ) ) );
	}
}

/**
* Change position of comment form
**/
function furnikit_move_comment_field_to_bottom( $fields ) {
$comment_field = $fields['comment'];
unset( $fields['comment'] );
$fields['comment'] = $comment_field;
return $fields;
}
 
add_filter( 'comment_form_fields', 'furnikit_move_comment_field_to_bottom' );

/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function furnikit_custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'furnikit_custom_excerpt_length', 999 );