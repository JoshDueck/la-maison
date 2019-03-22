$(document).ready(function () {

	$("#add_products_btn").on("click", function(){
		$("#products_container").fadeOut();
		$("#addproduct").fadeIn();
		
	});

	$("#changes_btn").on("click", function(){
		$("#addproduct").fadeOut();
		$("#products_container").fadeIn();
		
	});	
	
});