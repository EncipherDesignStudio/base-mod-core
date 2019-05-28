<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://encipherdesign.com/
 * @since      1.2.9
 *
 * @package    Mod_Core
 * @subpackage Mod_Core/inc
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.2.9
 * @package    Mod_Core
 * @subpackage Mod_Core/inc
 * @author     Encipher Design Studio
 */
class Mod_Core {
	
	/**
	 * $options.
	 *
	 * @since    1.2.9
	 * @access   protected
	 * @var      Mod_Core    $slug    sets $slug for the plugin.
	 */
	protected $slug = 'mod-core';
	
		/**
	 * $options.
	 *
	 * @since    1.2.9
	 * @access   protected
	 * @var      Mod_Core    $options    Maintains and registers all $options for the plugin.
	 */
	protected $options;
	
/**
	 * The helper class that is responsible for maintaining and registering all fn
	 * that power the plugin.
	 *
	 * @since    1.2.9
	 * @access   protected
	 * @var      Mod_Core_Helper    $helper    Maintains and registers all fn for the plugin.
	 */
	protected $helper;
	
	/**
	 * The security class that is responsible for maintaining and registering all security fn
	 * that power the plugin.
	 *
	 * @since    1.2.9
	 * @access   protected
	 * @var      Mod_Core_Security    $security    Maintains and registers all security fn for the plugin.
	 */
	protected $security;
	
	/**
	 * The loader class that is responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.2.9
	 * @access   protected
	 * @var      Mod_Core_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.2.9
	 * @access   protected
	 * @var      string    $Mod_Core    The string used to uniquely identify this plugin.
	 */
	protected $Mod_Core;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.2.9
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	
	/**
	 * Plugin instance.
	 *
	 * @since    1.2.9
	 * @access   protected
	 */
	protected static $instance = NULL;
	
	public static function get_instance() {
		
		// create an object
		NULL === self::$instance and self::$instance = new self;
		
		return self::$instance; // return the instance object
	}
	
	
	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.2.9
	 */
	public function __construct() {
		
		if ( defined( 'Mod_Core_VERSION' ) ) :

			$this->version = Mod_Core_VERSION;
		
		else :
		
			$this->version = '1.2.9';

		endif;
		
		$this->Mod_Core = 'mod-core';

		$this->set_dependencies();
		//$this->set_options();
	
		$this->set_locale();

		$this->set_helper();
		$this->set_security();

		//$this->set_admin_hooks();
		$this->set_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Mod_Core_Loader. Orchestrates the hooks of the plugin.
	 * - Mod_Core_i18n. Defines internationalization functionality.
	 * - Mod_Core_Admin. Defines all hooks for the admin area.
	 * - Mod_Core_Public. Defines all hooks for the public side of the site.
	 * - Mod_Core_Helper. Defines all helper fn for the public side of the site.
	 * - Mod_Core_Security. Defines all security hooks for the public side of the site.
	 * - Mod_Core_Meta. Defines all metadata hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.2.9
	 * @access   private
	 */
	private function set_dependencies() {

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once MOD_CORE_DIR . 'admin/class-mod-core-admin.php';
		
		/**
		 * The class responsible for providing the helperfunctions for the plugin.
		*/
		require_once MOD_CORE_DIR . 'admin/class-mod-core-options.php';
		
		/**
		 * The class responsible for providing the helperfunctions for the plugin.
		 */
		require_once MOD_CORE_DIR . 'inc/class-mod-core-helper.php';
		
		/**
		 * The class responsible for providing the helperfunctions for the plugin.
		 */
		require_once MOD_CORE_DIR . 'inc/class-mod-core-meta.php';
		
		/**
		 * The class responsible for providing the helperfunctions for the plugin.
		 */
		require_once MOD_CORE_DIR . 'inc/class-mod-core-security.php';
		
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once MOD_CORE_DIR . 'inc/class-mod-core-loader.php';
		
		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once MOD_CORE_DIR . 'inc/class-mod-core-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once MOD_CORE_DIR . 'public/class-mod-core-public.php';

		//load fn
		$this->loader = new Mod_Core_Loader();
		
	}

	/**
	 * Define the $options for this plugin.
	 *
	 * $options.
	 *
	 * @since    1.2.9
	 * @access   private
	 */
	private function set_options( $options ) {
		
		$options_default = array(
			'key'=>'value'
		);
		
		$opt = array_merge( $options_default, $options );

		$this->$options = $opt;
		
		return $this->$options;

	}

	
	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mod_Core_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.2.9
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Mod_Core_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}
	
	
	/**
	 * Define the helper for this plugin.
	 * @since    1.2.9
	 * @access   private
	 */
	private function set_helper() {
		
		$this->helper = new Mod_Core_Helper( $this->get_Mod_Core(), $this->get_version() );
		
	}
	
	
	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mod_Core_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.2.9
	 * @access   private
	 */
	private function set_security() {
		
		$this->security = new Mod_Core_Security( $this->get_Mod_Core(), $this->get_version() );
		
	}
	

/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.2.9
	 * @access   private
	 */
	private function set_admin_hooks() {

		$plugin_admin = new Mod_Core_Admin( $this->get_Mod_Core(), $this->get_version() );
		
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		//nix_hooks
		$this->loader->add_action( 'init', $plugin_admin, 'nix_hooks' );
		
		//nix_filters
		$this->loader->add_action( 'init', $plugin_admin, 'nix_filters' );
		
		//add_hooks
		$this->loader->add_action( 'init', $plugin_admin, 'add_hooks' );

		//add_filters
		$this->loader->add_action( 'init', $plugin_admin, 'add_filters' );
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.2.9
	 * @access   private
	 */
	private function set_public_hooks() {

		$plugin_public = new Mod_Core_Public( $this->get_Mod_Core(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'wp_dequeue_scripts', $plugin_public, 'deenqueue_styles' );
		$this->loader->add_action( 'wp_dequeue_scripts', $plugin_public, 'deenqueue_scripts' );
		
		//nix_hooks
		$this->loader->add_action( 'init', $plugin_public, 'nix_hooks' );
		
		//nix_filters
		$this->loader->add_action( 'init', $plugin_public, 'nix_filters' );
		
		//add_hooks
		$this->loader->add_action( 'init', $plugin_public, 'add_hooks' );

		//add_filters
		$this->loader->add_action( 'init', $plugin_public, 'add_filters' );
		
	}

	
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.2.9
	 */
	public function run() {
	
		$this->loader->run();
	
	}

	
	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.2.9
	 * @return    string    The name of the plugin.
	 */
	
	public function get_Mod_Core() {
	
		return $this->Mod_Core;
	
	}

	
	/**
	 * The reference to the class that orchestrates the hooks of the plugin.
	 *
	 * @since     1.2.9
	 * @return    Mod_Core_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
	
		return $this->loader;
	
	}
	
	
	/**
	 * Retrieve the options of the plugin.
	 *
	 * @since     1.2.9
	 * @return    string    The options for the plugin.
	 */
	public function get_options() {
	
		return $this->options;
	
	}
	
	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.2.9
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
	
		return $this->version;
	
	}

	
	/**
	 * Retrieve the helper class.
	 *
	 * @since     1.2.9
	 * @return    Mod_Core_Helper    The helper class for the plugin.
	 */
	public function get_helper() {

		return $this->helper;
	
	}
	
	
	/**
	 * Retrieve the security class.
	 *
	 * @since     1.2.9
	 * @return    Mod_Core_Security    Orchestrates the security hooks of the plugin.
	 */
	public function get_security() {
	
		return $this->security;
	
	}
	
}
