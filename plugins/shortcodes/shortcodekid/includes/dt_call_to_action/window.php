<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Call to action</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <?php require_once '../window_scripts.php'; ?>
    
    <script language="javascript" type="text/javascript">
	function init() {
		
		tinyMCEPopup.resizeToInnerSize();
		
		var selectedContent = tinyMCE.activeEditor.selection.getContent();
        if( selectedContent && selectedContent != 'undefined') {
			document.getElementById('call_ta_text').value = selectedContent;
		}
		
	}
	
	function insertShortcode() {
		var tagtext;
		var icon_bt = document.getElementById('dt_mce_panel-icon');
		
		// who is active ?
		if (icon_bt.className.indexOf('current') != -1) {
			var text = jQuery('#call_ta_text').val();
		    tagtext = '[call_to_action]'+text+'[/call_to_action]';
		}
		
		if(window.tinyMCE) {
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
			//Peforms a clean up of the current editor HTML. 
			//tinyMCEPopup.editor.execCommand('mceCleanup');
			//Repaints the editor. Sometimes the browser has graphic glitches. 
			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
		
		return false;
	}
	</script>
	<base target="_self" />
    
</head>
<body onload="init();">
	<form name="SKShortcodes" action="#">
	<div class="tabs">
		<ul>
			<li id="dt_mce_pu_tab-icon" class="current"><span><a href="javascript:mcTabs.displayTab('dt_mce_pu_tab-icon','dt_mce_panel-icon');" onmousedown="return false;">Call to action</a></span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper">      
    
		<!-- icon panel -->
		<div id="dt_mce_panel-icon" class="panel current">
        
        <fieldset>
            <legend>Text:</legend>
            <textarea name="call_ta_text" id="call_ta_text" class="wide-field"></textarea>
        </fieldset>

		</div>
		<!-- end icon panel -->
				
	</div>

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="Close" onclick="tinyMCEPopup.close(); return false;" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="Insert" onclick="insertShortcode(); return false;" />
		</div>
	</div>
    
</form>
</body>
</html>
