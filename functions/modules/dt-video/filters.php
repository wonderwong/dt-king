<?php

// add custon column 'dt_video_thumbs' in video list for thumbnails
function dt_f_video_col_thumb($defaults, $post_id){
    $head = array_slice( $defaults, 0, 1 );
    $tail = array_slice( $defaults, 1 );
    
    $head['dt_video_thumbs'] = _x('Thumbs', 'backend video', LANGUAGE_ZONE);
    
    $defaults = array_merge( $head, $tail );
    
    return $defaults;
}
add_filter('manage_edit-dt_video_columns', 'dt_f_video_col_thumb', 5);

// add custon column 'dt_video_cat' in albums list for category
function dt_f_video_col_cat( $defaults ) {
    $defaults['dt_video_cat'] = _x('Category', 'backend video', LANGUAGE_ZONE);

    return $defaults;
}
add_filter('manage_edit-dt_video_columns', 'dt_f_video_col_cat', 1);

// remove send button in image show
function dt_f_video_med_item_buttons( $args ) {
    $current_post_id = !empty( $_GET['post_id'] ) ? (int) $_GET['post_id'] : 0;
    if( 'dt_video' == get_post_type($current_post_id) ) {
        $args['send'] = true;
    }

    return $args;
}
add_filter( 'get_media_item_args', 'dt_f_video_med_item_buttons', 99, 1 );

function dt_f_video_hide_mboxes( $hidden, $screen, $use_defaults ) {
    $template = dt_core_get_template_name();
    if( 'dt-videogal-fullwidth.php' == $template || 'dt-videogal-sidebar.php' == $template ) {
        $meta_boxes = dt_core_get_metabox_list();
        if( !empty($meta_boxes) ) {
            $hidden = array_unique( array_merge($hidden, $meta_boxes) );
             
            foreach( $hidden as $index=>$box ){
                if( 'dt_page_box-video_category' == $box ||
                    'dt_page_box-video_options' == $box ||
                    'dt_page_box-footer_options' == $box ||
                    ('dt-videogal-sidebar.php' == $template && 'dt_page_box-sidebar_options' == $box)
                ) {
                    unset( $hidden[$index] );
                }
            }
        }
    }
    return $hidden;
}
add_filter('hidden_meta_boxes', 'dt_f_video_hide_mboxes', 99, 3);

?>
