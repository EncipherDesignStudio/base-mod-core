<?php
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.2.9
 * @package    Mod_Core
 * @subpackage Mod_Core/inc
 * @author     Encipher Design Studio
*/
class Mod_Core_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.2.9
	*/
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mod-core',
			false,
			MOD_CORE_DIR . '/lang/'
		);

	}

}
