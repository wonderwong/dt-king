<?php
/* modules/dt-photoalbums
*/

// layout
add_action( 'save_post', 'dt_metabox_albums_layout_options_save' );
add_action( 'save_post', 'dt_metabox_albums_layout_albums_save' );

// post type
add_action( 'save_post', 'dt_gallery_posttype_options_save' );

// metabxes
add_action( 'add_meta_boxes', 'dt_gallery_boxes' );
function dt_gallery_boxes() {
    add_meta_box(
        'gallery-order_options',
        _x( 'Custom gallery options', 'backend albums metabox options', LANGUAGE_ZONE ),
        'dt_gallery_posttype_options',
        'dt_gallery',
        'advanced',
        'low'
    );
    
    add_meta_box(
        'gallery-admin',
        _x( 'Gallery', 'backend albums metabox uploader', LANGUAGE_ZONE ),
        'dt_gallery_admin_box',
        'dt_gallery',
        'advanced',
        'high'
    );
		
	add_meta_box( 
        'dt_page_box-albums_list',
        _x( 'Display Albums:', 'backend albums layout', LANGUAGE_ZONE ),
        'dt_metabox_albums_layout_albums',
        'page',
        'normal',
        'core'
    );
        
	add_meta_box(
        'dt_page_box-albums_options',
        _x( 'Albums Settings', 'backend albums layout', LANGUAGE_ZONE ),
        'dt_metabox_albums_layout_options',
        'page',
		'normal',
		'core'
   );

}

// layout
function dt_metabox_albums_layout_options( $post ) {
	$box_name = 'dt_albums_layout_options';
	
    $defaults = array(
        'layout'			=> '2_col-list',
        'ppp'       		=> '',
		'orderby'   		=> 'date',
        'order'     		=> 'DESC',
        'show_excerpt'      => 'on',
		'show_all_pages'	=> 'off',
		'show_cat_filter'	=> 'on',
		'show_layout_swtch'	=> 'on'
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
	
	$layout = array(
		'2_col-list'	=> array(
			'desc'	=> _x('Two cols list', 'backend albums layout', LANGUAGE_ZONE),
			'img'	=> array('list-2cols.png', 72, 49)
		),
		'2_col-grid'	=> array(
			'desc'	=> _x('Two cols grid', 'backend albums layout', LANGUAGE_ZONE),
			'img'	=> array('grid-2cols.png', 72, 49)
		),
		'3_col-list'	=> array(
			'desc'	=> _x('Three cols list', 'backend albums layout', LANGUAGE_ZONE),
			'img'	=> array('list-3cols.png', 72, 49)
		),
		'3_col-grid'	=> array(
			'desc'	=> _x('Three cols grid', 'backend albums layout', LANGUAGE_ZONE),
			'img'	=> array('grid-3cols.png', 72, 49)
		)
	);
	
	$radio_on_off = array(
		'on'	=> array( 'desc' => _x('on', 'backend albums layout', LANGUAGE_ZONE) ),
		'off'	=> array( 'desc' => _x('off', 'backend albums layout', LANGUAGE_ZONE) )
	);
	
	echo '<p><strong>' . _x('Albums layout', 'backend albums layout', LANGUAGE_ZONE) . '</strong></p>';
	echo '<div class="dt_radio-img">';
	
	foreach( $layout as $val=>$data ) {
		$image = '';
		if( isset($data['img']) ) {
			$image = sprintf(
				'<img src="%1$s/%3$s" class="hide-if-no-js" width="%4$s" height="%5$s" style="background-image:url(%1$s/%2$s)" /><br />',
				esc_url(get_template_directory_uri() . '/images/admin'), esc_attr($data['img'][0]), 'blank.gif', $data['img'][1], $data['img'][2] 
			);
		}
		echo dt_melement( 'radio', array(
			'name'			=> $box_name . '_layout',
			'description'	=> $data['desc'],
			'checked'		=> $val == $opts['layout']?true:false,
			'value'			=> $val,
			'wrap'			=> '<label>'.$image.'%1$s %2$s</label>'
		) );
	}
	
	echo '</div>';
	
	echo '<div class="dt_hr"></div>';
	
	echo dt_melement( 'text', array(
		'name'			=> $box_name . '_ppp',
		'description'	=> _x('Number of photo albums to display on one page', 'backend albums layout', LANGUAGE_ZONE),
		'value'			=> $opts['ppp'],
		'wrap'			=> '<p><strong>%2$s</strong></p><p>%1$s</p>'
	) );
	
	echo '<div class="dt_hr"></div>';
	echo '<p><strong>' . _x('Ordering settings', 'backend albums layout', LANGUAGE_ZONE) . '</strong></p>';
	dt_core_mb_draw_order_options( array( 'box_name' => $box_name, 'order_current' => $opts['order'], 'orderby_current' => $opts['orderby'] ) );
	
	printf( '<div class="hide-if-no-js"><div class="dt_hr"></div><p><a href="#advanced-options" class="dt_advanced">
			<input type="hidden" name="%1$s" data-name="%1$s" value="hide" />
			<span class="dt_advanced-show">%2$s</span>
			<span class="dt_advanced-hide">%3$s</span> 
			%4$s
		</a></p></div>',
		'dt_albums-advanced',
		_x('+ Show', 'backend albums layout', LANGUAGE_ZONE),
		_x('- Hide', 'backend albums layout', LANGUAGE_ZONE),
		_x('advanced settings', 'backend albums layout', LANGUAGE_ZONE) );
	
	echo '<div class="dt_albums-advanced dt_container hide-if-js"><div class="dt_hr"></div>';

	echo '<p class="dt_switcher-box"><strong>' . _x('Show title and excerpt in grid layout', 'backend albums layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_excerpt', $opts['show_excerpt'], $radio_on_off );
	echo '</p>';
	
	echo '<div class="dt_hr"></div>';
	echo '<p class="dt_switcher-box"><strong>' . _x('Show all pages in paginator', 'backend albums layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_all_pages', $opts['show_all_pages'], $radio_on_off );
	echo '</p>';
	
	echo '<div class="dt_hr"></div>';
	echo '<p class="dt_switcher-box"><strong>' . _x('Show categories filter', 'backend albums layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_cat_filter', $opts['show_cat_filter'], $radio_on_off );
	echo '</p>';
	
	echo '<div class="dt_hr"></div>';
	echo '<p class="dt_switcher-box"><strong>' . _x('Show layout switcher', 'backend albums layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_layout_swtch', $opts['show_layout_swtch'], $radio_on_off );
	echo '</p>';
	
	echo '</div>';
}

function dt_metabox_albums_layout_options_save( $post_id ) {
	$box_name = 'dt_albums_layout_options';
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
	
	if( isset($_POST[$box_name.'_layout']) ) {
		$mydata['layout'] = esc_attr( $_POST[$box_name.'_layout'] );
	}
    
	if( isset($_POST[$box_name.'_ppp']) ) {
		$mydata['ppp'] = intval( $_POST[$box_name.'_ppp'] );
	}
	
	if( isset($_POST[$box_name.'_orderby']) ) {
		$mydata['orderby'] = esc_attr( $_POST[$box_name.'_orderby'] );
	}
	
	if( isset($_POST[$box_name.'_order']) ) {
		$mydata['order'] = esc_attr( $_POST[$box_name.'_order'] );
	}
	
	if( isset($_POST[$box_name.'_show_excerpt']) ) {
		$mydata['show_excerpt'] = esc_attr( $_POST[$box_name.'_show_excerpt'] );
	}
	
	if( isset($_POST[$box_name.'_show_all_pages']) ) {
		$mydata['show_all_pages'] = esc_attr( $_POST[$box_name.'_show_all_pages'] );
	}
	
	if( isset($_POST[$box_name.'_show_cat_filter']) ) {
		$mydata['show_cat_filter'] = esc_attr( $_POST[$box_name.'_show_cat_filter'] );
	}
	
	if( isset($_POST[$box_name.'_show_layout_swtch']) ) {
		$mydata['show_layout_swtch'] = esc_attr( $_POST[$box_name.'_show_layout_swtch'] );
	}
	
    update_post_meta( $post_id, '_' . $box_name, $mydata );
}

// albums category
function dt_metabox_albums_layout_albums( $post ) {
    $box_name = 'dt_albums_layout_albums';
    $defaults = array(
        'select'        => 'all',
        'type'          => 'albums',
        'albums'        => array(),
        'albums_cats'   => array()
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
    
    $terms = get_terms(
        'dt_gallery_category',
        array(
            'hide_empty'               => true,
            'hierarchical'             => false,
            'pad_counts'               => false
        )
    );

    $select = array(
        'all'       => array( 'desc' => 'All' ),
        'only'      => array( 'desc' => 'only' ),
        'except'    => array( 'desc' => 'except' )
    );

    $type = array(
        'albums'    => array( 'desc' => 'Albums', 'class' => 'type_selector' ),
        'category'  => array( 'desc' => 'Category', 'class' => 'type_selector' )
    );

    $links = array(
        array( 'href' => get_admin_url(). 'post-new.php?post_type=dt_gallery', 'desc' => _x('Add new album', 'backend albums layout', LANGUAGE_ZONE) ),
        array( 'href' => get_admin_url(). 'edit.php?post_type=dt_gallery', 'desc' => _x('Edit albums', 'backend albums layout', LANGUAGE_ZONE) ),
        array( 'href' => get_admin_url(). 'edit-tags.php?taxonomy=dt_gallery_category&post_type=dt_gallery', 'desc' => _x('Edit albums categories', 'backend albums layout', LANGUAGE_ZONE) )
    );

    $text = array(
        'header'        => sprintf('<h2>%s</h2><p><strong>%s</strong>%s</p><p><strong>%s</strong></p>',
            _x('ALL your Photo albums are being displayed on this page!', 'backend', LANGUAGE_ZONE),
            _x('By default all your Photo albums will be displayed on this page. ', 'backend', LANGUAGE_ZONE),
            _x('But you can specify which Album(s) or Album category(s) will (or will not) be shown.', 'backend', LANGUAGE_ZONE),
            _x('In tabs above you can select from the following options:', 'backend', LANGUAGE_ZONE)
        ),
        'select_desc'   => array(
            _x(' &mdash; all Albums will be shown on this page.', 'backend', LANGUAGE_ZONE),
            _x(' &mdash; choose Album(s) or Album category(s) to be shown on this page.', 'backend', LANGUAGE_ZONE),
            _x(' &mdash; choose which Album(s) or Album category(s) will be excluded from displaying on this page.', 'backend', LANGUAGE_ZONE)
        ),
        'info_desc'     => array(
            _x('%d albums', 'backend', LANGUAGE_ZONE)
        )
    );

   	$albums = new Wp_Query( 'post_type=dt_gallery&posts_per_page=-1&post_status=publish' );
    dt_core_mb_draw_modern_selector( array(
        'box_name'      => $box_name,
        'albums_name'   => $box_name . '_albums[%d]',
        'cats_name'     => $box_name . '_albums_cats[%d]',
        'links'         => $links,
        'posts'         => $albums->posts,
        'terms'         => $terms,
        'albums'        => $opts['albums'],
        'albums_cats'   => $opts['albums_cats'],
        'cur_type'      => $opts['type'],
        'cur_select'    => $opts['select'],
        'taxonomy'      => 'dt_gallery_category',
        'text'          => $text,
		'maintab_class' => 'dt_all_albums'
    ) );
}

function dt_metabox_albums_layout_albums_save( $post_id ) {
    $box_name = 'dt_albums_layout_albums';
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
   	 
        if( isset($_POST[$box_name. '_type']) ) {
            $mydata['type'] = esc_attr($_POST[$box_name . '_type']);
        }

   	    if( isset($_POST[$box_name. '_albums_cats']) ) {
	        $mydata['albums_cats'] = $_POST[$box_name. '_albums_cats'];
	    }
        
        if( isset($_POST[$box_name. '_albums']) ) {
	        $mydata['albums'] = $_POST[$box_name. '_albums'];
	    }
    }

    update_post_meta( $post_id, '_'.$box_name, $mydata );
}

// post type
function dt_gallery_posttype_options( $post ) {
    $box_name = 'dt_gal_p_options';
    $defaults = array(
        'orderby'           => 'menu_order',
        'order'             => 'ASC',
        'hide_thumbnail'    => false
    );
    $opts = get_post_meta( $post->ID, '_'.$box_name, true );
    $opts = wp_parse_args( $opts, $defaults );
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
    
    dt_m_optset_hide_thumb( array(
        'hide_thumbnail'    => $opts['hide_thumbnail'],
        'box_name'          => $box_name
    ) );
    dt_m_optset_orderby( array('current' => $opts['orderby'], 'box_name' => $box_name) );
    dt_m_optset_order( array('current' => $opts['order'], 'box_name' => $box_name) );
    
}

function dt_gallery_posttype_options_save( $post_id ) {
    $box_name = 'dt_gal_p_options';
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

    if( isset($_POST[$box_name. '_orderby']) ) {
        $mydata['orderby'] = $_POST[$box_name. '_orderby'];
    }
    
    if( isset($_POST[$box_name. '_order']) ) {
        $mydata['order'] = $_POST[$box_name. '_order'];
    }
    
    $mydata['hide_thumbnail'] = isset( $_POST[$box_name . '_hide_thumb'] );
    
    update_post_meta( $post_id, '_'.$box_name, $mydata );
}


// custom tab -------------------------------------------------------------------
function dt_gallery_admin_box( $post ) {

    $tab = 'type';
    $args = array(
        'post_type'			=>'attachment',
        'post_status'		=>'inherit',
        'post_parent'		=>$post->ID,
        'posts_per_page'	=>1
    );
    $attachments = new Wp_Query( $args );

    if( !empty($attachments->posts) ) {
        $tab = 'dt_gallery_media';
    }
    
    $u_href = get_admin_url();
    $u_href .= '/media-upload.php?post_id='. $post->ID;
    $u_href .= '&width=670&height=400&tab='.$tab;
?>
    <iframe src="<?php echo esc_url($u_href); ?>" width="100%" height="560">The Error!!!</iframe>
<?php
}

function dt_album_media_form( $errors ) {
    global $redir_tab, $type;

    $redir_tab = 'dt_gallery_media';
    media_upload_header();
    
    $post_id = intval($_REQUEST['post_id']);
    $form_action_url = admin_url("media-upload.php?type=$type&tab=dt_gallery_media&post_id=$post_id");
    $form_action_url = apply_filters('media_upload_form_url', $form_action_url, $type);
    $form_class = 'media-upload-form validate';
    
    if ( get_user_setting('uploader') )
        $form_class .= ' html-uploader';
?>	
    <script type="text/javascript">
    <!--
    jQuery(function($){
        var preloaded = $(".media-item.preloaded");
        if ( preloaded.length > 0 ) {
            preloaded.each(function(){prepareMediaItem({id:this.id.replace(/[^0-9]/g, '')},'');});
            updateMediaForm();
        }
    });
    -->
    </script>
    <div id="sort-buttons" class="hide-if-no-js">
    <span>
    <?php _e('All Tabs:'); ?>
    <a href="#" id="showall"><?php _e('Show'); ?></a>
    <a href="#" id="hideall" style="display:none;"><?php _e('Hide'); ?></a>
    </span>
    <?php _e('Sort Order:'); ?>
    <a href="#" id="asc"><?php _e('Ascending'); ?></a> |
    <a href="#" id="desc"><?php _e('Descending'); ?></a> |
    <a href="#" id="clear"><?php _ex('Clear', 'verb'); ?></a>
    </div>
    <form enctype="multipart/form-data" method="post" action="<?php echo esc_attr($form_action_url); ?>" class="<?php echo $form_class; ?>" id="gallery-form">
    <?php wp_nonce_field('media-form'); ?>
    <?php //media_upload_form( $errors ); ?>
    <table class="widefat" cellspacing="0">
    <thead><tr>
    <th><?php _e('Media'); ?></th>
    <th class="order-head"><?php _e('Order'); ?></th>
    <th class="actions-head"><?php _e('Actions'); ?></th>
    </tr></thead>
    </table>
    <div id="media-items">
    <?php add_filter('attachment_fields_to_edit', 'media_post_single_attachment_fields_to_edit', 10, 2); ?>
    <?php $_REQUEST['tab'] = 'gallery'; ?>
    <?php echo get_media_items($post_id, $errors); ?>
    <?php $_REQUEST['tab'] = 'dt_gallery_media';?>
    </div>

    <p class="ml-submit">
    <?php submit_button( __( 'Save all changes' ), 'button savebutton', 'save', false, array( 'id' => 'save-all', 'style' => 'display: none;' ) ); ?>
    <input type="hidden" name="post_id" id="post_id" value="<?php echo (int) $post_id; ?>" />
    <input type="hidden" name="type" value="<?php echo esc_attr( $GLOBALS['type'] ); ?>" />
    <input type="hidden" name="tab" value="<?php echo esc_attr( $GLOBALS['tab'] ); ?>" />
    </p>
    </form>
<?php
}

?>
