jQuery(function($) {
	'use strict';

	// Shortcodes and Search
	 $(".uif_type_of_feed").change(function(){
	 	if($(this).val() == "by_name"){
	 		$("#div_by_name").show();
	 		$("#generate_button").show();

	 	}

	 	if($(this).val() == ""){
	 		$("#div_by_name").hide();
	 		$("#generate_button").hide();
	 	}
	 });

	 // SHORTCODES
	 $("#uif_shortcode_form").submit(function(event){
	 	event.preventDefault();
	 	if($(".uif_type_of_feed option:selected").val() == 'by_name'){
		 	var uif_username = $("#uif_username").val();
		 	var uif_inst_number = $("#uif_inst_number").val();
		 	var uif_version = $('#uif_version').val();
		 	var shortcode = "[UIF_BY_USER username='"+uif_username+"' number='"+uif_inst_number+"' version ='"+uif_version+"']";
	 	}

		jQuery.ajax({
		type: "POST",
		url: ajaxurl,
		data: { action: 'uif_save_shortcodes', shortcode: shortcode},
		success: function(response){
			$("#uif_shortcode_div").html(response);
		},
		error: function(error){
			console.log("bad");
		}
		});
	 });

	 // FUNCTIONS
	 $("#uif_url_form").submit(function(event){
	 	event.preventDefault();
	 	var site_url = uif_ajax_object.site_url;
	 	if($(".uif_type_of_feed option:selected").val() == 'by_name'){
		 	var uif_username = $("#uif_username").val();
		 	var uif_inst_number = $("#uif_inst_number").val();
		 	var url = site_url+"/?rest_route=/uif/uif_by_name/"+uif_username+"/"+uif_inst_number+"/";
	 	}

		jQuery.ajax({
		type: "POST",
		url: ajaxurl,
		data: { action: 'uif_save_urls', url: url},
		success: function(response){
			$("#uif_urls_div").html(response);
		},
		error: function(error){
			console.log("bad");
		}
		});
	 });



});
