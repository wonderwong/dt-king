<?php
//Our hook
add_shortcode('accordion', 'dt_shortcode_accordion');
add_shortcode('acc_item', 'dt_shortcode_accordion_item');

//Our Funciton
function dt_shortcode_accordion($atts, $content = null) {
    extract( shortcode_atts( array( "title" => '' ), $atts) );

    if( $title )
        $title = '<h2>' . esc_attr($title) . '</h2>';

    return $title.'<div class="basic list1b">'.do_shortcode($content).'</div>';
}

//Our Funciton
function dt_shortcode_accordion_item($atts, $content = null) {
    extract( shortcode_atts( array( "title" => '', 'selected' => false ), $atts) );
    
    if( $title )
        $title = '<a'.($selected?' class="selected"':'').'>' . $title . '</a>';

    $output = '';
    //returns
    return $output.'<div class="accord'.($selected?' selected':'').'">'.$title.'<div>'.force_balance_tags(do_shortcode('<p>'.$content.'</p>')).'</div></div>';
}

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_accordion',
    'accordion',
    false
);
?>
