<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />    
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/style.css'?>">
    <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() . '/scripts/scripts.js'?>"></script>
    <!-- testing external for modal -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- testing external for modal -->
    <title>Nathalie Mota photographe</title>       
</head>

<body>

<?php echo get_template_part('/template-part/navmenu'); ?>


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