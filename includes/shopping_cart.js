$(document).ready(function(){

/*### start of increment_btn and decrement_btn ###*/
	
	// prod
	$("#decrement_btn0").click(function(){$decrement("#quantity0");});
	$("#decrement_btn1").click(function(){$decrement("#quantity1");});
	$("#decrement_btn2").click(function(){$decrement("#quantity2");});
	$("#decrement_btn3").click(function(){$decrement("#quantity3");});
	$("#decrement_btn4").click(function(){$decrement("#quantity4");});
	$("#decrement_btn5").click(function(){$decrement("#quantity5");});
	$("#decrement_btn6").click(function(){$decrement("#quantity6");});
	$("#decrement_btn7").click(function(){$decrement("#quantity7");});
	$("#decrement_btn8").click(function(){$decrement("#quantity8");});
	$("#decrement_btn9").click(function(){$decrement("#quantity9");});
	$("#decrement_btn10").click(function(){$decrement("#quantity10");});
	
	$("#increment_btn0").click(function(){$increment("#quantity0");});
	$("#increment_btn1").click(function(){$increment("#quantity1");});
	$("#increment_btn2").click(function(){$increment("#quantity2");});
	$("#increment_btn3").click(function(){$increment("#quantity3");});
	$("#increment_btn4").click(function(){$increment("#quantity4");});
	$("#increment_btn5").click(function(){$increment("#quantity5");});
	$("#increment_btn6").click(function(){$increment("#quantity6");});
	$("#increment_btn7").click(function(){$increment("#quantity7");});
	$("#increment_btn8").click(function(){$increment("#quantity8");});
	$("#increment_btn9").click(function(){$increment("#quantity9");});
	$("#increment_btn10").click(function(){$increment("#quantity10");});
	
/*### end of increment_btn and decrement_btn ###*/	
	
	
	function $increment($increment_field){
		$($increment_field).val(Math.abs($($increment_field).val()));
		$($increment_field).val(parseInt($($increment_field).val()) + 1);
		// get the id num of the tag and add it to the tag variable
		var $sub = $increment_field.substring(9);
		var $subtotal = $("#subtotal".concat($sub));
		// get the price and put the result in subtotal
		var $price = $("#price".concat($sub));
		$price = $price.text();
		$price = $price.substring(1);
		var $mult = parseFloat($price) * parseInt($($increment_field).val());
		$subtotal.html("=\$" + $mult.toFixed(2));
		$updateTotal();
		$savechangesFade();
	} // end of increment function
	
	function $decrement($decrement_field){
		$($decrement_field).val(Math.abs($($decrement_field).val()));
		if ($($decrement_field).val() > 1){
			$($decrement_field).val(parseInt($($decrement_field).val()) - 1);
			// get the id num of the tag and add it to the tag variable
			var $sub = $decrement_field.substring(9);
			var $subtotal = $("#subtotal".concat($sub));
			// get the price and put the result in subtotal
			var $price = $("#price".concat($sub));
			$price = $price.text();
			$price = $price.substring(1);
			var $mult = parseFloat($price) * parseInt($($decrement_field).val());
			$subtotal.html("=\$" + $mult.toFixed(2));
			$updateTotal();
			$savechangesFade();
		}
	} // end of decrement function
	
	
	function $savechangesFade(){
		$("#save_changes_btn").fadeIn();
	}

	function $updateTotal(){
		var $total = 0;
		for (let $i=0; $i < 11; $i++){
			var $subtotal = $("#subtotal".concat($i)).text();

			if ($subtotal.length > 0){
				$subtotal = $subtotal.substring(2);
				$subtotal = parseFloat($subtotal);
				$total += $subtotal;
			}
		}
		$("#totalamt").val($total.toFixed(2));
		$("#total").html("Total: \$" + $total.toFixed(2));
		
	}


	
}); // end of ready function