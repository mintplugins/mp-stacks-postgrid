<?php 
/**
 * This file contains the function which hooks to a brick's content output
 *
 * @since 1.0.0
 *
 * @package    MP Stacks PostGrid
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2013, Move Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */
 
/**
 * This function hooks to the brick output. If it is supposed to be a 'postgrid', then it will output the postgrid
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_stacks_brick_content_output_postgrid($default_content_output, $mp_stacks_content_type, $post_id){
	
	//If this stack content type is set to be an image	
	if ($mp_stacks_content_type == 'postgrid'){
		
		//Set default value for $content_output to NULL
		$content_output = NULL;	
		
		//Get PostGrid Metabox Repeater Array
		$postgrid_taxonomy_term = get_post_meta($post_id, 'postgrid_taxonomy_term', true);
		$termid_taxname = explode( '*', $postgrid_taxonomy_term );
			
		//PostGrid per row
		$postgrid_per_row = get_post_meta($post_id, 'postgrid_per_row', true);
		$postgrid_per_row = empty( $postgrid_per_row ) ? '2' : $postgrid_per_row;
		
		//Feature alignment
		$postgrid_alignment = get_post_meta($post_id, 'postgrid_alignment', true);
		$postgrid_alignment = empty( $postgrid_alignment ) ? 'left' : $postgrid_alignment;
		
		//Show Featured Images?
		$postgrid_show_featured_images = get_post_meta($post_id, 'postgrid_show_featured_images', true);
		
		//Featured Image width and height
		$postgrid_featured_images_width = get_post_meta($post_id, 'postgrid_featured_images_width', true);
		$postgrid_featured_images_width = !empty($postgrid_featured_images_width) ? $postgrid_featured_images_width :  300;
		
		$postgrid_featured_images_height = get_post_meta($post_id, 'postgrid_featured_images_height', true);
		$postgrid_featured_images_height = !empty($postgrid_featured_images_height) ? $postgrid_featured_images_height :  200;
		
		//Show Post Titles and Excerpts
		$postgrid_show_title_and_text = get_post_meta($post_id, 'postgrid_show_title_and_text', true);
		
		$postgrid_title_color = get_post_meta($post_id, 'postgrid_title_color', true);
		$postgrid_excerpt_color = get_post_meta($post_id, 'postgrid_excerpt_color', true);
		
		$postgrid_title_size = get_post_meta($post_id, 'postgrid_title_size', true);
		$postgrid_excerpt_size = get_post_meta($post_id, 'postgrid_excerpt_size', true);
		
		//get word limit for exceprts
		$word_limit = get_post_meta($post_id, 'postgrid_excerpt_word_limit', true);
		
		$read_more_text = __('...More', 'mp_stacks_postgrid');
		
		//Get PostGrid Output
		$postgrid_output = '<div class="mp-stacks-postgrid">';
		
		//Get PostGrid Output
		$postgrid_output .= '
		<style scoped>
			.mp-stacks-postgrid-item{ 
				color:' . get_post_meta($post_id, 'postgrid_text_color', true) . ';
				width:' . (100/$postgrid_per_row) .'%;
				text-align:' . $postgrid_alignment . ';
			}
			.mp-stacks-postgrid-item-title-holder .mp-stacks-postgrid-item-title{';
			
			if ( !empty( $postgrid_title_color ) ){
				$postgrid_output .= 'color:' . $postgrid_title_color . ';';
			}
			
			if ( !empty( $postgrid_title_size ) ){
				$postgrid_output .= 'font-size:' . $postgrid_title_size . 'px;';
				$postgrid_output .= 'line-height:' . ($postgrid_title_size+7) . 'px;';
			}
				
			$postgrid_output .= '} 
			
			.mp-stacks-postgrid-item-excerpt, .mp-stacks-postgrid-item-excerpt a{';
			
			if ( !empty( $postgrid_excerpt_color ) ){
				$postgrid_output .= 'color:' . $postgrid_excerpt_color . ';';
			}
			
			if ( !empty( $postgrid_excerpt_size ) ){
				$postgrid_output .= 'font-size:' . $postgrid_excerpt_size . 'px;';
				$postgrid_output .= 'line-height:' . ($postgrid_excerpt_size+7) . 'px;';
			}
			
			$postgrid_output .=' 
			}
			
			@media screen and (max-width: 600px){
				.mp-stacks-postgrid-item{ 
					width:' . '100%;
				}
			}';
			
			$postgrid_output .= $postgrid_alignment != 'left' ? NULL : '.mp-stacks-postgrid-icon{ margin: 0px 10px 0px 0px; }';
		$postgrid_output .= '</style>';
		
		//Set counter to 0
		$counter = 1;
				
		//Set the args for the new query
		$postgrid_args = array(
			'order' => 'ASC',
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => $termid_taxname[1],
					'field'    => 'id',
					'terms'    => $termid_taxname[0],
					'operator' => 'IN'
				)
			)
		);	
			
		//Create new query for stacks
		$postgrid_query = new WP_Query( apply_filters( 'postgrid_args', $postgrid_args ) );
		
		$css_output = NULL;
		
		//Loop through the stack group		
		if ( $postgrid_query->have_posts() ) { 
			
			while( $postgrid_query->have_posts() ) : $postgrid_query->the_post(); 
			
					$post_id = get_the_ID();
			
					$postgrid_output .= '<div class="mp-stacks-postgrid-item">';
						
						//If we should show the featured images
						if ($postgrid_show_featured_images){
							$postgrid_output .= '<div class="mp-stacks-postgrid-item-image-holder">';
								
								$postgrid_output .= '<a href="' . get_permalink() . '" >';
								
								$postgrid_output .= '<img src="' . mp_core_the_featured_image($post_id, $postgrid_featured_images_width, $postgrid_featured_images_height) . '" class="mp-stacks-postgrid-item-image" title="' . the_title_attribute( 'echo=0' ) . '" />';
								
								$postgrid_output .= '</a>';
								
							$postgrid_output .= '</div>';
							
							$postgrid_output .= $postgrid_alignment == 'center' ? '<div class="mp-stacks-postgrid-item-clearedfix"></div>' : NULL;
						}
						
						//If we should show the title and text
						if ($postgrid_show_title_and_text){
						
							$postgrid_output .= '<div class="mp-stacks-postgrid-item-title-holder">';
							
								$postgrid_output .= '<a class="mp-stacks-postgrid-item-title" href="' . get_permalink() . '" >' . get_the_title() . '</a>';
								
							$postgrid_output .= '</div>';
							
							//Add clear div to bump postgrid below title and icon
							$postgrid_output .= '<div class="mp-stacks-postgrid-item-clearedfix"></div>';
							
								$the_excerpt = get_the_excerpt();
							
							//Check word limit for excerpt				
							if (!empty($word_limit)){							
								//Cut the excerpt off at X number of words
								$the_excerpt = mp_stacks_postgrid_limit_text($the_excerpt, $word_limit);
							}
							
							$postgrid_output .= '<div class="mp-stacks-postgrid-item-excerpt">';
							
								$postgrid_output .= $the_excerpt . '<a href="' . get_permalink() . '">' . $read_more_text .'</a>';
									
							$postgrid_output .= '</div>';
						}
				
					$postgrid_output .= '</div>';
					
					if ( $postgrid_per_row == $counter ){
						
						//Add clear div to bump a new row
						$postgrid_output .= '<div class="mp-stacks-postgrid-item-clearedfix"></div>';
						
						//Reset counter
						$counter = 1;
					}
					else{
						
						//Increment Counter
						$counter = $counter + 1;
						
					}
					
			endwhile;
		}
		
		$postgrid_output .= '</div>';
		
		//Content output
		$content_output .= $postgrid_output;
		
		//Return
		return $content_output;
	}
	else{
		//Return
		return $default_content_output;
	}
}
add_filter('mp_stacks_brick_content_output', 'mp_stacks_brick_content_output_postgrid', 10, 3);