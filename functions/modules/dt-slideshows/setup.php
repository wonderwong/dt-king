<?php

/* setup post type sector */
function dt_slider_setup_post_type() {

// titels
$labels = array(
    'name'                  => _x('Slideshows', 'backend slideshow', LANGUAGE_ZONE),
    'singular_name'         => _x('Slideshow', 'backend slideshow', LANGUAGE_ZONE),
    'add_new'               => _x('Add New Slideshow', 'backend slideshow', LANGUAGE_ZONE),
    'add_new_item'          => _x('Add New Slideshow', 'backend slideshow', LANGUAGE_ZONE),
    'edit_item'             => _x('Edit Slideshow', 'backend slideshow', LANGUAGE_ZONE),
    'new_item'              => _x('New Slideshow', 'backend slideshow', LANGUAGE_ZONE),
    'view_item'             => _x('View Slideshow', 'backend slideshow', LANGUAGE_ZONE),
    'search_items'          => _x('Search', 'backend slideshow', LANGUAGE_ZONE),
    'not_found'             => _x('No Slideshows Found', 'backend slideshow', LANGUAGE_ZONE),
    'not_found_in_trash'    => _x('No Slideshows found in Trash', 'backend slideshow', LANGUAGE_ZONE),
    'parent_item_colon'     => '',
    'menu_name'             => _x('Slideshows', 'backend slideshow', LANGUAGE_ZONE)
);

$img = DT_SLIDESHOWS_URI. '/images/admin_ico_slides.png';

$args = array(
    'labels'                => $labels,
    'public'                => false,
    'publicly_queryable'    => false,
    'show_ui'               => true, 
    'show_in_menu'          => true, 
    'query_var'             => true,
    'rewrite'               => false,
    'capability_type'       => 'post',
    'has_archive'           => false, 
    'hierarchical'          => false,
    'menu_position'         => 29,
    'menu_icon'             => $img,
    'supports'              => array( 'thumbnail', 'title' )
);
register_post_type( 'dt_slider', $args);
/* post type end */

}
add_action('init', 'dt_slider_setup_post_type');

?>
