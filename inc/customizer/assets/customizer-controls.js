/**
 * Created by shramee on 19/10/15.
 */
( function ( $, api ) {
	api.makesite_multi_checkbox = api.Control.extend( {
		ready : function () {
			var $control = this.container.find('.wpd-custom-control'),
				$inputs = $control.find( 'input[type="checkbox"]' );
			$inputs.change( function () {
				var values = $control.find( 'input[type="checkbox"]:checked' ).not('.hidden').map( function () {
						return this.value;
				} ).get();

				$control.find( 'select' ).val( values ).change();

			} );
		}
	} );

	api.makesite_on_off = api.Control.extend( {
		ready : function () {
			var $t	= this.container,
				$b	= $t.find( '.button' );
			$b.click( function ( e ) {
				e.preventDefault();
				var $$ = $( this );

				if ( $$.hasClass( 'button-primary' ) ) {
					$$.siblings( 'input' )
						.val( '' )
						.change();
					$$
						.html( 'Off' )
						.attr( 'title', 'Disabled' );
				} else {
					$$.siblings( 'input' )
						.val( 'On' );
					$$
						.html( 'On' )
						.attr( 'title', 'Enabled' );
				}
				$$.siblings( 'input' ).change();
				$$.toggleClass( 'button-primary' );
			} );
		}
	} );

	api.controlConstructor['checkboxes'] = api.makesite_multi_checkbox;
	api.controlConstructor['img-checkboxes'] = api.makesite_multi_checkbox;
	api.controlConstructor['button-checkboxes'] = api.makesite_multi_checkbox;
	api.controlConstructor['on-off'] = api.makesite_on_off;

	api.makesite_alpha_color_control = api.Control.extend({
		ready: function() {
			var control = this,
				picker = this.container.find('.color-picker-hex');

			picker.val( control.setting() ).makesiteColorPicker({
				change: function() {
					control.setting.set( picker.makesiteColorPicker('color') );
				},
				clear: function() {
					control.setting.set( false );
				}
			});

			control.setting.bind( function( value ) {
				picker.val( value );
				picker.makesiteColorPicker( 'color', value );
			});
		}
	});

	api.controlConstructor['alpha-color'] = api.makesite_alpha_color_control;

	/* CSS complex controls */
	api.makesiteSaveVals = function ( e ) {
		var $p = e.data.p,
			save_vals = $p.find( 'input, select, textarea' ).not( '.val-store, [type="button"]' ).map(
				function () {
					var $t = $( this ),
						chkbx = $t.is(':checkbox');
					if (  $t.is(':radio') ) {
						if ( $t.is(':checked') ) {
							return this.value;
						}
					} else if ( ! chkbx || ( chkbx && $t.is(':checked') ) ) {
						return this.value;
					} else {
						return '';
					}
				}
			).get().join( '|' );
		$p.find( 'input.val-store' ).val( save_vals ).change();
	};

	api.makesiteFields = api.Control.extend( {
		ready : function () {
			var $p = this.container;
			$p.find( '.makesite-color' ).makesiteColorPicker( {
				change : function ( e, ui ) {
					//$( this ).val( ui.color.toString() );
					setTimeout( function () {
						api.makesiteSaveVals( { data : { p : $p } } );
					}, 250 );
				},
				clear : function ( e, ui ) {
					//$( this ).val( ui.color.toString() );
					setTimeout( function () {
						api.makesiteSaveVals( { data : { p : $p } } );
					}, 250 );
				}
			} );
			$p.find( '.makesite-google-fonts' ).makesiteGoogleFonts();
			var $inputs = $p.find( 'input, select, textarea' ).not( '.val-store, [type="button"], .wp-color-picker' );
			$inputs.change( { p : $p }, api.makesiteSaveVals );
		}
	} );
	api.controlConstructor['slider'] = api.makesiteFields;
	api.controlConstructor['shadow'] = api.makesiteFields;
	api.controlConstructor['border'] = api.makesiteFields;
	api.controlConstructor['all-border'] = api.makesiteFields;
	api.controlConstructor['font'] = api.makesiteFields;
	api.controlConstructor['text_shadow'] = api.makesiteFields;
	api.controlConstructor['spacing'] = api.makesiteFields;

} ) ( jQuery, wp.customize );
