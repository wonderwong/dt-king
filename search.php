<?php get_header(); ?>
<!-- index -->
    
        <div class="main clearfix">
            <h1><?php _e('Search Results for: ', LANGUAGE_ZONE); echo  get_search_query(); ?></h1>
            <div class="hr hr-wide gap-big"></div>

            <?php
            do_action('dt_layout_before_loop', 'index');
            if( have_posts() ) {
                while( have_posts() ) { the_post();
                    get_template_part('content', get_post_format());
                }

	            if( function_exists('wp_pagenavi') ) {
                    wp_pagenavi();
	            }
            }else {
                echo '<p>'.__('Nothing found', LANGUAGE_ZONE).'</p>';
            }
            ?>

        </div>

<?php get_footer(); ?>
