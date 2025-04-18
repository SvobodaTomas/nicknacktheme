<?php

# Custom Gutenberg blocks
require_once( 'inc/gutenberg-blocks.php' );

// Move Yoast to bottom
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');

// Register Gallery post type
// register_post_type("cpt-gallery",
// 	array(
// 		'labels' => array(
// 			'name'          => __( 'Gallerie' ),
// 			'singular_name' => __( 'Gallerie' ),
// 			'add_new'       => __( 'Přidat' ),
// 			'add_new_item'  => __( 'Přidat' ),
// 			'edit'          => __( 'Upravit' ),
// 			'edit_item'     => __( 'Upravit' ),
// 			'new_item'      => __( 'Upravit' ),
// 			'view'          => __( 'Zobrazit' ),
// 			'view_item'     => __( 'Zobrazit' ),
// 			'search_items'  => __( 'Prohledávat' ),
// 			'not_found'     => __( 'Nic nenalezeno' ),
// 			'not_found_in_trash' => __( 'Nic nenalezeno' ),
// 		),
// 		'public' => true,
// 		"publicaly_queryable" => false,
// 		"has_archive" => false,
// 		"menu_icon" => "dashicons-format-image",
// 		'capability_type' => 'post',
// 		'hierarchical' => true,
// 		'supports' => array( 'title', 'thumbnail'),
// 	)
// );
// // Register taxonomy Categories for Galleries
// $labels = array(
// 	'name'              => _x( 'Typ', 'taxonomy general name', 'textdomain' ),
// 	'singular_name'     => _x( 'Typ', 'taxonomy singular name', 'textdomain' ),
// 	'search_items'      => __( 'Hledat', 'textdomain' ),
// 	'all_items'         => __( 'Vše', 'textdomain' ),
// 	'edit_item'         => __( 'Upravit', 'textdomain' ),
// 	'update_item'       => __( 'Upravit', 'textdomain' ),
// 	'add_new_item'      => __( 'Nový', 'textdomain' ),
// 	'new_item_name'     => __( 'Nový', 'textdomain' ),
// 	'menu_name'         => __( 'Typ', 'textdomain' ),
// );

// $args = array(
// 	'hierarchical'      => true,
// 	'labels'            => $labels,
// 	'show_ui'           => true,
// 	'show_admin_column' => true,
// 	'query_var'         => true,
// 	'rewrite'           => array( 'slug' => 'typ' ),
// );

// register_taxonomy('tax-type', array( 'cpt-gallery' ), $args );

/**
 * WP-Forge functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage WP_Forge
 * @since WP-Forge 5.5.0.1
 */

/**
 * Lets start off by cleaning up the output of wp_head()
 */
 // Remove the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links_extra', 3 );
// Remove the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'feed_links', 2 );
// Remove the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'rsd_link' );
// Remove the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'wlwmanifest_link' );
// Remove index link
remove_action( 'wp_head', 'index_rel_link' );
// Remove prev link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
// Remove start link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
// Remove relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
// Remove the XHTML generator that is generated on the wp_head hook, WP version
remove_action( 'wp_head', 'wp_generator' );

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 623;

/**
 * Sets up theme defaults and registers the various WordPress features that
 * WP-Forge supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links, custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since WP-Forge 5.5.0.1
 */
function wpforge_setup() {
	/*
	 * Makes WP-Forge available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on WP-Forge, use find and replace
	 * to change 'wpforge' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'wpforge', get_template_directory() . '/language' );

	// This theme styles the visual editor to resemble the theme style
	add_editor_style( array( 'style.css',/*'css/foundation.css', */'fonts/wpforge-fonts.css' ) );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Makes our theme support WooCommerce
	add_theme_support( 'woocommerce' );

	//Switches default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	// This theme supports all available post formats by default. See http://codex.wordpress.org/Post_Formats
	//add_theme_support( 'post-formats', array(
	//		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	//) );

	// Add Excerpt support to Pages
	add_post_type_support( 'page', 'excerpt' );

	// Adds support for Jetpack's Infinite Scroll
	add_theme_support( 'infinite-scroll', array(
		'container' => 'content',
		'footer' => 'page',
	) );

	// Adds Title-Tag support
	add_theme_support( 'title-tag' );

	// This theme uses wp_nav_menu() in three locations.
	register_nav_menus(array(
		'primary' 	=> __( 'Main Menu', 'wpforge' ),
		'secondary' => __( 'Footer Menu', 'wpforge' ),
		'social' 	=> __( 'Social Menu', 'wpforge' ),
	));

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 623, 9999 ); // Unlimited height, soft crop

	// This theme supports custom background color and image, and here we also set up the default background color.
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );

}
add_action( 'after_setup_theme', 'wpforge_setup' );

/**
 * Adds custom header support
 *
 * @since WP-Forge 5.5.0.1
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Loads the Customizer
 *
 * @since WP-Forge 5.5.0.1
 */
require( get_template_directory() . '/inc/customizer/customizer.php' );

/**
 * Enqueue our scripts and styles
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_scripts_styles' ) ) {
	function wpforge_scripts_styles() {
		global $wp_styles;

		// Register our scripts
		wp_register_script ( 'modernizr', get_template_directory_uri() . '/js/vendor/modernizr.js', array('jquery'), '5.4', false );
		wp_register_script ( 'foundation-js', get_template_directory_uri() . '/js/foundation.min.js', array('jquery'), '5.4', true );

		if ( ICL_LANGUAGE_CODE == 'pl' ) {
			wp_register_script ( 'functions-js-pl', get_template_directory_uri() . '/js/functions-pl.min.js?v='.filemtime(get_stylesheet_directory() . '/js/functions-pl.min.js'), array('jquery'), '7.0', true );
		} else {
			wp_register_script ( 'functions-js', get_template_directory_uri() . '/js/functions.min.js?v='.filemtime(get_stylesheet_directory() . '/js/functions.min.js'), array('jquery'), '7.0', true );
		}
		// wp_register_script ( 'functions-js', get_template_directory_uri() . '/js/functions.js?v='.filemtime(get_stylesheet_directory() . '/js/functions.js'), array('jquery'), '7.0', true );

		/**
		 * Make the "Back" string in Foudation mobile menu translatable
		 * @see http://codex.wordpress.org/Function_Reference/wp_localize_script
		 * @author Thomas Meyer - https://github.com/tmconnect
		 *
		 * @since WP-Forge 5.5.0.1
		 */
		$translation_array = array(
			'nav_back' => __( 'Back', 'wpforge' ),
			'processing' => __( 'Processing...', 'wpforge' ),
			'add_product' => __( 'Přidat produkt', 'nicknack' )
		);
		wp_localize_script( 'foundation-js', 'foundation_strings', $translation_array );

		// Enqueue our scripts
	    wp_enqueue_script( 'modernizr' );
	    wp_enqueue_script( 'foundation-js' );
		if ( ICL_LANGUAGE_CODE == 'pl' ) {
			wp_enqueue_script( 'functions-js-pl' );
		} else {
			wp_enqueue_script( 'functions-js' );
		}

		// Register our stylesheets
		wp_register_style( 'wpforge-fonts', get_template_directory_uri() . '/fonts/wpforge-fonts.css' );
		wp_register_style( 'normalize', get_template_directory_uri() . '/css/normalize.css' );
		wp_register_style( 'foundation', get_template_directory_uri() . '/css/foundation.css' );
			//wp_register_style( 'custom', get_template_directory_uri() . '/style?v=1.1.css' );
		wp_register_style( 'wpforge', get_stylesheet_directory_uri() . '/style.css?v='.filemtime(get_stylesheet_directory() . '/style.css'), array(), false, 'all' );
		wp_register_style( 'form', get_stylesheet_directory_uri() . '/css/form.min.css?v='.filemtime(get_stylesheet_directory() . '/css/form.min.css'), array(), false, 'all' );
		wp_register_style( 'app', get_stylesheet_directory_uri() . '/css/app.min.css?v='.filemtime(get_stylesheet_directory() . '/css/app.min.css'), array(), false, 'all' );
		wp_register_style( 'acf-blocks', get_stylesheet_directory_uri() . '/css/acf-blocks.min.css?v='.filemtime(get_stylesheet_directory() . '/css/acf-blocks.min.css'), array(), false, 'all' );


		// Enqueue our stylesheets
		wp_enqueue_style( 'wpforge-fonts' );
		wp_enqueue_style( 'normalize' );
		wp_enqueue_style( 'foundation' );
		wp_enqueue_style( 'wpforge' );
		wp_enqueue_style( 'form' );
		wp_enqueue_style( 'acf-blocks' );
		wp_enqueue_style( 'app' );
		//wp_enqueue_style( 'custom' );
	}
	add_action( 'wp_enqueue_scripts', 'wpforge_scripts_styles', 0 );
}

/**
 * Enque threaded comments script in footer
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_enqueue_comments_reply' ) ) {
	function wpforge_enqueue_comments_reply() {
		if( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'comment_form_before', 'wpforge_enqueue_comments_reply' );
}

/**
 * Add Foundation 'active' class for the current menu item
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_active_nav_class' ) ) {
	function wpforge_active_nav_class( $classes, $item ) {
		if ( $item->current == 1 || $item->current_item_ancestor == true ) {
			$classes[] = 'active';
		}
		return $classes;
	}
	add_filter( 'nav_menu_css_class', 'wpforge_active_nav_class', 10, 2 );
}

/**
 * Use the active class of ZURB Foundation on wp_list_pages output.
 * From required+ Foundation http://themes.required.ch
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_active_list_pages_class' ) ) {
	function wpforge_active_list_pages_class( $input ) {

		$pattern = '/current_page_item/';
		$replace = 'current_page_item active';

		$output = preg_replace( $pattern, $replace, $input );

		return $output;
	}
	add_filter( 'wp_list_pages', 'wpforge_active_list_pages_class', 10, 2 );
}

// Add user id CSS class via http://codex.wordpress.org/Function_Reference/body_class
/*function add_helpful_user_classes() {
    if ( is_user_logged_in() ) {
        add_filter('body_class','class_to_body');
        add_filter('admin_body_class', 'class_to_body_admin');
    }
}
add_action('init', 'add_helpful_user_classes');
if ( is_user_logged_in() ) {
    add_filter('body_class','add_role_to_body');
    add_filter('admin_body_class','add_role_to_body');
}*/
/* Adds the user id to the admin body class array */
add_filter('admin_body_class', 'add_username_to_body');
function add_username_to_body( $classes ) {
	// add 'class-name' to the $classes array
	global $current_user;
	$user_ID = $current_user->ID;

	if ( is_array($classes) ) {
		$classes[] = 'user-id-' . $user_ID;
	} elseif ( is_string($classes) ) {
		$classes .= ' user-id-' . $user_ID;
	}
	// return the $classes array
	return $classes;
}

/**
 * class wpforge_walker
 * Custom output to enable the ZURB Navigation style.
 * Courtesy of Kriesi.at. http://www.kriesi.at/archives/improve-your-wordpress-navigation-menu-output
 * From required+ Foundation http://themes.required.ch
 *
 * @since WP-Forge 5.5.0.1
 */
class wpforge_walker extends Walker_Nav_Menu {

	/**
	 * Specify the item type to allow different walkers
	 * @var array
	 */
	var $nav_bar = '';

	function __construct( $nav_args = '' ) {

		$defaults = array(
			'item_type' => 'li',
			'in_top_bar' => false,
			'menu_type' => 'main-menu' //enable menu differenciation, used in preg_replace classes[] below
		);
		$this->nav_bar = apply_filters( 'req_nav_args', wp_parse_args( $nav_args, $defaults ) );
	}

	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

		$id_field = $this->db_fields['id'];
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		}
		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

	// Additionnal Class cleanup, as found in Roots_Nav_Walker - Roots Theme lib/nav.php
	// see http://roots.io/ and https://github.com/roots/roots
	$slug = sanitize_title($item->title);
	$classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', '', $classes);
	$classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);

	$menu_type = $this->nav_bar['menu_type'];
	$classes[] = 'menu-item menu-item-' . $menu_type . ' menu-item-' . $slug;

	$classes = array_unique($classes);

		// Check for flyout
		$flyout_toggle = '';
		if ( $args->has_children && $this->nav_bar['item_type'] == 'li' ) {

			if ( $depth == 0 && $this->nav_bar['in_top_bar'] == false ) {

				$classes[] = 'has-flyout';
				$flyout_toggle = '<a href="#" class="flyout-toggle"><span></span></a>';

			} else if ( $this->nav_bar['in_top_bar'] == true ) {

				$classes[] = 'has-dropdown';
				$flyout_toggle = '';
			}

		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		if ( $depth > 0 ) {
			$output .= $indent . '<li ' . $value . $class_names .'>';
		} else {
			$output .= $indent . ( $this->nav_bar['in_top_bar'] == true ? '<li class="divider"></li>' : '' ) . '<' . $this->nav_bar['item_type'] . ' ' . $value . $class_names .'>';
		}

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output  = $args->before;
		$item_output .= '<a '. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $flyout_toggle; // Add possible flyout toggle
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {

		if ( $depth > 0 ) {
			$output .= "</li>\n";
		} else {
			$output .= "</" . $this->nav_bar['item_type'] . ">\n";
		}
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {

		if ( $depth == 0 && $this->nav_bar['item_type'] == 'li' ) {
			$indent = str_repeat("\t", 1);
			$output .= $this->nav_bar['in_top_bar'] == true ? "\n$indent<ul class=\"dropdown\">\n" : "\n$indent<ul class=\"flyout\">\n";
		} else {
			$indent = str_repeat("\t", $depth);
			$output .= $this->nav_bar['in_top_bar'] == true ? "\n$indent<ul class=\"dropdown\">\n" : "\n$indent<ul class=\"level-$depth\">\n";
		}
	}
}

/**
 * Registers our main, front page and footer widget areas.
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_widgets_init' ) ) {
	function wpforge_widgets_init() {
		register_sidebar( array(
			'name' => __( 'Main Sidebar', 'wpforge' ),
			'id' => 'sidebar-1',
			'description' => __( 'Displays widgets in the blog area as well as pages.', 'wpforge' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h6 class="widget-title">',
			'after_title' => '</h6>',
		) );
		register_sidebar( array(
			'name' => __( 'First Front Page Widget Area', 'wpforge' ),
			'id' => 'sidebar-2',
			'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'wpforge' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h6 class="widget-title">',
			'after_title' => '</h6>',
		) );
		register_sidebar( array(
			'name' => __( 'Second Front Page Widget Area', 'wpforge' ),
			'id' => 'sidebar-3',
			'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'wpforge' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h6 class="widget-title">',
			'after_title' => '</h6>',
		) );
		register_sidebar( array(
			'name' => __( 'First Footer Widget Area', 'wpforge' ),
			'id' => 'sidebar-4',
			'description' => __( 'An optional widget area for your site footer', 'wpforge' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h6 class="widget-title">',
			'after_title' => '</h6>',
		) );
		register_sidebar( array(
			'name' => __( 'Second Footer Widget Area', 'wpforge' ),
			'id' => 'sidebar-5',
			'description' => __( 'An optional widget area for your site footer', 'wpforge' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h6 class="widget-title">',
			'after_title' => '</h6>',
		) );
		register_sidebar( array(
			'name' => __( 'Third Footer Widget Area', 'wpforge' ),
			'id' => 'sidebar-6',
			'description' => __( 'An optional widget area for your site footer', 'wpforge' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h6 class="widget-title">',
			'after_title' => '</h6>',
		) );
	}
	add_action( 'widgets_init', 'wpforge_widgets_init' );
}

/**
 * Front Page Template Sidebars. This will count the number of front page sidebars to enable dynamic classes for the home page
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_front_sidebar_class' ) ) {
	function wpforge_front_sidebar_class() {
		$count = 0;

		if ( is_active_sidebar( 'sidebar-2' ) )
			$count++;

		if ( is_active_sidebar( 'sidebar-3' ) )
			$count++;

		$class = '';

		switch ( $count ) {
			case '1':
				$class = 'medium-12 large-12';
				break;
			case '2':
				$class = 'medium-12 large-6';
				break;
		}

		if ( $class )
			echo '' . $class . '';
	}
}

/**
 * Footer Sidebars. This will count the number of footer sidebars to enable dynamic classes in the footer area
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_footer_sidebar_class' ) ) {
	function wpforge_footer_sidebar_class() {
		$count = 0;

		if ( is_active_sidebar( 'sidebar-4' ) )
			$count++;

		if ( is_active_sidebar( 'sidebar-5' ) )
			$count++;

		if ( is_active_sidebar( 'sidebar-6' ) )
			$count++;

		$class = '';

		switch ( $count ) {
			case '1':
				$class = 'medium-12 large-12';
				break;
			case '2':
				$class = 'medium-12 large-6';
				break;
			case '3':
				$class = 'medium-12 large-4';
				break;
		}

		if ( $class )
			echo '' . $class . '';
	}
}

/**
 * Numeric Page Navi (built into the theme by default)
 *
 * @see http://320press.com/wp-foundation/
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'page_navi' ) ) {
	function page_navi($before = '', $after = '') {
		global $wpdb, $wp_query;
		$request = $wp_query->request;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(get_query_var('paged'));
		$numposts = $wp_query->found_posts;
		$max_page = $wp_query->max_num_pages;
		if ( $numposts <= $posts_per_page ) { return; }
		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}
		$pages_to_show = 7;
		$pages_to_show_minus_1 = $pages_to_show-1;
		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
		$start_page = $paged - $half_page_start;
		if($start_page <= 0) {
			$start_page = 1;
		}
		$end_page = $paged + $half_page_end;
		if(($end_page - $start_page) != $pages_to_show_minus_1) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if($start_page <= 0) {
			$start_page = 1;
		}

		echo $before.'<ul class="pagination clearfix">'."";

		echo '<li class="">';
		previous_posts_link('&laquo; Previous');
		echo '</li>';
		for($i = $start_page; $i  <= $end_page; $i++) {
			if($i == $paged) {
				echo '<li class="current"><a href="#">'.$i.'</a></li>';
			} else {
				echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
			}
		}
		echo '<li class="">';
		next_posts_link('Next &raquo;');
		echo '</li>';
		echo '</ul>'.$after."";
	}
}

/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_content_nav' ) ) :

	function wpforge_content_nav( $html_id ) {
		global $wp_query;

		$html_id = esc_attr( $html_id );

		if ( $wp_query->max_num_pages > 1 ) : ?>
			<?php if(function_exists('page_navi') ) : ?>
				<?php page_navi(); ?>
			<?php else: ?>
			<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
				<h3 class="assistive-text"><?php _e( 'Post navigation', 'wpforge' ); ?></h3>
				<div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'wpforge' ) ); ?></div>
				<div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'wpforge' ) ); ?></div>
			</nav><!-- #<?php echo $html_id; ?> .navigation -->
	        <?php endif; ?>
		<?php endif;
}
endif;

/**
 * Template for comments and pingbacks.
 * To override this walker in a child theme without modifying the comments template
 * simply create your own wpforge_comment(), and that function will be used instead.
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_comment' ) ) :

	function wpforge_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
			// Display trackbacks differently than normal comments.
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php _e( 'Pingback:', 'wpforge' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'wpforge' ), '<span class="edit-link"><i class="fa fa-pencil"></i> ', '</span>' ); ?></p>
		<?php
				break;
			default :
			// Proceed with normal comments.
			global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<header class="comment-meta comment-author vcard">
					<?php
						echo get_avatar( $comment, 72 );
						printf( '<cite class="fn">%1$s %2$s</cite>',
							get_comment_author_link(),
							// If current post author is also comment author, make it known visually.
							( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post Author', 'wpforge' ) . '</span>' : ''
						);
						printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( __( '%1$s at %2$s', 'wpforge' ), get_comment_date(), get_comment_time() )
						);
					?>
				</header><!-- .comment-meta -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'wpforge' ); ?></p>
				<?php endif; ?>

				<section class="comment-content comment">
					<?php comment_text(); ?>
				</section><!-- .comment-content -->

				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '<span class="genericon genericon-reply"></span> Reply', 'wpforge' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
				<?php edit_comment_link( __( 'Edit', 'wpforge' ), '<p class="edit-link"><span class="genericon genericon-edit"></span>', '</p>' ); ?>
			</article><!-- #comment-## -->
		<?php
			break;
		endswitch; // end comment_type check
}
endif;

/**
 * Prints HTML with meta information for current post in home and single post view: categories
 * Create your own wpforge_entry_meta_categories() to override in a child theme.
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_entry_meta_categories' ) ) :

function wpforge_entry_meta_categories() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'wpforge' ) );
	if ( $categories_list ) {
		echo '<div class="entry-meta-categories"><span class="categories-links">' . $categories_list . '</span></div>';
	}
}
endif;

/**
 * Print HTML with meta information for the current post-date/time and author.
 *
 * @since WP-Forge 5.5.0.1
 *
 * @return void
 */
if ( ! function_exists( 'wpforge_entry_meta_header' ) ) :

function wpforge_entry_meta_header() {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		echo '<span class="genericon genericon-pinned"></span> <span class="sticky-post">' . __( 'Sticky', 'wpforge' ) . '</span>';
	}

	// Set up and print post meta information.
	printf( '<span class="entry-date updated"><span class="genericon genericon-time"></span><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a></span> <span class="byline"><span class="genericon genericon-user"></span><span class="author vcard"><a class="url fn n" href="%4$s" rel="author">%5$s</a></span></span>',
		esc_url( get_permalink() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		get_the_author()
	);
}
endif;

/**
 * Prints HTML with meta information in the footer for current post in home and single post view: tags.
 * Create your own wpforge_entry_meta_footer() to override in a child theme.
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_entry_meta_footer' ) ) :

	function wpforge_entry_meta_footer() {
		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', __( ', ', 'wpforge' ) );
		if ( $tag_list ) {
			echo '<div class="entry-meta-tags"><span class="genericon genericon-tag"></span> <span class="tags-links">' . $tag_list . '</span></div>';
		}
}
endif;

/**
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 * @param array Existing class values.
 * @return array Filtered class values.
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_body_class' ) ) {
	function wpforge_body_class( $classes ) {
		$background_color = get_background_color();

		if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) )
			$classes[] = 'full-width';

		if ( is_page_template( 'page-templates/front-page.php' ) ) {
			$classes[] = 'template-front-page';
			if ( has_post_thumbnail() )
				$classes[] = 'has-post-thumbnail';
			if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
				$classes[] = 'two-sidebars';
		}

		if ( empty( $background_color ) )
			$classes[] = 'custom-background-empty';
		elseif ( in_array( $background_color, array( 'e6e6e6', 'e6e6e6' ) ) )
			$classes[] = 'custom-background-white';

		// Enable custom font class only if the font CSS is queued to load.
		if ( wp_style_is( 'wpforge-fonts', 'queue' ) )
			$classes[] = 'custom-font-enabled';

		if ( ! is_multi_author() )
			$classes[] = 'single-author';

		return $classes;
	}
	add_filter( 'body_class', 'wpforge_body_class' );
}

/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_content_width' ) ) {
	function wpforge_content_width() {
		if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
			global $content_width;
			$content_width = 898;
		}
	}
	add_action( 'template_redirect', 'wpforge_content_width' );
}

/**
 * Custom Excerpt Length
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'custom_excerpt_length' ) ) {
	function custom_excerpt_length( $length ) {
		return 15;
	}
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
}

/**
 * Custom read more
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'new_excerpt_more' ) ) {
	function new_excerpt_more( $more ) {
		return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">...</a>';
	}
	add_filter( 'excerpt_more', 'new_excerpt_more' );
}

/**
 * Allows shortcodes to be used in text widgets
 *
 * @since WP-Forge 5.5.0.1
 */
add_filter('widget_text', 'do_shortcode');

/**
 * Remove the <p> from around imgs
 *
 * @see http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'filter_ptags_on_images' ) ) {
	function filter_ptags_on_images($content){
	   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	}
	add_filter('the_content', 'filter_ptags_on_images');
}

/**
 * Remove wp version param from any enqueued scripts
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_remove_script_version' ) ) {
	function wpforge_remove_script_version( $src ){

        if(strpos($src,'style.css')!==false || strpos($src,'functions.js')!==false || strpos($src,'functions.min.js')!==false) {

			$parse = parse_url($src);
			$parse_parts = explode('?', $src);

			if(isset($parse['query'])) {
				parse_str($parse['query'],$parse_str);

				unset($parse_str['ver']);

				$parse_parts[1] = http_build_query($parse_str);

				return implode('?',$parse_parts);
			}

            // $parts = explode( '?ver', $src );
            // return $parts[0];
		}

		return $src;
	}
	add_filter( 'script_loader_src', 'wpforge_remove_script_version', 15, 1 );
	add_filter( 'style_loader_src', 'wpforge_remove_script_version', 15, 1 );
}

/**
 * Remove .sticky from the post_class array (Thanks to required+ foundation)
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_filter_post_class' ) ) {
	function wpforge_filter_post_class( $classes ) {
	    if ( ( $key = array_search( 'sticky', $classes ) ) !== false ) {
	        unset( $classes[$key] );
	        $classes[] = 'sticky-post';
	    }
	    return $classes;
	}
	add_filter( 'post_class', 'wpforge_filter_post_class', 20 );
}

/**
 * Removes recent comments styling injected into header by WordPress - Styles moved to style sheet
 * @see https://gist.github.com/Narga/2887406
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_remove_recent_comments_style' ) ) {
	function wpforge_remove_recent_comments_style() {
		global $wp_widget_factory;
		if ( property_exists($wp_widget_factory,'widgets') && isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments']) ) {
			remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
		}
	}
	add_action( 'widgets_init', 'wpforge_remove_recent_comments_style' );
}

/**
 * Add favicon to header
 *
 * @since WP-Forge 5.5.0.1
 */
if ( ! function_exists( 'wpforge_favicon' ) ) {
	function wpforge_favicon() {
	echo '<link rel="shortcut icon" type="image/x-icon" href="' . site_url() . '/favicon.ico" />'."\n";
	}
	add_action('wp_head', 'wpforge_favicon', 0);
}

/**
 * Link all post thumbnials to the post permalink
 * @see http://codex.wordpress.org/Function_Reference/the_post_thumbnail
 *
 * @since WP-Forge 5.5.0.1

if ( ! function_exists( 'my_post_image_html' ) ) {
	function my_post_image_html( $html, $post_id, $post_image_id ) {
	  $html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . $html . '</a>';
	  return $html;
	}
	add_filter( 'post_thumbnail_html', 'my_post_image_html', 10, 3 );
}
 */
/**
 * Add HatomEntry to WordPress posts and pages for Google Structured Data
 *
 * @author CyrRei88
 * @see http://wordpress.org/support/topic/google-structured-data-missing-required-field-authorship-thumbnails-gone?replies=38
 *
 * @since WP-Forge 5.5.0.1

if ( ! function_exists( 'add_mod_hatom_data' ) ) {
	function add_mod_hatom_data($content) {
	    $t = get_the_modified_time('F jS, Y');
	    $author = get_the_author();
	    $title = get_the_title();
	    if ( is_single() || is_page() ) { // changed to include pages as well as posts
	        $content .= '<div class="hatom-extra" style="text-indent:-10000px; margin:0; font-size:0.5rem"><span class="entry-title">'.$title.'</span> was last modified: <span class="updated"> '.$t.'</span> by <span class="author vcard"><span class="fn">'.$author.'</span></span></div>';
	    }
	    return $content;
	    }
	add_filter('the_content', 'add_mod_hatom_data');
}
*/


// Custom post types
register_post_type( 'homepage',
  array(
    'labels' => array(
      'name'          => __( 'Homepage' ),
      'singular_name' => __( 'Přidat stránku' ),
      'add_new'       => __( 'Přidat stránku' ),
      'add_new_item'  => __( 'Přidat stránku' ),
      'edit'          => __( 'Upravit' ),
      'edit_item'     => __( 'Upravit stránku' ),
      'new_item'      => __( 'Upravit stránku' ),
      'view'          => __( 'Zobrazit' ),
      'view_item'     => __( 'Zobrazit stránku' ),
      'search_items'  => __( 'Prohledávat stránky' ),
      'not_found'     => __( 'Žádná stránka na homepage nebyla nalezena.' ),
      'not_found_in_trash' => __( 'Žádný banner nebyl nalezen v koši.' ),
    ),
    'public' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'supports' => array( 'title', 'editor', 'thumbnail'),
  )
);

add_filter('manage_homepage_posts_columns', 'posts_columns', 5);
add_action('manage_homepage_posts_custom_column', 'posts_custom_columns', 5, 2);
add_image_size('hp-header-thumb', 200, 133, true);

function posts_columns($defaults){
    $defaults['riv_post_thumbs'] = __('Náhled');
    return $defaults;
}
function posts_custom_columns($column_name, $id){
    if($column_name === 'riv_post_thumbs'){
      echo the_post_thumbnail( 'hp-header-thumb' );
    }
}


// Register People CPT
register_post_type( 'cpt-people',
	array(
	    'labels' => array(
		    'name' => __( 'Lidi' ),
		    'singular_name' => __( 'Lidi' ),
		    'add_new' => __( 'Přidat' ),
		    'add_new_item' => __( 'Přidat' ),
		    'edit' => __( 'Upravit' ),
		    'edit_item' => __( 'Upravit' ),
		    'new_item' => __( 'Upravit' ),
		    'view' => __( 'Zobrazit' ),
		    'view_item' => __( 'Zobrazit' ),
		    'search_items' => __( 'Hledat' ),
		    'not_found' => __( 'Nenalezeno' ),
		    'not_found_in_trash' => __( 'Nenalezeno' ),
	    ),
	    'menu_icon' => 'dashicons-universal-access',
	    'public' => true,
		'menu_position' => 1.2,
	    'capability_type' => 'post',
	    'hierarchical' => true,
		'has_archive'	=> true,
		'show_in_nav_menus' => true,
		'publicly_queryable'=> false,
	    'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'rewrite'	=> array('slug' => __('projekty'))
	)
);

// Add taxonomy for CPT SERIES - Category
$labels = array(
	'name'              => _x( 'Obor', 'taxonomy general name' ),
	'singular_name'     => _x( 'Obor', 'taxonomy singular name' ),
	'search_items'      => __( 'Hledat kategorii' ),
	'all_items'         => __( 'Všechny kategorie' ),
	'parent_item'       => __( 'Nadřazená kategorie' ),
	'parent_item_colon' => __( 'Nadřazená kategorie' ),
	'edit_item'         => __( 'Upravit kategorii' ),
	'update_item'       => __( 'Aktualizovat kategorii' ),
	'add_new_item'      => __( 'Přidat novou kategorii' ),
	'new_item_name'     => __( 'Nová kategorie' ),
	'menu_name'         => __( 'Kategorie' ),
);

$args = array(
	'hierarchical'      => true,
	'labels'            => $labels,
	'show_ui'           => true,
	'show_admin_column' => true,
	'has_archive'		=> true,
	'query_var'         => true,
	'publicly_queryable'=> false,
	'rewrite'	=> array('slug' => __('kategorie'))

);
register_taxonomy( 'tax-people-', array( 'cpt-people' ), $args );


register_post_type( 'history',
  array(
    'labels' => array(
      'name'          => __( 'Historie' ),
      'singular_name' => __( 'Přidat položku' ),
      'add_new'       => __( 'Přidat položku' ),
      'add_new_item'  => __( 'Přidat položku' ),
      'edit'          => __( 'Upravit' ),
      'edit_item'     => __( 'Upravit položku' ),
      'new_item'      => __( 'Upravit položku' ),
      'view'          => __( 'Zobrazit' ),
      'view_item'     => __( 'Zobrazit položku' ),
      'search_items'  => __( 'Prohledávat historii' ),
      'not_found'     => __( 'Žádná položka nebyla nalezena.' ),
      'not_found_in_trash' => __( 'Žádná položka nebyla nalezena v koši.' ),
    ),
    'public' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'supports' => array( 'title', 'editor'),
  )
);


register_post_type( 'reference',
  array(
    'labels' => array(
      'name'          => __( 'Reference' ),
      'singular_name' => __( 'Přidat položku' ),
      'add_new'       => __( 'Přidat položku' ),
      'add_new_item'  => __( 'Přidat položku' ),
      'edit'          => __( 'Upravit' ),
      'edit_item'     => __( 'Upravit položku' ),
      'new_item'      => __( 'Upravit položku' ),
      'view'          => __( 'Zobrazit' ),
      'view_item'     => __( 'Zobrazit položku' ),
      'search_items'  => __( 'Prohledávat historii' ),
      'not_found'     => __( 'Žádná položka nebyla nalezena.' ),
      'not_found_in_trash' => __( 'Žádná položka nebyla nalezena v koši.' ),
    ),
    'public' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'supports' => array( 'title', 'editor', 'thumbnail'),
  )
);
add_image_size('reference', 150, 150, false);


register_post_type( 'sluzby',
  array(
    'labels' => array(
      'name'          => __( 'Služby' ),
      'singular_name' => __( 'Přidat položku' ),
      'add_new'       => __( 'Přidat položku' ),
      'add_new_item'  => __( 'Přidat položku' ),
      'edit'          => __( 'Upravit' ),
      'edit_item'     => __( 'Upravit položku' ),
      'new_item'      => __( 'Upravit položku' ),
      'view'          => __( 'Zobrazit' ),
      'view_item'     => __( 'Zobrazit položku' ),
      'search_items'  => __( 'Prohledávat historii' ),
      'not_found'     => __( 'Žádná položka nebyla nalezena.' ),
      'not_found_in_trash' => __( 'Žádná položka nebyla nalezena v koši.' ),
    ),
    'public' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'supports' => array( 'title', 'editor', 'thumbnail'),
  )
);


register_post_type( 'sluzby-main',
  array(
    'labels' => array(
      'name'          => __( 'Služby' ),
      'singular_name' => __( 'Přidat položku' ),
      'add_new'       => __( 'Přidat položku' ),
      'add_new_item'  => __( 'Přidat položku' ),
      'edit'          => __( 'Upravit' ),
      'edit_item'     => __( 'Upravit položku' ),
      'new_item'      => __( 'Upravit položku' ),
      'view'          => __( 'Zobrazit' ),
      'view_item'     => __( 'Zobrazit položku' ),
      'search_items'  => __( 'Prohledávat historii' ),
      'not_found'     => __( 'Žádná položka nebyla nalezena.' ),
      'not_found_in_trash' => __( 'Žádná položka nebyla nalezena v koši.' ),
    ),
    'public' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'supports' => array( 'title', 'editor', 'thumbnail'),
  )
);


register_post_type( 'clanky',
  array(
    'labels' => array(
      'name'          => __( 'Napsali o nás' ),
      'singular_name' => __( 'Přidat položku' ),
      'add_new'       => __( 'Přidat položku' ),
      'add_new_item'  => __( 'Přidat položku' ),
      'edit'          => __( 'Upravit' ),
      'edit_item'     => __( 'Upravit položku' ),
      'new_item'      => __( 'Upravit položku' ),
      'view'          => __( 'Zobrazit' ),
      'view_item'     => __( 'Zobrazit položku' ),
      'search_items'  => __( 'Prohledávat historii' ),
      'not_found'     => __( 'Žádná položka nebyla nalezena.' ),
      'not_found_in_trash' => __( 'Žádná položka nebyla nalezena v koši.' ),
    ),
    'public' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'supports' => array( 'title'),
  )
);


function register_job() {
    register_post_type( 'kariera',
      array(
        'labels' => array(
          'name'          => __( 'Pracovní pozice' ),
          'singular_name' => __( 'Přidat pozici' ),
          'add_new'       => __( 'Přidat pozici' ),
          'add_new_item'  => __( 'Přidat pozici' ),
          'edit'          => __( 'Upravit' ),
          'edit_item'     => __( 'Upravit pozici' ),
          'new_item'      => __( 'Upravit pozici' ),
          'view'          => __( 'Zobrazit' ),
          'view_item'     => __( 'Zobrazit pozici' ),
          'search_items'  => __( 'Prohledávat historii' ),
          'not_found'     => __( 'Žádná pracovní pozice nebyla nalezena.' ),
          'not_found_in_trash' => __( 'Žádná pracovní pozice nebyla nalezena v koši.' ),
        ),
        'menu_icon' => 'dashicons-networking',
        'public' => true,
        'show_ui' => true,
        'publicly_queryable'=> true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'has_archive'	=> true,
        'show_in_nav_menus' => true,
        'supports' => array( 'title','excerpt','editor')
      )
    );
}
add_action('init', 'register_job');


// FAQ CPT
register_post_type( 'faq',
  array(
    'labels' => array(
      'name'          => __( 'FAQ' ),
      'singular_name' => __( 'Přidat položku' ),
      'add_new'       => __( 'Přidat položku' ),
      'add_new_item'  => __( 'Přidat položku' ),
      'edit'          => __( 'Upravit' ),
      'edit_item'     => __( 'Upravit položku' ),
      'new_item'      => __( 'Upravit položku' ),
      'view'          => __( 'Zobrazit' ),
      'view_item'     => __( 'Zobrazit položku' ),
      'search_items'  => __( 'Prohledávat historii' ),
      'not_found'     => __( 'Žádná položka nebyla nalezena.' ),
      'not_found_in_trash' => __( 'Žádná položka nebyla nalezena v koši.' ),
    ),
		'menu_icon' => 'dashicons-editor-help',
    'public' => true,
    'capability_type' => 'post',
		'hierarchical' => false,
		'has_archive' => true,
		'exclude_from_search' => true,
		'publicly_queryable' => true,
    'supports' => array( 'title', 'editor' ),
  )
);


// Custom admin stylesheet
add_action('admin_head', 'cms_custom_admin_css');
function cms_custom_admin_css() {
    echo '<link rel="stylesheet" href="' . get_bloginfo('stylesheet_directory') . '/css/admin.css" type="text/css" />';
};


function partners_slider() {
	$orbit = '<div class="large-12 columns">
              <div class="orbit-reference slider-wrapper">
                <ul data-orbit data-options="animation:slide;slide_number:false;timer:false;bullets:false">';

  $reflist = get_posts(
    array(
      'showposts' => -1,
      'post_type' => 'mau_partners',
      'suppress_filters' => false,
      'orderby' => 'menu_order',
      'order' => 'asc'
    )
  );
  $i = 0;

  foreach ($reflist as $ref) {  $i++;
    $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id($ref->ID), 'reference' );
    $partner_url = esc_url( get_post_meta( $ref->ID, '_mau_partner_url', true ) );
	  $partner_url = empty($partner_url) ? '#' : $partner_url ;

    $orbit .= ((($i-1)%5) == 0) ? '<li>' : '';
    $orbit .= '<div class="large-3 medium-3 small-2 left columns">
                 <div class="reference-box">
                   <a href="'.$partner_url.'" title="'.$ref->post_title.'" target="_blank"><img src="'.$image_attributes[0].'" alt="" width="'.$image_attributes[1].'" height="'.$image_attributes[2].'" /></a>
                 </div></div>';
     $orbit .= ((($i)%5)==0 || $i == count($reflist)) ? '</li>' : '';
  }

  $orbit .= '</ul></div>
         </div>';

	return $orbit;
}
add_shortcode( 'partners', 'partners_slider' );


function partners_slider_services() {
	$services_page = icl_object_id(98, 'page', false, 'cs'); ?>

	<div class="">
		<div class="hsContainer">
			<div class="hsContent">
				<h2 class="hsHeading skrollable skrollable-before" style="opacity: 1;"><?= __('Partneři','nicknack'); ?></h2>
				<div class="row skrollable skrollable-before" style="opacity: 1;">
					<?php echo do_shortcode('[partners]'); ?>
					<div class="large-12 columns">
						<div class="orbit-reference slider-wrapper">
						<div class="orbit-container"><a href="#" class="orbit-prev"><span></span></a><a href="#" class="orbit-next"><span></span></a></div>
						</div>
					</div>
					<div class="clear columns"><a href="<?= get_permalink($services_page); ?>" class="button"><?= __('Zobrazit více partnerů','nicknack'); ?></a></div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
add_shortcode( 'partners-services', 'partners_slider_services' );

/**
 * Novinky - last n
 *
 * @use: [novinky]
 *
 * @param $atts     array   Parameters
 * @return String
 */
function nicknack_news_shortcode( $atts ) {

	$a = shortcode_atts( array(
		'pocet' => 2,       // Default value
	), $atts );

	ob_start();
	$args = array(
		'post_type'     => 'post',
		'post_status'   => 'publish',
		'posts_per_page'=> $a['pocet']
	);
	$news = new WP_Query($args);

	if ($news->have_posts()) : ?>
		<div class="last-news row">
		<?php while ($news->have_posts()) : $news->the_post(); ?>
			<div class="small-12 medium-6 columns">
				<div class="columns" style="width:auto;">
					<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('thumbnail') ?></a>
				</div>
				<div class="small-12 medium-8 columns text-left">
					<h3 class="title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
					<time><?php the_date() ?></time>
					<?php the_excerpt() ?> <a href="<?php the_permalink() ?>"><?php _e('Read more') ?></a>
				</div>
			</div>
		<?php endwhile; ?>
		</div>
	<?php endif;

	wp_reset_postdata();
	return ob_get_clean();
}
add_shortcode( 'novinky', 'nicknack_news_shortcode' );

/**
 * Video section
 *
 * @use: [video]
 *
 * @param $atts     array   Parameters
 * @return String
 */
function nicknack_video_shortcode( $atts ) {

	$uploads = wp_upload_dir();
	$uploads_dir = $uploads['baseurl'];

	// if (ICL_LANGUAGE_CODE == 'pl') {
	// 	$poster_url = get_template_directory_uri() . '/video/video_hp_caption_pl.jpg';
	// 	$video_urls = array(
	// 		$uploads_dir . '/video/Nicknack_HP_PL_2019.mp4',
	// 		$uploads_dir . '/video/Nicknack_HP_PL_2019.webm'
	// 	);
	// } else {
		$poster_url = get_template_directory_uri() . '/video/video_caption_2020.png';
		$video_urls = array(
			$uploads_dir . '/video/NICKNACK-Evolution.mp4',
			$uploads_dir . '/video/NICKNACK-Evolution.webm'
		);
	// }

	ob_start(); ?>
	<section class="cont-vid">
		<div style="position:relative;">
			<video id="promo" preload="auto" width="auto" poster="<?php echo $poster_url; ?>">
				<source src="<?php echo $video_urls[0]; ?>" type="video/mp4; codecs=&quot;avc1.42E01E, mp4a.40.2&quot;">
				<source src="<?php echo $video_urls[1]; ?>" type="video/webm; codecs=&quot;vp8, vorbis&quot;">
				<?php _e('Video not supported.', 'nicknack'); ?>
			</video>
			<div id="buttonbar" class="buttonbar-new">
				<button id="play" class="play-new" onclick="vidplay();">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 162 162"><defs><style>.cls-1{fill:#fff;}</style></defs><path class="cls-1" d="M142.82,234.25a81,81,0,1,1,81-81A81,81,0,0,1,142.82,234.25Zm0-141.75a60.75,60.75,0,1,0,60.74,60.75A60.75,60.75,0,0,0,142.82,92.5Zm-20.26,30.37,50.63,30.38-50.63,30.37Z" transform="translate(-61.82 -72.25)"/></svg>
				</button>
			</div>
		</div>
	</section>
	<script>
		(function($) {

			$('#promo').click(function() {
				if (this.paused) {

				} else {
					if ( $(window).width() > 1025 ) {
						$('html, body').delay(500).animate({
							scrollTop: $("#promo").offset().top - 50
						}, 500);
					}
				}
			});

			// ------ Video controls ----

			$('.cont-vid').hover(
				function () {
					jQuery('video#promo').attr("controls", "controls");
				},
				function () {
					jQuery('video#promo').removeAttr("controls");
				}
			);

			$(window).on('load resize',function(){
				$('.cont-vid').closest('.row').css({'max-width':'initial!important'});
				$('.cont-vid').closest('.hsContent').css({'padding-left':'0','padding-right':'0','padding-bottom':'0'});
				var hh = $('#header').outerHeight(),
					vh = $(window).height();
				if(vh<600+hh) {
					$('#promo').css({'max-height':'calc(100vh - '+hh+'px)','object-fit':'cover'});
				} else {
					$('#promo').css({'max-height':'600px','object-fit':'cover'});
				}
				$('#promo').on('ended',function(){
					$('#promo').load();
					$('#promo').removeClass('bg_vid');
					$('#play').show();
					$('.cont-vid').removeClass('widened');
				});
				$('#promo').on('playing', function() {
					$('video#promo').addClass('bg_vid');
					$('#play').hide();
					$('.cont-vid').addClass('widened');

					if ( $(window).width() > 1025 ) {
						$('html, body').delay(500).animate({
							scrollTop: $("#promo").offset().top - 50
						}, 500);
					}
				});
				$('#promo').on('pause', function() {
					$('#play').show();
					jQuery('#buttonbar').removeClass('hidden');
				});
			});
		})(jQuery);
		// Video fns definitions
		function vidplay() {
			var video = document.getElementById("promo");
				hh = document.getElementById("header").offsetHeight,
				button = document.getElementById("play");
			video.volume = 0.35;
			video.style.objectFit = 'contain';
			document.getElementById('promo').style.maxHeight = 'calc(100vh - '+hh+'px)';

			video.play();
			jQuery('#buttonbar').addClass('hidden');
		}

		function restart() {
			var video = document.getElementById("promo");
			video.currentTime = 0;
		}

		function skip(value) {
			var video = document.getElementById("promo");
			video.currentTime += value;
		}
	</script>
	<?php return ob_get_clean();
}
// We call this function directly, because in content it wraps script with <p></p>
// add_shortcode( 'video', 'nicknack_video_shortcode' );

/**
 * Barvy
 *
 * @use: [barvy text=""]
 *
 * @param $atts     array   Parameters
 * @return String
 */
function nicknack_colors_shortcode( $atts ) {

	$product_page_id = 2198;

	ob_start(); ?>

	<ul class="color-var-list">

		<?php
		$i = 0;
		while (have_rows("bk_variations",$product_page_id)) : the_row(); ?>
			<li class="c-<?php echo($i); ?> color has-tip tip-top" data-tooltip tabindex="1" title="<?= get_sub_field("title_color",$product_page_id) . ' (' . get_sub_field("hex_color",$product_page_id).')'; ?>" data-id="<?php echo($i); ?>">
				<span class="color-inner" style="background-color:<?php the_sub_field("hex_color",$product_page_id); ?>;">
				</span>
			</li>
		<?php ++$i;
		endwhile; ?>

	</ul>
	<?php if ( !empty($atts['text']) ) : ?>
		<p class="colors-description"><?= $atts['text']; ?></p>
	<?php endif; ?>

	<?php return ob_get_clean();
}
add_shortcode( 'barvy', 'nicknack_colors_shortcode' );

/**
 * Kelimky
 *
 * @use: [kelimky]
 *
 * @return String
 */
function nicknack_cups_shortcode() {

	ob_start();

	?><div class="hsContent all-cups">
		<div class="wrapper">
			<img src="<?= get_stylesheet_directory_uri() . '/images/kelimky-objemy.jpg'; ?>" alt="<?= __('NICKNACK kelímky - objemy','nicknack'); ?>" title="<?= __('NICKNACK kelímky - objemy','nicknack'); ?>" class="all-cups-img">
			<?php if ( ICL_LANGUAGE_CODE == 'en' ) : ?>
				<img src="<?= get_stylesheet_directory_uri() . '/images/bublina-potisk_en.png'; ?>" class="bubble-1">
				<img src="<?= get_stylesheet_directory_uri() . '/images/bublina-novinka_en.png'; ?>" class="bubble-2">
				<img src="<?= get_stylesheet_directory_uri() . '/images/bublina-pocet_en.png'; ?>" class="bubble-3">
			<?php  elseif ( ICL_LANGUAGE_CODE == 'pl' ) : ?>
				<img src="<?= get_stylesheet_directory_uri() . '/images/bublina-potisk_pl.png'; ?>" class="bubble-1">
				<img src="<?= get_stylesheet_directory_uri() . '/images/bublina-novinka_pl.png'; ?>" class="bubble-2">
				<img src="<?= get_stylesheet_directory_uri() . '/images/bublina-pocet_pl.png'; ?>" class="bubble-3">
			<?php  elseif ( ICL_LANGUAGE_CODE == 'nl' ) : ?>
				<img src="<?= get_stylesheet_directory_uri() . '/images/bublina-potisk_nl.png'; ?>" class="bubble-1">
				<img src="<?= get_stylesheet_directory_uri() . '/images/bublina-novinka_nl.png'; ?>" class="bubble-2">
				<img src="<?= get_stylesheet_directory_uri() . '/images/bublina-pocet_nl.png'; ?>" class="bubble-3">
			<?php  elseif ( ICL_LANGUAGE_CODE == 'de' ) : ?>
				<img src="<?= get_stylesheet_directory_uri() . '/images/bublina-potisk_de.png'; ?>" class="bubble-1">
				<img src="<?= get_stylesheet_directory_uri() . '/images/bublina-novinka_de.png'; ?>" class="bubble-2">
				<img src="<?= get_stylesheet_directory_uri() . '/images/bublina-pocet_de.png'; ?>" class="bubble-3">
			<?php  else : ?>
				<img src="<?= get_stylesheet_directory_uri() . '/images/bublina-potisk.png'; ?>" class="bubble-1">
				<img src="<?= get_stylesheet_directory_uri() . '/images/bublina-novinka.png'; ?>" class="bubble-2">
				<img src="<?= get_stylesheet_directory_uri() . '/images/bublina-pocet.png'; ?>" class="bubble-3">
			<?php endif; ?>

			<span class="cup-volume">0,5 l</span>
			<span class="cup-volume">0,4 l</span>
			<span class="cup-volume">0,1 l &nbsp; <strong>0,2 l</strong> &nbsp; 0,3 l &nbsp; 0,4 l</span>
			<span class="cup-volume">0,25 l</span>
			<span class="cup-volume">0,3 l</span>
		</div>
	</div><?php

	return ob_get_clean();
}
add_shortcode( 'kelimky', 'nicknack_cups_shortcode' );


function newsletter_signup() {
  /*
	$newsletter = '<form action="//nicknack.us10.list-manage.com/subscribe/post?u=4327021590afcb861d13b03f3&amp;id=400a56eb06" method="post" name="mc-embedded-subscribe-form" class="mc-embedded-subscribe-form validate" target="_blank" novalidate>
                    <div id="mc_embed_signup_scroll">
                      <div class="input-field">
                        <div class="mc-field-group">
                        	<input type="email" value="" name="EMAIL" class="required email" placeholder="email" id="mce-EMAIL">
                        </div>
                      	<div id="mce-responses" class="clear">
                      		<div class="response" id="mce-error-response" style="display:none"></div>
                      		<div class="response" id="mce-success-response" style="display:none"></div>
                      	</div>
                        <div style="position: absolute; left: -5000px;">
                          <input type="text" name="b_4327021590afcb861d13b03f3_400a56eb06" tabindex="-1" value="">
                        </div>
                      </div>
                      <div class="submit-field">
                        <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
                      </div>
                    </div>
                  </form>';
  */

  $newsletter = do_shortcode('[mc4wp_form]');
	return $newsletter;
}
add_shortcode( 'newsletter', 'newsletter_signup' );

function icl_post_languages(){
  $languages = icl_get_languages('skip_missing=0');
  if(1 < count($languages)){
    foreach($languages as $l){
      if(!$l['active']) $langs[] = '<a href="'.$l['url'].'">'.$l['translated_name'].'</a>';
    }
    echo join('', $langs);
  }
}

function sluzby_vypis() {
  $return = '<div class="sluzby-vypis" data-equalizer data-equalizer-mq="large-up">';
  $args = array(
            'post_type' => 'sluzby',
            'posts_per_page' => 6,
            'suppress_filters' => false
          );
  $sluzby = get_posts($args);
  foreach($sluzby as $sluzba) {
    $return .= '<div class="medium-4 small-12 columns" data-equalizer-watch>
                  <div class="sluzby-thumb">'.get_the_post_thumbnail($sluzba->ID).'</div>
                  <h3>'.$sluzba->post_title.'</h3>
                  <p>'.$sluzba->post_content.'</p>
                </div>';
  }
  $return .= '</div>';
  $return .= '<script>jQuery(document).ready(function(){jQuery(document).foundation({equalizer:{equalize_on_stack: true}});});</script>';
  return $return;
}
add_shortcode('sluzby', 'sluzby_vypis');

/* exclude Settings page from admin list */
add_action( 'pre_get_posts' ,'exclude_this_page' );
function exclude_this_page( $query ) {
    if( !is_admin() )
      return $query;

    global $pagenow;

    if( 'edit.php' == $pagenow && ( get_query_var('post_type') && 'page' == get_query_var('post_type') ) )
          $query->set( 'post__not_in', array(554,600) ); // page id

    return $query;
}
function remove_metabox() {
   global $post;

   if ( $post->ID == 554 || $post->ID == 900 ) {
      remove_meta_box( 'wpseo_meta', 'page', 'normal' );
      remove_meta_box( 'pageparentdiv', 'page', 'side' );
  }
}
add_action( 'add_meta_boxes', 'remove_metabox', 11 );


/* galerie kelímků */

add_image_size('cups', 200, 300, true);
add_shortcode('gallery', 'custom_gallery_shortcode');

function custom_gallery_shortcode( $attr ) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) ) {
			$attr['orderby'] = 'post__in';
		}
		$attr['include'] = $attr['ids'];
	}

	$output = apply_filters( 'post_gallery', '', $attr, $instance );
	if ( $output != '' ) {
		return $output;
	}

	$html5 = current_theme_supports( 'html5', 'gallery' );
	$atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => $html5 ? 'figure'     : 'dl',
		'icontag'    => $html5 ? 'div'        : 'dt',
		'captiontag' => $html5 ? 'figcaption' : 'dd',
		'columns'    => 3,
		'size'       => 'cups',
		'include'    => '',
		'exclude'    => '',
		'link'       => ''
	), $attr, 'gallery' );

	$id = intval( $atts['id'] );

	if ( ! empty( $atts['include'] ) ) {
		$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	} else {
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	}

	if ( empty( $attachments ) ) {
		return '';
	}

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
		}
		return $output;
	}

	$itemtag = tag_escape( $atts['itemtag'] );
	$captiontag = tag_escape( $atts['captiontag'] );
	$icontag = tag_escape( $atts['icontag'] );
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) ) {
		$itemtag = 'dl';
	}
	if ( ! isset( $valid_tags[ $captiontag ] ) ) {
		$captiontag = 'dd';
	}
	if ( ! isset( $valid_tags[ $icontag ] ) ) {
		$icontag = 'dt';
	}

	$columns = intval( $atts['columns'] );
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = '';

	$size_class = sanitize_html_class( $atts['size'] );
	$gallery_div = '
      <div class="overlay-left">&nbsp;</div>
      <div class="overlay-right">&nbsp;</div>
      <div class="variable-width">';

	$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {

		$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
		if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
			$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
      $image_output = str_replace('<a href', '<a rel="gallery" href', $image_output);
		} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
			$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
		} else {
			$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
		}
		$image_meta  = wp_get_attachment_metadata( $id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
		}
		$output .= "<div>";
		$output .= "$image_output";

		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</div>";

	}

	$output .= "
		</div>\n";

	return $output;
}

// Add specific CSS class by filter
add_filter('body_class','my_class_names');
function my_class_names($classes) {
	// add 'class-name' to the $classes array
	if(ICL_LANGUAGE_CODE == 'cs'){
		$classes[] = 'class-name';
	} elseif(ICL_LANGUAGE_CODE == 'pl'){
		$classes[] = 'class-name';
	}
	// return the $classes array
	return $classes;
}

/* NEW FORMS ------------------ */
if ( ICL_LANGUAGE_CODE == 'cs' ) {
	define( 'F1', (int) get_field('settings-form-product',554, false, 'cs') );
	define( 'F2', (int) get_field('settings-form-contact',554, false, 'cs') );
	define( 'F1S', (string) get_field('settings-form-product',554, false, 'cs') );
	define( 'F2S', (string) get_field('settings-form-contact',554, false, 'cs') );
} else {
	define( 'F1', (int) get_field('settings-form-product',1413, false, 'pl') );
	define( 'F2', (int) get_field('settings-form-contact',1413, false, 'pl') );
	define( 'F1S', (string) get_field('settings-form-product',1413, false, 'pl') );
	define( 'F2S', (string) get_field('settings-form-contact',1413, false, 'pl') );
}

define( 'DISABLED_VALUE', '0' );

/**
 * Changes form column content for product definition.
 *
 * @hook gform_entries_column_filter
 */
function nn_contact_form_change_column_data( $value, $form_id, $field_id, $entry, $query_string ) {

	if ( $form_id == F2 && $field_id == 8 ) {

		$value = str_replace( array("[","]"),"",$value);
		$value_array = explode(',',$value);

		foreach ($value_array as $key => $product_definition) {

			// Product definition
			$product_definition = str_replace('"','',$product_definition);
			$product_definition = str_replace('&quot;','',$product_definition);

			// Product definition heading
			$product_definition_table_heading = str_replace("@@"," ",$product_definition);
			$product_definition_table_heading = str_replace("€€",", ",$product_definition_table_heading);

			// $product_definition = explode('@@', $product_definition);
			echo '<span style="color:#e2007a;font-weight:700;">Produkt '.($key+1).':</span> '.$product_definition_table_heading.'<br>';
		}
	} else {
		return $value;
	}
}
add_filter( 'gform_entries_column_filter', 'nn_contact_form_change_column_data', 10, 5 );

/**
 * Changes entry detail field content for product definition.
 *
 * @hook gform_entry_field_value
 */
function nn_contact_form_change_entry_field_content( $value, $field, $lead, $form ) {

	if ( $form['id'] == F2 && $field->id == 8 ) {

		$value = str_replace( array("[","]"),"",$value);
		$value_array = explode(',',$value);

		ob_start();

		foreach ($value_array as $key => $product_definition) {

			// Product definition
			$product_definition = str_replace('"','',$product_definition);
			$product_definition = str_replace('&quot;','',$product_definition);

			// Product definition heading
			$product_definition_table_heading = str_replace("@@"," ",$product_definition);
			$product_definition_table_heading = str_replace("€€",", ",$product_definition_table_heading);

			// $product_definition = explode('@@', $product_definition);
			echo '<span style="color:#e2007a;font-weight:700;">Produkt '.($key+1).':</span> '.$product_definition_table_heading.'<br>';
		}

		return ob_get_clean();
	}

	return $value;
}
add_filter( 'gform_entry_field_value', 'nn_contact_form_change_entry_field_content', 10, 4 );

function nn_form_localize_script() {

	// Register our scripts
	/*wp_register_script ( 'functions-js', get_template_directory_uri() . '/js/functions.js?v=' . filemtime(get_stylesheet_directory() . '/js/functions.js'), array('jquery'), '5.4', true );

	// Enqueue our scripts
	wp_enqueue_script( 'functions-js' );*/

	$form_object = array(
		'f1' => F1,
		'f2' => F2,
		'f1s' => F1S,
		'f2s' => F2S,
		'disVal' => DISABLED_VALUE,
		'badCupVolume' => __('Pouze v objemu 0,5l a 0,3l','nicknack'),
		'badCupVolumeLong' => __('Tento produkt lze vybrat pouze v objemu 0,5l a 0,3l','nicknack'),
		'amountText' => __('Počet kusů','nicknack'),
		'min100' => __('min. 100 ks','nicknack'),
		'min1000' => __('min. 1000 ks','nicknack'),
		'min250' => __('min. 250 ks','nicknack'),
		'amountTextSada' => __('Počet párty sad','nicknack'),
		'sadaPack' => __('balení obsahuje 20ks barevných kelímků','nicknack'),
		'motiveAmount' => __('počet grafických motivů','nicknack'),
		'motiveMin' => __('1 grafický motiv je určen min. pro 1000 ks','nicknack'),
		'motiveColorsAmount' => __('Počet barev v motivu','nicknack'),
		'selectFiles' => __('vybrat soubory','nicknack'),
		'noFilesContinue' => __('pokračovat bez nahrání dat','nicknack'),
		'continueText' => __('pokračovat','nicknack'),
		'changeProduct' => __('Upravit','nicknack'),
		'removeProduct' => __('Odebrat','nicknack'),
		'updateContactFields' => __('upravit údaje','nicknack'),
		'fieldMissing' => __('nevyplněno','nicknack'),
		'setProductBeforeSubmit' => __('Před odesláním musíte vybrat nějaký produkt','nicknack'),
		'formHeaderConfirmation' => __('Děkujeme za vaši poptávku','nicknack'),
		'maxFileSize' => __('Při nahrávání souboru/ů došlo k chybě. Mohlo dojít k překročení maximální velikosti jednoho souboru - 24MB.','nicknack')
	);

	if ( ICL_LANGUAGE_CODE == 'pl' ) {
		wp_localize_script( 'functions-js-pl', 'formObject', $form_object );
	} else {
		wp_localize_script( 'functions-js', 'formObject', $form_object );
	}
}
add_action( 'wp_enqueue_scripts', 'nn_form_localize_script', 0 );

// Form 1 disable submit button
add_filter( 'gform_submit_button_'.F1S, 'form_submit_button_disable', 10, 2 );    // Local
function form_submit_button_disable( $button, $form ) {
    return "";
}

// Form 2 hide submit button (will be shown in the last step)
add_filter( 'gform_submit_button_'.F2S, 'form_submit_button', 10, 2 );    // Local
function form_submit_button( $button, $form ) {

    return "<input type=\"submit\" id=\"gform_submit_button_{$form['id']}\" class=\"gform_button button tiny radius\" value=\"".__('Odeslat poptávku','nicknack')."\" tabindex=\"5\">";
}

/**
 * Changes the default Gravity Forms AJAX spinner.
 *
 * @hook gform_ajax_spinner_url
 *
 * @param string $src  The default spinner URL.
 * @return string $src The new spinner URL.
 */
function nn_gf_custom_gforms_spinner( $src ) {
    return ' ';
}
add_filter( 'gform_ajax_spinner_url', 'nn_gf_custom_gforms_spinner' );

// Set proper min value for amount and so on
function nn_product_form_custom_validation( $result, $value, $form, $field ) {

	$open = fopen( plugin_dir_path( __FILE__ ) . '/customvalid.txt', "w" ); // w - write, a - write only
	fwrite( $open, PHP_EOL.PHP_EOL."***************************************************" . PHP_EOL.PHP_EOL );
	fwrite( $open, "VALUE RAW: " . print_r($value,true) . PHP_EOL );
	fwrite( $open, "VALUE: " . print_r(intval($value),true) . PHP_EOL );
	fwrite( $open, "FIELD: " . print_r($field,true) . PHP_EOL );

	// Custom validation
	if ( $result['is_valid'] /*&& ( $field->cssClass != 'cup-color-sample-wrapper' || ($field->cssClass == 'cup-color-sample-wrapper' && $value))*/ ) {

		// NickNack (colored)
		// if ( strpos($field->cssClass,'colors-number-validation-message')!==false ) {
		if ( $field->pageNumber == '11' /*&& ( $field->cssClass != 'cup-color-sample-wrapper' || ($field->cssClass == 'cup-color-sample-wrapper' && $value) )*/ ) {

			// $variant = $product = '';

			// Important pairing
			$variant = rgpost( 'input_3' );
			$product = $variant=='potisk' ? rgpost( 'input_5' ) : rgpost( 'input_6' );
			$subproduct = $product=='sitotisk' ? rgpost( 'input_8' ) : '';
			$selectedColors = rgpost( 'input_47' );

			// fwrite( $open, PHP_EOL . "VARIANT: " . print_r($variant,true) . PHP_EOL );
			// fwrite( $open, "PRODUCT: " . print_r($product,true) . PHP_EOL );
			// fwrite( $open, "SUBPRODUCT: " . print_r($subproduct,true) . PHP_EOL );

			// Initialize
			$value_raw = $value;
			$value = intval($value);
			$valid = true;
			$valid_value = '';
			$message = __('Minimální počet kusů je','nicknack') . ' ';

			// Bez potisku
			if ( $variant=='bez-potisku' ) {
				// fwrite( $open, "-> BEZ POTISKU" . PHP_EOL );

				// Univerzalni
				if ( $product=='univerzalni' && $field->cssClass=='custom-cup-amount' && $value<100 ) {
					// fwrite( $open, "-> VALUE FALSE 1a" . PHP_EOL );
					$valid = false;
					$valid_value = 100;

				// Barevny
				} elseif ( $product=='barevny' ) {

					// Selected Color field check
					if( $field->cssClass=='cup-color-sample-wrapper' && /*$value_raw!=DISABLED_VALUE &&*/ $value<100 ) {
						// fwrite( $open, "-> VALUE FALSE 1b" . PHP_EOL );

						// There are some color selected
						if ( $selectedColors != '' ) {
							$selectedColors__array = json_decode($selectedColors);

							// Current color field is between selected colors
							if ( in_array('input_'.$field->formId.'_'.$field->id, $selectedColors__array) ) {
								$valid = false;
								$valid_value = '';
								$message = sprintf( __('min. %s ks','nicknack'), 100 );
							}
						}

					// Custom field for validation message when no color selected
					} elseif ( $field->id == 49 ) {
						// fwrite( $open, "-> SELECTED COLORS:". print_r($selectedColors,true) . PHP_EOL );

						// There is no color selected
						if ( $selectedColors == '' || empty($selectedColors) || $selectedColors == '[]' ) {
							// fwrite( $open, "-> SELECTED COLORS EMPTY" . PHP_EOL );
							$valid = false;
							$valid_value = '';
							$message = __('Vyberte barvu','nicknack');
						}
					}

				// Sada
				} elseif ( $product=='sada' && strpos($field->cssClass,'custom-cup-amount')!==false && $value<1 ) {
					// fwrite( $open, "-> VALUE FALSE sada: ". print_r($value,true) . PHP_EOL );
					$valid = false;
					$valid_value = 1;
				}

			// S potiskem
			} elseif ( $variant=='potisk' ) {
				// fwrite( $open, "-> S POTISKEM" . PHP_EOL );

				// IML product
				if ( $product=='iml' && $field->cssClass=='custom-cup-amount' && $value<1000 ) {
					// fwrite( $open, "-> VALUE FALSE 2" . PHP_EOL );
					$valid = false;
					$valid_value = 1000;

				// Sitotisk - transparentní kelimek
				} elseif ( $product=='sitotisk' && $subproduct=='transparentni-kelimek' && $field->cssClass=='custom-cup-amount' && $value<250 ) {
					// fwrite( $open, "-> VALUE FALSE 3" . PHP_EOL );
					$valid = false;
					$valid_value = 250;

				// Sitotisk - barevny kelimek
				} elseif ( $product=='sitotisk' && $subproduct=='barevny-kelimek' ) {

					// Selected Color field check
					if( $field->cssClass=='cup-color-sample-wrapper' /*&& $value_raw!=DISABLED_VALUE*/ && $value<250 ) {
						// fwrite( $open, "-> VALUE FALSE 4" . PHP_EOL );

						// There are some color selected
						if ( $selectedColors != '' ) {
							$selectedColors__array = json_decode($selectedColors);

							// Current color field is between selected colors
							if ( in_array('input_'.$field->formId.'_'.$field->id, $selectedColors__array) ) {
								$valid = false;
								$valid_value = '';
								$message = sprintf( __('min. %s ks','nicknack'), 250 );
							}
						}

					// Custom field for validation message when no color selected
					} elseif ( $field->id == 49 ) {

						// There is no color selected
						if ( $selectedColors == '' || empty($selectedColors) || $selectedColors == '[]' ) {
							// fwrite( $open, "-> SELECTED COLORS EMPTY" . PHP_EOL );
							$valid = false;
							$valid_value = '';
							$message = __('Vyberte barvu','nicknack');
						}
					}
				}

				// Motive field check
				if ( $field->cssClass=='motive-amount' && $value<1 ) {
					// fwrite( $open, "-> VALUE FALSE 4" . PHP_EOL );
					$valid = false;
					$valid_value = 1;

					// IML vs sitotisk
					if ( $product=='iml' ) {
						$message = __('Minimální počet motivů je','nicknack') . ' ';
					} elseif ( $product=='sitotisk' ) {
						$message = __('Minimální počet barev v motivu je','nicknack') . ' ';
					}
				}
			}

			if ( ! $valid ) {
				$result['is_valid'] = false;
				$result['message'] = $message . $valid_value;
			}

		// Hotcup (basic or colored)
		} elseif ( $field->pageNumber == '5' || $field->pageNumber == '6' ) {
			// fwrite( $open, "page 5 || 6" . PHP_EOL );

			$value_raw = $value;
			$value = intval($value);
			$valid = true;
			$valid_value = '';
			$message = __('Minimální počet kusů je','nicknack') . ' ';

			// $variant = $product = '';

			// Important pairing
			$variant = rgpost( 'input_56' );
			$product = $variant=='potisk' ? rgpost( 'input_78' ) : rgpost( 'input_62' );
			// $subproduct = $product=='sitotisk' ? rgpost( 'input_8' ) : '';
			$selectedColors = $product=='zakladni' ? rgpost( 'input_83' ) : rgpost( 'input_82' );
			$fieldForCustomValidation = $product=='zakladni' ? 85 : 84;

			// fwrite( $open, "-------------------------------------------" . PHP_EOL );
			// fwrite( $open, "VARIANT: " . print_r($variant,true) . PHP_EOL );
			// fwrite( $open, "PRODUCT: " . print_r($product,true) . PHP_EOL );
			// fwrite( $open, "selectedColors: " . print_r($selectedColors,true) . PHP_EOL );
			// fwrite( $open, "fieldForCustomValidation: " . print_r($fieldForCustomValidation,true) . PHP_EOL );
			// fwrite( $open, "-------------------------------------------" . PHP_EOL );

			if ( $variant=='potisk' ) {
				// fwrite( $open, "[potisk]" . PHP_EOL );

				// Selected Color field check
				if( strpos($field->cssClass,'cup-color-sample-wrapper')!==false /*&& $value_raw!=DISABLED_VALUE*/ && $value<250 ) {
					fwrite( $open, "is color field" . PHP_EOL );

						// There are some color selected
					if ( $selectedColors != '' ) {
						fwrite( $open, "-> SOME COLORS GIVEN" . PHP_EOL );
						$selectedColors__array = json_decode($selectedColors);

						// Current color field is between selected colors
						if ( in_array('input_'.$field->formId.'_'.$field->id, $selectedColors__array) ) {
							fwrite( $open, "-> THIS COLOR INCLUDED" . PHP_EOL );
							$valid = false;
							$valid_value = '';
							$message = sprintf( __('min. %s ks','nicknack'), 250 );
						}
					}

				// Custom field for validation message when no color selected
				} elseif ( $field->id == $fieldForCustomValidation ) {
					// fwrite( $open, "is CUSTOM amount field" . PHP_EOL );

					// There is no color selected
					if ( $selectedColors == '' || empty($selectedColors) || $selectedColors == '[]' ) {
						// fwrite( $open, "-> SELECTED COLORS EMPTY" . PHP_EOL );
						$valid = false;
						$valid_value = '';
						$message = __('Vyberte barvu','nicknack');
					}
				}

				// Motive field check
				if ( $field->cssClass=='motive-amount' && $value<1 ) {
					// fwrite( $open, "-> VALUE FALSE 4" . PHP_EOL );
					$valid = false;
					$valid_value = 1;

					$message = __('Minimální počet barev v motivu je','nicknack') . ' ';
				}

			} else {	// bez potisku
				// fwrite( $open, "[bez potisku]" . PHP_EOL );

				// Selected Color field check
				if( strpos($field->cssClass,'cup-color-sample-wrapper')!==false /*&& $value_raw!=DISABLED_VALUE*/ && $value<100 ) {
					// fwrite( $open, "-> color field & VALUE < 100" . PHP_EOL );

					// There are some color selected
					if ( $selectedColors != '' ) {
						$selectedColors__array = json_decode($selectedColors);

						// Current color field is between selected colors
						if ( in_array('input_'.$field->formId.'_'.$field->id, $selectedColors__array) ) {
							$valid = false;
							$valid_value = '';
							$message = sprintf( __('min. %s ks','nicknack'), 100 );
						}
					}

				// Custom field for validation message when no color selected
				} elseif ( $field->id == $fieldForCustomValidation ) {
					// fwrite( $open, "-> is custom amount field" . PHP_EOL );

					// There is no color selected
					if ( $selectedColors == '' || empty($selectedColors) || $selectedColors == '[]' ) {
						// fwrite( $open, "-> SELECTED COLORS EMPTY" . PHP_EOL );
						$valid = false;
						$valid_value = '';
						$message = __('Vyberte barvu','nicknack');
					}
				}
			}

			if ( ! $valid ) {
				$result['is_valid'] = false;
				$result['message'] = $message . $valid_value;
			}

		// Hotcup cap
		} elseif ( $field->pageNumber == '14' ) {

			$value_raw = $value;
			$value = intval($value);
			$valid = true;
			$valid_value = '';
			$message = __('Minimální počet kusů je','nicknack') . ' ';

			// Important pairing
			$selectedColors = rgpost( 'input_99' );
			$fieldForCustomValidation = 101;

			fwrite( $open, "-------------------------------------------" . PHP_EOL );
			fwrite( $open, "selectedColors: " . print_r($selectedColors,true) . PHP_EOL );
			fwrite( $open, "fieldForCustomValidation: " . print_r($fieldForCustomValidation,true) . PHP_EOL );
			fwrite( $open, "-------------------------------------------" . PHP_EOL );

			// Selected Color field check
			if( strpos($field->cssClass,'cup-color-sample-wrapper')!==false && $value<100 ) {
				fwrite( $open, "-- Selected Color field check --" . PHP_EOL );

				// There are some color selected
				if ( $selectedColors != '' ) {
					$selectedColors__array = json_decode($selectedColors);
					fwrite( $open, "selectedColors__array: " . print_r($selectedColors__array,true) . PHP_EOL );

					// Current color field is between selected colors
					if ( in_array('input_'.$field->formId.'_'.$field->id, $selectedColors__array) ) {
						$valid = false;
						$valid_value = '';
						$message = sprintf( __('min. %s ks','nicknack'), 100 );
					}
				}

			// Custom field for validation message when no color selected
			} elseif ( $field->id == $fieldForCustomValidation ) {
				fwrite( $open, "-- Custom field for validation message when no color selected --" . PHP_EOL );

				// There is no color selected
				if ( $selectedColors == '' || empty($selectedColors) || $selectedColors == '[]' ) {
					fwrite( $open, "-- There is no color selected --" . PHP_EOL );
					$valid = false;
					$valid_value = '';
					$message = __('Vyberte barvu','nicknack');
				}
			}

			if ( ! $valid ) {
				$result['is_valid'] = false;
				$result['message'] = $message . $valid_value;
			}
		}

	}

	fwrite( $open, "FIELD: " . print_r($field,true) . PHP_EOL );
	fwrite( $open, "FORM: " . print_r($form,true) . PHP_EOL );
	fclose( $open );

	return $result;
}
add_filter( 'gform_field_validation_'.F1S, 'nn_product_form_custom_validation', 10, 4 );

/**
 * Prevents submitting a inquiry-contact form without product definition data.
 *
 * Check the product hidden field, if there is some product definition.
 * Make validation FAIL if that field is empty (its probably a spam).
 *
 * @param Boolean $result
 * @param String $value
 * @param Object $form
 * @param Object $field
 * @return Boolean
 */
function nn_contact_form_custom_validation( $result, $value, $form, $field ) {

	// Custom validation
	if ( $result['is_valid'] ) {

		// Hidden input with product definition data
		if ( $field->id == '8' ) {

			if ( ! $value ) {
				$result['is_valid'] = false;
				$result['message'] = __('Bohužel došlo k chybě, prosíme, zkuste provést poptávku znovu.','nicknack');
			}
		}
	}

	return $result;
}
add_filter( 'gform_field_validation_'.F2S, 'nn_contact_form_custom_validation', 10, 4 );

// Change notification subject when amount over limit
function nn_check_before_notification_email( $email, $message_format, $notification, $entry ) {

	if ( $entry['form_id'] == F2S ) {

		$value = $entry[8];

		$value = str_replace( array("[","]"),"",$value);
		$value_array = explode(',',$value);

		foreach ($value_array as $key => $product_definition) {

			// Product definition
			$product_definition = str_replace('"','',$product_definition);
			$product_definition = str_replace('&quot;','',$product_definition);

			$product_definition = explode('@@', $product_definition);

			$amount_limit = 2000;

			// 0: product_type
			// 1: volume
			// 2: variant
			// 3: product
			// 4: subproduct
			// 5: colors
			// 6: amount
			// 7: motive
			$product_type = strtoupper( $product_definition[0] );
			$volume = $product_definition[1];
			$variant = $product_definition[2];
			$product = $product_definition[3];
			$subproduct = $product_definition[4];
			$colors = str_replace('&lt;br&gt;','',$product_definition[5]);	// Remove all <br>
			$colors = str_replace('<br>','',$colors);	// Remove all <br>
			$amount = $product_definition[6];
			$motive = $product_definition[7];

			// NickNack
			if ( $product_type=='NICKNACK' ) {

				if ( $variant == 'bez-potisku' ) {
					switch ($product) {
						case 'sada':
							$amount_limit = false;
							break;

						case 'barevny':
							$amount = 0;
							$colors_array = explode('€€', $colors);
							// For each selected color
							foreach ( $colors_array as $key => $color ) {
								// Explode to get the amount for this color
								$color_array = explode(':', $color);	// array("ŽLUTÝ","250")
								// Amount is here sum of the color sums
								$amount += intval($color_array[1]);
							}
							break;

						case 'univerzalni':
							break;

						default:
							break;
					}

				} else {
					$amount_limit = 3000;

					switch ($product) {
						case 'iml':
							break;

						case 'sitotisk':
							if ( $subproduct == 'transparentni-kelimek' ) {
								// No change, default limit
							} elseif ( $subproduct == 'barevny-kelimek' ) {
								$amount = 0;
								$colors_array = explode('€€', $colors);
								// For each selected color
								foreach ( $colors_array as $key => $color ) {
									// Explode to get the amount for this color
									$color_array = explode(':', $color);	// array("ŽLUTÝ","250")
									// Amount is here sum of the color sums
									$amount += intval($color_array[1]);
								}
							}
							break;

						default:
							break;
					}
				}

			// Hotcup
			} else {

				if ( $variant == 'bez-potisku' ) {

					switch ($product) {

						case 'zakladni':
						case 'barevny':
							$amount = 0;
							// ŠEDÝ:150Víčka:ŽLUTÁ:150 -> array("ŠEDÝ:150","ŽLUTÁ:150")
							$color_array_cup_cap = explode('Víčka:', $colors);
							$colors_array = explode('€€', $color_array_cup_cap[0]);
							// For each selected color
							foreach ( $colors_array as $key => $color ) {
								// Explode to get the amount for this color
								$color_array = explode(':', $color);	// array("ŽLUTÝ","250")
								// Amount is here sum of the color sums
								$amount += intval($color_array[1]);
							}
							break;

						default:
							break;
					}

				} else {

					switch ($product) {

						case 'zakladni':
						case 'barevny':
							$amount = 0;
							// ŠEDÝ:150Víčka:ŽLUTÁ:150 -> array("ŠEDÝ:150","ŽLUTÁ:150")
							$color_array_cup_cap = explode('Víčka:', $colors);
							$colors_array = explode('€€', $color_array_cup_cap[0]);
							// For each selected color
							foreach ( $colors_array as $key => $color ) {
								// Explode to get the amount for this color
								$color_array = explode(':', $color);	// array("ŽLUTÝ","250")
								// Amount is here sum of the color sums
								$amount += intval($color_array[1]);
							}
							break;

						default:
							break;
					}
				}
			}

			// Check final amount for this product definition
			if ( $amount_limit && $amount >= $amount_limit ) {
				// Change subject when over amount limit
				$email['subject'] .= ' [nadlimitní množství]';

				break;
			}
		}
	}

	return $email;
}
add_filter( 'gform_pre_send_email', 'nn_check_before_notification_email', 10, 4 );

?>