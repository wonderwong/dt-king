<?php
    class DT_Widget_Walker_Category extends Walker_Category {
        var $is_first = true; 

  	    function start_el(&$output, $category, $depth, $args) {
            extract($args);
  
            $cat_name = esc_attr( $category->name );
            $cat_name = apply_filters( 'list_cats', $cat_name, $category );
            $link = '<a href="' . esc_attr( get_term_link($category) ) . '" ';
            if ( $use_desc_for_title == 0 || empty($category->description) )
                $link .= 'title="' . esc_attr( sprintf(_x( 'View all posts filed under %s', 'widget categories', LANGUAGE_ZONE ), $cat_name) ) . '"';
            else
                $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
            $link .= '>';
            $link .= $cat_name;
    
            if ( !empty($show_count) )
                $link .= '<span>(' . intval($category->count) . ')</span>';
             
            $link .= '</a>';
     
            if ( !empty($feed_image) || !empty($feed) ) {
                $link .= ' ';
     
                if ( empty($feed_image) )
                    $link .= '(';
     
                $link .= '<a href="' . get_term_feed_link( $category->term_id, $category->taxonomy, $feed_type ) . '"';
     
                if ( empty($feed) ) {
                    $alt = ' alt="' . sprintf(_x( 'Feed for all posts filed under %s', 'widget categories', LANGUAGE_ZONE ), $cat_name ) . '"';
                } else {
                    $title = ' title="' . $feed . '"';
                    $alt = ' alt="' . $feed . '"';
                    $name = $feed;
                    $link .= $title;
                }
     
                $link .= '>';
     
                if ( empty($feed_image) )
                    $link .= $name;
                else
                    $link .= "<img src='$feed_image'$alt$title" . ' />';
     
                $link .= '</a>';
     
                if ( empty($feed_image) )
                    $link .= ')';
            }
     
            if ( !empty($show_date) )
                $link .= ' ' . gmdate('Y-m-d', $category->last_update_timestamp);
     
            if ( 'list' == $args['style'] ) {
                $output .= "\t<li";
                $class = 'cat-item cat-item-' . $category->term_id;
                
                if( $this->is_first ) {
                    $class = 'first ' . $class;
                    $this->is_first = false;
                }
                
                if ( !empty($current_category) ) {
                    $_current_category = get_term( $current_category, $category->taxonomy );
                    if ( $category->term_id == $current_category )
                        $class .=  ' current-cat';
                    elseif ( $category->term_id == $_current_category->parent )
                        $class .=  ' current-cat-parent';
                }
                $output .=  ' class="' . $class . '"';
                $output .= ">$link\n";
            } else {
                $output .= "\t$link<br />\n";
            }
        }
    
    }
    
	class DT_cats_Widget extends WP_Widget {
		function __construct() {
            parent::__construct(
                'dt_categories',
                DT_WIDGET_PREFIX . __('Categories', LANGUAGE_ZONE)
            );
		}

		function form( $instance ) {
			$defaults = array(
                'title'     => '',
                'cols'      => 1
            );
            $instance = wp_parse_args( $instance, $defaults );
            
            // outputs the options form on admin
            $title = esc_attr( $instance[ 'title' ] );
            $cols = intval( $instance[ 'cols' ] );
			?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">
                    <?php _e( 'Title:', LANGUAGE_ZONE ); ?>
                </label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<?php
		}

		function update($new_instance, $old_instance) {
			// processes widget options to be saved
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			return $instance;
		}

		function widget($args, $instance) {
			// outputs the content of the widget
			extract( $args );
			
			$title = apply_filters( 'widget_title', $instance['title'] );
            $cols_class = '';
//            $first_count = 1;

            $cats = wp_list_categories( array(
                'show_count'    => true,
                'hierarchical'  => false,
                'title_li'      => '',
                'echo'          => false,
                'walker'        => new DT_Widget_Walker_Category()
            ) );

//			preg_match_all('/(<a[^>]+>[^<]+<\/a>)/', $ret, $m);
//			$cats_count = count( $m[1] );
//			$i = 0;
			
			echo $before_widget;
			if( $title )
				echo $before_title . $title . $after_title;
                
/*			if( isset($id) && 'bottom-widget-area' != $id ) {
                echo '<div class="widget">';
            }
 */            
            ?>

            <ul class="categories">
		    
            <?php    
/*			foreach( $m[1] as $cat ){
				echo '<li'. ($i++ < $first_count? ' class="first"' : ''). '>'. $cat. '</li>'."\n";
            }
 */         
            echo $cats;
            ?>

			</ul>
            
            <?php

            echo $after_widget;

		}
	}
	
	function dt_cats_register() {
		register_widget('DT_cats_Widget');
	}
	
	add_action( 'widgets_init', 'dt_cats_register' );
