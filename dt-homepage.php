<?php
/* Template Name: 16. Homepage */
dt_storage('is_homepage', 'true');
dt_storage('have_sidebar', true);
?>

<?php get_header(); ?>

<div class="wp">
	<!--滚动图片-->
	<div class="banner home-banner">
		<ul id="home-slider">
			<li><img src="<?php the_tl_url();?>/images/temp/home-slider-1.jpg" alt="健康生活从水开始" width="1000" height="370"/></li>
		</ul>
	</div>
	<!--/滚动图片-->
	
	<!--首页内容-->
	<div class="home-content">
		
		<!--首页新闻-->
		<div class="c1 fl">
			<div class="h">
				<div class="hr fr">
					<a class="vht" href="/news">more</a>
					<h2 class="vht">最近新闻</h2>
				</div>
			</div>
			<div class="b">
				<ul>
					<?php 
						$args = array(
							'posts_per_page'	    => 5,
							'post_status'           => 'publish',
							'orderby'               => 'date',
							'order'                 => 'DESC',
							'no_found_rows'         => true,
							'ignore_sticky_posts'   => true,
							'tax_query'             => array( array(
									'taxonomy'          => 'category',
									'field'             => 'id',
									'terms'             => 1,
									'operator'			=> 'IN'
							) )
						);
						
						add_filter('posts_clauses', 'dt_core_join_left_filter');
						$query = new WP_Query( $args );
						remove_filter('posts_clauses', 'dt_core_join_left_filter');
						
						if ( $query->have_posts() ):
							while( $query->have_posts() ): 
								$query->the_post();
					?>
					
					<li><span class="fr" /><?php the_time('y-m-d')?></span><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php echo cutstr(get_the_title(),12);?></a></li>
					
					<?php
							endwhile;
						endif;
					?>
				</ul>
			</div>
		</div>
		<!--/首页新闻-->
		
		<!--首页产品-->
		<div class="c2 fl">
			<div class="h">
				<h2 class="vht">最新作品</h2>
			</div>
			<div class="b">
				<ul class="slider">
					<li><a href="#"><img src="<?php the_tl_url();?>/images/temp/home-pro-1.jpg" alt="最新作品1" /></a></li>
				</ul>
			</div>
		</div>
		<!--/首页产品-->
		
		<div class="c3 fl"><img src="<?php the_tl_url();?>/images/temp/home-content-img.jpg" alt="" width="132" height="125" /></div>
		
		<!--首页联系我们-->
		<div class="c4">
			<a href="http://wpa.qq.com/msgrd?V=1&Menu=yes&Uin=123456789" target="_blank" class="qq"></a>
		</div>
		<!--/首页联系我们-->
		
	</div>
	<!--/首页内容-->
	
</div>

<?php get_footer(); ?>
