<?php

/*-------------*/
/*-------------*/
/*Register assets*/
function enqueue_jquery() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');


function photo_theme_register_assets() {
    wp_enqueue_style('theme-main', get_stylesheet_uri());
    

    // Enqueue your custom JavaScript file
    wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/scripts/custom-scripts.js', array('jquery'), null, true);

    // Pass the AJAX URL to the JavaScript file  // !!! SEE HEADER.PHP !!!
    /*
    wp_localize_script('custom-scripts', 'photo_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
  
    wp_localize_script('custom-scripts', 'single_load_more_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
   
    wp_localize_script('custom-scripts', 'ajaxurl', array('ajax_url' => admin_url('admin-ajax.php')));
    */
    wp_localize_script('custom-scripts', 'custom_ajax', array('ajax_url' => admin_url('admin-ajax.php')));

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
/* AJAX / FRONT PAGE LOAD MORE BUTTON */  
function load_more_photos() {
    // Get the page number from the AJAX request
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    // Number of posts to load per request
    $posts_per_page = 10;

    // Query custom 'photo' posts for the current page
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => $posts_per_page, // Use the updated value
        'paged' => $page,
    );


    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Output your post content here
            // For example, you can use functions like the_title(), the_content(), etc.
            the_content();
            // Don't forget to flush the output buffer
            ob_flush();
            flush();
        }
    }

    // Always use wp_die() to terminate the script
    wp_die();
}

add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');


/* OLD VERSION
function load_more_photos() {
    $page = $_POST['page'];

    $custom_query_args = array(
        'post_type' => 'photo',
        'posts_per_page' => 10,
        'paged' => $page,
    );

    $custom_query = new WP_Query($custom_query_args);

    if ($custom_query->have_posts()) {
        while ($custom_query->have_posts()) {
            $custom_query->the_post();
            // Output the post content as you did before
        }
    }

    wp_die();
}

add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');
*/



/*-------------*/
/*-------------*/
// AJAX / BUTTON TAXO DATA FETCH CONTACT
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
/*
add_action('wp_ajax_nopriv_get_reference_term_data', 'get_reference_term_data');
*/


/*-------------*/
/*-------------*/
// SINGLE PAGE - SECTION 2 NEXT IMAGES
function load_post_content() {
    $post_id = $_POST['post_id'];
    $post = get_post($post_id);
    echo apply_filters('the_content', $post->post_content);
    die();
}
add_action('wp_ajax_load_post_content', 'load_post_content');
add_action('wp_ajax_nopriv_load_post_content', 'load_post_content');


/*-------------*/
/*-------------*/
// EXPAND ICON LIGHTBOX BEHAVIOUR
// Add AJAX action hook for fetching "photo" post content
add_action("wp_ajax_get_photo_content", "get_photo_content");
add_action("wp_ajax_nopriv_get_photo_content", "get_photo_content"); // Allow non-logged-in users to access this AJAX action

function get_photo_content() {
    $post_id = $_POST["post_id"];

    // Fetch the content of the "photo" post based on the provided post ID
    $photo_post = get_post($post_id);

    if ($photo_post) {
        // Return the post content as the AJAX response
        echo apply_filters("the_content", $photo_post->post_content);
    }

    // Don't forget to exit to prevent WordPress from returning additional data
    wp_die();
}



/*-------------*/
/*-------------*/
// Single Load More Button 
function single_load_more_photos() {
    $categorie_slug = sanitize_text_field($_POST['categorie']);
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 2; // Default to 2 if not provided

    $query = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => $posts_per_page, // Use the updated value
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field' => 'slug',
                'terms' => $categorie_slug,
            ),
        ),
    ));

    $generated_html = '';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Generate and append HTML for the individual posts
            $generated_html .= '<div class="photo-post">';
            // Append the post content
            the_content();
            $generated_html .= apply_filters('the_content', get_the_content());
            $generated_html .= '</div>';
        }
    }

    wp_reset_postdata();

    echo $generated_html;
    wp_die(); // Terminate the script safely
}


/*
function single_load_more_photos() {
    $categorie_slug = sanitize_text_field($_POST['categorie']);

    $query = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => -1, // Adjust the number of posts per page as needed
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field' => 'slug',
                'terms' => $categorie_slug,
            ),
        ),
    ));

    $generated_html = '';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Generate and append HTML for the individual posts
            $generated_html .= '<div class="photo-post">';
            // Append the post content
            $generated_html .= apply_filters('the_content', get_the_content());
            $generated_html .= '</div>';
        }
    }

    wp_reset_postdata();

    echo $generated_html;
    wp_die(); // Terminate the script safely
}

*/


// Single Load More Button OLD

/*
function single_load_more_photos() {
    $categorie_slug = sanitize_text_field($_POST['categorie']);

    $query = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field' => 'slug',
                'terms' => $categorie_slug,
            ),
        ),
    ));

    $generated_html = '';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            
            // Generate and append HTML for the individual posts
            $generated_html .= '<div class="photo-post">';
            // Append the post content
            $generated_html .= apply_filters('the_content', get_the_content());
            $generated_html .= '</div>';
        }
    }

    wp_reset_postdata();

    echo $generated_html;
    wp_die(); // Terminate the script safely
}

add_action('wp_ajax_single_load_more_photos', 'single_load_more_photos');
add_action('wp_ajax_nopriv_single_load_more_photos', 'single_load_more_photos');
*/


// Front Page Button 3 Taxo SORTING
function sort_posts_by_date() {
    // Get the sorting option from the AJAX request
    $sorting_option = sanitize_text_field($_POST['sorting_option']);

    // Define the custom query arguments based on the sorting option
    $custom_query_args = array(
        'post_type' => 'photo',
        'posts_per_page' => 10,
        'orderby' => ($sorting_option === 'Les plus anciennes') ? 'date' : 'date',
        'order' => ($sorting_option === 'Les plus anciennes') ? 'ASC' : 'DESC',
    );

    // Create a new custom query
    $custom_query = new WP_Query($custom_query_args);

    // Output the sorted posts
    if ($custom_query->have_posts()) :
        while ($custom_query->have_posts()) :
            $custom_query->the_post();

            // Output your post content as you did in your original code

        endwhile;
        wp_reset_postdata(); // Restore the global post data
    else :
        echo 'No custom posts found.';
    endif;

    wp_die(); // Always use wp_die() at the end of your AJAX callback function
}

add_action('wp_ajax_sort_posts_by_date', 'sort_posts_by_date');
add_action('wp_ajax_nopriv_sort_posts_by_date', 'sort_posts_by_date');
