<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://webcrunch.com.au/
 * @since      0.0.1
 *
 * @package    Configurator_Wp
 * @subpackage Configurator_Wp/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @todo Justify why we need this or remove it. AFAIK nothing can be done with textdomains else than loading it.
 *       This, if true, makes this class a total waste of code.
 *
 * @since      0.0.1
 * @package    Configurator_Wp
 * @subpackage Configurator_Wp/includes
 * @author     Your Name <scottzonneveldt@gmail.com>
 */
class Configurator_Wp_I18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.0.1
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'configurator-wp',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
