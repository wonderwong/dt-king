<?php
global $post;
$pg_opts = dt_storage('page_data');
$add_data = dt_storage('add_data');

$layout = explode('-', $add_data['init_layout']);
if( isset($layout[1]) ) {
    $layout = $layout[1];
}else {
    $layout = 'list';
}

$first_class = '';
if( (1 === dt_storage('post_is_first')) && ('grid' != $layout) ) {
    $first_class = ' first';
    dt_storage( 'post_is_first', -1 );
}

$pass_form = '';
$img_custom = 'onclick="jQuery(this).parents(\'.dt-hs-container\').find(\'.hidden-container a:first\').click(); return false;"';
if( post_password_required() ) {
    $pass_form = get_the_password_form();
    $title_tag = '<span class="%s">%s</span>';
}else {
    $title_tag = '<a class="%s" href="#"'.$img_custom.'>%s</a>';
}

$title = sprintf( $title_tag, dt_portfolio_classes( $add_data['init_layout'], 'head', false ), get_the_title() );
?>
<div class="dt-hs-container <?php dt_portfolio_classes( $add_data['init_layout'], 'block' ); echo $first_class; ?>">

        <?php
        $post_opts = get_post_meta($post->ID, '_dt_gal_p_options', true);
        $thumb_id = get_post_thumbnail_id($post->ID);
        
        $args = array(
            'post_type'         => 'attachment',
            'post_mime_type'    => 'image',
            'post_status'       => 'inherit',
            'post_parent'       => $post->ID,        
            'orderby'           => $post_opts['orderby'],
            'order'             => $post_opts['order'],
            'posts_per_page'    => -1
        );
        
        if( has_post_thumbnail() && $post_opts['hide_thumbnail'] ) {
            $args['post__not_in'] = array($thumb_id); 
        }

        $images = new WP_Query( $args );

        if( has_post_thumbnail() ) {
            $thumb_meta = wp_get_attachment_image_src($thumb_id, 'full');
        }elseif( $images->have_posts() ) {
            $thumb_meta = wp_get_attachment_image_src($images->posts[0]->ID, 'full');
        }else {
            $thumb_meta = null;
        }
        
        $img = dt_get_thumb_img( array(
            'class'         => 'photo highslide',
            'img_meta'      => $thumb_meta,
            'custom'        => $img_custom,
            'use_noimage'   => true,
            'thumb_opts'    => array('w' => $add_data['thumb_w'], 'h' => $add_data['thumb_h'] )
            ),
            '<div class="textwidget-photo"><a %HREF% %CLASS% %TITLE% %CUSTOM%><img %SRC% %SIZE%/></a>%P_FORM%</div>', false
        );

        echo str_replace( '%P_FORM%', $pass_form, $img );
        ?>
    
    <?php if( 'grid' != $pg_opts['layout'] || !isset($pg_opts['page_options']['show_excerpt']) || ('grid' == $pg_opts['layout'] && 'on' == $pg_opts['page_options']['show_excerpt'] ) ): ?>
    
    <?php if( 'grid' == $pg_opts['layout'] ): ?>
        <div class="widget-info">
    <?php echo str_replace( '%P_FORM%', '', $img ); endif; ?>

	<div class="<?php dt_portfolio_classes( $add_data['init_layout'], 'info' ); ?>">

        <?php echo $title; ?>

        <?php
        if( !post_password_required() ) {
            dt_the_content();
            dt_edit_link('Edit', null, 'grid' == $pg_opts['layout']?'details':'button');
        }
        ?>

	</div>

    <?php if( 'grid' == $pg_opts['layout'] ): ?>
        </div>
    <?php endif; ?>
    
    <?php endif;// show excerpt in grid layout ?>

        <?php if( $images->have_posts() && !post_password_required() ):
        $hs_group = 'dt_gallery_' . $post->ID;
        ?>
        
            <div class="hidden-container" data-hs_group="<?php echo $hs_group; ?>">

            <?php
            foreach( $images->posts as $image ) {
                dt_get_thumb_img( array(
                    'class'         => 'highslide',
                    'img_meta'      => wp_get_attachment_image_src($image->ID, 'full'),
                    'title'         => strip_tags( $image->post_excerpt ),
                    'thumb_opts'    => array('w' => 90, 'h' => 90 )
                    ),
                    '<a %HREF% %CLASS% %TITLE% %CUSTOM%><img alt="'.$image->post_title.'" %SRC% %SIZE%/></a>'
                );

                if( $image->post_excerpt && 0 ) { ?>
                    <div class="highslide-caption"><?php echo $image->post_excerpt; ?></div>
                <?php }
            }
            ?>
        
        </div>
        
        <?php endif; ?>

</div>
