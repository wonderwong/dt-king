<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Insert Button</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <?php require_once '../window_scripts.php'; ?>
    
    <script language="javascript" type="text/javascript">
	function init() {
		
		tinyMCEPopup.resizeToInnerSize();
		
		var selectedContent = tinyMCE.activeEditor.selection.getContent();
		
		if(selectedContent != '') {
			document.getElementById('dt_mce-text').value = selectedContent;
		}
		
	}
	
	function insertShortcode() {
		
		var tagtext;
	
		var icon_bt = document.getElementById('dt_mce_panel-icon');
		
		// who is active ?
		if (icon_bt.className.indexOf('current') != -1) {
			
			var icon_icon = document.getElementById('dt_mce-icon').value;
			var icon_link = document.getElementById('dt_mce-link').value;
			var icon_text = document.getElementById('dt_mce-text').value;
			var icon_size = document.getElementById('dt_mce-size').value;
			var icon_colour = document.getElementById('dt_mce-colour').value;
			var icon_target = jQuery('input[type=checkbox]#dt_mce-target:checked').length?' blank="true"':'';

            if( icon_size )
                icon_size = ' size="' + icon_size + '"';

            if( icon_colour )
                icon_colour = ' colour="' + icon_colour + '"';

			if (icon_text != '' )
				tagtext = '[button_icon icon="'+icon_icon+'" url="'+icon_link+'"'+icon_target+ icon_size + icon_colour + ']'+icon_text+'[/button_icon]<br/>';
			else{
                alert('Please specify a text to your button.');
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
    
</head>
<?php
$ico_list = array(
    'address-book'          => 'address-book',
    'alarm-clock'           => 'alarm-clock',
    'arrow-left'            => 'arrow-left',
    'arrow-down'            => 'arrow-down',
    'balance'               => 'balance',
    'balloon-quotation'     => 'balloon-quotation',
    'beer'                  => 'beer',
    'bell'                  => 'bell',
    'binocular'             => 'binocular',
    'block'                 => 'block',
    'blogs'                 => 'blogs',
    'blue-documents'        => 'blue-documents',
    'bomb'                  => 'bomb',
    'yin-yang'              => 'yin-yang',
    'wand'                  => 'wand',
    'users'                 => 'users',
    'trophy'                => 'trophy',
    'thumb-up'              => 'thumb-up',
    'thumb-down'            => 'thumb-down',
    'target'                => 'target',
    'star'                  => 'star',
    'smiley'                => 'smiley',
    'smiley-wink'           => 'smiley-wink',
    'smiley-roll'           => 'smiley-roll',
    'smiley-red'            => 'smiley-red',
    'smiley-razz'           => 'smiley-razz',
    'smiley-money'          => 'smiley-money',
    'smiley-mad'            => 'smiley-mad',
    'smiley-kitty'          => 'smiley-kitty',
    'smiley-grin'           => 'smiley-grin',
    'smiley-evil'           => 'smiley-evil',
    'smiley-cool'           => 'smiley-cool',
    'shield'                => 'shield',
    'safe'                  => 'safe',
    'rocket'                => 'rocket',
    'rainbow'               => 'rainbow',
    'puzzle'                => 'puzzle',
    'paper-plane'           => 'paper-plane',
    'palette'               => 'palette',
    'newspaper'             => 'newspaper',
    'new-text'              => 'new-text',
    'money-coin'            => 'money-coin',
    'medal'                 => 'medal',
    'map-pin'               => 'map-pin',
    'mail'                  => 'mail',
    'light-bulb'            => 'light-bulb',
    'lifebuoy'              => 'lifebuoy',
    'leaf'                  => 'leaf',
    'key'                   => 'key',
    'information'           => 'information',
    'home'                  => 'home',
    'heart'                 => 'heart',
    'hammer-screwdriver'    => 'hammer-screwdriver',
    'globe'                 => 'globe',
    'flask'                 => 'flask',
    'fire'                  => 'fire',
    'eye'                   => 'eye',
    'exclamation'           => 'exclamation',
    'document-zipper'       => 'document-zipper',
    'document-word'         => 'document-word',
    'document-pdf-text'     => 'document-pdf-text',
    'document-music'        => 'document-music',
    'document-film'         => 'document-film',
    'document-excel-table'  => 'document-excel-table',
    'disk'                  => 'disk',
    'cutlery'               => 'cutlery',
    'crown'                 => 'crown',
    'cup'                   => 'cup',
    'cross'                 => 'cross',
    'credit-cards'          => 'credit-cards',
    'creative-commons'      => 'creative-commons',
    'compass'               => 'compass',
    'color-swatch'          => 'color-swatch',
    'chart-pie'             => 'chart-pie',
    'chain'                 => 'chain',
    'car-red'               => 'car-red',
    'camera'                => 'camera',
    'calendar-month'        => 'calendar-month',
    'calculator'            => 'calculator',
    'cake'                  => 'cake',
    'bug'                   => 'bug',
    'briefcase'             => 'briefcase',
    'book'                  => 'book',
    'book-open-bookmark'    => 'book-open-bookmark',
    'smiley-zipper'         => 'smiley-zipper'
);

asort( $ico_list );
?>
<body onload="init();">
	<form name="SKShortcodes" action="#">
	<div class="tabs">
		<ul>
			<li id="dt_mce_pu_tab-icon" class="current"><span><a href="javascript:mcTabs.displayTab('dt_mce_pu_tab-icon','dt_mce_panel-icon');" onmousedown="return false;">Button</a></span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper">      
    
		<!-- icon panel -->
		<div id="dt_mce_panel-icon" class="panel current">
        
        <fieldset>
        
            <legend>Styling:</legend>
            <label for="iconIcon">Icon: </label>
           	<select name="iconIcon" id="dt_mce-icon" style="width: 230px">
                <option value="none">none</option>
        	    <?php foreach( $ico_list as $val=>$title ): ?>
                    <option value="<?php echo $val; ?>"><?php echo $title; ?></option>
                <?php endforeach; ?>
         	</select>
            <em>Icon of your button</em>
        
        </fieldset>
        
        <fieldset style="padding-left: 15px;">
            <legend>Options:</legend>

            <p>
	            <label for="dt_mce-size">Size:</label>
                <select name="icon_size" id="dt_mce-size" style="width: 230px">
                    <option value="">small</option>
                    <option value="middle">middle</option>
                    <option value="big">big</option>
                </select>
	            <em>Button size</em>
            </p>

            <p>
	            <label for="dt_mce-colour">Colour:</label>
                <select name="icon_colour" id="dt_mce-colour" style="width: 230px">
                    <option value="">white</option>
                    <option value="red">red</option>
                    <option value="green">green</option>
                    <option value="blue">blue</option>
                </select>
	            <em>Button colour</em>
            </p>

            <p>
	            <label for="dt_mce-text">Text:</label>
	            <input type="text" name="icon_text" id="dt_mce-text" style="width: 230px" />
	            <em>Insert the text of your button.</em>
            </p>

            <p>
                <label for="dt_mce-link">Link: <input type="text" name="icon_link" id="dt_mce-link" style="width: 230px" />
                <em>The URL your button will redirect to.</em>
            </p>

            <input type="checkbox" name="icon_target" id="dt_mce-target" value="true"/>
            <label for="dt_mce-target"> Open the link in a new window</label>

        </fieldset>
        
		</div>
		<!-- end icon panel -->
				
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
