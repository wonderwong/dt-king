<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Small photos</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
    <?php require_once '../window_scripts.php'; ?>
	
    <script language="javascript" type="text/javascript">    
    
    function init() {
		
		tinyMCEPopup.resizeToInnerSize();
		
        var selectedContent = window.parent.temp_GlobalSelection,
            temp = selectedContent,
            temp2 = null;
        
        if( temp == undefined )
            temp = '';

        window.parent.temp_GlobalSelection = '';
                
        if( (temp2 = temp.match(/(title)=["|']{1}(.*?)["|']{1}/i)) != null ) {
            jQuery('#dt_mce_window_widget_recent_photos_title').val(temp2[2]);
        } 

        if( (temp2 = temp.match(/(order)=["|']{1}(.*?)["|']{1}/i)) != null ) {
            jQuery('input[name="dt_mce_window_widget_recent_photos_order"]')
                .each(function() {
                    if( temp2[2] == jQuery(this).val() ) {
                        jQuery(this).attr('checked', 'checked');
                    }
                });
        } 

        if( (temp2 = temp.match(/(ppp)=["|']{1}(.*?)["|']{1}/i)) != null ) {
            jQuery('#dt_mce_window_widget_recent_photos_number').val(temp2[2]);
        } 

        if( (temp2 = temp.match(/(column)=["|']{1}(.*?)["|']{1}/i)) != null ) {
            jQuery('#dt_mce_window_widget_recent_photos_column option[value="'+temp2[2]+'"]').attr('selected', 'selected');
        } 
	}
	
	function insertShortcode() {
		var tagtext;
        
        var title = jQuery('#dt_mce_window_widget_recent_photos_title').val();
        var order = jQuery('input[name="dt_mce_window_widget_recent_photos_order"]:checked').val();
        var show_number = jQuery('#dt_mce_window_widget_recent_photos_number').val();
        var column = jQuery('#dt_mce_window_widget_recent_photos_column').val();
        
        if( show_number )
            show_number = ' ppp="' + show_number + '"';

        if( order )
            order = ' order="' + order + '"';

        tagtext = '[dt_recent_photos title="' + title + '" column="' + column + '"' + show_number + order + '/]';	
		
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
                <li id="photos_tab" class="current"><span><a href="javascript:mcTabs.displayTab('photos_tab','widget_recent_photos_panel');" onmousedown="return false;">Small photos</a></span></li>
            </ul>
        </div>
        
        <div class="panel_wrapper">
            
            <!-- small panel -->
            <div id="widget_recent_photos_panel" class="panel current">
            
                <fieldset style="padding-left: 15px;">
                    <legend> Title: </legend>
                    <input type="text" value="" name="dt_mce_window_widget_recent_photos_title" id="dt_mce_window_widget_recent_photos_title"/>
                </fieldset>

                <fieldset style="padding-left: 15px;">
                    <legend> Show: </legend>
                    <label><input type="radio" value="rand" name="dt_mce_window_widget_recent_photos_order" class="dt_mce_window_widget_recent_photos_username" checked="checked" /> Random Photos</label>
                    <label><input type="radio" value="latest" name="dt_mce_window_widget_recent_photos_order" class="dt_mce_window_widget_recent_photos_username" /> Latest Photos</label>
                </fieldset>

                <fieldset style="padding-left: 15px;">
                    <legend> Number of items to display: </legend>
                    <input type="text" value="6" name="dt_mce_window_widget_recent_photos_number" id="dt_mce_window_widget_recent_photos_number"/>
                </fieldset>

                <fieldset style="padding-left: 15px;">
                    <legend> Column: </legend>
                    <select name="dt_mce_window_widget_recent_photos_column" id="dt_mce_window_widget_recent_photos_column">

                    <?php
                    $columns = array( 'one-fourth', 'three-fourth', 'one-third', 'two-thirds', 'half', 'full-width' );
                    foreach( $columns as $column ):
                    ?>

                        <option value="<?php echo $column; ?>"><?php echo $column; ?></option>

                    <?php endforeach; ?>

                    </select>
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
