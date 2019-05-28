<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * TODO create options page
 * -- crud options
 *
 * @link       https://encipherdesign.com/
 * @since      1.2.9
 *
 * @package    Mod_Core
 * @subpackage Mod_Core/admin
 */

class Mod_Options extends Mod_Core_Admin {

	public function __construct() {
	
		add_action( 'admin_menu', array( 'Mod_Options', 'admin_menu' ) );
	
	}
	
	public static function set_admin_menu() {
	
		// tools submenu item: add_management_page()
		// plugins submenu item: add_plugins_page()
		// users submenu item: add_users_page()
		// theme submenu item: add_theme_page()
		// settings submenu item: add_options_page()
		
		add_options_page(
			'Page Title',
			'Circle Tree Login',
			'manage_options',
			'options_page_slug',
			array(
				'Mod_Options',
				'get_settings_page'
			)
		);
	
	}

	public static function get_settings_page() {
	
		require_once MOD_CORE_DIR . '/admin/display/mod-core-admin-display.php';
	
	}

	/**
	 *
	 * Provides default plugin options.
	 *
	 * USAGE:
	 * -- set var: $opt = include( '<opt>.php' );
	 * -- obtain value: $opt['<key>'];
	 * -- || include
	 * -- util fn: is_key( $key, $array ), arr_key_bool( $key, $array );
	 * -- util fn: arr_key_val( $val, $array );
	 *
	 $opts = array(
	 'key'=>'value'
	 ,'key'=>['value','value']
	 ,'key'=>['key'=>'value']
	 );
	 
	 *
	 * @return array
	 */
	
	public static function set_default_options(  ) {
		
		//register settings
		//load settings
		
	}

	
}

$options = new Mod_Options;