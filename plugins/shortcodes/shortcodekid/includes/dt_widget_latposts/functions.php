<?php
//Our hook
add_shortcode('dt_latest_posts', 'dt_print_widget_latposts');

// portfolio part
function dt_ajax_editor_widget_latposts() {
    $html = '';

    ob_start();

    // print select list
    ?>
    <fieldset style="padding-left: 15px;">
        <legend> Title: </legend>
        <input type="text" value="" name="dt_mce_window_widget_latposts_title" id="dt_mce_window_widget_latposts_title"/>
    </fieldset>
    
    <fieldset style="padding-left: 15px;" id="dt_mce_window_widget_latposts_align">
        <legend> Align: </legend>

        <label for="dt_mce_window_widget_latposts_a_left">Left</label>
        <input type="radio" value="left" name="dt_mce_window_widget_latposts_align" id="dt_mce_window_widget_latposts_a_left" checked="checked"/> &nbsp;&nbsp;
        
        <label for="dt_mce_window_widget_latposts_a_right">Right</label>
        <input type="radio" value="right" name="dt_mce_window_widget_latposts_align" id="dt_mce_window_widget_latposts_a_right"/>
    
    </fieldset>

    <?php
        
    $html .= ob_get_clean();
    
    add_filter( 'dt_admin_page_option_ppp-options', 'dt_shortcbuilder_photos_ppp_filter' );
    
    $html .= dt_admin_ppp_options(
        array(
            'options'           => array( 'ppp'   => 6 ),
            'box_name'          => 'dt_mce_window_widget_latposts'
        ),
        false
    );
        
	// generate the response
    $response = json_encode(
		array(
			'html_content'	=> $html
		)
	);

	// response output
    header( "Content-Type: application/json" );
    echo $response;

    // IMPORTANT: don't forget to "exit"
    exit;
}

add_action( 'wp_ajax_nopriv_dt_ajax_editor_widget_latposts', 'dt_ajax_editor_widget_latposts' );
add_action( 'wp_ajax_dt_ajax_editor_widget_latposts', 'dt_ajax_editor_widget_latposts' );

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_widget_latposts',
    'dt_widget_latposts',
    false
);

function dt_widget_latest_posts_images_filter( $shortcodes ) {
    global $ShortcodeKidPath;
    array_push(
        $shortcodes,
        array(
            'shortcode' => 'dt_latest_posts',
            'image'     => $ShortcodeKidPath . '/images/shortcodes/img_replace/posts.png',
            'command'   => 'dt_mce_command-widget_latposts'
        )    
    );
    return $shortcodes;
}
add_filter('jpb_visual_shortcodes', 'dt_widget_latest_posts_images_filter');
?>