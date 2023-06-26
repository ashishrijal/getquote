<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ashishrijal.com
 * @since      1.0.0
 *
 * @package    Getquote
 * @subpackage Getquote/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Getquote
 * @subpackage Getquote/admin
 * @author     ashish rijal <ashish@ashishrijal.com>
 */
class Getquote_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Getquote_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Getquote_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/getquote-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Getquote_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Getquote_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/getquote-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function get_quote_options_update() {
		register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
	}


	public function validate($input) {
		$valid = sanitize_email($input);
		return $valid;
	}
	
	public function get_quote_plugin_menu(){
		add_menu_page(
			'My Custom Plugin Settings',
			'Getquote',
			'manage_options',
			$this->plugin_name,
			array($this, 'display_plugin_setup_page'),
			'dashicons-admin-generic',
			100
		);
	}

	public function display_plugin_setup_page() {
		include plugin_dir_path( __FILE__ ) . 'get-quote-admin-form.php';
	}


	public function getquote_settings_init() {
		// register a new section in the "myplugin" page
		add_settings_section(
			'getquote_settings_section', // id of the section
			'Getquote Settings', // title to be displayed
			'', // callback function to be called when the section is rendered
			$this->plugin_name // page on which to display the section, this should match the menu slug
		);
	 
		// register a new field in the "myplugin_settings_section" section
		add_settings_field(
			'getquote_settings_field', // id of the field
			'Enter the email:', // label of the field
			array($this, 'getquote_settings_field_html'), // function to handle the field markup
			$this->plugin_name, // page on which to display the field
			'getquote_settings_section' // section in which to show the field
		);
	 }

	 public function getquote_settings_field_html() {
		// get the value of the setting we've registered with register_setting()
		$setting = get_option($this->plugin_name);
		include plugin_dir_path( __FILE__ ) . 'get-quote-admin-form-inputfield.php';
		// output the field
}



}