$(document).ready(function () {

	$("#add_to_cart").on("click", function(){
		$("#added_to_cart").fadeIn();
		
	}); // end of add_to_cart
	
	$("#decrement_btn").on("click", function(){
		if ($("#quantity").val() > 0){
			$("#quantity").val(parseInt($("#quantity").val()) - 1);
		}
		
	}); // end of decrement_btn
	
	$("#increment_btn").on("click", function(){
		$("#quantity").val(parseInt($("#quantity").val()) + 1);
		
	}); // end of increment_btn
	
	$('button').click(function() {
		
        var input = this;
        input.disabled = true;
        input.val("Product added");
		setTimeout(function() {
           input.disabled = false;
        }, 3000);

    }); 
	

}); // end of ready function