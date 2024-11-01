jQuery(window).ready(function(){
		
		//REMOVE IMAGES
		jQuery('body').on('click', '.carousel-image .remove-image', function(){
		var id = jQuery(this).parents('.carousel-image').attr('id');
		jQuery(this).parents('.carousel-image').remove();
		var currentJSON = jQuery('input[name="toast_carousel_images"]').val();
		var json = JSON.parse(currentJSON);
		var i = -1;
		jQuery(json).each(function(){
		i++;
		if(this.id == id){
		json.splice(i, 1);
		}
		})
		jQuery('input[name="toast_carousel_images"]').val(JSON.stringify(json));
		})
		
		//ADDING URLS
		jQuery('body').on('click', '.link', function(){
		var item_id = jQuery(this).parent('.carousel-image').attr('id');
		var currenturl = jQuery(this).attr('data-url');
		if(! jQuery(this).find('.url-selector').length > 0){
		jQuery('.dashicons-admin-links').removeClass('open');
		jQuery('.dashicons-admin-links').find('.url-selector').remove();
		jQuery(this).addClass('open');
		jQuery(this).append('<input type="text" class="url-selector" value="'+currenturl+'">');
		jQuery(this).val(currenturl);
		}
		})	
		
		jQuery('body').on('keydown', '.url-selector', function(e){
		var itemID = jQuery(this).parents('.carousel-image').attr('id');
		var input = jQuery('.url-selector').val();
		if(e.key == 'Enter'){
		e.preventDefault();
		var currentJSON = jQuery('input[name="toast_carousel_images"]').val();
		var json = JSON.parse(currentJSON);
		
		jQuery(json).each(function(){
		if(this.id == itemID){
		this.url = input;
		}
		jQuery('input[name="toast_carousel_images"]').val(JSON.stringify(json));
		})
		
		if(jQuery('.url-selector').val() != ''){
		jQuery(this).parent('.link').removeClass('not-selected');
		}else{
		jQuery(this).parent('.link').addClass('not-selected');
		}
		
		jQuery(this).parent('.link').attr('data-url', input);
		jQuery(this).parent('.link').removeClass('open');
		jQuery(this).remove();
		}
		})
		
		//RANGE SLIDER
		jQuery('input[type="range"]').on('input', function(){
		var value = jQuery(this).val();
		var name = jQuery(this).attr('name');
		if(jQuery(this).attr('data-percentage') == 'true'){
		jQuery('.range-amount[for="'+name+'"]').text(value+'%');
		}else{
		jQuery('.range-amount[for="'+name+'"]').text(value);
		}
		})

		//TABS
		jQuery('.toast-carousel-tabs .tab-select').on('click', function(){
		
		var tab = jQuery(this).attr('data-tab');
		jQuery('.toast-carousel-tab').removeClass('active');
		jQuery('.toast-carousel-tab[data-tab="'+tab+'"]').addClass('active');
		
		jQuery('.toast-carousel-tabs .tab-select').removeClass('active');
		jQuery('.toast-carousel-tabs .tab-select[data-tab="'+tab+'"]').addClass('active');
		})
		
		//REMOVE METABOX
		jQuery('#logo_slider_settings, #toast_carousel_image').removeClass('postbox');
		
		//COLOR PICKERS
		jQuery('.wp-color-picker').wpColorPicker();
		
		
		//CONDITIONAL LOGIC
		function conditionalLogic(){
		var imagesViewable = jQuery('select[name="toast_carousel_images_visible"]').val();
		var FocusEnabled = false;
		
		if(imagesViewable % 2 == 0){
		FocusEnabled = true
		}else{
		FocusEnabled = false;
		}
		
		if(FocusEnabled){
		jQuery('.toast-carousel-tabs .tab-select[data-tab="focus"]').hide();
		}else{
		jQuery('.toast-carousel-tabs .tab-select[data-tab="focus"]').show();
		}
		
		var showNav = jQuery('#toast_carousel_navigation_buttons').attr('checked');
		if(showNav != 'checked'){
		jQuery('.navigation-conditional').hide();
		}else{
		jQuery('.navigation-conditional').show();
		}
		
		
		}
		
		conditionalLogic();
		
		jQuery('select, input').on('change', function(){
		conditionalLogic();
		})
		
})