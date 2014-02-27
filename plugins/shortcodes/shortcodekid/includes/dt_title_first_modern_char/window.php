<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>First letter styling for a title</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
    <?php require_once '../window_scripts.php'; ?>
	
    <script language="javascript" type="text/javascript">    

	var selectedContent = '';
    var tagtext;
    
    function init() {
		tinyMCEPopup.resizeToInnerSize();
		selectedContent = tinyMCE.activeEditor.selection.getContent();
        
        if( selectedContent ) {
            jQuery( '#dt_mce-ed_content' ).val( selectedContent );
        }
	}
	
	function insertShortcode() {
        tagtext = '[dt_parallax_title]' + selectedContent + '[/dt_parallax_title]';
		
        if( window.tinyMCE ) {
			window.tinyMCE.execInstanceCommand( 'content', 'mceInsertContent', false, tagtext );
			//Peforms a clean up of the current editor HTML. 
			//tinyMCEPopup.editor.execCommand('mceCleanup');
			//Repaints the editor. Sometimes the browser has graphic glitches. 
			tinyMCEPopup.editor.execCommand( 'mceRepaint' );
			tinyMCEPopup.close();
		}
		
		return;
	}
	</script>
	<base target="_self" />
    
</head>
<body onload="init();">
	<form name="SKShortcodes" action="#">
        <div class="tabs">
            <ul>
                <li id="dt_mce_pu_tab-tfml" class="current"><span><a href="javascript:mcTabs.displayTab('dt_mce_pu_tab-tfml','dt_mce_panel-tfml');" onmousedown="return false;">First letter styling for a title</a></span></li>
            </ul>
        </div>
        
        <div class="panel_wrapper">
            
            <!-- small panel -->
            <div id="dt_mce_panel-tfml" class="panel current">
                <fieldset>
                    <legend>Editable Content:</legend>
                    <textarea id="dt_mce-ed_content" name="dt_mce-ed_content" style="width: 290px"></textarea>
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
