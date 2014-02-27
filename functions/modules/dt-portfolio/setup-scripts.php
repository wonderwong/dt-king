<?php

// backend related works metabox script
function dt_portfolio_related_works_script() {
    global $post;
    if( empty($post) || 'dt_portfolio' != get_post_type($post->ID) ) {
        return false;
    }
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            
            var dt_rel_block = jQuery('#dt_portfolio-post_related');

            // on load event
            if( jQuery('.dt_admin_show_related:checked', dt_rel_block).length ) {
                
                // show related box
                console.log('show related box');
                jQuery('.dt_admin_show_related_box', dt_rel_block).show();
            
                if( jQuery('.dt_admin_other_cat:checked').length ) {
                    console.log('show related other');
                    jQuery('.dt_admin_cat_list', dt_rel_block).show();
                }
            
            }
            
            // bind click events
            jQuery('.dt_admin_show_related', dt_rel_block).click(function(){
                console.log('show related box');
                jQuery('.dt_admin_show_related_box', dt_rel_block).toggle();

                if( jQuery('.dt_admin_other_cat:checked').length ) {
                    console.log('show related other');
                    jQuery('.dt_admin_cat_list', dt_rel_block).show();
                }
            });
            
            jQuery('.dt_admin_related_radio', dt_rel_block).click(function(event){
                if( jQuery(event.target).hasClass('dt_admin_other_cat') ) {
                    console.log('show related other');
                    jQuery('.dt_admin_cat_list', dt_rel_block).show();
                }else {
                    console.log('hide related other');
                    jQuery('.dt_admin_cat_list', dt_rel_block).hide();
                }

            });
        });
    </script>
    <?php
}
add_action( 'admin_print_scripts', 'dt_portfolio_related_works_script', 99 );


?>
