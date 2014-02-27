<?php
//Our hook
add_shortcode( 'dt_parallax_title', 'dt_home_title' );

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_tfmc',
    'dt_title_first_modern_char',
    false
);
?>