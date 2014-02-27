<?php get_header(); ?>
    
        <div class="main clearfix" style="min-height:400px;">
            
            <?php if( have_posts() ): while( have_posts() ): the_post(); ?>
            
            <h1><?php the_title(); ?></h1>
            
            <div class="hr hr-wide gap-small"></div>

            <div class="entry-meta">
            <?php
            dt_get_date_link( array('class' => 'ico-link date', 'wrap' => '<span class="%CLASS%">%DATE%</span>') );
//             dt_get_author_link( array('class' => 'ico-link author') );
            ?>
            </div>

            <?php
/*             global $post;
            $big = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
            $post_opts = get_post_meta( $post->ID, '_dt_meta_post_options', true );
            if( $big && (!isset($post_opts['hide_thumb']) || !$post_opts['hide_thumb']) ) {
                $big[3] = image_hwstring( $big[1], $big[2] );
                $thumb = dt_get_resized_img($big, array('w' => 702));
                printf('<a class="alignleft highslide" href="%1$s" onclick="return hs.expand(this)"><img src="%2$s" %3$s alt="%4$s" title="%4$s"></a>',
                    $big[0], $thumb[0], $thumb[3], get_the_title()
                );
            } */
            ?>

            <?php
                endwhile;
            endif;
            ?>

        </div>

<?php get_footer(); ?>
