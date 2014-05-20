<?php
/**
 * This page contains functions for modifying the metabox for postgrid as a media type
 *
 * @link http://mintplugins.com/doc/
 * @since 1.0.0
 *
 * @package    MP Stacks PostGrid
 * @subpackage Functions
 *
 * @copyright   Copyright (c) 2014, Mint Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author      Philip Johnston
 */
 
/**
 * Add PostGrid as a Media Type to the dropdown
 *
 * @since    1.0.0
 * @link     http://mintplugins.com/doc/
 * @param    array $args See link for description.
 * @return   void
 */
function mp_stacks_postgrid_create_meta_box(){	
	/**
	 * Array which stores all info about the new metabox
	 *
	 */
	$mp_stacks_postgrid_add_meta_box = array(
		'metabox_id' => 'mp_stacks_postgrid_metabox', 
		'metabox_title' => __( '"PostGrid" Content-Type', 'mp_stacks_postgrid'), 
		'metabox_posttype' => 'mp_brick', 
		'metabox_context' => 'advanced', 
		'metabox_priority' => 'low' 
	);
	
	/**
	 * Array which stores all info about the options within the metabox
	 *
	 */
	$mp_stacks_postgrid_items_array = array(
		array(
			'field_id'			=> 'postgrid_taxonomy_term',
			'field_title' 	=> __( 'Select the Category or Tag you want to show', 'mp_stacks_postgrid'),
			'field_description' 	=> '<br />' . __( 'Open up the following areas to add/remove new postgrid.', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'select',
			'field_value' => '',
			'field_select_values' => mp_core_get_all_tax_terms()
		),
		array(
			'field_id'			=> 'postgrid_per_row',
			'field_title' 	=> __( 'Posts Per Row', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'How many posts do you want from left to right before a new row starts?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_per_page',
			'field_title' 	=> __( 'Posts Per Page', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'How many posts do you want to show entirely?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_post_spacing',
			'field_title' 	=> __( 'Post Spacing', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'How much space would you like to have in between each post? (In Pixels)', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_show_featured_images',
			'field_title' 	=> __( 'Show Featured Images?', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Do you want to show the featured images for these posts?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_featured_images_width',
			'field_title' 	=> __( 'Featured Image Width', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'How wide should the images be?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_featured_images_height',
			'field_title' 	=> __( 'Featured Image Height', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'How high should the images be?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_show_title_and_text',
			'field_title' 	=> __( 'Show Titles and Excerpts?', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Do you want to show the Titles and Excerpts for these posts?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_title_color',
			'field_title' 	=> __( 'Titles\' Color', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Select the color the titles will be (leave blank for theme default)', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_title_size',
			'field_title' 	=> __( 'Titles\' Size', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Enter the text size the titles will be (leave blank for theme default)', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_excerpt_color',
			'field_title' 	=> __( 'Excerpt\' Color', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Select the color the excerpts will be (leave blank for theme default)', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_excerpt_size',
			'field_title' 	=> __( 'Excerpt\' Size', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Enter the text size the excerpts will be (leave blank for theme default)', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_excerpt_word_limit',
			'field_title' 	=> __( 'Word Limit for Excerpt\'s', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'How many words should be displayed before the "Read More" link is shown.', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_show_load_more_button',
			'field_title' 	=> __( 'Show "Load More" Button?', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Should we show a "Load More" button?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_load_more_button_color',
			'field_title' 	=> __( '"Load More" Button Color', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'What color should the "Load More" button be?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_load_more_button_text_color',
			'field_title' 	=> __( '"Load More" Button Text Color', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'What color should the "Load More" button\'s text be?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_mouse_over_load_more_button_color',
			'field_title' 	=> __( '"Load More" Button Text Color', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'What color should the "Load More" button be when the Mouse is over it?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'postgrid_mouse_over_load_more_button_text_color',
			'field_title' 	=> __( '"Load More" Button Text Color', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'What color should the "Load More" button\'s text be when the Mouse is over it?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
		)
	);
	
	
	/**
	 * Custom filter to allow for add-on plugins to hook in their own data for add_meta_box array
	 */
	$mp_stacks_postgrid_add_meta_box = has_filter('mp_stacks_postgrid_meta_box_array') ? apply_filters( 'mp_stacks_postgrid_meta_box_array', $mp_stacks_postgrid_add_meta_box) : $mp_stacks_postgrid_add_meta_box;
	
	//Globalize the and populate mp_stacks_features_items_array (do this before filter hooks are run)
	global $global_mp_stacks_postgrid_items_array;
	$global_mp_stacks_postgrid_items_array = $mp_stacks_postgrid_items_array;
	
	/**
	 * Custom filter to allow for add on plugins to hook in their own extra fields 
	 */
	$mp_stacks_postgrid_items_array = has_filter('mp_stacks_postgrid_items_array') ? apply_filters( 'mp_stacks_postgrid_items_array', $mp_stacks_postgrid_items_array) : $mp_stacks_postgrid_items_array;
	
	/**
	 * Create Metabox class
	 */
	global $mp_stacks_postgrid_meta_box;
	$mp_stacks_postgrid_meta_box = new MP_CORE_Metabox($mp_stacks_postgrid_add_meta_box, $mp_stacks_postgrid_items_array);
}
add_action('widgets_init', 'mp_stacks_postgrid_create_meta_box');