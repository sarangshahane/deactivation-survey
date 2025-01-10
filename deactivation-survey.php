<?php
/**
 * Plugin Name: User Deactivation Survey
 * Description: This plugin is used to collect feedback before deactivating the plugin.
 * Author: Brainstorm Force
 * Author URI: https://brainstormforce.com/
 * Version: 1.0.0
 * License: GPL v2
 * Text Domain: user-deactivation-survey
 *
 * @package deactivation-survey
 */

/**
 * Check of plugin constant is already defined
 */
if ( defined( 'UDS_FILE' ) ) {
	return;
}

/**
 * Set constants
 */
define( 'UDS_FILE', __FILE__ );
define( 'UDS_BASE', plugin_basename( UDS_FILE ) );
define( 'UDS_DIR', plugin_dir_path( UDS_FILE ) );
define( 'UDS_URL', plugins_url( '/', UDS_FILE ) );
define( 'UDS_VER', '1.0.0' );

require_once 'uds-plugin-loader.php';
