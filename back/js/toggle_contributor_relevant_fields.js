// JavaScript Document

var donor_location = document.getElementById("loc");

// what is the initial state of the selection? 
var initial_location = donor_location.value;

if(initial_location >= 8 && initial_location <= 22) {
	$(".contributor-field").show();
} else {
	$(".contributor-field").hide();
}

donor_location.addEventListener("input", function() {
	
	// The selected one is a contributor, and contributor fields should be toggled on (shown to the user)
	if(this.value >= 8 && this.value <= 22) {
		$(".contributor-field").show();
	} else {
		$(".contributor-field").hide();
	}
});