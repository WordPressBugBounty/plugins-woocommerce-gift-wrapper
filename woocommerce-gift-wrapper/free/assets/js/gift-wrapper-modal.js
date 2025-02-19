( function( $ ) {
	$( document ).ready( function() {
		// If only one wrap allowed in cart, show alert
		if ( "no" === wcgwpModal.number ) {
			document.addEventListener( "click", function (e) {
				if ( e.target.matches( ".modal .replace_wrap" ) ) {
					const cartItem = document.getElementsByClassName( "wcgwp-wrap-product" );
					if ( cartItem.length ) {
						if ( window.confirm( wcgwpModal.replaceText ) ) {
							return true;
						}
						e.preventDefault();
					}
				}
			});
		}
		let wcgwpVanillaModal;
		// Toggle the CORRECT modal
		function wcgwpGetModal( label ) {
			wcgwpVanillaModal = new Modal( {
				el: document.getElementById( "giftwrap_modal" + label )
			} );
		}
		// Toggle modal
		document.addEventListener( "click", function(e) {
			if ( ! e.target.matches( ".wcgwp-modal-toggle" ) ) {
				return;
			}
			let label = e.target.getAttribute( "data-label" );
			wcgwpGetModal( label );
			wcgwpVanillaModal.show();
		}.bind( this ) );
	});
	// Remove peri-cart gift wrap prompts when *wrappables* removed from cart (AJAX)
	$( document ).ajaxComplete( function( event, xhr, settings ) {
		if (
			xhr &&
			4 === xhr.readyState &&
			200 === xhr.status &&
			settings.url &&
			settings.url.includes( "wc-ajax=get_refreshed_fragments" )
		) {
			$.ajax( {
				type: "POST",
				url: wcgwpModal.ajaxurl,
				data: {
					action: "wcgwp_remove_from_cart",
				},
				success: function( response ) {
					if ( ! response.data ) {
						return;
					}
					$( ".giftwrap_header_wrapper" ).show();
					if ( true === response.data.hide ) {
						$( ".giftwrap_header_wrapper" ).hide();
					}
				}
			} );
		}
	});
}( jQuery ) );