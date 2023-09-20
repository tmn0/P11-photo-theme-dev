<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />    
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/style.css'?>">
    <title>Nathalie Mota photographe</title>    
</head>

<body>

<?php echo get_template_part('/template-part/template-navmenu'); ?>


<header class="header-hero-container">      
    <img class="hero-title"  alt="hero-title"
    src="<?php echo get_stylesheet_directory_uri() . '/medias/header-title.png'?>">   


<!-- selectable hero img in wordpress -->    
    
        <div id="custom-hero-image">
        <?php if (get_header_image()) : ?>
            <img src="<?php header_image(); ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>">
           
        <?php else: ?>
        <img src="<?php echo get_template_directory_uri() . '/medias/header-bg.jpeg'?>"> 
        </div>
        <?php endif ?>  
     

</header>