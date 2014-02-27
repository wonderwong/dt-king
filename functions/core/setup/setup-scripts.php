<?php
function dt_core_setup_scripts(){
	
/*    $colour = of_get_option( 'misc_colour_schema_select', 'pink' );
	
    // jQuery
	wp_deregister_script('jquery');
	wp_register_script(
        'jquery',
        'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js',
        array(),
        '1.7.1'
    );
	wp_enqueue_script('jquery');
			
	// register scripts
	wp_register_script(
        'cufon-yui',
        get_template_directory_uri().'/js/cufon-yui.js',
        array('jquery')
    );
    
	wp_register_script(
        'cufon-color-' . $colour,
        get_template_directory_uri().'/js/cufon-color-' . $colour . '.js',
        array('jquery', 'cufon-yui')
    );
    
	wp_register_script(
        'enigmatic',
        get_template_directory_uri().'/js/enigmatic.js',
        array('jquery', 'cufon-yui')
    );
    
	wp_register_script(
        'jquery-placeholder',
        get_template_directory_uri().'/js/plugins/placeholder/jquery.placeholder.js',
        array('jquery')
    );
    
	wp_register_script(
        'jquery-validationEngine',
        get_template_directory_uri().'/js/plugins/validator/jquery.validationEngine.js',
        array('jquery')
    );
    
    wp_register_script(
        'dt_highslide-full',
        get_template_directory_uri().'/js/plugins/highslide/highslide-full.packed.js',
        array(),
        '4.1.13'
    );
    
	wp_register_script(
        'z.trans',
        get_template_directory_uri().'/js/plugins/validator/z.trans.en.js',
        array('jquery', 'jquery-validationEngine')
    );
    
	wp_register_script(
        'jquery-easing',
        get_template_directory_uri().'/js/jquery.easing.1.3.js',
        array('jquery'),
        '1.3'
    );
    
	wp_register_script(
        'dt_slider',
        get_template_directory_uri().'/js/slider.js',
        array('jquery')
    );
    
    wp_register_script(
        'dt_shortcodes',
        get_template_directory_uri().'/js/shortcodes.js',
        array('jquery')
    );
	
    wp_register_script(
        'dt_jq_vt',
        get_template_directory_uri().'/js/jq_vt.js',
        array('jquery')
    );
    
    wp_register_script(
        'dt_jq_dbtap',
        get_template_directory_uri().'/js/jquery.doubletap.js',
        array('jquery')
    );
    
    wp_register_script(
        'dt_ajaxing',
        get_template_directory_uri().'/js/dt_ajaxing.js',
        array()
    );
    
    wp_register_script(
        'dt_preloader',
        get_template_directory_uri().'/js/preloader.js',
        array()
    );
    
    wp_register_script(
        'dt_img_loaded',
        get_template_directory_uri().'/js/plugins/image-loaded/jquery.image-loaded.js',
        array('jquery')
    );
    
    wp_register_script(
        'jquery-aw_showcase',
        get_template_directory_uri().'/js/jquery.aw-showcase.js',
        array('jquery')
    );
    
	// enqueue scripts
			
	// cufon fonts
	wp_enqueue_script( 'cufon-yui' );
	// plase for cufon scripts
	if( of_get_option('fonts_enable_cufon_checkbox', true) ){
		// get font selected in selec
		$font_select = of_get_option( 'fonts_select' );
		// if custom upload checked
		if( of_get_option( 'fonts_enable_custom_checkbox', false ) ){
			// get font from uploder
			$font_upload = of_get_option( 'fonts_custom_uploader' );
			// if font from uploader exists and hafe .js in its path
			if( $font_upload && strpos($font_upload, '.js') ){
				// add upladed font
				wp_enqueue_script( 'cufon-font', $font_upload );
			}else{
				// add font from select
				wp_enqueue_script( 'cufon-font', $font_select );
			}
		}else{
			// add font from select
			wp_enqueue_script( 'cufon-font', $font_select );
		}
	}
*/
}
	
add_action('wp_enqueue_scripts', 'dt_core_setup_scripts');

function dt_core_admin_setup_scripts() {
	// this script show/hide metaboxes for each page layout, enqueue it in footer
	wp_enqueue_script('dt_core_admin-mbox_switcher', get_template_directory_uri().'/js/admin/admin_mbox_switcher.js', array('jquery'), false, true);
	
	// add some magick for our metaboxes
	wp_enqueue_script('dt_core_admin-mbox_magick', get_template_directory_uri().'/js/admin/admin_mbox_magick.js', array('jquery'), false, true);
}
add_action('admin_enqueue_scripts', 'dt_core_admin_setup_scripts');