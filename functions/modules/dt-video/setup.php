<?php

/* setup post type sector */
function dt_video_setup_post_type() {

// title
$labels = array(
    'name'                  => _x('Video', 'backend video', LANGUAGE_ZONE),
    'singular_name'         => _x('Video', 'backend video', LANGUAGE_ZONE),
    'add_new'               => _x('Add New', 'backend video', LANGUAGE_ZONE),
    'add_new_item'          => _x('Add New', 'backend video', LANGUAGE_ZONE),
    'edit_item'             => _x('Edit', 'backend video', LANGUAGE_ZONE),
    'new_item'              => _x('New', 'backend video', LANGUAGE_ZONE),
    'view_item'             => _x('View', 'backend video', LANGUAGE_ZONE),
    'search_items'          => _x('Search', 'backend video', LANGUAGE_ZONE),
    'not_found'             => _x('No Items Found', 'backend video', LANGUAGE_ZONE),
    'not_found_in_trash'    => _x('No Items Found in Trash', 'backend video', LANGUAGE_ZONE), 
    'parent_item_colon'     => '',
    'menu_name'             => _x('Video', 'backend video', LANGUAGE_ZONE)
);

// settings
$args = array(
    'labels'                => $labels,
    'public'                => true,
    'publicly_queryable'    => true,
    'show_ui'               => true, 
    'show_in_menu'          => true, 
    'query_var'             => true,
    'rewrite'               => true,
    'capability_type'       => 'post',
    'has_archive'           => true, 
    'hierarchical'          => false,
    'menu_position'         => 28,
    'menu_icon'		        => DT_VIDEO_URI . '/images/admin_ico_gallery.png',
    'supports'              => array( 'title', 'thumbnail', 'excerpt' )
);
 
register_post_type( 'dt_video', $args );
/* post type end */

/* setup taxonomy */

// titles
$labels = array(
    'name'              => _x( 'Categories',            'backend video', LANGUAGE_ZONE ),
    'singular_name'     => _x( 'Category',              'backend video', LANGUAGE_ZONE ),
    'search_items'      => _x( 'Search in Category',    'backend video', LANGUAGE_ZONE ),
    'all_items'         => _x( 'Categories',            'backend video', LANGUAGE_ZONE ),
    'parent_item'       => _x( 'Parent Category',       'backend video', LANGUAGE_ZONE ),
    'parent_item_colon' => _x( 'Parent Category:',      'backend video', LANGUAGE_ZONE ),
    'edit_item'         => _x( 'Edit Category',         'backend video', LANGUAGE_ZONE ), 
    'update_item'       => _x( 'Update Category',       'backend video', LANGUAGE_ZONE ),
    'add_new_item'      => _x( 'Add New Category',      'backend video', LANGUAGE_ZONE ),
    'new_item_name'     => _x( 'New Category Name',     'backend video', LANGUAGE_ZONE ),
    'menu_name'         => _x( 'Categories',            'backend video', LANGUAGE_ZONE )
);

// settings
register_taxonomy(
    'dt_video_category',
    'dt_video',
    array(
        'hierarchical'          => true,
        'show_in_nav_menus '    => false,
        'public'                => false,
        'show_tagcloud'         => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'rewrite'               => true
    )
);
/* taxonomy end */

}
add_action('init', 'dt_video_setup_post_type');

?>
