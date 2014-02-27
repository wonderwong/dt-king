<?php
class King_pages extends WP_Widget {
	function __construct() {
        parent::__construct(
            'king_pages',
            'King pages'
        );
	}

	function form($instance) {
		// widget controls

        $defaults = array(
			'title' => '',
            'nums' => 1,
            'pageID'  => null
        );
        $instance = wp_parse_args( $instance, $defaults );
        $instance = array_map( 'esc_attr', $instance );

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title') ?>"><?php echo __( 'Title:', LANGUAGE_ZONE ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo $instance['title']; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('nums') ?>"><?php echo "一行显示数量：";?></label>
			<input id="<?php echo $this->get_field_id('nums') ?>" name="<?php echo $this->get_field_name('nums') ?>" type="text" value="<?php echo $instance['nums']; ?>" size="3" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('pageID') ?>"><?php echo "页面ID：";?></label>
			<input id="<?php echo $this->get_field_id('pageID') ?>" name="<?php echo $this->get_field_name('pageID') ?>" type="text" value="<?php echo $instance['pageID']; ?>" size="10" />
		</p>

	<?php

	}

	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        
        $new_instance['nums'] *= 1;
		$instance['nums'] = ($new_instance['nums'] > 0)?$new_instance['nums']:5;
		
		$instance['pageID'] = strip_tags( $new_instance['pageID'] );
        
        return $instance;
	}

	function widget($args, $instance) {
		// outputs the content of the widget
		extract( $args );
		
        $defaults = array(
            'title' => '',
            'nums' => 1,
            'pageID'  => null
        );
        $instance = wp_parse_args( $instance, $defaults );
        
		$title = apply_filters( 'widget_title', $instance['title'] );
	        
		
		echo $before_widget;
		
		if( $title )
			echo $before_title . $title . $after_title;
		
		$last = $posts->found_posts;
		
		king_the_pages($instance['nums'],$instance['pageID']);
		
		echo $after_widget;
	}
}

function king_pages_register() {
	register_widget('King_pages');
}

add_action( 'widgets_init', 'king_pages_register' );
