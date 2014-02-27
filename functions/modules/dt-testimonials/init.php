<?php

// module uri
if( !defined('DT_TESTIMONIALS_URI') ) {
    define( 'DT_TESTIMONIALS_URI', get_template_directory_uri(). '/functions/modules/dt-testimonials' );
}

// setup module
require_once 'setup.php';
//include_once 'setup-scripts.php';
//include_once 'functions.php';
include_once 'filters.php';
include_once 'actions.php';
//include_once 'metaboxes.php';

?>
