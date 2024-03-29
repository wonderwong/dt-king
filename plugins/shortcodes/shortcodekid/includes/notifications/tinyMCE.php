<?php

	class add_SKShortsNotifications_button {
	
		var $pluginname = "skshorts_notifications";
		
		function add_SKShortsNotifications_button()  {
			
			// Modify the version when tinyMCE plugins are changed.
			add_filter('tiny_mce_version', array(&$this, 'change_tinymce_version') );
			
			// init process for button control
			add_action('init', array (&$this, 'addShortnotifications') );
			
		}
	
		function addShortnotifications() {
		
			// Don't bother doing this stuff if the current user lacks permissions
			if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) return;
			
			// Add only in Rich Editor mode
			if ( get_user_option('rich_editing') == 'true') {
			 
				// add the button for wp2.5 in a new way
				add_filter("mce_external_plugins", array(&$this, "add_SKShortsNotifications_plugin" ), 5);
				add_filter('mce_buttons_3', array(&$this, 'register_SKShortsNotifications_button' ), 5);
				
			}
		}
		
		// used to insert button in wordpress 2.5x editor
		function register_SKShortsNotifications_button($buttons) {
		
			array_push($buttons, "", $this->pluginname );
			return $buttons;
			
		}
		
		// Load the TinyMCE plugin : (wp2.5)
		function add_SKShortsNotifications_plugin($plugin_array) { 

			global $ShortcodeKidPath;
			$plugin_array[$this->pluginname] =  $ShortcodeKidPath.'includes/notifications/notifications.js';
		
			return $plugin_array;
			
		}
		
		function change_tinymce_version($version) {
			return ++$version;
		}
		
	}

	// Call it now
	$tinymce_button = new add_SKShortsNotifications_button ();


?>