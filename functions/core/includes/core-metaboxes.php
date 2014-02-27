<?php

/* sidebar options */
function dt_core_metabox_sidebar_options( $post ) {
    $box_name = 'dt_layout_sidebar_options';
    $defaults = array(
        'align'     => 'left',
        'sidebar'   => 'sidebar_1'
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
    
	$sidebar_layout = array(
		'left'	=> array(
			'desc' 	=> _x('Left sidebar', 'backend sidebar options', LANGUAGE_ZONE),
			'img'	=> 'sidebar-left.png'
		),
		'right'	=> array(
			'desc' 	=> _x('Right sidebar', 'backend sidebar options', LANGUAGE_ZONE),
			'img'	=> 'sidebar-right.png'
		)
	);
	    
    echo '<p><strong>' . _x('Sidebar position', 'backend sidebar options', LANGUAGE_ZONE) . '</strong></p>';
    
	echo '<div class="dt_radio-img">';
		
		foreach( $sidebar_layout as $val=>$data ) {
			$image = '';
			if( isset($data['img']) ) {
				$image = sprintf(
					'<img src="%1$s/%3$s" class="hide-if-no-js" width="88" height="71" style="background-image:url(%1$s/%2$s)" />',
					esc_url(get_template_directory_uri() . '/images/admin'), esc_attr($data['img']), esc_attr('blank.gif') 
				);
			}
			echo dt_melement( 'radio', array(
				'name'          => $box_name . '_align',
				'checked'       => $val == $opts['align']?true:false,
				'description'   => $data['desc'],
				'value'         => $val,
				'wrap'			=> '<label>'.$image.'%1$s %2$s</label>'
			) );
		}
		
	echo '</div>';
	
    echo '<div class="dt_hr"></div>';
    
	echo '<div class="dt_inside-box">';
	
	echo '<p><strong>' . _x('Sidebar widgetized area', 'backend sidebar options', LANGUAGE_ZONE) . '</strong></p>';
    
	dt_core_mb_draw_sidebars_list( array(
        'box_name'          => $box_name,
        'sidebar_current'   => $opts['sidebar']
    ));
	
	echo '</div>';
}

function dt_core_metabox_sidebar_options_save( $post_id ) {
    $box_name = 'dt_layout_sidebar_options';
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

    if( isset($_POST[$box_name. '_align']) ) {
        $mydata['align'] = $_POST[$box_name. '_align'];
    }
    
    if( isset($_POST[$box_name. '_sidebar']) ) {
        $mydata['sidebar'] = $_POST[$box_name. '_sidebar'];
    }
    
    update_post_meta( $post_id, '_' . $box_name, $mydata );
}

/* footer options */
function dt_core_metabox_footer_options( $post ) {
    $box_name = 'dt_layout_footer_options';

    $defaults = array(
        'footer'    => 'show',
        'sidebar'   => 'sidebar_2',
        'layout'    => '1/4x4'
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
/*    
	$footer_layouts = array(
		'1/4x4' 		=> array( 'desc'  => '1/4 x 4' ),
        '1/4+1/2+1/4' 	=> array( 'desc'  => '1/4+1/2+1/4' ),
        '1/2+1/4+1/4' 	=> array( 'desc'  => '1/2+1/4+1/4' ),
        '1/4+1/4+1/2' 	=> array( 'desc'  => '1/4+1/4+1/2' ),
        '1/3x3' 		=> array( 'desc'  => '1/3 x 3' ),
        '1/3+2/3' 		=> array( 'desc'  => '1/3 + 2/3' ),
        '2/3+1/3' 		=> array( 'desc'  => '2/3 + 1/3' ),
        '1/2x3' 		=> array( 'desc'  => '1/2 x 2' )
    );
 */	
	$footer = array(
		'show'	=> array( 'desc'	=> _x('Yes', 'backend footer options', LANGUAGE_ZONE) ),
		'hide'	=> array( 'desc'	=> _x('No', 'backend footer options', LANGUAGE_ZONE) )
	);
	
	echo '<p class="dt_switcher-box">';
	echo '<strong>' . _x('Show widgetized footer', 'backend footer options', LANGUAGE_ZONE) . '</strong>';
	
	foreach( $footer as $val=>$data ) {
		echo dt_melement( 'radio', array(
			'name'          => $box_name . '_footer',
			'checked'       => $val == $opts['footer']?true:false,
			'description'   => $data['desc'],
			'value'         => $val,
			'wrap'			=> '<label class="dt_switcher">%1$s %2$s</label>',
			'data'			=> 'data-name="dt_footer-show"'
		) );
	}
	
	echo '</p>';
	echo '<div class="dt_footer-show dt_container hide-if-js"><div class="dt_hr"></div>';
/*	echo '<p><strong>' . _x('Footer layout', 'backend footer options', LANGUAGE_ZONE) . '</strong></p>';
	echo '<div class="dt_radio-img">';
	
	foreach( $footer_layouts as $val=>$data ) {
			$image = '';
			if( isset($data['img']) ) {
				$image = sprintf(
					'<img src="%1$s/%3$s" class="hide-if-no-js" width="88" height="71" style="background-image:url(%1$s/%2$s)" />',
					esc_url(get_template_directory_uri() . '/images/admin'), esc_attr($data['img']), esc_attr('blank.gif') 
				);
			}
			echo dt_melement( 'radio', array(
				'name'          => $box_name . '_layout',
				'checked'       => $val == $opts['layout']?true:false,
				'description'   => $data['desc'],
				'value'         => $val,
				'wrap'			=> '<label>'.$image.'%1$s %2$s</label>'
			) );
		}
	
	echo '</div>';
	echo '<div class="dt_hr"></div>';
 */
	dt_core_mb_draw_sidebars_list( array(
        'box_name'          => $box_name,
        'sidebar_current'   => $opts['sidebar'],
        'before'            => sprintf(
			'<div class="dt_inside-box"><p><strong>%s</strong></p>',
			_x('Footer widgetized area', 'backend footer options', LANGUAGE_ZONE)
		),
		'after'				=> '</div>'
    ));
	
	echo '</div>';
}

function dt_core_metabox_footer_options_save( $post_id ) {
    $box_name = 'dt_layout_footer_options';
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

    if( isset($_POST[$box_name. '_footer']) ) {
        $mydata['footer'] = $_POST[$box_name. '_footer'];
    }
    
    if( isset($_POST[$box_name. '_layout']) ) {
        $mydata['layout'] = $_POST[$box_name. '_layout'];
    }
    
    if( isset($_POST[$box_name. '_sidebar']) ) {
        $mydata['sidebar'] = $_POST[$box_name. '_sidebar'];
    }
    
    update_post_meta( $post_id, '_' . $box_name, $mydata );
}
?>
