<?php
//Our hook
add_shortcode('dt_twitter', 'dt_print_widget_twitter');

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_widget_twitter',
    'dt_widget_twitter',
    false
);

function dt_widget_twitter_images_filter( $shortcodes ) {
    global $ShortcodeKidPath;
    array_push(
        $shortcodes,
        array(
            'shortcode' => 'dt_twitter',
            'image'     => $ShortcodeKidPath . '../images/space.png',
            'command'   => 'dt_mce_command-widget_twitter'
        )    
    );
    return $shortcodes;
}
add_filter('jpb_visual_shortcodes', 'dt_widget_twitter_images_filter');
?>
