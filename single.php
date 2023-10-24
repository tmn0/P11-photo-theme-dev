<!-- Section 1 -->
<?php get_template_part('header'); ?>
<header>
<?php get_template_part('template-part/navmenu'); ?>
</header>

<div id="single-global-container">

<section id="single-content">
    <div class="single-content-left">
        <?php 
        while (have_posts()) :
            the_post();
        ?>

        

    <?php
    // Custom taxo 0 acf
    $terms_reference = get_field('reference');
    // Custom taxo 1
    $terms_categorie = get_the_terms(get_the_ID(), 'categorie');
    // Custom taxo 2
    $terms_format = get_the_terms(get_the_ID(), 'format');
    // Custom taxo 3 BUG
    /* $terms_types = get_the_terms(get_the_ID(), 'type');
    */
    // Taxo 4 date
    $post_date = get_the_date('Y');

    // Call custom taxos & title
    echo '<div class="single-taxos-container">';

    echo '<div><h1>' . get_the_title() . '</h1></div>';


    if ($terms_reference) {
        echo '<div class="taxo-item"><span class="label">Référence:&nbsp;</span>';
        echo '<span class="value">' . $terms_reference . '</span></div>';
    }

    if ($terms_categorie) {
        echo '<div class="taxo-item"><span class="label">Catégorie:&nbsp;</span>';
        echo '<span class="value">';
        foreach ($terms_categorie as $term) {
            echo $term->name;
        }
        echo '</span></div>';
    }

    if ($terms_format) {
        echo '<div class="taxo-item"><span class="label">Format:&nbsp;</span>';
        echo '<span class="value">';
        foreach ($terms_format as $term) {
            echo $term->name;
        }
        echo '</span></div>';
    }

    echo '<div class="taxo-item"><span class="label">Année:&nbsp;</span>';
    echo '<span class="value">' . $post_date . '</span></div>';

    /* Uncomment if needed
    if ($terms_types) {
        echo '<div class="taxo-item"><span class="label">Type:&nbsp;</span>';
        echo '<span class="value">';
        foreach ($terms_types as $term) {
            echo $term->name . ', ';
        }
        echo '</span></div>';
    }
    */


    echo '</div></div>';
    // div single-taxos-container & single-content-left
    ?> 



    
    <?php // single-content-right    
        $post_id = get_the_ID();
    ?>
    
    <div class="single-content-right">    
        <div class="single-expand-icon-container expand-icon"
        data-post-id="<?php echo $post_id; ?>">
        <i class="fa-solid fa-expand"></i>
    </div>
                 
                 
        <?php the_content(); ?>                
    </div>
    
        <?php
        endwhile;
        ?>

</section>


<!-- Section 2 -->
<section id="single-contact-shortcut-main-container">

    <div id="single-contact-shortcut-left-container">
        <div id="single-contact-shortcut-text-container">
            <p>Cette photo vous intéresse ?</p>
        </div>

        <div id="single-contact-shortcut-button-container">
            <button id="single-contact-button" class="contact-open-modal more-button" data-post-id="<?php echo get_the_ID(); ?>">Contact</button>
        </div>
    </div>

    <div id="single-contact-shortcut-right-container">
        <div id="single-contact-shortcut-right-inner-container">
        <div class="single-contact-shortcut-nav-img">
            <?php
            $current_post_id = get_the_ID();

            // Retrieve the next "photo" post
            $next_photo = get_next_post(true, '', 'photo');

            if ($next_photo) {
                // Extract the image from the next "photo" post's content
                $next_photo_content = apply_filters('the_content', $next_photo->post_content);
                $next_photo_image = get_first_image_from_content($next_photo_content);

                // Display the next photo's image
                if (!empty($next_photo_image)) {
                    echo $next_photo_image;
                }
            }
            ?>
        </div>

        <div id="single-contact-shortcut-arrows-container">
            <button id="arrow-left" class="shortcut-arrow"></button>
            <button id="arrow-right" class="shortcut-arrow"></button>
        </div>
    </div>
    </div>

</section>



<!-- Section 3 -->
<section id="single-section3-main-container">
    <div id="single-section3-title">
        <p>VOUS AIMEREZ AUSSI</p>
    </div>

    <div id="single-section3-image-container">
        <?php
        // Get the current post's category
        $terms_categorie = get_the_terms(get_the_ID(), 'categorie');

        // Check if the current post has a category
        if ($terms_categorie) {
            $category_name = $terms_categorie[0]->name; // Assuming it's the first category

            // Query two random images from the same category
            $random_images = get_posts(array(
                'post_type' => 'photo', 
                'posts_per_page' => 2,
                'post__not_in' => array(get_the_ID()), // Exclude the current post
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categorie', 
                        'field' => 'name',
                        'terms' => $category_name,
                    ),
                ),
                'orderby' => 'rand', // Get random posts
            ));

            // If random images are found, display them
            foreach ($random_images as $index => $image) {
                $image_permalink = get_permalink($image->ID); // Get the URL to the individual post
                $image_content = get_the_content(null, false, $image->ID);
                $image_id = 'single-image-' . $image->ID; // Create a unique ID for each image using the post's ID
                $post_id = $image->ID; // Get the post ID for the expand icon
                
                // Determine if it's the left or right image
                $position_class = ($index == 0) ? 'left' : 'right';                    

                // Image content
                echo '<div id="' . $image_id . '" class="dynamic-image ' . $position_class . '">' . $image_content ;
                
                // Open an anchor tag with target="_blank" for the eye icon
                echo '<a href="' . esc_url($image_permalink) . '" target="_blank" class="icon-link">';                 
                echo '<div class="single-eye-icon-container ' . $position_class . '">
                <i class="fa-regular fa-eye"></i></div>';
                echo '</a>';
                
                // Expand icon with data-post-id attribute
                echo '<div class="single-expand-icon-container expand-icon ' . $position_class . '
                " data-post-id="' . $post_id . '"><i class="fa-solid fa-expand"></i></div>';
                echo '</div>';    
            }
        } else {
            // Handle the case where the current post doesn't have a category
            echo "No category found for this post.";
        }
        ?>
    </div> <!-- "single-section3-image-container" -->
</section>




</div>
<?php get_footer(); ?>




<!-- mini image avec fleche: le post d'après
cf code theme 2020 de wp et adapter

2 photos suivantes dans single: random dans meme catégorie
-->