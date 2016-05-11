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
class WPD_Customize_Control extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'multi-select';

	/**
	 * Render the multi select control
	 * @param string $attr
	 * @since  1.0.0
	 * @access public
	 */
	public function render_select( $attr = '' ) {
		//Customizer field link
		$link = $this->get_link();
		//Open select
		echo "<select $attr $link>";
		$multi_values = ! is_array( $this->value() ) ? explode( '|', $this->value() ) : $this->value();
		//Options to select from
		foreach ( $this->choices as $value => $label ) {
			$selected = selected( in_array( $value, $multi_values ), true, false );
			echo "<option value='{$value}' {$selected}>{$label}</option>";
		}
		//Close select
		echo '</select>';
	}

	/**
	 * Returns the format to render fields in
	 * @since  1.0.0
	 * @access public
	 * @return string sprintf format
	 */
	public function get_format() {
		$format = '%s';
		if ( false !== strpos( $this->type, 'img-' ) ) {
			$format = '<img src="%s">';
		} else {
			$format = '<div class="button">%s</div> ';
		}

		return $format;
	}

	/**
	 * Returns the input for radio and checkboxes
	 * @param string $value the value for this input
	 * @access public
	 * @return string HTML for the input
	 * @since  1.0.0
	 */
	public function get_input( $value ) {

		$attrs = "value='$value' ";
		if ( 'checkboxes' != $this->type ) {
			$attrs .= "style='display:none;' ";
		}
		if ( false !== strpos( $this->type, 'radio' ) ) {
			$attrs .=
				'type="radio" name="_customize-radio-' . $this->id . '" ' .
				$this->get_link() . checked( $value, $this->value(), false );
		} else {
			$multi_values = ! is_array( $this->value() ) ? explode( '|', $this->value() ) : $this->value();
			$attrs .= 'type="checkbox" ' . checked( true, in_array( $value, $multi_values ), false );
		}
		return "<input $attrs>";
	}

	/**
	 * Displays the control content.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function render_content() {

		if ( 'on-off' != $this->type && empty( $this->choices ) && 'alpha-color' != $this->type ) { return; }

		if ( !empty( $this->label ) ) { ?>
			<span class="customize-control-title">
				<?php
				if ( 'on-off' == $this->type ) {
					?>
					<input class="on-off" type="hidden" <?php $this->link() ?> value="<?php
					echo $this->value() ? 'On' : '';
					?>">
					<div class="on-off button<?php
					echo 'On' == $this->value() ? 'button-primary' : '';
					?>" title="<?php
					echo 'On' == $this->value() ? 'Enabled' : 'Disabled';
					?>"><?php
						echo $this->value() ? 'On' : 'Off';
						?></div>
					<?php
				}
				echo esc_html( $this->label );
				?>
			</span>
			<?php
		}

		if ( !empty( $this->description ) ) {
			?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php
		}
		if ( 'on-off' == $this->type ) { return; }
		?>
		<div class="<?php echo 'wpd-custom-control button-control wpd-' . $this->type; ?>">
			<?php
			switch( $this->type ) {
				case 'checkboxes':
				case 'img-checkboxes':
				case 'button-checkboxes':
				$this->render_select( 'style="display:none" multiple="multiple"' );
				case 'img-radio':
				case 'button-radio':
					$format = $this->get_format();
					foreach ( $this->choices as $value => $label ) {
						echo '<label>' . $this->get_input( $value ) . sprintf( $format, $label ) . '</label>';
					}
					break;
				case 'multi-select':
					$this->render_select( 'multiple="multiple"' );
					break;
				case 'alpha-color':
				?>
					<input class='color-picker-hex' data-alpha='true' type='text' value='<?php echo esc_attr( $this->value() ); ?>' <?php $this->link(); ?> />
				<?php
			}
			?>
		</div>
		<?php
	}
}