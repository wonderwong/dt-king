<?php	
	
	//Simple Buttons
	function skshorts_simple_protected() {
		
		echo "<script type='text/javascript'>

	/* <![CDATA[ */ 
				
		edButtons[edButtons.length] = new edButton('sk_protected',
		
			'protected',
			'[protected] ',
			' [/protected] ',
			''
		
		);				

 /* ]]> */ 

	</script>";
		
	}
	
	// SIMPLE BUTTONS
	add_action('admin_head','skshorts_simple_protected');

?>