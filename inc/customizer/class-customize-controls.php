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
class MS_Customize_Control extends WP_Customize_Control {

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
	 *
	 * @param string $attr
	 *
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
		} else if ( false !== strpos( $this->type, 'button' ) ) {
			$format = '<div class="button">%s</div> ';
		} else {
			$format = '%s ';
		}

		return $format;
	}

	/**
	 * Returns the input for radio and checkboxes
	 *
	 * @param string $value the value for this input
	 *
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
	 * Displays the control title.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	private function render_title() {
		if ( ! empty( $this->label ) ) {
			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php
		}
	}

	/**
	 * Displays the control description.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	private function render_desc() {
		if ( ! empty( $this->description ) ) {
			?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php
		}
	}

	/**
	 * Displays the control content.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function render_content() {

		if ( 'on-off' == $this->type ) {
			$this->render_on_off();
		} else {
			$this->render_title();
			$this->render_desc();
			?>
			<div class="<?php echo 'wpd-custom-control button-control wpd-' . $this->type; ?>">
				<?php $this->render_control() ?>
			</div>
			<?php
		}
	}


	/**
	 * Displays on off control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function render_on_off() {
		$value = $class = '';
		$title = 'Disabled';
		$label = 'Off';
		if ( 'On' == $this->value() ) {
			$value = 'On';
			$class = 'button-primary';
			$title = 'Enabled';
			$label = 'On';
		}
		?>
		<span class="customize-control-title">
			<input class="on-off" type="hidden" <?php $this->link() ?> value="<?php echo $value ?>">
			<div class="on-off button <?php echo $class ?>" title="<?php echo $title ?>">
				<?php echo $label ?>
			</div>
			<?php echo esc_html( $this->label ); ?>
		</span>
		<?php
		$this->render_desc();
	}

	/**
	 * Displays control field.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function render_control() {

		if ( 'alpha-color' === $this->type ) {
			?>
			<input class='color-picker-hex' data-alpha='true' type='text'
			       value='<?php echo esc_attr( $this->value() ); ?>' <?php $this->link(); ?> />
			<?php
		} elseif ( ! empty( $this->choices ) ) {
			$this->render_multi_choice_control();
		}
	}

	/**
	 * Displays control field with multiple choices.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function render_multi_choice_control() {
		if ( 'multi-select' === $this->type ) {
			$this->render_select( 'multiple="multiple"' );
			return;
		}
		if ( false !== strpos( $this->type, 'checkboxes' ) ) {
			$this->render_select( 'style="display:none" multiple="multiple"' );
		}
		$format = $this->get_format();
		foreach ( $this->choices as $value => $label ) {
			echo '<label>' . $this->get_input( $value ) . sprintf( $format, $label ) . '</label>';
		}
	}
}