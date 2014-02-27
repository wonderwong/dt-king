<?php get_header(); ?>

<div class="wp clearfix">
	<div id="container" class="article-single-container container fl">
	
		<?php if( have_posts() ): while( have_posts() ): the_post(); setPostViews(get_the_id());?>
            
            <h1><?php the_title(); ?></h1>
            
            <?php if( !post_password_required() ): 
            
                    get_template_part('single', 'dt_blog');

                    else:?>
                        <div class="hr hr-wide gap-small"></div>
                        <?php echo get_the_password_form(); ?>
                <?php endif;// password protection

                endwhile;
            endif;
        ?>

	</div>
	<?php get_sidebar( 'right' ); ?>
</div>

<?php get_footer(); ?>
