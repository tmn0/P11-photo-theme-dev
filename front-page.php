<?php get_header(); ?>

</header>
<?php get_template_part('template-part/navmenu'); ?>
<?php get_template_part('template-part/hero'); ?>
</header>

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
                    <a href="#">Réception</a>
                    <a href="#">Télévision</a>
                    <a href="#">Concert</a>
                    <a href="#">Mariage</a>
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
                    <a href="#">Paysage</a>
                    <a href="#">Portrait</a>                
                </div>
            </div> <!-- End of Button 2 -->
        </div> <!-- End of taxonomy-selector-left-container -->

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

    <!-- Custom post + masonry -->
<section id="front-masonry">
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

            // Get the permalink of the post
            $post_permalink = get_permalink();

            // Open a grid item and wrap it in an anchor tag with target="_blank"
            echo '<a href="' . esc_url($post_permalink) . '" class="home-masonry-item" target="_blank">';

            
            // Display the content of the post
            the_content();

            // Close the anchor tag and the grid item
            echo '</a>';

            
            // Check if it's time to start a new row
            if ($item_count % 2 === 0) {
                echo '<div class="home-masonry-fix"></div>';
            }
            
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
        <button id="home-load-more-button" class="more-button" data-page="1">Charger plus</button>
    </div>
</section>

</div> <!-- Close home-container -->

<?php get_footer(); ?>
