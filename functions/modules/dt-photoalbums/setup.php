<?php

/* setup post type sector */
function dt_gallery_post_type() {

// title
$labels = array(
    'name'                  => _x('相册', 'backend albums', LANGUAGE_ZONE),
    'singular_name'         => _x('相册', 'backend albums', LANGUAGE_ZONE),
    'add_new'               => _x('添加', 'backend albums', LANGUAGE_ZONE),
    'add_new_item'          => _x('添加相册', 'backend albums', LANGUAGE_ZONE),
    'edit_item'             => _x('编辑', 'backend albums', LANGUAGE_ZONE),
    'new_item'              => _x('新相册', 'backend albums', LANGUAGE_ZONE),
    'view_item'             => _x('查看', 'backend albums', LANGUAGE_ZONE),
    'search_items'          => _x('搜索', 'backend albums', LANGUAGE_ZONE),
    'not_found'             => _x('没有找到', 'backend albums', LANGUAGE_ZONE),
    'not_found_in_trash'    => _x('回收站为空', 'backend albums', LANGUAGE_ZONE), 
    'parent_item_colon'     => '',
    'menu_name'             => _x('相册', 'backend albums', LANGUAGE_ZONE)
);

// settings
$args = array(
    'labels'                => $labels,
    'public'                => false,
    'publicly_queryable'    => false,
    'show_ui'               => true, 
    'show_in_menu'          => true, 
    'query_var'             => true,
    'rewrite'               => true,
    'capability_type'       => 'post',
    'has_archive'           => false, 
    'hierarchical'          => false,
    'menu_position'         => 28,
    'menu_icon'		        => DT_PHOTOALBUMS_URI . '/images/admin_ico_gallery.png',
    'supports'              => array( 'title', 'thumbnail', 'excerpt' )
);
 
register_post_type( 'dt_gallery', $args );
/* post type end */

/* setup taxonomy */

// titles
$labels = array(
    'name'              => _x( '分类目录',        'backend catalog', LANGUAGE_ZONE ),
    'singular_name'     => _x( '类别',		      'backend catalog', LANGUAGE_ZONE ),
    'search_items'      => _x( '分类搜索',        'backend catalog', LANGUAGE_ZONE ),
    'all_items'         => _x( '分类',            'backend catalog', LANGUAGE_ZONE ),
    'parent_item'       => _x( '父类别',		  'backend catalog', LANGUAGE_ZONE ),
    'parent_item_colon' => _x( '父类别:',		  'backend catalog', LANGUAGE_ZONE ),
    'edit_item'         => _x( '编辑类别',		  'backend catalog', LANGUAGE_ZONE ), 
    'update_item'       => _x( '更新类别',		  'backend catalog', LANGUAGE_ZONE ),
    'add_new_item'      => _x( '添加新分类目录',  'backend catalog', LANGUAGE_ZONE ),
    'new_item_name'     => _x( '新的分类名称',	  'backend catalog', LANGUAGE_ZONE ),
    'menu_name'         => _x( '分类目录',        'backend catalog', LANGUAGE_ZONE )
);

// settings
register_taxonomy(
    'dt_gallery_category',
    array( 'dt_gallery' ),
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
add_action('init', 'dt_gallery_post_type');

?>
