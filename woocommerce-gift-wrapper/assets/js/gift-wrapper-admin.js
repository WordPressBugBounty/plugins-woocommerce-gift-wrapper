jQuery(function($) {

	// When Thickbox is closed, remove/add classes that ensure plugin deactivation can happen
	$( document.body ).on( 'thickbox:removed', function () {
		$( "#deactivate-woocommerce-gift-wrapper" ).removeClass( "thickbox-open" );
		if ( $( "#deactivate-woocommerce-gift-wrapper" ).hasClass( "deactiviate" ) ) {
			$( "#deactivate-woocommerce-gift-wrapper" )[0].click();
		}
	} );

});

jQuery( document ).ready( function($) {

	// Disable a couple of WCGWP settings checkboxes
	$( "#wcgwp_multiples, #wcgwp_all_products" ).attr( "disabled", true );

	$( "#wcgwp-wrap-category-link" ).on( "click", function() {
		$( "#wcgwp_category_id").focus();
		$( [ document.documentElement, document.body ] ).animate({
			scrollTop: $( "#wcgwp_category_id" ).offset().top - 125
		}, 500 );
	});

	$( "#wcgwp_note_fee" ).on( "change", function () {
		if ( "yes" === $(this).val() ) {
			$( ".wcgwp-note-fee-amount" ).closest( "tr" ).show();
		} else {
			$( ".wcgwp-note-fee-amount" ).closest( "tr" ).hide();
		}
	}).trigger( "change" );

	$( "#wcgwp_cart_display" ).on( "change", function() {
		if ( "checkbox" === $(this).val() ) {
			$( "#wcgwp_checkbox_link" ).closest( "tr" ).show();
			$( "#wcgwp_show_thumb, #wcgwp_link" ).closest( "tr" ).hide();
		} else {
			$( "#wcgwp_checkbox_link" ).closest( "tr" ).hide();
			$( "#wcgwp_show_thumb, #wcgwp_link" ).closest( "tr" ).show();
		}
	}).trigger( "change" );

	$( "#wcgwp_number" ).on( "change", function () {
		if ( "yes" === $(this).val() ) {
			$( ".wcgwp-number-max" ).closest( "tr" ).show();
		} else {
			$( ".wcgwp-number-max" ).closest( "tr" ).hide();
		}
	}).trigger( "change" );

	$( ".wcgwp-plus" ).closest( "tr" ).hide();

	$( "#deactivate-woocommerce-gift-wrapper" ).on( "click", function( e ) {

		// If deactivation link does not have additional classes, go ahead and open feedback Thickbox
		if ( ! $( this ).hasClass( "thickbox-open" ) && ! $( this ).hasClass( "deactiviate" ) ) {
			e.preventDefault();
			$( "#wcgwp-feedback-thickbox-link" ).trigger( "click" );
			$( this ).addClass( "thickbox-open" );
		}

	});

	$( "#wcgwp-feedback-dialog-form input" ).on( "change", function() {
		$( ".wcgwp-feedback-text" ).hide();
		if ( $( this ).is( ":checked" ) ) {
			$( '.' + this.id ).show();
		}
	});

	$( '#wcgwp-feedback-skip' ).on( 'click', function() {

		$( ".wcgwp-button" ).addClass( "disabled" );
		$( "#wcgwp-feedback-dialog-form .spinner" ).show().css( "visibility", "visible" );
		$( "#deactivate-woocommerce-gift-wrapper" ).addClass( "deactiviate" );
		$( "#TB_closeWindowButton" ).trigger( "click" );

	} );

	$( '#wcgwp-feedback-submit' ).on( 'click', function() {

		if ( ! $( '[name="reason_key"]' ).is( ':checked' ) ) {
			alert( 'Please select a reason' );
			return;
		}
		$( ".wcgwp-button" ).addClass( "disabled" );
		$( "#wcgwp-feedback-dialog-form .spinner" ).show().css( "visibility", "visible" );
		let formData = $( "#wcgwp-feedback-dialog-form" ).serialize();
		console.log( formData );
		$( this ).addClass( 'loading' );
		$.post( ajaxurl, formData, function( response ) {
			// console.log( response );
			$( "#deactivate-woocommerce-gift-wrapper" ).addClass( "deactiviate" );
			$( "#TB_closeWindowButton" ).trigger( "click" );
		});

	});

});