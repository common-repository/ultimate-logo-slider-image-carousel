jQuery(window).ready(function(){

jQuery('.toast-carousel').each(function(){
var logoSlider = jQuery(this);
var index = 0;
var slideIndex = 0;
var max = jQuery(this).find('.toast-carousel-image').length;
var maxHeight = 0;
var slideSpeed = jQuery(this).attr('data-slider-speed');
var sliderTransition = jQuery(this).attr('data-transition-speed');
var activeScale = jQuery(this).attr('data-active-scale');
var opacity = jQuery(this).attr('data-opacity');
var imagesVisible = parseInt(jQuery(this).attr('data-images-visible'));
var imagesVisibleMobile = parseInt(jQuery(this).attr('data-images-visible-mobile'));
if(imagesVisibleMobile){
imagesVisible = imagesVisibleMobile;
}
var imageWidth = 100 / imagesVisible; 
var originalActiveItem = Math.round(imagesVisible / 2);
var threeDimensional = jQuery(this).attr('data-3d');
var imagesPadding = jQuery(this).attr('data-image-padding');

//POSITION ITEMS AS SHOULD BE
jQuery(this).find('.toast-carousel-image').each(function(){
var positioning = index * imageWidth;
index++;
jQuery(this).css({'left': positioning+'%', 'width': imageWidth+'%'});
jQuery(this).find('img').css({'transition': 'all '+ sliderTransition+'s', 'padding': imagesPadding+'%'})

if(imagesVisible % 2 == 1){
jQuery(this).find('img').css({'opacity': opacity});
}

})

setTimeout(function(){
jQuery(logoSlider).find('.toast-carousel-image').each(function(){
//SET HEIGHT OF LOGO TRACK AND FIRST ACTIVE ITEM
if(jQuery(this).find('img').height() > maxHeight){
maxHeight = jQuery(this).find('img').height();
}
});

//SET MAX HEIGHT IF FOCUS ITEMS ENABLED
if(imagesVisible % 2 == 1){
maxHeight = maxHeight * activeScale;
}
jQuery(logoSlider).css({'opacity': 1});
jQuery(logoSlider).find('.toast-carousel-track').height(maxHeight)

}, 400)

jQuery(logoSlider).find('.toast-carousel-image:nth-of-type('+originalActiveItem+')').addClass('active-logo');

function previousImagesScale(){
var itemsAmount = Math.floor(imagesVisible / 2);
var previousAmount = itemsAmount + 1;
jQuery(logoSlider).find('.toast-carousel-image.active-logo').prevAll().each(function(){
previousAmount--; 
var previousAmountOtherWay = (itemsAmount - previousAmount) + 1
var thisOpacity = 1 - (((1 - ((opacity * 1000) / 1000)) / itemsAmount) * previousAmountOtherWay)
var thisScale =  (((activeScale - 1) / itemsAmount) * previousAmount) + 1 - ((activeScale - 1) / itemsAmount);

jQuery(this).css({'z-index': previousAmount});
if(opacity != 1){
jQuery(this).find('img').css({'opacity': thisOpacity});
}
if(activeScale != 1){
 jQuery(this).find('img').css({'transform': 'scale('+thisScale / 1.5+')'});
}

})

}

function nextImagesScale(){
var itemsAmount = Math.floor(imagesVisible / 2);
var nextAmount = itemsAmount + 1;
jQuery(logoSlider).find('.toast-carousel-image.active-logo').nextAll().each(function(){
nextAmount--; 
var nextAmountOtherWay = (itemsAmount - nextAmount) + 1;
var thisOpacity = 1 - (((1 - ((opacity * 1000) / 1000)) / itemsAmount) * nextAmountOtherWay)
var thisScale =  (((activeScale - 1) / itemsAmount) * nextAmount) + 1 - ((activeScale - 1) / itemsAmount);

jQuery(this).css({'z-index': nextAmount});
if(opacity != 1){
jQuery(this).find('img').css({'opacity': thisOpacity});
}
if(activeScale != 1){
 jQuery(this).find('img').css({'transform': 'scale('+thisScale / 1.5+')'});
}

})
}

//FOCUS ITEMS CSS
if(imagesVisible % 2 == 1){
jQuery(logoSlider).find('.toast-carousel-image.active-logo img').css({'transform': 'scale('+activeScale+')', 'opacity': 1});

if(threeDimensional == 'on'){
previousImagesScale();
nextImagesScale();
}

}

//NEXT SLIDE FUNCTION
function nextSlide(){
	slideIndex++;
	var positioning = -slideIndex * imageWidth;
	var sliderTrackWidth = parseInt(jQuery(logoSlider).find('.toast-carousel-image:last-child').css('left'));
	jQuery(logoSlider).find('.toast-carousel-track').css({'transform': 'translateX('+positioning+'%)'});
	
	//APPEND SLIDE END
	var AppendItem = jQuery(logoSlider).find('.toast-carousel-image:first-child');
	setTimeout(function(){
	jQuery(AppendItem).appendTo(jQuery(logoSlider).find('.toast-carousel-track')).css({'left': 'calc('+sliderTrackWidth+'px + '+imageWidth+'%)'});
	}, sliderTransition * 1000);
	
	jQuery(logoSlider).find('.toast-carousel-image.active-logo').next().addClass('new-active-logo');
	jQuery(logoSlider).find('.toast-carousel-image').removeClass('active-logo');
	jQuery(logoSlider).find('.new-active-logo').removeClass('new-active-logo').addClass('active-logo');
	
	//FOCUS ITEMS CSS
	if(imagesVisible % 2 == 1){
	jQuery(logoSlider).find('.toast-carousel-image img').css({'transform': 'scale(1)', 'opacity': opacity});
	jQuery(logoSlider).find('.toast-carousel-image.active-logo img').css({'transform': 'scale('+activeScale+')', 'opacity': 1});
	
	if(threeDimensional == 'on'){
	previousImagesScale();
	nextImagesScale();
	}
	
	}
}

//BACK SLIDE FUNCTION
var backPosition = 0;
function backSlide(){
	slideIndex--;
	var positioning = -slideIndex * imageWidth;
	var firstItemPosition = parseInt(jQuery(logoSlider).find('.toast-carousel-image:first-child').css('left'));
	jQuery(logoSlider).find('.toast-carousel-track').css({'transform': 'translateX('+positioning+'%)'});
	//PREPEND SLIDE END
	jQuery(logoSlider).find('.toast-carousel-image:last-child').prependTo(jQuery(logoSlider).find('.toast-carousel-track')).css({'left': 'calc('+firstItemPosition+'px - '+imageWidth+'%)'});
	
	jQuery(logoSlider).find('.toast-carousel-image.active-logo').prev().addClass('new-active-logo');
	jQuery(logoSlider).find('.toast-carousel-image').removeClass('active-logo');
	jQuery(logoSlider).find('.new-active-logo').removeClass('new-active-logo').addClass('active-logo');
	
	//FOCUS ITEMS CSS
	if(imagesVisible % 2 == 1){
	jQuery(logoSlider).find('.toast-carousel-image img').css({'transform': 'scale(1)', 'opacity': opacity});
	jQuery(logoSlider).find('.toast-carousel-image.active-logo img').css({'transform': 'scale('+activeScale+')', 'opacity': 1});
	
	if(threeDimensional == 'on'){
	previousImagesScale();
	nextImagesScale();
	}
	
	}
}

//AUTOMATIC LOOP OF ITEMS
var loopTimer;
function loopSlide(logoSlider){

	//BUTTON CLICKS
    var clickButton = jQuery(logoSlider).find('.toast-carousel-navigation');
   	clickButton.off();
    window.setTimeout(function(){ 
        jQuery(clickButton).on('click', function(){
        if(jQuery(this).hasClass('forwards')){
        nextSlide();
		clearTimeout(loopTimer);
		loopSlide(logoSlider);
		}else{
		backSlide();
		clearTimeout(loopTimer);
		loopSlide(logoSlider);
		}
        
        });
    },sliderTransition * 1000);
    //END OF BUTTON CLICKS


loopTimer = setTimeout(function(){
	nextSlide();
	loopSlide(logoSlider);
}, slideSpeed)

}

//START LOOP
loopSlide(logoSlider);

})

})