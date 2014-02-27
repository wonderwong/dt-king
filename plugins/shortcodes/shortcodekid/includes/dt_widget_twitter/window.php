<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Twitter</title>
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
            jQuery('#dt_mce_window_widget_twitter_title').val(temp2[2]);
        } 

        if( (temp2 = temp.match(/(username)=["|']{1}(.*?)["|']{1}/i)) != null ) {
            jQuery('#dt_mce_window_widget_twitter_username').val(temp2[2]);
        } 

        if( (temp2 = temp.match(/(ppp)=["|']{1}(.*?)["|']{1}/i)) != null ) {
            jQuery('#dt_mce_window_widget_twitter_number').val(temp2[2]);
        } 

        if( (temp2 = temp.match(/(textlink)=["|']{1}(.*?)["|']{1}/i)) != null ) {
            jQuery('#dt_mce_window_widget_twitter_textlink').val(temp2[2]);
        } 

        if( (temp2 = temp.match(/(autoslide)=["|']{1}(.*?)["|']{1}/i)) != null ) {
            jQuery('#dt_mce_window_widget_twitter_autoslide').val(temp2[2]);
        } 

        if( (temp2 = temp.match(/(column)=["|']{1}(.*?)["|']{1}/i)) != null ) {
            jQuery('#dt_mce_window_widget_twitter_column option[value="'+temp2[2]+'"]').attr('selected', 'selected');
        } 
	}
	
	function insertShortcode() {
		var tagtext;
        
        var title = jQuery('#dt_mce_window_widget_twitter_title').val();
        var username = jQuery('#dt_mce_window_widget_twitter_username').val();
        var show_number = jQuery('#dt_mce_window_widget_twitter_number').val();
        var textlink = jQuery('#dt_mce_window_widget_twitter_textlink').val();
        var autoslide = jQuery('#dt_mce_window_widget_twitter_autoslide').val();
        var column = jQuery('#dt_mce_window_widget_twitter_column').val();
        
        if( username )
            username = ' username="' + username + '"';

        if( show_number )
            show_number = ' ppp="' + show_number + '"';

        if( textlink )
            textlink = ' textlink="' + textlink + '"';

        if( autoslide )
            autoslide = ' autoslide="' + autoslide + '"';

        tagtext = '[dt_twitter title="' + title + '" column="' + column + '"' + username + show_number + textlink + autoslide + '/]';	
		
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
                <li id="photos_tab" class="current"><span><a href="javascript:mcTabs.displayTab('photos_tab','widget_latposts_panel');" onmousedown="return false;">Twitter</a></span></li>
            </ul>
        </div>
        
        <div class="panel_wrapper">
            
            <!-- small panel -->
            <div id="widget_latposts_panel" class="panel current">
            
                <fieldset style="padding-left: 15px;">
                    <legend> Title: </legend>
                    <input type="text" value="" name="dt_mce_window_widget_twitter_title" id="dt_mce_window_widget_twitter_title"/>
                </fieldset>

                <fieldset style="padding-left: 15px;">
                    <legend> Username: </legend>
                    <input type="text" value="" name="dt_mce_window_widget_twitter_username" id="dt_mce_window_widget_twitter_username"/>
                </fieldset>

                <fieldset style="padding-left: 15px;">
                    <legend> Number of items to display: </legend>
                    <input type="text" value="6" name="dt_mce_window_widget_twitter_number" id="dt_mce_window_widget_twitter_number"/>
                </fieldset>

                <fieldset style="padding-left: 15px;">
                    <legend> Text link: </legend>
                    <input type="text" value="" name="dt_mce_window_widget_twitter_textlink" id="dt_mce_window_widget_twitter_textlink"/>
                </fieldset>

                <fieldset style="padding-left: 15px;">
                    <legend> Autoslide: </legend>
                    <input type="text" value="0" name="dt_mce_window_widget_twitter_autoslide" id="dt_mce_window_widget_twitter_autoslide"/>
					<em>milliseconds (1 second = 1000 milliseconds; to disable autoslide leave this field blank or set it to "0")</em>
                </fieldset>
                
                <fieldset style="padding-left: 15px;">
                    <legend> Column: </legend>
                    <select name="dt_mce_window_widget_twitter_column" id="dt_mce_window_widget_twitter_column">

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
