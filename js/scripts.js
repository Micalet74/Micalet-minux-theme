/**
 * Micalet Minux - Main Scripts
 */
(function($) {
    "use strict";

    // Objeto principal para organizar el código
    var MicaletApp = {
        
        // Inicialización
        init: function() {
            this.menuMobile();
            this.headerScroll();
            this.animations();
        },

        // Lógica para el menú responsive
        menuMobile: function() {
            const $btn = $('.menu-toggle'); // Asegúrate de que tu botón tenga esta clase
            const $nav = $('.main-navigation');

            $btn.on('click', function(e) {
                e.preventDefault();
                $nav.toggleClass('is-active');
                $(this).toggleClass('is-active');
            });
        },

        // Efecto en el header al hacer scroll
        headerScroll: function() {
            const $header = $('header.site-header');
            
            $(window).on('scroll', function() {
                if ($(window).scrollTop() > 50) {
                    $header.addClass('header-scrolled');
                } else {
                    $header.removeClass('header-scrolled');
                }
            });
        },

        // Espacio para animaciones (puedes usar AOS o GSAP aquí más adelante)
        animations: function() {
            console.log('Micalet Minux: Scripts cargados correctamente.');
            
            // Ejemplo: Fade in suave para los items del listado que creamos antes
            $('.micalet-item').each(function(i) {
                $(this).css({
                    'opacity': 0,
                    'transform': 'translateY(20px)',
                    'transition': 'all 0.6s ease'
                });
                
                setTimeout(() => {
                    $(this).css({
                        'opacity': 1,
                        'transform': 'translateY(0)'
                    });
                }, 200 * i);
            });
        }
    };

    // Ejecutar cuando el DOM esté listo
    $(document).ready(function() {
        MicaletApp.init();
    });

})(jQuery);