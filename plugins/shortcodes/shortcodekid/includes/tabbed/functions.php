<?php
//Our hook
add_shortcode('tabbed', 'skshort_tabbed');
add_shortcode('tab', 'skshort_tabs');

//Our Funciton
function skshort_tabbed($atts, $content = null) {
    extract(shortcode_atts(array(
        'tabs'      => 'SKSnotabs'
    ), $atts));
    
    if($tabs == 'SKSnotabs') { return; }
    
    //starts our output
    $output = '<div class="tab">
        <ul class="nav-tab">';
        
    $myTabs = explode('|', $tabs);
    global $dt_shortcode_tabbed_counter;
    $dt_shortcode_tabbed_counter = count($myTabs);
    $i = 1;
    //displays our tabs
    foreach($myTabs as $tab) {
        $output .= '<li><a href="#tab'.$i++.'">'.$tab.'</a></li>';
    }
    
    //closes our tabs UL
    $output .= '</ul>';
    
    //returns
    return $output.'<div class="list-wrap">'.do_shortcode($content).'</div></div>';
    
}

//Our Funciton
function skshort_tabs($atts, $content = null) {
    static $i = 1;
    $output = '';
    global $dt_shortcode_tabbed_counter;
    if( empty($dt_shortcode_tabbed_counter) )
        return '';
    
    if( $i > $dt_shortcode_tabbed_counter )
        $i = 1;

    //returns
    return '<div class="tab'.$i.($i++!=1?' hide':'').'">'.force_balance_tags(do_shortcode('<p>'.$content.'</p>')).'</div>';
}

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_tabb',
    'tabbed',
    false
);
?>
