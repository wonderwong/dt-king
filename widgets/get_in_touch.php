<?php
class DT_contact_Widget extends WP_Widget {

	/* Widget setup  */
	function __construct() {  
        
        // clear session entry
        if( isset($_SESSION['dt_captcha']) ) {
            unset($_SESSION['dt_captcha']);
        }
        
        /* Widget settings. */
		$widget_ops = array( 'description' => __('Contact form', LANGUAGE_ZONE) );

		/* Create the widget. */
        parent::__construct(
            'dt-contact-widget',
            DT_WIDGET_PREFIX . __('Contact', LANGUAGE_ZONE),
            $widget_ops
        );
	}

	/* Display the widget  */
    function widget( $args, $instance ) {
        static $widget_counter = 1;
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
        $en_captcha = isset($instance['enable_captcha'])?$instance['enable_captcha']:true;

        $captcha_id = 'widget_' . $widget_counter++;
		echo $before_widget ;

		// start
		echo $before_title . $title . $after_title;

        if( isset($instance['text']) && $instance['text'] )
            echo force_balance_tags('<p>' . $instance['text'] . '</p>');
?>
        <form class="uniform get-in-touch ajaxing" method="post" action="/"> 
            <?php wp_nonce_field('dt_contact_' . $captcha_id,'dt_contact_form_nonce'); ?>
            <input type="hidden" name="send_message" value="" />
            <input type="hidden" name="send_contacts" value="<?php echo $captcha_id; ?>" />

            <div class="i-h">
                <input id="your_name" name="f_name" type="text" value="" class="validate[required]" />
                <div class="i-l"><span><?php _e( 'Name', LANGUAGE_ZONE ); ?></span></div>
            </div>
            
            <div class="i-h">
                <input id="email" name="f_email" type="text" value="" class="validate[required,custom[email]" />
                <div class="i-l"><span><?php _e( 'E-mail', LANGUAGE_ZONE ); ?></span></div>
            </div>
            
            <div class="t-h">
                <textarea type="textarea" id="message" name="f_comment" class="validate[required]"></textarea>
            </div>
            
            <?php do_action('dt_contact_form_captcha_place', array( 'whoami' => $captcha_id, 'enable' => $en_captcha ) ); ?>
            
            <a href="#" class="button go_submit" title="<?php _e('Submit', LANGUAGE_ZONE); ?>"><span><i class="submit"></i><?php _e("Send message", LANGUAGE_ZONE); ?></span></a>
            <a href="#" class="do-clear"><?php _e( 'сlear form', LANGUAGE_ZONE ); ?></a> 
        </form>   
<?php
		echo $after_widget;
    }

	/* Update the widget settings  */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = isset($new_instance['title'])?strip_tags($new_instance['title']):'';
		$instance['text'] = isset($new_instance['text'])?esc_html($new_instance['text']):'';
        $instance['enable_captcha'] = isset($new_instance['enable_captcha']);
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
            'text'              => '',
			'title'             => '',
            'enable_captcha'    => true
		);
			
        $instance = wp_parse_args( (array) $instance, $defaults );
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', LANGUAGE_ZONE); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e('Text:', LANGUAGE_ZONE); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $instance['text']; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'enable_captcha' ); ?>"><?php _e('Enable Captcha:', LANGUAGE_ZONE); ?></label>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'enable_captcha' ); ?>" name="<?php echo $this->get_field_name( 'enable_captcha' ); ?>" <?php checked($instance['enable_captcha']); ?> />
		</p>
        <a href="<?php echo admin_url('admin.php?page=of-captcha-menu'); ?>"><?php _e('Captha options', LANGUAGE_ZONE); ?></a>
<?php

    }
}

/* Register the widget */
function dt_contact_register() {
	register_widget( 'DT_contact_Widget' );
}

/* Load the widget */
add_action( 'widgets_init', 'dt_contact_register' );
?>
