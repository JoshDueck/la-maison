<html>
<link rel="stylesheet" href="includes/products_display.css" type="text/css" media="screen" />
<head>
</head><body><br>

<?php
session_start();

if (isset($_SESSION['username'])) {
	echo "You are logged in";
} else {
	echo "NOT LOGGED IN";
}

include("includes/head.php"); // inserts header at the top

// connect to database
include("mysqli_connect.php"); // connection string is $dbc


$category_name = $_GET['category_name'];

if ($category_name == null){
	// run a query to display all products
	$all_prod_query = 
	"SELECT product_image, product_name, product_price, product_id
	FROM PRODUCT";
	$prod_rows = mysqli_query($dbc, $all_prod_query);

	echo "<br>
		<br>
		<table>
			<tr class=\"jump\">";

	// all products loop

	while($prod_row=mysqli_fetch_array($prod_rows, MYSQLI_ASSOC)){
		echo "<td class=\"shadow\">
				<a href=\"http://deepblue.cs.camosun.bc.ca/~ics19901/product_details.php?product_id=".$prod_row['product_id']."\">
				<img src=\"".$prod_row['product_image']."\"  class=\"img\" />
				</a>
				<h4 class=\"text\"><i>".$prod_row['product_name']."</i></h4>
				<h4 class=\"text\"><i>\$".$prod_row['product_price']."</i></h4>
				
		</td>
	";
	}
	echo "</tr>
		</table>
		<br>
		<br>";
}

// run a query based on category

$prod_query = 
"SELECT product_image, product_name, product_price, product_description, product_id, category_id, category_name
FROM PRODUCT p, PRODCAT pc, CATEGORY c
WHERE p.product_id = pc.PRODUCT_product_id
AND c.category_id = pc.CATEGORY_category_id
AND category_name = '$category_name'";
$prod_rows = mysqli_query($dbc, $prod_query);

echo "<br>
	<br>
	<table>
		<tr class=\"jump\">";

// category loop

while($prod_row=mysqli_fetch_array($prod_rows, MYSQLI_ASSOC)){
	echo "<td class=\"shadow\">
			<a href=\"http://deepblue.cs.camosun.bc.ca/~ics19901/product_details.php?product_id=".$prod_row['product_id']."\">
			<img src=\"{$prod_row['product_image']}\"  class=\"img\" />
			</a>
			<h4 class=\"text\"><i>".$prod_row['product_name']."</i></h4>
			<h4 class=\"text\"><i>\$".$prod_row['product_price']."</i></h4>
			
	</td>
";
}
echo "</tr>
	</table>
	<br>
	<br>";

?>

</body>
</html>