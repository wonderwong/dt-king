<?php
class King_recent_post extends WP_Widget {
	function __construct() {
        parent::__construct(
            'king_host_posts',
            'King host Posts'
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
		<p>
			<label for="<?php echo $this->get_field_id('strLen') ?>"><?php echo "标题字数：";?></label>
			<input id="<?php echo $this->get_field_id('strLen') ?>" name="<?php echo $this->get_field_name('strLen') ?>" type="text" value="<?php echo $instance['strLen']; ?>" size="3" />
		</p>

	<?php

	}

	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        
        $new_instance['show'] *= 1;
		$instance['show'] = ($new_instance['show'] > 0)?$new_instance['show']:5;
		
		$instance['strLen'] = ($new_instance['strLen'] > 0)?$new_instance['strLen']:0;
        
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
	        
		
		echo $before_widget;
		
		if( $title )
			echo $before_title . $title . $after_title;
		
		$last = $posts->found_posts;
		
		king_the_hot_posts($instance['show'],$instance['strLen']);
		
		echo $after_widget;
	}
}

function king_recent_posts_register() {
	register_widget('King_recent_post');
}

add_action( 'widgets_init', 'king_recent_posts_register' );
