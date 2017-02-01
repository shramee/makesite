<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Multiple checkbox customize control class.
 *
 * @since  1.0.0
 * @access public
 */
class Makesite_Customizer_CSS_Control extends WP_Customize_Control {

	/**
	 * Value for the field
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $value;

	/**
	 * Default value for this field
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $default = '';

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'heading';

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	protected $multi_values = array();

	/**
	 * Displays the control content.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function render_content() {

		$method = 'render_' . ms_make_id( $this->type, '_' ) . '_content';

		if ( ! method_exists( $this, $method ) ) {
			return;
		}

		echo "<span class='customize-control-title customize-control-{$this->type}-title'>{$this->label}</span>";

		if ( ! empty( $this->description ) ) {
			echo "<span class='description customize-control-description'>$this->description</span>";
		}

		$this->value        = $this->value() ? $this->value() : $this->default;
		$this->multi_values = is_array( $this->value ) ? $this->value : explode( '|', $this->value );

		$this->$method();
	}


	/**
	 * Renders the content for slider field type
	 * @since 1.0.0
	 */
	protected function render_slider_content() {
		$this->input_attrs = wp_parse_args( $this->input_attrs, array(
			'step' => 1,
			'min' => 0,
			'max' => 160,
		) );

		$this->output_main_control( 'range', ms_stringify_prop_val( $this->input_attrs ) . ' class="ms-width-75 ms-slider"' );
		$number_attr = "class='ms-width-25 alignright ms-slider-val'";

		if ( 'designer' != ms_user() ) {
			$number_attr .= " disabled='disabled'";
		}

		$this->output_main_control( 'number', $number_attr );
	}

	/**
	 * Renders the content for shadow field type
	 * @since 1.0.0
	 */
	protected function render_shadow_content() {
		$this->multi_values = 6 == count( $this->multi_values ) ? $this->multi_values : array( 0, 0, 0, 0, 0, '', );
		$key_index = 0;
		?>
		<div class="ms-subcontrol">
			<?php
			$this->output_input( 'inset', 'checkbox', "value='ms-val' " .
			                                          checked( 'inset', $this->multi_values[ $key_index ++ ], false ) ); ?>
			Inset
		</div><!-- .ms-subcontrol -->
		<?php

		$this->output_shadow_controls( 'box-shadow', $key_index );
	}

	/**
	 * Renders the content for text_shadow field type
	 * @since 1.0.0
	 */
	protected function render_text_shadow_content() {
		$this->multi_values = 4 == count( $this->multi_values ) ? $this->multi_values : array( 0, 0, 0, '', );
		$this->output_shadow_controls();
	}

	/**
	 * Renders the content for border field type
	 * @since 1.0.0
	 */
	protected function render_all_border_content() {
		$values = 4 == count( $this->multi_values ) ? $this->multi_values : array( '', '0', 'solid', '', );
		$sides = array(
			''                       => 'All',
			'-top'                   => 'Top',
			'-bottom'                => 'Bottom',
			'-right'                 => 'Right',
			'-left'                  => 'Left',
			'-top::-bottom'          => 'Top/Bottom',
			'-right::-left'          => 'Right/Left',
			'-right::-left::-bottom' => 'Right/Left/Bottom',
			'-right::-left::-top'    => 'Right/Left/Top',
		);
		$this->render_select_subcontrol( 'Border Sides:', $sides, $values[0], "class='ms-val ms-val-outset'" );

		$this->render_border_control( $values, 1 );
		$this->output_main_control();
	}

	/**
	 * Renders the content for border field type
	 * @since 1.0.0
	 */
	protected function render_border_content() {
		$values = 3 == count( $this->multi_values ) ? $this->multi_values : array( '0', '', '', );
		$this->render_border_control( $values );
		$this->output_main_control();
	}

	/**
	 * Renders the content for border field type
	 *
	 * @param array $values The values for the control
	 * @param int $key_offset The prefix for the key
	 *
	 * @since 1.0.0
	 */
	protected function render_border_control( $values, $key_offset = 0 ) {
		$styles = array(
			''       => 'No border',
			'solid'  => 'Solid',
			'double' => 'Double',
			'groove' => 'Groove',
			'inset'  => 'Inset',
			'outset' => 'Outset',
		);

		//Thickness
		$this->render_input_subcontrol( 'Thickness:', $values[ $key_offset + 0 ], 'range', "min='0' max='25' step='1' class='ms-val ms-val-down'" );
		//Border style
		$this->render_select_subcontrol( 'Border style:', $styles, $values[ $key_offset + 1 ], "class='ms-val ms-val-outset'" );
		//Border Color
		$this->render_input_subcontrol( 'Border Color:', $values[ $key_offset + 2 ], 'text', "class='ms-val ms-val-color ms-color'" );
	}

	/**
	 * Renders the content for font field type
	 * @since 1.0.0
	 */
	protected function render_font_content() {
		$vals = 8 == count( $this->multi_values ) ? $this->multi_values : array( '', '', '', '', '', '', '', 0, );
		$fonts  = array( '' => 'Default', );
		$fonts  = array_merge( $fonts, ms_get_fonts() );
		$hidden = "style='display:none;'";

		//Font style
		$this->render_font_style_content( $vals, $hidden );
		//Font display
		$this->render_font_display_content( $vals, $hidden );
		//Font size
		$this->render_input_subcontrol( 'Font size:', $vals[4], 'number', "min='5' max='160' step='1' class='ms-val ms-val-right'" );
		//Font family
		$this->render_select_subcontrol( 'Font family:', $fonts, $vals[5], "class='ms-val ms-google-fonts ms-font-family'" );
		//Color
		$this->render_input_subcontrol( 'Color:', $vals[6], 'text', "class='ms-val ms-val-color ms-color'" );
		//Letter spacing
		$this->render_input_subcontrol( 'Letter spacing (em):', $vals[7], 'range', "min='0' max='1.6' step='0.05' class='ms-val ms-val-lspacing'" );

		$this->output_main_control();
	}

	/**
	 * Renders font style control
	 * @param array $vals Values
	 * @param string $hidden Hidden style string
	 */
	protected function render_font_style_content( $vals, $hidden ) {
		?>
		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Font style:</span>

			<div class="button-control">
				<label>
					<?php $this->output_input( 'italic', 'checkbox', checked( 'italic', $vals[0], false ) . $hidden ) ?>
					<div class="button"><i>Italic</i></div>
				</label>
				<label>
					<?php $this->output_input( '700', 'checkbox', checked( '700', $vals[1], false ) . $hidden ) ?>
					<div class="button"><b>Bold</b></div>
				</label>
				<label>
					<?php $this->output_input( 'underline', 'checkbox', checked( 'underline', $vals[2], false ) . $hidden ) ?>
					<div class="button"><span style="text-decoration: underline">Underline</span></div>
				</label>
			</div>
		</div><!-- .ms-subcontrol -->
		<?php
	}

	/**
	 * Renders font display control
	 * @param array $vals Values
	 * @param string $hidden Hidden style string
	 */
	protected function render_font_display_content( $vals, $hidden ) {
		?>
		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Font Display:</span>

			<div class="button-control">
				<label>
					<?php $this->output_input( '', 'radio', checked( '', $vals[3], false ) . $hidden . ' name="_radio-control-' . $this->id . '"' ); ?>
					<div class="button">Normal</div>
				</label>
				<label>
					<?php $this->output_input( 'small-caps', 'radio', checked( 'small-caps', $vals[3], false ) . $hidden . ' name="_radio-control-' . $this->id . '"' ); ?>
					<div class="button"><span style="font-variant: small-caps">Small Caps</span></div>
				</label>
				<label>
					<?php $this->output_input( 'normal', 'radio', checked( 'normal', $vals[3], false ) . $hidden . ' name="_radio-control-' . $this->id . '"' ); ?>
					<div class="button"><span style="text-transform: uppercase">All Caps</span></div>
				</label>
			</div>
		</div><!-- .ms-subcontrol -->
		<?php
	}

	/**
	 * Renders the content for spacing field type
	 * @since 1.0.0
	 */
	protected function render_spacing_content() {
		$this->multi_values = 2 == count( $this->multi_values ) ? $this->multi_values : array( 0, 0, );
		$attrs = "min='0' max='160' step='1' class='ms-val";

		//Top/Bottom
		$this->render_input_subcontrol( 'Top/Bottom:', $this->multi_values[0], 'range', "$attrs ms-val-up'" );
		//Right/left
		$this->render_input_subcontrol( 'Right/left:', $this->multi_values[1], 'range', "$attrs ms-val-right'" );

		$this->output_main_control();
	}

	/**
	 * Renders the content for shadow field type
	 * @param string $box_shadow
	 * @param int $key_index
	 * @since 1.0.0
	 */
	protected function output_shadow_controls( $box_shadow = '', $key_index = 0 ) {

		//Left/Right offset
		$this->render_input_subcontrol( 'Left/Right:', $this->multi_values[ $key_index ++ ], 'range', "min='-25' max='25' class='ms-val ms-val-down'" );
		//Up/Down offset
		$this->render_input_subcontrol( 'Up/Down:', $this->multi_values[ $key_index ++ ], 'range', "min='-25' max='25' class='ms-val ms-val-right'" );
		//Blur
		$this->render_input_subcontrol( 'Blur:', $this->multi_values[ $key_index ++ ], 'range', "max='25' class='ms-val ms-val-blur'" );

		if ( 'box-shadow' == $box_shadow ) {
			//Output box shadow spread
			$this->render_input_subcontrol( 'Spread:', $this->multi_values[ $key_index ++ ], 'range', "max='25' class='ms-val ms-val-spread'" );
		}
		//Color
		$this->render_input_subcontrol( 'Color:', $this->multi_values[ $key_index ++ ], 'text', "class='ms-val ms-val-color ms-color'" );

		$this->output_main_control();
	}

	/**
	 * Outputs sub control with input
	 * @param array $options Options to output
	 * @param string $val_now Current value of the field
	 * @param string $attrs Additional attributes
	 */
	protected function render_input_subcontrol( $title, $val_now, $type = 'hidden', $attrs = '' ) {
		$this->render_subcontrol( $title, $this->get_input( $val_now, $type, $attrs ) );
	}

	/**
	 * Outputs sub control with select
	 * @param array $options Options to output
	 * @param string $val_now Current value of the field
	 * @param string $attrs Additional attributes
	 */
	protected function render_select_subcontrol( $title, $options, $val_now, $attrs = "" ) {
		$this->render_subcontrol( $title, $this->get_select( $options, $val_now, $attrs ) );
	}

	/**
	 * Outputs sub control with given field html
	 * @param array $options Options to output
	 * @param string $val_now Current value of the field
	 * @param string $attrs Additional attributes
	 */
	protected function render_subcontrol( $title, $field_html ) {
		?>
		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title"><?php echo $title ?></span>
			<?php echo $field_html ?>
		</div><!-- .ms-subcontrol -->
		<?php
	}

	/**
	 * Outputs select control
	 * @param array $options Options to output
	 * @param string $val_now Current value of the field
	 * @param string $attrs Additional attributes
	 */
	protected function output_select( $options, $val_now, $attrs = "" ) {
		echo $this->get_select( $options, $val_now, $attrs );
	}

	/**
	 * Prepares the select control
	 * @param array $options Options to output
	 * @param string $val_now Current value of the field
	 * @param string $attrs Additional attributes
	 * @return string HTML for select element
	 */
	protected function get_select( $options, $val_now, $attrs = "" ) {
		$return = "<select $attrs>";
		foreach ( $options as $value => $label ) {
			$return .= '<option value="' . esc_attr( $value ) . '"' . selected( $val_now, $value, false ) . '>' . $label . '</option>';
		}
		$return .= '</select>';

		return $return;
	}

	/**
	 * Outputs linked input of the desired type
	 * @param string $type Type of input
	 * @param string $attrs Input attributes
	 * @param bool $echo Whether or not to echo the input, default true
	 * @return void|string Input if $echo is false
	 * @since 1.0.0
	 */
	protected function output_main_control( $type = 'hidden', $attrs = "class='val-store'", $echo = true ) {
		$val_now = $this->value;
		$link    = $this->get_link();
		if ( $echo ) {
			$this->output_input( $val_now, $type, "{$attrs} {$link}" );
		} else {
			return $this->get_input( $val_now, $type, "{$attrs} {$link}" );
		}
	}

	/**
	 * Outputs input of the desired type
	 *
	 * @param string $val_now Current value of the field
	 * @param string $type Type og the field
	 * @param string $attrs Additional attributes
	 *
	 * @since 1.0.0
	 */
	protected function output_input( $val_now, $type = 'hidden', $attrs = '' ) {
		echo $this->get_input( $val_now, $type, $attrs );
	}

	/**
	 * Outputs input of the desired type
	 *
	 * @param string $val_now Current value of the field
	 * @param string $type Type og the field
	 * @param string $attrs Additional attributes
	 *
	 * @since 1.0.0
	 */
	protected function get_input( $val_now, $type = 'hidden', $attrs = '' ) {
		return "<input type='{$type}' value='{$val_now}' {$attrs}/>";
	}
}