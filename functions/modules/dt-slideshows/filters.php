<?php

// media uploader for gallery filter
function dt_f_slider_mu($tabs) {
	if( 'dt_slider' == get_post_type($_REQUEST['post_id']) ) {
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
    
		if( !isset($tabs['dt_slider_media'] )) {
			$tabs['dt_slider_media'] = sprintf(__('Slides (%s)'), "<span id='attachments-count'>$attachments</span>");
		}
        
        if( isset($tabs['type']) ) {
            $tabs['type'] = 'Upload';
        }
	}
	return $tabs;
}
add_filter('media_upload_tabs', 'dt_f_slider_mu', 99 );

// fields filter for custom uploader
function dt_f_slider_att_fields($fields, $post) {
	if( 'dt_slider' == get_post_type($post->post_parent) ) {
        
        unset($fields['align']);
        unset($fields['image-size']);
        unset($fields['post_content']);
        unset($fields['image_alt']);
        unset($fields['url']);
        
        // link field
        $fields["dt_slider_link"]["label"] = _x("Link", 'backend slider', LANGUAGE_ZONE);
        $fields["dt_slider_link"]["input"] = "text";
        $fields["dt_slider_link"]['value'] = get_post_meta($post->ID, "_dt_slider_link", true);
        
        // hide slide description field
        $fields["dt_slider_hdesc"]["label"] = '';
        $fields["dt_slider_hdesc"]["input"] = "html";
        $fields["dt_slider_hdesc"]["html"] = "<input type='checkbox' value='1'
            name='attachments[{$post->ID}][dt_slider_hdesc]'
            id='attachments[{$post->ID}][dt_slider_hdesc]'" . checked(get_post_meta($post->ID, "_dt_slider_hdesc", true), true, false ). "/> " . _x('Hide slide description', 'backend slider', LANGUAGE_ZONE);
        
        // open link in new window
        $fields["dt_slider_newwin"]["label"] = '';
        $fields["dt_slider_newwin"]["input"] = "html";
        $fields["dt_slider_newwin"]["html"] = "<input type='checkbox' value='1'
            name='attachments[{$post->ID}][dt_slider_newwin]'
            id='attachments[{$post->ID}][dt_slider_newwin]'" . checked(get_post_meta($post->ID, "_dt_slider_newwin", true), true, false ). "/> " . _x('Open link in a new window', 'backend slider', LANGUAGE_ZONE);
			
	}
	return $fields;
}
add_filter('attachment_fields_to_edit', 'dt_f_slider_att_fields', 99, 2);

// upload tab custom fields save handler
function dt_f_slider_att_fields_save($post, $attachment) {
	// prevent loading gallery after save uploaded images
    if( 'dt_slider' == get_post_type($_REQUEST['post_id']) ) {
        if( isset($_GET['tab']) && 'type' == $_GET['tab']) {
            unset($_POST['save']);
        }
    }
    
    // $attachment part of the form $_POST ($_POST[attachments][postID])
	// $post attachments wp post array - will be saved after returned
	//     $post['post_type'] == 'attachment'
	
    if( 'dt_slider' == get_post_type($post['post_parent']) ) {

        // link (text)
        if( isset($attachment['dt_slider_link']) ){
            // update_post_meta(postID, meta_key, meta_value);
            update_post_meta($post['ID'], '_dt_slider_link', $attachment['dt_slider_link']);
        }
        
        // hide desc (checkbox)
        update_post_meta($post['ID'], '_dt_slider_hdesc', isset($attachment['dt_slider_hdesc']));
        
        // open in new window (checkbox)
        update_post_meta($post['ID'], '_dt_slider_newwin', isset($attachment['dt_slider_newwin']));
    }
    
	return $post;
}
add_filter('attachment_fields_to_save', 'dt_f_slider_att_fields_save', 99, 2);

// add custon column 'dt_album_thumbs' in slideshow list
function dt_f_slider_col_thumb($defaults, $post_id){
    $head = array_slice( $defaults, 0, 1 );
    $tail = array_slice( $defaults, 1 );
    
    $head['dt_slider_thumbs'] = _x('Thumbs', 'backend slider', LANGUAGE_ZONE);
    
    $defaults = array_merge( $head, $tail );
    
    return $defaults;
}
add_filter('manage_edit-dt_slider_columns', 'dt_f_slider_col_thumb', 5);

function dt_f_slider_hide_mboxes( $hidden, $screen, $use_defaults ) {
    $template = dt_core_get_template_name();
    if( 'dt-slideshow-fullwidth.php' == $template ||
		'dt-slideshow-sidebar.php' == $template ||
		'dt-homepage-blog.php' == $template ) {
        $meta_boxes = dt_core_get_metabox_list();
        if( !empty($meta_boxes) ) {
            $hidden = array_unique( array_merge($hidden, $meta_boxes) );
             
            foreach( $hidden as $index=>$box ){
                if( 'dt_page_box-slideshows_list' == $box ||
                    'dt_page_box-slideshows_options' == $box ||
                    'dt_page_box-footer_options' == $box ||
                    ('dt-slideshow-sidebar.php' == $template && 'dt_page_box-sidebar_options' == $box)
                ) {
                    unset( $hidden[$index] );
                }
            }
        }
    }
    return $hidden;
}
add_filter('hidden_meta_boxes', 'dt_f_slider_hide_mboxes', 99, 3);

?>
