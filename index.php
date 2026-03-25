<?php get_header(); ?>

<main id="primary" class="site-main landing-page" role="main">
    <?php
    while ( have_posts() ) :
        the_post();
        // Esto carga el contenido que diseñes con WPBakery/Elementor/Gutenberg
        the_content();
    endwhile;
    ?>
</main>

<?php get_footer(); ?>