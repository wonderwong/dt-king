<?php
/* modules/dt-photos
*/

// layout
add_action( 'save_post', 'dt_metabox_photos_layout_albums_save' );
add_action( 'save_post', 'dt_metabox_photos_layout_options_save' );

/* Adds a box to the main column on the Post and Page edit screens */
add_action( 'add_meta_boxes', 'photos_meta_box' );
function photos_meta_box () {

		add_meta_box( 
            'dt_page_box-photos_albums',
            _x( 'Display Photos:', 'backend photos layout', LANGUAGE_ZONE ),
            'dt_metabox_photos_layout_albums',
            'page',
            'normal',
            'core'
        );
		
		add_meta_box( 
            'dt_page_box-photos_options',
            _x( 'Photos Settings:', 'backend photos layout', LANGUAGE_ZONE ),
            'dt_metabox_photos_layout_options',
            'page',
            'normal',
            'core'
        );
	
}

// layout

// photos category
function dt_metabox_photos_layout_albums( $post ) {
    $box_name = 'dt_photos_layout_albums';

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
        array( 'href' => get_admin_url(). 'post-new.php?post_type=dt_gallery', 'desc' => _x('Add new album', 'backend photos layout', LANGUAGE_ZONE) ),
        array( 'href' => get_admin_url(). 'edit.php?post_type=dt_gallery', 'desc' => _x('Edit albums', 'backend photos layout', LANGUAGE_ZONE) ),
        array( 'href' => get_admin_url(). 'edit-tags.php?taxonomy=dt_gallery_category&post_type=dt_gallery', 'desc' => _x('Edit albums categories', 'backend photos layout', LANGUAGE_ZONE) )
    );

    $text = array(
        'header'        => sprintf('<h2>%s</h2><p><strong>%s</strong>%s</p><p><strong>%s</strong></p>',
            _x('ALL Photos from all your Photo albums are being displayed on this page!', 'backend', LANGUAGE_ZONE),
            _x('By default all your Photos will be displayed on this page. ', 'backend', LANGUAGE_ZONE),
            _x('But you can specify which Album(s) or Album category(s) will (or will not) be shown.', 'backend', LANGUAGE_ZONE),
            _x('In tabs above you can select from the following options:', 'backend', LANGUAGE_ZONE)
        ),
        'select_desc'   => array(
            _x(' &mdash; all Photos from all Albums will be shown on this page.', 'backend', LANGUAGE_ZONE),
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

function dt_metabox_photos_layout_albums_save( $post_id ) {
    $box_name = 'dt_photos_layout_albums';
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

// photos options
function dt_metabox_photos_layout_options( $post ) {
	$box_name = 'dt_photos_layout_options';
	
    $defaults = array(
        'layout'			=> '2_col-grid',
        'ppp'       		=> '',
		'orderby'   		=> 'date',
        'order'     		=> 'DESC',
		'show_all_pages'	=> 'off',
		'show_cat_filter'	=> 'on'
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
	
	$layout = array(
		'2_col-grid'	=> array(
			'desc'	=> _x('Two cols grid', 'backend photos layout', LANGUAGE_ZONE),
			'img'	=> array('grid-2cols.png', 72, 49)
		),
		'3_col-grid'	=> array(
			'desc'	=> _x('Three cols grid', 'backend photos layout', LANGUAGE_ZONE),
			'img'	=> array('grid-3cols.png', 72, 49)
		)
	);
	
	$radio_on_off = array(
		'on'	=> array( 'desc' => _x('on', 'backend photos layout', LANGUAGE_ZONE) ),
		'off'	=> array( 'desc' => _x('off', 'backend photos layout', LANGUAGE_ZONE) )
	);
	
	echo '<p><strong>' . _x('Photos layout', 'backend photos layout', LANGUAGE_ZONE) . '</strong></p>';
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
	echo '</div><div class="dt_hr"></div>';
	
	echo dt_melement( 'text', array(
		'name'			=> $box_name . '_ppp',
		'description'	=> _x('Number of photos to display on one page', 'backend photos layout', LANGUAGE_ZONE),
		'value'			=> $opts['ppp'],
		'wrap'			=> '<p><strong>%2$s</strong></p><p>%1$s</p>'
	) );
	
	echo '<div class="dt_hr"></div>';
	echo '<p><strong>' . _x('Ordering settings', 'backend photos layout', LANGUAGE_ZONE) . '</strong></p>';
	dt_core_mb_draw_order_options( array( 'box_name' => $box_name, 'order_current' => $opts['order'], 'orderby_current' => $opts['orderby'] ) );
	
	printf( '<div class="hide-if-no-js"><div class="dt_hr"></div><p><a href="#advanced-options" class="dt_advanced">
			<input type="hidden" name="%1$s" data-name="%1$s" value="hide" />
			<span class="dt_advanced-show">%2$s</span>
			<span class="dt_advanced-hide">%3$s</span> 
			%4$s
		</a></p></div>',
		'dt_photos-advanced',
		_x('+ Show', 'backend photos layout', LANGUAGE_ZONE),
		_x('- Hide', 'backend photos layout', LANGUAGE_ZONE),
		_x('advanced settings', 'backend photos layout', LANGUAGE_ZONE) );
	
	echo '<div class="dt_photos-advanced dt_container hide-if-js"><div class="dt_hr"></div>';
	
	echo '<p class="dt_switcher-box"><strong>' . _x('Show all pages in paginator', 'backend photos layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_all_pages', $opts['show_all_pages'], $radio_on_off );
	echo '</p>';
	
	echo '<div class="dt_hr"></div>';
	echo '<p class="dt_switcher-box"><strong>' . _x('Show categories filter', 'backend photos layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_cat_filter', $opts['show_cat_filter'], $radio_on_off );
	echo '</p>';
	
	echo '</div>';
}

// pphotos options save
function dt_metabox_photos_layout_options_save( $post_id ) {
	$box_name = 'dt_photos_layout_options';
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
	
	if( isset($_POST[$box_name.'_show_all_pages']) ) {
		$mydata['show_all_pages'] = esc_attr( $_POST[$box_name.'_show_all_pages'] );
	}
	
	if( isset($_POST[$box_name.'_show_cat_filter']) ) {
		$mydata['show_cat_filter'] = esc_attr( $_POST[$box_name.'_show_cat_filter'] );
	}
	
    update_post_meta( $post_id, '_' . $box_name, $mydata );
}

?>
