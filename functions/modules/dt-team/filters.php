<?php
// add custon column 'dt_team_thumbs' in team list for thumbnails
function dt_f_team_col_thumb($defaults, $post_id){
    $head = array_slice( $defaults, 0, 1 );
    $tail = array_slice( $defaults, 1 );
    
    $head['dt_team_thumbs'] = _x('Thumbs', 'backend team', LANGUAGE_ZONE);
    
    $defaults = array_merge( $head, $tail );
    
    return $defaults;
}
add_filter('manage_edit-dt_team_columns', 'dt_f_team_col_thumb', 5);

// add custon column 'dt_team_cat' in team list for category
function dt_f_team_col_cat( $defaults ) {
    $defaults['dt_team_cat'] = __('Category', LANGUAGE_ZONE);

    return $defaults;
}
add_filter('manage_edit-dt_team_columns', 'dt_f_team_col_cat', 1);

// fields filter for custom uploader
function dt_f_team_att_fields($fields, $post) {
	if( 'dt_team' == get_post_type($post->post_parent) ) {
        unset($fields['align']);
        unset($fields['image-size']);
        unset($fields['post_content']);
        unset($fields['image_alt']);
        unset($fields['url']);
	}
	return $fields;
}
add_filter('attachment_fields_to_edit', 'dt_f_team_att_fields', 99, 2);

?>
