jQuery(document).ready(function($) {
	$("FORM#scormi_settings input#agreeToScormiNet").on("change", function(e){
		var saveButton = $("FORM#scormi_settings input#save-settings");
		if ( $(e.target).attr("checked") == "checked" )
			saveButton.removeAttr("disabled");
		else
			saveButton.attr("disabled", "disabled");
	});
});

