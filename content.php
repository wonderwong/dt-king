<?php
global $post;
$first_class = '';
if( 1 === dt_storage('post_is_first') ) {
    $first_class = ' first';
    dt_storage( 'post_is_first', -1 );
}

$title = get_the_title(); 
$comments = '<a href="#" title="" class="ico-link comments" onclick="return false;">%COUNT%</a>'; 
if( !post_password_required($post->ID) ) {
    $title = '<a href="'.get_permalink().'">'.$title.'</a>';
    $comments ='<a href="%HREF%" title="" class="ico-link comments">%COUNT%</a>'; 
}
?>
<div class="item-blog<?php echo $first_class; ?>">
    <div class="h">
		<div class="entry-meta fr">
			<span class="font-icon">R</span><?php echo getPostViews(get_the_id());?>次
			<span class="font-icon">P</span><?php the_time('Y-m-d');?>
		</div>	
		<h2 class="title"><?php echo $title; ?></h2>
	</div>
	
    <div class="b clearfix">
<?php
    if( !post_password_required($post->ID) ) {
        if( 'dt_team' !== $post->post_type && 'dt_benefits' !== $post->post_type ) {
		
			$thumb_id = get_post_thumbnail_id($post->ID);
			$args = array(
					'posts_per_page'    => -1,
					'post_type'			=> 'attachment',
					'post_mime_type'	=> 'image',
					'post_parent'       => $post->ID,
					'post_status' 		=> 'inherit'
			);
			
			$images = new WP_Query( $args );
		
			if( has_post_thumbnail( $post->ID ) ) {
				$thumb_meta = wp_get_attachment_image_src($thumb_id, 'full');
			}elseif( $images->have_posts() ) {
				$thumb_meta = wp_get_attachment_image_src($images->posts[0]->ID, 'full');
			}else {
				$thumb_meta = array(
					0	=>	'/wp-content/themes/dt-king/images/noimage.jpg'
				);
			}	
				
			$img=dt_get_thumb_img( array(
				'use_noimage'   => true,
				'img_class'	=> 'lazy-rwd-img',
				'use_lazy'	=> true,
                'thumb_opts'    => array('w' => 210, 'h' => 120)
            ),
				'<img %SRC% %IMG_CLASS% %SIZE% %DATA-SRC%/>', false
			);
		}
?>
		<div class="img img-wrap fl"><a href="<?php echo get_permalink(); ?>" data-src="<?php echo $thumb_meta[0]?>"><?php echo $img;?></a></div>
		<div class="br"><?php echo cutstr(get_the_excerpt(),150);?></div>
<?php
    }else {
        echo get_the_password_form(); 
    }
?>	
	</div>
    


</div>
