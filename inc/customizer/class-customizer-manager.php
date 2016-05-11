<?php
/**
 * Contains WPD_Settings_Page class
 * @author shramee
 * @since 1.0.0
 */

if ( ! class_exists( 'WPD_Customizer_Manager' ) ) {
	/**
	 * Class WPD_Customizer_Manager
	 */
	class WPD_Customizer_Manager {

		/** @var array Customizer controls classes */
		protected $controls_classes;

		/** @var string Customizer control class fallback */
		protected $default_control_class = 'WP_Customize_Control';

		/** @var string Section id */
		protected $id;

		/** @var string Section title */
		protected $title = 'Untitled';

		/** @var array Section fields */
		protected $fields = array();

		/** @var mixed Callback to add control */
		protected $add_control_callback;

		/** @var WP_Customize_Manager Customize manager */
		protected $man;

		/** @var string Sections and fields prefix */
		protected $token = 'wpd';

		/** @var string Settings class for all settings to register in this control */
		protected $settings_class = 'WP_Customize_Setting';

		/** @var string Settings type for all settings to register in this control */
		protected $settings_type = 'option';

		/** @var array Paths to files to include in customizer */
		protected $include = '';

		/**
		 * Gets the value of protected properties
		 * @param string $prop The property to fetch the value of
		 * @return mixed The value if property found or null
		 */
		public function __get( $prop ) {
			if ( property_exists( $this, $prop ) ) {
				return $this->$prop;
			}
			return null;
		}


		/**
		 * Constructor function.
		 * Adds customize register method to customize_register hook
		 * @param array $args paths to files to include in customizer
		 * @param int $priority the priority to register the customizer
		 * @since   0.7
		 */
		public function  __construct( $args, $priority = 50 ) {

			$keys = array_keys( get_object_vars( $this ) );

			foreach ( $keys as $key ) {
				if ( isset( $args[ $key ] ) ) {
					$this->$key = $args[ $key ];
				}
			}

			if ( ! is_callable( $this->add_control_callback ) ) {
				$this->add_control_callback = array( $this, 'add_control', );
			}

			if ( empty( $this->id ) ) {
				$this->id = wpd_make_id( $this->title );
			}

			$this->controls_classes = wp_parse_args( $this->controls_classes, array(
				'color'				=> 'WP_Customize_Color_Control',
				'image'				=> 'WP_Customize_Image_Control',
				'upload'			=> 'WP_Customize_Upload_Control',
				'alpha-color'		=> 'WPD_Customize_Control',
				'on-off'			=> 'WPD_Customize_Control',
				'checkboxes'		=> 'WPD_Customize_Control',
				'img-checkboxes'	=> 'WPD_Customize_Control',
				'img-radio'			=> 'WPD_Customize_Control',
				'button-checkboxes'	=> 'WPD_Customize_Control',
				'button-radio'		=> 'WPD_Customize_Control',
				'multi-select'		=> 'WPD_Customize_Control',
			) );

			//Register the panels, sections, controls and settings
			add_action( 'customize_register', array( $this, 'customizer_register' ), $priority );

			//Control scripts
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'controls_scripts' ) );
		}

		/**
		 * Adds custom fields, panels, and sections to WP_Customize_Manager
		 * @param WP_Customize_Manager $manager
		 * @action customize_register
		 * @since 0.7
		 */
		public function customizer_register( WP_Customize_Manager $manager ) {

			if ( file_exists( $this->include ) ) {
				include_once $this->include;
			}

			require_once 'class-customize-controls.php';

			//Set customize manager
			$this->man = $manager;

			//Register customizer elements
			$this->register_customizer_elements();
		}

		public function register_customizer_elements() {
			$fields = $this->fields;

			/**
			 * @var array $sections Customizer sections to  create
			 * WPD_Customizer_Manager::customizer_sections() prepares the section id from names in fields data
			 */
			$sections = $this->customizer_sections( $fields );

			//Registering fields
			$this->add_controls( $fields );

			if ( ! empty( $sections ) ) {

				/**
				 * Filters panel arguments.
				 * The dynamic part refers to the id of the ID of options group
				 * While registering the multiple sections,
				 * this hooks is available in addition to wpd_customizer_$this->id_section_args
				 * @param array $panel_args
				 */
				$panel_args = apply_filters( 'wpd_customizer_' . $this->id . '_panel_args', array(
						'title'    => $this->title,
						'priority' => 1,
				) );

				//Adding the panel
				$this->man->add_panel( "$this->token-$this->id", $panel_args );

				//Adding each section in the panel
				foreach ( $sections as $section_id => $section_title ) {

					/**
					 * Filters section arguments.
					 * The dynamic part refers to the id of the ID of options group
					 * @param array $section_args
					 * @param string $section_id
					 */
					$section_args = apply_filters( 'wpd_customizer_' . $this->id . '_section_args', array(
						'title' => $section_title,
						'panel' => "$this->token-$this->id",
					), $section_id );

					//Adding section
					$this->man->add_section( $section_id, $section_args );

				}
			} else {

				/**
				 * Filters section arguments.
				 * The dynamic part refers to the id of the ID of options group
				 * While registering the only main section $args can be filtered directly
				 * @param array $section_args
				 */
				$section_args = apply_filters( 'wpd_customizer_' . $this->id . '_section_args', array(
					'title' => $this->title,
					'priority' => 1,
				) );
				//Adding single section
				$this->man->add_section( "$this->token-$this->id", $section_args );

			}
		}

		function controls_scripts() {
			wp_enqueue_script( 'wpd-alpha-color-picker-js', WPD_DIR_URL . '/inc/assets/alpha-color-picker.js', array( 'jquery', 'wp-color-picker' ) );
			wp_enqueue_style( 'wpd-customizer-controls-css', WPD_DIR_URL . '/inc/assets/customizer-controls.css' );
			wp_enqueue_script( 'wpd-customizer-controls-js', WPD_DIR_URL . '/inc/assets/customizer-controls.js', array( 'jquery' ) );
		}

		/**
		 * Adds custom fields, panels, and sections to WP_Customize_Manager
		 * @param array $fields
		 * @return array Customizer sections to create
		 * @since 0.7
		 */
		public function customizer_sections( &$fields ) {
			/** @var array $sections Customizer sections to  create */
			$sections = array();

			foreach ( $fields as $ki => &$option ) {
				$option = wp_parse_args( $option, array(
					'id' => $ki,
					'default' => '',
				) );

				$option['id'] = $this->token . '-' . $this->id . '[' . $option['id'] . ']';

				if ( empty( $option['section'] ) ) {
					$option['section'] = $this->token . '-' . $this->id;
				} else {
					$section = $option['section'];
					if ( is_array( $section ) ) {
						$sections[ $section[0] ] = $section[1];
						$section = $section[0];
					} else if ( is_string( $section ) ) {
						if ( 0 === strpos( $section, 'existing_' ) ) {
							$section = str_replace( 'existing_', '', $section );
						} else {
							$section = $this->token . "-{$this->id}-" . wpd_make_id( $section );
							$sections[ $section ] = $option['section'];
						}
					}
					$option['section'] = $section;
				}
			}
			return $sections;
		}
		/**
		 * Adds controls and settings to WP_Customize_Manager
		 * @param array $fields Controls data
		 * @since 0.7
		 */
		protected function add_controls( $fields ) {
			foreach ( $fields as $option ) {
				$settings_class = $this->settings_class;

				$option = wp_parse_args(
					$option,
					array(
						'default' => '',
					)
				);

				/**
				 * Filters settings arguments.
				 * The dynamic part refers to the ID of options group
				 * @param array $setting_args Arguments
				 * @param array $option Option data
				 */
				$setting_args = apply_filters( 'wpd_customizer_' . $this->id . '_setting_args', array(
						'default' => $option['default'],
						'type'    => $this->settings_type,
					), $option );

				//Render Simple controls ( Containing single field )
				call_user_func( $this->add_control_callback, $option, $setting_args, $settings_class, $this );
			}
		}

		/**
		 * Adds simple control and its setting to WP_Customize_Manager
		 *
		 * @param array $option Field data
		 *
		 * @since 0.7
		 */
		public function add_control( $option, $setting_args, $settings_class ) {

			//Add settings
			$this->man->add_setting( new $settings_class( $this->man, $option['id'], $setting_args ) );

			//Create a section class
			if ( ! empty( $option['control_class'] ) ) {
				$control_class = $option['control_class'];
				//Add control
				$this->man->add_control(
					new $control_class(
						$this->man,
						$option['id'],
						$option
					)
				);
			} else if ( ! empty( $this->controls_classes[ $option['type'] ] ) ) {
				$control_class = $this->controls_classes[ $option['type'] ];
				//Add control
				$this->man->add_control(
					new $control_class(
						$this->man,
						$option['id'],
						$option
					)
				);
			} else {
				$control_class = $this->default_control_class;
				//Add control
				$this->man->add_control(
					new $control_class(
						$this->man,
						$option['id'],
						$option
					)
				);
			}
		}
	}
}