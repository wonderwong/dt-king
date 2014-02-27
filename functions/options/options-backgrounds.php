<?php
//
// options-backgrounds.php
//

$options[] = array( "page_title" => "背景", "menu_title" => "背景", "menu_slug" => "of-backgrounds-menu", "type" => "page" );

$options[] = array( "name" => _x('内容区域', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('主要背景', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    // bg color
    $options[] = array(
        "name"  => '',
        "desc"  => _x('背景颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "main_bg-bg_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    // bg image
    $options[] = array(
        "name"      => '',
        "desc"      => _x('选择背景图片', 'theme-options', LANGUAGE_ZONE),
        "id"        => "background-bg_image",
        "std"       => 'none',
        "type"      => "images",
        "options"   => dt_get_images_in( 'images/backgrounds/content/pattern-main', 'images/backgrounds' )
    );

    // upload bg					
    $options[] = array(
        "name"      => '',
        "desc"      => _x('... 使用上传的图片', 'theme-options', LANGUAGE_ZONE),
        "id"        => "main_bg-bg_upload",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        // uploader
        $options[] = array( "name" => "", "desc" => "", "id" => "main_bg-bg_custom", "type" => "upload" );

    $options[] = array( 'type' => 'js_hide_end' ); 

    // repeat
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Repeat', 'theme-options', LANGUAGE_ZONE),
        "id"        => "main_bg-bg_repeat",
        "std"       => "repeat",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $fl_arr
    );

    // vertical
    $options[] = array(
        "name"      => '',
        "desc"      => _x('垂直位置', 'theme-options', LANGUAGE_ZONE),
        "id"        => "main_bg-bg_vertical_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $v_arr
    );

    // horizontal
    $options[] = array(
        "name"      => '',
        "desc"      => _x('水平位置', 'theme-options', LANGUAGE_ZONE),
        "id"        => "main_bg-bg_horizontal_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $h_arr
    );
	
	// fixed background				
    $options[] = array(
        "name"      => '',
        "desc"      => _x('固定背景', 'theme-options', LANGUAGE_ZONE),
        "id"        => "main_bg-bg_fixed",
        "std"       => "0",
        "type"      => "checkbox"
    );

$options[] = array(	"type" => "block_end");

    $divs_and_heads = array(
/*        array(
            'img_desc'  => _x('Headers underline', 'theme-options', LANGUAGE_ZONE),
            'img_std'   => 'none',
            'img_opts'  => dt_get_images_in('images/dividers/content/underline'),
            'prefix'    => 'header_under'
        ),
 */
        array(
            'img_desc'   => _x('Choose thick divider', 'theme-options', LANGUAGE_ZONE),
            'img_std'    => 'none',
            'img_opts'   => dt_get_images_in( 'images/backgrounds/content/div-big', 'images/backgrounds' ),
            'prefix'     => 'wide_divider',
            'block_name' => 'Thick divider'
        ),
        array(
            'img_desc'   => _x('Choose thin divider', 'theme-options', LANGUAGE_ZONE),
            'img_std'    => 'none',
            'img_opts'   => dt_get_images_in( 'images/backgrounds/content/div-small', 'images/backgrounds' ),
            'prefix'     => 'narrow_divider',
            'block_name' => 'Thin divider'
        )
    );
    
    foreach( $divs_and_heads as $opts_set ) {
		
		$options[] = array(	"name" => _x($opts_set['block_name'], 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");
        
        $opts_set['prefix'] = 'content_' . $opts_set['prefix'];

        $options[] = array(
            "name"      => '',
            "desc"      => $opts_set['img_desc'],
            "id"        => "divs_and_heads-" . $opts_set['prefix'],
            "std"       => $opts_set['img_std'], 
            "type"      => "images",
            "options"   => $opts_set['img_opts'] 
        );

        $options[] = array(
            "name"      => '',
            "desc"      => _x('... or upload your own image', 'theme-options', LANGUAGE_ZONE),
            "id"        => "divs_and_heads-{$opts_set['prefix']}_upload",
            "std"       => "0",
            "type"      => "checkbox",
            'options'   => array( 'java_hide' => true )
        );

        $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "name" => "", "desc" => "", "id" => "divs_and_heads-{$opts_set['prefix']}_custom", "type" => "upload");

        $options[] = array( 'type' => 'js_hide_end' ); 

        $options[] = array(
            "name"  => '',
            "desc"  => _x('Repeat-x', 'theme-options', LANGUAGE_ZONE),
            "id"    => "divs_and_heads-{$opts_set['prefix']}_repeatx",
            "std"   => "0",
            "type"  => "checkbox"
        );

        $options[] = array( "type" => "block_end");
    }

$options[] = array(	"name" => _x('小工具/短代码 背景', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"  => '',
        "desc"  => _x('背景颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "widgetcodes-bg_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('背景透明度', 'theme-options', LANGUAGE_ZONE),
        "id"        => "widgetcodes-bg_opacity",
        "std"       => 0, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );

$options[] = array(	"type" => "block_end");

$options[] = array( "name" => _x('Headers', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('首页头部', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"      => '',
        "desc"      => _x('选择背景图片', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_homepage-bg_image",
        "std"       => 'none', 
        "type"      => "images",
        "options"   => dt_get_images_in( 'images/backgrounds/header/art-header-main', 'images/backgrounds' ) 
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('...使用上传的图片', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_homepage-bg_upload",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "name" => "", "desc" => "", "id" => "header_homepage-bg_custom", "type" => "upload" );

    $options[] = array( 'type' => 'js_hide_end' ); 

    // repeat
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Repeat', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_homepage-bg_repeat",
        "std"       => "no-repeat",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $fl_arr
    );

    // vertical
    $options[] = array(
        "name"      => '',
        "desc"      => _x('垂直位置', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_homepage-bg_vertical_pos",
        "std"       => "top",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $v_arr
    );

    // horizontal
    $options[] = array(
        "name"      => '',
        "desc"      => _x('水平位置', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_homepage-bg_horizontal_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $h_arr
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('内容页头部', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"      => '',
        "desc"      => _x('选择背景图片', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_content-bg_image",
        "std"       => 'none', 
        "type"      => "images",
        "options"   => dt_get_images_in( 'images/backgrounds/header/art-header-inner', 'images/backgrounds' ) 
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('...使用上传的图片', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_content-bg_upload",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "name" => "", "desc" => "", "id" => "header_content-bg_custom", "type" => "upload" );

    $options[] = array( 'type' => 'js_hide_end' ); 

    // repeat
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Repeat', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_content-bg_repeat",
        "std"       => "no-repeat",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $fl_arr
    );

    // vertical
    $options[] = array(
        "name"      => '',
        "desc"      => _x('垂直位置', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_content-bg_vertical_pos",
        "std"       => "top",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $v_arr
    );

    // horizontal
    $options[] = array(
        "name"      => '',
        "desc"      => _x('水平位置', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_content-bg_horizontal_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $h_arr
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Background under contact block', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"  => '',
        "desc"  => _x('背景颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "contact-bg_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('背景透明度', 'theme-options', LANGUAGE_ZONE),
        "id"        => "contact-bg_opacity",
        "std"       => 0, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('顶行背景', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"  => '',
        "desc"  => _x('背景颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "top_line-bg_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('背景透明度', 'theme-options', LANGUAGE_ZONE),
        "id"        => "top_line-bg_opacity",
        "std"       => 100, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('选择背景图片', 'theme-options', LANGUAGE_ZONE),
        "id"        => "top_line-bg_image",
        "std"       => 'none', 
        "type"      => "images",
        "options"   => dt_get_images_in( 'images/backgrounds/header/line-top', 'images/backgrounds' ) 
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('...使用上传的图片', 'theme-options', LANGUAGE_ZONE),
        "id"        => "top_line-bg_upload",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "name" => "", "desc" => "", "id" => "top_line-bg_custom", "type" => "upload" );

    $options[] = array( 'type' => 'js_hide_end' ); 

    // repeat
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Repeat', 'theme-options', LANGUAGE_ZONE),
        "id"        => "top_line-bg_repeat",
        "std"       => "repeat",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $fl_arr
    );

    // vertical
    $options[] = array(
        "name"      => '',
        "desc"      => _x('垂直位置', 'theme-options', LANGUAGE_ZONE),
        "id"        => "top_line-bg_vertical_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $v_arr
    );

    // horizontal
    $options[] = array(
        "name"      => '',
        "desc"      => _x('水平位置', 'theme-options', LANGUAGE_ZONE),
        "id"        => "top_line-bg_horizontal_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $h_arr
    );

$options[] = array(	"type" => "block_end");

/*
 *  Parallax
 */
$options[] = array( "name" => _x('Parallax', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('鼠标响应视差背景', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"      => '',
        "desc"      => _x('开启', 'theme-options', LANGUAGE_ZONE),
        "id"        => "mr_parallax-enable",
        "std"       => "1",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );

    $options[] = array( 'type' => 'js_hide_begin' );
   
        $options[] = array(
            "name"      => '',
            "desc"      => _x('动画', 'theme-options', LANGUAGE_ZONE),
            "id"        => "mr_parallax-animate",
            "std"       => "every",
            "type"      => "select",
            "class"     => "mini",
            "options"   => $homepage_arr
        );

        $options[] = array(
            "name"      => '',
            "desc"      => _x('显示', 'theme-options', LANGUAGE_ZONE),
            "id"        => "mr_parallax-show",
            "std"       => "every",
            "type"      => "select",
            "class"     => "mini",
            "options"   => $homepage_arr
        );

        $options[] = array(
            "name"  => '',
            "desc"  => _x('视差背景粘住', 'theme-options', LANGUAGE_ZONE),
            "id"    => "mr_parallax-fixed",
            "std"   => "0",
            "type"  => "checkbox"
        );

    $options[] = array( 'type' => 'js_hide_end' ); 

$options[] = array(	"type" => "block_end");

$parallax_lvls = array(
    array(
        'name'          => 'first_level',
        'block_name'    => _x('第一级', 'theme-options', LANGUAGE_ZONE),
        'img_opts'      => dt_get_images_in( 'images/backgrounds/parallax/p1', 'images/backgrounds' ),
        'img_std'       => 'none'
    ),
    array(
        'name'          => 'second_level',
        'block_name'    => _x('第二级', 'theme-options', LANGUAGE_ZONE),
        'img_opts'      => dt_get_images_in( 'images/backgrounds/parallax/p2', 'images/backgrounds' ),
        'img_std'       => 'none'
    ),
    array(
        'name'          => 'third_level',
        'block_name'    => _x('第三级', 'theme-options', LANGUAGE_ZONE),
        'img_opts'      => dt_get_images_in('images/backgrounds/parallax/p3', 'images/backgrounds' ),
        'img_std'       => 'none'
    ),
    array(
        'name'          => 'forth_level',
        'block_name'    => _x('第四级', 'theme-options', LANGUAGE_ZONE),
        'img_opts'      => dt_get_images_in('images/backgrounds/parallax/p4', 'images/backgrounds' ),
        'img_std'       => 'none'
    )
);

foreach( $parallax_lvls as $level ) {
    
    $options[] = array(	"name" => $level['block_name'], "type" => "block_begin");

        $options[] = array(
            "name"      => '',
            "desc"      => _x('选择背景图片', 'theme-options', LANGUAGE_ZONE),
            "id"        => $level['name'] . "-bg_image",
            "std"       => $level['img_std'], 
            "type"      => "images",
            "options"   => $level['img_opts'] 
        );

        $options[] = array(
            "name"      => '',
            "desc"      => _x('...使用上传的图片', 'theme-options', LANGUAGE_ZONE),
            "id"        => $level['name'] . "-bg_upload",
            "std"       => "0",
            "type"      => "checkbox",
            'options'   => array( 'java_hide' => true )
        );

        $options[] = array( 'type' => 'js_hide_begin' );

            $options[] = array( "name" => "", "desc" => "", "id" => $level['name'] . "-bg_custom", "type" => "upload" );

        $options[] = array( 'type' => 'js_hide_end' ); 

        // repeat
        $options[] = array(
            "name"      => '',
            "desc"      => _x('Repeat', 'theme-options', LANGUAGE_ZONE),
            "id"        => $level['name'] . "-bg_repeat",
            "std"       => "no-repeat",
            "type"      => "select",
            "class"     => "mini",
            "options"   => $repeat_x_arr
        );

        // horizontal
        $options[] = array(
            "name"      => '',
            "desc"      => _x('垂直位置', 'theme-options', LANGUAGE_ZONE),
            "id"        => $level['name'] . "-bg_horizontal_pos",
            "std"       => "center",
            "type"      => "select",
            "class"     => "mini",
            "options"   => $h_arr
        );

    $options[] = array(	"type" => "block_end");

}

/*
 * Footer
 */
$options[] = array( "name" => _x('Footer', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('页脚背景', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"  => '',
        "desc"  => _x('背景颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "footer-bg_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('选择背景图片', 'theme-options', LANGUAGE_ZONE),
        "id"        => "footer-bg_image",
        "std"       => 'none', 
        "type"      => "images",
        "options"   => dt_get_images_in( 'images/backgrounds/footer/pattern-footer', 'images/backgrounds' ) 
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('...使用上传的图片', 'theme-options', LANGUAGE_ZONE),
        "id"        => "footer-bg_upload",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "name" => "", "desc" => "", "id" => "footer-bg_custom", "type" => "upload" );

    $options[] = array( 'type' => 'js_hide_end' ); 

    // repeat
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Repeat', 'theme-options', LANGUAGE_ZONE),
        "id"        => "footer-bg_repeat",
        "std"       => "repeat",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $fl_arr
    );

    // vertical
    $options[] = array(
        "name"      => '',
        "desc"      => _x('垂直位置', 'theme-options', LANGUAGE_ZONE),
        "id"        => "footer-bg_vertical_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $v_arr
    );

    // horizontal
    $options[] = array(
        "name"      => '',
        "desc"      => _x('水平位置', 'theme-options', LANGUAGE_ZONE),
        "id"        => "footer-bg_horizontal_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $h_arr
    );

$options[] = array(	"type" => "block_end");

    $divs_and_heads[0]['img_desc'] = _x('选择装饰线', 'theme-options', LANGUAGE_ZONE);
    $divs_and_heads[0]['img_opts'] = dt_get_images_in( 'images/backgrounds/footer/line-decor', 'images/backgrounds' );
    $divs_and_heads[0]['block_name'] = '页脚上方装饰线';
/*
    unset($divs_and_heads[1]);
    $divs_and_heads[1]['img_desc'] = _x('Headers underline', 'theme-options', LANGUAGE_ZONE);
    $divs_and_heads[1]['img_opts'] = dt_get_images_in('images/dividers/footer/underline');
 */
 
/* Dividers here */

    $divs_and_heads[1]['img_desc'] = _x('选择分隔物', 'theme-options', LANGUAGE_ZONE);
    $divs_and_heads[1]['img_opts'] = dt_get_images_in( 'images/backgrounds/footer/div-footer', 'images/backgrounds' );
    $divs_and_heads[1]['block_name'] = '页脚小工具分隔物';

    foreach( $divs_and_heads as $opts_set ) {
		
        $options[] = array(	"name" => _x($opts_set['block_name'], 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

        $opts_set['prefix'] = 'footer_' . $opts_set['prefix'];

        $options[] = array(
            "name"      => '',
            "desc"      => $opts_set['img_desc'],
            "id"        => "divs_and_heads-" . $opts_set['prefix'],
            "std"       => $opts_set['img_std'], 
            "type"      => "images",
            "options"   => $opts_set['img_opts'] 
        );

        $options[] = array(
            "name"      => '',
            "desc"      => _x('...使用上传的图片', 'theme-options', LANGUAGE_ZONE),
            "id"        => "divs_and_heads-{$opts_set['prefix']}_upload",
            "std"       => "0",
            "type"      => "checkbox",
            'options'   => array( 'java_hide' => true )
        );

        $options[] = array( 'type' => 'js_hide_begin' );

            $options[] = array( "name" => "", "desc" => "", "id" => "divs_and_heads-{$opts_set['prefix']}_custom", "type" => "upload");

        $options[] = array( 'type' => 'js_hide_end' ); 

        $options[] = array(
            "name"  => '',
            "desc"  => _x('Repeat-x', 'theme-options', LANGUAGE_ZONE),
            "id"    => "divs_and_heads-{$opts_set['prefix']}_repeatx",
            "std"   => "0",
            "type"  => "checkbox"
        );

        $options[] = array(	"type" => "block_end");
    }

$options[] = array(	"name" => _x('页脚小工具背景', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"  => '',
        "desc"  => _x('背景颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "widgetcodes_footer-bg_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('背景透明度', 'theme-options', LANGUAGE_ZONE),
        "id"        => "widgetcodes_footer-bg_opacity",
        "std"       => 0, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('底行背景', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"  => '',
        "desc"  => _x('背景颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "bottom_line-bg_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('背景透明度', 'theme-options', LANGUAGE_ZONE),
        "id"        => "bottom_line-bg_opacity",
        "std"       => 17, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('选择背景图片', 'theme-options', LANGUAGE_ZONE),
        "id"        => "bottom_line-bg_image",
        "std"       => 'none', 
        "type"      => "images",
        "options"   => dt_get_images_in( 'images/backgrounds/footer/line-bottom', 'images/backgrounds' ) 
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('...使用上传的图片', 'theme-options', LANGUAGE_ZONE),
        "id"        => "bottom_line-bg_upload",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "name" => "", "desc" => "", "id" => "bottom_line-bg_custom", "type" => "upload" );

    $options[] = array( 'type' => 'js_hide_end' ); 

    // repeat
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Repeat', 'theme-options', LANGUAGE_ZONE),
        "id"        => "bottom_line-bg_repeat",
        "std"       => "repeat",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $fl_arr
    );

    // vertical
    $options[] = array(
        "name"      => '',
        "desc"      => _x('垂直位置', 'theme-options', LANGUAGE_ZONE),
        "id"        => "bottom_line-bg_vertical_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $v_arr
    );

    // horizontal
    $options[] = array(
        "name"      => '',
        "desc"      => _x('水平位置', 'theme-options', LANGUAGE_ZONE),
        "id"        => "bottom_line-bg_horizontal_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $h_arr
    );

$options[] = array(	"type" => "block_end");
