<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://encipherdesign.com/
 * @since      1.2.9
 *
 * @package    Mod_Core
 * @subpackage Mod_Core/admin
*/
class Mod_Core_Admin {

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
	 * @var      string    $version    The current version of this plugin.
	 */
	protected $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.2.9
	 * @param      string    $Mod_Core       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Mod_Core, $version ) {

		$this->Mod_Core = $Mod_Core;
		$this->version = $version;

	}
	
	 /**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.2.9
	 */
	public function enqueue_styles() {

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.2.9
	 */
	public function enqueue_scripts() {

	}
	
	public function nix_hooks() {
	
	}
	
	public function nix_filters() {
	
	}
	
	
	public function add_hooks() {
		
	}
	
	public function add_filters() {
		
	}
}
