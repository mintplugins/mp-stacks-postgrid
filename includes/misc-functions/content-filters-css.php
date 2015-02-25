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
	
	//Post Inner Margin (padding)
	$postgrid_post_inner_margin = mp_core_get_post_meta($post_id, 'postgrid_post_inner_margin', '0');
			
	//Padding inside the featured images
	$postgrid_featured_images_inner_margin = mp_core_get_post_meta($post_id, 'postgrid_featured_images_inner_margin', '10' );
	
	//Image Overlay Color and Opacity
	$postgrid_images_overlay_color = mp_core_get_post_meta($post_id, 'postgrid_images_overlay_color', '#FFF' );
	$postgrid_images_overlay_opacity = mp_core_get_post_meta($post_id, 'postgrid_images_overlay_opacity', '0' );
	
	//Use the Excerpt's Color as the default fallback for all text in the grid
	$default_text_color = mp_core_get_post_meta( $post_id, 'postgrid_excerpt_color' );
	
	//Padding for items directly under the image
	$postgrid_post_below_image_area_inner_margin = mp_core_get_post_meta( $post_id, 'postgrid_post_below_image_area_inner_margin', '0' );

	
	//Get CSS Output
	
	$css_output = '
	#mp-brick-' . $post_id . ' .mp-stacks-grid-item{' . 
			mp_core_css_line( 'color', $default_text_color ) . 
			mp_core_css_line( 'width', (100/$postgrid_per_row), '%' ) . 
			mp_core_css_line( 'padding', $postgrid_post_spacing, 'px' ) . 
	'}
	#mp-brick-' . $post_id . ' .mp-stacks-grid-item-inner{' . 
			mp_core_css_line( 'padding', $postgrid_post_inner_margin, 'px' ) . '
	}
	#mp-brick-' . $post_id . ' .mp-stacks-grid-item-inner .mp-stacks-grid-item-below-image-holder{' . 
			mp_core_css_line( 'padding', $postgrid_post_below_image_area_inner_margin, 'px' ) . '
	}
	/*Below image, remove the padding-top (spacing) from the first text item*/
	#mp-brick-' . $post_id . ' .mp-stacks-grid-item-inner .mp-stacks-grid-item-below-image-holder [class*="link"]:first-child [class*="holder"]{
		' . ( $postgrid_post_below_image_area_inner_margin != '0' ? 'padding-top:0px!important;' : NULL ) . '	
	}
	/*Over image, remove the padding-top (spacing) from the first text item*/
	#mp-brick-' . $post_id . ' .mp-stacks-grid .mp-stacks-grid-item .mp-stacks-grid-item-inner .mp-stacks-grid-over-image-text-container-table-cell [class*="holder"]:first-child{
		padding-top:0px;
	}';
	
	$css_output .= apply_filters( 'mp_stacks_postgrid_css', $css_output, $post_id );
	
	$css_output .= '
	#mp-brick-' . $post_id . ' .mp-stacks-grid-over-image-text-container,
	#mp-brick-' . $post_id . ' .mp-stacks-grid-over-image-text-container-top,
	#mp-brick-' . $post_id . ' .mp-stacks-grid-over-image-text-container-middle,
	#mp-brick-' . $post_id . ' .mp-stacks-grid-over-image-text-container-bottom{' . 
		mp_core_css_line( 'padding', $postgrid_featured_images_inner_margin, 'px' ) . 
	'}';
	
	//Get the css output for the image overlay for mobile
	$css_output .= mp_stacks_grid_overlay_mobile_css( $post_id, 'postgrid_image_overlay_animation_keyframes' );
	
	return $css_output;
	
}
add_filter('mp_brick_additional_css', 'mp_stacks_brick_content_output_css_postgrid', 10, 4);