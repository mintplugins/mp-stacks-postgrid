<?php
/**
 * This file contains a function which checks if the MP Stacks plugin is installed.
 *
 * @since 1.0.0
 *
 * @package    MP Core
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2015, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */
 
/**
* Check to make sure the MP Stacks Plugin is installed.
*
* @since    1.0.0
* @link     http://mintplugins.com/doc/plugin-checker-class/
* @return   array $plugins An array of plugins to be installed. This is passed in through the mp_core_check_plugins filter.
* @return   array $plugins An array of plugins to be installed. This is passed to the mp_core_check_plugins filter. (see link).
*/
if (!function_exists('mp_stacks_plugin_check')){
	function mp_stacks_plugin_check( $plugins ) {
		
		$add_plugins = array(
			array(
				'plugin_name' => 'MP Stacks',
				'plugin_message' => __('You require the MP Stacks plugin. Install it here.', 'mp_stacks_postgrid'),
				'plugin_filename' => 'mp-stacks.php',
				'plugin_download_link' => 'http://mintplugins.com/repo/mp-stacks/?downloadfile=true',
				'plugin_info_link' => 'http://mintplugins.com/plugins/mp-stacks',
				'plugin_group_install' => true,
				'plugin_required' => true,
				'plugin_wp_repo' => true,
			)
		);
		
		return array_merge( $plugins, $add_plugins );
	}
}
add_filter( 'mp_core_check_plugins', 'mp_stacks_plugin_check' );