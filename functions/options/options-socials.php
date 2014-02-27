<?php
/*
 * options-socials.php
 */
$options[] = array( "page_title" => "社交工具", "menu_title" => "社交工具", "menu_slug" => "of-socials-menu", "type" => "page" );

$options[] = array( "name" => _x('社交工具', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('社交工具', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

$soc_ico_arr = dt_get_fonts_in( 'images/soc-ico' );

$options[] = array(
    'id'        => 'social_icons',
    'type'      => 'social_icon',
    'std'       => '',
    'options'   => array(
        'fields'        => $soc_ico_arr,
        'ico_height'    => 20,
        'ico_width'     => 20
    )
);

$options[] = array(	"type" => "block_end");
