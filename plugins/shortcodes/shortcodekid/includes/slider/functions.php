<?php
//Our hook
add_shortcode('anything_slider', 'dt_shortcode_anything_slider');

function dt_ajax_editor_anything_slider() {
    
    $items = new WP_Query( array(
        'post_type'         => 'dt_slider',
        'posts_per_page'    => -1,
        'post_status'       => 'publish',
        'order'             => 'ASC',
        'orderBy'           => 'title'
    ) ); 
        
    $html = '';

    ob_start(); ?>
            
    <label><?php _e('Select a slider:', LANGUAGE_ZONE); ?></label><br />
            <?php 
            if( $items->have_posts() ):
                $selected  = $items->posts[0]->ID;
            ?>

                <?php foreach( $items->posts as $slide ): ?>

                <label><input type="radio" name="slider_id" value="<?php echo $slide->ID; ?>" <?php checked( $slide->ID == $selected ); ?>/>&nbsp;<?php echo $slide->post_title; ?></label><br />

                <?php endforeach; ?>

            <?php else: ?>

                <span style="color: red;"><?php _e('There is no sliders', LANGUAGE_ZONE); ?></span>

            <?php endif; ?>

    <?php
    $html .= ob_get_clean();

	// generate the response
    $response = json_encode(
		array(
			'html_content'	=> $html
		)
	);

	// response output
    header( "Content-Type: application/json" );
    echo $response;

    // IMPORTANT: don't forget to "exit"
    exit;
}
add_action( 'wp_ajax_dt_ajax_editor_anything_slider', 'dt_ajax_editor_anything_slider' );

function dt_shortcode_anything_slider( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'column'    => 'half',
        'title'     => '',
        'slider_id' => '',
        'autoslide' => 0
    ), $atts));
    
    if( $title )
        $title = '<h2>'.esc_html($title).'</h2>';
    
    $autoslide_on = $autoslide?1:0;

    $args = array(
        'posts_per_page'	=> 1,
        'post_type'         => 'dt_slider',
        'post_status'       => 'publish'
    );

    if( $slider_id ) {
        $args['post__in'] = array($slider_id);
    }
        
    $p_query = new WP_Query( $args ); 

    $sizes_full = array(
        'one-fourth'    => array( 202 ),
        'three-fourth'  => array( 702 ),
        'one-third'     => array( 286 ),
        'two-thirds'    => array( 620 ),
        'half'          => array( 452 ),
        'full-width'    => array( 952 )
    );

    $sizes = array(
        'one-fourth'    => array( 140 ),
        'three-fourth'  => array( 516 ),
        'one-third'     => array( 202 ),
        'two-thirds'    => array( 452 ),
        'half'          => array( 328 ),
        'full-width'    => array( 704 )
    );
    
    $img_width = null;
    if( !dt_storage('have_sidebar') && isset($sizes_full[$column]) )
        $img_width = current($sizes_full[$column]);
    elseif( dt_storage('have_sidebar') && isset($sizes[$column]) )
        $img_width = current($sizes[$column]);

    $error_text = '';
    $slides_arr = array();
    if( $p_query->have_posts() ) {
        foreach( $p_query->posts as $album ) {
	
            $args = array(
                'posts_per_page'    => -1,
                'post_type'			=> 'attachment',
			    'post_mime_type'	=> 'image',
                'post_parent'       => $album->ID,
			    'post_status' 		=> 'inherit',
                'orderby'           => 'menu_order',
                'order'             => 'ASC'
		    );
		
		    $images = new WP_Query( $args );

            global $post;

            if( $images->have_posts() ) {
                while( $images->have_posts() ) { $images->the_post();
                
                        $link = get_post_meta( $post->ID, '_dt_slider_link', true );
                        $hide_desc = get_post_meta( $post->ID, '_dt_slider_hdesc', true );
                        $link_neww = get_post_meta( $post->ID, '_dt_slider_newwin', true );
                        
                        $tmp_arr = array();
                        
                        if( !$hide_desc ) {
                            $tmp_arr['caption'] = get_the_excerpt();
                        }

                        if( !empty($link) ) {
                            $tmp_arr['link'] = $link;
                        }

                        if( !empty($link_neww) ) {
                            $tmp_arr['link_neww'] = true;
                        }
                         
                        if( !empty($post->post_title) && !$hide_desc )  
                            $tmp_arr['title'] = $post->post_title;
                         
                        $slide_src = dt_get_resized_img(
                            wp_get_attachment_image_src($post->ID, 'full'),
                            array('w' => $img_width)    
                        );
                        $tmp_arr['src'] = $slide_src[0];
                        $tmp_arr['size_str'] = $slide_src[3];

                        $slides_arr[] = $tmp_arr;
                    }
                }else {
                    $error_text .= '<div style="color: red; margin: 0 auto; padding: 20px; text-shadow: none; ">'.__('There are no images in the slider.', LANGUAGE_ZONE).'</div>';
                }
            }
        }
    wp_reset_postdata();
    $slider = dt_get_anything_slider( array(
        'items_arr' => $slides_arr,
        'class'     => 'slider-shortcode anything',
        'wrap'      => '<div class="%CLASS%" data-autoslide="'.$autoslide.'" data-autoslide_on="'.$autoslide_on.'">%SLIDER%</div>'
    ), false );

    $output = '<div class="'.esc_attr($column).'">'.$title.$slider.$error_text.'</div>';
    return $output;
}

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_slider',
    'slider',
    false
);

function dt_shortcode_slider_images_filter( $shortcodes ) {
    global $ShortcodeKidPath;
    array_push(
        $shortcodes,
        array(
            'shortcode' => 'anything_slider',
            'image'     => $ShortcodeKidPath . '../images/space.png',
            'command'   => 'dt_mce_command-slider'
        )    
    );
    return $shortcodes;
}
add_filter('jpb_visual_shortcodes', 'dt_shortcode_slider_images_filter');

?>
