<?php
// add custon column 'dt_logos_thumbs' in logos list for thumbnails
function dt_f_logos_col_thumb($defaults, $post_id){
    $head = array_slice( $defaults, 0, 1 );
    $tail = array_slice( $defaults, 1 );
    
    $head['dt_logos_thumbs'] = _x('Thumbs', 'backend logos', LANGUAGE_ZONE);
    
    $defaults = array_merge( $head, $tail );
    
    return $defaults;
}
add_filter('manage_edit-dt_logos_columns', 'dt_f_logos_col_thumb', 5);

// add custon column 'dt_logos_cat' in logos list for category
function dt_f_logos_col_cat( $defaults ) {
    $defaults['dt_logos_cat'] = __('Category', LANGUAGE_ZONE);

    return $defaults;
}
add_filter('manage_edit-dt_logos_columns', 'dt_f_logos_col_cat', 1);

// fields filter for custom uploader
function dt_f_logos_att_fields($fields, $post) {
	if( 'dt_logos' == get_post_type($post->post_parent) ) {
        unset($fields['align']);
        unset($fields['image-size']);
        unset($fields['post_content']);
        unset($fields['image_alt']);
        unset($fields['url']);
	}
	return $fields;
}
add_filter('attachment_fields_to_edit', 'dt_f_logos_att_fields', 99, 2);

?>
