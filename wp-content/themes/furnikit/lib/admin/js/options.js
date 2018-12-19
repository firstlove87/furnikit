jQuery(document).ready(function(){
	
	
	if(jQuery('#last_tab').val() == ''){

		jQuery('.furnikit-opts-group-tab:first').slideDown('fast');
		jQuery('#furnikit-opts-group-menu li:first').addClass('active');
	
	}else{
		
		tabid = jQuery('#last_tab').val();
		jQuery('#'+tabid+'_section_group').slideDown('fast');
		jQuery('#'+tabid+'_section_group_li').addClass('active');
		
	}
	
	
	jQuery('input[name="'+furnikit_opts.opt_name+'[defaults]"]').click(function(){
		if(!confirm(furnikit_opts.reset_confirm)){
			return false;
		}
	});
	
	jQuery('.furnikit-opts-group-tab-link-a').click(function(){
		relid = jQuery(this).attr('data-rel');
		
		jQuery('#last_tab').val(relid);
		
		jQuery('.furnikit-opts-group-tab').each(function(){
			if(jQuery(this).attr('id') == relid+'_section_group'){
				jQuery(this).show();
			}else{
				jQuery(this).hide();
			}
			
		});
		
		jQuery('.furnikit-opts-group-tab-link-li').each(function(){
				if(jQuery(this).attr('id') != relid+'_section_group_li' && jQuery(this).hasClass('active')){
					jQuery(this).removeClass('active');
				}
				if(jQuery(this).attr('id') == relid+'_section_group_li'){
					jQuery(this).addClass('active');
				}
		});
	});
	
	
	
	
	if(jQuery('#furnikit-opts-save').is(':visible')){
		jQuery('#furnikit-opts-save').delay(4000).slideUp('slow');
	}
	
	if(jQuery('#furnikit-opts-imported').is(':visible')){
		jQuery('#furnikit-opts-imported').delay(4000).slideUp('slow');
	}	
	
	jQuery('input, textarea, select').change(function(){
		jQuery('#furnikit-opts-save-warn').slideDown('slow');
	});
	
	
	jQuery('#furnikit-opts-import-code-button').click(function(){
		if(jQuery('#furnikit-opts-import-link-wrapper').is(':visible')){
			jQuery('#furnikit-opts-import-link-wrapper').fadeOut('fast');
			jQuery('#import-link-value').val('');
		}
		jQuery('#furnikit-opts-import-code-wrapper').fadeIn('slow');
	});
	
	jQuery('#furnikit-opts-import-link-button').click(function(){
		if(jQuery('#furnikit-opts-import-code-wrapper').is(':visible')){
			jQuery('#furnikit-opts-import-code-wrapper').fadeOut('fast');
			jQuery('#import-code-value').val('');
		}
		jQuery('#furnikit-opts-import-link-wrapper').fadeIn('slow');
	});
	
	
	
	
	jQuery('#furnikit-opts-export-code-copy').click(function(){
		if(jQuery('#furnikit-opts-export-link-value').is(':visible')){jQuery('#furnikit-opts-export-link-value').fadeOut('slow');}
		jQuery('#furnikit-opts-export-code').toggle('fade');
	});
	
	jQuery('#furnikit-opts-export-link').click(function(){
		if(jQuery('#furnikit-opts-export-code').is(':visible')){jQuery('#furnikit-opts-export-code').fadeOut('slow');}
		jQuery('#furnikit-opts-export-link-value').toggle('fade');
	});
	
	

	
	
	
});