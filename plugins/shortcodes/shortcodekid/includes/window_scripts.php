<?php
/*if( isset($_GET['themeurl']) ) {
    $clear_url = explode( $_SERVER['SERVER_NAME'], $_GET['themeurl'] );
    $shkid_url = $_GET['themeurl'] . '/plugins/shortcodes/shortcodekid/css';
}else {*/
    $shkid_url = '../../css';
//}

/*if( isset($_GET['mceurl']) ) {

    $mce_url = $_GET['mceurl'];
}else { */
    $mce_url = '../../../../../../../../wp-includes/js/tinymce';
//}
?>
<script language="javascript" type="text/javascript" src="<?php echo $mce_url; ?>/tiny_mce_popup.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $mce_url; ?>/utils/mctabs.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $mce_url; ?>/utils/form_utils.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $mce_url; ?>/../jquery/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $shkid_url; ?>/window.css">
