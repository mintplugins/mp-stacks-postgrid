<?php 
/**
 * This file contains the function which set up the Dates in the Grid. 
 *
 * To use this for additional Text Overlays in a grid, duplicate this file 
 * 1. Find and replace "postgrid" with your plugin's prefix
 * 2. Find and replace "date" with your desired text overlay name
 * 3. Make custom changes to the mp_stacks_postgrid_date function about what is displayed.
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
 * Add the meta options for the Grid Dates to the PostGrid Metabox
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $post_id Int - The ID of the Brick
 * @return   Array - All of the placement optons needed for Date
 */
function mp_stacks_postgrid_date_meta_options( $items_array ){		
	
	//Date Settings
	$new_fields = array(
		//Date
		'postgrid_date_showhider' => array(
			'field_id'			=> 'postgrid_date_settings',
			'field_title' 	=> __( 'Date Settings', 'mp_stacks_postgrid'),
			'field_description' 	=> __( '', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'showhider',
			'field_value' => '',
		),
		'postgrid_date_format' => array(
			'field_id'			=> 'postgrid_date_format',
			'field_title' 	=> __( 'Date Format', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the date format for your Wordpress by', 'mp_stacks_postgrid' ) . ' <a href="' .  admin_url( 'options-general.php' ) . '">' . __( 'clicking here', 'mp_stacks_postgrid' ) . '</a>',
			'field_type' 	=> 'basictext',
			'field_value' => 'true',
			'field_showhider' => 'postgrid_date_settings',
		),
		'postgrid_date_show' => array(
			'field_id'			=> 'postgrid_date_show',
			'field_title' 	=> __( 'Show Dates?', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Do you want to show the Dates for these posts?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => 'true',
			'field_showhider' => 'postgrid_date_settings',
		),
		'postgrid_date_placement' => array(
			'field_id'			=> 'postgrid_date_placement',
			'field_title' 	=> __( 'Date Placement', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Where would you like to place the date? Default: Over Image, Top-Left', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'select',
			'field_value' => 'over_image_top_left',
			'field_select_values' => mp_stacks_get_text_position_options(),
			'field_showhider' => 'postgrid_date_settings',
		),
		'postgrid_date_color' => array(
			'field_id'			=> 'postgrid_date_color',
			'field_title' 	=> __( 'Date\' Color', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Select the color the dates will be. Default: #000 (Black)', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '#000',
			'field_showhider' => 'postgrid_date_settings',
		),
		'postgrid_date_size' => array(
			'field_id'			=> 'postgrid_date_size',
			'field_title' 	=> __( 'Date Size', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Enter the text size the dates will be. Default: 13', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '13',
			'field_showhider' => 'postgrid_date_settings',
		),
		//Date animation stuff
		'postgrid_date_animation_desc' => array(
			'field_id'			=> 'postgrid_date_animation_description',
			'field_title' 	=> __( 'Animate the Date upon Mouse-Over', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Add keyframe animations to apply to the date and play upon mouse-over.', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'basictext',
			'field_value' => '',
			'field_showhider' => 'postgrid_date_settings',
		),
		'postgrid_date_animation_repeater_title' => array(
			'field_id'			=> 'postgrid_date_animation_repeater_title',
			'field_title' 	=> __( 'KeyFrame', 'mp_stacks_postgrid'),
			'field_description' 	=> NULL,
			'field_type' 	=> 'repeatertitle',
			'field_repeater' => 'postgrid_date_animation_keyframes',
			'field_showhider' => 'postgrid_date_settings',
		),
		'postgrid_date_animation_length' => array(
			'field_id'			=> 'animation_length',
			'field_title' 	=> __( 'Animation Length', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the length between this keyframe and the previous one in milliseconds. Default: 500', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '500',
			'field_repeater' => 'postgrid_date_animation_keyframes',
			'field_showhider' => 'postgrid_date_settings',
			'field_container_class' => 'mp_animation_length',
		),
		'postgrid_date_animation_opacity' => array(
			'field_id'			=> 'opacity',
			'field_title' 	=> __( 'Opacity', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the opacity percentage at this keyframe. Default: 100', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'input_range',
			'field_value' => '100',
			'field_repeater' => 'postgrid_date_animation_keyframes',
			'field_showhider' => 'postgrid_date_settings',
		),
		'postgrid_date_animation_rotation' => array(
			'field_id'			=> 'rotateZ',
			'field_title' 	=> __( 'Rotation', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the rotation degree angle at this keyframe. Default: 0', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'postgrid_date_animation_keyframes',
			'field_showhider' => 'postgrid_date_settings',
		),
		'postgrid_date_animation_x' => array(
			'field_id'			=> 'translateX',
			'field_title' 	=> __( 'X Position', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the X position, in relation to its starting position, at this keyframe. The unit is pixels. Default: 0', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'postgrid_date_animation_keyframes',
			'field_showhider' => 'postgrid_date_settings',
		),
		'postgrid_date_animation_y' => array(
			'field_id'			=> 'translateY',
			'field_title' 	=> __( 'Y Position', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the Y position, in relation to its starting position, at this keyframe. The unit is pixels. Default: 0', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'postgrid_date_animation_keyframes',
			'field_showhider' => 'postgrid_date_settings',
		),
		//Date Background
		'postgrid_date_bg_showhider' => array(
			'field_id'			=> 'postgrid_date_background_settings',
			'field_title' 	=> __( 'Date Background Settings', 'mp_stacks_postgrid'),
			'field_description' 	=> __( '', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'showhider',
			'field_value' => '',
		),
		'postgrid_date_bg_show' => array(
			'field_id'			=> 'postgrid_date_background_show',
			'field_title' 	=> __( 'Show Date Backgrounds?', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Do you want to show a background color behind the date?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => 'true',
			'field_showhider' => 'postgrid_date_background_settings',
		),
		'postgrid_date_bg_size' => array(
			'field_id'			=> 'postgrid_date_background_padding',
			'field_title' 	=> __( 'Date Background Size', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'How many pixels bigger should the Date Background be than the Text? Default: 5', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '5',
			'field_showhider' => 'postgrid_date_background_settings',
		),
		'postgrid_date_bg_color' => array(
			'field_id'			=> 'postgrid_date_background_color',
			'field_title' 	=> __( 'Date Background Color', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'What color should the date background be? Default: #FFF (White)', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '#FFF',
			'field_showhider' => 'postgrid_date_background_settings',
		),
		'postgrid_date_bg_opacity' => array(
			'field_id'			=> 'postgrid_date_background_opacity',
			'field_title' 	=> __( 'Date Background Opacity', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the opacity percentage? Default: 100', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'input_range',
			'field_value' => '100',
			'field_showhider' => 'postgrid_date_background_settings',
		),

	);
	
	return mp_core_insert_meta_fields( $items_array, $new_fields, 'postgrid_meta_hook_anchor_2' );

}
add_filter( 'mp_stacks_postgrid_items_array', 'mp_stacks_postgrid_date_meta_options', 97 );

/**
 * Add the placement options for the Date using placement options filter hook
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $post_id Int - The ID of the Brick
 * @return   Array - All of the placement optons needed for Date
 */
function mp_stacks_postgrid_date_placement_options( $placement_options, $post_id ){
	
	//Show Post Dates
	$placement_options['date_show'] = mp_core_get_post_meta($post_id, 'postgrid_date_show');

	//Dates Placement
	$placement_options['date_placement'] = mp_core_get_post_meta($post_id, 'postgrid_date_placement', 'over_image_top_left');
	
	return $placement_options;	
}
add_filter( 'mp_stacks_postgrid_placement_options', 'mp_stacks_postgrid_date_placement_options', 10, 2 );

/**
 * Get the HTML for the date in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $post_id Int - The ID of the post to get the excerpt of
 * @return   $html_output String - A string holding the html for an excerpt in the grid
 */
function mp_stacks_postgrid_date( $post_id ){
	
	$the_date = get_the_date( get_option( 'date_format' ), $post_id );

	$postgrid_output = mp_stacks_grid_highlight_text_html( array( 
		'class_name' => 'mp-stacks-postgrid-item-date',
		'output_string' => $the_date, 
	) );
	
	return $postgrid_output;	

}

/**
 * Hook the Date to the "Top" and "Over" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_postgrid_date_top_over_callback( $postgrid_output, $grid_post_id, $options ){
	
	//If we should show the date over the image
	if ( strpos( $options['date_placement'], 'over') !== false && strpos( $options['date_placement'], 'top') !== false && $options['date_show']){
		
		return $postgrid_output . mp_stacks_postgrid_date( $grid_post_id, $options['word_limit'], $options['read_more_text'] );

	}
	
	return $postgrid_output;
	
}
add_filter( 'mp_stacks_postgrid_top_over', 'mp_stacks_postgrid_date_top_over_callback', 14, 3 );

/**
 * Hook the Date to the "Middle" and "Over" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_postgrid_date_middle_over_callback( $postgrid_output, $grid_post_id, $options ){
	
	//If we should show the date over the image
	if ( strpos( $options['date_placement'], 'over') !== false && strpos( $options['date_placement'], 'middle') !== false && $options['date_show']){
		
		return $postgrid_output . mp_stacks_postgrid_date( $grid_post_id, $options['word_limit'], $options['read_more_text'] );

	}
	
	return $postgrid_output;
}
add_filter( 'mp_stacks_postgrid_middle_over', 'mp_stacks_postgrid_date_middle_over_callback', 14, 3 );

/**
 * Hook the Date to the "Bottom" and "Over" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $grid_post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_postgrid_date_bottom_over_callback( $postgrid_output, $grid_post_id, $options ){
	
	//If we should show the date over the image
	if ( strpos( $options['date_placement'], 'over') !== false && strpos( $options['date_placement'], 'bottom') !== false && $options['date_show']){
		
		return $postgrid_output . mp_stacks_postgrid_date( $grid_post_id, $options['word_limit'], $options['read_more_text'] );

	}
	
	return $postgrid_output;
	
}
add_filter( 'mp_stacks_postgrid_bottom_over', 'mp_stacks_postgrid_date_bottom_over_callback', 14, 3 );

/**
 * Hook the Date to the "Below" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $grid_post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_postgrid_date_below_over_callback( $postgrid_output, $grid_post_id, $options ){
	
	//If we should show the date below the image
	if ( strpos( $options['date_placement'], 'below') !== false && $options['date_show']){
		
		$date_html_output = '<a href="' . get_permalink() . '" class="mp-stacks-postgrid-date-link">';	
			$date_html_output .= mp_stacks_postgrid_date( $grid_post_id, $options['word_limit'], $options['read_more_text'] );
		$date_html_output .= '</a>';
		
		return $postgrid_output . $date_html_output;
	}
	
	return $postgrid_output;
	
}
add_filter( 'mp_stacks_postgrid_below', 'mp_stacks_postgrid_date_below_over_callback', 14, 3 );

/**
 * Add the JS for the date to PostGrid's HTML output
 *
 * @access   public
 * @since    1.0.0
 * @param    $postgrid_output String - The output for postgrid up until this point.
 * @return   $postgrid_output String - The incoming HTML with the new JS animation for the date appended.
 */
function mp_stacks_postgrid_date_animation_js( $postgrid_output, $post_id ){
	
	//Get JS output to animate the dates on mouse over and out
	$date_animation_js = mp_core_js_mouse_over_animate_child( '#mp-brick-' . $post_id . ' .mp-stacks-grid-item', '.mp-stacks-postgrid-item-date-holder', mp_core_get_post_meta( $post_id, 'postgrid_date_animation_keyframes', array() ) ); 

	return $postgrid_output . $date_animation_js;
}
add_filter( 'mp_stacks_postgrid_animation_js', 'mp_stacks_postgrid_date_animation_js', 10, 2 );
		
/**
 * Add the CSS for the date to PostGrid's CSS
 *
 * @access   public
 * @since    1.0.0
 * @param    $css_output String - The CSS that exists already up until this filter has run
 * @return   $css_output String - The incoming CSS with our new CSS for the date appended.
 */
function mp_stacks_postgrid_date_css( $css_output, $post_id ){
	
	$date_css_defaults = array(
		'color' => '#000',
		'size' => 13,
		'lineheight' => 13,
		'padding' => 0,
		'background_padding' => 5,
		'background_color' => '#fff',
		'background_opacity' => 100,
		'placement_string' => 'over_image_top_left',
	);

	return $css_output .= mp_stacks_grid_text_css( $post_id, 'postgrid_date', 'mp-stacks-postgrid-item-date', $date_css_defaults );
}
add_filter('mp_stacks_postgrid_css', 'mp_stacks_postgrid_date_css', 10, 2);