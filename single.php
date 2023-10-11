<?php get_template_part('header'); ?>
<header>
<?php get_template_part('template-part/navmenu'); ?>
</header>

<?php 
while (have_posts()) :
    the_post();
?>

    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h1><?php the_title(); ?></h1>
        <div class="post-content">
            <?php the_content(); ?>
        </div>
        
        
        
    </div>

<?php
endwhile;
?>

<?php get_footer(); ?>