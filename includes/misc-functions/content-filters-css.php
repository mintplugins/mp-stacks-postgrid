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
	$postgrid_featured_images_inner_margin = mp_core_get_post_meta($post_id, 'postgrid_featured_images_inner_margin', '10' );
	
	//Image Overlay Color and Opacity
	$postgrid_images_overlay_color = mp_core_get_post_meta($post_id, 'postgrid_images_overlay_color', '#FFF' );
	$postgrid_images_overlay_opacity = mp_core_get_post_meta($post_id, 'postgrid_images_overlay_opacity', '0' );
	
	//Titles placement
	$postgrid_titles_placement = mp_core_get_post_meta($post_id, 'postgrid_titles_placement', 'below_image_left');
	
	//Title Color and size
	$postgrid_title_color = mp_core_get_post_meta($post_id, 'postgrid_title_color', NULL);
	$postgrid_title_size = mp_core_get_post_meta($post_id, 'postgrid_title_size', '20');
	$postgrid_title_lineheight = mp_core_get_post_meta($post_id, 'postgrid_title_lineheight', '20');
	
	//Show Post Title Backgrounds?
	$postgrid_show_title_backgrounds = mp_core_get_post_meta($post_id, 'postgrid_show_title_backgrounds');
	
	//If we should show the title backgrounds
	if ( $postgrid_show_title_backgrounds ){
		//Title background spacing (padding)
		$postgrid_title_background_padding = mp_core_get_post_meta($post_id, 'postgrid_title_background_padding', '5');	
		
			//Calculate Minimum Line Height with Padding
			$min_line_height_with_padding = ( $postgrid_title_background_padding * 3 ) + $postgrid_title_size;
			//If the line height with padding is greater than the lineheight, we need to make the lineheight match or the layout gets thrown off
			$postgrid_title_lineheight = $min_line_height_with_padding  > $postgrid_title_lineheight ? $min_line_height_with_padding : $postgrid_title_lineheight;
			
		//Title background color 
		$postgrid_title_background_color = mp_core_get_post_meta($post_id, 'postgrid_title_background_color', '#fff' );	
		//Title background opacity 
		$postgrid_title_background_opacity = mp_core_get_post_meta($post_id, 'postgrid_title_background_opacity', '100');	
	}
	else{
		//Title background spacing (padding)
		$postgrid_title_background_padding = '0';	
		//Title background color - defaults to white
		$postgrid_title_background_color = '#FFFFFF';	
		//Title background opacity 
		$postgrid_title_background_opacity = '0';	
	}
	
	//Excerpts Placement
	$postgrid_excerpt_placement = mp_core_get_post_meta($post_id, 'postgrid_excerpt_placement', 'below_image_left');
	
	//Excerpt Color and Size
	$postgrid_excerpt_color = mp_core_get_post_meta($post_id, 'postgrid_excerpt_color', NULL);
	$postgrid_excerpt_size = mp_core_get_post_meta($post_id, 'postgrid_excerpt_size', '15');
	$postgrid_excerpt_lineheight = mp_core_get_post_meta($post_id, 'postgrid_excerpt_lineheight', '18');
	
	//Show Excerpt Backgrounds?
	$postgrid_show_excerpt_backgrounds = mp_core_get_post_meta($post_id, 'postgrid_show_excerpt_backgrounds');
	
	//If we should show the excerpt backgrounds
	if ( $postgrid_show_excerpt_backgrounds ){
		//Excerpt background spacing (padding)
		$postgrid_excerpt_background_padding = mp_core_get_post_meta($post_id, 'postgrid_excerpt_background_padding', '5');	
		
			//Calculate Minimum Line Height with Padding
			$min_line_height_with_padding = ( $postgrid_excerpt_background_padding * 3 ) + $postgrid_excerpt_size;
			//If the line height with padding is greater than the lineheight, we need to make the lineheight match or the layout gets thrown off
			$postgrid_excerpt_lineheight = $min_line_height_with_padding  > $postgrid_excerpt_lineheight ? $min_line_height_with_padding : $postgrid_excerpt_lineheight;
			
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
	$postgrid_load_more_button_color = mp_core_get_post_meta($post_id, 'postgrid_load_more_button_color', NULL);
	$postgrid_load_more_button_text_color = mp_core_get_post_meta($post_id, 'postgrid_load_more_button_text_color', NULL);
	$postgrid_mouse_over_load_more_button_color = mp_core_get_post_meta($post_id, 'postgrid_mouse_over_load_more_button_color', NULL);
	$postgrid_mouse_over_load_more_button_text_color = mp_core_get_post_meta($post_id, 'postgrid_mouse_over_load_more_button_text_color', NULL);
	
	//Get CSS Output
	$css_output .= '
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-item{' . 
			mp_core_css_line( 'color', $postgrid_excerpt_color ) . 
			mp_core_css_line( 'width', (100/$postgrid_per_row), '%' ) . 
			mp_core_css_line( 'padding', $postgrid_post_spacing, 'px' ) . 
		'}
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-item-title-holder{
			' . mp_stacks_grid_get_text_placement_css( $postgrid_titles_placement, array( 
					'line_height' => ( $postgrid_title_size ),
				) ) . ';' . 
			mp_core_css_line( 'color', $postgrid_title_color ) . 
			mp_core_css_line( 'font-size', $postgrid_title_size, 'px' ) . 
			mp_core_css_line( 'line-height', $postgrid_title_lineheight, 'px' ) . 
		'}' . 
		mp_stacks_grid_highlight_text_css( array( 
				'brick_id' => $post_id,
				'class_name' => 'mp-stacks-postgrid-item-title',
				'highlight_padding' => $postgrid_title_background_padding, 
				'highlight_color' => $postgrid_title_background_color, 
				'highlight_opacity' => $postgrid_title_background_opacity
		) ) . '
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-item-excerpt-holder, 
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-item-excerpt-holder a{
			' . mp_stacks_grid_get_text_placement_css( $postgrid_excerpt_placement, array( 
					'line_height' => ($postgrid_excerpt_size),
				) ) . '; ' .
			mp_core_css_line( 'color', $postgrid_excerpt_color ) . 
			mp_core_css_line( 'font-size', $postgrid_excerpt_size, 'px' ) . 
			mp_core_css_line( 'line-height', $postgrid_excerpt_lineheight, 'px' ) . 
		'}' . 
		mp_stacks_grid_highlight_text_css( array( 
				'brick_id' => $post_id,
				'class_name' => 'mp-stacks-postgrid-item-excerpt',
				'highlight_padding' => $postgrid_excerpt_background_padding, 
				'highlight_color' => $postgrid_excerpt_background_color, 
				'highlight_opacity' => $postgrid_excerpt_background_opacity
		) ) . '
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-load-more-button{' . 
			mp_core_css_line( 'color', $postgrid_load_more_button_text_color ) . 
			mp_core_css_line( 'background-color', $postgrid_load_more_button_color ) . 
		'}
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-load-more-button:hover{' . 
			mp_core_css_line( 'color', $postgrid_mouse_over_load_more_button_text_color ) . 
			mp_core_css_line( 'background-color', $postgrid_mouse_over_load_more_button_color ) . 
		'}
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-over-image-text-container,
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-over-image-text-container-top,
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-over-image-text-container-middle,
		#mp-brick-' . $post_id . ' .mp-stacks-postgrid-over-image-text-container-bottom{' . 
			mp_core_css_line( 'padding', $postgrid_featured_images_inner_margin, 'px' ) . 
		'}';
		
		return $css_output;
	
}
add_filter('mp_brick_additional_css', 'mp_stacks_brick_content_output_css_postgrid', 10, 4);