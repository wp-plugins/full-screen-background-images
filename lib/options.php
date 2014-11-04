<?php
add_action( 'admin_menu', 'fsbi_add_admin_menu' );
add_action( 'admin_init', 'fsbi_settings_init' );


function fsbi_add_admin_menu(  ) { 

	add_submenu_page( 'edit.php?post_type=cpt_background', 'Options', 'Options', 'manage_options', 'options', 'fsbi_options_page' );

}


function fsbi_settings_exist(  ) { 

	if( false == get_option( 'fsbi_settings' ) ) { 

		add_option( 'fsbi_settings' );

	}

}


function fsbi_settings_init(  ) { 

	register_setting( 'fsbi_options_page', 'fsbi_settings' );
	
	add_settings_section(
		'fsbi_options_section', 
		__( 'Options', 'fsbi' ), 
		'fsbi_options_section_callback', 
		'fsbi_options_page'
	);

	add_settings_field( 
		'fsbi_autoplay', 
		__( 'Autoplay', 'fsbi' ), 
		'fsbi_autoplay_render', 
		'fsbi_options_page', 
		'fsbi_options_section' 
	);
	
	add_settings_field( 
		'fsbi_fit_always', 
		__( 'Fit always', 'fsbi' ), 
		'fsbi_fit_always_render', 
		'fsbi_options_page', 
		'fsbi_options_section' 
	);
	
	add_settings_field( 
		'fsbi_horizontal_center', 
		__( 'Horizontal center', 'fsbi' ), 
		'fsbi_horizontal_center_render', 
		'fsbi_options_page', 
		'fsbi_options_section' 
	);
	
	add_settings_field( 
		'fsbi_vertical_center', 
		__( 'Vertical center', 'fsbi' ), 
		'fsbi_vertical_center_render', 
		'fsbi_options_page', 
		'fsbi_options_section' 
	);
	
	add_settings_field( 
		'fsbi_keyboard_nav', 
		__( 'Keyboard Navigation', 'fsbi' ), 
		'fsbi_keyboard_nav_render', 
		'fsbi_options_page', 
		'fsbi_options_section' 
	);
	
	add_settings_field( 
		'fsbi_min_width', 
		__( 'Min Width', 'fsbi' ), 
		'fsbi_min_width_render', 
		'fsbi_options_page', 
		'fsbi_options_section' 
	);
	
	add_settings_field( 
		'fsbi_min_height', 
		__( 'Min Height', 'fsbi' ), 
		'fsbi_min_height_render', 
		'fsbi_options_page', 
		'fsbi_options_section' 
	);
	
	add_settings_field( 
		'fsbi_pause_hover', 
		__( 'Pause on Hover', 'fsbi' ), 
		'fsbi_pause_hover_render', 
		'fsbi_options_page', 
		'fsbi_options_section' 
	);
	
	add_settings_field( 
		'fsbi_random', 
		__( 'Random Slides', 'fsbi' ), 
		'fsbi_random_render', 
		'fsbi_options_page', 
		'fsbi_options_section' 
	);

	add_settings_field( 
		'fsbi_slide_interval', 
		__( 'Slides Interval', 'fsbi' ), 
		'fsbi_slide_interval_render', 
		'fsbi_options_page', 
		'fsbi_options_section' 
	);
	
	add_settings_field( 
		'fsbi_transition', 
		__( 'Transition Slides', 'fsbi' ), 
		'fsbi_transition_render', 
		'fsbi_options_page', 
		'fsbi_options_section' 
	);
	
	add_settings_field( 
		'fsbi_transition_speed', 
		__( 'Transition Speed', 'fsbi' ), 
		'fsbi_transition_speed_render', 
		'fsbi_options_page', 
		'fsbi_options_section' 
	);

}

function fsbi_autoplay_render(  ) { 

	$options = get_option( 'fsbi_settings' );
	?>
	<select name='fsbi_settings[autoplay]'>
        <option value='1' <?php selected( $options['autoplay'], '1' ); ?>><?php _e('Yes', 'fsbi'); ?></option>
        <option value='0' <?php selected( $options['autoplay'], '0' ); ?>><?php _e('No', 'fsbi'); ?></option>
    </select>
	<?php
	echo '<span style="font-size:11px;font-style:italic;">'.__('Determines whether slideshow begins playing when page is loaded.' , 'fsbi').'</span>';

}

function fsbi_fit_always_render(  ) { 

	$options = get_option( 'fsbi_settings' );
	?>
	<select name='fsbi_settings[fit_always]'>
		<option value='1' <?php selected( $options['fit_always'], '1' ); ?>><?php _e('Yes', 'fsbi'); ?></option>
		<option value='0' <?php selected( $options['fit_always'], '0' ); ?>><?php _e('No', 'fsbi'); ?></option>
	</select>
	<?php
	echo '<span style="font-size:11px;font-style:italic;">'.__('Prevents the image from ever being cropped. Ignores minimum width and height.' , 'fsbi').'</span>';

}

function fsbi_horizontal_center_render(  ) { 

	$options = get_option( 'fsbi_settings' );
	?>
	<select name='fsbi_settings[horizontal_center]'>
		<option value='1' <?php selected( $options['horizontal_center'], '1' ); ?>><?php _e('Yes', 'fsbi'); ?></option>
		<option value='0' <?php selected( $options['horizontal_center'], '0' ); ?>><?php _e('No', 'fsbi'); ?></option>
	</select>
	<?php
	echo '<span style="font-size:11px;font-style:italic;">'.__('Centers image horizontally. When turned off, the images resize/display from the left of the page.' , 'fsbi').'</span>';

}

function fsbi_vertical_center_render(  ) { 

	$options = get_option( 'fsbi_settings' );
	?>
	<select name='fsbi_settings[vertical_center]'>
		<option value='1' <?php selected( $options['vertical_center'], '1' ); ?>><?php _e('Yes', 'fsbi'); ?></option>
		<option value='0' <?php selected( $options['vertical_center'], '0' ); ?>><?php _e('No', 'fsbi'); ?></option>
	</select>
	<?php
	echo '<span style="font-size:11px;font-style:italic;">'.__('Centers image vertically. When turned off, the images resize/display from the top of the page.' , 'fsbi').'</span>';

}

function fsbi_keyboard_nav_render(  ) { 

	$options = get_option( 'fsbi_settings' );
	?>
	<select name='fsbi_settings[keyboard_nav]'>
		<option value='1' <?php selected( $options['keyboard_nav'], '1' ); ?>><?php _e('Yes', 'fsbi'); ?></option>
		<option value='0' <?php selected( $options['keyboard_nav'], '0' ); ?>><?php _e('No', 'fsbi'); ?></option>
	</select>
	<?php
	echo '<span style="font-size:11px;font-style:italic;">'.__('Allows control via keyboard (Spacebar: Pause or play - Right or Up Arrow: Next slide - Left or Down Arrow: Previous slide).' , 'fsbi').'</span>';

}

function fsbi_min_width_render(  ) { 

	$options = get_option( 'fsbi_settings' );
	?>
	<input type='text' name='fsbi_settings[min_width]' value='<?php echo $options['min_width']; ?>'>
	<?php
	echo '<span style="font-size:11px;font-style:italic;">'.__('Minimum width the image is allowed to be. If it is met, the image won\'t size down any further.' , 'fsbi').'</span>';
}

function fsbi_min_height_render(  ) { 

	$options = get_option( 'fsbi_settings' );
	?>
	<input type='text' name='fsbi_settings[min_height]' value='<?php echo $options['min_height']; ?>'>
	<?php
	echo '<span style="font-size:11px;font-style:italic;">'.__('Minimum height the image is allowed to be. If it is met, the image won\'t size down any further.' , 'fsbi').'</span>';
}

function fsbi_pause_hover_render(  ) { 

	$options = get_option( 'fsbi_settings' );
	?>
	<select name='fsbi_settings[pause_hover]'>
		<option value='1' <?php selected( $options['pause_hover'], '1' ); ?>><?php _e('Yes', 'fsbi'); ?></option>
		<option value='0' <?php selected( $options['pause_hover'], '0' ); ?>><?php _e('No', 'fsbi'); ?></option>
	</select>
	<?php
	echo '<span style="font-size:11px;font-style:italic;">'.__('Pauses slideshow while current image hovered over.' , 'fsbi').'</span>';

}

function fsbi_random_render(  ) { 

	$options = get_option( 'fsbi_settings' );
	?>
	<select name='fsbi_settings[random]'>
		<option value='1' <?php selected( $options['random'], '1' ); ?>><?php _e('Yes', 'fsbi'); ?></option>
		<option value='0' <?php selected( $options['random'], '0' ); ?>><?php _e('No', 'fsbi'); ?></option>
	</select>
	<?php
	echo '<span style="font-size:11px;font-style:italic;">'.__('Slides are shown in a random order. start_slide is disregarded.' , 'fsbi').'</span>';

}


function fsbi_slide_interval_render(  ) { 

	$options = get_option( 'fsbi_settings' );
	?>
	<input type='text' name='fsbi_settings[slide_interval]' value='<?php echo $options['slide_interval']; ?>'>
	<?php
	echo '<span style="font-size:11px;font-style:italic;">'.__('Time between slide changes in milliseconds.' , 'fsbi').'</span>';
}

function fsbi_transition_render(  ) { 

	$options = get_option( 'fsbi_settings' );
	?>
	<select name='fsbi_settings[transition]'>
		<option value='none' <?php selected( $options['transition'], 'none' ); ?>><?php _e('No transition effect', 'fsbi'); ?></option>
		<option value='fade' <?php selected( $options['transition'], 'fade' ); ?>><?php _e('Fade effect ', 'fsbi'); ?></option>
		<option value='slideTop' <?php selected( $options['transition'], 'slideTop' ); ?>><?php _e('Slide in from top', 'fsbi'); ?></option>
		<option value='slideRight' <?php selected( $options['transition'], 'slideRight' ); ?>><?php _e('Slide in from right', 'fsbi'); ?></option>
		<option value='slideBottom' <?php selected( $options['transition'], 'slideBottom' ); ?>><?php _e('Slide in from bottom', 'fsbi'); ?></option>
		<option value='slideLeft' <?php selected( $options['transition'], 'slideLeft' ); ?>><?php _e('Slide in from left', 'fsbi'); ?></option>
		<option value='carouselRight' <?php selected( $options['transition'], 'carouselRight' ); ?>><?php _e('Carousel from right to left', 'fsbi'); ?></option>
		<option value='carouselLeft' <?php selected( $options['transition'], 'carouselLeft' ); ?>><?php _e('Carousel from left to right', 'fsbi'); ?></option>
	</select>
	<?php
	echo '<span style="font-size:11px;font-style:italic;">'.__('Controls which effect is used to transition between slides.' , 'fsbi').'</span>';

}

function fsbi_transition_speed_render(  ) { 

	$options = get_option( 'fsbi_settings' );
	?>
	<input type='text' name='fsbi_settings[transition_speed]' value='<?php echo $options['transition_speed']; ?>'>
	<?php
	echo '<span style="font-size:11px;font-style:italic;">'.__('Speed of transitions in milliseconds.' , 'fsbi').'</span>';
}


function fsbi_options_section_callback(  ) { 

	echo __( 'This section contains options for setting up Full Screen Background Images plugin', 'fsbi' );

}


function fsbi_options_page(  ) { 

	?>
	<form action='options.php' method='post'>
		
		<h2><?php echo __( 'Full Screen Background Images', 'fsbi' ); ?></h2>
		
		<?php
		settings_fields( 'fsbi_options_page' );
		do_settings_sections( 'fsbi_options_page' );
		submit_button();
		?>
		
	</form>
	<?php

}

?>