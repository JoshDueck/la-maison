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
	
$delete_all = $_POST['delete_all'];
// If user clicks delete all button
if($delete_all=="true"){
	// Query for deleting all products in cart
	$delete_all = "DELETE from CART WHERE CUSTOMER_customer_id=".$_SESSION['customer_id'].";";
	// Deleting all items from a the cart of the user that is logged in
	$result2 = mysqli_query($dbc, $delete_all);
}



/***** start of update quantities *****/
if (isset($_POST["save_changes"])){
	// create variables
	for ($i=0; $i < 11; $i++){
		
		${"quantity".$i} = $_POST["quantity".$i];
		${"product_id".$i} = $_POST["product_id".$i];
		
		// echo "Variables are quantity: ${'quantity'.$i} and product_id: ${'product_id'.$i}"; //debug statement
		
		// updates value if the row exists

		if (isset($_POST["quantity".$i])){
			if (${"quantity".$i} != 0){
				
				$insert = "UPDATE CART SET quantity=".abs(${'quantity'.$i})." where CUSTOMER_customer_id=".$_SESSION['customer_id']." and PRODUCT_product_id=${'product_id'.$i};";
			
				// echo "The query I'm trying to use is: ".$insert; // debug statement
				// insert value into database
				if (mysqli_query($dbc, $insert)) { // runs when successfully inserted
					//  success message
					$sucess = true;
				} else { // failed to insert
					$sucess = false;
					break;
				}
			} else{
				echo "<p id=\"failure_message\">Failed to set quantity to zero. If you wish to remove a product, click on the remove button.<br />";
				$sucess = false;
				break;
			}
		}
		
	}
	// display sucess message
	if ($sucess == true){
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
	
	
	$rownum = 0;
	
	while($prod_row=mysqli_fetch_array($cart_rows, MYSQLI_ASSOC)){
		$prod_name=$prod_row['product_name'];
		$prod_name=substr($prod_name, 0, 40);
		$prod_image=$prod_row['product_image'];
		$subtotal=$prod_row['quantity']*$prod_row['product_price'];
		$total += $subtotal;
		echo "<form method=\"POST\" action=\"shopping_cart.php\" enctype=\"multipart/form-data\">"; // start of update quantities form
		echo "<tr>";
		echo "<td class=\"image_row\"><a href=\"product_details.php?product_id={$prod_row['product_id']}\"><img class=\"prod_imgs\" src=\"".$prod_row['product_image']."\"></a></td>";
		echo "<td class=\"name_row\">$prod_name</td>";
		echo "<td id='price".$rownum."'>$".$prod_row['product_price']."</td>";
		echo "<td>
		<button type=\"submit\" class=\"decrement_btn\" id='decrement_btn".$rownum."' name='decrement_btn".$rownum."' value=\"-\" />
		<input type=\"number\" class=\"quantity\" id=\"quantity".$rownum."\" name=\"quantity".$rownum."\" value=\"{$prod_row['quantity']}\" />
		<input type=\"button\" class=\"increment_btn\" id='increment_btn".$rownum."' name='increment_btn".$rownum."' value=\"+\" />
		<input type=\"hidden\" id='product_id".$rownum."' name=\"product_id".$rownum."\" value=\"{$prod_row['product_id']}\" />";
		
			echo "</td>";

		echo "<td class=\"subtotal\" id=\"subtotal".$rownum."\">=\$$subtotal";		
		// remove from cart using GET
		echo "<td><a href='shopping_cart.php?product_id={$prod_row['product_id']}' style='text-decoration:none;'>Remove</a></td>";

		echo "</tr>";
		$rownum += 1;
		echo "</form>"; // end of update quantities form
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