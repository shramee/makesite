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

		if ( 'heading' == $this->type ) {
			echo '<br><hr>';
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
	 * Renders the content for heading field type
	 * @since 1.0.0
	 */
	protected function render_heading_content() {
		echo '<hr>';
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
		$this->output_shadow_controls( 'box-shadow' );
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
		$this->multi_values = 4 == count( $this->multi_values ) ? $this->multi_values : array( '', '0', 'solid', '', );
		?>
		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Border Sides:</span>
			<?php $this->output_select( array(
				''                       => 'All',
				'-top'                   => 'Top',
				'-bottom'                => 'Bottom',
				'-right'                 => 'Right',
				'-left'                  => 'Left',
				'-top::-bottom'          => 'Top/Bottom',
				'-right::-left'          => 'Right/Left',
				'-right::-left::-bottom' => 'Right/Left/Bottom',
				'-right::-left::-top'    => 'Right/Left/Top',
			), $this->multi_values[0], "class='ms-val ms-val-outset'" ); ?>
		</div><!-- .ms-subcontrol -->
		<?php
		$this->render_border_control( $this->multi_values, 1 );
		$this->output_main_control();
	}

	/**
	 * Renders the content for border field type
	 * @since 1.0.0
	 */
	protected function render_border_content() {
		$this->multi_values = 3 == count( $this->multi_values ) ? $this->multi_values : array( '0', '', '', );
		$this->render_border_control( $this->multi_values );
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
		?>
		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Thickness:</span>
			<?php
			$this->output_input( $values[ $key_offset + 0 ], 'range', "min='0' max='25' step='1' class='ms-val ms-val-down'" );
			?>
		</div><!-- .ms-subcontrol -->

		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Border style:</span>
			<?php $this->output_select( array(
				''       => 'No border',
				'solid'  => 'Solid',
				'double' => 'Double',
				'groove' => 'Groove',
				'inset'  => 'Inset',
				'outset' => 'Outset',
			), $values[ $key_offset + 1 ], "class='ms-val ms-val-outset'" ); ?>
		</div><!-- .ms-subcontrol -->

		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Border Color:</span>
			<?php $this->output_input( $values[ $key_offset + 2 ], 'text', "class='ms-val ms-val-color ms-color'" ); ?>
		</div><!-- .ms-subcontrol -->
		<?php
	}

	/**
	 * Renders the content for font field type
	 * @since 1.0.0
	 */
	protected function render_font_content() {
		$values = 7 == count( $this->multi_values ) ? $this->multi_values : array( '', '', '', '', '', '', '', );
		$fonts  = array( '' => 'Default', );
		$fonts  = array_merge( $fonts, ms_get_fonts() );
		$hidden = "style='display:none;'";
		?>

		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Font style:</span>

			<div class="button-control">
				<label>
					<?php
					$this->output_input( 'italic', 'checkbox', checked( 'italic', $values[0], false ) . $hidden )
					?>
					<div class="button"><i>Italic</i></div>
				</label>
				<label>
					<?php
					$this->output_input( '700', 'checkbox', checked( '700', $values[1], false ) . $hidden )
					?>
					<div class="button"><b>Bold</b></div>
				</label>
				<label>
					<?php
					$this->output_input( 'underline', 'checkbox', checked( 'underline', $values[2], false ) . $hidden )
					?>
					<div class="button"><span style="text-decoration: underline">Underline</span></div>
				</label>
			</div>
		</div><!-- .ms-subcontrol -->

		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Font Display:</span>

			<div class="button-control">
				<label>
					<?php
					$this->output_input(
						'',
						'radio',
						checked( '', $values[3], false ) . $hidden . ' name="_radio-control-' . $this->id . '"'
					);
					?>
					<div class="button">Normal</div>
				</label>
				<label>
					<?php
					$this->output_input(
						'small-caps',
						'radio',
						checked( 'small-caps', $values[3], false ) . $hidden . ' name="_radio-control-' . $this->id . '"'
					);
					?>
					<div class="button"><span style="font-variant: small-caps">Small Caps</span></div>
				</label>
				<label>
					<?php
					$this->output_input(
						'normal',
						'radio',
						checked( 'normal', $values[3], false ) . $hidden . ' name="_radio-control-' . $this->id . '"'
					);
					?>
					<div class="button"><span style="text-transform: uppercase">  All Caps</span></div>
				</label>
			</div>
		</div><!-- .ms-subcontrol -->

		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Font size:</span>
			<?php $this->output_input( $values[4], 'number', "min='0' max='160' step='1' class='ms-val ms-val-right'" ); ?>
		</div><!-- .ms-subcontrol -->

		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Font family:</span>
			<?php $this->output_select( $fonts, $values[5], "class='ms-val ms-google-fonts ms-font-family'" ); ?>
		</div><!-- .ms-subcontrol -->

		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Color:</span>
			<?php $this->output_input( $values[6], 'text', "class='ms-val ms-val-color ms-color'" ); ?>
		</div><!-- .ms-subcontrol -->

		<?php
		$this->output_main_control();
	}

	/**
	 * Renders the content for spacing field type
	 * @since 1.0.0
	 */
	protected function render_spacing_content() {
		$this->multi_values = 2 == count( $this->multi_values ) ? $this->multi_values : array( 0, 0, );
		?>

		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Top/Bottom:</span>
			<?php $this->output_input( $this->multi_values[0], 'range', "min='0' max='160' step='1' class='ms-val ms-val-up'" ); ?>
		</div><!-- .ms-subcontrol -->

		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Right/left:</span>
			<?php $this->output_input( $this->multi_values[1], 'range', "min='0' max='160' step='1' class='ms-val ms-val-right'" ); ?>
		</div><!-- .ms-subcontrol -->

		<?php
		$this->output_main_control();
	}

	/**
	 * Renders the content for shadow field type
	 *
	 * @param string $box_shadow
	 *
	 * @since 1.0.0
	 */
	protected function output_shadow_controls( $box_shadow = '' ) {

		$key_index = 0;

		if ( 'box-shadow' == $box_shadow ) {
			//If not font shadow output spread
			?>
			<div class="ms-subcontrol">
				<?php
				$this->output_input( 'inset', 'checkbox', "value='ms-val' " .
				                                          checked( 'inset', $this->multi_values[ $key_index ++ ], false ) ); ?>
				Inset
			</div><!-- .ms-subcontrol -->
			<?php
		}
		?>

		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Right:</span>
			<?php $this->output_input( $this->multi_values[ $key_index ++ ], 'range', "max='25' class='ms-val ms-val-down'" ); ?>
		</div><!-- .ms-subcontrol -->

		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Down:</span>
			<?php $this->output_input( $this->multi_values[ $key_index ++ ], 'range', "max='25' class='ms-val ms-val-right'" ); ?>
		</div><!-- .ms-subcontrol -->

		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Blur:</span>
			<?php $this->output_input( $this->multi_values[ $key_index ++ ], 'range', "max='25' class='ms-val ms-val-blur'" ); ?>
		</div><!-- .ms-subcontrol -->

		<?php
		if ( 'box-shadow' == $box_shadow ) {
			//Output box shadow spread
			?>

			<div class="ms-subcontrol">
				<span class="ms-subcontrol-title">Spread:</span>
				<?php $this->output_input( $this->multi_values[ $key_index ++ ], 'range', "class='ms-val ms-val-spread'" ); ?>
			</div><!-- .ms-subcontrol -->

		<?php } ?>

		<div class="ms-subcontrol">
			<span class="ms-subcontrol-title">Color:</span>
			<?php $this->output_input( $this->multi_values[ $key_index ++ ], 'text', "class='ms-val ms-val-color ms-color'" ); ?>
		</div><!-- .ms-subcontrol -->
		<?php
		$this->output_main_control();
	}

	/**
	 * Outputs select control
	 *
	 * @param array $options Options to output
	 * @param string $val_now Current value of the field
	 * @param string $attrs Additional attributes
	 */
	protected function output_select( $options, $val_now, $attrs = "" ) {
		echo "<select $attrs>";
		foreach ( $options as $value => $label ) {
			echo '<option value="' . esc_attr( $value ) . '"' . selected( $val_now, $value, false ) . '>' . $label . '</option>';
		}
		echo '</select>';
	}

	/**
	 * Outputs linked input of the desired type
	 *
	 * @param string $type Type of input
	 * @param string $attrs
	 *
	 * @since 1.0.0
	 */
	protected function output_main_control( $type = 'hidden', $attrs = "class='val-store'" ) {
		$val_now = $this->value;
		$link    = $this->get_link();
		$this->output_input( $val_now, $type, "{$attrs} {$link}" );
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
		echo "<input type='{$type}' value='{$val_now}' {$attrs}/>";
	}
}