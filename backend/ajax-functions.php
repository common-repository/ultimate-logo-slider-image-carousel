<?php function toast_carousel_update_preview(){
$images = $_POST['images'];
foreach($images as $image): ?>
<div class="carousel-image" id="<?php echo $image[id]; ?>">
<?php echo wp_get_attachment_image($image[id], 'medium'); ?> 
<i class="dashicons-admin-links link <?php if($image[url] == ''): ?>not-selected<?php endif; ?>" data-url="<?php echo $image[url]; ?>"></i>
<i class="dashicons-no remove-image"></i>
</div>
<?php endforeach;
die();
}
add_action('wp_ajax_nopriv_toast_carousel_update_preview' , 'toast_carousel_update_preview');
add_action('wp_ajax_toast_carousel_update_preview' , 'toast_carousel_update_preview'); ?>