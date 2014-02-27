<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Anything Slider</title>
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
                action : 'dt_ajax_editor_anything_slider'
            },
            function( response ){
                // insert responce
                jQuery('#ajax_container_1').html(response.html_content);
                dt_showhide_funnie();
                
                if( (temp2 = temp.match(/(title)=["|']{1}(.*?)["|']{1}/i)) != null ) {
                    jQuery('#slider_title').val(temp2[2]);
                } 
                                
                if( (temp2 = temp.match(/(autoslide)=["|']{1}(.*?)["|']{1}/i)) != null ) {
                    jQuery('#slider_autoslide').val(parseInt(temp2[2]));
                } 

                if( (temp2 = temp.match(/(column)=["|']{1}(.*?)["|']{1}/i)) != null ) {
                    jQuery('#slider_column').val(temp2[2]);
                }

                if( (temp2 = temp.match(/(slider_id)=["|']{1}(.*?)["|']{1}/i)) != null ) {
                    var checked_slider = jQuery('input[name="slider_id"][value="'+temp2[2]+'"]');
                    if( checked_slider.length )
                        checked_slider.attr('checked', 'checked');
                }
            }
        );

		tinyMCEPopup.resizeToInnerSize();
	}
	
	function insertShortcode() {
		
		var tagtext;
		var lists_bt = document.getElementById('lists_panel');
		
		// who is active ?
		if (lists_bt.className.indexOf('current') != -1) {
			
            var slider_title = jQuery('#slider_title').val();
            var slider_autoslide = jQuery('#slider_autoslide').val();
            var slider_column = jQuery('#slider_column option:selected').val();
            var slider_id = jQuery('input[name="slider_id"]:checked').val();
            
			tagtext = '[anything_slider title="'+slider_title+'" column="'+slider_column+'" autoslide="'+slider_autoslide+'" slider_id="'+slider_id+'"/]';
				
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
			<li id="lists_tab" class="current"><span><a href="javascript:mcTabs.displayTab('lists_tab','lists_panel');" onmousedown="return false;">Anything Slider</a></span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper">
    
		<!-- small panel -->
		<div id="lists_panel" class="panel current">
        
        <fieldset>
            <legend>Title:</legend>
            <input type="text" name="slider_title" id="slider_title" class="wide-field" value="" />
        </fieldset>
        
        <div id="ajax_container_1"></div>

        <fieldset>
            <legend>Autoslide:</legend>
            <input type="text" name="slider_autoslide" id="slider_autoslide" value="0" />
			<em>milliseconds (1 second = 1000 milliseconds; to disable autoslide leave this field blank or set it to "0")</em>
        </fieldset>

                <fieldset style="padding-left: 15px;">
                    <legend> Column: </legend>
                    <select name="slider_column" id="slider_column">

                    <?php
                    $columns = array( 'one-fourth', 'three-fourth', 'one-third', 'two-thirds', 'half', 'full-width' );
                    foreach( $columns as $column ):
                    ?>

                        <option value="<?php echo $column; ?>"><?php echo $column; ?></option>

                    <?php endforeach; ?>

                    </select>
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
    <script language="javascript" type="text/javascript">
        function dt_showhide_funnie() {
            jQuery(".showhide").each(function () {
                var ee = this;
                jQuery("input[type=radio]", ee).change(function () {
                    jQuery(".list").hide();
                    if ( jQuery(this).attr("checked") )
                        jQuery(".list", ee).show();
                    else
                        jQuery(".list", ee).hide();
                });
                jQuery("input[type=radio]:checked", ee).change();
            });
        }
    </script>
</form>
</body>
</html>
