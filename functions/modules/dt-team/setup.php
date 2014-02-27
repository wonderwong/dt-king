<?php

/* setup post type sector */
function dt_team_setup_post_type() {

// titles
$labels = array(
    'name'                  => _x('Team',              'backend team', LANGUAGE_ZONE),
    'singular_name'         => _x('Team',              'backend team', LANGUAGE_ZONE),
    'add_new'               => _x('Add New',                'backend team', LANGUAGE_ZONE),
    'add_new_item'          => _x('Add New Teammate',           'backend team', LANGUAGE_ZONE),
    'edit_item'             => _x('Edit Teammate',              'backend team', LANGUAGE_ZONE),
    'new_item'              => _x('New Teammate',               'backend team', LANGUAGE_ZONE),
    'view_item'             => _x('View Teammate',              'backend team', LANGUAGE_ZONE),
    'search_items'          => _x('Search Teammates',           'backend team', LANGUAGE_ZONE),
    'not_found'             => _x('No teammates found',         'backend team', LANGUAGE_ZONE),
    'not_found_in_trash'    => _x('No Teammates found in Trash','backend team', LANGUAGE_ZONE), 
    'parent_item_colon'     => '',
    'menu_name'             => _x('Team', 'backend team', LANGUAGE_ZONE)
);

$img = DT_TEAM_URI. '/images/admin_ico_team.png';

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
register_post_type( 'dt_team', $args );
/* post type end */

/* setup taxonomy */

// titles
$labels = array(
    'name'              => _x( 'Categories',        'backend team', LANGUAGE_ZONE ),
    'singular_name'     => _x( 'Category',          'backend team', LANGUAGE_ZONE ),
    'search_items'      => _x( 'Search in Category','backend team', LANGUAGE_ZONE ),
    'all_items'         => _x( 'Categories',        'backend team', LANGUAGE_ZONE ),
    'parent_item'       => _x( 'Parent Category',   'backend team', LANGUAGE_ZONE ),
    'parent_item_colon' => _x( 'Parent Category:',  'backend team', LANGUAGE_ZONE ),
    'edit_item'         => _x( 'Edit Category',     'backend team', LANGUAGE_ZONE ), 
    'update_item'       => _x( 'Update Category',   'backend team', LANGUAGE_ZONE ),
    'add_new_item'      => _x( 'Add New Category',  'backend team', LANGUAGE_ZONE ),
    'new_item_name'     => _x( 'New Category Name', 'backend team', LANGUAGE_ZONE ),
    'menu_name'         => _x( 'Categories',        'backend team', LANGUAGE_ZONE )
); 	

register_taxonomy(
    'dt_team_category',
    array( 'dt_team' ),
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
add_action('init', 'dt_team_setup_post_type');

?>
