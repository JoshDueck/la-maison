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
					var_dump($_POST);
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
	
$delete_all = $_POST['delete_all'];
// If user clicks delete all button
if($delete_all=="true"){
	// Query for deleting all products in cart
	$delete_all = "DELETE from CART WHERE CUSTOMER_customer_id=".$_SESSION['customer_id'].";";
	// Deleting all items from a the cart of the user that is logged in
	$result2 = mysqli_query($dbc, $delete_all);
}



/***** start of update quantities *****/

if (isset($_POST["changes_made"])){ // they clicked +/- buttons
	// write the query to get all the products from the cart

	include("mysqli_connect.php"); // connection name $dbc
	$query="select CUSTOMER_customer_id, quantity, product_id, product_price from CART, PRODUCT where PRODUCT_product_id = product_id and CUSTOMER_customer_id =".$_SESSION['customer_id'].";";
	$cart_rows = mysqli_query($dbc, $query);
		
	while($prod_row=mysqli_fetch_array($cart_rows, MYSQLI_ASSOC)){ // loop to find the product that was changed
		//echo "Variables are quantity: ${'quantity'.$i} and product_id: ${'product_id'.$i}"; //debug statement
		
		if (isset($_POST["quantity{$prod_row['product_id']}"])){ // the quantity is the one we need to change
			$quantity = abs($_POST["quantity{$prod_row['product_id']}"]);
		
			if(isset($_POST["decrement_btn{$prod_row['product_id']}"])){
				$quantity--; 
			} else{
				$quantity++;
			}
			
			$insert = "UPDATE CART SET quantity=".$quantity." where CUSTOMER_customer_id=".$_SESSION['customer_id']." and PRODUCT_product_id=".$_POST["product_id{$prod_row['product_id']}"].";";
				
				// echo "The query I'm trying to use is: ".$insert; // debug statement
				// insert value into database

				if (mysqli_query($dbc, $insert)) { // runs when successfully inserted
					//  success message
					$success = true;
				} else { // failed to insert
					$success = false;
					break;
				}
		}

	}
	
	// display success message
	if ($success == true){
		echo "<p id=\"success_message\"> You have successfully updated the products.</p>";
	} else {
		echo "<p id=\"failure_message\"> FAILED TO UPDATE PRODUCTS QUANTITY.<br />";
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

	echo "<th class=\"image_row\">Product Image</th>";
	echo "<th class=\"name_row\">Product Name</th>";
	echo "<th>Price</th>";
	echo "<th>Quantity</th>";
	echo "<th>Subtotal</th>";
	echo "<th>
		<form method=\"POST\" action=\"shopping_cart.php\" enctype=\"multipart/form-data\">
		<input type=\"hidden\" id=\"delete_all\" name=\"delete_all\" value=\"true\">

	    <button type=\"submit\" name=\"delete\" id=\"delete\">Remove All</button>
		</form>
	</th>";

	echo "</tr>";
	$total=0;
	
	$query="select PRODUCT_product_id, CUSTOMER_customer_id, quantity, product_id, product_image, product_name, product_price from CART, PRODUCT where PRODUCT_product_id = product_id and CUSTOMER_customer_id =".$_SESSION['customer_id'].";";
	
	$cart_rows = mysqli_query($dbc, $query);
	
	
	
	// all products
	
	
	while($prod_row=mysqli_fetch_array($cart_rows, MYSQLI_ASSOC)){
		$prod_name=$prod_row['product_name'];
		$prod_name=substr($prod_name, 0, 40);
		$prod_image=$prod_row['product_image'];
		$subtotal=$prod_row['quantity']*$prod_row['product_price'];
		$total += $subtotal;
		
		echo "<tr>";
		echo "<td class=\"image_row\"><a href=\"product_details.php?product_id={$prod_row['product_id']}\"><img class=\"prod_imgs\" src=\"".$prod_row['product_image']."\"></a></td>";
		echo "<td class=\"name_row\">$prod_name</td>";
		echo "<td id='price{$prod_row['product_id']}'>$".$prod_row['product_price']."</td>";
		echo "<td>";
	
		// start of update quantities form
		echo "<form method=\"POST\" action=\"shopping_cart.php\" enctype=\"multipart/form-data\">
		
		<button type=\"submit\" class=\"decrement_btn\" id='decrement_btn{$prod_row['product_id']}' name='decrement_btn{$prod_row['product_id']}' value=\"-\" />-</button>
		<input type=\"hidden\" id='product_id{$prod_row['product_id']}' name=\"product_id{$prod_row['product_id']}\" value=\"{$prod_row['product_id']}\" />
		<input type=\"hidden\" class=\"quantity\" id=\"quantity{$prod_row['product_id']}\" name=\"quantity{$prod_row['product_id']}\" value=\"{$prod_row['quantity']}\" />
		<input type=\"hidden\" id='changes_made' name=\"changes_made\" value=\"true\" />";
		echo "</form>";
		
		echo "<span class='quantity' id=\"quantity{$prod_row['product_id']}\">{$prod_row['quantity']}</span>";
		// start of update quantities form
		
		echo "<form method=\"POST\" action=\"shopping_cart.php\" enctype=\"multipart/form-data\">
		<button type=\"submit\" class=\"increment_btn\" id='increment_btn{$prod_row['product_id']}' name='increment_btn{$prod_row['product_id']}' value=\"+\">+</button>
		<input type=\"hidden\" id='changes_made' name=\"changes_made\" value=\"true\" />
		<input type=\"hidden\" class=\"quantity\" id=\"quantity{$prod_row['product_id']}\" name=\"quantity{$prod_row['product_id']}\" value=\"{$prod_row['quantity']}\" />
		<input type=\"hidden\" id='product_id{$prod_row['product_id']}' name=\"product_id{$prod_row['product_id']}\" value=\"{$prod_row['product_id']}\" />";
		
		echo "</form>"; // end of update quantities form
	
			echo "</td>";

		echo "<td class=\"subtotal\" id=\"subtotal{$prod_row['product_id']}\">=\$$subtotal";		
		// remove from cart using GET
		echo "<td><a href='shopping_cart.php?product_id={$prod_row['product_id']}' style='text-decoration:none;'>Remove</a></td>";

		echo "</tr>";
	
		
	}
	echo "</table>";
	
	
	// start of floating_total div
	echo "<div id='floating_total'>
		
			<p id='total'>Total: =\$$total</p>
			
			
		";
		
		$stripeamount = $total*100;

		?>
		
		<?php require_once('./config.php'); ?>

		<form action="charge.php" method="post">
			<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
				data-key="<?php echo $stripe['publishable_key']; ?>"
				data-description="Access for a year"
				data-amount="<?php echo "$stripeamount" ?>"
				data-locale="auto"></script>
			<input type="hidden" name="totalamt" value="<?php echo "$total" ?>">
			<input type="hidden" name="totalamt" value="<?php echo "$total" ?>">
			<input type="hidden" name="totalamt" value="<?php echo "$total" ?>">
			<input type="hidden" name="totalamt" value="<?php echo "$total" ?>">
			<input type="hidden" name="totalamt" value="<?php echo "$total" ?>">
		</form>
		
		
		<?php
		echo "
			
	</div>
	"; // end of floating_total div
	
}else{ // shopping cart is empty

	echo "<h1 align='center'>Your shopping cart is empty.<br><br><a href='index.php'><input type='button' class='link1' value='Continue shopping'></a></h1>";
}


include("includes/footer.html");

echo "<div id='bottom_space'></div>";

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="includes/shopping_cart.js"></script>
</body>
</html>