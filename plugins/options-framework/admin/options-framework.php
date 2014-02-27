<?php
/*
Plugin Name: Options Framework
Plugin URI: http://www.wptheming.com
Description: A framework for building theme options.
Version: 0.8
Author: Devin Price
Author URI: http://www.wptheming.com
License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

/* Basic plugin definitions */

define('OPTIONS_FRAMEWORK_VERSION', '0.8');

/* Make sure we don't expose any info if called directly */

if ( !function_exists( 'add_action' ) ) {
	echo "Hi there!  I'm just a little plugin, don't mind me.";
	exit;
}

/* If the user can't edit theme options, no use running this plugin */

add_action('init', 'optionsframework_rolescheck' );

/* Load options */
function optionsframework_load_options() {
    // Loads the options array from the theme
	if ( $optionsfile = locate_template( array('functions/options/options.php') ) ) {
        require_once($optionsfile);
	}
	else if (file_exists( dirname( __FILE__ ) . '/options.php' ) ) {
		require_once dirname( __FILE__ ) . '/options.php';
	}
}

function optionsframework_rolescheck () {
	
	if ( current_user_can( 'edit_theme_options') ) {
		// If the user can edit theme options, let the fun begin!
		add_action( 'admin_menu', 'optionsframework_add_page');
		add_action( 'admin_init', 'optionsframework_init' );
		add_action( 'admin_init', 'optionsframework_mlu_init' );
        
        optionsframework_load_options();
	}
}


/* Loads the file for option sanitization */

add_action('init', 'optionsframework_load_sanitization' );

function optionsframework_load_sanitization() {
	require_once dirname( __FILE__ ) . '/options-sanitize.php';
}

/* 
 * Creates the settings in the database by looping through the array
 * we supplied in options.php.  This is a neat way to do it since
 * we won't have to save settings for headers, descriptions, or arguments.
 *
 * Read more about the Settings API in the WordPress codex:
 * http://codex.wordpress.org/Settings_API
 *
 */

function optionsframework_init() {

	// Include the required files
	require_once dirname( __FILE__ ) . '/options-interface.php';
	require_once dirname( __FILE__ ) . '/options-medialibrary-uploader.php';
    
	// Updates the unique option id in the database if it has changed
	optionsframework_option_name();
	
	$optionsframework_settings = get_option('optionsframework' );
	
	// Gets the unique id, returning a default if it isn't defined
	if ( isset($optionsframework_settings['id']) ) {
		$option_name = $optionsframework_settings['id'];
	}
	else {
		$option_name = 'optionsframework';
	}
	
	// If the option has no saved data, load the defaults
	if ( ! get_option($option_name) ) {
		optionsframework_setdefaults();
	}
	
	// Registers the settings fields and callback
	register_setting( 'optionsframework', $option_name, 'optionsframework_validate' );
}

/* 
 * Adds default options to the database if they aren't already present.
 * May update this later to load only on plugin activation, or theme
 * activation since most people won't be editing the options.php
 * on a regular basis.
 *
 * http://codex.wordpress.org/Function_Reference/add_option
 *
 */

function optionsframework_setdefaults() {
	
	$optionsframework_settings = get_option('optionsframework');

	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];
	
	/* 
	 * Each theme will hopefully have a unique id, and all of its options saved
	 * as a separate option set.  We need to track all of these option sets so
	 * it can be easily deleted if someone wishes to remove the plugin and
	 * its associated data.  No need to clutter the database.  
	 *
	 */
	
	if ( isset($optionsframework_settings['knownoptions']) ) {
		$knownoptions =  $optionsframework_settings['knownoptions'];
		if ( !in_array($option_name, $knownoptions) ) {
			array_push( $knownoptions, $option_name );
			$optionsframework_settings['knownoptions'] = $knownoptions;
			update_option('optionsframework', $optionsframework_settings);
		}
	} else {
		$newoptionname = array($option_name);
		$optionsframework_settings['knownoptions'] = $newoptionname;
		update_option('optionsframework', $optionsframework_settings);
	}
	
	// Gets the default options data from the array in options.php
	$options = optionsframework_options();
	
	// If the options haven't been added to the database yet, they are added now
	$values = of_get_default_values();
	
	if ( isset($values) ) {
		add_option( $option_name, $values ); // Add option with default settings
	}
}

function optionsframework_buffer( $data = null ) {
    static $buffer = null;
    if( $data ) {
        $buffer = $data;
    }
    return $buffer;
}

/* Add a subpage called "Theme Options" to the appearance menu. */

if ( !function_exists( 'optionsframework_add_page' ) ) {
    function optionsframework_add_page() {
        //optionsframework_load_options();
        
        $options_arr = optionsframework_options();
        $subpages = array_filter($options_arr, 'optionsframework_options_page_filter');
        
        $main_page = add_menu_page('皮肤', '主题选项', 'edit_theme_options', 'options-framework', 'optionsframework_page');
        
        // Adds actions to hook in the required css and javascript
        add_action("admin_print_styles-$main_page",'optionsframework_load_styles');
        add_action("admin_print_scripts-$main_page", 'optionsframework_load_scripts');
		add_action( "admin_print_styles-$main_page", 'optionsframework_mlu_css', 0 );
		add_action( "admin_print_scripts-$main_page", 'optionsframework_mlu_js', 0 );
      
        foreach( $subpages as $subpage ) {
            $sp = add_submenu_page(
                'options-framework',
                $subpage['page_title'],
                $subpage['menu_title'],
                'edit_theme_options',
                $subpage['menu_slug'],
                'optionsframework_page'
            );
            
            // Adds actions to hook in the required css and javascript
            add_action("admin_print_styles-$sp",'optionsframework_load_styles');
            add_action("admin_print_scripts-$sp", 'optionsframework_load_scripts');
			add_action( "admin_print_styles-$sp", 'optionsframework_mlu_css', 0 );
			add_action( "admin_print_scripts-$sp", 'optionsframework_mlu_js', 0 );
        
        }

        /* change menu name for main page */
        global $submenu;
        if( isset($submenu['options-framework']) ) {
            $submenu['options-framework'][0][0] = '皮肤';
        }

    }
}

/* Loads the CSS */

function optionsframework_load_styles() {
	wp_enqueue_style('admin-style', OPTIONS_FRAMEWORK_DIRECTORY.'css/admin-style.css');
	wp_enqueue_style('color-picker', OPTIONS_FRAMEWORK_DIRECTORY.'css/colorpicker.css');
	wp_enqueue_style('of-jquery-ui-slider', OPTIONS_FRAMEWORK_DIRECTORY.'css/jquery-ui.css');
}	

/* Loads the javascript */

function optionsframework_load_scripts() {

	// Inline scripts from options-interface.php
	add_action('admin_head', 'of_admin_head');
	
	// Enqueued scripts
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-dialog');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('jquery-ui-widget');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('color-picker', OPTIONS_FRAMEWORK_DIRECTORY.'js/colorpicker.js', array('jquery'));
	wp_enqueue_script('options-custom', OPTIONS_FRAMEWORK_DIRECTORY.'js/options-custom.js', array('jquery'));
}

function of_admin_head() {

	// Hook to add custom scripts
	do_action( 'optionsframework_custom_scripts' );
}

/* 
 * Builds out the options panel.
 *
 * If we were using the Settings API as it was likely intended we would use
 * do_settings_sections here.  But as we don't want the settings wrapped in a table,
 * we'll call our own custom optionsframework_fields.  See options-interface.php
 * for specifics on how each individual field is generated.
 *
 * Nonces are provided using the settings_fields()
 *
 */

if ( !function_exists( 'optionsframework_page' ) ) {
function optionsframework_page() {
	$return = optionsframework_fields();
	settings_errors();
	?>
    
	<div class="wrap">
    <?php screen_icon( 'themes' ); ?>
    <h2 class="nav-tab-wrapper">
        <?php echo $return[1]; ?>
    </h2>
    
    <div class="metabox-holder">
    <div id="optionsframework" class="postbox">
		<form action="options.php" method="post">
		<?php settings_fields('optionsframework'); ?>

		<?php echo $return[0]; /* Settings */ ?>
        
        <div id="optionsframework-submit">
			<input type="submit" class="button-primary" name="update" value="<?php esc_attr_e( '保存设置', 'opt_framework' ); ?>" />
            <input type="submit" class="reset-button button-secondary" name="reset" value="<?php esc_attr_e( '恢复默认', 'opt_framework' ); ?>" onclick="return confirm( '<?php print esc_js( __( 'Click OK to reset. Any theme settings will be lost!', 'opt_framework' ) ); ?>' );" />
            <div class="clear"></div>
		</div>
	</form>
</div> <!-- / #container -->
</div>
</div> <!-- / .wrap -->

<?php
}
}

/** 
 * Validate Options.
 *
 * This runs after the submit/reset button has been clicked and
 * validates the inputs.
 *
 * @uses $_POST['reset']
 * @uses $_POST['update']
 */
function optionsframework_validate( $input ) {

	/*
	 * Restore Defaults.
	 *
	 * In the event that the user clicked the "Restore Defaults"
	 * button, the options defined in the theme's options.php
	 * file will be added to the option for the active theme.
	 */
	 
	if ( isset( $_POST['reset'] ) ) {
		add_settings_error( 'options-framework', 'restore_defaults', __( 'Default options restored.', 'optionsframework' ), 'updated fade' );
        $current = null;
        if( isset($_POST['_wp_http_referer']) ) {
            $arr = array();
            wp_parse_str($_POST['_wp_http_referer'], $arr);
            $current = current($arr);
        }
        return of_get_default_values( $current );
	}

	/*
	 * Udpdate Settings.
	 */
	 
	if ( isset( $_POST['update'] ) ) {

		$clean = array();
		$options_orig = optionsframework_options();
        $options = array_filter($options_orig, 'optionsframework_options_for_page_filter');
         
		foreach ( $options as $option ) {

			if ( ! isset( $option['id'] ) ) {
				continue;
			}

			if ( ! isset( $option['type'] ) ) {
				continue;
			}

			$sanitize = isset($option['sanitize'])?$option['sanitize']:true;
			
			$id = preg_replace( '/(\W!-)/', '', strtolower( $option['id'] ) );
            
			// Set checkbox to false if it wasn't sent in the $_POST
			if ( 'checkbox' == $option['type'] && ! isset( $input[$id] ) ) {
				$input[$id] = '0';
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST
			if ( 'multicheck' == $option['type'] && ! isset( $input[$id] ) ) {
				foreach ( $option['options'] as $key => $value ) {
					$input[$id][$key] = '0';
				}
			}
            
            if( ! isset($input[$id]) ) {
                continue;
            }
             
			// For a value to be submitted to database it must pass through a sanitization filter
            if( !has_filter( 'of_sanitize_' . $option['type']) ) {
                continue;
            }


			if( $sanitize ) {
				$clean[$id] = apply_filters( 'of_sanitize_' . $option['type'], $input[$id], $option );
			}else {
				$clean[$id] = $input[$id];
			}
		}
        unset( $option );
        
		$known_options = get_option('optionsframework', array());
        $saved_options = get_option($known_options['id'], array());

        if( isset($clean['of-preset']) ) {
            $preserve = array(
                'of_generatortest2',
                'social_icons',
                'appearance-favicon',
                'appearance-copyrights',
                'appearance-dt_credits',
                'misc-show_header_contacts',
                'misc-contact_address',
                'misc-contact_phone',
                'misc-contact_email',
                'misc-contact_skype',
                'misc-parent_menu_clickable',
                'misc-analitics_code'
            );
			
			$preset_options = optionsframework_presets_data($clean['of-preset']);

            foreach( $preserve as $pres ) {
                if( isset($preset_options[$pres]) )
                    unset( $preset_options[$pres] );
            }
			
            $saved_options = array_merge( $saved_options, $preset_options );
        }

        $clean = array_merge($saved_options, $clean);
/*      
        echo '<pre>';        
        var_export( $clean );
        echo '</pre>';        
*/
		add_settings_error( 'options-framework', 'save_options', __( 'Options saved.', 'optionsframework' ), 'updated fade' );
		return $clean;
	}

	/*
	 * Request Not Recognized.
	 */
	
	return of_get_default_values();
}

/**
 * Format Configuration Array.
 *
 * Get an array of all default values as set in
 * options.php. The 'id','std' and 'type' keys need
 * to be defined in the configuration array. In the
 * event that these keys are not present the option
 * will not be included in this function's output.
 *
 * @return    array     Rey-keyed options configuration array.
 *
 * @access    private
 */
 
function of_get_default_values( $page = null ) {
	$output = $defaults_preset = $saved_options = array();
	$config = optionsframework_options();
    $known_options = get_option('optionsframework', array());
    $tmp_options = get_option($known_options['id'], array());
    
    if( empty($tmp_options) )
        $tmp_options['of-preset'] = 'origami';

    if( isset($tmp_options['of-preset']) ) {
        $defaults_preset = optionsframework_presets_data($tmp_options['of-preset']);
    }

    if( $page ) {
        $arr = array();
        $found = null;
        foreach($config as $option) {
            if( 'options-framework' == $page && (null === $found) ) {
                $found = true;
            }elseif( isset($option['type']) && 'page' == $option['type'] && $option['menu_slug'] == $page ) {
                $found = true;
                continue;
            }elseif( isset($option['type']) && 'page' == $option['type'] ) {
                $found = false;
            }
            
            if( $found ) {
                $arr[] = $option;
            }
        }
        $config = $arr;
        $saved_options = $tmp_options;
    }

	foreach ( (array) $config as $option ) {
		if ( ! isset( $option['id'] ) ) {
			continue;
		}
		if ( ! isset( $option['std'] ) ) {
			continue;
		}
		if ( ! isset( $option['type'] ) ) {
			continue;
		}
		if ( has_filter( 'of_sanitize_' . $option['type'] ) ) {
            $value = $option['std'];
            if( isset($defaults_preset[$option['id']]) ) {
                $value = $defaults_preset[$option['id']];
            }
			$output[$option['id']] = apply_filters( 'of_sanitize_' . $option['type'], $value, $option );
		}
	}
    $output = array_merge($saved_options, $output);
    
	return $output;
}

/**
 * Add Theme Options menu item to Admin Bar.
 */
 
add_action( 'wp_before_admin_bar_render', 'optionsframework_adminbar' );

function optionsframework_adminbar() {
	
	global $wp_admin_bar;
	
	$wp_admin_bar->add_menu( array(
		'parent'    => 'appearance',
		'id'        => 'of_theme_options',
		'title'     => __( 'Theme options', 'opt_framework' ),
		'href'      => admin_url( 'admin.php?page=options-framework' )
  ));
}


if ( ! function_exists( 'of_get_option' ) ) {

	/**
	 * Get Option.
	 *
	 * Helper function to return the theme option value.
	 * If no value has been saved, it returns $default.
	 * Needed because options are saved as serialized strings.
	 */
	 
	function of_get_option( $name, $default = false ) {
		$config = get_option( 'optionsframework' );

		if ( ! isset( $config['id'] ) ) {
			return $default;
		}

		// for demo stand in production you may wish delete
		if( function_exists( 'dt_get_demo_presets' ) ){
			if( ( $option = dt_get_demo_presets( $name ) ) !== false ){
				return $option;
			}
		}

		$options = get_option( $config['id'] );

		if ( isset( $options[$name] ) ) {
			return $options[$name];
		}

		return $default;
	}
}
