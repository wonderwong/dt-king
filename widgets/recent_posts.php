<?php
class DT_recent_post extends WP_Widget {
	function __construct() {
        parent::__construct(
            'dt_recent_posts',
            DT_WIDGET_PREFIX . __('Recent Posts', LANGUAGE_ZONE)
        );
	}

	function form($instance) {
		// widget controls

        $defaults = array(
            'title' => '',
            'show'  => 5
        );
        $instance = wp_parse_args( $instance, $defaults );
        $instance = array_map( 'esc_attr', $instance );

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title') ?>"><?php echo __( 'Title:', LANGUAGE_ZONE ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo $instance['title']; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('show') ?>"><?php echo __( 'Number of posts to show:', LANGUAGE_ZONE ) ?></label>
			<input id="<?php echo $this->get_field_id('show') ?>" name="<?php echo $this->get_field_name('show') ?>" type="text" value="<?php echo $instance['show']; ?>" size="3" />
		</p>

	<?php

	}

	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        
        $new_instance['show'] *= 1;
		$instance['show'] = ($new_instance['show'] > 0)?$new_instance['show']:5;
        
        return $instance;
	}

	function widget($args, $instance) {
		// outputs the content of the widget
		extract( $args );
		
        $defaults = array(
            'title' => '',
            'show'  => 5
        );
        $instance = wp_parse_args( $instance, $defaults );
        
		$title = apply_filters( 'widget_title', $instance['title'] );
	        
        $posts = new WP_Query( array(
            'post_status'           => 'publish',
            'posts_per_page'        => $instance['show'],
            'ignore_sticky_posts'   => true,
            'no_found_rows'         => true
        ) );
		
		echo $before_widget;
		
		if( $title )
			echo $before_title . $title . $after_title;
		
		$last = $posts->found_posts;
		
		if( $posts->have_posts() ) {
		    $i = 1;
			foreach( $posts->posts as $post_item ):
                $class = '';
                if( $i == 1 ) {
                    $class = ' first';
                }elseif( $i == $last ) {
                    $class = ' last';
                }

                $title = get_the_title($post_item->ID);
                if( !$title ) {
                    $title = __('No title', LANGUAGE_ZONE);
                }
                ?>

                <div class="post<?php echo $class ; ?>">
                    <a href="<?php echo get_permalink($post_item->ID); ?>"><?php echo $title; ?></a>
				    <div class="goto-post">
                        <span class="ico-link date"><?php echo get_the_time(get_option('date_format'), $post_item->ID); ?></span>
<?php                        
                dt_get_comments_link(
                    '<span class="ico-link comments">%COUNT%</span>',
                    array( 'no_coments' => '' ),
                    $post_item->ID
                );
?>
                    </div>
                </div>
            <?php

            $i++;
		    endforeach;	
		}
		echo $after_widget;
	}
}

function dt_recent_posts_register() {
	register_widget('DT_recent_post');
}

add_action( 'widgets_init', 'dt_recent_posts_register' );
