jQuery(document).ready(function(){
	
	
	if(jQuery('#last_tab').val() == ''){

		jQuery('.zr-opts-group-tab:first').slideDown('fast');
		jQuery('#zr-opts-group-menu li:first').addClass('active');
	
	}else{
		
		tabid = jQuery('#last_tab').val();
		jQuery('#'+tabid+'_section_group').slideDown('fast');
		jQuery('#'+tabid+'_section_group_li').addClass('active');
		
	}
	
	
	jQuery('input[name="'+zr_opts.opt_name+'[defaults]"]').click(function(){
		if(!confirm(zr_opts.reset_confirm)){
			return false;
		}
	});
	
	jQuery('.zr-opts-group-tab-link-a').click(function(){
		relid = jQuery(this).attr('data-rel');
		
		jQuery('#last_tab').val(relid);
		
		jQuery('.zr-opts-group-tab').each(function(){
			if(jQuery(this).attr('id') == relid+'_section_group'){
				jQuery(this).show();
			}else{
				jQuery(this).hide();
			}
			
		});
		
		jQuery('.zr-opts-group-tab-link-li').each(function(){
				if(jQuery(this).attr('id') != relid+'_section_group_li' && jQuery(this).hasClass('active')){
					jQuery(this).removeClass('active');
				}
				if(jQuery(this).attr('id') == relid+'_section_group_li'){
					jQuery(this).addClass('active');
				}
		});
	});
	
	
	
	
	if(jQuery('#zr-opts-save').is(':visible')){
		jQuery('#zr-opts-save').delay(4000).slideUp('slow');
	}
	
	if(jQuery('#zr-opts-imported').is(':visible')){
		jQuery('#zr-opts-imported').delay(4000).slideUp('slow');
	}	
	
	jQuery('input, textarea, select').change(function(){
		jQuery('#zr-opts-save-warn').slideDown('slow');
	});
	
	
	jQuery('#zr-opts-import-code-button').click(function(){
		if(jQuery('#zr-opts-import-link-wrapper').is(':visible')){
			jQuery('#zr-opts-import-link-wrapper').fadeOut('fast');
			jQuery('#import-link-value').val('');
		}
		jQuery('#zr-opts-import-code-wrapper').fadeIn('slow');
	});
	
	jQuery('#zr-opts-import-link-button').click(function(){
		if(jQuery('#zr-opts-import-code-wrapper').is(':visible')){
			jQuery('#zr-opts-import-code-wrapper').fadeOut('fast');
			jQuery('#import-code-value').val('');
		}
		jQuery('#zr-opts-import-link-wrapper').fadeIn('slow');
	});
	
	
	
	
	jQuery('#zr-opts-export-code-copy').click(function(){
		if(jQuery('#zr-opts-export-link-value').is(':visible')){jQuery('#zr-opts-export-link-value').fadeOut('slow');}
		jQuery('#zr-opts-export-code').toggle('fade');
	});
	
	jQuery('#zr-opts-export-link').click(function(){
		if(jQuery('#zr-opts-export-code').is(':visible')){jQuery('#zr-opts-export-code').fadeOut('slow');}
		jQuery('#zr-opts-export-link-value').toggle('fade');
	});
	
	

	
	
	
});