<?php add_action( 'admin_head', 'toast_carousel_script' );
function toast_carousel_script() {
	global $post_type; ?>
	
	<?php if($post_type == 'toast_carousels'): ?>
	<?php $my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 ); ?>
	<script type='text/javascript'>
		jQuery( document ).ready( function( $ ) {
		
			//IMAGE SELECTION
			var file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; 
			var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>;
			jQuery('.toast-carousel-choose-images').on('click', function( event ){
				event.preventDefault();
				if ( file_frame ) {
					file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
					file_frame.open();
					return;
				} else {
					wp.media.model.settings.post.id = set_to_post_id;
				}
				file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Add images to logo slider',
					button: {
						text: 'Select',
					},
					multiple: 'add'
				});
				
				//LOAD SELECTED IMAGES
				file_frame.on( 'open', function() {
				var selection = file_frame.state().get('selection');
				var imagesList = jQuery('input[name="toast_carousel_images"]').val();
				jQuery('.toast-carousel-images-preview').find('.carousel-image').each(function(){
				selection.push(wp.media.attachment(jQuery(this).attr('id')));
				})
				});
				
				
				file_frame.on( 'select', function() {
					attachment = file_frame.state().get('selection').toJSON();
					var currentIDS = [];
					var items = [];
					
					if(jQuery('input[name="toast_carousel_images"]').val() !== '[{' && jQuery('input[name="toast_carousel_images"]').val()){
					var currentJSON = JSON.parse(jQuery('input[name="toast_carousel_images"]').val());
					jQuery(currentJSON).each(function(){
						obj = new Object();
						obj.id = this.id;
						obj.url = this.url;
						currentIDS.push(obj);
					})
					}
					
					jQuery(attachment).each(function(){
						
						var newitemid = this.id;
						var newitemurl = '';
						
						obj = new Object();
						
						jQuery(currentIDS).each(function(){
						if(newitemid == this.id){	
						newitemurl = this.url;
						}
						})
						
						obj.id = newitemid;
						obj.url = newitemurl;
						
						items.push(obj); 
						
					})
					jQuery('input[name="toast_carousel_images"]').val(JSON.stringify(items));

					jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'post',
        data: { action: 'toast_carousel_update_preview',
        		images: items
        		},
        success: function(toast_carousel_update_preview){
       jQuery('.toast-carousel-images-preview').html(toast_carousel_update_preview);
        }
    });
					

					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
				});
					// Finally, open the modal
					file_frame.open();
			});
			
		});
	</script>
	<?php endif; ?>
<?php }