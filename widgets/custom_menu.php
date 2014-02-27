<?php
function dt_widget_custom_menu_class_filter( $class, $item, $args ) {
    static $item_counter = 0;
    $item_counter++;
    
    if( 1 == $item_counter ) {
        $class[] = 'first';
    }

    if( $args->menu->count == $item_counter )
        $item_counter = 0;
    
    return $class;
}

function dt_widget_custom_menu_start_el_filter( $item_output, $item, $depth, $args ) {
    static $item_counter = 0;
    $item_counter++;
/*
    if( 1 == $item_counter ) {
        $item_output = str_replace( '' $item_output );
    }
 */  
    return $item_output;
}

/*
 * Modified standard wordpress widget
 */
class DT_Nav_Menu_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => _x('Use this widget to add one of your custom menus as a widget.', 'widget custom menu', LANGUAGE_ZONE) );
		parent::__construct( 'dt_nav_menu', DT_WIDGET_PREFIX . _x('Custom Menu', 'widget custom menu', LANGUAGE_ZONE), $widget_ops );
	}

	function widget($args, $instance) {
		// Get menu
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

		if ( !$nav_menu )
			return;

		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'];

		if ( !empty($instance['title']) )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
        
        add_filter( 'nav_menu_css_class', 'dt_widget_custom_menu_class_filter', 99, 3 );
		wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'container' => false, 'menu_class' => 'custom-menu' ) );
        remove_filter( 'nav_menu_css_class', 'dt_widget_custom_menu_class_filter', 99, 3 );

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

		// Get menus
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		// If no menus exists, direct the user to go and create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( _x('No menus have been created yet. <a href="%s">Create some</a>.', 'widget custom menu', LANGUAGE_ZONE), admin_url('nav-menus.php') ) .'</p>';
			return;
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo _x('Title:', 'widget custom menu', LANGUAGE_ZONE) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php echo _x('Select Menu:', 'widget custom menu', LANGUAGE_ZONE); ?></label>
			<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
		<?php
			foreach ( $menus as $menu ) {
				$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
				echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
			}
		?>
			</select>
		</p>
		<?php
	}
}

function dt_menu_register() {
	register_widget('DT_Nav_Menu_Widget');
}
	
add_action( 'widgets_init', 'dt_menu_register' );

?>
