<?php
/* modules/dt-blog/
 */

// layout
add_action( 'save_post', 'dt_metabox_blog_category_save' );
add_action( 'save_post', 'dt_metabox_blog_options_save' );
add_action( 'save_post', 'dt_core_metabox_sidebar_options_save' );
add_action( 'save_post', 'dt_core_metabox_footer_options_save' );

// post type
add_action( 'save_post', 'dt_metabox_post_options_save' );

// metaboxes
add_action( 'add_meta_boxes', 'dt_blog_boxes' );
function dt_blog_boxes() {
        
        // post options
        add_meta_box(
            'dt_page_box-post_options',
            _x( 'Post options', 'backend blog metabox category', LANGUAGE_ZONE ),
            'dt_metabox_post_options',
            'post',
            'side'
        );

        add_meta_box(
            'dt_page_box-blog_cats',
            _x( 'Display Blog Category(s)', 'backend blog metabox category', LANGUAGE_ZONE ),
            'dt_metabox_blog_category',
            'page',
            'normal',
            'high'
        );
        
        add_meta_box(
            'dt_page_box-blog_options',
            _x( 'Blog options', 'backend blog metabox adv options', LANGUAGE_ZONE ),
            'dt_metabox_blog_options',
            'page',
            'normal',
            'core'
        );
        
        add_meta_box(
            'dt_page_box-sidebar_options',
            _x( 'Sidebar options', 'backend blog metabox sidebar', LANGUAGE_ZONE ),
            'dt_core_metabox_sidebar_options',
            'page',
            'side',
            'core'
        );
        
        add_meta_box(
            'dt_page_box-footer_options',
            _x( 'Footer options', 'backend blog metabox uploader', LANGUAGE_ZONE ),
            'dt_core_metabox_footer_options',
            'page',
            'side',
            'core'
        );
}

function dt_metabox_blog_category( $post ) {
    $box_name = 'dt_meta_blog_list';

    $defaults = array(
        'select'    => 'all',
        'blog_cats' => array()
    );
    
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
    
    $terms = get_terms(
        'category',
        array(
            'type'                     => 'post',
            'hide_empty'               => 1,
            'hierarchical'             => 0,
            'pad_counts'               => false
        )
    );
    
    $select = array(
        'all'       => array( 'desc' => 'All' ),
        'only'      => array( 'desc' => 'only' ),
        'except'    => array( 'desc' => 'except' )
    );

    $links = array(
        array( 'href' => get_admin_url(). 'post-new.php',                       'desc' => _x('Add new post', 'backend blog layout', LANGUAGE_ZONE) ),
        array( 'href' => get_admin_url(). 'edit.php',                           'desc' => _x('Edit posts', 'backend blog layout', LANGUAGE_ZONE) ),
        array( 'href' => get_admin_url(). 'edit-tags.php?taxonomy=category',    'desc' => _x('Edit posts categories', 'backend blog layout', LANGUAGE_ZONE) ),
        array( 'href' => get_admin_url(). 'edit-tags.php?taxonomy=post_tag',    'desc' => _x('Edit posts tags', 'backend blog layout', LANGUAGE_ZONE) )
    );

    $text = array(
        'header'        => sprintf('<h2>%s</h2><p><strong>%s</strong>%s</p><p><strong>%s</strong></p>',
            _x('ALL your Blog posts are being displayed on this page!', 'backend', LANGUAGE_ZONE),
            _x('By default all your Blog posts will be displayed on this page. ', 'backend', LANGUAGE_ZONE),
            _x('But you can specify which Blog categories will (or will not) be shown.', 'backend', LANGUAGE_ZONE),
            _x('In tabs above you can select from the following options:', 'backend', LANGUAGE_ZONE)
        ),
        'select_desc'   => array(
            _x(' &mdash; all Blog posts (from all categories) will be shown on this page.', 'backend', LANGUAGE_ZONE),
            _x(' &mdash; choose Blog category(s) to be shown on this page.', 'backend', LANGUAGE_ZONE),
            _x(' &mdash; choose which category(s) will be excluded from displaying on this page.', 'backend', LANGUAGE_ZONE)
        ),
        'info_desc'     => array(
            _x('%d posts', 'backend', LANGUAGE_ZONE)
        )
    );

    dt_core_mb_draw_modern_selector( array(
        'box_name'      => $box_name,
        'cats_name'     => $box_name . '_blog_cats[%d]',
        'links'         => $links,
        'terms'         => $terms,
        'albums_cats'   => $opts['blog_cats'],
        'cur_type'      => 'category',
        'cur_select'    => $opts['select'],
        'text'          => $text,
		'maintab_class' => 'dt_all_blog'
    ) );
}

function dt_metabox_blog_category_save( $post_id ) {
    $box_name = 'dt_meta_blog_list';
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
  
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times

    if ( !isset( $_POST[$box_name. '_nonce'] ) || !wp_verify_nonce( $_POST[$box_name. '_nonce'], plugin_basename( __FILE__ ) ) )
        return;

  
    // Check permissions
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
    
    $mydata = null;
    
    if( !empty($_POST[$box_name. '_select']) ) {
        $mydata['select'] = esc_attr($_POST[$box_name. '_select']);
   	 
   	    if( isset($_POST[$box_name. '_blog_cats']) ) {
	        $mydata['blog_cats'] = $_POST[$box_name. '_blog_cats'];
	    }
    }
    
    update_post_meta( $post_id, '_'.$box_name, $mydata );

}

function dt_metabox_blog_options( $post ) {
    $box_name = 'dt_meta_blog_options';
    $defaults = array(
        'orderby'           => 'date',
        'order'             => 'DESC',
        'ppp'               => ''
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
    
    $ppp = dt_melement( 'text', array(
        'name'          => $box_name . '_ppp',
        'value'         => $opts['ppp'],
		'wrap'			=> '%1$s'
    ));
    
	echo '<p><strong>' . _x('Number of posts to display on one page', 'backend blog', LANGUAGE_ZONE) . '</strong></p>';
    echo '<p>' . $ppp . '</p>';
	echo '<div class="dt_hr"></div>';
	echo '<p><strong>' . _x('Ordering settings', 'backend blog', LANGUAGE_ZONE) . '</strong></p>';
    
	dt_core_mb_draw_order_options( array(
        'box_name'          => $box_name,
        'order_current'     => $opts['order'],
        'orderby_current'   => $opts['orderby']
    ));
}

function dt_metabox_blog_options_save( $post_id ) {
    $box_name = 'dt_meta_blog_options';
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
  
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times

    if ( !isset( $_POST[$box_name. '_nonce'] ) || !wp_verify_nonce( $_POST[$box_name. '_nonce'], plugin_basename( __FILE__ ) ) )
        return;

    // Check permissions
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
    
    $mydata = null;

    if( isset($_POST[$box_name. '_ppp']) ) {
        $mydata['ppp'] = $_POST[$box_name. '_ppp'];
    }
    
    if( isset($_POST[$box_name. '_orderby']) ) {
        $mydata['orderby'] = $_POST[$box_name. '_orderby'];
    }
    
    if( isset($_POST[$box_name. '_order']) ) {
        $mydata['order'] = $_POST[$box_name. '_order'];
    }
    
    update_post_meta( $post_id, '_' . $box_name, $mydata );
}

// post type
function dt_metabox_post_options( $post ) {
    $box_name = 'dt_meta_post_options';
    $defaults = array(
        'hide_thumb' => 'false'
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
    
    $hide_desc_el = dt_melement( 'checkbox', array(
        'name'          => $box_name . '_hide_thumb',
        'checked'       => $opts['hide_thumb'],
        'description'   => _x('Hide featured image on the Post page', 'backend blog', LANGUAGE_ZONE),
		'wrap'			=> '<label>%1$s&nbsp;%2$s</label>'
    ));
    
    echo '<p>'. $hide_desc_el. '</p>';
}

function dt_metabox_post_options_save( $post_id ) {
    $box_name = 'dt_meta_post_options';

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    if ( !isset( $_POST[$box_name. '_nonce'] ) || !wp_verify_nonce( $_POST[$box_name. '_nonce'], plugin_basename( __FILE__ ) ) )
        return;

    // Check permissions
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
    
    $mydata = null;

    if( isset($_POST[$box_name. '_hide_thumb']) ) {
        $mydata['hide_thumb'] = true;
    }else {
        $mydata['hide_thumb'] = false;
    }
    
    update_post_meta( $post_id, '_' . $box_name, $mydata );
}

?>
