<?php
require_once 'page_menu_class.php';
require_once 'nav_menu_class.php';

function dt_menu( $data = array() ) {
    $defaults = array(
        'menu_wraper' 	=> '<ul id="%MENU_ID%">%MENU_ITEMS%</ul>',
        'menu_items'	=> '<li class="testingg %ITEM_CLASS%"><a href="%ITEM_HREF%" title="%ESC_ITEM_TITLE%">%ITEM_TITLE%</a>%SUBMENU%</li>',
        'submenu' 		=> '<div style="visibility: hidden; display: block;"><ul class="testingggg">%ITEM%</ul><i></i></div>'
    );
    
    $options = wp_parse_args( $data, $defaults );
    
    $options['menu_wraper'] = str_replace(
        array(
            '%MENU_ID%',
            '%MENU_CLASS%',
            '%MENU_ITEMS%'
        ),
        array(
            '%1$s',
            '%2$s',
            '%3$s'
        ),
        $options['menu_wraper']
    );
    
    $options['menu_items'] = explode( '%SUBMENU%', $options['menu_items'] );
    $options['submenu'] = explode( '%ITEM%', $options['submenu'] );
    
    $theme_location = 'primary-menu';
    $parent_clicable = of_get_option( 'misc-parent_menu_clickable' );
    $args = array(
        'container'			    => false,
        'menu_id' 			    => 'mainmenu',
        'fallback_cb' 		    => 'dt_page_menu',
        'theme_location' 	    => $theme_location,
        'parent_clicable' 	    => $parent_clicable,
        'menu_class' 		    => false,
        'container_class'	    => false,
        'dt_item_wrap_start'    => $options['menu_items'][0],
        'dt_item_wrap_end'      => $options['menu_items'][1],
        'dt_submenu_wrap_start' => $options['submenu'][0],
        'dt_submenu_wrap_end'   => $options['submenu'][1],
        'items_wrap'            => $options['menu_wraper']
    );
    if( has_nav_menu( $theme_location ) ){
        $walker_args = array(
            'theme_location' 	=> $theme_location,
            'parent_clicable' 	=> $parent_clicable
        );
        $args['walker'] = new Dt_Walker_Nav_Menu( $walker_args );
    }
    wp_nav_menu( $args );
}

// function to fallof from wp_nav_menu
function dt_page_menu( $args = array() ) {
        $defaults = array(
            'sort_column'       => 'menu_order, post_title',
            'container_class'   => 'nav-bg',
            'menu_id'           => 'nav',
            'echo'              => false,
            'link_before'       => '',
            'link_after'        => ''
        );
        $args = wp_parse_args( $args, $defaults );
        $args = apply_filters( 'wp_page_menu_args', $args );
        $menu = '';
        $list_args = $args;
                    
        $list_args['echo'] = false;
        $list_args['title_li'] = '';
        $list_args['walker'] = new Dt_Custom_Walker_Page();
        $menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages($list_args) );

        if ( isset( $menu ) )
            $menu = sprintf(
                $args['items_wrap'],
                $args['menu_id'],
                $args['menu_class'],
                $menu
            );
//            $menu = '<ul' . ( isset($args['menu_id'])?' id="'.esc_attr($args['menu_id']).'"':'' ) . '>' . $menu . '</ul>';

        if ( isset( $container ) )
            $menu = '<div class="' . esc_attr($args['container_class']) . '">' . $menu . "</div>\n";

        $menu = apply_filters( 'wp_page_menu', $menu, $args );
        if ( $args['echo'] ) {
            echo $menu;
        }else {
            return $menu;
        }
}

