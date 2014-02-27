<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Tabbed Content</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
    <?php require_once '../window_scripts.php'; ?>
	
    <script language="javascript" type="text/javascript">
	function init() {
		tinyMCEPopup.resizeToInnerSize();
	}
	
	function insertShortcode() {
		
		var tagtext;
		var lists_bt = document.getElementById('lists_tab'); 
		
		// who is active ?
		if (lists_bt.className.indexOf('current') != -1) {
			
			var tabbed = document.getElementById('tabbed_tabs').value;
			
			if(tabbed != '') {
				var tabs = tabbed.split("|");
				var tabsLen = tabs.length;
				var myOutput = '';
				for(i=1;i<=tabsLen;i++) {
					myOutput += '[tab] '+tabs[i-1].toUpperCase()+'_CONTENT [/tab] ';
				}
				
				tagtext = '[tabbed tabs="'+tabbed+'"] '+myOutput+'[/tabbed] ';
				
			} else {
				
				alert('Specify at least one tab');
				
			}				
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
			<li id="lists_tab" class="current"><span><a href="javascript:mcTabs.displayTab('lists_tab','lists_panel');" onmousedown="return false;">Tabbed Content</a></span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper">
    
		<!-- small panel -->
		<div id="lists_panel">
        
        <fieldset style="padding-left: 15px;">
        
            <legend>Tabs:</legend>
            
            <input type="text" name="tabbed_tabs" id="tabbed_tabs" class="wide-field" />
            <em>Title of your tabs. Separate tabs with "|" (vertical line, no quotes)</em>
        
        </fieldset>

		</div>
		<!-- end small panel -->
		
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
