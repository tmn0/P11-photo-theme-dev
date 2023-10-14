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
            $post_id = get_the_ID();

            // Retrieve all images attached to the post
            $attachments = get_posts(array(
                'post_type' => 'attachment',
                'posts_per_page' => -1,
                'post_parent' => $post_id,
            ));

            // Find the current image's position
            $current_image_index = 0;
            $current_image_id = get_post_thumbnail_id();
            foreach ($attachments as $index => $attachment) {
                if ($attachment->ID == $current_image_id) {
                    $current_image_index = $index;
                    break;
                }
            }

            // Calculate the index of the next image
            $next_image_index = $current_image_index + 1;

            // Check if the next image exists and display it
            if (isset($attachments[$next_image_index])) {
                echo wp_get_attachment_image($attachments[$next_image_index]->ID, 'large');
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
            foreach ($random_images as $image) {
                $image_permalink = get_permalink($image->ID); // Get the URL to the individual post
                $image_content = get_the_content(null, false, $image->ID);

                // Wrap the image in an anchor tag with target="_blank" and link to the individual post
                echo '<a href="' . esc_url($image_permalink) . '" target="_blank" class="image-wrapper">' . $image_content . '</a>';
            }
        } else {
            // Handle the case where the current post doesn't have a category
            echo "No category found for this post.";
        }
        ?>
    </div>

    <div id="single-section3-button-container">
        <button id="single-section3-button" class="more-button">Toutes les photos</button>
    </div>
</section>






</div>
<?php get_footer(); ?>




<!-- mini image avec fleche: le post d'après
cf code theme 2020 de wp et adapter

2 photos suivantes dans single: random dans meme catégorie
-->