<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://https://github.com/RajatWisdm/
 * @since      1.0.0
 *
 * @package    Wdm_Subscribe
 * @subpackage Wdm_Subscribe/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wdm_Subscribe
 * @subpackage Wdm_Subscribe/includes
 * @author     Rajat Ganguly <rajat.ganguly@wisdmlabs.com>
 */
class Wdm_Subscribe_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wdm-subscribe',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
