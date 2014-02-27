<?php

/**
 * Generates the options fields that are used in the form.
 */

function optionsframework_fields() {

	global $allowedtags;
	$optionsframework_settings = get_option('optionsframework');
	
	// Get the theme name so we can display it up top
    $wp_ver = explode('.', get_bloginfo('version'));
    $wp_ver = array_map( 'intval', $wp_ver );
    
    if( $wp_ver[0] < 3 || ( 3 == $wp_ver[0] && $wp_ver[1] <= 3 ) ) {
        $themename = get_theme_data(STYLESHEETPATH . '/style.css');
        $themename = $themename['Name'];
        
    }else {
        $themename = wp_get_theme();
        $themename = $themename->name;
    }

	// Gets the unique option id
	if (isset($optionsframework_settings['id'])) {
		$option_name = $optionsframework_settings['id'];
	}
	else {
		$option_name = 'optionsframework';
	};

	$settings = get_option($option_name);
    
    $options = optionsframework_options();
    // filter options for current page
    $options = array_filter($options, 'optionsframework_options_for_page_filter');
    
    $counter = 0;
	$menu = '';
	$output = '';
	
	foreach ($options as $value) {
	   
		$counter++;
		$val = '';
		$select_value = '';
		$checked = '';
		
		// Wrap all options
		if( ($value['type'] != "block_begin") &&
            ($value['type'] != "block_end") &&
            ($value['type'] != "heading") &&
            ($value['type'] != "info") &&
            ($value['type'] != "page") &&
            ($value['type'] != 'js_hide_begin') && 
            ($value['type'] != 'js_hide_end') ) {

			// Keep all ids lowercase with no spaces
			$value['id'] = preg_replace('/(\W!-)/', '', strtolower($value['id']) );

			$id = 'section-' . $value['id'];

			$class = 'section ';
			if ( isset( $value['type'] ) ) {
				$class .= ' section-' . $value['type'];
			}
			if ( isset( $value['class'] ) ) {
				$class .= ' ' . $value['class'];
			}

			$output .= '<div id="' . esc_attr( $id ) .'" class="' . esc_attr( $class ) . '">'."\n";
            if( isset( $value['name'] ) ) {
			    $output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";		
            }    
            $output .= '<div class="option">' . "\n";

			$explain_value = '';
			if ( isset( $value['desc'] ) ) {
				$explain_value = $value['desc'];
			}
			$output .= '<div class="explain">' . wp_kses( $explain_value, $allowedtags) . '</div>'."\n";

            $output .= '<div class="controls">' . "\n";
		 }
		
		// Set default value to $val
		if ( isset( $value['std']) ) {
			$val = $value['std'];
		}
		
		// If the option is already saved, ovveride $val
		if ( ($value['type'] != 'heading') && ($value['type'] != 'info') && ($value['type'] != 'page') ) {
			if ( isset($value['id']) && isset($settings[($value['id'])]) ) {
					$val = $settings[($value['id'])];
					// Striping slashes of non-array options
					if (!is_array($val)) {
						$val = stripslashes($val);
					}
			}
		}
		                                
		switch ( $value['type'] ) {
		
		// Basic text input
		case 'text':
			$maxlength = isset( $value['maxlength'] )?' maxlength="' .$value['maxlength']. '"':'';
			$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '"' .$maxlength. ' />';
		break;

		// Textarea
		case 'textarea':
			$cols = '8';
			$ta_value = '';
			
			if(isset($value['options'])){
				$ta_options = $value['options'];
				if(isset($ta_options['cols'])){
					$cols = $ta_options['cols'];
				} else { $cols = '8'; }
			}
			
			$val = stripslashes( $val );
			
			$output .= '<textarea id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" cols="'. esc_attr( $cols ) . '" rows="8">' . esc_textarea( $val ) . '</textarea>';
		break;
		
		// Select Box
		case 'select':
			$output .= '<select class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';
			
			foreach ($value['options'] as $key => $option ) {
				$selected = '';
				 if( $val != '' ) {
					 if ( $val == $key) { $selected = ' selected="selected"';} 
			     }
				 $output .= '<option'. $selected .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
			 } 
			 $output .= '</select>';
		break;

		
		// Radio Box
		case "radio":
			$name = $option_name .'['. $value['id'] .']';
			foreach ($value['options'] as $key => $option) {
				$id = $option_name . '-' . $value['id'] .'-'. $key;
				$output .= '<input class="of-input of-radio" type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="'. esc_attr( $key ) . '" '. checked( $val, $key, false) .' /><label for="' . esc_attr( $id ) . '">' . esc_html( $option ) . '</label>';
			}
		break;
		
		// Image Selectors
		case "images":
			$name = $option_name .'['. $value['id'] .']';
            $dir = get_template_directory_uri();
			foreach ( $value['options'] as $key => $option ) {
				$selected = '';
				$checked = '';
				if ( $val != '' ) {
					if ( $val == $key ) {
						$selected = ' of-radio-img-selected';
						$checked = ' checked="checked"';
					}
                }

                $img = $dir . $option;

				$output .= '<input type="radio" id="' . esc_attr( $value['id'] .'_'. $key) . '" class="of-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" '. $checked .' />';
				$output .= '<div class="of-radio-img-label">' . esc_html( $key ) . '</div>';
				$output .= '<img src="' . esc_url( $img ) . '" alt="' . $option .'" class="of-radio-img-img' . $selected .'" onclick="document.getElementById(\''. esc_attr($value['id'] .'_'. $key) .'\').checked=true;" />';
			}
		break;
		
		// Checkbox
		case "checkbox":
            $classes = array();
            $classes[] = 'checkbox';
            $classes[] = 'of-input';
            if( isset($value['options']['java_hide']) && $value['options']['java_hide'] ) {
                $classes[] = 'of-js-hider';
            }
            $classes = implode(' ', $classes);

			$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="' . $classes . '" type="checkbox" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" '. checked( $val, 1, false) .' />';
		break;
		
		// Multicheck
		case "multicheck":
			foreach ($value['options'] as $key => $option) {
				$checked = '';
				$label = $option;
				$option = preg_replace('/\W/', '', strtolower($key));

				$id = $option_name . '-' . $value['id'] . '-'. $option;
				$name = $option_name . '[' . $value['id'] . '][' . $option .']';

			    if ( isset($val[$option]) ) {
					$checked = checked($val[$option], 1, false);
				}

				$output .= '<input id="' . esc_attr( $id ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $name ) . '" ' . $checked . ' /><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
			}
		break;
		
		// Color picker
		case "color":
			$output .= '<div id="' . esc_attr( $value['id'] . '_picker' ) . '" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $val ) . '"></div></div>';
			$output .= '<input class="of-color" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '" type="text" value="' . esc_attr( $val ) . '" />';
		break; 
		
		// Uploader
		case "upload":
			$output .= optionsframework_medialibrary_uploader( $value['id'], $val, null ); // New AJAX Uploader using Media Library	
		break;
		
		// Typography
		case 'typography':	
		
			$typography_stored = $val;
			
			// Font Size
			$output .= '<select class="of-typography of-typography-size" name="' . esc_attr( $option_name . '[' . $value['id'] . '][size]' ) . '" id="' . esc_attr( $value['id'] . '_size' ) . '">';
			for ($i = 9; $i < 71; $i++) { 
				$size = $i . 'px';
				$output .= '<option value="' . esc_attr( $size ) . '" ' . selected( $typography_stored['size'], $size, false ) . '>' . esc_html( $size ) . '</option>';
			}
			$output .= '</select>';
		
			// Font Face
			$output .= '<select class="of-typography of-typography-face" name="' . esc_attr( $option_name . '[' . $value['id'] . '][face]' ) . '" id="' . esc_attr( $value['id'] . '_face' ) . '">';
			
			$faces = of_recognized_font_faces();
			foreach ( $faces as $key => $face ) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['face'], $key, false ) . '>' . esc_html( $face ) . '</option>';
			}			
			
			$output .= '</select>';	

			// Font Weight
			$output .= '<select class="of-typography of-typography-style" name="'.$option_name.'['.$value['id'].'][style]" id="'. $value['id'].'_style">';

			/* Font Style */
			$styles = of_recognized_font_styles();
			foreach ( $styles as $key => $style ) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['style'], $key, false ) . '>'. $style .'</option>';
			}
			$output .= '</select>';

			// Font Color		
			$output .= '<div id="' . esc_attr( $value['id'] ) . '_color_picker" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $typography_stored['color'] ) . '"></div></div>';
			$output .= '<input class="of-color of-typography of-typography-color" name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" type="text" value="' . esc_attr( $typography_stored['color'] ) . '" />';

		break;
		
		// Background
		case 'background':
			
			$background = $val;
			
			// Background Color		
			$output .= '<div id="' . esc_attr( $value['id'] ) . '_color_picker" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $background['color'] ) . '"></div></div>';
			$output .= '<input class="of-color of-background of-background-color" name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" type="text" value="' . esc_attr( $background['color'] ) . '" />';
			
			// Background Image - New AJAX Uploader using Media Library
			if (!isset($background['image'])) {
				$background['image'] = '';
			}
			
			$output .= optionsframework_medialibrary_uploader( $value['id'], $background['image'], null, '',0,'image');
			$class = 'of-background-properties';
			if ( '' == $background['image'] ) {
				$class .= ' hide';
			}
			$output .= '<div class="' . esc_attr( $class ) . '">';
			
			// Background Repeat
			$output .= '<select class="of-background of-background-repeat" name="' . esc_attr( $option_name . '[' . $value['id'] . '][repeat]'  ) . '" id="' . esc_attr( $value['id'] . '_repeat' ) . '">';
			$repeats = of_recognized_background_repeat();
			
			foreach ($repeats as $key => $repeat) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['repeat'], $key, false ) . '>'. esc_html( $repeat ) . '</option>';
			}
			$output .= '</select>';
			
			// Background Position
			$output .= '<select class="of-background of-background-position" name="' . esc_attr( $option_name . '[' . $value['id'] . '][position]' ) . '" id="' . esc_attr( $value['id'] . '_position' ) . '">';
			$positions = of_recognized_background_position();
			
			foreach ($positions as $key=>$position) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['position'], $key, false ) . '>'. esc_html( $position ) . '</option>';
			}
			$output .= '</select>';
			
			// Background Attachment
			$output .= '<select class="of-background of-background-attachment" name="' . esc_attr( $option_name . '[' . $value['id'] . '][attachment]' ) . '" id="' . esc_attr( $value['id'] . '_attachment' ) . '">';
			$attachments = of_recognized_background_attachment();
			
			foreach ($attachments as $key => $attachment) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['attachment'], $key, false ) . '>' . esc_html( $attachment ) . '</option>';
			}
			$output .= '</select>';
			$output .= '</div>';
		
		break;  
		
		// Info
		case "info":
			$class = 'section';
			if ( isset( $value['type'] ) ) {
				$class .= ' section-' . $value['type'];
			}
			if ( isset( $value['class'] ) ) {
				$class .= ' ' . $value['class'];
			}

			$output .= '<div class="' . esc_attr( $class ) . '">' . "\n";
			if ( isset($value['name']) ) {
				$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
			}
			if ( $value['desc'] ) {
				$output .= apply_filters('of_sanitize_info', $value['desc'] ) . "\n";
			}
			$output .= '<div class="clear"></div></div>' . "\n";
		break;

		// Block begin
		case "block_begin":
			$class = 'section';
			$id = '';
			if ( isset( $value['type'] ) ) {
				$class .= ' section-' . $value['type'];
			}
			if ( isset( $value['class'] ) ) {
				$class .= ' ' . $value['class'];
			}
			if( isset( $value['id'] ) ){
				$id .= ' id="' . esc_attr($value['id']) . '"'; 
			}
			$output .= '<div' .$id. ' class="widgets-sortables ' . esc_attr( $class ) . '">'."\n";
			if( isset($value['name']) && !empty($value['name']) ){
				$output .= '<div class="sidebar-name"><h3>' . esc_html( $value['name'] ) . '</h3></div>' . "\n";
			}
		break;
		
		
		// Block End
		case "block_end": 
			$output .= '</div>'."\n".'<!-- block_end -->'; 
		break;
		
		// Heading for Navigation
		case "heading":
			if($counter >= 2){
			   $output .= '</div>'."\n";
			}
			$jquery_click_hook = preg_replace('/\W/', '', strtolower($value['name']) );
			$jquery_click_hook = "of-option-" . $jquery_click_hook;
			$menu .= '<a id="'.  esc_attr( $jquery_click_hook ) . '-tab" class="nav-tab" title="' . esc_attr( $value['name'] ) . '" href="' . esc_attr( '#'.  $jquery_click_hook ) . '">' . esc_html( $value['name'] ) . '</a>';
			$output .= '<div class="group" id="' . esc_attr( $jquery_click_hook ) . '">';
			//$output .= '<h3>' . esc_html( $value['name'] ) . '</h3>' . "\n";
		break;
            
        case "page":
            
        break;

        case "button":
			$output .= '<input type="button" id="' . esc_attr( $value['id'] ) . '" class="button" name="' . esc_attr( $option_name . '[' . $value['id']. ']' ). '" value="'. esc_attr($value['options']['title']). '">';
            break;    
            
        // fields generator
        case "fields_generator":
		    	
            if( !isset($value['options']['fields']) || !is_array($value['options']['fields']) ) {
                break;
            }

            $del_link = '<div class="submitbox"><a href="#" class="of_fields_gen_del submitdelete">Delete</a></div>';
            
            $output .= '<ul class="of_fields_gen_list">';
            
            // сохраненные элементы
            if( is_array($val) ) {
                
                $i = 0;
                // создаем элементы  
                foreach( $val as $index=>$field ) {
                    
                    $block = $b_title = '';
                    // используем шаблон
                    foreach( $value['options']['fields'] as $name => $data ) {
                        
                        // checked если поле присутствует в записи, если нет поля value в шаблоне
                        // или если оно есть и равно значению поля в записи
                        $checked = false;
                        if( isset($field[$name]) &&
                            (!isset($data['value']) || 
                            (isset($data['value']) && $data['value'] == $field[$name])) ) {
                            $checked = true;
                        }
                        
                        // получаем тайтл
                        if( isset($data['class']) && 'of_fields_gen_title' == $data['class'] ) {
                            $b_title = $field[$name];
                        }
                        
                        $el_args = array(
                            'name'          => sprintf('%s[%s][%d][%s]',
                                $option_name,
                                $value['id'],
                                $index,
                                $name
                            ),
                            'description'   => isset($data['description'])?$data['description']:'',
                            'class'         => isset($data['class'])?$data['class']:'',
                            'value'         => ('checkbox' == $data['type'])?'':$field[$name],
                            'checked'       => $checked
                        );
                        
                        if( isset($data['desc_wrap']) ) {
                            $el_args['desc_wrap'] = $data['desc_wrap'];
                        }
                        
                        if( isset($data['wrap']) ) {
                            $el_args['wrap'] = $data['wrap'];
                        }
                        
                        if( isset($data['style']) ) {
                            $el_args['style'] = $data['style'];
                        }
                        
                        // создаем элемент формы
                        $element = dt_melement( $data['type'], $el_args);
                        
                        $block .= $element;
                    }
                    unset($data);
                    
                    $output .= '<li class="nav-menus-php">';
                    
                    $output .= '<div class="of_fields_gen_title menu-item-handle" data-index="' . $index . '">' . esc_attr($b_title);
                    $output .= '<span class="item-controls"><a title="Edit Widgetized Area" class="item-edit"></a></span></div>';
                    $output .= '<div class="of_fields_gen_data menu-item-settings description" style="display: none;">' . $block;
                    if( $index > 7 ){
                        $output .= $del_link;
                    }
                    $output .= '</div>';
                    $output .= '</li>';
                    
                    $i++;
                }
                unset($field);
                
            }
                        
            $output .= '</ul>';
            
            // панел управления
            $output .= '<div class="of_fields_gen_controls">';
            
            // используем шаблон
            foreach( $value['options']['fields'] as $name => $data ) {
                $el_args = array(
                    'name'          => sprintf('%s[%s][%s]',
                        $option_name,
                        $value['id'],
                        $name
                    ),
                    'description'   => isset($data['description'])?$data['description']:'',
                    'class'         => isset($data['class'])?$data['class']:'',
                    'checked'       => isset($data['checked'])?$data['checked']:false
                );
                
                if( isset($data['desc_wrap']) ) {
                    $el_args['desc_wrap'] = $data['desc_wrap'];
                }
                
                if( isset($data['wrap']) ) {
                    $el_args['wrap'] = $data['wrap'];
                }
                
                if( isset($data['style']) ) {
                    $el_args['style'] = $data['style'];
                }
                
                if( isset($data['value']) ) {
                    $el_args['value'] = $data['value'];
                }
                
                // создаем элемент формы
                $element = dt_melement( $data['type'], $el_args);
                
                $output .= $element;
            }
            unset($data);
            
            // добавляем кнопочку
            $button = dt_melement( 'button', array(
                'name'  => $option_name. '[' . $value['id'] . '][add]',
                'title' => isset($value['options']['button']['title'])?$value['options']['button']['title']:'Add',
                'class' => 'of_fields_gen_add'
            ));
            
            $output .= $button;
            
            $output .= '</div>';
            
        break;
		
        // Social icons 
		case 'social_icon':

            if( !isset($value['options']['fields']) || !is_array($value['options']['fields']) ) {
                continue;
            }
            
            $w = $h = '20';
            if( !empty($value['options']['ico_width']) ) {
                $w = intval($value['options']['ico_width']);
            }
            if( !empty($value['options']['ico_height']) ) {
                $h = intval($value['options']['ico_height']);
            }
            $ico_size = sprintf( 'width: %dpx;height: %dpx;', $w, $h );

            foreach( $value['options']['fields'] as $src=>$desc ) {
                $clear_desc = strtolower(str_replace(' ', '', $desc));
                $name = sprintf( '%s[%s][%s]', $option_name, $value['id'], $clear_desc );
                $soc_link = ( isset($val[$clear_desc]) && isset($val[$clear_desc]['link']) )?$val[$clear_desc]['link']:'';

                $output .= '<div class="of-soc-image" style="background: url( ' . esc_attr( get_template_directory_uri() . $src ) . ' ) no-repeat 0 0; vertical-align: middle; margin-right: 5px; display: inline-block;' . $ico_size . '" title="' . esc_attr($desc) . '"></div>';

			    $maxlength = isset( $value['maxlength'] )?' maxlength="' .$value['maxlength']. '"':'';
			    $output .= '<input class="of-input" name="' . esc_attr( $name .'[link]' ) . '" type="text" value="' . esc_attr( $soc_link ) . '"' .$maxlength. ' style="display: inline-block; width: 300px; vertical-align: middle;" />';

			    $output .= '<input name="' . esc_attr( $name . '[src]' ) . '" type="hidden" value="' . esc_attr( $src ) . '" /> <br>';
            }

		break;

        case 'slider':

            $output .= '<div class="of-slider"></div>';

            $slider_opts = array(
                'max'   => isset($value['options']['max'])?$value['options']['max']:100,
                'min'   => isset($value['options']['min'])?$value['options']['min']:0,
                'step'  => isset($value['options']['step'])?$value['options']['step']:1,
                'value' => isset($val)?$val:0
            );
            $str = '';
            foreach( $slider_opts as $name=>$val ) {
                $str .= ' data-' . $name . '="' . esc_attr($val) . '"';
            }
            
            $output .= '<input type="text" class="of-slider-value"' . $str . ' name="' . esc_attr($option_name . '[' . $value['id'] . ']') . '" readonly />';

		    break;

        case 'js_hide_begin':
            $output .= '<div class="of-element of-js-hide hide-if-js">';
            break;

        case 'js_hide_end':
            $output .= '</div>';
            break;
        }

		if( ( $value['type'] != "block_begin" ) &&
            ( $value['type'] != "block_end" ) &&
            ( $value['type'] != "heading" ) &&
            ( $value['type'] != "info" ) &&
            ( $value['type'] != "page" ) &&
            ( $value['type'] != 'js_hide_begin' ) && 
            ( $value['type'] != 'js_hide_end' ) ) {
			
            if ( $value['type'] != "checkbox" ) {
				$output .= '<br/>';
			}
/*
			$explain_value = '';
			if ( isset( $value['desc'] ) ) {
				$explain_value = $value['desc'];
			}
			$output .= '</div><div class="explain">' . wp_kses( $explain_value, $allowedtags) . '</div>'."\n";
 */
            $output .= '</div>' . "\n";
			$output .= '<div class="clear"></div></div></div>'."\n";
		
        }
        
        
	}
    $output .= '</div>';
    return array($output,$menu);
}
