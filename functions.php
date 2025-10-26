<?php
/**
 * Telica Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Telica 1.1
 * @since Telica 1.1
 */

// Adds theme support for post formats.
if ( ! function_exists( 'telica_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Telica 1.1
	 *
	 * @return void
	 */
	function telica_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'telica_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'telica_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Telica 1.1
	 *
	 * @return void
	 */
	function telica_editor_style() {
		add_editor_style( 'assets/css/editor-style.css' );
    add_editor_style( 'assets/css/components.css' );
	}
endif;
add_action( 'after_setup_theme', 'telica_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'telica_enqueue_assets' ) ) :
  /**
   * Enqueue assets built by Vite.
   *
   * @since Telica 1.2
   */
  function telica_enqueue_assets() {
    $theme_dir = get_template_directory();
		$theme_uri = get_template_directory_uri();
		$dist_path = $theme_dir . '/dist';
		$dist_uri  = $theme_uri . '/dist';
		$version   = wp_get_theme()->get( 'Version' );

    $dev_mode = file_exists( $dist_path . '/assets/css/style.css' );

    $path = get_template_directory() . '/assets/css/components.css';
    $uri  = get_template_directory_uri() . '/assets/css/components.css';

    if ( file_exists( $path ) ) {
        $ver = filemtime( $path );
        wp_enqueue_style( 'telica-components', $uri, array(), $ver );
    }

    if ( $dev_mode ) {
			wp_enqueue_style(
				'telica-style',
				$dist_uri . '/assets/css/style.css',
				array(),
				$version
			);

			wp_enqueue_script(
				'telica-main',
				$dist_uri . '/assets/js/main.js',
				array(),
				$version,
				true
			);

		} else {
			$manifest_path = $dist_path . '/manifest.json';

			if ( file_exists( $manifest_path ) ) {
				$manifest = json_decode( file_get_contents( $manifest_path ), true );
				$css_file = null;
				$js_file  = null;

				foreach ( $manifest as $entry ) {
					if ( isset( $entry['file'] ) && str_ends_with( $entry['file'], '.js' ) ) {
						$js_file = $entry['file'];
					}

					if ( isset( $entry['css'] ) && ! empty( $entry['css'][0] ) ) {
						$css_file = $entry['css'][0];
					}
				}

				if ( $css_file ) {
					wp_enqueue_style(
						'telica-style',
						$dist_uri . '/' . $css_file,
						array(),
						$version
					);
				}

				if ( $js_file ) {
					wp_enqueue_script(
						'telica-main',
						$dist_uri . '/' . $js_file,
						array(),
						$version,
						true
					);
				}
			}
		}
  }
endif;
add_action( 'wp_enqueue_scripts', 'telica_enqueue_assets' );


function telica_register_block_patterns() {
    register_block_pattern_category(
        'featured',
        array( 'label' => __( 'Featured', 'telica' ) )
    );
    register_block_pattern_category(
        'call-to-action',
        array( 'label' => __( 'Call to Action', 'telica' ) )
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

    // Author Box pattern
    if ( file_exists( get_template_directory() . '/patterns/author-box.php' ) ) {
        register_block_pattern(
            'telica/author-box',
            array(
                'title'       => __( 'Author Box', 'telica' ),
                'description' => _x( 'Box with image, text, and social icons.', 'Pattern description', 'telica' ),
                'categories'  => array( 'call-to-action' ),
                'content'     => file_get_contents( get_template_directory() . '/patterns/author-box.php' ),
            )
        );
    }

    // Load portfolio pattern and replace placeholder with theme URI so editor gets real URLs.
    $portfolio_content = file_get_contents( get_template_directory() . '/patterns/portfolio.php' );
    if ( false !== $portfolio_content ) {
        $portfolio_content = str_replace( '%%THEME_URI%%', esc_url( get_stylesheet_directory_uri() ), $portfolio_content );
        register_block_pattern(
            'telica/portfolio',
            array(
                'title'       => __( 'Portfolio', 'telica' ),
                'description' => _x( 'Portfolio with heading, text, and images.', 'Pattern description', 'telica' ),
                'categories'  => array( 'featured' ),
                'content'     => $portfolio_content,
            )
        );
    }
}
add_action( 'init', 'telica_register_block_patterns' );

// function telica_enqueue_assets() {
//     $path = get_template_directory() . '/assets/css/components.css';
//     $uri  = get_template_directory_uri() . '/assets/css/components.css';

//     if ( file_exists( $path ) ) {
//         $ver = filemtime( $path );
//         wp_enqueue_style( 'telica-components', $uri, array(), $ver );
//     }
// }
// add_action( 'wp_enqueue_scripts', 'telica_enqueue_assets' );