<?php

// module uri
if( !defined('DT_VIDEO_URI') ) {
    define( 'DT_VIDEO_URI', get_template_directory_uri(). '/functions/modules/dt-video' );
}

// setup module
require_once 'setup.php';
require_once 'setup-scripts.php';

//include_once 'functions.php';
include_once 'filters.php';
include_once 'actions.php';
include_once 'metaboxes.php';

?>