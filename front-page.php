<?php get_header(); ?>

<div class="home-container">
    <!-- Buttons & Filters -->
    <div class="taxonomy-selector-main-container">
        <div class="taxonomy-selector-left-container">
            <!-- Button 1 -->
            <div class="taxonomy-button-container">
                <button class="home-button">
                    <p class="home-button-title">CATÉGORIES</p>
                    <div class="fa-caret-container">
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                </button>
                <div class="home-dropdown">
                    <a href="#">Réception</a>
                    <a href="#">Télévision</a>
                    <a href="#">Concert</a>
                    <a href="#">Mariage</a>
                </div>
            </div>
            <!-- Button 2 -->
            <div id="format-button" class="taxonomy-button-container">
                <button class="home-button">
                    <p class="home-button-title">CATÉGORIES</p>
                    <div class="fa-caret-container">
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                </button>
                <div class="home-dropdown">
                    <a href="#">Format</a>
                    <a href="#">Type</a>                
                </div>
            </div> <!-- End of Button 2 -->
        </div> <!-- End of taxonomy-selector-left-container -->

        <div class="taxonomy-selector-right-container">
            <div class="taxonomy-button-container">
                <button class="home-button">
                    <p class="home-button-title">CATÉGORIES</p>
                    <div class="fa-caret-container">
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                </button>
                <div class="home-dropdown">
                    <a href="#">Réception</a>
                    <a href="#">Télévision</a>
                    <a href="#">Concert</a>
                    <a href="#">Mariage</a>
                </div>
            </div>
        </div>

    </div> <!-- End of taxonomy-selector-main-container -->

    <!-- Custom post + masonry -->
    <?php
    $custom_query_args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
    );

    // Create a new custom query
    $custom_query = new WP_Query($custom_query_args);

    // Initialize a counter to keep track of items
    $item_count = 0;

    // Open a container for the grid
    echo '<div class="home-masonry-grid">';

    // Loop through the custom query results
    if ($custom_query->have_posts()) :
        while ($custom_query->have_posts()) :
            $custom_query->the_post();

            // Increment the item count
            $item_count++;

            // Open a grid item
            echo '<div class="home-masonry-item">';

            // Display the content of the post
            the_content();

            // Close the grid item
            echo '</div>';

            /*
            // Check if it's time to start a new row
            if ($item_count % 2 === 0) {
                echo '<div class="home-masonry-fix"></div>';
            }
            */
        endwhile;

        // Close the grid container
        echo '</div>';

        wp_reset_postdata(); // Restore the global post data

    else :
        echo 'No custom posts found.';
    endif;
    ?>

    <!-- Load more button -->
    <div class="load-more-button-container">
        <button id="home-load-more-button" class="more-button" data-page="2">Charger plus</button>
    </div>
</div> <!-- Close home-container -->

<?php get_footer(); ?>
