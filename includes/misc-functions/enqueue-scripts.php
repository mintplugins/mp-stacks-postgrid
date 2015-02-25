<?php
/**
 * This file contains the enqueue scripts function for the postgrid plugin
 *
 * @since 1.0.0
 *
 * @package    MP Stacks PostGrid
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
			
	//Enqueue velocity JS
	wp_enqueue_script( 'velocity_js', MP_CORE_JS_SCRIPTS_URL . 'velocity.min.js', array( 'jquery' ), MP_STACKS_POSTGRID_VERSION );
	
	//Enqueue Waypoints JS
	wp_enqueue_script( 'waypoints_js', MP_CORE_JS_SCRIPTS_URL . 'waypoints.min.js', array( 'jquery' ), MP_STACKS_POSTGRID_VERSION );
	
	//masonry script
	wp_enqueue_script( 'masonry' );
			
	//Enqueue postgrid JS
	wp_enqueue_script( 'mp_stacks_postgrid_js', plugins_url( 'js/postgrid.js', dirname( __FILE__ ) ), array( 'jquery', 'velocity_js', 'masonry', 'waypoints_js' ), MP_STACKS_POSTGRID_VERSION );

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
	

}
 
/**
 * Enqueue css face for postgrid
 */
add_action( 'admin_enqueue_scripts', 'mp_stacks_postgrid_admin_enqueue_scripts' );