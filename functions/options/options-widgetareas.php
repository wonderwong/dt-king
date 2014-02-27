<?php

// new subpage
$options[] = array( "page_title" => "小工具区", "menu_title" => "小工具区", "menu_slug" => "of-widgetareas-menu", "type" => "page" );

$options[] = array( "name" => _x("小工具区", 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('小工具区', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

$options[] = array(
    'name'      => '',
    'desc'      => '',
    'id'        => 'of_generatortest2',
    'type'      => 'fields_generator',
    'std'       => array(
        1 => array(
                'sidebar_name'  => '默认侧边栏',
                'sidebar_desc'  => __('Sidebar primary widget area', LANGUAGE_ZONE)
        ),
        2 => array(
                'sidebar_name'  => '默认页脚',
                'sidebar_desc'  => __('Footer primary widget area', LANGUAGE_ZONE)
        ),
        3 => array(
                'sidebar_name'  => '文章侧边栏',
                'sidebar_desc'  => __('Single post page sidebar', LANGUAGE_ZONE)
        ),
        4 => array(
                'sidebar_name'  => 'Catalog文章侧边栏',
                'sidebar_desc'  => __('Single catalog item page sidebar', LANGUAGE_ZONE)
        ),
        5 => array(
                'sidebar_name'  => '文章页脚',
                'sidebar_desc'  => __('Single post page footer', LANGUAGE_ZONE)
        ),
        6 => array(
                'sidebar_name'  => 'Catalog文章页脚',
                'sidebar_desc'  => __('Single catalog item page footer', LANGUAGE_ZONE)
        ),
		7 => array(
                'sidebar_name'  => 'Portfolio文章页脚',
                'sidebar_desc'  => __('Single portfolio project page footer', LANGUAGE_ZONE)
        )
    ),
    'options'   => array(
        'fields' => array(
            'sidebar_name'   => array(
                'type'          => 'text',
                'class'         => 'of_fields_gen_title',
                'description'   => 'Sidebar name',
                'wrap'          => '<label>%2$s%1$s</label>',
                'desc_wrap'     => '%2$s'
            ),
            'sidebar_desc'   => array(
                'type'          => 'textarea',
                'description'   => 'Sidebar description (optional)',
                'wrap'          => '<label>%2$s%1$s</label>',
                'desc_wrap'     => '%2$s'
            )
        )
    )
);

$options[] = array(	"type" => "block_end");
