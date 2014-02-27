// add hide/show effect to checkbox list
jQuery(document).ready( function() {
    var i = 1;
    jQuery('.dt-widget-switcher input').live( 'click', function() {
        if( jQuery(this).attr('name').search('__i__') == -1 ) {
            var container = jQuery(this).parents('.dt-widget-switcher').next('div.hide-if-js');
            if( 'all' == jQuery(this).val() ) {
                container.hide();
            }else {
                container.show();
            }
        }
    } );
	jQuery('.dt-widget-switcher input:checked').click();
});

// do some stuff on widget save
jQuery(document).ajaxSuccess(function(e, xhr, settings) {
	var search_str = '%5Bselect%5D=';
	if( settings.data.search('action=save-widget') != -1 &&
        settings.data.search(search_str) != -1 )
    {   
        // do some stuff
		jQuery('.dt-widget-switcher input:checked').click();
	} 
});
