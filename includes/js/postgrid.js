jQuery(document).ready(function($){
		
	$( document ).on( 'click', '.mp-stacks-postgrid-load-more-button', function(event){
		
		event.preventDefault();
		
		// Use ajax to add the persons email to the list
		var postData = {
			action: 'mp_stacks_postgrid_load_more',
			mp_stacks_postgrid_brick_id: $(this).attr( 'mp_brick_id' ),
			mp_stacks_postgrid_offset: $(this).attr( 'mp_brick_offset' ),
			mp_stacks_postgrid_counter: $(this).attr( 'mp_stacks_postgrid_counter' ),
			
		};
		
		var the_postgrid_container = $(this).parent();
		var the_button = $(this);
		
		//Ajax to make new stack
		$.ajax({
			type: "POST",
			data: postData,
			url: mp_stacks_frontend_vars.ajaxurl,
			success: function (response) {
				
				the_button.replaceWith(response);
			
			}
		}).fail(function (data) {
			console.log(data);
		});	
		
	});
	
}); 