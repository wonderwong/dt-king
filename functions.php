<?php
require_once dirname(__FILE__) . '/functions/core/core-init.php';

function dt_top_menu_register() {
	register_nav_menu( 'top-menu', __( 'Top Menu', LANGUAGE_ZONE ) );
}
add_action('after_setup_theme', 'dt_top_menu_register');

function dt_setup_scripts() {
    $uri = get_template_directory_uri();

    wp_enqueue_script( 'dt_scripts', $uri.'/js/LAB.min.js', array('jquery') , null , true );
    
    $page_layout = dt_core_get_template_name();
    if( !$page_layout ) {
        $page_layout = 'index.php';
    }else {
        $page_layout = str_replace( array('dt-', '.php', '-sidebar', '-fullwidth'), '', $page_layout ); 
    }

    global $post;

    $data = array(
	    'ajaxurl'	    => admin_url( 'admin-ajax.php' ),
        'post_id'       => isset($post->ID)?$post->ID:'',
        'page_layout'   => $page_layout,
        'nonce'         => wp_create_nonce('nonce_'.$page_layout)
    );

    switch( $page_layout ) {
        case 'portfolio':
            $opts = get_post_meta($post->ID, '_dt_portfolio_layout_options', true);
            break;
        case 'photos':
            $opts = get_post_meta($post->ID, '_dt_photos_layout_options', true);
            break;
        case 'videogal':
            $opts = get_post_meta($post->ID, '_dt_video_layout_options', true);
            break;
        case 'photogallery':
            $opts = get_post_meta($post->ID, '_dt_gallery_layout_options', true);
            break;
        case 'category':
            $opts = get_post_meta($post->ID, '_dt_category_layout_options', true);
            break;
        case 'albums':
            $opts = get_post_meta($post->ID, '_dt_albums_layout_options', true);
            break;
    }
    if( isset($opts['layout']) ) {
        $data['layout'] = end(explode('-', $opts['layout']));
    }

    wp_localize_script( 'dt_scripts', 'dt_ajax', $data );
}
add_action('wp_enqueue_scripts', 'dt_setup_scripts');

function dt_setup_styles() {
    $uri = get_template_directory_uri();

    wp_enqueue_style( 'dt_style',  $uri.'/images/style.css' );
}
//add_action( 'wp_enqueue_scripts', 'dt_setup_styles' );

function dt_explorer_stuff() {
	if( !is_admin() ):
?>
    <!--[if IE]><script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script><![endif]-->
    <!--[if lte IE 7]><link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/old_ie.css" /><![endif]-->
    <!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/js/plugins/highslide/highslide-ie6.css" />
	<![endif]-->
    <!--[if lte IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/origami-ie8.css" />
	<![endif]-->
<?php
	endif;
}
//add_action( 'wp_print_scripts', 'dt_explorer_stuff' );

function dt_setup_admin_scripts( $hook ) {
    if( 'widgets.php' != $hook )
       return; 
    
    wp_enqueue_script( 'dt_admin_widgets', get_template_directory_uri().'/js/admin/admin_widgets_page.js', array('jquery') );
}
add_action("admin_enqueue_scripts", 'dt_setup_admin_scripts');

function dt_footer_widgetarea() {
    global $post;
    if( !empty($post) && is_single() ) {
        switch( $post->post_type ) {
            case 'post':
                dt_widget_area('', null, 'sidebar_5'); return false;
            case 'dt_catalog': 
                dt_widget_area('', null, 'sidebar_6'); return false;
        }
    }

    dt_widget_area('footer');
}

function dt_aside_widgetarea() {
    dt_widget_area('sidebar');
}

function dt_widgets_params( $params ) {
    $params['before_widget'] = '<div class="widget">';
    $params['after_widget'] = '</div>';
    $params['before_title'] = '<div class="header">';
    $params['after_title'] = '</div>';
    return $params;
}
add_filter('dt_setup_widgets_params', 'dt_widgets_params');

function dt_page_navi_args_filter( $args ) {
    $args['wrap'] = '<div id="nav-above" class="navigation blog"><ul class="%CLASS%">%LIST%';

    $add_data = dt_storage('add_data');
    if( $add_data &&
        isset($add_data['init_layout']) &&
        $add_data['init_layout'] == '3_col-list'
    ) {
        $args['wrap'] = '<div id="nav-above" class="navigation blog with-3-col"><ul class="%CLASS%">%LIST%';
    }

    $args['item_wrap'] = '<li class="%ACT_CLASS%"><a href="%HREF%" class="btn btn-green"><span>%TEXT%</span></a></li>';
    $args['first_wrap'] = '<li class="larr"><a href="%HREF%" class="btn btn-green"><span>%TEXT%</span></a></li>';
    $args['last_wrap'] = '<li class="rarr"><a href="%HREF%" class="btn btn-green"><span>%TEXT%</span></a></li>';
    $args['dotleft_wrap'] = '<li class="dotes">%TEXT%</li>'; 
    $args['dotright_wrap'] = '<li class="dotes">%TEXT%</li>';
    $args['pages_wrap'] = '</ul><div class="paginator-r"><span class="pagin-info">%TEXT%</span>%PREV%%NEXT%</div></div>';
    $args['pages_prev_class'] = 'prev';
    $args['pages_next_class'] = 'next';
    $args['act_class'] = 'act';
    return $args;
}
add_filter('wp_page_navi_args', 'dt_page_navi_args_filter');

function dt_details_link( $post_id = null, $class = 'button' ) {
    if( empty($post_id) ) {
        global $post;
        $post_id = $post->ID;
    }
    $url = get_permalink($post_id);
    if( $url ) {
        printf(
            '<a href="%s" class="%s"><span><i class="more"></i>%s</span></a>',
            $url, $class, __('Details', LANGUAGE_ZONE)
        );
    }
}

// edit post link
function dt_edit_link( $text = 'Edit', $post_id = null, $class = 'button' ) {
    if( current_user_can('edit_posts')) {
        global $post;
        if( empty($post_id) && $post ) {
            $post_id = $post->ID;
        }
        
        if( !empty($class) )
            $class = sprintf( ' class="%s"', esc_attr($class) );

        printf( '<a href="%s"' . $class . ' style="margin-left: 5px;"><span>%s</span></a>',
            get_edit_post_link($post_id),
            $text
        );
    }
}

/* comments callback
 */
function dt_single_comments( $comment, $args, $depth ) {
    static $comments_count = 0, $prev_depth = 1;
    $comments_count++;
     
    if( $prev_depth != $depth ) {
        // this is shit 
        if( $depth < $prev_depth ) {
            for( $i = $depth; $i < $prev_depth; $i++ ) {
                echo '</div>';
            }
        }
        $prev_depth = $depth;
    }
     
    $classes = array();
    if( !$args['has_children'] || ($depth == 5) ) {
        $classes[] = 'nochildren';
    }

    $GLOBALS['comment'] = $comment;
    $avatar_size = 52;
    $classes = implode( ' ', $classes ); 
    ?>
    <div id="comment-<?php echo $comment->comment_ID ?>" class="comment level<?php echo $depth; ?> <?php echo esc_attr($classes); ?>">
        <span class="avatar"><?php
            echo get_avatar(
                $comment,
                $avatar_size,
                esc_url( get_template_directory_uri() . '/images/com.jpg' )
            );
        ?></span>
          <span class="text<?php echo ($args['comments_nmbr'] == $comments_count)?' last':''; ?>"><span class="head"><?php comment_author($comment->comment_ID); ?></span><span class="comment-meta"><span class="ico-link date"><?php
                printf(
                    __('%s at %s', LANGUAGE_ZONE ),
                    get_comment_date(),
                    get_comment_time()
                );
                ?></span><?php
        edit_comment_link(
            __( 'Edit', LANGUAGE_ZONE ),
            '<span class="edit-link">',
            '</span>'
        );
        ?><a href="#" class="ico-link comments"><?php _e( 'Reply', LANGUAGE_ZONE ); ?></a></span>
        <?php comment_text(); ?>
        </span>
    </div><!-- close element -->
    <?php
    
    if( $depth >= 1 && $depth < 5 && $args['has_children'] ) {
        echo '<div class="children">';
    }
    
    if( $args['comments_nmbr'] == $comments_count ) {
        for( $i = 0; $i < $depth - 1; $i++ ) {
            echo '</div>';
        }
    }

}

function dt_comments_end_callback() {
}

// gravatar
/*
add_filter( 'avatar_defaults', 'dt_default_avatar' );
function dt_default_avatar ( $avatar_defaults ) {
		$new_avatar_url = get_bloginfo( 'template_directory' ) . '/images/com.jpg';
		$avatar_defaults[$new_avatar_url] = 'DT Default avatar';
		return $avatar_defaults;
}
 */
function dt_index_layout_init( $layout ) {
    if( 'index' != $layout ) {
        return false;
    }

    
    if( 'post-format-standard' == get_query_var('post_format') ) {
        global $_wp_theme_features;
        $pf_arr = array();
        foreach( $_wp_theme_features['post-formats'][0] as $pf ){
            $pf_arr[] = 'post-format-' . $pf;
        }
        
        if( !$paged = get_query_var('page') )
            $paged = get_query_var('paged');

        query_posts( array(
            'tax_query' => array( array(
                'taxonomy'  => 'post_format',
                'field'     => 'slug',
                'terms'     => $pf_arr,
                'operator'  => 'NOT IN'
            ) ),
            'post_type'     => 'post',
            'paged'                 => $paged,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => true
        ) );
    }

    global $wp_query;
    if( have_posts() ) {
        $thumb_arr = dt_core_get_posts_thumbnails( $wp_query->posts );
        dt_storage( 'thumbs_array', $thumb_arr['thumbs_meta'] );
    }  
    dt_storage( 'post_is_first', 1 );
}
add_action('dt_layout_before_loop', 'dt_index_layout_init', 10, 1);

function dt_main_block_class_changer( $class = '', $echo = true ) {
    $template = dt_core_get_template_name();
    $classes = array();
    
    if( $class ) {
        $classes[] = $class;
    }

    switch( $template ) {
        case 'dt-homepage-blog.php':
            global $paged;
            if( $paged > 1) {
                $classes[] = 'bg';
                break;
            }
        case 'dt-slideshow-fullwidth.php':
        case 'dt-slideshow-sidebar.php':
            $classes[] = 'home-bg';
            break;    
        default:
            $classes[] = 'bg';
    }
    
    if( $echo ) {
        echo implode(' ', $classes);
    }else {
        return $classes;
    }
    return false;
}

function dt_get_layout_switcher( $opts = array(), $echo = true ) {
    $buttons = array(
        '2_col'     => array(
            'grid'  => array(
                'class'     => 'categ td',
                'href'      => 'grid',
                'i_class'   => 'ico-f'
            ),
            'list' => array(
                'class'     => 'categ list',
                'href'      => 'list',
                'i_class'   => 'ico-t'
            )
        ),
        '3_col'     => array(
            'grid'  => array(
                'class'     => 'categ td-three',
                'href'      => 'grid',
                'i_class'   => 'three-coll'
            ),
            'list' => array(
                'class'     => 'categ list-three',
                'href'      => 'list',
                'i_class'   => 'three-coll-t'
            )
        )
    );
    $defaults = array(
        'type'      => '2_col',
        'current'   => 'list',
        'hash'      => '%s'
    );
    $opts = wp_parse_args( $opts, $defaults );

    if( !isset($buttons[$opts['type']]) || !isset($buttons[$opts['type']][$opts['current']]) ) {
        return false;
    }

    $output = '';

    foreach( $buttons[$opts['type']] as $select=>$button ) {
        if( $select == $opts['current'] ) {
            $button['class'] .= ' act';
        }
        $output .= sprintf(
            '<a class="button %s" href="%s"><span><i class="%s"></i></span></a>',
            $button['class'],
            sprintf( $opts['hash'], $button['href'] ),
            $button['i_class']
        );
    }

    if( $echo ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

function dt_excerpt_more_filter( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'dt_excerpt_more_filter' );

function dt_get_category_list_options_filter( $opts ) {
    $opts['wrap'] = '%LIST%';
    $opts['item_wrap'] = '<a href="%HREF%" class="%CLASS%"><span>%TERM_NICENAME% (%COUNT%)</span></a>';
    $opts['item_class'] = 'button';
    return $opts;
}
add_filter( 'dt_get_category_list_options', 'dt_get_category_list_options_filter' );

function dt_category_list( array $opts ) {
    $defaults = array(
        'taxonomy'          => null,
        'post_type'         => null,
        'layout'            => null,
        'terms'             => array(),
        'select'            => 'all',
        'layout_switcher'   => true,
        'count_attachments' => false,
        'show'              => true,
        'post_ids'          => array()
    );
    $opts = wp_parse_args( $opts, $defaults );
    
    if( !($opts['taxonomy'] && $opts['post_type'] && $opts['layout'] && ($opts['show'] || $opts['layout_switcher'])) ) {
        return '';
    }
    
    if( $opts['show'] || $opts['layout_switcher'] ):

        $layout = explode('-', $opts['layout']);

        if( $opts['show'] ) {
            $list = dt_get_category_list( array(
                'taxonomy'          => $opts['taxonomy'],
                'post_type'         => $opts['post_type'],
                'terms'             => $opts['terms'],
                'count_attachments' => $opts['count_attachments'],
                'select'            => $opts['select'],
                'post_ids'          => $opts['post_ids'],
                'hash'              => '#%TERM_ID%/%PAGE%/' . (isset($layout[1])?$layout[1]:'list')
            ), false );
        }else
            $list = false;
    ?>
    
<div class="navig-category<?php echo !$list?' no-category':''; ?>">
    
    <?php
    
    echo $list;

    if( isset($layout[1]) && $opts['layout_switcher'] ) {
        dt_get_layout_switcher( array(
            'type'      => $layout[0],
            'current'   => $layout[1],
            'hash'      => '#all/1/%s'
        ) );
    }
    ?>

</div>

    <?php
    endif;
}

function dt_post_type_do_ajax() {
    $new_paged = !empty($_POST['paged'])?trim(intval($_POST['paged'])):1;
    $layout = !empty($_POST['layout'])?trim(stripslashes($_POST['layout'])):''; 

    $cat_id = !empty($_POST['cat_id'])?trim(stripslashes($_POST['cat_id'])):'all';
    if( 'all' != $cat_id && 'none' != $cat_id ) {
       $cat_id = explode(',', $cat_id); 
    }

    if( isset($_POST['page_layout']) ) {
        $page_layout = trim(stripslashes($_POST['page_layout']));
    }else {
        wp_die( __('Empty page layout', LANGUAGE_ZONE) );
    }

    if( !empty($_POST['post_id']) ) {
        $post_id = intval(trim($_POST['post_id']));
    }else {
        wp_die( __('Empty post id', LANGUAGE_ZONE) );
    }

    switch( $page_layout ) {
        case 'portfolio':
            $page_layout = 'dt-portfolio';
            break;
        case 'photos':
            $page_layout = 'dt-photos';
            break;
        case 'catalog':
            $page_layout = 'dt-catalog';
            break;
        case 'albums':
            $page_layout = 'dt-albums';
            break;
        case 'videogal':
            $page_layout = 'dt-video';
            break;
        default:
            wp_die( __('Undefined page layout', LANGUAGE_ZONE) );
    }

    // do page init
    global $wp_query;
    $wp_query->query('page_id=' . $post_id . '&status=publish');

    if( have_posts() ) {
        the_post();
    }else {
        wp_die( __('There are no such page', LANGUAGE_ZONE) );
    }

    // replace paged
    $wp_query->set('paged', $new_paged);
    global $paged;
    $paged = $new_paged;

    // store settings
    dt_storage( 'page_data', array(
        'cat_id'        => is_array($cat_id)?$cat_id:array($cat_id),
        'page_layout'   => $page_layout,
        'base_url'      => get_permalink($post_id),
        'layout'        => $layout
    ) );
    
    $data = array(
        'cat_id'    => $cat_id    
    );

    do_action('dt_layout_before_loop', $page_layout, $data );
    global $DT_QUERY;
    if( $DT_QUERY->have_posts() ) {

        while( $DT_QUERY->have_posts() ) {
            $DT_QUERY->the_post();
            get_template_part('content', $page_layout);
        }
        if( function_exists('wp_pagenavi') ) {
            wp_pagenavi( $DT_QUERY, array( 'ajaxing'   => true, 'num_pages' => dt_storage('num_pages', null, 5)) );
        }
    }

    // IMPORTANT: don't forget to "exit"
    exit;
}
add_action( 'wp_ajax_nopriv_dt_post_type_do_ajax', 'dt_post_type_do_ajax' );
add_action( 'wp_ajax_dt_post_type_do_ajax', 'dt_post_type_do_ajax' );

function dt_get_anything_slider( $opts = array(), $echo = true ) {
    $defaults = array(
        'wrap'      => '<div class="%CLASS%">%SLIDER%</div>',
        'class'     => 'slider-shortcode anything gal',
        'items_arr' => array()
    );
    $opts = wp_parse_args( $opts, $defaults );
    
    if( empty($opts['items_arr']) )
        return '';

    $output = '';
    foreach( $opts['items_arr'] as $slide ) {
        $caption = '';
        if( !empty($slide['caption']) ) {
            $caption = sprintf(
                '<span class="html-caption"><p>%s</p></span>',
                $slide['caption']
            );
        }

        $output .= '<li class="panel">'."\n";
        if( !isset($slide['is_video']) || $slide['is_video'] == false ) {
            $output .= sprintf(
                '<img src="%s" %s />%s',
                $slide['src'],
                $slide['size_str'],
                $caption
            );
        }else {
            $output .= dt_get_embed( $slide['src'], $slide['size_str'][0], $slide['size_str'][1], false );
        }
        $output .= '</li>';
    }
    $output = '<ul class="anything-slider">' . $output . '</ul>';
    
    $output = str_replace( array(
            '%SLIDER%',
            '%CLASS%'
        ), array(
            $output,
            $opts['class']
        ), $opts['wrap']
    );

    if( $echo ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

function dt_get_carousel_slider( array $opts = array(), $echo = true ) {
    $defaults = array(
        'wrap'      => '<div class="%CLASS%">%SLIDER%<a id="prev1" class="prev" href="#"></a><a id="next1" class="next" href="#"></a></div>',
        'class'     => 'list-carousel recent',
        'id'        => '',
        'items_arr' => array()
    );
    $opts = wp_parse_args( $opts, $defaults );
    
    $output = '';
    foreach( $opts['items_arr'] as $item ) {
        $caption = '';
/*        if( $slide['caption'] ) {
            $caption = sprintf(
                '<span class="html-caption">%s</span>',
                $slide['caption']
            );
        }
 */     
        if( !isset($item['href']) ) {
            if( isset($item['post_id']) ) {
                $item['href'] = get_permalink($item['post_id']);
            }else {
                $item['href'] = '#';
            }
        }
        $output .= sprintf(
            '<li><div class="textwidget"><div class="textwidget-photo"><a class="photo" href="%s"><img src="%s" %s /></a></div></div></li>',
            $item['href'],
            $item['src'],
            $item['size_str']
//            $item['caption']
        );
    }
    $output = '<ul' . ( !empty($opts['id'])?' id="' . $opts['id'] . '"':'' ) . ' class="carouFredSel_1">' . $output . '</ul>';
    
    $output = str_replace( array(
            '%SLIDER%',
            '%CLASS%'
        ), array(
            $output,
            $opts['class']
        ), $opts['wrap']
    );

    if( $echo ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

function dt_get_carousel_homepage_slider( array $opts = array(), $echo = true ) {
    $defaults = array(
        'wrap'      => '<div class="navig-nivo caros"><div id="carousel-left"></div><div id="carousel-right"></div></div><section id="%ID%"><div id="carousel-container"><div id="carousel">%SLIDER%</div></div></section>',
        'class'     => '',
        'id'        => 'slide',
        'items_arr' => array()
    );
    $opts = wp_parse_args( $opts, $defaults );
    
    $output = '';
    foreach( $opts['items_arr'] as $item ) {
        $item_output = '';
        $link = '<a href="javascript: void(0);">%s</a>';
		
        if( !empty($item['title']) )
            $item_output .= '<div class="caption-head">' . $item['title'] . '</div>';

        if( !empty($item['caption']) )
            $item_output .= '<div class="text-capt">' . $item['caption'] . '</div>';

        if( $item_output )
            $item_output = '<div class="carousel-caption">' . $item_output . '</div>';
		
		if( !empty($item['link']) ) {
			if( !empty($item['in_neww']) )
				$link = '<a href="'. $item['link']. '" target="_blank">%s</a>';
			else
				$link = '<a href="'. $item['link']. '">%s</a>';
		}
		
		$img = sprintf( $link, '<img class="carousel-image" alt="' . ( !empty($item['title'])?esc_attr($item['title']):'' ) . '" src="' . $item['src'] . '" />' );
        $item_output = $img. '<div class="mask"><img alt="" src="' . get_template_directory_uri() . '/images/bg-carousel.png" /></div>' . $item_output;

        $output .= '<div class="carousel-feature">' . $item_output . '</div>';
    }

    $output = str_replace(
        array( '%SLIDER%', '%CLASS%', '%ID%' ),
        array( $output, $opts['class'], $opts['id'] ),
        $opts['wrap']
    );

    if( $echo ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

function dt_get_photo_stack_slider( array $opts = array(), $echo = true ) {
    wp_enqueue_script( 'dt_photo_stack', get_template_directory_uri().'/js/photo-stack.js', array('jquery') );

    $defaults = array(
        'wrap'      => '<div class="navig-nivo ps"><a class="prev"></a><a class="next"></a></div><section id="%ID%"><div id="ps-slider" class="ps-slider"><div id="ps-albums">%SLIDER%</div></div></section>',
        'class'     => '',
        'id'        => 'slide',
        'items_arr' => array()
    );
    $opts = wp_parse_args( $opts, $defaults );
    
    $output = '';
    foreach( $opts['items_arr'] as $item ) {
        $item_output = $link = $link_class = '';
                	
        if( !empty($item['title']) )
            $item_output .= '<div class="ps-head"><h3>' . $item['title'] . '</h3></div>';

        if( !empty($item['caption']) )
            $item_output .= '<div class="ps-cont">' . $item['caption'] . '</div>';

        if( $item_output )
            $item_output = '<div class="ps-desc">' . $item_output . '</div>';
		
		if( !empty($item['link']) ) {
			$link_class = ' dt-clickable';
			if( !empty($item['in_neww']) )
				$link = ' onclick="window.open(\''. $item['link']. '\');"';
			else
				$link = ' onclick="window.location=\''. $item['link']. '\'";';
		}
	
        $item_output = '<img class="carousel-image" alt="' . ( !empty($item['title'])?esc_attr($item['title']):'' ) . '" src="' . $item['src'] . '" />' . $item_output;

        $output .= '<div class="ps-album"><div class="ps-inner'. $link_class. '"'. $link. '>' . $item_output . '</div></div>';
    }

    $output = str_replace(
        array( '%SLIDER%', '%CLASS%', '%ID%' ),
        array( $output, $opts['class'], $opts['id'] ),
        $opts['wrap']
    );

    if( $echo ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

function dt_get_jfancy_tile_slider( array $opts = array(), $echo = true ) {
    wp_enqueue_script( 'dt_jfancy_tile', get_template_directory_uri().'/js/jquery.jfancytile.js', array('jquery') );

    $defaults = array(
        'wrap'      => '<div class="navig-nivo"></div><section id="%ID%"><div id="fancytile-slide"><ul>%SLIDER%</ul></div><div class="mask"></div></section>',
        'class'     => '',
        'id'        => 'slide',
        'items_arr' => array()
    );
    $opts = wp_parse_args( $opts, $defaults );
    
    $output = '';
    foreach( $opts['items_arr'] as $item ) {
        $item_output = $link = '';
                	
        if( !empty($item['title']) )
            $item_output .= '<div class="caption-head">' . $item['title'] . '</div>';

        if( !empty($item['caption']) )
            $item_output .= '<div class="text-capt">' . $item['caption'] . '</div>';

        if( $item_output )
            $item_output = '<div class="html-caption">' . $item_output . '</div>';
		
		if( !empty($item['link']) ) {
			$link = ' data-link="'. esc_attr($item['link']). '"';
			if( isset($item['in_neww']) )
				$link .= ' data-target_blank="'. intval($item['in_neww']). '"';
		}
		
        $item_output = '<img alt="' . ( !empty($item['title'])?esc_attr($item['title']):'' ) . '" src="' . $item['src'] . '" ' . $item['size_str'] . $link. ' />' . $item_output;

        $output .= '<li>' . $item_output . '</li>';
    }

    $output = str_replace(
        array( '%SLIDER%', '%CLASS%', '%ID%' ),
        array( $output, $opts['class'], $opts['id'] ),
        $opts['wrap']
    );

    if( $echo ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

function dt_get_coda_slider( array $opts = array() ) {
    $defaults = array(
        'wrap'      => '<div class="coda-slider-wrapper"><div class="coda-slider preload">%SLIDER%</div></div>',
        'item_wrap' => '<div class="panel"><div class="panel-wrapper">%1$s</div><div class="panel-author">%2$s</div></div>',
        'data'      => array(),
        'wrap_data' => array(),
        'echo'      => true
    );
    $opts = wp_parse_args( $opts, $defaults );
    
    if( empty($opts['data']) || !is_array($opts['data']) ) {
        return '';
    }

    $output = '';
    foreach( $opts['data'] as $slide ) {
        if( !is_array($slide) ) {
            continue;
        }

//        $slide[0] = apply_filters('the_content', strip_shortcodes($slide[0]));
        
        $replace_arr = array();
        for( $i = 0; $i < count( $slide ); $i++ ) {
            $replace_arr[] = '%' . ($i + 1) . '$s';
            if( isset($opts['wrap_data'][$i]) ) {
                $slide[$i] = sprintf( $opts['wrap_data'][$i], $slide[$i] );
            }
        }
        $output .= str_replace( $replace_arr, $slide, $opts['item_wrap'] );
    }
    
    $output = str_replace( array('%SLIDER%'), array( $output ), $opts['wrap'] );

    if( $opts['echo'] ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

/* Nivo slider helper
 */
function dt_get_nivo_slider( array $opts = array(), $echo = true ) {
    $defaults = array(
        'wrap'          => '<div class="navig-nivo big-slider"><div class="nivo-directionNav"><a class="nivo-prevNav"></a><a class="nivo-nextNav"></a></div></div><section id="%ID%"><div class="%CLASS%">%SLIDER%</div><div class="mask"></div><div class="grid"></div></section>',
        'class'         => 'slider-wrapper theme-default',
        'id'            => 'slide',
        'items_wrap'    => '<div id="slider" class="nivoSlider">%IMAGES%</div>%CAPTIONS%',
        'items_arr'     => array()
    );
    $opts = wp_parse_args( $opts, $defaults );

    if( empty($opts['items_arr']) )
        return '';

    $output = '';
    $images = $caption = '';
    $i = 1;

    foreach( $opts['items_arr'] as $slide ) {
		$link = '%s';
        $caption .= '<div class="nivo-html-caption caption-' . $i . '">';

        if( !empty($slide['title']) )
            $caption .= '<div class="caption-head">' . $slide['title'] . '</div>';

        if( !empty($slide['caption']) )
            $caption .= '<div class="text-capt">' . $slide['caption'] . '</div>';
		
		if( !empty($slide['link']) ) {
			if( !empty($slide['in_neww']) )
				$link = '<a href="'. $slide['link']. '" target="_blank">%s</a>';
			else
				$link = '<a href="'. $slide['link']. '">%s</a>';
		}
		
        $caption .= '</div>';

        $images .= sprintf( $link, '<img src="' . $slide['src'] . '" alt="" title=".caption-' . $i . '" ' . $slide['size_str'] . ' />' );
        $i++;
    }

    $output .= str_replace( array('%IMAGES%', '%CAPTIONS%'), array($images, $caption), $opts['items_wrap'] );
/*    
    '<div id="slider" class="nivoSlider">' . $images . '</div>' . $caption;
 */
    $output = str_replace(
        array( '%SLIDER%', '%CLASS%', '%ID%' ),
        array( $output, $opts['class'], $opts['id'] ),
        $opts['wrap']
    );

    if( $echo ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

function dt_portfolio_classes( $type = '2_col-list', $place = '', $echo = true ) {
    if( empty($place) ) {
        return '';
    }
    $class = array(
        '2_col' => array(
            'list'  => array(
                'fullwidth' => array(
                    'block' => 'textwidget text',
                    'head'  => 'head',
                    'info'  => 'info half'
                ),
                'sidebar'   => array(
                    'block' => 'textwidget text',
                    'head'  => 'head',
                    'info'  => 'info half'
                )
            ),
            'grid'  => array(
                'fullwidth' => array(
                    'block' => 'textwidget',
                    'head'  => 'head',
                    'info'  => 'info half'
                ),
                'sidebar'   => array(
                    'block' => 'textwidget',
                    'head'  => 'head',
                    'info'  => 'info half'
                )
            )
        ),
        '3_col' => array(
            'list'  => array(
                'fullwidth' => array(
                    'block' => 'textwidget one-third',
                    'head'  => 'head-capt',
                    'info'  => 'info one-third'
                ),
                'sidebar'   => array(
                    'block' => 'textwidget one-fourth',
                    'head'  => 'head-capt',
                    'info'  => 'info one-fourth'
                )
            ),
            'grid'  => array(
                'fullwidth' => array(
                    'block' => 'textwidget',
                    'head'  => 'head-capt',
                    'info'  => 'info one-third'
                ),
                'sidebar'   => array(
                    'block' => 'textwidget',
                    'head'  => 'head-capt',
                    'info'  => 'info one-fourth'
                )
            )
        )
    );

    $add_data = dt_storage( 'add_data' );

    $type = explode('-', $type);
    if( !isset($class[$type[0]][$type[1]][$add_data['template_layout']][$place]) ) {
        return '';
    }

//    var_dump( $type, $add_data['template_layout'], $place );

    $output_class = $class[$type[0]][$type[1]][$add_data['template_layout']][$place];
    
    if( $echo ) {
        echo $output_class;
    }else {
        return $output_class;
    }
    return false;
}

function dt_storage_add_data_init( array $data ) {
//    $opts = get_post_meta($post->ID, '_dt_portfolio_layout_options', true);
    $thumb_sizes = array(
        '2_col' => array(
            'fullwidth' => array( 462, 272 ),
            'sidebar'   => array( 337, 202 )
        ),
        '3_col' => array(
            'fullwidth' => array( 298, 172 ),
            'sidebar'   => array( 215, 122 )
        )
    );
    $add_data = array();
    $template = dt_core_get_template_name();
    $page_data = dt_storage('page_data');

    if( isset($data['layout']) ) {
        $cols_layout = current(explode('-', $data['layout']));
        $add_data['init_layout'] = $cols_layout . '-' . $page_data['layout'];//$opts['layout']; 
    }else {
        $cols_layout = '';
    }
    
    if( isset($data['template_layout']) ) {
        $template_layout = array( '1' => $data['template_layout'] );
    }else {
        $template_layout = explode( '-', str_replace(array('dt-', '.php'), '', $template) );
    }    
    if( isset($template_layout[1]) ) {
        $template_layout = $template_layout[1];
        if( isset($thumb_sizes[$cols_layout][$template_layout][0]) &&
            isset($thumb_sizes[$cols_layout][$template_layout][1])
        ) {
            $add_data['thumb_w'] = $thumb_sizes[$cols_layout][$template_layout][0];
            $add_data['thumb_h'] = $thumb_sizes[$cols_layout][$template_layout][1];
        }
    }else {
        $template_layout = '';
    }

    $add_data['cols_layout'] = $cols_layout;
    $add_data['template_layout'] = $template_layout;
     
    dt_storage('add_data', $add_data);
}

function dt_style_options_get_image( $params, $img_1, $img_2 = '', $use_second_img = false ) {
    if( 'none' == $img_1 && (!$img_2 || 'none' == $img_2) )
        return 'none;';
    
    if( 'none' == $img_1 && !$use_second_img ) {
        return $img_1 . ';';
    }
    
    $defaults = array(
        'repeat'    => 'repeat',
        'x-pos'     => 0,
        'y-pos'     => 0,
        'important' => true
    );
    $params = wp_parse_args( $params, $defaults );

    $output = get_stylesheet_directory_uri() . $img_1;
    if( $use_second_img && $img_2 ) {
        $output = site_url() . $img_2;
    }
    $output = sprintf(
        'url(%s)%s;',
        esc_url($output),
        ($params['important']?' !important':'')
    );
    return $output;
}

function dt_style_options_get_bg_position( $y, $x ) {
    return sprintf( '%s %s !important;', $y, $x );
}

function dt_style_options_get_rgba_from_hex_color( $params, $color, $opacity = 0 ) {
    $defaults = array(
        'important' => true
    );
    $params = wp_parse_args( $params, $defaults );

    if( is_array($color) ) {
        $rgb_array = array_map('intval', $color);    
    }else {
        $color = str_replace('#', '', $color);
        $rgb_array = str_split($color, 2);
        if( is_array($rgb_array) && count($rgb_array) == 3 ) {
            $rgb_array = array_map('hexdec', $rgb_array);
        }else {
            return '#ffffff;';
        }
    }

    $opacity = ($opacity > 0)?$opacity/100:0;
    
    return sprintf(
        'rgba(%d,%d,%d,%s)%s;',
        $rgb_array[0], $rgb_array[1], $rgb_array[2], $opacity,
        ($params['important']?' !important':'')
    );
}

function dt_style_options_get_rgba_from_hex_color_for_ie( $params, $color, $opacity = 0 ) {
    $defaults = array(
        'important' => true
    );
    $params = wp_parse_args( $params, $defaults );

    if( is_array($color) ) {
        $hex_color = implode( '', $color );   
    }else{
        $hex_color = str_replace( '#', '', $color );
    }

    $opacity = ($opacity > 0)?round($opacity*2.55):0;
    
    
    return sprintf(
        'progid:DXImageTransform.Microsoft.gradient(startColorstr=#%2$s%1$s,endColorstr=#%2$s%1$s)%3$s;',
        $hex_color, dechex($opacity), ($params['important']?' !important':'')
    );
}

function dt_get_shadow_color( $color, $params = ' 1px 1px 0' ) {
	$shadow = 'none';
	if( $color )
		$shadow = $color. $params;
	return $shadow;
}

function dt_get_soc_links() {
    $links = of_get_option('social_icons');

    if( empty($links) ) {
        return '';
    }

?>

    <ul class="soc-ico">

<?php foreach( $links as $name=>$data ): ?>

        <li><a class="<?php echo $name; ?> trigger" href="<?php echo esc_url($data['link']); ?>"><span><?php echo $name; ?></span></a></li> 

<?php endforeach; ?>

    </ul>

<?php
}

function dt_redirect_for_standard_post_format() {
    if( 'post-format-standard' == get_query_var('post_format') ) {
        locate_template( array( 'archive.php', 'index.php' ), true );
        exit;
    }
}
add_action( 'template_redirect', 'dt_redirect_for_standard_post_format' );

// gallery shortcode filter
function dt_filter_gallery_sc($output, $attr) {
	global $post, $wp_locale;
	$exclude_def = '';
    $event = '';
	if( $hide_in_gal = get_post_meta( $post->ID, 'hide_in_gal', true ) && ('gallery' == get_post_format($post->ID)) ) {
		$exclude_def = get_post_thumbnail_id( $post->ID );
	}
	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}
		
	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'li',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => $exclude_def
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	if( isset($attr['link']) && ('file' == $attr['link']) ) {
        $event .= 'onclick="return hs.expand(this, { slideshowGroup: \'' . $post->ID . '\' })"';
		$hs_class = " hs_me";
	}else {
		$hs_class = " to_attachment";
	}
	
	$itemtag = tag_escape($itemtag);
	$columns = intval($columns);
	$size_class = sanitize_html_class( $size );
	
	//$output	= '';
	$output = "<div class='img-text-list itl-right'><ul class='style1 style1 num-{$columns} shadow-side clearfix  gallery-size-{$size_class}'>";

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$class = $description = '';
        $class .= 'highslide img-wrap-a ';
		if( isset($attr['link']) && ('file' == $attr['link']) ) {
			$href = wp_get_attachment_image_src($id, 'full');
			$href = $href?current($href):'#';
			$class .= "fadeThis ";
		}else {
			$href = get_permalink($id);
		}
		
		if( $attachment->post_content ) {
			$description = '<p class="wp-caption-text">'.wptexturize($attachment->post_content).'</p>';
			$class .= 'wp-caption ';
		}
		
		$caption = wptexturize(trim($attachment->post_excerpt));
		$dt_img = dt_get_thumbnail(
            array(
                'img_id'	=> $id,
                'width'		=> 154,
                'height'    => 94,
                'upscale'	=> true,
                'quality'   => 90,
                'zc_align'  => 'c'
            )        
        );
        $src[0] = $dt_img['thumnail_img'];
        $src[1] = $dt_img['width'];
        $src[2] = $dt_img['height'];
        //$src = wp_get_attachment_image_src($id, $size);
        
		$link = "<a class='{$class}' href='{$href}' title='{$caption}' rel='prettyPhoto[gallery-hor]'>
		<img src='{$src[0]}' alt='' width='{$src[1]}' height='{$src[2]}'/>{$description}
		</a>";
        
        $li_size = $src[1];
        
		$output .= "<{$itemtag}>";
		$output .= '<div class="img">';
		$output .= $link;
		$output .= '<div class="shadow"></div>';
		$output .= '</div>';
		$output .= '<div class="title vh"><h3>荣誉证书</h3></div>';
		$output .= "</{$itemtag}>";
	}

	$output .= "</ul>\n";

	return $output;
}
add_filter('post_gallery', 'dt_filter_gallery_sc', 10, 2);

add_filter('body_class','dt_body_class_names');
function dt_body_class_names($classes) {
    foreach( $classes as $index=>$class ) {
        if( 'search' == $class ) {
            unset($classes[$index]);
        }
    }
	return $classes;
}

function dt_password_form() {
    global $post, $paged;
    $http_referer = wp_referer_field( false );
    $page_data = dt_storage( 'page_data' ); 
    $wp_ver = explode('.', get_bloginfo('version'));
    $wp_ver = array_map( 'intval', $wp_ver );
    
    if( $wp_ver[0] < 3 || ( 3 == $wp_ver[0] && $wp_ver[1] <= 3 ) ) {
        $form_action = esc_url( get_option('siteurl') . '/wp-pass.php' );
    }else {
        $form_action = esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); 
    } 

    if( $page_data && isset($page_data['base_url']) && isset($page_data['cat_id']) && isset($page_data['layout']) ) {
        $site_url = site_url();
        $http_referer = str_replace( str_replace($site_url, '', admin_url('admin-ajax.php')), str_replace($site_url, '', $page_data['base_url']).'#'.current($page_data['cat_id']).'/'.$paged.'/'.$page_data['layout'], $http_referer );
    }
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<div class="form-protect"><form class="protected-post-form get-in-touch" action="'. $form_action. '" method="post">'. $http_referer. '
    <div>' . __( "To view this protected post, enter the password below:", LANGUAGE_ZONE ) . '</div>
    <label for="' . $label . '">' . __( "Password:", LANGUAGE_ZONE ) . '&nbsp;&nbsp;&nbsp;</label><div class="i-h"><input name="post_password" id="' . $label . '" type="password" size="20" /></div>
	<a title="Submit" class="button go_submit" onClick="submit();" href="#"><span>' . esc_attr__( "Submit" ) . '</span></a>
	
	
    </form></div>
    ';
    return $o;
}
add_filter( 'the_password_form', 'dt_password_form' );

function dt_exclude_post_protected_filter( $where ) {
    return $where.' AND post_password=""';
}

if( false ) {
    ob_start();
    post_class();
    comment_form();
    ob_get_clean();
}

/*
	---------------------------------------------
		King
	---------------------------------------------
*/

require_once "king_host_posts.php";
require_once "widgets/king_pages.php";

add_filter('show_admin_bar','__return_false');//彻底移除管理员工具条
remove_action( 'wp_head', 'wp_generator' ); //删除版权

//字符串截取函数
function cutstr($sourcestr,$cutlength){
	$returnstr = '';
	$i = 0;
	$n = 0;
	$str_length = strlen($sourcestr);
	$mb_str_length = mb_strlen($sourcestr, 'utf-8');
	while(($n < $cutlength) && ($i <= $str_length)){
		$temp_str = substr($sourcestr,$i,1);
		$ascnum = ord($temp_str);
		if($ascnum >= 224){
			$returnstr = $returnstr.substr($sourcestr,$i,3);
			$i = $i + 3;
			$n++;
		}
		elseif($ascnum >= 192){
			$returnstr = $returnstr.substr($sourcestr,$i,2);
			$i = $i + 2;
			$n++;
		}
		elseif(($ascnum >= 65) && ($ascnum <= 90)){
			$returnstr = $returnstr.substr($sourcestr,$i,1);
			$i = $i + 1;
			$n++;
		}
		else{
			$returnstr = $returnstr.substr($sourcestr,$i,1);
			$i = $i + 1;
			$n = $n + 0.5;
		}
	}
	if ($mb_str_length > $cutlength){
		$returnstr = $returnstr . "...";
	}
	return $returnstr;
}


//Remove dashboard widgets   
function remove_dashboard_widgets(){   
  global $wp_meta_boxes;   
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);   
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);   
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);   
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);   
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);   
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); 
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);   
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
}   
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');



//custom admin logo   
function custom_logo() {   
  echo '<style type="text/css">   
    #wp-admin-bar-wp-logo span.ab-icon { background-image: url('.get_bloginfo('template_directory').'/images/admin_logo.png) !important; }   
    </style>';   
}   
add_action('admin_head', 'custom_logo');  

//输出模板路径
function the_tl_url(){
	echo get_template_directory_uri();
}

//当前页slug
function the_slug() {
    $post_data = get_post($post->ID, ARRAY_A);
    $slug = $post_data['post_name'];
    return $slug;
}

//king十条文章列表
function king_post_list($cart_ids=array(),$num=10){
	$html = '';
	foreach ($cart_ids as $cart_id){
		$cart=get_the_category($cart_id);
		$list ='';
		$html .= '<div class="box"><div class="h">';
		$html .= '<div class="hr fr"><a href="'.get_category_link( $cart_id).'">MORE&gt;&gt;</a></div>';
		$html .= '<h2>'.get_category($cart_id)->name.'</h2>';
		$html .= '</div><div class="b clearfix">';
	
		$king_query = new WP_Query();
		$king_query->query('cat='.$cart_id.'&showposts='.$num);
		$count=1;
		if ($king_query->have_posts()):
			foreach( $king_query->posts as $kingpost ) {
				if ($count==1){
					$thumb_id = get_post_thumbnail_id($kingpost->ID);
					$args = array(
							'posts_per_page'    => -1,
							'post_type'			=> 'attachment',
							'post_mime_type'	=> 'image',
							'post_parent'       => $kingpost->ID,
							'post_status' 		=> 'inherit'
					);
				
					$images = new WP_Query( $args );
				
					if( has_post_thumbnail($kingpost->ID) ) {
						$thumb_meta = wp_get_attachment_image_src($thumb_id, 'full');
					}elseif( $images->have_posts() ) {
						$thumb_meta = wp_get_attachment_image_src($images->posts[0]->ID, 'full');
					}else {
						$thumb_meta = array(
							0	=>	'/wp-content/themes/dt-king/images/noimage.jpg'
						);
					}

					$img = dt_get_thumb_img( array(
							'img_class'         => 'photo lazy-rwd-img',
							'img_meta'      => $thumb_meta,
							'use_noimage'   => true,
							'use_lazy'		=>	true,
							'title'         => $kingpost->post_title,
							'href'          => 'javascript:;',
							'thumb_opts'    => array( 'w' => 300, 'h' => 150 )
					),
							'<img %SRC% %DATA-SRC% %IMG_CLASS%  %SIZE%/>', false
					);
					$html .= '<div class="bl fl img-title-wrap">';
					$html .= '<figure class="img img-wrap"><a href="'.$kingpost->guid.'" data-src="'.$thumb_meta[0].'">'.$img.'</a></figure>';
					$html .= '<h3 class="title"><a href="'.$kingpost->guid.'">'.cutstr($kingpost->post_title,18).'</a></h3>';
					$html .= '<p>'.cutstr($kingpost->post_excerpt,63).'</p>';
					$html .= '<div class="post_meta"><span>点击:'.getPostViews($kingpost->ID).'次</span><span>标签：';
					$posttags = get_the_tags($kingpost->ID);
					if (!empty($posttags)){
						foreach ($posttags as $tag){
							$html .= '<a href="'.get_tag_link($tag->term_id).'">'.$tag->name.'</a>';
						}
					}
					$html .= '</span></div></div>';
					$count++;
				}else{
					
					$list .= '<li><span class="fr">'.king_get_month(king_get_year($kingpost->post_date)).'</span><span class="fr">'.getPostViews($kingpost->ID).'次</span><a href="'.$kingpost->guid.'">'.cutstr($kingpost->post_title,18).'</a></li>';
				}
			}
			$html .= '<div class="br fr"><ul>'.$list.'</ul></div>';
		endif;
		
		$html .= '</div></div>';
	}
	echo $html;
}

/*获取文章浏览次数*/
function getPostViews($postID){
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
		return "0";
	}
	return $count;
}

/*设置文章浏览次数*/
function setPostViews($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	}else{
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}

/*获取照片喜欢次数*/
function getPicLoveNums($postID){
	$count_key = 'pic_love_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
		return "0";
	}
	return $count;
}

/*增加照片喜欢次数*/
function setPicLoveNums($postID) {
	$count_key = 'pic_love_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	}else{
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}

/*增加喜欢次数ajax*/
function king_love_pic_do_ajax() {

    $post_id = stripslashes($_POST['post_id']);
	
	setPicLoveNums($post_id);
	
	echo getPicLoveNums($post_id);

    // IMPORTANT: don't forget to "exit"
    exit;
}
add_action( 'wp_ajax_nopriv_king_love_pic_do_ajax', 'king_love_pic_do_ajax' );
add_action( 'wp_ajax_king_love_pic_do_ajax', 'king_love_pic_do_ajax' );

//获取年份
function king_get_year($post_id){
	$strArr=explode(' ',$post_id);
	return $strArr[0];
}

//获取月日
function king_get_month($year){
	$strArr=substr($year, 5);
	return $strArr;
}


/**
 * 获取浏览量最高的文章
 * @param int $num 要查询的总条数
 * @param int $cutLen 查出标题要截出的字数
 * @return string
 */
function king_get_hot_posts($num=10,$cutLen=0){
	global $wpdb; 
	
	$sql = "SELECT DISTINCT guid,post_title,meta_value FROM $wpdb->postmeta,$wpdb->posts WHERE meta_key='post_views_count' AND $wpdb->postmeta.post_id=$wpdb->posts.id AND $wpdb->posts.post_type='post' AND $wpdb->posts.post_status='publish' ORDER BY ABS(meta_value) DESC LIMIT ".$num;
	
	$posts = $wpdb->get_results($sql); 
	$output = '<ul>'; 
	foreach ($posts as $post) { 
		if ($cutLen==0){
			$output .= '<li><span class="fr">'.$post->meta_value.'次</span><a title="'.$post->post_title.'" href="'.$post->guid.'">'.$post->post_title.'</a>';
		}else{
			$output .= '<li><span class="fr">'.$post->meta_value.'次</span><a title="'.$post->post_title.'" href="'.$post->guid.'">'.cutstr($post->post_title,$cutLen).'</a>';
		}
	} 
	$output .= '</ul>'; 
	return $output; 
}

//输出浏览量最高的文章
function king_the_hot_posts($num=10,$cutLen=0){
	$output=king_get_hot_posts($num,$cutLen);
	echo $output; 
}

//彩色标签

function colorCloud($text) {
	$text = preg_replace_callback('|<a (.+?)>|i', 'colorCloudCallback', $text);
	return $text;
}
function colorCloudCallback($matches) {
	$text = $matches[1];
	$color = dechex(rand(0,16777215));
	$pattern = '/style=(\'|\")(.*)(\'|\")/i';
	$text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text);
	return "<a $text>";
}

//add_filter('wp_tag_cloud', 'colorCloud', 1);


//相关文章
function king_relate_posts($postID,$num=6){

	global $wpdb;
	$post_tags = wp_get_post_tags($postID);
	$cats = wp_get_post_categories($postID);
	$output='';
	if ($post_tags) {
		$tag_list = '';
		foreach ($post_tags as $tag) {
			// 获取标签列表
			$tag_list .= $tag->term_id.',';
		}
		$tag_list = substr($tag_list, 0, strlen($tag_list)-1);
		
		$related_posts = $wpdb->get_results("
			SELECT DISTINCT ID, post_title
			FROM {$wpdb->prefix}posts, {$wpdb->prefix}term_relationships, {$wpdb->prefix}term_taxonomy
			WHERE {$wpdb->prefix}term_taxonomy.term_taxonomy_id = {$wpdb->prefix}term_relationships.term_taxonomy_id
			AND ID = object_id
			AND taxonomy = 'post_tag'
			AND post_status = 'publish'
			AND post_type = 'post'
			AND term_id IN (" . $tag_list . ")
			AND ID != '" . $postID . "'
			ORDER BY RAND()
			LIMIT {$num}"
		);
			
		if ( $related_posts ) {
			foreach ($related_posts as $related_post) {
				$img=king_get_thumb_img($related_post->ID,null,210,120);
				$output .= '<li><div class="img img-wrap">'.$img.'</div><a class="title" href="'.get_permalink($related_post->ID).'" title="'.$related_post->post_title.'">'.$related_post->post_title.'</a></li>';
			}
			echo "<ul id='relate-post-list'>".$output."</ul>";
		}
	}else if ($cats){
		$related = $wpdb->get_results("
			SELECT post_title, ID
			FROM {$wpdb->prefix}posts, {$wpdb->prefix}term_relationships, {$wpdb->prefix}term_taxonomy
			WHERE {$wpdb->prefix}posts.ID = {$wpdb->prefix}term_relationships.object_id
			AND {$wpdb->prefix}term_taxonomy.taxonomy = 'category'
			AND {$wpdb->prefix}term_taxonomy.term_taxonomy_id = {$wpdb->prefix}term_relationships.term_taxonomy_id
			AND {$wpdb->prefix}posts.post_status = 'publish'
			AND {$wpdb->prefix}posts.post_type = 'post'
			AND {$wpdb->prefix}term_taxonomy.term_id = '" . $cats[0] . "'
			AND {$wpdb->prefix}posts.ID != '" . $postID . "'
			ORDER BY RAND( )
			LIMIT ".$num
		);

		if ( $related ) {
			foreach ($related as $related_post) {
				$img=king_get_thumb_img($related_post->ID,null,210,120);
				$output .= '<li><div class="img img-wrap">'.$img.'</div><a class="title" href="'.get_permalink($related_post->ID).'" title="'.$related_post->post_title.'">'.$related_post->post_title.'</a></li>';
			}
			echo "<ul id='relate-post-list'>".$output."</ul>";
		}
	}else{
		echo "no";
	}
}

function king_get_thumb_img($postID,$href=null,$w,$h){
	$thumb_id = get_post_thumbnail_id($postID);
	$args = array(
			'posts_per_page'    => -1,
			'post_type'			=> 'attachment',
			'post_mime_type'	=> 'image',
			'post_parent'       => $postID,
			'post_status' 		=> 'inherit'
	);

	$images = new WP_Query( $args );

	if( has_post_thumbnail( $postID ) ) {
		$thumb_meta = wp_get_attachment_image_src($thumb_id, 'full');
	}elseif( $images->have_posts() ) {
		$thumb_meta = wp_get_attachment_image_src($images->posts[0]->ID, 'full');
	}else {
		$thumb_meta = array(
			0	=>	'/wp-content/themes/dt-king/images/noimage.jpg'
		);
	}
	
	if (!$href){
		$img = dt_get_thumb_img( array(
			'img_meta'      => $thumb_meta,
			'use_noimage'   => true,
			'use_lazy'	=> true,
			'img_class'	=>	'lazy-img',
			'thumb_opts'    => array( 'w' => $w, 'h' => $h )
		),
			'',	false
		);
	}else{
		$img = dt_get_thumb_img( array(
			'img_meta'      => $thumb_meta,
			'use_noimage'   => true,
			'href'          => $href,
			'thumb_opts'    => array( 'w' => $w, 'h' => $h )
		),
			'',	false
		);
	};

	
	return $img;
}

function king_get_thumb_img_withouta($postID,$w,$h,$lazy = false){
	$thumb_id = get_post_thumbnail_id($postID);
	$args = array(
			'posts_per_page'    => -1,
			'post_type'			=> 'attachment',
			'post_mime_type'	=> 'image',
			'post_parent'       => $postID,
			'post_status' 		=> 'inherit'
	);

	$images = new WP_Query( $args );

	if( has_post_thumbnail( $postID ) ) {
		$thumb_meta = wp_get_attachment_image_src($thumb_id, 'full');
	}elseif( $images->have_posts() ) {
		$thumb_meta = wp_get_attachment_image_src($images->posts[0]->ID, 'full');
	}else {
		$thumb_meta = array(
			0	=>	'/wp-content/themes/dt-king/images/noimage.jpg'
		);
	}
	
	
	$img = dt_get_thumb_img( array(
		'img_meta'      => $thumb_meta,
		'img_class'		=> 'lazy-img',
		'use_noimage'   => true,
		'use_lazy' => $lazy,
		'thumb_opts'    => array( 'w' => $w, 'h' => $h )
	),
		'<img %SRC%  %DATA-SRC% %IMG_CLASS% %SIZE%/>',	false
	);
	

	
	return $img;
}

//获取页面及缩略图
function king_the_pages($num=1,$pageID=null){
	
	if (isset($pageID)){
		
		$pageID=explode(",",$pageID);
		
		$output='<ul class="clearfix img-list img-list-'.$num.'">';
		
		
		if ($num==2){
			foreach ($pageID as $page){
				$output.='<li><a href="'.get_page_link($page).'"><p>'.get_post($page)->post_title.'</p</a></li>';
			}
		}else if($num==3){
			foreach ($pageID as $page){
				$output.='<li><a href="'.get_page_link($page).'">'.king_get_thumb_img_withouta($page,80,80,true).'<p>'.get_post($page)->post_title.'</p></a></li>';
			}
		}else{
			foreach ($pageID as $page){
				$output.='<li><a href="'.get_page_link($page).'"><p>'.get_post($page)->post_title.'</p></a></li>';
			}
		}
		
		
		$output.='</ul>';
		echo $output;
	}
}

//面包屑
function get_breadcrumbs()
{
    global $wp_query,$post;
 
    if ( !is_home() ){
 
        // Start the UL
        echo '<ul class="breadcrumbs">';
        // Add the Home link
        echo '<li><a href="'. get_settings('home') .'">'. get_bloginfo('name') .'</a></li>';
 
        if ( is_category() )
        {
            $catTitle = single_cat_title( "", false );
            $cat = get_cat_ID( $catTitle );
            echo "<li> &raquo; ". get_category_parents( $cat, TRUE, " &raquo; " ) ."</li>";
        }
        elseif ( is_archive() && !is_category() )
        {
            echo "<li> &raquo; Archives</li>";
        }
        elseif ( is_search() ) {
 
            echo "<li> &raquo; Search Results</li>";
        }
        elseif ( is_404() )
        {
            echo "<li> &raquo; 404 Not Found</li>";
        }
        elseif ( is_single() )
        {
			$postType=$post->post_type;
			if ($postType=="dt_catalog"){
				echo '<li> &raquo; <a href="'.get_page_link(407).'">推荐</a> &raquo ';
				echo the_title('','', FALSE) ."</li>";
			}else{
				$category = get_the_category();
				$category_id = get_cat_ID( $category[0]->cat_name );
				echo '<li> &raquo; '. get_category_parents( $category_id, TRUE, " &raquo; " );
				//echo the_title('','', FALSE) ."</li>";
			}
        }
        elseif ( is_page() )
        {
		
			$post = $wp_query->get_queried_object();
 
            if ( $post->post_parent == 0 ){
 
                echo "<li> &raquo; ".the_title('','', FALSE)."</li>";
 
            } else {
                $title = the_title('','', FALSE);
                $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
                array_push($ancestors, $post->ID);
 
                foreach ( $ancestors as $ancestor ){
                    if( $ancestor != end($ancestors) ){
                        echo '<li> &raquo; <a href="'. get_permalink($ancestor) .'">'. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</a></li>';
                    } else {
                        echo '<li> &raquo; '. strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) .'</li>';
                    }
                }
            }
        }
 
        // End the UL
        echo "</ul>";
    }
}

function king_get_the_category( $id = false ,$cate='category' ) {
	$categories = get_the_terms( $id, $cate );
	if ( ! $categories || is_wp_error( $categories ) )
		$categories = array();

	$categories = array_values( $categories );

	foreach ( array_keys( $categories ) as $key ) {
		_make_cat_compat( $categories[$key] );
	}

	return apply_filters( 'get_the_categories', $categories );
}

function king_get_cat_ID( $cat_name , $cate='category' ) {
	$cat = get_term_by( 'name', $cat_name, $cate );
	if ( $cat )
		return $cat->term_id;
	return 0;
}


//获取经过src处理的正文
function king_the_content($more_link_text = null, $stripteaser = false) {
	$content = get_the_content($more_link_text, $stripteaser);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	$reg = '/<img([^s]+)src="([^"]{4,})"/';
	$replace = '<img class="lazy-img" $1src="" data-src="$2"';
	$content = preg_replace($reg, $replace, $content);
	echo $content;
}

//---------



?>
