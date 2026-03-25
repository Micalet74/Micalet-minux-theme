<?php
/**
 * Theme Name: Micalet Minux
 * Author: Micalet WDS
 */

/*------------------------------------*\
	1. SOPORTE DEL TEMA
\*------------------------------------*/

if ( ! isset( $content_width ) ) {
    $content_width = 1200;
}

if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'menus' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' ); // Importante para SEO moderno

    // Tamaños de imagen personalizados
    add_image_size( 'large', 1024, '', true );
    add_image_size( 'medium', 600, '', true );
    add_image_size( 'small', 300, '', true );
    add_image_size( 'custom-size', 800, 400, true );

    // Idiomas
    load_theme_textdomain( 'micaletminux', get_template_directory() . '/languages' );
}

/*------------------------------------*\
	2. SCRIPTS Y ESTILOS
\*------------------------------------*/

// Carga en el Frontend
function micaletminux_assets() {
    if ( ! is_admin() ) {
        // Estilos
        wp_enqueue_style( 'normalize', get_template_directory_uri() . '/normalize.css', array(), '8.0.1' );
        wp_enqueue_style( 'micaletminux-main', get_template_directory_uri() . '/style.css', array(), '1.0.0' );
        wp_enqueue_style( 'dashicons' ); // Carga dashicons en el front si lo necesitas

        // Scripts
        wp_enqueue_script( 'micaletminux-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), '1.0.0', true );
        wp_localize_script( 'micaletminux-scripts', 'micalet_vars', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'micaletminux_assets' );

// Carga en el Admin
function micaletminux_admin_assets() {
    wp_enqueue_media();
    wp_enqueue_script( 'micaletminux-admin', get_template_directory_uri() . '/js/script_importar.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'micaletminux_admin_assets' );

/*------------------------------------*\
	3. MENÚS Y SIDEBARS
\*------------------------------------*/

function micaletminux_register_menus() {
    register_nav_menus( array(
        'header-menu'  => __( 'Menú Cabecera', 'micaletminux' ),
        'footer-menu'  => __( 'Menú Pie de Página', 'micaletminux' ),
    ) );
}
add_action( 'init', 'micaletminux_register_menus' );

function micaletminux_register_sidebars() {
    register_sidebar( array(
        'name'          => __( 'Barra Lateral Principal', 'micaletminux' ),
        'id'            => 'main-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'micaletminux_register_sidebars' );

/*------------------------------------*\
	4. FUNCIONES DE UTILIDAD
\*------------------------------------*/

// Acortador de texto optimizado
function micalet_cortar_texto( $texto, $limite = 100 ) {
    $texto = wp_strip_all_tags( $texto );
    if ( mb_strlen( $texto ) > $limite ) {
        $texto = mb_substr( $texto, 0, $limite );
        $texto = mb_substr( $texto, 0, mb_strrpos( $texto, ' ' ) ) . '...';
    }
    return $texto;
}

// Limpieza de clases del body
add_filter( 'body_class', function( $classes ) {
    global $post;
    if ( is_singular() ) {
        $classes[] = $post->post_name;
    }
    return $classes;
});

/*------------------------------------*\
	5. SHORTCODE: LISTADO DE ENTRADAS
\*------------------------------------*/

function micalet_shortcode_listado_entradas( $atts ) {
    $a = shortcode_atts( array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'tipo' => 'fila', // fila o cuadricula
        'order' => 'DESC',
        'orderby' => 'date',
        'mostrar_resumen' => 'si'
    ), $atts );

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    
    $args = array(
        'post_type'      => explode( ',', $a['post_type'] ),
        'posts_per_page' => $a['posts_per_page'],
        'orderby'        => $a['orderby'],
        'order'          => $a['order'],
        'paged'          => $paged,
    );

    $query = new WP_Query( $args );
    $output = '<div class="micalet-grid ' . esc_attr( $a['tipo'] ) . '">';

    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            $output .= '<div class="micalet-item">';
            if ( has_post_thumbnail() ) {
                $output .= '<div class="micalet-img"><a href="'.get_permalink().'">' . get_the_post_thumbnail( get_the_ID(), 'medium' ) . '</a></div>';
            }
            $output .= '<h3><a href="'.get_permalink().'">' . get_the_title() . '</a></h3>';
            if ( $a['mostrar_resumen'] === 'si' ) {
                $output .= '<p>' . micalet_cortar_texto( get_the_excerpt(), 150 ) . '</p>';
            }
            $output .= '</div>';
        endwhile;
        wp_reset_postdata();
    else :
        $output .= __( 'No se encontraron entradas.', 'micaletminux' );
    endif;

    $output .= '</div>';
    return $output;
}
add_shortcode( 'listado_entradas', 'micalet_shortcode_listado_entradas' );

/*------------------------------------*\
	6. COMPATIBILIDAD WPBAKERY
\*------------------------------------*/
add_action( 'vc_before_init', 'micalet_vc_integration' );
function micalet_vc_integration() {
    if ( function_exists( 'vc_map' ) ) {
        vc_map( array(
            "name" => __( "Listado Micalet", "micaletminux" ),
            "base" => "listado_entradas",
            "category" => __( "Micalet Minux", "micaletminux" ),
            "params" => array(
                array(
                    "type" => "textfield",
                    "heading" => __( "Tipo de Post", "micaletminux" ),
                    "param_name" => "post_type",
                    "value" => "post"
                ),
            )
        ) );
    }
}