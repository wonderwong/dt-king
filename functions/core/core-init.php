<?php

// include config file
require_once 'core-config.php';

require_once 'core-filters.php';
require_once 'core-actions.php';

// include core functions
require_once 'core-functions.php';

// include metabox functions
require_once 'includes/metabox-functions.php';
require_once 'includes/core-metaboxes.php';

// include menu functions
require_once 'menu/core-menu.php';

require_once 'includes/lib.php';

// set content width
if ( !isset( $content_width ) ) {
    $content_width = 630;
}

// add modules
include_files_in_dir("/../modules/", false, 'init.php');

/* Set up theme defaults and registers support for various WordPress features. */
if ( !function_exists( 'dt_init' ) ){

	function dt_init() {

		// for translate purpose
		if( function_exists( 'load_theme_textdomain' ) ){
			load_theme_textdomain( LANGUAGE_ZONE, get_template_directory(). '/languages' );
		}
        
		/* menu slot */
		register_nav_menu( 'primary-menu', __( 'Primary Menu', LANGUAGE_ZONE ) );
		//add_theme_support( 'post-formats', $dt_post_formats );

		if ( function_exists( 'add_theme_support' ) ) { 

			/* add theme support images */
			add_theme_support( 'post-thumbnails' );

			/* add automatic feeds support */
			add_theme_support( 'automatic-feed-links' );

		}

		if( function_exists( 'add_editor_style' ) ) {
            add_editor_style();
        }
        
		// Include functions/*.php
//		include_files_in_dir("/functions/");

		// Include plugins/*/*.php
		include_files_in_dir("/../../plugins/", false);
//		include_files_in_dir("/plugins/options-framework/", true);
//		include_files_in_dir("/plugins/shortcodekid/", true);
//		include_files_in_dir("/plugins/visual-shortcodes/", true);

        // add dynamic widgetized areas
        include_once dirname(__FILE__) . '/setup/setup-widgets.php';
        
		include_once dirname(__FILE__) . '/setup/setup-scripts.php';
        include_once dirname(__FILE__) . '/setup/setup-styles.php';
        
		//remove in production , for demo stand only!!!
		if( function_exists( 'optionsframework_dt_presets' ) ){
			optionsframework_dt_presets();
		}

	}

	//add_action( 'init', 'dt_init' );
	add_action( 'after_setup_theme', 'dt_init' );
}

?>
