<?php
/**
 * Provides admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 * 
 * TODO add mod options form
 *
 * @link       https://encipherdesign.com/
 * @since      1.2.9
 *
 * @package    Mod_Core
 * @subpackage Mod_Core/admin/display
*/

?>
<section class="txt">
	<h2 class="title-section">Core Mods</h2>
	<p>When activated, this plugin implements several security methods, and enhances content.</p>
	<ul class="list bullet">
		<li><strong>Security:</strong> 
			Obsfucate or remove several elements to help mitigate potential exploits in the standard installation.
			<ul class="list bullet">
				<li>Add headers for Strict-Transport-Security, X-Content-Type-Options, X-XSS-Protection, Referrer-Policy, X-Frame-Options and Content-Security-Policy.</li>
				<li>Remove headers for X-Powered-By and Generator.</li>
				<li>Remove version query string from urls.</li>
			</ul>
		</li>
		<li><strong>SEO Metadata:</strong>
			Enhance rankings by including additional metadata used by search engines
			<ul class="list bullet">
				<li>Add optional metadata input fields for each page/post.</li>
				<li>Utilize default metadata settings when page/post description is unavailable.</li>
			</ul>
		</li>
		<li><strong>Settings: </strong>
			Modify allowed upload content/media, and manage additional site options. 
			<ul class="list bullet">
				<li>Add upload capabilities for svg images and json files. Mime-type handling should be appropriately set server-side.</li>
				<li>Remove upload capabilities for Excel files.</li>
				<li>Add Media setting for a default image when featured image is not present.</li>
				<li>Add General setting for a default site description metadata. The page/post title is prepended as to not adversely impact search engine rankings.</li>
				<li>Add General setting for Social Media accounts to further integrate custom service metadata.</li>
			</ul>
		</li>
	</ul>
</section>