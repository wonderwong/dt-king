<?php
class dt_add_mce_button {
    public $plugin_name = '';
    public $plugin_dir = '';
    public $debug = false;
    
    function __construct( $p_name, $p_dir, $deb ) {
        $this->plugin_name = $p_name;
        $this->plugin_dir = $p_dir;
        $this->debug = $deb;
        
        // Modify the version when tinyMCE plugins are changed.
        add_filter('tiny_mce_version', array(&$this, 'change_tinymce_version') );
        
        // init process for button control
        add_action('init', array (&$this, 'add_buttons') );
    }
    
    function add_SKShortsPhotos_button()  {
        
        // Modify the version when tinyMCE plugins are changed.
        add_filter('tiny_mce_version', array(&$this, 'change_tinymce_version') );
        
        // init process for button control
        add_action('init', array (&$this, 'addShort_buttons') );
        
    }

    function add_buttons() {
        // Don't bother doing this stuff if the current user lacks permissions
        if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) return;
        
        // Add only in Rich Editor mode
        if ( get_user_option('rich_editing') == 'true') {
            
            // add the button for wp2.5 in a new way
            add_filter("mce_external_plugins", array(&$this, "add_plugin" ), 5);
            add_filter('mce_buttons_3', array(&$this, 'register_button' ), 5);
            
        }
    }
    
    // used to insert button in wordpress 2.5x editor
    function register_button($buttons) {
        
        array_push( $buttons, '', $this->plugin_name );
        return $buttons;
        
    }
    
    // Load the TinyMCE plugin : editor_plugin.js (wp2.5)
    function add_plugin($plugin_array) {    
    
        global $ShortcodeKidPath;
        $plugin_array[$this->plugin_name] =  $ShortcodeKidPath . 'includes/' . $this->plugin_dir . '/plugin.js';		
        
        return $plugin_array;
        
    }
    
    function change_tinymce_version($version) {
        return ++$version;
    }
    
    function get_info() {
        var_dump( $this->plugin_name );
        var_dump( $this->plugin_dir );
    }
}
?>