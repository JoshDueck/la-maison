<html>
<head>
<title>Add A Product</title>
<link rel="stylesheet" href="includes/update products m.css" type="text/css" media="screen" />
<link rel="stylesheet" href="includes/addproduct.css" type="text/css" media="screen" />
</head>
<body>
<?php
//session_start();
include("includes/head.php");
//include('includes/update products m.html'); 
include("mysqli_connect.php");

	$q = "select * from PRODUCT;";
	
	echo "<div id=\"buttons-parent\">
<button id=\"add_products_btn\" class=\"btns\">Add Products</button>
<button id=\"changes_btn\" class=\"btns\">Make Changes</button>
</div>
<div id=\"products_container\">
	<div class=\"products\">
";
	echo '<table border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
	<tr>
		<td align="left" width="20%"><b>Product Image</b></td>
		<td align="left" width="20%"><b>Product Name</b></td>
		<td align="left" width="20%"><b>Product Price</b></td>
		<td align="left" width="50%"><b>Description</b></td>
		<td align="center" width="10%"><b>Action</b></td>

	</tr>';
	
	$r = mysqli_query ($dbc, $q);
	while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {

		// Display each record:
		echo "\t<tr>
			<td align=\"left\"><img src=\"{$row['product_image']}\" /></td>
			<td align=\"left\">{$row['product_name']}</td>
			<td align=\"left\">\${$row['product_price']}</td>
			<td align=\"left\">{$row['product_description']}</td>
			<td align=\"right\"><a href=\"edit_tree.php?treeid={$row['product_id']}\">EDIT</a></td>
			<td align=\"right\"><a href=\"delete_tree.php?treeid={$row['product_id']}\">DELETE</a></td>
		</tr>\n";
		

	} // End of while loop.
	
	echo '</table>';
	//mysqli_close($dbc);	
	echo 		"</div>"; // end of class products div
	echo "</div>"; // end of class products-container div
	


	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$prodname = $_POST['prodname'];
		$prodcat = $_POST['prodcat'];
		$prodsubcat = $_POST['prodsubcat'];
		$prodprice = $_POST['prodprice'];
		$proddesc = $_POST['proddesc'];
		$prodimage = $_POST['prodimage'];
		
		// inserting data from add product
		$query = "insert into PRODUCT (product_name, product_image, product_price, product_description) values ('$prodname', '$prodimage', $prodprice, '$proddesc');";
		
		// check if there was an error  adding in a product
		if (!mysqli_query($dbc, $query)) {
			echo "Error: ".mysqli_error($dbc);
			
		}
		else {
			echo "<p>Product successfully added! Back to <a href='addproduct.php'>Add Product</a></p>";
			$sql = "select last_insert_id();";
			$result = mysqli_query($dbc, $sql);
			if ($result){
				$row = mysqli_fetch_array ($result);
				$product_id = $row['last_insert_id()'];
			}
			
		}
		
		// linking a product to a category
		$querycat = "insert into PRODCAT(CATEGORY_category_id, PRODUCT_product_id) values ($prodcat, $product_id);";
		
		// linking a product to a subcatefory
		$querysubcat = "insert into PRODCAT(CATEGORY_category_id, PRODUCT_product_id) values ($prodsubcat, $product_id);";
			
		
		
		
		
		// linking a product to a category_id CHECKER
		if (!mysqli_query($dbc, $querycat)) {
			echo "Error: ".mysqli_error($dbc);
		}
		
		//linking a product to a subcategory CHECKER
		if (!mysqli_query($dbc, $querysubcat)) {
			echo "Error: ".mysqli_error($dbc);
		}
		
		
		
	}
	else {
/*
if (isset($_SESSION['username'])) {                             LOGIN SESSION
    
}else{
	echo  "<h4>You are not logged in. Please <a href='log in.html'>LOG IN</a></h4>";
} // END IF for outside IF
*/


?>

<div id="addproduct" class="modal">
<form method="POST" action="addproduct.php" class="modal-content">
	Product Name:<br>
	
	<input type="text" name="prodname">
	<br>
	<br>
	Product Category:<br>
	<select name="prodcat">
			<option value="1">Kitchen</option>
			<option value="2">Bath</option>
			<option value="3">Dining</option>
			<option value="4">Bedroom</option>
			<option value="5">Decoration</option>
		</select>
	<br>
	<br>
	Product Subcategory:<br>
		<select name="prodsubcat">
			<option value="11">Small Appliance</option>
			<option value="12">Cookware</option>
			<option value="13">Kitchen Organization</option>
			<option value="14">Coffee & Tea</option>
			<option value="15">Trash & Recycling</option>
			
			<option value="16">Bath Towels & Rugs</option>
			<option value="17">Bathroom Accessories</option>
			<option value="18">Shower</option>
			<option value="19">Bathroom Mirrors & Lighting</option>
			<option value="20">Bath Furniture</option>
			
			<option value="21">Flatware</option>
			<option value="22">Formal Finnerware</option>
			<option value="23">Drinkware</option>
			<option value="24">Serveware</option>
			<option value="25">Barware & Stemware</option>
			
			<option value="26">Duvet Covers</option>
			<option value="27">Blankets & Throws</option>
			<option value="28">Bedding Accessories</option>
			<option value="29">Kids Bedding</option>
			<option value="30">Bedding Basics</option>
			
			<option value="31">Wall Decor</option>
			<option value="32">Clocks</option>
			<option value="33">Lighting</option>
			<option value="34">Candles & Fragrance</option>
			<option value="35">Table Decor</option>
			
		</select>
		<br>
	<br>
	
	Product Price:<br>
	<input type="text" name="prodprice">
	<br>
	<br>
	Product Image:<br>
	<input type="text" name="prodimage">
	<br>
	<br>
	Product Desciption:<br>
	<textarea name="proddesc" rows="20" cols="100" class="textarea"></textarea>
	<br>
	<br>
	<input type="submit" value="Submit">
	<br>
	<br>
</form> 
</div>

<?php
	}

include('includes/footer.html');
?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="includes/addproduct.js"></script>
</body>
</html>