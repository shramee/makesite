<?php

/**
 * Class Makesite_Design_Fields_Css
 * Generates css from design fields
 */
class Makesite_Design_Fields_Css {

	/** @var array Google fonts to load */
	protected $gf_load  = array();

	/** @var array Google fonts */
	protected $gf_data;

	/** @var array Styles data */
	protected $css = '';

	/** @var array Classes to add to body */
	protected $body_class = array();

	/** @var array Font value formats */
	protected $font_format = array(
		0 => 'font-style:%s;',
		1 => 'font-weight:%s;',
		2 => 'text-decoration:%s;',
		4 => 'font-size:%spx;',
		5 => 'font-family:%s;',
		6 => 'color:%s;',
		7 => 'letter-spacing:%sem;',
	);

	/** @var string Google fonts url */
	protected $gf_url = '';

	/**
	 * Generates CSS data from settings
	 * @action wp
	 * @uses Makesite_Design::$styles, Makesite_Design::$gf_load
	 * @since 1.0.0
	 */
	protected function process_setting( $id, $f ) {
		if ( empty( $f['default'] ) ) {
			$f['default'] = '';
		}

		//Getting setting in a var
		$setting = get_option( $id, $f['default'] );

		if ( $this->is_field_css( $setting, $f ) ) {
			return $this->field_css( $setting, $f['output'], $f );
		}

		return '';
	}

	protected function is_field_css( $setting, $f ) {

		if ( empty( $setting ) )
			return false;

		if ( ! empty( $f['body_class'] ) )
			$this->body_class[] = sprintf( $f['body_class'], $setting );

		if ( empty( $f['output'] ) )
			return false;

		return true;
	}

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
		$vals[1] = ms_array_value( $vals, 1, 400 );

		$this->gf_load[ $vals[5] ][ $vals[1] ] = 1;

		//Set property value
		if ( strpos( $vals[5], ' Light' ) ) {
			$vals[5] = "'$vals[5]', '" . str_replace( ' Light', '', $vals[5] ) . "'";
			$vals[1] -= 200;
		}

		foreach ( $this->font_format as $k => $f )
			$value .= ms_sprintf_array_val( $f, $vals, $k );

		$value .= $this->font_field_style_css( ms_array_value( $vals, 3 ) );

		//Return styles data
		return $value;
	}

	/**
	 * Return font style setting for font field
	 * @param $style string Font style setting
	 * @return string Font style css
	 */
	protected function font_field_style_css( $style ) {
		if ( ! empty( $vals[3] ) ) {
			if ( 'normal' == $vals[3] ) {
				return 'text-transform:uppercase;';
			} else {
				return "font-variant:small-caps;";
			}
		}

		return 'font-variant:normal;';
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