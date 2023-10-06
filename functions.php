<?php

/*-------------*/
/*-------------*/
/* Enqueueing */
function photo_theme_register_assets() {
    // Enqueue the JavaScript file
    wp_enqueue_script('scripts', get_template_directory_uri() . '/scripts/script.js', array('jquery'), '1.0', true);

    // Enqueue the main stylesheet
    wp_enqueue_style('theme-main', get_stylesheet_uri()); // Use get_stylesheet_uri() to get the main stylesheet

    // jQuery is already included in WordPress by default, no need to enqueue it again

    // You can't pass 'enqueue_jquery' as the fourth argument for add_action, it's not needed.
}
add_action('wp_enqueue_scripts', 'photo_theme_register_assets');



/*-------------*/
/*-------------*/
/* WP Menu call */
function wp_menu_setup() {
    register_nav_menu('primary', 'Primary Navigation Menu');
}
add_action('after_setup_theme', 'wp_menu_setup');

/*-------------*/
/* In wordpress menu */
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
/* Selectable hero img in wordpress */
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
            $output .= "<a href='#' id='open-modal'>Contact</a>"; // Add an ID to the link
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

/*-------------*/
/*-------------*/
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


/*-------------*/
/*-------------*/
/* AJAX / LOAD MORE BUTTON */ 
function load_more_posts_scripts() {
    wp_enqueue_script('load-more-posts', get_template_directory_uri() . '/scripts/scripts.js', array('jquery'), '1.0', true);
    wp_localize_script('load-more-posts', 'loadmoreposts', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'load_more_posts_scripts');


/*-------------*/
function load_more_posts() {
    $page = $_POST['page'];

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $page,
    );

    $custom_query = new WP_Query($args);

    if ($custom_query->have_posts()) :
        while ($custom_query->have_posts()) :
            $custom_query->the_post();
            // Display the content of the post as you did before
        endwhile;
    endif;

    wp_reset_postdata();

    die();
}

add_action('wp_ajax_load_more_posts', 'load_more_posts'); // For logged in users
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts'); // For non-logged in users



