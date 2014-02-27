<?php

// module uri
if( !defined('DT_SLIDESHOWS_URI') ) {
    define( 'DT_SLIDESHOWS_URI', get_template_directory_uri(). '/functions/modules/dt-slideshows' );
}

// setup module
require_once 'setup.php';

//include_once 'functions.php';
include_once 'filters.php';
include_once 'actions.php';
include_once 'metaboxes.php';

?>