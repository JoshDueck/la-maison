<html>
<head>
<link rel="stylesheet" href="includes/receipt.css" type="text/css" media="screen" />
</head>
<?php
session_start();

include('includes/head.php');
if (isset($_SESSION['customer_id'])) {
/*
					echo '<pre>';
					var_dump($_SESSION);
					echo '</pre>';

					echo '<pre>';
					var_dump($_POST);
					echo '</pre>';
*/
	
	require_once('./config.php');
	$token  = $_POST['stripeToken'];
	$totalamt = $_POST['totalamt'];
    echo "<div id=\"body\">";
	
	$customer = \Stripe\Customer::create(array(
		'email' => $email,
		'source'  => $token
	));

	
	$totalamt *= 100;
	
  $charge = \Stripe\Charge::create(array(
      'customer' => $customer->id,
      'amount'   => $totalamt,
      'currency' => 'cad'
  ));
  
	$amount = number_format(($totalamt / 100), 2);

	echo '<h3>Successfully charged $'.$amount.' </h3><h2>Thank you for shopping at La Maison</h2>';

	// query to delete the cart:
	  
	  
	// inserting data to the order_history
	include("mysqli_connect.php"); // connection name $dbc
	$query1 = "insert into ORDER_HISTORY (CUSTOMER_customer_id, order_date, order_time) values (".$_SESSION['customer_id'].", curdate(), curtime());";
		
	$data_rows = mysqli_query($dbc, $query1);
		
	$select_cart="select PRODUCT_product_id, CUSTOMER_customer_id, quantity, product_id, product_image, product_name, product_price from CART, PRODUCT where PRODUCT_product_id = product_id and CUSTOMER_customer_id =".$_SESSION['customer_id'].";";

	$cart_rows = mysqli_query($dbc, $select_cart);

	$last_id = "select last_insert_id()";
	$last_id = mysqli_query($dbc, $last_id);
	$row = mysqli_fetch_array($last_id);
	$last_id = $row['last_insert_id()'];
		
	while($prod_row=mysqli_fetch_array($cart_rows, MYSQLI_ASSOC)){
	//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// inserting data to the order prduct
	
		$query2 = "insert into ORDER_PRODUCT (ORDER_HISTORY_order_number, PRODUCT_product_id, quantity, purchase_price) values ($last_id, {$prod_row['PRODUCT_product_id']}, {$prod_row['quantity']}, {$prod_row['product_price']});";
		
	
		$data_rows = mysqli_query($dbc, $query2);
		
		if (!$data_rows) {
			echo "Error: ".mysqli_error($dbc);
		}
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// QUERY FOR ORDER_ID AND TIME OF PURCHASE
		$orderquery = "SELECT order_number, order_date, order_time FROM ORDER_HISTORY WHERE order_number = $last_id and CUSTOMER_customer_id = ".$_SESSION['customer_id'].";";


		$row = mysqli_query($dbc, $orderquery);
		$order_number = $last_id;
		$order_row=mysqli_fetch_array($row, MYSQLI_ASSOC);
		// QUERY FOR PRODUCTS THAT WERE PURCHASED
		$customer_id = $_SESSION['customer_id'];
		
		$prodquery = "SELECT product_name, product_price, quantity from ORDER_PRODUCT o, PRODUCT p, ORDER_HISTORY h 
					WHERE h.order_number=o.ORDER_HISTORY_order_number and p.product_id = o.PRODUCT_product_id
					and h.CUSTOMER_customer_id = $customer_id and h.order_number = $order_number;";
		$row2 = mysqli_query($dbc, $prodquery);
		
		$receipt = "$order_number".$_SESSION['customer_fname'].$_SESSION['customer_lname'];
		// Identify the file to use:
		$file = "/home/student/ics19901/receipts/$receipt.txt";

		$newreceipt = fopen($file, "w") or die("Unable to open file.");
		
		//
		echo "<table id=\"order_table\" border='1'>
			<tr id='titles'>
			<td id='name'><b>Name</b></td>
			<td id='price'><b>Price</b></td>
			<td id='quantity'><b>Quantity</b></td>
			<td id='total'><b>Total</b></td>
			</tr>";

		$row = mysqli_query($dbc, $orderquery);
		$order_number = $last_id;
		$order_row=mysqli_fetch_array($row, MYSQLI_ASSOC);
		// QUERY FOR PRODUCTS THAT WERE PURCHASED
		$customer_id = $_SESSION['customer_id'];
		
		$prodquery = "SELECT product_name, product_price, quantity from ORDER_PRODUCT o, PRODUCT p, ORDER_HISTORY h 
					WHERE h.order_number=o.ORDER_HISTORY_order_number and p.product_id = o.PRODUCT_product_id
					and h.CUSTOMER_customer_id = $customer_id and h.order_number = $order_number;";
		$row2 = mysqli_query($dbc, $prodquery);
		
		$receipt = "$order_number".$_SESSION['customer_fname'].$_SESSION['customer_lname'];
		// Identify the file to use:
		$file = "/home/student/ics19901/receipts/$receipt.txt";

		$newreceipt = fopen($file, "w") or die("Unable to open file.");
		
		//
		echo "<table id=\"order_table\" border='1'>
			<tr id='titles'>
			<td id='name'>Name</td>
			<td id='price'>Price</td>
			<td id='quantity'>Quantity</td>
			<td id='total'>Total</td>
			</tr>";





		echo "<br>";
		$ordernum = "Order number: #$order_number\n";
		fwrite($newreceipt, $ordernum);
		echo " $ordernum";
		echo "<br>";

		echo "<br>";

		
		$day_ordered = $order_row['order_date'];
		$time_ordered = $order_row['order_time'];
		$orderdate = "Purchased on: $day_ordered at $time_ordered\n";
		fwrite($newreceipt, $orderdate);
		echo "$orderdate";

		echo "<br>";
		echo "<br>";

		

		$ordered_byfname = $_SESSION['customer_fname'];
		$ordered_bylname = $_SESSION['customer_lname'];
		$ordername = "Purchased by: $ordered_byfname $ordered_bylname\n";
		fwrite($newreceipt, $ordername);
		
		$total = 0;
		echo "<h3>PRODUCTS</h3>";
		while ($prod_row=mysqli_fetch_array($row2, MYSQLI_ASSOC)) {
			$prod_name = $prod_row['product_name'];
			$prod_quantity = $prod_row['quantity'];
			$prod_price = $prod_row['product_price'] * $prod_quantity;
			$prod_price_per = $prod_row['product_price'];
			$orderproducts = "Product: $prod_name \nAmount purchased: $prod_quantity for $$prod_price\n\n";
			fwrite($newreceipt, $orderproducts);
			echo "<tr>
			<td id='productname'>$prod_name</td>
			<td id='productprice'>$$prod_price_per</td>
			<td id='productquantity'>$prod_quantity</td>
			<td id='producttotal'>$$prod_price</td>
			</tr>";
			$total = $total+$prod_price;
		} 
		$subtotal = $total;
		echo "<tr>

		<td colspan=\"3\" class='subtotal'>Subtotal</td>

		<td colspan=\"3\">Subtotal</td>

		<td>$$subtotal</td>
		</tr>";
		
		$subtotal_str = "Subtotal: $$subtotal \n";
		fwrite($newreceipt, $subtotal_str);
		
		$tax_percent = 0.12;
		$tax = $total * $tax_percent;
		$tax = number_format($tax, 2);
		echo "<tr>

			<td colspan=\"3\">Tax (12%)</td>

			<td>$$tax</td>
			</tr>";
			
		$tax_str = "Taxed amount: $$tax \n";
		fwrite($newreceipt, $tax_str);
		
		$total_price = $total+$tax;
		$total_price_str = "Total cost: $$total_price \n";
		fwrite($newreceipt, $total_price_str);
		
		echo "<tr>

		<td colspan=\"3\" id='total'><b>Total<b></td>

		<td>$$total_price</td>
		</tr>
		</table>";
		
		$country = $_SESSION['customer_country'];
		$province = $_SESSION['customer_province'];
		$city = $_SESSION['customer_city'];
		$address = $_SESSION['customer_address'];
		$postal = $_SESSION['customer_postal'];
		$orderaddress = "\nOrder sent to: $address \n$city, $province, $country \n$postal";
		fwrite($newreceipt, $orderaddress);
		
		echo "<br>";
		echo "Order sent to: $address";
		echo "<br>";

		echo "<br>";
		echo "$city, $province, $country";
		echo "<br>";
		echo "<br>";
		echo "$postal";
		echo "<br>";
		echo "<br>";
		echo "<input type='submit' onclick=\"window.location.href='order_history.php'\" value='Click here to view order history' id='orderbutton'>";
		echo "<br>";
		echo "<br>";
		fclose($newreceipt);
		echo '</div>';


		echo "$city, $province, $country";
		echo "<br>";
		echo "$postal";
			
		fclose($newreceipt);
		
	
		// Deleting cart from database
		$delete_all = "DELETE from CART WHERE CUSTOMER_customer_id=".$_SESSION['customer_id'].";";
		mysqli_query($dbc, $delete_all);
	}
} else{
	echo "
	<h3>You have to be logged in to access this page.</h3>
	";
}
  include ('includes/footer.html');
?>

</html>