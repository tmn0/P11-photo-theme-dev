<?php get_template_part('header'); ?>
<header>
<?php get_template_part('template-part/navmenu'); ?>
</header>

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
    // Custom taxo 1
    $terms = get_the_terms(get_the_ID(), 'categorie');
    // Custom taxo 2
    $terms_format = get_the_terms(get_the_ID(), 'format');

    // Call custom taxos
    if (($terms || $terms_format) && (!is_wp_error($terms) || !is_wp_error($terms_format))) {
        echo '<div>'; 

        if ($terms) {
            echo '<h2>Categorie:</h2>';
            foreach ($terms as $term) {
                echo '<p>' . $term->name . '</p>';
            }
        }

        if ($terms_format) {
            echo '<h2>Format:</h2>';
            foreach ($terms_format as $term) {
                echo '<p>' . $term->name . '</p>';
            }
        }

        echo '</div>'; 
    }
?>

    



    <div class="single-content-right">        
        <?php the_content(); ?>                
    </div>

        <?php
        endwhile;
        ?>

</section>

<?php get_footer(); ?>
