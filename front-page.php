<?php get_header(); ?>

</header>
<?php get_template_part('template-part/navmenu'); ?>
<?php get_template_part('template-part/hero'); ?>



<div class="home-container">
    <!-- Buttons & Filters -->
    <div class="taxonomy-selector-main-container">
        <div class="taxonomy-selector-left-container">

            <!-- Button 1 -->
            <div class="taxonomy-button-container">
                <button class="home-button" id="front-taxo-button1">                
                    <p class="home-button-title">CATÉGORIES</p>
                    <div class="fa-caret-container">
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                </button>
                <div class="home-dropdown" id="front-dropdown1">
                    <a href="#" data-category="Réception">Réception</a>
                    <a href="#" data-category="Télévision">Télévision</a>
                    <a href="#" data-category="Concert">Concert</a>
                    <a href="#" data-category="Mariage">Mariage</a>
                </div>
            </div>

            <!-- Button 2 -->
            <div id="format-button" class="taxonomy-button-container">
                    <button class="home-button" id="front-taxo-button2">
                        <p class="home-button-title">FORMATS</p>
                        <div class="fa-caret-container">
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                    </button>
                    <div class="home-dropdown" id="front-dropdown2">
                        <a href="#" data-category="Paysage">Paysage</a>
                        <a href="#" data-category="Portrait">Portrait</a>                
                    </div>
                </div> <!-- End of Button 2 -->
            </div> <!-- End of taxonomy-selector-left-container -->

            <!-- Button 3 -->
            <div class="taxonomy-selector-right-container">
                <div class="taxonomy-button-container">
                    <button class="home-button" id="front-taxo-button3">
                        <p class="home-button-title">TRIER PAR</p>
                        <div class="fa-caret-container">
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                    </button>
                    <div class="home-dropdown" id="front-dropdown3">
                        <a href="#">Les plus récentes</a>
                        <a href="#">Les plus anciennes</a>                  
                    </div>
                </div>
            </div>

    </div> <!-- End of taxonomy-selector-main-container -->



<!-- Custom post + masonry grid-->
<section id="front-masonry">
    <?php
    $custom_query_args = array(
        'post_type' => 'photo',
     /* 'posts_per_page' => 10,*/
    );

    // Create a new custom query
    $custom_query = new WP_Query($custom_query_args);

    // Initialize a counter to keep track of items
    $item_count = 0;

    // Open a container for the grid
    echo '<div class="home-masonry-grid">';

    // Loop through the custom query results
    $custom_query = new WP_Query($custom_query_args);
        if ($custom_query->have_posts()) :
            while ($custom_query->have_posts()) :
            $custom_query->the_post();

            // Get the post ID
            $post_id = get_the_ID();

            // Increment the item count
            $item_count++;

            // Get the permalink of the post
            $post_permalink = get_permalink();

            // Open a grid item
            echo '<div class="home-masonry-item" data-post-date="' . esc_attr(get_the_date('Y-m-d')) . '">';
         

            // Open a container div for the content, including title, category, and post content
            echo '<div class="masonry-photo-details">';

            // Output the expand-icon with data-post-id attribute
            echo '<div class="expand-icon-container expand-icon" data-post-id="' . esc_attr($post_id) . '"><i class="fa-solid fa-expand"></i></div>';

            // Open an anchor tag with target="_blank" for the icon
            echo '<a href="' . esc_url($post_permalink) . '" target="_blank" class="icon-link">';

            // Add the Font Awesome icon within a div
            echo '<div class="eye-icon-container"><i class="fa-regular fa-eye"></i></div>';

            // Close the anchor tag for the icon
            echo '</a>';
            

            // Display the custom post "photo" title
            echo '<p class="masonry-photo-title">' . get_the_title() . '</p>';

            // Fetch the custom taxonomy "categorie"
            $categories = get_the_terms(get_the_ID(), 'categorie');
            if ($categories) {
                echo '<div class="masonry-photo-category">';
                foreach ($categories as $category) {
                    echo '<span class="category">' . $category->name . '</span>';
                }
                echo '</div>';
            }
            // Close the container div photo-details
            echo '</div>';

            // Display the content of the post
            the_content();
            

            // Close the grid item
            echo '</div>';
            

            // Check if it's time to start a new row
            if ($item_count % 2 === 0) {
                echo '<div class="home-masonry-fix"></div>';
            }

        endwhile;

            // Load more posts
            echo '<div id="front-page-new-posts-container"></div>';


        // Close the grid container
        echo '</div>';

        wp_reset_postdata(); // Restore the global post data

    else :
        echo 'No custom posts found.';
    endif;
    ?>

    <!-- Load more button -->
    <div class="load-more-button-container">
        <button id="home-load-more-button" class="more-button" data-page="1">Charger plus</button>
    </div>
</section>


</div> <!-- Close home-container -->

<?php get_footer(); ?>
