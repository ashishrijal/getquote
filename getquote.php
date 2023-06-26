<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ashishrijal.com
 * @since             1.0.0
 * @package           Getquote
 *
 * @wordpress-plugin
 * Plugin Name:       getquote
 * Plugin URI:        https://ashishrijal.com
 * Description:       This is a plugin to get quote
 * Version:           1.0.0
 * Author:            ashish rijal
 * Author URI:        https://ashishrijal.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       getquote
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'GETQUOTE_VERSION', '1.0.0' );

function activate_getquote(){
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-getquote-activator.php';
    new Getquote_Activator();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-getquote-deactivator.php
 */
function deactivate_getquote() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-getquote-deactivator.php';
	Getquote_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_getquote' );
register_deactivation_hook( __FILE__, 'deactivate_getquote' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-getquote.php';

//require plugin_dir_path( __FILE__ ) . 'includes/class-getquote-wc-product.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_getquote() {
    
    $plugin = new Getquote();
	$plugin->run();
}

run_getquote();

function create_my_custom_page() {
    $new_page = array(
        'post_type' => 'page',
        'post_title' => 'quote',
        'post_content' => '',
        'post_status' => 'publish',
        'post_author' => 1,
    );
    $new_page_id = wp_insert_post($new_page);
    update_post_meta($new_page_id, '_wp_page_template', 'get-quote-page.php');
}