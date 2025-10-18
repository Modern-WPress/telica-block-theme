<?php
function telica_register_block_patterns() {
    register_block_pattern_category(
        'featured',
        array( 'label' => __( 'Featured', 'telica' ) )
    );

    register_block_pattern(
        'telica/hero-block',
        array(
            'title'       => __( 'Hero Block', 'telica' ),
            'description' => _x( 'Sección hero con fondo, título, subtítulo y botón.', 'Pattern description', 'telica' ),
            'categories'  => array( 'featured' ),
            'content'     => file_get_contents( get_template_directory() . '/patterns/hero-block.php' ),
        )
    );

    register_block_pattern(
        'telica/three-columns-cards',
        array(
            'title'       => __( 'Three Columns Cards', 'telica' ),
            'description' => _x( 'Tres tarjetas en tres columnas en escritorio y una columna en móvil.', 'Pattern description', 'telica' ),
            'categories'  => array( 'featured' ),
            'content'     => file_get_contents( get_template_directory() . '/patterns/three-columns-cards.php' ),
        )
    );

    register_block_pattern(
        'telica/cta',
        array(
            'title'       => __( 'CTA', 'telica' ),
            'description' => _x( 'Call to action with left text and two buttons on the right.', 'Pattern description', 'telica' ),
            'categories'  => array( 'featured' ),
            'content'     => file_get_contents( get_template_directory() . '/patterns/cta.php' ),
        )
    );
}
add_action( 'init', 'telica_register_block_patterns' );

function telica_enqueue_assets() {
    $path = get_template_directory() . '/assets/css/components.css';
    $uri  = get_template_directory_uri() . '/assets/css/components.css';

    if ( file_exists( $path ) ) {
        $ver = filemtime( $path );
        wp_enqueue_style( 'telica-components', $uri, array(), $ver );
    }
}
add_action( 'wp_enqueue_scripts', 'telica_enqueue_assets' );

// Load styles inside the block editor (Gutenberg)
function telica_enqueue_editor_assets() {
    // Ensure theme supports editor styles
    add_theme_support( 'editor-styles' );
    // Reuse the same components stylesheet in the editor
    add_editor_style( 'assets/css/components.css' );
}
add_action( 'after_setup_theme', 'telica_enqueue_editor_assets' );

