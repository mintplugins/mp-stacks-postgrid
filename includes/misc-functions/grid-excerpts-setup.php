<?php 
/**
 * This file contains the function which set up the Excerpts in the Grid
 *
 * To use this for additional Text Overlays in a grid, duplicate this file 
 * 1. Find and replace "postgrid" with your plugin's prefix
 * 2. Find and replace "excerpt" with your desired text overlay name
 * 3. Make custom changes to the mp_stacks_postgrid_excerpt function about what is displayed.
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
 * Add the meta options for the Grid Excerpts to the PostGrid Metabox
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $items_array Array - The existing Meta Options in this Array
 * @return   Array - All of the placement optons needed for Excerpt
 */
function mp_stacks_postgrid_excerpt_meta_options( $items_array ){		
	
	//Excerpt Settings
	$new_fields = array(
		//Excerpt
		'postgrid_excerpt_showhider' => array(
			'field_id'			=> 'postgrid_excerpt_settings',
			'field_title' 	=> __( 'Excerpt Settings', 'mp_stacks_postgrid'),
			'field_description' 	=> __( '', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'showhider',
			'field_value' => '',
		),
		'postgrid_excerpt_show' => array(
			'field_id'			=> 'postgrid_excerpt_show',
			'field_title' 	=> __( 'Show Excerpts?', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Do you want to show the Excerpts for these posts?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => 'true',
			'field_showhider' => 'postgrid_excerpt_settings',
		),
		'postgrid_excerpt_placement' => array(
			'field_id'			=> 'postgrid_excerpt_placement',
			'field_title' 	=> __( 'Excerpt Placement', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Where would you like to place the excerpt? Default: Below Image, Left', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'select',
			'field_value' => '',
			'field_select_values' => mp_stacks_get_text_position_options(),
			'field_showhider' => 'postgrid_excerpt_settings',
		),
		'postgrid_excerpt_color' => array(
			'field_id'			=> 'postgrid_excerpt_color',
			'field_title' 	=> __( 'Excerpt Color', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Select the color the excerpts will be (leave blank for theme default)', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
			'field_showhider' => 'postgrid_excerpt_settings',
		),
		'postgrid_excerpt_size' => array(
			'field_id'			=> 'postgrid_excerpt_size',
			'field_title' 	=> __( 'Excerpt Size', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Enter the text size the excerpts will be. Default: 15', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '15',
			'field_showhider' => 'postgrid_excerpt_settings',
		),
		'postgrid_excerpt_lineheight' => array(
			'field_id'			=> 'postgrid_excerpt_lineheight',
			'field_title' 	=> __( 'Excerpt Line Height', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Enter the line height for the excerpt text. Default: 18', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '18',
			'field_showhider' => 'postgrid_excerpt_settings',
		),
		'postgrid_excerpt_word_limit' => array(
			'field_id'			=> 'postgrid_excerpt_word_limit',
			'field_title' 	=> __( 'Word Limit for Excerpt', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'How many words should be displayed before the "Read More" link is shown. Default: All words are shown.', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '',
			'field_showhider' => 'postgrid_excerpt_settings',
		),
		//Excerpt animation stuff
		'postgrid_excerpt_animation_desc' => array(
			'field_id'			=> 'postgrid_excerpt_animation_description',
			'field_title' 	=> __( 'Animate the Excerpt upon Mouse-Over', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Add keyframe animations to apply to the excerpt and play upon mouse-over.', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'basictext',
			'field_value' => '',
			'field_showhider' => 'postgrid_excerpt_settings',
		),
		'postgrid_excerpt_animation_repeater_title' => array(
			'field_id'			=> 'postgrid_excerpt_animation_repeater_title',
			'field_title' 	=> __( 'KeyFrame', 'mp_stacks_postgrid'),
			'field_description' 	=> NULL,
			'field_type' 	=> 'repeatertitle',
			'field_repeater' => 'postgrid_excerpt_animation_keyframes',
			'field_showhider' => 'postgrid_excerpt_settings',
		),
		'postgrid_excerpt_animation_length' => array(
			'field_id'			=> 'animation_length',
			'field_title' 	=> __( 'Animation Length', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the length between this keyframe and the previous one in milliseconds. Default: 500', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '500',
			'field_repeater' => 'postgrid_excerpt_animation_keyframes',
			'field_showhider' => 'postgrid_excerpt_settings',
			'field_container_class' => 'mp_animation_length',
		),
		'postgrid_excerpt_animation_opacity' => array(
			'field_id'			=> 'opacity',
			'field_title' 	=> __( 'Opacity', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the opacity percentage at this keyframe. Default: 100', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'input_range',
			'field_value' => '100',
			'field_repeater' => 'postgrid_excerpt_animation_keyframes',
			'field_showhider' => 'postgrid_excerpt_settings',
		),
		'postgrid_excerpt_animation_rotation' => array(
			'field_id'			=> 'rotateZ',
			'field_title' 	=> __( 'Rotation', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the rotation degree angle at this keyframe. Default: 0', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'postgrid_excerpt_animation_keyframes',
			'field_showhider' => 'postgrid_excerpt_settings',
		),
		'postgrid_excerpt_animation_x' => array(
			'field_id'			=> 'translateX',
			'field_title' 	=> __( 'X Position', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the X position, in relation to its starting position, at this keyframe. The unit is pixels. Default: 0', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'postgrid_excerpt_animation_keyframes',
			'field_showhider' => 'postgrid_excerpt_settings',
		),
		'postgrid_excerpt_animation_y' => array(
			'field_id'			=> 'translateY',
			'field_title' 	=> __( 'Y Position', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the Y position, in relation to its starting position, at this keyframe. The unit is pixels. Default: 0', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'postgrid_excerpt_animation_keyframes',
			'field_showhider' => 'postgrid_excerpt_settings',
		),
		'postgrid_excerpt_read_more_text' => array(
			'field_id'			=> 'postgrid_excerpt_read_more_text',
			'field_title' 	=> __( '"Read More" Text for Excerpt\'s', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'What should the "Read More" text be at the end of the Excerpt? Default: "Read More". Leave blank for no output.', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'textbox',
			'field_value' => __( 'Read More', 'mp_stacks_postgrid' ),
			'field_showhider' => 'postgrid_excerpt_settings',
		),
		//Excerpt Background
		'postgrid_excerpt_bg_showhider' => array(
			'field_id'			=> 'postgrid_excerpt_background_settings',
			'field_title' 	=> __( 'Excerpt Background Settings', 'mp_stacks_postgrid'),
			'field_description' 	=> __( '', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'showhider',
			'field_value' => '',
		),
		'postgrid_excerpt_bg_show' => array(
			'field_id'			=> 'postgrid_excerpt_background_show',
			'field_title' 	=> __( 'Show Excerpt Backgrounds?', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Do you want to show a background color behind the excerpt?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => '',
			'field_showhider' => 'postgrid_excerpt_background_settings',
		),
		'postgrid_excerpt_bg_size' => array(
			'field_id'			=> 'postgrid_excerpt_background_padding',
			'field_title' 	=> __( 'Excerpt Background Size', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'How many pixels bigger should the Excerpt Background be than the Text? Default: 5', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '5',
			'field_showhider' => 'postgrid_excerpt_background_settings',
		),
		'postgrid_excerpt_bg_color' => array(
			'field_id'			=> 'postgrid_excerpt_background_color',
			'field_title' 	=> __( 'Excerpt Background Color', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'What color should the excerpt background be? Default: #FFF (White)', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '#FFF',
			'field_showhider' => 'postgrid_excerpt_background_settings',
		),
		'postgrid_excerpt_bg_opacity' => array(
			'field_id'			=> 'postgrid_excerpt_background_opacity',
			'field_title' 	=> __( 'Excerpt Background Opacity', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the opacity percentage? Default: 100', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '100',
			'field_showhider' => 'postgrid_excerpt_background_settings',
		),

	);
	
	return mp_core_insert_meta_fields( $items_array, $new_fields, 'postgrid_meta_hook_anchor_2' );

}
add_filter( 'mp_stacks_postgrid_items_array', 'mp_stacks_postgrid_excerpt_meta_options', 90 );

/**
 * Add the placement options for the Excerpt using placement options filter hook
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $post_id Int - The ID of the Brick
 * @return   Array - All of the placement optons needed for Excerpt
 */
function mp_stacks_postgrid_excerpt_placement_options( $placement_options, $post_id ){
	
	//Show Post Excerpts
	$placement_options['excerpt_show'] = mp_core_get_post_meta($post_id, 'postgrid_excerpt_show');

	//Excerpts Placement
	$placement_options['excerpt_placement'] = mp_core_get_post_meta($post_id, 'postgrid_excerpt_placement', 'below_image_left');
	
	//get word limit for exceprts
	$placement_options['word_limit'] = mp_core_get_post_meta($post_id, 'postgrid_excerpt_word_limit', 20);
	
	//Get Read More Text for excerpts
	$placement_options['read_more_text'] = mp_core_get_post_meta($post_id, 'postgrid_excerpt_read_more_text', __( '...Read More', 'mp_stacks_postgrid' ) );
	
	return $placement_options;	
}
add_filter( 'mp_stacks_postgrid_placement_options', 'mp_stacks_postgrid_excerpt_placement_options', 10, 2 );

/**
 * Get the HTML for the excerpt in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $post_id Int - The ID of the post to get the excerpt of
 * @param    $word_limit Int - The total number of words to include in the excerpt
 * @param    $read_more_text String - The ID of the post to get the title of
 * @return   $html_output String - A string holding the html for an excerpt in the grid
 */
function mp_stacks_postgrid_excerpt( $post_id, $word_limit, $read_more_text = NULL ){
	
	$the_excerpt = mp_core_get_excerpt_by_id($post_id);
	
	//Check word limit for excerpt				
	if (!empty($word_limit)){							
		//Cut the excerpt off at X number of words
		$the_excerpt = mp_core_limit_text_to_words($the_excerpt, $word_limit);
	}
	
	//If there are 0 words in this excerpt
	if (mp_core_word_count($the_excerpt) == 0 ){
		return NULL;	
	}
	else{
		
		$output_string = strip_tags($the_excerpt);
		
		$output_string .= !empty( $read_more_text ) ? '<span class="mp-stacks-postgrid-read-more">' . $read_more_text . '</span>' : NULL;
		
	}
	
	$postgrid_output = mp_stacks_grid_highlight_text_html( array( 
		'class_name' => 'mp-stacks-postgrid-item-excerpt',
		'output_string' => $output_string, 
	) );
	
	return $postgrid_output;	

	
}

/**
 * Hook the Excerpt to the "Top" and "Over" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_postgrid_excerpt_top_over_callback( $postgrid_output, $grid_post_id, $options ){
	
	//If we should show the excerpt over the image
	if ( strpos( $options['excerpt_placement'], 'over') !== false && strpos( $options['excerpt_placement'], 'top') !== false && $options['excerpt_show']){
		
		return $postgrid_output . mp_stacks_postgrid_excerpt( $grid_post_id, $options['word_limit'], $options['read_more_text'] );

	}
	
	return $postgrid_output;
	
}
add_filter( 'mp_stacks_postgrid_top_over', 'mp_stacks_postgrid_excerpt_top_over_callback', 15, 3 );

/**
 * Hook the Excerpt to the "Middle" and "Over" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_postgrid_excerpt_middle_over_callback( $postgrid_output, $grid_post_id, $options ){
	
	//If we should show the excerpt over the image
	if ( strpos( $options['excerpt_placement'], 'over') !== false && strpos( $options['excerpt_placement'], 'middle') !== false && $options['excerpt_show']){
		
		return $postgrid_output . mp_stacks_postgrid_excerpt( $grid_post_id, $options['word_limit'], $options['read_more_text'] );

	}
	
	return $postgrid_output;
}
add_filter( 'mp_stacks_postgrid_middle_over', 'mp_stacks_postgrid_excerpt_middle_over_callback', 15, 3 );

/**
 * Hook the Excerpt to the "Bottom" and "Over" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $grid_post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_postgrid_excerpt_bottom_over_callback( $postgrid_output, $grid_post_id, $options ){
	
	//If we should show the excerpt over the image
	if ( strpos( $options['excerpt_placement'], 'over') !== false && strpos( $options['excerpt_placement'], 'bottom') !== false && $options['excerpt_show']){
		
		return $postgrid_output . mp_stacks_postgrid_excerpt( $grid_post_id, $options['word_limit'], $options['read_more_text'] );

	}
	
	return $postgrid_output;
	
}
add_filter( 'mp_stacks_postgrid_bottom_over', 'mp_stacks_postgrid_excerpt_bottom_over_callback', 15, 3 );

/**
 * Hook the Excerpt to the "Below" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $grid_post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_postgrid_excerpt_below_over_callback( $postgrid_output, $grid_post_id, $options ){
	
	//If we should show the excerpt below the image
	if ( strpos( $options['excerpt_placement'], 'below') !== false && $options['excerpt_show']){
		
		$excerpt_html_output = '<a href="' . get_permalink() . '" class="mp-stacks-postgrid-excerpt-link">';	
			$excerpt_html_output .= mp_stacks_postgrid_excerpt( $grid_post_id, $options['word_limit'], $options['read_more_text'] );
		$excerpt_html_output .= '</a>';
		
		return $postgrid_output . $excerpt_html_output;
	}
	
	return $postgrid_output;
	
}
add_filter( 'mp_stacks_postgrid_below', 'mp_stacks_postgrid_excerpt_below_over_callback', 15, 3 );

/**
 * Add the JS for the excerpt to PostGrid's HTML output
 *
 * @access   public
 * @since    1.0.0
 * @param    $postgrid_output String - The output for postgrid up until this point.
 * @return   $postgrid_output String - The incoming HTML with the new JS animation for the excerpt appended.
 */
function mp_stacks_postgrid_excerpt_animation_js( $postgrid_output, $post_id ){
	
	//Get JS output to animate the excerpts on mouse over and out
	$excerpt_animation_js = mp_core_js_mouse_over_animate_child( '#mp-brick-' . $post_id . ' .mp-stacks-grid-item', '.mp-stacks-postgrid-item-excerpt-holder', mp_core_get_post_meta( $post_id, 'postgrid_excerpt_animation_keyframes', array() ) ); 

	return $postgrid_output . $excerpt_animation_js;
}
add_filter( 'mp_stacks_postgrid_animation_js', 'mp_stacks_postgrid_excerpt_animation_js', 10, 2 );
		
/**
 * Add the CSS for the excerpt to PostGrid's CSS
 *
 * @access   public
 * @since    1.0.0
 * @param    $css_output String - The CSS that exists already up until this filter has run
 * @return   $css_output String - The incoming CSS with our new CSS for the excerpt appended.
 */
function mp_stacks_postgrid_excerpt_css( $css_output, $post_id ){
	
	$excerpt_css_defaults = array(
		'color' => NULL,
		'size' => 15,
		'lineheight' => 18,
		'background_padding' => 5,
		'background_color' => '#fff',
		'background_opacity' => 100,
		'placement_string' => 'below_image_left',
	);

	return $css_output .= mp_stacks_grid_text_css( $post_id, 'postgrid_excerpt', 'mp-stacks-postgrid-item-excerpt', $excerpt_css_defaults );
}
add_filter('mp_stacks_postgrid_css', 'mp_stacks_postgrid_excerpt_css', 10, 2);