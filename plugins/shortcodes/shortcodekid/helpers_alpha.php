<?php
function dt_shortcbuilder_photos_ppp_filter( $data ) {
    $data['before'] = '<fieldset style="padding-left: 15px;"><legend>Number of items to display:</legend><label>';
    $data['after'] = '%2$s</label></fieldset>';
    $data['description'] = '';
    return $data;
}

function dt_shortcbuilder_photos_orderby_filter( $data ) {
    $data['before'] = '<legend>Ordering settings:</legend>' . $data['before'];
    return $data;
}

function dt_shortcbuilder_photos_order_filter( $data ) {
    $data['before'] = '<legend>Sort by:</legend>' . $data['before'];
    return $data;
}

// print code for selecting items in wp-admin   
function dt_admin_select_list( $opts = array() ) {
    if( empty($opts) ) {
        return false;
    }
    
    $only = $except = $list = array();
    $defaults = array(
        'before_title'      => '<p>',
        'after_title'       => '</p>',
        'labels'            => array(
            'main'      => 'Select the category(s) to display:',
            'all'       => ' All',
            'only'      => ' Only:',
            'except'    => ' All, except:'
        ),
        'rad_butt_name'     => 'show_type_potrf',
        'checkbox_name'     => 'show_portf',
        'terms'             => array(),
        'current_sel'       => array(),
        'con_class'         => '',
        'before_element'    => '',
        'after_element'     => ''
    );
    $opts = wp_parse_args( $opts, $defaults );
    
    if( empty($opts['terms']) ) {
        return;
    }
    
    if( !empty($opts['current_sel']) && is_array($opts['current_sel']) ) {
        $key = key($opts['current_sel']);
        if( is_array($opts['current_sel'][$key]) ) {
            $$key = $opts['current_sel'][$key];
        }else {
            $$key = array( $opts['current_sel'][$key] );
        }
    }
    
    ?>
    <script>
        var dt_admin = {box: "#<?php echo $opts['con_class']; ?>"};
    </script>
    <?php /*
    <script src="<?php echo get_template_directory_uri(); ?>/js/admin_list.js"></script>
     */?>
    
    <?php echo $opts['before_element']; ?>
    
    <?php echo $opts['before_title']. $opts['labels']['main']. $opts['after_title']; ?>
    
    <div class="showhide">
        <label><input name="<?php echo esc_attr($opts['rad_butt_name']); ?>" value="all" <?php checked( empty($list) ); ?> type="radio"> <span><?php echo $opts['labels']['all']; ?></span></label>
    </div>
    <div class="showhide">
        <label><input name="<?php echo esc_attr($opts['rad_butt_name']); ?>" value="only" <?php checked( !empty($only) ); ?> type="radio"> <span><?php echo $opts['labels']['only']; ?></span></label>
        <div style="margin-left: 20px; margin-bottom: 8px; display: none;" class="list">
            <?php
            if( $opts['terms'] ):
                foreach( $opts['terms'] as $term ): ?>
                    <label style="display: block;">
                        <input name="<?php echo esc_attr($opts['checkbox_name']); ?>[only][]" value="<?php echo esc_attr($term->term_id); ?>" type="checkbox" <?php checked( in_array($term->term_id, $only) ); ?>> <span><?php echo $term->name; ?></span></label>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
    <div class="showhide">
        <label><input name="<?php echo esc_attr($opts['rad_butt_name']); ?>" value="except" <?php checked( !empty($except) ); ?> type="radio"> <span><?php echo $opts['labels']['except']; ?></span></label>
        <div style="margin-left: 20px; margin-bottom: 8px; display: none;" class="list">
            <?php
            if( $opts['terms'] ):
                foreach( $opts['terms'] as $term ): ?>
                    <label style="display: block;"><input name="<?php echo esc_attr($opts['checkbox_name']); ?>[except][]" value="<?php echo esc_attr($term->term_id); ?>" type="checkbox" <?php checked( in_array($term->term_id, $except) ); ?>> <span><?php echo $term->name; ?></span></label>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
    
    <?php echo $opts['after_element']; ?>
    
<?php
}

// print order selection code for wp-admin
function dt_admin_order_options( $opts = array(), $echo = true ) {
    if( empty($opts) ) {
        return false;
    }
    
    if( !isset($opts['defaults']) ) {
        $opts['defaults'] = array();
    }
    
    $options = wp_parse_args( $opts['options'], $opts['defaults'] );
    $box_name = $opts['box_name'];
    
    $before_fieldset = '';
    $after_fieldset = '';
    
    $before_element = '<p>';
    $after_element = '</p>';
    
    if( isset($opts['before_fieldset']) ) {
        $before_fieldset = $opts['before_fieldset'];
    }
    
    if( isset($opts['after_fieldset']) ) {
        $after_fieldset = $opts['after_fieldset'];
    }
    
    if( isset($opts['before_element']) ) {
        $before_element = $opts['before_element'];
    }
    
    if( isset($opts['after_element']) ) {
        $after_element = $opts['after_element'];
    }
    
    $output = '';
    
    $output .= $before_element . dt_admin_page_option_orderby( $box_name, $options['orderby'] ) . $after_element;
        
    $output .= $before_element . dt_admin_page_option_order( $box_name, $options['order'] ) . $after_element;
    
    $output = $before_fieldset . $output . $after_fieldset;
    
    if( !$echo ) {
        return $output;
    }
    
    echo $output;
    return true;
}

// print slug "editor" option
function dt_admin_slug_options( $opts = array() ) {
    if( empty($opts) ) {
        return false;
    }    
    
    if( !isset($opts['defaults']) ) {
        $opts['defaults'] = array();
    }
    
    $options = wp_parse_args( $opts['options'], $opts['defaults'] );
    $box_name = $opts['box_name'];
    
    ?>
    
    <p>
        <label>
            <input type="text" name="<?php echo $box_name; ?>_slug" value="<?php echo esc_attr($options['slug']); ?>" style="width: 150px"/>
            <span><?php _e( 'Edit category slug', LANGUAGE_ZONE ); ?></span>
        </label>
    </p>
    
    <?php
}

// print posts_per_page option
function dt_admin_ppp_options( $opts = array(), $echo = true ) {
    if( empty($opts) ) {
        return false;
    }
    
    if( !isset($opts['defaults']) ) {
        $opts['defaults'] = array();
    }
    
    $options = wp_parse_args( $opts['options'], $opts['defaults'] );
    $box_name = $opts['box_name'];
    
    $output = dt_admin_page_option_ppp($box_name, $options['ppp']);
    
    if( !$echo ) {
        return $output;
    }
    
    echo $output;
    return true;
}

// order
function dt_admin_page_option_order( $box_name, $current = false ) {
    if( empty($box_name) ) {
        return false;
    }
    
    $p_order = array(
        'ASC'   => ' Ascending',
        'DESC'  => ' Descending'
    );
    
    $defaults = array(
        'before'            => '',
        'after'             => '',
        'element_layout'    => '<label><input type="radio" id="%1$s_order" name="%1$s_order" value="%2$s" %3$s/> <span>%4$s</span></label> &nbsp;&nbsp;',
        'element_type'      => 'radio',
        'description'       => 'Order selection'
    );
    $options = apply_filters( 'dt_admin_page_option_order-options', $defaults );
    
    switch( $options['element_type'] ) {
        case 'select':
            $e_function = 'selected';
            break;
        default:
            $e_function = 'checked';
    }
    
    $options['before'] = sprintf(
        $options['before'],
        esc_attr($box_name),
        $options['description']
    );
    
    $options['after'] = sprintf(
        $options['after'],
        esc_attr($box_name),
        $options['description']
    );
    
    $elements = '';
    foreach( $p_order as $order=>$title ) {       
        $elements .= sprintf(
            $options['element_layout'],
            esc_attr($box_name),
            esc_attr($order),
            $e_function( $current, $order, false ),
            $title
        );
    }
    return $options['before'] . $elements . $options['after'];
}

// orderby
function dt_admin_page_option_orderby( $box_name, $current = false ) {
    if( empty($box_name) ) {
        return false;
    }
    
    $p_orderby = array(
        'ID'        => __( 'Order by ID', LANGUAGE_ZONE ),
        'author'    => __( 'Order by author', LANGUAGE_ZONE ),
        'title'     => __( 'Order by title', LANGUAGE_ZONE ),
        'date'      => __( 'Order by date', LANGUAGE_ZONE ),
        'modified'  => __( 'Order by modified', LANGUAGE_ZONE ),
        'rand'      => __( 'Order by rand', LANGUAGE_ZONE ),
        'menu_order'=> __( 'Order by menu', LANGUAGE_ZONE )
    );
    
    $defaults = array(
        'before'            => '<select id="%1$s_orderby" name="%1$s_orderby">',
        'after'             => '</select>%2$s',
        'element_layout'    => '<option value="%2$s" %3$s>%4$s</option>',
        'element_type'      => 'select',
        'description'       => ''
    );
    $options = apply_filters( 'dt_admin_page_option_orderby-options', $defaults );
    
    switch( $options['element_type'] ) {
        case 'select':
            $e_function = 'selected';
            break;
        default:
            $e_function = 'checked';
    }
    
    $options['before'] = sprintf(
        $options['before'],
        esc_attr($box_name),
        $options['description']
    );
    
    $options['after'] = sprintf(
        $options['after'],
        esc_attr($box_name),
        $options['description']
    );
    
    $elements = '';
    foreach( $p_orderby as $order=>$title ) {
        $elements .= sprintf(
            $options['element_layout'],
            esc_attr($box_name),
            esc_attr($order),
            $e_function( $current, $order, false ),
            $title
        );
    }
    return $options['before'] . $elements . $options['after'];
}

// ppp
function dt_admin_page_option_ppp( $box_name, $current = false ) {
    if( empty($box_name) ) {
        return false;
    }
    
    $data = array( $current );
    
    $defaults = array(
        'before'            => '<label>',
        'after'             => ' <span>%2$s</span></label>',
        'element_layout'    => '<input type="text" id="%1$s_ppp" name="%1$s_ppp" size="4" value="%4$s"/>',
        'element_type'      => 'text',
        'description'       => 'Number of posts on this page ( if empty - uses standard setting )'
    );
    $options = apply_filters( 'dt_admin_page_option_ppp-options', $defaults );
    
    switch( $options['element_type'] ) {
        case 'select':
            $e_function = 'selected';
            break;
        default:
            $e_function = 'checked';
    }
    
    $options['before'] = sprintf(
        $options['before'],
        esc_attr($box_name),
        $options['description']
    );
    
    $options['after'] = sprintf(
        $options['after'],
        esc_attr($box_name),
        $options['description']
    );
    
    $elements = '';
    foreach( $data as $value=>$title ) {
        $elements .= sprintf(
            $options['element_layout'],
            esc_attr($box_name),
            esc_attr($value),
            $e_function( $current, $value, false ),
            $title
        );
    }
    return $options['before'] . $elements . $options['after'];
}
