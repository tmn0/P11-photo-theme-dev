<?php

function photo_theme_register_assets() {    
    
    /* wp_enqueue_script('jquery' ); */   
    
	wp_enqueue_script ('scripts', 
        get_template_directory_uri() . '/scripts/script.js', array( 'jquery' ), '1.0', true
    );
    
    
    wp_enqueue_style ( 'photo', get_stylesheet_uri(), array(), '1.0'
    );  	
    
}

add_action( 'wp_enqueue_scripts', 'photo_theme_register_assets' );


/*-------------*/
/*-------------*/
/* script call */

/*
function enqueue_custom_script() {    
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . 'scripts/scripts.js');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script');
*/

/*-------------*/
/*-------------*/
//* style call , get_theme_file_uri :: not working ?? //// only in html < link rel> ? 

/*
function theme_enqueue_styles() {
  wp_register_style('theme-main', get_stylesheet_directory_uri() . '/style.css' );
  wp_enqueue_style('theme-main'); 
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
*/

/*-------------*/
/*
function enqueue_custom_styles() {
    wp_enqueue_style('custom-modal-styles', get_template_directory_uri() . '/style-modal.css');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');
*/

/*-------------*/
/*-------------*/
/* wordpress menu addition for theme */
function wp_menu_setup() {
    register_nav_menu('primary', 'Primary Navigation Menu');
}
add_action('after_setup_theme', 'wp_menu_setup');

/*-------------*/
/* wordpress menu call */
function theme_menus() {
    register_nav_menus(
        array(
            'custom-menu' => __('Menu1'),
        )
    );
}
add_action('init', 'theme_menus');


/*-------------*/
/*-------------*/
/* adding selectable hero img in wordpress */
function custom_theme_support() {
    add_theme_support('custom-header', array(        
        
        'width'         => 1440, 
        'height'        => 900,  
        'flex-height'   => true,
        'flex-width'    => true,
        'uploads'       => true,
        'wp-head-callback' => 'custom_header_style'
        
    ));
}
add_action('after_setup_theme', 'custom_theme_support');


/*-------------*/
/*-------------*/
/* Walker Menu */
/*
class Walker_Main_Menu extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $current_object_id = 0) {
       
        if ($item->title === 'Contact') {           
            $output .= "<li class='custom-menu-item contact-open-modal'>";
            $output .= "<a href='" . get_template_directory_uri() . '/template-part/contact.php'. "'>Contact</a>"; 
            $output .= "</li>";

        } else {           
            $output .= "<li>";
            $output .= "<a href='" . $item->url . "'>" . $item->title . "</a>";
            $output .= "</li>";
        }
    }
}
*/
class Walker_Main_Menu extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $current_object_id = 0) {
       
        if ($item->title === 'Contact') {
            $output .= "<li class='custom-menu-item contact-open-modal'>";
            $output .= "<a href='#' id='openModal'>Contact</a>"; // Add an ID to the link
            $output .= "</li>";

        } else {           
            $output .= "<li>";
            $output .= "<a href='" . $item->url . "'>" . $item->title . "</a>";
            $output .= "</li>";
        }
    }
}


/* Contact shortcode register*/

/*
function custom_register_wpforms_shortcode() {
    add_shortcode('wpforms', 'custom_wpforms_shortcode_callback');
}

function custom_wpforms_shortcode_callback($atts) {
    function custom_wpforms_shortcode_callback($atts) {
   
    if (function_exists('wpforms')) {
        
        if (isset($atts['id'])) {
           
            $form_id = intval($atts['id']); // Convert 'id' attribute to an integer
            $form = wpforms()->form->get($form_id);

            
            if ($form) {
                
                $form_output = wpforms()->process->render(
                    $form_id,
                    [
                        'title' => (isset($atts['title']) && strtolower($atts['title']) === 'false') ? false : true,
                        
                    ]
                );

                return $form_output;
            } else {
                return 'Form not found'; 
            }
        } else {
            return 'No form ID provided'; 
        }
    } else {
        return 'WPForms plugin is not active'; 
    }
}

}

add_action('init', 'custom_register_wpforms_shortcode');

add_filter('the_content', 'filter_content_example');
*/


/* Custom post type photo */ 
function custom_register_photo_post_type() {
    register_post_type('photo', array(
        'labels' => array(
            'name' => __('photos', 'your-text-domain'), 
            'singular_name' => __('photo', 'your-text-domain'), 
        ),
    ));
}
add_action('init', 'custom_register_photo_post_type');
