<?php
class skshorts_video {

    function vimeo($atts, $content=null) {
		extract(shortcode_atts(array(
			'clip_id' 	=> '',
			'width' 	=> '512',
			'height' 	=> '288',
		), $atts));

		if (empty($clip_id) || !is_numeric($clip_id)) return '<!-- Shortcode Kid Video: Invalid clip_id -->';
		if ($height && !$width) $width = intval($height * 16 / 9);
		if (!$height && $width) $height = intval($width * 9 / 16);
		
		return "<p><iframe src='http://player.vimeo.com/video/$clip_id?portrait=0' width='$width' height='$height' frameborder='0'></iframe></p>";
    }
	
	function youtube($atts, $content=null) {
		extract(shortcode_atts(array(
			'clip_id' 	=> '',
			'width' 	=> '512',
			'height' 	=> '288',
		), $atts));
		
		if (empty($clip_id)) return '<!-- Shortcode Kid Video: Invalid clip_id -->';
		if ($height && !$width) $width = intval($height * 16 / 9);
		if (!$height && $width) $height = intval($width * 9 / 16);
		$height += 25; // Youtube Controls
		
		return '<p><object width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" data="http://www.youtube.com/v/'.$clip_id.'&fs=1&fmt=18">
			<param name="movie" value="http://www.youtube.com/v/'.$clip_id.'&fs=1&fmt=18"></param>
			<param name="allowFullScreen" value="true" />
			<param name="allowscriptaccess" value="always" />
			<param name="wmode" value="transparent"></param>
			</object></p>';
	}

}

add_shortcode('youtube', array('skshorts_video', 'youtube'));
add_shortcode('vimeo', array('skshorts_video', 'vimeo'));

include('tinyMCE.php');

?>