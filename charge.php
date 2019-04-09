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

	echo "Total amt: $totalamt";
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
	echo '<h3>Successfully charged $'.$amount.' </h3>Thank you for shopping at La Maison';
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
		$orderquery = "SELECT order_number, order_date, order_time FROM ORDER_HISTORY WHERE CUSTOMER_customer_id = ".$_SESSION['customer_id'].";";

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
		
		$ordernum = "ORDER NUMBER: $order_number\n";
		fwrite($newreceipt, $ordernum);
		
		$day_ordered = $order_row['order_date'];
		$time_ordered = $order_row['order_time'];
		$orderdate = "Purchased on: $day_ordered at $time_ordered\n";
		fwrite($newreceipt, $orderdate);
		
		$ordered_byfname = $_SESSION['customer_fname'];
		$ordered_bylname = $_SESSION['customer_lname'];
		$ordername = "Purchased by: $ordered_byfname $ordered_bylname\n";
		fwrite($newreceipt, $ordername);
		
		$total = 0;
		while ($prod_row=mysqli_fetch_array($row2, MYSQLI_ASSOC)) {
			$prod_name = $prod_row['product_name'];
			$prod_quantity = $prod_row['quantity'];
			$prod_price = $prod_row['product_price'] * $prod_quantity;
			$orderproducts = "PRODUCT: $prod_name     AMOUNT PURCHASED: $prod_quantity for $$prod_price\n";
			fwrite($newreceipt, $orderproducts);
			$total = $total+$prod_price;
		} 
		$total_price = "TOTAL PRICE: $total\n";
		fwrite($newreceipt, $total_price);
		
		$country = $_SESSION['customer_country'];
		$province = $_SESSION['customer_province'];
		$city = $_SESSION['customer_city'];
		$address = $_SESSION['customer_address'];
		$postal = $_SESSION['customer_postal'];
		$orderaddress = "Order sent to: $address \n$city, $province, $country \n$postal";
		fwrite($newreceipt, $orderaddress);
			
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