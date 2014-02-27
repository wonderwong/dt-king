<?php
/* Template Name: 14. Catalog */
?>
<?php get_header(); ?>

<div class="wp wp-100 clearfix">
	<div id="container-full" class="reco-container">
        <h1 class="vh"><?php the_title(); ?></h1>
		
        <?php
        global $post;
        $opts = get_post_meta($post->ID, '_dt_catalog_layout_options', true);
        $cats = get_post_meta($post->ID, '_dt_catalog_layout_category', true);

        //调用分类，暂时隐藏
		/*
		dt_category_list( array(
            'post_type'         => 'dt_catalog',
            'taxonomy'          => 'dt_catalog_category',
            'select'            => $cats['select'],
            'layout'            => '2_col-list',
            'show'              => ('on' == $opts['show_cat_filter'])?true:false,
            'layout_switcher'   => false,
            'terms'             => isset($cats['catalog_cats'])?$cats['catalog_cats']:array()
        ) );
		*/
		
        ?>
        
<?php

	if ($post->ID==460||$post->ID==407){

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		
		$catsImplode = implode(",",$cats['catalog_cats']);
		
	
		$args = array(
			'posts_per_page'		=> $opts['ppp'],
			'paged'					=> $paged,
			'post_type'        		=> 'dt_catalog',
			'post_status'           => 'publish',
			'orderby'          		=> $opts['orderby'],
			'order'            		=> $opts['order'],
			'no_found_rows'         => true,
			'ignore_sticky_posts'   => true,
			'tax_query'             => array( array(
					'taxonomy'          => 'dt_catalog_category',
					'field'             => 'id',
					'terms'             => $catsImplode ,
					'operator'			=> 'IN'
			) )
		);
		
		add_filter('posts_clauses', 'dt_core_join_left_filter');
		$query = new WP_Query( $args );
		remove_filter('posts_clauses', 'dt_core_join_left_filter');
		
		if ( $query->have_posts() ):
		
			echo '<ul id="reco-book-list" class="reco-book-list clearfix">';

			$count = 0;
			while( $query->have_posts() ): $query->the_post(); $count++; 
				
?>

<li class="<?php 
	if (fmod($count,5)==0) echo 'last ';
	if ($count<6) echo 'first';
?>">
	<h2 class="vh"><?php the_title();?></h2>
	<?php echo king_get_thumb_img(get_the_ID(),get_permalink(),108,139) ;?>
</li>

<?php
			endwhile;
?>
	</ul>
<?php
		endif;
	
	}else if ($post->ID==448){
	
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		
		$catsImplode = implode(",",$cats['catalog_cats']);
		
		$args = array(
			'posts_per_page'		=> $opts['ppp'],
			'paged'					=> $paged,
			'post_type'        		=> 'dt_catalog',
			'post_status'           => 'publish',
			'orderby'          		=> $opts['orderby'],
			'order'            		=> $opts['order'],
			'no_found_rows'         => true,
			'ignore_sticky_posts'   => true,
			'tax_query'             => array( array(
					'taxonomy'          => 'dt_catalog_category',
					'field'             => 'id',
					'terms'             => $catsImplode ,
					'operator'			=> 'IN'
			) )
		);
		
		add_filter('posts_clauses', 'dt_core_join_left_filter');
		$query = new WP_Query( $args );
		remove_filter('posts_clauses', 'dt_core_join_left_filter');
		
		if ( $query->have_posts() ):
		
			echo '<ul id="reco-movie-list" class="reco-movie-list clearfix">';

			$count = 0;
			while( $query->have_posts() ): $query->the_post(); $count++; 
				
?>

<li class="<?php	if (fmod($count,4)==0) echo 'last ';?>">
	<h2 class="vh"><?php the_title();?></h2>
	<?php echo king_get_thumb_img(get_the_ID(),get_permalink(),205,304) ;?>
</li>

<?php
			endwhile;
?>
	</ul>
<?php
		endif;
	}
?>

		
    </div>
</div>

<?php get_footer(); ?>
