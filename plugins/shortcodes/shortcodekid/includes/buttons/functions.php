<?php
//Our hook
add_shortcode('button_icon', 'dt_button_icon');

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_buttons',
    'buttons',
    false
);
?>