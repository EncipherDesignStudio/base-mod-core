<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mod_Core
 * @subpackage Mod_Core/public
 * @author     Encipher Design Studio
*/
class Mod_Core_Public extends Mod_Core {

	
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
	 * @param    string    $Mod_Core   The name of the plugin.
	 * @param    string    $version    The version of this plugin.
	*/
	public function __construct( $Mod_Core, $version ) {

		$this->Mod_Core = $Mod_Core;
		$this->version = $version;

	}

	
	/**
	 * Register front-end stylesheets.
	 *
	 * @since    1.2.9
	*/
	public function enqueue_styles() {
		
		
	}

	
	/**
	 * Deregister front-end stylesheets.
	 * 
	 * @since    1.2.9
	*/
	public function deenqueue_styles() {
				
		//Disable Dashicons on Front-end
		add_action( 'wp_dequeue_style', array( 'Mod_Core_Helper', 'dequeue_dashicon' ) );
		
		//dequeue gutenberg stuff
		add_action( 'wp_dequeue_style', array( 'Mod_Core_Helper', 'dequeue_block_lib' ) );

		//dequeue unnecessary styles
		add_action( 'wp_dequeue_style', array( 'Mod_Core_Helper', 'nix_styles' ) );

		//deregister unnecessary styles
		add_action('wp_deregister_style', array( 'Mod_Core_Helper', 'nix_styles' ) );
		
	}
	
	
	/**
	 * Register public-facing javascript.
	 *
	 * @since    1.2.9
	*/
	public function enqueue_scripts() {


	}


	/**
	 * Dequeue public-facing javascript.
	 *
	 * @since    1.2.9
	*/
	public function deenqueue_scripts() {
		
		
	}
	
	
	/**
	 * Removes specified hooks.
	 * 
	 * TODO connect with admin options 
	*/
	public function nix_hooks(){

		remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
		
		// remove gb nag
		remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );
		
		// Display the links to the general feeds: Post and Comment Feed
		remove_action( 'wp_head', 'feed_links', 2 ); 
		
		// Display the links to the extra feeds such as category feeds
		remove_action( 'wp_head', 'feed_links_extra', 3 );

		// Display the link to the Really Simple Discovery service endpoint, EditURI link
		remove_action( 'wp_head', 'rsd_link' ); 
		
		// Display the link to the Windows Live Writer manifest file.
		remove_action( 'wp_head', 'wlwmanifest_link' ); 

		// index link
		remove_action( 'wp_head', 'index_rel_link' ); 

		// prev link
		remove_action( 'wp_head', 'parent_post_rel_link', 10 ); 

		// start link
		remove_action( 'wp_head', 'start_post_rel_link', 10 ); 
		
		// Display relational links for the posts adjacent to the current post.
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 ); 
		
		// Display the XHTML generator that is generated on the wp_head hook, WP version
		remove_action( 'wp_head', 'wp_generator' );

		// remove WP dns-prefetch nonsense
		remove_action( 'wp_head', 'wp_resource_hints', 2 );

		// Disable REST API link tag
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
		remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
		
		// Disable REST API link in HTTP headers
		remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );

		// remove WP 4.2+ emoji nonsense
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		add_filter( 'emoji_svg_url', array( 'Mod_Core_Helper', 'set_falsify' ) );
		
		//Remove Shortlink
		remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
		
		//Disable XML-RPC
		add_filter( 'xmlrpc_enabled', array( 'Mod_Core_Helper', 'set_falsify' ) );
		
		// Disable oEmbed Discovery Links
		// Remove the oEmbed REST API endpoint.
		remove_action( 'rest_api_init', 'wp_oembed_register_route' );
		
		// Turn off oEmbed auto discovery. Don't filter oEmbed results.
		add_filter( 'embed_oembed_discover', array( 'Mod_Core_Helper', 'set_falsify' ) );
		
		// Remove oEmbed discovery links.
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
		
		// Remove oEmbed-specific JavaScript from the front-end and back-end.
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	
	}

	
	/**
	 * removes specific filters.
 	*/	
	public function nix_filters(){

		//no clickable links in comments
		remove_filter( 'comment_text', 'make_clickable', 9 );
		
		//remove numbnut wp capitalization
		remove_filter( 'the_title', 'capital_P_dangit', 11 );
		remove_filter( 'the_content', 'capital_P_dangit', 11 );
		remove_filter( 'comment_text', 'capital_P_dangit', 31 );

	}
	
	
	public function add_hooks(){
		
		//hide author/page fishing
		add_action( 'request', array( 'Mod_Core_Security', 'nix_url_scrape' ), 999, 2 );

		//security headers
		add_action( 'send_headers', array( 'Mod_Core_Security', 'set_security_headers' ), 1 );
		
		//heartbeat
		add_action( 'init', array( 'Mod_Core_Helper', 'nix_heartbeat' ), 1 );

		//pingback
		add_action( 'pre_ping', array( 'Mod_Core_Helper', 'nix_pingback' ) );
		
		//redirect for specific archives
		add_action('template_redirect', array( 'Mod_Core_Helper', 'nix_archives' ) );
				
	}
	
	
	public function add_filters(){

		//comments
		add_filter( 'comment_reply_link', array( 'Mod_Core_Helper', 'set_comment_link' ) );
		add_action( 'comment_reply_redirect', array( 'Mod_Core_Helper', 'set_comment_reply_redirect' ) );
		
		//remove pings
		add_filter( 'pings_open', array( 'Mod_Core_Helper', 'set_falsify' ) );
		
		//version exposure
		add_filter( 'script_loader_src', array( 'Mod_Core_Security', 'set_nix_versioning' ), 999, 1 );
		add_filter( 'style_loader_src', array( 'Mod_Core_Security', 'set_nix_versioning' ), 999, 1 );

		//version exposure || custom generator
		add_filter('the_generator', array( 'Mod_Core_Helper', 'set_empty' ) );

		 //Hide the Admin Bar
		add_filter( 'show_admin_bar', array( 'Mod_Core_Helper', 'set_falsify' ) );
		
	}
	
}