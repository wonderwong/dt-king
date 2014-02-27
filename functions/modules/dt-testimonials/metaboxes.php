<?php
/* modules/dt-testimonials
*/

// post type 
add_action( 'save_post', 'dt_metabox_testimonials_author_save' );

/* Adds a box to the main column on the Post and Page edit screens */
add_action( 'add_meta_boxes', 'testimonials_meta_box' );
function testimonials_meta_box() {
    
    // post options
    add_meta_box ( 
        'dt_testimonials-author',
        _x( 'Author', 'backend testimonials post', LANGUAGE_ZONE ),
        'dt_metabox_testimonials_author',
        'dt_testimonials',
        'side'
    );

}

// layout

// portfolio category
function dt_metabox_testimonials_author( $post ) {
    $box_name = 'dt_testimonials_author';
    
    $defaults = array(
        'author'  => ''
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );

    echo dt_melement( 'text', array(
       'name'           => $box_name . '_author',
       'value'          => $opts['author'],
       'class'          => 'widefat',
       'wrap'           => '%2$s%1$s',
       'description'    => _x('Author', 'backend testimonials post', LANGUAGE_ZONE)
    ) );
}

function dt_metabox_testimonials_author_save( $post_id ) {
    $box_name = 'dt_testimonials_author';

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

    if( !empty($_POST[$box_name. '_author']) )
        $mydata['author'] = esc_attr($_POST[$box_name. '_author']);

    update_post_meta( $post_id, '_'.$box_name, $mydata );
}
?>
