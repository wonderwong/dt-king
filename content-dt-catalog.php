<?php
global $post;

$pg_opts = dt_storage( 'page_data' );
$add_data = dt_storage( 'add_data' );

$first_class = '';
if( 1 === dt_storage('post_is_first') ) {
    $first_class = ' first';
    dt_storage( 'post_is_first', -1 );
}

$opts = get_post_meta($post->ID, '_dt_catalog-goods_options', true);
?>
<div class="<?php dt_portfolio_classes( '2_col-list', 'block' ); echo $first_class; ?>">

        <?php
        dt_get_thumb_img( array(
            'class'         => 'photo',
            'use_noimage'   => true,
            'href'          => get_permalink(),
            'thumb_opts'    => array('w' => 337, 'h' => 202 )
            ),
            '<div class="textwidget-photo">
                <a %HREF% %CLASS% %TITLE% %CUSTOM%><img %SRC% %IMG_CLASS% %SIZE%/></a>
            </div>'
        );
        ?>

	<div class="<?php dt_portfolio_classes( '2_col-list', 'info' ); ?>">
		<a class="<?php dt_portfolio_classes( '2_col-list', 'head' ); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        <span class="price"><?php _e('Price: ', LANGUAGE_ZONE); !empty($opts['price'])?print($opts['price']):_e('Undefined', LANGUAGE_ZONE); ?></span>

        <?php
        dt_the_content();
        dt_details_link();
        dt_edit_link();
        ?>

	</div>

</div>
