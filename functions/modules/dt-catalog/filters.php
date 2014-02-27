<?php

// media uploader for catalog filter
function dt_f_catalog_mu($tabs) {
	if( 'dt_catalog' == get_post_type($_REQUEST['post_id']) ) {
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
    
		if( !isset($tabs['dt_catalog_media'])) {
			$tabs['dt_catalog_media'] = sprintf(__('Images (%s)'), "<span id='attachments-count'>$attachments</span>");
		}
        
        if( isset($tabs['type']) ) {
            $tabs['type'] = 'Upload';
        }
	}
	return $tabs;
}
add_filter('media_upload_tabs', 'dt_f_catalog_mu', 99 );

// fields filter for custom uploader
function dt_f_catalog_att_fields($fields, $post) {
	if( 'dt_catalog' == get_post_type($post->post_parent) ) {
        unset($fields['align']);
        unset($fields['image-size']);
        unset($fields['post_content']);
        unset($fields['image_alt']);
        unset($fields['url']);
        
        // video link
        $fields['dt_catalog_video_link']['input'] = 'text';
        $fields['dt_catalog_video_link']['value'] = get_post_meta( $post->ID, '_dt_catalog_video_link', true);
        $fields['dt_catalog_video_link']['label'] = _x('Video link', 'backend catalog uploader', LANGUAGE_ZONE );
        
	}
	return $fields;
}
add_filter('attachment_fields_to_edit', 'dt_f_catalog_att_fields', 99, 2);

// save custom fields
function dt_f_catalog_att_fields_save( $post, $attachment ) {
    // prevent loading gallery after save uploaded images
    if( 'dt_catalog' == get_post_type($_REQUEST['post_id']) ) {
        if( isset($_GET['tab']) && 'type' == $_GET['tab']) {
            unset($_POST['save']);
        }
    }
    
    if( isset($attachment['dt_catalog_video_link']) ){  
        update_post_meta($post['ID'], '_dt_catalog_video_link', esc_url($attachment['dt_catalog_video_link']));  
    }
    return $post;
}
add_filter('attachment_fields_to_save', 'dt_f_catalog_att_fields_save', 99, 2);

// remove send button in image show
function dt_f_catalog_med_item_buttons( $args ) {
	$current_post_id = !empty( $_GET['post_id'] ) ? (int) $_GET['post_id'] : 0;
    if( 'dt_catalog' == get_post_type($current_post_id) ) {
        $args['send'] = false;
    }

	return $args;
}
add_filter( 'get_media_item_args', 'dt_f_catalog_med_item_buttons', 10, 1 );

// add custon column 'dt_catalog_thumbs' in catalog list for thumbnails
function dt_f_catalog_col_thumb($defaults, $post_id){
    $head = array_slice( $defaults, 0, 1 );
    $tail = array_slice( $defaults, 1 );
    
    $head['dt_catalog_thumbs'] = _x('Thumbs', 'backend catalog', LANGUAGE_ZONE);
    
    $defaults = array_merge( $head, $tail );
    
    return $defaults;
}
add_filter('manage_edit-dt_catalog_columns', 'dt_f_catalog_col_thumb', 5);

// add custon column 'dt_catalog_cat' in catalog list for category
function dt_f_catalog_col_cat( $defaults ) {
    $defaults['dt_catalog_cat'] = __('Category', LANGUAGE_ZONE);

    return $defaults;
}
add_filter('manage_edit-dt_catalog_columns', 'dt_f_catalog_col_cat', 1);

function dt_f_catalog_hide_mboxes( $hidden, $screen, $use_defaults ) {
    $template = dt_core_get_template_name();
    if( 'dt-catalog.php' == $template ) {
        $meta_boxes = dt_core_get_metabox_list();
        if( !empty($meta_boxes) ) {
            $hidden = array_unique( array_merge($hidden, $meta_boxes) );
             
            foreach( $hidden as $index=>$box ) {
                if( 'dt_page_box-catalog_category' == $box ||
                    'dt_page_box-catalog_options' == $box ||
                    'dt_page_box-footer_options' == $box ||
                    'dt_page_box-sidebar_options' == $box ) {
                    unset( $hidden[$index] );
                }
            }
        }
    }
    return $hidden;
}
add_filter('hidden_meta_boxes', 'dt_f_catalog_hide_mboxes', 99, 3);

?>
