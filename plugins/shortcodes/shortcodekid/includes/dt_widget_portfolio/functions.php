<?php
//Our hook
add_shortcode('dt_portfolio', 'dt_print_widget_portfolio');

function dt_print_widget_portfolio( $atts ) {
    extract(
        shortcode_atts(
            array(
                'title'     => '',
                'order'     => 'DESC',
                'orderby'   => 'date',
                'ppp'       => 6,
                'lines'     => 1,
                'except'    => '',
                'only'      => '',
                'autoslide' => '',
                'showdesc'  => '1',
                'column'    => 'half'
            ),
            $atts
        )
    );
    
    $img_sizes_full = array(
        'one-fourth'    => array( 202, 100 ),
        'three-fourth'  => array( 216, 122 ),
        'one-third'     => array( 282, 170 ),
        'two-thirds'    => array( 296, 170 ),
        'half'          => array( 212, 122 ),
        'full-width'    => array( 217, 122 )
    );

    $img_sizes = array(
        'one-fourth'    => array( 140, 100 ),
        'three-fourth'  => array( 153, 100 ),
        'one-third'     => array( 202, 120 ),
        'two-thirds'    => array( 212, 120 ),
        'half'          => array( 150, 100 ),
        'full-width'    => array( 155, 100 )
    );
    
    $args = array(
        'before_widget' => '<div class="' . esc_attr($column) .'">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
        'lines'         => intval($lines)
    );

    if( dt_storage('have_sidebar') ) {
        if( isset($img_sizes[$column]) )
            $args['img_size'] = $img_sizes[$column];
    }else {
        if( isset($img_sizes_full[$column]) ) 
            $args['img_size'] = $img_sizes_full[$column];
    }
    
    $select = 'all';
    $cats =  array();
    
    if( $except ) {
        $select = 'except';
        $cats = array_map('trim', explode(',', $except));
    }

    if( $only ) {
        $select = 'only';
        $cats = array_map('trim', explode(',', $only));
    }

    ob_start();
    
    $params = array( 
        "title"     => $title,
        "show"      => intval($ppp),
        "order"     => strip_tags($order),
        "orderby"   => strip_tags($orderby),
        "autoslide" => abs($autoslide*1),
        "desc"      => (bool) $showdesc,
        "select"    => strip_tags($select)
    );

    if( $cats )
        $params['cats'] = $cats;

    the_widget( 'DT_portfolio_Widget', $params, $args );

    $output = ob_get_clean();
    return $output;
}

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
		<em>milliseconds (1 second = 1000 milliseconds; to disable autoslide leave this field blank or set it to "0")</em>
    </fieldset>
    
    <fieldset style="padding-left: 15px;">
        <legend> Show Description: </legend>
        <label><input type="checkbox" value="1" name="dt_mce_window_portfolio_showdesc" id="dt_mce_window_portfolio_showdesc" checked="checked" /> show description</label>
    </fieldset>
    
    <fieldset style="padding-left: 15px;">
        <legend> Lines: </legend>
        <select name="dt_mce_window_portfolio_lines" id="dt_mce_window_portfolio_lines">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
    </fieldset>

    <fieldset style="padding-left: 15px;">
         <legend> Column: </legend>
         <select name="dt_mce_window_portfolio_column" id="dt_mce_window_portfolio_column">

         <?php
         $columns = array( 'one-fourth', 'three-fourth', 'one-third', 'two-thirds', 'half', 'full-width' );
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
            'image'     => $ShortcodeKidPath . '../images/space.png',
            'command'   => 'dt_mce_command-widget_portfolio'
        )    
    );
    return $shortcodes;
}
add_filter('jpb_visual_shortcodes', 'dt_portfolio_widget_images_filter');
?>
