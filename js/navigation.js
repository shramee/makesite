/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function( $ ) {
	$( '.menu-toggle' ).click( function () {
		$( this ).parent().toggleClass( 'menu-toggled' );
	} );
} )( jQuery );
