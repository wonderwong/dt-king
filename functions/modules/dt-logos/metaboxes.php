<?php
/* modules/dt-logos
*/

// post type 
add_action( 'save_post', 'dt_metabox_logos_options_save' );

/* Adds a box to the main column on the Post and Page edit screens */
add_action( 'add_meta_boxes', 'logos_meta_box' );
function logos_meta_box () {
    
    // post options
    add_meta_box ( 
        'dt_logos-post_options',
        _x( 'Logos options', 'backend logos post', LANGUAGE_ZONE ),
        'dt_metabox_logos_options',
        'dt_logos',
        'normal',
        'high'
    );

}

// layout

// portfolio category
function dt_metabox_logos_options( $post ) {
    $box_name = 'dt_logos_options';
    
    $defaults = array(
        'url'   => '',
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
    
?>

    <label><?php echo _x('Target link:', 'backend logos post', LANGUAGE_ZONE); ?><input class="widefat" name="<?php echo esc_attr($box_name . '_url'); ?>" value="<?php echo esc_url($opts['url']); ?>" /></label>

<?php
}

function dt_metabox_logos_options_save( $post_id ) {
    $box_name = 'dt_logos_options';

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

    if( !empty($_POST[$box_name. '_url']) ) {
        $mydata['url'] = esc_url($_POST[$box_name. '_url']);
    }

    update_post_meta( $post_id, '_'.$box_name, $mydata );
}
