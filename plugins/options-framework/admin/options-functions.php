<?php
// function that get array of cufon fonts
function dt_get_fonts_in( $dir = 'fonts' ){
    $res = array();
    $dirname = dirname(__FILE__). '/../../../' .$dir;
    if ($handle = opendir( $dirname ) ) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                $f_name = preg_split( '/\.[^.]+$/', $file );
                $f_name = str_replace( array('_', '.font'), array(' ', ''), ucfirst(strtolower($f_name[0])) );
                $res['/' . $dir . '/' .$file] = $f_name;
            }
        }
        closedir($handle);
    }
    if( empty($res) ){
        $res['none'] = __( 'no fonts', 'dt-options-fonts_select');
    }
    return $res;
}

// get images for options framework
function dt_get_images_in( $dir = '', $one_img_dir = '' ){
//    $noimage = get_stylesheet_directory_uri(). '/images/noimage_small.jpg';
    $noimage = '/images/noimage_small.jpg';
    $basedir = dirname(__FILE__). '/../../../';
    $dirname = $basedir .$dir;
    $res = $full_dir = $thumbs_dir = array();
    $res['none'] = $noimage;
    
    // full dir
    if ( file_exists($dirname. '/full') && $handle = opendir( $dirname. '/full') ) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != 'Thumb.db' && $file != 'Thumbs.db' && $file !='.DS_Store' && preg_match('/[.jpeg|.jpg|.png|.gif]$/', $file)) {
                $f_name = preg_split( '/\.[^.]+$/', $file );
                $full_dir[$f_name[0]] = $file;
            }
        }
        closedir($handle);
    }
    unset($file);
    
    // thumbs dir
    if ( file_exists($dirname. '/thumbs') && $handle = opendir( $dirname. '/thumbs') ) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != 'Thumb.db' && $file != 'Thumbs.db') {
                $f_name = preg_split( '/\.[^.]+$/', $file );
                $thumbs_dir[$f_name[0]] = $file;
            }
        }
        closedir($handle);
    }
    unset($file);
    asort($full_dir);
    
    foreach( $full_dir as $name=>$file ){
//        $full_link = get_stylesheet_directory_uri() . '/' . $dir . '/full/' . $file;
        $full_link = '/' . $dir . '/full/' . $file;
        if( array_key_exists( $name, $thumbs_dir ) ){
//            $thumb_link = get_stylesheet_directory_uri() . '/' . $dir . '/thumbs/' . $thumbs_dir[$name];
            $thumb_link = '/' . $dir . '/thumbs/' . $thumbs_dir[$name];
        }else {
            $one_img = explode('_', $name);
            if( $one_img[0] != $name && $one_img_dir && file_exists($basedir.$one_img_dir.'/'.$one_img[0].'.png') )
                $thumb_link = '/'.$one_img_dir.'/'.$one_img[0].'.png';

            if( $one_img[0] != $name && $one_img_dir && file_exists($basedir.$one_img_dir.'/'.$one_img[0].'.jpg') )
                $thumb_link = '/'.$one_img_dir.'/'.$one_img[0].'.jpg';

            if( !isset($thumb_link) ) {
                $thumb_meta = dt_get_resized_img( array( get_template_directory_uri().$full_link, 1000, 1000 ), array( 'w' => 119, 'h' => 119, 'z' => 3 ) );
                $thumb_link = str_replace( get_template_directory_uri(), '', $thumb_meta[0] );
            }
        }

        $res[$full_link] = $thumb_link;
    }
    
    return $res;
}

// options add custom scripts
add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');
function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {
    
    // js_hide
    jQuery('#optionsframework input[type="checkbox"].of-js-hider').click(function() {
        var element = jQuery(this);
        element.parents('#section-'+element.attr('id')).next('.of-js-hide').fadeToggle(400);
    });
    
    jQuery('#optionsframework input[type="checkbox"]:checked.of-js-hider').each(function(){
        var element = jQuery(this);
        element.parents('#section-'+element.attr('id')).next('.of-js-hide').show();
    });

    // of_fields_generator script

    jQuery('#optionsframework .of_fields_gen_list').sortable();
    jQuery('#optionsframework .of_fields_gen_list');

    jQuery('button.of_fields_gen_add').click(function() {
        var container = jQuery(this).parent().prev('.of_fields_gen_list');
        var layout = jQuery(this).parents('div.of_fields_gen_controls');
        
		var size = 0;
		container.find('div.of_fields_gen_title').each( function(){
			var index = parseInt(jQuery(this).attr('data-index'));
			if( index >= size )
				size = index;
		});
		size += 1;

        var del_link = '<div class="submitbox"><a href="#" class="of_fields_gen_del submitdelete">Delete</a></div>';
        
        var new_block = layout.clone();
        new_block.find('button.of_fields_gen_add').detach();
        new_block
            .attr('class', '')
            .addClass('of_fields_gen_data menu-item-settings description')
			.append(del_link);
        
        new_block.find('input, textarea').each(function(){
            var name = jQuery(this).attr('name').toString();
            
            // this line must be awful, simple horror
            jQuery(this).val(layout.find('input[name="'+name+'"], textarea[name="'+name+'"]').val());
            
            name = name.replace("][", "]["+ size +"][");
            jQuery(this).attr('name', name);
        });
        container.append(new_block);
        new_block
            .wrap('<li class="nav-menus-php"></li>')
            .before('<div class="of_fields_gen_title menu-item-handle" data-index="' + size + '">'+jQuery('.of_fields_gen_title', new_block).val()+'<span class="item-controls"><a class="item-edit" title="Edit Widgetized Area"></a></span></div>');
        new_block.hide();
        del_button();
        toggle_button();
        
    });
    
function del_button() {
	jQuery('.of_fields_gen_del').click(function() {
        var title_container = jQuery(this).parents('li').find('div.of_fields_gen_title');
        console.log(title_container);
        title_container.next('div.of_fields_gen_data').hide().detach();
        title_container.hide('slow').detach();
        return false;
    });
}
del_button();
    
function toggle_button() {
    jQuery('.item-edit').click(function(event) {
        if( jQuery(event.target).parents('.of_fields_gen_title').is('div.of_fields_gen_title') ) {
            jQuery(event.target).parents('.of_fields_gen_title').next('div.of_fields_gen_data').toggle();
        }
    });
}
toggle_button();
    
        
    jQuery('div.controls').change(function(event) {
        if( jQuery(event.target).not('div').is('.of_fields_gen_title') ) {
            var div_title = jQuery(event.target)
                .parents('div.of_fields_gen_data')
                .prev('div.of_fields_gen_title');
            var del_link =  div_title.children();
            div_title.text(jQuery(event.target).val()).append(del_link);
        }
    });
    // of_fields_generator end

    /*
     * slider
     */
    jQuery( ".of-slider" ).each(function() {
        
        var data = jQuery(this).next('input.of-slider-value');
        var value = data.attr('data-value');
        var min = data.attr('data-min');
        var max = data.attr('data-max');
        var step = data.attr('data-step');

        if( data.length ) {
            jQuery(this).slider({
		        value: parseInt(value),
		        min: parseInt(min),
		        max: parseInt(max),
		        step: parseInt(step),
                range: 'min',
		        slide: function( event, ui ) {
			        data.val( ui.value );
		        }
	        });
            data.val(jQuery(this).slider('option', 'value'));
        }
    });    
});
</script>
 
<?php
}

/* find option pages in array */
function optionsframework_options_page_filter( $item ) {
    if( isset($item['type']) && 'page' == $item['type'] ) {
        return true;
    }
    return false;
}

/* find options for current page */
function optionsframework_options_for_page_filter( $item ) {
    static $bingo = false;
    static $found_main = false;
    
    if( !isset($_GET['page']) ) {
        if( !isset($_POST['_wp_http_referer']) ) {
            return true;
        }else {
            $arr = array();
            wp_parse_str($_POST['_wp_http_referer'], $arr);
            $current = current($arr);
        }
    }else {
        $current = $_GET['page'];
    }
    
    if( 'options-framework' == $current && !$found_main ) {
        $bingo = true;
        $found_main = true;
    }
    
    if( isset($item['type']) && 'page' == $item['type'] && $item['menu_slug'] == $current ) {
        $bingo = true;
        return false;
    }elseif( isset($item['type']) && 'page' == $item['type'] ) {
        $bingo = false;
    }
      
    return $bingo;
}

function optionsframework_presets_data( $id ) {
    $presets = array();
	
	include_once 'presets/AncientMarble.php';
	include_once 'presets/Fabulous.php';
	include_once 'presets/ClassicRestaurant.php';
	include_once 'presets/Geometric.php';
	include_once 'presets/KidsAndParents.php';
	include_once 'presets/MedicalClinick.php';
	include_once 'presets/Minimalist.php';
	include_once 'presets/Origami.php';
	include_once 'presets/SpaSalon.php';
	include_once 'presets/TatooSalon.php';
	include_once 'presets/BoxedDark.php';
	include_once 'presets/BoxedLight.php';
	
    if( isset($presets[$id]) ) {
        return $presets[$id];
    }
    return array();
}

?>
