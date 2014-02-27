<?php	
	
	//Simple Buttons
	function skshorts_simple_social() {
		
		echo "<script type='text/javascript'>

	/* <![CDATA[ */ 
				
		edButtons[edButtons.length] = new edButton('sk_digg',
			'digg',
			'[digg]',
			''
		);
		
		edButtons[edButtons.length] = new edButton('sk_stumble',
			'stumble',
			'[stumble]',
			''
		);	
		
		edButtons[edButtons.length] = new edButton('sk_facebook',
			'facebook',
			'[facebook]',
			''
		);
		
		edButtons[edButtons.length] = new edButton('sk_buzz',
			'buzz',
			'[buzz]',
			''
		);
		
		edButtons[edButtons.length] = new edButton('sk_buzz',
			'twitter',
			'[twitter name=\"name\"]',
			''
		);	
		
		edButtons[edButtons.length] = new edButton('sk_retweet',
			'retweet',
			'[retweet]',
			''
		);
		
		edButtons[edButtons.length] = new edButton('sk_feedburner',
			'feedburner',
			'[feedburner name=\"name\"]',
			''
		);

 /* ]]> */ 

	</script>";
		
	}
	
	// SIMPLE BUTTONS
	add_action('admin_head-post.php','skshorts_simple_social');

?>