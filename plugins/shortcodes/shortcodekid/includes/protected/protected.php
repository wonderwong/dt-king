<?php

add_shortcode('protected','sk_protected');
function sk_protected($atts, $content = null){

	if ( is_user_logged_in() ) {
		//$content = sk_delete_htmltags($content);	
		$content = do_shortcode($content);
		$output = $content;
	} else {
		$output = "<div id='sk-protected'>
				<p class='sk-registration'>The following content is for our members only</p>
					<div class='sk-protected-form'>
					<form action='" . home_url() . "/wp-login.php' method='post'>
						<p><label>Username: <input type='text' name='log' id='log' value='" . esc_html(stripslashes($user_login), 1) . "' size='20' /></label></p>
						<p><label>Password: <input type='password' name='pwd' id='pwd' size='20' /></label></p>
						<input type='submit' name='submit' value='Login' id='sklogin-button' />
					</form> 
					</div> <!-- .sk-protected-form -->
				<p class='sk-registration'>Not a member? <a href='".site_url('wp-login.php?action=register', 'login_post')."'>Register today!</a></p>
				</div> <!-- .sk-protected -->";
	}
				
	return $output;
}

include('tinyMCE.php');

?>
