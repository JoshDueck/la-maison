<!DOCTYPE html>
<html>

<head>
<title>Shopping Cart</title>
<link rel="stylesheet" href="includes/shopping_cart.css" type="text/css" media="screen" />
</head>
<body>

<?php
session_start();
/*
					echo '<pre>';
					var_dump($_SESSION);
					echo '</pre>';
*/
include("includes/head.php");

/**** repeating products ****/
	
		
// check if user is logged in
if(!(isset($_SESSION['customer_id'])&&$_SESSION['customer_id']!='')){
		header("Location:includes/login.php");
		echo "<h1 >You are not logged in. <a href='login.php'>Login please</a></h1>"; 
}
	
// connect to the database
include("mysqli_connect.php"); // connection name $dbc
	
	// Getting which product needs to be deleted
	$prodID = $_GET['product_id'];
	// Query for deleting product
	$deleteprod = "DELETE from CART WHERE PRODUCT_product_id='$prodID' and CUSTOMER_customer_id =".$_SESSION['customer_id'].";";
	// Deleting where product matches the account the user is logged in from
	$result = mysqli_query($dbc, $deleteprod);


/***** start of update quantities *****/
if (isset($_POST["save_changes"])){
	// create variables
	for ($i=0; $i < 11; $i++){
		
		${"quantity".$i} = $_POST["quantity".$i];
		${"product_id".$i} = $_POST["product_id".$i];
		
		// echo "Variables are quantity: ${'quantity'.$i} and product_id: ${'product_id'.$i}"; //debug statement
		
		// updates value if the row exists
		if (${"product_id".$i} > 0){
				
			$insert = "UPDATE CART SET quantity=${'quantity'.$i} where CUSTOMER_customer_id=".$_SESSION['customer_id']." and PRODUCT_product_id=${'product_id'.$i};";
			
			// echo "The query I'm trying to use is: ".$insert; // debug statement
			// insert value into database
			if (mysqli_query($dbc, $insert)) { // runs when successfully inserted
				//  success message
				$sucess = true;
			} else { // failed to insert
				$sucess = false;
			}
		}
	}
	// display sucess message
	if ($sucess == true){
		echo "<p id=\"success_message\"> You have successfully updated the products.</p>";
	} else {
		echo "<p id=\"success_message\"> FAILED TO UPDATE PRODUCTS QUANTITY.<br />";
		// echo "Error: ".mysqli_error($dbc); // debug statement
	}
}
/***** end of update quantities *****/



$query="select PRODUCT_product_id, CUSTOMER_customer_id, quantity, product_id, product_image, product_name, product_price from CART, PRODUCT where PRODUCT_product_id = product_id and CUSTOMER_customer_id =".$_SESSION['customer_id'].";";
$cart_rows = mysqli_query($dbc, $query);
$prod_row=mysqli_num_rows($cart_rows);
// echo "The number of rows is: ".$prod_row; // debugging statement 
// query
if(isset($_SESSION['customer_id']) && ($prod_row >0)){
	// table in php
	echo "<table cellpadding='5' cellspacing='5' style='width:100%;'>";
	echo "<tr>";

	echo "<td class=\"image_row\">Product Image</td>";
	echo "<td class=\"name_row\" style='width: 150px; word-break: break-all;'>Product Name</td>";
	echo "<td>Price</td>";
	echo "<td>Quantity</td>";
	echo "<td>Subtotal</td>";
	echo "<td>
		<form method=\"POST\" action=\"shopping_cart.php\" enctype=\"multipart/form-data\">
		<input type=\"hidden\" id=\"delete_all\" name=\"delete_all\" value=\"true\">
	    <button type=\"submit\" name=\"delete\" id=\"delete\">Delete All</button>
	</td>";

	echo "</tr>";
	$total=0;
	
	$query="select PRODUCT_product_id, CUSTOMER_customer_id, quantity, product_id, product_image, product_name, product_price from CART, PRODUCT where PRODUCT_product_id = product_id and CUSTOMER_customer_id =".$_SESSION['customer_id'].";";
	
	$cart_rows = mysqli_query($dbc, $query);
	
	
	
	// all products
	echo "<form method=\"POST\" action=\"shopping_cart.php\" enctype=\"multipart/form-data\">";
	
	$rownum = 0;
	
	while($prod_row=mysqli_fetch_array($cart_rows, MYSQLI_ASSOC)){
		$prod_name=$prod_row['product_name'];
		$prod_name=substr($prod_name, 0, 40);
		$prod_image=$prod_row['product_image'];
		$subtotal=$prod_row['quantity']*$prod_row['product_price'];
		$total += $subtotal;
		
		echo "<tr>";
		echo "<td class=\"image_row\"  style=\"\"><img src=\"".$prod_row['product_image']."\" style=\"width:150px;\"></td>";
		echo "<td class=\"name_row\"  style=' word-wrap:break-word; word-break: break-all;'>$prod_name</td>";
		echo "<td id=\"price".$rownum."\">$".$prod_row['product_price']."</td>";
		echo "<td>
		<input type=\"button\" class=\"decrement_btn\" id='decrement_btn".$rownum."' value=\"-\" />
		<input type=\"number\" class=\"quantity\" id=\"quantity".$rownum."\" name=\"quantity".$rownum."\" value=\"{$prod_row['quantity']}\" />
		<input type=\"button\" class=\"increment_btn\" id='increment_btn".$rownum."' value=\"+\" />
		<input type=\"hidden\" id='product_id".$rownum."' name=\"product_id".$rownum."\" value=\"{$prod_row['product_id']}\" />";
		
			echo "</td>";

		echo "<td class=\"subtotal\" id=\"subtotal".$rownum."\">= \$$subtotal";		
		echo "<td style='width:100px;'><a href='shopping_cart.php?product_id={$prod_row['product_id']}' style='text-decoration:none;'>Remove</a></td>";

		echo "</tr>";
		$rownum += 1;
	}
	echo "<tr style='color:#ff0000;'>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td>Total</td>";
	echo "</tr>";
	echo "<tr style='color:#000000;'>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<input type=\"hidden\" id=\"save_changes\" name=\"save_changes\" value=\"true\">";
	echo "<td><button type='submit' id=\"save_changes_btn\">Save changes</button></td>";
			echo "</form>";
	echo "<td><br /><b>= \$$total</b></td>";
	echo "<td><br /><a href='check_out.php'><img src = 'images/checkout.png' width='120px' height='40px'></a></td>";
	echo "</tr>";
	echo "</table>";			
	
}else{ // shopping cart is empty

	echo "<font color='#000000'><h1 >Your shopping cart is empty.<br /><br><a href='index.php'><input type='button' class='link1' value='Continue shopping' style='width:150px; height:35px; font-size:15px;'></a></h1></font>";
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="includes/shopping_cart.js"></script>
</body>
</html>