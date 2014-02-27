<?php
global $post;
$pg_opts = dt_storage('page_data');
$add_data = dt_storage('add_data');
?>
    <div class="<?php dt_portfolio_classes( $add_data['init_layout'], 'block' ); ?>">

        <?php
        $caption = get_the_excerpt();
        $caption_hs = '';
        if( $caption && 0 ) {
            $caption_hs = '<div class="highslide-caption">'.$caption.'</div>';
        }
        $img = dt_get_thumb_img( array(
            'class'         => 'photo highslide',
            'img_meta'      => wp_get_attachment_image_src( $post->ID, 'full' ),
            'custom'        => ' onclick="return hs.expand(this, galleryOptions)"',
            'title'         => strip_tags( $caption ),
            'thumb_opts'    => array('w' => $add_data['thumb_w'], 'h' => $add_data['thumb_h'] )
            ),
            '<div class="textwidget-photo"><a %HREF% %CLASS% %TITLE% %CUSTOM%><img alt="'.get_the_title().'" %SRC% %IMG_CLASS% %SIZE%/></a>'.$caption_hs.'</div>', false
        );
        echo $img;
        ?>
    </div>

</div>
