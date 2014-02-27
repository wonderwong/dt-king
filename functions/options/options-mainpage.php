<?php
/*
 * options-mainpage.php
 */
$options[] = array( "page_title" => "外观", "menu_title" => "外观", "menu_slug" => "of-appearance-menu", "type" => "page" );

//BRANDING
$options[] = array( "name" => _x('品牌', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('头部 Logo', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    // logo
    $options[] = array(
        "name"  => '',
        "desc"  => '',
        "id"    => 'appearance-header_logo',
        "type"  => 'upload',
        'std'   => str_replace( site_url(), '', get_template_directory_uri() . '/images/origami/logo.png' )
    );

    // logo horizontal position
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Logo 位置', 'theme-options', LANGUAGE_ZONE),
        "id"        => "appearance-header_logo_position",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $h_arr
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('页脚 Logo', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    // logo
    $options[] = array(
        "name"  => '',
        "desc"  => '',
        "id"    => 'appearance-footer_logo',
        "type"  => 'upload',
        'std'   => str_replace( site_url(), '', get_template_directory_uri() . '/images/origami/logo-down.png' )
    );

    // logo horizontal position
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Logo 位置', 'theme-options', LANGUAGE_ZONE),
        "id"        => "appearance-footer_logo_position",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $h_arr
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('网站图标', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    // favicon
    $options[] = array( "name" => '', "desc" => '', "id" => "appearance-favicon", "type" => "upload" );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('版权 & 技术支持', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"  => '',
        "desc"  => _x('版权信息', 'theme-options', LANGUAGE_ZONE),
        "id"    => "appearance-copyrights",
        "std"   => false,
        "type"  => "textarea"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('技术支持', 'theme-options', LANGUAGE_ZONE),
        "id"        => "appearance-dt_credits",
        "std"       => "1",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );
    
    $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "desc"  => '谢谢支持！', "type" => "info" );
    
    $options[] = array( 'type' => 'js_hide_end' ); 

$options[] = array(	"type" => "block_end");

// MISC
$options[] = array( "name" => _x('Misc', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('头部显示联系信息', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('头部显示联系信息', 'theme-options', LANGUAGE_ZONE),
        "id"        => "misc-show_header_contacts",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );
    
    $contact_fields = array(
        array(
            'prefix'    => 'address',
            'desc'      => _x('地址', 'theme-options', LANGUAGE_ZONE) 
        ),
        array(
            'prefix'    => 'phone',
            'desc'      => _x('电话', 'theme-options', LANGUAGE_ZONE) 
        ),
        array(
            'prefix'    => 'email',
            'desc'      => _x('Email', 'theme-options', LANGUAGE_ZONE) 
        ),
        array(
            'prefix'    => 'skype',
            'desc'      => _x('Skype', 'theme-options', LANGUAGE_ZONE) 
        ),
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        foreach( $contact_fields as $field ) {
        
            $options[] = array(
                "name"      => '',
                "desc"      => $field['desc'],
                "id"        => "misc-contact_" . $field['prefix'],
                "std"       => "",
                "type"      => "text",
                'sanitize'  => false
            );

        }

    $options[] = array(	"type" => "block_end");

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('显示 下一个/上一个 链接', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    // show prev/next in post
    $options[] = array(
        "name"  => "",
        "desc"  => _x('文章页面', 'theme-options', LANGUAGE_ZONE),
        "id"    => "misc-show_next_prev_post",
        "std"   => "1",
        "type"  => "checkbox"
    );

	// show prev/next in portfolio
    $options[] = array(
        "name"  => "",
        "desc"  => _x('产品页面', 'theme-options', LANGUAGE_ZONE),
        "id"    => "misc-show_next_prev_portfolio",
        "std"   => "1",
        "type"  => "checkbox"
    );
	
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('顶行搜索表单', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    // show search
    $options[] = array(
        "name"  => "",
        "desc"  => _x('显示搜索表单', 'theme-options', LANGUAGE_ZONE),
        "id"    => "misc-show_search_top",
        "std"   => "1",
        "type"  => "checkbox"
    );
	
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('文章选项', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    // show author details
    $options[] = array(
        "name"  => "",
        "desc"  => _x('文章页显示作者信息', 'theme-options', LANGUAGE_ZONE),
        "id"    => "misc-show_author_details",
        "std"   => "1",
        "type"  => "checkbox"
    );
	
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('父菜单可点击', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    // parent menu clickable
    $options[] = array(
        "name"  => "",
        "desc"  => _x('启用', 'theme-options', LANGUAGE_ZONE),
        "id"    => "misc-parent_menu_clickable",
        "std"   => "0",
        "type"  => "checkbox"
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('谷歌分析', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"      => '',
        "desc"      => _x('谷歌分析代码', 'theme-options', LANGUAGE_ZONE),
        "id"        => "misc-analitics_code",
        "std"       => false,
        "type"      => "textarea",
        "sanitize"  => false
    );

$options[] = array(	"type" => "block_end");
