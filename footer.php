</div><footer id="colophon" class="site-footer footer" role="contentinfo">
        <div class="container">
            <div class="row footer-widgets">
                
                <div class="col-footer">
                    <div class="footer-logo">
                        <?php if ( has_custom_logo() ) { the_custom_logo(); } ?>
                    </div>
                    <p class="footer-description">
                        <?php bloginfo('description'); ?>
                    </p>
                </div>

                <div class="col-footer">
                    <h3><?php _e('Enlaces', 'micaletminux'); ?></h3>
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'footer-menu',
                        'fallback_cb'    => false,
                        'container'      => false,
                        'menu_class'     => 'footer-links',
                    ) );
                    ?>
                </div>

                <div class="col-footer">
                    <h3><?php _e('Contacto', 'micaletminux'); ?></h3>
                    <div class="footer-contact">
                        <p>Hola@micaletminux.com</p>
                    </div>
                </div>

            </div>

            <div class="site-info">
                <hr>
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> - <?php _e('Todos los derechos reservados', 'micaletminux'); ?></p>
            </div>
        </div>
    </footer>

    <?php wp_footer(); // ¡VITAL! Aquí se cargan los JS ?>
</body>
</html>