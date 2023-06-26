<?php

/**
 * Fired during plugin activation
 *
 * @link       https://ashishrijal.com
 * @since      1.0.0
 *
 * @package    Getquote
 * @subpackage Getquote/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Getquote
 * @subpackage Getquote/includes
 * @author     ashish rijal <ashish@ashishrijal.com>
 */


class Getquote_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	 public function __construct(){
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

}