<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://krzysztof-furtak.pl
 * @since      2.0.0
 *
 * @package    Kk_I_Like_It
 * @subpackage Kk_I_Like_It/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      2.0.0
 * @package    Kk_I_Like_It
 * @subpackage Kk_I_Like_It/includes
 * @author     Krzysztof Furtak <krzysztof.furtak@gmail.com>
 */
class Kk_I_Like_It_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    2.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'kk-i-like-it',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}



}
