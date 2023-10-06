<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />    
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/style.css'?>">
    <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() . '/scripts/scripts.js'?>"></script>   
    <!-- our project just needs Font Awesome Solid + Brands -->
    <link href="<?php echo get_stylesheet_directory_uri() . '/assets/fa-free/css/fontawesome.css'?>" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri() . '/assets/fa-free/css/brands.css'?>" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri() . '/assets/fa-free/css/solid.css'?>" rel="stylesheet">
    <script src="<?php echo get_stylesheet_directory_uri() . '/scripts/jquery-3.7.1.min.js'?>"></script>
    <title>Nathalie Mota photographe</title>       
</head>

<body>

<?php echo get_template_part('/template-part/navmenu'); ?>
<?php echo get_template_part('/template-part/contact'); ?>
<!-- (vérif template part dans template part) -->

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