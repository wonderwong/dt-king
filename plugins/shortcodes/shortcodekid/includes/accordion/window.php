<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Accordion</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
    <?php require_once '../window_scripts.php'; ?>
	
    <script language="javascript" type="text/javascript">
	function init() {
		
		tinyMCEPopup.resizeToInnerSize();
		
	}
	
	function insertShortcode() {
		
		var tagtext;
        var title = jQuery('#accordion_title').val();	
        
        if( title && title != 'udefined' )
            title = ' title="' + title + '"';

	    var tabbed = document.getElementById('accordion_tabs').value;
			
		if(tabbed != '') {
			var tabs = tabbed.split("|");
			var tabsLen = tabs.length;
			
			var myOutput = '';
			
			for(i=1;i<=tabsLen;i++) {
				myOutput += '[acc_item title="'+tabs[i-1]+'"] '+tabs[i-1].toUpperCase()+'_CONTENT [/acc_item] ';
			}
            tagtext = '[accordion items="'+tabbed+'"'+title+'] '+myOutput+' [/accordion]';    
		} else {
			alert('Specify at least one item');
            return false;
		}				

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
<body onload="init();">
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
	<form name="SKShortcodes" action="#">
	<div class="tabs">
		<ul>
			<li id="lists_tab" class="current"><span><a href="javascript:mcTabs.displayTab('lists_tab','lists_panel');" onmousedown="return false;">Accordion</a></span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper">
    
		<!-- small panel -->
		<div id="lists_panel">
        
        <fieldset style="padding-left: 15px;">
            <legend>Title:</legend>
            <input type="text" name="accordion_title" id="accordion_title" class="wide-field" />
        </fieldset>

        <fieldset style="padding-left: 15px;">
        
            <legend>Items:</legend>
            
            <input type="text" name="accordion_tabs" id="accordion_tabs" class="wide-field" />
            <em>Title of your items. Separate items with "|" (vertical line, no quotes)</em>
        
        </fieldset>

		</div>
		<!-- end small panel -->
		
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
