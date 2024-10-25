<?php

/**
 * Content Width
 */
function core_content_width()
{
	$GLOBALS['content_width'] = apply_filters('core_content_width', 2048);
}
add_action('after_setup_theme', 'core_content_width', 0);


/**
 * Core functions and definitions
 */
if (!function_exists('core_setup')) :
	function core_setup()
	{

		// Main Menus
		register_nav_menus(MAIN_MENU);

		//Theme Support
		add_theme_support('admin-bar', ['callback' => '__return_false']);
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_theme_support(
			'html5',
			[
				'search-form',
				'gallery',
				'caption',
				'comment-form',
				'comment-list',
				'style',
				'script',
			]
		);
		add_theme_support(
			'custom-logo',
			[
				'height'      => 100,
				'width'       => 300,
				'flex-width'  => true,
				'flex-height' => true,
			]
		);

		add_image_size(IMG_SIZE_SM, 384, 384, false);

		add_theme_support('editor-styles');
		add_editor_style(get_core_enqueue_path('main.css', false));
	}
endif;
add_action('after_setup_theme', 'core_setup');

add_post_type_support('page', 'excerpt');

/**
 * Extra Image Sizes In Editor
 */
function add_custom_image_sizes()
{
	return [
		IMG_SIZE_XS => __('X Small'),
		IMG_SIZE_SM => __('Small'),
		IMG_SIZE_MD => __('Medium'),
		IMG_SIZE_LG => __('Large'),
		IMG_SIZE_XL => __('X Large'),
		IMG_SIZE_2XL => __('2X Large'),
		IMG_SIZE_3XL => __('3X Large'),
		'full' => __('Full Size')
	];
}
add_filter('image_size_names_choose', 'add_custom_image_sizes');

/**
 * Widgets
 */
function core_widgets_init()
{
	for ($i = 1; $i <= FOOTER_SIDEBAR_QUANTITY; $i++) {
		$col_class = $i == 1 ? 'col-md-4' : 'col-md';
		$offset_class = $i == 2 ? ' offset-xl-1 offset-md-1' : '';

		$classes = $col_class . $offset_class;

		register_sidebar([
			'name'          => esc_html__("Footer Widget $i", 'core'),
			'id'            => "footer-sidebar-$i",
			'before_sidebar' => '<div id="%1$s" class="vstack gap-2 ' . $classes . '">',
			'after_sidebar' => '</div>',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="main-footer__title">',
			'after_title'   => '</h2>',
		]);
	}
	register_sidebar([
		'name'          => esc_html__("Widget Login", 'core'),
		'id'            => "widget-login",
		'before_sidebar' => '<div id="%1$s" class="vstack gap-2 ' . $classes . '">',
		'after_sidebar' => '</div>',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="main-footer__title">',
		'after_title'   => '</h2>',
	]);
}
add_action('widgets_init', 'core_widgets_init');

/**
 * Front-end CSS and JS
 */

function core_enqueue()
{
	//Dequeue
	wp_dequeue_style('classic-theme-styles');
	wp_dequeue_style('wp-block-library');
	wp_dequeue_script('comment-reply');

	//Sprite
	wp_enqueue_script('sprite-async', get_core_enqueue_path('sprite.js'), [], null, true);

	//Core Files
	wp_enqueue_style('main', get_core_enqueue_path('main.css'), [], null);
	wp_enqueue_script('main-defer', get_core_enqueue_path('main.js'), [], null, true);

	// Swiper
	wp_enqueue_style('swiper', get_core_enqueue_path('swiper.css'), [], null);
	wp_enqueue_script('swiper-async', get_core_enqueue_path('swiper.js'), [], null, true);
}
add_action('wp_enqueue_scripts', 'core_enqueue');

/**
 * Admin Panel CSS and JS
 */
function core_admin_enqueue()
{
	wp_enqueue_style('admin', get_core_enqueue_path('admin.css'), [], null);
	wp_enqueue_script('admin-async', get_core_enqueue_path('admin.js'), ['acf', 'jquery'], null);
}
add_action('admin_enqueue_scripts', 'core_admin_enqueue');

/**
 * Requires
 */
require get_template_directory() . '/inc/variables.php';
require get_template_directory() . '/inc/theme-functions.php';
require get_template_directory() . '/inc/main-menu.php';
require get_template_directory() . '/inc/acf.php';
require get_template_directory() . '/inc/actions.php';
require get_template_directory() . '/inc/filters.php';
require get_template_directory() . '/inc/shortcodes.php';
require get_template_directory() . '/inc/tiny-mce.php';
require get_template_directory() . '/inc/gravity-forms.php';
// require get_template_directory() . '/inc/image-validation.php';
require get_template_directory() . '/inc/popups.php';
