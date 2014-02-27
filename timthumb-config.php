<?php
define ('FILE_CACHE_DIRECTORY', '../../uploads/dt_cache');

if( isset($_GET['src']) ) {
	$pos = strpos('~', $_GET['src']);
	if( $pos !== false && $pos <= 1 ) {
		$src = strstr($_GET['src'], '~');
		$pos = strpos($src, '/');
		if( $pos !== false ) {
			$_GET['src'] = substr( $src, $pos+1 );
			$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(dirname(dirname($_SERVER['SCRIPT_FILENAME']))));
		}
		unset($src);
	}
	unset($pos);
}

?>