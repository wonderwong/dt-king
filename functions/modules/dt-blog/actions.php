<?php

function dt_blog_layput_init( $layout ) {
    
    if( 'dt-blog' != $layout ) {
        return false;
    }
    
    global $post, $DT_QUERY;
    $opts = get_post_meta($post->ID, '_dt_meta_blog_options', true);
    $cats = get_post_meta($post->ID, '_dt_meta_blog_list', true);
    
    if( !$paged = get_query_var('page') ) {
        $paged = get_query_var('paged');
    }

    $args = array(
        'post_type' => 'post',
        'order'     => $opts['order'],
        'orderby'   => $opts['orderby'],
        'status'    => 'publish',
        'paged'     => $paged
    );

    if( $opts['ppp'] ) {
        $args['posts_per_page'] = $opts['ppp'];
    }

    if( !isset($cats['blog_cats']) ) {
        $cats['blog_cats'] = array();
    }

    switch( $cats['select'] ) {
        case 'only':
            $args['category__in'] = array_keys($cats['blog_cats']);
            break;
    
        case 'except':
            $args['category__not_in'] = array_keys($cats['blog_cats']);
    }
 
    $DT_QUERY = new WP_Query( $args ); 
    
    if( $DT_QUERY->have_posts() ) {
        $thumb_arr = dt_core_get_posts_thumbnails( $DT_QUERY->posts );
        dt_storage( 'thumbs_array', $thumb_arr['thumbs_meta'] );
    }
    dt_storage( 'post_is_first', 1 );
}
add_action( 'dt_layout_before_loop', 'dt_blog_layput_init', 10, 1 );

?>
