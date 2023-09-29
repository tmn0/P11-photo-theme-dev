<div class="nav-container">
    <div class="logo-container">
    <a href="<?php echo get_site_url()?>">
        <img class="nav-logo" alt="site-title-image"
        src="<?php echo get_stylesheet_directory_uri() . '/medias/logo_med.png'?>">
    </a>
    </div>

    <div class="nav-menu-container">
        <nav role="navigation" aria-label="<?php _e('main menu', 'text-domain'); ?>">
            <?php
                wp_nav_menu([
                    'theme_location' => 'custom-menu',
                    'container'      => false,
                    'walker' => new Walker_Main_Menu(),
                ]);
            ?>
            <?php get_template_part('contact'); ?>
        </nav>
    </div>    
</div>


