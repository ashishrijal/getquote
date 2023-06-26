<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ashishrijal.com
 * @since      1.0.0
 *
 * @package    Getquote
 * @subpackage Getquote/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Getquote
 * @subpackage Getquote/public
 * @author     ashish rijal <ashish@ashishrijal.com>
 */
class Getquote_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/getquote-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/getquote-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'ajax-script', plugin_dir_url( __FILE__ ) . '/js/ajax-form-getquote.js', array('jquery') );
		wp_localize_script( 'ajax-script', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );		
		
	}
	
	public function my_quote_add_to_cart(){	
		include plugin_dir_path( __FILE__ ) . 'get-quote-form.php';
	}

	function use_my_custom_template($template) {
		if (is_page('quote')) {
			$template = plugin_dir_path(__FILE__) . 'get-quote-page.php';
		}
		return $template;
	}

	function view_details_loop(){
		echo '<div class="view_details">View Details</div>';
	}

	function getquote_form_submit_action(){
		$first_name = sanitize_text_field( $_POST['first_name'] );
		$last_name = sanitize_text_field( $_POST['last_name'] );
		$company = sanitize_text_field( $_POST['company'] );
		$country = sanitize_text_field( $_POST['country'] );
		$phone = sanitize_text_field( $_POST['phone'] );
		$email = sanitize_text_field( $_POST['email'] );
		$comments = sanitize_text_field( $_POST['comments'] );
		$product = sanitize_text_field( $_POST['nameofproduct'] );
		
		$message = "From :".$first_name." ".$last_name.
		"\r\nCompany: ".$company.
		"\r\nCountry: ".$country.
		"\r\nPhone Number: ".$phone.
		"\r\nEmail: ".$email. 
		"\r\nMessage: ".$comments;
		
		$email  = get_option($this->plugin_name);
		
		$to = $email;
		
		$subject = 'Enquiry about '.$product;
		if ( wp_mail( $to, $subject, $message, $headers ) ) {
    		echo json_encode( array( 'success' => true) );
		} 

		else{
			echo json_encode(array('success'=>false));
		}

		wp_die();
	}
}