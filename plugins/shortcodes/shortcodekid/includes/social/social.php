<?php
add_shortcode('digg', 'sk_digg');
function sk_digg($atts, $content = null) {		
	$output = "<script type='text/javascript'>
(function() {
var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
s.type = 'text/javascript';
s.async = true;
s.src = 'http://widgets.digg.com/buttons.js';
s1.parentNode.insertBefore(s, s1);
})();
</script>
<!-- Medium Button -->
<a class='DiggThisButton DiggMedium'></a>";
	
	return $output;
}

add_shortcode('stumble','sk_stumble');
function sk_stumble($atts, $content = null){
	$output = "<script src='http://www.stumbleupon.com/hostedbadge.php?s=5'></script>";
	return $output;
}

add_shortcode('facebook','sk_facebook');
function sk_facebook($atts, $content = null){
	$output = "<a name='fb_share' type='button_count' href='http://www.facebook.com/sharer.php'>Share</a><script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>";
	return $output;
}

add_shortcode('buzz','sk_buzz');
function sk_buzz($atts, $content = null){
	$output = "<a title='Post to Google Buzz' class='google-buzz-button' href='http://www.google.com/buzz/post' data-button-style='normal-count'></a>
<script type='text/javascript' src='http://www.google.com/buzz/api/button.js'></script>";
	return $output;
}

add_shortcode('twitter','sk_twitter');
function sk_twitter($atts, $content = null){
	extract(shortcode_atts(array(
		"name" => 'name'
	), $atts));
	$output = "<script type='text/javascript' src='http://twittercounter.com/embed/{$name}/ffffff/111111'></script>";
	return $output;
}

add_shortcode('feedburner','sk_feedburner');
function sk_feedburner($atts, $content = null){
	extract(shortcode_atts(array(
		"name" => 'name'
	), $atts));
	$output = "<a href='http://feeds.feedburner.com/{$name}'><img src='http://feeds.feedburner.com/~fc/{$name}?bg=99CCFF&amp;fg=444444&amp;anim=0' height='26' width='88' style='border:0' alt='' />
</a>";
	return $output;
}

add_shortcode('retweet','sk_retweet');
function sk_retweet($atts, $content = null){
	$output = "<a href='http://twitter.com/share' class='twitter-share-button' data-count='vertical'>Tweet</a><script type='text/javascript' src='http://platform.twitter.com/widgets.js'></script>";
	return $output;
}

include('tinyMCE.php');
?>