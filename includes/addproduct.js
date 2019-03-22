$(document).ready(function () {

	$("#add_products_btn").on("click", function(){
		$("#products_container").fadeOut();
		$("#addproduct").fadeIn();
		
	});

	$("#changes_btn").on("click", function(){
		$("#addproduct").fadeOut();
		$("#products_container").fadeIn();
		
	});	

	//Results (initially hidden)
	/*
	$("#topResults").hide();
	$("#results").hide();
	$("#score").hide();
	
	//if they forgot to fill in a question, their score will not show
	if (count == 0) {
		$("#topResults").html("You scored " + score + " out of 5");
		$("#results").html("<h3 class='redWithYellow'>RESULTS FOR " + name + ": You scored " + score + " out of 5</h3>");
		$("#topResults").fadeIn(3000);
		$("#results").fadeIn(3000);
		
		//flashing  'PERFECT' message
		if (score == 5) {
			$("#score").html("<h3 class='redWithYellow'>You scored 5/5. Perfect!</h3>");
			for (var i = 0; i < 10; i++) {
				$("#score").fadeIn(500);
				$("#score").fadeOut(500);
			}
			$("#score").fadeIn(500);
		}
	}
	*/
});