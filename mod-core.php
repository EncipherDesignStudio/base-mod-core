<?php

/**
 * Mod_Core Startup.
 * 
 * Defines common variables, & inits plugin. 
 *
 * TODO
	-- Create admin settings GUI to manage desired features
	-- Maintenance: Consolidate like items to manage specific features based on selected options
	-- Add missing SEO and accessibility meta for section 508, WCAG compliance
	-- Start translation file
	-- Find a CSP solution that won't bork wp nonsense
 *
 * @link              https://encipherdesign.com/
 * @since             1.2.9
 * @package           Mod_Core
 *
 * @wordpress-plugin
 * Plugin Name:       Base: Mod Core
 * Plugin URI:        https://encipherdesign.com/
 * Description:       Modify core WP fn with helpful features.
 * Version:           1.2.9
 * Author:            Encipher Design Studio
 * Author URI:        https://encipherdesign.com/
 * License:           MEH.1.29+
 * License URI:       https://encipherdesign.com/
 * Text Domain:       mod-core
 * Domain Path:       /lang
*/

/**
	Plugin definitions.
	Define version number, theme name, directory path and url.
*/
define( 'MOD_CORE_VERSION', '1.2.9' );
define( 'MOD_CORE_THM', 'mod-core' );
define( 'MOD_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'MOD_CORE_URL', plugin_dir_url( __FILE__ ) );

define( 'MOD_CORE_DOMAIN', get_bloginfo( 'site_url' ) );

/**

	Defines directory for Bad Bot Ban Script.
	No beginning or ending forward slashes.
	@see class-mod-core-security.php
*/ 
define( 'MOD_CORE_BADBOTS_DIR', 'crush' );


/**
 * Activation tasks.
 * This action is documented in inc/class-mod-core-activator.php
*/
function activate_mod_core() {
	
	require_once MOD_CORE_DIR . 'inc/class-mod-core-activate.php';
	
	Mod_Core_Activator::activate();
	
}

/**
 * Deactivation tasks.
 * This action is documented in inc/class-mod-core-deactivator.php
*/
function deactivate_mod_core() {

	require_once MOD_CORE_DIR . 'inc/class-mod-core-deactivate.php';
	
	Mod_Core_Deactivator::deactivate();

}

register_activation_hook( __FILE__, 'activate_mod_core' );
register_deactivation_hook( __FILE__, 'deactivate_mod_core' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
*/
require MOD_CORE_DIR . 'inc/class-mod-core.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.2.9
*/
function run_mod_core() {

	$mod_core = new Mod_Core();
	$mod_core->run();

}

run_mod_core();