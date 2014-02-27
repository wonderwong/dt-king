(function() {
	var command_name = 'dt_mce_command-clear';
	var plugin_name = 'dt_mce_plugin_shortcode_clear';

	tinymce.create( 'tinymce.plugins.' + plugin_name, {
		init : function( ed, url ) {

			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand(command_name, function() {
				if(window.tinyMCE) {
					//var tagtext = '[clear]';
					//window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);

					var node			= tinyMCE.activeEditor.selection.getNode(),
						parents			= tinyMCE.activeEditor.dom.getParents(node).reverse(),
						oldestParent	= parents[2];
						blank			= document.createElement('p');

					blank.innerHTML = "&nbsp;";

					if (typeof oldestParent != "undefined") {
						tinyMCE.activeEditor.dom.insertAfter(blank, oldestParent);
						//oldestParent.parentNode.insertBefore(blank, oldestParent);
					} else if (typeof node != "undefined") {
						tinyMCE.activeEditor.dom.insertAfter(blank, node);
						//node.parentNode.insertBefore(blank, node);
					} else {
						//alert("bastard!");
					}
//console.log(blank);
//tinyMCE.activeEditor.selection.select(blank);


var range = document.createRange();
var textNode = blank;
range.setStart(textNode, 0);
range.setEnd(textNode, 0);
//window.getSelection().addRange(range);

tinyMCE.activeEditor.selection.setRng(range);
//console.log(test)

					//Peforms a clean up of the current editor HTML. 
					//tinyMCEPopup.editor.execCommand('mceCleanup');
				}
			});

			// Register example button
			ed.addButton( plugin_name, {
				title : 'Clear',
				cmd : command_name,
				image : url + '/sc-clear.png'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			/*ed.onNodeChange.add( function( ed, cm, n ) {
				cm.setActive( command_name, n.nodeName == 'IMG');
			});*/
		}
	});

	// Register plugin
	tinymce.PluginManager.add( plugin_name, tinymce.plugins.dt_mce_plugin_shortcode_clear );

})();