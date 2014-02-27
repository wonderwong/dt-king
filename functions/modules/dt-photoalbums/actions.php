<?php

// custom mediauploader tab action
function dt_a_album_mu() {
    $errors = array();

    if ( !empty($_POST) ) {
        $return = media_upload_form_handler();

        if ( is_string($return) )
            return $return;
        if ( is_array($return) )
            $errors = $return;
    }

    wp_enqueue_style( 'media' );
    wp_enqueue_script('admin-gallery');
    
    return wp_iframe( 'dt_album_media_form', $errors );
}
add_action( 'media_upload_dt_gallery_media', 'dt_a_album_mu' );

// admin album list thumbnail column action
function dt_a_album_col_thumb($column_name, $id){
	if($column_name === 'dt_album_thumbs'){
		$thumb = dt_get_thumbnail(
            array( 
                'post_id' 	=> $id,
                'width' 	=> 100,
                'height' 	=> 100,
                'upscale'	=> true
            )
		);
		
		printf( '<a href="post.php?post=%d&action=edit" title=""><img src="%s" alt=""/></a>',
			$id,
			$thumb['thumnail_img']
		);
    }
}
add_action('manage_posts_custom_column', 'dt_a_album_col_thumb', 5, 2);

// admin album list category column action
function dt_a_album_col_cat($column_name, $id){
    if( 'dt_album_cat' === $column_name ){
        $post_type = get_post_type($id);
        
        if( 'dt_gallery' == $post_type ) {
            $taxonomy = 'dt_gallery_category';
        }else {
            return false;
        }

        $categories = '';
        $before = '';
        $after = '';
        $sep = __( ', ', LANGUAGE_ZONE );
        $terms = get_the_terms( $id, $taxonomy );
  
        if( $terms ) {
            foreach ( $terms as $term ) {
                $link = get_term_link( $term, $taxonomy );
                $link = str_replace( site_url('/'), site_url('/') . 'wp-admin/edit.php', $link );
                $link = add_query_arg( 'post_type', $post_type, $link );
                $term_links[] = '<a href="' . $link . '" rel="tag">' . $term->name . ' (' . $term->term_id . ')' . '</a>';
            }
            $categories = $before . join( $sep, $term_links ) . $after;
        }
        echo $categories;
    }
}
add_action('manage_posts_custom_column', 'dt_a_album_col_cat', 5, 2);

function dt_albums_layout_init( $layout, $data = array() ) {
    if( 'dt-albums' != $layout || !isset($data['cat_id']) ) {
        return false;
    }
    
    global $post, $DT_QUERY, $wpdb;
    $opts = get_post_meta($post->ID, '_dt_albums_layout_options', true);
    $cats = get_post_meta($post->ID, '_dt_albums_layout_albums', true);
    
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
        'order'             => $opts['order'],
        'orderby'           => $opts['orderby'],
        'post_status'       => 'publish',
        'paged'             => $paged
    );

    if( $opts['ppp'] ) {
        $args['posts_per_page'] = $opts['ppp'];
    }

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
    
    dt_storage( 'post_is_first', 1 );
    dt_storage( 'num_pages', ('on' == $opts['show_all_pages'])?999:null );
}
add_action( 'dt_layout_before_loop', 'dt_albums_layout_init', 99, 2 );

?>
