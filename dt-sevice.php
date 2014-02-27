<?php
/* Template Name: 19. Service */
dt_storage('is_homepage', 'true');
dt_storage('have_sidebar', true);
?>

<?php get_header(); ?>

	<div class="wp">
	
		<div class="banner page-banner">
			<?php if (has_post_thumbnail()) { the_post_thumbnail() ;} ?>
		</div>
		
		<div id="container" class="clearfix about">
		
			<!--left-sidebar-->
			<?php get_template_part("side")?>
			<!--/left-sidebar-->
			
			<!--content-->
			<div id="content" class="content page-content-2 fr">
<?php
if( have_posts() ) {
	while( have_posts() ) {
		the_post();
?>
				<div class="h">
					<div class="hr fr">
						<a href="#">首页</a>&gt;<a href="#">首页</a>&gt;<a href="#">首页</a>
					</div>
					<h1 class="font-main"><?php the_title();?></h1>
				</div>
				
				<div class="text">
					<?php the_content();?>
				</div>
<?php
	}
}
?>
			</div>
			<!--/content-->
		
		</div>
		
	</div>

<?php get_footer(); ?>
