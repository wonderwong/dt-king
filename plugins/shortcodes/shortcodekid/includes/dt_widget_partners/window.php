<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Partners</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
    <?php require_once '../window_scripts.php'; ?>
	
    <script language="javascript" type="text/javascript">    
    
    function init() {

        var selectedContent = window.parent.temp_GlobalSelection,
            temp = selectedContent,
            temp2 = null;
        
        if( temp == undefined )
            temp = '';

        window.parent.temp_GlobalSelection = '';

        // fire ajax
        jQuery.post(
            tinymce.documentBaseURL + 'admin-ajax.php',
            {
                // action function
                action : 'dt_ajax_editor_widget_logo'
            },
            function( response ){
                // insert responce
                jQuery('#logo_panel').html(response.html_content);
                dt_showhide_funnie();
                
                if( (temp2 = temp.match(/(ppp)=["|']{1}(.*?)["|']{1}/i)) != null ) {
                    jQuery('#dt_mce_window_logo_ppp').val(parseInt(temp2[2]));
                } 

                if( (temp2 = temp.match(/(title)=["|']{1}(.*?)["|']{1}/i)) != null ) {
                    jQuery('#dt_mce_window_logo_title').val(temp2[2]);
                } 
                                
                if( (temp2 = temp.match(/(autoslide)=["|']{1}(.*?)["|']{1}/i)) != null ) {
                    jQuery('#dt_mce_window_logo_autoslide').val(parseInt(temp2[2]));
                } 

                if( (temp2 = temp.match(/(orderby)=["|']{1}(.*?)["|']{1}/i)) != null ) {
                    jQuery('#dt_mce_window_logo_orderby').val(temp2[2]);
                }
                                
                if( (temp2 = temp.match(/(column)=["|']{1}(.*?)["|']{1}/i)) != null ) {
                    jQuery('#dt_mce_window_logo_column').val(temp2[2]);
                }

                if( (temp2 = temp.match(/(order)=["|']{1}(.*?)["|']{1}/i)) != null ) {
                    jQuery('input[name="dt_mce_window_logo_order"]')
                        .each(function() {
                            if( temp2[2] == jQuery(this).val() ) {
                                jQuery(this).attr('checked', 'checked');
                            }
                        });
                }
                
                if( (temp2 = temp.match(/(except)=["|']{1}(.*?)["|']{1}/i)) != null ||
                    (temp2 = temp.match(/(only)=["|']{1}(.*?)["|']{1}/i)) != null
                ) {
                    jQuery('input[name="show_type_gallery"]')
                        .each(function() {
                            if( temp2[1] == jQuery(this).val() ) {
                                jQuery(this).click();
                                var el_ids = temp2[2].replace(/ /g, '').split(',');
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
        
        var ppp = jQuery('#dt_mce_window_logo_ppp').val();
        var orderBy = jQuery('#dt_mce_window_logo_orderby').val();
        var order = jQuery('input[name="dt_mce_window_logo_order"]:checked').val();

        var column = jQuery('#dt_mce_window_logo_column option:selected').val();
        var title = jQuery('#dt_mce_window_logo_title').val();
        var autoslide = jQuery('#dt_mce_window_logo_autoslide').val();

        var ids = new Array();
        var filter = '';
        var selected_filter = jQuery("input[type=radio]:checked", jQuery('#logo_panel'));
        selected_filter.
            parent().next('.list').
            find('input[type=checkbox]:checked').
            each(function() {
                ids.push(jQuery(this).val());
            });
                    
        if( 'all' != selected_filter.val() ) {
            filter = ' ' + selected_filter.val() + '="' + ids.join() + '"';
        }

        tagtext = '[dt_partners title="' + title + '" ppp="' + ppp + '" orderby="' + orderBy + '" order="' + order + '" column="' + column + '" autoslide="' + autoslide + '"' + filter + '/]';	
		
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
                <li id="logo_tab" class="current"><span><a href="javascript:mcTabs.displayTab('logo_tab','logo_panel');" onmousedown="return false;">Partners</a></span></li>
            </ul>
        </div>
        
        <div class="panel_wrapper">
            
            <!-- small panel -->
            <div id="logo_panel" class="panel current" style="height: 200px;"></div>
            
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
            jQuery(".showhide", jQuery('#logo_panel')).each(function () {
                var ee = this;
                jQuery("input[type=radio]", ee).change(function () {
                    jQuery(".list", jQuery('#logo_panel')).hide();
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
