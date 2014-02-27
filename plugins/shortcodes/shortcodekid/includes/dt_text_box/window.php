<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Text Box</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
    <?php require_once '../window_scripts.php'; ?>
	
    <script language="javascript" type="text/javascript">

	function init() {
		tinyMCEPopup.resizeToInnerSize();
		var selectedContent = tinyMCE.activeEditor.selection.getContent();
		if(selectedContent != undefined && selectedContent != '') {
			document.getElementById('dt_mce-text').value = selectedContent;
		}
		
	}
	
	function insertShortcode() {
		
		var tagtext;
		
		var notifications_bt = document.getElementById('dt_mce_pu_tab-text_box');
		
		// who is active ?
		if (notifications_bt.className.indexOf('current') != -1) {
			var nots_color = document.getElementById('dt_mce-color').value;
			var nots_text = document.getElementById('dt_mce-text').value;
			var nots_title = document.getElementById('dt_mce-title').value;

            if( nots_title ) {
                nots_title = '" title="' + nots_title;
            }
            
			if (nots_text != '' ) {
				tagtext = '[text_box class="' + nots_color + nots_title + '"] '+nots_text+' [/text_box] ';
            }else {
				alert('Please specify a text to your text box.');
                return false;
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
		
		return false;
	}
	</script>
	<base target="_self" />
    
	<style type="text/css">
	
    label span { color: #f00; }
	
    </style>
    
</head>
<?php
$color_list = array(
    'red'       => 'red',
    'orange'    => 'orange',
    'green'     => 'green',
    'grey'      => 'grey',
    'blue'      => 'blue'
);
?>
<body onload="init();">
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
	<form name="SKShortcodes" action="#">
	<div class="tabs">
		<ul>
			<li id="dt_mce_pu_tab-text_box" class="current"><span><a href="javascript:mcTabs.displayTab('dt_mce_pu_tab-text_box','dt_mce_panel-text_box');" onmousedown="return false;">Text Box</a></span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper">
    
		<!-- small panel -->
		<div id="dt_mce_panel-text_box" class="panel current">
        
        <fieldset style="padding-left: 15px;">
            <legend>Styling:</legend>
            <label for="dt_mce-color">Color:</label>
            <select name="dt_mce-color" id="dt_mce-color" style="width: 230px">
                <?php foreach( $color_list as $val=>$title ): ?>
                    <option value="<?php echo $val; ?>"><?php echo $title; ?></option>
                <?php endforeach;?>
            </select>
        </fieldset>

        <fieldset style="padding-left: 15px;">
        	<legend>Title:</legend>
            <input type="text" name="dt_mce-title" id="dt_mce-title" class="wide-field">
        </fieldset>
        
        <fieldset style="padding-left: 15px;">
            <legend>Text:</legend>
            <textarea type="text" name="dt_mce-text" id="dt_mce-text" class="wide-field"></textarea>
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
