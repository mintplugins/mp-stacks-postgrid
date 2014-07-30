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
			
	//Enqueue postgrid CSS
	wp_enqueue_style( 'mp_stacks_postgrid_css', plugins_url( 'css/postgrid.css', dirname( __FILE__ ) ) );
	
	//Enqueue velocity JS
	wp_enqueue_script( 'velocity_js', plugins_url( 'js/jquery.velocity.min.js', dirname( __FILE__ ) ), array( 'jquery' ) );
	
	//Enqueue postgrid JS
	wp_enqueue_script( 'mp_stacks_postgrid_js', plugins_url( 'js/postgrid.js', dirname( __FILE__ ) ), array( 'jquery', 'velocity_js', 'velocity_ui_js' ) );
	
	//Localize the postgrid js
	wp_localize_script( 'mp_stacks_postgrid_js', 'mp_stacks_postgrid_vars', array(
		'loading_text' =>  __('Loading...', 'mp_stacks_postgrid')
	)
	);

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
	
	//Enqueue Admin PostGrid CSS
	wp_enqueue_style( 'mp_stacks_postgrid_css', plugins_url( 'css/admin-postgrid.css', dirname( __FILE__ ) ) );

}
 
/**
 * Enqueue css face for postgrid
 */
add_action( 'admin_enqueue_scripts', 'mp_stacks_postgrid_admin_enqueue_scripts' );