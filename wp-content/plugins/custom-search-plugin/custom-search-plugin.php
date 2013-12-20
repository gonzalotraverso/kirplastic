<?php
/*
Plugin Name: Custom Search
Plugin URI: http://bestwebsoft.com/plugin/
Description: Custom Search Plugin designed to search for site custom types.
Author: BestWebSoft
Version: 1.13
Author URI: http://bestwebsoft.com/
License: GPLv2 or later
*/
 
/*  © Copyright 2011  BestWebSoft  ( http://support.bestwebsoft.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! function_exists( 'bws_add_menu_render' ) ) {
	function bws_add_menu_render() {
		global $wpdb, $wp_version, $title;
		$active_plugins = get_option('active_plugins');
		$all_plugins = get_plugins();
		$error = '';
		$message = '';
		$bwsmn_form_email = '';

		$array_activate = array();
		$array_install	= array();
		$array_recomend = array();
		$count_activate = $count_install = $count_recomend = 0;
		$array_plugins	= array(
			array( 'captcha\/captcha.php', 'Captcha', 'http://bestwebsoft.com/plugin/captcha-plugin/', 'http://bestwebsoft.com/plugin/captcha-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Captcha+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=captcha.php' ), 
			array( 'contact-form-plugin\/contact_form.php', 'Contact Form', 'http://bestwebsoft.com/plugin/contact-form/', 'http://bestwebsoft.com/plugin/contact-form/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Contact+Form+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=contact_form.php' ), 
			array( 'facebook-button-plugin\/facebook-button-plugin.php', 'Facebook Like Button Plugin', 'http://bestwebsoft.com/plugin/facebook-like-button-plugin/', 'http://bestwebsoft.com/plugin/facebook-like-button-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Facebook+Like+Button+Plugin+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=facebook-button-plugin.php' ), 
			array( 'twitter-plugin\/twitter.php', 'Twitter Plugin', 'http://bestwebsoft.com/plugin/twitter-plugin/', 'http://bestwebsoft.com/plugin/twitter-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Twitter+Plugin+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=twitter.php' ), 
			array( 'portfolio\/portfolio.php', 'Portfolio', 'http://bestwebsoft.com/plugin/portfolio-plugin/', 'http://bestwebsoft.com/plugin/portfolio-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Portfolio+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=portfolio.php' ),
			array( 'gallery-plugin\/gallery-plugin.php', 'Gallery', 'http://bestwebsoft.com/plugin/gallery-plugin/', 'http://bestwebsoft.com/plugin/gallery-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Gallery+Plugin+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=gallery-plugin.php' ),
			array( 'adsense-plugin\/adsense-plugin.php', 'Google AdSense Plugin', 'http://bestwebsoft.com/plugin/google-adsense-plugin/', 'http://bestwebsoft.com/plugin/google-adsense-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Adsense+Plugin+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=adsense-plugin.php' ),
			array( 'custom-search-plugin\/custom-search-plugin.php', 'Custom Search Plugin', 'http://bestwebsoft.com/plugin/custom-search-plugin/', 'http://bestwebsoft.com/plugin/custom-search-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Custom+Search+plugin+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=custom_search.php' ),
			array( 'quotes-and-tips\/quotes-and-tips.php', 'Quotes and Tips', 'http://bestwebsoft.com/plugin/quotes-and-tips/', 'http://bestwebsoft.com/plugin/quotes-and-tips/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Quotes+and+Tips+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=quotes-and-tips.php' ),
			array( 'google-sitemap-plugin\/google-sitemap-plugin.php', 'Google sitemap plugin', 'http://bestwebsoft.com/plugin/google-sitemap-plugin/', 'http://bestwebsoft.com/plugin/google-sitemap-plugin/#download', '/wp-admin/plugin-install.php?tab=search&type=term&s=Google+sitemap+plugin+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=google-sitemap-plugin.php' ),
			array( 'updater\/updater.php', 'Updater', 'http://bestwebsoft.com/plugin/updater-plugin/', 'http://bestwebsoft.com/plugin/updater-plugin/#download', '/wp-admin/plugin-install.php?tab=search&s=updater+bestwebsoft&plugin-search-input=Search+Plugins', 'admin.php?page=updater-options' )
		);
		foreach ( $array_plugins as $plugins ) {
			if( 0 < count( preg_grep( "/".$plugins[0]."/", $active_plugins ) ) ) {
				$array_activate[$count_activate]["title"] = $plugins[1];
				$array_activate[$count_activate]["link"] = $plugins[2];
				$array_activate[$count_activate]["href"] = $plugins[3];
				$array_activate[$count_activate]["url"]	= $plugins[5];
				$count_activate++;
			} else if ( array_key_exists(str_replace( "\\", "", $plugins[0]), $all_plugins ) ) {
				$array_install[$count_install]["title"] = $plugins[1];
				$array_install[$count_install]["link"]	= $plugins[2];
				$array_install[$count_install]["href"]	= $plugins[3];
				$count_install++;
			} else {
				$array_recomend[$count_recomend]["title"] = $plugins[1];
				$array_recomend[$count_recomend]["link"] = $plugins[2];
				$array_recomend[$count_recomend]["href"] = $plugins[3];
				$array_recomend[$count_recomend]["slug"] = $plugins[4];
				$count_recomend++;
			}
		}
		$array_activate_pro = array();
		$array_install_pro	= array();
		$array_recomend_pro = array();
		$count_activate_pro = $count_install_pro = $count_recomend_pro = 0;
		$array_plugins_pro	= array(
			array( 'gallery-plugin-pro\/gallery-plugin-pro.php', 'Gallery Pro', 'http://bestwebsoft.com/plugin/gallery-pro/?k=382e5ce7c96a6391f5ffa5e116b37fe0', 'http://bestwebsoft.com/plugin/gallery-pro/?k=382e5ce7c96a6391f5ffa5e116b37fe0#purchase', 'admin.php?page=gallery-plugin-pro.php' ),
			array( 'contact-form-pro\/contact_form_pro.php', 'Contact Form Pro', 'http://bestwebsoft.com/plugin/contact-form-pro/?k=773dc97bb3551975db0e32edca1a6d71', 'http://bestwebsoft.com/plugin/contact-form-pro/?k=773dc97bb3551975db0e32edca1a6d71#purchase', 'admin.php?page=contact_form_pro.php' )
		);
		foreach ( $array_plugins_pro as $plugins ) {
			if( 0 < count( preg_grep( "/".$plugins[0]."/", $active_plugins ) ) ) {
				$array_activate_pro[$count_activate_pro]["title"] = $plugins[1];
				$array_activate_pro[$count_activate_pro]["link"] = $plugins[2];
				$array_activate_pro[$count_activate_pro]["href"] = $plugins[3];
				$array_activate_pro[$count_activate_pro]["url"]	= $plugins[4];
				$count_activate_pro++;
			} else if( array_key_exists(str_replace( "\\", "", $plugins[0]), $all_plugins ) ) {
				$array_install_pro[$count_install_pro]["title"] = $plugins[1];
				$array_install_pro[$count_install_pro]["link"]	= $plugins[2];
				$array_install_pro[$count_install_pro]["href"]	= $plugins[3];
				$count_install_pro++;
			} else {
				$array_recomend_pro[$count_recomend_pro]["title"] = $plugins[1];
				$array_recomend_pro[$count_recomend_pro]["link"] = $plugins[2];
				$array_recomend_pro[$count_recomend_pro]["href"] = $plugins[3];
				$count_recomend_pro++;
			}
		}
		
		$sql_version = $wpdb->get_var( "SELECT VERSION() AS version" );
	    $mysql_info = $wpdb->get_results( "SHOW VARIABLES LIKE 'sql_mode'" );
	    if ( is_array( $mysql_info) )
	    	$sql_mode = $mysql_info[0]->Value;
	    if ( empty( $sql_mode ) )
	    	$sql_mode = __( 'Not set', 'custom-search' );
	    if ( ini_get( 'safe_mode' ) )
	    	$safe_mode = __( 'On', 'custom-search' );
	    else
	    	$safe_mode = __( 'Off', 'custom-search' );
	    if ( ini_get( 'allow_url_fopen' ) )
	    	$allow_url_fopen = __( 'On', 'custom-search' );
	    else
	    	$allow_url_fopen = __( 'Off', 'custom-search' );
	    if ( ini_get( 'upload_max_filesize' ) )
	    	$upload_max_filesize = ini_get( 'upload_max_filesize' );
	    else
	    	$upload_max_filesize = __( 'N/A', 'custom-search' );
	    if ( ini_get('post_max_size') )
	    	$post_max_size = ini_get('post_max_size');
	    else
	    	$post_max_size = __( 'N/A', 'custom-search' );
	    if ( ini_get( 'max_execution_time' ) )
	    	$max_execution_time = ini_get( 'max_execution_time' );
	    else
	    	$max_execution_time = __( 'N/A', 'custom-search' );
	    if ( ini_get( 'memory_limit' ) )
	    	$memory_limit = ini_get( 'memory_limit' );
	    else
	    	$memory_limit = __( 'N/A', 'custom-search' );
	    if ( function_exists( 'memory_get_usage' ) )
	    	$memory_usage = round( memory_get_usage() / 1024 / 1024, 2 ) . __(' Mb', 'custom-search' );
	    else
	    	$memory_usage = __( 'N/A', 'custom-search' );
	    if ( is_callable( 'exif_read_data' ) )
	    	$exif_read_data = __( 'Yes', 'custom-search' ) . " ( V" . substr( phpversion( 'exif' ), 0,4 ) . ")" ;
	    else
	    	$exif_read_data = __( 'No', 'custom-search' );
	    if ( is_callable( 'iptcparse' ) )
	    	$iptcparse = __( 'Yes', 'custom-search' );
	    else
	    	$iptcparse = __( 'No', 'custom-search' );
	    if ( is_callable( 'xml_parser_create' ) )
	    	$xml_parser_create = __( 'Yes', 'custom-search' );
	    else
	    	$xml_parser_create = __( 'No', 'custom-search' );

		if ( function_exists( 'wp_get_theme' ) )
			$theme = wp_get_theme();
		else
			$theme = get_theme( get_current_theme() );

		if ( function_exists( 'is_multisite' ) ) {
			if ( is_multisite() ) {
				$multisite = __( 'Yes', 'custom-search' );
			} else {
				$multisite = __( 'No', 'custom-search' );
			}
		} else
			$multisite = __( 'N/A', 'custom-search' );

		$site_url = get_option( 'siteurl' );
		$home_url = get_option( 'home' );
		$db_version = get_option( 'db_version' );
		$system_info = array(
			'system_info' => '',
			'active_plugins' => '',
			'inactive_plugins' => ''
		);
		$system_info['system_info'] = array(
	        __( 'Operating System', 'custom-search' )				=> PHP_OS,
	        __( 'Server', 'custom-search' )						=> $_SERVER["SERVER_SOFTWARE"],
	        __( 'Memory usage', 'custom-search' )					=> $memory_usage,
	        __( 'MYSQL Version', 'custom-search' )				=> $sql_version,
	        __( 'SQL Mode', 'custom-search' )						=> $sql_mode,
	        __( 'PHP Version', 'custom-search' )					=> PHP_VERSION,
	        __( 'PHP Safe Mode', 'custom-search' )				=> $safe_mode,
	        __( 'PHP Allow URL fopen', 'custom-search' )			=> $allow_url_fopen,
	        __( 'PHP Memory Limit', 'custom-search' )				=> $memory_limit,
	        __( 'PHP Max Upload Size', 'custom-search' )			=> $upload_max_filesize,
	        __( 'PHP Max Post Size', 'custom-search' )			=> $post_max_size,
	        __( 'PHP Max Script Execute Time', 'custom-search' )	=> $max_execution_time,
	        __( 'PHP Exif support', 'custom-search' )				=> $exif_read_data,
	        __( 'PHP IPTC support', 'custom-search' )				=> $iptcparse,
	        __( 'PHP XML support', 'custom-search' )				=> $xml_parser_create,
			__( 'Site URL', 'custom-search' )						=> $site_url,
			__( 'Home URL', 'custom-search' )						=> $home_url,
			__( 'WordPress Version', 'custom-search' )			=> $wp_version,
			__( 'WordPress DB Version', 'custom-search' )			=> $db_version,
			__( 'Multisite', 'custom-search' )					=> $multisite,
			__( 'Active Theme', 'custom-search' )					=> $theme['Name'].' '.$theme['Version']
		);
		foreach ( $all_plugins as $path => $plugin ) {
			if ( is_plugin_active( $path ) ) {
				$system_info['active_plugins'][ $plugin['Name'] ] = $plugin['Version'];
			} else {
				$system_info['inactive_plugins'][ $plugin['Name'] ] = $plugin['Version'];
			}
		} 

		if ( ( isset( $_REQUEST['bwsmn_form_submit'] ) && check_admin_referer( plugin_basename(__FILE__), 'bwsmn_nonce_submit' ) ) ||
			 ( isset( $_REQUEST['bwsmn_form_submit_custom_email'] ) && check_admin_referer( plugin_basename(__FILE__), 'bwsmn_nonce_submit_custom_email' ) ) ) {
			if ( isset( $_REQUEST['bwsmn_form_email'] ) ) {
				$bwsmn_form_email = trim( $_REQUEST['bwsmn_form_email'] );
				if( $bwsmn_form_email == "" || !preg_match( "/^((?:[a-z0-9']+(?:[a-z0-9\-_\.']+)?@[a-z0-9]+(?:[a-z0-9\-\.]+)?\.[a-z]{2,5})[, ]*)+$/i", $bwsmn_form_email ) ) {
					$error = __( "Please enter a valid email address.", 'custom-search' );
				} else {
					$email = $bwsmn_form_email;
					$bwsmn_form_email = '';
					$message = __( 'Email with system info is sent to ', 'custom-search' ) . $email;			
				}
			} else {
				$email = 'plugin_system_status@bestwebsoft.com';
				$message = __( 'Thank you for contacting us.', 'custom-search' );
			}

			if ( $error == '' ) {
				$headers  = 'MIME-Version: 1.0' . "\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\n";
				$headers .= 'From: ' . get_option( 'admin_email' );
				$message_text = '<html><head><title>System Info From ' . $home_url . '</title></head><body>
				<h4>Environment</h4>
				<table>';
				foreach ( $system_info['system_info'] as $key => $value ) {
					$message_text .= '<tr><td>'. $key .'</td><td>'. $value .'</td></tr>';	
				}
				$message_text .= '</table>
				<h4>Active Plugins</h4>
				<table>';
				foreach ( $system_info['active_plugins'] as $key => $value ) {	
					$message_text .= '<tr><td scope="row">'. $key .'</td><td scope="row">'. $value .'</td></tr>';	
				}
				$message_text .= '</table>
				<h4>Inactive Plugins</h4>
				<table>';
				foreach ( $system_info['inactive_plugins'] as $key => $value ) {
					$message_text .= '<tr><td scope="row">'. $key .'</td><td scope="row">'. $value .'</td></tr>';
				}
				$message_text .= '</table></body></html>';
				$result = wp_mail( $email, 'System Info From ' . $home_url, $message_text, $headers );
				if ( $result != true )
					$error = __( "Sorry, email message could not be delivered.", 'custom-search' );
			}
		}
		?><div class="wrap">
			<div class="icon32 icon32-bws" id="icon-options-general"></div>
			<h2><?php echo $title;?></h2>
			<div class="updated fade" <?php if( !( isset( $_REQUEST['bwsmn_form_submit'] ) || isset( $_REQUEST['bwsmn_form_submit_custom_email'] ) ) || $error != "" ) echo "style=\"display:none\""; ?>><p><strong><?php echo $message; ?></strong></p></div>
			<div class="error" <?php if ( "" == $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $error; ?></strong></p></div>
			<h3 style="color: blue;"><?php _e( 'Pro plugins', 'custom-search' ); ?></h3>
			<?php if( 0 < $count_activate_pro ) { ?>
			<div style="padding-left:15px;">
				<h4><?php _e( 'Activated plugins', 'custom-search' ); ?></h4>
				<?php foreach ( $array_activate_pro as $activate_plugin ) { ?>
				<div style="float:left; width:200px;"><?php echo $activate_plugin["title"]; ?></div> <p><a href="<?php echo $activate_plugin["link"]; ?>" target="_blank"><?php echo __( "Read more", 'custom-search' ); ?></a> <a href="<?php echo $activate_plugin["url"]; ?>"><?php echo __( "Settings", 'custom-search' ); ?></a></p>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if( 0 < $count_install_pro ) { ?>
			<div style="padding-left:15px;">
				<h4><?php _e( 'Installed plugins', 'custom-search' ); ?></h4>
				<?php foreach ( $array_install_pro as $install_plugin) { ?>
				<div style="float:left; width:200px;"><?php echo $install_plugin["title"]; ?></div> <p><a href="<?php echo $install_plugin["link"]; ?>" target="_blank"><?php echo __( "Read more", 'custom-search' ); ?></a></p>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if( 0 < $count_recomend_pro ) { ?>
			<div style="padding-left:15px;">
				<h4><?php _e( 'Recommended plugins', 'custom-search' ); ?></h4>
				<?php foreach ( $array_recomend_pro as $recomend_plugin ) { ?>
				<div style="float:left; width:200px;"><?php echo $recomend_plugin["title"]; ?></div> <p><a href="<?php echo $recomend_plugin["link"]; ?>" target="_blank"><?php echo __( "Read more", 'custom-search' ); ?></a> <a href="<?php echo $recomend_plugin["href"]; ?>" target="_blank"><?php echo __( "Purchase", 'custom-search' ); ?></a></p>
				<?php } ?>
			</div>
			<?php } ?>
			<br />
			<h3 style="color: green"><?php _e( 'Free plugins', 'custom-search' ); ?></h3>
			<?php if( 0 < $count_activate ) { ?>
			<div style="padding-left:15px;">
				<h4><?php _e( 'Activated plugins', 'custom-search' ); ?></h4>
				<?php foreach( $array_activate as $activate_plugin ) { ?>
				<div style="float:left; width:200px;"><?php echo $activate_plugin["title"]; ?></div> <p><a href="<?php echo $activate_plugin["link"]; ?>" target="_blank"><?php echo __( "Read more", 'custom-search' ); ?></a> <a href="<?php echo $activate_plugin["url"]; ?>"><?php echo __( "Settings", 'custom-search' ); ?></a></p>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if( 0 < $count_install ) { ?>
			<div style="padding-left:15px;">
				<h4><?php _e( 'Installed plugins', 'custom-search' ); ?></h4>
				<?php foreach ( $array_install as $install_plugin ) { ?>
				<div style="float:left; width:200px;"><?php echo $install_plugin["title"]; ?></div> <p><a href="<?php echo $install_plugin["link"]; ?>" target="_blank"><?php echo __( "Read more", 'custom-search' ); ?></a></p>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if( 0 < $count_recomend ) { ?>
			<div style="padding-left:15px;">
				<h4><?php _e( 'Recommended plugins', 'custom-search' ); ?></h4>
				<?php foreach ( $array_recomend as $recomend_plugin ) { ?>
				<div style="float:left; width:200px;"><?php echo $recomend_plugin["title"]; ?></div> <p><a href="<?php echo $recomend_plugin["link"]; ?>" target="_blank"><?php echo __( "Read more", 'custom-search' ); ?></a> <a href="<?php echo $recomend_plugin["href"]; ?>" target="_blank"><?php echo __( "Download", 'custom-search' ); ?></a> <a class="install-now" href="<?php echo get_bloginfo( "url" ) . $recomend_plugin["slug"]; ?>" title="<?php esc_attr( sprintf( __( 'Install %s' ), $recomend_plugin["title"] ) ) ?>" target="_blank"><?php echo __( 'Install now from wordpress.org', 'custom-search' ) ?></a></p>
				<?php } ?>
			</div>
			<?php } ?>	
			<br />		
			<span style="color: rgb(136, 136, 136); font-size: 10px;"><?php _e( 'If you have any questions, please contact us via', 'custom-search' ); ?> <a href="http://support.bestwebsoft.com">http://support.bestwebsoft.com</a></span>
			<div id="poststuff" class="bws_system_info_mata_box">
				<div class="postbox">
					<div class="handlediv" title="Click to toggle">
						<br>
					</div>
					<h3 class="hndle">
						<span><?php _e( 'System status', 'custom-search' ); ?></span>
					</h3>
					<div class="inside">
						<table class="bws_system_info">
							<thead><tr><th><?php _e( 'Environment', 'custom-search' ); ?></th><td></td></tr></thead>
							<tbody>
							<?php foreach ( $system_info['system_info'] as $key => $value ) { ?>	
								<tr>
									<td scope="row"><?php echo $key; ?></td>
									<td scope="row"><?php echo $value; ?></td>
								</tr>	
							<?php } ?>
							</tbody>
						</table>
						<table class="bws_system_info">
							<thead><tr><th><?php _e( 'Active Plugins', 'custom-search' ); ?></th><th></th></tr></thead>
							<tbody>
							<?php foreach ( $system_info['active_plugins'] as $key => $value ) { ?>	
								<tr>
									<td scope="row"><?php echo $key; ?></td>
									<td scope="row"><?php echo $value; ?></td>
								</tr>	
							<?php } ?>
							</tbody>
						</table>
						<table class="bws_system_info">
							<thead><tr><th><?php _e( 'Inactive Plugins', 'custom-search' ); ?></th><th></th></tr></thead>
							<tbody>
							<?php foreach ( $system_info['inactive_plugins'] as $key => $value ) { ?>	
								<tr>
									<td scope="row"><?php echo $key; ?></td>
									<td scope="row"><?php echo $value; ?></td>
								</tr>	
							<?php } ?>
							</tbody>
						</table>
						<div class="clear"></div>						
						<form method="post" action="admin.php?page=bws_plugins">
							<p>			
								<input type="hidden" name="bwsmn_form_submit" value="submit" />
								<input type="submit" class="button-primary" value="<?php _e( 'Send to support', 'custom-search' ) ?>" />
								<?php wp_nonce_field( plugin_basename(__FILE__), 'bwsmn_nonce_submit' ); ?>		
							</p>		
						</form>				
						<form method="post" action="admin.php?page=bws_plugins">	
							<p>			
								<input type="hidden" name="bwsmn_form_submit_custom_email" value="submit" />						
								<input type="submit" class="button" value="<?php _e( 'Send to custom email &#187;', 'custom-search' ) ?>" />
								<input type="text" value="<?php echo $bwsmn_form_email; ?>" name="bwsmn_form_email" />
								<?php wp_nonce_field( plugin_basename(__FILE__), 'bwsmn_nonce_submit_custom_email' ); ?>
							</p>				
						</form>						
					</div>
				</div>
			</div>
		</div>
	<?php }
}

if( ! function_exists( 'add_cstmsrch_admin_menu' ) ) {
	function add_cstmsrch_admin_menu() {
		add_menu_page( 'BWS Plugins', 'BWS Plugins', 'manage_options', 'bws_plugins', 'bws_add_menu_render', plugins_url("images/px.png", __FILE__), 1001); 
		add_submenu_page( 'bws_plugins', __( 'Custom Search Settings', 'custom-search' ), __( 'Custom search', 'custom-search' ), 'manage_options', "custom_search.php", 'cstmsrch_settings_page' );
	}
}

if ( ! function_exists ( 'cstmsrch_admin_head' ) ) {
	function cstmsrch_admin_head() {
		wp_register_style( 'cstmsrchStylesheet', plugins_url( 'css/style.css', __FILE__ ) );
		wp_enqueue_style( 'cstmsrchStylesheet' );

		if ( isset( $_GET['page'] ) && $_GET['page'] == "bws_plugins" )
			wp_enqueue_script( 'bws_menu_script', plugins_url( 'js/bws_menu.js' , __FILE__ ) );
	}
}

if( ! function_exists( 'register_cstmsrch_settings' ) ) {
	function register_cstmsrch_settings() {
		global $wpmu;
		global $cstmsrch_options;

		$cstmsrch_option_defaults = array();

		if ( 1 == $wpmu ) {
			if( ! get_site_option( 'bws_custom_search' ) ) {
				add_site_option( 'bws_custom_search', $cstmsrch_option_defaults );
			}
		} 
		else {
			if( ! get_option( 'bws_custom_search' ) )
				add_option( 'bws_custom_search', $cstmsrch_option_defaults );
		}
			
		if ( 1 == $wpmu )
			$cstmsrch_options = get_site_option( 'bws_custom_search' ); 
		else
			$cstmsrch_options = get_option( 'bws_custom_search' );
	}	
}

if( ! function_exists( 'delete_cstmsrch_settings' ) ) {
	function delete_cstmsrch_settings() {
		delete_option( 'bws_custom_search' );
	}
}   

if( ! function_exists( 'cstmsrch_options_global' ) ) {
	function cstmsrch_options_global() {
		global $wpmu, $cstmsrch_options;
		if ( 1 == $wpmu )
			$cstmsrch_options = get_site_option( 'bws_custom_search' ); 
		else
			$cstmsrch_options = get_option( 'bws_custom_search' );
	}
}   

if( ! function_exists( 'cstmsrch_searchfilter' ) ) {
	function cstmsrch_searchfilter( $query ) {
		global $cstmsrch_options;
		if ( $query->is_search ){
			$cstmsrch_post_standart_types = array( 'post', 'page', 'revision', 'attachment', 'nav_menu_item' );
			$cstmsrch_result_merge = array_merge( $cstmsrch_post_standart_types, $cstmsrch_options );	
			$query->set( 'post_type', $cstmsrch_result_merge );				
		}
		return $query;
	}
}   

if( ! function_exists( 'cstmsrch_settings_page' ) ){	
	function  cstmsrch_settings_page(){
	global $wpdb, $cstmsrch_options;
	$cstmsrch_necessary_variables = array();
	if( isset( $_REQUEST['cstmsrch_submit'] ) && check_admin_referer( plugin_basename(__FILE__), 'cstmsrch_nonce_name' ) ) {
		$cstmsrch_options = isset( $_REQUEST['cstmsrch_options'] ) ? $_REQUEST['cstmsrch_options'] : array() ;
		update_option( 'bws_custom_search', $cstmsrch_options );
		$message = __( "Settings saved" , 'custom-search' );	
	}
	$cstmsrch_result = $wpdb->get_results( "SELECT post_type FROM ". $wpdb->posts ." WHERE post_type NOT IN ('revision', 'page', 'post', 'attachment', 'nav_menu_item') GROUP BY post_type" );	
	?>
	<div class="wrap">
		<div class="icon32 icon32-bws" id="icon-options-general"></div>
		<h2><?php _e( 'Custom Search Settings', 'custom-search' ); ?></h2>
		<div class="updated fade" <?php if( ! isset( $_REQUEST['cstmsrch_submit'] ) ) echo "style=\"display:none\""; ?>><p><strong><?php echo $message; ?></strong></p></div>
		<?php if( count( $cstmsrch_result ) > 0 ) { ?>
			<form method="post" action="" style="margin-top: 10px;">
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e( 'Enable Custom search for:', 'custom-search' ); ?> </th>
						<td>
							<?php 
							foreach ( $cstmsrch_result as $key => $value ) { ?>
								<input type="checkbox" <?php echo ( in_array( $value->post_type, $cstmsrch_options ) ?  'checked="checked"' : "" ); ?> name="cstmsrch_options[]" value="<?php echo $value->post_type; ?>"/><span style="text-transform: capitalize; padding-left: 5px;"><?php echo $value->post_type; ?></span><br />
							<?php } ?>
						</td>
					</tr>	
				</table>	
				<input type="hidden" name="cstmsrch_submit" value="submit" />
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Changes' , 'custom-search' ) ?>" />
				</p>
				<?php wp_nonce_field( plugin_basename(__FILE__), 'cstmsrch_nonce_name' ); ?>
			</form>
		<?php } else { ?>
			<?php _e( 'No custom post type found.', 'custom-search' ); ?>
		<?php } ?>
		</div>
	<?php
	}
}

if ( ! function_exists ( 'cstmsrch_init' ) ) {
	function cstmsrch_init(){
		load_plugin_textdomain( 'custom-search', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
	}
}

register_activation_hook( __FILE__, 'register_cstmsrch_settings'); // activate plugin
register_uninstall_hook( __FILE__, 'delete_cstmsrch_settings'); // uninstall plugin
	
add_action( 'admin_menu', 'add_cstmsrch_admin_menu' );
add_action( 'admin_init', 'cstmsrch_init' );
add_action( 'admin_enqueue_scripts', 'cstmsrch_admin_head' );
add_action( 'init', 'cstmsrch_options_global' );
add_filter( 'pre_get_posts', 'cstmsrch_searchfilter' );
?>