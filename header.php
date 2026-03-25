<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header id="masthead" class="site-header menuprin" role="banner">
        <div class="container contenedormenu">
            
            <div class="logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php 
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                    } else {
                        echo '<h1 class="site-title">' . get_bloginfo( 'name' ) . '</h1>';
                    }
                    ?>
                </a>
            </div>

            <nav id="site-navigation" class="main-navigation nav menuprincipal" role="navigation">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>

                <?php
                wp_nav_menu( array(
                    'theme_location' => 'header-menu', // Asegúrate de que este nombre coincida en functions.php
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'menu_class'     => 'menuprin-list',
                ) );
                ?>
            </nav>

        </div>
    </header>

    <div id="content" class="site-content">