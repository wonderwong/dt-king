<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Columns</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
    <?php require_once '../window_scripts.php'; ?>
	
    <script language="javascript" type="text/javascript">    
	var selectedContent = '';
    var tagtext;
    
    function init() {
        tinyMCEPopup.resizeToInnerSize();
		selectedContent = tinyMCE.activeEditor.selection.getContent();
        
        // fire ajax
        jQuery.post(
            tinymce.documentBaseURL + 'admin-ajax.php',
            {
                // action function
                action : 'dt_ajax_editor_columns'
            },
            function( response ){
                // insert responce
                jQuery('#dt_mce_panel-columns').html(response.html_content);
                
                if( selectedContent ) {
                    jQuery( '#dt_mce-ed_content' ).val( selectedContent );
                } 
            }
        );         
	}
	
	function insertShortcode() {
        var style = jQuery('#dt_mce-style').val();
        var align = jQuery('#dt_mce-align:checked').val() ? ' align="right"' : '';
        var last = jQuery('#dt_mce-last:checked').val() ? ' last="true"': '';
        var content = jQuery( '#dt_mce-ed_content' ).val();
        
        tagtext = '[' + style + align + last + ']<p>' + content + '</p>[/' + style + ']';
		
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
    
	<style type="text/css">
	
    label span { color: #f00; }
	
    </style>
    
</head>
<body onload="init();">
	<form name="SKShortcodes" action="#">
        <div class="tabs">
            <ul>
                <li id="dt_mce_pu_tab-columns" class="current"><span><a href="javascript:mcTabs.displayTab('dt_mce_pu_tab-columns','dt_mce_panel-columns');" onmousedown="return false;">Columns</a></span></li>
            </ul>
        </div>
        
        <div class="panel_wrapper">
            
            <!-- small panel -->
            <div id="dt_mce_panel-columns" class="panel current"></div>
            
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
