<?php
// PullQuotes
add_shortcode('pullquote_left','sk_pullquote_left');
function sk_pullquote_left($atts, $content = null){
	$content = do_shortcode($content);
	$output = "<span class='pullquote-left'>{$content}</span>";
	return $output;
}

add_shortcode('pullquote_right','sk_pullquote_right');
function sk_pullquote_right($atts, $content = null){
	$content = do_shortcode($content);
	$output = "<span class='pullquote-right'>{$content}</span>";
	return $output;
}
?>