jQuery( function( $ ) {

	// wc_add_to_cart_params is required to continue, ensure the object exists
	if ( typeof wc_add_to_cart_params === 'undefined' )
		return false;

	// Ajax add to cart
	$( document ).on( 'click', '.product_type_variable.add_to_cart_button', function(e) {
		
		$variation_form = $( this ).closest( '.item-wrap' ).find( '.zr-variation-frontend' );
		var var_id = $(this).data( 'variation_id' );		
		var product_id = $(this).data( 'product_id' );
		var quantity = $(this).data( 'quantity' );
		var	item = $(this).data( 'variation' );
		
		if( var_id == 0 ){
			var qv_target =  $('.zr-quickview-bottom');
			qv_target.addClass( 'show loading' );
			// AJAX add to cart request 
			var data = {
				action: 'binace_quickviewproduct',
				product_id: product_id,
			};
			var ajaxurl   = wc_add_to_cart_params.wc_ajax_url.replace( '%%endpoint%%', 'binace_quickviewproduct' );
			e.preventDefault();
			$.post( ajaxurl, data, function( response ) {
				if ( ! response ){
					return;
				}
				qv_target.find( '.quickview-inner' ).append( response );				
				qv_target.removeClass( 'loading' );
				$( '.quickview-container .product-images' ).each(function(){
					var $id 					= this.id;
					var $rtl 					= $('body').hasClass( 'rtl' );
					var $img_slider 	= $(this).find('.product-responsive');
					var $thumb_slider = $(this).find('.product-responsive-thumbnail' )
					$img_slider.slick({
						slidesToShow: 1,
						slidesToScroll: 1,
						fade: true,
						arrows: false,
						rtl: $rtl,
						asNavFor: $thumb_slider
					});
					$thumb_slider.slick({
						slidesToShow: 4,
						slidesToScroll: 1,
						asNavFor: $img_slider,
						arrows: true,
						focusOnSelect: true,
						rtl: $rtl,
						responsive: [				
						{
							breakpoint: 360,
							settings: {
								slidesToShow: 2    
							}
						}
						]
					});

					var el = $(this);
					setTimeout(function(){
						el.removeClass("loading");
						var height = el.find('.product-responsive').outerHeight();
						var target = el.find( ' .item-video' );
						target.css({'height': height,'padding-top': (height - target.outerHeight())/2 });

						var thumb_height = el.find('.product-responsive-thumbnail' ).outerHeight();
						var thumb_target = el.find( '.item-video-thumb' );
						thumb_target.css({ height: thumb_height,'padding-top':( thumb_height - thumb_target.outerHeight() )/2 });
						qv_target.find( '.quickview-content' ).css( 'margin-top', ( $(window).height() - qv_target.find( '.quickview-content' ).outerHeight() ) /2 );
						var _wpUtilSettings  = quickview_param.wpUtilSettings;
						var woocommerce_params = quickview_param.woocommerce_params;
						var wc_add_to_cart_variation_params = quickview_param.wc_add_to_cart_variation_params;
						$.getScript(quickview_param.add_to_cart);
						$.getScript(quickview_param.woocommerce);
						$.getScript(quickview_param.add_to_cart_variable);
						$.getScript(quickview_param.wp_embed);
						$.getScript(quickview_param.underscore);
						$.getScript(quickview_param.wp_util);
					}, 1000);
				});	
			});
		}else{
				
			
			
			var $thisbutton = $( this );
			if ( $thisbutton.is( '.product_type_variable.add_to_cart_button' ) ) {

				$thisbutton.removeClass( 'added' );
				$thisbutton.addClass( 'loading' );

				var data = {
					action: 'zr_wooswatches_variation_custom_add_to_cart_ajax',
					product_id: product_id,
					quantity: quantity,
					variation_id: var_id,
					variation: item
				};

				// Trigger event
				$( 'body' ).trigger( 'adding_to_cart', [ $thisbutton, data ] );
				var ajaxurl   = wc_add_to_cart_params.wc_ajax_url.replace( '%%endpoint%%', 'zr_wooswatches_variation_custom_add_to_cart_ajax' );
				// Ajax action
				$.post( ajaxurl, data, function( response ) {

					if ( ! response )
						return;

					var this_page = window.location.toString();

					this_page = this_page.replace( 'add-to-cart', 'added-to-cart' );

					$thisbutton.removeClass('loading');

					if ( response.error && response.product_url ) {
						window.location = response.product_url;
						return;
					}

					fragments = response.fragments;
					cart_hash = response.cart_hash;
					
					console.log(fragments);

					// Block fragments class
					if ( fragments ) {
						$.each(fragments, function(key, value) {
							$(key).addClass('updating');
						});
					}

					// Block widgets and fragments
					$('.shop_table.cart, .updating, .cart_totals,.widget_shopping_cart_top', '.top-form-minicart').fadeTo('400', '0.6').block({message: null, overlayCSS: {background: 'transparent url(' + woocommerce_params.ajax_loader_url + ') no-repeat center', backgroundSize: '16px 16px', opacity: 0.6 } } );
					
					// Changes button classes
					$thisbutton.removeClass( 'loading' ).addClass( 'added' );				

					// Replace fragments
					if ( fragments ) {
						$.each(fragments, function(key, value) {
							$(key).replaceWith(value);
						});
					}

					// Unblock
					$('.widget_shopping_cart, .updating, .widget_shopping_cart_top').stop(true).css('opacity', '1').unblock();

					// Cart page elements
					$('.widget_shopping_cart_top').load( this_page + ' .widget_shopping_cart_top:eq(0) > *', function() {

						$("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").addClass('buttons_added').append('<input type="button" value="+" id="add1" class="plus" />').prepend('<input type="button" value="-" id="minus1" class="minus" />');

						$('.widget_shopping_cart_top').stop(true).css('opacity', '1').unblock();

						$('body').trigger('cart_page_refreshed');
					});
					
					// Cart page elements
					$('.shop_table.cart').load( this_page + ' .shop_table.cart:eq(0) > *', function() {

						$("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").addClass('buttons_added').append('<input type="button" value="+" id="add1" class="plus" />').prepend('<input type="button" value="-" id="minus1" class="minus" />');

						$('.shop_table.cart').stop(true).css('opacity', '1').unblock();

						$('body').trigger('cart_page_refreshed');
					});				

					$('.cart_totals').load( this_page + ' .cart_totals:eq(0) > *', function() {
						$('.cart_totals').stop(true).css('opacity', '1').unblock();
					});

					// Trigger event so themes can refresh other areas
					$('body').trigger( 'added_to_cart', [ fragments, cart_hash ] );
				});

				return false;

			} else {
				return true;
			}
		}

	});

});
