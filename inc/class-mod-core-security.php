<?php
/**
 * Security related fn.
 *
 * @author     Encipher Design Studio
 * @since      1.2.9
 * @package    Mod_Core
 * @subpackage Mod_Core/inc
*/

class Mod_Core_Security extends Mod_Core {

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

	/*
	 ________________________________________________________________________________________________________________________
	 
	 SECURITY
	 ________________________________________________________________________________________________________________________
	 
	*/

	/**
	
		Implementation of Blackhole.
		
		https://perishablepress.com/blackhole-bad-bots/
	
	*/
	public static function set_crush() {
		
		echo '<a rel="nofollow" class="hide crush" href="' . MOD_CORE_DOMAIN . '' . wp_slash( MOD_CORE_BADBOTS_DIR ) . '" title="Do NOT follow this link.">Do NOT follow this link. You will fall into the internet blackhole, BANNED from this site.</a>';
		require_once( realpath( getenv( 'DOCUMENT_ROOT' ) ) . '' . wp_slash( MOD_CORE_BADBOTS_DIR ) . 'index.php' );
		
	}
	
	public static function set_crush_link() {
		
		echo '<a rel="nofollow" class="hide crush" href="' . MOD_CORE_DOMAIN . '' . wp_slash( MOD_CORE_BADBOTS_DIR ) . '" title="Do NOT follow this link.">Do NOT follow this link. You will fall into the internet blackhole, BANNED from this site.</a>';
		
	}
	
	//https://www.tipsandtricks-hq.com/introduction-to-wordpress-nonces-5357
	public static function set_nonce() {
		
		$nonce_len = 16;
		return base64_encode( random_bytes( $nonce_len ) );
	
	}

	
	public static function set_sha( $sha = 512 ) {
		
		//$nonce_len = 16;512 = 64; 256 = 44;
		//if (! $sha ) $sha = 256;
		$sha_len = ( $sha === 512 ) ? 64 : 44;
		
		$bytes = openssl_random_pseudo_bytes( $sha_len );
		
		if ( ! is_admin() && ! is_customize_preview() ) ://! current_user_can( 'manage_options' ) 
	
			if ( $sha === 512 ) :
			
				//do
				$hash = "'sha512-" . base64_encode( $bytes ) . "' 'self' data: https:";				

			else :
			
				$hash = "'sha256-" . base64_encode( $bytes ) . "' 'self' data: https:";
			
			endif;
			
		else :
			
			//don't
			$hash = "'self' 'unsafe-inline' data: https:";
			
		endif;
		
		return $hash;//base64_encode( random_bytes( $sha_len ) )
		
	}
	
	
	/**
	*	Set allowed font-src.
	* 
	* @param array $domain
	* @return void|string
	*/
	public static function set_font_src( $domain = ['https:','\'self\'','https://fonts.googleapis.com','https://fonts.gstatic.com'] ) {//

		$str = '';

		//validate urls
		if ( empty( $domain ) ) :
		
			return;
		
		elseif ( is_array( $domain ) ) :
		
			$str = ' font-src ' . implode( ' ', $domain ) . '; ';
		
		elseif ( is_string( $domain ) ):
		
			$str = ' font-src ' . $domain . '; ';
		
		endif;
		
		return $str;
		
	}
	
	
	/**
	 *  set security headers.
	 *
	 *  set/remove headers for improve security.
	 *
	 * @since    1.2.9
	 * @return {string} $src
	 * @filter script_loader_src
	 * @filter style_loader_src
	*/
	public static function set_security_headers(){

		if ( headers_sent() ) :
		
			return; //<sadness>
		
		endif;
		
		//powered by php/asp,etc
		//if ( opt->header-x-power !== '' ) : header( 'x-powered-by', 'Unicorn Magic' ) endif;
		header_remove( 'x-powered-by' );
		//X-AspNet-Version
		header_remove( 'X-AspNet-Version' );
		//X-AspNetMvc-Version
		header_remove( 'X-AspNetMvc-Version' );
		//X-Pingback
		header_remove( 'X-Pingback' );
		//X-CF-Powered-By
		header_remove( 'X-CF-Powered-By' );
		//X-Mod-Pagespeed
		header_remove( 'X-Mod-Pagespeed' );
		//server
		//if ( opt->header-server !== '' ) : header( 'server', 'Unicorn Magic' ) endif;
		header( 'Server: Unicorn Magic' );
		//header_remove( 'Server' );
		
		//wordpress generator
		//if ( opt->header-generator !== '' ) : endif;
		header( 'generator', 'Unicorn Magic' );
		remove_action( 'wp_head' , 'wp_generator' );
		
		//permit pdf/flash access [crossdomain.xml]
		header( 'X-Permitted-Cross-Domain-Policies: none' );
		
		//ADD
		//X-CSRF-Token target origin == source origin
		//verify: Source Origin via Origin Header == Referer Header
		
		//iframes clickjacking
		header( 'X-Frame-Options: SAMEORIGIN' );
		//header( 'X-Frame-Options: DENY' );
		//header( 'X-Frame-Options: ALLOW-FROM ' . domain );
		
		//referrer policy
		//no referrer info sent to other sites
		//also use  rel="noreferrer" on <a> and <link> tags
		header( 'Referrer-Policy: no-referrer' );
		//only ssl referrers allowed to other sites
		//header( 'Referrer-Policy: strict-origin-when-cross-origin');
		
		//block xxs
		header( 'X-XSS-Protection: 1; mode=block' );
		
		//mimetype browser sniffing
		header( 'X-Content-Type-Options: nosniff' );
		
		//no prefetching
		header( 'X-DNS-Prefetch-Control: off' );
		
		//https:: header( 'Strict-Transport-Security: max-age=' . time . ' includeSubDomains;'  [optional:: . ' preload'] );
		header( 'Strict-Transport-Security: max-age=31536000 includeSubDomains; ' );//preload
		
		/**

		Content-Security-Policy.
		
		Unfortunately wp doesn't play well [at all] with this opt.
		wp & most plugins use inline css & js
		resolve: mod wp core, mod plugins 
		
		//content policy: ssl only
			//https://www.keycdn.com/support/content-security-policy/
			//header( "Content-Security-Policy: default-src https:; script-src https: 'unsafe-inline'; style-src https: 'unsafe-inline'" );
			
		//or lockdown to only allow from specific domains: domainlist: spc delimited https://<domainname>
			//header( "Content-Security-Policy: default-src 'none'; script-src ". domain . "; style-src ". domainlist . "; img-src ". domainlist . "; connect-src ". domainlist . "; child-src 'self'" );
		
		//add -Report-Only as Content-Security-Policy-Report-Only for testing mode
				//G0CufoWPLTm5OhVU1OioVsF0ge/f2hWhXLJHu3QH0bQ=
				//sha256-B9zEjrTwSA8f9t+ymcEiaDkiL/BqFb8ot66/TSoNA68=
				//set_nonce();
				//$nonce = base64_encode( random_bytes( $nonce_len) );
			//https://www.cspisawesome.com/content_security_policies'sha512-" . $hash . "' 
		
			build_policy( ass arr of directives ){
				self::set_sha()
				if x directive in array : 
				self::set_x_src( array or str ){
					creates each valid '{{directive}} {{src}}; '
				}
				concat as policy && return
			}
		 
		 EX ::
			 //all opt
			 Content-Security-Policy: script-src 'self' cdn.trustedorigin.net; img-src *;
			 
			 https: :: ssl only
			 *.<a-specific-domain.net> :: specified domains & any subdomain
			 
			 //only allow from specific domainlist or script: spc delimited https://<domainname>
			 'https://<domain> || https://<domain>/<scriptpath>.js'
			 
			 // single quoted val opt::
			 // only self hosted assets
			 'self'
		*/
		if ( ! is_admin() && ! is_customize_preview() ) :
		
			//header( 'Content-Security-Policy: default-src ' . self::set_sha() . ' ;' . self::set_font_src() );
			//script-src nonce-" . $nonce . " https:; object-src nonce-" . $nonce . "https:; style-src nonce-" . $nonce . " https:; img-src nonce-" . $nonce . " data: https:; media-src nonce-" . $nonce . "https:; frame-src nonce-" . $nonce . "https:; font-src nonce-" . $nonce . " data: https:; connect-src nonce-" . $nonce . " https:" );
			//header( "X-Content-Security-Policy: default-src 'self' https:; script-src data: 'unsafe-inline' https:; object-src https:; style-src data: 'unsafe-inline' https:; img-src 'self' data: https:; media-src https:; frame-src https:; font-src 'self' https:; connect-src https:" );
			//header( "X-WebKit-CSP: default-src 'self' https:; script-src data: 'unsafe-inline' https:; object-src https:; style-src data: 'unsafe-inline' https:; img-src 'self' data: https:; media-src https:; frame-src https:; font-src 'self' https:; connect-src https:" );
		
		endif;

	}
		
	
	/**
		
		Protect from Author and Page Scraping.
		
		Advised to change admin user id from 1 as well as admin username
		
	*/
	public static function nix_url_scrape( $vars ) {

		//$vars->query_vars
		$var_arr = ['author','author_name','p'];//,'category_name','cat'
		
		if ( 
			! is_admin() 
			&& is_object( $vars ) 
			&& is_array( $vars->query_vars ) 
		) : 
			
			// removing multiple keys
			foreach ( $var_arr as $key )
				unset( $vars->query_vars[$key] );
				//unset( $vars->public_query_vars[$key] );
				
				// if the query is for a category
				if ( isset( $vars->query_vars['category_name'] ) ) :
				
					// save the slug
					$pagename = $vars->query_vars['category_name'];
					
					// completely replace the query with a page query
					$vars->query_vars['pagename'] = $pagename;
					$vars->query_vars['category_name'] = '';
					
				endif;
				
		elseif ( 
			! is_admin()
			&& is_array( $vars ) 
		) :

			if ( isset( $vars['category_name'] ) ) :
			
				// save the slug
				$pagename = $vars['category_name'];
				
				// completely replace the query with a page query
				$vars['pagename'] = $pagename;
				//$vars['category_name'] = '';
				
			endif;
				
		endif;
		
		foreach ( $var_arr as $key ) :
	
			unset( $vars[$key] );
	
		endforeach;

		return $vars;

	}

		
	/**
	 *  Hide version strings.
	 *
	 *  Hide WP version strings from scripts and styles.
	 *
	 * @since    1.2.9
	 * @return {string} $src
	 * @filter script_loader_src
	 * @filter style_loader_src
	*/
	public static function set_nix_versioning( $src ) {
		
		global $query;
		
		parse_str( parse_url( $src, PHP_URL_QUERY ), $query );
		
		if ( ! empty( $query['ver'] ) ) :
		
			$src = remove_query_arg( 'ver', $src );

		endif;

		return $src;
	
	}
	
	
	/**
	
	//TODO
	
	public static set_csp_rules( $policy_arr = [ '<type>' => ['<src>',''], ... ] ){

		//commonly supported directives
		$csp_directives = ['base-uri','block-all-mixed-content','child-src','connect-src','default-src','font-src','form-action','frame-ancestors','frame-src','img-src','manifest-src','media-src','object-src','plugin-types','referrer','report-uri','require-sri-for','sandbox','script-src','style-src','upgrade-insecure-requests','worker-src','report-to'];
		$csp_options 	= ['self','none','report-sample'];
		
		//warn for not recommended:: ,'unsafe-inline','unsafe-eval'
		//no quotes: strict-dynamic, data:, https:
		//add mediastream: once standard

		$csp = '';
		
		if ( is_array( $policy_arr ) ) :
		
			foreach( $policy as $directive => $sources ) :
			
				if ( in_array( $policy, $csp_directives ) && ! empty( $sources ) ) :
				
					$csp .= $directive . ' ';
					
					if ( is_array( $sources ) ) :
					
						//loop-validate $sources
						foreach( $type as $directive => $sources ) :
						
							if ( is_string( $src ) ) :
							
								if valid :
								
									//add src
									//https: vs https://<valid-url>
									//needs missing quotes ? :: self, none, report-sample, unsafe-inline, unsafe-eval
									
									$csp .= $src;
							
							else 
							
								throw exceptional err
							
							endif;
						
						endforeach;
					
					elseif ( is_string() ) :
					
						if validate_src_string( ) :
						
							$csp .= src_string;
						
						else :
						
							warn err;
						
						endif;
					
					endif;
				
					$csp .= '; ';
				
				endif;
			
			endforeach;
		
		elseif ?  is_string && %directives% && %options% in string
		
			if validate_src_str() : 
			
				$csp .= $policy;
			
			else :
			
				//warn possible exceptional syntax err
			
			endif;
	
		endif;
	
	}
	
	public static validate_src_string( ){
	
		//if str contains spc? explode-loop or find directive, split at semicolon loop remainder = validate_src() to explode spc add $policy . semi-colon,
		//combine directives directive-to-semicolon as policy rule,
		//if valid directive-src true else false or only valid policy
	
	}
	
	*/

}