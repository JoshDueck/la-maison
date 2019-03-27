<html>
<link rel="stylesheet" href="includes/product_details.css" type="text/css" media="screen" />
<head>
</head>
<body>
<article>
<?php

include("includes/head.php"); // inserts header at the top

include("mysqli_connect.php"); // connection string is $dbc	

$product_id = $_GET['product_id'];

// select all the other data
$query = "select product_name, product_image, product_price, product_description from PRODUCT where product_id = $product_id;";

// check if there was an error finding the product

$result = mysqli_query($dbc, $query);

	if ($result == false) {
		echo "Error: ".mysqli_error($dbc);
		
	}
	else { // product was found in the database
	
		while($prod_row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
			echo "
				<div id=\"img_container\">
			<img src=\"".$prod_row['product_image']."\" />
		</div> <!-- end of img_container -->
		<div id=\"details_container\">
		
		<div id=\"name_container\">
		
			<h2>".$prod_row['product_name']."</h2>
		
		</div> <!-- end of name_container -->
		
		<div id=\"price_container\">
		
			<h3>$".$prod_row['product_price']."</h3>
		
		</div> <!-- end of price_container -->
		
		<div id=\"buttons_container\">
		
			<button id = \"add_to_cart\">Add to cart</button>
				
				<div id=\"added_to_cart\">
				
					<input type=\"button\" id='decrement_btn' value=\"-\" />
					<input type=\"number\" id='quantity' value='0' />
					<input type=\"button\" id='increment_btn' value=\"+\" />
				
				</div> <!-- end of added_to_cart -->
		
		</div> <!-- end of buttons_container -->
		
		</div> <!-- end of details_container -->
		
		<div id=\"description_container\">
			<h3>Details</h3><p>
			";
			$proddesc = str_replace("\\n","<br />",$prod_row['product_description']);
			$proddesc = str_replace("\"\"","\"",$proddesc);
			echo str_replace("\\t-","• ",$proddesc);
			echo "</p></div> <!-- end of description_container -->
	
			";
		}
}

?>
	
</article>

<?php

include('includes/footer.html');

?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="includes/product_details.js"></script>
</body>
</html>