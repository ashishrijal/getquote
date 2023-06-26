<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://ashishrijal.com
 * @since      1.0.0
 *
 * @package    Getquote
 * @subpackage Getquote/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Getquote
 * @subpackage Getquote/includes
 * @author     ashish rijal <ashish@ashishrijal.com>
 */
class Getquote {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Getquote_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'GETQUOTE_VERSION' ) ) {
			$this->version = GETQUOTE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'getquote';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Getquote_Loader. Orchestrates the hooks of the plugin.
	 * - Getquote_i18n. Defines internationalization functionality.
	 * - Getquote_Admin. Defines all hooks for the admin area.
	 * - Getquote_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-getquote-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-getquote-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-getquote-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-getquote-public.php';

		$this->loader = new Getquote_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Getquote_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Getquote_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Getquote_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'get_quote_options_update' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'get_quote_plugin_menu');
		$this->loader->add_action( 'admin_init', $plugin_admin, 'getquote_settings_init');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Getquote_Public( $this->get_plugin_name(), $this->get_version() );

		// removing some of the hooks that displays price and add to cart buttons!

		add_action('wp_loaded', function() use ($plugin_public) {
			if (has_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart')) {
				remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);				
			}
		});


		add_action('wp_loaded', function() use ($plugin_public) {
			if (has_action('woocommerce_single_product_summary', 'woocommerce_template_single_price')) {
				remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);			
			}
		});

		add_action('wp_loaded', function() use ($plugin_public) {			
			if (has_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price')) {
				remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);			
			}
		});

		add_action('wp_loaded', function() use ($plugin_public) {			
			if (has_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart')) {
				remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);			
			}
		});
				
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'woocommerce_single_product_summary', $plugin_public, 'my_quote_add_to_cart',50 );
		$this->loader->add_action( 'woocommerce_after_shop_loop_item_title', $plugin_public, 'view_details_loop',10 );
		$this->loader->add_filter( 'template_include', $plugin_public, 'use_my_custom_template');
		$this->loader->add_action( 'wp_ajax_getquote_form_submit_action', $plugin_public, 'getquote_form_submit_action');
		$this->loader->add_action( 'wp_ajax_nopriv_getquote_form_submit_action', $plugin_public, 'getquote_form_submit_action');		

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Getquote_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}