<?php
/**
 * Created by PhpStorm.
 * User: shramee
 * Date: 22/08/16
 * Time: 2:19 PM
 */

class Makesite_Design_Fields_Css {

	/** @var array Google fonts to load */
	protected $gf_load  = array();

	/** @var array Google fonts */
	protected $gf_data;

	protected function field_css( $setting, $format, $f ) {
		$style = '';
		if ( is_array( $format )  ) {
			if ( ! empty( $format[ $setting ] ) ) {
				$style = $format[ $setting ];
			}
		} else {
			$method = ms_make_id( $f['type'], '_' ) . '_field_css';
			if ( method_exists( $this, $method ) ) {
				$style = $this->$method( explode( '|', $setting ) ); // Get style from callback
				if ( $style ) {
					$style = sprintf( $format, $style );
				}
			} else {
				$style = sprintf( $format, $setting );
			}
		}

		return $style;
	}

	/**
	 * Returns the styles from type of control
	 * @param array $vals Current settings
	 * @return string $css
	 */
	protected function font_field_css( $vals ) {
		$value = '';
		$vals[1] = empty( $vals[1] ) ? 400 : $vals[1];
		$this->gf_load[ $vals[5] ][] = $vals[1];
		//Set property value
		if ( strpos( $vals[5], ' Light' ) ) {
			$vals[5] = "'$vals[5]', '" . str_replace( ' Light', '', $vals[5] ) . "'";
			$vals[1] -= 200;
		}

		$value .= empty( $vals[0] ) ? '' : "font-style:$vals[0];";
		$value .= "font-weight:$vals[1];";
		$value .= empty( $vals[2] ) ? '' : "text-decoration:$vals[2];";
		if ( empty( $vals[3] ) ) {
			$value .= 'font-variant:normal;';
		} else {
			if ( 'normal' == $vals[3] ) {
				$value .= 'text-transform:uppercase;';
			} else {
				$value .= "font-variant:small-caps;";
			}
		}
		$value .= empty( $vals[4] ) ? '' : "font-size:$vals[4]px;";
		$value .= empty( $vals[5] ) ? '' : "font-family:$vals[5];";
		$value .= empty( $vals[6] ) ? '' : "color:$vals[6];";

		//Return styles data
		return $value;
	}

	/**
	 * Returns the styles from type of control
	 * @param array $vals Current settings
	 * @return string $css
	 */
	protected function border_field_css( $vals ) {
		if ( ! empty( $vals[1] ) ) {
			//Set property value
			$value = "{$vals[0]}px {$vals[1]} {$vals[2]}";
			//Return styles data
			return $value;
		}

		return '';
	}

	/**
	 * Returns the styles from type of control
	 * @param array $vals Current settings
	 * @return string $css
	 */
	protected function all_border_field_css( $vals ) {
		if ( ! empty( $vals[1] ) ) {
			$sides = explode( '::', $vals[0] );
			$style = '';
			foreach ( $sides as $side ) {
				$style .= "border{$side}-width: {$vals[1]}px;";
				$style .= "border{$side}-style: {$vals[2]};";
				$style .= "border{$side}-color: {$vals[3]};";
			}
			//Return styles data
			return $style;
		}

		return '';
	}

	/**
	 * Returns the styles from type of control
	 * @param array $vals Current settings
	 * @return string $css
	 */
	protected function spacing_field_css( $vals ) {
		if ( isset( $vals[1] ) ) {
			return implode( 'px ', $vals ) . 'px';
		}

		return '';
	}

	/**
	 * Returns the styles from type of control
	 * @param array $vals Current settings
	 * @return string $css
	 */
	protected function shadow_field_css( $vals ) {
		if ( ! empty( $vals[5] ) ) {
			$value = '';
			foreach ( $vals as $val ) {
				if ( is_numeric( $val ) ) {
					$value .= $val . 'px ';
				} else {
					$value .= $val . ' ';
				}
			}
			return "box-shadow:$value;";
		}

		return '';
	}

	/**
	 * Returns the styles from type of control
	 * @param array $vals Current settings
	 * @return string $css
	 */
	protected function text_shadow_field_css( $vals ) {
		if ( ! empty( $vals[3] ) ) {
			$value = '';
			foreach ( $vals as $val ) {
				if ( is_numeric( $val ) ) {
					$value .= $val . 'px ';
				} else {
					$value .= $val . ' ';
				}
			}
			return "text-shadow:$value;";
		}

		return '';
	}
}