<?php
	
	
	//Simple Buttons
	function skshorts_simple_video() {
		
		echo "<script type='text/javascript'>

	/* <![CDATA[ */ 
				
		edButtons[edButtons.length] = new edButton('sk_video',
		
			'vimeo',
			'[vimeo clip_id=\"\"] ',
			''
		
		);
		
		edButtons[edButtons.length] = new edButton('sk_youtube',
		
			'youtube',
			'[youtube clip_id=\"\"] ',
			''
		
		);

        edButtons[edButtons.length] = new edButton('sk_frame',
		
			'frame',
			'[frame] ',
			'[/frame]'
		
		);		

 /* ]]> */ 

	</script>";
		
	}
	
	// SIMPLE BUTTONS
	add_action('admin_head','skshorts_simple_video');



?>