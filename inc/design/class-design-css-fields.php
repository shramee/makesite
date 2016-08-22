<?php
/**
 * Created by PhpStorm.
 * User: shramee
 * Date: 22/08/16
 * Time: 2:19 PM
 */

class Makesite_Design_Css_Fields {

	protected function get_style( $format, $setting, $f ) {
		$method = 'css_' . ms_make_id( $f['type'], '_' );
		if ( method_exists( $this, $method ) ) {
			$vals = explode( '|', $setting ); //Setting multi values from string

			return sprintf( $format, $this->$method( $vals ) ); // Getting style from callback
		} else {
			return sprintf( $format, $setting );
		}
	}

	/**
	 * Returns the styles from type of control
	 * @param array $vals Current settings
	 * @return string $css
	 */
	protected function css_font( $vals ) {
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
	protected function css_border( $vals ) {
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
	protected function css_all_border( $vals ) {
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
	protected function css_spacing( $vals ) {
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
	protected function css_shadow( $vals ) {
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
	protected function css_text_shadow( $vals ) {
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