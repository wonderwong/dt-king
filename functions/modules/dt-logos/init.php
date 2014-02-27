<?php

// module uri
if( !defined('DT_LOGOS_URI') ) {
    define( 'DT_LOGOS_URI', get_template_directory_uri(). '/functions/modules/dt-logos' );
}

// setup module
require_once 'setup.php';
//include_once 'setup-scripts.php';
//include_once 'functions.php';
include_once 'filters.php';
include_once 'actions.php';
include_once 'metaboxes.php';

?>
