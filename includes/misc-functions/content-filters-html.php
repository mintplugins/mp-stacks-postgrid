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
function mp_stacks_brick_content_output_postgrid( $default_content_output, $mp_stacks_content_type, $post_id ){
	
	//If this stack content type is set to be a download grid	
	if ($mp_stacks_content_type != 'postgrid'){
		
		return $default_content_output;
		
	}
	
	//Set default value for $content_output to NULL
	$content_output = NULL;	
	
	//Get Download Taxonomy Term to Loop through
	$postgrid_taxonomy_term = mp_core_get_post_meta($post_id, 'postgrid_taxonomy_term', '');
	
	//Get PostGrid Metabox Repeater Array
	$postgrid_taxonomy_term = mp_core_get_post_meta($post_id, 'postgrid_taxonomy_term', '');
	$termid_taxname = explode( '*', $postgrid_taxonomy_term );
		
	//Download per row
	$postgrid_per_row = mp_core_get_post_meta($post_id, 'postgrid_per_row', '3');
	
	//Download per page
	$postgrid_per_page = mp_core_get_post_meta($post_id, 'postgrid_per_page', '9');
	
	//Show Download Images?
	$postgrid_show_featured_images = mp_core_get_post_meta($post_id, 'postgrid_show_featured_images');
	
	//Download Image width and height
	$postgrid_featured_images_width = mp_core_get_post_meta( $post_id, 'postgrid_featured_images_width', '300' );
	$postgrid_featured_images_height = mp_core_get_post_meta( $post_id, 'postgrid_featured_images_height', '200' );
	
	//Show Post Titles
	$postgrid_show_titles = mp_core_get_post_meta($post_id, 'postgrid_show_titles');
	
	//Show Post Title Backgrounds?
	$postgrid_show_title_backgrounds = mp_core_get_post_meta($post_id, 'postgrid_show_title_backgrounds');
	
	//Titles placement
	$postgrid_titles_placement = mp_core_get_post_meta($post_id, 'postgrid_titles_placement', 'below_image_left');
	
	//Show Post Excerpts
	$postgrid_show_excerpts = mp_core_get_post_meta($post_id, 'postgrid_show_excerpts');
	
	//Excerpts Placement
	$postgrid_excerpt_placement = mp_core_get_post_meta($post_id, 'postgrid_excerpt_placement', 'below_image_left');
	
	//Show Load More Button?
	$postgrid_show_load_more_button = mp_core_get_post_meta($post_id, 'postgrid_show_load_more_button');

	//Load More Button Text
	$postgrid_load_more_text = mp_core_get_post_meta($post_id, 'postgrid_load_more_text', __( 'Load More', 'mp_stacks_postgrid' ) );
	
	//get word limit for exceprts
	$word_limit = mp_core_get_post_meta($post_id, 'postgrid_excerpt_word_limit', 20);
	
	$read_more_text = __('...', 'mp_stacks_postgrid');
	
	//Get Download Output
	$postgrid_output = '<div class="mp-stacks-postgrid">';
	
	//Get JS output to animate the titles on mouse over and out
	$postgrid_output .= mp_core_js_mouse_over_animate_child( '#mp-brick-' . $post_id . ' .mp-stacks-postgrid-item', '.mp-stacks-postgrid-item-title-holder', mp_core_get_post_meta( $post_id, 'postgrid_title_animation_keyframes', array() ) ); 
	
	//Get JS output to animate the titles background on mouse over and out
	if ( $postgrid_show_title_backgrounds ){
		$postgrid_output .= mp_core_js_mouse_over_animate_child( '#mp-brick-' . $post_id . ' .mp-stacks-postgrid-item', '.mp-stacks-postgrid-item-title-background', mp_core_get_post_meta( $post_id, 'postgrid_title_background_animation_keyframes', array() ) ); 
	}
	
	//Get JS output to animate the excerpts on mouse over and out
	$postgrid_output .= mp_core_js_mouse_over_animate_child( '#mp-brick-' . $post_id . ' .mp-stacks-postgrid-item', '.mp-stacks-postgrid-item-excerpt-holder', mp_core_get_post_meta( $post_id, 'postgrid_excerpt_animation_keyframes', array() ) ); 
	
	//Get JS output to animate the images on mouse over and out
	$postgrid_output .= mp_core_js_mouse_over_animate_child( '#mp-brick-' . $post_id . ' .mp-stacks-postgrid-item', '.mp-stacks-postgrid-item-image', mp_core_get_post_meta( $post_id, 'postgrid_image_animation_keyframes', array() ) ); 
	
	//Get JS output to animate the images overlays on mouse over and out
	$postgrid_output .= mp_core_js_mouse_over_animate_child( '#mp-brick-' . $post_id . ' .mp-stacks-postgrid-item', '.mp-stacks-postgrid-item-image-overlay', mp_core_get_post_meta( $post_id, 'postgrid_image_overlay_animation_keyframes', array() ) ); 
	
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
		
				$grid_post_id = get_the_ID();
		
				$postgrid_output .= '<div class="mp-stacks-postgrid-item">';
					
					//If we should show the featured images
					if ($postgrid_show_featured_images){
						
						$postgrid_output .= '<div class="mp-stacks-postgrid-item-image-holder">';
						
							$postgrid_output .= '<div class="mp-stacks-postgrid-item-image-overlay"></div>';
							
							$postgrid_output .= '<a href="' . get_permalink() . '" class="mp-stacks-postgrid-image-link">';
							
							$postgrid_output .= '<img src="' . mp_core_the_featured_image($grid_post_id, $postgrid_featured_images_width, $postgrid_featured_images_height) . '" class="mp-stacks-postgrid-item-image" title="' . the_title_attribute( 'echo=0' ) . '" />';
							
							//Top Over
							$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-top">';
							
								$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-table">';
								
									$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-table-cell">';
									
										//If we should show the title over the image
										if ( strpos( $postgrid_titles_placement, 'over') !== false && strpos( $postgrid_titles_placement, 'top') !== false && $postgrid_show_titles){
											
											$postgrid_output .= mp_stacks_postgrid_title( $grid_post_id );
								
										}
										
										//If we should show the excerpt over the image
										if ( strpos( $postgrid_excerpt_placement, 'over') !== false && strpos( $postgrid_excerpt_placement, 'top') !== false && $postgrid_show_excerpts){
											
											$postgrid_output .= mp_stacks_postgrid_excerpt( $grid_post_id, $word_limit, $read_more_text );
											
										}
									
									$postgrid_output .= '</div>';
									
								$postgrid_output .= '</div>';
							
							$postgrid_output .= '</div>';
							
							//Middle Over
							$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-middle">';
							
								$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-table">';
								
									$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-table-cell">';
									
										//If we should show the title over the image
										if ( strpos( $postgrid_titles_placement, 'over') !== false && strpos( $postgrid_titles_placement, 'middle') !== false && $postgrid_show_titles){
											
											$postgrid_output .= mp_stacks_postgrid_title( $grid_post_id );
								
										}
										
										//If we should show the excerpt over the image
										if ( strpos( $postgrid_excerpt_placement, 'over') !== false && strpos( $postgrid_excerpt_placement, 'middle') !== false && $postgrid_show_excerpts){
											
											$postgrid_output .= mp_stacks_postgrid_excerpt( $grid_post_id, $word_limit, $read_more_text );
											
										}
									
									$postgrid_output .= '</div>';
									
								$postgrid_output .= '</div>';
							
							$postgrid_output .= '</div>';
							
							//Bottom Over
							$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-bottom">';
							
								$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-table">';
								
									$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-table-cell">';
									
										//If we should show the title over the image
										if ( strpos( $postgrid_titles_placement, 'over') !== false && strpos( $postgrid_titles_placement, 'bottom') !== false && $postgrid_show_titles){
											
											$postgrid_output .= mp_stacks_postgrid_title( $grid_post_id );
								
										}
										
										//If we should show the excerpt over the image
										if ( strpos( $postgrid_excerpt_placement, 'over') !== false && strpos( $postgrid_excerpt_placement, 'bottom') !== false && $postgrid_show_excerpts){
											
											$postgrid_output .= mp_stacks_postgrid_excerpt( $grid_post_id, $word_limit, $read_more_text );
											
										}
									
									$postgrid_output .= '</div>';
									
								$postgrid_output .= '</div>';
							
							$postgrid_output .= '</div>';
							
							$postgrid_output .= '</a>';
							
						$postgrid_output .= '</div>';
						
					}
						
					//If we should show the title below the image
					if ( strpos( $postgrid_titles_placement, 'below') !== false && $postgrid_show_titles){
						
						$postgrid_output .= '<a href="' . get_permalink() . '" class="mp-stacks-postgrid-title-link">';	
							$postgrid_output .= mp_stacks_postgrid_title( $grid_post_id );
						$postgrid_output .= '</a>';
					
					}
					//If we should show the excerpt below the image
					if ( strpos( $postgrid_excerpt_placement, 'below') !== false && $postgrid_show_excerpts){
						
						$postgrid_output .= '<a href="' . get_permalink() . '" class="mp-stacks-postgrid-title-link">';	
							$postgrid_output .= mp_stacks_postgrid_excerpt( $grid_post_id, $word_limit, $read_more_text );
						$postgrid_output .= '</a>';
						
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
		$postgrid_output .= '<a mp_post_id="' . $post_id . '" mp_brick_offset="' . $post_offset . '" mp_stacks_postgrid_counter="' . $counter . '" class="button mp-stacks-postgrid-load-more-button">' . $postgrid_load_more_text . '</a>';	
	}
	
	$postgrid_output .= '</div>';
	
	//Content output
	$content_output .= $postgrid_output;
	
	//Return
	return $content_output;

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
			
	if (!isset( $_POST['mp_stacks_postgrid_post_id'] ) || !isset( $_POST['mp_stacks_postgrid_offset'] ) || !isset( $_POST['mp_stacks_postgrid_counter'] ) ){
		return;	
	}
	
	$post_id = $_POST['mp_stacks_postgrid_post_id'];
	$post_offset = $_POST['mp_stacks_postgrid_offset'];
	$counter = $_POST['mp_stacks_postgrid_counter'];

	//Get Download Taxonomy Term to Loop through
	$postgrid_taxonomy_term = mp_core_get_post_meta($post_id, 'postgrid_taxonomy_term', '');
	
	//Get PostGrid Metabox Repeater Array
	$postgrid_taxonomy_term = mp_core_get_post_meta($post_id, 'postgrid_taxonomy_term', '');
	$termid_taxname = explode( '*', $postgrid_taxonomy_term );
		
	//Download per row
	$postgrid_per_row = mp_core_get_post_meta($post_id, 'postgrid_per_row', '3');
	
	//Download per page
	$postgrid_per_page = mp_core_get_post_meta($post_id, 'postgrid_per_page', '9');
	
	//Show Download Images?
	$postgrid_show_featured_images = mp_core_get_post_meta($post_id, 'postgrid_show_featured_images');
	
	//Download Image width and height
	$postgrid_featured_images_width = mp_core_get_post_meta($post_id, 'postgrid_featured_images_width', '300' );
	$postgrid_featured_images_height = mp_core_get_post_meta($post_id, 'postgrid_featured_images_height', '200');
	
	//Show Post Titles
	$postgrid_show_titles = mp_core_get_post_meta($post_id, 'postgrid_show_titles');
	
	//Show Post Title Backgrounds
	$postgrid_show_title_backgrounds = mp_core_get_post_meta($post_id, 'postgrid_show_title_backgrounds');
	
	//Titles placement
	$postgrid_titles_placement = mp_core_get_post_meta($post_id, 'postgrid_titles_placement', 'below_image_left');
	
	//Show Post Excerpts
	$postgrid_show_excerpts = mp_core_get_post_meta($post_id, 'postgrid_show_excerpts');
	
	//Excerpts Placement
	$postgrid_excerpt_placement = mp_core_get_post_meta($post_id, 'postgrid_excerpt_placement', 'below_image_left');
	
	//Show Load More Button?
	$postgrid_show_load_more_button = mp_core_get_post_meta($post_id, 'postgrid_show_load_more_button');

	//Load More Button Text
	$postgrid_load_more_text = mp_core_get_post_meta($post_id, 'postgrid_load_more_text', __( 'Load More', 'mp_stacks_postgrid' ) );
	
	//get word limit for exceprts
	$word_limit = mp_core_get_post_meta($post_id, 'postgrid_excerpt_word_limit', 20);
	
	$read_more_text = __('...', 'mp_stacks_postgrid');
	
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
	
	//jQuery Trigger to reset all downloadgrid animations to their first frames
	$postgrid_output = '<script type="text/javascript">jQuery(document).ready(function($){ $(document).trigger("mp_core_animation_set_first_keyframe_trigger"); });</script>';
	
	//Loop through the stack group		
	if ( $postgrid_query->have_posts() ) {
		
		while( $postgrid_query->have_posts() ) : $postgrid_query->the_post(); 
		
				$grid_post_id = get_the_ID();
		
				$postgrid_output .= '<div class="mp-stacks-postgrid-item">';
					
					//If we should show the featured images
					if ($postgrid_show_featured_images){
						
						$postgrid_output .= '<div class="mp-stacks-postgrid-item-image-holder">';
						
							$postgrid_output .= '<div class="mp-stacks-postgrid-item-image-overlay"></div>';
							
							$postgrid_output .= '<a href="' . get_permalink() . '" class="mp-stacks-postgrid-image-link">';
							
							$postgrid_output .= '<img src="' . mp_core_the_featured_image($grid_post_id, $postgrid_featured_images_width, $postgrid_featured_images_height) . '" class="mp-stacks-postgrid-item-image" title="' . the_title_attribute( 'echo=0' ) . '" />';
							
							//Top Over
							$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-top">';
							
								$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-table">';
								
									$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-table-cell">';
									
										//If we should show the title over the image
										if ( strpos( $postgrid_titles_placement, 'over') !== false && strpos( $postgrid_titles_placement, 'top') !== false && $postgrid_show_titles){
											
											$postgrid_output .= mp_stacks_postgrid_title( $grid_post_id );
								
										}
										
										//If we should show the excerpt over the image
										if ( strpos( $postgrid_excerpt_placement, 'over') !== false && strpos( $postgrid_excerpt_placement, 'top') !== false && $postgrid_show_excerpts){
											
											$postgrid_output .= mp_stacks_postgrid_excerpt( $grid_post_id, $word_limit, $read_more_text );
											
										}
									
									$postgrid_output .= '</div>';
									
								$postgrid_output .= '</div>';
							
							$postgrid_output .= '</div>';
							
							//Middle Over
							$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-middle">';
							
								$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-table">';
								
									$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-table-cell">';
									
										//If we should show the title over the image
										if ( strpos( $postgrid_titles_placement, 'over') !== false && strpos( $postgrid_titles_placement, 'middle') !== false && $postgrid_show_titles){
											
											$postgrid_output .= mp_stacks_postgrid_title( $grid_post_id );
								
										}
										
										//If we should show the excerpt over the image
										if ( strpos( $postgrid_excerpt_placement, 'over') !== false && strpos( $postgrid_excerpt_placement, 'middle') !== false && $postgrid_show_excerpts){
											
											$postgrid_output .= mp_stacks_postgrid_excerpt( $grid_post_id, $word_limit, $read_more_text );
											
										}
									
									$postgrid_output .= '</div>';
									
								$postgrid_output .= '</div>';
							
							$postgrid_output .= '</div>';
							
							//Bottom Over
							$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-bottom">';
							
								$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-table">';
								
									$postgrid_output .= '<div class="mp-stacks-postgrid-over-image-text-container-table-cell">';
									
										//If we should show the title over the image
										if ( strpos( $postgrid_titles_placement, 'over') !== false && strpos( $postgrid_titles_placement, 'bottom') !== false && $postgrid_show_titles){
											
											$postgrid_output .= mp_stacks_postgrid_title( $grid_post_id );
								
										}
										
										//If we should show the excerpt over the image
										if ( strpos( $postgrid_excerpt_placement, 'over') !== false && strpos( $postgrid_excerpt_placement, 'bottom') !== false && $postgrid_show_excerpts){
											
											$postgrid_output .= mp_stacks_postgrid_excerpt( $grid_post_id, $word_limit, $read_more_text );
											
										}
									
									$postgrid_output .= '</div>';
									
								$postgrid_output .= '</div>';
							
							$postgrid_output .= '</div>';
							
							$postgrid_output .= '</a>';
							
						$postgrid_output .= '</div>';
						
					}
					
					//If we should show the title below the image
					if ( strpos( $postgrid_titles_placement, 'below') !== false && $postgrid_show_titles){
						
						$postgrid_output .= '<a href="' . get_permalink() . '" class="mp-stacks-postgrid-title-link">';	
							$postgrid_output .= mp_stacks_postgrid_title( $grid_post_id );
						$postgrid_output .= '</a>';	
			
					}
					//If we should show the excerpt below the image
					if ( strpos( $postgrid_excerpt_placement, 'below') !== false && $postgrid_show_excerpts){
						
						$postgrid_output .= '<a href="' . get_permalink() . '" class="mp-stacks-postgrid-title-link">';	
							$postgrid_output .= mp_stacks_postgrid_excerpt( $grid_post_id, $word_limit, $read_more_text );
						$postgrid_output .= '</a>';	
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
		$postgrid_output .= '<a mp_post_id="' . $post_id . '" mp_brick_offset="' . $post_offset . '" mp_stacks_postgrid_counter="' . $counter . '" class="button mp-stacks-postgrid-load-more-button">' . $postgrid_load_more_text . '</a>';	
	}
	
	$postgrid_output .= '</div>';
	
	echo $postgrid_output;
	
	die();
			
}
add_action( 'wp_ajax_mp_stacks_postgrid_load_more', 'mp_postgrid_ajax_load_more' );
add_action( 'wp_ajax_nopriv_mp_stacks_postgrid_load_more', 'mp_postgrid_ajax_load_more' );

/**
 * Get the HTML for the title in the grid
 *
 * @access   public
 * @since    1.0.0
 * @post_id  $post_id Int - The ID of the post to get the title of
 * @return   $html_output String - A string holding the html for a title in the grid
 */
function mp_stacks_postgrid_title( $post_id ){
	
	$postgrid_output = mp_stacks_grid_highlight_text_html( array( 
		'class_name' => 'mp-stacks-postgrid-item-title',
		'output_string' => get_the_title( $post_id ), 
	) );
	
	return $postgrid_output;
	
}

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
function mp_stacks_postgrid_excerpt( $post_id, $word_limit, $read_more_text ){
	
	//Add clear div to bump postgrid below title and icon
	$postgrid_output = '<div class="mp-stacks-postgrid-item-clearedfix"></div>';
	
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
	
		//$output_string .= $read_more_text;
		
	}
	
	$postgrid_output .= mp_stacks_grid_highlight_text_html( array( 
		'class_name' => 'mp-stacks-postgrid-item-excerpt',
		'output_string' => $output_string, 
	) );
	
	return $postgrid_output;	

	
}