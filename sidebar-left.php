<?php
global $post;
if( isset($post) && !empty($post) ) {
    $opts = get_post_meta($post->ID, '_dt_layout_sidebar_options', true);
}else {
    $opts = array();
}    

if( isset($opts['align']) && ('left' == $opts['align']) ):
?>

<!-- left sidebar -->
<div id="sidebar" class="fl">
<?php dt_aside_widgetarea(); ?>
</div>

<?php endif; ?>
