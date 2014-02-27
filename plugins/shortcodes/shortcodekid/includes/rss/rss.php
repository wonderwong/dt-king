<?php

function sk_rss_shortcode( $atts ) {
	extract(shortcode_atts(array(  
	    "feed" 		=> '',  
		"num" 		=> '5',  
		"excerpt" 	=> true,
		"target"	=> '_self'
	), $atts));
	require_once(ABSPATH.WPINC.'/rss.php');  
	if ( $feed != "" && $rss = fetch_rss( $feed ) ) {
		$content = '<ul>';
		if ( $num !== -1 ) {
			$rss->items = array_slice( $rss->items, 0, $num );
		}
		foreach ( (array) $rss->items as $item ) {
			$content .= '<li>';
			if ($target != '_self')
				$content .= '<a href="'.esc_url( $item['link'] ).'" target="'.esc_attr($target).'">'. esc_html($item['title']) .'</a>';
			else
				$content .= '<a href="'.esc_url( $item['link'] ).'">'. esc_html($item['title']) .'</a>';
			if ( $excerpt != false && $excerpt != "false") {
				$content .= '<br/><span class="rss_excerpt">'. esc_html($item['summary']) .'</span>';
			}
			$content .= '</li>';
		}
		$content .= '</ul>';
	}
	return $content;
}

add_shortcode( 'rss', 'sk_rss_shortcode' );

include('tinyMCE.php');

?>