<?php
global $post;
if( isset($post) && !empty($post) ) {
    $opts = get_post_meta($post->ID, '_dt_layout_sidebar_options', true);
}else {
    $opts = array();
}

if( (isset($opts['align']) && ('right' == $opts['align'])) || !isset($opts['align']) ):
?>

<!-- right sidebar -->
<aside id="sidebar" class="fr">
	<div id="mypic" class="mypic">
		<i class="mask"></i>
		<a class="a-0" href="<?php echo get_page_link(127)?>" title="关于King"></a>
		<a class="a-1" href="<?php echo get_page_link(127)?>" title="关于King">Who is King</a>
		<a class="a-2" href="<?php echo get_page_link(183)?>" title="访问我的相册">Visit King's gallery</a>
		<a class="a-3" href="<?php echo get_page_link(774)?>" title="钢铁是怎样练成的">How to design the Webfing</a>
	</div>
<?php dt_aside_widgetarea(); ?>
</aside>

<?php endif; ?>
