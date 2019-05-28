<?php
/**
 * admin ui helper
 * frontend ui helper
 * theme opt helper
 * widget helper
 * 
//get the base class
if( !class_exists('MainClass') ) {
    require_once MOD_CORE_DIR . '/_inc/MainClass.php';
}
class AddonClass extends MainClass{}
 * 
 */

/**
 * Fired during plugin use.
 *
 * This class defines all functions necessary to run during the plugin's activation.
 *
 * @since      1.2.9
 * @package    Mod_Core
 * @subpackage Mod_Core/inc
 * @author     Encipher Design Studio
 */

class Mod_Core_Helper extends Mod_Core {

	
	/**
	 * The plugin ID.
	 *
	 * @since    1.2.9
	 * @access   private
	 * @var      string    $Mod_Core    The ID of this plugin.
	 */
	protected $Mod_Core;
	
	
	/**
	 * The plugin version.
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

	
	/*
	 ________________________________________________________________________________________________________________________
	 
	 ADMIN FUNCTIONS
	 ________________________________________________________________________________________________________________________

	 */

	
	/*
	 ________________________________________________________________________________________________________________________
	 
	 SIMPLE VALUES
	 ________________________________________________________________________________________________________________________
	 
	*/
	
	/**
	 * Return an empty string.
	 *
	 * @since    1.2.9
	 * 
	 * @return string
	 */
	public static function set_empty() {
		
		return '';
		
	}
	
	
	/**
	 * Return an empty array.
	 *
	 * @since    1.2.9
	 *
	 * @return array
	 */
	public static function set_empty_array() {
		
		return array();
		
	}
	
	
	/**
	 * Return null.
	 *
	 * @since    1.2.9
	 * @return null
	 */
	public static function set_nullify() {
		
		return null;
		
	}
	
	
	/**
	 * Return false.
	 *
	 * @since    1.2.9
	 * @return boolean
	 */
	public static function set_falsify() {
		
		return false;
		
	}
	
	
	/*
	 ________________________________________________________________________________________________________________________
	 
	 NUMBERS
	 ________________________________________________________________________________________________________________________

	*/

	 
	 /**
	 * Return random number.
	 * Defaults to 3-digit value between 100 - 999.
	 *
	 * @since    1.2.9
	 * @return 	number
	 */
	public static function get_random_num( $from = 100, $to = 999 ) {
		
		$random = rand( $from, $to );
	 	
		return $random;

	}

	 
	 /**
	  * Return whether integer is an odd number.
		 //Is a number ODD? Y/N
	  *
	  * @since    1.2.9
	  * @return 	boolean
	  */
	 public static function is_num_odd( $int ) {
	 	
		return( $int & 1 );
		 
	 }


	 /**
	 * Remove archives.
	 *
	 * On access of archive pages [category, tag, date, author] archive set to 404 page not found.
	 *
	 * @since    1.2.9
	 */
	
	public static function nix_archives() {
		
		if( is_date() || is_author() ) {//|| is_tag()is_category() || 
			
			global $wp_query;
			$wp_query->set_404();
			
		}
		
	}
	
	
	/**
	 * 404 error.
	 *
	 * On access of archive pages [category, tag, date, author] archive set to 404 page not found.
	 *
	 * @since    1.2.9
	 */
	
	public static function set_404() {
		
		global $wp_query;
		$template = null;
		
		status_header( '404' );
		
		if ( isset( $wp_query ) && is_object( $wp_query ) ) {
			
			$wp_query->set_404();
			
		}
		
		if ( function_exists( 'get_404_template' ) ) {
			
			$template = get_404_template();
		
		}
		
		if ( $template && @file_exists( $template ) ) {
		
			include( $template );
			exit;
		
		}
		
	}
	
	
	
	/**
	 * Remove replytocom
	 */
	public function set_comment_link( $link ) {
		
		return preg_replace( '`href=(["\'])(?:.*(?:\?|&|&#038;)replytocom=(\d+)#respond)`', 'href=$1#comment-$2', $link );
		
	}
	
	
	/**
	 * Remove replytocom
	 */
	public function set_comment_reply_redirect() {
		
		global $post;
		
		if( ! empty( $post ) && isset( $_GET['replytocom'] ) && is_singular() ) {
		
			$post_url = get_permalink( $post->id );
			$comment_id = sanitize_text_field( $_GET['replytocom'] );
			$query_string = remove_query_arg( 'replytocom', sanitize_text_field( $_SERVER['QUERY_STRING'] ) );
			
			if( ! empty( $query_string ) ) {
			
				$post_url .= '?' . $query_string;
			
			}
			
			$post_url .= '#comment-' . $comment_id;
			
			wp_safe_redirect( $post_url, 301 );
			die();
		
		}
		
		return false;
		
	}
	
	
	
	/**
	 * Redirect archives.
	 *
	 * On access of archive pages [category, tag, date, author] archive redirect to home
	 * less secure, exposes WP
	 * 
	 * @since    1.2.9
	 */
	public static function set_archive_redirect() {
		
		if ( is_category() || is_date() || is_author() ) {//|| is_tag() 
		
			wp_safe_redirect( home_url() );
		
		}
		
	}
	
	
	/**
	 * Escape json data
	 * @param  array $data
	 * @return string escaped json string
	 */
	public static function get_escaped_json( array $data ) {
		
		return htmlspecialchars( json_encode( $data ), ENT_QUOTES, 'UTF-8' );
		
	}
		
	
	/**
	 * 
	 * Disable Dashicons on Front-end.
	 *
	 * @since    1.2.9
	*/
	public static function dequeue_dashicon() {
		
		wp_deregister_style('dashicons');
		wp_dequeue_style('dashicons');
		
	}
	
	
	/**
	* Disable Gutenberg Styles on Front-end.
	*
	* @since    1.2.9
	*/
	public static function dequeue_block_lib() {

		//NIX
		wp_dequeue_style( 'dashicons' );
		wp_deregister_style( 'dashicons' );
		
		wp_dequeue_style( 'animate-css' );
		wp_deregister_style( 'animate-css' );
		
		//woo storefront
		wp_dequeue_style( 'storefront-style' );
		wp_deregister_style( 'storefront-style' );
		wp_dequeue_style( 'storefront-style-inline-css' );
		wp_deregister_style( 'storefront-style-inline-css' );
		wp_dequeue_style( 'storefront-fonts' );
		wp_deregister_style( 'storefront-fonts' );
		wp_dequeue_style( 'storefront-fonts' );
		wp_deregister_style( 'storefront-fonts' );
		wp_dequeue_style( 'storefront-icons-css' );
		wp_deregister_style( 'storefront-icons-css' );
		wp_dequeue_style( 'storefront-gutenberg-blocks' );
		wp_deregister_style( 'storefront-gutenberg-blocks' );
		wp_dequeue_style( 'storefront-icons' );
		wp_deregister_style( 'storefront-icons' );
		wp_dequeue_style( 'storefront-fonts-css' );
		wp_deregister_style( 'storefront-fonts-css' );
		wp_dequeue_style( 'storefront-style-css' );
		wp_deregister_style( 'storefront-style-css' );
		
		wp_dequeue_style( 'wp-editor-css' );
		wp_deregister_style( 'wp-editor-css' );
		wp_dequeue_style( 'wp-editor-font-css' );
		wp_deregister_style( 'wp-editor-font-css' );
		
		wp_dequeue_style( 'wp-components-css' );
		wp_deregister_style( 'wp-components-css' );
		
		//wp-block-library
		wp_deregister_style( 'wp-block-library-css' );
		wp_dequeue_style( 'wp-block-library-css' );
		
		//wp-block-library
		//wp_deregister_style( 'wp-block-library' );
		//wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_deregister_style( 'wp-block-library-theme' );

		wp_dequeue_style( 'wp-nux-css' );
		wp_deregister_style( 'wp-nux-css' );
		
		wp_deregister_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'wp-block-library-theme' );

	}
	
	
	/**
	 * Disable all Styles on Front-end.
	 *
	 * @since    1.2.9
	 */
	static function nix_styles() {
		
		// get all styles data
		global $wp_styles;

		// create an array of stylesheet "handles" to allow to remain
		$styles_to_keep = array( 'bpthm' );
		
		// loop over all of the registered scripts
		foreach ( $wp_styles->registered as $handle => $data ) {
			
			// if we want to keep it, skip it
			if ( in_array( $handle, $styles_to_keep ) ) continue;
			
				// otherwise remove it
				wp_deregister_style( $handle );
				wp_dequeue_style( $handle );
			
		}
		
	}	

	
	
	/**
	 Disable Self Pingback.
	 *
	 * @since    1.2.9
	 */
	public static function nix_pingback( &$links ) {
		
		foreach ( $links as $l => $link )
		
			if ( 0 === strpos( $link, get_option( 'home' ) ) )
			
				unset( $links[$l] );
	
	}

	
	/**
	 Disable Heartbeat.
	 *
	 * @since    1.2.9
	 */
	public static function nix_heartbeat() {
	
		if ( ! empty( $_SERVER['QUERY_STRING'] ) ) :
		
			$current_url = $_SERVER['REQUEST_URI'] . '?' . $_SERVER['QUERY_STRING'];
		
		else :
		
			$current_url = $_SERVER['REQUEST_URI'];
		
		endif;
		
		$current_screen = wp_parse_url( $current_url );
		
		if ( ! is_admin() || '/wp-admin/post.php' !== $current_screen )
			
			wp_deregister_script('heartbeat');

	}

	
	/**
	 Disable jq migrate.
	 */
	public static function nix_jq( &$scripts ) {
		
		if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
		
			remove_action( 'wp_head', 'wp_print_scripts' );
			remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
			remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
		
		}

		$jquery_dependencies = $scripts->registered['jquery']->deps;
		$scripts->registered['jquery']->deps = array_diff( $jquery_dependencies, array( 'jquery-migrate' ) );
		
		add_action( 'wp_footer', 'wp_print_scripts', 5 );
		
		wp_deregister_script( 'jquery');
		wp_register_script( 'jquery', ( 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js' ), false, '', true );
		
		wp_enqueue_script( 'jquery' );

	}

	
	/**
	 * Attachment pages redirect
	*/
	public function set_attachment_redirect() {
		
		global $post;
		
		if ( is_attachment() ) :
		
			if( isset( $post->post_parent ) && ( $post->post_parent != 0 ) ) :
			
				wp_safe_redirect( get_permalink( $post->post_parent ), 301 );
			
			else :
				
				wp_safe_redirect( home_url(), 301 );
			
			endif;
			
			exit;

		endif;
	
	}
					
}