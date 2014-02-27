<?php
/* Template Name: 08. Photos (Full-width) */
?>
<?php get_header(); ?>
<?php 
global $post;
$opts = get_post_meta($post->ID, '_dt_photos_layout_options', true);
$cats = get_post_meta($post->ID, '_dt_photos_layout_albums', true);
$curPageId=$post->ID;
?>

<div class="wp clearfix">
	<div id="container-full" class="single-gallery-container">
		<ul id="gallery">
		
<?php 

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	foreach ($cats['albums'] as $key => $value){
		$args = array(
				'posts_per_page'	=> $opts['ppp'],
				'paged'				=> $paged,
				'post_type'         => 'attachment',
				'post_mime_type'	=> 'image',
				'post_status' 		=> 'inherit',
				'post_parent'       => $cats['albums'][$key],
				'orderby'           => $opts['orderby'],
				'order'             => $opts['order']
		);
		$p_query = new WP_Query( $args );
		$count = 0;
		if( $p_query->have_posts() ) {
			 
			while( $p_query->have_posts() ) {
				$count++;
				$p_query->the_post();
				 
				$thumb_meta = wp_get_attachment_image_src(get_the_ID(), 'full');

				$thumb = dt_get_thumb_img( array(
						'img_meta'      => $thumb_meta,
						'use_noimage'   => true,
						'href'          => 'javascript:;',
						'thumb_opts'    => array( 'w' => 215)
				),
						'<img %SRC% %SIZE% />', false
				);

?>	
			<li class="li-<?php echo $count; ?>">
				<a class="img" href="<?php echo $thumb_meta[0]; ?>">
				
<?php
	if ($curPageId){
		echo '<img width="215" src="'.$thumb_meta[0].'"/>';
	}else{
		echo $thumb; 
	}
	
?>
				</a>
				<h2><?php the_title();?><span>-<?php the_time('Y-m-d')?></span></h2>
				<div class="love">
					<span class="fr num"><?php echo getPicLoveNums(get_the_id());?></span>
					<a id="post-<?php the_id();?>" class="btn btn-gray" href="javascript:;"><span class="font-icon">O</span>喜欢</a>
				</div>
			</li>
<?php 	
		}
	}
?>	

		</ul>
		<div class="vh">
<?php
 
	if( function_exists('wp_pagenavi') ) {
		wp_pagenavi( $p_query );
	}
}
	    	
?>	
		</div>
	</div>
</div>

<?php get_footer(); ?>
