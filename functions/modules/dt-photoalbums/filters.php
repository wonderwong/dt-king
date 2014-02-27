<?php

// media uploader for gallery filter
function dt_f_album_mu($tabs) {
	if( 'dt_gallery' == get_post_type($_REQUEST['post_id']) ) {
		global $wpdb;
        
        if( isset($tabs['library']) ) {
			unset($tabs['library']);
		}
		
        if( isset($tabs['gallery']) ) {
			unset($tabs['gallery']);
		}
        
        if( isset($tabs['type_url']) ) {
			unset($tabs['type_url']);
		}
        
        $post_id = intval($_REQUEST['post_id']);
  
        if ( $post_id ) {
            $attachments = intval( $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM $wpdb->posts WHERE post_type = 'attachment' AND post_status != 'trash' AND post_parent = %d", $post_id ) ) );
        }
        
        if ( empty($attachments) ) {
            unset($tabs['gallery']);
            return $tabs;
        }
    
		if( !isset($tabs['dt_gallery_media'])) {
			$tabs['dt_gallery_media'] = sprintf(__('Images (%s)'), "<span id='attachments-count'>$attachments</span>");
		}
        
        if( isset($tabs['type']) ) {
            $tabs['type'] = 'Upload';
        }
	}
	return $tabs;
}
add_filter('media_upload_tabs', 'dt_f_album_mu', 99 );

// filter prevent loading gallery after save uploaded images
function dt_f_album_aftos( $post, $attachments ) {
    if( 'dt_gallery' == get_post_type($_REQUEST['post_id']) ) {
        if( isset($_GET['tab']) && 'type' == $_GET['tab']) {
            unset($_POST['save']);
        }
    }
    return $post;
}
add_filter( 'attachment_fields_to_save', 'dt_f_album_aftos', 99, 2 );

// fields filter for custom uploader
function dt_f_album_att_fields($fields, $post) {
	if( 'dt_gallery' == get_post_type($post->post_parent) ) {
        unset($fields['align']);
        unset($fields['image-size']);
        unset($fields['post_content']);
        unset($fields['image_alt']);
        unset($fields['url']);
	}
	return $fields;
}
add_filter('attachment_fields_to_edit', 'dt_f_album_att_fields', 99, 2);

// add custon column 'dt_album_thumbs' in albums list for thumbnails
function dt_f_album_col_thumb($defaults, $post_id){
    $head = array_slice( $defaults, 0, 1 );
    $tail = array_slice( $defaults, 1 );
    
    $head['dt_album_thumbs'] = _x('Thumbs', 'backend albums', LANGUAGE_ZONE);
    
    $defaults = array_merge( $head, $tail );
//    $defaults['dt_album_thumbs'] = __('Thumbs', LANGUAGE_ZONE);
    
    return $defaults;
}
add_filter('manage_edit-dt_gallery_columns', 'dt_f_album_col_thumb', 5);

// add custon column 'dt_album_cat' in albums list for category
function dt_f_album_col_cat( $defaults ) {
    $defaults['dt_album_cat'] = __('Category', LANGUAGE_ZONE);

    return $defaults;
}
add_filter('manage_edit-dt_gallery_columns', 'dt_f_album_col_cat', 1);

function dt_f_album_hide_mboxes( $hidden, $screen, $use_defaults ) {
    $template = dt_core_get_template_name();
    if( 'dt-albums-fullwidth.php' == $template || 'dt-albums-sidebar.php' == $template ) {
        $meta_boxes = dt_core_get_metabox_list();
        if( !empty($meta_boxes) ) {
            $hidden = array_unique( array_merge($hidden, $meta_boxes) );
             
            foreach( $hidden as $index=>$box ){
                if( 'dt_page_box-albums_list' == $box ||
                    'dt_page_box-albums_options' == $box ||
                    'dt_page_box-footer_options' == $box ||
                    ('dt-albums-sidebar.php' == $template && 'dt_page_box-sidebar_options' == $box)
                ) {
                    unset( $hidden[$index] );
                }
            }
        }
    }
    return $hidden;
}
add_filter('hidden_meta_boxes', 'dt_f_album_hide_mboxes', 99, 3);

?>
