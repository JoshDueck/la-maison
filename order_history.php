<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="includes/order.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="includes/order.js"></script>
</head>
<body>
 <div id = "page-container">
	<div id = "content-wrap">
<?php
session_start();

include('includes/head.php');

// check if user is logged in
if(!(isset($_SESSION['customer_id'])&&$_SESSION['customer_id']!='')){
		header("Location:includes/login.php");

		echo "<h1 >You are not logged in. <a href='login.php'>Login please</a></h1>"; 
}

// connect to the database
include("mysqli_connect.php"); // connection name $dbc


// first part
/* select order_number, CUSTOMER_customer_id, order_date, order_time from ORDER_HISTORY; */

// second part
/* select ORDER_HISTORY_order_number, PRDOCUT_product_id, quantity, purchase_price from ORDER_PRODUCT; */

// third part
/* select product_image, product_name from PRODUCT; */

// query


$query = "select order_number, order_date, order_time from ORDER_HISTORY where CUSTOMER_customer_id = ".$_SESSION['customer_id'].";";

$order_rows = mysqli_query($dbc, $query);
$history_rows = mysqli_num_rows($order_rows);

if(isset($_SESSION['customer_id']) && ($history_rows > 0)) {

	echo "<h3><u>Your Orders</u></h3>";
	
	echo '<script type="text/javascript"></script>'; 
	while($history_rows=mysqli_fetch_array($order_rows, MYSQLI_ASSOC)) {
		
		$preTotal = "<p class=\"border\"><button id=\"toggle_{$history_rows['order_number']}\" class=\"swap\"><i class=\"fa fa-angle-double-right\"></i></button><b class=\"order_number\"> # ".$history_rows['order_number']."</b><b class=\"total_price\">$"; // html content before the total
		
		$total = 0;

		$postTotal = "</b><b class=\"order_date\"> ".$history_rows['order_date']."</b><b class=\"order_time\">".$history_rows['order_time'] ."</b></p>"; // html content after the total
		
		$prodsQ = "select quantity, purchase_price, product_id, product_image, product_name FROM ORDER_PRODUCT o, PRODUCT p where o.PRODUCT_product_id = p.product_id AND ORDER_HISTORY_order_number = ".$history_rows['order_number'].";";
		
		$prod_rows = mysqli_query($dbc, $prodsQ);
		
		$actTotal = 0;
		$prodDisplay = "";
		while($products_rows=mysqli_fetch_array($prod_rows, MYSQLI_ASSOC)) {
			$prodDisplay .= "
			<br>
			<div class=\"order_details".$products_rows['product_id']."\">
				<b class=\"product_image\">
					<a href=\"product_details.php?product_id=".$products_rows['product_id']."\"><img src=\"".$products_rows['product_image']."\"  class=\"img\"/>
					</a>
				</b>
				
				<b class=\"product_name\">
					".$products_rows['product_name']." 
				</b>
				<b class=\"purchase_price\">$ ".$products_rows['purchase_price']."
				</b>
				<b class=\"quantity\">".$products_rows['quantity']."
				</b>
			</div>";
			$actTotal += $products_rows['purchase_price']*$products_rows['quantity'];
			
		} // close inner while loop	
		
		echo "".$preTotal;
		echo "".$actTotal;
		echo "".$postTotal;
		echo "<div class=\"order_container\" id=\"order_container_{$history_rows['order_number']}\">";
		echo "".$prodDisplay;
		echo "</div>";
		echo "
		<script>
			$(\"#toggle_{$history_rows['order_number']}\").click(function(){
				if ($(\"#order_container_{$history_rows['order_number']}\").is(\":visible\")){ // content currently displayed
					$(\"#order_container_{$history_rows['order_number']}\").slideUp();
				} else{ // content currently hidden
					$(\"#order_container_{$history_rows['order_number']}\").slideDown();
				}
			});
			
		</script>
		
		";
	} // close outter while loop
}else{ // order history is empty
	
	echo "<h1 align='center'>You have no orders<br><br><a href='index.php'><input type='button' class='link1' value='Continue shopping'></a></h1>";
}

mysqli_close($dbc);
?>

</div>
<footer id="footer">
<?php
include("includes/footer.html");
?>
</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
	<script src="includes/order.js"></script>

</body>
</html>