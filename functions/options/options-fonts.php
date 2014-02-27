<?php
/*
 * Fonts
 */
$options[] = array( "page_title" => "字体", "menu_title" => "字体", "menu_slug" => "of-fonts-menu", "type" => "page" );

$options[] = array( "name" => _x('字体', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('基本字体类型', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"      => '',
        "desc"      =>  _x('选择字体', 'theme-options', LANGUAGE_ZONE),
        "id"        => "fonts-font_family",
        "std"       => "Trebuchet_MS",
        "type"      => "select",
        "class"     => "mini",
        "options"   => array(
            'Andale_Mono'                   => 'Andale Mono',
            'Arial'                         => 'Arial',
            'Arial_Bold'                    => 'Arial Bold',
            'Arial_Italic'                  => 'Arial Italic',
            'Arial_Bold_Italic'             => 'Arial Bold Italic',
            'Arial_Black'                   => 'Arial Black',
            'Comic_Sans_MS'                 => 'Comic Sans MS',
            'Comic_Sans_MS_Bold'            => 'Comic Sans MS Bold',
            'Courier_New'                   => 'Courier New',
            'Courier_New_Bold'              => 'Courier New Bold',
            'Courier_New_Italic'            => 'Courier New Italic',
            'Courier_New_Bold_Italic'       => 'Courier New Bold Italic',
            'Georgia'                       => 'Georgia',
            'Georgia_Bold'                  => 'Georgia Bold',
            'Georgia_Italic'                => 'Georgia Italic',
            'Georgia_Bold_Italic'           => 'Georgia Bold Italic',
            'Impact_Lucida_Console'         => 'Impact Lucida Console',
            'Lucida_Sans_Unicode'           => 'Lucida Sans Unicode',
            'Marlett'                       => 'Marlett',
            'Minion_Web'                    => 'Minion Web',
            'Symbol'                        => 'Symbol',
            'Times_New_Roman'               => 'Times New Roman',
            'Times_New_Roman_Bold'          => 'Times New Roman Bold',
            'Times_New_Roman_Italic'        => 'Times New Roman Italic',
            'Times_New_Roman_Bold_Italic'   => 'Times New Roman Bold Italic',
            'Tahoma'                        => 'Tahoma',
            'Trebuchet_MS'                  => 'Trebuchet MS',
            'Trebuchet_MS_Bold'             => 'Trebuchet MS Bold',
            'Trebuchet_MS_Italic'           => 'Trebuchet MS Italic',
            'Trebuchet_MS_Bold_Italic'      => 'Trebuchet MS Bold Italic',
            'Verdana'                       => 'Verdana',
            'Verdana_Bold'                  => 'Verdana Bold',
            'Verdana_Italic'                => 'Verdana Italic',
            'Verdana_Bold_Italic'           => 'Verdana Bold Italic',
            'Webdings'                      => 'Webdings'
        ) 
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('主菜单和按钮', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('链接颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts-links_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('活动链接颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts-hover_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('顶行', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('文本颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-topline_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('文本阴影', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-topline_shadow_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('头部联系信息', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('文本颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-contacts_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('文本阴影', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-contacts_shadow_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('内容区域', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('主要文本颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-primary_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('主要文本阴影', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-primary_shadow_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('次要文本颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-secondary_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('次要文本阴影', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-secondary_shadow_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('页脚', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('主要文本颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_footer-primary_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('主要文本阴影', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_footer-primary_shadow_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('次要文本颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_footer-secondary_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('次要文本阴影', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_footer-secondary_shadow_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('底行', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('文本颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-bottomline_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('文本阴影', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-bottomline_shadow_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('标题 (h1-h6) 字体', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('启用 cufon', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts-enable_cufon",
        "std"   => "1",
        "type"  => "checkbox"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('选择 cufon 字体', 'theme-options', LANGUAGE_ZONE),
        "id"        => "fonts-list",
        "std"       => "/js/fonts/Pacifico_400.font.js",
        "type"      => "select",
        "class"     => "mini",
        "options"   => dt_get_fonts_in( 'js/fonts' )
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('...使用上传的 cufon 字体', 'theme-options', LANGUAGE_ZONE),
        "id"        => "fonts-upload",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );
	
    $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "name" => "", "desc"  => '', "id" => "fonts-custom", "type" => "upload" );
    
    $options[] = array( 'type' => 'js_hide_end' ); 
/*
    $header_sizes = array( 
        '12' => 12,
        '14' => 14,
        '15' => 15,
        '16' => 16,
        '17' => 17,
        '18' => 18,
        '20' => 20,
        '22' => 22,
        '24' => 24,
        '26' => 26,
        '28' => 28,
        '20' => 20,
        '32' => 32,
        '34' => 34,
        '36' => 36,
        '40' => 40
    );
 */
 
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('标题大小', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $headers = array(
        'h1'    => array( 'desc' => 'H1', 'std' => 32 ), 
        'h2'    => array( 'desc' => 'H2', 'std' => 24 ), 
        'h3'    => array( 'desc' => 'H3', 'std' => 20 ),
        'h4'    => array( 'desc' => 'H4', 'std' => 17 ),
        'h5'    => array( 'desc' => 'H5', 'std' => 15 ),
        'h6'    => array( 'desc' => 'H6', 'std' => 12 )
    );
    
    foreach( $headers as $name=>$data) {
        $options[] = array(
            "name"      => '',
            "desc"      => $data['desc'],
            "id"        => "fonts-headers_size_" . $name,
            "std"       => $data['std'],
            "type"      => "text",
            "class"     => "mini"
        );
    }//end foreach
	
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('内容区域标题颜色', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('文本梯度:顶层颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-headers_top_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('文本梯度:底层颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-headers_bottom_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('文本阴影颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-headers_shadow_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('页脚标题颜色', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('文本梯度:顶层颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_footer-headers_top_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('文本梯度:底层颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_footer-headers_bottom_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('文本阴影颜色', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_footer-headers_shadow_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

$options[] = array(	"type" => "block_end");
