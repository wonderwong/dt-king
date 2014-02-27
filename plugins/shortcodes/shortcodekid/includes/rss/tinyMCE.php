<?php	
	
	//Simple Buttons
	function skshorts_simple_rss() {
		
		echo "<script type='text/javascript'>

	/* <![CDATA[ */ 
				
		edButtons[edButtons.length] = new edButton('sk_rss',
		
			'rss',
			'[rss feed=\"Enter the Feed URL here\" num=\"5\" excerpt=\"false\"] ',
			''
		
		);				

 /* ]]> */ 

	</script>";
		
	}
	
	// SIMPLE BUTTONS
	add_action('admin_head-post.php','skshorts_simple_rss');

?>