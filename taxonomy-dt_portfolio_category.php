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
		<img height="278" width="1000" alt="product_03" class="attachment-post-thumbnail wp-post-image" src="/wp-content/uploads/2013/03/product_03.jpg">
	</div>
	
	<div id="container" class="clearfix about">
		
		<!--left-sidebar-->
		<?php get_template_part("side-portfolio")?>
		<!--/left-sidebar-->
		
		<!--content-->
		<div id="content" class="content page-content-2 fr">
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
    do_action('dt_layout_before_loop', 'index');
	if( have_posts() ) {
        while( have_posts() ) { 
			the_post();
			$thumb_id = get_post_thumbnail_id(get_the_id());
			$args = array(
					'posts_per_page'    => -1,
					'post_type'			=> 'attachment',
					'post_mime_type'	=> 'image',
					'post_parent'       => get_the_id(),
					'post_status' 		=> 'inherit'
			);
		
			$images = new WP_Query( $args );
		
			if( has_post_thumbnail( get_the_id() ) ) {
				$thumb_meta = wp_get_attachment_image_src($thumb_id, 'full');
			}elseif( $images->have_posts() ) {
				$thumb_meta = wp_get_attachment_image_src($images->posts[0]->ID, 'full');
			}else {
				$thumb_meta = null;
			}
		
			$img = dt_get_thumb_img( array(
					'class'         => 'photo',
					'img_meta'      => $thumb_meta,
					'use_noimage'   => true,
					'title'         => get_the_title(),
					'href'          => 'javascript:;',
					'thumb_opts'    => array( 'w' => 214, 'h' => 132 )
			),
					'<img %SRC% %IMG_CLASS% %SIZE% />', false
			);
?>

							<li>
								<div class="img">
									<div class="img-wrap">
										<a href="<?php echo $thumb_meta[0]; ?>" class="img-wrap-a" title="<?php echo $portfolio->post_title;?>">
											<?php echo $img;?>
										</a>
									</div>
									<div class="shadow"></div>
								</div>
								<div class="title vh">
									<h3><a href="http://www.deep-time.com"><?php the_title();?></a></h3>
								</div>
							</li>

<?php
                
		}

	    if( function_exists('wp_pagenavi') ) {
             wp_pagenavi();
	    }
    } 
?>		
		

			
					
					
			
				</ul>
			</div>
			<!--/style1-3个-阴影在中间-->
	
		</div>
		<!--/content-->
	
	</div>

</div>



<?php get_footer(); ?>
