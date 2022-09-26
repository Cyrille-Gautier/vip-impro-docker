<?php

define( 'MAGSY_VERSION', '1.3.0' );

if ( ! function_exists( 'magsy_setup' ) ) :
function magsy_setup() {
	load_theme_textdomain( 'magsy', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio' ) );
	add_theme_support( 'align-wide' );

	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'magsy' ),
	) );

	register_nav_menus( array(
		'menu-2' => esc_html__( 'Footer', 'magsy' ),
	) );

	add_image_size( 'magsy_full_400', 400 );
	add_image_size( 'magsy_full_800', 800 );
	add_image_size( 'magsy_full_1160', 1160 );
	add_image_size( 'magsy_rect_300', 300, 200, true );
}
endif;
add_action( 'after_setup_theme', 'magsy_setup' );

function magsy_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'magsy_content_width', 1130 );
}
add_action( 'after_setup_theme', 'magsy_content_width', 0 );

function magsy_widgets_init() {
	register_sidebar( array(
		'name' => esc_html__( 'Modular Page', 'magsy' ),
		'id' => 'modules',
		'description' => esc_html__( 'Add modules here.', 'magsy' ),
		'before_widget' => '<div id="%1$s" class="section %2$s"><div class="container">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="section-title"><span>',
		'after_title' => '</span></h3>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Sidebar', 'magsy' ),
		'id' => 'sidebar',
		'description' => esc_html__( 'Add sidebar widgets here.', 'magsy' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Off-Canvas', 'magsy' ),
		'id' => 'off_canvas',
		'description' => esc_html__( 'Add off-canvas widgets here.', 'magsy' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );
}
add_action( 'widgets_init', 'magsy_widgets_init' );

function magsy_fonts_url() {
	$font_url = '';

	/*
	Translators: If there are characters in your language that are not supported
	by chosen font(s), translate this to 'off'. Do not translate into your own language.
	*/
	if ( 'off' !== _x( 'on', 'Google Fonts: on or off', 'magsy' ) ) {
	  $font_url = add_query_arg( 'family', urlencode( 'Lato:400,400i,700,900|Merriweather:400,700&subset=latin,latin-ext' ), '//fonts.googleapis.com/css' );
	}

	return esc_url( $font_url );
}

function magsy_scripts() {
	wp_enqueue_style( 'magsy-fonts', magsy_fonts_url(), array(), MAGSY_VERSION );
	wp_enqueue_style( 'magsy-style', get_stylesheet_uri(), array(), MAGSY_VERSION );

	wp_enqueue_script( 'magsy-script', get_template_directory_uri() . '/js/magsy.min.js', array( 'jquery', 'masonry' ), MAGSY_VERSION, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$magsy_params = array(
    'home_url' => esc_url( home_url() ),
    'admin_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
    'logo_regular' => esc_url( magsy_get_option( 'magsy_logo_regular@2x', '' ) ),
    'logo_contrary' => esc_url( magsy_get_option( 'magsy_logo_contrary@2x', '' ) ),
    'like_nonce' => wp_create_nonce( 'magsy_like_nonce' ),
    'unlike_nonce' => wp_create_nonce( 'magsy_unlike_nonce' ),
    'like_title' => apply_filters( 'magsy_like_title', esc_html__( 'Click to like this post.', 'magsy' ) ),
		'unlike_title' => apply_filters( 'magsy_unlike_title', esc_html__( 'You have already liked this post. Click again to unlike it.', 'magsy' ) ),
		'infinite_load' => apply_filters( 'magsy_infinite_button_load', esc_html__( 'Load more', 'magsy' ) ),
		'infinite_loading' => apply_filters( 'magsy_infinite_button_load', esc_html__( 'Loading...', 'magsy' ) ),
  );
  wp_localize_script( 'magsy-script', 'magsyParams', $magsy_params );
}
add_action( 'wp_enqueue_scripts', 'magsy_scripts' );

if ( ! function_exists( 'rwmb_meta' ) ) {
  function rwmb_meta( $key, $args = '', $post_id = null ) {
    return false;
  }
}

require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/template-tags/template-tags.php';
require get_template_directory() . '/inc/walker.php';
require get_template_directory() . '/inc/customizer/class-magsy-kirki.php';
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/metabox.php';
require get_template_directory() . '/inc/tgmpa/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/tgmpa/tgmpa.php';