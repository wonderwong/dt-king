<div class="entry-meta">
	<span class="font-icon">P</span><?php the_time('Y-m-d');?>
	<span class="font-icon">U</span><?php the_author();?>
	<?php the_tags($before='<span class="font-icon">,</span>');?>
	<span class="font-icon">R</span><?php echo getPostViews(get_the_id());?>次
</div>

<div class="content"><?php the_content();?></div>
<div class="nav-page"><?php wp_link_pages();?></div>
<p class="king-link">【原文来源:&lt;<a title="悟道前端-前端悟道:html,css,js,ajax" href="<?php echo esc_url( home_url( '/' ) ); ?>">悟道前端</a>&gt;本文链接:<a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php echo get_permalink();?></a>-转载请保留链接，谢谢!】</p>

<?php if( of_get_option('misc-show_next_prev_post') ): ?>
			
<div class="clearfix next-and-prev">
	<div class="fl">
	<?php next_post_link('%link', '<span class="font-icon"><</span><span class="text">%title</span>', TRUE);?>
	</div>
	
	<div class="fr">
	<?php previous_post_link('%link', '<span class="text">%title</span><span class="font-icon">></span>', TRUE);?>
	</div>
</div>

<!--相关文章-->
<div class="relate-posts">
	<div class="h">
		<div class="entry-meta fr"></div>	
		<h4>或许你喜欢</h4>
	</div>
	<div class="b clearfix">
		<?php king_relate_posts(get_the_id());?>
	</div>
</div>
<!--/相关文章-->
            
<?php endif; ?>

<?php comments_template(); ?>
