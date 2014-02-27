<?php
/*
	
	Plugin Name: Shortcode Kid
	Version: 1.3
	Description: Adds many useful shortcodes to your WordPress Theme and Visaul Editor. Buttons, toggle content, image slider, and many more.
	Author: Shortcode Kid
	Author URI: http://www.shortcodekid.com
	Plugin URI: http://www.shortcodekid.com
	
*/
	
	//Plugin Path
    global $ShortcodeKidPath;
    $ShortcodeKidPath = DT_PLUGINS_URL.'/shortcodes/shortcodekid/';
/*	$ShortcodeKidPath = DT_PLUGINS_DIR . '/' . str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
*/	
	////////////////////////////////////
	// LOADS OUR JS SCRIPT
	////////////////////////////////////
	
	//init hook
	add_action('init', 'skShortIncludeJs');
	
	//our include js function
	function skShortIncludeJs() {
		global $ShortcodeKidPath;
		if(!is_admin()) {
			
			//shortcodes.js
			wp_register_script('skshortcodes', DT_PLUGINS_URL.'/shortcodes/shortcodekid/js/shortcodes.js');
			
			//Enqueue our script
			wp_enqueue_script('jquery');
			wp_enqueue_script('skshortcodes');
			
		}
		
	}
    
    /* TODO: delete in future */
    function dt_shortcode_admin() {
        $rel_theme_url = explode( $_SERVER['SERVER_NAME'], get_template_directory_uri() );
        if( isset($rel_theme_url[1]) )
            $rel_theme_url = $rel_theme_url[1];
        else
            $rel_theme_url = str_replace( site_url(), '', get_template_directory_uri() );

        wp_localize_script(
            'custom_quicktags',
            'dt_admin',
            array(
                'themeurl'	=> $rel_theme_url
            )
        );
    }
//    add_action('admin_enqueue_scripts', 'dt_shortcode_admin');

	////////////////////////////////////
	// LOADS OUR CSS FILES
	////////////////////////////////////
	
    /*
     * register with hook 'wp_print_styles'
     */
    add_action('wp_print_styles', 'add_skid_stylesheet');

    /*
     * Enqueue style-file, if it exists.
     */

    function add_skid_stylesheet() { 
        $skidStyleUrl = DT_PLUGINS_URL . '/shortcodekid/css/shortcodes.css';
        $skidStyleFile = DT_PLUGINS_DIR . '/shortcodekid/css/shortcodes.css';
        if ( file_exists($skidStyleFile) ) {
            wp_register_style('skidStyleSheets', $skidStyleUrl);
            wp_enqueue_style( 'skidStyleSheets');
        }
    }
	
	////////////////////////////////////
	// jQUERY ACTIVATORS
	////////////////////////////////////
	
	//Let's now include our JS stuff
	add_action('wp_head', 'skShortIncludeJsActivators');
	
	//let's include the necessary code
	function skShortIncludeJsActivators() {
		$output = "
		<script type=\"text/javascript\">
			jQuery(document).ready(function() {
				jQuery('.sktooltip').each(function() {
					jQuery(this).SKTooltip();
				});
				jQuery('.sk-notification').each(function() {
					jQuery(this).closeNotification();
				});
				jQuery('.skimage-slider').each(function() {
					jQuery(this).skImageSlider();
				});
				jQuery('.sktoggle-open, .sktoggle-closed').each(function() {
					jQuery(this).skToggle();
				});
				jQuery('.sktabbed').each(function() {
					jQuery(this).skTabbed();
				});
			});
		</script>";
		echo $output;
	}
	
	//ALLOW SHORTCODES IN WIDGETS
	add_filter('widget_text', 'do_shortcode');
	
	/*
	Plugin Name: Shortcode Empty Paragraph Fix
	Plugin URI: http://www.johannheyne.de/wordpress/shortcode-empty-paragraph-fix/
	Description: Fix issues when shortcodes are embedded in a block of content that is filtered by wpautop.
	Author URI: http://www.johannheyne.de
	Version: 0.1
	*/

	add_filter('the_content', 'shortcode_empty_paragraph_fix');
	function shortcode_empty_paragraph_fix($content) {   
		$array = array (
			'<p>[' => '[', 
			']</p>' => ']', 
			']<br />' => ']'
		);

		$content = strtr($content, $array);

		return $content;
	}
	
    require('helpers_alpha.php');	
    require_once('shortcodes_lib.php');	

	////////////////////////////////////
	// THE SHORTCODES
	////////////////////////////////////
	
    // MCE BUTTON CLASS
    include('includes/tinyMCE-button_class.php');	
   
	//QUOTES
	include('includes/pullquotes/pullquotes.php');	
	
	//COLUMN TEMPLATE
	include('includes/columns/functions.php');
	
	//ICON BUTTONS
// 	include('includes/buttons/functions.php');
	
	//TOOLTIPS
// 	include('includes/tooltips/functions.php');
	
	//IMAGE SLIDER
// 	include('includes/slider/functions.php');
	
	//SOCIAL MEDIA
// 	include('includes/social/social.php');	
	
	//TOGGLE
// 	include('includes/toggle/functions.php');
	
	//TABBED
// 	include('includes/tabbed/functions.php');
	
	//ACCORDION
// 	include('includes/accordion/functions.php');
	
	//HIGHLIGHT
// 	include('includes/highlight/highlight.php');
	
	//VIDEOS
//	include('includes/video/video.php');
	
	//PROTECTED
//	include('includes/protected/protected.php');
	
	//RSS
//	include('includes/rss/rss.php');

    //DT CUSTOM POST SHORTCODES

    // BENEFITS
//     include('includes/dt_benefits/functions.php');

/*    
    // PHOTOS
	include('includes/dt_photos/functions.php');
   
    // GALLERY
	include('includes/dt_gallery/functions.php');
 
    // PORTFOLIO
	include('includes/dt_portfolio/functions.php');
*/
 
    // WIDGET LATEST POSTS
//	include('includes/dt_widget_latposts/functions.php');
    
	// WIDGET TWITTER
// 	include('includes/dt_widget_twitter/functions.php');
	
	// WIDGET RECENT PHOTOS 
// 	include('includes/dt_widget_recent_photos/functions.php');
	
	// WIDGET TESTIMONIALS 
// 	include('includes/dt_widget_testimonials/functions.php');
	
	// FRAMED VIDEO 
// 	include('includes/dt_framed_video/functions.php');
	
	// google map 
// 	include('includes/dt_google_map/functions.php');

	//call to action 
// 	include('includes/dt_call_to_action/functions.php');

	// WIDGET PORTFOLIO 
// 	include('includes/dt_widget_portfolio/functions.php');
	
    // WIDGET LOGO
//     include('includes/dt_widget_partners/functions.php');
	
    // WIDGET CONTACT 
//     include('includes/dt_widget_contactform/functions.php');
	
    // TEXT BOX
// 	include('includes/dt_text_box/functions.php');
    
    // DIVIDER
// 	include('includes/dt_divider/functions.php');
    
    // CLEAR
//	include('includes/dt_clear/functions.php');
    
    // THIS IS TESTING NEW INTERFACE!!!
	include('includes/dt_layout_builder/functions.php');
	// WUAAAAAGGGGHHH!!!
    
    
	//let's trick tinymce into thnking its a new version to clean up the cache
	function my_refresh_mce($ver) {
		
	  $ver += 3;
	  return $ver;
	  
	}
	
	//tricks tinyMCE
	add_filter( 'tiny_mce_version', 'my_refresh_mce');
	
	////////////////////////////////////
	// ADD ADMIN PAGE
	////////////////////////////////////	
	
	// Includes Shortcode Ninja Admin Page
//	include 'admin/shortcodekid-admin.php';	

?>
