<?php
global $post;
$slider_options = get_post_meta( $post->ID, '_dt_slider_layout_options', true );
$sliders = get_post_meta( $post->ID, '_dt_slider_layout_slideshows', true );

$args = array(
    'post_type'         => 'dt_slider',
    'posts_per_page'    => -1,
    'order'             => 'ASC',
    'orderby'           => 'menu_order',     
    'post_status'       => 'publish'
);

if( 'only' == $sliders['select'] )
    $args['post__in'] = $sliders['slideshows'];

if( 'except' == $sliders['select'] )
    $args['post__not_in'] = $sliders['slideshows'];

$sliders = new WP_Query( $args );
$sliders_ids = array();
if( $sliders->have_posts() ) {
    foreach( $sliders->posts as $slider ) {
        $sliders_ids[] = intval($slider->ID);
    }
}
wp_reset_postdata();

$args = array(
    'post_type'         => 'attachment',
    'post_mime_type'    => 'image',
    'post_status'       => 'inherit',
    'order'             => 'ASC',
    'orderby'           => 'menu_order',     
    'posts_per_page'    => -1
);

dt_storage( 'where_filter_param', implode(',', $sliders_ids) ); 

add_filter( 'posts_where' , 'dt_core_parents_where_filter' );
$images = new WP_Query( $args );
remove_filter( 'posts_where' , 'dt_core_parents_where_filter' );

$slides_arr = array();
global $current_user, $paged;

if( $images->have_posts() && ($paged >= 0 && $paged <= 1) ) {

    $slide_hw = array(
        'nivo'          => array( 'w' => 950, 'h' => 420 ),
        'carousel'      => array( 'w' => 510, 'h' => 320 ),
        'photo_stack'   => array( 'w' => 226, 'h' => 420 ),
        'fancy_tyle'    => array( 'w' => 950, 'h' => 420 )
    );

    while( $images->have_posts() ) { $images->the_post();
    
        $link = get_post_meta( $post->ID, '_dt_slider_link', true );
        $hide_desc = get_post_meta( $post->ID, '_dt_slider_hdesc', true );
        $link_neww = get_post_meta( $post->ID, '_dt_slider_newwin', true );
        
        $tmp_arr = array();
        if( !empty($post->post_excerpt) && !$hide_desc ) {
            $tmp_arr['caption'] = get_the_excerpt();
        }

        if( !empty($post->post_title) && !$hide_desc )  
            $tmp_arr['title'] = $post->post_title;
        
        $img = wp_get_attachment_image_src( $post->ID, 'full' );
        if( $img ) {
            $tmp_arr['src'] = str_replace( array('src="', '"'), '', dt_get_thumb_img(
                array(
                   'img_meta'   => $img,
                   'thumb_opts' => $slide_hw[$slider_options['slider']]
                ),
                '%SRC%',
                false
            ) );
            $tmp_arr['size_str'] = image_hwstring(
                $slide_hw[$slider_options['slider']]['w'],
                $slide_hw[$slider_options['slider']]['h']
            );
        }
		
		if( $link )
			$tmp_arr['link'] = esc_attr($link);
 
		$tmp_arr['in_neww'] = intval($link_neww);
		
		$slides_arr[] = $tmp_arr;
    }

    $autoslide = intval($slider_options['auto_period']);
    $autoslide_on = $autoslide?'1':'0';

    switch( $slider_options['slider'] ) {
        case 'nivo': dt_get_nivo_slider( array('items_arr' => $slides_arr, 'items_wrap' => '<div id="slider" class="nivoSlider" data-autoslide="'.$autoslide.'" data-autoslide_on="'.$autoslide_on.'">%IMAGES%</div>%CAPTIONS%') ); break;
        case 'photo_stack': dt_get_photo_stack_slider( array(
            'items_arr' => $slides_arr,
            'wrap'      => '<div class="navig-nivo ps"><a class="prev"></a><a class="next"></a></div><section id="%ID%"><div id="ps-slider" class="ps-slider" data-autoslide="'.$autoslide.'" data-autoslide_on="'.$autoslide_on.'"><div id="ps-albums">%SLIDER%</div></div></section>',
            ) ); break;
        case 'fancy_tyle': dt_get_jfancy_tile_slider( array(
            'items_arr' => $slides_arr,
            'wrap'      => '<div class="navig-nivo"></div><section id="%ID%"><div id="fancytile-slide" data-autoslide="'.$autoslide.'" data-autoslide_on="'.$autoslide_on.'"><ul>%SLIDER%</ul></div><div class="mask"></div></section>',
            ) ); break;
        case 'carousel': dt_get_carousel_homepage_slider( array(
            'items_arr' => $slides_arr,
            'wrap'      => '<div class="navig-nivo caros"><div id="carousel-left"></div><div id="carousel-right"></div></div><section id="%ID%"><div id="carousel-container"><div id="carousel" data-autoslide="'.$autoslide.'" data-autoslide_on="'.$autoslide_on.'">%SLIDER%</div></div></section>',
            ) ); break;
    }

}elseif( !$images->have_posts() && user_can($current_user->ID, 'edit_pages') ) {
?>
    <div style="color: red; width: 200px; margin: 0 auto; padding: 20px; text-shadow: none; "><?php _e('There are no images in the slider.', LANGUAGE_ZONE); ?></div>
<?php
}
wp_reset_postdata();
?>
