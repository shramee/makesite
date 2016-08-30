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
	$( "body" ).delegate( "[data-toggle-class], [data-toggle-target]", "click", function() {
		var $t = $( this ),
			target = $t.data( 'toggle-target' ), // Selector for target
			$target = target ? $t.closest( target ) : $t.parent(), // jQuery object for target
			htmlClass = $t.data( 'toggle-class' );
		htmlClass = htmlClass ? htmlClass : 'toggled';
		$target.toggleClass( htmlClass );
	} );
} )( jQuery );

