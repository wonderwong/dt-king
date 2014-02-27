<?php

class tinymce_fkn_new_interface {

	function __construct() {
		add_filter('mce_external_plugins', array( &$this, 'add_tcustom_tinymce_plugin' ));
		add_filter('mce_buttons_3', array(&$this, 'register_button' ));
	}
	
	//include the tinymce javascript plugin
	function add_tcustom_tinymce_plugin($plugin_array) {
		global $ShortcodeKidPath;
		$plugin_array['dt_mce_plugin_shortcode_fkn_new_interface'] =  $ShortcodeKidPath . 'includes/fkn_new_interface/plugin.js';		
		return $plugin_array;
	}

	//include the css file to style the graphic that replaces the shortcode
	function myformatTinyMCE($in) {
		$in['content_css'] .= ",".WP_PLUGIN_URL.'/tinymce-graphical-shortcode/tinymce-plugin/icitspots/editor-style.css';
		return $in;
	}

	// used to insert button in wordpress 2.5x editor
	function register_button($buttons) {
		array_push( $buttons, '', 'dt_createColumn', 'dt_removeColumn', 'dt_lineBefore', 'dt_lineAfter' );
		return $buttons;
	}

}

add_action("init", create_function('', 'new tinymce_fkn_new_interface();'));

?>