<?php
/**
 * Adds css for customizer options
 * @package makesite
 * @since 1.0.0
 */

class Makesite_Design_Css {

	/** @var Makesite_Design_Css Instance */
	protected static $instance;

	/** @var array Styles data */
	protected $css;

	/** @var string Classes to add to body */
	protected $body_classes = '';

	/** @var array Google fonts to load */
	protected $gf_load  =array();

	/** @var array Google fonts */
	protected $gf_data;

	/** @var array Setting for current options group */
	protected $settings;

	/**
	 * Returns instance of Makesite_Design_Css
	 * @return Makesite_Design_Css
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function get_css() {
		$t = Makesite_Design_Css::instance();

		if ( empty( $t->css ) )
			$t->save_data();

		return $t->css;
	}

	/**
	 * Magic constructor
	 * @since 1.0.0
	 */
	protected function __construct() {
		$this->gf_data = ms_get_fonts( 'data' );
		if ( is_customize_preview() ) {
			$this->save_data();
		}
	}

	/**
	 * Generates CSS data from settings
	 * @action wp
	 * @uses Makesite_Design_Css::$styles, Makesite_Design_Css::$gf_load
	 * @since 1.0.0
	 */
	protected function process_settings() {
		$styles = '';

		$ms_fields = Makesite_Design::fields();
		foreach ( $ms_fields as $settings_group => $options ) {
			foreach( $options as $id => $f ) {

				$f['default'] = empty( $f['default'] ) ? '' : $f['default'];

				//Getting setting in a var
				$setting = get_option( $id, $f['default'] );

				if ( $this->is_field_css( $setting, $f ) ) {
					$styles .= $this->field_css(  $setting, $f['output'], $f );
				}
			}
		}
		$this->css = $styles;
	}

	protected function field_css( $setting, $output, $f ) {
		if ( is_array( $output ) ) {
			if ( ! empty( $output[ $setting ] ) ) {
				return $output[ $setting ];
			}
		} else {
			//Setting CSS vars
			return $this->get_style( $output, $setting, $f );
		}
	}

	protected function is_field_css( $setting, $f ) {

		if ( empty( $setting ) )
			return false;

		if ( ! empty( $f['body_class'] ) )
			$this->body_classes .= sprintf( $f['body_class'], $setting );

		if ( empty( $f['output'] ) )
			return false;

		return true;
	}

	protected function get_style( $format, $setting, $f ) {
		$method = 'css_' . ms_make_id( $f['type'], '_' );
		if ( method_exists( $this, $method ) ) {
			$vals = explode( '|', $setting ); //Setting multi values from string
			return $this->$method( $vals, $format ); // Getting style from callback
		} else {
			return sprintf( $format, $setting );
		}
	}

	/**
	 * Returns the styles from type of control
	 * @param array $vals Current settings
	 * @param string $style Style format
	 * @return string $css
	 */
	protected function css_font( $vals, $style ) {
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
			return sprintf( $style, $value );
		}

		return '';
	}

	/**
	 * Returns the styles from type of control
	 * @param array $vals Current settings
	 * @param string $style Style format
	 * @return string $css
	 */
	protected function css_border( $vals, $style ) {
		//Split values to array
		if ( ! empty( $vals[1] ) ) {
			//Set property value
			$value = "{$vals[0]}px {$vals[1]} {$vals[2]}";
			//Return styles data
			return sprintf( $style, $value );
		}

		return '';
	}

	/**
	 * Returns the styles from type of control
	 * @param array $vals Current settings
	 * @param string $style Style format
	 * @return string $css
	 */
	protected function css_all_custo( $default, $style, $id ) {

		$default = implode( '|', $default );

		$css = '';

		//bg-color
		$bg_color = ms_array_value( $this->settings, "$id-bg-color", '' );
		$css .= "\n" . $bg_color ? "background-color:{$bg_color};" : '';

		//border-radius
		$border_radius = ms_array_value( $this->settings, "$id-border-radius", '' );
		$css .= "\n" . $border_radius ? "border-radius:{$border_radius}px;" : '';

		//border
		$border = ms_array_value( $this->settings, $id . '-border' );
		$css .= "\n" . $this->css_all_border( explode( '|', $border ) );

		//shadow
		$shadow = ms_array_value( $this->settings, $id . '-shadow' );
		$css .= "\n" . $this->css_shadow( explode( '|', $shadow ), 'box-shadow: %s;' );

		//padding
		$padding = ms_array_value( $this->settings, $id . '-padding' );
		$css .= "\n" . $this->css_spacing( explode( '|', $padding ), 'padding: %s;' );

		return $css;
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
	protected function css_spacing( $vals, $style ) {
		//Split values to array
		if ( isset( $vals[1] ) ) {
			return sprintf( $style, implode( 'px ', $vals ) . 'px' );
		}

		return '';
	}

	/**
	 * Returns the styles from type of control
	 * @param array $vals Current settings
	 * @return string $css
	 */
	protected function css_shadow( $vals, $style ) {
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
			return sprintf( $style, $value );
		}

		return '';
	}

	/**
	 * Returns the styles from type of control
	 * @param array $vals Current settings
	 * @return string $css
	 */
	protected function css_text_shadow( $vals, $style ) {
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
			return sprintf( $style, $value );
		}

		return '';
	}

	/**
	 * Outputs CSS from CSS data
	 * @action wp_head
	 * @uses Makesite_Design_Css::$styles
	 * @since 1.0.0
	 */
	protected function save_data() {
		if ( empty( $this->css ) ) {
			$this->process_settings();

			update_option( 'ms_design_body_classes', $this->body_classes );
			update_option( 'ms_design_css', $this->css );
			update_option( 'ms_design_google_fonts', $this->google_fonts_url() );
		}
	}

	/**
	 * Registers Makesite control types to the liby customizer fields
	 * @action wp
	 * @uses Makesite_Design_Css::$styles, Makesite_Design_Css::$gf_load
	 * @return string google font url
	 * @since 1.0.0
	 */
	public function google_fonts_url() {
		$load_fonts = array();
		foreach( $this->gf_load as $font => $weight ) {
			if ( 'Open Sans Condensed' == $font ) {
				$this->gf_load[ $font ] = array( '300' );
			} elseif ( strpos( $font, ' Light' ) ) {
				$this->gf_load[ str_replace( ' Light', '', $font ) ][] = '300';
			}
		}
		foreach( $this->gf_load as $font => $weight )
			$load_fonts[] = $font . ':' . implode( ':', $weight );

		if ( $load_fonts )
			return '//fonts.googleapis.com/css?family=' . join( '%7C', $load_fonts );
		else
			return '';
	}
}