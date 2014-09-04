<?php

add_action('init', 'cpt_background_init');

function cpt_background_init() {
	$labels = array(
	    'name' => _x('Backgrounds', 'post type general name', 'hwpt'),
	    'singular_name' => _x('Backgrounds', 'post type singular name', 'hwpt'),
	    'new_item' => __('New Background', 'hwpt'),
	    'add_new' => __('New Background', 'hwpt'),
	    'add_new_item' => __('Add New Background', 'hwpt'),
	    'view_item' => __('View Background', 'hwpt'),
	    'edit_item' => __('Edit Background', 'hwpt'),
	    'search_items' => __('Search Backgrounds', 'hwpt'),
	    'not_found' => __('No Backgrounds found', 'hwpt'),
	    'not_found_in_trash' => __('No Backgrounds found in the trash', 'hwpt'),
	    'parent_item_colon' => __('Parent Background:', 'hwpt')
	);

	$args = array(
	    'labels' => $labels,
	    'public' => true,
	    'publicly_queryable' => true,
	    'show_ui' => true,
	    'singular_label' => __('Backgrounds', 'hwpt'),
	    'query_var' => true,
	    'rewrite' => true,
	    'capability_type' => 'post',
	    'hierarchical' => false,
	    'has_archive' => false,
	    'menu_position' => 30,
	    'supports' => array(
		'title',
		'thumbnail'
	    ),
	    'menu_icon' => 'dashicons-format-gallery',
	);

	register_post_type('cpt_background', $args);
}