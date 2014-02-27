<?php
/* dt-page
*/

// layout
/*
add_action( 'save_post', 'dt_core_metabox_footer_options_save' );
add_action( 'save_post', 'dt_core_metabox_sidebar_options_save' );
*/
/* Adds a box to the main column on the Post and Page edit screens */
//add_action( 'add_meta_boxes', 'page_meta_box' );
function page_meta_box () {
/*    
    $template_file = dt_core_get_template_name();
    
    if( 'dt-page-fullwidth.php' == $template_file ||
        'dt-page-sidebar.php' == $template_file ) {
        
        add_meta_box( 
            'dt_page_layout-footer_options',
            _x( 'Footer options', 'backend slider layout', LANGUAGE_ZONE ),
            'dt_core_metabox_footer_options',
            'page',
            'side',
            'core'
        );
		
	}
	
	if( 'dt-page-sidebar.php' == $template_file ) {
		add_meta_box( 
            'dt_page_layout-sidebar_options',
            _x( 'Sidebar options', 'backend slider layout', LANGUAGE_ZONE ),
            'dt_core_metabox_sidebar_options',
            'page',
            'side',
            'core'
        );
	}
*/

}