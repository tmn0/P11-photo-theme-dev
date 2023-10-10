<?php
get_header();

// Start the loop
while (have_posts()) :
    the_post();
?>

    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h1><?php the_title(); ?></h1>
        <div class="post-content">
            <?php the_content(); ?>
        </div>
        
        <!-- Display custom taxonomy terms -->
        <div class="custom-taxonomy-terms">
            <?php
            $photo_terms = get_the_terms(get_the_ID(), 'photo');
            if ($photo_terms) {
                echo '<p>Photo Categories: ';
                $term_links = array();
                foreach ($photo_terms as $term) {
                    $term_links[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
                }
                echo implode(', ', $term_links);
                echo '</p>';
            }
            ?>
        </div>
    </div>

<?php
endwhile;