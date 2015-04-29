<?php 
/**
 * This file contains the function which hooks to a brick's content output
 *
 * @since 1.0.0
 *
 * @package    MP Stacks PostGrid
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2015, Mint Plugins
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
	
	//If this stack content type is NOT set to be a postgrid	
	if ($mp_stacks_content_type != 'postgrid'){
		
		return $default_content_output;
		
	}
	
	//Because we run the same function for this and for "Load More" ajax, we call a re-usable function which returns the output
	$postgrid_output = mp_stacks_postgrid_output( $post_id );
	
	//Return
	return $postgrid_output['postgrid_output'] . $postgrid_output['load_more_button'] . $postgrid_output['postgrid_after'];

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
	
	if ( !isset( $_POST['mp_stacks_grid_post_id'] ) || !isset( $_POST['mp_stacks_grid_offset'] ) ){
		return;	
	}
	
	$post_id = $_POST['mp_stacks_grid_post_id'];
	$post_offset = $_POST['mp_stacks_grid_offset'];

	//Because we run the same function for this and for "Load More" ajax, we call a re-usable function which returns the output
	$postgrid_output = mp_stacks_postgrid_output( $post_id, $post_offset );
	
	echo json_encode( array(
		'items' => $postgrid_output['postgrid_output'],
		'button' => $postgrid_output['load_more_button'],
		'animation_trigger' => $postgrid_output['animation_trigger']
	) );
	
	die();
			
}
add_action( 'wp_ajax_mp_stacks_postgrid_load_more', 'mp_postgrid_ajax_load_more' );
add_action( 'wp_ajax_nopriv_mp_stacks_postgrid_load_more', 'mp_postgrid_ajax_load_more' );

/**
 * Run the Grid Loop and Return the HTML Output, Load More Button, and Animation Trigger for the Grid
 *
 * @access   public
 * @since    1.0.0
 * @param    Void
 * @param    $post_id Int - The ID of the Brick
 * @param    $post_offset Int - The number of posts deep we are into the loop (if doing ajax). If not doing ajax, set this to 0;
 * @return   Array - HTML output from the Grid Loop, The Load More Button, and the Animation Trigger in an array for usage in either ajax or not.
 */
function mp_stacks_postgrid_output( $post_id, $post_offset = NULL ){
	
	global $wp_query;
	
	//Start up the PHP session if there isn't one already
	if( !session_id() ){
		session_start();
	}
	
	//If we are NOT doing ajax get the parent's post id from the wp_query.
	if ( !defined( 'DOING_AJAX' ) ){
		$queried_object_id = $wp_query->queried_object_id;
		$_SESSION['mp_stacks_downloadgrid_queryobjid_' . $post_id] = $queried_object_id;
	}
	//If we are doing ajax, get the parent's post id from the PHP session where it was stored on initial the page load.
	else{
		$queried_object_id = $_SESSION['mp_stacks_downloadgrid_queryobjid_' . $post_id];
	}
	
	//Get this Brick Info
	$post = get_post($post_id);
	
	$postgrid_output = NULL;
	
	//Get Original Download Taxonomy Term to Loop through (old way)
	$postgrid_taxonomy_term = mp_core_get_post_meta($post_id, 'postgrid_taxonomy_term', '');
	
	//Get taxonomy term repeater (new way)
	$postgrid_taxonomy_terms = mp_core_get_post_meta($post_id, 'postgrid_taxonomy_terms', '');
	
	//Download per row
	$postgrid_per_row = mp_core_get_post_meta($post_id, 'postgrid_per_row', '3');
	
	//Download per page
	$postgrid_per_page = mp_core_get_post_meta($post_id, 'postgrid_per_page', '9');
	
	//Set the args for the new query
	$postgrid_args = array(
		'order' => 'DESC',
		'paged' => 0,
		'post_status' => 'publish',
		'posts_per_page' => $postgrid_per_page,
		'tax_query' => array(
			'relation' => 'OR',
		)
	);	
		
	//If there are tax terms selected to show (the "new" way with multiple terms)
	if ( is_array( $postgrid_taxonomy_terms ) && !empty( $postgrid_taxonomy_terms[0]['taxonomy_term'] ) ){
		
		//Loop through each term the user added to this postgrid
		foreach( $postgrid_taxonomy_terms as $postgrid_taxonomy_term ){
			
			//If we should show related posts
			if ( $postgrid_taxonomy_term['taxonomy_term'] == 'related_posts' ){
				
				$tags = wp_get_post_terms( $queried_object_id, apply_filters( 'mp_stacks_postgrid_related_posts_tax_slug', 'post_tag', $post_id ) );
				
				if ( is_object( $tags ) ){
					$tags_array = $tags;
				}
				elseif (is_array( $tags ) ){
					$tags_array = isset( $tags[0] ) ? $tags[0] : NULL;
				}
				
				$tag_slugs = wp_get_post_terms( $queried_object_id, apply_filters( 'mp_stacks_postgrid_related_posts_tax_slug', 'post_tag', $post_id ), array("fields" => "slugs") );
				
				//Add the related tags as a tax_query to the WP_Query
				$postgrid_args['tax_query'][] = array(
					'taxonomy' => apply_filters( 'mp_stacks_postgrid_related_posts_tax_slug', 'post_tag', $post_id ),
					'field'    => 'slug',
					'terms'    => $tag_slugs,
				);
							
			}
			else{
				
				//Add this term to the tax_query
				$postgrid_args['tax_query'][] = array(
					'taxonomy' => apply_filters( 'mp_stacks_postgrid_main_tax_slug', 'category', $post_id ),
					'field'    => 'id',
					'terms'    => $postgrid_taxonomy_term['taxonomy_term'],
					'operator' => 'IN'
				);
			}
		}
	}
	//if there is a single tax term to show (this is backward compatibility for before the terms selector was repeatable).
	else if( !empty( $postgrid_taxonomy_term ) ){
		
		//Get PostGrid Metabox Repeater Array
		$termid_taxname = explode( '*', $postgrid_taxonomy_term );
		
		if ( !isset( $termid_taxname[1] ) || !isset( $termid_taxname[0] ) ){
			return;	
		}
			
		//Add this term to the tax_query
		$postgrid_args['tax_query'][] = array(
			'taxonomy' => $termid_taxname[1],
			'field'    => 'id',
			'terms'    => $termid_taxname[0],
			'operator' => 'IN'
		);
	}
	//Otherwise there's nothing to show so get out of here
	else{
		return false;	
	}
	
	//If we are using Offset
	if ( !empty( $post_offset ) ){
		//Add offset args to the WP_Query
		$postgrid_args['offset'] = $post_offset;
	}
	//Alternatively, if we are using brick pagination
	else if ( isset( $wp_query->query['mp_brick_pagination_slugs'] ) ){
		
		//Get the brick slug
		$pagination_brick_slugs = explode( '|||', $wp_query->query['mp_brick_pagination_slugs'] );
		
		$pagination_brick_page_numbers = explode( '|||', $wp_query->query['mp_brick_pagination_page_numbers'] );
		
		$brick_pagination_counter = 0;
	
		//Loop through each brick in the url which has pagination
		foreach( $pagination_brick_slugs as $brick_slug ){
			//If this brick is the one we want to paginate
			if ( $brick_slug == $post->post_name ){
				//Add page number to the WP_Query
				$postgrid_args['paged'] = $pagination_brick_page_numbers[$brick_pagination_counter];
				//Set the post offset variable to start at the end of the current page
				$post_offset = isset( $postgrid_args['paged'] ) ? ($postgrid_args['paged'] * $postgrid_per_page) - $postgrid_per_page : 0;
			}
			
			//Increment the counter which aligns $pagination_brick_page_numbers to $pagination_brick_slugs
			$brick_pagination_counter = $brick_pagination_counter + 1;
		}
		
	}
	
	//Show Download Images?
	$postgrid_featured_images_show = mp_core_get_post_meta_checkbox($post_id, 'postgrid_featured_images_show', true);
	
	//Download Image width and height
	$postgrid_featured_images_width = mp_core_get_post_meta( $post_id, 'postgrid_featured_images_width', '300' );
	$postgrid_featured_images_height = mp_core_get_post_meta( $post_id, 'postgrid_featured_images_height', '200' );
	
	//Get the options for the grid placement - we pass this to the action filters for text placement
	$grid_placement_options = apply_filters( 'mp_stacks_postgrid_placement_options', NULL, $post_id );
		
	//Get the JS for animating items - only needed the first time we run this - not on subsequent Ajax requests.
	if ( !defined('DOING_AJAX') ){
		
		//Here we set javascript for this grid
		$postgrid_output .= apply_filters( 'mp_stacks_grid_js', NULL, $post_id, 'postgrid' );
							
	}
	
	//Add HTML that sits before the "grid" div
	$postgrid_output .= !defined('DOING_AJAX') ? apply_filters( 'mp_stacks_grid_before', NULL, $post_id, 'postgrid', $postgrid_taxonomy_terms ) : NULL; 
		
	//Get Download Output
	$postgrid_output .= !defined('DOING_AJAX') ? '<div class="mp-stacks-grid ' . apply_filters( 'mp_stacks_grid_classes', NULL, $post_id, 'postgrid' ) . '">' : NULL;
		
	//Create new query for stacks
	$postgrid_query = new WP_Query( apply_filters( 'postgrid_args', $postgrid_args ) );
	
	$total_posts = $postgrid_query->found_posts;
	
	//Loop through the stack group		
	if ( $postgrid_query->have_posts() ) { 
		
		while( $postgrid_query->have_posts() ) : $postgrid_query->the_post(); 
				
				$grid_post_id = get_the_ID();
								
				//Reset Grid Classes String
				$source_counter = 0;
				$post_source_num = NULL;
				$grid_item_inner_bg_color = NULL;
				
				//If there are multiple tax terms selected to show
				if ( is_array( $postgrid_taxonomy_terms ) && !empty( $postgrid_taxonomy_terms[0]['taxonomy_term'] ) ){
					
					//Loop through each "repeat" source the user added to this postgrid
					foreach( $postgrid_taxonomy_terms as $postgrid_taxonomy_term ){
												
						//If we should show related posts
						if ( $postgrid_taxonomy_term['taxonomy_term'] == 'related_posts' ){
							
							//Store the source this post belongs to
							$post_source_num = $source_counter;
														
							//Add the bg color for this post
							if ( !empty( $postgrid_taxonomy_term['taxonomy_bg_color'] ) ){
								$grid_item_inner_bg_color = $postgrid_taxonomy_term['taxonomy_bg_color'];
							}
						}
						//If the current post (in this loop through the source repeats) has the term applied to this repeat
						else if ( has_term( $postgrid_taxonomy_term['taxonomy_term'], 'category', $grid_post_id ) ){
							
							//Store the source this post belongs to
							$post_source_num = $source_counter;
														
							//Set the bg color for this post
							if ( !empty( $postgrid_taxonomy_term['taxonomy_bg_color'] ) ){
								$grid_item_inner_bg_color = $postgrid_taxonomy_term['taxonomy_bg_color'];
							}
							
						}
						
						$source_counter = $source_counter + 1;
						
					}
				}
				
				//Add our custom classes to the grid-item 
				$class_string = 'mp-stacks-grid-source-' . $post_source_num . ' mp-stacks-grid-item mp-stacks-grid-item-' . $grid_post_id . ' ';
				//Add all posts that would be added from the post_class wp function as well
				$class_string = join( ' ', get_post_class( $class_string, $grid_post_id ) );
				$class_string = apply_filters( 'mp_stacks_grid_item_classes', $class_string, $post_id, 'postgrid' ); 
								
				//Get the Grid Item Attributes
				$grid_item_attribute_string = apply_filters( 'mp_stacks_grid_attribute_string', NULL, $postgrid_taxonomy_terms, $grid_post_id, $post_id, 'postgrid', $post_source_num );
								
				$postgrid_output .= '<div class="' . $class_string . '" ' . $grid_item_attribute_string . '>';
					$postgrid_output .= '<div class="mp-stacks-grid-item-inner" ' . (!empty( $grid_item_inner_bg_color ) ? 'mp-default-bg-color="' . $grid_item_inner_bg_color . '"' : NULL) . '>';					
					
					//Add htmloutput directly inside this grid item
					$postgrid_output .= apply_filters( 'mp_stacks_grid_inside_grid_item_top', NULL, $postgrid_taxonomy_terms, $post_id, 'postgrid', $grid_post_id, $post_source_num );
															
					//Microformats
					$postgrid_output .= '
					<article class="microformats hentry" style="display:none;">
						<h2 class="entry-title">' . get_the_title() . '</h2>
						<span class="author vcard"><span class="fn">' . get_the_author() . '</span></span>
						<time class="published" datetime="' . get_the_time('Y-m-d H:i:s') . '">' . get_the_date() . '</time>
						<time class="updated" datetime="' . get_the_modified_date('Y-m-d H:i:s') . '">' . get_the_modified_date() .'</time>
						<div class="entry-summary">' . mp_core_get_excerpt_by_id($grid_post_id) . '</div>
					</article>';
					
					//If we should show the featured images
					if ($postgrid_featured_images_show){
						
						$postgrid_output .= '<div class="mp-stacks-grid-item-image-holder">';
						
							$postgrid_output .= '<div class="mp-stacks-grid-item-image-overlay"></div>';
							
							$postgrid_output .= '<a href="' . get_permalink() . '" class="mp-stacks-grid-image-link">';
							
							//Get the featured image and crop according to the user's specs
							if ( $postgrid_featured_images_height > 0 && !empty( $postgrid_featured_images_height ) ){
								$featured_image = mp_core_the_featured_image($grid_post_id, $postgrid_featured_images_width, $postgrid_featured_images_height);
							}
							else{
								$featured_image = mp_core_the_featured_image( $grid_post_id, $postgrid_featured_images_width );	
							}
							
							$postgrid_output .= '<img src="' . $featured_image . '" class="mp-stacks-grid-item-image" title="' . the_title_attribute( 'echo=0' ) . '" alt="' . the_title_attribute( 'echo=0' ) . '" />';
							
							//Top Over
							$postgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-top">';
							
								$postgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-table">';
								
									$postgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-table-cell">';
										
										//Filter Hook to output HTML into the "Top" and "Over" position on the featured Image
										$postgrid_output .= apply_filters( 'mp_stacks_postgrid_top_over', NULL, $grid_post_id, $grid_placement_options );
									
									$postgrid_output .= '</div>';
									
								$postgrid_output .= '</div>';
							
							$postgrid_output .= '</div>';
							
							//Middle Over
							$postgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-middle">';
							
								$postgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-table">';
								
									$postgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-table-cell">';
									
										//Filter Hook to output HTML into the "Middle" and "Over" position on the featured Image
										$postgrid_output .= apply_filters( 'mp_stacks_postgrid_middle_over', NULL, $grid_post_id, $grid_placement_options );
									
									$postgrid_output .= '</div>';
									
								$postgrid_output .= '</div>';
							
							$postgrid_output .= '</div>';
							
							//Bottom Over
							$postgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-bottom">';
							
								$postgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-table">';
								
									$postgrid_output .= '<div class="mp-stacks-grid-over-image-text-container-table-cell">';
										
										//Filter Hook to output HTML into the "Bottom" and "Over" position on the featured Image
										$postgrid_output .= apply_filters( 'mp_stacks_postgrid_bottom_over', NULL, $grid_post_id, $grid_placement_options );
									
									$postgrid_output .= '</div>';
									
								$postgrid_output .= '</div>';
							
							$postgrid_output .= '</div>';
							
							$postgrid_output .= '</a>';
							
						$postgrid_output .= '</div>';
						
					}
					
					//Filter Hook to output HTML into the "Below" position on the featured Image
					$postgrid_below = apply_filters( 'mp_stacks_postgrid_below', NULL, $grid_post_id, $grid_placement_options );
						
					if ( !empty( $postgrid_below ) ){
						//Below Image Area Container:
						$postgrid_output .= '<div class="mp-stacks-grid-item-below-image-holder">';
						
							//Filter Hook to output HTML into the "Below" position on the featured Image
							$postgrid_output .= $postgrid_below;
							
						$postgrid_output .= '</div>';
					}
				
				$postgrid_output .= '</div></div>';
								
				//Increment Offset
				$post_offset = $post_offset + 1;
				
		endwhile;
	}
	
	//If we're not doing ajax, add the stuff to close the postgrid container and items needed after
	if ( !defined('DOING_AJAX') ){
		$postgrid_output .= '</div>';
	}
	
	
	//jQuery Trigger to reset all postgrid animations to their first frames
	$animation_trigger = '<script type="text/javascript">jQuery(document).ready(function($){ $(document).trigger("mp_core_animation_set_first_keyframe_trigger"); });</script>';
	
	//Assemble args for the load more output
	$load_more_args = array(
		 'meta_prefix' => 'postgrid',
		 'total_posts' => $total_posts, 
		 'posts_per_page' => $postgrid_per_page, 
		 'paged' => $postgrid_args['paged'], 
		 'post_offset' => $post_offset,
		 'brick_slug' => $post->post_name
	);
	
	return array(
		'postgrid_output' => $postgrid_output,
		'load_more_button' => apply_filters( 'mp_stacks_postgrid_load_more_html_output', $load_more_html = NULL, $post_id, $load_more_args ),
		'animation_trigger' => $animation_trigger,
		'postgrid_after' => '<div class="mp-stacks-grid-item-clearedfix"></div><div class="mp-stacks-grid-after"></div>'
	);
		
}