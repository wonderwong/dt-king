<div class="entry-meta">
		<span class="font-icon">P</span><?php the_time('Y-m-d');?>
		<span class="font-icon">U</span><?php the_author();?>
		<span class="font-icon">R</span><?php echo getPostViews(get_the_id());?>次
        <div class="bdshare-t"><div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_t163" data-cmd="t163" title="分享到网易微博"></a></div></div>
</div>



<div class="content"><?php king_the_content();?></div>
<div class="nav-page"><?php wp_link_pages();?></div>
<p class="king-link">【原文来源:&lt;<a title="悟道前端-前端悟道:html,css,js,ajax" href="<?php echo esc_url( home_url( '/' ) ); ?>">悟道前端</a>&gt;本文链接:<a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php echo get_permalink();?></a>-转载请保留链接，谢谢!】</p>
<div class="tag-wrap"><?php the_tags($before='<span>标签：</span>',' ');?></div>

<div class="bdshare-f clearfix">
	<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
	<a class="bds_sqq"></a>
	<a class="bds_tsina"></a>
	<a class="bds_qzone"></a>
	<a class="bds_tqq"></a>
	<a class="bds_tqf"></a>
	<a class="bds_renren"></a>
	<a class="bds_kaixin001"></a>
	<a class="bds_t163"></a>
	<span class="bds_more"></span>
	<a class="shareCount"></a>
	</div>
</div>

<?php if( of_get_option('misc-show_next_prev_post') ): ?>
			
<div class="clearfix next-and-prev">
	<div class="fl">
	<?php //next_post_link('%link', '<span class="font-icon"><</span><span class="text">%title</span>', TRUE);?>
	<?php if (get_next_post()) { next_post_link('%link','<span class="font-icon">&lt;</span><span class="text">%title</span>',true);} else { echo '<span class="font-icon">&lt;</span><span class="text">没有了，已经是最新文章</span>';} ?>  
	</div>
	
	<div class="fr">
	<?php //previous_post_link('%link', '<span class="text">%title</span><span class="font-icon">></span>', TRUE);?>
	
	<?php if (get_previous_post()) { previous_post_link('%link','<span class="text">%title</span><span class="font-icon">&gt;</span>',true);} else { echo '<span class="text">没有了，已经是最后文章</span><span class="font-icon">&gt;</span>';} ?>  
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
