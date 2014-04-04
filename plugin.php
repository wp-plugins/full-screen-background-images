<?php

/*
  Plugin Name: Full Screen Background Images
  Plugin URI: http://wordpress.org/extend/plugins/full-screen-background-images/
  Author URI: http://www.kouratoras.gr
  Author: Konstantinos Kouratoras
  Contributors: kouratoras
  Donate link:
  Tags: full, screen, background, images
  Requires at least: 3.2
  Tested up to: 3.8.1
  Stable tag: 0.2.2
  Version: 0.2.2
  License: GPLv2 or later
  Description: Full Screen Background Images Plugin creates an image slideshow as a background to your website.

  Copyright 2012 Konstantinos Kouratoras (kouratoras@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

define('PLUGIN_DIR_NAME', 'full-screen-background-images');

class FullScreenBackground {
	/* -------------------------------------------------- */
	/* Constructor
	  /*-------------------------------------------------- */

	public function __construct() {

		register_activation_hook(__FILE__, array($this, 'plugin_activation'));

		load_plugin_textdomain('full-screen-background-locale', false, plugin_dir_path(__FILE__) . '/lang/');

		//Backgrounds custom post type
		require_once( plugin_dir_path(__FILE__) . 'cpt_backgrounds.php' );

		//Register scripts and styles
		add_action('wp_enqueue_scripts', array(&$this, 'register_plugin_scripts'));
		add_action('wp_enqueue_scripts', array(&$this, 'register_plugin_styles'));

		add_action('wp_head', array(&$this, 'plugin_init'));
	}

	/* -------------------------------------------------- */
	/* On plugin activation
	  /* -------------------------------------------------- */
	public function plugin_activation() {
		if (function_exists('add_theme_support')) {
			add_theme_support('post-thumbnails');
			add_image_size('full_screen_background', 1600, 1200, true);
		}
	}

	/* -------------------------------------------------- */
	/* Registers and enqueues scripts.
	  /* -------------------------------------------------- */

	public function register_plugin_scripts() {

		wp_enqueue_script('jquery');

		wp_register_script('jquery-easing', plugins_url(PLUGIN_DIR_NAME . '/js/jquery.easing.min.js'));
		wp_enqueue_script('jquery-easing');

		wp_register_script('supersized', plugins_url(PLUGIN_DIR_NAME . '/js/supersized.3.2.7.min.js'));
		wp_enqueue_script('supersized');

		wp_register_script('supersized-shutter', plugins_url(PLUGIN_DIR_NAME . '/js/supersized.shutter.min.js'));
		wp_enqueue_script('supersized-shutter');
	}

	/* -------------------------------------------------- */
	/* Registers and enqueues scripts.
	  /* -------------------------------------------------- */

	public function register_plugin_styles() {

		wp_register_style('supersized', plugins_url(PLUGIN_DIR_NAME . '/css/supersized.css'));
		wp_enqueue_style('supersized');

		wp_register_style('supersized-shutter', plugins_url(PLUGIN_DIR_NAME . '/css/supersized.shutter.css'));
		wp_enqueue_style('supersized-shutter');
	}

	public function plugin_init($content) {

		$args = array(
		    'post_type' => 'cpt_background',
		    'posts_per_page' => -1,
		    'update_post_term_cache' => false, // don't retrieve post terms
		    'update_post_meta_cache' => false, // don't retrieve post meta
		);
		$the_query = new WP_Query($args);

		$script_code = '<script type="text/javascript">
	
		jQuery(function($){

			$.supersized({

				// Functionality
				slide_interval          :   3000,
				transition              :   1, 
				transition_speed	:	300,

				// Components							
				slide_links		:	"blank",
				slides 			:  	[';

		if ($the_query->have_posts()) :

			while ($the_query->have_posts()) : $the_query->the_post();	
				if (has_post_thumbnail()) {
					$image_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full_screen_background');
					$script_code .= '{image : "' . $image_url[0] .'", title : "' . get_the_title() . '"},';
				}
			endwhile;
		endif;
		$script_code = substr($script_code, 0 , -1);
		$script_code .= ']		
			});
		});
		</script>';

		echo $script_code;
		
		wp_reset_query();
	}
}

new FullScreenBackground();