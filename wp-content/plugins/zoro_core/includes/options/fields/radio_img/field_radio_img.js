/*
 *
 * ZR_Options_radio_img function
 * Changes the radio select option, and changes class on images
 *
 */
function zr_radio_img_select(relid, labelclass){
	jQuery(this).prev('input[type="radio"]').prop('checked');

	jQuery('.zr-radio-img-'+labelclass).removeClass('zr-radio-img-selected');	
	
	jQuery('label[for="'+relid+'"]').addClass('zr-radio-img-selected');
}//function