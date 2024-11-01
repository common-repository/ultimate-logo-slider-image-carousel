<?php function toast_carousel($atts){
$id = $atts['id'];

$images = get_post_meta($id , 'toast_carousel_images', true);
$images_array = json_decode($images);
$slider_speed = 5;
$new_tab = false;
$navi_buttons = false;
$active_scale = 1.5;
$opacity = 0.1;
$images_visible = 3;
$images_visible_mobile = 3;
$crop_images = false;
$transition_speed = .5;
$three_dimensions = true;
$image_padding = 15;
$navi_color = 'black';
$navi_icon = 1; ?>

<?php if(count($images_array) < $images_visible + 1): ?>
<?php if(current_user_can('editor') || current_user_can('administrator')): ?> 
<div class="toast-carousel-error-message">Please add more images to your slider or lower 'Number of images visible in the viewport' setting.</div>
<?php endif; ?>
<?php else: ?>
<div class="toast-carousel" id="slider-id-<?php echo $id; ?>" data-3d="<?php echo $three_dimensions; ?>" data-slider-speed="<?php echo $slider_speed; ?>000" data-transition-speed="<?php echo $transition_speed; ?>" data-active-scale="<?php echo $active_scale; ?>" data-opacity="<?php echo $opacity; ?>" data-images-visible="<?php echo $images_visible ?>" <?php if(wp_is_mobile()): ?>data-images-visible-mobile="<?php echo $images_visible_mobile; ?>"<?php endif; ?> data-image-padding="<?php echo $image_padding; ?>">
<?php if($navi_buttons): ?>
<?php if($navi_icon == 1): ?>
<?php $left = 'dashicons-arrow-left'; ?>
<?php $right = 'dashicons-arrow-right'; ?>
<?php elseif($navi_icon == 2): ?>
<?php $left = 'dashicons-arrow-left-alt'; ?>
<?php $right = 'dashicons-arrow-right-alt'; ?>
<?php else: ?>
<?php $left = 'dashicons-arrow-left-alt2'; ?>
<?php $right = 'dashicons-arrow-right-alt2'; ?>
<?php endif; ?>

<i class="<?php echo $left; ?> toast-carousel-navigation backwards" style="background-color:<?php echo $navi_color; ?>"></i>
<i class="<?php echo $right; ?> toast-carousel-navigation forwards" style="background-color:<?php echo $navi_color; ?>"></i>
<?php endif; ?>
<div class="toast-carousel-track" style="transition:all <?php echo $transition_speed; ?>s">
<?php foreach($images_array as $image){ ?>
<?php if(is_int($image->id)): ?>
<div class="toast-carousel-image">
<?php if($image->url): ?>
<a href="<?php echo $image->url; ?>" <?php if($new_tab): ?>target="_blank"<?php endif; ?>>
<?php endif; ?>

<?php if($crop_images): ?>
<?php $image_height = wp_get_attachment_metadata($image->id, full)['height']; ?>
<?php $image_width = wp_get_attachment_metadata($image->id, full)['width']; ?>
<?php $alt = get_post_meta($image->id, '_wp_attachment_image_alt', true); ?>
<?php if($image_height > $image_width): ?>
<?php $dimensions = $image_width; ?>
<?php else: ?>
<?php $dimensions = $image_height; ?>
<?php endif; ?>
<?php $new_image = toast_carousel_aq_resize(wp_get_attachment_url($image->id, 'full'), $dimensions, $dimensions, true); ?>
<img src="<?php echo esc_url( $new_image ); ?>" alt="<?php echo $alt; ?>" />
<?php else: ?>
<?php echo wp_get_attachment_image($image->id, 'full'); ?>
<?php endif; ?>

<?php if($image->url): ?>
</a>
<?php endif; ?>
</div>
<?php endif; ?>
<?php } ?>
</div>
</div>
<?php endif; ?>
<?php }
add_shortcode('toast_carousel', 'toast_carousel');