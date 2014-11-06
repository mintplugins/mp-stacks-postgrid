<?php 
/**
 * This file contains the function which set up the Load More button/Pagination in the Grid
 *
 * To use for your own Add-On, find and replace "postgrid" with your plugin's prefix
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

function mp_stacks_postgrid_setup_load_more(){
	//Create the Meta options, CSS output, and HTML Output for the Load More button.
	new MP_Stacks_Grid_Load_More( 'postgrid' );
}
add_action( 'init', 'mp_stacks_postgrid_setup_load_more' );