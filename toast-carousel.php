<?php
   /*
   Plugin Name: Ultimate Logo Slider & Image Carousel
   Plugin URI:
   description: Wordpress' most advanced image carousel and slider.
   Version: 1.1.0
   Author: Toast Plugins
   Author URI: https://www.toastplugins.co.uk/
   */
?>
<?php include dirname(__FILE__). '/backend/backend.php'; ?>
<?php include dirname(__FILE__). '/backend/gallery-selector.php'; ?>
<?php include dirname(__FILE__). '/backend/ajax-functions.php'; ?>
<?php include dirname(__FILE__). '/backend/functions.php'; ?>
<?php require_once dirname(__FILE__). '/aqua-resizer.php'; ?>
<?php include dirname(__FILE__). '/frontend/shortcode.php'; ?>
<?php function toast_carousel_backend_scripts(){
global $post;
if($post && $post->post_type === 'toast_carousels'):
wp_enqueue_script('toast_carousel_backend_script', plugin_dir_url( __FILE__ ) . 'backend/script.js', array('wp-color-picker'), 'null', false );
wp_enqueue_style('toast_carousel_backend_styles', plugin_dir_url( __FILE__ ) . 'backend/style.css', array(), 'null', false );
endif;
}
add_action('admin_enqueue_scripts', 'toast_carousel_backend_scripts');
function toast_carousel_frontend_scripts(){
wp_enqueue_script('toast_carousel_frontend_script', plugin_dir_url( __FILE__ ) . 'frontend/script.js', array(), 'null', false );
wp_enqueue_style('toast_carousel_frontend_styles', plugin_dir_url( __FILE__ ) . 'frontend/style.css', array(), 'null', false );
wp_enqueue_style( 'dashicons' );
}
add_action('wp_enqueue_scripts', 'toast_carousel_frontend_scripts');