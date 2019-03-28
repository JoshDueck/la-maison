<html>
<link rel="stylesheet" href="includes/products_display.css" type="text/css" media="screen" />
<head>
</head><body><br>

<?php

//include("includes/head.php"); // inserts header at the top

$create_account = $_POST['create_account'];

if($create_account=="true"){ // user came from create_account page
	echo "Coming from create account";
	// get all the post variables
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$address = $_POST['address'];
		$city = $_POST['city'];
		$province = $_POST['province'];
		$country = $_POST['country'];
		$postal = $_POST['postal'];
		$customer_email = $_POST['customer_email'];
		$password = $_POST['password'];
		$password_repeat = $_POST['password_repeat'];
		
	//checking email
		include('mysqli_connect.php');
		
		$q = "select customer_email from CUSTOMER where customer_email='$customer_email'";
	
		$query = mysqli_query($dbc, $q);
		
		
		// look through query
		//$row = mysqli_fetch_array($query, MYSQLI_NUM);
		
		
		$row=mysqli_num_rows($query);
		
		
		
		// insert them into the database
		if($row == 0) {
			echo "Email is valid, ready to isnert";
			$query = "insert into CUSTOMER (account_type, customer_fname, customer_lname, customer_country, 
			customer_province, customer_city, customer_address, customer_postal, customer_email, customer_password) 
			values ('user', '$firstname', '$lastname', '$country', '$province', '$city', '$address', '$postal', '$customer_email', md5('$password'))";
			if (mysqli_query($dbc, $query)){
				echo "inserted successfully";
			}else{
				echo "Error: ".mysqli_error($dbc);
			}
			 
		}
		else {
			echo "Email is already in use";
		}
		
				
		$q2 = "select customer_id from CUSTOMER where customer_email='$customer_email'";
		
		$query2 = mysqli_query($dbc, $q2);
		
		$row2 = mysqli_fetch_array($query2, MYSQLI_NUM);
		
		echo "$row2[0], $customer_email";
		
		
		
	// start session
	session_start();
	//session for create account
	
	$_SESSION['customer_id'] = $row2[0]; // stores id as a session variable
	

	if (isset($_POST['customer_email'])) {
		$customer_email = $_POST['customer_email']; // Checking 
		$password = $_POST['password'];
		include('mysqli_connect.php');
		
		$query = "SELECT * from CUSTOMER WHERE customer_email='".$_POST['customer_email']."' AND customer_password = md5('$password');";
		$row = @mysqli_query ($dbc, $query);
		
		if (mysqli_num_rows($row) == 1) {
			$prod_row=mysqli_fetch_array($row, MYSQLI_ASSOC);
			
			$_SESSION['customer_email']=$customer_email;
			$_SESSION['customer_id']=$prod_row['customer_id'];
			$_SESSION['account_type']=$prod_row['account_type'];
			$_SESSION['customer_fname']=$prod_row['customer_fname'];
			$_SESSION['customer_lname']=$prod_row['customer_lname'];
			$_SESSION['customer_country']=$prod_row['customer_country'];
			$_SESSION['customer_province']=$prod_row['customer_province'];
			$_SESSION['customer_city']=$prod_row['customer_city'];
			$_SESSION['customer_address']=$prod_row['customer_address'];
			$_SESSION['customer_postal']=$prod_row['customer_postal'];
				
			
			echo "You have logged in successfully";
				
		} else { // Not a match!
			echo  "<h4>Invalid login credentials. Please <a href='login.php'>TRY AGAIN</a></h4>";
			//echo $_POST['customer_email'];
		}
		
	}
	else{
		echo "Not logged in. <a href='login.php'> Click here to login.</a>";
	}

	
}else{ // user came from login page
	session_start();
	
	//$_SESSION['sessionHello']="hello world"; ---------------------------------- DEBUGGING STATEMENT
	//$_SESSION['customer_country']=$row['customer_country']; ------------------- DEBUGGING STATEMENT
	
	if (isset($_SESSION['customer_email'])) {
		include("mysqli_connect.php"); // $dbc connection set
		$username = $_SESSION['customer_email']; // Change to get first and last name from database
		echo "Hello, ".$_SESSION['customer_fname']."! Welcome to La Maison.";
	}
	else {
		if (isset($_POST['customer_email'])) {
			$username = $_POST['customer_email']; // Checking 
			$password = $_POST['password'];
			include('mysqli_connect.php');
			
			$query = "SELECT * from CUSTOMER WHERE customer_email='$username' AND customer_password = md5('$password');";
			$row = @mysqli_query ($dbc, $query);
			
			if (mysqli_num_rows($row) == 1) { // customer used valid credentials
				$prod_row=mysqli_fetch_array($row, MYSQLI_ASSOC);
				
				$_SESSION['customer_email']=$username;
				$_SESSION['customer_id']=$prod_row['customer_id'];
				$_SESSION['account_type']=$prod_row['account_type'];
				$_SESSION['customer_fname']=$prod_row['customer_fname'];
				$_SESSION['customer_lname']=$prod_row['customer_lname'];
				$_SESSION['customer_country']=$prod_row['customer_country'];
				$_SESSION['customer_province']=$prod_row['customer_province'];
				$_SESSION['customer_city']=$prod_row['customer_city'];
				$_SESSION['customer_address']=$prod_row['customer_address'];
				$_SESSION['customer_postal']=$prod_row['customer_postal'];
				
				/*
				echo "You have logged in successfully";
				echo "The session id is...: ".session_id();
					echo '<pre>';
					var_dump($_SESSION);
					echo '</pre>'; */
			} else { // Not a match!
				echo  "<h4>Invalid login credentials. Please <a href='login.php'>TRY AGAIN</a></h4>";
			}
			
		}
		else{
			echo "Not logged in";
		}
	}
}

include("includes/head.php"); // inserts header at the top

/***** display all products regardless of where the user came from *****/

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

/***** end of displaying all products *****/




include("footer.html");
?>
</body>
</html>