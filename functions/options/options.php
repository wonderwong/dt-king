<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */
function optionsframework_option_name() {

    // This gets the theme name from the stylesheet (lowercase and without spaces)
    $wp_ver = explode('.', get_bloginfo('version'));
    $wp_ver = array_map( 'intval', $wp_ver );
    
    if( $wp_ver[0] < 3 || ( 3 == $wp_ver[0] && $wp_ver[1] <= 3 ) ) {
        $themename = get_theme_data(STYLESHEETPATH . '/style.css');
        $themename = $themename['Name'];
        
    }else {
        $themename = wp_get_theme();
        $themename = $themename->name;
    }

    $themename = preg_replace("/\W/", "", strtolower($themename) );
    
    $optionsframework_settings = get_option('optionsframework');
    $optionsframework_settings['id'] = $themename;
    update_option('optionsframework', $optionsframework_settings);

}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	$fl_arr = array(
        'repeat'    =>__( 'repeat', 'dt-options-repeat_select'),
		'repeat-x'  =>__( 'repeat-x', 'dt-options-repeat_select'),
		'repeat-y'  =>__( 'repeat-y', 'dt-options-repeat_select'),
		'no-repeat' =>__( 'no-repeat', 'dt-options-repeat_select'),
	);
	$repeat_x_arr = array(
        'no-repeat' =>__( 'no-repeat', 'dt-options-repeat_select'),
		'repeat-x'  =>__( 'repeat-x', 'dt-options-repeat_select')
	);
	$v_arr = array(
        'center'    =>__( 'center', 'dt-options-repeat_select'),
		'top'       =>__( 'top', 'dt-options-repeat_select'),
		'bottom'    =>__( 'bottom', 'dt-options-repeat_select'),
	);
	$h_arr = array(
        'center'    =>__( 'center', 'dt-options-repeat_select'),
		'left'      =>__( 'left', 'dt-options-repeat_select'),
		'right'     =>__( 'right', 'dt-options-repeat_select'),
	);
    $colour_arr = array(
        'blue'      => __( 'blue', 'dt-options-colour_select'),
        'green'     => __( 'green', 'dt-options-colour_select'),
        'orange'    => __( 'orange', 'dt-options-colour_select'),
        'purple'    => __( 'purple', 'dt-options-colour_select'),
        'yellow'    => __( 'yellow', 'dt-options-colour_select'),
        'pink'      => __( 'pink', 'dt-options-colour_select'),
        'white'     => __( 'white', 'dt-options-colour_select')
    );
    $footer_arr = array(
        'every'     =>__( 'on every page', 'dt-options-wf_select'),
        'home'      =>__( 'front page only', 'dt-options-wf_select'),
        'ex_home'   =>__( 'everywhere except front page', 'dt-options-wf_select'),
        'nowhere'   =>__( 'nowhere', 'dt-options-wf_select'),
    );
    $homepage_arr = array(
        'every'     =>__( 'everywhere', 'dt-options-wf_select'),
        'home'      =>__( 'only on homepage templates', 'dt-options-wf_select'),
        'ex_home'   =>__( 'everywhere except homepage templates', 'dt-options-wf_select'),
        'nowhere'   =>__( 'nowhere', 'dt-options-wf_select'),
    );
	$options = array();
    
    // always stay ontop
    include dirname(__FILE__) . '/options-presets.php';
    
    // submenu section
    include dirname(__FILE__) . '/options-mainpage.php';
//     include dirname(__FILE__) . '/options-backgrounds.php';
//     include dirname(__FILE__) . '/options-fonts.php';
    include dirname(__FILE__) . '/options-widgetareas.php';
//     include dirname(__FILE__) . '/options-socials.php';
//     include dirname(__FILE__) . '/../../plugins/captcha/options/options.php';
    
	return $options;
}
