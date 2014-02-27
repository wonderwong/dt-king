<?php
/* Begin Widget Class */
class DT_slider_Widget extends WP_Widget {
    public $dt_defaults = array( 
		'title'     => '',
		'show'      => 6,
        'desc'      => true,
        'autoslide' => 0,
        'cats'      => null 
    );

	/* Widget setup  */
	function __construct() {  
        /* Widget settings. */
		$widget_ops = array( 'description' => __('A widget with slider', LANGUAGE_ZONE) );

		/* Create the widget. */
        parent::__construct(
            'dt-slider-widget',
            DT_WIDGET_PREFIX . __('Slider', LANGUAGE_ZONE),
            $widget_ops
        );
	}

	/* Display the widget  */
	function widget( $args, $instance ) {
        
		extract( $args );

        $instance = wp_parse_args( (array) $instance, $this->dt_defaults );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
        $autoslide = $instance['autoslide'];
        $autoslide_on = $autoslide?1:0;

		global $wpdb, $post;
        
        $args = array(
			'posts_per_page'	=> 1 ,
            'post_type'         => 'dt_slider',
            'post_status'       => 'publish',
            'post__in'          => array($instance['cats'])
        );

        $p_query = new WP_Query( $args ); 

		echo $before_widget ;

		// start
		echo $before_title . $title . $after_title;
        ?>	

        <div class="navig-small">
		    <a class="SliderNamePrev" href="javascript:void(0);"></a>
			<a class="SliderNameNext" href="javascript:void(0);"></a>
		</div>
        <div class="slider_container_1"> 
        <?php
        if( $p_query->have_posts() ) {
            $slides_arr = array();
            foreach( $p_query->posts as $album ) {
		
                $args = array(
                    'posts_per_page'    => $instance['show'],
			        'post_type'			=> 'attachment',
			        'post_mime_type'	=> 'image',
                    'post_parent'       => $album->ID,
                    'post_status' 		=> 'inherit',
                    'orderby'           => 'menu_order',
                    'order'             => 'ASC'
		        );
		
		        $images = new WP_Query( $args );

                if( $images->have_posts() ) {
                    while( $images->have_posts() ) { $images->the_post();
                        $link = get_post_meta( $post->ID, '_dt_slider_link', true );
                        $hide_desc = get_post_meta( $post->ID, '_dt_slider_hdesc', true );
                        $link_neww = get_post_meta( $post->ID, '_dt_slider_newwin', true );
                        
                        $tmp_arr = array();
                        if( !empty($post->post_excerpt) && !$hide_desc && $instance['desc'] ) {
                            $tmp_arr['caption'] = wp_trim_words( get_the_excerpt(), 15, '' );
                        }
                        
                        if( !empty($link) ) {
                            $tmp_arr['link'] = $link;
                        }

                        if( !empty($link_neww) ) {
                            $tmp_arr['link_neww'] = true;
                        }
                         
                        if( !empty($post->post_title) && !$hide_desc )  
                            $tmp_arr['title'] = $post->post_title;
                     
                        $img = wp_get_attachment_image_src( $post->ID, 'full' );
                        if( $img ) {
                            $tmp_arr['src'] = str_replace( array('src="', '"'), '', dt_get_thumb_img(
                                array(
                                'img_meta'   => $img,
                                'thumb_opts' => array( 'w' => 202, 'h' => 202 ) 
                                ),
                                '%SRC%',
                                false
                            ) );
                            $tmp_arr['size_str'] = image_hwstring( 202, 202 );
                        }
                        $slides_arr[] = $tmp_arr;
                    }
                }else{ ?>

                    <div style="color: red; margin: 0 auto; padding: 20px; text-shadow: none; "><?php _e('There are no images in the slider.', LANGUAGE_ZONE); ?></div>

                <?php
                }
            }

            $images = $caption = '';
            $i = 1;

            foreach( $slides_arr as $slide ) {
                $caption .= '<div class="nivo-html-caption caption-' . $i . '">';
                if( !empty($slide['caption']) )
                    $caption .= '<p>' . $slide['caption'] . '</p>';
                $caption .= '</div>';

                if( !empty($slide['link']) )
                    $images .= '<a href="' . esc_url($slide['link']) . '"' . (!empty($slide['link_neww'])?'target="_blank"':'') . '>';
                
                $images .= '<img src="' . $slide['src'] . '" alt="" title=".caption-' . $i . '" ' . $slide['size_str'] . ' />';
                
                if( !empty($slide['link']) )
                    $images .= '</a>';

                $i++;
            }

            
            ?>

                <div class="widget_slider" data-autoslide="<?php echo $autoslide; ?>" data-autoslide_on="<?php echo $autoslide_on; ?>"><?php echo $images; ?></div><?php echo $caption; ?>
            </div>
            <?php
        }
        wp_reset_postdata();

		echo $after_widget;
	}

	/* Update the widget settings  */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
        $instance['show'] = abs(intval($new_instance['show']));
        $instance['cats'] = intval($new_instance['cats']);
        $instance['autoslide'] = abs(intval($new_instance['autoslide']));
        $instance['desc'] = (bool) $new_instance['desc'];
 		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
        $instance = wp_parse_args( (array) $instance, $this->dt_defaults );
        ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', LANGUAGE_ZONE); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
		</p>
        <p>
			<label><strong><?php _e('Select a slider:', LANGUAGE_ZONE); ?></strong></label><br />
            <?php 
            $slides = new WP_Query( array(
                'post_type'         => 'dt_slider',
                'post_status'       => 'publish',
                'posts_per_page'    => -1,
                'orderby'           => 'title',
                'order'             => 'ASC'
            ) );
            
            if( $slides->have_posts() ):
                if( empty($instance['cats']) ) {
                    $instance['cats'] = $slides->posts[0]->ID;
                }
            ?>

                <?php foreach( $slides->posts as $slide ): ?>

                <input id="<?php echo $this->get_field_id($slide->ID); ?>" type="radio" name="<?php echo $this->get_field_name('cats'); ?>" value="<?php echo $slide->ID; ?>" <?php checked( $slide->ID == $instance['cats'] ); ?>/>
                <label for="<?php echo $this->get_field_id($slide->ID); ?>">&nbsp;<?php echo $slide->post_title; ?></label><br />

                <?php endforeach; ?>

            <?php else: ?>

                <span style="color: red;"><?php _e('There is no sliders', LANGUAGE_ZONE); ?></span>

            <?php endif; ?>

        </p>
        <p style="display: none">
			<label for="<?php echo $this->get_field_id( 'desc' ); ?>"><?php _e('Show hovering description:', LANGUAGE_ZONE); ?></label>
            <input id="<?php echo $this->get_field_id( 'desc' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'desc' ); ?>" <?php checked( $instance['desc'] ); ?> />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show' ); ?>"><?php _e('How many:', LANGUAGE_ZONE); ?></label>
            <input id="<?php echo $this->get_field_id( 'show' ); ?>" name="<?php echo $this->get_field_name( 'show' ); ?>" value="<?php echo esc_attr($instance['show']); ?>" size="3" />
	    </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'autoslide' ); ?>"><?php _e('Autoslide:', LANGUAGE_ZONE); ?></label>
            <input id="<?php echo $this->get_field_id( 'autoslide' ); ?>" name="<?php echo $this->get_field_name( 'autoslide' ); ?>" value="<?php echo esc_attr($instance['autoslide']); ?>" size="4" />
			<em>milliseconds<br /> (1 second = 1000 milliseconds; to disable autoslide leave this field blank or set it to "0")</em>
	    </p>

		
		<div style="clear: both;"></div>
	<?php
	}
}

/* Register the widget */
function dt_slider_register() {
	register_widget( 'DT_slider_Widget' );
}

/* Load the widget */
add_action( 'widgets_init', 'dt_slider_register' );
?>
