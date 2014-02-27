<?php

// function includes files in $dir, if $no_more set to true there no includes in subdirectories 
function include_files_in_dir( $dir, $no_more = false, $f_name = null ) {
    
    $dir_init = $dir;
    $dir = dirname(__FILE__).$dir;
  
    if (!file_exists($dir)) {
        throw new Exception("Folder $dir does not exist");
    }
     
    $files = array();
     
    if ($handle = opendir( $dir )) {

        while( false !== ($file = @readdir($handle)) ) {
        
            if ( is_dir( $dir.$file ) && !preg_match('/^\./', $file) && !$no_more ) {
                include_files_in_dir($dir_init.$file."/", true, $f_name);
            }else {
                
                if( $f_name && $f_name == $file ) {
                    $files[] = $dir.$file;
                }elseif( !$f_name && preg_match('/^[^~]{1}.*\.php$/', $file) ) {
                    $files[] = $dir.$file;
                }
            
            }
            
        }
        @closedir($handle);

    }
  
    sort($files);
  
    foreach($files as $file) {
        include_once $file;
    }

}


function dt_core_get_template_name() {
    global $post;
    if( isset($_GET['post']) ) {
        $post_id = $_GET['post'];
    }elseif( isset($_POST['post_ID']) ) {
        $post_id = $_POST['post_ID'];
    }elseif( isset($post->ID) ) {
        $post_id = $post->ID;
    }else
        return false;
    
    return get_post_meta($post_id, '_wp_page_template', true);
}

function dt_core_get_posts_thumbnails( $dt_posts = array(), $taxonomy = '', $opts = array() ) {
    global $wpdb;
    $posts_id = $thumbs_id = $thumbs = $thumbs_meta = $tmp = '';

    if( empty($dt_posts) ) {
        return false;
    }

	// store posts ids
	foreach( $dt_posts as $dt_post ) {
		$posts_id[] = $dt_post->ID;
	}
	
	// convert posts ids to string
	$tmp = implode(',', $posts_id);
	
	// get posts thumbnails ids
	$thumbs = $wpdb->get_results( $wpdb->prepare( "
		SELECT post_id, meta_value AS thumb_id
		FROM $wpdb->postmeta 
		WHERE post_id IN ($tmp)
		AND meta_key = '_thumbnail_id'
	" , null) );

    if( empty($thumbs) ) {
        return false;
    }

    // store thumbs ids and relationships between post and thumbnail
	foreach( $thumbs as $dt_thumb ) {
		$thumbs_id['thumb_ids'][] = $dt_thumb->thumb_id;
		$thumbs_id['thumbs_posts'][$dt_thumb->thumb_id] = $dt_thumb->post_id;
	}
	
    // convert thumbs ids to string
	$tmp = implode(',', $thumbs_id['thumb_ids']);
	
	// get thumbnails meta info
	$thumbs = $wpdb->get_results( $wpdb->prepare( "
		SELECT post_id, meta_value, meta_key
		FROM $wpdb->postmeta 
		WHERE post_id IN ($tmp)
		AND meta_key = '_wp_attachment_metadata'
	" , null) );	
	
    // make final array
	foreach( $thumbs as $thumb_meta ) {	
        $thumbs_meta[$thumbs_id['thumbs_posts'][$thumb_meta->post_id]]['data'] = unserialize($thumb_meta->meta_value);
    }

    return array(
        'thumbs_meta'   => $thumbs_meta,
        'posts_id'      => $posts_id
    );
}

function dt_core_get_metabox_list( $opts = array() ) {
    global $wp_meta_boxes;
    
    $defaults = array(
        'id'    => 'dt_page_box',
        'page'  => 'page'
    );
    $opts = wp_parse_args( $opts, $defaults );

    $meta_boxes = array();

    foreach( array('side', 'normal') as $context ) {
        foreach( array('high', 'sorted', 'core', 'default', 'low') as $priority ) {
            if( isset($wp_meta_boxes[$opts['page']][$context][$priority]) ) {
                foreach ( (array) $wp_meta_boxes[$opts['page']][$context][$priority] as $id=>$box ) {
                    if( false !== strpos( $id, $opts['id']) ) {
                        $meta_boxes[] = $id; 
                    }
                }
            }
        }
    }
    return $meta_boxes;
}


/* debug class */
class DT_SERVICE {
    protected $startTime = 0;
	protected $lastBenchTime = 0;
    protected static $buffer = null;
    
    // debug log
    public function debug( $level, $msg, $line = __LINE__, $file = __FILE__ ) {
		if( DT_DEBUG && $level <= DT_DEBUG_LEVEL ) {
			$execTime = sprintf('%.6f', microtime(true) - $this->startTime);
			$tick = sprintf('%.6f', 0);
			if( $this->lastBenchTime > 0 ) {
				$tick = sprintf('%.6f', microtime(true) - $this->lastBenchTime);
			}
			$this->lastBenchTime = microtime(true);
            
            error_log(
                "File < $file > line | $line | [$execTime : $tick]: $msg\n",
                3,
                DT_DEBUG_LOG_FILENAME
            ); 
		}
	}
    
    // trace
    public function trace( $func = '', $action = '', $file = '' ) {
        if( DT_TRACE ) {
            
            $wrap =  '<span class="dt_debug dt_trace">%s</span>';
            $file = basename( $file );
            $msg = "$func > $action ( $file )";
            
            switch( DT_TRACE_TYPE ) {
                case 'file':
                    $msg = $file;
                    break;
                case 'action':
                    $msg = $action;
                    break;
                case 'function':
                    $msg = $func;
                    break;
            }
            printf( $wrap, $msg );
        }
    }
    
    // buffer method
    public function buffer( $data = null, $write = false ) {
        if( $data && !$write ) {
            DT_SERVICE::$buffer = $data;
        }elseif( $write ) {
            DT_SERVICE::$buffer = $data;
        }
        return DT_SERVICE::$buffer;
    }
}
// debug class end

?>
