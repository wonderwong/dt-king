<?php
add_shortcode('text_box', 'dt_shortcode_text_box');

function dt_shortcode_text_box($atts, $content = null) {
	extract(shortcode_atts(array(
		"title"     => '',
        "class"     => 'red'
	), $atts));
    
    if( $title ) {
        $title = '<div class="message-box-title">' . $title . '</div>';
    }
    return '<div class="message-box-wrapper ' . esc_attr($class) . '">' . $title . '<div class="message-box-content">' . do_shortcode(trim($content)) . '</div></div>';
}

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_text_box',
    'dt_text_box',
    false
);
?>
