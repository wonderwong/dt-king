<?php
/*
 * Captcha options
 */
$options[] = array( "page_title" => "验证码", "menu_title" => "验证码", "menu_slug" => "of-captcha-menu", "type" => "page" );

$options[] = array( "name" => _x('验证码设置', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

// enable for
$options[] = array(	"name" => __( '启用验证码:', 'dt-options-name'),
					"type" => "block_begin" );                    

// hide for register
$options[] = array( "name" => "",
                    "desc" => __( "注册用户不显示", 'dt-options-desc' ),
                    "id" => "captcha_hide_register",
                    "std" => "1",
                    "type" => "checkbox" );
  /*                  
// for contact form
$options[] = array( "name" => "",
                    "desc" => __( "contact form", 'dt-options-desc' ),
                    "id" => "captcha_contact_form",
                    "std" => "1",
                    "type" => "checkbox" );

// for contact form
$options[] = array( "name" => "",
                    "desc" => __( "get in touch widget", 'dt-options-desc' ),
                    "id" => "captcha_contact_widget",
                    "std" => "1",
                    "type" => "checkbox" );
   */
$options[] = array(	"type" => "block_end" );
/*
$options[] = array( "name"  => '',
                    "desc"  => "label vor CAPTCHA in form",
                    "id"    => "captcha_label_form",
                    "std"   => '',
                    "type"  => "text" );
 */
// arithmetic
$options[] = array(	"name" => __( '验证码算术操作:', 'dt-options-name'),
					"type" => "block_begin");
/*
// plus
$options[] = array( "name" => "",
                    "desc" => __( "plus (+)", 'dt-options-desc' ),
                    "id" => "captcha_math_action_plus",
                    "std" => "1",
                    "type" => "checkbox" );
*/
// minus
$options[] = array( "name" => "",
                    "desc" => __( "减 (-)", 'dt-options-desc' ),
                    "id" => "captcha_math_action_minus",
                    "std" => "1",
                    "type" => "checkbox" );
                    
// multiply
$options[] = array( "name" => "",
                    "desc" => __( "乘 (x)", 'dt-options-desc' ),
                    "id" => "captcha_math_action_increase",
                    "std" => "1",
                    "type" => "checkbox" );
                    
$options[] = array(	"type" => "block_end");

// difficulty
$options[] = array(	"name" => __( '困难验证码:', 'dt-options-name'),
					"type" => "block_begin");
                    
// numbers
$options[] = array( "name" => "",
                    "desc" => __( "数字", 'dt-options-desc' ),
                    "id" => "captcha_difficulty_number",
                    "std" => "1",
                    "type" => "checkbox" );
                    
// words
$options[] = array( "name" => "",
                    "desc" => __( "文字", 'dt-options-desc' ),
                    "id" => "captcha_difficulty_word",
                    "std" => "1",
                    "type" => "checkbox" );
                    
$options[] = array(	"type" => "block_end");
?>
