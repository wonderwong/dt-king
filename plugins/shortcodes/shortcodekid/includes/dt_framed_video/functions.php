<?php
//Our hook
add_shortcode('framed_video', 'dt_shortcode_video');

function dt_shortcode_video($atts, $content = null) {
	extract(shortcode_atts(array(
        "column"    => 'half'
	), $atts)); 

    $sizes_full = array(
        'one-fourth'    => array( 202 ),
        'three-fourth'  => array( 702 ),
        'one-third'     => array( 286 ),
        'two-thirds'    => array( 620 ),
        'half'          => array( 452 ),
        'full-width'    => array( 952 )
    );

    $sizes = array(
        'one-fourth'    => array( 140 ),
        'three-fourth'  => array( 516 ),
        'one-third'     => array( 202 ),
        'two-thirds'    => array( 452 ),
        'half'          => array( 328 ),
        'full-width'    => array( 704 )
    );
    
    $video_width = null;

    if( !dt_storage('have_sidebar') && isset($sizes_full[$column]) )
        $video_width = current($sizes_full[$column]);
    elseif( dt_storage('have_sidebar') && isset($sizes[$column]) )
        $video_width = current($sizes[$column]);

    return '<div class="'.esc_attr($column).'"><div class="videos">'.dt_get_embed($content, $video_width, null, false).'</div></div>';
}

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_video',
    'dt_framed_video',
    false
);
?>
