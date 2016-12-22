function get_sarea() {
	var area = $('#area').val();
	var requestFrom = $('#addNewBldng').val();
	if (area === "@add@") {
		$('#area').hide();
        $('#area_input').show();
        $('#sarea').hide();
        $('#sarea_input').show();
        $('#street').hide();
        $('#street_input').show();
	} else {
		$('#area_input').val(area);
		$.ajax({
			type: "POST",
			url: "/actions/act_stng_updt.php",
			data: {area: area, sub_area: true},
			success: function(html) {
				if (html == "") {
					$("#sarea").html('<option value="">Select A Sub Area</option>');
				} else if (requestFrom === "@add@") {
					$("#sarea").html(html+'<option value="@add@">-- Enter A New SubArea --</option>');
				} else {
					$("#sarea").html(html);
				}			
				$("#street").html('<option value="">Select A Street Name</option>');
				$("#bldng").html('<option value="">Select A Building Name</option>');
			}
		});
	}
}
function get_street() {
	var area = $('#area').val();
	var sarea = $('#sarea').val();
	var requestFrom = $('#addNewBldng').val();
	if (sarea === "@add@") {
		$('#sarea').hide();
        $('#sarea_input').show();
        $('#street').hide();
        $('#street_input').show();
	} else {
		$('#area_input').val(area);
		$('#sarea_input').val(sarea);
		$.ajax({
			type: "POST",
			url: "/actions/act_stng_updt.php",
			data: {area: area, sarea: sarea, get_street: true},
			success: function(html) {
				if (html == "") {
					$("#street").html('<option value="">Select A Street Name</option>');
				} else if (requestFrom === "@add@") {
					$("#street").html(html+'<option value="@add@">-- Enter A New Street --</option>');
				} else {
					$("#street").html(html);
				}
				$("#bldng").html('<option value="">Select A Building Name</option>');
			}
		});
	}
}
function get_bldng() {
	var area = $('#area').val();
	var sarea = $('#sarea').val();
	var street = $('#street').val();
	var requestFrom = $('#addNewBldng').val();
	if (street === "@add@") {
		$('#street').hide();
        $('#street_input').show();
	} else if (requestFrom === undefined) {
		$('#area_input').val(area);
		$('#sarea_input').val(sarea);
		$('#street_input').val(street);
		$.ajax({
			type: "POST",
			url: "/actions/act_stng_updt.php",
			data: {area: area, sarea: sarea, street: street, building: true},
			success: function(html) {
				if (html == "") {
					$("#bldng").html('<option value="">Select A Building Name</option>');
				} else {
					$("#bldng").html(html);
				}
			}
		});
	}
}