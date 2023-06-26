<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://ashishrijal.com
 * @since      1.0.0
 *
 * @package    Getquote
 * @subpackage Getquote/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Getquote
 * @subpackage Getquote/includes
 * @author     ashish rijal <ashish@ashishrijal.com>
 */
class Getquote_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		$page_title = 'quote';
		$page = get_page_by_title($page_title);
		if ($page) {
			wp_delete_post($page->ID, true);
		}
	}

}