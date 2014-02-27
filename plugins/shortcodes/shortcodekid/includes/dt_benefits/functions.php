<?php
//Our hook
add_shortcode('dt_benefits', 'dt_benefits');

function dt_benefits( $atts ) {
    global $post;
    
    $temp = clone $post;
    
    extract(
        shortcode_atts(
            array(
                "ppp"       => 4,
                "title"     => '',
                "orderby"   => 'Date',
                "order"     => 'DESC',
                "class"     => '',
                "except"    => '',
                "only"      => '',
                "column"    => 'half'
            ),
            $atts
        )
    );
    
    if( 'full-width_three' == $column )
        $column = str_replace('_three', ' third', $column);

    if( 'full-width_fourth' == $column )
        $column = str_replace('_fourth', ' fourth', $column);

    $output = '';
    
    $args = array(
        'post_type'     => 'dt_benefits',
        'post_status'   => 'publish',
        'orderby'       => $orderby,
        'order'         => $order,
    );

    if( $except || $only ) {
        $cats = array_map('trim', explode(',', $except?$except:$only));
        $args['tax_query'] = array( array(
            'taxonomy'  => 'dt_benefits_category',
			'field'     => 'id',
            'terms'     => $cats,
            'operator'  => 'IN'
        ) );
        if( $except )
            $args['tax_query'][0]['oprerator'] = 'NOT IN';
    }
    
    if( $ppp ) {
        $args['posts_per_page'] = $ppp;
    }
    
    $query = new Wp_Query( $args );
    
    if( $query->have_posts() ) {
        $output .= '<div class="'.$column.$class.'">'."\n";

        if( $title )
           $output .= "\t".'<h2>' . $title . '</h2>'."\n";
        
        $output .= "\t".'<div class="text-content">'."\n";

        while( $query->have_posts() ) {
            $query->the_post();
            
            $output .= "\t\t".'<div class="text-inline">'."\n"; 

            // if there is thumbnail
            if( has_post_thumbnail(get_the_ID()) ) {              
                $img['thumnail_img'] = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()));
                $img['thumnail_img'] = $img['thumnail_img'][0];
                
                $img_block = sprintf(
                    "\n\t\t\t\t".'<img class="do-ico" src="%s" alt="%s"/>'."\n",
                    $img['thumnail_img'],
                    esc_attr(get_the_title())
                );
            }else {
                $img_block = '';
            }
            
            $output .= sprintf(
                "\t\t\t".'<p class="head">%2$s</p>'."\n"."\t\t\t".'<p>%1$s%3$s</p>'."\n",
                $img_block,
                get_the_title(),
                $post->post_content
            );
              
            $output .= "\t\t".'</div>'."\n";    
        }

        $output .= "\t".'</div>'."\n";    
        
        $output .= '</div>'."\n";    
    }
    
    $post = $temp;
    
    return $output;
}

// portfolio part
function dt_ajax_editor_benefits() {
    $html = '';
    
    add_filter( 'dt_admin_page_option_ppp-options', 'dt_shortcbuilder_photos_ppp_filter' );
    add_filter( 'dt_admin_page_option_orderby-options', 'dt_shortcbuilder_photos_orderby_filter' );
    add_filter( 'dt_admin_page_option_order-options', 'dt_shortcbuilder_photos_order_filter' );
    
    $terms = get_categories(
        array(
            'type'                     => 'dt_benefits',
            'hide_empty'               => 1,
            'hierarchical'             => 0,
            'taxonomy'                 => 'dt_benefits_category',
            'pad_counts'               => false
        )
    );

    ob_start();
?>
    
    <fieldset style="padding-left: 15px;">
         <legend> Title: </legend>
         <input type="text" id="dt_mce_window_benefits_title" name="dt_mce_window_benefits_title" value="" />
    </fieldset>
<?php
    dt_admin_select_list(
        array(
            'rad_butt_name'     => 'show_type_gallery',
            'checkbox_name'     => 'show_gallery',
            'terms'             => &$terms,
            'con_class'         => 'dt_mce_gal_list',
            'before_element'    => '<fieldset style="padding-left: 15px;">',
            'after_element'     => '</fieldset>',
            'before_title'      => '<legend>',
            'after_title'       => '</legend>'
        )    
    );
    $html .= ob_get_clean();

    $html .= dt_admin_ppp_options(
        array(
            'options'           => array( 'ppp'   => 4 ),
            'box_name'          => 'dt_mce_window_benefits',
            'before_element'    => '<fieldset style="padding-left: 15px;">',
            'after_element'     => '</fieldset>'
        ),
        false
    );
    
    $html .= dt_admin_order_options(
        array(
            'options'           => array(
                'orderby'   => 'date',
                'order'     => 'DESC'
            ),
            'box_name'          => 'dt_mce_window_benefits',
            'before_element'    => '<fieldset style="padding-left: 15px;">',
            'after_element'     => '</fieldset>'
        ),
        false
    );

    ob_start();
?> 
    
    <fieldset style="padding-left: 15px;">
         <legend> Column: </legend>
         <select name="dt_mce_window_benefits_column" id="dt_mce_window_benefits_column">

        <?php
        $columns = array(
            'one-fourth'        => 'one-fourth',
            'three-fourth'      => 'three-fourth',
            'one-third'         => 'one-third',
            'two-thirds'        => 'two-thirds',
            'half'              => 'half',
            'full-width_three'  => 'full-width(three columns)',
            'full-width_fourth' => 'full-width(four columns)'
        );
        foreach( $columns as $column=>$title ):
        ?>

         <option value="<?php echo $column; ?>"><?php echo $title; ?></option>

         <?php endforeach; ?>

         </select>
    </fieldset>
    
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
add_action( 'wp_ajax_dt_ajax_editor_benefits', 'dt_ajax_editor_benefits' );

// Call it now
$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_benefits',
    'dt_benefits',
    false
);

function dt_benefits_images_filter( $shortcodes ) {
    global $ShortcodeKidPath;
    array_push(
        $shortcodes,
        array(
            'shortcode' => 'dt_benefits',
            'image'     => $ShortcodeKidPath . '../images/space.png',
            'command'   => 'dt_mce_command-benefits'
        )    
    );
    return $shortcodes;
}
add_filter('jpb_visual_shortcodes', 'dt_benefits_images_filter');
?>
