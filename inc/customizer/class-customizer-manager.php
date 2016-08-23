<?php
/**
 * Contains Makesite_Customizer_Manager class
 * @author shramee
 * @since 1.0.0
 */
if ( ! class_exists( 'Makesite_Customizer_Manager' ) ) {
	/**
	 * Class Makesite_Customizer_Manager
	 */
	class Makesite_Customizer_Manager {

		/** @var array Customizer controls classes */
		protected $controls_classes;

		/** @var string Customizer control class f lback */
		protected $default_control_class = 'WP_Customize_Control';

		/** @var string Section id */
		protected $id;

		/** @var string Section title */
		protected $title = 'Untitled';

		/** @var int Priority for panel/section */
		protected $priority = 1;

		/** @var array Section fields */
		protected $fields = array();

		/** @var callable Callback to add control */
		protected $add_control_callback;

		/** @var WP_Customize_Manager Customize manager */
		protected $man;

		/** @var string Sections and fields prefix */
		protected $token = 'ms';

		/** @var string Settings class for all settings to register in this control */
		protected $settings_class = 'WP_Customize_Setting';

		/** @var string Settings type for all settings to register in this control */
		protected $settings_type = 'option';

		/** @var array Paths to files to include in customizer */
		protected $include = '';

		/** @var string Section name(s) prefix */
		protected $section_prefix = 'ms-';

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
			//Register the panels, sections, controls and settings
			add_action( 'customize_register', array( $this, 'init' ), $priority );
			//Control scripts
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'controls_scripts' ) );
		}

		/**
		 * Initiates registering customizer elements
		 * @param WP_Customize_Manager $manager
		 */
		public function init( $manager ) {
			if ( empty( $this->id ) ) {
				$this->id = ms_make_id( $this->title );
			}
			if ( ! is_callable( $this->add_control_callback ) ) {
				$this->add_control_callback = array( $this, 'add_control', );
			}
			$this->controls_classes();
			$this->customizer_register( $manager );
		}

		/**
		 * Returns classes needed to render the controls
		 */
		protected function controls_classes() {
			$this->controls_classes = wp_parse_args( $this->controls_classes, array(
				'color'             => 'WP_Customize_Color_Control',
				'image'             => 'WP_Customize_Image_Control',
				'upload'            => 'WP_Customize_Upload_Control',
				'heading'           => 'Makesite_Customizer_Control',
				'alpha-color'       => 'Makesite_Customizer_Control',
				'on-off'            => 'Makesite_Customizer_Control',
				'checkboxes'        => 'Makesite_Customizer_Control',
				'img-checkboxes'    => 'Makesite_Customizer_Control',
				'img-radio'         => 'Makesite_Customizer_Control',
				'button-checkboxes' => 'Makesite_Customizer_Control',
				'button-radio'      => 'Makesite_Customizer_Control',
				'multi-select'      => 'Makesite_Customizer_Control',
			) );
		}

		/**
		 * Adds custom fields, panels, and sections to WP_Customize_Manager
		 * @param WP_Customize_Manager $manager
		 * @action customize_register
		 * @since 0.7
		 */
		public function customizer_register( $manager ) {
			if ( file_exists( $this->include ) ) {
				include_once $this->include;
			}
			//Set customize manager
			$this->man = $manager;
			//Register customizer elements
			$this->register_customizer_elements();
		}

		/**
		 * Registers sections and fields
		 */
		public function register_customizer_elements() {
			$fields = $this->fields;
			/**
			 * @var array $sections Customizer sections to  create
			 * Makesite_Customizer_Manager::customizer_sections() prepares the section id from names in fields data
			 */
			$sections = $this->customizer_sections( $fields );
			//Registering fields
			$this->add_controls( $fields );
			if ( ! empty( $sections ) ) {
				/**
				 * Filters panel arguments.
				 * The dynamic part refers to the id of the ID of options group
				 * While registering the multiple sections,
				 * this hooks is available in addition to ms_customizer_$this->id_section_args
				 * @param array $panel_args
				 */
				$panel_args = apply_filters( 'ms_customizer_' . $this->id . '_panel_args', array(
					'title'    => $this->title,
					'priority' => $this->priority,
				) );
				//Adding the panel
				$this->man->add_panel( "$this->token-$this->id", $panel_args );
				$section_priority = 2;
				//Adding each section in the panel
				foreach ( $sections as $section_id => $section_title ) {
					/**
					 * Filters section arguments.
					 * The dynamic part refers to the id of the ID of options group
					 * @param array $section_args
					 * @param string $section_id
					 */
					$section_args = apply_filters( 'ms_customizer_' . $this->id . '_section_args', array(
						'title' => $section_title,
						'panel' => "$this->token-$this->id",
						'priority' => $section_priority++,
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
				$section_args = apply_filters( 'ms_customizer_' . $this->id . '_section_args', array(
					'title' => $this->title,
					'priority' => 1,
				) );
				//Adding single section
				$this->man->add_section( "$this->token-$this->id", $section_args );
			}
		}

		/**
		 * Enqueues customizer scripts and styles
		 */
		public function controls_scripts() {
			// Alpha color picker
			wp_enqueue_script( 'ms-color-picker', MS_URL . '/inc/customizer/assets/alpha-color-picker.js', array( 'jquery', 'wp-color-picker' ) );

			//Google fonts
			wp_enqueue_style( 'makesite-google-fonts-css', MS_URL . 'inc/customizer/assets/google-fonts.css', array(), MS_VER );
			wp_enqueue_script( 'makesite-google-fonts-js', MS_URL . 'inc/customizer/assets/google-fonts.js', array( 'jquery' ), MS_VER, 'in_footer' );

			// Controls JS
			wp_enqueue_style( 'makesite-customizer-controls-css', MS_URL . 'inc/customizer/assets/customizer-controls.css', array(), MS_VER );
			wp_enqueue_script( 'makesite-customizer-controls-js', MS_URL . 'inc/customizer/assets/customizer-controls.js', array( 'ms-color-picker', 'makesite-google-fonts-js' ), MS_VER, 'in_footer' );

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
				if ( empty( $option['section'] ) ) {
					$option['section'] = $this->token . '-' . $this->id;
				} else {
					$this->get_customizer_section_from_field( $option, $sections );
				}
			}
			return $sections;
		}

		/**
		 * Gets section data from field
		 * @param array $option
		 * @param array $sections
		 * @since 0.7
		 */
		private function get_customizer_section_from_field( &$option, &$sections ) {
			$sec = $option['section'];
			if ( is_array( $sec ) ) {
				$sections[ $sec[0] ] = $sec[1];
				$sec = $sec[0];
			} else if ( is_string( $sec ) ) {
				if ( 0 === strpos( $sec, 'existing_' ) ) {
					$sec = str_replace( 'existing_', '', $sec );
				} else {
					$sec = $this->section_prefix . ms_make_id( $sec );
					$sections[ $sec ] = $option['section'];
				}
			}
			$option['section'] = $sec;
		}

		/**
		 * Adds controls and settings to WP_Customize_Manager
		 * @param array $fields Controls data
		 * @since 0.7
		 */
		protected function add_controls( $fields ) {
			foreach ( $fields as $option ) {
				$settings_class = $this->settings_class;
				/**
				 * Filters settings arguments.
				 * The dynamic part refers to the ID of options group
				 * @param array $setting_args Arguments
				 * @param array $option Option data
				 */
				$setting_args = apply_filters( 'ms_customizer_' . $this->id . '_setting_args', array(
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
			$control_class =
				! empty( $option['control_class'] ) ?
					$option['control_class'] :
					! empty( $this->controls_classes[ $option['type'] ] ) ?
						$this->controls_classes[ $option['type'] ] :
						$this->default_control_class;
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