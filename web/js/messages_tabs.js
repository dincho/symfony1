
jQuery(document).ready(function(){
	jQuery("#messages_group a").click(function(){
		var formId = jQuery(this).attr("rel");
		jQuery("form").hide();
		jQuery("#"+formId).show();
		jQuery("#messages_group").find("a").removeClass("active_group");
		jQuery(this).addClass("active_group");
	});
	
	
	
	var anchor = window.location.hash;
	if(anchor){
		var formId = jQuery(anchor+"_messages").attr("rel");
		jQuery("form").hide();
		jQuery("#"+formId).show();
		jQuery("#messages_group").find("a").removeClass("active_group");
		jQuery(anchor+"_messages").addClass("active_group");
	}
});
