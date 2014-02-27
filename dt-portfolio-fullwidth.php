<?php
/* Template Name: 06. Portfolio (Full-width) */
?>

<?php get_header(); ?>

<?php 
global $post;
$opts = get_post_meta($post->ID, '_dt_portfolio_layout_options', true);
$cats = get_post_meta($post->ID, '_dt_portfolio_layout_category', true);
?>

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
					<!--style1-3个-阴影在中间-->
					<div class="img-text-list itl-right">
						<ul class="style1 num-3 shadow-middle clearfix">
		
		
<?php 
	$args = array(
			'posts_per_page'	=> 15,
			'post_type'         => 'dt_portfolio',
			'post_status'       => 'publish',
			'orderby'           => 'date',
			'order'             => 'DESC'
	);
	
	$b_query = new WP_Query( $args );
	
	foreach( $b_query->posts as $portfolio ) {
		$thumb_id = get_post_thumbnail_id($portfolio->ID);
		// 		var_dump($portfolio);
		$args = array(
				'posts_per_page'    => -1,
				'post_type'			=> 'attachment',
				'post_mime_type'	=> 'image',
				'post_parent'       => $portfolio->ID,
				'post_status' 		=> 'inherit'
		);
	
		$images = new WP_Query( $args );
	
		if( has_post_thumbnail( $portfolio->ID ) ) {
			$thumb_meta = wp_get_attachment_image_src($thumb_id, 'full');
		}elseif( $images->have_posts() ) {
			$thumb_meta = wp_get_attachment_image_src($images->posts[0]->ID, 'full');
		}else {
			$thumb_meta = null;
		}
	
		$img = dt_get_thumb_img( array(
				'class'         => 'img-wrap-a',
				'img_meta'      => $thumb_meta,
				'use_noimage'   => true,
				'title'         => $portfolio->post_title,
				'href'          => 'javascript:;',
				'thumb_opts'    => array( 'w' => 214, 'h' => 132 )
		),
				'<img %SRC% %IMG_CLASS% %SIZE% />', false
		);
	
	
?>		
			
					<li>
						<div class="img">
							<div class="img-wrap">
								<a href="<?php echo $portfolio->guid;?>" class="img-wrap-a" title="<?php echo $portfolio->post_title;?>">
									<?php echo $img;?>
								</a>
							</div>
							<div class="shadow"></div>
						</div>
						<div class="title vh">
							<h3><a href="http://www.deep-time.com"><?php echo $portfolio->post_title;?></a></h3>
						</div>
					</li>
					
<?
	}
?>						
				</ul>
			</div>
			<!--/style1-3个-阴影在中间-->
			
<?php
	}
}
?>		
		</div>
		<!--/content-->
	
	</div>

</div>



<?php get_footer(); ?>
