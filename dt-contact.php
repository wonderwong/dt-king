<?php
/* Template Name: 18. Contact */
?>

<?php get_header(); ?>

<div class="main mt48">

	<?php
	if( have_posts() ) {
	    while( have_posts() ) { the_post(); the_content(); }
	}
	?>

    <div class="clearfix"></div>
</div>

<?php get_footer(); ?>
