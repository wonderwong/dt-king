jQuery(document).ready( function() {
	
	var dt_boxes = new Object();
	// new!
	var dt_nonces = new Object();
	
	function dt_find_boxes() {
		jQuery('.postbox').each(function(){
			var this_id = jQuery(this).attr('id');
			if(this_id.match(/dt_page_box-/i)){
				dt_boxes[this_id] = '#'+this_id;
				//new!
				if( typeof (nonce_field = jQuery(this).find('input[type="hidden"][name$="_nonce"]').attr('id')) != 'undefined' ) {
					dt_nonces[this_id] = '#'+nonce_field;
				}
			}
		});
	}
	// new!
	dt_find_boxes();
/*
	function dt_toggle_box_options() {
		if( active_box.length ) {
			jQuery(".showhide", jQuery(active_box)).each(function () {
				var ee = this;
				jQuery("input[type=radio]", ee).change(function () {
					jQuery(".list", jQuery(active_box)).hide();
					if ( jQuery(this).attr("checked") ) {
						jQuery(".list", ee).show();
					}else {
						jQuery(".list", ee).hide();
					}
				});
				jQuery("input[type=radio]:checked", ee).change();
			});
		}
	}
*/
//	var active_box = '';
	function dt_toggle_boxes() {
		for(var key in dt_boxes) {
			jQuery(dt_boxes[key]).hide();
			//new!
			if( 'dt_blocked_nonce' != jQuery(dt_nonces[key]).attr('class') ) {
				jQuery(dt_nonces[key]).attr('name', 'blocked_'+jQuery(dt_nonces[key]).attr('name'));
				jQuery(dt_nonces[key]).attr('class', 'dt_blocked_nonce');
			}
		}
//		active_box = '';
		for(var i=0;i<arguments.length;i++) {
			jQuery(arguments[i]).show();
			// new!
			var nonce_key = arguments[i].slice(1);
			if( 'dt_blocked_nonce' == jQuery(dt_nonces[nonce_key]).attr('class') ) {
				var new_name = jQuery(dt_nonces[nonce_key]).attr('name').replace("blocked_", "");
				jQuery(dt_nonces[nonce_key]).attr('name', new_name);
				jQuery(dt_nonces[nonce_key]).attr('class', '');
			}
//			active_box = arguments[i];
//			dt_toggle_box_options();
		}
	}

	jQuery("#page_template").change(function() {
		
		switch( jQuery(this).val() ) {
			
			// albums
			case 'dt-albums-sidebar.php':
				dt_toggle_boxes('#dt_page_box-albums_list', '#dt_page_box-albums_options', '#dt_page_box-footer_options', '#dt_page_box-sidebar_options');
				break;
				
			case 'dt-albums-fullwidth.php':
				dt_toggle_boxes('#dt_page_box-albums_list', '#dt_page_box-albums_options', '#dt_page_box-footer_options');
				break;
			
			// photos
			case 'dt-photos-sidebar.php':
				dt_toggle_boxes('#dt_page_box-photos_albums', '#dt_page_box-photos_options', '#dt_page_box-footer_options', '#dt_page_box-sidebar_options');
				break;
				
			case 'dt-photos-fullwidth.php':
				dt_toggle_boxes('#dt_page_box-photos_albums', '#dt_page_box-photos_options', '#dt_page_box-footer_options');
				break;
			
			// portfolio
			case 'dt-portfolio-sidebar.php':
				dt_toggle_boxes('#dt_page_box-portfolio_category', '#dt_page_box-portfolio_options', '#dt_page_box-footer_options', '#dt_page_box-sidebar_options');
				break;
				
			case 'dt-portfolio-fullwidth.php':
				dt_toggle_boxes('#dt_page_box-portfolio_category', '#dt_page_box-portfolio_options', '#dt_page_box-footer_options');
				break;
			
			// slideshow
			case 'dt-slideshow-sidebar.php':
				dt_toggle_boxes('#dt_page_box-slideshows_list', '#dt_page_box-slideshows_options', '#dt_page_box-footer_options', '#dt_page_box-sidebar_options');
				break;
				
			case 'dt-slideshow-fullwidth.php':
				dt_toggle_boxes('#dt_page_box-slideshows_list', '#dt_page_box-slideshows_options', '#dt_page_box-footer_options');
				break;
			
			// video
			case 'dt-videogal-sidebar.php':
				dt_toggle_boxes('#dt_page_box-video_category', '#dt_page_box-video_options', '#dt_page_box-footer_options', '#dt_page_box-sidebar_options');
				break;
				
			case 'dt-videogal-fullwidth.php':
				dt_toggle_boxes('#dt_page_box-video_category', '#dt_page_box-video_options', '#dt_page_box-footer_options');
				break;
			
			// page
			case 'dt-page-sidebar.php':
				dt_toggle_boxes('#dt_page_box-footer_options', '#dt_page_box-sidebar_options');
				break;
				
			case 'dt-page-fullwidth.php':
				dt_toggle_boxes('#dt_page_box-footer_options');
				break;
			
			// blog
			case 'dt-blog.php':
				dt_toggle_boxes('#dt_page_box-blog_cats', '#dt_page_box-blog_options', '#dt_page_box-footer_options', '#dt_page_box-sidebar_options');
				break;
			
			// catalog
			case 'dt-catalog.php':
				dt_toggle_boxes('#dt_page_box-catalog_category', '#dt_page_box-catalog_options', '#dt_page_box-footer_options', '#dt_page_box-sidebar_options');
				break;
                
			// homepage with blog 
			case 'dt-homepage-blog.php':
				dt_toggle_boxes('#dt_page_box-slideshows_list', '#dt_page_box-slideshows_options', '#dt_page_box-blog_cats', '#dt_page_box-blog_options', '#dt_page_box-footer_options', '#dt_page_box-sidebar_options');
				break;
			
			default:
				dt_toggle_boxes();
			break;

		}
		
	});
	jQuery("#page_template").trigger('change');

});
