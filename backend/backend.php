<?php function toast_carousel_setup(){
register_post_type('toast_carousels', array(
										'labels' => array(
														'name' => __('Carousels'),
														'singular_name' => __('Carousel', 'toast_carousel'),
														'edit_item'   	=> __('Edit Carousel', 'toast_carousel' ),
														'view_item'             => __( 'View Carousel', 'toast_carousel' ),
														),
										 'public'      => true,
										 'publicly_queryable'  => false,
                           				 'has_archive' => false,
                           				 'exclude_from_search' => true,
                           				 'show_in_nav_menus' => false,
                           				 'show_in_menu' => true,
                           				 'supports' => 'title',
                           				 'menu_icon' => 'dashicons-format-gallery',
                           				 'menu_position' => 99
											));

}
add_action('init', 'toast_carousel_setup'); ?>
<?php function toast_add_meta_boxes(){
 	add_meta_box(
		'toast_carousel_image',
		__('Logo Slider Images'),
		'toast_carousel_images',
		'toast_carousels'
	);
	
	function toast_carousel_images(){ ?>
	<div class="select-images-description">
	<h2>Create your carousel</h2>
	<p>To start creating your carousel, select your images using the button below.</p>
	</div>
	<a class="toast-carousel-choose-images">Select Images</a>
	<?php global $post;
	wp_nonce_field( basename( __FILE__ ), 'logo_slider_fields' );
	$images = get_post_meta( $post->ID, 'toast_carousel_images', true ); ?>
	<div class="toast-carousel-images-preview">
	<?php $images_array = json_decode($images); ?>
	<?php if($images_array): ?>
	<?php foreach($images_array as $image): ?>
	<div class="carousel-image" id="<?php echo $image->id; ?>">
	<?php echo wp_get_attachment_image($image->id, 'medium'); ?>
	<i class="dashicons-admin-links link <?php if($image->url == ''): ?>not-selected<?php endif; ?>" data-url="<?php echo $image->url; ?>"></i>
	<i class="dashicons-no remove-image"></i>
	</div>
	<?php endforeach; ?>
	<?php endif; ?>
	</div>
	<input type="hidden" name="toast_carousel_images" value='<?php echo $images; ?>'>
	<?php }
	
	add_meta_box(
		'toast_carousel_get_premium_advert',
		__('Toast Carousel Advert'),
		'toast_carousel_get_premium_advert',
		'toast_carousels'
	);
	
	add_meta_box(
		'toast_logo_slider_settings',
		__('Logo Slider Settings'),
		'toast_logo_slider_settings',
		'toast_carousels'
	);
	
	function toast_logo_slider_settings(){ ?>
	<?php global $post;
	wp_nonce_field( basename( __FILE__ ), 'logo_slider_fields' ); ?>
	
	<div class="toast-carousel-settings-fields">
	<div class="toast-carousel-tabs">
	
	<div class="tab-select active" data-tab="general">
	<h3>General</h3>
	<p>Basic carousel options</p>
	</div>
	
	<div class="tab-select" data-tab="focus">
	<h3>Focus</h3>
	<p>Focus Images & options</p>
	</div>
	
	<div class="tab-select" data-tab="styling">
	<h3>Styling</h3>
	<p>Optimise styles & layout</p>
	</div>
	
	<div class="tab-select" data-tab="mobile">
	<h3>Mobile</h3>
	<p>Controls for mobile devices</p>
	</div>
	
	</div>
	
	<div class="toast-carousel-tab active" data-tab="general">
	<h2>General</h2>
	
	<div class="visible-items option">
	<div class="option-title">
	<h3>Number of images visible in the viewport</h3>
	<?php toast_carousel_get_premium_link(); ?>
	</div>
	<div class="option-description">
	The number of logo's to show at a single time within the viewport. <strong>Note: Focus images will not work if the value is set to even.</strong>
	</div>
	
	<?php $images_visible = get_post_meta( $post->ID, 'toast_carousel_images_visible', true ); ?>
	<select name="toast_carousel_images_visible" disabled>
	<?php for($i = 2; $i <= 10; $i++): ?>
	<option value="<?php echo $i; ?>" <?php if($images_visible): ?><?php if($images_visible == $i): ?>selected<?php endif; ?><?php else: ?><?php if($i == 3): ?>selected<?php endif; ?><?php endif; ?>><?php echo $i; ?></option>
	
	<?php endfor; ?>
	</select>
	</div>
	
	<div class="option-row">
	<div class="slider-speed option">
	<div class="option-title">
	<h3>Time between transitions</h3>
	<?php toast_carousel_get_premium_link(); ?>
	</div>
	<div class="option-description">
	Sets the amount of time between each slide transition.
	</div>
	
	<?php $speed = get_post_meta( $post->ID, 'toast_carousel_speed', true ); ?>
	<select name="toast_carousel_speed" disabled>
		<?php for($i = 1; $i <= 20; $i++): ?>
		<option value="<?php echo $i; ?>" <?php if($speed): ?><?php if($speed == $i): ?>selected<?php endif; ?><?php else: ?><?php if($i == 5): ?>selected<?php endif; ?><?php endif; ?>><?php echo $i; ?> Seconds</option>
		<?php endfor; ?>
	</select>
	</div>
	
	<div class="slider-transition-speed option">
	<div class="option-title">
	<h3>Speed of transitions</h3>
	<?php toast_carousel_get_premium_link(); ?>
	</div>
	<div class="option-description">
	Sets the speed transitions take place.
	</div>
	
	<?php $transition_speed = get_post_meta( $post->ID, 'toast_carousel_transition_speed', true ); ?>
	<select name="toast_carousel_transition_speed" disabled>
		<?php for($i = 1; $i <= 10; $i++): ?>
		<option value="<?php echo $i * 0.1 ?>" <?php if($transition_speed): ?><?php if($transition_speed == $i * 0.1): ?>selected<?php endif; ?><?php else: ?><?php if($i * 0.1 == 0.5): ?>selected<?php endif; ?><?php endif; ?>><?php echo $i * 0.1; ?> Seconds</option>
		<?php endfor; ?>
	</select>
	</div>
	</div>
	
	<div class="crop-images option">
	<div class="option-title">
	<h3>Crop images to square dimensions</h3>
	<?php toast_carousel_get_premium_link(); ?>
	</div>
	
	<?php $crop_images = get_post_meta( $post->ID, 'toast_carousel_crop_images', true ); ?>
	<input type="checkbox" id="toast_carousel_crop_images" name="toast_carousel_crop_images" <?php if($crop_images): ?>checked<?php endif; ?> disabled>
	<label for="toast_carousel_crop_images" class="option-label">
	Enable this option to crop all images automatically to fit within square dimensions <strong>(Not recommended for logo carousels)</strong>.
	</label>
	
	</div>
	
	<div class="new-tab option">
	<div class="option-title">
	<h3>Open links in new tab</h3>
	<?php toast_carousel_get_premium_link(); ?>
	</div>
	
	<?php $open_new_tab = get_post_meta( $post->ID, 'toast_carousel_new_tab', true ); ?>
	<input type="checkbox" id="toast_carousel_new_tab" name="toast_carousel_new_tab" <?php if($open_new_tab): ?>checked<?php endif; ?> disabled>
	<label for="toast_carousel_new_tab" class="option-label">
	Enable to open <strong>all</strong> image links in new tabs.
	</label>
	
	</div>

	</div>
	
	<div class="toast-carousel-tab" data-tab="styling">
	<h2>Styling</h2>
	
	<div class="navi-buttons option">
	
	<div class="image-padding option">
	<div class="option-title">
	<h3>Padding on images</h3>
	<?php toast_carousel_get_premium_link(); ?>
	</div>
	<div class="option-description">
	Set the padding around each image in relation to its width.
	</div>
	<?php $image_padding = get_post_meta( $post->ID, 'toast_carousel_image_padding', true ); ?>
	<div for="toast_carousel_image_padding" class="range-amount">15%</div>
	<input type="range" min="1" max="40" step="1" class="padding-slider" name="toast_carousel_image_padding" data-percentage="true" value="15" disabled>
	</div>
	
	<div class="show-nav-buttons option">
	<div class="option-title">
	<h3>Show navigation buttons</h3>
	<?php toast_carousel_get_premium_link(); ?>
	</div>
	<?php $navi_buttons = get_post_meta( $post->ID, 'toast_carousel_navigation_buttons', true ); ?>
	<input type="checkbox" id="toast_carousel_navigation_buttons" name="toast_carousel_navigation_buttons" disabled>
	<label for="toast_carousel_navigation_buttons" class="option-label">
	Enable to display slider navigation arrows.
	</label>
	</div>
	</div>
	
	<div class="option-row navigation-conditional">
	<div class="nav-button-color option">
	<div class="option-title">
	<h3>Navigation Button Colour</h3>
	<?php toast_carousel_get_premium_link(); ?>
	</div>
	<div class="option-description">
	Choose the colour of navigation buttons
	</div>
	<?php $navi_color = get_post_meta( $post->ID, 'toast_carousel_navigation_color', true ); ?>
	<input type="text" class="wp-color-picker" name="toast_carousel_navigation_color" value="<?php if($navi_color): ?><?php echo $navi_color; ?><?php else: ?>#000000<?php endif; ?>" disabled>
	</div>
	
	<div class="navi-icon option">
	<div class="option-title">
	<h3>Navigation Icon</h3>
	<?php toast_carousel_get_premium_link(); ?>
	</div>
	<div class="option-description">
	Choose the navigation icon
	</div>
	<?php $navi_icon = get_post_meta( $post->ID, 'toast_carousel_navigation_icon', true ); ?>
	<select name="toast_carousel_navigation_icon" class="dashicon-select" disabled>
		<option class="dashicons-arrow-right" value="1" <?php if($navi_icon == 1): ?>selected<?php endif; ?>>&#xf139</option>
		<option class="dashicons-arrow-right-alt" value="2" <?php if($navi_icon == 2): ?>selected<?php endif; ?>>&#xf344</option>
		<option class="dashicons-arrow-right-alt2" value="3" <?php if($navi_icon == 3): ?>selected<?php endif; ?>>&#xf345</option>
	</select>
	</div>
	</div>
	
	</div>
	
	<div class="toast-carousel-tab" data-tab="focus">
	<h2>Focus</h2>
	
	<div class="option-row">
	<div class="scale option">
	<div class="option-title">
	<h3>Scale focus image</h3>
	<?php toast_carousel_get_premium_link(); ?>
	</div>
	<div class="option-description">
	Set the scale size for the image which is focused
	</div>
	<?php $scale_size = get_post_meta( $post->ID, 'toast_carousel_scale_up', true ); ?>
	<div for="toast_carousel_scale_up" class="range-amount">1.5</div>
	<input type="range" min="1" max="2" step="0.1" class="scale-slider" name="toast_carousel_scale_up" value="1.5" disabled>
	</div>
	
	<div class="opacity option">
	<div class="option-title">
	<h3>Opacity of images out of focus</h3>
	<?php toast_carousel_get_premium_link(); ?>
	</div>
	<div class="option-description">
	Set the opacity for the images which aren't focused
	</div>
	<?php $opacity_amount = get_post_meta( $post->ID, 'toast_carousel_opacity', true ); ?>
	<div for="toast_carousel_opacity" class="range-amount">0.1</div>
	<input type="range" min="0.1" max="1" step="0.1" class="opacity-slider" name="toast_carousel_opacity" value="0.1" disabled>
	</div>
	</div><!--End of row-->
	
	<div class="gradual option">
	<div class="option-title">
	<h3>3D Carousel</h3>
	<?php toast_carousel_get_premium_link(); ?>
	</div>
	<?php $gradual = get_post_meta( $post->ID, 'toast_carousel_gradual', true ); ?>
	<input type="checkbox" id="toast_carousel_gradual" name="toast_carousel_gradual" checked disabled>
	<label for="toast_carousel_gradual" class="option-label">
	Images gradually scale and gain opacity the closer they are to the focal image creating a 3D effect. 
	</label>
	</div>
	
	</div>
	
	
	<div class="toast-carousel-tab" data-tab="mobile">
	<h2>Mobile</h2>
	
	<div class="mobile-visible-items option">
	<div class="option-title">
	<h3>Number of images visible in the viewport (on mobile)</h3>
	<?php toast_carousel_get_premium_link(); ?>
	</div>
	<div class="option-description">
	The number of image's to show at a single time within the viewport. <strong>Note: Focus images will not work if the value is set to even.</strong>
	</div>
	
	<?php $images_visible = get_post_meta( $post->ID, 'toast_carousel_images_visible_mobile', true ); ?>
	<select name="toast_carousel_images_visible_mobile" disabled>
	<?php for($i = 1; $i <= 10; $i++): ?>
	<option value="<?php echo $i; ?>" <?php if(3 == $i): ?>selected<?php endif; ?>><?php echo $i; ?></option>
	
	<?php endfor; ?>
	</select>
	</div>
	
	</div>
	
	</div>
	
	<?php }
	
	add_meta_box(
		'logo_slider_detail',
		__('Logo Slider Details'),
		'toast_logo_slider_details',
		'toast_carousels',
		'side'
	);
	
	function toast_logo_slider_details(){
	global $post; ?>
	<p>Copy the shortcode below and paste it anywhere within your site to display this logo slider</p>
	<code>[toast_carousel id="<?php echo $post->ID; ?>"]</code>
	<?php }
	
}	
add_action( 'add_meta_boxes', 'toast_add_meta_boxes' );

function toast_carousel_save_meta( $post_id, $post ) {
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	if (! wp_verify_nonce( $_POST['logo_slider_fields'], basename(__FILE__) ) ) {
		return $post_id;
	}

	
	$slider_meta['toast_carousel_images'] = $_POST['toast_carousel_images'];
	$slider_meta['toast_carousel_speed'] = esc_html($_POST['toast_carousel_speed']);
	$slider_meta['toast_carousel_transition_speed'] = esc_html($_POST['toast_carousel_transition_speed']);
	$slider_meta['toast_carousel_new_tab'] = esc_html($_POST['toast_carousel_new_tab']);
	$slider_meta['toast_carousel_navigation_buttons'] = esc_html($_POST['toast_carousel_navigation_buttons']);
	$slider_meta['toast_carousel_scale_up'] = esc_html($_POST['toast_carousel_scale_up']);
	$slider_meta['toast_carousel_opacity'] = esc_html($_POST['toast_carousel_opacity']);
	$slider_meta['toast_carousel_images_visible'] = esc_html($_POST['toast_carousel_images_visible']);
	$slider_meta['toast_carousel_crop_images'] = esc_html($_POST['toast_carousel_crop_images']);
	$slider_meta['toast_carousel_gradual'] = esc_html($_POST['toast_carousel_gradual']);
	$slider_meta['toast_carousel_images_visible_mobile'] = esc_html($_POST['toast_carousel_images_visible_mobile']);
	$slider_meta['toast_carousel_image_padding'] = esc_html($_POST['toast_carousel_image_padding']);
	$slider_meta['toast_carousel_navigation_color'] = esc_html($_POST['toast_carousel_navigation_color']);
	$slider_meta['toast_carousel_navigation_icon'] = esc_html($_POST['toast_carousel_navigation_icon']);
	
	foreach ( $slider_meta as $key => $value ) :
		if ( 'revision' === $post->post_type ) {
			return;
		}
		if ( get_post_meta( $post_id, $key, false ) ) {
			update_post_meta( $post_id, $key, $value );
		} else {
			add_post_meta( $post_id, $key, $value);
		}
		if ( ! $value ) {
			delete_post_meta( $post_id, $key );
		}
	endforeach;
}
add_action( 'save_post', 'toast_carousel_save_meta', 1, 2 );