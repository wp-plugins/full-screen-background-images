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
  Tested up to: 4.1
  Stable tag: 0.3.2
  Version: 0.3.2
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
	
	private $settings;
	
	/* -------------------------------------------------- */
	/* Constructor
	  /*-------------------------------------------------- */

	public function __construct() {

		register_activation_hook(__FILE__, array($this, 'plugin_activation'));

		load_plugin_textdomain('fsbi', false, plugin_dir_path(__FILE__) . '/lang/');
		
		//Fetch settings
		$this->settings = get_option('fsbi_settings');

		//Backgrounds custom post type
		require_once( plugin_dir_path(__FILE__) . '/lib/cpt_backgrounds.php' );
		
		//Options Page
		require_once( plugin_dir_path(__FILE__) . '/lib/options.php' );
		
		//Action links
		add_filter('plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2);

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
	/* Settings button
	  /* -------------------------------------------------- */
	public function plugin_action_links($links, $file) {
		static $current_plugin = '';

		if (!$current_plugin) {
			$current_plugin = plugin_basename(__FILE__);
		}

		if ($file == $current_plugin) {
			$settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/edit.php?post_type=cpt_background&page=options">' . __('Settings', 'scrollup') . '</a>';
			array_unshift($links, $settings_link);
			
			$settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/edit.php?post_type=cpt_background">' . __('Backgrounds', 'scrollup') . '</a>';
			array_unshift($links, $settings_link);
		}

		return $links;
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
				
		$fsbi_autoplay = ($this->settings['autoplay'] ? $this->settings['autoplay'] : '0');
		$fsbi_fit_always = ($this->settings['fit_always'] ? $this->settings['fit_always'] : '0');
		$fsbi_horizontal_center = ($this->settings['horizontal_center'] ? $this->settings['horizontal_center'] : '0');
		$fsbi_vertical_center = ($this->settings['vertical_center'] ? $this->settings['vertical_center'] : '0');
		$fsbi_keyboard_nav = ($this->settings['keyboard_nav'] ? $this->settings['keyboard_nav'] : '0');
		$fsbi_min_height = ($this->settings['min_height'] ? $this->settings['min_height'] : '0');
		$fsbi_min_width = ($this->settings['min_width'] ? $this->settings['min_width'] : '0');
		$fsbi_pause_hover = ($this->settings['pause_hover'] ? $this->settings['pause_hover'] : '0');
		$fsbi_random = ($this->settings['random'] ? $this->settings['random'] : '0');
		$fsbi_slide_interval = ($this->settings['slide_interval'] ? $this->settings['slide_interval'] : '5000');
		$fsbi_transition = ($this->settings['transition'] ? $this->settings['transition'] : '1');
		$fsbi_transition_speed = ($this->settings['transition_speed'] ? $this->settings['transition_speed'] : '750');

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

				autoplay		:   '.$fsbi_autoplay.',
				fit_always		:   '.$fsbi_fit_always.',
				horizontal_center	:   '.$fsbi_horizontal_center.',
				vertical_center		:   '.$fsbi_vertical_center.',
				keyboard_nav		:   '.$fsbi_keyboard_nav.',
				min_height		:   '.$fsbi_min_height.',
				min_width		:   '.$fsbi_min_width.',
				pause_hover		:   '.$fsbi_pause_hover.',
				random			:   '.$fsbi_random.',
				slide_interval		:   '.$fsbi_slide_interval.',
				transition		:   "'.$fsbi_transition.'",
				transition_speed	:   '.$fsbi_transition_speed.',
				
				slide_links		:	"blank",
				slides 			:	[';

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