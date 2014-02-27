<?php
/* Template Name: 15. Homepage with Blog */
dt_storage('is_homepage', 'true');
dt_storage('have_sidebar', true);
?>
<?php get_header(); ?>    

<section class="wp clearfix">
	<div id="container" class="fl">
		<h1 class="vh">悟道前端</h1>
        <?php king_post_list(array(14,171,16,19,1));?>
	</div>
	<?php get_sidebar( 'right' ); ?>
</section>
 
<?php get_footer(); ?>
