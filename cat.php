<!DOCTYPE html>
<html>
<link rel="stylesheet" href="cat.css" type="text/css" media="screen" />
<head>
</head>
<body>
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
	echo "<button class='subnavbtn'>".$cat_row['category_name']."<i class='fa fa-caret-down'></i></button>";
	echo "<div class='subnav-content'>";
	// query the subcategories
	$subcat_query = "SELECT * FROM CATEGORY where parent_id =".$cat_row['category_id'].";";
	$subcat_rows = mysqli_query($dbc, $subcat_query);
	// display the category's subcategories
	while($subcat_row=mysqli_fetch_array($subcat_rows, MYSQLI_ASSOC)){
		echo "<a href='#sub1.1'>".$subcat_row['category_name']."</a>";
	}
	echo "</div>"; // end of subnav-content div
	echo "</div>"; // end of subnav div
}

echo "";
echo "";
echo "</div>"; // end of navbar div



?>
<!--
<div class="navbar">
  <div class="subnav">
    <button class="subnavbtn">Category 1 <i class="fa fa-caret-down"></i></button>
    <div class="subnav-content">
      <a href="#sub1.1">Sub 1.1</a>
      <a href="#sub1.2">Sub 1.2</a>
      <a href="#sub1.3">Sub 1.3</a>
    </div>
  </div> 
  
  
  <div class="subnav">
    <button class="subnavbtn">Category 2<i class="fa fa-caret-down"></i></button>
    <div class="subnav-content">
      <a href="#sub2.1">Sub 2.1</a>
      <a href="#sub2.2">Sub 2.2</a>
      <a href="#sub2.3">Sub 2.3</a>
      <a href="#sub2.4">Sub 2.4</a>
    </div>
  </div>
  
  
  <div class="subnav">
    <button class="subnavbtn">Category 3<i class="fa fa-caret-down"></i></button>
    <div class="subnav-content">
      <a href="#sub3.1">Sub 3.1</a>
      <a href="#sub3.2">Sub 3.2</a>
      <a href="#sub3.3">Sub 3.3</a>
      <a href="#sub3.4">Sub 3.4</a>
    </div>
	</div>
	
	  <div class="subnav">
    <button class="subnavbtn">Category 4<i class="fa fa-caret-down"></i></button>
    <div class="subnav-content">
      <a href="#sub4.1">Sub 4.1</a>
      <a href="#sub4.2">Sub 4.2</a>
      <a href="#sub4.3">Sub 4.3</a>
    </div>
  </div> 
  
    <div class="subnav">
    <button class="subnavbtn">Category 5<i class="fa fa-caret-down"></i></button>
    <div class="subnav-content">
      <a href="#sub5.1">Sub 5.1</a>
      <a href="#sub5.2">Sub 5.2</a>
      <a href="#sub5.3">Sub 5.3</a>
    </div>
  </div> 
	
	
</div>
-->
</body>
</html>
