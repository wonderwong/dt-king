<?php
//Our hook
add_shortcode('dt_portfolio', 'dt_print_widget_portfolio');

// portfolio part
function dt_ajax_editor_widget_portfolio() {
    $box_name = 'dt_portfolio_layout';
    
    $terms = get_categories(
        array(
            'type'                     => 'dt_portfolio',
            'hide_empty'               => 1,
            'hierarchical'             => 0,
            'taxonomy'                 => 'dt_portfolio_category',
            'pad_counts'               => false
        )
    );
    
    $html = '';

    ob_start();
    ?>

    <fieldset style="padding-left: 15px;">
        <legend> Title: </legend>
        <input type="text" value="" name="dt_mce_window_portfolio_title" id="dt_mce_window_portfolio_title">
    </fieldset>

    <?php
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
            'box_name'          => 'dt_mce_window_portfolio'
        ),
        false
    );
    
    $html .= dt_admin_order_options(
        array(
            'options'           => array(
                'orderby'   => 'date',
                'order'     => 'DESC'
            ),
            'box_name'          => 'dt_mce_window_portfolio',
            'before_element'    => '<fieldset style="padding-left: 15px;">',
            'after_element'     => '</fieldset>'
        ),
        false
    );

    ob_start();
    ?>

    <fieldset style="padding-left: 15px;">
        <legend> Autoslide: </legend>
        <input type="text" value="0" name="dt_mce_window_portfolio_autoslide" id="dt_mce_window_portfolio_autoslide">
    </fieldset>
    
    <fieldset style="padding-left: 15px;">
        <legend> Show Description: </legend>
        <label><input type="checkbox" value="1" name="dt_mce_window_portfolio_showdesc" id="dt_mce_window_portfolio_showdesc" checked="checked" /> show description</label>
    </fieldset>
    
    <fieldset style="padding-left: 15px;">
        <legend> Show Description: </legend>
        <label><input type="checkbox" value="1" name="dt_mce_window_portfolio_showdesc" id="dt_mce_window_portfolio_showdesc" checked="checked" /> show description</label>
    </fieldset>

    <fieldset style="padding-left: 15px;">
         <legend> Column: </legend>
         <select name="dt_mce_window_portfolio_column" id="dt_mce_window_portfolio_column">

         <?php
         $columns = array( 'one-fourth', 'three-forth', 'one-third', 'two-thirds', 'half', 'full-width' );
         foreach( $columns as $column ):
         ?>

         <option value="<?php echo $column; ?>"><?php echo $column; ?></option>

         <?php endforeach; ?>

         </select>
    </fieldset>

    <?php
    $html .= ob_get_clean();

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

add_action( 'wp_ajax_nopriv_dt_ajax_editor_widget_portfolio', 'dt_ajax_editor_widget_portfolio' );
add_action( 'wp_ajax_dt_ajax_editor_widget_portfolio', 'dt_ajax_editor_widget_portfolio' );

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_widget_portfolio',
    'dt_widget_portfolio',
    false
);

function dt_portfolio_widget_images_filter( $shortcodes ) {
    global $ShortcodeKidPath;
    array_push(
        $shortcodes,
        array(
            'shortcode' => 'dt_portfolio',
            'image'     => $ShortcodeKidPath . '/images/shortcodes/img_replace/question.png',
            'command'   => 'dt_mce_command-widget_portfolio'
        )    
    );
    return $shortcodes;
}
add_filter('jpb_visual_shortcodes', 'dt_portfolio_widget_images_filter');
?>
