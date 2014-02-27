<div class="widget widget-por">
		<div class="h">
			<span class="font-main">Latest produte</span>最新产品
		</div>
		<ul class="b">

<?php 
	$args = array(
			'posts_per_page'	=> 2,
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
				'class'         => 'photo',
				'img_meta'      => $thumb_meta,
				'use_noimage'   => true,
				'title'         => $portfolio->post_title,
				'href'          => 'javascript:;',
				'thumb_opts'    => array( 'w' => 92, 'h' => 92 )
		),
				'<img %SRC% %IMG_CLASS% %SIZE% />', false
		);
	
	
?>		
		
			<li class="clearfix">
			
				<div class="fl img">
					<a title="<?php echo $portfolio->post_title;?>" rel="photoPhoto[gallery]" href="<?php echo $thumb_meta[0]; ?>"><?php echo $img; ?></a>
				</div>
				
				<div class="br">
					<h3><?php echo $portfolio->post_title;?></h3>
					<p><?php echo cutstr( $portfolio->post_content, 25);?></p>
				</div>
				
			</li>
<?
	}
?>		
		</ul>
	</div>
