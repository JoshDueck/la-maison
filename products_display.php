<html>
<link rel="stylesheet" href="includes/product_display.css" type="text/css" media="screen" />
<head>
</head><body><br>

<?php
include("includes/head.php"); // inserts header at the top

$category_name = $_GET['category_name'];


// connect to database
include("mysqli_connect.php"); // connection string is $dbc
// run a query
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
			<a href=\"#\">
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