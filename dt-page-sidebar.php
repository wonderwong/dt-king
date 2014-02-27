<?php
/* Template Name: 04. Page with Sidebar */
?>
<?php get_header(); ?>
<?php dt_storage('have_sidebar', true); ?>


<div class="wp clearfix">
	<div id="container" class="page-container container fl">
	
		<?php if( have_posts() ): while( have_posts() ): the_post(); setPostViews(get_the_id());?>
            
            <h1><?php the_title(); ?></h1>
            
			<div class="content">
            <?php 
			
			the_content();
			endwhile;
			endif;
			?>
			</div>
		
		<?php comments_template(); ?>
		
	</div>
	<?php get_sidebar( 'right' ); ?>
</div>

<?php get_footer(); ?>
