<?php

/*-------------*/
/*-------------*/
/*Register assets*/
function photo_theme_register_assets() {   
    wp_enqueue_style('theme-main', get_stylesheet_uri());

    /*
    // Enqueue the default jQuery library included with WordPress
    wp_enqueue_script('jquery');
    */
    
    // Enqueue custom jQuery library (+ override WP base jQuery)
    wp_enqueue_script('custom-jquery', get_template_directory_uri() . '/scripts/jquery-3.7.1.min.js', array(), null, true);

    // Enqueue custom JavaScript file + custom-jquery as dependency
    wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/scripts/scripts.js', array('custom-jquery'), '1.0', true);

    // Localize data for the script
    wp_localize_script('custom-scripts', 'custom_script_data', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
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


/* Contact shortcode register (redondant w/ plugin code ?)*/

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
/* Custom post type photo config*/ 
function custom_photo_post_type() {
$args = array(
    'public' => true,
    'label'  => 'Photos',
    'rewrite' => array( 'slug' => 'photo' ),
);
register_post_type( 'photo', $args );
}
add_action( 'init', 'custom_photo_post_type' );

/*---  Conflict with code above >> disabled code or unnecessary ---
function custom_register_photo_post_type() {
    register_post_type('photo', array(
        'labels' => array(
            'name' => __('photos', 'your-text-domain'), 
            'singular_name' => __('photo', 'your-text-domain'), 
        ),
    ));
}
add_action('init', 'custom_register_photo_post_type');
*/




/*-------------*/
/*-------------*/
/* WP IMG CLASS REMOVE-REPLACE */ 
function custom_modify_post_content($content) {
    
    $content = preg_replace('/<figure(.*?)>(.*?)<\/figure>/i', '<div$1>$2</div>', $content);

    return $content;
}
add_filter('the_content', 'custom_modify_post_content');

/*-------------*/
function remove_image_size_attributes($attributes) {
    
    if (isset($attributes['class'])) {

        $attributes['class'] = str_replace('wp-block-image', '', $attributes['class']);
        $attributes['class'] = trim($attributes['class']); // Remove extra spaces
        
        $classes_to_remove = array(
            'size-large',  
            'size-medium', 
            'size-small',        
        );

        if (empty($attributes['class'])) {
            unset($attributes['class']);

        }

        $attributes['class'] = array_diff($attributes['class'], $classes_to_remove);
    }

    return $attributes;
}
add_filter('wp_get_attachment_image_attributes', 'remove_image_size_attributes');



/*-------------*/
/*-------------*/
/* AJAX / FRONT PAGE TAXO BUTTON 1 Categorie*/  



/* JQUERY IS BUGGY  */
/*
jQuery(document).ready(function($) {
    // Handle the click event on the category button
    $('#front-taxo-button1').on('click', function(e) {
        e.preventDefault();

        // Get the selected category from the button's text
        var category = $.trim($(this).find('.home-button-title').text());

        // Send an AJAX request to retrieve posts based on the selected category
        $.ajax({
            type: 'POST',
            url: custom_script_data.ajax_url,
            data: {
                action: 'filter_posts',
                category: category,
            },
            success: function(response) {
                // Update the masonry grid with the filtered posts
                $('#front-masonry').html(response);
            },
        });
    });
});
*/




/*-------------*/
/*-------------*/
/* AJAX / FRONT PAGE LOAD MORE BUTTON */  
function load_more_posts() {
    $page = $_POST['page'];

    /*DEBUGGING*/
    error_log('load_more_posts function called, page = ' . $page);
    // Debug the data
    error_log('Data received in the AJAX request:');
    error_log(print_r($_POST, true));
    /*DEBUGGING*/
    
    $custom_query_args = array(
        'post_type' => 'photo',
        'posts_per_page' => 10,
        'paged' => $page
    );

    $custom_query = new WP_Query($custom_query_args);

    if ($custom_query->have_posts()) {
        while ($custom_query->have_posts()) {
            $custom_query->the_post();
            // Output the HTML for each new post
            // This should match the structure used in your initial code
        }

        wp_reset_postdata();
    } else {
        echo ''; // No more posts to load
    }

    die(); // Always end with die() for AJAX requests
}

add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');



/* AJAX / LOAD MORE BUTTON test
function load_more_posts() {
    $page = $_POST['page'];
    $posts_per_page = 8;

    $custom_query_args = array(
        'post_type' => 'photo',
        'posts_per_page' => $posts_per_page,
        'paged' => $page,
    );

    $custom_query = new WP_Query($custom_query_args);

    if ($custom_query->have_posts()) :
        while ($custom_query->have_posts()) : $custom_query->the_post();
            // Your loop content here
        endwhile;
        wp_reset_postdata();
    else :
        // No more posts to load
        echo '0';
    endif;

    die();
}

add_action('wp_ajax_load_more_posts', 'load_more_posts'); // for logged-in users
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts'); // for non-logged-in users
*/

/* AJAX / LOAD MORE BUTTON TEST 2*/
/* 
function load_more_posts() {
    $page = $_POST['page'];
    $custom_query_args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $page,
    );

    // Create a new custom query
    $custom_query = new WP_Query($custom_query_args);

    if ($custom_query->have_posts()) :
        while ($custom_query->have_posts()) :
            $custom_query->the_post();

            // Output the content of each post as you did in your initial loop

        endwhile;
        wp_reset_postdata();
    else :
        echo 'No more posts found';
        error_log('No more posts found'); // Log the error message
    endif;
    
    die(); // This is important to end the AJAX response.
}

add_action('wp_ajax_load_more_posts', 'load_more_posts'); // For logged-in users
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts'); // For non-logged-in users


function load_more_posts_scripts() {
    wp_enqueue_script('load-more-posts', get_template_directory_uri() . '/scripts/scripts.js', array('jquery'), '1.0', true);
    wp_localize_script('load-more-posts', 'loadmoreposts', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'load_more_posts_scripts');
*/



/*-------------*/
/*-------------*/
// AJAX / BUTTON TAXO DATA FETCH
function get_reference_term_data() {
    // Get the post ID from the AJAX request
    $post_id = $_POST['post_id'];

    // Get the "reference" term data for the current post
    $terms_reference = get_field('reference', $post_id);

    // Create an array with the term data
    $term_data = array(
        'reference' => $terms_reference,
    );

    // Encode the data as JSON and send it back as the AJAX response
    echo json_encode($term_data);

    wp_die(); // Always include this to terminate the script properly
}

add_action('wp_ajax_get_reference_term_data', 'get_reference_term_data');
add_action('wp_ajax_nopriv_get_reference_term_data', 'get_reference_term_data');



/*-------------*/
/*-------------*/
// SINGLE PAGE - SECTION 2 NEXT IMAGES
function get_first_image_from_content($content) {
    $pattern = '/<img[^>]+src=[\'"]([^\'"]+)[\'"][^>]*>/';
    preg_match($pattern, $content, $matches);

    if (isset($matches[1])) {
        return '<img src="' . esc_url($matches[1]) . '">';
    }

    return ''; // Return an empty string if no image is found
}



/*-------------*/
/*-------------*/
// EXPAND ICON LIGHTBOX BEHAVIOUR
add_action('wp_ajax_get_image_content', 'get_image_content');
add_action('wp_ajax_nopriv_get_image_content', 'get_image_content');

function get_image_content() {
    $post_id = $_GET['post_id'];
    $image_content = ''; // Initialize the variable to store the image content

    // Check if the post with the provided ID exists and has the post type "photo"
    $post = get_post($post_id);
    if ($post && $post->post_type === 'photo') {
        // If it's a "photo" post type, fetch the content
        $image_content = $post->post_content;
    }

    echo $image_content;
    wp_die(); // Always include this to end the AJAX request
}
