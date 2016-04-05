<?php
/*
Plugin Name: Book Collector Post Type
Description: Keep track of the books in your collection
Author: Patrick Jones
Author URI: http://www.patrickmjones.com
Version: 0.0.1
*/

add_action('init', 'pj_book_opt');

function pj_book_opt() {
	register_post_type( 'book', array(
		'labels' => array(
			'name' => 'Books',
			'singular_name' => 'Book'
		),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'rewrite' => array("slug" => "books"),
		
		'description' => 'Books in your collection.',
		'menu_position' => 20,
		'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
		'menu_icon' => 'dashicons-book'
	));

	register_taxonomy(
		'book_language',
		'book',
		array(
			'labels' => array(
				'name' => __( 'Languages'),
				'singular_name' => __('Language'),
				'add_new_item' => __('Add New Language'),
				'edit_item' => __('Edit Language'),
				'new_item' => __('New Language'),
				'search_items' => __('Search Languages')
			),
			'rewrite' => array('slug' => 'book_language'),
			'hierarchical' => false
		)
	);

	register_taxonomy(
		'book_author',
		'book',
		array(
			'labels' => array(
				'name' => __( 'Authors'),
				'singular_name' => __('Author'),
				'add_new_item' => __('Add New Author'),
				'edit_item' => __('Edit Author'),
				'new_item' => __('New Author'),
				'search_items' => __('Search Authors')
			),
			'rewrite' => array('slug' => 'book_author'),
			'hierarchical' => false
		)
	);

	add_filter('manage_edit-book_columns', 'pj_book_add_new_book_columns');
	add_filter("template_include", 'pj_book_template_include' );
	add_action('manage_book_posts_custom_column', 'pj_book_manage_book_columns', 10, 2);
	add_action('pre_get_posts', 'pj_book_num_posts_for_testimonials');

	add_theme_support( 'post-thumbnails', array('book'));

	flush_rewrite_rules();

} 

function pj_book_num_posts_for_testimonials($query)
{
	if ($query->is_main_query() && $query->is_post_type_archive('book') && !is_admin()) {
		$query->set('posts_per_page', 20);
	}
}
 

function pj_book_add_new_book_columns($book_columns) {
	$new_book_columns['cb'] = '<input type="checkbox" />';
	$new_book_columns['title'] = _x('Game Name', 'column name');
	$new_book_columns['original_title'] = __('Original Title');
	$new_book_columns['bookauthor'] = __('Author');
	$new_book_columns['language'] = __('Language');
	$new_book_columns['year'] = __('Year');

	return $new_book_columns;
}
 
function pj_book_manage_book_columns($column_name, $id) {
	global $wpdb;
	switch ($column_name) {
		case 'original_title':
			echo get_field('original_title');
			break;
		case 'year':
			echo get_field('year');
			break;
		case 'language':
			$language_id = get_field('language', $id);
			$term = get_term( $language_id, 'book_language');
			echo $term->name;
			break;
		case 'bookauthor':
			$author_id = get_field('bookauthor', $id);
			$term = get_term( $author_id, 'book_author');
			echo $term->name;
			break;
		default:
			break;
	} // end switch
}   

function pj_book_template_include( $template_path ) {
	if ( get_post_type() == 'book' ) {
		if ( is_single() ) {
			// checks if the file exists in the theme first,
			// otherwise serve the file from the plugin
			if ( $theme_file = locate_template( array ( 'single-book.php' ) ) ) {
				$template_path = $theme_file;
			} else {
				$template_path = plugin_dir_path( __FILE__ ) . '/single-book.php';
			}
		}else if ( is_archive() ) {
			if ( $theme_file = locate_template( array ( 'archive-book.php' ) ) ) {
				$template_path = $theme_file;
			} else {
				$template_path = plugin_dir_path( __FILE__ ) . '/archive-book.php';
			}
		}
	}
	return $template_path;
}

?>
