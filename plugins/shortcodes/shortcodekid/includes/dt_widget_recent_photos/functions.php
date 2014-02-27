<?php
//Our hook
add_shortcode('dt_recent_photos', 'dt_print_widget_recent_photos');

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_widget_recent_photos',
    'dt_widget_recent_photos',
    false
);

function dt_widget_recent_photos_images_filter( $shortcodes ) {
    global $ShortcodeKidPath;
    array_push(
        $shortcodes,
        array(
            'shortcode' => 'dt_recent_photos',
            'image'     => $ShortcodeKidPath . '../images/space.png',
            'command'   => 'dt_mce_command-widget_recent_photos'
        )    
    );
    return $shortcodes;
}
add_filter('jpb_visual_shortcodes', 'dt_widget_recent_photos_images_filter');
?>
