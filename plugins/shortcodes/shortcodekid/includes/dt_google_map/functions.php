<?php
//Our hook
add_shortcode('google_map', 'dt_shortcode_google_map');

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_google_map',
    'dt_google_map',
    false
);
?>
