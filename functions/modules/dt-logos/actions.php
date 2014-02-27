<?php

// admin logos list thumbnail column action
function dt_a_logos_col_thumb($column_name, $id){
	if( 'dt_logos_thumbs' === $column_name ){
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
add_action('manage_posts_custom_column', 'dt_a_logos_col_thumb', 5, 2);

// admin logos list category column action
function dt_a_logos_col_cat($column_name, $id){
    if( 'dt_logos_cat' === $column_name ){
        $post_type = get_post_type($id);
        
        if( 'dt_logos' == $post_type ) {
            $taxonomy = 'dt_logos_category';
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
add_action('manage_posts_custom_column', 'dt_a_logos_col_cat', 5, 2);

?>