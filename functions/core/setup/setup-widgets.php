<?php

// add widgets
include_files_in_dir("/../../widgets/", false);

function dt_widgets_init() {

	if( function_exists('of_get_option') ) {
        $option = apply_filters( 'dt_setup_widgets_field', 'of_generatortest2' );
        $w_areas = apply_filters( 'dt_setup_widgets_sidebars_list', of_get_option($option, false) );
        $w_params_def = array(
            'before_widget' => '<div class="widget-t"></div><div class="widget">',
			'after_widget' 	=> '</div><div class="widget-b"></div>',
			'before_title' 	=> '<div class="header">',
			'after_title'	=> '</div>'
        );
        $w_params = apply_filters( 'dt_setup_widgets_params', $w_params_def );

		if( is_array($w_areas) ) {
			
			$prefix = 'sidebar_';
			
            foreach( $w_areas as $index=>$sidebar ) {
//                $w_params = apply_filters( 'dt_setup_widgets_params_' . $prefix . $index, $w_params_def );
//                $w_params = wp_parse_args( $w_params, $w_params_def );

				register_sidebar( array(
					'name' 			=> $sidebar['sidebar_name'],
					'id' 			=> $prefix . $index,
					'description' 	=> sprintf('%1$s', $sidebar['sidebar_desc'], $prefix . $index),
					'before_widget' => $w_params['before_widget'],
					'after_widget' 	=> $w_params['after_widget'],
					'before_title' 	=> $w_params['before_title'],
					'after_title'	=> $w_params['after_title'] 
				) );
			}
		
		}
	}
    
}
add_action( 'widgets_init', 'dt_widgets_init' );
