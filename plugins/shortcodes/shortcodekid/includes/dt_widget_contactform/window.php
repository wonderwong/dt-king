<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Contact form</title>
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

        if( (temp2 = temp.match(/(title)=["|']{1}(.*?)["|']{1}/i)) != null ) {
            jQuery('#dt_mce_window_contact_title').val(temp2[2]);
        } 
                        
        if( (temp2 = temp.match(/(captcha)=["|']{1}(.*?)["|']{1}/i)) != null ) {
            if( temp2[2] == "true" || temp2[2] == "1" ) {
                jQuery('#dt_mce_window_contact_captcha').attr('checked', 'checked');
            }else {
                jQuery('#dt_mce_window_contact_captcha').removeAttr('checked');
            }
        } 
                                
        if( (temp2 = temp.match(/(text)=["|']{1}(.*?)["|']{1}/i)) != null ) {
            jQuery('#dt_mce_window_contact_text').val(temp2[2]);
        } 

        if( (temp2 = temp.match(/(column)=["|']{1}(.*?)["|']{1}/i)) != null ) {
            jQuery('#dt_mce_window_contact_column').val(temp2[2]);
        }

        tinyMCEPopup.resizeToInnerSize();
	}
	
	function insertShortcode() {
		var tagtext;
        
        var column = jQuery('#dt_mce_window_contact_column option:selected').val();
        var title = jQuery('#dt_mce_window_contact_title').val();

        var text = jQuery('#dt_mce_window_contact_text').val();
        if( text )
            text = ' text="' + text + '"';

        var captcha = jQuery('#dt_mce_window_contact_captcha:checked');
        if( captcha.length )
            captcha = 1;
        else
            captcha = 0;

        tagtext = '[dt_contact title="' + title + '" column="' + column + '" captcha="' + captcha + '"' + text + '/]';	
		
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
                <li id="contact_tab" class="current"><span><a href="javascript:mcTabs.displayTab('contact_tab','contact_panel');" onmousedown="return false;">Contact form</a></span></li>
            </ul>
        </div>
        
        <div class="panel_wrapper">
            
            <!-- small panel -->
            <div id="contact_panel" class="panel current" style="height: 200px;">

                <fieldset style="padding-left: 15px;">
                    <legend> Title: </legend>
                    <input type="text" value="" name="dt_mce_window_contact_title" id="dt_mce_window_contact_title" class="wide-field" />
                </fieldset>

                <fieldset style="padding-left: 15px;">
                    <legend> Text: </legend>
                    <textarea name="dt_mce_window_contact_text" id="dt_mce_window_contact_text" class="wide-field"></textarea>
                </fieldset>

                <fieldset style="padding-left: 15px;">
                    <legend> Captcha: </legend>
                    <label><input type="checkbox" value="" name="dt_mce_window_contact_captcha" id="dt_mce_window_contact_captcha" /> Enable Captcha</label>
                </fieldset>

                <fieldset style="padding-left: 15px;">
                    <legend> Column: </legend>
                    <select name="dt_mce_window_contact_column" id="dt_mce_window_contact_column">

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
