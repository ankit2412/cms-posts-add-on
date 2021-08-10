<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.auth-test.com
 * @since      1.0.0
 *
 * @package    Cms_Posts_Add_On
 * @subpackage Cms_Posts_Add_On/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Cms_Posts_Add_On
 * @subpackage Cms_Posts_Add_On/includes
 * @author     Ankit Jani <ankitj@cmsminds.com>
 */
class Cms_Posts_Add_On_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'cms-posts-add-on',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
