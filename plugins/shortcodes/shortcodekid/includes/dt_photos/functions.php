<?php
//Our hook
add_shortcode('dt_photos', 'dt_shortcode_photos');

// portfolio part
function dt_ajax_editor_photos() {
    $box_name = 'dt_gallery_layout';
    
    $terms = get_categories(
        array(
            'type'                     => 'dt_gallery',
            'hide_empty'               => 1,
            'hierarchical'             => 0,
            'taxonomy'                 => 'dt_gallery_category',
            'pad_counts'               => false
        )
    );
    
    $html = '';

    ob_start();

    // print select list
    dt_admin_select_list(
        array(
            'rad_butt_name'     => 'show_type_gallery',
            'checkbox_name'     => 'show_gallery',
            'terms'             => &$terms,
            'con_class'         => 'dt_mce_gal_list',
            'before_element'    => '<fieldset style="padding-left: 15px;">',
            'after_element'     => '</fieldset>',
            'before_title'      => '<legend>',
            'after_title'       => '</legend>'
        )    
    );

    $html .= ob_get_clean();
    
    add_filter( 'dt_admin_page_option_ppp-options', 'dt_shortcbuilder_photos_ppp_filter' );
    add_filter( 'dt_admin_page_option_orderby-options', 'dt_shortcbuilder_photos_orderby_filter' );
    add_filter( 'dt_admin_page_option_order-options', 'dt_shortcbuilder_photos_order_filter' );
    
    $html .= dt_admin_ppp_options(
        array(
            'options'           => array( 'ppp'   => 6 ),
            'box_name'          => 'dt_mce_window_photos'
        ),
        false
    );
 
    $html .= dt_admin_order_options(
        array(
            'options'           => array(
                'orderby'   => 'date',
                'order'     => 'DESC'
            ),
            'box_name'          => 'dt_mce_window_photos',
            'before_element'    => '<fieldset style="padding-left: 15px;">',
            'after_element'     => '</fieldset>'
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

add_action( 'wp_ajax_nopriv_dt_ajax_editor_photos', 'dt_ajax_editor_photos' );
add_action( 'wp_ajax_dt_ajax_editor_photos', 'dt_ajax_editor_photos' );

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_photos',
    'dt_photos',
    false
);

function dt_photos_images_filter( $shortcodes ) {
    global $ShortcodeKidPath;
    array_push(
        $shortcodes,
        array(
            'shortcode' => 'dt_photos',
            'image'     => $ShortcodeKidPath . '/images/shortcodes/img_replace/photos.png',
            'command'   => 'dt_mce_command-photos'
        )    
    );
    return $shortcodes;
}
add_filter('jpb_visual_shortcodes', 'dt_photos_images_filter');
?>