<?php
add_shortcode('tooltip', 'tooltip');

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_tooltips',
    'tooltips',
    false
);
?>