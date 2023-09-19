<?php
function custom_scripts() {
  wp_register_script('photo_theme_scripts', get_template_directory_uri() . '/scripts/scripts.js');
  wp_enqueue_script('photo_theme_scripts');      
}
add_action( 'wp_enqueue_scripts', 'custom_scripts' );



function theme_enqueue_styles() {
  wp_register_style('theme-main', get_stylesheet_directory_uri() . '/style.css' );
  wp_enqueue_style('theme-main'); 
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );


/* get_theme_file_uri :: non plus*/

function custom_theme_setup() {
    register_nav_menu('primary', 'Primary Navigation Menu');
}
add_action('after_setup_theme', 'custom_theme_setup');
