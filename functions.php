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
}
add_action( 'init', 'telica_register_block_patterns' );
