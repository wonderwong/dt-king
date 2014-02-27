<?php	
	
	//Simple Buttons
	function skshorts_simple_pullquotes() {
		
		echo "<script type='text/javascript'>

	/* <![CDATA[ */ 
				
		edButtons[edButtons.length] = new edButton('sk_pullquote_left',
		
			'pullquote_left',
			'[pullquote_left]',
			' [/pullquote_left]'
			''
		
		);
		
		edButtons[edButtons.length] = new edButton('sk_pullquote_right',
		
			'pullquote_right',
			'[pullquote_right]',
			' [/pullquote_right]'
			''
		
		);		

 /* ]]> */ 

	</script>";
		
	}
	
	// SIMPLE BUTTONS
	add_action('admin_head','skshorts_simple_pullquotes');

?>