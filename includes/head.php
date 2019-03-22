<!DOCTYPE html>
<html>
<link rel="stylesheet" href="includes/head.css" type="text/css" media="screen" />
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div class="header">
<div >
  <a href="#default" class="logo"><h3 id="logo">La Maison</h3></a>
  <h3 class="right-top">Hello Username</h3>
  </div>
	<br>
	<br>
  <div class="searchbar">
  <input class="topnav" type="text" placeholder="Search here">
  <input class="header-right" type="button" value="Cart" >
  <input class="header-right" type="button" value="Login" >
  <input class="header-right" type="button" value="Join">
  <input class="header-right" type="button" value="Orders">
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
	echo "<a class='subnavbtn' href='http://deepblue.cs.camosun.bc.ca/~ics19901/products_display.php?category_name={$cat_row['category_name']}'>".$cat_row['category_name']."<i class='fa fa-caret-down'></i></a>";
	echo "<div class='subnav-content'>";
	// query the subcategories
	$subcat_query = "SELECT * FROM CATEGORY where parent_id =".$cat_row['category_id'].";";
	$subcat_rows = mysqli_query($dbc, $subcat_query);
	// display the category's subcategories
	while($subcat_row=mysqli_fetch_array($subcat_rows, MYSQLI_ASSOC)){
		echo "<a href='http://deepblue.cs.camosun.bc.ca/~ics19901/products_display.php?category_name={$subcat_row['category_name']}'>".$subcat_row['category_name']."</a>";
	}
	echo "</div>"; // end of subnav-content div
	echo "</div>"; // end of subnav div
}


echo "</div>"; // end of navbar div



?>
<br>
<br>
