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
 * This function hooks to the brick output. If it is supposed to be a 'postgrid', then it will output the postgrid
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_stacks_brick_content_output_postgrid($default_content_output, $mp_stacks_content_type, $brick_id){
	
	//If this stack content type is set to be an image	
	if ($mp_stacks_content_type == 'postgrid'){
		
		//Set default value for $content_output to NULL
		$content_output = NULL;	
		
		//Get PostGrid Metabox Repeater Array
		$postgrid_taxonomy_term = get_post_meta($brick_id, 'postgrid_taxonomy_term', true);
		$termid_taxname = explode( '*', $postgrid_taxonomy_term );
			
		//PostGrid per row
		$postgrid_per_row = get_post_meta($brick_id, 'postgrid_per_row', true);
		$postgrid_per_row = empty( $postgrid_per_row ) ? '2' : $postgrid_per_row;
		
		//PostGrid per page
		$postgrid_per_page = get_post_meta($brick_id, 'postgrid_per_page', true);
		$postgrid_per_page = empty( $postgrid_per_page ) ? '10' : $postgrid_per_page;
		
		//Post Spacing (padding)
		$postgrid_post_spacing = get_post_meta($brick_id, 'postgrid_post_spacing', true);
		$postgrid_post_spacing = empty( $postgrid_post_spacing ) ? '20' : $postgrid_post_spacing;
		
		//Feature alignment
		$postgrid_alignment = get_post_meta($brick_id, 'postgrid_alignment', true);
		$postgrid_alignment = empty( $postgrid_alignment ) ? 'left' : $postgrid_alignment;
		
		//Show Featured Images?
		$postgrid_show_featured_images = get_post_meta($brick_id, 'postgrid_show_featured_images', true);
		
		//Featured Image width and height
		$postgrid_featured_images_width = get_post_meta($brick_id, 'postgrid_featured_images_width', true);
		$postgrid_featured_images_width = !empty($postgrid_featured_images_width) ? $postgrid_featured_images_width :  300;
		
		$postgrid_featured_images_height = get_post_meta($brick_id, 'postgrid_featured_images_height', true);
		$postgrid_featured_images_height = !empty($postgrid_featured_images_height) ? $postgrid_featured_images_height :  200;
		
		//Show Post Titles and Excerpts
		$postgrid_show_title_and_text = get_post_meta($brick_id, 'postgrid_show_title_and_text', true);
		
		//Show Load More Button?
		$postgrid_show_load_more_button = get_post_meta($brick_id, 'postgrid_show_load_more_button', true);
		
		//Load More Buttons Colors
		$postgrid_load_more_button_color = get_post_meta($brick_id, 'postgrid_load_more_button_color', true);
		$postgrid_load_more_button_text_color = get_post_meta($brick_id, 'postgrid_load_more_button_text_color', true);
		$postgrid_mouse_over_load_more_button_color = get_post_meta($brick_id, 'postgrid_mouse_over_load_more_button_color', true);
		$postgrid_mouse_over_load_more_button_text_color = get_post_meta($brick_id, 'postgrid_mouse_over_load_more_button_text_color', true);
		
		//Title Color
		$postgrid_title_color = get_post_meta($brick_id, 'postgrid_title_color', true);
		$postgrid_excerpt_color = get_post_meta($brick_id, 'postgrid_excerpt_color', true);
		
		//Text Color
		$postgrid_title_size = get_post_meta($brick_id, 'postgrid_title_size', true);
		$postgrid_excerpt_size = get_post_meta($brick_id, 'postgrid_excerpt_size', true);
		
		//get word limit for exceprts
		$word_limit = get_post_meta($brick_id, 'postgrid_excerpt_word_limit', true);
		
		$read_more_text = __('...More', 'mp_stacks_postgrid');
		
		//Get PostGrid Output
		$postgrid_output = '<div class="mp-stacks-postgrid">';
		
		//Get PostGrid Output
		$postgrid_output .= '
		<style scoped>
			.mp-stacks-postgrid-item{ 
				color:' . get_post_meta($brick_id, 'postgrid_text_color', true) . ';
				width:' . (100/$postgrid_per_row) .'%;
				text-align:' . $postgrid_alignment . ';
				padding: ' . $postgrid_post_spacing . 'px;
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
			.mp-stacks-postgrid-load-more-button{
				color:' . $postgrid_load_more_button_text_color  . ';
				background-color:' . $postgrid_load_more_button_color  . ';
			}
			.mp-stacks-postgrid-load-more-button:hover{
				color:' . $postgrid_mouse_over_load_more_button_text_color  . ';
				background-color:' . $postgrid_mouse_over_load_more_button_color  . ';
			}';
			
			$postgrid_output .= $postgrid_alignment != 'left' ? NULL : '.mp-stacks-postgrid-icon{ margin: 0px 10px 0px 0px; }';
		$postgrid_output .= '</style>';
		
		//Set counter to 0
		$counter = 1;
				
		//Set the args for the new query
		$postgrid_args = array(
			'order' => 'DESC',
			'posts_per_page' => $postgrid_per_page,
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
		
		$total_posts = $postgrid_query->found_posts;
		
		$css_output = NULL;
		
		//Set the offset of posts to be 0
		$post_offset = 0;
		
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
					
					//Increment Offset
					$post_offset = $post_offset + 1;
					
			endwhile;
		}
		
		//If there are still more posts in this taxonomy
		if ( $total_posts > $post_offset && $postgrid_show_load_more_button ){
			$postgrid_output .= '<a mp_brick_id="' . $brick_id . '" mp_brick_offset="' . $post_offset . '" mp_stacks_postgrid_counter="' . $counter . '" class="button mp-stacks-postgrid-load-more-button">' . __( 'Load More Posts', 'mp_stacks_postgrid' ) . '</a>';	
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

/**
 * Output more posts using ajax
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_postgrid_ajax_load_more(){
		
	if (!isset( $_POST['mp_stacks_postgrid_brick_id'] ) || !isset( $_POST['mp_stacks_postgrid_offset'] ) || !isset( $_POST['mp_stacks_postgrid_counter'] ) ){
		return;	
	}
	
	$brick_id = $_POST['mp_stacks_postgrid_brick_id'];
	$post_offset = $_POST['mp_stacks_postgrid_offset'];
	$counter = $_POST['mp_stacks_postgrid_counter'];
	
	//Show Featured Images?
	$postgrid_show_featured_images = get_post_meta($brick_id, 'postgrid_show_featured_images', true);
	
	//Featured Image width and height
	$postgrid_featured_images_width = get_post_meta($brick_id, 'postgrid_featured_images_width', true);
	$postgrid_featured_images_width = !empty($postgrid_featured_images_width) ? $postgrid_featured_images_width :  300;
	
	$postgrid_featured_images_height = get_post_meta($brick_id, 'postgrid_featured_images_height', true);
	$postgrid_featured_images_height = !empty($postgrid_featured_images_height) ? $postgrid_featured_images_height :  200;
	
	//PostGrid per row
	$postgrid_per_row = get_post_meta($brick_id, 'postgrid_per_row', true);
	$postgrid_per_row = empty( $postgrid_per_row ) ? '2' : $postgrid_per_row;
	
	//Show Post Titles and Excerpts
	$postgrid_show_title_and_text = get_post_meta($brick_id, 'postgrid_show_title_and_text', true);
		
	//Get PostGrid Metabox Repeater Array
	$postgrid_taxonomy_term = get_post_meta($brick_id, 'postgrid_taxonomy_term', true);
	$termid_taxname = explode( '*', $postgrid_taxonomy_term );
	
	//PostGrid per page
	$postgrid_per_page = get_post_meta($brick_id, 'postgrid_per_page', true);
	$postgrid_per_page = empty( $postgrid_per_page ) ? '10' : $postgrid_per_page;
	
	//get word limit for exceprts
	$word_limit = get_post_meta($brick_id, 'postgrid_excerpt_word_limit', true);
	
	//Set the args for the new query
		$postgrid_args = array(
			'order' => 'DESC',
			'posts_per_page' => $postgrid_per_page,
			'offset'     =>  $post_offset,
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
		
		$total_posts = $postgrid_query->found_posts;
		
		$css_output = NULL;
		
		$postgrid_output = NULL;
		
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
					
					//Increment Offset
					$post_offset = $post_offset + 1;
					
			endwhile;
			
			//If there are still more posts in this taxonomy
			if ( $total_posts > $post_offset ){
				$postgrid_output .= '<a mp_brick_id="' . $brick_id . '" mp_brick_offset="' . $post_offset . '" mp_stacks_postgrid_counter="' . $counter . '" class="button mp-stacks-postgrid-load-more-button">' . __( 'Load More Posts', 'mp_stacks_postgrid' ) . '</a>';	
			}
		}
		
		echo $postgrid_output;
		
		die();
			
}
add_action( 'wp_ajax_mp_stacks_postgrid_load_more', 'mp_postgrid_ajax_load_more' );
add_action( 'wp_ajax_nopriv_mp_stacks_postgrid_load_more', 'mp_postgrid_ajax_load_more' );