<?php
/* modules/dt-portfolio
*/

// layout
add_action( 'save_post', 'dt_core_metabox_footer_options_save' );
add_action( 'save_post', 'dt_core_metabox_sidebar_options_save' );
add_action( 'save_post', 'dt_metabox_portfolio_layout_category_save' );
add_action( 'save_post', 'dt_metabox_portfolio_layout_options_save' );

// post type 
add_action( 'save_post', 'dt_metabox_portfolio_options_save' );
add_action( 'save_post', 'dt_metabox_portfolio_related_save' );

/* Adds a box to the main column on the Post and Page edit screens */
add_action( 'add_meta_boxes', 'portfolio_meta_box' );
function portfolio_meta_box () {
    
    // post options
    add_meta_box ( 
        'dt_portfolio-post_options',
        _x( 'Project Options', 'backend portfolio post', LANGUAGE_ZONE ),
        'dt_metabox_portfolio_options',
        'dt_portfolio',
        'side'
    );
    
    // related category
    add_meta_box ( 
        'dt_portfolio-post_related',
        _x( 'Related Projects', 'backend portfolio post', LANGUAGE_ZONE ),
        'dt_metabox_portfolio_related',
        'dt_portfolio',
        'advanced',
        'high'
    );
    
    // post media uploader
    add_meta_box(
        'dt_portfolio-muploader',
        _x( 'Project media (for slideshow)', 'backend portfolio metabox uploader', LANGUAGE_ZONE ),
        'dt_metabox_portfolio_muploader',
        'dt_portfolio',
        'normal',
        'high'
    );
		
	add_meta_box( 
        'dt_page_box-portfolio_category',
        _x( 'Display Portfolio Category(s):', 'backend portfolio layout', LANGUAGE_ZONE ),
        'dt_metabox_portfolio_layout_category',
        'page',
        'normal',
        'core'
    );
		
	add_meta_box( 
        'dt_page_box-portfolio_options',
        _x( 'Portfolio Settings:', 'backend portfolio layout', LANGUAGE_ZONE ),
        'dt_metabox_portfolio_layout_options',
        'page',
        'normal',
        'core'
    );
	
}

// layout

// portfolio category
function dt_metabox_portfolio_layout_category( $post ) {
    $box_name = 'dt_portfolio_layout_category';
    
    $defaults = array(
        'select'            => 'all',
        'portfolio_cats'    => array()
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
    
    $terms = get_terms(
        'dt_portfolio_category',
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
        array( 'href' => get_admin_url(). 'post-new.php?post_type=dt_portfolio', 'desc' => _x('Add new project', 'backend portfolio layout', LANGUAGE_ZONE) ),
        array( 'href' => get_admin_url(). 'edit.php?post_type=dt_portfolio', 'desc' => _x('Edit portfolio', 'backend portfolio layout', LANGUAGE_ZONE) ),
        array( 'href' => get_admin_url(). 'edit-tags.php?taxonomy=dt_portfolio_category&post_type=dt_portfolio', 'desc' => _x('Edit portfolio categories', 'backend portfolio layout', LANGUAGE_ZONE) )
    );

    $text = array(
        'header'        => sprintf('<h2>%s</h2><p><strong>%s</strong>%s</p><p><strong>%s</strong></p>',
            _x('ALL your Portfolio projects are being displayed on this page!', 'backend', LANGUAGE_ZONE),
            _x('By default all your Portfolio projects will be displayed on this page. ', 'backend', LANGUAGE_ZONE),
            _x('But you can specify which Portfolio project category(s) will (or will not) be shown.', 'backend', LANGUAGE_ZONE),
            _x('In tabs above you can select from the following options:', 'backend', LANGUAGE_ZONE)
        ),
        'select_desc'   => array(
            _x(' &mdash; all Projects will be shown on this page.', 'backend', LANGUAGE_ZONE),
            _x(' &mdash; choose Project category(s) to be shown on this page.', 'backend', LANGUAGE_ZONE),
            _x(' &mdash; choose which Project category(s) will be excluded from displaying on this page.', 'backend', LANGUAGE_ZONE)
        ),
        'info_desc'     => array(
            _x('%d items', 'backend', LANGUAGE_ZONE)
        )
    );

    dt_core_mb_draw_modern_selector( array(
        'box_name'      => $box_name,
        'cats_name'     => $box_name . '_portfolio_cats[%d]',
        'links'         => $links,
        'terms'         => $terms,
        'albums_cats'   => $opts['portfolio_cats'],
        'cur_type'      => 'category',
        'cur_select'    => $opts['select'],
        'text'          => $text,
		'maintab_class' => 'dt_all_portfolio'
    ) );
}

function dt_metabox_portfolio_layout_category_save( $post_id ) {
    $box_name = 'dt_portfolio_layout_category';
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
   	 
   	    if( isset($_POST[$box_name. '_portfolio_cats']) ) {
	        $mydata['portfolio_cats'] = $_POST[$box_name. '_portfolio_cats'];
	    }
    }

    update_post_meta( $post_id, '_'.$box_name, $mydata );
}

// portfolio options
function dt_metabox_portfolio_layout_options( $post ) {
	$box_name = 'dt_portfolio_layout_options';
	
    $defaults = array(
        'layout'			=> '2_col-list',
        'ppp'       		=> '',
		'orderby'   		=> 'date',
        'order'     		=> 'DESC',
		'show_meta'			=> 'on',
		'show_excerpt'		=> 'on',
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
			'desc'	=> _x('Two cols list', 'backend portfolio layout', LANGUAGE_ZONE),
			'img'	=> array('list-2cols.png', 72, 49)
		),
		'2_col-grid'	=> array(
			'desc'	=> _x('Two cols grid', 'backend portfolio layout', LANGUAGE_ZONE),
			'img'	=> array('grid-2cols.png', 72, 49)
		),
		'3_col-list'	=> array(
			'desc'	=> _x('Three cols list', 'backend portfolio layout', LANGUAGE_ZONE),
			'img'	=> array('list-3cols.png', 72, 49)
		),
		'3_col-grid'	=> array(
			'desc'	=> _x('Three cols grid', 'backend portfolio layout', LANGUAGE_ZONE),
			'img'	=> array('grid-3cols.png', 72, 49)
		)
	);
	
	$radio_on_off = array(
		'on'	=> array( 'desc' => _x('on', 'backend portfolio layout', LANGUAGE_ZONE) ),
		'off'	=> array( 'desc' => _x('off', 'backend portfolio layout', LANGUAGE_ZONE) )
	);
	
	echo '<p><strong>' . _x('Portfolio layout', 'backend portfolio layout', LANGUAGE_ZONE) . '</strong></p>';
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
		'description'	=> _x('Number of portfolio projects to display on one page', 'backend portfolio layout', LANGUAGE_ZONE),
		'value'			=> $opts['ppp'],
		'wrap'			=> '<p><strong>%2$s</strong></p><p>%1$s</p>'
	) );
	
	echo '<div class="dt_hr"></div>';
	echo '<p><strong>' . _x('Ordering settings', 'backend portfolio layout', LANGUAGE_ZONE) . '</strong></p>';
	dt_core_mb_draw_order_options( array( 'box_name' => $box_name, 'order_current' => $opts['order'], 'orderby_current' => $opts['orderby'] ) );
	
	printf( '<div class="hide-if-no-js"><div class="dt_hr"></div><p><a href="#advanced-options" class="dt_advanced">
			<input type="hidden" name="%1$s" data-name="%1$s" value="hide" />
			<span class="dt_advanced-show">%2$s</span>
			<span class="dt_advanced-hide">%3$s</span> 
			%4$s
		</a></p></div>',
		'dt_portfolio-advanced',
		_x('+ Show', 'backend portfolio layout', LANGUAGE_ZONE),
		_x('- Hide', 'backend portfolio layout', LANGUAGE_ZONE),
		_x('advanced settings', 'backend portfolio layout', LANGUAGE_ZONE) );
	
	echo '<div class="dt_portfolio-advanced dt_container hide-if-js"><div class="dt_hr"></div>';
	
	echo '<p class="dt_switcher-box"><strong>' . _x('Show title and excerpt in grid layout', 'backend portfolio layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_meta', $opts['show_meta'], $radio_on_off );
	echo '</p>';
	
	echo '<div class="dt_hr"></div>';
	echo '<p class="dt_switcher-box"><strong>' . _x('Show "Details" button in grid layout', 'backend portfolio layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_excerpt', $opts['show_excerpt'], $radio_on_off );
	echo '</p>';
	
	echo '<div class="dt_hr"></div>';
	echo '<p class="dt_switcher-box"><strong>' . _x('Show all pages in paginator', 'backend portfolio layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_all_pages', $opts['show_all_pages'], $radio_on_off );
	echo '</p>';
	
	echo '<div class="dt_hr"></div>';
	echo '<p class="dt_switcher-box"><strong>' . _x('Show categories filter', 'backend portfolio layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_cat_filter', $opts['show_cat_filter'], $radio_on_off );
	echo '</p>';
	
	echo '<div class="dt_hr"></div>';
	echo '<p class="dt_switcher-box"><strong>' . _x('Show layout switcher', 'backend portfolio layout', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_show_layout_swtch', $opts['show_layout_swtch'], $radio_on_off );
	echo '</p>';
	
	echo '</div>';
}

// pportfolio options save
function dt_metabox_portfolio_layout_options_save( $post_id ) {
	$box_name = 'dt_portfolio_layout_options';
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

// post type

// portfolio options
function dt_metabox_portfolio_options( $post ) {
    $box_name = 'dt_portfolio_options';

    $defaults = array(
        'hide_thumbnail'    => false,
        'hide_media'        => false,
        'hide_meta'         => false
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
    
    $hide_thumb = dt_melement( 'checkbox', array(
        'name'          => $box_name . '_hide_thumbnail',
        'checked'       => $opts['hide_thumbnail'],
        'description'   => _x(' Hide featured image on the Project page', 'backend portfolio', LANGUAGE_ZONE)
    ));
    $hide_thumb->generate_id('hide_thumb');
    
    $hide_meta = dt_melement( 'checkbox', array(
        'name'          => $box_name . '_hide_meta',
        'checked'       => $opts['hide_meta'],
        'description'   => _x(' Hide meta information (categories list) on the Project page', 'backend portfolio', LANGUAGE_ZONE)
    ));
    $hide_meta->generate_id('hide_meta');
    
    $hide_media = dt_melement( 'checkbox', array(
        'name'          => $box_name . '_hide_media',
        'checked'       => $opts['hide_media'],
        'description'   => _x('Hide project media slider on the Project page', 'backend portfolio', LANGUAGE_ZONE)
    ));
    $hide_media->generate_id('hide_media');

    echo '<p>' . $hide_thumb . '</p><p>' . $hide_meta . '</p><p>' . $hide_media. '</p>';
}

function dt_metabox_portfolio_options_save( $post_id ) {
    $box_name = 'dt_portfolio_options';
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

    $mydata['hide_thumbnail'] = isset($_POST[$box_name. '_hide_thumbnail']);
    
    $mydata['hide_meta'] = isset($_POST[$box_name. '_hide_meta']);

    $mydata['hide_media'] = isset($_POST[$box_name. '_hide_media']);
    
    update_post_meta( $post_id, '_' . $box_name, $mydata );
}

// related category
function dt_metabox_portfolio_related( $post ) {
    $box_name = 'dt_portfolio_related';
/*    
    $post_terms = wp_get_post_terms($post->ID, 'dt_portfolio_category', array('fields' => 'ids'));
    
    if( !empty($post_terms) ) {
        $post_terms = implode(',', $post_terms);
    }else{
        $post_terms = 'other';
    }

 */
    $defaults = array(
        'show_related'  => false,
        'related'       => 'same' 
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );

    $opts = wp_parse_args( $opts, $defaults );
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
    
    // show related
    $show_related = dt_melement( 'checkbox', array(
        'name'          => $box_name . '_show_related',
        'checked'       => $opts['show_related'],
        'description'   => _x(' Show related projects', 'backend portfolio', LANGUAGE_ZONE),
        'class'         => 'dt_admin_show_related'
    ));
    
    // related category
    $related_same = dt_melement( 'radio', array(
        'name'          => $box_name . '_related',
        'checked'       => ('same' == $opts['related'])?true:false,
        'description'   => _x(' From the same category', 'backend portfolio', LANGUAGE_ZONE),
        'value'         => 'same',
        'class'         => 'dt_admin_related_radio'
    ));
    
    $related_other = dt_melement( 'radio', array(
        'name'          => $box_name . '_related',
        'checked'       => is_array($opts['related']),
        'description'   => _x(' Choose category(s)', 'backend portfolio', LANGUAGE_ZONE),
        'value'         => 'other',
        'class'         => 'dt_admin_related_radio dt_admin_other_cat'
    ));
    
    // output
    echo '<p>' . $show_related . '</p>';
    
    echo '<div class="dt_admin_show_related_box" style="display: none;">';
    
    echo '<p>' . $related_same . '<br/>' . $related_other . '</p>';
    
    echo '<div class="dt_admin_cat_list" style="display: none;">';
    
    // terms
    $post_type_terms = get_terms('dt_portfolio_category', 'hide_empty=0');
    $selected_terms = is_array($opts['related'])?$opts['related']:array();

    foreach( $post_type_terms as $term ) {
        echo dt_melement( 'checkbox', array(
            'name'          => $box_name . '_related_terms[]',
            'checked'       => in_array($term->term_id, $selected_terms),
            'description'   => $term->name,
            'desc_wrap'     => '%2$s',
            'value'         => $term->term_id,
            'wrap'          => '<label style="display: block;">%1$s%2$s</label>'
        ));
    }
    unset($term);
    
    echo '</div>';
    
    echo '</div>';
}

/* related save */
function dt_metabox_portfolio_related_save( $post_id ) {
    $box_name = 'dt_portfolio_related';
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

    $mydata['show_related'] = isset($_POST[$box_name. '_show_related']);
    
    if( 'other' == $_POST[$box_name. '_related'] && isset($_POST[$box_name. '_related_terms']) ) {
        $mydata['related'] = array_map('intval', $_POST[$box_name. '_related_terms']);
    }else {
        $mydata['related'] = 'same'; 
    }
    update_post_meta( $post_id, '_' . $box_name, $mydata );
}

// portfolio uploader
function dt_metabox_portfolio_muploader( $post ) {
    $tab = 'type';
    $args = array(
        'post_type'			=>'attachment',
        'post_status'		=>'inherit',
        'post_parent'		=>$post->ID,
        'posts_per_page'	=>1
    );
    $attachments = new Wp_Query( $args );

    if( !empty($attachments->posts) ) {
        $tab = 'dt_portfolio_media';
    }
    
    $u_href = get_admin_url();
    $u_href .= '/media-upload.php?post_id='. $post->ID;
    $u_href .= '&width=670&height=400&tab='.$tab;
?>
    <iframe src="<?php echo esc_url($u_href); ?>" width="100%" height="560">The Error!!!</iframe>
<?php
}

function dt_portfolio_media_form( $errors ) {
    global $redir_tab, $type;

    $redir_tab = 'dt_portfolio_media';
    media_upload_header();
    
    $post_id = intval($_REQUEST['post_id']);
    $form_action_url = admin_url("media-upload.php?type=$type&tab=dt_portfolio_media&post_id=$post_id");
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
    <?php $_REQUEST['tab'] = 'dt_portfolio_media';?>
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
