<?php
//Simple Buttons
function skshorts_simple_columns() {
    
    echo "<script type='text/javascript'>

/* <![CDATA[ */ 			
    
    edButtons[edButtons.length] = new edButton('sk_clear',
    
        'clear',
        '[clear]',
        '',
        ''
    
    );

/* ]]> */ 

</script>";
    
}

// SIMPLE BUTTONS
add_action('admin_head-post.php','skshorts_simple_columns');
?>