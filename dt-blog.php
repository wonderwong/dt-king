<?php
/* Template Name: 05. Blog */
dt_storage('have_sidebar', true);
?>
<?php get_header(); ?>

    <?php get_template_part('top-bg'); ?>

    <?php get_template_part('parallax'); ?>

    <div class="wp clearfix">

        <?php get_template_part('nav'); ?>
        
        <?php get_sidebar( 'left' ); ?>

        <div id="container" class="archive-post-container container fl">
            <h1><?php the_title(); ?></h1>
            <div class="hr hr-wide gap-big"></div>

            <?php
            do_action('dt_layout_before_loop', 'dt-blog');
            global $DT_QUERY;
            if( $DT_QUERY->have_posts() ) {
                while( $DT_QUERY->have_posts() ) {
                    $DT_QUERY->the_post();
                    get_template_part('content', get_post_format() );
                }

	            if( function_exists('wp_pagenavi') ) {
                    wp_pagenavi( $DT_QUERY );
	            }
            }
            wp_reset_postdata();
            ?>

        </div>
        
        <?php get_sidebar( 'right' ); ?>

    </div>

<?php get_footer(); ?>
