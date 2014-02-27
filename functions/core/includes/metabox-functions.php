<?php
class DT_Item {
    public static $count = 0;
    
    function __construct() {
        DT_Item::$count++;
    }
    
    function __destruct() {
        DT_Item::$count--;
    }
    
    public $name = '';
    public $id = '';
    public $style = '';
    public $class = '';
    public $data = '';
}

/* checkbox */
class DT_Mcheckbox extends DT_Item {   
    
    public $wrap = '<label>%1$s%2$s</label>';
    public $desc_wrap = '%2$s';
    public $value = '';
    public $checked = false;
    public $desc = '';
    
    function __construct( $options = array() ) {
        parent::__construct();
        $this->init( $options );
    }
    
    function __toString() {
        return $this->create();
    }
    
    public function generate_id( $id ) {
        $this->id = parent::$count . '_' . $id;
		$this->desc_wrap = '<label for="%1$s">%2$s</label>';
		$this->wrap = '%1$s%2$s';
    }
    
    public function init( $options ) {
        $def = array(
            'wrap'          => $this->wrap,
            'class'         => $this->class,
            'id'            => $this->id,
            'style'         => $this->style,
            'name'          => $this->name,
            'value'         => $this->value,
            'checked'       => $this->checked,
            'description'   => $this->desc,
            'desc_wrap'     => $this->desc_wrap
        );
        $options = wp_parse_args( $options, $def );
        
        $this->wrap = $options['wrap'];
        $this->class = esc_attr($options['class']);
        $this->id = esc_attr($options['id']);
        $this->style = esc_attr($options['style']);
        $this->name = esc_attr($options['name']);
        $this->value = esc_attr($options['value']);
        $this->checked = $options['checked'];
        $this->desc = $options['description'];
        $this->desc_wrap = $options['desc_wrap'];
    }
    
    public function create() {
        $html = $desc = '';
        $html .= '<input type="checkbox"';
        $html .= sprintf( ' name="%s"', $this->name );
        
        if( $this->id ) {
            $html .= sprintf( ' id="%s"', $this->id );
        }
        
        if( $this->class ) {
            $html .= sprintf( ' class="%s"', $this->class );
        }
        
        if( $this->value ) {
            $html .= sprintf( ' value="%s"', $this->value );
        }
        
        $html .= checked( $this->checked, true, false );
        
        if( $this->style ) {
            $html .= sprintf( ' style="%s"', $this->style );
        }
        
        $html .= '/>';
        
        if( $this->desc ) {
            $desc = sprintf( $this->desc_wrap, $this->id, $this->desc, $html );
        }
        
        // wrap this thing
        $html = sprintf( $this->wrap, $html, $desc );
        
        return $html;
    }

}

/* radiobox */
class DT_Mradio extends DT_Item {    
    
	public $wrap = '<label>%1$s%2$s</label>';
    public $desc_wrap = '%2$s';
	public $value = '';
    public $checked = false;
    public $desc = '';
    
    function __construct( $options = array() ) {
        parent::__construct();
        $this->init( $options );
    }
    
    function __toString() {
        return $this->create();
    }
    
    public function generate_id( $id ) {
        $this->id = parent::$count . '_' . $id;
		$this->desc_wrap = '<label for="%1$s">%2$s</label>';
		$this->wrap = '%1$s%2$s';
    }
    
    public function init( $options ) {
        $def = array(
            'wrap'          => $this->wrap,
            'class'         => $this->class,
            'id'            => $this->id,
            'style'         => $this->style,
            'name'          => $this->name,
            'value'         => $this->value,
            'checked'       => $this->checked,
            'description'   => $this->desc,
            'desc_wrap'     => $this->desc_wrap,
			'data'			=> $this->data
        );
        $options = wp_parse_args( $options, $def );
        
        $this->wrap = $options['wrap'];
        $this->class = esc_attr($options['class']);
        $this->id = esc_attr($options['id']);
        $this->style = esc_attr($options['style']);
        $this->name = esc_attr($options['name']);
        $this->value = esc_attr($options['value']);
        $this->checked = $options['checked'];
        $this->desc = $options['description'];
        $this->desc_wrap = $options['desc_wrap'];
        $this->data = $options['data'];
    }
    
    public function create() {
        $html = $desc = '';
        $html .= '<input type="radio"';
        $html .= sprintf( ' name="%s"', $this->name );
        
        if( $this->id ) {
            $html .= sprintf( ' id="%s"', $this->id );
        }
        
        if( $this->class ) {
            $html .= sprintf( ' class="%s"', $this->class );
        }
        
        if( $this->value ) {
            $html .= sprintf( ' value="%s"', $this->value );
        }
        
        $html .= checked( $this->checked, true, false );
        
        if( $this->style ) {
            $html .= sprintf( ' style="%s"', $this->style );
        }
		
		if( $this->data ) {
            $html .= sprintf( ' %s', $this->data );
        }
        
        $html .= '/>';
        
        if( $this->desc ) {
            $desc = sprintf( $this->desc_wrap, $this->id, $this->desc );
        }
        
        // wrap this thing
        $html = sprintf( $this->wrap, $html, $desc );
        
        return $html;
    }

}

/* select */
class DT_Mselect extends DT_Item {    
    
	public $wrap = '<label>%1$s%2$s</label>';
    public $desc_wrap = '%2$s';
	public $options = array();
    public $selected = '';
    public $desc = '';
    
    function __construct( $options = array() ) {
        parent::__construct();
        $this->init( $options );
    }
    
    function __toString() {
        return $this->create();
    }
    
    public function generate_id( $id ) {
        $this->id = parent::$count . '_' . $id;
		$this->desc_wrap = '<label for="%1$s">%2$s</label>';
		$this->wrap = '%1$s%2$s';
    }
    
    public function init( $options ) {
        $def = array(
            'wrap'          => $this->wrap,
            'class'         => $this->class,
            'id'            => $this->id,
            'style'         => $this->style,
            'name'          => $this->name,
            'options'       => $this->options,
            'selected'      => $this->selected,
            'description'   => $this->desc,
            'desc_wrap'     => $this->desc_wrap
        );
        $options = wp_parse_args( $options, $def );
        
        $this->wrap = $options['wrap'];
        $this->class = esc_attr($options['class']);
        $this->id = esc_attr($options['id']);
        $this->style = esc_attr($options['style']);
        $this->name = esc_attr($options['name']);
        $this->options = $options['options'];
        $this->selected = $options['selected'];
        $this->desc = $options['description'];
        $this->desc_wrap = $options['desc_wrap'];
    }
    
    public function create() {
        $html = $desc = '';
        $html .= '<select';
        $html .= sprintf( ' name="%s"', $this->name );
        
        if( $this->id ) {
            $html .= sprintf( ' id="%s"', $this->id );
        }
        
        if( $this->class ) {
            $html .= sprintf( ' class="%s"', $this->class );
        }
        
        if( $this->style ) {
            $html .= sprintf( ' style="%s"', $this->style );
        }
        
        $html .= '>';
        
        if( !empty($this->options) ) {
            foreach( $this->options as $val=>$title ) {
                $html .= sprintf( '<option value="%s"%s>%s</option>',
                    esc_attr($val),
                    selected( $this->selected, $val, false ),
                    $title
                );
            }
        }
        
        $html .= '</select>';
        
        if( $this->desc ) {
            $desc = sprintf( $this->desc_wrap, $this->id, $this->desc );
        }
        
        // wrap this thing
        $html = sprintf( $this->wrap, $html, $desc );
        
        return $html;
    }

}

/* button */
class DT_Mbutton extends DT_Item {
    
	public $wrap = '%1$s';
    public $value = '';
    public $title = '';
    
    function __construct( $options = array() ) {
        parent::__construct();
        $this->init( $options );
    }
    
    function __toString() {
        return $this->create();
    }
    
    public function generate_id( $id ) {
        $this->id = parent::$count . '_' . $id;
    }
    
    public function init( $options ) {
        $def = array(
            'wrap'          => $this->wrap,
            'class'         => $this->class,
            'id'            => $this->id,
            'style'         => $this->style,
            'name'          => $this->name,
            'value'         => $this->value,
            'title'         => $this->title
        );
        $options = wp_parse_args( $options, $def );
        
        $this->wrap = $options['wrap'];
        $this->class = esc_attr($options['class']);
        $this->id = esc_attr($options['id']);
        $this->style = esc_attr($options['style']);
        $this->name = esc_attr($options['name']);
        $this->value = esc_attr($options['value']);
        $this->title = $options['title'];
    }
    
    public function create() {
        $html = $desc = '';
        $html .= '<button type="button"';
        $html .= sprintf( ' name="%s"', $this->name );
        
        if( $this->id ) {
            $html .= sprintf( ' id="%s"', $this->id );
        }
        
        if( $this->class ) {
            $html .= sprintf( ' class="%s"', $this->class );
        }
        
        if( $this->value ) {
            $html .= sprintf( ' value="%s"', $this->value );
        }
                
        if( $this->style ) {
            $html .= sprintf( ' style="%s"', $this->style );
        }
        
        $html .= '>';
        
        if( $this->title ) {
            $html .= $this->title;
        }
        
        $html .= '</button>';
        // wrap this thing
        $html = sprintf( $this->wrap, $html );
        
        return $html;
    }

}

/* text */
class DT_Mtext extends DT_Item {
    
	public $wrap = '<label>%1$s%2$s</label>';
    public $desc_wrap = '%2$s';
    public $value = '';
    public $desc = '';
    
    function __construct( $options = array() ) {
        parent::__construct();
        $this->init( $options );
    }
    
    function __toString() {
        return $this->create();
    }
    
    public function generate_id( $id ) {
        $this->id = parent::$count . '_' . $id;
		$this->desc_wrap = '<label for="%1$s">%2$s</label>';
		$this->wrap = '%1$s%2$s';
    }
    
    public function init( $options ) {
        $def = array(
            'wrap'          => $this->wrap,
            'class'         => $this->class,
            'id'            => $this->id,
            'style'         => $this->style,
            'name'          => $this->name,
            'value'         => $this->value,
            'description'   => $this->desc,
            'desc_wrap'     => $this->desc_wrap
        );
        $options = wp_parse_args( $options, $def );
        
        $this->wrap = $options['wrap'];
        $this->class = esc_attr($options['class']);
        $this->id = esc_attr($options['id']);
        $this->style = esc_attr($options['style']);
        $this->name = esc_attr($options['name']);
        $this->value = esc_attr($options['value']);
        $this->desc = esc_attr($options['description']);
        $this->desc_wrap = $options['desc_wrap'];
    }
    
    public function create() {
        $html = $desc = '';
        $html .= '<input type="text"';
        $html .= sprintf( ' name="%s"', $this->name );
        
        if( $this->id ) {
            $html .= sprintf( ' id="%s"', $this->id );
        }
        
        if( $this->class ) {
            $html .= sprintf( ' class="%s"', $this->class );
        }
        
        $html .= sprintf( ' value="%s"', $this->value );
                
        if( $this->style ) {
            $html .= sprintf( ' style="%s"', $this->style );
        }
        
        $html .= '/>';
        
        if( $this->desc ) {
            $desc = sprintf( $this->desc_wrap, $this->id, $this->desc );
        }
        
        // wrap this thing
        $html = sprintf( $this->wrap, $html, $desc );
        
        return $html;
    }

}

/* textarea */
class DT_Mtextarea extends DT_Item {
    
	public $wrap = '<label>%1$s%2$s</label>';
    public $desc_wrap = '%2$s';
    public $value = '';
    public $desc = '';
    
    function __construct( $options = array() ) {
        parent::__construct();
        $this->init( $options );
    }
    
    function __toString() {
        return $this->create();
    }
    
    public function generate_id( $id ) {
        $this->id = parent::$count . '_' . $id;
		$this->desc_wrap = '<label for="%1$s">%2$s</label>';
		$this->wrap = '%1$s%2$s';
    }
    
    public function init( $options ) {
        $def = array(
            'wrap'          => $this->wrap,
            'class'         => $this->class,
            'id'            => $this->id,
            'style'         => $this->style,
            'name'          => $this->name,
            'value'         => $this->value,
            'description'   => $this->desc,
            'desc_wrap'     => $this->desc_wrap
        );
        $options = wp_parse_args( $options, $def );
        
        $this->wrap = $options['wrap'];
        $this->class = esc_attr($options['class']);
        $this->id = esc_attr($options['id']);
        $this->style = esc_attr($options['style']);
        $this->name = esc_attr($options['name']);
        $this->value = esc_attr($options['value']);
        $this->desc = esc_attr($options['description']);
        $this->desc_wrap = $options['desc_wrap'];
    }
    
    public function create() {
        $html = $desc = '';
        $html .= '<textarea';
        $html .= sprintf( ' name="%s"', $this->name );
        
        if( $this->id ) {
            $html .= sprintf( ' id="%s"', $this->id );
        }
        
        if( $this->class ) {
            $html .= sprintf( ' class="%s"', $this->class );
        }
                
        if( $this->style ) {
            $html .= sprintf( ' style="%s"', $this->style );
        }
        
        $html .= '>';
        
        if( $this->value ) {
            $html .= esc_html($this->value);
        }
        
        $html .= '</textarea>';
        
        if( $this->desc ) {
            $desc = sprintf( $this->desc_wrap, $this->id, $this->desc );
        }
        
        // wrap this thing
        $html = sprintf( $this->wrap, $html, $desc );
        
        return $html;
    }

}

/* link */
class DT_Mlink extends DT_Item {
    public $wrap = '%1$s';
    public $desc_wrap = '%2$s';
    public $href = '#';
    public $desc = '';
    
    function __construct( $options = array() ) {
        parent::__construct();
        $this->init( $options );
    }
    
    function __toString() {
        return $this->create();
    }
    
    public function generate_id( $id ) {
        $this->id = parent::$count . '_' . $id;
    }
    
    public function init( $options ) {
        $def = array(
            'wrap'          => $this->wrap,
            'class'         => $this->class,
            'id'            => $this->id,
            'style'         => $this->style,
            'href'          => $this->href,
            'description'   => $this->desc,
            'desc_wrap'     => $this->desc_wrap
        );
        $options = wp_parse_args( $options, $def );
        
        $this->wrap = $options['wrap'];
        $this->class = esc_attr($options['class']);
        $this->id = esc_attr($options['id']);
        $this->style = esc_attr($options['style']);
        $this->href = esc_url($options['href']);
        $this->desc = esc_attr($options['description']);
        $this->desc_wrap = $options['desc_wrap'];
    }
    
    public function create() {
        $html = $desc = '';
        $html .= '<a';
        
        $html .= sprintf( ' href="%s"', $this->href );
        
        if( $this->id ) {
            $html .= sprintf( ' id="%s"', $this->id );
        }
        
        if( $this->class ) {
            $html .= sprintf( ' class="%s"', $this->class );
        }
                
        if( $this->style ) {
            $html .= sprintf( ' style="%s"', $this->style );
        }
        
        $html .= '>';
        
        if( $this->desc ) {
            $html .= sprintf( $this->desc_wrap, $this->id, $this->desc );
        }
        
        $html .= '</a>';
        
        // wrap this thing
        $html = sprintf( $this->wrap, $html );
        
        return $html;
    }

}
/* create element function */
    
function dt_melement( $type, $options ) {
    switch( $type ) {
        case 'checkbox': return new DT_Mcheckbox( $options );
        case 'radio': return new DT_Mradio( $options );
        case 'select': return new DT_Mselect( $options );
        case 'button': return new DT_Mbutton( $options );
        case 'text': return new DT_Mtext( $options );
        case 'textarea': return new DT_Mtextarea( $options );
        case 'link': return new DT_Mlink( $options );
    }
}

/* core metabox options */
function dt_core_mb_draw_order_options( $opts ) {
    $defaults = array(
        'box_name'          => '',
        'order_current'     => 'DESC',
        'orderby_current'   => 'date',
        'add_menu_order'    => false
    );
    $opts = wp_parse_args( $opts, $defaults );

    $p_orderby = array(
        'ID'        => _x( 'Order by ID', 'backend orderby', LANGUAGE_ZONE ),
        'author'    => _x( 'Order by author', 'backend orderby', LANGUAGE_ZONE ),
        'title'     => _x( 'Order by title', 'backend orderby', LANGUAGE_ZONE ),
        'date'      => _x( 'Order by date', 'backend orderby', LANGUAGE_ZONE ),
        'modified'  => _x( 'Order by modified', 'backend orderby', LANGUAGE_ZONE ),
        'rand'      => _x( 'Order by rand', 'backend orderby', LANGUAGE_ZONE )
    );

    if( $opts['add_menu_order'] )
        $p_orderby['menu_order'] = _x( 'Order by menu', 'backend orderby', LANGUAGE_ZONE );
    
    /* order checkboxes */
    // ASC
    $asc = dt_melement( 'radio', array(
        'name'          => $opts['box_name'] . '_order',
        'checked'       => 'ASC' == $opts['order_current']?true:false,
        'description'   => _x('Ascending', 'backend order', LANGUAGE_ZONE),
        'value'         => 'ASC',
		'wrap'			=> '<label>%1$s %2$s</label>'
    ) );
    
    // DESC
    $desc = dt_melement( 'radio', array(
        'name'          => $opts['box_name'] . '_order',
        'checked'       => 'DESC' == $opts['order_current']?true:false,
        'description'   => _x('Descending', 'backend order', LANGUAGE_ZONE),
        'value'         => 'DESC',
		'wrap'			=> '<label>%1$s %2$s</label>'
    ) );
    
    /* orderby chapter */
    $orderby = dt_melement( 'select', array(
        'name'          => $opts['box_name'] . '_orderby',
        'selected'      => $opts['orderby_current'],
        'description'   => '',
        'options'       => $p_orderby,
        'wrap'          => '%2$s%1$s'
    ) );
    
    echo '<p>';
    echo $orderby;
    echo '</p>';

    echo '<p class="dt_switcher-box">';
    echo $asc . $desc;
    echo '</p>';
}

function dt_core_mb_draw_sidebars_list( $opts ) {
    
    $i = 0;
    $prefix = 'sidebar_';
    $sidebars = array();
    $sidebars_arr = of_get_option('of_generatortest2', false);
    foreach( $sidebars_arr as $index=>$sidebar ) {
        $sidebars[$prefix . $index] = $sidebar['sidebar_name'];
    }
    
    /* sidebars list */
    $sidebar = dt_melement( 'select', array(
        'name'          => $opts['box_name'] . '_sidebar',
        'selected'      => $opts['sidebar_current'],
        'description'   => '',
        'options'       => $sidebars,
        'wrap'          => '%2$s%1$s'
    ) );
    
    if( isset($opts['before']) ) {
        echo $opts['before'];
    }
    
    echo $sidebar;
    
    if( isset($opts['after']) ) {
        echo $opts['after'];
    }
    
}

function dt_core_mb_draw_radio_switcher( $name, $current, $opts = array() ) {
	foreach( $opts as $val=>$data ) {
        
        if( !isset($data['wrap']) ) {
            $data['wrap'] = '<label>%1$s %2$s</label>';
        }

		echo dt_melement( 'radio', array(
			'name'			=> $name,
			'description'	=> $data['desc'],
			'checked'		=> $val == $current?true:false,
			'value'			=> $val,
            'wrap'			=> $data['wrap'],
            'class'         => isset($data['class'])?$data['class']:'',
            'style'         => isset($data['style'])?$data['style']:''
		) );
	}
}

function dt_core_mb_draw_category_list( $name, $current, $terms, $opts = array() ) {

    if( empty($terms) ) {
        return false;
    }
    
    $str = '';
    $defaults = array(
        'wrap'          => '%s',
        'element_wrap'  => '<div class="dt_list-item"><label class="dt_checkbox">%1$s</label><span>%2$s</span></div>',
        'desc_wrap'     => '%s (%d)'
    );
    $opts = wp_parse_args( $opts, $defaults );

    foreach( $terms as $term ) {
	   $str .= dt_melement( 'checkbox', array(
	        'name'    		=> sprintf( $name, $term->term_id ),
	        'description'	=> sprintf( $opts['desc_wrap'], $term->name, $term->count ),
	        'value'		    => $term->term_id,
            'checked'		=> isset( $current[$term->term_id] ),
            'wrap'          => $opts['element_wrap']
	    ) );
    }

    printf( $opts['wrap'], $str );
 
}

function dt_core_mb_draw_functional_links( $opts = array(), $wrap = '%s', $class = 'button' ) {
    
    if( empty($opts) ) {
        return false;
    }
    
    $str = '';
    foreach( $opts as $data ) {
        $str .= dt_melement( 'link', array(
            'href'          => $data['href'],
            'class'         => $class,
            'description'   => $data['desc']
        ) );
        $str .= ' ';
    }

    printf( $wrap, $str );
}

function dt_core_mb_draw_posts_list( $name, $current, array $posts, $opts = array() ) {
    if( empty($posts) ) {
        return false;
    }
    
    global $wpdb;

    $defaults = array(
        'wrap'          => '%s',
        'element_wrap'  => '<div class="dt_list-item"><div class="dt_item-holder">%s</div></div>',
        'taxonomy'      => ''
    );
    $opts = wp_parse_args( $opts, $defaults );
        
    $data = dt_core_get_posts_thumbnails( $posts );

    if( $data ) {
        $thumbs_meta = $data['thumbs_meta'];
	    $uploadsdir = wp_upload_dir();
    }
    
    $output = ''; 
    foreach( $posts as $item ) {
        $str = '';
        $str .= dt_melement( 'checkbox', array(
	        'name'    		=> sprintf( $name, $item->ID),
	        'value'		    => $item->ID,
            'checked'		=> isset($current[$item->ID]),
            'wrap'          => '<label class="dt_checkbox">%1$s</label>'
	    ) );
        
        $file_name = get_template_directory_uri().'/images/noimage_thumbnail.jpg'; 
        if( isset($thumbs_meta[$item->ID]) ) {
            $file_name = $thumbs_meta[$item->ID]['data']['file'];
            if( isset($thumbs_meta[$item->ID]['data']['sizes']) ) {
		        $orig_file_name = end( explode('/', $file_name) );
		        $file_name = str_replace( $orig_file_name, $thumbs_meta[$item->ID]['data']['sizes']['thumbnail']['file'], $file_name);
            }
            $file_name = $uploadsdir['baseurl'] . '/' . $file_name;
        }else {
            $args = array(
                'numberposts'       => 1,
                'order'             => 'ASC',
                'post_mime_type'    => 'image',
                'post_parent'       => $item->ID,
                'post_status'       => null,
                'post_type'         => 'attachment' //may use orderby
            );

            $attachments = get_children( $args );
            if( $attachments ) {
                $att = current($attachments);
                    
                if( !($img = wp_get_attachment_image_src($att->ID, 'thumbnail')) ) {
                    $img = wp_get_attachment_image_src($att->ID, 'full');
                }
                $file_name = $img[0];
            }
        }
        
        $cover_style = 'dt_album-cover';
        $w = $h = 88; 
        if( 'dt_slider' == $item->post_type ) {
            $cover_style = 'dt_slider-cover';
            $w = 98; $h = 68;
        }
        
        $str .= sprintf( '<div class="dt_item-cover %s"><div><img src="%s" heught="%d" width="%d" /></div></div>', $cover_style, $file_name, $h, $w );

        // may be more complex and speede
        $atts = intval( $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM $wpdb->posts WHERE post_type = 'attachment' AND post_mime_type LIKE 'image/%%' AND post_status != 'trash' AND post_parent = %d", $item->ID ) ) );
            
        $str .= '<div class="dt_item-desc">';

        $pic_text = _x('no pictures', 'backend', LANGUAGE_ZONE);
        if( $atts == 1 ) {
            $pic_text = _x('1 picture', 'backend', LANGUAGE_ZONE);
        }elseif( $atts > 1 ) {
            $pic_text = sprintf(_x('%d pictures', 'backend', LANGUAGE_ZONE), $atts);
        }

        $str .= '<strong><a href="#">' . $item->post_title . '</a> (' . $pic_text . ')</strong>';

        $terms = get_the_terms( $item->ID, $opts['taxonomy'] );

        if( !is_wp_error($terms) && $terms ) { 
            $post_type = get_post_type($item->ID);
            $term_links = array();
            foreach ( $terms as $term ) {
                $link = get_term_link( $term, $opts['taxonomy'] );
                $link = str_replace( site_url('/'), site_url('/') . 'wp-admin/edit.php', $link );
                $link = add_query_arg( 'post_type', $post_type, $link );
                $term_links[] = '<a href="' . $link . '" rel="tag">' . $term->name . '</a>';
            }
            
            if( empty($term_links) ) {
                $term_links[] = 'none';
            }
            
            $str .= '<p><strong>' . _x('Categories: ', 'backend', LANGUAGE_ZONE) . '</strong>' . implode( ', ', $term_links ) . '</p>';
        }else {
            $str .= '<p></p>';
        }

        $str .= '<strong>' . _x('Date: ', 'backend', LANGUAGE_ZONE) . '</strong>';
        $str .= '<abbr title="' . get_the_date(get_option('date_format')) . '">' .  get_the_date(get_option('date_format')) . '</abbr>';
        
        $str .= '<div class="row-actions">';
        $str .= sprintf('<span class="edit"><a title="%s" href="%s">%s</a></span>',
            __('Edit this item', 'backend', LANGUAGE_ZONE),
            esc_url(get_admin_url() . 'post.php?post=' . $item->ID . '&action=edit'),
            __('Edit', 'backend', LANGUAGE_ZONE) 
        );
        if( current_user_can( 'edit_post', $item->ID ) ) {
            $str .= sprintf(' | <span class="trash"><a title="%s" href="%s">%s</a></span>',
                __('Move this item to the Trash', 'backend', LANGUAGE_ZONE),
                wp_nonce_url( site_url() . "/wp-admin/post.php?action=trash&post=" . $item->ID, 'trash-' . $item->post_type . '_' . $item->ID),
                __('Trash', 'backend', LANGUAGE_ZONE) 
            );
        }
        $str .= '</div>';

        $str .= '</div>';

        $str = sprintf( $opts['element_wrap'], $str ); 
        $output .= $str;
	}

    printf( $opts['wrap'], $output ); 
 
}

function dt_core_mb_draw_modern_selector( array $opts = array() ) {

    $defaults = array(
        'taxonomy'      => null,
        'maintab_class' => 'dt_all_sliders',
        'box_name'      => null,
        'albums_name'   => '',
        'cats_name'     => '',
        'posts'         => array(),
        'terms'         => array(),
        'albums'        => array(),
        'albums_cats'   => array(),
        'links'         => array(),
        'text'          => array(),
        'cur_type'      => null,
        'cur_select'    => null
    );
    $opts = wp_parse_args( $opts, $defaults );
    
    $tabs_arr = array(
        'arrange'   => __('Arrange by:', LANGUAGE_ZONE),
        'only'      => __('Only', LANGUAGE_ZONE),
        'except'    => __('All, except', LANGUAGE_ZONE),
        'all'       => __('All', LANGUAGE_ZONE)
    );

    $type = array(
        'albums'    => array(
            'desc'  => __('Albums', LANGUAGE_ZONE),
            'class' => 'type_selector',
            'wrap'  => '<label class="dt_arrange dt_by-albums">%1$s<span>%2$s</span></label>'
        ),
        'category'  => array(
            'desc'  => __('Category', LANGUAGE_ZONE),
            'class' => 'type_selector',
            'wrap'  => '<label class="dt_arrange dt_by-categories">%1$s<span>%2$s</span></label>'
        )
    );

    $select = array(
        'all'       => array(
            'desc'  => __('All', LANGUAGE_ZONE),
            'wrap'  => '<label class="dt_tab dt_all">%1$s<span>%2$s</span></label>'
        ),
        'only'      => array(
            'desc'  => __('Only', LANGUAGE_ZONE),
            'wrap'  => '<label class="dt_tab dt_only">%1$s<span>%2$s</span></label>'
        ),
        'except'    => array(
            'desc'  => __('All, except', LANGUAGE_ZONE),
            'wrap'  => '<label class="dt_tab dt_except">%1$s<span>%2$s</span></label>'
        )
    );
    
    if( $opts['posts'] ) {
        $posts_arr = array();
        foreach( $opts['posts'] as $pst ) {
            $posts_arr[] = intval($pst->ID);
        }
        $posts_arr = implode(',', $posts_arr);

        global $wpdb;
        $atts = intval( $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM $wpdb->posts WHERE post_type = 'attachment' AND post_mime_type LIKE 'image/%%' AND post_status != 'trash' AND post_parent IN($posts_arr)", null) ) );
    }
?>

    <div class="dt_tabs">

        <div class="dt_arrange-by">

        <?php if( $opts['terms'] && $opts['posts'] ): ?>
        
            <strong><?php echo $tabs_arr['arrange']; ?></strong>

        <?php elseif( $opts['terms'] ):

            unset( $type['albums'] );
            $type['category']['wrap'] = '<label class="dt_arrange dt_by-categories">%1$s</label>';

        elseif( $opts['posts'] ):

            unset( $type['category'] );
            $type['albums']['wrap'] = '<label class="dt_arrange dt_by-albums">%1$s</label>';

        endif; ?>

            <?php dt_core_mb_draw_radio_switcher( $opts['box_name'] . '_type', $opts['cur_type'], $type ); ?>

        </div>
        
        <?php dt_core_mb_draw_radio_switcher( $opts['box_name'] . '_select', $opts['cur_select'], $select); ?>
        
    </div>
    <div class="dt_tabs-content">
    
    <div class="dt_tab-all hide-if-js">
        <div class="dt_all_desc<?php echo !empty($opts['maintab_class'])?' '.esc_attr($opts['maintab_class']):''; ?>">

            <?php if( !empty($opts['text']) && is_array($opts['text']) ): ?>

                <?php echo $opts['text']['header']; ?>

            <ul>
                <li>
                    <strong><?php echo $select['all']['desc']; ?></strong>
                    <?php echo isset($opts['text']['select_desc'][0])?$opts['text']['select_desc'][0]:''; ?>
                </li>
                <li>
                    <strong><?php echo $select['only']['desc']; ?></strong>
                    <?php echo isset($opts['text']['select_desc'][1])?$opts['text']['select_desc'][1]:''; ?>
                </li>
                <li>
                    <strong><?php echo $select['except']['desc']; ?></strong>
                    <?php echo isset($opts['text']['select_desc'][2])?$opts['text']['select_desc'][2]:''; ?>
                </li>
			</ul>
            
                <?php if( isset($opts['text']['info_desc']) ): ?>
            
            <p class="dt_hr"></p>
            <h4><?php echo _x('You have:', 'backend', LANGUAGE_ZONE); ?></h4>
            <ul class="dt_total">

                <?php if( $opts['posts'] ): ?>
                
                    <li class="dt_total_albums"><?php printf( $opts['text']['info_desc'][0], count($opts['posts']) ); ?></li>

                    <?php if( isset($opts['text']['info_desc'][1]) ): ?>
                    <li class="dt_total_images"><?php printf( $opts['text']['info_desc'][1], $atts ); ?></li>
                    <?php endif; ?>

                <?php endif; ?>

                <?php if( $opts['terms'] ): ?>

                    <li class="dt_total_categories"><?php printf( _x('%d categories', 'backend', LANGUAGE_ZONE), count($opts['terms']) ); ?></li>

                <?php endif; ?>

            </ul>
    
                <?php endif; ?>

            <?php endif; ?>
            
            <?php dt_core_mb_draw_functional_links( $opts['links'] ); ?>

        </div>
    </div>
    <div class="dt_tab-select hide-if-js">
    <?php if( $opts['posts'] && $opts['albums_name'] ): ?>
        <div class="dt_tab-items hide-if-js"><?php
            $args = array();
            if( $opts['taxonomy'] ) {
                $args['taxonomy'] = $opts['taxonomy'];
            }

            dt_core_mb_draw_posts_list( $opts['albums_name'], $opts['albums'], $opts['posts'], $args );
        ?></div>
    <?php endif; ?>
    <?php if( $opts['terms'] && $opts['cats_name'] ): ?>
        <div class="dt_tab-categories hide-if-js"><?php
            dt_core_mb_draw_category_list( $opts['cats_name'], $opts['albums_cats'], $opts['terms'] );
        ?></div>
    <?php endif; ?>
        <div class="dt_nano-mask" style="display: none; "></div>
    </div>
    
    </div><!-- .tabs_content -->

<?php

}

?>
