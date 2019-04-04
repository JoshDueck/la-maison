$(document).ready(function () {

	$("#decrement_btn").on("click", function(){
		if ($("#quantity").val() > 1){
			$("#quantity").val(parseInt($("#quantity").val()) - 1);
		}
		
	}); // end of decrement_btn
	
	$("#increment_btn").on("click", function(){
		$("#quantity").val(parseInt($("#quantity").val()) + 1);
		
	}); // end of increment_btn
	
	/*
	$('button').click(function() {
		
        var input = this;
        input.disabled = true;
        
		setTimeout(function() {
           input.disabled = false;
        }, 3000);

    }); 
	*/
	
}); // end of ready function