<?php get_header(); ?>
    
        <div class="main clearfix">
            
            <?php if( have_posts() ): while( have_posts() ): the_post(); ?>
            
            <h1><?php the_title(); ?></h1>
            <div class="hr hr-wide gap-big"></div>

            <?php
            global $post;
            $opts = get_post_meta($post->ID, '_dt_video_options', true);
            ?>

            <div class="full-left">
                    
                <?php
                the_excerpt();
                ?>

            </div>
            
            <?php endwhile; endif; ?>
        
        </div><!-- #container -->
    
<?php get_footer(); ?>
