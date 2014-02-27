<?php get_header(); ?>
    
<div class="wp">
	
	<div class="banner page-banner">
		<img src="/wp-content/uploads/2013/03/product_03.jpg" alt="" />
	</div>
	
	<div id="container" class="clearfix about">
		
		<!--left-sidebar-->
		<?php get_template_part("side")?>
		<!--/left-sidebar-->
		
		<!--content-->
		<div id="content" class="content por-content fr">
		
<?php 

	if( have_posts() ): while( have_posts() ): the_post(); 

?>
			
			<div class="c1 clearfix">
				<div id="por-slider" class="slider fl">
					<div class="por-middle-wrap">
						<ul id="por-middle" class="clearfix">
<?php 

		global $post;
		$dt_tmp_query = new WP_Query();
		$post_opts = get_post_meta($post->ID, '_dt_portfolio_options', true);
		$args = array(
			'post_type'         => 'attachment',
			'post_status'       => 'inherit',
			'posts_per_page'    => -1,
			'post_parent'       => $post->ID,
			'post_mime_type'    => 'image',
			'orderby'           => 'menu_order',
			'order'             => 'ASC'
		);
		if( $post_opts['hide_thumbnail'] )
			$args['post__not_in'] = array( get_post_thumbnail_id() );

		$dt_tmp_query->query( $args );
		if( $dt_tmp_query->have_posts() ) {
			$count=0;
			foreach( $dt_tmp_query->posts as $slide ) {
			
				$slide_title = $slide->post_title;
				$slide_big_src = wp_get_attachment_image_src($slide->ID, 'full');
				$slide_middle_src = dt_get_resized_img( wp_get_attachment_image_src($slide->ID, 'full'), array('w' => 400,'h' => 300) );

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
				<div class="por-item">
					<ul>
						<li><strong>产品属性1：</strong><?php the_field('pro_property_1');?></li>
						<li><strong>产品属性2：</strong><?php the_field('pro_property_2');?></li>
						<li><strong>产品属性3：</strong><?php the_field('pro_property_3');?></li>
						<li><strong>产品简介：</strong><?php echo cutstr(get_the_content(),150);?></li>
					</ul>
				</div>
			</div>
			
			<div class="c2">
				<div class="tab">
					<ul>
						<li><a href="javascrip:;">产品描述</a></li>
						<li><a href="javascrip:;">产品参数</a></li>
						<li><a href="javascrip:;">产品扩展1</a></li>
						<li><a href="javascrip:;">产品扩展2</a></li>
					</ul>
				</div>
				<div class="b act"><?php the_field('pro_desc');?></div>
				<div class="b"><?php the_field('pro_parameter');?></div>
				<div class="b"><?php the_field('pro_desc_1');?></div>
				<div class="b"><?php the_field('pro_desc_2');?></div>
			</div>
		</div>
		
<?php 
				
		endwhile;
	endif;
?>
		<!--/content-->
	
	</div>

</div>
    
<?php get_footer(); ?>
