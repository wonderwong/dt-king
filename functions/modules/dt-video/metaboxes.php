<?php
/* modules/dt-video
*/

// layout
add_action( 'save_post', 'dt_metabox_video_layout_category_save' );
add_action( 'save_post', 'dt_metabox_video_layout_options_save' );

// post type
add_action( 'save_post', 'dt_metabox_video_options_save' );

// metaboxez
add_action( 'add_meta_boxes', 'dt_video_boxes' );
function dt_video_boxes() {
    add_meta_box(
        'video-options',
        _x( 'Video options', 'backend video metabox options', LANGUAGE_ZONE ),
        'dt_metabox_video_options',
        'dt_video',
        'advanced',
        'low'
    );

	add_meta_box( 
        'dt_page_box-video_category',
        _x( 'Display Video Category(s):', 'backend video layout', LANGUAGE_ZONE ),
        'dt_metabox_video_layout_category',
        'page',
        'normal',
        'core'
    );
		
	add_meta_box( 
        'dt_page_box-video_options',
        _x( 'Video Gallery Settings:', 'backend video layout', LANGUAGE_ZONE ),
        'dt_metabox_video_layout_options',
        'page',
        'normal',
        'core'
    );

}

// layout

// video category
function dt_metabox_video_layout_category( $post ) {
    $box_name = 'dt_video_layout_category';

    $defaults = array(
        'select'        => 'all',
        'video_cats'    => array() 
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
    
    $terms = get_terms(
        'dt_video_category',
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

    $links = array(
        array( 'href' => get_admin_url(). 'post-new.php?post_type=dt_video', 'desc' => _x('Add new video', 'backend video layout', LANGUAGE_ZONE) ),
        array( 'href' => get_admin_url(). 'edit.php?post_type=dt_video', 'desc' => _x('Edit video gallery', 'backend video layout', LANGUAGE_ZONE) ),
        array( 'href' => get_admin_url(). 'edit-tags.php?taxonomy=dt_video_category&post_type=dt_video', 'desc' => _x('Edit video categories', 'backend video layout', LANGUAGE_ZONE) )
    );

    $text = array(
        'header'        => sprintf('<h2>%s</h2><p><strong>%s</strong>%s</p><p><strong>%s</strong></p>',
            _x('ALL your Videos are being displayed on this page!', 'backend', LANGUAGE_ZONE),
            _x('By default all your Videos will be displayed on this page. ', 'backend', LANGUAGE_ZONE),
            _x('But you can specify which Video category(s) will (or will not) be shown.', 'backend', LANGUAGE_ZONE),
            _x('In tabs above you can select from the following options:', 'backend', LANGUAGE_ZONE)
        ),
        'select_desc'   => array(
            _x(' &mdash; all Videos will be shown on this page.', 'backend', LANGUAGE_ZONE),
            _x(' &mdash; choose Video category(s) to be shown on this page.', 'backend', LANGUAGE_ZONE),
            _x(' &mdash; choose which Video category(s) will be excluded from displaying on this page.', 'backend', LANGUAGE_ZONE)
        ),
        'info_desc'     => array(
            _x('%d albums', 'backend', LANGUAGE_ZONE)
        )
    );

    dt_core_mb_draw_modern_selector( array(
        'box_name'      => $box_name,
        'cats_name'     => $box_name . '_video_cats[%d]',
        'links'         => $links,
        'terms'         => $terms,
        'albums_cats'   => $opts['video_cats'],
        'cur_type'      => 'category',
        'cur_select'    => $opts['select'],
        'text'          => $text,
		'maintab_class' => 'dt_all_video'
    ) );
}

function dt_metabox_video_layout_category_save( $post_id ) {
    $box_name = 'dt_video_layout_category';
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
   	 
   	    if( isset($_POST[$box_name. '_video_cats']) ) {
	        $mydata['video_cats'] = $_POST[$box_name. '_video_cats'];
	    }
    }

    update_post_meta( $post_id, '_'.$box_name, $mydata );
}

// video options
function dt_metabox_video_layout_options( $post ) {
	$box_name = 'dt_video_layout_options';
	
    $defaults = array(
        'layout'			=> '2_col-grid',
        'ppp'       		=> '',
		'orderby'   		=> 'date',
        'order'     		=> 'DESC',
		'show_meta'			=> 'on',
//		'show_excerpt'		=> 'on',
		'show_all_pages'	=> 'off',
		'show_cat_filter'	=> 'on',
//		'show_layout_swtch'	=> 'on'
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
	
	$layout = array(
		'2_col-grid'	=> array(
			'desc'	=> _x('Two cols grid', 'backend portfolio layout', LANGUAGE_ZONE),
			'img'	=> array('grid-2cols.png', 72, 49)
		),
		'3_col-grid'	=> array(
			'desc'	=> _x('Three cols grid', 'backend portfolio layout', LANGUAGE_ZONE),
			'img'	=> array('grid-3cols.png', 72, 49)
		)
	);
	
	$radio_on_off = array(
		'on'	=> array( 'desc' => _x('on', 'backend video layout', LANGUAGE_ZONE) ),
		'off'	=> array( 'desc' => _x('off', 'backend video layout', LANGUAGE_ZONE) )
	);
	
	echo '<p><strong>' . _x('Video layout', 'backend video layout', LANGUAGE_ZONE) . '</strong></p>';
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
		'description'	=> _x('Number of videos to display on one page', 'backend video layout', LANGUAGE_ZONE),
		'value'			=> $opts['ppp'],
		'wrap'			=> '<p><strong>%2$s</strong></p><p>%1$s</p>'
	) );
	
	echo '<div class="dt_hr"></div>';
	echo '<p><strong>' . _x('Ordering settings', 'backend video layout', LANGUAGE_ZONE) . '</strong></p>';
	dt_core_mb_draw_order_options( array( 'box_name' => $box_name, 'order_current' => $opts['order'], 'orderby_current' => $opts['orderby'] ) );
	
	printf( '<div class="hide-if-no-js"><div class="dt_hr"></div><p><a href="#advanced-options" class="dt_advanced">
			<input type="hidden" name="%1$s" data-name="%1$s" value="hide" />
			<span class="dt_advanced-show">%2$s</span>
			<span class="dt_advanced-hide">%3$s</span> 
			%4$s
		</a></p></div>',
		'dt_video-advanced',
		_x('+ Show', 'backend video layout', LANGUAGE_ZONE),
		_x('- Hide', 'backend video layout', LANGUAGE_ZONE),
		_x('advanced settings', 'backend video layout', LANGUAGE_ZONE) );
	
	echo '<div class="dt_video-advanced dt_container hide-if-js"><div class="dt_hr"></div>';
	
	echo '<p class="dt_switcher-box"><strong>' . _x('Show title and excerpt', 'backend video layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_meta', $opts['show_meta'], $radio_on_off );
	echo '</p>';
/*	
	echo '<div class="dt_hr"></div>';
	echo '<p class="dt_switcher-box"><strong>' . _x('Show excerpts and details buttons', 'backend video layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_excerpt', $opts['show_excerpt'], $radio_on_off );
	echo '</p>';
 */	
	echo '<div class="dt_hr"></div>';
	echo '<p class="dt_switcher-box"><strong>' . _x('Show all pages in paginator', 'backend video layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_all_pages', $opts['show_all_pages'], $radio_on_off );
	echo '</p>';
	
	echo '<div class="dt_hr"></div>';
	echo '<p class="dt_switcher-box"><strong>' . _x('Show categories filter', 'backend video layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_cat_filter', $opts['show_cat_filter'], $radio_on_off );
	echo '</p>';
/*	
	echo '<div class="dt_hr"></div>';
	echo '<p class="dt_switcher-box"><strong>' . _x('Show layout switcher', 'backend video layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_layout_swtch', $opts['show_layout_swtch'], $radio_on_off );
	echo '</p>';
 */	
	echo '</div>';
}

// video options save
function dt_metabox_video_layout_options_save( $post_id ) {
	$box_name = 'dt_video_layout_options';
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
		$mydata['ppp'] = esc_attr( $_POST[$box_name.'_ppp'] );
	}
	
	if( isset($_POST[$box_name.'_orderby']) ) {
		$mydata['orderby'] = esc_attr( $_POST[$box_name.'_orderby'] );
	}
	
	if( isset($_POST[$box_name.'_order']) ) {
		$mydata['order'] = esc_attr( $_POST[$box_name.'_order'] );
	}
	
	if( isset($_POST[$box_name.'_show_meta']) ) {
		$mydata['show_meta'] = esc_attr( $_POST[$box_name.'_show_meta'] );
	}
/*	
	if( isset($_POST[$box_name.'_show_excerpt']) ) {
		$mydata['show_excerpt'] = esc_attr( $_POST[$box_name.'_show_excerpt'] );
	}
 */	
	if( isset($_POST[$box_name.'_show_all_pages']) ) {
		$mydata['show_all_pages'] = esc_attr( $_POST[$box_name.'_show_all_pages'] );
	}
	
	if( isset($_POST[$box_name.'_show_cat_filter']) ) {
		$mydata['show_cat_filter'] = esc_attr( $_POST[$box_name.'_show_cat_filter'] );
	}
/*	
	if( isset($_POST[$box_name.'_show_layout_swtch']) ) {
		$mydata['show_layout_swtch'] = esc_attr( $_POST[$box_name.'_show_layout_swtch'] );
	}
 */	
    update_post_meta( $post_id, '_' . $box_name, $mydata );
}

// post type
function dt_metabox_video_options( $post ) {
    $box_name = 'dt_video_options';
    $defaults = array(
        'video_link'    => '',
        'height'        => '',
        'width'         => ''
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
    
    // video link
    $link = dt_melement( 'text', array(
        'name'          => $box_name . '_video_link',
        'class'         => 'widefat',
        'description'   => __('Video link:', 'backend video', LANGUAGE_ZONE ),
        'wrap'          => '%2$s%1$s',
        'value'         => $opts['video_link']
    ));
    
    // upload button
/*    $upload = dt_melement( 'link', array(
        'description'   => _x( 'Upload Video', 'backend video', LANGUAGE_ZONE ),
        'class'         => 'button-primary thickbox',
        'href'          => get_admin_url().'media-upload.php?post_id='.$post->ID.'&type=video&TB_iframe=1&width=640&height=310'
    ));
 */    
    // height
    $height = dt_melement( 'text', array(
        'name'          => $box_name . '_height',
        'description'   => _x( ' Set video HEIGHT', 'backend video', LANGUAGE_ZONE ),
        'value'         => $opts['height'],
        'style'         => 'width: 40px;'
    ));
    $height->generate_id('v_height');
    
    // width
    $width = dt_melement( 'text', array(
        'name'          => $box_name . '_width',
        'description'   => _x( ' Set video WIDTH', 'backend video', LANGUAGE_ZONE ),
        'value'         => $opts['width'],
        'style'         => 'width: 40px;'
    ));
    $width->generate_id('v_width');
    
    
    echo '<p>' . $link . '</p>';
    echo '<p>' . $width . '<br/>' . $height . '</p>';
}

function dt_metabox_video_options_save( $post_id ) {
    $box_name = 'dt_video_options';
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

    if( isset($_POST[$box_name. '_video_link']) ) {
        $mydata['video_link'] = $_POST[$box_name. '_video_link'];
    }
    
    if( isset($_POST[$box_name. '_width']) ) {
        $mydata['width'] = $_POST[$box_name. '_width'];
    }
    
    if( isset($_POST[$box_name. '_height']) ) {
        $mydata['height'] = $_POST[$box_name. '_height'];
    }
        
    update_post_meta( $post_id, '_' . $box_name, $mydata );
}

?>
