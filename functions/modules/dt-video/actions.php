<?php

// admin album list thumbnail column action
function dt_a_video_col_thumb($column_name, $id){
	if($column_name === 'dt_video_thumbs'){
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
add_action('manage_posts_custom_column', 'dt_a_video_col_thumb', 5, 2);

// admin album list category column action
function dt_a_video_col_cat($column_name, $id){
    if( 'dt_video_cat' === $column_name ){
        $post_type = get_post_type($id);
        
        if( 'dt_video' == $post_type ) {
            $taxonomy = 'dt_video_category';
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
add_action('manage_posts_custom_column', 'dt_a_video_col_cat', 5, 2);

function dt_video_layout_init( $layout, $data = array() ) {
    
    if( 'dt-video' != $layout || !isset($data['cat_id']) ) {
        return false;
    }
    
    global $post, $DT_QUERY;
    $opts = get_post_meta($post->ID, '_dt_video_layout_options', true);
    $cats = get_post_meta($post->ID, '_dt_video_layout_category', true);

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
        'post_type' => 'dt_video',
        'order'     => $opts['order'],
        'orderby'   => $opts['orderby'],
        'status'    => 'publish',
        'paged'     => $paged
    );

    if( $opts['ppp'] ) {
        $args['posts_per_page'] = $opts['ppp'];
    }
    
    if( !isset($cats['video_cats']) ) {
        $cats['video_cats'] = array();
    }else {
        $cats['video_cats'] = array_map('intval', array_values($cats['video_cats']));
    }

    if( is_array($data['cat_id']) ) {
        $in_array = in_array(current($data['cat_id']), $cats['video_cats']);
        $args['tax_query'] = array( array(
            'taxonomy'  => 'dt_video_category',
            'field'     => 'id',
            'operator'  => 'IN'
        ) );

        if( ('only' == $cats['select'] && $in_array) ||
            ('except' == $cats['select'] && !$in_array) ||
            'all' == $cats['select']
        ) {
            $args['tax_query'][0]['terms'] = intval(current($data['cat_id']));
        }else {
            $args['tax_query'][0]['terms'] = 0;
        }
    }elseif( ('none' == $data['cat_id']) || ( !empty($cats['video_cats']) && !('all' == $cats['select']) ) ) {
        $terms = get_terms( 'dt_video_category', array(
            'type'          => 'dt_video',
            'hide_empty'    => 1,
            'hierarchical'  => 0,
            'pad_counts'    => false,
            'fields'        => 'ids'
        ) );

        $args['tax_query'] = array( array(
            'taxonomy'  => 'dt_video_category',
            'field'     => 'id',
            'terms'     => $terms,
            'operator'  => 'IN'
        ) );

        if( 'none' == $data['cat_id'] ) {
            $args['tax_query'][0]['operator'] = 'NOT IN';
        }elseif( 'except' == $cats['select'] ) {
            $args['tax_query']['relation'] = 'OR';
            $args['tax_query'][1] = $args['tax_query'][0];
            $args['tax_query'][0]['terms'] = array_diff($terms, $cats['video_cats']);
            $args['tax_query'][1]['operator'] = 'NOT IN';
        }elseif( 'only' == $cats['select'] ) {
            $args['tax_query'][0]['terms'] = $cats['video_cats'];
        }
    }
 
    add_filter('posts_clauses', 'dt_core_join_left_filter');
    $DT_QUERY = new WP_Query( $args ); 
    remove_filter('posts_clauses', 'dt_core_join_left_filter');

    if( $DT_QUERY->have_posts() ) {
        $thumb_arr = dt_core_get_posts_thumbnails( $DT_QUERY->posts );
        dt_storage( 'thumbs_array', $thumb_arr['thumbs_meta'] );
    }
    dt_storage( 'num_pages', ('on' == $opts['show_all_pages'])?999:null );
}
add_action( 'dt_layout_before_loop', 'dt_video_layout_init', 99, 2 );

?>
