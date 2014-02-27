<?php
/* modules/dt-team
*/

// post type 
add_action( 'save_post', 'dt_metabox_info_save' );

/* Adds a box to the main column on the Post and Page edit screens */
add_action( 'add_meta_boxes', 'team_meta_box' );
function team_meta_box() {
    
    // post options
    add_meta_box ( 
        'dt_team-post_info',
        _x( 'Teammate', 'backend ourteam post', LANGUAGE_ZONE ),
        'dt_metabox_team_info',
        'dt_team',
        'side'
    );

}

// layout

// portfolio category
function dt_metabox_team_info( $post ) {
    $box_name = 'dt_team_info';
    
    $defaults = array(
        'position'  => '',
        'age'       => ''    
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );

    echo dt_melement( 'text', array(
       'name'           => $box_name . '_position',
       'value'          => $opts['position'],
       'class'          => 'widefat',
       'wrap'           => '%2$s%1$s',
       'description'    => _x('Position', 'backend ourteam post', LANGUAGE_ZONE)
    ) );

    echo dt_melement( 'text', array(
       'name'           => $box_name . '_age',
       'value'          => $opts['age'],
       'class'          => 'widefat',
       'wrap'           => '%2$s%1$s',
       'description'    => _x('Age', 'backend ourteam post', LANGUAGE_ZONE)
    ) );
}

function dt_metabox_info_save( $post_id ) {
    $box_name = 'dt_team_info';
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

    if( !empty($_POST[$box_name. '_position']) )
        $mydata['position'] = esc_attr($_POST[$box_name. '_position']);
        
    if( !empty($_POST[$box_name. '_age']) )
        $mydata['age'] = esc_attr($_POST[$box_name. '_age']);

    update_post_meta( $post_id, '_'.$box_name, $mydata );
}
?>
