<?php

// help text element retieve data from thickbox
function dt_video_uploader_script() {
    global $post;
    if( empty($post) || 'dt_video' != get_post_type($post->ID) ) {
        return false;
    }
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
/*
            jQuery('#upload_image_button').click(function() {
             formfield = jQuery('#dt_video').attr('name');
             tb_show('', jQuery(this).attr('href') );
             return false;
            });
*/
            window.send_to_editor = function(html) {
                var video = jQuery(html.toString()).attr('href');
                jQuery('input[name="dt_video_options_video_link"]').attr('value', video);
                tb_remove();
            }
/*            
            jQuery('#remove_image_button').click(function(){
                jQuery(this).parent().find('#dt_video').attr('value', '');
                return false;
            });
*/
        });
    </script>
    <?php
}
add_action( 'admin_print_scripts', 'dt_video_uploader_script', 99 );


?>