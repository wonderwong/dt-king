<?php

/* setup post type sector */
function dt_benefits_setup_posttype() {

// titles
$labels = array(
    'name'                  => _x('Benefits',              'backend benefits', LANGUAGE_ZONE),
    'singular_name'         => _x('Benefits',              'backend benefits', LANGUAGE_ZONE),
    'add_new'               => _x('Add New',                'backend benefits', LANGUAGE_ZONE),
    'add_new_item'          => _x('Add New Item',           'backend benefits', LANGUAGE_ZONE),
    'edit_item'             => _x('Edit Item',              'backend benefits', LANGUAGE_ZONE),
    'new_item'              => _x('New Item',               'backend benefits', LANGUAGE_ZONE),
    'view_item'             => _x('View Item',              'backend benefits', LANGUAGE_ZONE),
    'search_items'          => _x('Search Items',           'backend benefits', LANGUAGE_ZONE),
    'not_found'             => _x('No items found',         'backend benefits', LANGUAGE_ZONE),
    'not_found_in_trash'    => _x('No items found in Trash','backend benefits', LANGUAGE_ZONE), 
    'parent_item_colon'     => '',
    'menu_name'             => _x('Benefits', 'backend benefits', LANGUAGE_ZONE)
);

$img = DT_BENEFITS_URI. '/images/admin_ico_benefits.png';

// options
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
    'menu_position'         => 27,
    'menu_icon'             => $img,
    'supports'              => array( 'title', 'editor', 'thumbnail' )
);
register_post_type( 'dt_benefits', $args );
/* post type end */

/* setup taxonomy */

// titles
$labels = array(
    'name'              => _x( 'Categories',        'backend benefits', LANGUAGE_ZONE ),
    'singular_name'     => _x( 'Category',          'backend benefits', LANGUAGE_ZONE ),
    'search_items'      => _x( 'Search in Category','backend benefits', LANGUAGE_ZONE ),
    'all_items'         => _x( 'Categories',        'backend benefits', LANGUAGE_ZONE ),
    'parent_item'       => _x( 'Parent Category',   'backend benefits', LANGUAGE_ZONE ),
    'parent_item_colon' => _x( 'Parent Category:',  'backend benefits', LANGUAGE_ZONE ),
    'edit_item'         => _x( 'Edit Category',     'backend benefits', LANGUAGE_ZONE ), 
    'update_item'       => _x( 'Update Category',   'backend benefits', LANGUAGE_ZONE ),
    'add_new_item'      => _x( 'Add New Category',  'backend benefits', LANGUAGE_ZONE ),
    'new_item_name'     => _x( 'New Category Name', 'backend benefits', LANGUAGE_ZONE ),
    'menu_name'         => _x( 'Categories',        'backend benefits', LANGUAGE_ZONE )
); 	

register_taxonomy(
    'dt_benefits_category',
    array( 'dt_benefits' ),
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

add_action('init', 'dt_benefits_setup_posttype');

?>
