<div class="nav-container">
    <a href="<?php echo get_site_url()?>">
        <img class="nav-logo" alt="site-title-image"
        src="<?php echo get_stylesheet_directory_uri() . '/medias/logo_med.png'?>">
    </a>

    <div class="nav-menu-container">
    <?php
    if (has_nav_menu('custom-menu')) { 
        wp_nav_menu(array(
            'theme_location' => 'Menu1',
            'menu_class' => 'nav-menu1', 
        ));
    }
    ?>
    </div>    
</div>