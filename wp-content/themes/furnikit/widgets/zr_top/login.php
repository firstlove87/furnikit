<?php if ( class_exists( 'WooCommerce' ) ) { ?>
<?php global $woocommerce; ?>
<div class="top-login">
	<?php if ( ! is_user_logged_in() ) {  ?>		
		<?php echo ' <a href="javascript:void(0);" data-toggle="modal" data-target="#login_form"><span>'.esc_html__( 'Login/Register', 'furnikit' ).'</span></a> '; ?>
	<?php } else{?>
		<?php 
			$user_id = get_current_user_id();
			$user_info = get_userdata( $user_id );	
		?>
		<a href="<?php echo wp_logout_url( home_url('/') ); ?>" title="<?php esc_attr_e( 'Logout', 'furnikit' ) ?>"><span><?php esc_html_e('Logout', 'furnikit'); ?></span></a> 
	<?php } ?>
</div>
<?php } ?>
