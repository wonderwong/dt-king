<?php
/*
//Our hook
add_shortcode('clear', 'clear');
add_shortcode('one-fourth', 'one_fourth');
add_shortcode('three-fourth', 'three_fourth');
add_shortcode('one-third', 'one_third');
add_shortcode('two-third', 'two_third');
add_shortcode('one-half', 'one_half');
 */
//add_action('init', 'addColumnsShorts');
add_action('admin_enqueue_scripts', 'addColumnsShorts');

function addColumnsShorts( $hook ) {
	if( 'post.php' != $hook )
		return;
    global $ShortcodeKidPath;
    wp_enqueue_script('custom_quicktags', $ShortcodeKidPath.'includes/columns/quicktags.js', array('quicktags'), '1.0');
}

//our TinyMCE
include('tinyMCE.php');
/*
// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_columns',
    'columns',
    false
);

// ajax content
function dt_ajax_editor_columns() {
    $html = '';
    $col_list = array(
        'one-fourth'    => '1/4',
        'three-fourth'  => '3/4',
        'one-third'     => '1/3',
        'two-third'     => '2/3',
        'one-half'      => '1/2'
    );
    $sel_style_name = 'style';
    $chk_last_name = 'last';
    $chk_frame_name = 'frame';
    $chk_align_name = 'align';
    $txa_edt_content = 'ed_content';
    
    $html .= '<fieldset>';
    $html .= '<legend>Column settings:</legend>';

    $html .= '<p><label for="dt_mce-' . $sel_style_name . '">Column width: </label> ';
    
    $html .= '<select name="dt_mce-' . $sel_style_name . '" id="dt_mce-' . $sel_style_name . '" class="short-field">';
    foreach( $col_list as $val=>$title ) {
        $html .= '<option value="' . $val . '">' . $title . '</option>';
    }
    $html .= '</select></p>';
    
    $html .= '<p><input type="checkbox" id="dt_mce-' . $chk_last_name . '" name="dt_mce-' . $chk_last_name . '"/>';
    $html .= ' <label for="dt_mce-' . $chk_last_name . '">Last</label></p>';
    
    $html .= '<p><input type="checkbox" id="dt_mce-' . $chk_align_name . '" name="dt_mce-' . $chk_align_name . '"/>';
    $html .= ' <label for="dt_mce-' . $chk_align_name . '">Right align</label></p>';
    
    $html .= '</fieldset>';
    
    $html .= '<fieldset style="padding-left: 15px; padding-right: 15px;">';
    $html .= '<legend>Editable Content:</legend>';
    
    $html .= '<textarea id="dt_mce-' . $txa_edt_content . '" name="dt_mce-' . $txa_edt_content . '" class="wide-field"></textarea>';
    
    $html .= '</fieldset>';

	// generate the response
    $response = json_encode(
		array(
			'html_content'	=> $html
		)
	);

	// response output
    header( "Content-Type: application/json" );
    echo $response;

    // IMPORTANT: don't forget to "exit"
    exit;
}
add_action( 'wp_ajax_dt_ajax_editor_columns', 'dt_ajax_editor_columns' );
 */
?>
