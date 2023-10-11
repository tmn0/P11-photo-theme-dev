<div class="hero-container">      
    <img class="hero-title"  alt="hero-title"
    src="<?php echo get_stylesheet_directory_uri() . '/medias/hero-title.png'?>">   


<!-- selectable hero img in wordpress -->    
    
        <div id="custom-hero-image">
        <?php if (get_header_image()) : ?>
            <img src="<?php header_image(); ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>">
           
        <?php else: ?>
        <img src="<?php echo get_template_directory_uri() . '/medias/hero-bg.jpeg'?>"> 
        </div>
        <?php endif ?>  
</div>

