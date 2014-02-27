<?php
function dt_core_admin_setup_styles() {
	// styling metaboxes
	wp_enqueue_style('dt_core_admin-mbox_magick_style', get_template_directory_uri().'/css/admin/admin_mbox_magick.css', array(), false);
}
add_action('admin_enqueue_scripts', 'dt_core_admin_setup_styles');