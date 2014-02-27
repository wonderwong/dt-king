<?php
/* Begin Widget Class */
class DT_latest_photo_Widget extends WP_Widget {

	/* Widget setup  */
	function __construct() {  
        /* Widget settings. */
		$widget_ops = array( 'description' => __('A widget with photos from your albums', 'dt') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 250, 'id_base' => 'dt-latest-photo-widget' );

		/* Create the widget. */
        parent::__construct(
            'dt-latest-photo-widget',
            DT_WIDGET_PREFIX . __('Small photos', LANGUAGE_ZONE),
            $widget_ops,
            $control_ops
        );
	}

	/* Display the widget  */
	function widget( $args, $instance ) {
        $this->dt_hs_group++;
        
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$show = isset($instance['show'])?$instance['show']:6;
		$order = $instance['order'];
		
		global $wpdb;
        
        dt_storage(
            'where_filter_param',
            sprintf(
                'SELECT ID FROM %s WHERE post_type="%s" AND post_status="publish" AND post_password=""',
                $wpdb->posts,
                'dt_gallery'
            )
        ); 
		
		$args = array(
			'posts_per_page'	=> $show,
			'post_type'			=> 'attachment',
			'post_mime_type'	=> 'image',
			'post_status' 		=> 'inherit'
		);
		if ( 'rand' == $order ) {
			$args['orderby'] = 'rand';
		}
		
        add_filter( 'posts_where' , 'dt_core_parents_where_filter' );
		$p_query = new Wp_Query( $args );
        remove_filter( 'posts_where' , 'dt_core_parents_where_filter' );
		
		echo $before_widget ;

		// start
		echo $before_title . $title . $after_title;
			
		echo '<div class="flickr">';
		
		if ( !empty($p_query->posts) ) {
			foreach ( $p_query->posts as $photo ) {

                if( post_password_required($photo->post_parent) )
                    continue;

                $title = $photo->post_title;
                $caption = $photo->post_excerpt;
				$photo_t_src = dt_get_thumbnail(
                    array(
                        'img_id'	=> $photo->ID,
                        'width'		=> 58,
                        'height'	=> 58,
                        'upscale'   => true
                    )
                );
				$photo_b_src = wp_get_attachment_image_src( $photo->ID, 'full' );
				printf( '<a href="%s" rel="prettyPhoto[gallery-flickr]" class="%s" title="%s"%s><img %s src="%s" data-src="%s" alt="%s" class="%s"/><i></i></a>',
					$photo_b_src[0],
					'alignleft-f',
                    strip_tags($caption),
                    '',
					$photo_t_src['size_str'],
                    get_template_directory_uri()."/images/blank.gif",
					$photo_t_src['thumnail_img'],
                    $title,
					'lazy-img'
				);
                if( $caption && 0 )
                    echo '<div class="highslide-caption">'.$caption.'</div>';
			}
		}
		
		echo '</div><!-- /.flickr -->';
	
		echo $after_widget;
	}

	/* Update the widget settings  */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['show'] = intval($new_instance['show']);
        $instance['order'] = strip_tags($new_instance['order']);
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 
			'title' => '',
			'order' => 'rand',
			'show'  => 6
		);
			
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', LANGUAGE_ZONE); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
		</p>

		<p>
            <label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e('Show:', 'dt'); ?></label><br />
            <label>
   			    <input id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" value="rand" type="radio" <?php checked( $instance['order'], 'rand' ); ?> /> Random photos
			</label><br />
			<label>
   			    <input id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" value="latest" type="radio" <?php checked( $instance['order'], 'latest' ); ?> /> Latest photos
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show' ); ?>"><?php _e('How many:', LANGUAGE_ZONE); ?></label>
            <input id="<?php echo $this->get_field_id( 'show' ); ?>" name="<?php echo $this->get_field_name( 'show' ); ?>" value="<?php echo esc_attr($instance['show']); ?>" size="3" />
	   </p>
		
		<div style="clear: both;"></div>
	<?php
	}
}

/* Register the widget */
function dt_latest_photo_register() {
	register_widget( 'DT_latest_photo_Widget' );
}

/* Load the widget */
add_action( 'widgets_init', 'dt_latest_photo_register' );

?>
