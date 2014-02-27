(function() {
	
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('skshorts_highlight');
	
	tinymce.create('tinymce.plugins.skshorts_highlight', {		 
		init : function(ed, url) {
			
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('mceskshorts_highlight', function() {
				
				ed.windowManager.open({
					
					file : url + '/window.php',
					width : 360 + ed.getLang('skshorts_highlight.delta_width', 0),
					height : 336 + ed.getLang('skshorts_highlight.delta_height', 0),
					inline : 1
					
				}, {
					
					plugin_url : url // Plugin absolute URL
					
				});
			});

			// Register example button
			ed.addButton('skshorts_highlight', {
				
				title : 'Highlight',
				cmd : 'mceskshorts_highlight',
				image : url + '/sc-text-highlight.png'
				
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				
				cm.setActive('mceskshorts_highlight', n.nodeName == 'IMG');
				
			});
		}, 
		getInfo : function() {
			
			return {
				
					longname : "Shortcode Kid Shortcodes Framework",
					author : 'Skortcode Kid',
					authorurl : 'http://www.shortcodekid.com/',
					infourl : 'http://www.shortcodekid.com/',
					version : "1.0"
					
			};
			
		}
		
	});

	// Register plugin
	tinymce.PluginManager.add('skshorts_highlight', tinymce.plugins.skshorts_highlight);
	
})();
