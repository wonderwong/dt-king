<?php
//Our hook
add_shortcode('toggle', 'toggle');

function toggle($atts, $content = null) {
	extract(shortcode_atts(array(
        "title"     => ''
	), $atts)); 
    return '<div class="toggle"><a href="#" class="question"><i class="q_a"></i><strong>'.$title.'</strong></a><div class="answer" style="display: none;">'.do_shortcode(trim($content)).'</div></div>';
}

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_toggle',
    'toggle',
    false
);
?>
