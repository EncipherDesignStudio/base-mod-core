<?php

/**
 * Fired during plugin use.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.2.9
 * @package    Mod_Core
 * @subpackage Mod_Core/inc
 * @author     Encipher Design Studio
*/

class Mod_Core_Meta extends Mod_Core {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.2.9
	 * @access   private
	 * @var      string    $Mod_Core    The ID of this plugin.
	*/
	protected $Mod_Core;
	
	/**
	 * The version of this plugin.
	 *
	 * @since    1.2.9
	 * @access   private
	 * @var      string    $version    Current version of this plugin.
	*/
	protected $version;
	
	/**
	 * Initialize the class and set properties.
	 *
	 * @since		1.2.9
	 * @param		string    $Mod_Core   The name of this plugin.
	 * @param		string    $version    The version of this plugin.
	*/
	public function __construct( $Mod_Core, $version ) {
		
		$this->Mod_Core = $Mod_Core;
		$this->version = $version;
		
	}
	
	/**
	 * Return theme information.
	 *
	 * @since    1.2.9
	 *
	 * @return array
	 */
	public static function get_theme_meta() {
		
		$thm_data = wp_get_theme();
		
		$thm_meta['title'] = 		$thm_data['Name'];//'Base';
		$thm_meta['name'] = 		$thm_data['Tags'];//BPEDS_BASE_THEME_NAME;
		$thm_meta['author'] = 		$thm_data['Author'];//'Encipher Design Studio';
		$thm_meta['author_url'] = 	$thm_data['Author URI'];//'https://encipherdesign.com/';
		$thm_meta['theme_url'] = 	$thm_data['Theme URI'];//'https://encipherdesign.com/wp/';
		$thm_meta['status'] = 		$thm_data['Status'];//'Production|Beta';
		$thm_meta['version'] = 		$thm_data['Version'];//'1.29';
		$thm_meta['description'] = 	$thm_data['Description'];//Theme Description
		
		return $thm_meta;
		
	}
	
}