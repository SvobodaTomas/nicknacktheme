<?php
/**
 * Custom Gutenberg blocks
 * 
 * @see https://www.advancedcustomfields.com/resources/acf_register_block_type/
 */

define( 'NN_BLOCK_CATEGORY', "portiva-special" );

function nn_acf_blocks_init() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // GLOBAL BLOCKS

        // Product slider gallerys
        acf_register_block_type(array(
            'name'              => 'product-slider-gallery',
            'title'             => __('Galerie produktů'),
            'description'       => __('Galerie produktů - slider'),
            'mode'              => 'edit',
            'render_template'   => 'template-parts/blocks/product-slider-gallery.php',
            'category'          => NN_BLOCK_CATEGORY,
        ));
    }
}
add_action( 'acf/init', 'nn_acf_blocks_init' );

/**
 * Register custom block category
 *
 * @param Array $categories
 * @param Object $post
 *
 * @return Array
 */
function nicknack_block_categories( $categories, $post ) {

    // Post types able to use these blocks
    // $enabled_post_types = array( 'post' );

    // if ( ! in_array($post->post_type,$enabled_post_types) ) {
    //     return $categories;
    // }

    $nn_special = array(
        array(
            'slug' => NN_BLOCK_CATEGORY,
            'title' => 'portiva',
            'icon'  => 'hammer',
        ),
    );

    array_merge(
        $categories,
        array(
            $nn_special
        )
    );

    return $categories;
}
add_filter( 'block_categories', 'nicknack_block_categories', 10, 2 );

/**
 * Restrict gutenberg blocks.
 * 
 * @param Bool|Array $allowed_block_types
 * @param WP_Post $post
 */
function nicknack_restrict_block_types( $allowed_block_types, $post ) {

	// Disable all blocks
	// return array();
 
	// return array(
	// 	'core/image',
	// 	'core/paragraph',
	// 	'core/heading',
	// 	'core/list',
	// 	'core/gallery',
	// 	'core/table',
	// 	// 'acf/...',
	// );

	return $allowed_block_types;
}
add_filter( 'allowed_block_types', 'nicknack_restrict_block_types', 10, 2 );
?>