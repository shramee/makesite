<?php
/**
 * Created by PhpStorm.
 * User: shramee
 * Date: 22/08/16
 * Time: 2:19 PM
 */

class Makesite_Design_Css_Fields {

	protected function field_css( $format, $setting, $f ) {
		$style = '';
		if ( is_array( $format )  ) {
			if ( ! empty( $format[ $setting ] ) ) {
				$style = $format[ $setting ];
			}
		} else {
			$method = ms_make_id( $f['type'], '_' ) . '_field_css';
			if ( method_exists( $this, $method ) ) {
				$style = sprintf( $format, $this->$method( explode( '|', $setting ) ) ); // Getting style from callback
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
		//Split values to array
		if ( ! empty( $vals[4] ) ) {
			$this->gf_load[ $vals[4] ][] = $vals[2] ? $vals[2] : '400';
			//Set property value
			if ( strpos( $vals[4], ' Light' ) ) {
				$vals[4] = "'$vals[4]', '" . str_replace( ' Light', '', $vals[4] ) . "'";
				$vals[2] = '300';
			}
			$value = "font:{$vals[0]} {$vals[1]} {$vals[2]} {$vals[3]}px {$vals[4]}; color: {$vals[5]}";
			//Set font to load
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
	protected function border_field_css( $vals ) {
		//Split values to array
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
		//Split values to array
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
		//Split values to array
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
		//Split values to array
		if ( isset( $vals[1] ) ) {
			$value = '';
			foreach ( $vals as $val ) {
				if ( is_numeric( $val ) ) {
					$value .= $val . 'px ';
				} else {
					$value .= $val . ' ';
				}
			}
			return $value;
		}

		return '';
	}

	/**
	 * Returns the styles from type of control
	 * @param array $vals Current settings
	 * @return string $css
	 */
	protected function text_shadow_field_css( $vals ) {
		//Split values to array
		if ( isset( $vals[3] ) ) {
			$value = '';
			foreach ( $vals as $val ) {
				if ( is_numeric( $val ) ) {
					$value .= $val . 'px ';
				} else {
					$value .= $val . ' ';
				}
			}
			return $value;
		}

		return '';
	}
}