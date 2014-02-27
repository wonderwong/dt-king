<?php
$pg_opts = dt_storage('page_data');
$add_data = dt_storage('add_data');
$vid_opts = get_post_meta( get_the_ID(), '_dt_video_options', true);

$w_str = $h_str = '';
$custom = ' onclick="return false;"';

if( !empty($vid_opts['video_link']) ) {
    $video_html = dt_get_embed( $vid_opts['video_link'], ($vid_opts['width']?$vid_opts['width']:null), ($vid_opts['height']?$vid_opts['height']:null), false );
    
    preg_match('/width=[\"\'\s](\d+?)[\"\'\s]/', $video_html, $width);
    preg_match('/height=[\"\'\s](\d+?)[\"\'\s]/', $video_html, $height);
    
    if( isset($width[1]) )
        $w_str = ", width: " . intval($width[1]);

    if( isset($height[1]) )
        $h_str = ", height: " . intval($height[1]+5);

    $custom = ' onclick="return hs.htmlExpand(this, { contentId: \'dt-content-id-'.get_the_ID().'\''.$w_str.$h_str.' });"';
}

$page_data = dt_storage('page_data');
if( $page_data && isset($page_data['page_options']) ) {
    $page_opts = $page_data['page_options'];
}else {
    $page_opts = array();
}
?>
<div class="dt-video-item <?php dt_portfolio_classes( $add_data['init_layout'], 'block' ); ?>">
        <?php
        $img = dt_get_thumb_img( array(
            'class'         => 'photo',
            'href'          => '#',
            'custom'        => $custom,
            'use_noimage'   => true,
            'thumb_opts'    => array('w' => $add_data['thumb_w'], 'h' => $add_data['thumb_h'] )
            ),
            '<div class="textwidget-photo"><a %HREF% %CLASS% %TITLE% %CUSTOM%><img %SRC% %SIZE%/></a></div>', false
        );
        echo $img;
        ?>

    <?php if( !isset($page_opts['show_meta']) || (isset($page_opts['show_meta']) && 'on' == $page_opts['show_meta']) ): ?>    

    <div class="widget-info">
    <?php echo $img; ?>
	    <div class="<?php dt_portfolio_classes( $add_data['init_layout'], 'info' ); ?>">
            <a class="<?php dt_portfolio_classes( $add_data['init_layout'], 'head' ); ?>" href="#"<?php echo $custom; ?>><?php the_title(); ?></a>
            <?php dt_the_content(); dt_edit_link( 'Edit', null, ('grid' == $pg_opts['layout'])?'details':'button'); ?>
	    </div>
    </div>

    <?php endif; ?>

    <div class="highslide-maincontent" id="dt-content-id-<?php the_ID(); ?>"><?php echo $video_html; ?></div>
</div>
