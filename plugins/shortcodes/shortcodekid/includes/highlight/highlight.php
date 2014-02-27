<?php
	
	///////////////////////////////////
	///////////////////////////////////
	//// THIS WILL HANDLE THE SHORTCODES
	//// FOR HIGHLIGHT
	///////////////////////////////////
	///////////////////////////////////
	
	//Our hook
	add_shortcode('highlight', 'skshort_highlight');
	
	//Our Funciton
	function skshort_highlight($atts, $content = null) {
		
		//extracts our attrs . if not set set default
		extract(shortcode_atts(array(
		
			'color' => 'light'
		
		), $atts));
		
		//decide colors
		switch($color) {
			
			case 'blue':
				$class = 'highlight-blue';
				break;
			
			case 'orange':
				$class = 'highlight-orange';
				break;
			
			case 'green':
				$class = 'highlight-green';
				break;
			
			case 'purple':
				$class = 'highlight-purple';
				break;
			
			case 'pink':
				$class = 'highlight-pink';
				break;
			
			case 'red':
				$class = 'highlight-red';
				break;
			
			case 'grey':
				$class = 'highlight-grey';
				break;
			
			case 'light':
				$class = 'highlight-light';
				break;
			
			case 'black':
				$class = 'highlight-black';
				break;
				
			case 'yellow':
				$class = 'highlight-yellow';
				break;
			
		}
		
		return '<span class="skhighlight '.$class.'">'.trim($content).'</span>';
		
	}
	
	include('tinyMCE.php');

?>