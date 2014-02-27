<?php get_header(); ?>
    
<div class="wp clearfix">
	<div id="container" class="archive-post-container container fl">
	
		<h1>
<?php if( is_category() ):
	_e( 'Category archive: ', LANGUAGE_ZONE );
		echo single_cat_title( null, false );
	elseif( is_tag() ):
		_e( 'Tag archive: ', LANGUAGE_ZONE );
		echo single_tag_title( null, false );
	elseif( is_author() ):
		$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
		_e( 'Author archive: ', LANGUAGE_ZONE );
		echo $curauth->nickname;
	elseif( is_date() ):
		_e( 'Date archive: ', LANGUAGE_ZONE );
		echo single_month_title( ' ', false );
	else:
		global $post;
		_e( 'Archive: ', LANGUAGE_ZONE );
		if( $post )
			echo get_post_format_string(get_post_format());
		else
			echo 'Standard';
	endif;
?>
		</h1>
			
<?php
do_action('dt_layout_before_loop', 'index');
if( have_posts() ) {
	while( have_posts() ) { the_post();
		get_template_part('content', get_post_format() );
	}

	if( function_exists('wp_pagenavi') ) {
		wp_pagenavi();
	}
} 
?>
	

	</div>
	
	<?php get_sidebar( 'right' ); ?>
	
</div>        
        
       
<?php get_footer(); ?>
