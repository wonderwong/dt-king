(function() {
	
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('skshorts_notifications');
	
	tinymce.create('tinymce.plugins.skshorts_notifications', {		 
		init : function(ed, url) {
			
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('mceskshorts_notifications', function() {
				
				ed.windowManager.open({
					
					file : url + '/window.php',
					width : 360 + ed.getLang('skshorts_notifications.delta_width', 0),
					height : 380 + ed.getLang('skshorts_notifications.delta_height', 0),
					inline : 1
					
				}, {
					
					plugin_url : url // Plugin absolute URL
					
				});
			});

			// Register example button
			ed.addButton('skshorts_notifications', {
				
				title : 'Notification Boxes',
				cmd : 'mceskshorts_notifications',
				image : url + '/notifications.png'
				
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				
				cm.setActive('mceskshorts_notifications', n.nodeName == 'IMG');
				
			});
		}, 
		getInfo : function() {
			
			return {
				
					longname : "Shortcode Kid Shortcodes Framework",
					author : 'Shortcode Kid',
					authorurl : 'http://www.shortcodekid.com/',
					infourl : 'http://www.shortcodekid.com/',
					version : "1.0"
					
			};
			
		}
		
	});

	// Register plugin
	tinymce.PluginManager.add('skshorts_notifications', tinymce.plugins.skshorts_notifications);
	
})();
