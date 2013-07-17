var zoomDone = new Array();		

function zoomSwitch(imagename){	
	jQuery("#zoomWrapper a").hide();
	jQuery("#image" + imagename).show();
	jQuery("#anchor_image" + imagename).attr("style", "display:block");
				
	if(!zoomDone.in_array(imagename)) {
		jQuery("#anchor_image" + imagename).jqzoom(zoomOptions);
		zoomDone.push(imagename);
	}
}
	
Array.prototype.in_array = function(p_val) {
	for(var i = 0, l = this.length; i < l; i++) {
		if(this[i] == p_val) {
			return true;
		}
	}
	return false;
}
