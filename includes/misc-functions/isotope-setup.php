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
 * @copyright  Copyright (c) 2015, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */

/**
 * Add the meta options for "Isotope" to the PostGrid Metabox
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $items_array Array - The existing Meta Options in this Array
 * @return   Array - The Items Array with the Isotope Options added
*/
function mp_stacks_postgrid_add_isotope_meta( $items_array ){
	
	$meta_prefix = 'postgrid';
			
	$new_items_array = mp_core_insert_meta_fields( $items_array, mp_stacks_grid_isotope_meta( $meta_prefix ), $meta_prefix . '_meta_hook_anchor_1' );
	
	return $new_items_array;
	
}
add_filter( 'mp_stacks_' . 'postgrid' . '_items_array', 'mp_stacks_postgrid_add_isotope_meta', 13 );

/**
 * Add the Filter Group Options the user can select from.
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $isotope_filter_groups Array - Coming in its value is an empty array
 * @return   Array - Returning out, it is an array containing the Filter Groups that the user can choose from.
*/
function mp_stacks_postgrid_isotope_filter_group_options( $isotope_filter_groups ){
	
	//This array can contain custom groups (for outside sources like instgram), AND/OR WordPress taxonomy slugs.			
	$isotope_filter_groups = mp_stacks_postgrid_isotope_filter_groups();
	
	//Simplify the array to just be a key => value pair with strings on both sides.
	foreach( $isotope_filter_groups as $isotope_filter_group_id => $isotope_filter_group ){
		$meta_isotope_filter_group_array[$isotope_filter_group_id] = $isotope_filter_group['filter_group_name'];
	}
	
	return $meta_isotope_filter_group_array;
	
}
add_filter( 'postgrid' . '_isotope_filter_groups', 'mp_stacks_postgrid_isotope_filter_group_options' );

/**
 * Formulate Filter Group Options the user can select from - used by other functions.
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $isotope_filter_groups Array - Coming in its value is an empty array
 * @return   Array - Returning out it is an array containing the Filter Groups that the user can choose from.
*/
function mp_stacks_postgrid_isotope_filter_groups(){
	
	//This array can contain custom groups (for outside sources like instgram), AND/OR WordPress taxonomy slugs.			
	$isotope_filter_groups = array( 
		'category' => array( 
			'is_wordpress_taxonomy' => true,
			'filter_group_name' => __( 'Categories', 'mp_stacks_postgrid' ),
			'meta_field_ids_representing_tax_term' => array(
				'category' => array()
			),
			//Icon info
			'default_icon_font_string' => 'fa-th-large', //A default icon-font class string to use if no unique icon is given
			'default_icon_image_url' => plugins_url( '/assets/images/user-icon.png', dirname( dirname( __FILE__ ) ) ), //A default url to use if no unique icon is given
		),
		'post_tag' => array(
			'is_wordpress_taxonomy' => true,
			'filter_group_name' => __( 'Post Tags', 'mp_stacks_postgrid' ),
			'meta_field_ids_representing_tax_term' => array(),
			//Icon info
			'default_icon_font_string' => 'fa-th-large', //A default icon-font class string to use if no unique icon is given
			'default_icon_image_url' => plugins_url( '/assets/images/user-icon.png', dirname( dirname( __FILE__ ) ) ), //A default url to use if no unique icon is given
		),
	);
	
	$isotope_filter_groups = apply_filters( 'mp_stacks_postgrid_isotope_filter_groups', $isotope_filter_groups );
	
	return $isotope_filter_groups;
	
}

/**
 * Set up a default icon to use for the "All" Button - we do this because our icon font has some blank space above each icon for line height. This way our "All" Icon matches them.
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $isotope_icon String - The CSS Class for the icon font - most likely empty coming in.
 * @param    $meta_prefix String - The meta prefix used for this grid. In this case it is 'socialgrid'
 * @return   String - Returning out it is the icon font class name as a string
*/
function mp_stacks_postgrid_all_icon( $isotope_icon, $meta_prefix ){
	
	if ( $meta_prefix != 'postgrid' ){
		return $isotope_icon;	
	}
	
	return 'fa-th-large';
}
add_filter( 'mp_stacks_grid_isotope_all_icon_font_class', 'mp_stacks_postgrid_all_icon', 10, 2);