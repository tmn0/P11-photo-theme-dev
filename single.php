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
    echo '<div><p>Référence:</p>';    
        echo '<p>'. $terms_reference . '</p>';    
    echo '</div>';
}


if ($terms_categorie) {
    echo '<div><p>Categorie:</p>';
    foreach ($terms_categorie as $term) {
        echo '<p>' . $term->name . '</p>';
    }
    echo '</div>';

}

if ($terms_format) {
    echo '<div><p>Format:</p>';
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

<?php get_footer(); ?>

<!-- mini image avec fleche: le post d'après
cf code theme 2020 de wp et adapter

2 photos suivantes dans single: random dans meme catégorie
-->