<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce; ?>

<?php do_action('woocommerce_before_customer_login_form'); ?>
<form method="post" class="login" id="login_ajax" action="<?php echo wp_login_url(); ?>">
	<div class="block-content">
		<div class="login-customer">
			<span><?php esc_html_e( 'Don’t have account?', 'furnikit') ?></span><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_attr_e( 'Sign up', 'furnikit' ) ?>" class="btn-reg-popup"><?php esc_html_e( 'Sign up', 'furnikit' ); ?></a>
		</div>
		<div class="registered-account">
			<div class="email-input">
				<p><?php esc_html_e( 'Your Email', 'furnikit') ?></p>
				<input type="text" class="form-control input-text username" name="username" id="username" placeholder="<?php esc_attr_e( 'Email', 'furnikit' ) ?>" />
			</div>
			<div class="pass-input">
				<p><?php esc_html_e( 'Your Password', 'furnikit') ?></p>
				<input class="form-control input-text password" type="password" placeholder="<?php esc_attr_e( '6-20 characters', 'furnikit' ) ?>" name="password" id="password" />
			</div>
			<div class="ft-link-p">
				<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>" title="<?php esc_attr_e( 'Forgot your password', 'furnikit' ) ?>"><?php esc_html_e( 'Forgot your password?', 'furnikit' ); ?></a>
			</div>
			<div class="actions">
				<div class="submit-login">
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<input type="submit" class="button btn-submit-login" name="login" value="<?php esc_attr_e( 'Login Account', 'furnikit' ); ?>" />
				</div>	
			</div>
			<div id="login_message"></div>			
		</div>
		
	</div>
</form>
<div class="clear"></div>
	
<?php do_action('woocommerce_after_cphone-icon-login ustomer_login_form'); ?>