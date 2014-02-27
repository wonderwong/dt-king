<?php
function dt_f_photos_hide_mboxes( $hidden, $screen, $use_defaults ) {
    $template = dt_core_get_template_name();
    if( 'dt-photos-fullwidth.php' == $template || 'dt-photos-sidebar.php' == $template ) {
        $meta_boxes = dt_core_get_metabox_list();
        if( !empty($meta_boxes) ) {
            $hidden = array_unique( array_merge($hidden, $meta_boxes) );
             
            foreach( $hidden as $index=>$box ){
                if( 'dt_page_box-photos_albums' == $box ||
                    'dt_page_box-photos_options' == $box ||
                    'dt_page_box-footer_options' == $box ||
                    ('dt-photos-sidebar.php' == $template && 'dt_page_box-sidebar_options' == $box)
                ) {
                    unset( $hidden[$index] );
                }
            }
        }
    }
    return $hidden;
}
add_filter('hidden_meta_boxes', 'dt_f_photos_hide_mboxes', 99, 3);

?>
