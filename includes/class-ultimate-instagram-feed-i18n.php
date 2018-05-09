<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       omark.me
 * @since      1.0.0
 *
 * @package    Ultimate_Instagram_Feed
 * @subpackage Ultimate_Instagram_Feed/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ultimate_Instagram_Feed
 * @subpackage Ultimate_Instagram_Feed/includes
 * @author     Omar Kasem <omar.kasem207@gmail.com>
 */
class Ultimate_Instagram_Feed_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ultimate-instagram-feed',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
