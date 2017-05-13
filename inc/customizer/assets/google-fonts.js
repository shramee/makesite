/**
 * Created by shramee on 16/11/15.
 */
( function ( $ ) {
	$.fn.makesiteGoogleFonts = function () {
		var $t = $( this ),
			$div = $( '<div />' ).addClass( 'makesite-google-fonts' );

		if ( $t.siblings( '.makesite-google-fonts' ).length ) {
			return;
		}

		$t.find( 'option' ).each( function () {
			var $$ = $( this ),
				Font = $$.attr( 'value' ) || 'Default',
				font = Font.replace( / /g, '-' ).toLowerCase(),
				classes = 'makesite-gf-' + font;
			if ( $$.prop( 'selected' ) ) {
				classes += ' active'
			}
			$div.append( $( '<span/>' ).data( 'font', Font ).addClass( classes ).text( Font ) );
		} );
		$t.after( $( '<div />' ).addClass( 'makesite-google-fonts-wrap' ).append( $div ) );
		$t.hide();
		$div = $t.siblings( '.makesite-google-fonts-wrap' ).children( '.makesite-google-fonts' );
		$div.show();
		$div.find( 'span' ).click( function () {
			var $$ = $( this );
			$$.siblings().removeClass( 'active' );
			$$.addClass( 'active' );
			$t.val( $$.data( 'font' ) ).change();
		} );

		var $active_field = $t.siblings( 'div.makesite-google-fonts' ).find( '.active' );

		if ( 1 == $active_field.count ) {
			$t.siblings( 'div.makesite-google-fonts' ).scrollTop( $active_field.offsetTop )
		}
	};
	$( '.makesite-google-fonts' ).makesiteGoogleFonts();
} )( jQuery );