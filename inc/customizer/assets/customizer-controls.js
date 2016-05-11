/**
 * Created by shramee on 19/10/15.
 */
jQuery( function ( $ ) {
	var api = wp.customize;

	api.ms_multi_checkbox = api.Control.extend( {
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

	api.ms_on_off = api.Control.extend( {
		ready : function () {
			var $t	= this.container,
				$b	= $t.find( '.button' );
			$b.click( function ( e ) {
				e.preventDefault();
				var $$ = $( this );
				console.log( $$.hasClass( 'button-primary' ) );
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

	api.controlConstructor['checkboxes'] = api.ms_multi_checkbox;
	api.controlConstructor['img-checkboxes'] = api.ms_multi_checkbox;
	api.controlConstructor['button-checkboxes'] = api.ms_multi_checkbox;
	api.controlConstructor['on-off'] = api.ms_on_off;

	api.wpd_alpha_color_control = api.Control.extend({
		ready: function() {
			var control = this,
				picker = this.container.find('.color-picker-hex');

			picker.val( control.setting() ).wpdColorPicker({
				change: function() {
					control.setting.set( picker.wpdColorPicker('color') );
				},
				clear: function() {
					control.setting.set( false );
				}
			});

			control.setting.bind( function( value ) {
				picker.val( value );
				picker.wpdColorPicker( 'color', value );
			});
		}
	});

	api.controlConstructor['alpha-color'] = api.wpd_alpha_color_control;
} );
