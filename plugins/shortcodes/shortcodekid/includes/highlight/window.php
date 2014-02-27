<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Insert Highlight Text</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
    <?php require_once '../window_scripts.php'; ?>
	
    <script language="javascript" type="text/javascript">
	function init() {
		
		tinyMCEPopup.resizeToInnerSize();
		
		var selectedContent = tinyMCE.activeEditor.selection.getContent();
		
		if(selectedContent != '') {
			
			document.getElementById('highlight_el').value = selectedContent;
			
		}
		
	}
	
	function insertShortcode() {
		
		var tagtext;
		
		var highlight_bt = document.getElementById('highlight_panel');
		
		// who is active ?
		if (highlight_bt.className.indexOf('current') != -1) {
			
			var selectedContent = tinyMCE.activeEditor.selection.getContent();
			
			var highlight_color = document.getElementById('highlight_color').value;
			var highlight_el = document.getElementById('highlight_el').value;
				
			if (highlight_el != '' )
				tagtext = '[highlight color="'+highlight_color+'"]'+highlight_el+'[/highlight]';
			else
				alert('Please specify some text to highlight.');
				
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
    
	<style type="text/css">
	
    label span { color: #f00; }
	
    </style>
    
</head>
<body onload="init();">
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
	<form name="SKShortcodes" action="#">
	<div class="tabs">
		<ul>
			<li id="highlight_tab" class="current"><span><a href="javascript:mcTabs.displayTab('highlight_tab','highlight_panel');" onmousedown="return false;">Highlights</a></span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper">
    
		<!-- small panel -->
		<div id="highlight_panel" class="panel current">
        
        <fieldset style="padding-left: 15px;">
        
            <legend>Styling:</legend>
                <label for="highlight_color">Color:</label>
                        <select name="highlight_color" id="highlight_color" style="width: 230px">
                            <option value="blue">Blue</option>
                            <option value="orange">Orange</option>
                            <option value="green">Green</option>
                            <option value="purple">Purple</option>
                            <option value="pink">Pink</option>
                            <option value="red">Red</option>
                            <option value="grey">Grey</option>
                            <option value="light">Light</option>
                            <option value="black">Black</option>
                            <option value="yellow">Yellow</option>
                        </select>
        </fieldset>
        
        <fieldset style="padding-left: 15px;">
        
        	<legend>Text:</legend>
                    <textarea type="text" name="highlight_el" id="highlight_el" class="wide-field"></textarea>
            <br /><em>The 'highlighted' element. Accepts shortcodes.</em>
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
<?php

?>
