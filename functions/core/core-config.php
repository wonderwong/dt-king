<?php

// languige zone
if( !defined( 'LANGUAGE_ZONE' ) ) {
    define( 'LANGUAGE_ZONE', 'dt');
}

// widget prefix
if( !defined( 'DT_WIDGET_PREFIX' ) ) {
    define( 'DT_WIDGET_PREFIX', 'DT-');
}

// debug flag
if( !defined( 'DT_DEBUG' ) ) {
    define( 'DT_DEBUG', false );
}

// debug level
if( !defined( 'DT_DEBUG_LEVEL' ) ) {
    define( 'DT_DEBUG_LEVEL', 1 );
}

// debug filename
if( !defined( 'DT_DEBUG_LOG_FILENAME' ) ) {
    define( 'DT_DEBUG_LOG_FILENAME', 'dt-log' );
}

// trace
if( !defined( 'DT_TRACE' ) ) {
    define( 'DT_TRACE', false );
}

// trace
if( !defined( 'DT_TRACE_TYPE' ) ) {
    define( 'DT_TRACE_TYPE', 'function' );
}

if( !defined( 'DT_PLUGINS_URL' ) ) {
    define( 'DT_PLUGINS_URL', get_template_directory_uri() . '/plugins' );
}

if( !defined( 'DT_PLUGINS_DIR' ) ) {
    define( 'DT_PLUGINS_DIR', dirname(__FILE__) . "/../plugins/" );
}

?>
