<?php
//Our hook
add_shortcode('dt_contact', 'dt_print_widget_contact');

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_widget_contact',
    'dt_widget_contactform',
    false
);

function dt_contact_widget_images_filter( $shortcodes ) {
    global $ShortcodeKidPath;
    array_push(
        $shortcodes,
        array(
            'shortcode' => 'dt_contact',
            'image'     => $ShortcodeKidPath . '../images/space.png',
            'command'   => 'dt_mce_command-widget_contact'
        )    
    );
    return $shortcodes;
}
add_filter('jpb_visual_shortcodes', 'dt_contact_widget_images_filter');
?>
