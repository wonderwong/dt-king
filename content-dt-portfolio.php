<?php
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

$pass_form = $img_custom = '';
if( post_password_required() ) {
    $pass_form = get_the_password_form();
    $title_tag = '<span class="%s">%s</span>';
    $img_href = '#';
    $img_custom = 'onclick="return: false;"';
}else {
    $img_href = get_permalink();
    $title_tag = '<a href="'.get_permalink().'" class="%s">%s</a>';
}

$title = sprintf( $title_tag, dt_portfolio_classes( $add_data['init_layout'], 'head', false ), get_the_title() );
?>
<div class="<?php dt_portfolio_classes( $add_data['init_layout'], 'block' ); echo $first_class; ?>">

        <?php
        $img = dt_get_thumb_img( array(
            'class'         => 'photo',
            'href'          => $img_href,
            'custom'        => $img_custom,
            'use_noimage'   => true,
            'thumb_opts'    => array('w' => $add_data['thumb_w'], 'h' => $add_data['thumb_h'] )
            ),
            '<div class="textwidget-photo"><a %HREF% %CLASS% %TITLE% %CUSTOM%><img %SRC% %IMG_CLASS% %SIZE%/></a>%P_FORM%</div>', false
        );

        echo str_replace( '%P_FORM%', $pass_form, $img );

        $page_data = dt_storage('page_data');
        if( $page_data && isset($page_data['page_options']) ) {
            $page_opts = $page_data['page_options'];
        }else {
            $page_opts = array();
        }
        ?>
    
    <?php if( 'list' == $pg_opts['layout'] || !isset($page_opts['show_meta']) || (isset($page_opts['show_meta']) && 'on' == $page_opts['show_meta']) ): ?>    

    <?php if( 'grid' == $pg_opts['layout'] ): ?>
        <div class="widget-info">
    <?php echo str_replace( '%P_FORM%', '', $img ); endif;// grid ?>
    
	<div class="<?php dt_portfolio_classes( $add_data['init_layout'], 'info' ); ?>">
        
        <?php echo $title; ?>

        <?php if( !post_password_required() ): ?>

            <?php
            dt_the_content();
            if( 'list' == $pg_opts['layout'] || isset($page_opts['show_excerpt']) && 'on' == $page_opts['show_excerpt'] )
                dt_details_link(null, ('grid' == $layout)?'details':'button');
            dt_edit_link('Edit', null, ('grid' == $layout)?'details':'button');
            ?>

        <?php endif;// pass protected ?>

    </div>

    <?php if( 'grid' == $pg_opts['layout'] ): ?>
        </div>
    <?php endif;// grid ?>
    
    <?php endif;// show meta or list layout ?>

</div>
