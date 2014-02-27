(function() {
	var command_name = 'dt_mce_command-gallery';
    var plugin_name = 'dt_mce_plugin_shortcode_gallery';
	
	tinymce.create( 'tinymce.plugins.' + plugin_name, {		 
		init : function( ed, url ) {
			
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand(command_name, function() {
				ed.windowManager.open({
					
                    resizable: false,
					file : url + '/window.php',
					width : 360 + ed.getLang( plugin_name + '.delta_width', 0 ),
					height : 360 + ed.getLang( plugin_name + '.delta_height', 0 ),
					inline : 1
					
				}, {
					
					plugin_url : url // Plugin absolute URL
					
				});
			});

			// Register example button
			ed.addButton( plugin_name, {
				
				title : 'Photo Albums',
				cmd : command_name,
				image : url + '/sc-album.png'
				
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add( function( ed, cm, n ) {
				
				cm.setActive( command_name, n.nodeName == 'IMG');
				
			});
		}
	});

	// Register plugin
	tinymce.PluginManager.add( plugin_name, tinymce.plugins.dt_mce_plugin_shortcode_gallery );
	
})();
