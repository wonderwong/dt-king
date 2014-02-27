<?php
//Our hook
add_shortcode('call_to_action', 'dt_shortcode_call_to_action');

function dt_shortcode_call_to_action( $atts, $content = null ) {
    return '<div class="about">'.do_shortcode(trim($content)).'</div>'; 
}

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_call_to_action',
    'dt_call_to_action',
    false
);
?>
