<?php
//Our hook
add_shortcode('dt_divider', 'dt_shortcode_divider');

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_divider',
    'dt_divider',
    false
);
?>