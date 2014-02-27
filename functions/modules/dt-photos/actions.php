<?php

function dt_photos_layout_init( $layout, $data = array() ) {
    if( 'dt-photos' != $layout || !isset($data['cat_id']) ) {
        return false;
    }
    
    global $post, $DT_QUERY, $wpdb;
    $opts = get_post_meta($post->ID, '_dt_photos_layout_options', true);
    $cats = get_post_meta($post->ID, '_dt_photos_layout_albums', true);
    
    $page_data = dt_storage('page_data');
    if( $page_data && is_array($page_data) ) {
        $page_data['page_options'] = $opts;
        dt_storage( 'page_data', $page_data );
    }else{
        dt_storage( 'page_data', array('page_options' => $opts) );
    }

    dt_storage_add_data_init( array('layout' => $opts['layout']) );
     
    if( !$paged = get_query_var('page') ) {
        $paged = get_query_var('paged');
    }

    $args = array(
        'post_type'         => 'dt_gallery',
        'post_status'       => 'publish',
    );

    $args['posts_per_page'] = -1;

    if( !isset($cats['albums_cats']) ) {
        $cats['albums_cats'] = array();
    }else {
        $cats['albums_cats'] = array_map('intval', array_values($cats['albums_cats']));
    }
    
    if( is_array($data['cat_id']) ) {

        $args['tax_query'] = array( array(
            'taxonomy'  => 'dt_gallery_category',
            'field'     => 'id',
            'operator'  => 'IN'
        ) );

        $args['tax_query'][0]['terms'] = intval(current($data['cat_id']));

        if( 'category' == $cats['type'] && !empty($cats['albums_cats']) && ('all' != $cats['select']) ) {

            $in_array = in_array(current($data['cat_id']), $cats['albums_cats']);

            if( ('only' == $cats['select'] && !$in_array) || ('except' == $cats['select'] && $in_array) ) {
                $args['tax_query'][0]['terms'] = 0;
            }
        }

    }elseif( 'none' == $data['cat_id'] ) {

        $terms = get_terms( 'dt_gallery_category', array(
            'type'          => 'dt_gallery',
            'hide_empty'    => 1,
            'hierarchical'  => 0,
            'pad_counts'    => false,
            'fields'        => 'ids'
        ) );

        $args['tax_query'] = array( array(
            'taxonomy'  => 'dt_gallery_category',
            'field'     => 'id',
            'terms'     => $terms,
            'operator'  => 'NOT IN'
        ) );

    }elseif( 'category' == $cats['type'] && !empty($cats['albums_cats']) && ('all' != $cats['select']) ) {

        $args['tax_query'] = array( array(
            'taxonomy'  => 'dt_gallery_category',
            'field'     => 'id',
            'terms'     => $cats['albums_cats']
        ) );

        switch( $cats['select'] ) {
            case 'only': $args['tax_query'][0]['operator'] = 'IN'; break;
            case 'except': $args['tax_query'][0]['operator'] = 'NOT IN';
        }

    }

    if( 'albums' == $cats['type'] && !empty($cats['albums']) && ('all' != $cats['select']) ) {
        switch( $cats['select'] ) {
            case 'only': $args['post__in'] = array_values($cats['albums']); break;
            case 'except': $args['post__not_in'] = array_values($cats['albums']);
        }
    }

    add_filter('posts_clauses', 'dt_core_join_left_filter');
    $DT_QUERY = new WP_Query( $args ); 
    remove_filter('posts_clauses', 'dt_core_join_left_filter');

    if( $DT_QUERY->have_posts() ) {
        foreach( $DT_QUERY->posts as $album ) {
            if( post_password_required($album->ID) )
                continue;
            $output[] = $album->ID;
        }
    }
    dt_storage( 'where_filter_param', implode(',', $output) ); 

    $args = array(
        'post_type'         => 'attachment',
        'order'             => $opts['order'],
        'orderby'           => $opts['orderby'],
        'post_mime_type'	=> 'image',
        'post_status'       => 'inherit',
        'paged'             => $paged
    );

    if( $opts['ppp'] ) {
        $args['posts_per_page'] = $opts['ppp'];
    }

    add_filter( 'posts_where' , 'dt_core_parents_where_filter' );
    $DT_QUERY->query( $args ); 
    remove_filter( 'posts_where' , 'dt_core_parents_where_filter' );
    
    dt_storage( 'num_pages', ('on' == $opts['show_all_pages'])?999:null );
}
add_action( 'dt_layout_before_loop', 'dt_photos_layout_init', 99, 2 );

?>
