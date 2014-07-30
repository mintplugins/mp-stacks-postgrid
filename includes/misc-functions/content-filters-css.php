<?php 
/**
 * This file contains the function which hooks to a brick's content output
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
 * Get the CSS for a text div based on the placement string the user has chosen
 *
 * @access   public
 * @since    1.0.0
 * @param    $placement_string String - A string chosen by the user to specify the position of the title
 * @param    $args Array - An associative array with additional options like image width and height, etc
 * @return   $css_output String - A string containing the CSS for the titles in this grid
 */
function mp_stacks_postgrid_get_text_placement_css( $placement_string, $args ){
	
	$css_output = NULL;
	
	$text_line_height = $args['postgrid_line_height'] / 2 . 'px';
	
	if( $placement_string == 'below_image_left' ){
		
		$css_output = 'text-align:left; padding-top:' . $text_line_height . ';';
	}
	else if(  $placement_string == 'below_image_right' ){
		$css_output = 'text-align:right; padding-top:' . $text_line_height . ';';
	}
	else if(  $placement_string == 'below_image_centered' ){
		$css_output = 'text-align:center; padding-top:' . $text_line_height . ';';
	}
	else if(  $placement_string == 'over_image_top_left' ){
		$css_output = 'text-align:left; padding:' . $text_line_height . ' 0px;';
	}
	else if(  $placement_string == 'over_image_top_right' ){
		$css_output = 'text-align:right; padding:' . $text_line_height . ' 0px';
	}
	else if(  $placement_string == 'over_image_top_centered' ){
		$css_output = 'text-align:center; padding:' . $text_line_height . ' 0px;';
	}
	else if(  $placement_string == 'over_image_middle_left' ){
		$css_output = 'text-align:left; padding:' . $text_line_height . ' 0px;';
	}
	else if(  $placement_string == 'over_image_middle_right' ){
		$css_output = 'text-align:right; padding:' . $text_line_height . ' 0px;';
	}
	else if(  $placement_string == 'over_image_middle_centered' ){
		$css_output = 'text-align:center; padding:' . $text_line_height . ' 0px;';
	}
	else if(  $placement_string == 'over_image_bottom_left' ){
		$css_output = 'text-align:left; padding:' . $text_line_height . ' 0px;';
	}
	else if(  $placement_string == 'over_image_bottom_right' ){
		$css_output = 'text-align:right; padding:' . $text_line_height . ' 0px;';
	}
	else if(  $placement_string == 'over_image_bottom_centered' ){
		$css_output = 'text-align:center; padding:' . $text_line_height . ' 0px;';
	}
	
	return $css_output;
		
}

/**
 * Process the CSS needed for the grid
 *
 * @access   public
 * @since    1.0.0
 * @param    $css_output          String - The incoming CSS output coming from other things using this filter
 * @param    $post_id             Int - The post ID of the brick
 * @param    $first_content_type  String - The first content type chosen for this brick
 * @param    $second_content_type String - The second content type chosen for this brick
 * @return   $html_output         String - A string holding the css the brick
 */
function mp_stacks_brick_content_output_css_postgrid( $css_output, $post_id, $first_content_type, $second_content_type ){
	
	if ( $first_content_type != 'postgrid' && $second_content_type != 'postgrid' ){
		return $css_output;	
	}
	
	//Download per row
	$postgrid_per_row = mp_core_get_post_meta($post_id, 'postgrid_per_row', '3');
	
	//Post Spacing (padding)
	$postgrid_post_spacing = mp_core_get_post_meta($post_id, 'postgrid_post_spacing', '20');
	
	//Padding inside the featured images
	$postgrid_featured_images_inner_margin = mp_core_get_post_meta($post_id, 'postgrid_featured_images_inner_margin', '20' );
	
	//Image Overlay Color and Opacity
	$postgrid_images_overlay_color = mp_core_get_post_meta($post_id, 'postgrid_images_overlay_color', '#FFF' );
	$postgrid_images_overlay_opacity = mp_core_get_post_meta($post_id, 'postgrid_images_overlay_opacity', '0' );
	
	//Titles placement
	$postgrid_titles_placement = mp_core_get_post_meta($post_id, 'postgrid_titles_placement', 'below_image_left');
	
	//Title Color and size
	$postgrid_title_color = mp_core_get_post_meta($post_id, 'postgrid_title_color', 'inherit');
	$postgrid_title_size = mp_core_get_post_meta($post_id, 'postgrid_title_size', '20');
	$postgrid_title_leading = mp_core_get_post_meta($post_id, 'postgrid_title_leading', '5');
	
	//Show Post Title Backgrounds?
	$postgrid_show_title_backgrounds = mp_core_get_post_meta($post_id, 'postgrid_show_title_backgrounds');
	
	//If we should show the title backgrounds
	if ( $postgrid_show_title_backgrounds ){
		//Excerpt background spacing (padding)
		$postgrid_title_background_padding = mp_core_get_post_meta($post_id, 'postgrid_title_background_padding', '0');	
		//Excerpt background color 
		$postgrid_title_background_color = mp_core_get_post_meta($post_id, 'postgrid_title_background_color', '#fff' );	
		//Excerpt background opacity 
		$postgrid_title_background_opacity = mp_core_get_post_meta($post_id, 'postgrid_title_background_opacity', '100');	
	}
	else{
		//Excerpt background spacing (padding)
		$postgrid_title_background_padding = '0';	
		//Excerpt background color - defaults to white
		$postgrid_title_background_color = '#FFFFFF';	
		//Excerpt background opacity 
		$postgrid_title_background_opacity = '0';	
	}
	
	//Excerpts Placement
	$postgrid_excerpt_placement = mp_core_get_post_meta($post_id, 'postgrid_excerpt_placement', 'below_image_left');
	
	//Excerpt Color and Size
	$postgrid_excerpt_color = mp_core_get_post_meta($post_id, 'postgrid_excerpt_color', 'inherit');
	$postgrid_excerpt_size = mp_core_get_post_meta($post_id, 'postgrid_excerpt_size', '15');
	$postgrid_excerpt_leading = mp_core_get_post_meta($post_id, 'postgrid_excerpt_leading', '3');
	
	//Show Excerpt Backgrounds?
	$postgrid_show_excerpt_backgrounds = mp_core_get_post_meta($post_id, 'postgrid_show_excerpt_backgrounds');
	
	//If we should show the excerpt backgrounds
	if ( $postgrid_show_excerpt_backgrounds ){
		//Excerpt background spacing (padding)
		$postgrid_excerpt_background_padding = mp_core_get_post_meta($post_id, 'postgrid_excerpt_background_padding', '0');	
		//Excerpt background color 
		$postgrid_excerpt_background_color = mp_core_get_post_meta($post_id, 'postgrid_excerpt_background_color', '#fff' );	
		//Excerpt background opacity 
		$postgrid_excerpt_background_opacity = mp_core_get_post_meta($post_id, 'postgrid_excerpt_background_opacity', '100');	
	}
	else{
		//Excerpt background spacing (padding)
		$postgrid_excerpt_background_padding = '0';	
		//Excerpt background color - defaults to white
		$postgrid_excerpt_background_color = '#FFFFFF';	
		//Excerpt background opacity 
		$postgrid_excerpt_background_opacity = '0';	
	}
	
	//Load More Buttons Colors
	$postgrid_load_more_button_color = mp_core_get_post_meta($post_id, 'postgrid_load_more_button_color', 'inherit');
	$postgrid_load_more_button_text_color = mp_core_get_post_meta($post_id, 'postgrid_load_more_button_text_color', 'inherit');
	$postgrid_mouse_over_load_more_button_color = mp_core_get_post_meta($post_id, 'postgrid_mouse_over_load_more_button_color', 'inherit');
	$postgrid_mouse_over_load_more_button_text_color = mp_core_get_post_meta($post_id, 'postgrid_mouse_over_load_more_button_text_color', 'inherit');
	
	//Get CSS Output
	$css_output .= '
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-item{ 
			color:' . $postgrid_excerpt_color . ';
			width:' . (100/$postgrid_per_row) .'%;
			padding: ' . $postgrid_post_spacing . 'px;
		}
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-item-title-holder{
			' . mp_stacks_postgrid_get_text_placement_css( $postgrid_titles_placement, array( 
					'postgrid_line_height' => ( $postgrid_title_size + $postgrid_title_leading ),
				) ) . ';
	
			color:' . $postgrid_title_color . ';
			font-size:' . $postgrid_title_size . 'px;
			line-height:' . ( $postgrid_title_size ) . 'px;
		}
		' . mp_stacks_grid_highlight_text_css( array( 
				'brick_id' => $post_id,
				'class_name' => 'mp-stacks-postgrid-item-title',
				'highlight_padding' => $postgrid_title_background_padding, 
				'highlight_color' => $postgrid_title_background_color, 
				'highlight_opacity' => $postgrid_title_background_opacity
		) ) . '
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-item-excerpt-holder, 
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-item-excerpt-holder a{
			' . mp_stacks_postgrid_get_text_placement_css( $postgrid_excerpt_placement, array( 
					'postgrid_line_height' => ($postgrid_excerpt_size),
				) ) . ';
			
			color:' . $postgrid_excerpt_color . ';
			font-size:' . $postgrid_excerpt_size . 'px;
			line-height:' . ($postgrid_excerpt_size + $postgrid_excerpt_leading) . 'px;
		}
		' . mp_stacks_grid_highlight_text_css( array( 
				'brick_id' => $post_id,
				'class_name' => 'mp-stacks-postgrid-item-excerpt',
				'highlight_padding' => $postgrid_excerpt_background_padding, 
				'highlight_color' => $postgrid_excerpt_background_color, 
				'highlight_opacity' => $postgrid_excerpt_background_opacity
		) ) . '
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-load-more-button{
			color:' . $postgrid_load_more_button_text_color  . ';
			background-color:' . $postgrid_load_more_button_color  . ';
		}
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-load-more-button:hover{
			color:' . $postgrid_mouse_over_load_more_button_text_color  . ';
			background-color:' . $postgrid_mouse_over_load_more_button_color  . ';
		}
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-over-image-text-container,
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-over-image-text-container-top,
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-over-image-text-container-middle,
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-over-image-text-container-bottom{
			padding: ' . $postgrid_featured_images_inner_margin . 'px;
		}';
		
		return $css_output;
	
}
add_filter('mp_brick_additional_css', 'mp_stacks_brick_content_output_css_postgrid', 10, 4);