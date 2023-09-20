<?php
function custom_scripts() {
  wp_register_script('photo_theme_scripts', get_template_directory_uri() . '/scripts/scripts.js');
  wp_enqueue_script('photo_theme_scripts');      
}
add_action( 'wp_enqueue_scripts', 'custom_scripts' );


/* get_theme_file_uri :: not working ?? //// only in html < link rel> ? */
function theme_enqueue_styles() {
  wp_register_style('theme-main', get_stylesheet_directory_uri() . '/style.css' );
  wp_enqueue_style('theme-main'); 
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );



/* wordpress menu addition for theme */
function wp_menu_setup() {
    register_nav_menu('primary', 'Primary Navigation Menu');
}
add_action('after_setup_theme', 'wp_menu_setup');


/* wordpress menu call */
function theme_menus() {
    register_nav_menus(
        array(
            'custom-menu' => __('Menu1'),
        )
    );
}
add_action('init', 'theme_menus');
