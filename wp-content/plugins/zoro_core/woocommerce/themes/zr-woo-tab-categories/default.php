<?php 

/**
	* Layout Tab Category Default
	* @version     1.0.0
**/
	
	$widget_id = isset( $widget_id ) ? $widget_id : $this->generateID();
	$viewall = get_permalink( wc_get_page_id( 'shop' ) );	
	if( $category == '' ){
		return '<div class="alert alert-warning alert-dismissible" role="alert">
			<a class="close" data-dismiss="alert">&times;</a>
			<p>'. esc_html__( 'Please select a category for SW Woocommerce Tab Category Slider. Layout ', 'zr_core' ) . $layout .'</p>
		</div>';
	}
	if( !is_array( $category ) ){
		$category = explode( ',', $category );
	}
?>
<div class="zr-woo-tab-cat zr-ajax" id="<?php echo esc_attr( 'category_' . $widget_id ); ?>" >
	<div class="resp-tab" style="position:relative;">
		<div class="category-slider-content clearfix">
			<div class="block-title">
				<?php
				$titles = strpos($title1, ' ');
				$title = ($titles !== false) ? '<span>' . substr($title1, 0, $titles) . '</span>' .' '. substr($title1, $titles + 1): $title1 ;
				echo '<h3>'. $title .'</h3>';
				?>
			</div>
			<button class="button-collapse collapsed pull-right" type="button" data-toggle="collapse" data-target="#<?php echo 'nav_'.$widget_id; ?>"  aria-expanded="false">				
			</button>
			<div class="nav-tabs-select">
				<ul class="nav nav-tabs" id="<?php echo 'nav_'.$widget_id; ?>">
				<?php 
					$i = 1;
					foreach($category as $cat){
						$terms = get_term_by('slug', $cat, 'product_cat');
						if( $terms != NULL ){			
				?>
					<li class="<?php if( $i == $tab_active ){echo 'active loaded'; }?>">
						<a href="#<?php echo esc_attr( $cat. '_' .$widget_id ) ?>" data-type="tab_ajax" data-layout="<?php echo esc_attr( $layout );?>" data-row="<?php echo esc_attr( $item_row ) ?>" data-length="<?php echo esc_attr( $title_length ) ?>" data-ajaxurl="<?php echo esc_url( zr_ajax_url() ) ?>" data-category="<?php echo esc_attr( $cat ) ?>" data-toggle="tab" data-sorder="<?php echo esc_attr( $select_order ); ?>" data-catload="ajax" data-number="<?php echo esc_attr( $numberposts ); ?>" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
							<?php echo $terms->name; ?>
						</a>
					</li>	
					<?php $i ++; ?>
				<?php } } ?>
				</ul>
			</div>
		</div>
		<div class="tab-content">
		<?php 
			$active = ( $tab_active - 1 >= 0 ) ? $tab_active - 1 : 0;
			$default = array();
			if( $select_order == 'latest' ){
				$default = array(
					'post_type'	=> 'product',
					'tax_query'	=> array(
					array(
						'taxonomy'	=> 'product_cat',
						'field'		=> 'slug',
						'terms'		=> $category[$active])),
					'orderby' => 'date',
					'order' => $order,
					'post_status' => 'publish',
					'showposts' => $numberposts
				);
			}
			if( $select_order == 'rating' ){
				$default = array(
					'post_type' 			=> 'product',
					'post_status' 			=> 'publish',
					'ignore_sticky_posts'   => 1,
					'tax_query'	=> array(
					array(
						'taxonomy'	=> 'product_cat',
						'field'		=> 'slug',
						'terms'		=> $category[$active])),
					'orderby' 				=> $orderby,
					'order'					=> $order,
					'showposts' 		=> $numberposts,
				);
					$default['meta_key'] = '_wc_average_rating';	
					$default['orderby'] = 'meta_value_num';
			}
			if( $select_order == 'bestsales' ){
				$default = array(
					'post_type' 			=> 'product',
					'post_status' 			=> 'publish',
					'ignore_sticky_posts'   => 1,
					'tax_query'	=> array(
						array(
							'taxonomy'	=> 'product_cat',
							'field'		=> 'slug',
							'terms'		=> $category[$active])),
					'paged'	=> 1,
					'showposts'				=> $numberposts,
					'meta_key' 		 		=> 'total_sales',
					'orderby' 		 		=> 'meta_value_num',					
				);
			}
			if( $select_order == 'featured' ){
				$default = array(
					'post_type'				=> 'product',
					'post_status' 			=> 'publish',
					'tax_query'	=> array(
						array(
							'taxonomy'	=> 'product_cat',
							'field'		=> 'slug',
							'terms'		=> $category[$active])),
					'ignore_sticky_posts'	=> 1,
					'posts_per_page' 		=> $numberposts,
					'orderby' 				=> $orderby,
					'order' 				=> $order,					
				);
				$default['tax_query'][] = array(						
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'featured',
					'operator' => 'IN',	
				);
			}
			$default = zr_check_product_visiblity( $default );
			
			$list = new WP_Query( $default );	
			$term = get_term_by('slug', $category[$active], 'product_cat');			
		?>
			<div class="tab-pane active" id="<?php echo esc_attr( $category[$active]. '_' .$widget_id ) ?>">
			<?php if( $list->have_posts() ) : ?>
				<div id="<?php echo esc_attr( 'tab_cat_'. $category[$active]. '_' .$widget_id ); ?>" class="woo-tab-container-slider responsive-slider loading clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>"  data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
					<div class="resp-slider-container">
							<div class="slider responsive">
						<?php 
							$count_items 	= 0;
							$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
							$count_items 	= ( $numberposts >= $numb ) ? $numb : $numberposts;
							$i 				= 0;
							$j				= 0;
							while($list->have_posts()): $list->the_post();
							global $product, $post;
							$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
							if( $i % $item_row == 0 ){
						?>
							<div class="item <?php echo esc_attr( $class )?> product clearfix">
						<?php } ?>
							<div class="item-wrap">
								<div class="item-detail">										
									<div class="item-img products-thumb">		
										<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
										<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
									</div>										
									<div class="item-content">																			
										<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php zr_trim_words( get_the_title(), $title_length ); ?></a></h4>
										<?php if ( $price_html = $product->get_price_html() ){?>
										<div class="item-price">
											<span>
												<?php echo $price_html; ?>
											</span>
										</div>
										<?php } ?>
										<?php do_action( 'zr_woocommerce_custom_action' ); ?>
									</div>								
								</div>
							</div>
							<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
						<?php $i++; $j++; endwhile; wp_reset_postdata();?>
						</div>
					</div>
				</div>
				<?php 
					else :
						echo '<div class="alert alert-warning alert-dismissible" role="alert">
						<a class="close" data-dismiss="alert">&times;</a>
						<p>'. esc_html__( 'There is not product on this tab', 'zr_core' ) .'</p>
						</div>';
					endif;
				?>
			</div>
		</div>
	</div>
</div>