<!DOCTYPE html>
<html>
<link rel="stylesheet" href="includes/head.css" type="text/css" media="screen" />
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php
session_start();
?>
<div class="header">
<div >
  <a href="index.php" class="logo"><h3 id="logo">La Maison</h3></a>
  <h3 class="right-top">
	<?php 
	if (isset($_SESSION['customer_id'])) { 
		$customer_fname = $_SESSION['customer_fname']; 
		$account_type = $_SESSION['account_type'];
		echo "Welcome, $customer_fname";
	} else {
	  echo "Not logged in"; 
	  }
	?>
	</h3>
  </div>
	<br>
	<br>
  <div class="searchbar">
  <input class="topnav" type="text" id="top" placeholder="Search here">
<?php
	if (isset($_SESSION['customer_id'])) { // checking if user is logged in
?>
  <input class="header-right" type="button" value="Logout" onclick="window.location.href = 'logout.php'">

<?php
		if ($account_type == 'admin') { // checking if user account is of type admin
?> 
  <input class="header-right" type="button" value="Manage Products" onclick="window.location.href = 'addproduct.php'">
<?php
		} // closing account type check if-statement
?>
  
  
  <input class="header-right" type="button" value="Cart" onclick="window.location.href = 'shopping_cart.php'">
  <input class="header-right" type="button" value="Order History">
<?php
}  // closing check to see if account is logged in
else { // execute if user is not logged into an account
?>
  <input class="header-right" type="button" value="Login" onclick="window.location.href = 'login.php'">
  <input class="header-right" type="button" value="Sign Up" onclick="window.location.href = 'create_account.php'">
<?php
} // end of else statement
?>
  </div>
</div>
<?php

// connect to database
include("mysqli_connect.php"); // connection string is $dbc

// run a query
$cat_query = "SELECT * FROM CATEGORY where parent_id IS NULL;";
$cat_rows = mysqli_query($dbc, $cat_query);

echo "<div class='navbar'>"; // start navbar

// category loop

while($cat_row=mysqli_fetch_array($cat_rows, MYSQLI_ASSOC)){
	// display each cat
	echo "<div class='subnav'>";
	echo "<a class='subnavbtn' href='http://deepblue.cs.camosun.bc.ca/~ics19901/products_display.php?category_name={$cat_row['category_name']}'>".$cat_row['category_name']."<i class='fa fa-caret-down'></i></a><br><br>";
	echo "<div class='subnav-content' id='desired_element'>";
	// query the subcategories
	$subcat_query = "SELECT * FROM CATEGORY where parent_id =".$cat_row['category_id'].";";
	$subcat_rows = mysqli_query($dbc, $subcat_query);
	// display the category's subcategories
	
	while($subcat_row=mysqli_fetch_array($subcat_rows, MYSQLI_ASSOC)){
		
		echo "<p><a href='http://deepblue.cs.camosun.bc.ca/~ics19901/products_display.php?category_name={$subcat_row['category_name']}'>".$subcat_row['category_name']."</a></p>";
		
	}

	echo "</div>"; // end of subnav-content div
	echo "</div>"; // end of subnav div
}


echo "</div>"; // end of navbar div



?>
<br>
<br>
