<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Latest Posts</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
    <?php require_once '../window_scripts.php'; ?>
	
    <script language="javascript" type="text/javascript">    
    
    function init() {
		
		tinyMCEPopup.resizeToInnerSize();
		
		var selectedContent = tinyMCE.activeEditor.selection.getContent();

        // fire ajax
        jQuery.post(
            tinymce.documentBaseURL + 'admin-ajax.php',
            {
                // action function
                action : 'dt_ajax_editor_widget_latposts'
            },
            function( response ){
                // insert responce
                jQuery('#widget_latposts_panel').html(response.html_content);
                
                temp = selectedContent;
                
                if( (temp2 = temp.match(/(ppp)=["']*(.*?)["'\s\/\]]+/i)) != null ) {
                    jQuery('#dt_mce_window_widget_latposts_ppp').val(temp2[2]);
                } 
                
                if( (temp2 = temp.match(/(title)=["']*(.*?)["'\s\/\]]+/i)) != null ) {
                    jQuery('#dt_mce_window_widget_latposts_title').val(temp2[2]);
                }
                
                if( (temp2 = temp.match(/(align)=["']*(.*?)["'\s\/\]]+/i)) != null ) {
                    jQuery('input[name="dt_mce_window_widget_latposts_align"]')
                        .each(function() {
                            if( temp2[2] == jQuery(this).val() ) {
                                jQuery(this).attr('checked', 'checked');
                            }
                        });
                }
                
            }
        );
	}
	
	function insertShortcode() {
		var tagtext;
        
        var ppp = jQuery('#dt_mce_window_widget_latposts_ppp').val();
//        var category = jQuery('#dt_mce_window_widget_latposts_categ').val();
        var title = jQuery('#dt_mce_window_widget_latposts_title').val();
        var align = jQuery('input[type=radio]:checked', jQuery('#dt_mce_window_widget_latposts_align')).val();
        
        tagtext = '[dt_latest_posts ppp="' + ppp + '" title="' + title + '" align="' + align + '"/]';	
		
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
	<form name="SKShortcodes" action="#">
        <div class="tabs">
            <ul>
                <li id="photos_tab" class="current"><span><a href="javascript:mcTabs.displayTab('photos_tab','widget_latposts_panel');" onmousedown="return false;">Latest posts</a></span></li>
            </ul>
        </div>
        
        <div class="panel_wrapper">
            
            <!-- small panel -->
            <div id="widget_latposts_panel" class="panel current"></div>
            
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
