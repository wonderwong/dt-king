<?php
/* Begin Widget Class */
class DT_logos_Widget extends WP_Widget {
    public $dt_defaults = array( 
		'title'     => '',
		'order'     => 'ASC',
		'show'      => 6,
        'desc'      => true,
        'orderby'   => 'modified',
        'select'    => 'all',
        'autoslide' => 0,
        'cats'      => array()
    );

	/* Widget setup  */
	function __construct() {  
        /* Widget settings. */
		$widget_ops = array( 'description' => __('A widget with logos', LANGUAGE_ZONE) );

		/* Create the widget. */
        parent::__construct(
            'dt-logos-widget',
            DT_WIDGET_PREFIX . __('Logos', LANGUAGE_ZONE),
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
		
		global $wpdb;
        
        $args = array(
			'posts_per_page'	=> $instance['show'],
            'post_type'         => 'dt_logos',
            'post_status'       => 'publish',
            'orderby'           => $instance['orderby'],
            'order'             => $instance['order'],
            'tax_query'         => array( array(
                'taxonomy'      => 'dt_logos_category',
                'field'         => 'id',
                'terms'         => $instance['cats']
            ) ),
        );

        switch( $instance['select'] ) {
            case 'only': $args['tax_query'][0]['operator'] = 'IN'; break;
            case 'except': $args['tax_query'][0]['operator'] = 'NOT IN'; break;
            default: unset( $args['tax_query'] );
        }
        
        add_filter('posts_clauses', 'dt_core_join_left_filter');
        $p_query = new WP_Query( $args ); 
        remove_filter('posts_clauses', 'dt_core_join_left_filter');

		echo $before_widget ;

		// start
		echo $before_title . $title . $after_title;
        ?>	
        <div class="partner-bg">
            <div class="list-carousel recent">
                <ul class="carouFredSel_1" data-autoslide="<?php echo $autoslide; ?>" data-autoslide_on="<?php echo $autoslide_on; ?>">
        
        <?php
        if ( $p_query->found_posts ) {

            foreach( $p_query->posts as $logos ) {
                if( has_post_thumbnail( $logos->ID ) ):
                    $thumb_id = get_post_thumbnail_id($logos->ID);
                    $thumb_meta = wp_get_attachment_image_src($thumb_id, 'full');

                    $args = array(
                        'posts_per_page'    => 1,
			            'post_type'			=> 'attachment',
			            'post_mime_type'	=> 'image',
			            'post_status' 		=> 'inherit',
                        'p'                 => $thumb_id
		            );
		
		            $thumbnail = new WP_Query( $args );

                    $logos_opts = get_post_meta( $logos->ID, '_dt_logos_options', true );
            ?>

                <li>

                <?php
                $logo_img = sprintf( '<img src="%s" alt="%s" %s />', esc_url($thumb_meta[0]), $thumbnail->posts[0]->post_excerpt, image_hwstring($thumb_meta[1], $thumb_meta[2]) );
                if( isset($logos_opts['url']) && !empty($logos_opts['url']) )
                    $logo_img = sprintf( '<a href="%s" title="%s">%s</a>', esc_url($logos_opts['url']), $logos->post_title, $logo_img );
                echo $logo_img;
                ?>

                </li>

                <?php
                endif;
            };
        }
        ?>

            </ul> 

        <?php if( $p_query->found_posts > 1 ): ?>
            
            <a class="prev" href="#"></a>
            <a class="next" href="#"></a>
                    
        <?php endif; ?>

            </div>
	    </div>
        <?php
		echo $after_widget;
	}

	/* Update the widget settings  */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
        $instance['show'] = abs(intval($new_instance['show']));
        $instance['order'] = strip_tags($new_instance['order']);
        $instance['orderby'] = strip_tags($new_instance['orderby']);
        $instance['cats'] = array_map('intval', (array) $new_instance['cats']);
        $instance['select'] = !empty($instance['cats'])?strip_tags($new_instance['select']):'all';
        $instance['autoslide'] = abs(intval($new_instance['autoslide']));
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

        $p_orderby = array(
            'ID'        => _x( 'Order by ID', 'backend orderby', LANGUAGE_ZONE ),
            'author'    => _x( 'Order by author', 'backend orderby', LANGUAGE_ZONE ),
            'title'     => _x( 'Order by title', 'backend orderby', LANGUAGE_ZONE ),
            'date'      => _x( 'Order by date', 'backend orderby', LANGUAGE_ZONE ),
            'modified'  => _x( 'Order by modified', 'backend orderby', LANGUAGE_ZONE ),
            'rand'      => _x( 'Order by rand', 'backend orderby', LANGUAGE_ZONE ),
            'menu_order'=> _x( 'Order by menu', 'backend orderby', LANGUAGE_ZONE )
        );

        ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', LANGUAGE_ZONE); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
		</p>
        <p>
			<strong><?php _e('Show Logos from following categories:', LANGUAGE_ZONE); ?></strong><br />
            <?php 
            $terms = get_terms( 'dt_logos_category', array(
                'hide_empty'    => 1,
                'hierarchical'  => false 
            ) );

            if( !is_wp_error($terms) ): ?>

            <div class="dt-widget-switcher">

            <?php dt_core_mb_draw_radio_switcher(
                    $this->get_field_name( 'select' ),
                    $instance['select'],
                    array(
                        'all'       => array( 'desc' => __('All', LANGUAGE_ZONE) ),
                        'only'      => array( 'desc' => __('Only', LANGUAGE_ZONE) ),
                        'except'    => array( 'desc' => __('Except', LANGUAGE_ZONE) )
                    )
                );
            ?>
            
            </div>

            <div class="hide-if-js">

                <?php foreach( $terms as $term ): ?>

                <input id="<?php echo $this->get_field_id($term->term_id); ?>" type="checkbox" name="<?php echo $this->get_field_name('cats'); ?>[]" value="<?php echo $term->term_id; ?>" <?php checked( in_array($term->term_id, $instance['cats']) ); ?>/>
                <label for="<?php echo $this->get_field_id($term->term_id); ?>"><?php echo $term->name; ?></label><br />

                <?php endforeach; ?>

            </div>

            <?php else: ?>

            <span style="color: red;"><?php _e('There is no categories', LANGUAGE_ZONE); ?></span>

            <?php endif; ?>

        </p>
		<p>
            <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('Show:', LANGUAGE_ZONE); ?></label>
            <select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
                <?php foreach( $p_orderby as $value=>$name ): ?>
                <option value="<?php echo $value; ?>" <?php selected( $instance['orderby'], $value ); ?>><?php echo $name; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        </p>
            <?php echo _e('Sort by:', LANGUAGE_ZONE);?>
            <label>
            <input name="<?php echo $this->get_field_name( 'order' ); ?>" value="ASC" type="radio" <?php checked( $instance['order'], 'ASC' ); ?> /><?php _e('Ascending', LANGUAGE_ZONE); ?>
			</label>
			<label>
            <input name="<?php echo $this->get_field_name( 'order' ); ?>" value="DESC" type="radio" <?php checked( $instance['order'], 'DESC' ); ?> /><?php _e('Descending', LANGUAGE_ZONE); ?>
			</label>
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
function dt_logos_register() {
	register_widget( 'DT_logos_Widget' );
}

/* Load the widget */
add_action( 'widgets_init', 'dt_logos_register' );
?>
