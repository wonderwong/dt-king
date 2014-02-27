<?php

function dt_core_parents_where_filter( $where ) {
    if( function_exists('dt_storage') ) {
        global $wpdb;
    	$param = dt_storage('where_filter_param');
	    if( $param ) {
            $where .= sprintf( " AND $wpdb->posts.post_parent IN(%s)", $wpdb->prepare($param, null));
        }else {
            $where .= ' AND 1=0';
        }
    }    
    return $where;
}

function dt_core_join_left_filter( $parts ) {
    if( isset($parts['join']) && !empty($parts['join']) ) {
        $parts['join'] = str_replace( 'INNER', 'LEFT', $parts['join']);
    }
    return $parts;
}

?>
