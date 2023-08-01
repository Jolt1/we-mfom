// JavaScript Document

var donor_loc = document.getElementById("loc");
var special_gifts_subcategory = document.getElementById("special-gifts-subcategory");
		
if(donor_loc.value == 24) {
		$(special_gifts_subcategory).show();
	} else {
		$(special_gifts_subcategory).hide();
	}

donor_loc.addEventListener("input", function() {
	if(donor_loc.value == 24) {
		var special_gifts_subcategory = document.getElementById("special-gifts-subcategory");
		$("#special-gifts-subcategory").show();
	} else {
		$("#special-gifts-subcategory").hide();
	}	
});