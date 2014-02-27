<?php get_header(); ?>

<div class="wp clearfix">
	<div id="container" class="reco-single-container container fl">
	
		<?php if( have_posts() ): while( have_posts() ): the_post(); setPostViews(get_the_id());?>
			
            <h1 class="vh"><?php the_title();?></h1>
			
			<div class="h1">推荐书藉</div>
			
			<div class="pro-top clearfix">
			
				<!--项目图片-->
				<div class="pro-pic-wrap fl">
				<div class="por-middle-wrap">
						<ul id="por-middle" class="clearfix">
<?php 

		global $post;
		$dt_tmp_query = new WP_Query();
		$post_opts = get_post_meta(get_the_ID(), '_dt_portfolio_options', true);
		$args = array(
			'post_type'         => 'attachment',
			'post_status'       => 'inherit',
			'posts_per_page'    => -1,
			'post_parent'       => $post->ID,
			'post_mime_type'    => 'image',
			'orderby'           => 'menu_order',
			'order'             => 'ASC'
		);
//		if( $post_opts['hide_thumbnail'] )
//			$args['post__not_in'] = array( get_post_thumbnail_id() );

		$dt_tmp_query->query( $args );
		if( $dt_tmp_query->have_posts() ) {
			$count=0;
			foreach( $dt_tmp_query->posts as $slide ) {
			
				$slide_title = $slide->post_title;
				$slide_big_src = wp_get_attachment_image_src($slide->ID, 'full');
				$slide_middle_src = dt_get_resized_img( wp_get_attachment_image_src($slide->ID, 'full'), array('w' => 310,'h' => 300) );

?>
			
							<li class="li-<?php echo $count?> <?php if ($count==0) echo 'act';?>"><a href="<?php echo $slide_big_src[0];?>" rel="prettyPhoto[gallery]" title="<?php echo $slide_title;?>"><img src="<?php echo $slide_middle_src[0];?>" alt="" /></a></li>

<?php
				$count++;
			}
		}
?>
						</ul>
					</div>
				</div>
				<!--/项目图片-->
				
				<!--项目属性-->
				<ul class="pro-items">
					<li class="pro-name"><?php the_title();?></li>
					<li id="pro-hot"><strong>热度：</strong><div class="reco-star" data="<?php the_field("reco_star");?>"></div></li>
					<li><strong>价格：</strong><?php the_field("reco_price");?></li>
					<li><strong>作者：</strong><?php the_field("reco_author");?></li>
					<li><strong>出版日期：</strong><?php the_field("reco_date");?></li>
					<li><strong>下载链接：</strong><?php the_field("reco_link");?></li>
					<li class="pro-excerpt"><strong>读者点评：</strong><?php the_excerpt();?></li>
				</ul>
				<!--项目属性-->
				
			</div>
			
			<!--项目详情-->
			
			<div class="pro-details">
				<div class="tab">
					<ul class="clearfix">
						<li><a href="" class="act"><span>图书简介</span></a></li>
						<li><a href=""><span>图书目录</span></a></li>
						<li><a href=""><span>精典内容</span></a></li>
					</ul>
				</div>
				<div class="wrap">
					<div class="b act"><?php the_field("reco_desc");?></div>
					<div class="b"><?php the_field("reco_list");?></div>
					<div class="b"><?php the_content();?></div>
				</div>
			</div>
			
			<!--/项目详情-->
            
<?php 
		endwhile;
	endif;
?>

	</div>
	<?php get_sidebar( 'right' ); ?>
</div>

<?php get_footer(); ?>
