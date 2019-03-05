<?php 
	if( !is_array( $select_order ) ){
		$select_order = explode( ',', $select_order );
	}
	
	$widget_id = isset( $widget_id ) ? $widget_id : $this->generateID();
	$viewall = get_permalink( wc_get_page_id( 'shop' ) );	
?>
<div class="zr-tab-mobile style-moblie" id="<?php echo esc_attr( $widget_id ); ?>" >
	<div class="resp-tab" style="position:relative;">
		<div class="top-tab-slider clearfix">
			<div class="woocommmerce-shop"><a href="<?php echo esc_url( $viewall ); ?>" title="<?php esc_html_e( 'Woocommerce Shop', 'zr_core' ) ?>"><?php echo esc_html__('View all','zr_core');?></a></div>
			<ul class="nav nav-tabs">
				<?php 
						$tab_title = '';
						foreach( $select_order as $i  => $so ){						
							switch ($so) {
							case 'latest':
								$tab_title = __( 'Latest Products', 'zr_core' );
								( zr_mobile_check() ) ? $tab_title = __( 'New arrivals', 'zr_core' ) : $tab_title = __( 'Latest Products', 'zr_core' );
							break;
							case 'rating':
								$tab_title = __( 'Top Rating Products', 'zr_core' );
							break;
							case 'bestsales':
								$tab_title = __( 'Best Selling Products', 'zr_core' );
								( zr_mobile_check() ) ? $tab_title = __( 'Best Selling', 'zr_core' ) : $tab_title = __( 'Best Selling Products', 'zr_core' );
							break;						
							default:
								$tab_title = __( 'Featured Products', 'zr_core' );
							}
					?>
					<li <?php echo ( $i == 0 )? 'class="active"' : ''; ?>>
						<a href="#<?php echo esc_attr( $so. '_' .$widget_id ) ?>" data-type="so_ajax" data-layout="<?php echo esc_attr( $layout );?>" data-length="<?php echo esc_attr( $title_length ) ?>" data-row="<?php echo esc_attr( $item_row ) ?>" data-ajaxurl="<?php echo esc_url( zr_ajax_url() ) ?>" data-category="<?php echo esc_attr( $category ) ?>" data-toggle="tab" data-sorder="<?php echo esc_attr( $so ); ?>" data-catload="ajax" data-number="<?php echo esc_attr( $numberposts ); ?>" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
							<?php echo esc_html( $tab_title ); ?>
						</a>
					</li>			
				<?php } ?>
			</ul>
		</div>		
		<div class="tab-content clearfix">	
		<!-- Product tab slider -->
		<?php foreach( $select_order as $i  => $so ){ ?>
			<div class="tab-pane <?php echo ( $i == ( $tab_active -1 ) ) ? 'active in' : ''; ?>" id="<?php echo esc_attr( $so. '_' .$widget_id ) ?>"></div>
		<?php } ?>											
		</div>			
		<!-- End product tab slider -->
	</div>
</div>
