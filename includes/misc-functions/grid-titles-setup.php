<?php 
/**
 * This file contains the function which set up the Titles in the Grid
 *
 * To use this for additional Text Overlays in a grid, duplicate this file 
 * 1. Find and replace "postgrid" with your plugin's prefix
 * 2. Find and replace "title" with your desired text overlay name
 * 3. Make custom changes to the mp_stacks_postgrid_title function about what is displayed.
 *
 * @since 1.0.0
 *
 * @package    MP Stacks PostGrid
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2016, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */

/**
 * Add the meta options for the Grid Titles to the PostGrid Metabox
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $post_id Int - The ID of the Brick
 * @return   Array - All of the placement optons needed for Title, Price, and Excerpt
 */
function mp_stacks_postgrid_title_meta_options( $items_array ){		
	
	//Title Settings
	$new_fields = array(
		'postgrid_title_showhider' => array(
			'field_id'			=> 'postgrid_title_settings',
			'field_title' 	=> __( 'Title Settings', 'mp_stacks_postgrid'),
			'field_description' 	=> __( '', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'showhider',
			'field_value' => '',
		),
		'postgrid_title_show' => array(
			'field_id'			=> 'postgrid_title_show',
			'field_title' 	=> __( 'Show Titles?', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Do you want to show the Titles for these posts?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => 'true',
			'field_showhider' => 'postgrid_title_settings',
		),
		'postgrid_title_placement' => array(
			'field_id'			=> 'postgrid_title_placement',
			'field_title' 	=> __( 'Titles\' Placement', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Where would you like to place the title? Default: Below Image, Left', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'select',
			'field_value' => 'below_image_left',
			'field_select_values' => mp_stacks_get_text_position_options(),
			'field_showhider' => 'postgrid_title_settings',
		),
		'postgrid_title_color' => array(
			'field_id'			=> 'postgrid_title_color',
			'field_title' 	=> __( 'Titles\' Color', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Select the color the titles will be (leave blank for theme default)', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
			'field_showhider' => 'postgrid_title_settings',
		),
		'postgrid_title_size' => array(
			'field_id'			=> 'postgrid_title_size',
			'field_title' 	=> __( 'Titles\' Size', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Enter the text size the titles will be. Default: 20', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '20',
			'field_showhider' => 'postgrid_title_settings',
		),
		'postgrid_title_lineheight' => array(
			'field_id'			=> 'postgrid_title_lineheight',
			'field_title' 	=> __( 'Titles\' Line Height', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Enter the line height for the excerpt text. Default: 24', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '24',
			'field_showhider' => 'postgrid_title_settings',
		),
		
		'postgrid_title_google_font' => array(
			'field_id'			=> 'postgrid_title_google_font',
			'field_title' 	=> __( 'Google Font Name', 'mp_stacks'),
			'field_description' 	=> 'Enter the name of the Google Font to use for this Text <br /><a class="button" href="https://www.google.com/fonts" target="_blank">Browse Google Fonts<div  style="margin-top: 3.3px; margin-left: 5px;" class="dashicons dashicons-share-alt2"></div></a>',
			'field_type' 	=> 'textbox',
			'field_value' => '',
			'field_placeholder' => __( 'Google Font Name', 'mp_stacks_googlefonts' ),
			'field_showhider' => 'postgrid_title_settings',
		),
		'postgrid_title_google_font_weight_style' => array(
			'field_id'			=> 'postgrid_title_google_font_weight_style',
			'field_title' 	=> __( 'Font Weight/Style', 'mp_stacks'),
			'field_description' 	=> 'Set the weight of this font (If available for your chosen font)',
			'field_type' 	=> 'select',
			'field_select_values' => array( 
				'100' => 'Thin', 
				'200' => 'Extra-Light', 
				'300' => 'Light', 
				'400' => 'Normal', 
				'500' => 'Medium', 
				'600' => 'Semi-Bold', 
				'700' => 'Bold',
				'900' => 'Ultra-Bold', 
			),
			'field_value' => '',
			'field_showhider' => 'postgrid_title_settings',
		),
		
		'postgrid_title_spacing' => array(
			'field_id'			=> 'postgrid_title_spacing',
			'field_title' 	=> __( 'Titles\' Spacing', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'How much space should there be between the title and any content directly above it? Default: 10', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '10',
			'field_showhider' => 'postgrid_title_settings',
		),
		'postgrid_title_animation_desc' => array(
			'field_id'			=> 'postgrid_title_animation_description',
			'field_title' 	=> __( 'Animate the Title upon Mouse-Over', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Control the animations of the titles when the user\'s mouse is over the featured images by adding keyframes here:', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'basictext',
			'field_value' => '',
			'field_showhider' => 'postgrid_title_settings',
		),
		'postgrid_title_animation_repeater_title' => array(
			'field_id'			=> 'postgrid_title_animation_repeater_title',
			'field_title' 	=> __( 'KeyFrame', 'mp_stacks_postgrid'),
			'field_description' 	=> NULL,
			'field_type' 	=> 'repeatertitle',
			'field_repeater' => 'postgrid_title_animation_keyframes',
			'field_showhider' => 'postgrid_title_settings',
		),
		'postgrid_title_animation_length' => array(
			'field_id'			=> 'animation_length',
			'field_title' 	=> __( 'Animation Length', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the length between this keyframe and the previous one in milliseconds. Default: 500', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '500',
			'field_repeater' => 'postgrid_title_animation_keyframes',
			'field_showhider' => 'postgrid_title_settings',
			'field_container_class' => 'mp_animation_length',
		),
		'postgrid_title_animation_opacity' => array(
			'field_id'			=> 'opacity',
			'field_title' 	=> __( 'Opacity', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the opacity percentage at this keyframe. Default: 100', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'input_range',
			'field_value' => '100',
			'field_repeater' => 'postgrid_title_animation_keyframes',
			'field_showhider' => 'postgrid_title_settings',
		),
		'postgrid_title_animation_ratation' => array(
			'field_id'			=> 'rotateZ',
			'field_title' 	=> __( 'Rotation', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the rotation degree angle at this keyframe. Default: 0', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'postgrid_title_animation_keyframes',
			'field_showhider' => 'postgrid_title_settings',
		),
		'postgrid_title_animation_x' => array(
			'field_id'			=> 'translateX',
			'field_title' 	=> __( 'X Position', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the X position, in relation to its starting position, at this keyframe. The unit is pixels. Default: 0', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'postgrid_title_animation_keyframes',
			'field_showhider' => 'postgrid_title_settings',
		),
		'postgrid_title_animation_y' => array(
			'field_id'			=> 'translateY',
			'field_title' 	=> __( 'Y Position', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the Y position, in relation to its starting position, at this keyframe. The unit is pixels. Default: 0', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '0',
			'field_repeater' => 'postgrid_title_animation_keyframes',
			'field_showhider' => 'postgrid_title_settings',
		),
		//Title Background
		'postgrid_title_bg_showhider' => array(
			'field_id'			=> 'postgrid_title_background_settings',
			'field_title' 	=> __( 'Title Background Settings', 'mp_stacks_postgrid'),
			'field_description' 	=> __( '', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'showhider',
			'field_value' => '',
		),
		'postgrid_title_bg_show' => array(
			'field_id'			=> 'postgrid_title_background_show',
			'field_title' 	=> __( 'Show Title Backgrounds?', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Do you want to show a background color behind the title?', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'checkbox',
			'field_value' => '',
			'field_showhider' => 'postgrid_title_background_settings',
		),
		'postgrid_title_bg_size' => array(
			'field_id'			=> 'postgrid_title_background_padding',
			'field_title' 	=> __( 'Title Background Size', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'How many pixels bigger should the Title Background be than the Text? Default: 5', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'number',
			'field_value' => '5',
			'field_showhider' => 'postgrid_title_background_settings',
		),
		'postgrid_title_bg_color' => array(
			'field_id'			=> 'postgrid_title_background_color',
			'field_title' 	=> __( 'Title Background Color', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'What color should the title background be? Default: #FFF (White)', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '#FFF',
			'field_showhider' => 'postgrid_title_background_settings',
		),
		'postgrid_title_bg_opacity' => array(
			'field_id'			=> 'postgrid_title_background_opacity',
			'field_title' 	=> __( 'Title Background Opacity', 'mp_stacks_postgrid'),
			'field_description' 	=> __( 'Set the opacity percentage? Default: 100', 'mp_stacks_postgrid' ),
			'field_type' 	=> 'input_range',
			'field_value' => '100',
			'field_showhider' => 'postgrid_title_background_settings',
		)
	);
	
	return mp_core_insert_meta_fields( $items_array, $new_fields, 'postgrid_meta_hook_anchor_2' );

}
add_filter( 'mp_stacks_postgrid_items_array', 'mp_stacks_postgrid_title_meta_options', 12 );

/**
 * Add the placement options for the Title using placement options filter hook
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $post_id Int - The ID of the Brick
 * @return   Array - All of the placement optons needed for Title, Price, and Excerpt
 */
function mp_stacks_postgrid_title_placement_options( $placement_options, $post_id ){
	
	print_r($placement_options);
	
	//Show Post Titles
	$placement_options['title_show'] = mp_core_get_post_meta($post_id, 'postgrid_title_show');
	
	//Titles placement
	$placement_options['title_placement'] = mp_core_get_post_meta($post_id, 'postgrid_title_placement', 'below_image_left');
	
	return $placement_options;	
}
add_filter( 'mp_stacks_postgrid_placement_options', 'mp_stacks_postgrid_title_placement_options', 10, 2 );

/**
 * Get the HTML for the title in the grid
 *
 * @access   public
 * @since    1.0.0
 * @post_id  $post_id Int - The ID of the post to get the title of
 * @return   $html_output String - A string holding the html for a title in the grid
 */
function mp_stacks_postgrid_title( $post_id ){
	
	$title_html_output = mp_stacks_grid_highlight_text_html( array( 
		'class_name' => 'mp-stacks-postgrid-item-title',
		'output_string' => apply_filters( 'mp_stacks_postgrid_title', get_the_title( $post_id ), $post_id )
	) );
	
	return $title_html_output;
	
}

/**
 * Hook the Title to the "Top" and "Over" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_postgrid_title_top_over_callback( $postgrid_output, $grid_post_id, $options ){
	
	//If we should show the title over the image
	if ( strpos( $options['title_placement'], 'over') !== false && strpos( $options['title_placement'], 'top') !== false && $options['title_show']){
		
		return $postgrid_output . mp_stacks_postgrid_title( $grid_post_id );

	}
	
	return $postgrid_output;
	
}
add_filter( 'mp_stacks_postgrid_top_over', 'mp_stacks_postgrid_title_top_over_callback', 10, 3 );

/**
 * Hook the Title to the "Middle" and "Over" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_postgrid_title_middle_over_callback( $postgrid_output, $grid_post_id, $options ){
	
	//If we should show the title over the image
	if ( strpos( $options['title_placement'], 'over') !== false && strpos( $options['title_placement'], 'middle') !== false && $options['title_show']){
		
		return $postgrid_output . mp_stacks_postgrid_title( $grid_post_id );

	}
	
	return $postgrid_output;
}
add_filter( 'mp_stacks_postgrid_middle_over', 'mp_stacks_postgrid_title_middle_over_callback', 10, 3 );

/**
 * Hook the Title to the "Bottom" and "Over" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $grid_post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_postgrid_title_bottom_over_callback( $postgrid_output, $grid_post_id, $options ){
	
	//If we should show the title over the image
	if ( strpos( $options['title_placement'], 'over') !== false && strpos( $options['title_placement'], 'bottom') !== false && $options['title_show']){
		
		return $postgrid_output . mp_stacks_postgrid_title( $grid_post_id );

	}
	
	return $postgrid_output;
	
}
add_filter( 'mp_stacks_postgrid_bottom_over', 'mp_stacks_postgrid_title_bottom_over_callback', 10, 3 );

/**
 * Hook the Title to the "Below" position in the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $grid_post_id Int - The ID of the post
 * @return   $html_output String - A string holding the html for text over a featured image in the grid
 */
function mp_stacks_postgrid_title_below_over_callback( $postgrid_output, $grid_post_id, $brick_id, $options ){
	
	//If we should show the title below the image
	if ( strpos( $options['title_placement'], 'below') !== false && $options['title_show']){
		
		$title_html_output = '<a href="' . apply_filters( 'mp_stacks_postgrid_grid_post_permalink', get_permalink(), $grid_post_id, $brick_id ) . '" class="mp-stacks-postgrid-title-link ' . apply_filters( 'mp_stacks_postgrid_grid_postlink_classes', NULL, $grid_post_id, $brick_id ) . '">';	
			$title_html_output .= mp_stacks_postgrid_title( $grid_post_id );
		$title_html_output .= '</a>';
		
		return $postgrid_output . $title_html_output;
	}
	
	return $postgrid_output;
	
}
add_filter( 'mp_stacks_postgrid_below', 'mp_stacks_postgrid_title_below_over_callback', 10, 4 );

/**
 * Add the JS for the title to PostGrid's HTML output
 *
 * @access   public
 * @since    1.0.0
 * @param    $existing_filter_output String - Any output already returned to this filter previously
 * @param    $post_id String - the ID of the Brick where all the meta is saved.
 * @param    $meta_prefix String - the prefix to put before each meta_field key to differentiate it from other plugins. :EG "postgrid"
 * @return   $new_grid_output - the existing grid output with additional thigns added by this function.
 */
function mp_stacks_postgrid_title_animation_js( $existing_filter_output, $post_id, $meta_prefix ){
	
	if ( $meta_prefix != 'postgrid' ){
		return $existing_filter_output;	
	}
					
	//Get JS output to animate the titles on mouse over and out
	$title_animation_js = mp_core_js_mouse_over_animate_child( '#mp-brick-' . $post_id . ' .mp-stacks-grid-item', '.mp-stacks-postgrid-item-title-holder', mp_core_get_post_meta( $post_id, 'postgrid_title_animation_keyframes', array() ), true, true, 'mp-brick-' . $post_id ); 

	return $existing_filter_output .= $title_animation_js;
}
add_filter( 'mp_stacks_grid_js', 'mp_stacks_postgrid_title_animation_js', 10, 3 );
		
/**
 * Add the CSS for the title to PostGrid's CSS
 *
 * @access   public
 * @since    1.0.0
 * @param    $css_output String - The CSS that exists already up until this filter has run
 * @return   $css_output String - The incoming CSS with our new CSS for the title appended.
 */
function mp_stacks_postgrid_title_css( $css_output, $post_id ){
	
	$title_css_defaults = array(
		'color' => NULL,
		'size' => 20,
		'lineheight' => 24,
		'padding_top' => 10, //aka 'spacing'
		'background_padding' => 5,
		'background_color' => '#fff',
		'background_opacity' => 100,
		'placement_string' => 'below_image_left',
	);

	return $css_output .= mp_stacks_grid_text_css( $post_id, 'postgrid_title', 'mp-stacks-postgrid-item-title', $title_css_defaults );
}
add_filter('mp_stacks_postgrid_css', 'mp_stacks_postgrid_title_css', 10, 2);

/**
 * Add the Google Fonts for the Grid Titles
 *
 * @param    $css_output          String - The incoming CSS output coming from other things using this filter
 * @param    $post_id             Int - The post ID of the brick
 * @param    $first_content_type  String - The first content type chosen for this brick
 * @param    $second_content_type String - The second content type chosen for this brick
 * @return   $css_output          String - A string holding the css the brick
 */
function mp_stacks_postgrid_title_google_font( $css_output, $post_id, $first_content_type, $second_content_type ){
	
	if ( $first_content_type != 'postgrid' && $second_content_type != 'postgrid' ){
		return $css_output;	
	}
	
	global $mp_stacks_footer_inline_css, $mp_core_font_families;
	
	//Default settings for the MP Core Google Font Class
	$mp_core_google_font_args = array( 'echo_google_font_css' => false, 'wrap_in_style_tags' => false );
	
	$postgrid_title_googlefont = mp_core_get_post_meta( $post_id, 'postgrid_title_google_font' );
	$postgrid_title_googlefontweight = mp_core_get_post_meta( $post_id, 'postgrid_title_google_font_weight_style' );
	
	//If a font name has been entered
	if ( !empty( $postgrid_title_googlefont ) ){
		
		//Check if a font extra (weight) has been selected and add it if so.
		$postgrid_title_googlefontweight = isset($postgrid_title_googlefontweight) && !empty( $postgrid_title_googlefontweight ) ? ':' . $postgrid_title_googlefontweight : NULL;
		$postgrid_title_googlefont = $postgrid_title_googlefont . $postgrid_title_googlefontweight;
	
		//Load the Google Font using the Google Font Class in MP Core
		new MP_CORE_Font( $postgrid_title_googlefont, $postgrid_title_googlefont, $mp_core_google_font_args );
		$mp_stacks_footer_inline_css[$postgrid_title_googlefont] = $mp_core_font_families[$postgrid_title_googlefont];
		
		//Return the incoming css string plus css to apply this font family to all paragraph tags
		$css_output .=  '#mp-brick-' . $post_id . ' .mp-stacks-postgrid-item-title, #mp-brick-' . $post_id . ' .mp-stacks-postgrid-item-title * { font-family: \'' . $postgrid_title_googlefont . '\';}';
	
	}
	
	return $css_output;	
}
add_filter('mp_brick_additional_css', 'mp_stacks_postgrid_title_google_font', 10, 4);	