<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Photos</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
    <?php require_once '../window_scripts.php'; ?>
	
    <script language="javascript" type="text/javascript">    
    
    function init() {
		var selectedContent = tinyMCE.activeEditor.selection.getContent();	
        
        // fire ajax
        jQuery.post(
            tinymce.documentBaseURL + 'admin-ajax.php',
            {
                // action function
                action : 'dt_ajax_editor_photos'
            },
            function( response ){
                // insert responce
                jQuery('#photos_panel').html(response.html_content);
                dt_showhide_funnie();
                
                temp = selectedContent;
                
                if( (temp2 = temp.match(/(ppp)=["']*(.*?)["'\s\/\]]+/i)) != null ) {
                    jQuery('#dt_mce_window_photos_ppp').val(temp2[2]);
                } 
                                
                if( (temp2 = temp.match(/(orderby)=["']*(.*?)["'\s\/\]]+/i)) != null ) {
                    jQuery('#dt_mce_window_photos_orderby').val(temp2[2]);
                }
                                
                if( (temp2 = temp.match(/(order)=["']*(.*?)["'\s\/\]]+/i)) != null ) {
                    jQuery('input[name="dt_mce_window_photos_order"]')
                        .each(function() {
                            if( temp2[2] == jQuery(this).val() ) {
                                jQuery(this).attr('checked', 'checked');
                            }
                        });
                }
                
                if( (temp2 = temp.match(/(except)=["']*(.*?)["'\s\/\]]+/i)) != null ||
                    (temp2 = temp.match(/(only)=["']*(.*?)["'\s\/\]]+/i)) != null
                ) {
                    jQuery('input[name="show_type_gallery"]')
                        .each(function() {
                            if( temp2[1] == jQuery(this).val() ) {
                                jQuery(this).click();
                                var el_ids = temp2[2].replace(' ', '').split(',');
                                for( var i=0; i<el_ids.length; i++ ) {
                                    jQuery('input[name="show_gallery\['+temp2[1]+'\]\[\]"][value="'+el_ids[i]+'"]').attr('checked', 'checked');
                                }
                            }
                        });
                }
            }
        );
        
		tinyMCEPopup.resizeToInnerSize();
	}
	
	function insertShortcode() {
		var tagtext;
        
        var ppp = jQuery('#dt_mce_window_photos_ppp').val();
        var orderBy = jQuery('#dt_mce_window_photos_orderby').val();
        var order = jQuery('input[name="dt_mce_window_photos_order"]:checked').val();
		
        var ids = new Array();
        var filter = '';
        var selected_filter = jQuery("input[type=radio]:checked", jQuery('#photos_panel'));
        selected_filter.
            parent().next('.list').
            find('input[type=checkbox]:checked').
            each(function() {
                ids.push(jQuery(this).val());
            });
                    
        if( 'all' != selected_filter.val() ) {
            filter = ' ' + selected_filter.val() + '="' + ids.join() + '"';
        }

        tagtext = '[dt_photos ppp="' + ppp + '" orderby="' + orderBy + '" order="' + order + '"' + filter + '/]';	
		
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
                <li id="photos_tab" class="current"><span><a href="javascript:mcTabs.displayTab('photos_tab','photos_panel');" onmousedown="return false;">Photos</a></span></li>
            </ul>
        </div>
        
        <div class="panel_wrapper">
            
            <!-- small panel -->
            <div id="photos_panel" class="panel current" style="height: 200px;"></div>
            
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
    <script language="javascript" type="text/javascript">
        function dt_showhide_funnie() {
            jQuery(".showhide", jQuery('#photos_panel')).each(function () {
                var ee = this;
                jQuery("input[type=radio]", ee).change(function () {
                    jQuery(".list", jQuery('#photos_panel')).hide();
                    if ( jQuery(this).attr("checked") )
                        jQuery(".list", ee).show();
                    else
                        jQuery(".list", ee).hide();
                });
                jQuery("input[type=radio]:checked", ee).change();
            });
        }
    </script>
</body>
</html>
