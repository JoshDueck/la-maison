<?php
session_start();
include('includes/header.html');
require_once('./config.php');
if (isset($_SESSION['username'])) {
	$token  = $_POST['stripeToken'];
	$email  = $_POST['stripeEmail'];

	$totalamt = $_POST['totalamt'];

	echo "Total amt: $totalamt";
	$customer = \Stripe\Customer::create(array(
	  'email' => $email,
	  'source'  => $token
	));

	$charge = \Stripe\Charge::create(array(
	  'customer' => $customer->id,
	  'amount'   => $totalamt,
	  'currency' => 'cad'
	));

	$amount = number_format(($totalamt / 100), 2);
	echo '<h3>Successfully charged $'.$amount.' </h3>Thank you for shopping at Tuk Tuk Heaven';
	// query to delete the cart:
	  
	  
	// inserting data to the order_history
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
		
		if (!mysqli_query($dbc, $query2)) {
			echo "Error: ".mysqli_error($dbc);
		} 
		
	}
}
  include ('includes/footer.html');
?>