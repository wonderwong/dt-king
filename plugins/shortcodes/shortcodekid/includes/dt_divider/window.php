<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Divider</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
    <?php require_once '../window_scripts.php'; ?>
	
    <script language="javascript" type="text/javascript">   
    function init() {	
		tinyMCEPopup.resizeToInnerSize();
	}
	
	function insertShortcode() {
		var tagtext;
        
        var style = jQuery('#dt_mce-style').val();
              
        tagtext = '[dt_divider style="' + style + '"/]';	
		
		if(window.tinyMCE) {
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
			//Peforms a clean up of the current editor HTML. 
			//tinyMCEPopup.editor.execCommand('mceCleanup');
			//Repaints the editor. Sometimes the browser has graphic glitches. 
			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
		
		return;
	}
	</script>
	<base target="_self" />
    
</head>
<?php
$devider_list = array(
    'narrow'        => 'narrow',
    'wide'          => 'wide',
    'double-gap'    => 'double-gap',
    'gap'           => 'gap'
);
?>
<body onload="init();">
	<form name="SKShortcodes" action="#">
        <div class="tabs">
            <ul>
                <li id="devider_tab" class="current"><span><a href="javascript:mcTabs.displayTab('devider_tab','devider_panel');" onmousedown="return false;">Divider</a></span></li>
            </ul>
        </div>
        
        <div class="panel_wrapper">
            <!-- small panel -->
            <div id="devider_panel" class="panel current" style="height: 100px;">
                <fieldset style="padding-left: 15px;">
                    <legend>Style:</legend>
                    <label for="dt_mce-style"></label>
                    <select name="dt_mce-style" id="dt_mce-style">
                        <?php foreach( $devider_list as $val=>$title ): ?>
                            <option value="<?php echo $val; ?>"><?php echo $title; ?></option>
                        <?php endforeach; ?>
                    </select>
                </fieldset>
            </div>
        </div>
        
        <div class="mceActionPanel">
            <div style="float: left">
                <input type="button" id="cancel" name="cancel" value="Close" onclick="tinyMCEPopup.close();" />
            </div>

            <div style="float: right">
                <input type="submit" id="insert" name="insert" value="Insert" onclick="insertShortcode();" />
            </div>
        </div>
        
    </form>
</body>
</html>
