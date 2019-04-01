$(document).ready(function(){

/*### start of increment_btn and decrement_btn ###*/
	
	// prod
	$("#decrement_btn0").click(function (){$decrement($("#quantity0"));});
	$("#decrement_btn1").click(function(){$decrement($("#quantity1"));});
	$("#decrement_btn2").click(function(){$decrement($("#quantity2"));});
	$("#decrement_btn3").click(function(){$decrement($("#quantity3"));});
	$("#decrement_btn4").click(function(){$decrement($("#quantity4"));});
	$("#decrement_btn5").click(function(){$decrement($("#quantity5"));});
	$("#decrement_btn6").click(function(){$decrement($("#quantity6"));});
	$("#decrement_btn7").click(function(){$decrement($("#quantity7"));});
	$("#decrement_btn8").click(function(){$decrement($("#quantity8"));});
	$("#decrement_btn9").click(function(){$decrement($("#quantity9"));});
	$("#decrement_btn10").click(function(){$decrement($("#quantity10"));});
	
	$("#increment_btn0").click(function(){$increment($("#quantity0"));});
	$("#increment_btn1").click(function(){$increment($("#quantity1"));});
	$("#increment_btn2").click(function(){$increment($("#quantity2"));});
	$("#increment_btn3").click(function(){$increment($("#quantity3"));});
	$("#increment_btn4").click(function(){$increment($("#quantity4"));});
	$("#increment_btn5").click(function(){$increment($("#quantity5"));});
	$("#increment_btn6").click(function(){$increment($("#quantity6"));});
	$("#increment_btn7").click(function(){$increment($("#quantity7"));});
	$("#increment_btn8").click(function(){$increment($("#quantity8"));});
	$("#increment_btn9").click(function(){$increment($("#quantity9"));});
	$("#increment_btn10").click(function(){$increment($("#quantity10"));});
	
/*### end of increment_btn and decrement_btn ###*/	
	
	
	
	function $increment($increment_field){
		$increment_field.val(parseInt($increment_field.val()) + 1);
		$increment_field.css("color", "red");
	} // end of increment function
	
	function $decrement($decrement_field){
		if ($decrement_field.val() > 1){
			$decrement_field.val(parseInt($decrement_field.val()) - 1);
			$decrement_field.css("color", "green");
		}
	} // end of decrement function
	
	

	
}); // end of ready function