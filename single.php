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

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
             <h1><?php echo strtoupper(get_the_title()); ?></h1>
        </div>
    </div>


<?php
// Custom taxo 0 acf
$terms_reference = get_field('reference');
// Custom taxo 1
$terms_categorie = get_the_terms(get_the_ID(), 'categorie');
// Custom taxo 2
$terms_format = get_the_terms(get_the_ID(), 'format');
// Custom taxo 3
// $terms_type = get_the_terms(get_the_ID(), 'type');

// Call custom taxos
echo '<div class="single-taxos-container">';


if ($terms_reference) {
    echo '<div><p>Référence:&nbsp;</p>';    
        echo '<p>'. $terms_reference . '</p>';    
    echo '</div>';
}


if ($terms_categorie) {
    echo '<div><p>Categorie:&nbsp;</p>';
    foreach ($terms_categorie as $term) {
        echo '<p>' . $term->name . '</p>';
    }
    echo '</div>';

}

if ($terms_format) {
    echo '<div><p>Format:&nbsp;</p>';
    foreach ($terms_format as $term) {
        echo '<p>' . $term->name . '</p>';
    }
    echo '</div>';
}


echo '</div>';


?>

    <div class="single-content-right">        
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
                'post_type' => 'photo', // Adjust to your custom post type
                'posts_per_page' => 2,
                'post__not_in' => array(get_the_ID()), // Exclude the current post
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categorie', // Replace with your custom category taxonomy
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
                
                

                // Determine if it's the left or right image
                $position_class = ($index == 0) ? 'left' : 'right';                    
                
                // Image content
                echo '<div id="' . $image_id . '" class="dynamic-image ' . $position_class . '">' . $image_content ;
                
                // Open an anchor tag with target="_blank" for the eye icon
                echo '<a href="' . esc_url($image_permalink) . '" target="_blank" class="icon-link">';                 
                echo '<div class="single-eye-icon-container ' . $position_class . '"><i class="fa-regular fa-eye"></i></div>';
                echo '</a>';
                // Expand icon
                echo '<div class="single-expand-icon-container ' . $position_class . '"><i class="fa-solid fa-expand"></i></div>';
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