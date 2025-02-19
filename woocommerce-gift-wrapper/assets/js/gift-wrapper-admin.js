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

});