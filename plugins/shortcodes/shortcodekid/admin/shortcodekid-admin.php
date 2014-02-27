<?php
//Admin area style
function admin_register_head() {
	global $ShortcodeKidPath;
	$siteurl = get_option('siteurl');
	$url = $ShortcodeKidPath. 'admin/sk-admin-style.css';
	echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}
add_action('admin_head', 'admin_register_head');

// Admin menu stuff
add_action('admin_menu', 'shortcode_kid_plugin_menu');

function shortcode_kid_plugin_menu() {
global $ShortcodeKidPath;
  add_menu_page('Shortcode Kid Options', 'Shortcode Kid', 'manage_options', 'shortcode-kid', 'shortcode_kid_plugin_options', 'div');

}

function shortcode_kid_plugin_options() {

  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }
?>

<div id="poststuff" class="wrap">
  <h2 class="kid-title-icon">Shortcode Kid</h2>
  
  
  <p><a href="http://www.shortcodekid.com/">View our sales page for examples</a> - <a href="mailto:scott@shortcodekid.com">Contact Support</a> - <a href="http://www.shortcodekid.com/affiliate-program/">Earn 50% of Sales With Our Affiliate Program</a></p>
  <p>Shortcode Kid is owned by Bernadot Studios, LLC. Creators of <a href="http://alohathemes.com" target="_blank" >AlohaThemes.com</a>.</p>
  
  <iframe src="http://shortcodekid.com/promo" width="550" height="400" scrolling="yes">
  <p>Your browser does not support iframes.</p>
</iframe>
  
</div>

<?php } ?>