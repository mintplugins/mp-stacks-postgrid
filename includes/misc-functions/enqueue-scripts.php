<?php
/**
 * This file contains the enqueue scripts function for the postgrid plugin
 *
 * @since 1.0.0
 *
 * @package    MP Stacks Features
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2014, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */
 
/**
 * Enqueue JS and CSS for postgrid 
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */

/**
 * Enqueue css and js
 *
 * Filter: mp_stacks_postgrid_css_location
 */
function mp_stacks_postgrid_enqueue_scripts(){
			
	//Enqueue postgrid CSS
	wp_enqueue_style( 'mp_stacks_postgrid_css', plugins_url( 'css/postgrid.css', dirname( __FILE__ ) ) );
	
	//Enqueue postgrid CSS
	wp_enqueue_script( 'mp_stacks_postgrid_js', plugins_url( 'js/postgrid.js', dirname( __FILE__ ) ), array( 'jquery', 'mp_stacks_front_end_js' ) );

}
 
/**
 * Enqueue css face for postgrid
 */
add_action( 'wp_enqueue_scripts', 'mp_stacks_postgrid_enqueue_scripts' );

/**
 * Enqueue css and js
 *
 * Filter: mp_stacks_postgrid_css_location
 */
function mp_stacks_postgrid_admin_enqueue_scripts(){
	
	//Enqueue Admin Features CSS
	wp_enqueue_style( 'mp_stacks_postgrid_css', plugins_url( 'css/admin-postgrid.css', dirname( __FILE__ ) ) );

}
 
/**
 * Enqueue css face for postgrid
 */
add_action( 'admin_enqueue_scripts', 'mp_stacks_postgrid_admin_enqueue_scripts' );