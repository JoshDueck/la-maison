<html>
<link rel="stylesheet" href="includes/product_details.css" type="text/css" media="screen" />
<head>
</head>
<body>
<?php
session_start();


include("includes/head.php"); // inserts header at the top

echo "<article>";

include("mysqli_connect.php"); // connection string is $dbc	


$quantity = $_GET['quantity'];
$product_id = $_GET['product_id'];

// checks if the customer added anything to the cart
if ($quantity != "" && $quantity != 0){
// added, display success message and add to cart
	//  success message
	echo "<p id='success_message'> You have succefully added ".$quantity." products. <a href='http://deepblue.cs.camosun.bc.ca/~ics19901/shopping_cart.php'>View Shopping cart</a>";
	// update product in database
	query = "INSERT INTO CART (CUSTOMER_customer_id, PRODUCT_product_id, quantity) VALUES (1,".$product.",".$quantity.") ON DUPLICATE KEY UPDATE quantity=".$quantity.";";
	
} else{
	echo "No quantity";
}


// select all the other data
$query = "select product_id, product_name, product_image, product_price, product_description from PRODUCT where product_id = $product_id;";

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
			
			";
			
			if (isset($_SESSION['username'])) {
				echo "You are logged in";
				// if user is logged in, add stuff to the cart
				echo "<form method=\"GET\" action=\"product_details.php?product_id=".$prod_row['product_id']."&quantity=".quantity."\" enctype=\"multipart/form-data\">";
				
			} else{
				echo "you are not logged in";
				// if user is NOT logged in, redirect them to login page
				echo "<form action=\"login.php\" class=\"modal-content\" enctype=\"multipart/form-data\">";
			}
			
			echo "
			
			<input type=\"button\" id='decrement_btn' value=\"-\" />
			<input type=\"number\" id='quantity' name=\"quantity\" value='1' />
			<input type=\"button\" id='increment_btn' value=\"+\" />
			<input type=\"hidden\" id='product_id' name=\"product_id\" value='{$prod_row['product_id']}' />
			<button type='submit' id=\"add_to_cart\">Add to cart</button>
			
			</form>
		</div> <!-- end of buttons_container -->
		
		</div> <!-- end of details_container -->
		
		<div id=\"description_container\">
			<h3>Details</h3><p>
			";
			$proddesc = str_replace("\\n","<br />",$prod_row['product_description']);
			$proddesc = str_replace("\"\"","\"",$proddesc);
			echo str_replace("\\t-","&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp• ",$proddesc);
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